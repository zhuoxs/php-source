<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/28
 * Time: 11:31
 */

namespace app\controller;



use think\Cookie;
use think\Db;
use think\Request;

class Open extends BaseController
{
    private  $appid;
    private  $appkey;

    function __construct (Request $request)
    {
        parent::__construct($request);
        //返回地址
        $this->redirect_uri = url("open/callback");
    }
    public function login(Request $request){
        //  var_dump($_SERVER);die;
        $code=$request->param('code/s','qq');
        $log_state=md5(uniqid(rand(), TRUE));
        $dos = array('qq', 'wechat');
        $ac = (!empty($code) && in_array($code, $dos))?$code:'qq';
        //保存到cookie
        Cookie::set('log_ac',$ac,1800);//保存登录方式
        Cookie::set('log_state',$log_state,1800);//安全state
        $mode=$ac.'_login';
        $this->$mode($log_state);
    }

    //获取登录配置信息
    public function get_loginconfig($logincode='qq'){
if(is_wechat() && $logincode=='wechat'){
    $where = ['pay_code' => 'wxPay'];
    $payInfo = Db::name('payment')->where($where)->find();
    $payConfig = \json_decode($payInfo['config'], true);
    if (!is_array($payConfig))  throw new \Exception("配置:Wechat,配置信息不正确!");
    $returnData=[];
    foreach ($payConfig as $item){
        $returnData[$item['name']]=$item['value'];
    }
    $config_info['APPID']=$returnData['appid'];
    $config_info['APPKey']=$returnData['secret_key'];
    return $config_info;
}else{
    $info=Db::name('login_setting')->where(['login_code'=>$logincode])->field('id,login_code,login_name,config,status')->find();
    $config=json_decode($info['config'],true);
    $config_info=array();
    foreach ($config as $item){
        $config_info[$item['name']]=$item['value'];
    }
    $config_info['status']=$info['status'];
    return $config_info;
}
    }
    //总登录返回方法
    public function callback(){
        $ac=Cookie::get('log_ac');
        if(empty($ac)){
            $this->error('登录已过期', url('Index/index'), null, 3);
        }
        $log_state=Cookie::get('log_state');
        $mode=$ac.'_callback';
        $uid= $this->$mode($log_state);
    }
    //微信登录调用方法
    public function wechat_login($log_state=''){
        if(is_wechat()){
            $config=$this->get_loginconfig('wechat');
            $apiUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$config['APPID']}&redirect_uri=".urlencode($this->redirect_uri)."&response_type=code&scope=snsapi_userinfo&state={$log_state}#wechat_redirect";

            header("Location:{$apiUrl}");
            exit;
        }else{
            $config=$this->get_loginconfig('wechat');
            if($config['status']==0) exit('微信登录为关闭状态~');
            $login_url='https://open.weixin.qq.com/connect/qrconnect?appid='.$config['APPID'].'&redirect_uri='.urlencode($this->redirect_uri).'&response_type=code&scope=snsapi_login&state='.$log_state.'#wechat_redirect';
            header("location:$login_url");exit;
        }

    }
    //QQ登录调用方法
    public function qq_login($log_state=''){
        $config=$this->get_loginconfig('qq');
        if($config['status']==0) exit('QQ登录为关闭状态~');
        $scope= "get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo";
        $login_url='https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id='.$config['APPID'].'&redirect_uri='.$this->redirect_uri.'&state='.$log_state.'&scope='.$scope;
        header("location:$login_url");exit;
    }
    //微信登录返回
    public function wechat_callback($log_state){
        $request= Request::instance();
        $state=$request->get('state');
        $code=$request->get('code');
        if(empty($state) || empty($code)){
            $this->error('参数错误', url('Index/index'), null, 3);
        }
        if($state!=$log_state){
            $this->error('非法登录~!', url('Index/index'), null, 3);
        }
        //获取ACCSEE_TOTEN
        $config=$this->get_loginconfig('wechat');
        $token_url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='. $config['APPID'].'&secret='. $config['APPKey'].'&code='.$code.'&grant_type=authorization_code';
        $response=json_decode($this->get_url_contents($token_url),true);
        if(array_key_exists('errcode',$response)){
            $this->error('登入失败，没获取到access_token！', url('Index/index'), null, 3);
        }
        //获取openid
        $graph_url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=". $config['APPID']."&grant_type=refresh_token&refresh_token=".$response['refresh_token'];
        $str  = json_decode($this->get_url_contents($graph_url),true);
        if(array_key_exists('errcode',$str)){
            $this->error('登入失败，没获取到openid！', url('Index/index'), null, 3);
        }
        $openid=$str['openid'];
        $get_user_info="https://api.weixin.qq.com/sns/userinfo?access_token=".$str['access_token']."&openid=".$str['openid'];
        $arr  = json_decode($this->get_url_contents($get_user_info),true);
        //先判断用户是否存在
        $userinfo = Db::name('member')->where(['openid'=>$openid])->find();
        //用户信息入库
        if(!empty($arr)&&empty($userinfo)){
            $userdata['username']='';
            $userdata['nickname']=$arr['nickname'];
            $userdata['headimgurl']=$arr['headimgurl'];
            $userdata['add_time']=time();
            $userdata['sex']= $arr['sex'];
            $userdata['last_ip']=$request->ip();
            $userdata['pid']=0;
            $userdata['openid']=$openid;
            $info=['id'=>1,'username'=>$arr['nickname'],'password'=>''];
            $userdata['access_token']=get_token($info);

            $uid=Db::name('member')->insertGetId($userdata);
            $sessionUserInfo = [
                'username' => $arr['nickname'],
                'nickname' =>$arr['nickname'],
                'email' => '',
                'tel' => '',
                'sex' => $userdata['sex'],
                'is_agent' => 0,
                'headimgurl' =>$arr['headimgurl'],
                'is_permanent' => 0
            ];
            //写入session
            session('access_token',  $userdata['access_token']);
            session('member_id', $uid);
            session('member_info', $sessionUserInfo);
            $this->success('登录成功', url('Index/index'), null, 3);
        }else if($userinfo){
            $sessionUserInfo = [
                'username' => $userinfo['username'],
                'nickname' =>$userinfo['nickname'],
                'email' => $userinfo['email'],
                'tel' => $userinfo['tel'],
                'sex' => $userinfo['sex'],
                'is_agent' => 0,
                'headimgurl' =>$userinfo['headimgurl'],
                'is_permanent' => 0
            ];
            $token=get_token($userinfo);
            Db::name('member')->where(['openid'=>$openid])->update(['access_token'=>$token]);
            //写入session
            session('access_token', $token);
            session('member_id', $userinfo['id']);
            session('member_info', $sessionUserInfo);
            $this->success('登录成功', url('Index/index'), null, 3);
        }else{
            $this->error('请求出错', url('Index/index'), null, 3);
        }
    }
    //QQ登录返回
    public function qq_callback($log_state){
        $request= Request::instance();
        $state=$request->get('state');
        $code=$request->get('code');
        if(empty($state) || empty($code)){
            $this->error('参数错误', url('Index/index'), null, 3);
        }
        if($state!=$log_state){
            $this->error('非法登录~!', url('Index/index'), null, 3);
        }
        //获取ACCSEE_TOTEN
        $config=$this->get_loginconfig('qq');
        $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
            . "client_id=" . $config['APPID']. "&redirect_uri=" . urlencode($this->redirect_uri)
            . "&client_secret=" . $config['APPKey']. "&code=" . $code;
        $response=$this->get_url_contents($token_url);
        if (strpos($response, "callback") !== false){
            $this->error('登入失败，没获取到access_token！', url('Index/index'), null, 3);
        }
        $params = array();
        parse_str($response, $params);
        $data['access_token']=$params['access_token'];
        $data['refresh_token']=$params['refresh_token'];
        $data['expire_in']=$params['expires_in'];
        //获取OPENID
        $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=".$data['access_token'];
        $str  = $this->get_url_contents($graph_url);
        if (strpos($str, "callback") !== false){
            $lpos = strpos($str, "(");
            $rpos = strrpos($str, ")");
            $str  = substr($str, $lpos + 1, $rpos - $lpos -1);
        }
        $user = json_decode($str);
        if (isset($user->error)){
            $this->error('获取openid失败！', url('Index/index'), null, 3);
        }
        $qqid=$user->openid;
        //获取用户信息
        $get_user_info = "https://graph.qq.com/user/get_user_info?"
            . "access_token=" . $data['access_token']
            . "&oauth_consumer_key=" . $config['APPID']
            . "&openid=" . $qqid
            . "&format=json";

        $info=$this->get_url_contents($get_user_info);
        $arr = json_decode($info, true);
        //先判断用户是否存在
        $userinfo = Db::name('member')->where(['openid'=>$user->openid])->find();
        //用户信息入库
        if(!empty($arr)&&empty($userinfo)){
            $userdata['username']='';
            $userdata['nickname']=$arr['nickname'];
            $userdata['headimgurl']=$arr['figureurl_2'];
            $userdata['add_time']=time();
            $arr['gender']=='男'?$userdata['sex']=1:$userdata['sex']=0;
            $userdata['last_ip']=$request->ip();
            $userdata['pid']=0;
            $userdata['openid']=$qqid;
            $info=['id'=>1,'username'=>$arr['nickname'],'password'=>''];
            $userdata['access_token']=get_token($info);

            $uid=Db::name('member')->insertGetId($userdata);
            $sessionUserInfo = [
                'username' => $arr['nickname'],
                'nickname' =>$userinfo['nickname'],
                'email' => $userinfo['email'],
                'tel' => $userinfo['tel'],
                'sex' => $userdata['sex'],
                'is_agent' => 0,
                'headimgurl' =>$arr['figureurl_2'],
                'is_permanent' => 0
            ];
            //写入session
            session('access_token',  $userdata['access_token']);
            session('member_id', $uid);
            session('member_info', $sessionUserInfo);
            $this->success('登录成功', url('Index/index'), null, 3);
        }else if($userinfo){
            $sessionUserInfo = [
                'username' => $userinfo['username'],
                'nickname' =>$userinfo['nickname'],
                'email' => $userinfo['email'],
                'tel' => $userinfo['tel'],
                'sex' => $userinfo['sex'],
                'is_agent' => 0,
                'headimgurl' =>$userinfo['headimgurl'],
                'is_permanent' => 0
            ];
            $token=get_token($userinfo);
            Db::name('member')->where(['openid'=>$qqid])->update(['access_token'=>$token]);
            //写入session
            session('access_token', $token);
            session('member_id', $userinfo['id']);
            session('member_info', $sessionUserInfo);
            $this->success('登录成功', url('Index/index'), null, 3);
        }else{
            $this->error('请求出错', url('Index/index'), null, 3);
        }
        //   return $this->denglu_str('qq',$qqid,$data);

    }

    //POST 、 GET
    function get_url_contents($url,$post='',$type='get'){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        if($type=='post') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }else{
            curl_setopt($ch, CURLOPT_POST, 0);
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'msvod');
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}