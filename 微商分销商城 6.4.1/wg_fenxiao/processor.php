<?php
/**
 * @author
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Wg_fenxiaoModuleProcessor extends WeModuleProcessor {
    protected $acc; //account
    public function respond() {

        global $_W;
        load()->model('mc');
        load()->func('communication');
        $this->acc = WeAccount::create(); //获取account
        $msgtype = strtolower($this->message['msgtype']);
        $event = strtolower($this->message['event']);
        if ($msgtype == 'text' || $event == 'click') {
            $content = $this->message['content'];
            if ($content == '分销专属二维码'|| $content =='重新生成二维码') {
                //01、准备poster
                $sql = "SELECT * FROM " . tablename('wg_fenxiao_poster') . " WHERE `isdefault`=:isdefault AND `weid`=:weid ORDER BY `id` DESC LIMIT 1";
                $poster = pdo_fetch($sql, array(
                    ':isdefault' => 1,
                    ':weid'      => $_W['uniacid']
                ));
                if (empty($poster)) {
                    return $this->respText('商家还未配置分销二维码');
                } else {
                    //02.准备member数据
                    $sql = "SELECT * FROM " . tablename('wg_fenxiao_member') . " where openid=:openid AND weid=:weid";
                    $member = pdo_fetch($sql, array(
                        ':openid' => $this->message['from'],
                        ':weid'   => $_W['uniacid']
                    ));
                    if (empty($member)) { //检查自己是否是会员
                        return $this->respText('请先浏览一下商城，自动注册为默认会员后，再生成二维码');
                    }
                    if ($poster['isopen'] == 0 && $member['isagent'] == 0) { //如果不是正式分销商
                        $notext = !empty($poster['notext']) ? $poster['notext'] : '您还不是分销商，不能生成自己的专属二维码';
                        
                        return $this->respText($notext);
                    }
                    //03.准备带参数二维码信息
                    $qr = pdo_fetch('select * from ' . tablename('wg_fenxiao_poster_qr') . ' where openid=:openid and weid=:weid limit 1', [
                        ':openid' => $this->message['from'],
                        ':weid'   => $_W['uniacid']
                    ]);
                    if (empty($qr)) {
                        $barcode['action_info']['scene']['scene_str'] = $this->message['from'];
                        $barcode['action_name'] = 'QR_LIMIT_STR_SCENE';
                        $result = $this->acc->barCodeCreateFixed($barcode); //调用微信生成二维码
                        $qrimg = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $result['ticket'];
                        $qr = array(
                            'weid'   => $_W['uniacid'],
                            'openid' => $this->message['from'],
                            'ticket' => $result['ticket'],
                            'qrimg'  => $qrimg,
                            'url'    => $result['url']
                        );
                        pdo_insert('wg_fenxiao_poster_qr', $qr);
                        $qr['id'] = pdo_insertid();
                    }
                    //04.最主要的生成二维码的主程序
                    $img = $this->createPoster($poster, $member, $qr,$content);
                    $mediaid = $img['mediaid'];
                    
                    return $this->respImage($mediaid);
                }
            }else {
                $rid = $this->rule;
                $sql = "SELECT * FROM " . tablename('wg_fenxiao_news_reply') . " WHERE rid = :id AND parent_id = -1 ORDER BY displayorder DESC, id ASC LIMIT 8";
                $commends = pdo_fetchall($sql, array(':id' => $rid));
                if (empty($commends)) {
                    $sql = "SELECT * FROM " . tablename('wg_fenxiao_news_reply') . " WHERE rid = :id AND parent_id = 0 ORDER BY RAND()";
                    $main = pdo_fetch($sql, array(':id' => $rid));
                    if(empty($main['id'])) {
                        return false;
                    }
                    $sql = "SELECT * FROM " . tablename('wg_fenxiao_news_reply') . " WHERE id = :id OR parent_id = :parent_id ORDER BY parent_id ASC, displayorder DESC, id ASC LIMIT 8";
                    $commends = pdo_fetchall($sql, array(':id'=>$main['id'], ':parent_id'=>$main['id']));
                }
                if(empty($commends)) {
                    return false;
                }
                $news = array();
                foreach($commends as $c) {
                    $row = array();
                    $row['title'] = $c['title'];
                    $row['description'] = $c['description'];
                    !empty($c['thumb']) && $row['picurl'] = tomedia($c['thumb']);
                    $row['url'] = empty($c['url']) ? $this->createMobileUrl('wenzhang', array('id' => $c['id'],'myopenid'=>$this->message['from'])) : $c['url'];
                    $news[] = $row;
                }
                return $this->respNews($news);
            }
        } elseif ($msgtype == 'event') { //如果是关注事件
            if ($event == 'subscribe') {
                $openid   = $this->message['from'];
                $eventkey = $this->message['eventkey'];
                if (empty($eventkey)) { //普通关注，没有推荐人的情况
                    $noguanzhu = !empty($this->module['config']['noguanzhu']) ? $this->module['config']['noguanzhu'] : '欢迎关注';
                    return $this->respText($noguanzhu);
                } else {
                    $fatherData = $this->getFatherData($eventkey, $_W['uniacid']); //获取二维码里面的父信息
                    $isMember   = $this->checkHaveMember($openid, $_W['uniacid']); //检查自己是否是正式会员
                    $guanzhuhuifu = !empty($this->module['config']['guanzhuhuifu']) ? $this->module['config']['guanzhuhuifu'] : '欢迎关注';
                    if ($isMember == false) {
                        $isMember  = $this->registerMember($openid, $_W['uniacid'], $fatherData['id']);
                        $member_id = $isMember['id'];
                        $guanzhuhuifu = str_replace('{fathername}', $fatherData['nickname'], $guanzhuhuifu);
                        $guanzhuhuifu = str_replace('{member_id}', $member_id, $guanzhuhuifu);
                        //发送模板消息给上三级
                        if (!empty($this->module['config']['xinzengguanzhu'])) {
                            $this->sendXinZengGuanZhuTongZhi($fatherData['id'],$this->module['config']['xinzengguanzhu'],$isMember['nickname']);
                        }
                        //增加积分
                        if(!empty($this->module['config']['zengjiajifen'])){
                           $this->addJifen($fatherData['id'],$this->module['config']['zengjiajifen'],'扫描推广'.$isMember['nickname'].'增加积分'.$this->module['config']['zengjiajifen'], $isMember['weid']);
                        }
                        
                    } else {
                        $guanzhuhuifu = '欢迎回来，这里依然精彩';
                    }
                    
                    return $this->respText($guanzhuhuifu);
                }
            }
        }
    }
   /**
     * [addJifen 增加积分的方法]
     * @param [type] $member_id [description]
     * @param [type] $jifen     [description]
     */
    protected function addJifen($member_id, $jifen, $shuoming, $weid) {
        $jifen = $jifen + 0;
        $sql = "UPDATE " . tablename('wg_fenxiao_member') . " SET `jifen`=jifen+:jifen WHERE id=:member_id";
        $res = pdo_query($sql, array(
            ':member_id' => $member_id,
            ':jifen'     => $jifen
        ));
        if ($res) {
            $this->addJifenMingXi($member_id, $jifen, $shuoming);//写入明细
            //如果是agent，增加分销商等级
            $isagent = $this->getIsAgent($member_id);
            //如果是分销商，检查等级
            if($isagent['isagent'] == 1){
                $this->editAgentLevel($isagent['jifen'],$member_id,$isagent['agentlevel'],$weid);
            }
        }
    }

    /**
     * 用户等级编辑
     * @param $jifen
     * @param $member_id
     * @param $cur_level
     * @param $weid
     */
    protected function editAgentLevel($jifen,$member_id,$cur_level,$weid){
        $sql = "SELECT jifen,level FROM " . tablename('wg_fenxiao_member_level'). " WHERE jifen<=:jifen AND weid=:weid ORDER BY level DESC LIMIT 1";

        $agentLevl = pdo_fetch($sql, array(
            ':jifen' => $jifen,
            ':weid'  => $weid + 0
        ));
        if(!empty($agentLevl)){
            if ($cur_level != $agentLevl['level']) {
                //升级有升级奖
                if ($agentLevl['level'] > $cur_level) {
                    $data['level_jiang'] = $agentLevl['level'];
                }
                $data['agentlevel'] = $agentLevl['level'];
                pdo_update('wg_fenxiao_member', $data, array(
                    'id' => $member_id
                ));
            }
        }
    }
      /**
     * [getIsAgent description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    protected function getIsAgent($id){
        $sql = "SELECT isagent,jifen,agentlevel FROM " . tablename('wg_fenxiao_member') . " WHERE `id`=:id";
        $data = pdo_fetch($sql, array(
            ':id' => $id
        ));
        
        return $data;
    }

    protected function addJifenMingXi($memberid,$jifen,$shuoming){
        $data = array(
            'memberid'   => $memberid+0,
            'jifen'      => $jifen+0,
            'shuoming'   => $shuoming,
            'createtime' => time()
        );
        pdo_insert('wg_fenxiao_jifen_mingxi',$data);
    }
    /**
     * [sendXinZengGuanZhuTongZhi description]
     * @param  [type] $parent_id  [description]
     * @param  [type] $templateid [description]
     * @param  [type] $nickname   [description]
     * @return [type]             [description]
     */
    protected function sendXinZengGuanZhuTongZhi($parent_id,$templateid,$nickname){
        $parents = $this->getParents($parent_id);
        foreach ($parents as $key => $value) {
				if($key == 1){
				$name = '虎将';
			}	
			if($key == 2){
				$name = '大将';
			}	
			if($key == 3){
				$name = '福将';
			}
            $data = array (
                'first' => array('value' => '恭喜您增加一员'.$name.':'.$nickname,'color'=>'#173177'),
                'keyword1' => array('value' => $nickname,'color'=>'#173177'),
                'keyword2' => array('value' => date('Y-m-d H:i',strtotime('now')),'color'=>'#173177'),
                'remark' => array(
                    'value' => '系统推荐人：'.$parents[1]['nickname'],
                    'color' => '#173177'
                )
            );
            $this->acc->sendTplNotice($value['openid'],$templateid,$data);
        }
       
    }
    /**
     * [getParents 获取三级父亲信息数组]
     * @param  [type] $parent_id [description]
     * @return [type]            [description]
     */
    protected function getParents($parent_id){
        $arr = array();
        $parent1 = $this->getParentInfo($parent_id);
        if(!empty($parent1)){
            $arr[1] = $parent1;
            $parent2 = $this->getParentInfo($parent1['parent_id']);
            if(!empty($parent2)){
                $arr[2] = $parent2;
                $parent3 = $this->getParentInfo($parent2['parent_id']);
                if(!empty($parent3)){
                    $arr[3] = $parent3;
                }
            }
        }
        return $arr;
         

    }
    /**
     * [getParentInfo 获取父亲的id，openid,parent_id]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    protected function getParentInfo($id){
        $sql = "SELECT id,openid,nickname,parent_id FROM " . tablename('wg_fenxiao_member') . " WHERE `id`=:id";
        $data = pdo_fetch($sql,array(':id'=>$id));
        return $data;
    }

    /**
     * @param $eventkey
     * @param $weid
     * @return mixed
     */
    protected function getFatherData($eventkey, $weid) {
        $openid = str_replace('qrscene_', '', $eventkey); //去掉前缀，形成openid
        $sql    = "SELECT id,nickname FROM " . tablename('wg_fenxiao_member') . " WHERE `openid`=:openid AND `weid`=:weid ORDER BY `id` LIMIT 1";
        $data   = pdo_fetch($sql, [
            ':openid' => $openid,
            ':weid'   => $weid
        ]);
        return $data;
    }

    /**
     * @param $openid
     * @param $weid
     * @param int $father
     * @return array
     */
    protected function registerMember($openid, $weid, $father = 0) {
        $userinfo = $this->acc->fansQueryInfo($openid);
        //插入member数据
        $data = [
            'weid'      => $weid,
            'openid'    => $openid,
            'nickname'  => $userinfo['nickname'],
            'avatar'    => $userinfo['headimgurl'],
            'follow'    => $userinfo['subscribe'],
            'parent_id' => $father
        ];
        pdo_insert('wg_fenxiao_member', $data);
        $data['id'] = pdo_insertid();
        
        return $data;
    }
    /**
     * [checkHaveMember 检查是否注册了会员]
     * @param  [type] $openid [description]
     * @param  [type] $weid   [description]
     * @return [type]         [description]
     */
    protected function checkHaveMember($openid, $weid) {
        //1.检查是否注册了会员
        $sql = "SELECT id,nickname FROM " . tablename('wg_fenxiao_member') . " where openid=:openid AND weid=:weid ORDER BY `id` ASC LIMIT 1";
        $member = pdo_fetch($sql, array(
            ':openid' => $openid,
            ':weid' => $weid
        ));
        
        return $member;
    }
    protected function createPoster($poster, $member, $qr, $content,$upload = true) {
        global $_W;
        load()->func('communication');
        load()->func('file');
        $path = IA_ROOT . "/addons/wg_fenxiao/data/poster/" . $_W['uniacid'] . "/".substr($this->message['from'], 0,2) ."/";
        if (!is_dir($path)) {
            load()->func('file');
            mkdirs($path);
        }
        $file = 'qr-' . $this->message['from'] . '.jpg';
        //如果后来编辑了poster，需要删除图片
        if (($poster['createtime'] > $qr['createtime']) || !is_file($path . $file) || $content=='重新生成二维码') {
            file_delete($path . $file);
            $qr['createtime'] = 0;
            //生成二维码前的，等待文字
            if (!empty($poster['waittext'])) {
                $custom = array(
                    'msgtype' => 'text',
                    'text' => array(
                        'content' => urlencode($poster['waittext'])
                    ) ,
                    'touser' => $this->message['from'],
                );
                $this->acc->sendCustomNotice($custom);
            }
        }
        if (!is_file($path . $file)) {
            set_time_limit(0);
            @ini_set('memory_limit', '256M');
            $target = imagecreatetruecolor(640, 1008);
            $bg = $this->createImage(tomedia($poster['bg']));
            imagecopy($target, $bg, 0, 0, 0, 0, 640, 1008);
            imagedestroy($bg);
            $data = json_decode(str_replace('&quot;', "'", $poster['data']) , true);
            
            foreach ($data as $d) {
                $d = $this->getRealData($d);
                if ($d['type'] == 'head') {
                    $avatar = preg_replace('/\/0$/i', '/96', $member['avatar']);
                    $target = $this->mergeImage($target, $d, $avatar);
                } else if ($d['type'] == 'img') {
                    $target = $this->mergeImage($target, $d, $d['src']);
                } else if ($d['type'] == 'qr') {
                    $target = $this->mergeImage($target, $d, tomedia($qr['qrimg']));
                } else if ($d['type'] == 'nickname') {
                    $target = $this->mergeText($target, $d, '我是'.$member['nickname']);
                }
            }
            imagejpeg($target, $path . $file);
            imagedestroy($target);
        }
        $img = $_W['siteroot'] . "addons/wg_fenxiao/data/poster/" . $_W['uniacid'] . "/" .substr($this->message['from'], 0,2)."/". $file;
        if (!$upload) {
            return $img;
        }
        if (empty($qr['mediaid']) || empty($qr['createtime']) || $qr['createtime'] + 3600 * 24 * 3 - 7200 < time()) {
            $mediaid = $this->uploadImage($path . $file);
            $qr['mediaid'] = $mediaid;
            pdo_update('wg_fenxiao_poster_qr', array(
                'mediaid'    => $mediaid,
                'createtime' => time()
            ) , array(
                'id' => $qr['id']
            ));
        }
        
        return array(
            'img'     => $img,
            'mediaid' => $qr['mediaid']
        );
    }
    protected function createImage($imgurl) {
        load()->func('communication');
        $resp = ihttp_request($imgurl);
        
        return imagecreatefromstring($resp['content']);
    }
    protected function getRealData($data) {
        $data['left'] = intval(str_replace('px', '', $data['left'])) * 2;
        $data['top'] = intval(str_replace('px', '', $data['top'])) * 2;
        $data['width'] = intval(str_replace('px', '', $data['width'])) * 2;
        $data['height'] = intval(str_replace('px', '', $data['height'])) * 2;
        $data['size'] = intval(str_replace('px', '', $data['size'])) * 2;
        $data['src'] = tomedia($data['src']);
        
        return $data;
    }
    protected function mergeImage($target, $data, $imgurl) {
        $img = $this->createImage($imgurl);
        $w = imagesx($img);
        $h = imagesy($img);
        imagecopyresized($target, $img, $data['left'], $data['top'], 0, 0, $data['width'], $data['height'], $w, $h);
        imagedestroy($img);
        
        return $target;
    }
    protected function mergeText($target, $data, $text) {
        $font   = IA_ROOT . "/addons/wg_fenxiao/recouse/font/msyh.ttf";
        $colors = $this->hex2rgb($data['color']);
        $color  = imagecolorallocate($target, $colors['red'], $colors['green'], $colors['blue']);
        imagettftext($target, $data['size'], 0, $data['left'], $data['top'] + $data['size'], $color, $font, $text);
        return $target;
    }
    protected function hex2rgb($colour) {
        if ($colour[0] == '#') {
            $colour = substr($colour, 1);
        }
        if (strlen($colour) == 6) {
            list($r, $g, $b) = array(
                $colour[0] . $colour[1],
                $colour[2] . $colour[3],
                $colour[4] . $colour[5]
            );
        } elseif (strlen($colour) == 3) {
            list($r, $g, $b) = array(
                $colour[0] . $colour[0],
                $colour[1] . $colour[1],
                $colour[2] . $colour[2]
            );
        } else {
            
            return false;
        }
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        
        return array(
            'red' => $r,
            'green' => $g,
            'blue' => $b
        );
    }
    protected function uploadImage($img) {
        load()->func('communication');
        $access_token = $this->acc->fetch_token();
        $resp = ihttp_request("http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type=image", array(
            'media' => '@' . $img
        ));
        $content = @json_decode($resp['content'], true);
        
        return $content['media_id'];
    }
}
