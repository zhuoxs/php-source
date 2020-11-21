<?php
/**
 * 便利店模块处理程序
 *
 * @author Gorden
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
include IA_ROOT . "/addons/super_mov/model.php";
function getShort($url){
    $url='http://api.t.sina.com.cn/short_url/shorten.json?source=31641035&url_long='.$url;
    $result=ihttp_get($url);
    $result = json_decode($result['content'],true);
    return $result;
}
class Super_movModuleProcessor extends WeModuleProcessor{
    public function respond(){
    	global $_W, $_GPC;
    	$settings = $this->module['config'];
    	$content = $this->message['content'];
    	$modules_bindings = pdo_get('modules_bindings', array('do' => 'index','module'=>'super_mov')); 
    	$rule = pdo_get('rule_keyword', array('uniacid' => $_W['uniacid'],'module'=>'super_mov'));
    	if (!$this->inContext){    		
			$content = str_replace($rule['content'], "", $content);
			if ($content) {				
					$where = ' WHERE uniacid = :uniacid '; 			
					$where .= ' AND title LIKE :title ';
					$params[':uniacid'] = $_W['uniacid'];	
					$params[':title'] = "%".$content."%";				
					$sql = ' SELECT * FROM '.tablename('cyl_vip_video_manage').$where.' ORDER BY id DESC ';			
					$search = pdo_fetchall($sql, $params, 'id');
					foreach ($search as $key => &$value) {
						$value['z_id'] = $value['id'];
					}
					if ($settings['ziyuan'] == 1 || $settings['ziyuan'] == 3) { 
			            $url = m3u8();
                        $ip = $_SERVER['SERVER_ADDR'] ? $_SERVER['SERVER_ADDR'] : $_SERVER['REMOTE_ADDR']; 
                		$url = $url . "?ziyuan=".$settings['ziyuan']."&ip=".$ip."&key=".$content;
			            $response = ihttp_get($url); 
			            $list = json_decode($response['content'],true);
			            $list = array_merge($search,$list);  
			        }elseif ($settings['ziyuan'] == 2) { 
			            $list = mac_list(array('key'=>$content));   
			            $list = array_merge($search,$list); 
			        }else{ 	
						$list1 = caiji_list($content);
						foreach ($list1 as $key => &$value) {
							if ($value['link'] && strexists($value['btn'],'立即播放')) {
								$list[] = $value;
							}elseif (!strexists($value['type'],'电影') && $value['link']) {
								$list[] = $value;
							}
						}
						$list = array_merge($search,$list); 						

					}
			}
			if (empty($list)) {
				$content = '未搜索到您要看的视频，请输入<<'.$rule['content'].'>>,后边加上您要搜索视频名称即可，例如：'.$rule['content'].'火影';
				return $this->respText($content);	
			}
		    // $news = array();
		    $i = 1;			    
	        foreach ($list as $key=>$item) {
	        	if (!strexists($settings['screen_name'], $item['title'])) {
		        	if (strexists($item['type'],'动漫')) { 
		        		$op = 'dongman';
		        	}elseif (strexists($item['type'],'电视剧')) {
		        		$op = 'dianshi';
		        	}elseif (strexists($item['type'],'综艺')) {
		        		$op = 'zongyi';
		        	}else{
		        		$op = 'dianying';
		        	}
		        	if($settings['ziyuan'] == 1 || $settings['ziyuan'] == 3){
						  if($data['type'] == 4){
						  	$op = 'dongman';
						  }elseif($data['type'] == 2){
						  	$op = 'dianshi';
						  }elseif($data['type'] == 3){
						  	$op = 'zongyi';
						  }else{
						 	$op = 'dianying';
						  }
						  if ($i <= 10) { 
							  $title = $item['title'];
							  if ($item['z_id']) {
							  	$url1 = link_url('index',array('mov'=>'detail','op'=>$op,'url'=>$item['link'],'id'=>$item['z_id'],'guanzhu'=>1),$settings['search_site']); 
							  }else{
							  	$url1 = link_url('index',array('mov'=>'detail','op'=>$op,'url'=>$item['link'],'d_id'=>$item['id'],'guanzhu'=>1),$settings['search_site']);
							  }
							  $url = getShort($url1);
							  $news .= $title . "：" . "<a href='".$url1."'>".$url['0']['url_short']."</a>"."\r\n"; 
							  // $news .= '点击链接即可观看，请关注我们公众号：'.$_W['uniaccount']['account'];
							} 
							$i++; 
					}elseif($settings['ziyuan'] == 2){ 						 
						  if ($i <= 10) { 
							  $title = $item['title'];
							  if ($item['z_id']) {
							  	$url1 = link_url('index',array('mov'=>'detail','op'=>$op,'url'=>$item['link'],'id'=>$item['z_id'],'guanzhu'=>1),$settings['search_site']);
							  }else{
							  	$url1 = link_url('index',array('mov'=>'detail','op'=>$op,'url'=>$item['link'],'d_id'=>$item['id'],'guanzhu'=>1),$settings['search_site']);
							  }
							  $url = getShort($url1);
							  $news .= $title . "：" . "<a href='".$url1."'>".$url['0']['url_short']."</a>"."\r\n"; 
							  // $news .= '点击链接即可观看，请关注我们公众号：'.$_W['uniaccount']['account'];
							} 
							$i++;
					}else{ 
			        	if ($item['title'] ) {
			        		if ($i <= 10) { 
							  $title = strip_tags($item['type'].$item['title']);
							  $url1 = $settings['search_site'] ? link_url('index',array('mov'=>'detail','op'=>$op,'url'=>$item['link'],'id'=>$item['id'],'guanzhu'=>1),$settings['search_site']) : link_url('index',array('mov'=>'detail','op'=>$op,'url'=>$item['link'],'id'=>$item['id'],'guanzhu'=>1));
							  $url = getShort($url1);
							  $news .= $title . "：" . "<a href='".$url1."'>".$url['0']['url_short']."</a>"."\r\n"; 							  
							} 							
			        		$i++;   
			        	}
			        }
	        	} 
	        }    	
	        $news .= '点击链接即可观看，搜索更多视频请在网页内搜索'."\r\n";	
	        $news .= '请关注我们公众号：'.$_W['uniaccount']['account'];	
	        $this->endContext();	 
    	}
        return $this->respText($news);
    }
}