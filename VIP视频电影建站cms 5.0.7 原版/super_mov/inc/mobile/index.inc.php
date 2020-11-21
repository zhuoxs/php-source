<?php
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$settings = $this->module['config'];
if ($settings['is_news'] < 1) {
    $title = $settings['site_title'];
    include $this->template('h5/index'); 
    exit();
}
if ($_GPC['mov'] == 'detail') {
    $op = $_GPC['op'];
    $id = $_GPC['id'];  
    $acc = WeAccount::create(); 
    $password = $_COOKIE['password'];       
    $info = $acc->fansQueryInfo($_W['openid']);      
    $settings = $this->module['config'];
    $setting = setting();
    $setting = $setting['member']; 
    $site_name = iunserializer($setting['setting']);
    if ($site_name) {
        $settings['logo'] = $site_name['logo'];
        $settings['subscribe_title'] = $site_name['subscribe_title'];
        $settings['index_gg'] = $site_name['index_gg'];
        $settings['copyright'] = $site_name['copyright'];
        $settings['guanzhu_ewm'] = $site_name['guanzhu_ewm'];  
    }
    if ($settings['is_pc'] == 2 && is_weixin()) {       
        $url = link_url('index'); 
        Header("Location: ".$url);
        exit();  
    }
    if (pdo_tableexists('cyl_video_pc_site') && !is_weixin()) {
        $openid = $_GPC['phone'];
        $member = member($openid,'is_weixin');
        if ($member['nickname']) {
            $openid = $member['openid'];
            $member = member($openid);
        }
    }elseif(pdo_tableexists('cyl_video_pc_site') && is_weixin() && $_W['oauth_account']['level'] < 4 ){
        $openid = $_GPC['phone'];
        $member = member($openid,'is_weixin');
        if ($member['nickname']) {
            $openid = $member['openid'];
            $member = member($openid);
        }
    }else{
        $openid = $_W['openid'];
        $member = member($openid);
    } 
    if (pdo_tableexists('cyl_video_pc_site') && $member['is_pay'] == 0 && !is_weixin() && !$openid) {
        $openid = $_W['clientip'];
    } 
    if (pdo_tableexists('cyl_video_pc_site') && $member['is_pay'] == 0 && is_weixin() && !$openid && $_W['oauth_account']['level'] < 4) {
        $openid = $_W['clientip'];
    }
    if (TIMESTAMP > $member['end_time'] && $member['is_pay'] == 1) {
        pdo_update('cyl_vip_video_member',array('end_time'=>null,'is_pay'=>0),array('openid'=>$member['openid']));
        $data = array(
                'first' => array(
                    'value' => '您好,'.$member['nickname'].'您的会员已到期',
                    'color' => '#ff510'
                ) ,
                'keyword1' => array(
                    'value' => '会员到期',
                    'color' => '#ff510'
                ) ,
                'keyword2' => array(
                    'value' => date('Y-m-d H:i:s',$member['end_time']),
                    'color' => '#ff510'
                ) ,                   
                'remark' => array(
                    'value' => '欢迎继续使用',
                    'color' => '#ff510'
                ) ,
            );
        $url = link_url('member');
        $acc->sendTplNotice($member['openid'], $settings['due_id'], $data, $url, $topcolor = '#FF683F');
    }        
    $ad = pdo_fetch("SELECT * FROM " . tablename('cyl_vip_video_ad') . " WHERE uniacid = :uniacid AND type = 'dumiao'  AND status = 0 ORDER BY rand() DESC LIMIT 1",array(':uniacid'=>$_W['uniacid']),'id');
    if (TIMESTAMP > $ad['end_time']) {
        pdo_update('cyl_vip_video_ad',array('status'=>1),array('id'=>$ad['id']));
    } 
    if (!pdo_tableexists('cyl_video_pc_site')) {
        if(!is_weixin()){ 
            message('暂时只支持微信,请使用微信观看视频');   
        } 
    }   
    if ($settings['is_pc'] == 1) {
        if(!is_weixin()){ 
            message('暂时只支持微信,请使用微信观看视频');  
        }  
    }    
    if ($site_name) { 
        $hdp = pdo_getall('cyl_vip_video_hdp', array('uniacid'=>$_W['uniacid'],'type'=>$_GPC['mov'],'site_name'=>$setting['site_name']), array() , '' , 'sort DESC , id DESC');
    }else{
        if (pdo_tableexists('cyl_agent_site_member')) {
            $hdp = pdo_getall('cyl_vip_video_hdp', array('uniacid'=>$_W['uniacid'],'type'=>$_GPC['mov'],'site_name'=>''), array() , '' , 'sort DESC , id DESC'); 
        }else{
            $hdp = pdo_getall('cyl_vip_video_hdp', array('uniacid'=>$_W['uniacid'],'type'=>$_GPC['mov']), array() , '' , 'sort DESC , id DESC'); 
        }
    }
    $category = pdo_fetchall("SELECT * FROM ".tablename('cyl_vip_video_category')." WHERE uniacid = :uniacid AND parentid = :parentid AND status = :status ORDER BY parentid ASC, displayorder ASC, id ASC ", array(':uniacid'=>$_W['uniacid'],':parentid'=>0,':status'=>0), 'id');
    $url = $_GPC['url'];
    $yurl = $_GPC['url'];
    if ($setting['card']) {
    	$setting_setting = iunserializer($setting['card']);
    	$settings['everyday_free_num'] = $setting_setting['everyday_free_num'];
    	$settings['free_num'] = $setting_setting['free_num'];
    	$settings['warn_font'] = $setting_setting['warn_font']; 
    }
    if ($settings['everyday_free_num'] == 1) {
        $num = pdo_fetchcolumn("SELECT COUNT(*),time FROM " . tablename('cyl_vip_video') . " WHERE uniacid = :uniacid AND openid = :openid AND time >= :firsttime AND time <= :lasttime ", array(':uniacid' => $_W['uniacid'],':openid' => $openid,':firsttime'=>strtotime(date('Y-m-d 00:00:00')),':lasttime'=>strtotime(date('Y-m-d 23:59:59'))));
    }else{
        $num = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('cyl_vip_video') . " WHERE uniacid = :uniacid AND openid = :openid ", array(':uniacid' => $_W['uniacid'],':openid' => $openid));
    }
    if ($num >= $settings['free_num'] && $member['is_pay'] == 0) {
        message($settings['warn_font'] ? $settings['warn_font'] : '您的免费观看次数已用完，请点击确定开通会员，无限制观看',link_url('member',array('op'=>'open')),'error'); 
    } 
    $jilu = pdo_fetchall("SELECT openid , yvideo_url FROM ".tablename('cyl_vip_video')." WHERE uniacid = :uniacid AND openid = :openid ORDER BY id DESC LIMIT 10", array(':uniacid'=>$_W['uniacid'],':openid'=>$openid));
    if ($_GPC['d_id']) {
        $video_id = $_GPC['url'] ? $_GPC['url'] : $_GPC['d_id'];
    }else{
        $video_id = $_GPC['url'] ? $_GPC['url'] : $id;
    }
    $comment = pdo_fetchall("SELECT * FROM ".tablename('cyl_vip_video_message')." WHERE uniacid = :uniacid AND video_id = :video_id AND status = 1 ORDER BY id DESC LIMIT 10", array(':uniacid'=>$_W['uniacid'],':video_id'=>$video_id)); 
    $shoucang = pdo_get('cyl_vip_video',array('uniacid' => $_W['uniacid'],'yvideo_url' => $_W['siteurl'],'openid' => $openid,'type' => 'shoucang'));  
    if ($id) {
        $content = pdo_fetch("SELECT * FROM ".tablename('cyl_vip_video_manage')." WHERE id=:id",array(':id'=>$id));
        if (checksubmit('submit')) {
            if ($_GPC['password'] == $content['password']) {
                setcookie("password",$_GPC['password'],time()+2*7*24*3600);
                $url = link_url('index',array('mov'=>'detail','id'=>$id));
                Header("Location: ".$url);
            }else{
                message('密码不正确，请重新输入','','error');
            }           
        }
        $click = $content['click']; 
        $juji = iunserializer($content['video_url']);
        if (count($juji) < 2) {
            $url = $juji['0']['link'];
            $url = tomedia($url);
        }else{
            $url = $_GPC['url'];
            if (!$url) {
                $url = $juji['0']['link'];
                $url = tomedia($url);
            }
        }
        $is_charge = pdo_get('cyl_vip_video_order',array('uniacid'=>$_W['uniacid'],'video_id'=>$id));
        $is_vip = is_vip($id,'id');
        pdo_update('cyl_vip_video_manage', array('click +=' => 1), array('id' => $id));                 
    }elseif ($op == 'yule' || $op == 'gaoxiao') {
        $url = kan360($url);        
        $content['title'] = $url['title'];      
        $content['thumb'] = $url['thumb'];      
        $url = $url['mp4'];
        // $tuijian = pc_caiji_detail_tuijian($url);
    }else{  
        if ($settings['ziyuan'] == 1 || $settings['ziyuan'] == 3 ) { 
            $site = array(); 
            $vip_url = $_W['siteurl'];     
            $is_vip = is_vip($vip_url,'url');
            $url_time = cache_load('pc_caiji_detail:'.$_GPC['d_id']); 
            if ((TIMESTAMP - $url_time) > 3600 ) {
                $url = m3u8();
                $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
                $url = $url . "?ziyuan=".$settings['ziyuan']."&ip=".$ip."&id=".$_GPC['d_id'];
                $response = ihttp_get($url); 
                $content = json_decode($response['content'],true); 
                $tuijian = $content['tuijian'];  
                cache_write('pc_caiji_detail:'.$_GPC['d_id'], TIMESTAMP);                                 
                cache_write('content:'.$_GPC['d_id'], $content);  
                cache_write('tuijian:'.$_GPC['d_id'], $tuijian);  
            }else{
                $content = cache_load('content:'.$_GPC['d_id']);
                $tuijian = cache_load('tuijian:'.$_GPC['d_id']); 
            }       
            $content['title'] = $content['vod_name'];
            $content['star'] = $content['vod_score'];
            $content['year'] = $content['vod_year'];
            $content['area'] = $content['vod_area'];
            $content['actor'] = $content['vod_actor'];
            $content['desc'] = $content['vod_content'];
            $content['thumb'] = $content['vod_pic'];            
            if (strexists($content['thumb'], 'tu')) {
                $content['thumb'] = MODULE_URL . $content['thumb'];   
                $content['thumb'] = trim($content['thumb']);                  
            }         
            $play_list = $content['vod_play_list'];
            $site_list = array();
            foreach ($play_list as $key => $value) {
                $site_list[] = $value['sid'];
            }
            if ($_GPC['site']) {
                current($site_list);
                $site_title = $play_list[$_GPC['site']]['player_info']['des'];
            }else{
                $site_title = current($play_list);
                
                $site_title = $site_title['player_info']['des'];
            }
            $playurl = $content['playurl'];
            $jishu = $_GPC['jishu'];
            
            if ($_GPC['site']) {
                $first_val = $play_list[$_GPC['site']];

            }else{
                $first_val = current($play_list);                
            } 
            if ($jishu) {
                $url = $first_val['urls'][$jishu]['url'];
            }else{
                $jishu = 1;
                $url = $first_val['urls'][$jishu]['url'];
            }
            $juji = $first_val['urls'];
            if ($first_val['urls']['1']['name'] == $first_val['url_count']) {
                $jishu_zidong = $jishu - 1;
            }else{
                $jishu_zidong = $jishu + 1;
            }           
            if (strexists($url,'27pan')) {
                 $url = pan27($url);
            }
            foreach ($tuijian as $key => &$value) {
                if (strexists($value['vod_pic'], 'tu.php')) {
                    $value['vod_pic'] = MODULE_URL . $value['vod_pic'];                    
                }                
            }
            if ($first_val['player_info']['des'] == '27') {
                $is_cdn = 'false';
            }   
            isetcookie ('shangci', $_W['siteurl']);
            isetcookie ('shangci_title', $content['title']);
            isetcookie ('shangci_jishu', $_GPC['jishu']);   
            $click = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cyl_vip_video') . " WHERE uniacid = :uniacid AND video_id = :video_id ",array(':uniacid'=>$_W['uniacid'],':video_id'=>$_GPC['d_id']));            
        }elseif ($settings['ziyuan'] == 2) { 
            $cate = mac_category();             
            $site = array(); 
            $vip_url = $_W['siteurl'];     
            $is_vip = is_vip($vip_url,'url');            
            $content = mac_detail($_GPC['d_id']); 
            $tuijian = $content['tuijian'];                       
            $play_list = $content['play_list'];
            $link = $content['site']; 
            $url = $link['0'];
            if ($_GPC['site']) {
                $site_title = $_GPC['site'];
            }else{
                $site_title = $link['0'];
            }                          
            $playurl = $content['playurl'];
            $jishu = $_GPC['jishu'];
            if ($_GPC['site']) {
                $first_val = $play_list[$_GPC['site']];
            }else{
                $first_val = $play_list[$link['0']];
            } 
            if ($jishu) {
                $url = $first_val['urls'][$jishu]['url'];
            }else{
                $jishu = 1;
                $url = $first_val['urls'][$jishu]['url'];
            }
            $juji = $first_val['urls'];
            if ($first_val['urls']['1']['name'] == $first_val['url_count']) {
                $jishu_zidong = $jishu - 1;
            }else{
                $jishu_zidong = $jishu + 1;
            }   
             
            isetcookie ('shangci', $_W['siteurl']);
            isetcookie ('shangci_title', $content['title']);
            isetcookie ('shangci_jishu', $_GPC['jishu']);   
           $click = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cyl_vip_video') . " WHERE uniacid = :uniacid AND video_id = :video_id ",array(':uniacid'=>$_W['uniacid'],':video_id'=>$_GPC['d_id']));               
        }else{ 
            $url_time = cache_load('pc_caiji_detail:'.$url);        
            if ((TIMESTAMP - $url_time) > 86400 ) {
                $content = pc_caiji_detail($url,$op);
                $tuijian = pc_caiji_detail_tuijian($url);       
                $daoyan = pc_caiji_detail_daoyan($url); 
                cache_write('pc_caiji_detail:'.$url, TIMESTAMP);                
                cache_write('content:'.$url, $content);  
                cache_write('tuijian:'.$url, $tuijian);  
                cache_write('daoyan:'.$url, $daoyan); 
            }else{
                $content = cache_load('content:'.$url); 
                $tuijian = cache_load('tuijian:'.$url); 
                $daoyan = cache_load('daoyan:'.$url);               
            }       
            $site = site(); 
            $content = $content['0'];   
            $vip_url = $_W['siteurl'];     
            $is_vip = is_vip($vip_url,'url');
            if ($op == 'dianying') {                 
                if ((TIMESTAMP - $url_time) > 86400 ) {
                    $link = caiji_url($url);
                    cache_write('caiji_url:'.$url, $link);
                }else{
                    $link = cache_load('caiji_url:'.$url);
                }           
                if ($_GPC['link']) {
                    $url = $_GPC['link'];
                }else{
                    if (strpos($link['0']['link'], 'qq') && count($link) > 1 && !$settings['tengxun']) {
                        $url = $link['1']['link'];
                        $site_title = $link['1']['title'];
                    }else{
                        $url = $link['0']['link'];
                    }               
                }               
            }
            if ($op == 'dianshi') {             
                $link = dianshi_url($url);
                if ($_GPC['site']) {
                    $site = array_keys($site,$_GPC['site']);  
                }else{
                    if (count($link) > 1) {
                        if (strexists($link['0'], '腾讯') || strexists($link['0'], '华数TV') && !$settings['tengxun']) {
                          $site_title = $link['1'];
                        }elseif (strexists($site_title, '腾讯') || strexists($site_title, '华数TV') ) { 
                          $site_title = $link['2'];
                        }else{
                          $site_title = $link['0'];
                        }            
                    }else{
                        $site_title = $link['0'];
                    }
                    $site = array_keys($site,str_replace('(付费)','',$site_title));
                }      
                $juji = juji_url($_GPC['url'],$site);      
                if ($_GPC['link']) {
                  $url = $_GPC['link'];
                }else{        
                  $url = $juji['0']['link'];         
                } 
            }             
            if ($op == 'dongman') {
                $link = dianshi_url($url);
                if ($_GPC['site']) {
                    $site = array_keys($site,$_GPC['site']);  
                }else{
                    if (count($link) > 1) {
                        if (strexists($link['0'], '腾讯') || strexists($link['0'], '华数TV') && !$settings['tengxun']) {
                          $site_title = $link['1'];
                        }elseif (strexists($site_title, '腾讯') || strexists($site_title, '华数TV') ) { 
                          $site_title = $link['2'];
                        }else{
                          $site_title = $link['0'];
                        }            
                    }else{
                        $site_title = $link['0'];
                    }
                    $site = array_keys($site,str_replace('(付费)','',$site_title));
                } 
                $juji = dongman_url($url,$site);
                if ($_GPC['link']) {
                    $url = $_GPC['link'];
                }else{
                    $url = $juji['0']['link'];
                } 
            }
            if ($op == 'zongyi') {
                $link = zongyi_url($url);               
                if ($_GPC['site']) {
                    $site = array_keys($site,$_GPC['site']);  
                }else{
                    if (strexists($link['0']['title'], '腾讯') && count($link) > 1 && !$settings['tengxun']) {                    
                        $site_title = $link['1']['title'];
                    }else{
                        $site_title = $link['0']['title'];
                    }
                    $site = array_keys($site,str_replace('(付费)','',$site_title));
                } 
                $year = $_GPC['year'];
                if ($year) {
                    $ss = '/([\x80-\xff]*)/i';
                    $year = preg_replace($ss,'',$year);
                    $juji = zongyi_juji_url($url,$site,$year);      
                }else{                  
                    $juji = zongyi_juji_url($url,$site);
                }           
                $year = zongyi_year_url($url);
                // var_dump($year); 
                if (!$_GPC['year']) {
                    $_GPC['year'] = $year['0']['date'];
                }           
                if ($_GPC['link']) {
                    $url = $_GPC['link'];
                }else{
                    $url = $juji['0']['link'];
                }
            }
            $click = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cyl_vip_video') . " WHERE uniacid = :uniacid AND yvideo_url = :yvideo_url ",array(':uniacid'=>$_W['uniacid'],':yvideo_url'=>$yurl)); 
        }  
                    
    }       
    $video = pdo_get('cyl_vip_video', array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'video_url'=>$url));
    if (!$video) {
        if ($_GPC['d_id']) {
            $video_id = $_GPC['d_id'];
        }else{ 
            $video_id = $id;
        }
        if ($id) {
            pdo_insert('cyl_vip_video', array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'title'=>$content['title'],'video_url'=>$url,'video_id'=>$video_id,'yvideo_url'=>$_W['siteurl'],'type'=>$op,'time'=>TIMESTAMP,'share'=>$_GPC['jishu']));
        }else{              
            pdo_insert('cyl_vip_video', array('uniacid'=>$_W['uniacid'],'openid'=>$openid,'title'=>$content['title'],'video_url'=>$url,'video_id'=>$video_id,'yvideo_url'=>$_W['siteurl'],'type'=>$op,'time'=>TIMESTAMP,'share'=>$_GPC['jishu'])); 
        }
    }   
    if ($_GPC['index'] == 1) {
        $url = $_GPC['url'];
    } 
    $Hurl = isset($_SERVER['HTTPS'])?'https':'http';

    if ($settings['api']) {     
        if (strexists($url,'zhilian')) {
                $url = explode('&type=zhilian',$url);               
                $api = $url['0'];
        }elseif (strexists($url,'baidu')) {
            
            $api = $settings['baidu_api'].$url; 
        }else{
            $api = $settings['api'].$url.'&link='.$_GPC['link']; 
        }
    }else{
        
        if ($id) {          
            if (strexists($url,'zhilian')) {
                $url = explode('&type=zhilian',$url);               
                $api = $url['0'];
            }elseif ($settings['baidu_api'] && strexists($url,'baidu')) {
                $api = $settings['baidu_api'].$url;
            }else{
                $api = 'http://jiexi.thecook.com.cn/vip/player.php?url='.$url.'&link='.$_GPC['link'];
                $api = ihttp_get($api);
                $api = $api['content'];
            } 
        }else{
            $api = 'http://jiexi.thecook.com.cn/vip/player.php?url='.$url.'&link='.$_GPC['link'];
            $api = ihttp_get($api);
            $api = $api['content'];
        }  
    } 

    if ($settings['duo_api']) {
       $duo_api = explode(',',$settings['duo_api']);
        if ($_GPC['api']) {
            $api = $duo_api[$_GPC['api']-1].$url.'&link='.$_GPC['link'];
        } 
    } 
    $type = $_GPC['type'];
    if ($type == 'shoucang'){
        $data = array(
            'uniacid' => $_W['uniacid'],
            'yvideo_url' => $_GPC['video_id'],
            'openid' => $_W['openid'],            
            'title' => $_GPC['title'],            
            'type' => 'shoucang'            
        );
        $ret = pdo_get('cyl_vip_video',$data);
        if (empty($ret)) {
            pdo_insert('cyl_vip_video', $data); 
            echo '收藏成功';
            exit();
        }else{
            pdo_delete('cyl_vip_video', array('id'=>$ret['id'])); 
            echo '取消收藏成功';
            exit();
        }
    }       
    if ($type == 'comment') {
        $data = array(
            'uniacid' => $_W['uniacid'],
            'video_id' => $_GPC['video_id'],
            'old_id' => $_GPC['title'],
            'openid' => $member['openid'],            
            'content' => $_GPC['content'],
            'time' => TIMESTAMP
        );        
        if ($settings['comment'] == 1) { 
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }
        if ($data['openid']) {
            $ret = pdo_insert('cyl_vip_video_message', $data);                
        }       
        if (!empty($ret)) {
            echo json_encode($data);
            exit();
        } else {
            echo '留言失败';
        }
    }
    if ($settings['ziyuan'] == 2) {
        include $this->template('pingguo/detail'); 
    }else{
        include $this->template('news/detail'); 
    }     
    exit();
}else{
    $eid = $_GPC['eid'];
    $setting = setting();
    $site_name = $setting['member']; 
    $settings = $this->module['config'];
    if ($site_name['setting']) {
        $setting = iunserializer($site_name['setting']);
        $settings['site_title'] = $setting['site_title'];
        $settings['logo'] = $setting['logo'];
        $settings['subscribe_title'] = $setting['subscribe_title'];
        $settings['subscribe_url'] = $setting['subscribe_url'];
        $settings['index_gg'] = $setting['index_gg'];
        $settings['copyright'] = $setting['copyright'];
        $settings['guanzhu_ewm'] = $setting['guanzhu_ewm'];
    }
    $op = $_GPC['op'] ? $_GPC['op'] : 'index';
    if (!$_GPC['banner_time'] && $settings['banner'] == 1 && $_W['os'] != 'windows' && $op != 'banner') { 
        $url = link_url('index',array('op'=>'banner')); 
        Header("Location: ".$url);
        exit();  
    }
    if ($op == 'banner') {
        $ip = $_W['clientip'];
        isetcookie('banner_time',$ip,$settings['banner_time']);
        $hdp = pdo_getall('cyl_vip_video_hdp', array('uniacid'=>$_W['uniacid'],'type'=>'banner'), array() , '' , 'sort DESC , id DESC');
        if (!$hdp) {
            $url = link_url('index'); 
            Header("Location: ".$url);
            exit(); 
         } 
        include $this->template('news/banner'); 
        exit();
    }
    $acc = WeAccount::create();  
    $pid = $_GPC['pid'];
    $num = $settings['list'] ? $settings['list'] : 6;       
    $member = member($_W['openid']); 
    $type_id_1 = $_GPC['type_id_1'];
    if (TIMESTAMP > $member['end_time'] && $member['is_pay'] == 1) {
        pdo_update('cyl_vip_video_member',array('end_time'=>null,'is_pay'=>0),array('openid'=>$member['openid']));
        $data = array(
                'first' => array(
                    'value' => '您好,'.$member['nickname'].'您的会员已到期',
                    'color' => '#ff510'
                ) ,
                'keyword1' => array(
                    'value' => '会员到期',
                    'color' => '#ff510'
                ) ,
                'keyword2' => array(
                    'value' => date('Y-m-d H:i:s',$member['end_time']),
                    'color' => '#ff510'
                ) ,                   
                'remark' => array(
                    'value' => '欢迎继续使用',
                    'color' => '#ff510'
                ) ,
            );
        $url = link_url('member');
        $acc->sendTplNotice($member['openid'], $settings['due_id'], $data, $url, $topcolor = '#FF683F');
    }
    $jilu = pdo_fetchall("SELECT title , yvideo_url FROM ".tablename('cyl_vip_video')." WHERE uniacid = :uniacid AND openid = :openid ORDER BY id DESC LIMIT 10", array(':uniacid'=>$_W['uniacid'],':openid'=>$_W['openid']));
    if ($site_name) {  
        $hdp = pdo_getall('cyl_vip_video_hdp', array('uniacid'=>$_W['uniacid'],'type'=>$op,'site_name'=>$site_name['site_name']), array() , '' , 'sort DESC , id DESC');
    }else{
        if (pdo_tableexists('cyl_agent_site_member')) {
            $hdp = pdo_getall('cyl_vip_video_hdp', array('uniacid'=>$_W['uniacid'],'type'=>$op,'site_name'=>''), array() , '' , 'sort DESC , id DESC'); 
        }else{
            $hdp = pdo_getall('cyl_vip_video_hdp', array('uniacid'=>$_W['uniacid'],'type'=>$op), array() , '' , 'sort DESC , id DESC'); 
        }
    }
    $category = pdo_fetchall("SELECT * FROM ".tablename('cyl_vip_video_category')." WHERE uniacid = :uniacid AND parentid = :parentid AND status = :status ORDER BY parentid ASC, displayorder ASC, id ASC ", array(':uniacid'=>$_W['uniacid'],':parentid'=>0,':status'=>0), 'id');
    $parent = array(); 
    $children = array();
    if (!empty($category)) {
        $children = '';
        foreach ($category as $cid => $cate) {
            if (!empty($cate['parentid'])) {
                $children[$cate['parentid']][] = $cate;
            } else {
                $parent[$cate['id']] = $cate;
            }
        }
    }   
    $ad = ad();
    foreach ($ad as $key => $value) { 
        if ($key == 'dianying' || $key == 'dianshi' || $key == 'zongyi' || $key == 'dongman' ) {
           $gg[$key] = pdo_fetch("SELECT * FROM " . tablename('cyl_vip_video_ad') . " WHERE uniacid = :uniacid AND type = :type  AND status = 0 ORDER BY rand() DESC LIMIT 1",array(':uniacid'=>$_W['uniacid'],':type'=>$key),'id');    
        }elseif ($key != 'dumiao') {
           $list_gg[$key] = pdo_fetchall("SELECT * FROM " . tablename('cyl_vip_video_ad') . " WHERE uniacid = :uniacid AND type = :type  AND status = 0 ORDER BY id DESC ",array(':uniacid'=>$_W['uniacid'],':type'=>$key),'insert');  
        }       
    }
    foreach ($gg as $key => $value) {                
        if ($value['end_time'] < TIMESTAMP ) {
            pdo_update('cyl_vip_video_ad', array('end_time' => '','status'=>1), array('id'=>$value['id']));
        } 
    }       
    foreach ($list_gg as $key => $value) {
        foreach ($value as $key => $value) {
            if ($value['end_time'] < TIMESTAMP ) {
                pdo_update('cyl_vip_video_ad', array('end_time' => '','status'=>1), array('id'=>$value['id']));
            }
        }
    }   
    if ($op == 'today' && $settings['ziyuan'] == 2) {    	
    	$type =mac_category();     	        
        $today = mac_list(array('op'=>'today','pageno'=>100));
    }elseif ($op == 'today' && $settings['ziyuan'] == 1) {
    	$url = m3u8();
        $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
        $url = $url . "?ip=".$ip."&op=today&pageno=100";
	    $response = ihttp_get($url); 
	    $today = json_decode($response['content'],true); 
        foreach ($today as $key => &$value) {
            if (strexists($value['img'], 'tu')) {
                $value['img'] = 'https://www.tv6.com/' . $value['img'];                
            }                
        }
    }elseif ($op == 'today' && $settings['ziyuan'] == 3) {
        $url = m3u8();
        $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
        $url = $url . "?ziyuan=".$setings['ziyuan']."&ip=".$ip."&op=today&pageno=100";
        $response = ihttp_get($url); 
        $today = json_decode($response['content'],true); 
    }    
    if ($op == 'index' && !$type_id_1) {
        $data = pdo_getall('cyl_vip_video_manage', array('uniacid'=>$_W['uniacid'],'display !=' => 1), array() , '' ,array('sort DESC','time DESC','id DESC'));

    	if ($settings['ziyuan'] == 2) {
                $type =mac_category();                 
                $today = mac_list(array('op'=>'today','pageno'=>20));
                $dianying = index_list('dianying',$settings['ziyuan']);
                
        }else{
	        $time = cache_load('cyl_vip_video:time'.$_W['uniacid']);            
	       
	        if ($settings['ziyuan'] == 1 || $settings['ziyuan'] == 3) { 
                $url = m3u8();
                $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
                $url = $url . "?ziyuan=".$settings['ziyuan']."&ip=".$ip."&op=today&pageno=20";
	            $response = ihttp_get($url); 
	        	$today = json_decode($response['content'],true); 
	        }
	        if ((TIMESTAMP - $time) > 3600 ) {  
	            if ($settings['ziyuan'] == 1 || $settings['ziyuan'] == 3) {
	                $dianying = index_list('dianying',$settings['ziyuan'],$settings['dianying_rank'] ? $settings['dianying_rank'] : 'rankhot');
	                $dianshi = index_list('dianshi',$settings['ziyuan'],'rankhot');
	                $zongyi = index_list('zongyi',$settings['ziyuan'],$settings['zongyi_rank'] ? $settings['zongyi_rank'] : 'rankhot');
	                $dongman = index_list('dongman',$settings['ziyuan'],$settings['dongman_rank'] ? $settings['dongman_rank'] : 'rankhot');  
	            }else{
	                $dianying = index_list($url,$settings['dianying_rank'] ? $settings['dianying_rank'] : 'rankhot','dianying',$settings['screen_name']);
	                $dianshi = index_list($url,'rankhot','dianshi',$settings['screen_name']);
	                $zongyi = index_list($url,$settings['zongyi_rank'] ? $settings['zongyi_rank'] : 'rankhot','zongyi',$settings['screen_name']);
	                $dongman = index_list($url,$settings['dongman_rank'] ? $settings['dongman_rank'] : 'rankhot','dongman',$settings['screen_name']);                    
	            }
	            cache_write('cyl_vip_video:time'.$_W['uniacid'], TIMESTAMP);               
	            cache_write('cyl_vip_video:dianying'.$_W['uniacid'], $dianying);  
	            cache_write('cyl_vip_video:dianshi'.$_W['uniacid'], $dianshi);  
	            cache_write('cyl_vip_video:zongyi'.$_W['uniacid'], $zongyi);   
	            cache_write('cyl_vip_video:dongman'.$_W['uniacid'], $dongman);  
	        }else{
	            $dianying = cache_load('cyl_vip_video:dianying'.$_W['uniacid']);   
	            $dianshi = cache_load('cyl_vip_video:dianshi'.$_W['uniacid']); 
	            $zongyi = cache_load('cyl_vip_video:zongyi'.$_W['uniacid']);   
	            $dongman = cache_load('cyl_vip_video:dongman'.$_W['uniacid']); 
	            // var_dump($dongman);  
	        }
            foreach ($today as $key => &$value) {
                if (strexists($value['img'], 'tu.php')) {
                    $value['img'] = MODULE_URL . $value['img'];                    
                }elseif (strexists($value['img'], 'doubanio.com')) {
                    $value['img'] = MODULE_URL . 'tu.php?tu=' .$value['img'];      
                }                     
            }
            foreach ($dianying as $key => &$value) {
                if (strexists($value['img'], 'tu.php')) {
                    $value['img'] = MODULE_URL . $value['img'];                    
                }elseif (strexists($value['img'], 'doubanio.com')) {
                    $value['img'] = MODULE_URL . 'tu.php?tu=' .$value['img'];      
                }             
            }
            foreach ($dianshi as $key => &$value) {
                if (strexists($value['img'], 'tu.php')) {
                    $value['img'] = MODULE_URL . $value['img'];                    
                }elseif (strexists($value['img'], 'doubanio.com')) {
                    $value['img'] = MODULE_URL . 'tu.php?tu=' .$value['img'];      
                }              
            }
            foreach ($zongyi as $key => &$value) {
                if (strexists($value['img'], 'tu.php')) {
                    $value['img'] = MODULE_URL . $value['img'];                    
                }elseif (strexists($value['img'], 'doubanio.com')) {
                    $value['img'] = MODULE_URL . 'tu.php?tu=' .$value['img'];      
                }              
            }
            foreach ($dongman as $key => &$value) {
                if (strexists($value['img'], 'tu.php')) {
                    $value['img'] = MODULE_URL . $value['img'];                    
                }elseif (strexists($value['img'], 'doubanio.com')) {
                    $value['img'] = MODULE_URL . 'tu.php?tu=' .$value['img'];      
                }              
            }
    	}        
        foreach ($list_gg['dianying_list'] as  &$row){
            $row['out_link'] = $row['link'];
        } 
        foreach($list_gg['dianying_list'] as $k=>$p){
          array_splice($dianying, $k-1, 0, array($p));
        } 

        foreach ($list_gg['dianshi_list'] as  &$row){
            $row['out_link'] = $row['link'];
        } 
        foreach($list_gg['dianshi_list'] as $k=>$p){
          array_splice($dianshi, $k-1, 0, array($p));
        }

        foreach ($list_gg['zongyi_list'] as  &$row){
            $row['out_link'] = $row['link'];
        } 
        foreach($list_gg['zongyi_list'] as $k=>$p){
          array_splice($zongyi, $k-1, 0, array($p));
        }

        foreach ($list_gg['dongman_list'] as  &$row){
            $row['out_link'] = $row['link'];
        } 
        foreach($list_gg['dongman_list'] as $k=>$p){
          array_splice($dongman, $k-1, 0, array($p));
        }
        if ($settings['ziyuan'] == 2) {
        	include $this->template('pingguo/index'); 
        }else{
        	include $this->template('news/index'); 
        }
        
    }else{        
        if ($op > 0) {
            $where['uniacid'] = $_W['uniacid'];
            $where['cid'] = $op;
            $where['display !='] = 1;
            if ($pid > 0) {
                $where['pid'] = $pid;       
            }   
            $data = pdo_getall('cyl_vip_video_manage', $where, array() , '' , 'sort DESC' ,'time DESC', 'id DESC');
            $cat = pdo_getall('cyl_vip_video_category', array('uniacid'=>$_W['uniacid'],'parentid'=>$op), array() , '' , 'id DESC');                 
        }elseif($op == 'yule' || $op == 'gaoxiao'){         
            $data = kan360_list($op);                       
        }elseif ($settings['ziyuan'] == 2) {
            $type = mac_category();            
            $type_pid = $type['1'][$type_id_1];            
            $rank = $_GPC['rank'] ? $_GPC['rank'] : 'rankhot';  
            $year = $_GPC['year'];                  
            $type_id = $_GPC['type_id'];                  
            $area = $_GPC['area'];  
            $num = $_GPC['num'] ? $_GPC['num'] : 0;   
            $where = array('type_id_1'=>$type_id_1); 
            if (!$type_pid) {
               $where = array('type_id'=>$type_id_1);
            }
            if ($type_id) {
                $where['type_id'] = $type_id;
            } 
            if ($year) {
                $where['vod_year'] = $year;
            } 
            if ($area) {
                $where['vod_area'] = $area;
            }             
            $data = mac_list($where,$rank);            
        }else{ 
            $url = $_GPC['url'];
            $year = $_GPC['year'];                  
            $area = $_GPC['area'];                  
            $act = $_GPC['act'];                    
            $cat = $_GPC['cat'];                    
            $num = $_GPC['num'] ? $_GPC['num'] : 0;     
            $rank = $_GPC['rank'] ? $_GPC['rank'] : 'rankhot'; 
            if (!$settings['ziyuan']) {
                if ($_GPC['cat'] || $_GPC['act'] || $_GPC['year'] || $_GPC['area'] || $rank) {
                    $url = "http://www.360kan.com/".$op."/list.php?rank=".$rank."&year=".$year."&area=".$area."&act=".$act."&cat=".$cat."&pageno=".$num;
                }else{
                    $url = "http://www.360kan.com/".$op."/list.php?rank=".$rank."&cat=all&area=all&act=all&year=all&pageno=".$num;
                }
            }   
            $discover_time = cache_load('discover:time'.$op.$rank.$_W['uniacid']); 
            $data = cache_load('discover:data'.$op.$rank.$_GPC['cat'].$_GPC['cat_id'].$_GPC['year'].$_GPC['area'].$_W['uniacid']);                
            if (empty($data) || (TIMESTAMP - $discover_time) > 3600) {
                if ($settings['ziyuan'] == 1 || $settings['ziyuan'] == 3) {
                    $cat = $_GPC['cat_id'];
                    $url = m3u8();
                    $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
                    $url = $url . "?ziyuan=".$settings['ziyuan']."&ip=".$ip."&op=".$op."&rank=".$rank."&year=".$year."&area=".$area."&act=".$act."&cat=".$cat."&pageno=".$num; 
                    $response = ihttp_get($url); 
                    $data = json_decode($response['content'],true);
                }else{
                    $data = discover($url);     
                }                           
                cache_write('discover:data'.$op.$rank.$_GPC['cat'].$_GPC['cat_id'].$_GPC['year'].$_GPC['area'].$_W['uniacid'],$data);
            }else{
                $data = cache_load('discover:data'.$op.$rank.$_GPC['cat'].$_GPC['cat_id'].$_GPC['year'].$_GPC['area'].$_W['uniacid']);  
            }
            if ($op == 'dianying') {
                foreach ($list_gg['dianying_list'] as  &$row){
                    $row['out_link'] = $row['link'];
                } 
                foreach($list_gg['dianying_list'] as $k=>$p){
                  array_splice($data, $k-1, 0, array($p));
                } 
            }   
            
            if ($op == 'dianshi') {
                foreach ($list_gg['dianshi_list'] as  &$row){
                    $row['out_link'] = $row['link'];
                } 
                foreach($list_gg['dianshi_list'] as $k=>$p){
                  array_splice($data, $k-1, 0, array($p));
                }
            }
            if ($op == 'zongyi') {
                foreach ($list_gg['zongyi_list'] as  &$row){
                    $row['out_link'] = $row['link'];
                }
                foreach($list_gg['zongyi_list'] as $k=>$p){
                  array_splice($data, $k-1, 0, array($p));
                }
            } 
            if ($op == 'dongman') {
                foreach ($list_gg['dongman_list'] as  &$row){
                    $row['out_link'] = $row['link'];
                } 
                foreach($list_gg['dongman_list'] as $k=>$p){
                  array_splice($data, $k-1, 0, array($p));
                }
            } 
            foreach ($data as $key => &$value) {
                if (strexists($value['img'], 'tu')) {
                    $value['img'] = MODULE_URL . $value['img'];                 
                }                
            }               
            if ((TIMESTAMP - $discover_time) > 86400) {
                if ($settings['ziyuan'] == 1 || $settings['ziyuan'] == 3) {
                    $url = m3u8();
                    $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
                    $url = $url . "?ziyuan=".$settings['ziyuan']."&ip=".$ip."&op=".$op."&do=1";
                    $response = ihttp_get($url); 
                    $category_list = json_decode($response['content'],true); 
                    $cat =  $category_list['0'];  
                    $area =  $category_list['1'];  
                    $year = $category_list['2'];  
                }else{
                    $category_list = category_list($url);
                    $cat =  $category_list['0'];            
                    $year = $category_list['1']; 
                    $area = $category_list['2'];
                    $star = $category_list['3'];
                }                   
                cache_write('discover:time'.$op.$rank.$_W['uniacid'], TIMESTAMP);                  
                cache_write('discover:cat'.$op.$rank.$_W['uniacid'], $cat);  
                cache_write('discover:year'.$op.$rank.$_W['uniacid'], $year);   
                cache_write('discover:area'.$op.$rank.$_W['uniacid'], $area);  
                cache_write('discover:star'.$op.$rank.$_W['uniacid'], $star);  
            }else{                  
                $cat = cache_load('discover:cat'.$op.$rank.$_W['uniacid']);    
                $year = cache_load('discover:year'.$op.$rank.$_W['uniacid']);
                $area = cache_load('discover:area'.$op.$rank.$_W['uniacid']);
                $star = cache_load('discover:star'.$op.$rank.$_W['uniacid']);
            }            
        }
        $cid = $_GPC['cid'];
        if ($_GPC['type'] == 'json') {              
            if ($op > 0) {                  
                $num = isset($_GPC['page']) ? $_GPC['page'] : 2;
                $pageindex = 50;                    
                if (!empty($_GPC['keyword'])) {
                    $condition.= " AND title LIKE '%{$_GPC['keyword']}%'";
                }
                if (!empty($_GPC['pcate'])) {
                    $pcate = intval($_GPC['pcate']);
                    $condition.= " AND pcate = $pcate";
                }
                if (!empty($_GPC['ccate'])) {
                    $ccate = $_GPC['ccate'];
                    $condition.= " AND ccate = $ccate";
                }
                $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('cyl_vip_video_manage') . " WHERE uniacid = {$_W['uniacid']} $condition");
                $data = pdo_fetchall("SELECT * FROM " . tablename('cyl_vip_video_manage') . " WHERE uniacid = ".$_W['uniacid']." ORDER BY id DESC LIMIT " . ($num - 1) * $pageindex . ',' . $pageindex); 
                if (!$data) {
                    exit();
                }
            }elseif($op == 'yule' || $op == 'gaoxiao'){                 
                $num = $_GPC['num']+1;
                $cid = $_GPC['cid'];
                $data = kan360_list($op,$cid,$num);
            }elseif ($settings['ziyuan'] == 2) {
                $type = mac_category();            
                $type_pid = $type['1'][$type_id_1];            
                $rank = $_GPC['rank'] ? $_GPC['rank'] : 'rankhot';  
                $year = $_GPC['year'];                  
                $type_id = $_GPC['type_id'];                  
                $area = $_GPC['area'];  
                $num = $_GPC['num'];   
                $where = array('type_id_1'=>$_GPC['type_id_1']); 
                if (!$type_pid) {
                   $where = array('type_id'=>$_GPC['type_id_1']);
                }
                if ($type_id) {
                    $where['type_id'] = $type_id;
                } 
                if ($year) {
                    $where['vod_year'] = $year;
                } 
                if ($area) {
                    $where['vod_area'] = $area;
                }        
                $data = mac_list($where,$rank,$num);            
            }else{
                $url = $_GPC['url'];
                $num = $_GPC['num'];
                $year = $_GPC['year'];
                $area = $_GPC['area'];
                $act = $_GPC['act'];
                $cat = $_GPC['cat_id'];
                $num = $_GPC['num'];
                $rank = $_GPC['rank'] ? $_GPC['rank'] : 'rankhot';      
                if (!$settings['ziyuan']) {
                    if ($_GPC['cat'] || $_GPC['act'] || $_GPC['year'] || $_GPC['area'] || $rank) {
                        $url = "http://www.360kan.com/".$op."/list.php?rank=".$rank."&year=".$year."&area=".$area."&act=".$act."&cat=".$cat."&pageno=".$num;
                    }else{
                        $url = "http://www.360kan.com/".$op."/list.php?rank=".$rank."&cat=all&area=all&act=all&year=all&pageno=".$num;
                    }
                }
                $discover_time = cache_load('discover:time'.$op.$rank.$num.$_W['uniacid']);
                $data = cache_load('discover:data'.$op.$rank.$_GPC['cat'].$_GPC['cat_id'].$_GPC['year'].$_GPC['area'].$num.$_W['uniacid']);
                // var_dump($data);
                if (empty($data) || (TIMESTAMP - $discover_time) > 3600) {
                    cache_write('discover:time'.$op.$rank.$num.$_W['uniacid'], TIMESTAMP);
                    if ($settings['ziyuan'] == 1 || $settings['ziyuan'] == 3) {
                       $url = m3u8();
                       $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
                       $url = $url . "?ziyuan=".$settings['ziyuan']."&ip=".$ip."&op=".$op."&rank=".$rank."&year=".$year."&area=".$area."&act=".$act."&cat=".$cat."&pageno=".$num;
                       $response = ihttp_get($url); 
                       $data = json_decode($response['content'],true);
                    }else{
                        $data = discover($url);
                    }
                    cache_write('discover:data'.$op.$rank.$_GPC['cat'].$_GPC['cat_id'].$_GPC['year'].$_GPC['area'].$num.$_W['uniacid'],$data);
                }else{
                    $data = cache_load('discover:data'.$op.$rank.$_GPC['cat'].$_GPC['cat_id'].$_GPC['year'].$_GPC['area'].$num.$_W['uniacid']);                     
                } 
                          
            }
            
            if ($op == 'dianying') {
                foreach ($list_gg['dianying_list'] as  &$row){
                    $row['out_link'] = $row['link'];
                } 
                foreach($list_gg['dianying_list'] as $k=>$p){
                  array_splice($data, $k-1, 0, array($p));
                } 
            }   
            
            if ($op == 'dianshi') {
                foreach ($list_gg['dianshi_list'] as  &$row){
                    $row['out_link'] = $row['link'];
                } 
                foreach($list_gg['dianshi_list'] as $k=>$p){
                  array_splice($data, $k-1, 0, array($p));
                }
            }
            if ($op == 'zongyi') {
                foreach ($list_gg['zongyi_list'] as  &$row){
                    $row['out_link'] = $row['link'];
                } 
                foreach($list_gg['zongyi_list'] as $k=>$p){
                  array_splice($zongyi, $k-1, 0, array($p));
                }
            }
            if ($op == 'dongman') {
                foreach ($list_gg['dongman_list'] as  &$row){
                    $row['out_link'] = $row['link'];
                } 
                foreach($list_gg['dongman_list'] as $k=>$p){
                  array_splice($dongman, $k-1, 0, array($p));
                }
            }   
            foreach ($data as $key => &$value) {
                if (strexists($value['img'], 'tu')) {
                    $value['img'] = MODULE_URL . $value['img'];
                    // var_dump($value);
                }                
            }            
            include $this->template('discover_json'); 
            exit();
        }
        if ($settings['ziyuan'] == 2) {
            include $this->template('pingguo/index'); 
        }else{
            include $this->template('news/index'); 
        }
    }
}               
