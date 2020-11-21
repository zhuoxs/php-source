<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/27
 * Time: 11:23
 */

namespace Encore\Admin;


use Illuminate\Support\Arr;

class Config
{
    /**
     * All of the configuration items.
     *
     * @var array
     */
    protected static $items = [];

    public static function getConfigPath()
    {
        return base_path()."/config.php";
    }
    /**
     * Create a new configuration repository.
     *
     * @param  array  $items
     * @return void
     */
    public static function load()
    {
        if(file_exists($path = static::getConfigPath()))
        {
            static::$items = require_once($path);
        }

    }

    /**
     * Determine if the given configuration value exists.
     *
     * @param  string  $key
     * @return bool
     */
    public static function has($key)
    {
        return Arr::has(static::$items, $key);
    }

    /**
     * Get the specified configuration value.
     *
     * @param  array|string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        if (is_array($key)) {
            return static::getMany($key);
        }

        return Arr::get(static::$items, $key, $default);
    }

    /**
     * Get many configuration values.
     *
     * @param  array  $keys
     * @return array
     */
    public static function getMany($keys)
    {
        $config = [];

        foreach ($keys as $key => $default) {
            if (is_numeric($key)) {
                list($key, $default) = [$default, null];
            }

            $config[$key] = Arr::get(static::$items, $key, $default);
        }

        return $config;
    }

    /**
     * Set a given configuration value.
     *
     * @param  array|string  $key
     * @param  mixed   $value
     * @return void
     */
    public static function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            Arr::set(static::$items, $key, $value);
        }
    }

    /**
     * Prepend a value onto an array configuration value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public static function prepend($key, $value)
    {
        $array = static::get($key);

        array_unshift($array, $value);

        static::set($key, $array);
    }

    /**
     * Push a value onto an array configuration value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public static function push($key, $value)
    {
        $array = static::get($key);

        $array[] = $value;

        static::set($key, $array);
    }

    /**
     * Get all of the configuration items for the application.
     *
     * @return array
     */
    public static function all()
    {
        return static::$items;
    }

    /**
     * Determine if the given configuration option exists.
     *
     * @param  string  $key
     * @return bool
     */
    public static function offsetExists($key)
    {
        return static::has($key);
    }

    /**
     * Get a configuration option.
     *
     * @param  string  $key
     * @return mixed
     */
    public static function offsetGet($key)
    {
        return static::get($key);
    }

    /**
     * Set a configuration option.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public static function offsetSet($key, $value)
    {
        static::set($key, $value);
    }

    /**
     * Unset a configuration option.
     *
     * @param  string  $key
     * @return void
     */
    public static function offsetUnset($key)
    {
        static::set($key, null);
    }
}