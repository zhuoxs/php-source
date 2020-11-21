<?php
namespace Home\Controller;

use Common\Controller\PublicBaseController;
use Common\Model\PhonecodeModel;
use Common\Model\SmsModel;
use Org\Net\Jssdk;

class PublicController extends PublicBaseController{

  
    public function getcode()
  {
  	  $tel = trim( $_REQUEST['tel'] );
      $code = mt_rand(100000,999999);
    
     if( !$this->checkMobile( $tel ) )
     {
           echo json_encode( array( 'msg' => '手机号码错误', 'code' => 0 ) );
           exit;
     }
      $yzmtime =  session( 'yzmtime' );
      if( $yzmtime )
      {
      		if( $lefttime = time() - $yzmtime < 60 )
            {
            	    if( !$this->checkMobile( $tel ) )
                     {
                           echo json_encode( array( 'msg' => $lefttime.'秒后重试', 'code' => 0 ) );
                           exit;
                     }
            }
      }
      session( 'yzmcode' , $code );
     	
      
      $statusStr = array(
        "0" => "短信发送成功",
        "-1" => "参数不全",
        "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
        "30" => "密码错误",
        "40" => "账号不存在",
        "41" => "余额不足",
        "42" => "帐户已过期",
        "43" => "IP地址限制",
        "50" => "内容含有敏感词"
        );
        $smsapi = "http://api.smsbao.com/";
        $user = "shenlujie"; //短信平台帐号
        $pass = md5("slj19851023"); //短信平台密码
        $content= "【米粒小屋赞多多】您的验证码为{$code}，验证码5分钟内有效。";
        $phone = $tel;//要发送短信的手机号码
        $sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
        $result =file_get_contents($sendurl) ;
      	if( $result == '0' )
        {
        		 echo json_encode( array( 'msg' => '短信发送成功', 'code' => 1) );
            	exit;
        }
      else  
      {
    		  echo json_encode( array( 'msg' => '短信发送失败:'.$statusStr[$result], 'code' => 0 ) );
              exit;
      }
 
      
    	include dirname(__FILE__).'/Alisms.class.php';
    	 $Alisms = new \Alisms( 'LTAI17wCRrzxDYa6', 'deln1BPGQO7onAjTA5Rnk0OqYXXDZb','点点网','SMS_168590830'  );
		 $arr  = $Alisms -> sendSms(  $tel, $code);
 
   		 
    
    	if( $arr['Message'] == "OK" && $arr['Code'] == "OK" )
        {
        	    echo json_encode( array( 'msg' => '短信发送成功', 'code' => 1) );
            	exit;
        }
    	else
        {
         
        	  echo json_encode( array( 'msg' => '短信发送失败:'.$arr['Message'], 'code' => 0 ) );
              exit;
        }
    
    
    
    
    
      header('content-type:text/html;charset=utf-8');
      $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
      $smsConf = array(
          'key'   => 'b0044997fa6c2435cb99405f6c451358', //您申请的APPKEY
          'mobile'    => $tel, //接受短信的用户手机号码
          'tpl_id'    => '147086', //您申请的短信模板ID，根据实际情况修改
          'tpl_value' =>'#code#='.$code //您设置的模板变量，根据实际情况修改
      );
      $content = $this->juhecurl($sendUrl,$smsConf,1); //请求发送短信
		
      if($content)
      {
          $result = json_decode($content,true);
          $error_code = $result['error_code'];
          if($error_code == 0){
              //状态为0，说明短信发送成功
            
            session( 'yzmtime' , time() );
            
               echo json_encode( array( 'msg' => '短信发送成功', 'code' => 1) );
            	exit;
          }else{
              //状态非0，说明失败
              $msg = $result['reason'];
             # echo "短信发送失败(".$error_code.")：".$msg; exit;
            
               echo json_encode( array( 'msg' => '短信发送失败:'.$msg, 'code' => 0 ) );
            	exit;
            
          }
      }else{
          //返回内容异常，以下可根据业务逻辑自行修改
         # echo "请求发送短信失败";  exit;
                echo json_encode( array( 'msg' => '请求发送短信失败:'.$msg, 'code' => 0 ) );
            	exit;
      }



  }
  
  function juhecurl($url,$params=false,$ispost=0){
    $httpInfo = array();
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
    curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
    if( $ispost )
    {
        curl_setopt( $ch , CURLOPT_POST , true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
        curl_setopt( $ch , CURLOPT_URL , $url );
    }
    else
    {
        if($params){
            curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
        }else{
            curl_setopt( $ch , CURLOPT_URL , $url);
        }
    }
    $response = curl_exec( $ch );
    if ($response === FALSE) {
        //echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
    $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
    curl_close( $ch );
    return $response;
}
  
  
  function checkMobile($str) 
   { 
     $pattern = "/^(13|15|14|16|17|18|19)\d{9}$/"; 
     if (preg_match($pattern,$str)) 
     { 
       return true; 
     } 
     else
     { 
       return false; 
     } 
   } 
    /**
     * 注册
     */
    public function reg()
    {

        if( IS_POST ) {
            $member_model = M('member');
            $time = time();
            $d = I('post.');
            $username = trim($d['username']);
            $nickname = trim($d['nickname']);
            $password = trim($d['password']);
            $repassword = trim($d['repassword']);
            $invite_code = intval($d['invite_code']);
			$code =  trim($d['code']);
            if( $username == '' ) {
                $this->error('请输入要注册的账户。');
            }
          
                 if( empty( $code ) ) 
            {
                $this->error('请输入短信验证码。');
            }
          
             if( $code != session('yzmcode')  ) 
            {
               $this->error('短信验证码不正确。');
            }
          
          
            if( $nickname == '' ) {
                $this->error('请输入您的姓名。');
            }
            if( $password == '' ) {
                $this->error('请输入密码。');
            }
            if( $repassword == '' ) {
                $this->error('请出入确认密码。');
            }
            if( $password!=$repassword ) {
                $this->error('两次密码输入不相同。');
            }

            if( $invite_code != '') {
                $check_code = $member_model->where(array('id'=>$invite_code))->find();
                if( empty($check_code) ) {
                    $this->error('邀请码不存在。');
                }
            }

            $check_username = $member_model->where(array('username'=>$username))->find();
            if( $check_username ) {
                $this->error('该账号已被注册。');
            }
            $data = array();
            $data['username'] = $username;
            $data['nickname'] = $nickname;
            $data['password'] = sp_encry($password);
            $data['p1'] = $invite_code;
            $data['create_time'] = $time;
            $data['last_login_time'] = $time;


            if (!empty($invite_code)) {
                $parent_pids = $member_model->where(array('id' => $invite_code))->getField('pids');
                $pids = !empty($parent_pids) ? $parent_pids.','.$invite_code : $invite_code;
                //保留10层关系
                $pids = explode(',', $pids);
                $pids = array_slice($pids, -10);
                $pids = implode(',',$pids);
                $data['pids'] = $pids;

                //推荐人的团队总数加1
                $data1 = array(
                    'id' => $invite_code,
                    'p1_num'=> array('exp', "`p1_num`+1"),
                    'p_num' => array('exp', "`p_num`+1")
                );
                $member_model->save($data1);

                //二级
                $p2 = $member_model->where(array('id' => $invite_code))->getField('p1');
                if( intval($p2)>0 ) {
                    $data['p2'] = intval($p2);

                    //推荐人团队总数加1
                    $data2 = array(
                        'id' => $p2,
                        'p2_num'=> array('exp', "`p2_num`+1"),
                        'p_num' => array('exp', "`p_num`+1")
                    );
                    $member_model->save($data2);
                }

                //往上3级 （1级）
                if( intval($p2)>0 ) {
                    $p3 = $member_model->where(array('id' => $p2))->getField('p1');
                    if( intval($p3)>0 ) {
                        $data['p3'] = intval($p3);

                        //推荐人团队总数加1
                        $data3 = array(
                            'id' => $p3,
                            'p3_num'=> array('exp', "`p3_num`+1"),
                            'p_num' => array('exp', "`p_num`+1")
                        );
                        $member_model->save($data3);
                    }
                }
            }

            $res = $member_model->add($data);
            $id = $res;
            if( $res ) {
                $user = $member_model->find($id);
                session('member', $user);
                $this->success('注册成功', U('task/appxiazai'));
            } else {
                $this->error('注册失败');
            }
        } else {
            if( $this->is_login() ) {
                $this->redirect('index/index');
            }
            $invite_code = I('get.smid');
            $this->assign('invite_code', $invite_code);
            $title = '用户注册';
            $this->assign('title', $title);
            $this->display();
        }
    }

    /**
     * 登陆
     */
    public function login()
    {
        if( IS_POST ){
            $referer = I('post.referer');
            if( empty($referer) ){
                $referer = base64_encode(U('Index/index'));
            }
            $referer = base64_decode($referer);

            $username = trim(I('post.username'));
            $password = trim(I('post.password'));
            if( $username == '' && $password == '' ) {
                $this->error('请输入登录账户和密码。');
            }
            if( $username == '' ) {
                $this->error('请输入登录账户。');
            }
            if( $password == '' ) {
                $this->error('请输入密码。');
            }
//            echo sp_encry($password);exit;
            $result = M('member')->where( array('username'=>$username, 'password'=>sp_encry($password) ))->find();
            if( $result ){
                M('member')->where(array('id'=>$result['id']))->getField('last_login_time', time());
                session('member', $result);
                echo json_encode( array('status'=>1,'info'=>'登陆成功','url'=>$referer) );
                exit;
            } else {
                $this->error('登录失败，用户名或密码错误！');
            }
        } else {
            $referer = I('get.referer');
            if( empty($referer) ) {
                if( strpos($referer,'logout') !== false ) {
                    $referer = $_SERVER['HTTP_REFERER'];
                }
            }
            if( !empty($referer) ) {
                $referer = base64_encode($referer);
            }

            $this->assign('title','登录');
            $this->assign('referer',$referer);
            $this->display();
        }
    }

    /**
     * 注销
     */
    public function logout(){
        if(isset($_SESSION['member'])) {
            unset($_SESSION['member']);
            unset($_SESSION['member_client_info']);
            session_destroy();
            $this->redirect('Index/index');
            //$this->success('退出成功！', U('Public/login'));
        }else {
            $this->error('已经登出！', U('Public/login'));
        }
    }

    /**
     * 检测手机号
     * @param $phone
     * @param $tip
     * @return bool
     */
    public function check_phone($phone, &$tip)
    {
        if( empty($phone) ) {
            $phone = I('phone');
        }
        if( empty($phone) ) {
            $tip = '手机号码不能为空。';
            return false;
        }
        if( !is_phone($phone) ) {
            $tip = '手机号码格式不正确。';
            return false;
        }
        $count = M('member')->where(array('phone'=>$phone))->count();
        if( intval($count) > 0 ) {
            $tip = '该手机号码已被注册。';
            return false;
        }
        return true;
    }

    /**
     * 发送短信
     */
    public function send_phone_code()
    {

        $has_send_phone_code = session('has_send_phone_code');
        if( isset($has_send_phone_code['expire']) && $has_send_phone_code['expire'] > time() ) {
            $this->error('短信发送过于频繁');
        }

        $code_type = I('code_type');
        $phone = I('phone');

        if( !is_phone($phone) ) {
            $this->error('手机号码不正确');
        }

        //如果是注册类型先检测手机号码是否还能注册
        if( $code_type == 'reg' ) {
            if( !$this->check_phone($phone, $tip) ) {
                $this->error($tip);
            }
        }

        $code = rand(1000,9999);
        $content = "您的验证码为" . $code;
        //发送短信
        $error_msg = '';
        $smsModel = new SmsModel();
        $has_send_sms = $smsModel->send($phone,$content,$error_msg);
        //$has_send_sms = Sms2Model::send($phone,$content,$error_msg);
        if( $has_send_sms ) {
            PhonecodeModel::set_phone_code($code_type, $phone, $code);
            session('has_send_phone_code',array('has'=>'yes','expire'=>time() + 10));
            $this->success('验证码发送成功');
        } else {
            $this->error($error_msg);
        }
    }

    /**
     * 推广记录
     */
    public function share()
    {
        $member_id = I('get.smid');
        if( empty($member_id) ) {
            $member_id = $this->get_member_id();
        }
        if( is_wechat() ) {
            $config = C('WEIXINPAY_CONFIG');
            $jssdk = new Jssdk($config['APPID'], $config['APPSECRET']);
            # 生成分享签名等数据
            $signPackage = $jssdk->GetSignPackage();
            $this->assign('signPackage', $signPackage);

            //share_info
            $nickname = M('member')->where(array('id'=>$member_id))->getField('nickname');
            $share_link = U('Public/reg',array("smid"=>$member_id),'',true);
            $share_title = '帮帮-遇见最好的自己';
            $share_desc = "让科技实现价值 让共享创造财富。我是帮帮推广合伙人{$nickname} 加入我们开启财富之旅";
            $share_logo = "http://".$_SERVER['HTTP_HOST']."/Upload/qrcode/share_{$member_id}.png";
            $this->assign('share_link', $share_link);
            $this->assign('share_title', $share_title);
            $this->assign('share_desc', $share_desc);
            $this->assign('share_logo', $share_logo);

            $this->assign('is_wechat', 1);
        } else {
            $this->assign('is_wechat', 0);
        }
        $this->assign('member_client_info', session('member_client_info'));
        $this->display();
    }

    /**
     * 关注微信公众号
     */
    public function follow_weixin()
    {
        //退出登陆
        unset($_SESSION['member']);

        $this->display();
    }

    public function app()
    {
        $dev = new \Org\Net\Mobile();
        if( $dev->is('iOS') ) {
            $app_url = sp_cfg('app_ios');
        } else {
            $app_url = sp_cfg('app_android');
        }
        header("Location: $app_url");
        exit;
        //AndroidOS
        /*if( $dev->is('iOS') ) {
            $client_dev = 'ios';
        } else {
            $client_dev = 'android';
        }
        $this->assign('client_dev', $client_dev);*/

        //$this->display();
    }

    public function app_download()
    {
        $type = I('get.type');
        if( $type == 'ios' ) {
            $file = sp_cfg('app_ios');
        } else {
            $file = sp_cfg('app_android');
        }

        $data['type'] = $type;
        $data['member_id'] = $this->get_member_id();
        $data['ip'] = get_client_ip();
        $data['create_time'] = time();
        M('app_download')->add($data);

        header("Location: $file");
    }
}