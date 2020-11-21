<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/23
 * Time: 15:57
 */
class Wxsms
{
    //发送模板消息
    /*
     * uid:uid
     * to_user:admin store user
     * data_id : 处理的id
     * $types ： 模板id
     */
    public function send_tmplate($uid,$data_id,$types)
    {
        global $_W;
        $uniacid=$_W['uniacid'];
        //初始化返回值
        $data = array(
            'msg'=>'',
            'errono'=>0,
        );
        //查询关联公众号及信息
        $uniacid_arr = pdo_get('monai_seckill_wechattem_set',['uniacid'=>$uniacid]);
        $wx_info = pdo_get('account_wechats',['uniacid'=>$uniacid_arr['wechat_id']]);
        if(empty($wx_info['uniacid']))
        {
            $data['msg'] = '公众号配置错误';
            return $data;
        }
        //获取要发送的模板内容
        $tel_arr = include_once IA_ROOT . '/addons/'.MODEL_NAME.'/config/wechattem.php';
        
        $tempids = @pdo_get('monai_seckill_wechattem_conf', array('uniacid'=>$uniacid,'template_type'=>$types));
        if(empty($tempids['is_open']))
        {
            $data['errono'] = 1;
            return $data;
        }
        $content = json_decode($tempids['content'],1);
        foreach ($content as $k =>$v)
        {
            unset($content[$k]['title']);
            unset($content[$k]['is_kexie']);
            if(!empty($v['key']))
            {
                $val_arr = [];
                $db_arr = explode("*", $v['key']);
                $val_arr = @pdo_get($db_arr[0], array('uniacid'=>$uniacid,$db_arr[1]=>$data_id));
                $content[$k]['value'] = empty($val_arr[$content[$k]['value']])?'无':$val_arr[$content[$k]['value']];
                unset($content[$k]['key']);
            }
            if($v['value']=='time')
            {
                $content[$k]['value'] = date('Y-m-d H:i:s',time());
            }
            if($v['value']=='date')
            {
                $content[$k]['value'] = date('Y-m-d',time());
            }
        }
        //获取acctoken
        $access_token = $this->getWechatAccessToken($wx_info['uniacid']);
        
        //获取接受者的openid
        $user_info = @pdo_get('monai_seckill_member', array('uniacid'=>$uniacid,'uid'=>$uid));
        $openid = $user_info['wxopenid'];
        
        if(empty($openid))
        {
            $data['msg'] = '用户未关联公众号';
            return $data;
        }
        //发送
        $url = '';
        $miniprogram['appid'] = $_W['account']['key'];
        $miniprogram['pagepath'] = 'pages/mine/mine';
        $result = $this->sendTplNotice($openid, $tempids['template_id'], $content, $url,'#FF683F',$access_token,$miniprogram);
        $data['errono'] = 1;
        return $data;
    }
    public function sendTplNotice($touser, $template_id, $postdata, $url = '', $topcolor = '#FF683F', $token, $miniprogram) {
    
        $data = array();
        $data['touser'] = $touser;
        $data['template_id'] = trim($template_id);
        $data['url'] = trim($url);
        $data['miniprogram'] = $miniprogram;
        $data['topcolor'] = trim($topcolor);
        $data['data'] = $postdata;
        $data = json_encode($data);
        $post_url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$token}";
        $response = ihttp_request($post_url, $data);
        if(is_error($response)) {
            return error(-1, "访问公众平台接口失败, 错误: {$response['message']}");
        }
        $result = @json_decode($response['content'], true);
        dump($result);exit;
        if(empty($result)) {
            return error(-1, "接口调用失败, 元数据: {$response['meta']}");
        } elseif(!empty($result['errcode'])) {
            return error(-1, "访问微信接口错误, 错误代码: {$result['errcode']}, 错误信息: {$result['errmsg']},信息详情：{$this->errorCode($result['errcode'])}");
        }
        return true;
    }
    public function getWechatAccessToken($wechat_id)
    {
        $this->account = account_fetch($wechat_id);
        $cachekey = "accesstoken:{$wechat_id}";
        $cache = cache_load($cachekey);
        if (!empty($cache) && !empty($cache['token']) && $cache['expire'] > TIMESTAMP) {
            $this->account['access_token'] = $cache;
            return $cache['token'];
        }
        if (empty($this->account['key']) || empty($this->account['secret'])) {
            return error('-1', '未填写公众号的 appid 或 appsecret！');
        }
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->account['key']}&secret={$this->account['secret']}";
        $content = ihttp_get($url);
        if(is_error($content)) {
            return error('-1', '获取微信公众号授权失败, 请稍后重试！错误详情: ' . $content['message']);
        }
        if (empty($content['content'])) {
            return error('-1', 'AccessToken获取失败，请检查appid和appsecret的值是否与微信公众平台一致！');
        }
        $token = @json_decode($content['content'], true);
        if(empty($token) || !is_array($token) || empty($token['access_token']) || empty($token['expires_in'])) {
            $errorinfo = substr($content['meta'], strpos($content['meta'], '{'));
            $errorinfo = @json_decode($errorinfo, true);
            return error('-1', '获取微信公众号授权失败, 请稍后重试！ 公众平台返回原始数据为: 错误代码-' . $errorinfo['errcode'] . '，错误信息-' . $errorinfo['errmsg']);
        }
        $record = array();
        $record['token'] = $token['access_token'];
        $record['expire'] = TIMESTAMP + $token['expires_in'] - 200;
        cache_write($cachekey, $record);
        return $record['token'];
    }
    public function errorCode($code, $errmsg = '未知错误') {
        $errors = array(
            '-1' => '系统繁忙',
            '0' => '请求成功',
            '40001' => '获取access_token时AppSecret错误，或者access_token无效',
            '40002' => '不合法的凭证类型',
            '40003' => '不合法的OpenID',
            '40004' => '不合法的媒体文件类型',
            '40005' => '不合法的文件类型',
            '40006' => '不合法的文件大小',
            '40007' => '不合法的媒体文件id',
            '40008' => '不合法的消息类型',
            '40009' => '不合法的图片文件大小',
            '40010' => '不合法的语音文件大小',
            '40011' => '不合法的视频文件大小',
            '40012' => '不合法的缩略图文件大小',
            '40013' => '不合法的APPID',
            '40014' => '不合法的access_token',
            '40015' => '不合法的菜单类型',
            '40016' => '不合法的按钮个数',
            '40017' => '不合法的按钮个数',
            '40018' => '不合法的按钮名字长度',
            '40019' => '不合法的按钮KEY长度',
            '40020' => '不合法的按钮URL长度',
            '40021' => '不合法的菜单版本号',
            '40022' => '不合法的子菜单级数',
            '40023' => '不合法的子菜单按钮个数',
            '40024' => '不合法的子菜单按钮类型',
            '40025' => '不合法的子菜单按钮名字长度',
            '40026' => '不合法的子菜单按钮KEY长度',
            '40027' => '不合法的子菜单按钮URL长度',
            '40028' => '不合法的自定义菜单使用用户',
            '40029' => '不合法的oauth_code',
            '40030' => '不合法的refresh_token',
            '40031' => '不合法的openid列表',
            '40032' => '不合法的openid列表长度',
            '40033' => '不合法的请求字符，不能包含\uxxxx格式的字符',
            '40035' => '不合法的参数',
            '40038' => '不合法的请求格式',
            '40039' => '不合法的URL长度',
            '40050' => '不合法的分组id',
            '40051' => '分组名字不合法',
            '40155' => '请勿添加其他公众号的主页链接',
            '41001' => '缺少access_token参数',
            '41002' => '缺少appid参数',
            '41003' => '缺少refresh_token参数',
            '41004' => '缺少secret参数',
            '41005' => '缺少多媒体文件数据',
            '41006' => '缺少media_id参数',
            '41007' => '缺少子菜单数据',
            '41008' => '缺少oauth code',
            '41009' => '缺少openid',
            '42001' => 'access_token超时',
            '42002' => 'refresh_token超时',
            '42003' => 'oauth_code超时',
            '43001' => '需要GET请求',
            '43002' => '需要POST请求',
            '43003' => '需要HTTPS请求',
            '43004' => '需要接收者关注',
            '43005' => '需要好友关系',
            '44001' => '多媒体文件为空',
            '44002' => 'POST的数据包为空',
            '44003' => '图文消息内容为空',
            '44004' => '文本消息内容为空',
            '45001' => '多媒体文件大小超过限制',
            '45002' => '消息内容超过限制',
            '45003' => '标题字段超过限制',
            '45004' => '描述字段超过限制',
            '45005' => '链接字段超过限制',
            '45006' => '图片链接字段超过限制',
            '45007' => '语音播放时间超过限制',
            '45008' => '图文消息超过限制',
            '45009' => '接口调用超过限制',
            '45010' => '创建菜单个数超过限制',
            '45015' => '回复时间超过限制',
            '45016' => '系统分组，不允许修改',
            '45017' => '分组名字过长',
            '45018' => '分组数量超过上限',
            '45056' => '创建的标签数过多，请注意不能超过100个',
            '45057' => '该标签下粉丝数超过10w，不允许直接删除',
            '45058' => '不能修改0/1/2这三个系统默认保留的标签',
            '45059' => '有粉丝身上的标签数已经超过限制',
            '45065' => '24小时内不可给该组人群发该素材',
            '45157' => '标签名非法，请注意不能和其他标签重名',
            '45158' => '标签名长度超过30个字节',
            '45159' => '非法的标签',
            '46001' => '不存在媒体数据',
            '46002' => '不存在的菜单版本',
            '46003' => '不存在的菜单数据',
            '46004' => '不存在的用户',
            '47001' => '解析JSON/XML内容错误',
            '48001' => 'api功能未授权',
            '48003' => '请在微信平台开启群发功能',
            '50001' => '用户未授权该api',
            '40070' => '基本信息baseinfo中填写的库存信息SKU不合法。',
            '41011' => '必填字段不完整或不合法，参考相应接口。',
            '40056' => '无效code，请确认code长度在20个字符以内，且处于非异常状态（转赠、删除）。',
            '43009' => '无自定义SN权限，请参考开发者必读中的流程开通权限。',
            '43010' => '无储值权限,请参考开发者必读中的流程开通权限。',
            '43011' => '无积分权限,请参考开发者必读中的流程开通权限。',
            '40078' => '无效卡券，未通过审核，已被置为失效。',
            '40079' => '基本信息base_info中填写的date_info不合法或核销卡券未到生效时间。',
            '45021' => '文本字段超过长度限制，请参考相应字段说明。',
            '40080' => '卡券扩展信息cardext不合法。',
            '40097' => '基本信息base_info中填写的参数不合法。',
            '49004' => '签名错误。',
            '43012' => '无自定义cell跳转外链权限，请参考开发者必读中的申请流程开通权限。',
            '40099' => '该code已被核销。',
            '61005' => '缺少接入平台关键数据，等待微信开放平台推送数据，请十分钟后再试或是检查“授权事件接收URL”是否写错（index.php?c=account&amp;a=auth&amp;do=ticket地址中的&amp;符号容易被替换成&amp;amp;）',
            '61023' => '请重新授权接入该公众号',
        );
        $code = strval($code);
        if($code == '40001' || $code == '42001') {
            $cachekey = "accesstoken:{$this->account['acid']}";
            cache_delete($cachekey);
            return '微信公众平台授权异常, 系统已修复这个错误, 请刷新页面重试.';
        }
        if($errors[$code]) {
            return $errors[$code];
        } else {
            return $errmsg;
        }
    }
}