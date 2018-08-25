<?php

/*
 * This file is part of My Test News Site.
 * @link https://github.com/IlyaDolgorukov/newssite
 * @author Ilya Dolgorukov
 * 
 */

namespace core;

/**
 * Class Request
 * @package core
 */
class Request
{
    const TYPE_INT = 'int';
    const TYPE_STRING = 'string';
    const TYPE_STRING_TRIM = 'string_trim';
    const TYPE_ARRAY_INT = 'array_int';
    const TYPE_ARRAY = 'array';

    /**
     * @var array
     */
    protected static $params = array();

    /**
     * @param $key
     * @param null $value
     */
    public static function setParam($key, $value = null)
    {
        if ($value === null && is_array($key)) {
            self::$params = $key;
        } else {
            self::$params[$key] = $value;
        }
    }

    /**
     * @param $val
     * @param null $type
     * @return array|int|mixed|null|string
     */
    protected static function cast($val, $type = null)
    {
        $result = $val;
        $type = trim(strtolower($type));
        switch ($type) {
            case self::TYPE_INT:
                $result = (int)$val;
                break;
            case self::TYPE_STRING_TRIM:
                $result = trim(self::cast($val, self::TYPE_STRING));
                break;
            case self::TYPE_ARRAY_INT:
                if (!is_array($val)) {
                    $val = explode(",", $val);
                }
                foreach ($val as &$v) {
                    $v = self::cast($v, self::TYPE_INT);
                }
                reset($val);
                $result = $val;
                break;
            case self::TYPE_STRING:
                if (is_array($val)) {
                    $result = reset($val);
                    if (is_array($result)) {
                        $result = null;
                    }
                }
                break;
            case self::TYPE_ARRAY:
                if (!is_array($val)) {
                    $result = (array)$val;
                }
                break;
        }
        return $result;
    }

    /**
     * @param $value
     * @return string
     */
    public static function clearFormField($value)
    {
        $val = self::cast($value, '', 'string_trim');
        return (!empty($val)) ? htmlspecialchars($val) : '';
    }

    public static function validateForm($data, $fields)
    {
        $errors = $values = array();
        foreach ($fields as $field) {
            $val = (isset($data[$field])) ? self::clearFormField($data[$field]) : '';
            if (!empty($val)) {
                $values[$field] = $val;
            } else {
                $errors[] = $field;
            }
        }
        return compact('values', 'errors');
    }

    /**
     * @param null $name
     * @param null $default
     * @param null $type
     * @return array|int|mixed|null|string
     */
    public static function get($name = null, $default = null, $type = null)
    {
        return self::getData($_GET, $name, $default, $type);
    }

    /**
     * @param null $name
     * @param null $default
     * @param null $type
     * @return array|int|mixed|null|string
     */
    public static function post($name = null, $default = null, $type = null)
    {
        return self::getData($_POST, $name, $default, $type);
    }

    /**
     * @param null $name
     * @param null $default
     * @param null $type
     * @return array|int|mixed|null|string
     */
    public static function param($name = null, $default = null, $type = null)
    {
        return self::getData(self::$params, $name, $default, $type);
    }

    /**
     * @param null $name
     * @param null $default
     * @param null $type
     * @return array|int|mixed|null|string
     */
    public static function server($name = null, $default = null, $type = null)
    {
        if ($name && !isset($_SERVER[$name])) {
            $name = strtoupper($name);
        }
        return self::getData($_SERVER, $name, $default, $type);
    }

    /**
     * @return string
     */
    public static function getMethod()
    {
        return strtolower(self::server('REQUEST_METHOD'));
    }

    /**
     * @param $data
     * @param null $name
     * @param null $default
     * @param null $type
     * @return array|int|mixed|null|string
     */
    protected static function getData($data, $name = null, $default = null, $type = null)
    {
        if ($name === null) {
            return $data;
        }
        if (isset($data[$name])) {
            return $type ? self::cast($data[$name], $type) : $data[$name];
        } else {
            return self::getDefault($default);
        }
    }

    /**
     * @param $default
     * @return array|mixed
     */
    protected static function getDefault(&$default)
    {
        return is_array($default) && $default ? array_shift($default) : $default;
    }

    /**
     * @param null $name
     * @param null $default
     * @param null $type
     * @return array|int|mixed|null|string
     */
    public static function cookie($name = null, $default = null, $type = null)
    {
        return self::getData($_COOKIE, $name, $default, $type);
    }

    /**
     * @return bool
     */
    public static function isXMLHttpRequest()
    {
        return self::server('HTTP_X_REQUESTED_WITH') == 'XMLHttpRequest';
    }
}
