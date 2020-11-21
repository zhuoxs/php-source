<?php
/**
 * API入参静态检查类
 * 可以对API的参数类型、长度、最大值等进行校验
 *
 **/
class NuomiRequestParamsCheck
{
	 /**
	  * [checkNotNull description]
	  * @param  [type] $value     [description]
	  * @param  [type] $fieldName [description]
	  * @return [type]            [description]
	  */
	public static function checkNotNull($fieldName,$value) {
		if(self::checkEmpty($value)){
			throw new Exception("missing param: " .$fieldName , 1);
		}
	}

    /**
     * @param $value
     * @return bool
     */
    public static function checkEmpty($value)
    {
        if (!isset($value)) {
            return true;
        }
        if ($value === null) {
            return true;
        }
        if (trim($value) === "") {
            return true;
        }
        return false;
    }
}
