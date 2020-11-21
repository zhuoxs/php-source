<?php


namespace Encore\Admin;


/**
 * Class Url
 * @package Encore\Admin
 */
class Url
{
    /**
     * @return string
     */
    public static function getBaseUrl()
    {
        if(isset($GLOBALS["project_type"]) && $GLOBALS["project_type"] == "we7"){
            $version_id = $_REQUEST["version_id"];
            $m = $_REQUEST["m"];
            if(intval(IMS_VERSION) == 1){
                return "/web/index.php?c=home&a=welcome&do=ext&m=$m&version_id=$version_id";
            }else{
                return "/web/index.php?c=module&a=welcome&do=welcome_display&m=$m&version_id=$version_id";
            }
        }
        else
        {
            return "/?";
        }
    }

    /**
     * @param $controller
     * @return string
     */
    public static function index($controller)
    {
       return self::setDoAndOp($controller,"index");
    }

    /**
     * @param $controller
     * @param $op
     * @param null $id
     * @return string
     */
    public static  function setDoAndOp($controller, $op, $id=null)
    {
        $url = self::getBaseUrl()."&_do=$controller&_op=$op";
        if($id != null)
        {
            $url .="&id=$id";
        }
        return $url;
    }

    /**
     * @param $controller
     * @return string
     */
    public static function create($controller)
    {
        return self::setDoAndOp($controller,"create");
    }

    /**
     * @param $controller
     * @return string
     */
    public static function store($controller)
    {
        return self::setDoAndOp($controller,"store");
    }


    /**
     * @param $controller
     * @param $id
     * @return string
     */
    public static function show($controller, $id)
    {
        return self::setDoAndOp($controller,"show",$id);
    }

    /**
     * @param $controller
     * @param null $id
     * @return string
     */
    public static function update($controller, $id=null)
    {
        return self::setDoAndOp($controller,"update",$id);
    }

    /**
     * @param $controller
     * @return string
     */
    public static function destroy($controller)
    {
        return self::setDoAndOp($controller,"destroy");
    }

    /**
     * @param $controller
     * @param $action
     * @param array $option
     * @return string
     */
    public static function generate($controller, $action, $option = []){
        if(count($option) > 0)
        {
            $url = self::getBaseUrl()."&_do=$controller&_op=$action&".http_build_query($option);
            return $url;
        }
        else
        {
            return self::setDoAndOp($controller,$action);
        }

    }
}