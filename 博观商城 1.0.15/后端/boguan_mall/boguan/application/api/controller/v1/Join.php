<?php
/**
 * Created by Boguan.
 * User: leo
 * WebSite: http://www.boguanweb.com
 * Date: 2018-9-7
 * Time: 11:44
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\model\Join as JoinModel;
use app\api\model\JoinForm as JoinFormModel;
use app\api\service\Token as TokenService;

class Join extends BaseController
{

    public function getJoinContent(){
        $join= JoinModel::where('status','=',1)->order('create_time','desc')->find();

        if (!$join){
            return [
                'msg'=> '获取失败',
                'errorCode'=> 0
            ];
        }
        return [
            'msg'=> '获取成功',
            'data'=> $join,
            'errorCode'=> 1
        ];
    }

    //加盟申请
    public function joinSubmit(){
        $data= input('post.');
        $validate = \think\Loader::validate('Withdraw');
        $result= $validate->check($data);
        if(!$result){
            return [
                'msg'=> $validate->getError(),
                'errorCode'=> 0,
            ];
        }
        if(isset($data['formId'])){
            $data['prepay_id']= $data['formId'];
            unset($data['formId']);
        }
        $uid= TokenService::getCurrentUid();
        $haveSubmit= JoinFormModel::where([
            'user_id'=> $uid,
            'status'=> 0
        ])->find();
        if ($haveSubmit){
            return [
                'msg'=> '您已提交，请等待审核',
                'errorCode'=> 0
            ];
        }

        $data['user_id']= $uid;
        $res= JoinFormModel::create($data);
        if ($res){
            return [
                'msg'=> '提交成功，请等待审核',
                'errorCode'=> 1
            ];
        }else{
            return [
                'msg'=> '网络异常',
                'errorCode'=> 0
            ];
        }
    }
}