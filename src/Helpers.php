<?php


namespace IsaEken\Strargs;


class Helpers
{
    /**
     * @param string $value
     * @return float|bool|int|string|null
     */
    public static function stringToValue(string $value): float|bool|int|string|null
    {
        if (str_starts_with($value, '"') && str_ends_with($value, '"')) {
            $value = substr($value, 1);
            return substr($value, 0, mb_strlen($value) - 1);
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
     * @param bool|float|int|string|null $value
     * @return string
     */
    public static function valueToString(bool|float|int|string|null $value): string
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

        return '"' . ((string) $value) . '"';
    }
}
