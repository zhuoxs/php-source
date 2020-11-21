<?php


namespace Encore\Admin;

use Illuminate\Support\Arr;


/**
 * Class Session
 * @package Encore\Admin
 */
class Session
{
    /**
     *
     */
    public static function start()
    {
        session_start();
        static::forget(static::get('_flash.old', []));

        static::put('_flash.old', static::get('_flash.new', []));

        static::put('_flash.new', []);

    }

    /**
     * @param $key
     * @param null $default
     * @return null
     */
    public static function get($key, $default = null)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    /**
     * @param $key
     * @param $value
     */
    public static function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * @param $keys
     */
    public static function forget($keys)
    {
        foreach ($keys as $key){
            if(isset($_SESSION[$key]))
                unset($_SESSION[$key]);
        }

    }

    /**
     * @param $key
     * @param $value
     */
    public static function flash($key, $value)
    {
        static::put($key, $value);
        static::push("_flash.new",$key);
        static::removeFromOldFlashData([$key]);


    }

    /**
     * Push a value onto a session array.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public static function push($key, $value)
    {
        $array = static::get($key, []);

        $array[] = $value;

        static::put($key, $array);
    }

    /**
     * @param $keys
     */
    public static function removeFromOldFlashData($keys)
    {
        static::put('_flash.old', array_diff(static::get('_flash.old', []), $keys));
    }


    /**
     * @return string
     */
    public static function getToastr()
    {
        if(Session::has("toastr")){
            $toastr     = Session::get('toastr');
            $type       = array_get($toastr['type'], 0, 'success');
            $message    = isset($toastr['message']) ? $toastr['message']:'';
            $options    = json_encode(isset($toastr['options']) ? $toastr['options']:[]);

            return sprintf("toastr.%s('%s',null,%s);",
                $type,$message,$options);
        }
        return "";
    }

    /**
     * Determine if the session contains old input.
     *
     * @param  string  $key
     * @return bool
     */
    public static function hasOldInput($key = null)
    {
        $old =static::getOldInput($key);

        return is_null($key) ? count($old) > 0 : ! is_null($old);
    }

    public static function getOldInput($key = null, $default = null)
    {
        return Arr::get(static::get('_old_input', []), $key, $default);
    }

    /**
     * Flash an array of input to the session.
     *
     * @param  array  $input
     */
    public static  function withInput(array $input = null)
    {
        static::flashInput($_REQUEST);

    }
    /**
     * Flash an input array to the session.
     *
     * @param  array  $value
     * @return void
     */
    public static function flashInput(array $value)
    {
        static::flash('_old_input', $value);
    }

}