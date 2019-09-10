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
     * @return array|bool|float|int|mixed|null
     */
    public function sanitize($entry, $default = null, bool $jsonDecodeAssoc = false)
    {
        if (is_string($entry)) {
            $entry = trim($entry);
        }
        switch (true) {
            case $entry === '':
            case $entry === 'null':
                $return = null;
                break;
            case $entry === 'false':
                $return = false;
                break;
            case $entry === 'true':
            case $entry === 'on':
                $return = true;
                break;
            case is_numeric($entry):
                if ((int) $entry !== $entry) {
                    $return = doubleval($entry);
                } else {
                    $return = intval($entry);
                }
                break;
            case $this->isJson($entry):
                $return = json_decode($entry, $jsonDecodeAssoc);
                if (is_array($return)) {
                    $return = $this->sanitizeAll($return);
                }
                break;
            case is_array($entry):
                $return = $this->sanitizeAll($entry);
                break;
            default:
                $return = $entry;
                break;
        };
        if (isset($default) && ! $return) {
            return $default;
        }

        return $return;
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
