<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2018-3-24
 * Time: 12:00
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\AppToken;
use app\api\validate\AppTokenGet;
use app\lib\exception\ParameterException;
use think\Controller;
use app\api\validate\TokenGet;
use app\api\service\UserToken;
use app\api\service\Token as TokenService;

class Token extends BaseController
{
    public function getToken($code=''){
        $code= input('code');
        (new TokenGet())->goCheck();
        $ut=new UserToken($code);
        $token= $ut->get();
        return [
            'token'=> $token
        ];
        //return 'success';

    }

    //验证客户端token
    public function verifyToken($token=''){
        if(!$token){
            throw new ParameterException([
                'token不允许为空'
            ]);
        }
        $valid= TokenService::verifyToken($token);
        return [
            'isValid' => $valid
        ];
    }

    /*
     * 第三方应用获取令牌
     * @url /app_token?
     * @post ac=:ac $e=:secret
     * */
    public function getAppToken($ac='', $se=''){
        (new AppTokenGet())->goCheck();
        $app = new AppToken();
        $token = $app->get($ac, $se);
        return [
            'token'=> $token,
        ];
    }
}