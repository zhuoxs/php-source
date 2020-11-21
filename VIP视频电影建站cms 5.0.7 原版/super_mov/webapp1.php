<?php
header("Access-Control-Allow-Origin: *");
defined('IN_IA') or exit('Access Denied');
include IA_ROOT . "/addons/super_mov/model.php";
load()->func('communication');
class Super_movModuleWebapp extends WeModuleWebapp { 
public function getuid(){
    global $_W, $_GPC; 
    $settings = $this->module['config'];    
    $session = pdo_get('cyl_video_sessions',array('sid'=>$_W['session_id']));
    if ($session) {
    	$member = pdo_get('mc_members',array('uid'=>$session['uid']));    	
    	$video_member = member($member['mobile'],'is_weixin');
        $data['openid'] = $member['openid'];
        if ($member['nickname'] || $member['avatar']) {
            $_W['openid'] = $member['openid'];
            $member = member($_W['openid']);
            $data['avatar'] = $member['avatar'];
            $data['nickname'] = $member['nickname'];
            $data['openid'] = $member['openid'];
            $data['uid'] = $member['uid'];
        } 	
    	$member = array_merge($member,$video_member); 
    	$member['openid'] = $member['openid'];
    }else{
    	$fans = pdo_get('mc_mapping_fans',array('openid'=>$_W['openid']));
    	$member = pdo_get('mc_members',array('uid'=>$fans['uid']));  
    	$video_member = member($fans['openid']);          
    	$member = array_merge($video_member,$member);
    	$member['openid'] = $fans['openid']; 
    }                     
    if ($_GPC['tiaoshi'] == 1) {
        $member = pdo_get('mc_members',array('uid'=>10));
        $fans = pdo_get('mc_mapping_fans',array('uid'=>10));
        $member['openid'] = $fans['openid'];
        $video_member = member($member['openid']);
        $member = array_merge($member,$video_member);
        $member['openid'] = $fans['openid'];
    }     
    $member['avatarUrl'] = $member['avatar'] ? $member['avatar'] : $_W['uniaccount']['logo'];
    $member['nickName'] = $member['nickname'] ? $member['nickname'] : $member['mobile'];  
    $member['uid'] = $member['uid']; 
    $member['credit1'] = $member['credit1'];
    $cyl_vip_video_history = pdo_get('cyl_vip_video_history',array('uid'=>$member['uid']),array('COUNT(*) AS count'));
    $member['historynum'] = $cyl_vip_video_history['count'];
    $cyl_vip_video_collection = pdo_get('cyl_vip_video_collection',array('uid'=>$member['uid']),array('COUNT(*) AS count'));
    $member['collectionnum'] = $cyl_vip_video_collection['count'];
    return $member;
}
public function doPageFoot() {
    global $_W, $_GPC; 
    $settings = $this->module['config'];
    $data = array();
    $settings['tabBar_color'] = $settings['tabBar_color'] ? $settings['tabBar_color'] : '#ffffff';
    $data['foot'] = tabBar($settings);
    $data['tabBar_backgroundColor'] = $settings['tabBar_backgroundColor'] ? $settings['tabBar_backgroundColor'] : '#ea5455'; 
    result(0, 'success' ,$data);       
}
public function doPageVersion() {
    global $_W, $_GPC; 
   	$data = array('version'=>'1.0.3','wgtUrl'=>'https://sport.mtgjiaxiang.com/addons/super_mov/template/mobile/h5/static/__UNI__748811E.wgt','banben'=>2,'note'=>'重要更新提示');
    result(0, 'success' ,$data);       
}
public function doPageSettings() {
    global $_W, $_GPC; 
    $setting = array();
    $settings = $this->module['config']; 
    $setting['logo'] = $_W['uniaccount']['logo'];   
    $setting['list'] = $settings['list'] ? $settings['list'] : '6';     
    $setting['theme'] = $settings['theme'];     
    $setting['frontColor'] = $settings['frontColor'];     
    $setting['headtheme'] = $settings['headtheme'];     
    $setting['site_title'] = $settings['site_title'];     
    $setting['subscribe_title'] = $settings['subscribe_title'];     
    $setting['share_title'] = $settings['share_title'];     
    $setting['share_desc'] = $settings['share_desc'];     
    $setting['index_gg'] = $settings['index_gg'];     
    $setting['copyright'] = $settings['copyright'];     
    $setting['pay_settings'] = $settings['pay_settings'];     
    $setting['free_num'] = $settings['free_num'];     
    $setting['warn_font'] = $settings['warn_font'];     
    $setting['shuoming'] = $settings['shuoming'];     
    $setting['share_thumb'] = tomedia($settings['share_thumb']);  
    $setting['ewm'] = tomedia($settings['ewm']);  
    $setting['card'] = iunserializer($settings['card']); 
    result(0, 'success' ,$setting);     
}
public function doPageNavlist() {
    global $_W, $_GPC; 
    $data = category();
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
    $data = array('list'=>$data,'category'=>$category); 
    result(0, 'success' ,$data);     
}
public function doPageHdp() {
    global $_W, $_GPC; 
    $op = $_GPC['op'] ? $_GPC['op'] : 'index';
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
    if ($site_name) {  
        $data = pdo_getall('cyl_vip_video_hdp', array('uniacid'=>$_W['uniacid'],'type'=>$op,'site_name'=>$site_name['site_name']), array() , '' , 'sort DESC , id DESC');
    }else{
        if (pdo_tableexists('cyl_agent_site_member')) {
            $data = pdo_getall('cyl_vip_video_hdp', array('uniacid'=>$_W['uniacid'],'type'=>$op,'site_name'=>''), array() , '' , 'sort DESC , id DESC'); 
        }else{
            $data = pdo_getall('cyl_vip_video_hdp', array('uniacid'=>$_W['uniacid'],'type'=>$op), array() , '' , 'sort DESC , id DESC'); 
        }
    }    
    foreach ($data as $key => &$value) {
        $value['thumb'] = tomedia($value['thumb']);
    }
    result(0, 'success' ,$data);     
}
public function doPageNewsindex() {
    global $_W, $_GPC; 
    $json = array();
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
    $acc = WeAccount::create();  
    $json['num'] = $settings['list'] ? $settings['list'] : 6;     
    $member = member($_W['openid']); 
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
                $value['img'] = MODULE_URL . $value['img'];                
            }                
        }
    }elseif ($op == 'today' && $settings['ziyuan'] == 3) {
        $url = m3u8();
        $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
        $url = $url . "?ziyuan=".$setings['ziyuan']."&ip=".$ip."&op=today&pageno=100";
        $response = ihttp_get($url); 
        $today = json_decode($response['content'],true); 
    }
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
        $row['img'] = tomedia($row['thumb']);
        $row['hint'] = '广告';
    } 
    foreach($list_gg['dianying_list'] as $k=>$p){
      array_splice($dianying, $k-1, 0, array($p));
    } 

    foreach ($list_gg['dianshi_list'] as  &$row){
        $row['out_link'] = $row['link'];
        $row['img'] = tomedia($row['thumb']);
        $row['hint'] = '广告';
    } 
    foreach($list_gg['dianshi_list'] as $k=>$p){
      array_splice($dianshi, $k-1, 0, array($p));
    }

    foreach ($list_gg['zongyi_list'] as  &$row){
        $row['out_link'] = $row['link'];
        $row['img'] = tomedia($row['thumb']);
        $row['hint'] = '广告';
    } 
    foreach($list_gg['zongyi_list'] as $k=>$p){
      array_splice($zongyi, $k-1, 0, array($p));
    }

    foreach ($list_gg['dongman_list'] as  &$row){
        $row['out_link'] = $row['link'];
        $row['img'] = tomedia($row['thumb']);
        $row['hint'] = '广告';
    } 
    foreach($list_gg['dongman_list'] as $k=>$p){
      array_splice($dongman, $k-1, 0, array($p));
    }    
    $json['list'] = array(
        'today' => array(
            'title' => '今日更新',
            'list' => $today, 
        ),
        'dianying' => array(
            'title' => '电影',
            'list' => $dianying,
        ),
        'dianshi' => array(
            'title' => '电视剧',
            'list' => $dianshi,
        ),
        'zongyi' => array(
            'title' => '综艺',
            'list' => $zongyi,
        ),
        'dongman' => array(
            'title' => '动漫',
            'list' => $dongman,
        ),
    ); 
    $json['gg'] = $list_gg;
    result(0, 'success' ,$json);     
}
public function doPageNewslist() { 
    global $_W, $_GPC;
    $op = $_GPC['id'];
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
    if ($op > 0) {
        $where['uniacid'] = $_W['uniacid'];
        $where['cid'] = $op;
        $where['display !='] = 1;
        if ($_GPC['year'] > 0) {
            $where['pid'] = $_GPC['year'];       
        }   
        $data = pdo_getall('cyl_vip_video_manage', $where, array() , '' , 'sort DESC' ,'time DESC', 'id DESC');
        foreach ($data as $key => &$value) {
        	$value['img'] = tomedia($value['thumb']);
        }
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
    }elseif ($op == 'today' && $settings['ziyuan'] == 2) {    	
    	$type =mac_category();     	        
        $today = mac_list(array('op'=>'today','pageno'=>100));
    }elseif ($op == 'today' && $settings['ziyuan'] == 1) {
    	$url = m3u8();
        $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
        $url = $url . "?ip=".$ip."&op=today&pageno=100";
	    $response = ihttp_get($url); 
	    $data = json_decode($response['content'],true); 
        foreach ($data as $key => &$value) {
            if (strexists($value['img'], 'tu')) {
                $value['img'] = 'https://www.tv6.com/' . $value['img'];                
            }                
        }
    }else{ 
        $url = $_GPC['url'];
        $year = $_GPC['year'];                  
        $area = $_GPC['area'];                  
        $act = $_GPC['act'];                    
        $cat = $_GPC['cat'];                    
        $num = $_GPC['num'] ? $_GPC['num'] : 1;     
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
            cache_write('discover:data'.$op.$rank.$_GPC['cat'].$_GPC['cat_id'].$_GPC['year'].$_GPC['area'].$num.$_W['uniacid'],$data);
        }else{
            $data = cache_load('discover:data'.$op.$rank.$_GPC['cat'].$_GPC['cat_id'].$_GPC['year'].$_GPC['area'].$num.$_W['uniacid']);  
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
    $json = array();
    $json['list'] = $data;
    $json['cat'] = array(
        '0' => $cat,
        '1' => $year,
        '2' => $area,
    );
    $json['rank'] = array(
        array('key'=>'rankhot','title'=>'最近热映'),
        array('key'=>'createtime','title'=>'最近更新'),
        array('key'=>'rankpoint','title'=>'最受好评'),
    );
    result(0, 'success' ,$json);     
}
public function doPagenewsSearch() {
    global $_W, $_GPC;
    $setting = setting();
    $setting = $setting['member']; 
    $settings = $this->module['config'];
    if ($settings['ziyuan'] == 2) {
        $type = mac_category();
    }    
    if ($setting) {
        $setting = iunserializer($setting['setting']);
        $settings['site_title'] = $setting['site_title'];
        $settings['logo'] = $setting['logo'];
        $settings['subscribe_title'] = $setting['subscribe_title'];
        $settings['subscribe_url'] = $setting['subscribe_url'];
        $settings['index_gg'] = $setting['index_gg'];
        $settings['copyright'] = $setting['copyright'];
        $settings['guanzhu_ewm'] = $setting['guanzhu_ewm'];
    }
    $where = ' WHERE uniacid = :uniacid AND display != 1 ';
    $params[':uniacid'] = $_W['uniacid'];
    $sql = ' SELECT * FROM '.tablename('cyl_vip_video_manage').$where.' ORDER BY id DESC LIMIT 50';         
    $video = pdo_fetchall($sql, $params, 'id');             
    $op = $_GPC['op'] ? $_GPC['op'] : 'search';
    $key = $_GPC['key'];
    if ($key) { 
        $where = ' WHERE uniacid = :uniacid ';          
        $where .= ' AND title LIKE :title ';
        $params[':uniacid'] = $_W['uniacid'];   
        $params[':title'] = "%".$_GPC['key']."%";             
        $sql = ' SELECT * FROM '.tablename('cyl_vip_video_manage').$where.' ORDER BY id DESC ';         
        $search = pdo_fetchall($sql, $params, 'id');
        if ($settings['ziyuan'] == 1 || $settings['ziyuan'] == 3) { 
            $url = m3u8();
            $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : gethostbyname($_SERVER['SERVER_NAME']);
            $url = $url . "?ziyuan=".$settings['ziyuan']."&ip=".$ip."&key=".$key;
            $response = ihttp_get($url); 
            $list = json_decode($response['content'],true);
        }elseif ($settings['ziyuan'] == 2) {                 
            $list = mac_list(array('key'=>$key));                
        }else{                      
            $list = caiji_list($key);
        }
    }
    if (count($list) == 1 ) {
        if (strexists($list['0']['img'], 'tu')) {
            $list['0']['img'] = MODULE_URL . $list['0']['img'];                    
        }  
    }else{
        foreach ($list as $key => &$value) {
            if (strexists($value['img'], 'tu')) {
                $value['img'] = MODULE_URL . $value['img'];                    
            }                
        }
    }
    
    if ($op == 'json') {
        $url = 'https://video.360kan.com/suggest.php?ac=richsug&kw='.$_GPC['kw'];
        $url = ihttp_get($url);    
        $content = json_decode($url['content'],true);            
        $list =  $content['data']['suglist']; 
    }
    $list['list']  = $list;
    $list['videosite']  = videosite();
    result(0, 'success' ,$list);
}
public function doPagenewsXiaopin() {
    global $_W, $_GPC;
    $ch = curl_init();
    $setting = setting();
    $op = $_GPC['op'] ? $_GPC['op'] : 'list';
    if ($op == 'list') {
        $setting = $setting['member']; 
        $settings = $this->module['config'];
        if ($settings['ziyuan'] == 2) {
            $type = mac_category();
        }    
        if ($setting) {
            $setting = iunserializer($setting['setting']);
            $settings['site_title'] = $setting['site_title'];
            $settings['logo'] = $setting['logo'];
            $settings['subscribe_title'] = $setting['subscribe_title'];
            $settings['subscribe_url'] = $setting['subscribe_url'];
            $settings['index_gg'] = $setting['index_gg'];
            $settings['copyright'] = $setting['copyright'];
            $settings['guanzhu_ewm'] = $setting['guanzhu_ewm'];
        }
        $max_cursor = $_GPC['num'];
        $list = xiaopin($max_cursor);
        foreach ($list as $key => &$value) {
            $value['img'] = $value['imgv_url'];
            $value['hint'] = $value['duration'];
        }
        result(0, 'success' ,$list);
    }
    if ($op == 'json') {
        $url = $_GPC['url'];
        $url = parse_url($url);
        $url = 'http://m.v.baidu.com'.$url['path'];

        $html = ihttp_request($url, '', array('CURLOPT_REFERER' => 'http://m.v.baidu.com'));

        $html = explode('source: {"mp4":"',$html['content']);
        $html = explode('","ori',$html['1']);
        $html = $html['0'];
        result(0, 'success' ,$html);
    }   
}
public function doPagenewsTv() {
    global $_W, $_GPC;
    $list =  array();
    $cctv = cctv();
    $cntv = cntv();
    $wstv = wstv();
    $qttv = qttv();
    $list = array(
        'cctv'=>$cctv,
        // 'cntv'=>$cntv,
        'wstv'=>$wstv,
        'qttv'=>$qttv,
    );
    result(0, 'success' ,$list);   
}
public function doPageNewsdetail() {
    global $_W, $_GPC; 
    $op = $_GPC['op'];
    $id = $_GPC['id'];
    $settings = $this->module['config'];
    $member = $this->getuid();
    $uid = $member['uid'];    
    $ad = pdo_fetch("SELECT * FROM " . tablename('cyl_vip_video_ad') . " WHERE uniacid = :uniacid AND type = 'dumiao'  AND status = 0 ORDER BY rand() DESC LIMIT 1",array(':uniacid'=>$_W['uniacid']),'id');
    if (TIMESTAMP > $ad['end_time']) {
        pdo_update('cyl_vip_video_ad',array('status'=>1),array('id'=>$ad['id']));
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
    $content = pdo_fetch("SELECT * FROM ".tablename('cyl_vip_video_manage')." WHERE id=:id",array(':id'=>$_GPC['d_id'])); 
    if ($content['id']) {        
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
        foreach ($juji as $key => $value) {
        	$juji[$key] = array(
        		'url' => $value['link'],
        		'name' => $value['title'],
        		'from' => $value['title'],
        		'nid' => $key,
        	);
        }
        if (count($juji) < 2) {
            $url = $juji['0']['url'];
            $url = tomedia($url);
        }else{
            $url = $_GPC['url'];
            if (!$url) {
                $url = $juji['0']['url'];
                $url = tomedia($url);
            }
        }
        $is_charge = pdo_get('cyl_vip_video_order',array('uniacid'=>$_W['uniacid'],'video_id'=>$id));
        $is_vip = is_vip($content['id'],'id');
        pdo_update('cyl_vip_video_manage', array('click +=' => 1), array('id' => $id));                 
    }elseif ($op == 'yule' || $op == 'gaoxiao') {
        $url = kan360($url);        
        $content['title'] = $url['title'];      
        $content['thumb'] = $url['thumb'];      
        $url = $url['mp4'];
        // $tuijian = pc_caiji_detail_tuijian($url);
    }else{ 
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
    }
    $json = array();
    // $url = 'http://wxsnsdy.tc.qq.com/105/20210/snsdyvideodownload?filekey=30280201010421301f0201690402534804102ca905ce620b1241b726bc41dcff44e00204012882540400&bizid=1023&hy=SH&fileparam=302c020101042530230204136ffd93020457e3c4ff02024ef202031e8d7f02030f42400204045a320a0201000400';
    $json['src'] = $url;
    $json['name'] = $content['vod_name'] ? $content['vod_name'] : $content['title'];
    $json['source'] = $content['vod_score'] ? $content['vod_score'] : $content['star'];
    $json['director'] = $content['vod_director'];
    $json['actor'] = $content['vod_actor']; 
    $json['area'] = $content['area']; 
    $json['esTags'] = $content['vod_class']; 
    $json['desc'] = $content['desc']; 
    $json['tuijian'] = $tuijian;      
    $json['jishu'] = $jishu;
    $json['juji'] = $juji;
    $json['site_title'] = $site_title;
    $json['ismember'] = $member['end_time'] > TIMESTAMP ? true : false;
    foreach ($play_list as $key => $value) {
       $newplay_list[] = $value;
    }
    $json['play_list'] = $newplay_list;
    result(0, 'success' ,$json);    
}
public function doPagenewsHistory() {
    global $_W, $_GPC;
    $member = $this->getuid();
    $uid = $member['uid'];
    $d_id = $_GPC['d_id']; 
    if (!$uid) {
        result(0, '请先登陆',-1);
    } 
    $op = $_GPC['op'] ? $_GPC['op'] : 'post'; 
    if ($op == 'list') {
        $list = pdo_getall('cyl_vip_video_history',array('uid'=>$uid,'uniacid'=>$_W['uniacid']),array(),'',array('time DESC'));
        result(0, 'success',$list);
    } 
    if ($op == 'del') {
        $list = pdo_delete('cyl_vip_video_history',array('uid'=>$uid,'uniacid'=>$_W['uniacid']));
        result(0, 'success',$list);
    }   
    if ($op == 'post') {
        if ($uid) {
            $data = pdo_get('cyl_vip_video_history',array('uid'=>$uid,'d_id'=>$d_id));
            if ($data) {
                pdo_update('cyl_vip_video_history', array('jishu'=>$_GPC['jishu'],'time'=>TIMESTAMP),array('id'=>$data['id']));
            }else{
                pdo_insert('cyl_vip_video_history', array('uid'=>$uid,'d_id'=>$d_id,'uniacid'=>$_W['uniacid'],'title'=>$_GPC['title'],'time'=>TIMESTAMP));
            }
        }    
    }   
       
}
public function doPageCollection() {
    global $_W, $_GPC;    
    $op = $_GPC['op'] ? $_GPC['op'] : 'list';
    $member = $this->getuid();   
    $uid = $member['uid'];
    if (!$uid) {
        result(0, '请先登陆',-1);
    } 
    if ($op == 'list') {
        $list = pdo_getall('cyl_vip_video_collection',array('uid'=>$uid,'uniacid'=>$_W['uniacid']),array(),'',array('id DESC'));
        result(0, 'success',$list);
    }
    if ($op == 'collection') {
        $d_id = $_GPC['d_id']; 
        $collection = pdo_get('cyl_vip_video_collection',array('uid'=>$uid,'d_id'=>$d_id));
        if ($collection) {
            $result = pdo_delete('cyl_vip_video_collection', array('id'=>$collection['id']));
            if (!empty($result)) {            
                result(0, '取消收藏',array('isCollection'=>0));
            }else{
                result(-1, '收藏失败');
            }
        }else{
            $result = pdo_insert('cyl_vip_video_collection', array('uid'=>$uid,'d_id'=>$d_id,'uniacid'=>$_W['uniacid'],'title'=>$_GPC['title']));
            if (!empty($result)) {            
                result(0, '收藏成功',array('isCollection'=>1));
            }else{
                result(-1, '收藏失败');
            }
        }    
    } 
    if ($op == 'del') {
        $id = $_GPC['id'];
        $list = pdo_delete('cyl_vip_video_collection',array('uid'=>$uid,'uniacid'=>$_W['uniacid'],'id'=>$id)); 
        result(0, '清空成功');
    } 
    if ($op == 'get') {
        $d_id = $_GPC['d_id'];
        $collection = pdo_get('cyl_vip_video_collection',array('uid'=>$uid,'d_id'=>$d_id)); 
        result(0, '清空成功',$collection);
    }               
}
public function doPageMember() {
    global $_W, $_GPC; 
    $member = $this->getuid();        
    $data['avatarUrl'] = $member['avatar'] ? $member['avatar'] : $_W['uniaccount']['logo'];
    $data['nickName'] = $member['nickname'] ? $member['nickname'] : $member['mobile'];
    $data['member'] = $member;
    $data['uid'] = $member['uid'];
    $data['credit1'] = $member['credit1'];
    $data['end_time'] = date('Y-m-d H:i:s',$member['end_time']);
    $cyl_vip_video_history = pdo_get('cyl_vip_video_history',array('uid'=>$data['uid']),array('COUNT(*) AS count'));
    $data['historynum'] = $cyl_vip_video_history['count'];
    $cyl_vip_video_collection = pdo_get('cyl_vip_video_collection',array('uid'=>$data['uid']),array('COUNT(*) AS count'));
    $data['collectionnum'] = $cyl_vip_video_collection['count'];
    result(0, 'success' ,$data);    
}
public function doPageOrder() {
    global $_W, $_GPC; 
    $member = $this->getuid(); 
    if (!$member['openid']) {
        result(-1, '未登陆'); 
    }      
    $data = array(
        'uniacid' => $_W['uniacid'],
        'openid' => $member['openid'],
    );
    $list = pdo_getall('cyl_vip_video_order', $data, array() , '' , 'id DESC'); 
    foreach ($list as $key => $value) {
        $list[$key] = array(
            'fee' => $value['fee'],
            'time' => date('Y-m-d H:i:s',$value['time']),
            'status' => $value['status'] ? '已支付' : '未支付',
            'day' => $value['day'],
        );
    }
    result(0, 'success' ,$list);    
}
public function doPageCard() {
    global $_W, $_GPC; 
    $acc = WeAccount::create(); 
    $member = $this->getuid();
    $uid = $member['uid'];               
    $data = array(
        'uniacid' => $_W['uniacid'],
        'pwd' => trim($_GPC['card']),                  
    );
    $card = pdo_get('cyl_vip_video_keyword_id', $data, array() , '' , 'id DESC');
    if (!$card) {
        result(0, '兑换码无效','error');  
    }elseif ($card['status']) {
        result(0, '兑换码已使用','error');   
    }else{
        $res = pdo_update('cyl_vip_video_keyword_id', array('status'=>1,'openid'=>$member['openid']), array('id'=>$card['id']));                    
        if($res){
            if ($member['openid']) {
                if ($member['end_time']) { 
                    pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$card['day']." days",$member['end_time'])), array('id' => $member['id'],'uniacid'=>$data['uniacid']));
                    $time = date('Y-m-d H:i:s',strtotime("+".$card['day']." days",$member['end_time']));
                }else{                      
                    pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$card['day']." days")), array('id' => $member['id'],'uniacid'=>$data['uniacid']));
                    $time = date('Y-m-d H:i:s',strtotime("+".$card['day']." days"));
                }
            } 
            if($settings['tpl_id']) {
                $data = array(
                    'first' => array(
                        'value' => '您好,'.$member['nickname'].'开通了'.$card['day'].'天会员',
                        'color' => '#ff510'
                    ) ,
                    'keyword1' => array(
                        'value' => '会员开通',
                        'color' => '#ff510'
                    ) ,
                    'keyword2' => array(
                        'value' => '开通提醒',
                        'color' => '#ff510'
                    ) ,                    
                    'remark' => array(
                        'value' => '卡密兑换'.$card['day'].'天,到期时间'.$time,
                        'color' => '#ff510'
                    ) ,
                );
                $url = link_url('member');
                $acc->sendTplNotice($member['openid'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
                $data = array(
                    'first' => array(
                        'value' => $member['nickname'].'开通了'.$card['day'].'天会员',
                        'color' => '#ff510'
                    ) ,
                    'keyword1' => array(
                        'value' => '会员开通',
                        'color' => '#ff510'
                    ) ,
                    'keyword2' => array(
                        'value' => '开通提醒',
                        'color' => '#ff510'
                    ) ,                    
                    'remark' => array(
                        'value' => '卡密兑换'.$card['day'].'天，到期时间'.$time.'请进入后台查看',
                        'color' => '#ff510'
                    ) ,
                );                  
                $acc->sendTplNotice($settings['kf_id'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
            }
            $data = array(
                'uniacid' => $_W['uniacid'],
                'openid' => $member['openid'],
                'uid' => $uid,
                'tid' => '卡密兑换',
                'fee' => '',                
                'status' => 1,
                'day' => $card['day'],
                'time' => TIMESTAMP
            );                  
            pdo_insert('cyl_vip_video_order',$data);
            $member = $this->getuid();
            result(0, '兑换成功',$member);
        }
    }  
}
public function doPageOpen(){
	global $_W, $_GPC; 
	$settings = $this->module['config']; 
    $acc = WeAccount::create(); 
    $member = $this->getuid();
    $uid = $member['uid'];             
	$credit = mc_credit_fetch($member['uid']);
	$card = iunserializer($settings['card']); 
	$card = $card[$_GPC['key']];
    $day = $card['day'];
    $fee = $card['card_fee'];
    $day = $card['card_day'];
    $jifen = $card['card_credit'];
    $fee = $jifen;                      
    if (!$card) {
        result(-1, '非法操作');
    }
    if ($fee > $credit['credit1']) {
        result(-1,'积分不足');
    }
    if (empty($fee)) {
        message('管理员未设置积分，请使用微信支付兑换','','error');
    }
    $data = array(
        'uniacid' => $_W['uniacid'],
        'openid' => $member['openid'],
        'uid' => $member['uid'],
        'tid' => '积分兑换',
        'fee' => $fee,              
        'status' => 1,
        'day' => $day,
        'time' => TIMESTAMP
    );           
    pdo_insert('cyl_vip_video_order',$data);
    mc_credit_update($member['uid'], 'credit1', -$fee, array($member['uid'], '视频会员开通-'.$fee.'积分','super_mov'));
    if ($member['openid']) {
        if ($member['end_time']) { 
            pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days",$member['end_time'])), array('id' => $member['id'],'uniacid'=>$data['uniacid']));
            $time = date('Y-m-d H:i:s',strtotime("+".$day." days",$member['end_time']));
        }else{                      
            pdo_update('cyl_vip_video_member', array('is_pay'=>1,'end_time'=>strtotime("+".$day." days")), array('id' => $member['id'],'uniacid'=>$data['uniacid']));
            $time = date('Y-m-d H:i:s',strtotime("+".$day." days"));
        } 
    }
    if($settings['tpl_id']) {
        $data = array(
                'first' => array(
                    'value' => '您好,'.$member['nickname'],
                    'color' => '#ff510'
                ) ,
                'keyword1' => array(
                    'value' => $params['tid'],
                    'color' => '#ff510'
                ) ,
                'keyword2' => array(
                    'value' => '支付成功',
                    'color' => '#ff510'
                ) ,   
                'keyword3' => array(
                    'value' => date('Y-m-d H:i:s',TIMESTAMP),
                    'color' => '#ff510'
                ) ,    
                'keyword4' => array(
                    'value' => $_W['uniaccount']['name'],
                    'color' => '#ff510'
                ) ,  
                'keyword5' => array(
                    'value' => $fee.'积分',
                    'color' => '#ff510'
                ) ,              
                'remark' => array(
                    'value' => '到期时间：'.$time.'',
                    'color' => '#ff510'
                ) ,
            ); 
            $url = link_url('member');
            $acc->sendTplNotice($data['openid'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');
            $data = array(
                'first' => array(
                    'value' => $member['nickname'].'开通了'.$day.'天会员',
                    'color' => '#ff510'
                ) ,
                'keyword1' => array(
                    'value' => $params['tid'],
                    'color' => '#ff510'
                ) ,
                'keyword2' => array(
                    'value' => '支付成功',
                    'color' => '#ff510'
                ) ,   
                'keyword3' => array(
                    'value' => date('Y-m-d H:i:s',TIMESTAMP),
                    'color' => '#ff510'
                ) ,    
                'keyword4' => array(
                    'value' => $_W['uniaccount']['name'],
                    'color' => '#ff510'
                ) ,  
                'keyword5' => array(
                    'value' => $fee.'积分',
                    'color' => '#ff510'
                ) ,              
                'remark' => array(
                    'value' => '会员到期时间'.$time.'请进入后台查看',
                    'color' => '#ff510'
                ) ,
            );
            $acc->sendTplNotice($settings['kf_id'], $settings['tpl_id'], $data, $url, $topcolor = '#FF683F');   
        
    }
    $member = $this->getuid();
    $member['end_time'] = date('Y-m-d H:i:s',$member['end_time']);
    result(0, '兑换成功',$member);
}
public function doPageWeixin() {
    global $_W, $_GPC;  
    $setting = setting();   
    $site_name = $setting['member']; 
    $settings = $this->module['config'];  
    if ($setting['member']['card']) {
        $settings['card'] = $setting['member']['card'];
        $settings['pay_settings'] = 1;
        $settingss = iunserializer($site_name['setting']);
        $settings['site_title'] = $settingss['site_title'];
        $settings['copyright'] = $settingss['copyright'];
    } 
    $member = $this->getuid();
    $uid = $member['uid'];             
    $credit = mc_credit_fetch($member['uid']);
    $card = iunserializer($settings['card']);     
    if ($setting['member']['card']) {
        $card = iunserializer($setting['member']['card']);
        $card = $card['card'];
    }
    $card = $card[$_GPC['key']];
    $day = $card['day'];
    $fee = $card['card_fee'];
    $day = $card['card_day'];
    $jifen = $card['card_credit'];
    $amount = $fee;                      
    if (!$card) {
        result(-1, '非法操作');
    }
    $id = $_GPC['id'];  
    $video_id = $_GPC['video_id'];  
    if (is_weixin()) {
       if(empty($member['openid'])){message('非法进入');}  
    }    
    if ($id) {
        $order = pdo_fetch("SELECT * FROM " . tablename('cyl_vip_video_order') . " WHERE id = :id", array(':id' => $id));
        if ($member['openid'] != $order['openid']) {
            result(-1, '非法进入');
        }
        $day = $order['day'];
        $snid = $order['tid'];
        $amount = $order['fee'];     
    }else{
        $snid = date('YmdHis') . str_pad(mt_rand(1, 99999),6, '0', STR_PAD_LEFT);
    }   
    if ($_GPC['type'] == 'shang') {
        $amount = $_GPC['fee']; 
    }
    if ($_GPC['type'] == 'charge') { 
        $video = pdo_get('cyl_vip_video_manage',array('id'=>$video_id));
        $amount = $video['charge']; 
    }
    if($amount < 0.01) {
        result(-1, '支付错误, 金额小于0.01'); 
    }        
    if ($_GPC['type'] == 'shang') {        
        
        $data = array(
            'uniacid' => $_W['uniacid'],
            'openid' => $member['openid'],
            'uid' => $member['uid'],
            'tid' => $snid,
            'fee' => $amount,               
            'status' => 0,
            'day' => $day,      
            'time' => TIMESTAMP
        );
        $data['desc'] = '视频打赏';
        $title = '视频打赏';
    }elseif ($_GPC['type'] == 'charge') { 
        $data = array(
            'uniacid' => $_W['uniacid'],
            'openid' => $member['openid'],
            'uid' => $member['uid'],
            'tid' => $snid,
            'fee' => $amount,               
            'video_id' => $video_id,               
            'status' => 0,
            'time' => TIMESTAMP
        );
        $data['desc'] = '视频收费';
        $title = '视频收费';
    }else{
        $data = array(
            'uniacid' => $_W['uniacid'],
            'openid' => $member['openid'],
            'uid' => $member['uid'],
            'tid' => $snid,
            'fee' => $amount,               
            'status' => 0,
            'day' => $day,      
            'time' => TIMESTAMP
        );
        $title = '会员开通';
    }
    if ($setting['member']['site_name']) {
           $data['site_name'] = $setting['member']['site_name']; 
    }
    if ($id) {
        pdo_update('cyl_vip_video_order',$data,array('id'=>$id));
    }else{
        pdo_insert('cyl_vip_video_order',$data);
        $id = pdo_insertid();
    }
    $params = array(
        'id' => $id,
        'tid' => $snid,      //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码20位
        'ordersn' => $snid,  //收银台中显示的订单号
        'title' => $title,          //收银台中显示的标题
        'fee' => $amount,      //收银台中显示需要支付的金额,只能大于 0
        'user' => $member['uid'],     //付款用户, 付款的用户名(选填项) 
    );
    if ($settings['payment'] == 4) {
        $this->codepay($params);
    }elseif ($settings['payment'] == 2) {
        $data = array(
            'mchid'        => $settings['appkey'],
            'body'         => $title,
            'total_fee'    => $amount * 100,
            'out_trade_no' => $snid,
            'hide' => 1, 
            'notify_url'=> $_W['siteroot'] . 'app/index.php?i='.$_W['uniacid'].'&c=entry&do=jspay&m=super_mov',
            'callback_url'=> $_W['siteroot'] . 'app/index.php?i='.$_W['uniacid'].'&c=entry&tid='.$id.'&do=jspayreturn&m=super_mov',
        );
        $key = $settings['secret_key'];
        $data['sign'] = sign($data, $key); 
        $url = 'https://payjs.cn/api/cashier?' . http_build_query($data);
        header("Location:".$url);  
        // exit();
        // $result = ihttp_post($url, $data);
        // $result = json_decode($result['content'],true);
        // $this->pay($result);
    }else{
        $this->pay($params);
    }
    exit(); 
}
protected function pay($params = array() , $mine = array()) {
    global $_W;
    $settings = $this->module['config'];
    $params['module'] = $this->module['name'];
    $sql = 'SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid';
    $pars = array();
    $pars[':uniacid'] = $_W['uniacid'];
    $pars[':module'] = $params['module'];
    $pars[':tid'] = $params['tid'];
    $log = pdo_fetch($sql, $pars);
    if(!empty($log) && $log['status'] == '1') {
        result(-1,'这个订单已经支付成功, 不需要重复支付.');
    }
    $setting = uni_setting($_W['uniacid'], array('payment', 'creditbehaviors'));
    if(!is_array($setting['payment'])) {
        result(-1,'没有有效的支付方式, 请联系网站管理员.');
    }
    $log = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'module' => $params['module'], 'tid' => $params['tid']));
    if (empty($log)) {
        $log = array(
            'uniacid' => $_W['uniacid'],
            'acid' => $_W['acid'],
            'openid' => $_W['member']['uid'],
            'module' => $this->module['name'],              'tid' => $params['tid'],
            'fee' => $params['fee'],
            'card_fee' => $params['fee'],
            'status' => '0',
            'is_usecard' => '0',
        );
        pdo_insert('core_paylog', $log);
    } 
    $pay = $setting['payment'];
    foreach ($pay as &$value) {
        $value['switch'] = $value['pay_switch'];
    }    
    if (!is_weixin() && $settings['weixin_h5'] != 1 ) {  
        $pays = $params['fee']; //获取需要支付的价格
        #插入语句书写的地方
        $conf = $this->payconfig($params['tid'], $pays * 100, '会员开通');
        if (!$conf || $conf['return_code'] == 'FAIL')
            result(-1, '对不起，微信支付接口调用错误!' . $conf['return_msg']); 
          
        $conf['mweb_url'] = $conf['mweb_url'] . '&redirect_url=' . urlencode($this->wxpay['notify_url'].'&tid='.$params['tid'].'&order_id='.$params['id']); 
        $url = $conf['mweb_url']; 
    }else{
        unset($value);
        $pay['credit']['switch'] = false;
        $pay['delivery']['switch'] = false;     
        $url = url('mc/cash/wechat', array('params' => base64_encode(json_encode($params))));
        result(0,'即将跳转支付',$url); 
        exit();
    }
}
public function doPageRegister() {
    global $_W, $_GPC;  
    $openid = $_W['openid'];
    $sql = 'SELECT `uid` FROM ' . tablename('mc_members') . ' WHERE `uniacid`=:uniacid';
    $pars = array();
    $pars[':uniacid'] = $_W['acid'];
    $code = trim($_GPC['code']);        
    $username = trim($_GPC['username']);
    $password = trim($_GPC['password']);
    load()->model('utility');
    if (!code_verify($_W['uniacid'], $username, $password)) {
        result(-1,'验证码错误');
    } else {
        pdo_delete('uni_verifycode', array('receiver' => $username));
    }
    $type = 'mobile';
    $sql .= ' AND `mobile`=:mobile';
    $pars[':mobile'] = $username;
    $user = pdo_fetch($sql, $pars);
    if(!empty($_W['openid'])) {
        $fan = mc_fansinfo($_W['openid']);
        if (!empty($fan)) {
            $map_fans = $fan['tag'];
        }
        if (empty($map_fans) && isset($_SESSION['userinfo'])) {
            $map_fans = iunserializer(base64_decode($_SESSION['userinfo']));
        }
    }
    $default_groupid = pdo_fetchcolumn('SELECT groupid FROM ' .tablename('mc_groups') . ' WHERE uniacid = :uniacid AND isdefault = 1', array(':uniacid' => $_W['acid']));
    $data = array(
        'uniacid' => $_W['acid'],
        'salt' => random(8),
        'groupid' => $default_groupid, 
        'createtime' => TIMESTAMP,
    );     
    $data['mobile'] = $type == 'mobile' ? $username : '';
    if (!empty($password)) {
        $data['password'] = md5($password . $data['salt'] . $_W['config']['setting']['authkey']);
    }
    if (empty($type)) {
        $data['mobile'] = $username;
    }
    if(!empty($map_fans)) {
        $data['nickname'] = strip_emoji($map_fans['nickname']);
        $data['gender'] = $map_fans['sex'];
        $data['residecity'] = $map_fans['city'] ? $map_fans['city'] . '市' : '';
        $data['resideprovince'] = $map_fans['province'] ? $map_fans['province'] . '省' : '';
        $data['nationality'] = $map_fans['country'];
        $data['avatar'] = $map_fans['headimgurl'];
    }
    if(!empty($user)) {
        pdo_update('mc_members', $data,array('mobile' => $username));           
    }else{
        pdo_insert('mc_members', $data);
        $user['uid'] = pdo_insertid();          
    }
    pdo_insert('cyl_video_sessions', array('sid' => $_W['session_id'], 'uniacid' => $_W['acid'], 'uid' => $user['uid']));

    $phone = $data['mobile'];
    $member = pdo_get('cyl_vip_video_member', array('phone'=>$phone,'uniacid'=>$_W['uniacid']));
    $data = array(
        'uniacid' => $_W['uniacid'],
        'phone' => $phone,
        'uid' => $user['uid'],
        'time' => TIMESTAMP, 
        'old_time' => TIMESTAMP,
        'password' => md5($_GPC['password']),
        'openid' => $phone,
    );
    if (is_weixin() && $_W['oauth_account']['level'] == 4) {
        $data['openid'] = $_W['openid'];
    }        
    if($member) {
        $res = pdo_update('cyl_vip_video_member', $data,array('id'=>$member['id'])); 
    }else{
        $res = pdo_insert('cyl_vip_video_member', $data);
    }            
    isetcookie('phone',$phone,3600*24*24);
    if (!empty($fan) && !empty($fan['fanid'])) {
        pdo_update('mc_mapping_fans', array('uid'=>$user['uid']), array('fanid'=>$fan['fanid'])); 
    }
    if($user['uid']) {
        result(0 ,'登陆成功！',array('sessionid' => $_W['session_id'], 'userinfo' => $user, 'openid' => $username));        
    } 
    result(0, 'success' ,$data);    
}
public function doPageSms() {
    global $_GPC, $_W;
    load()->model('utility');
    pdo_delete('uni_verifycode', array('createtime <' => TIMESTAMP - 1800)); 
    $receiver = trim($_GPC['receiver']);
    $verifycode_table = table('uni_verifycode');

    $row = $verifycode_table->getByReceiverVerifycode($_W['uniacid'], $receiver, ''); 
    $record = array();
    $code = random(6, true);

    if(!empty($row)) {
        $failed_count = table('uni_verifycode')->getFailedCountByReceiver($receiver);
        if($row['total'] >= 5) {
            result(-1, '您的操作过于频繁,请稍后再试');
        }
        $record['total'] = $row['total'] + 1;
    } else {
        $record['uniacid'] = $_W['uniacid'];
        $record['receiver'] = $receiver;
        $record['total'] = 1;
    }
    $record['verifycode'] = $code;
    $record['createtime'] = TIMESTAMP;
    if(!empty($row)) {
        pdo_update('uni_verifycode', $record, array('id' => $row['id']));
    } else {
        pdo_insert('uni_verifycode', $record);
    }
    $res = sendsms($receiver,$code);
    $res = json_decode($res,true);
    if($res['errmsg'] == 'OK'){ 
        result(0, 'success',$res);   
    }else{
        result(-1, $res['Message']);
    }           
}
public function doPageClearStorage() {
    global $_W, $_GPC;  
    $member = $this->getuid();     
    $result = pdo_delete('cyl_video_sessions', array('uid'=>$member['uid']));
    result(0, 'success');    
}
public function doPageOpenid(){
    global $_W, $_GPC;
    load()->model('mc');
    $oauth = $_GPC['userInfo'];
    $openid = $_GPC['openid'];
    if (empty($openid) && !empty($_W['openid'])) {
        $openid = $_W['openid'];
    }
    if (!empty($openid)) {
        $fans = mc_fansinfo($openid,$_W['acid']);
        if (!empty($fans)) {
            result(0, '', array('sessionid' => $_W['session_id'], 'userinfo' => $fans));
        } else {
            result(1, 'openid不存在');
        }
    }
    $oauth = array(
        'openid' => $_GPC['openid1'], 
        'unionid' => $_GPC['unionid'], 
    );     
    if (!empty($oauth) && !is_error($oauth)) {
        $fans = mc_fansinfo($oauth['openid'],$_W['acid']);        
        if (empty($fans)) {
            $record = array(
                'openid' => $oauth['openid'],
                'unionid' => $oauth['unionid'],
                'uid' => 0,
                'acid' => $_W['acid'],
                'uniacid' => $_W['acid'],
                'salt' => random(8),
                'updatetime' => TIMESTAMP,
                'nickname' => '',
                'follow' => '1',
                'followtime' => TIMESTAMP,
                'unfollowtime' => 0,
                'tag' => '',
            );
            $email = md5($oauth['openid']).'@we7.cc';
            $email_exists_member = pdo_getcolumn('mc_members', array('email' => $email, 'uniacid' => $_W['acid']), 'uid');
            if (!empty($email_exists_member)) {
                $uid = $email_exists_member;
            } else {
                $default_groupid = pdo_fetchcolumn('SELECT groupid FROM ' .tablename('mc_groups') . ' WHERE uniacid = :uniacid AND isdefault = 1', array(':uniacid' => $_W['acid']));
                $data = array(
                    'uniacid' => $_W['acid'],
                    'email' => $email,
                    'salt' => random(8),
                    'groupid' => $default_groupid,
                    'createtime' => TIMESTAMP,
                    'password' => md5($message['from'] . $data['salt'] . $_W['config']['setting']['authkey']),
                    'nickname' => '',
                    'avatar' => '',
                    'gender' => '',
                    'nationality' => '',
                    'resideprovince' => '',
                    'residecity' => '',
                );
                pdo_insert('mc_members', $data);
                $uid = pdo_insertid();
            }
            $record['uid'] = $uid;
            $_SESSION['uid'] = $uid;
            pdo_insert('mc_mapping_fans', $record);
        } else {
            $userinfo = $fans['tag'];
            $uid = $fans['uid'];
        }
        if (empty($userinfo)) {
            $userinfo = array(
                'openid' => $oauth['openid'],
            );
        }
        result(0, '', array('sessionid' => $_W['session_id'], 'userinfo' => $fans, 'openid' => $oauth['openid']));
    } else {
        result(1, $oauth['errMsg']);
    }
}
public function doPageUserinfo() {
    global $_W, $_GPC;  
    load()->model('mc');      
    $userinfo = array(
        'openId' => $_GPC['openId'], 
        'nickName' => $_GPC['nickName'], 
        'gender' => $_GPC['gender'], 
        'city' => $_GPC['city'], 
        'province' => $_GPC['province'], 
        'avatarUrl' => $_GPC['avatarUrl'], 
        'unionId' => $_GPC['unionid'], 
    );
    $userinfo['nickname'] = $userinfo['nickName'];
    $_SESSION['userinfo'] = base64_encode(iserializer($userinfo));
    $fans = mc_fansinfo($userinfo['openId']);
    $fans_update = array(
        'nickname' => $userinfo['nickName'],
        'unionid' => $userinfo['unionId'],
        'tag' => base64_encode(iserializer(array(
            'subscribe' => 1,
            'openid' => $userinfo['openId'],
            'nickname' => $userinfo['nickName'],
            'sex' => $userinfo['gender'],
            'language' => $userinfo['language'],
            'city' => $userinfo['city'],
            'province' => $userinfo['province'],
            'country' => $userinfo['country'],
            'headimgurl' => $userinfo['avatarUrl'],
        ))),
    );
    if (!empty($userinfo['unionId'])) {
        $union_fans = pdo_get('mc_mapping_fans', array('unionid' => $userinfo['unionId'], 'openid !=' => $userinfo['openId']));        
        if (!empty($union_fans['uid'])) {
            $fans_update['uid'] = $union_fans['uid'];           
        }else{
             $fans_update['uid'] = $fans['uid'];      
        }
    }
    
    
    $member = mc_fetch_one($fans['uid'],$_W['acid']);     
    if (!empty($member)) {
        pdo_update('mc_members', array('nickname' => $userinfo['nickName'], 'avatar' => $userinfo['avatarUrl'], 'gender' => $userinfo['gender']), array('uid' => $fans['uid']));
    }    
    pdo_update('mc_mapping_fans', $fans_update, array('fanid' => $fans['fanid']));
    pdo_insert('cyl_video_sessions', array('sid' => $_W['session_id'], 'uniacid' => $_W['acid'], 'uid' => $fans_update['uid']));
    unset($member['password']);
    unset($member['salt']);
    result(0, '', $member);
}
}