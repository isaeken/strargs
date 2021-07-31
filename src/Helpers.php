<?php


namespace IsaEken\Strargs;


class Helpers
{
    /**
     * @param string $string
     * @return bool
     */
    public static function isJson(string $string): bool
    {
        json_decode($string);
        return match (json_last_error()) {
            JSON_ERROR_NONE => '',
            JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded.',
            JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON.',
            JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded.',
            JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON.',
            JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded.',
            JSON_ERROR_RECURSION => 'One or more recursive references in the value to be encoded.',
            JSON_ERROR_INF_OR_NAN => 'One or more NAN or INF values in the value to be encoded.',
            JSON_ERROR_UNSUPPORTED_TYPE => 'A value of a type that cannot be encoded was given.',
            default => 'Unknown JSON error occurred.',
        } === '';
    }

    /**
     * @param string $value
     * @return float|bool|int|string|object|array|null
     */
    public static function stringToValue(string $value): float|bool|int|string|object|array|null
    {
        if (str_starts_with($value, '"') && str_ends_with($value, '"')) {
            $value = substr($value, 1);
            $value = substr($value, 0, mb_strlen($value) - 1);
            $value = str_replace('\"', '"', $value);
            return static::isJson($value) ? json_decode($value) :  $value;
        }
        else if (is_numeric($value)) {
            return ($value == (int) $value ? (int) $value : (float) $value);
        }
        else if (strtolower($value) === 'true' || strtolower($value) === 'false') {
            return strtolower($value) === 'true';
        }
        else if (strtolower($value) === 'null') {
            return null;
        }

        return $value;
    }

    /**
     * @param bool|float|int|string|object|array|null $value
     * @return string
     */
    public static function valueToString(bool|float|int|string|object|array|null $value): string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        else if (is_numeric($value)) {
            return (string) $value;
        }
        else if (is_null($value)) {
            return 'null';
        }
        else if (is_object($value) || is_array($value)) {
            return '"' . str_replace('"', '\"', json_encode($value)) . '"';
        }

        return '"' . ((string) $value) . '"';
    }
}
