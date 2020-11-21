<?php

if( !function_exists("base_path")) {
    /**
     * @return string
     */
    function base_path(){
        return __DIR__;
    }
}


if(!function_exists('redirect'))
{
    /**
     * 跳转页面
     * @param $uri
     */
    function redirect($uri)
    {
        header("Location: $uri",true, 302);
        exit();
    }
}
if(!function_exists('dd')) {
    /**
     * @param $obj
     */
    function dd($obj)
    {
        var_dump($obj);
        exit();
    }
}

/**
 * @return array
 */
function getMenu()
{
    return config("menu");
}

/**
 * @return mixed
 */
if(!function_exists('request'))
{
    function request($key = null ,$default = null)
    {
        if($key == null)
        {
            $request = $_REQUEST;
            unset($request["_do"]);
            unset($request["_op"]);
            unset($request["_token"]);
            unset($request["_method"]);
            return $request;
        }
        return isset($_REQUEST[$key]) ? $_REQUEST[$key] :$default;

    }
}

if(!function_exists('debug')) {
    function debug($info, $replace = false)
    {

        $path = __DIR__."/../../data/logs";
        if(!file_exists($path)){
            mkdir($path);
        }

        $file = $path."/debug.txt";
        if($replace)
        {
            return file_put_contents($file,var_export($info,true));

        }
        else
        {
            return file_put_contents($file,var_export($info,true),FILE_APPEND);

        }
    }
}


/**
 * @param $resource
 * @return string
 */
function assets($resource)
{
    if(substr($resource,0,2) == "//" ||
        substr($resource,0,7) == "http://" ||
        substr($resource,0,8) == "https://"
    )
    {
        return $resource;
    }
    return "../addons/yzbld_sun/assets".$resource;
}
// baseUrl
function getBaseUrl($uri = '')
{
    $baseUrl = (isset($_SERVER['HTTPS']) && 'off' != $_SERVER['HTTPS']) ? 'https://' : 'http://';
    $baseUrl .= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
    //$baseUrl .= isset($_SERVER['SCRIPT_NAME']) ? dirname($_SERVER['SCRIPT_NAME']) : dirname(getenv('SCRIPT_NAME'));
    return $baseUrl;
}

function now()
{
    return date('Y-m-d H:i:s');
}

function isCurrent($path)
{
    $pos1 = strpos($path,"_do=");
    if($pos1 !== false){
        $pos2 = strpos($path,"&",$pos1 + 4);
        $controller = substr($path,$pos1 + 4,$pos2 -($pos1+4));
        return $controller == $_REQUEST["_do"] ? "current" : "";
    }
    return "";

}
