<?php

namespace Okipa\DataSanitizer;

class DataSanitizer
{
    /**
     * Cleans given input and returns cleaned data.
     *
     * @param mixed $entry          The data to clean
     * @param mixed $default        Value to return by default if the input data is falsy
     * @param bool $jsonDecodeAssoc Should json_decode return an associative array instead of StdClass?
     *
     * @return array|bool|float|int|null
     */
    public function sanitize($entry, $default = null, bool $jsonDecodeAssoc = false)
    {
        $this->trimEntry($entry);
        $return = $this->sanitizeFromType($entry, $jsonDecodeAssoc);
        if (isset($default) && ! $return) {
            return $default;
        }

        return $return;
    }

    /**
     * @param mixed $entry
     *
     * @return void
     */
    protected function trimEntry(&$entry): void
    {
        if (is_string($entry)) {
            $entry = trim($entry);
        }
    }

    /**
     * @param mixed $entry
     * @param bool $jsonDecodeAssoc
     *
     * @return array|bool|float|int|null
     */
    protected function sanitizeFromType($entry, bool $jsonDecodeAssoc)
    {
        if ($this->isNull($entry)) {
            return null;
        } elseif ($this->isFalse($entry)) {
            return false;
        } elseif ($this->isTrue($entry)) {
            return true;
        } elseif (is_numeric($entry)) {
            if ((int) $entry !== $entry) {
                return doubleval($entry);
            } else {
                return intval($entry);
            }
        } elseif ($this->isJson($entry)) {
            $decoded = json_decode($entry, $jsonDecodeAssoc);
            if (is_array($decoded)) {
                return $this->sanitizeAll($decoded);
            } else {
                return $decoded;
            }
        } elseif (is_array($entry)) {
            return $this->sanitizeAll($entry);
        } else {
            return $entry;
        }
    }

    /**
     * @param mixed $entry
     *
     * @return bool
     */
    protected function isNull($entry): bool
    {
        return $entry === '' || $entry === 'null';
    }

    /**
     * @param mixed $entry
     *
     * @return bool
     */
    protected function isFalse($entry): bool
    {
        return $entry === 'false';
    }

    /**
     * @param mixed $entry
     *
     * @return bool
     */
    protected function isTrue($entry): bool
    {
        return $entry === 'true' || $entry === 'on';
    }

    /**
     * Check if an item is JSON.
     *
     * @param mixed $string Item to check
     *
     * @return bool
     */
    protected function isJson($string): bool
    {
        if (! is_string($string)) {
            return false;
        }
        json_decode($string);

        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Recursive method to sanitize deep array of data.
     *
     * @param array $entries Array of data to sanitize
     *
     * @return array
     */
    protected function sanitizeAll(array $entries): array
    {
        $return = [];
        foreach ($entries as $key => $entry) {
            if (is_array($entry)) {
                $return[$key] = $this->sanitizeAll($entry);
            } else {
                $return[$key] = $this->sanitize($entry);
            }
        }

        return $return;
    }
}
