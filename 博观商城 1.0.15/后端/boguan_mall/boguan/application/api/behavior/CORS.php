<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2018-4-13
 * Time: 14:30
 */

namespace app\api\behavior;


class CORS
{
    public function appInit(&$params){
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: token,Origin, X-Requested-With, Content-Type, Accept');
        header('Access-Control-Allow-Methods:　POST, GET');

        if (request()->isOptions()){
            exit();
        }
    }

}