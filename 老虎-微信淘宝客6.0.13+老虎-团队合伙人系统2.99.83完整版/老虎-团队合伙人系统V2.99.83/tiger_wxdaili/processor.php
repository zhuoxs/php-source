<?php
/**
 * 微信淘宝客群代理
 *
 * @author 说图谱源码源码社区
 * @url www.shuotupu.com
 */
defined('IN_IA') or exit('Access Denied');

class Tiger_wxdailiModuleProcessor extends WeModuleProcessor {
	public function respond() {
        global $_W;
        $cfg = $this->module['config']; 
        $openid=$this->message['from']; 
		$key = $this->message['content'];
        load()->model('mc');
        $fans = mc_fetch($this->message['from']);
        if (empty($fans['nickname']) || empty($fans['avatar'])){
                $ACCESS_TOKEN = $this->getAccessToken();
                $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$ACCESS_TOKEN}&openid={$openid}&lang=zh_CN";
                load()->func('communication');
                $json = ihttp_get($url);
                $userInfo = @json_decode($json['content'], true);
                $fans['nickname'] = $userInfo['nickname'];
                $fans['avatar'] = $userInfo['headimgurl'];
                $fans['province'] = $userInfo['province'];
                $fans['city'] = $userInfo['city'];
                $fans['sex']=$userInfo['sex'];
		}

		//这里定义此模块进行消息处理时的具体过程, 请查看微擎文档来编写你的代码
        $list = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_qun") . " WHERE weid = '{$_W['uniacid']}' and keyw ='{$key}' order by id desc");
        if(empty($list)){
          $this->postText($this->message['from'],'管理员未添加对应的群!请联系管理员');
        }
        foreach($list as $k=>$v){
           $msum = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_qunmember')." where weid='{$_W['uniacid']}' and qunid='{$v['id']}'");
           if($v['xzrs']>$msum){//如果当前群数据小于上线人数就加人
               if(empty($v)){
                       $this->postText($this->message['from'],'管理员未添加对应的群!请联系管理员');
                    }else{
                       $member=pdo_fetch("SELECT * FROM " . tablename($this->modulename."_qunmember") . " WHERE weid = '{$_W['uniacid']}' and openid='{$openid}'");
                       if(empty($member)){//没有加入，插入数据
                          $data=array(
                              'weid'=>$_W['uniacid'],
                              'quntitle'=>$v['title'],
                              'qunid'=>$v['id'],
                              'openid'=>$openid,
                              'nickname'=>$fans['nickname'],
                              'avatar'=>$fans['avatar'],
                              'province'=>$fans['province'],
                              'city'=>$fans['city'],
                              'sex'=>$fans['sex'],
                              'createtime'=>TIMESTAMP
                          );
                          pdo_insert($this->modulename."_qunmember", $data);
                            if(!empty($cfg['jlqmsg'])){
                              $this->postText($this->message['from'],$cfg['jlqmsg']);
                            }
                            if(!empty($list[0]['picurl'])){
                              $this->postimg($this->message['from'],$v['picurl']);   
                            }                          
                       }else{
                         $this->postText($this->message['from'],$cfg['jqmsg']);
                       }           
                    }
              break;
           }
        }


        
	}


     public function postText($openid, $text) {
		$post = '{"touser":"' . $openid . '","msgtype":"text","text":{"content":"' . $text . '"}}';
		$ret = $this->postRes($this->getAccessToken(), $post);
		return $ret;
	}

    private function postRes($access_token, $data) {
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
		load()->func('communication');
		$ret = ihttp_request($url, $data);
		$content = @json_decode($ret['content'], true);
		return $content['errcode'];
	}

    public function postimg($openid,$media_id){
       $message = array(
            'touser' => $openid,
            'msgtype' => 'image',
            'image' => array('media_id' =>$media_id) //微信素材media_id，微擎中微信上传组件可以得到此值
        );
        $account_api = WeAccount::create();
        $status = $account_api->sendCustomNotice($message);
        return 1;
    }

    private function getAccessToken() {
		global $_W;
		load()->model('account');
		$acid = $_W['acid'];
		if (empty($acid)) {
			$acid = $_W['uniacid'];
		}
		$account = WeAccount::create($acid);
		//$token = $account->fetch_available_token();
        $token = $account->getAccessToken();
		return $token;
	}
}