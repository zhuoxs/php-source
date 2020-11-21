<?php
namespace app\admin\controller;


use app\model\Openvip;
use app\model\Vipcode;
use app\model\Memberconf;
use app\model\Vipcard;
use app\model\Userbalancerecord;

class Cuser extends Base
{
    public function get_list(){

        $model = $this->model;

        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('nickname','like',"%$key%");
            }
            global $_W;
            $query->where('uniacid',$_W['uniacid']);
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->where($query)->select();
        foreach ($list as $key=>$value){
            $list[$key]['vip_endtime']=$value['vip_endtime']?date('Y-m-d H:i:s',$value['vip_endtime']):'未开通';
        }
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function editbalance(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id=input('get.id');
        $info = \app\model\User::get(['id'=>$id]);
        $this->view->info = $info;
        return view('editbalance');
    }
    public function savebalance(){
        global $_W,$_GPC;
        $bal=new Userbalancerecord();
        $id = input('post.id');
        $type=input('post.type');
        $money=input('post.money');
        if($id>0&&$money>0){
            if($type==2){
                $money=-$money;
            }
            $bal->editBalance($id,$money);
            $bal->addBalanceRecord($id,$_W['uniacid'],4,$send_money='0.00',$money,'','',$remark='后台修改操作');
            return array(
                'code'=>0,
                'data'=>1
            );
        }
    }
    /**
     * 会员卡设置
    */
    public function vipcard(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view();
    }
    public function get_vipcard_list(){
        $model = new Vipcard();
        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
        };
        //排序、分页
        $model->fill_order_limit();
        $list = $model->where($query)->select();
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    /**
     * 激活码
    */
    public function vipcode(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view();
    }
    public function get_vipcode_list(){
        $model = new Vipcode();
        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('code|batch','like',"%$key%");
            }
            $type=input('get.type');
            if($type){
                $query->where('isuse','=',$type-1);
            }

        };
        //排序、分页
        $model->fill_order_limit();
        $list = $model->where($query)->select();
        foreach ($list as $key =>$value){
            $list[$key]['usetime']=$value['usetime']?date('Y-m-d H:i:s',$value['usetime']):"";
        }
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function savecode(){
        $num=input('post.number');
        $day=input('post.day');
        $nums=ceil(($num/2));
        for ($j=0;$j<$nums;$j++){
            $this->addcode($day,$j,$num);
        }
        return array(
            'code'=>0,
            'data'=>1
        );
    }
    public function addcode($day,$page,$num){
        $last=$num-($page*2);
        if($last>2){
            $length=2;
        }else{
            $length=$last;
        }
        $batch='NO'.date('YmdHis');
        for ($i = 0; $i < $length; $i++) {
            $strs="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
            $code=substr(str_shuffle($strs),mt_rand(0,strlen($strs)-11),10).rand(100000,999999);
            $newcode=substr($code,0,15);
            $data['code']=$newcode;
            $data['day']=$day;
            $data['batch']=$batch;
            $is=Vipcode::get(['code'=>$newcode]);
            if($is){
                unset($data);
            }else{
                $model=new Vipcode();
                $model->allowField(true)->save($data);
            }
        }
    }
    /**
     * 会员规则
    */
    public function memberrule(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = [];

        $info['member_pic'] = \app\model\Config::get_value('member_pic');
        $info['member_bg_color'] = \app\model\Config::get_value('member_bg_color');
        $info['member_font_color'] = \app\model\Config::get_value('member_font_color');
        $info['member_rule'] = \app\model\Config::get_value('member_rule');
        $this->view->info = $info;
        return view();
    }
    public function savememberrule(){
        $info = new \app\model\Config();

        $data = input('post.');

        $list = [];

        $list[] = \app\model\Config::full_id('member_rule',$data['member_rule']);
        $list[] = \app\model\Config::full_id('member_pic',$data['member_pic']);
        $list[] = \app\model\Config::full_id('member_bg_color',$data['member_bg_color']);
        $list[] = \app\model\Config::full_id('member_font_color',$data['member_font_color']);
        $ret = $info->allowField(true)->saveAll($list);

        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }
    //TODO::导出激活码
    public function exportData(){
        global $_W;
        $model=new Vipcode();
        $list=$model->where(['isuse'=>0,'uniacid'=>$_W['uniacid'],'state'=>1])->field('code,day')->select();
        $list=json_decode(json_encode($list),true);
        $str = iconv("utf-8","gb2312//IGNORE","激活码,有效天数\n");
        foreach ($list as $key => $value) {
            $code=iconv("utf-8","gb2312//IGNORE",$value['code']);
            $str .=$code.",".$value['day']."\n";
        }
        $filename = '激活码导出'.date('YmdHis').'.csv'; //设置文件名
        export_csv($filename,$str);     //导出///
    }
    //TODO::导出用户信息
    public function exportUserData(){
        global $_W;
        $model=new \app\model\User();
        $list=$model->where(['uniacid'=>$_W['uniacid']])->select();
        $list=json_decode(json_encode($list),true);
        $str = iconv("utf-8","gb2312//IGNORE","uid,昵称,电话,性别,累计消费,会员卡号,会员到期时间\n");
        foreach ($list as $key => $value) {
            $nickname=iconv("utf-8","gb2312//IGNORE",$value['nickname']);
            if($value['gender']==1){
                $gender=iconv("utf-8","gb2312//IGNORE",'男');
            }elseif($value['gender']==2){
                $gender=iconv("utf-8","gb2312//IGNORE",'女');
            }else{
                $gender=iconv("utf-8","gb2312//IGNORE",'未知');
            }
            $vip_end_time=$value['vip_endtime']?date('Y-m-d H:i:s',$value['vip_endtime']):'';
            $str .=$value['id'].",".$nickname.",".$value['tel'].",".$gender.",".$value['total_consume'].",".$value['vip_cardnum'].",".$vip_end_time."\n";
        }
        $filename = '用户信息导出'.date('YmdHis').'.csv'; //设置文件名
        export_csv($filename,$str);     //导出///
    }
    public function viplog(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view();
    }
    public function get_viplog_list(){
        $model = new Openvip();
        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('user_id','like',"%$key%");
            }
            $type=input('get.type');
            if($type){
                $query->where('type','=',$type);
            }

        };
        //排序、分页
        $model->fill_order_limit();
        $list = $model->where($query)->select();
        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function selectrules(){
        $model = $this->model;
        $model->field("id,nickname as text")->order('id asc');
        $list = $model->select();
        return $list;
    }
}
