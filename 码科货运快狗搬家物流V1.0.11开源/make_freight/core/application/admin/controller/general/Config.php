<?php

namespace app\admin\controller\general;

use app\common\controller\Backend;
use app\common\model\Config as ConfigModel;
use think\Exception;
use think\Db;

/**
 * 系统配置
 *
 * @icon fa fa-cogs
 * @remark 可以在此增改系统的变量和分组,也可以自定义分组和变量,如果需要删除请从数据库中删除
 */
class Config extends Backend
{

    /**
     * @var \app\common\model\Config
     */
    protected $model = null;
    protected $noNeedRight = ['check'];

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new ConfigModel();
    }

    /**
     * 查看
     */
    public function index()
    {

        $res    = Db::name('config')->where('uniacid',$GLOBALS['fuid'])->select();

        $config  = null;
        if($res){
            $config = array_column($res,'value','name');
        }


        $uid    = db('admin')->where('id',$this->auth->id)->field('id,uniacid')->find();

        $keyFile = IA_ROOT.'/addons/make_freight/workman/ssl/server.key';
        $pemFile = IA_ROOT.'/addons/make_freight/workman/ssl/server.pem';
        $key     = '';
        $pem     = '';
        is_file($keyFile) && $key = file_get_contents($keyFile);
        is_file($pemFile) && $pem = file_get_contents($pemFile);



        return $this->view->fetch('',[
            'setting'   => $config,
            'uniacid'   => $uid,
            'skey'      => $key,
            'spem'      => $pem
        ]);
    }

    /**
     * 基础设置
     */
    public function base(){
        if( request()->isPost() ){
            $params = $this->request->post('row/a');

            $field  = ['admin_name','admin_url'];
            $re     = $this->model->editConfig($params,$field);


            $admin = model('admin')->get($this->auth->id);
            $admin->save(['uniacid'=>$params['uniacid']]);
            session("freight_admin", $admin->toArray());




            if($re || $admin){
                $this->success('更新成功');
            }else{
                $this->error('更新失败');
            }

        }
    }

    /**
     * 小程序配置
     */
    public function SmallProgram(){
        if( request()->isPost() ){
            $params = $this->request->post('row/a');

            foreach($params as $k=>&$v){
                $v = preg_replace('# #','',$v);
                if(empty($v)){
                    return $this->error('请输入配置参数');
                }
            }
            $field  = ['program_background','program_font','program_title','appid','appsecret','amap','tmap','logo','share'];

            $re     = $this->model->editConfig($params,$field);
            if($re){
                $this->success('更新成功');
            }else{
                $this->error('更新失败');
            }
        }
    }

    /**
     * 其他配置
     */
    public function rest(){
        if( request()->isPost() ){
            $params = $this->request->post('row/a');
            foreach($params as $k=>&$v){
                $v = preg_replace('# #','',$v);
                if(empty($v)){
                    return $this->error('请输入配置参数');
                }
            }

            $field  = ['order_ratio','withdrawal_condition','scope','service_tel','get_scope'];

            $re     = $this->model->editConfig($params,$field);
            if($re){
                $this->success('更新成功');
            }else{
                $this->error('更新失败');
            }
        }
    }

    //短信配置
    public function sms(){
        if( request()->isPost() ){
            $params = $this->request->post('row/a');
            foreach($params as $k=>&$v){
                $v = preg_replace('# #','',$v);
                if(empty($v)){
                    return $this->error('请输入配置参数');
                }
            }

            $field  = ['ali_access','ali_secret','sign_name','code_sms'];

            $re     = $this->model->editConfig($params,$field);
            if($re){
                $this->success('更新成功');
            }else{
                $this->error('更新失败');
            }
        }
    }
    //ssl证书配置
    public function ssl(){
        if( request()->isPost() ){
            $params = $this->request->post('row/a');
            foreach($params as $k=>&$v){
                if(empty($v)){
                    return $this->error('请输入配置参数');
                }
            }

            $key = file_put_contents(IA_ROOT.'/addons/make_freight/workman/ssl/server.key',$params['ssl_key']);
            $pem = file_put_contents(IA_ROOT.'/addons/make_freight/workman/ssl/server.pem',$params['ssl_pem']);

            if($key || $pem){
                $this->success('更新成功');
            }else{
                $this->error('更新失败');
            }
        }
    }


    //微信配置
    public function wechat(){
        if( request()->isPost() ){
            $params = $this->request->post('row/a');


            $field  = ['mchid','mch_cert','mch_key','pay_secret'];

            $re     = $this->model->editConfig($params,$field);
            if($re){
                $this->success('更新成功');
            }else{
                $this->error('更新失败');
            }
        }
    }

    //活动设置
    public function  activity(){
        $coupons = db('coupon')->where('uniacid',$GLOBALS['fuid'])->field('id,name')->select();
        $config  = db('config')->where(['name'=>['in',['coupon_id','coupon_back']],'uniacid'=>$GLOBALS['fuid'] ])->field('value,name')->select();
        if($config)
            $config  = array_column($config,'value','name');

        if( $this->request->isPost() ){
            $params = $this->request->param('row/a');
            $field  = ['coupon_id','coupon_back'];
            $re     = $this->model->editConfig($params,$field);
            if($re){
                $this->success('更新成功');
            }else{
                $this->error('更新失败');
            }

        }


        $this->assign([
            'coupons'  => $coupons,
            'setting'  => $config,
        ]);
        return $this->view->fetch();
    }

    //协议设置
    public function agreement(){
        if( $this->request->isPost() ){
            $params = $this->request->param('row/a');
            $field  = ['user_agm','driver_agm'];
            $re     = $this->model->editConfig($params,$field);
            if($re){
                $this->success('更新成功');
            }else{
                $this->error('更新失败');
            }

        }
    }

    //注册小程序模板库
    public function registel_tpl(){

        $type = !empty($_REQUEST['type']) ? abs(intval($_REQUEST['type'])) : 0;
        if($type>1)
            $this->error('传递类型有误，请刷新后重试');


        $tplId = array('AT0009','AT1001');
        $value = array('user_msg_tpl','driver_msg_tpl');
        $examples= array(
            array('订单编号','取货地址','收货地址','金额','备注','下单时间'),
            array('订单号','订单金额','下单人','备注','配送地址'),
        );


        $unicid = $GLOBALS['fuid'];

        $token = get_access_token($unicid);

        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/library/get?access_token='.$token;

        $result = setRequest($url,json_encode(array("id"=>$tplId[$type])));
        $result = json_decode($result, true);
        if($result['errcode']!==0){
            $this->error($result['errmsg'] ? $result['errmsg'] : '获取模板消息列表失败!');
        }
        $example = $examples[$type];

        $data = array();

        foreach ($result['keyword_list'] as $v){
            if(in_array($v['name'],$example)){
                $data[array_search($v['name'],$example)] = $v['keyword_id'];
            }
        }
        ksort($data);
        $data = json_encode(array(
            'id'    => $tplId[$type],
            'keyword_id_list'=>$data
        ));

        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/add?access_token='.$token;
        $resultTpl = setRequest($url,$data);
        $resultTpl = json_decode($resultTpl,true);

        if($resultTpl['errcode']!==0 || empty($resultTpl['template_id'])){
            $this->error($resultTpl['errmsg'] ? $resultTpl['errmsg'] : '添加至模板库列表失败!');
        }

        //直接更新

        $set = $this->model->editConfig([ $value[$type] => $resultTpl['template_id']],[$value[$type]]);
        if(!empty($set)) {
            $this->success('操作成功！已启用',null,$resultTpl);
        }

        $this->error('保存失败！请稍后重试');
    }



}
