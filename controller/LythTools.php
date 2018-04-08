<?php
 /**
 *
 */
class LythTools
{
    public static function isInt( int $value)
    {
        return is_Int($value);
    }
    public static function isNumeric($value)
    {
        return is_numeric($value);
    }
    public static function isString($data)
    {
        return is_string($data);
    }
    public static function isUrl($url)
    {
        return preg_match('/^[~:#,$%&_=\(\)\.\? \+\-@\/a-zA-Z0-9\pL\pS-]+$/u', $url);
    }
    public static function isGenericName($name)
    {
        return preg_match("/^[a-zA-ZÀ-ÿ'. -]+$/", $name);
    }
    public static function isPattern( string $pattern, int $hit_count)
    {
        if (!preg_match('/^\d+(?:-\d+)*$/', $pattern)) {
            return false;
        }
        $hits = explode('-', $pattern);

        if ($hit_count !== count($hits)) {
            return false;
        }

        return true;
    }
    public static function isColor($color)
    {
        return preg_match('/^(#[0-9a-fA-F]{6}|[a-zA-Z0-9-]*)$/', $color);
    }
}
