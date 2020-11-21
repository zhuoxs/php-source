<?php
/**
 * 万能门店小程序模块小程序接口定义
 *
 * @author 懒人源码
 * @url www.lanrenzhijia.com
 */
defined('IN_IA') or exit('Access Denied');
define("HTTPSHOST",$_W['attachurl']);
define("ROOT_PATH",IA_ROOT.'/addons/sudu8_page/');
class Sudu8_pageModuleWxapp extends WeModuleWxapp {
	public function doPagehomepage(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$res = pdo_fetch("SELECT homepage FROM ".tablename('sudu8_page_base')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		$diypageset = pdo_fetch("SELECT foot_is FROM ".tablename('sudu8_page_diypageset')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		$pageid = pdo_fetch("SELECT id FROM ".tablename('sudu8_page_diypage')." WHERE uniacid = :uniacid and `index` = 1" , array(':uniacid' => $uniacid));
		if($diypageset){
			$res['foot_is'] = $diypageset['foot_is'];
		}else{
			$res['foot_is'] = 1;
		}
		if($pageid){
			$res['pageid'] = $pageid['id'];
		}else{
			$res['pageid'] = 0;
		}
		return $this->result(0, 'success', $res);
	}
	public function doPagegetfoot(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$foot = $_GPC['foot'];
		if($foot==1){
			$baseInfo = pdo_fetch("SELECT tabnum,color_bar,tabbar_bg,tabbar_tc,tabbar_tca,tabbar,tabbar_t FROM ".tablename('sudu8_page_base')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
			$baseInfo['tabbar'] =unserialize($baseInfo['tabbar']);
			for ($i=0; $i<=4; $i++) {
				$baseInfo['tabbar'][$i] = unserialize($baseInfo['tabbar'][$i]);
				if($baseInfo['tabbar'][$i]){
					if(strpos($baseInfo['tabbar'][$i]['tabbar_linktype'],"tel") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if($baseInfo['tabbar'][$i]['tabbar_linktype']=="map"){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if($baseInfo['tabbar'][$i]['tabbar_linktype']=="web"){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "web";
					}
					if($baseInfo['tabbar'][$i]['tabbar_linktype']=="server"){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "server";
					}

					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/showArt/showArt") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/showPic/showPic") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/showPro/showPro") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/showProMore/showProMore") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/showPro_lv/showPro_lv") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/listPic/listPic") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/listPro/listPro") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_sign/index/index") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_sign/new/new") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_sign/ranking/ranking") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_pt/orderlist/orderlist") !==false){
							$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/about/about") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}

					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_food/food/food") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}

					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_pt/index/index") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_exchange/list/list") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_exchange/order/order") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
			
					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/index/index") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/book/book") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/coupon/coupon") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/shoppay/shoppay") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/store/store") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
					if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/usercenter/usercenter") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
					}
				}
				if(is_numeric($baseInfo['tabbar'][$i]['tabbar_l'])){
					$cate_type = pdo_fetch("SELECT id,type,list_type FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid,':id' => $baseInfo['tabbar'][$i]['tabbar_l']));
	                if( $cate_type['type'] == "page"){
	                	$baseInfo['tabbar'][$i]['type']= 'page';
	                }
	                if($cate_type['list_type'] == 0 && $cate_type['type'] != "page"){
	                	$baseInfo['tabbar'][$i]['type']= 'listCate';
	                }elseif($cate_type['list_type'] == 1 && $cate_type['type'] != "page"){
	                	$baseInfo['tabbar'][$i]['type']= 'list'.substr($cate_type['type'],4,strlen($cate_type['type']));
	                }
				}
				if($baseInfo['tabbar'][$i]['tabbar_l'] == "webpage"){
					$baseInfo['tabbar'][$i]['tabbar_url']= urlencode($baseInfo['tabbar'][$i]['tabbar_url']);
				}
			}
			$baseInfo['color_bar'] = "1px solid ".$baseInfo['color_bar'];
			return $this->result(0, 'success', $baseInfo);
		}else{
		    $sql = "SELECT * FROM ".tablename('sudu8_page_diypage')." WHERE `index` = 1 and uniacid = {$uniacid}";
		    $data = pdo_fetch($sql);
	        if($data['items'] != ''){
		        $data['items'] = unserialize($data['items']);
		        foreach($data['items'] as $k => &$v){
		        	if($v['id'] == "footmenu"){
		        		$count = count($v['data']);
		        		$res['count'] = $count;
		        		$res['params'] = $v['params'];
		        		$res['style'] = $v['style'];
		        		$res['data'] = $v['data'];

		        		$text_is = $v['params']['textshow'];
		        		if($text_is==1){
		        			$res['footmenuh'] = $v['style']['paddingleft']*2 +$v['style']['textfont']+$v['style']['paddingtop']*2+ $v['style']['iconfont']+1;
		        			$res['foottext'] = 1;
		        		}else{
		        			$res['footmenuh'] = $v['style']['paddingtop']*2+ $v['style']['iconfont']+1;
		        			$res['foottext'] = 0;
		        		}
		        		$res['footmenu'] = 1;
		        	}
		        }
	        }
			return $this->result(0, 'success', $res);
		}
	}
	public function doPageBaseMin(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$baseInfo = pdo_fetch("SELECT name,base_tcolor,base_color,base_color2,base_color_t,color_bar,tel,longitude,latitude,copyright,copyimg,tel_b,uniacid,tabbar_bg,tabbar_tc,tabbar_tca,tabbar_t,tabbar,tabnum,config,address,copy_do FROM ".tablename('sudu8_page_base')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		$config = unserialize($baseInfo['config']);
		$baseInfo['commA'] =$config['commA'];
		$baseInfo['commAs'] =$config['commAs'];
		$baseInfo['commP'] =$config['commP'];
		$baseInfo['commPs'] =$config['commPs'];
		$baseInfo['serverBtn'] =$config['serverBtn'];
		if($baseInfo['serverBtn']!=0){
			$baseInfo['serverBtn']=1;
		}
		if($baseInfo['copyimg']){
			if(stristr($baseInfo['copyimg'], 'http')){
				$baseInfo['copyimg']= $baseInfo['copyimg'];
			}else{
				$baseInfo['copyimg']= HTTPSHOST.$baseInfo['copyimg'];
			}
		}
		$baseInfo['tabbar'] =unserialize($baseInfo['tabbar']);
		for ($i=0; $i<=4; $i++) {
			$baseInfo['tabbar'][$i] = unserialize($baseInfo['tabbar'][$i]);
			if($baseInfo['tabbar'][$i]){
				if(strpos($baseInfo['tabbar'][$i]['tabbar_linktype'],"tel") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if($baseInfo['tabbar'][$i]['tabbar_linktype']=="map"){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if($baseInfo['tabbar'][$i]['tabbar_linktype']=="web"){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "web";
				}
				if($baseInfo['tabbar'][$i]['tabbar_linktype']=="server"){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "server";
				}

				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/showArt/showArt") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/showPic/showPic") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/showPro/showPro") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/showProMore/showProMore") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/showPro_lv/showPro_lv") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/listPic/listPic") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/listPro/listPro") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_sign/index/index") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_sign/new/new") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_sign/ranking/ranking") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_pt/orderlist/orderlist") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/about/about") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}

				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_food/food/food") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}

				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_pt/index/index") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_exchange/list/list") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_exchange/order/order") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
		
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/index/index") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/book/book") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/coupon/coupon") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/shoppay/shoppay") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/store/store") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/usercenter/usercenter") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
			}
			if(is_numeric($baseInfo['tabbar'][$i]['tabbar_l'])){
				$cate_type = pdo_fetch("SELECT id,type,list_type FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid,':id' => $baseInfo['tabbar'][$i]['tabbar_l']));
                if( $cate_type['type'] == "page"){
                	$baseInfo['tabbar'][$i]['type']= 'page';
                }
                if($cate_type['list_type'] == 0 && $cate_type['type'] != "page"){
                	$baseInfo['tabbar'][$i]['type']= 'listCate';
                }elseif($cate_type['list_type'] == 1 && $cate_type['type'] != "page"){
                	$baseInfo['tabbar'][$i]['type']= 'list'.substr($cate_type['type'],4,strlen($cate_type['type']));
                }
			}
			if($baseInfo['tabbar'][$i]['tabbar_l'] == "webpage"){
				$baseInfo['tabbar'][$i]['tabbar_url']= urlencode($baseInfo['tabbar'][$i]['tabbar_url']);
			}
		}
		$baseInfo['color_bar'] = "1px solid ".$baseInfo['color_bar'];
		return $this->result(0, 'success', $baseInfo);
	}
	public function doPageBase(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$fxsid = $_GPC['fxsid'];
		$baseInfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_base')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		$baseInfo['ot'] = pdo_fetch("SELECT forms_name FROM ".tablename('sudu8_page_forms_config')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		if($baseInfo['ot']['forms_name'] == ""){
			$baseInfo['ot']['forms_name'] = "在线预约";
		}
		//展开新版广告的配置参数
		$config = unserialize($baseInfo['config']);
		$baseInfo['bigadT'] =$config['bigadT'];
		$baseInfo['bigadC'] =$config['bigadC'];
		$baseInfo['bigadCTC'] =intval($config['bigadCTC']);
		$baseInfo['bigadCNN'] =$config['bigadCNN'];
		$baseInfo['miniadT'] =$config['miniadT'];
		$baseInfo['newhead'] =$config['newhead'];
		$baseInfo['search'] =$config['search'];
		$baseInfo['copT'] =$config['copT'];
		$baseInfo['userFood'] =$config['userFood'];
		$baseInfo['commA'] =$config['commA'];
		$baseInfo['commAs'] =$config['commAs'];
		$baseInfo['commP'] =$config['commP'];
		$baseInfo['commPs'] =$config['commPs'];
		$baseInfo['serverBtn'] =$config['serverBtn'];
		$baseInfo['duomerchants'] =$config['duomerchants'];
		//背景图
		if($baseInfo['banner']){
			if(stristr($baseInfo['banner'], 'http')){
				$baseInfo['banner'] = $baseInfo['banner'];
			}else{
				$baseInfo['banner'] =  HTTPSHOST.$baseInfo['banner'];
			}
		}
		//老幻灯片
		if($baseInfo['index_style'] =="slide"){
			$baseInfo['slide'] = unserialize($baseInfo['slide']);
			$num = count($baseInfo['slide']);
			$slide = array();
			$slide = $baseInfo['slide'];
			$baseInfo['slide'] = array();
			for($i = 0; $i < $num; $i++){
				if(stristr($slide[$i], 'http')){
					$baseInfo['slide'][$i] = $slide[$i];
				}else{
	  				$baseInfo['slide'][$i] = HTTPSHOST.$slide[$i];
				}
			}
		}
		//新幻灯片
		if($baseInfo['index_style'] =="newslide"){
			$slide = pdo_fetchall("SELECT pic,url FROM ".tablename('sudu8_page_banner')." WHERE uniacid = :uniacid and type = 'banner' ORDER BY num DESC,id DESC"  , array(':uniacid' => $uniacid));
			$num = count($slide);
			$baseInfo['slide'] = array();
			for($i = 0; $i < $num; $i++){
				if(stristr($slide[$i]['pic'], 'http')){
	  				$baseInfo['slide'][$i]['pic'] = $slide[$i]['pic'];
				}else{
	  				$baseInfo['slide'][$i]['pic'] = HTTPSHOST.$slide[$i]['pic'];
				}
	  			$baseInfo['slide'][$i]['url'] = $slide[$i]['url'];

			}
			
			//var_dump($baseInfo['slide']);
		}
		//开屏广告
		if($config['bigadT'] =="1"){
			$slide = pdo_fetchall("SELECT pic FROM ".tablename('sudu8_page_banner')." WHERE uniacid = :uniacid and type = 'bigad' and flag = 1 ORDER BY num DESC,id DESC"  , array(':uniacid' => $uniacid));
			$num = count($slide);
			$baseInfo['bigad'] = array();
			for($i = 0; $i < $num; $i++){
				if(stristr($slide[$i]['pic'], 'http')){
	  				$baseInfo['bigad'][$i] = $slide[$i]['pic'];
				}else{
	  				$baseInfo['bigad'][$i] = HTTPSHOST.$slide[$i]['pic'];
				}
			}
		}
		if($config['bigadT'] =="2"){
			$slide = pdo_fetchall("SELECT pic,url FROM ".tablename('sudu8_page_banner')." WHERE uniacid = :uniacid and type = 'bigad' and flag = 1 ORDER BY num DESC,id DESC"  , array(':uniacid' => $uniacid));
			$num = count($slide);
			$baseInfo['bigad'] = array();
			for($i = 0; $i < $num; $i++){
				if(stristr($slide[$i]['pic'], 'http')){
	  				$baseInfo['bigad'][$i]['pic'] = $slide[$i]['pic'];
				}else{
	  				$baseInfo['bigad'][$i]['pic'] = HTTPSHOST.$slide[$i]['pic'];
				}
				$baseInfo['bigad'][$i]['url'] = $slide[$i]['url'];
			}
		}
		//弹窗广告
		if($config['miniadT'] =="1" || $config['miniadT'] =="2"){
			$slide = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_banner')." WHERE uniacid = :uniacid and type = 'miniad' and flag = 1  ORDER BY num DESC,id DESC"  , array(':uniacid' => $uniacid));
			$num = count($slide);
			$baseInfo['miniad'] = array();
			for($i = 0; $i < $num; $i++){
				$baseInfo['miniad'][$i] = array();
				if(stristr($slide[$i]['pic'], 'http')){
	  				$baseInfo['miniad'][$i]['pic'] = $slide[$i]['pic'];
				}else{
	  				$baseInfo['miniad'][$i]['pic'] = HTTPSHOST.$slide[$i]['pic'];
				}
	  			$baseInfo['miniad'][$i]['descp'] = $slide[$i]['descp'];
	  			$baseInfo['miniad'][$i]['url'] = $slide[$i]['url'];
			}
			$baseInfo['miniadN'] = $config['miniadN'];
			$baseInfo['miniadB'] = $config['miniadB'];
		}
		//logo
		if(stristr($baseInfo['logo'], 'http')){
			$baseInfo['logo'] = $baseInfo['logo'];
		}else{
			$baseInfo['logo'] = HTTPSHOST.$baseInfo['logo'];
		}
		if(stristr($baseInfo['logo2'], 'http')){
			$baseInfo['logo2'] = $baseInfo['logo2'];
		}else{
			$baseInfo['logo2'] = HTTPSHOST.$baseInfo['logo2'];
		}
		if($baseInfo['copyimg']){
			if(stristr($baseInfo['copyimg'], 'http')){
				$baseInfo['copyimg']= $baseInfo['copyimg'];
			}else{
				$baseInfo['copyimg']= HTTPSHOST.$baseInfo['copyimg'];
			}
		}
		//视频
		if($baseInfo['video']){
			include 'videoInfo.php';
            $videoInfo = new videoInfo();  
            $videodata=$videoInfo->getVideoInfo($baseInfo['video']);  
	        $baseInfo['video'] = $videodata['url'];
		}
		if($baseInfo['v_img']){
			if(stristr($baseInfo['v_img'], 'http')){
				$baseInfo['v_img'] = $baseInfo['v_img'];
			}else{
				$baseInfo['v_img'] = HTTPSHOST.$baseInfo['v_img'];
			}
		}
		if($baseInfo['c_b_bg']){
			if(stristr($baseInfo['c_b_bg'], 'http')){
				$baseInfo['c_b_bg'] = $baseInfo['c_b_bg'];
			}else{
				$baseInfo['c_b_bg'] = HTTPSHOST.$baseInfo['c_b_bg'];
			}
		}
		$baseInfo['tabbar'] =unserialize($baseInfo['tabbar']);
		for ($i=0; $i<=4; $i++) {
			$baseInfo['tabbar'][$i] = unserialize($baseInfo['tabbar'][$i]);
			if($baseInfo['tabbar'][$i]){
				if(strpos($baseInfo['tabbar'][$i]['tabbar_linktype'],"tel") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if($baseInfo['tabbar'][$i]['tabbar_linktype']=="map"){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if($baseInfo['tabbar'][$i]['tabbar_linktype']=="web"){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "web";
				}
				if($baseInfo['tabbar'][$i]['tabbar_linktype']=="server"){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "server";
				}

				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/showArt/showArt") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/showPic/showPic") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/showPro/showPro") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/showProMore/showProMore") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/showPro_lv/showPro_lv") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/listPic/listPic") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/listPro/listPro") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_sign/index/index") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_sign/new/new") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_sign/ranking/ranking") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_pt/orderlist/orderlist") !==false){
						$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/about/about") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}

				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_food/food/food") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}

				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_pt/index/index") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_exchange/list/list") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page_plugin_exchange/order/order") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
		
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/index/index") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/book/book") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/coupon/coupon") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/shoppay/shoppay") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/store/store") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
				if(strpos($baseInfo['tabbar'][$i]['tabbar_url'],"/sudu8_page/usercenter/usercenter") !==false){
					$baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
				}
			}

			if(is_numeric($baseInfo['tabbar'][$i]['tabbar_l'])){
				$cate_type = pdo_fetch("SELECT id,type,list_type FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid,':id' => $baseInfo['tabbar'][$i]['tabbar_l']));
                if( $cate_type['type'] == "page"){
                	$baseInfo['tabbar'][$i]['type']= 'page';
                }
                if( $cate_type['type'] == "coupon"){
                	$baseInfo['tabbar'][$i]['type']= 'coupon';
                }
                if($cate_type['list_type'] == 0 && $cate_type['type'] != "page"){
                	$baseInfo['tabbar'][$i]['type']= 'listCate';
                }elseif($cate_type['list_type'] == 1 && $cate_type['type'] != "page"){
                	$baseInfo['tabbar'][$i]['type']= 'list'.substr($cate_type['type'],4,strlen($cate_type['type']));
                }
			}
			if($baseInfo['tabbar'][$i]['tabbar_l'] == "webpage"){
				$baseInfo['tabbar'][$i]['tabbar_url']= urlencode($baseInfo['tabbar'][$i]['tabbar_url']);
			}
		}
		$baseInfo['color_bar'] = "1px solid ".$baseInfo['color_bar'];
		/*
		//是否开启分销，是否为首次点击绑定
		$fxType = pdo_fetch("SELECT fx_cj,sxj_gx FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		//判断是否开启分销&&存在分销商openid&&首次点击绑定，都满足继续绑定
		if($fxType['fx_cj'] != 4 && $fxType['sxj_gx'] == 1 && $fxsid){
			//判断是有上级，没有的话继续绑定
			$fxParent = pdo_fetch("SELECT parent_id FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $uniacid));
			//判断之前是否绑定分销商，没有则继续
			if($fxParent['parent_id'] == ""){
				// 分销商的关系[1.绑定上下级关系 ]
				$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
				//获取该小程序的分销关系绑定规则
				$guiz = pdo_fetch("SELECT fx_cj,sxj_gx,uniacid FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
				$fxsid = $_GPC['fxsid'];
				// 1.先进行上下级关系绑定[判断是不是首次下单]
				if($guiz['sxj_gx']==1 && $userinfo['parent_id'] == '0' && $fxsid != '0' && $userinfo['fxs'] !=2){
					$fxsinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $fxsid ,':uniacid' => $_W['uniacid']));
					$p_fxs = $fxsinfo['parent_id'];  //分销商的上级
					$p_p_fxs = $fxsinfo['p_parent_id']; //分销商的上上级
					// 判断启用几级分销 
					$fx_cj = $guiz['fx_cj'];
					// 分别做判断
					if($fx_cj == 1){
						$uuser = pdo_update("sudu8_page_user",array("parent_id"=>$fxsid),array("openid"=>$openid,'uniacid' => $_W['uniacid']));
					}
					if($fx_cj == 2){
						$uuser = pdo_update("sudu8_page_user",array("parent_id"=>$fxsid,"p_parent_id"=>$p_fxs),array("openid"=>$openid,'uniacid' => $_W['uniacid']));
					}
					if($fx_cj == 3){
						$uuser = pdo_update("sudu8_page_user",array("parent_id"=>$fxsid,"p_parent_id"=>$p_fxs,"p_p_parent_id"=>$p_p_fxs),array("openid"=>$openid,'uniacid' => $_W['uniacid']));
					}	
				}
			}
		}
		*/
	

      	
		return $this->result(0, 'success', $baseInfo);
	}
	public function doPagestorelist(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$store['catelist'] = pdo_fetchall("SELECT id,num,name FROM ".tablename('sudu8_page_shops_cate') ." WHERE uniacid = :uniacid and flag =1 order by num desc", array(':uniacid' => $uniacid));
		$tjnum = pdo_fetchcolumn("SELECT tjnum FROM ".tablename('sudu8_page_shops_set') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
		$store['storeHot'] =  pdo_fetchall("SELECT id,uniacid,name,logo,hot FROM ".tablename('sudu8_page_shops_shop')." WHERE uniacid = :uniacid and hot = 1 ORDER BY id DESC LIMIT 0,".$tjnum , array(':uniacid' => $uniacid));
		$num2 = count($store['storeHot']);
		for($i = 0; $i < $num2; $i++){
			if(stristr($store['storeHot'][$i]['logo'], 'http')){
				$store['storeHot'][$i]['logo'] = $store['storeHot'][$i]['logo'];
			}else{
				$store['storeHot'][$i]['logo'] = HTTPSHOST.$store['storeHot'][$i]['logo']; 
			}
		}
		return $this->result(0, 'success', $store);
	}
	public function doPageAppbase(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$code = $_GPC['code'];
		$app = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		$appid = $app['key'];
		$appsecret = $app['secret'];
		$url = "https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$appsecret."&js_code=".$code."&grant_type=authorization_code";
		$weixin = file_get_contents($url);
		$jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
		$array = get_object_vars($jsondecode);//转换成数组
		$openid = $array['openid'];//输出openid
		if($openid){
			$data = array(
	    		"uniacid" => $uniacid,
				"openid" => $openid,
				"createtime" => time()
	    	);
	    	//var_dump($data);
			//1.判断openid是否存在于数据库
    		$user = pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_user')." WHERE openid = :id and uniacid = :uniacid" , array(':id' => $openid ,':uniacid' => $_W['uniacid']));
    		if($user['n']==0){
	    		pdo_insert('sudu8_page_user', $data);
	    		return $this->result(0, 'success', $data);
	    	}else{
	    		return $this->result(0, 'success', $data);
	    	}
		}else{
			var_dump($weixin);
		}
	}
	public function doPageUseupdate(){ 
		global $_GPC, $_W;
		$uniacid = $_W['uniacid']; 
		$openid =  $_GPC['openid'];
		$user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :id and uniacid = :uniacid" , array(':id' => $openid ,':uniacid' => $_W['uniacid']));
		$data = array(
    		"uniacid" => $uniacid,
    		"openid" => $_GPC['openid'],
    		"createtime" => time(),
			"nickname" => $_GPC['nickname'],
			"avatar" => $_GPC['avatarUrl'],
			"gender" => $_GPC['gender'],
			"resideprovince" => $_GPC['province'], 
	    	"residecity" => $_GPC['city'],
	    	"nationality" => $_GPC['country'] 
    	);
		if($user){
			pdo_update('sudu8_page_user', $data, array('openid' => $openid ,'uniacid' => $uniacid));
		}else{
			pdo_insert('sudu8_page_user', $data);
		}
		// 新增返回个人信息
		$newuserinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :id and uniacid = :uniacid" , array(':id' => $openid ,':uniacid' => $_W['uniacid']));
		$parent_id = $newuserinfo['parent_id'];
		if($parent_id != '0'){
			$tjr = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :id and uniacid = :uniacid" , array(':id' => $parent_id ,':uniacid' => $_W['uniacid']));
			if($tjr['fxs']==2){
				$newuserinfo['tjr'] = $tjr['realname'];
			}else{
				$newuserinfo['tjr'] = "您是由平台方推荐";
			}
		}else{
			$newuserinfo['tjr'] = "您是由平台方推荐";
		}
		return $this->result(0, 'success', $newuserinfo);
	}
	/*多栏目开始*/
	public function doPagechangelist(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid']; 
		$cid = $_GPC['cid']?$_GPC['cid']:'0';
		$multi_id = $_GPC['multi_id'];
		if($cid == '0'){
            $sql = "SELECT * FROM ".tablename('sudu8_page_products')." WHERE multi = 1 AND top_catas != '' AND `mulitcataid` = {$multi_id}";
            $data['pro_list'] = pdo_fetchall($sql);
	        $num = count($data['pro_list']);
			for($i = 0; $i < $num; $i++){
				if(stristr($data['pro_list'][$i]['thumb'], 'http')){
	  				$data['pro_list'][$i]['thumb'] = $data['pro_list'][$i]['thumb'];
				}else{
	  				$data['pro_list'][$i]['thumb'] = HTTPSHOST.$data['pro_list'][$i]['thumb'];
				}
			}
            return json_encode($data);exit;
		}else{
		    $cid = explode(',',$cid);
		    $pid = $_GPC['pid']?explode('-',$_GPC['pid']):'';
		    $sql = "SELECT * FROM ".tablename('sudu8_page_products')." WHERE multi = 1 AND `mulitcataid` = {$multi_id}";
		    foreach ($cid as $k => $v){
		        if($v == 0){
		            $sql .= " AND find_in_set('".$pid[$k]."',top_catas)";
                }else{
		            $sql .= " AND find_in_set('".$v."',sons_catas)";
                }
            }
            $sql .= " AND top_catas != ''";
		    $data['pro_list'] = pdo_fetchall($sql);
	        $num = count($data['pro_list']);
			for($i = 0; $i < $num; $i++){
				if(stristr($data['pro_list'][$i]['thumb'], 'http')){
	  				$data['pro_list'][$i]['thumb'] = $data['pro_list'][$i]['thumb'];
				}else{
	  				$data['pro_list'][$i]['thumb'] = HTTPSHOST.$data['pro_list'][$i]['thumb'];
				}
			}
            return json_encode($data);exit;
		}
		return json_encode($data);
	}
	public function doPagelistArt_duo(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid']; 
		// $showArt = $_GPC['showArt'];
		$multi_id = $_GPC['multi_id'];
		$data['cate'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_multicate')." WHERE id = :id" , array(':id' => $multi_id));
		$cid = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_multicate')." WHERE id = :id" , array(':id' => $multi_id));
		$topcate = unserialize($cid['cid']);
        $sql = "SELECT * FROM ".tablename('sudu8_page_products')." WHERE multi = 1 AND top_catas != '' AND `mulitcataid` = {$multi_id}";
        $data['pro_list'] = pdo_fetchall($sql);
        $num = count($data['pro_list']);
		for($i = 0; $i < $num; $i++){
			if(stristr($data['pro_list'][$i]['thumb'], 'http')){
  				$data['pro_list'][$i]['thumb'] = $data['pro_list'][$i]['thumb'];
			}else{
  				$data['pro_list'][$i]['thumb'] = HTTPSHOST.$data['pro_list'][$i]['thumb'];
			}
		}
		$mlid = $_GPC['multi_id'];
		$sql = "SELECT `top_catas` FROM ".tablename('sudu8_page_multicate')." WHERE `id` = {$mlid}";
        $top_catas = pdo_fetch($sql);
        if($top_catas){
            $sql = "SELECT * FROM ".tablename('sudu8_page_multicates')." WHERE `id` IN (".$top_catas['top_catas'].")";
            $top_one = pdo_fetchall($sql);
            foreach ($top_one as $k => $v){
                $sql = "SELECT * FROM ".tablename('sudu8_page_multicates')." WHERE `pid` = {$v['id']}";
                $top_one[$k]['sons'] = pdo_fetchall($sql);
            }
            $data['topcate'] = $top_one;
        }
		return json_encode($data);
	}
	public function doPagegetcate(){
		global $_GPC, $_W;
		$multi_id = $_GPC['multi_id'];
		$cid = $_GPC['cid'];
		$subcate = pdo_fetchAll("SELECT id,name FROM ".tablename('sudu8_page_cate')." WHERE cid = :cid " , array(':cid' => $cid));
		return json_encode($subcate);
	}
	public function doPagegetkuaidi(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$id = $_GPC['id'];
		$proinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products') ." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid,':id' => $id));
		return $this->result(0, 'success', $proinfo['kuaidi']);
	}
	/*多栏目结束*/
	// 获取全局情况
	public function dopageglobaluserinfo(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid']; 
		$openid =  $_GPC['openid'];
		$newuserinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :id and uniacid = :uniacid" , array(':id' => $openid ,':uniacid' => $uniacid));
		$parent_id = $newuserinfo['parent_id'];
		if($parent_id != '0'){
			$tjr = pdo_fetch("SELECT openid,fxs FROM ".tablename('sudu8_page_user')." WHERE openid = :id and uniacid = :uniacid" , array(':id' => $parent_id ,':uniacid' => $uniacid));
			$tjrname = pdo_fetch("SELECT nickname FROM ".tablename('sudu8_page_user')." WHERE openid = :id and uniacid = :uniacid" , array(':id' => $tjr['openid'] ,':uniacid' => $uniacid));
			if($tjr['fxs']==2){
				$newuserinfo['tjr'] = $tjrname['nickname'];
			}else{
				$newuserinfo['tjr'] = "您是由平台方推荐";
			}
		}else{
			$newuserinfo['tjr'] = "您是由平台方推荐";
		}
		return $this->result(0, 'success', $newuserinfo);
	}
	//新增评价功能 18.02.22
	public function doPageComment(){
		include ROOT_PATH.'inc/pinglun.php';
	}
	//页面加载时获取文章id全部评论
	public function doPageGetComment(){
		include ROOT_PATH.'inc/pinglun1.php';
	}
	public function doPagecommentFollow(){
		include ROOT_PATH.'inc/pinglun2.php';
	}

  	
  	public function doPageselectShopList(){
     global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
      
        $option1 = $_GPC['option1'];
        $option2 = $_GPC['option2'];
        $option3 = $_GPC['option3'];
        $le = $_GPC['latitude'];
        $ne = $_GPC['longitude'];
        
        $sql = "select id,uniacid,name,logo,tel,address,(2 * 6378.137 * ASIN(SQRT(POW(SIN(PI()*(".$le."-latitude)/360),2)+COS(PI()*".$le."/180)* COS(latitude * PI()/180)*POW(SIN(PI()*(".$ne."-longitude)/360),2)))) as distance FROM  ".tablename('sudu8_page_shops_shop') ." WHERE uniacid = :uniacid and flag =1";

        $options = array(':uniacid' => $uniacid);

        if(!empty($option1) && ($option1 != '全部分类')){
            $cid = pdo_fetchcolumn("SELECT id FROM ".tablename('sudu8_page_shops_cate')." WHERE uniacid = :uniacid and flag = 1 and name = :name", array(':uniacid' => $uniacid, ':name' => $option1));
            $sql .= ' and cid like "%'.$cid.'%"';
            // $options[':cid'] = $cid;
       	}
        
        if($option3 == '优选商家'){
            $sql .= ' and hot = :hot';
            $options[':hot'] = 1;
        }
        
        if($option2 == '综合排序'){
            $sql .= ' order by star desc';
        }
        
        if($option2 == '距离最近'){
            $sql .= ' ORDER BY distance ASC';        
        }
       	$shop_size = pdo_fetchcolumn("SELECT num FROM ".tablename('sudu8_page_shops_set') . "WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
       	$sql .= ' LIMIT 0,'.$shop_size;
        $lists = pdo_fetchall($sql, $options);

        // var_dump($sql);
        // var_dump($options);
        foreach ($lists as $key => &$res) {
            $res['logo'] = HTTPSHOST.$res['logo'];
            $res['distance'] = $this->beautifyDistance($res['distance']);
        }
        
        return $this->result(0, 'success', $lists);
    }
  
    public function beautifyDistance($distance)
    {
        if ($distance < 1) {
         $distance = number_format(floatval($distance)*1000, 2);
            return "{$distance}m";
        } else {
            $d = number_format(floatval($distance), 2);
            return "{$d}km";
        }
    }
  	
	public function doPageAbout(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$aboutInfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_about')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		//老幻灯片
		if($aboutInfo['header'] =="2"){
			$slideAll = pdo_fetch("SELECT slide FROM ".tablename('sudu8_page_base')." WHERE uniacid = :uniacid"  , array(':uniacid' => $uniacid));
			$aboutInfo['slide'] = unserialize($slideAll['slide']);
			$num = count($aboutInfo['slide']);
			for($i = 0; $i < $num; $i++){
				if(stristr($aboutInfo['slide'][$i], 'http')){
					$aboutInfo['slide'][$i] = $aboutInfo['slide'][$i];
				}else{
					$aboutInfo['slide'][$i] = HTTPSHOST.$aboutInfo['slide'][$i]; 
				}
			}
		}
		//新幻灯片
		if($aboutInfo['header'] =="3"){
			$slide = pdo_fetchall("SELECT pic,url FROM ".tablename('sudu8_page_banner')." WHERE uniacid = :uniacid and type = 'banner' ORDER BY num DESC,id DESC"  , array(':uniacid' => $uniacid));
			$num = count($slide);
			$aboutInfo['slide'] = array();
			for($i = 0; $i < $num; $i++){
				if(stristr($slide[$i]['pic'], 'http')){
					$aboutInfo['slide'][$i]['pic'] = $slide[$i]['pic'];
				}else{
					$aboutInfo['slide'][$i]['pic'] =  HTTPSHOST.$slide[$i]['pic'];
				}
	  			$aboutInfo['slide'][$i]['url'] = $slide[$i]['url'];
			}
		}
		return $this->result(0, 'success', $aboutInfo);
	}
	public function doPageCommon(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$copyright = pdo_fetch("SELECT copyright,tel,tel_b,latitude,longitude,name,address FROM ".tablename('sudu8_page_base')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		return $this->result(0, 'success', $copyright);
	}
	public function doPageProducts(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$products = pdo_fetchall("SELECT id,type,num,title,thumb,`desc`,buy_type FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid ORDER BY num DESC,id DESC"  , array(':uniacid' => $uniacid));
		foreach ($products as  &$row){
			if(stristr($row['thumb'], 'http')){
				$row['thumb'] = $row['thumb'];
			}else{
				$row['thumb'] = HTTPSHOST.$row['thumb'];
			}
		}
		//var_dump($products);
		return $this->result(0, 'success', $products);
	}
	public function doPageProductsList(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$pindex = max(1, intval($_GPC['page']));
		$cateinfo = pdo_fetch("SELECT pagenum FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id = :cid" , array(':uniacid' => $uniacid,':cid' => $cid));
		$psize = $cateinfo['pagenum'];
		if(!$psize){
			$psize = 10;
		}
		$ProductsList = pdo_fetchall("SELECT id,type,num,title,thumb,`desc`,buy_type FROM ".tablename('sudu8_page_products')."WHERE uniacid = :uniacid ORDER BY num DESC,id DESC LIMIT ".($pindex - 1) * $psize.",".$psize , array(':uniacid' => $uniacid));
		foreach ($ProductsList as  &$row){
			if(stristr($row['thumb'], 'http')){
				$row['thumb'] = $row['thumb'];
			}else{
				$row['thumb'] = HTTPSHOST.$row['thumb'];
			}
		}
		return $this->result(0, 'success', $ProductsList);
	}
	public function doPageProductsDetail(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$openid = $_GPC['openid'];
		$ProductsDetail = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $id ,':uniacid' => $uniacid));
		if($ProductsDetail['shareimg']){
			if(stristr($ProductsDetail['shareimg'], 'http')){
				$ProductsDetail['thumbimg'] = $ProductsDetail['shareimg'];
			}else{
				$ProductsDetail['thumbimg'] = HTTPSHOST.$ProductsDetail['shareimg'];
			}
		}else{
			if(stristr($ProductsDetail['shareimg'], 'http')){
				$ProductsDetail['thumbimg'] = $ProductsDetail['thumb'];
			}else{
				$ProductsDetail['thumbimg'] = HTTPSHOST.$ProductsDetail['thumb'];
			}
		}
		if(!$ProductsDetail['price']){
			$ProductsDetail['price'] = 0;
		}
		if(intval($ProductsDetail['pro_flag'])>0){
			$ProductsDetail['navlist'] = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_art_navlist')." WHERE cid = :cid and uniacid = :uniacid and flag = 1 order by num desc" , array(':cid' => intval($ProductsDetail['pro_flag']) ,':uniacid' => $uniacid));
			$ProductsDetail['navlistnum'] = count($ProductsDetail['navlist']);
		}
		$data = array(
            'hits' => $ProductsDetail['hits'] + 1,
        );
		pdo_update('sudu8_page_products', $data, array('id' => $id ,'uniacid' => $uniacid));
		if($ProductsDetail['etime']){
			$ProductsDetail['etime'] = date("Y-m-d H:i:s",$ProductsDetail['etime']);
		}else{
			$ProductsDetail['etime'] = date("Y-m-d H:i:s",$ProductsDetail['ctime']);
		}
		$ProductsDetail['ctime'] = date("Y-m-d H:i:s",$ProductsDetail['ctime']);
		if($ProductsDetail['video']){
			include ROOT_PATH.'videoInfo.php';
            $videoInfo = new videoInfo();
            $videodata=$videoInfo->getVideoInfo($ProductsDetail['video']);
	        $ProductsDetail['video'] = $videodata['url'];
		}
		$videopay = 0;
        if($ProductsDetail['price']== 0){  //不需要付费直接可播放状态为1
        	$videopay = 1;
        }else{  //需要付费去查有没有付费记录
        	$videopayflag = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_video_pay')." WHERE openid = :openid and pid = :pid and uniacid = :uniacid" , array(':openid' => $openid, ':pid' => $id,':uniacid' => $uniacid));
        	//1.如果有支付的记录
        	if($videopayflag){
        		$videopay = 1;
        	}
        }
        $ProductsDetail['videopay'] = $videopay;
        if($ProductsDetail['labels']){
        	$ProductsDetail['labels'] = HTTPSHOST.$ProductsDetail['labels'];
        }else{
        	$ProductsDetail['thumb'] = HTTPSHOST.$ProductsDetail['thumb'];
        }
		$ProductsDetail['btn'] = pdo_fetch("SELECT pic_page_btn FROM ".tablename('sudu8_page_cate')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $ProductsDetail['cid'] ,':uniacid' => $uniacid));
		$cateConf = pdo_fetch("SELECT cateconf FROM ".tablename('sudu8_page_cate')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $ProductsDetail['cid'] ,':uniacid' => $uniacid));
		$cateConf = unserialize($cateConf['cateconf']);
		$ProductsDetail['pmarb'] = $cateConf['pmarb'];
		$ProductsDetail['ptit'] = $cateConf['ptit'];
		$formset = $ProductsDetail['formset'];
		if($formset!=0&&$formset!=""){
			$forms = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_formlist')." WHERE id = :id" , array(':id' => $formset));
			$forms2 = unserialize($forms['tp_text']);
			foreach($forms2 as $key=>&$res){
				if($res['tp_text']){
					$res['tp_text'] = explode(",", $res['tp_text']);
				}
				$res['val']='';
			}
		}else{
			$forms2 = "NULL";
		}
		$ProductsDetail['forms'] = $forms2;
		$likeArt = pdo_fetch("SELECT glnews FROM ".tablename('sudu8_page_products')." WHERE id = :id" , array(':id' => $id));
		if($likeArt){
			$likeArt = unserialize($likeArt['glnews']);
			$ProductsDetail['likeArtList'] = array();
			foreach($likeArt as $v)
			{
			  $likeArtArr = pdo_fetch("SELECT id,num,thumb,`desc`,title FROM ".tablename('sudu8_page_products')." WHERE id = :id" , array(':id' => $v));
			  $likeArtArr['thumb'] = HTTPSHOST.$likeArtArr['thumb'];
			  array_push($ProductsDetail['likeArtList'],$likeArtArr);
			}
		}
		return $this->result(0, 'success', $ProductsDetail);
	}
	//17.08.04 新增留言功能 sudu8//
	public function doPageFormsConfig(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$formsConfig = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_forms_config')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		$formsConfig['t5'] = unserialize($formsConfig['t5']);
		$formsConfig['t6'] = unserialize($formsConfig['t6']);
		$formsConfig['c2'] = unserialize($formsConfig['c2']);
		$formsConfig['s2'] = unserialize($formsConfig['s2']);
		$formsConfig['con2'] = unserialize($formsConfig['con2']);
		//老幻灯片
		if($formsConfig['forms_head'] =="slide"){
			$slideAll = pdo_fetch("SELECT slide FROM ".tablename('sudu8_page_base')." WHERE uniacid = :uniacid"  , array(':uniacid' => $uniacid));
			$formsConfig['slide'] = unserialize($slideAll['slide']);
			$num = count($formsConfig['slide']);
			for($i = 0; $i < $num; $i++){
	  			if(stristr($formsConfig['slide'][$i], 'http')){
					$formsConfig['slide'][$i] = $formsConfig['slide'][$i];
				}else{
					$formsConfig['slide'][$i] = HTTPSHOST.$formsConfig['slide'][$i];
				}
			}
		}
		//新幻灯片
		if($formsConfig['forms_head'] =="newslide"){
			$slide = pdo_fetchall("SELECT pic,url FROM ".tablename('sudu8_page_banner')." WHERE uniacid = :uniacid and type = 'banner' ORDER BY num DESC,id DESC"  , array(':uniacid' => $uniacid));
			$num = count($slide);
			$formsConfig['slide'] = array();
			for($i = 0; $i < $num; $i++){
				if(stristr($slide[$i]['pic'], 'http')){
	  				$formsConfig['slide'][$i]['pic'] = $slide[$i]['pic'];
				}else{
	  				$formsConfig['slide'][$i]['pic'] = HTTPSHOST.$slide[$i]['pic'];
				}
	  			$formsConfig['slide'][$i]['url'] = $slide[$i]['url'];
			}
			//var_dump($baseInfo['slide']);
		}
		//单选两个
		if(!empty($formsConfig['single_num']) and $formsConfig['single_num']!=0){
			$single_num = 100 / $formsConfig['single_num'];
			if($single_num>100 or $single_num<20){
				$formsConfig['single_num'] = 100;
			}else{
				$formsConfig['single_num'] = $single_num;
			}
		}else{
			$formsConfig['single_num'] = 100;
		}
		if(!empty($formsConfig['s2']['s2num']) and $formsConfig['s2']['s2num']!=0){
			$single_num2 = 100 / $formsConfig['s2']['s2num'];
			if($single_num2>100 or $single_num2<20){
				$formsConfig['s2']['s2num'] = 100;
			}else{
				$formsConfig['s2']['s2num'] = $single_num2;
			}
		}else{
			$formsConfig['s2']['s2num'] = 100;
		}
		//复选的
		if(!empty($formsConfig['checkbox_num']) and $formsConfig['checkbox_num']!=0){
			$checkbox_num = 100 / $formsConfig['checkbox_num'];
			if($checkbox_num>100 or $checkbox_num<20){
				$formsConfig['checkbox_num'] = 100;
			}else{
				$formsConfig['checkbox_num'] = $checkbox_num;
			}
		}else{
			$formsConfig['checkbox_num'] = 100;
		}
		if(!empty($formsConfig['c2']['c2num']) and $formsConfig['c2']['c2num']!=0){
			$checkbox_num2 = 100 / $formsConfig['c2']['c2num'];
			if($checkbox_num2>100 or $checkbox_num2<20){
				$formsConfig['c2']['c2num'] = 100;
			}else{
				$formsConfig['c2']['c2num'] = $checkbox_num2;
			}
		}else{
			$formsConfig['c2']['c2num'] = 100;
		}
		return $this->result(0, 'success', $formsConfig);
	}
	//表单提交
	public function doPageDiyForms(){
		require_once(IA_ROOT."/framework/library/phpmailer/class.phpmailer.php");
		require_once(IA_ROOT."/framework/library/phpmailer/class.smtp.php");
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$forms = stripslashes(html_entity_decode($_GPC['forminfo']));
		$forms = json_decode($forms,TRUE);
		$data['val'] = serialize($forms);
		$data['uniacid'] = $uniacid;
		$data['cid'] = $_GPC['formid'];
		$data['creattime'] = time();
		$result = pdo_insert('sudu8_page_formcon', $data);
		return $this->result(0, 'success', $result);
	}
	//表单提交
	public function doPageAddForms(){
		require_once(IA_ROOT."/framework/library/phpmailer/class.phpmailer.php");
		require_once(IA_ROOT."/framework/library/phpmailer/class.smtp.php");
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$formsConfig = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_forms_config')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		$formsConfig['t5'] = unserialize($formsConfig['t5']);
		$formsConfig['t6'] = unserialize($formsConfig['t6']);
		$formsConfig['c2'] = unserialize($formsConfig['c2']);
		$formsConfig['s2'] = unserialize($formsConfig['s2']);
		$formsConfig['con2'] = unserialize($formsConfig['con2']);
		$data = array(
                    'uniacid' => $_W['uniacid'],
                    'name' => $_GPC['name'],
                    'tel' => $_GPC['tel'],
                    'wechat' => $_GPC['wechat'],
                    'address' => $_GPC['address'],
                    'date' => $_GPC['date'],
                    'timef' => $_GPC['time'],
                    'single' => $_GPC['single'],
                    'checkbox' => $_GPC['checkbox'],
                    'content' => $_GPC['content'],
                    't5' => $_GPC['t5'],
                    't6' => $_GPC['t6'],
                    's2' => $_GPC['s2'],
                    'c2' => $_GPC['c2'],
                    'con2' => $_GPC['con2'],
                    'time' => TIMESTAMP
                );
		$result = pdo_insert('sudu8_page_forms', $data);
		if ($formsConfig['mail_user'] && $formsConfig['mail_sendto']){
			$mail_sendto = array();
			$mail_sendto =explode(",",$formsConfig['mail_sendto']);
			$row_mail_user = $formsConfig['mail_user'];
			$row_mail_pass = $formsConfig['mail_password'];
			$row_mail_name =$formsConfig['mail_user_name'];
			$row_name = $formsConfig['name']."： ".$_GPC['name']."<br />";
			if($formsConfig['tel_use']){
				$row_tel = $formsConfig['tel']."： ".$_GPC['tel']."<br />";
			}
			if($formsConfig['wechat_use']){
				$row_wechat = $formsConfig['wechat']."： ".$_GPC['wechat']."<br />";
			}
			if($formsConfig['address_use']){
				$row_address = $formsConfig['address']."： ".$_GPC['address']."<br />";
			}
			if($formsConfig['t5']['t5u']){
				$row_t5 = $formsConfig['t5']['t5n']."： ".$_GPC['t5']."<br />";
			}
			if($formsConfig['t6']['t6u']){
				$row_t6 = $formsConfig['t6']['t6n']."： ".$_GPC['t6']."<br />";
			}
			if($formsConfig['date_use']){
				$row_date = $formsConfig['date']."： ".$_GPC['date']."<br />";
			}
			if($formsConfig['time_use']){
				$row_time = $formsConfig['time']."： ".$_GPC['time']."<br />";
			}
			if($formsConfig['single_use']){
				$row_single = $formsConfig['single_n']."： ".$_GPC['single']."<br />";
			}
			if($formsConfig['s2']['s2u']){
				$row_s2 = $formsConfig['s2']['s2n']."： ".$_GPC['s2']."<br />";
			}
			if($formsConfig['checkbox_use']){
				$row_checkbox = $formsConfig['checkbox_n']."： ".$_GPC['checkbox']."<br />";
			}
			if($formsConfig['c2']['c2u']){
				$row_c2 = $formsConfig['c2']['c2n']."： ".$_GPC['c2']."<br />";
			}
			if($formsConfig['content_use']){
				$row_content = $formsConfig['content_n']."： ".$_GPC['content']."<br />";
			}
			if($formsConfig['con2']['con2u']){
				$row_con2 = $formsConfig['con2']['con2n']."： ".$_GPC['con2']."<br />";
			}
	 		$mail = new PHPMailer();
	        $mail->CharSet ="utf-8";
	        $mail->Encoding = "base64";
	        $mail->SMTPSecure = "ssl";
	        $mail->IsSMTP();
	        $mail->Port=465;
	        $mail->Host = "smtp.qq.com";
	        $mail->SMTPAuth = true;
	        $mail->SMTPDebug  = false;
	        $mail->Username = $row_mail_user;
	        $mail->Password = $row_mail_pass;
	        $mail->setFrom($row_mail_user,$row_mail_name);
			foreach($mail_sendto as $v)
			{
			  $mail->AddAddress($v);
			}
			$mail->Subject = date("m-d",time())." - ".$_GPC['name'];
			$mail->isHTML(true); 
			$mail->Body    = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>详细内容：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>".$row_name.$row_tel.$row_wechat.$row_address.$row_t5.$row_t6.$row_date.$row_time.$row_single.$row_s2.$row_checkbox.$row_c2.$row_content.$row_con2."<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>".$row_mail_name."</div></div>";
			if(!$mail->send()) {
			    $result = "send_err";
			} else {
			    $result = "send_ok";
			}
		}
		$applet = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		$appid = $applet['key'];
		$appsecret = $applet['secret'];
		if($applet)
		{
			$mid =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_message')." WHERE uniacid = :uniacid and flag=2" , array(':uniacid' => $_W['uniacid']));
			if($mid)
			{
				if($mid['mid']!="")
				{
					$mids = $mid['mid'];
					$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
					$a_token = $this->_requestGetcurl($url);
					if($a_token)
					{
						$url_m="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$a_token['access_token'];
						$formId=$_GPC['formid'];
						$ftitle=$formsConfig['forms_name'];
						$ftime=date('Y-m-d H:i:s',time());
						$fmsg=$formsConfig['success'];
						$openid=$_GPC['openid'];
						$furl = $mid['url'];
						$post_info = '{
								  "touser": "'.$openid.'",  
								  "template_id": "'.$mids.'", 
								  "page": "'.$furl.'",          
								  "form_id": "'.$formId.'",         
								  "data": {
								      "keyword1": {
								          "value": "'.$ftitle.'", 
								          "color": "#173177"
								      }, 
								      "keyword2": {
								          "value": "'.$ftime.'", 
								          "color": "#173177"
								      }, 
								      "keyword3": {
								          "value": "'.$fmsg.'", 
								          "color": "#173177"
								      } 
								  },
								  "emphasis_keyword": "keyword1.DATA" 
								}';
							$this->_requestPost($url_m,$post_info);
					}
				}
			}
		}
		return $this->result(0, 'success', $result);
	}
	public function doPageNav(){
		global $_GPC, $_W;
		$type = $_GPC['type'];
		$uniacid = $_W['uniacid'];
		$nav = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_nav')." WHERE uniacid = :uniacid and type = :type" , array(':uniacid' => $uniacid,':type' => $type));
		$nav['number'] = 100/$nav['number']  - $nav['box_p_lr']*2;
		if($nav['statue'] == 1){
			$nav_list =explode(",",$nav['url']);
			$nav['url']= array();
			foreach ($nav_list as $row){
	  			$cate_list = pdo_fetch("SELECT id,cid,catepic,name,name_n,type,list_type FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id = :id" , array(':uniacid' => $uniacid,':id' => $row));
	  			if($cate_list['type'] == 'page'){
	  				$cate_list['list_type'] = 'page';
	  			}else{
	  				if($cate_list['list_type'] == 0){
			  			$cate_list['list_type'] = 'listCate';
		  			}else if($cate_list['list_type'] == 1){
		  				if($cate_list['type']=='showPro'){
		  					$cate_list['list_type'] = 'listPro';
		  				}else{
		  					$cate_list['list_type'] = 'listPic';
		  				}
		  			}
	  			}
	  			if(empty($cate_list['name_n'])){
		  			$cate_list['name_n'] = $cate_list['name'];
	  			}
	  			if(stristr($cate_list['catepic'], 'http')){
	  				$cate_list['catepic'] = $cate_list['catepic'];
				}else{
					$cate_list['catepic'] = HTTPSHOST.$cate_list['catepic'];
				}
	  			array_push($nav['url'],$cate_list);
			}
		}elseif($nav['statue'] == 2){
			$nav['url'] = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_navlist')." WHERE uniacid = :uniacid  and flag = 1 ORDER BY num DESC,id DESC" , array(':uniacid' => $uniacid));
			foreach ($nav['url'] as &$row){
				if($row['type'] == 5){
					$row['url']=urlencode($row['url']);
				}
				if(stristr($row['pic'], 'http')){
	  				$row['pic'] = $row['pic'];
				}else{
	  				$row['pic'] = HTTPSHOST.$row['pic'];
				}
			}
		}else{
		}
		return $this->result(0, 'success', $nav);
	}
	public function doPageindexCop(){
		global $_GPC, $_W;
		$type = $_GPC['type'];
		$uniacid = $_W['uniacid'];
		$now = time();
		//var_dump($now);
		$indexCopAll = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE (etime > ".$now." or etime =0) and uniacid = :uniacid  and flag = 1 ORDER BY num DESC,id DESC" , array(':uniacid' => $uniacid));
		$indexCopOne = $indexCopAll['0'];
		if($indexCopOne){
			if($indexCopOne['btime']){
				$indexCopOne['btime'] = date("Y-m-d",$indexCopOne['btime']);
			}
			if($indexCopOne['etime']){
				$indexCopOne['etime'] = date("Y-m-d",$indexCopOne['etime']);
			}
		}
		return $this->result(0, 'success', $indexCopOne);
	}
	//170820 首页推荐区块横排、竖排内容
	public function doPageIndex_hot(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$list_x = pdo_fetchall("SELECT id,type,num,title,thumb,`desc`,buy_type,is_more FROM ".tablename('sudu8_page_products')." WHERE type_x=1 and uniacid = :uniacid ORDER BY num DESC,id DESC"  , array(':uniacid' => $uniacid));
		foreach ($list_x as  &$row){
			if(stristr($row['thumb'], 'http')){
	  				$row['thumb'] = $row['thumb'];
				}else{
	  				$row['thumb'] = HTTPSHOST.$row['thumb'];
				}
			if($row['type']=="showPro" && $row['is_more'] == 1){
				$row['type'] = "showPro_lv";
			}
		} 
		// 获取最大推荐书
		$listConf = pdo_fetch("SELECT sptj_max,sptj_max_sp FROM ".tablename('sudu8_page_base')." WHERE uniacid = :uniacid "  , array(':uniacid' => $uniacid));
		$max_pt = $listConf['sptj_max'];
		$max_sp = $listConf['sptj_max_sp'];
		$list_y = pdo_fetchall("SELECT id,type,num,title,thumb,ctime,hits,`desc`,price,market_price,sale_num,buy_type,is_more FROM ".tablename('sudu8_page_products')." WHERE type_y=1 and flag = 1 and uniacid = :uniacid and (type = 'showArt' or type = 'showPic') ORDER BY num DESC,id DESC LIMIT 0 ," . $max_pt  , array(':uniacid' => $uniacid));
		foreach ($list_y as  &$row){
			if(stristr($row['thumb'], 'http')){
	  				$row['thumb'] = $row['thumb'];
				}else{
	  				$row['thumb'] = HTTPSHOST.$row['thumb'];
				}
			$row['ctime'] = date("y-m-d H:i:s",$row['ctime']);
			if($row['type']=="showPro" && $row['is_more'] == 1){
				$row['type'] = "showPro_lv";
			}
		}
		$list_y_sp = pdo_fetchall("SELECT id,type,num,title,thumb,ctime,hits,`desc`,price,market_price,sale_num,buy_type,is_more FROM ".tablename('sudu8_page_products')." WHERE type_y=1 and flag = 1 and uniacid = :uniacid and (type = 'showPro' or type = 'showProMore') ORDER BY num DESC,id DESC LIMIT 0 ," . $max_sp  , array(':uniacid' => $uniacid));
		foreach ($list_y_sp as  &$row){
			if(stristr($row['thumb'], 'http')){
	  				$row['thumb'] = $row['thumb'];
				}else{
	  				$row['thumb'] = HTTPSHOST.$row['thumb'];
				}
			$row['ctime'] = date("y-m-d H:i:s",$row['ctime']);
			if($row['type']=="showPro" && $row['is_more'] == 1){
				$row['type'] = "showPro_lv";
			}
		}
		$Index_hot= array();
		$Index_hot['list_x'] = $list_x;
		$Index_hot['list_y'] = $list_y;
		$Index_hot['list_y_sp'] = $list_y_sp;
		return $this->result(0, 'success', $Index_hot);
	}
	//首页推荐栏目
	public function doPageIndex_cate(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$index_cate = pdo_fetchall("SELECT id,cid,num,name,ename,type,list_type,list_style,list_tstyle,list_stylet FROM ".tablename('sudu8_page_cate')." WHERE cid=0 and uniacid = :uniacid and show_i = 1 and statue =1   ORDER BY num DESC,id DESC"  , array(':uniacid' => $uniacid));
		// echo "<pre>";
		// var_dump($index_cate);
		// echo "</pre>";
		// die();
		//一级分类循环
		foreach ($index_cate as  $key=>$row){
			$id = $row['id'];//一级栏目ID
			//var_dump($id);
			if(stristr($row['catepic'], 'http')){
	  				$row['catepic'] = $row['catepic'];
				}else{
	  				$row['catepic'] = HTTPSHOST.$row['catepic'];
				}
			//var_dump($row['type']);
			if($row['type'] == 'showPic' or  $row['type'] =='showArt'  or  $row['type'] =='showPro'){
				//var_dump($row['list_type']);
				if($row['list_type'] == 0){//展示子栏目，获取子栏目的内容 栏目标题等
					$index_cate[$key]['l_type'] = 'listCate';
					$index_cate[$key]['list']= array();//一级栏目list数组
					$index_cate[$key]['list'] = pdo_fetchall("SELECT id,cid,num,name,ename,catepic,cdesc,list_style,list_tstyle,type FROM ".tablename('sudu8_page_cate')." WHERE cid=:cid and uniacid = :uniacid and statue =1 ORDER BY num DESC,id DESC"  , array(':uniacid' => $uniacid,':cid' => $id));//写入一级栏目list数组
					//var_dump($index_cate[$key]['list']);
					foreach ($index_cate[$key]['list'] as  $key2=>$row2){
						if ($index_cate[$key]['list'][$key2]['type'] == 'showPro') {
							$index_cate[$key]['list'][$key2]['type'] = 'listPro';
						}else{
							$index_cate[$key]['list'][$key2]['type'] = 'listPic';
						}
						if(stristr($row2['catepic'], 'http')){
			  				$index_cate[$key]['list'][$key2]['catepic'] = $row2['catepic'];
						}else{
			  				$index_cate[$key]['list'][$key2]['catepic'] = HTTPSHOST.$row2['catepic'];
						}
					}
					//var_dump($index_cate[$key]['list']);
					//var_dump("aaaa");
				}else if($row['list_type'] == 1){//展示栏目内容，获取文章标题等
					if($index_cate[$key]['type']=='showPro'){
	  					$index_cate[$key]['l_type'] = 'listPro';
	  				}else{
	  					$index_cate[$key]['l_type'] = 'listPic';
	  				}
					$index_cate[$key]['list']= array();//一级栏目list数组
					//$index_cate[$key]['list'] = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_products')." WHERE  pcid= :pcid and flag = 1 and uniacid = :uniacid and type_i = 1 ORDER BY num DESC,id DESC"  , array(':uniacid' => $uniacid,':pcid'=> $id));//写入一级栏目list数组
					$index_cate[$key]['list'] = pdo_fetchall("SELECT id,num,type_i,title,thumb,hits,type,ctime,`desc`,price,market_price,sale_num,is_more,buy_type,sale_tnum FROM ".tablename('sudu8_page_products')." WHERE  pcid= :pcid and flag = 1 and uniacid = :uniacid and type_i = 1 ORDER BY num DESC,id DESC"  , array(':uniacid' => $uniacid,':pcid'=> $id));//写入一级栏目list数组
					// if($row['type'] =='showPro'){
					// 	$duo_list = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products')." WHERE  pcid= :pcid and flag = 1 and uniacid = :uniacid and type_i = 1 ORDER BY num DESC,id DESC"  , array(':uniacid' => $uniacid,':pcid'=> $id));//写入一级栏目list数组
					// 	foreach ($duo_list as $key3 => $reb) {
					// 		$reb['type'] = "showProMore";
					// 		array_push($index_cate[$key]['list'] , $reb);
					// 	}
					// }
					foreach ($index_cate[$key]['list'] as  $key2=>$row2){
						$index_cate[$key]['list'][$key2]['ctime'] = date("y-m-d H:i:s",$index_cate[$key]['list'][$key2]['ctime']);
						if(stristr($row2['thumb'], 'http')){
			  				$index_cate[$key]['list'][$key2]['thumb'] = $row2['thumb'];
						}else{
			  				$index_cate[$key]['list'][$key2]['thumb'] = HTTPSHOST.$row2['thumb'];
						}
						$index_cate[$key]['list'][$key2]['sale_num'] = intval($index_cate[$key]['list'][$key2]['sale_num']) + intval($index_cate[$key]['list'][$key2]['sale_tnum']);
						if($row2['is_more']==1 && $row2['type']=='showPro'){
							$index_cate[$key]['list'][$key2]['type'] = 'showPro_lv';
						}
					}
					//var_dump($index_cate[$key]['list']);
					//var_dump("bbbb");
				}
			}else if($row['type'] == 'showWxapps'){
				//var_dump($row['list_type']);
				if($row['list_type'] == 0){//展示子栏目，获取子栏目的内容 栏目标题等
					$index_cate[$key]['l_type'] = 'listCate';
					$index_cate[$key]['list']= array();//一级栏目list数组
					$index_cate[$key]['list'] = pdo_fetchall("SELECT id,cid,num,name,ename,catepic,cdesc,list_style,list_tstyle FROM ".tablename('sudu8_page_cate')." WHERE cid=:cid and uniacid = :uniacid and statue =1 ORDER BY num DESC,id DESC"  , array(':uniacid' => $uniacid,':cid' => $id));//写入一级栏目list数组
					//var_dump($index_cate[$key]['list']);
					foreach ($index_cate[$key]['list'] as  $key2=>$row2){
						if(stristr($row2['catepic'], 'http')){
			  				$index_cate[$key]['list'][$key2]['catepic'] = $row2['catepic'];
						}else{
			  				$index_cate[$key]['list'][$key2]['catepic'] = HTTPSHOST.$row2['catepic'];
						}
					}
					//var_dump($index_cate[$key]['list']);
				}else if($row['list_type'] == 1){//展示栏目内容，获取文章标题等
					$index_cate[$key]['l_type'] = 'listPic';
					$index_cate[$key]['list']= array();//一级栏目list数组
					$index_cate[$key]['list'] = pdo_fetchall("SELECT id,num,title,type,thumb,appId,path,`desc` FROM ".tablename('sudu8_page_wxapps')." WHERE  pcid= :pcid and uniacid = :uniacid and type_i = 1 ORDER BY num DESC,id DESC"  , array(':uniacid' => $uniacid,':pcid'=> $id));//写入一级栏目list数组
					//var_dump($index_cate[$key]['list']);
					foreach ($index_cate[$key]['list'] as  $key2=>$row2){
						if(stristr($row2['thumb'], 'http')){
			  				$index_cate[$key]['list'][$key2]['thumb'] = $row2['thumb'];
						}else{
			  				$index_cate[$key]['list'][$key2]['thumb'] = HTTPSHOST.$row2['thumb'];
						}
					}
					//var_dump($index_cate[$key]['list']);
				}
			}else if($row['type'] == 'page'){
				if($row['list_type'] == 0){//展示子栏目，获取子栏目的内容 栏目标题等
					$index_cate[$key]['l_type'] = 'page';
					$index_cate[$key]['list']= array();//一级栏目list数组
					$index_cate[$key]['list'] = pdo_fetchall("SELECT id,cid,num,name,ename,catepic,cdesc,list_style,list_tstyle,type FROM ".tablename('sudu8_page_cate')." WHERE cid=:cid and uniacid = :uniacid and statue =1 ORDER BY num DESC,id DESC"  , array(':uniacid' => $uniacid,':cid' => $id));//写入一级栏目list数组
					//var_dump($index_cate[$key]['list']);
					foreach ($index_cate[$key]['list'] as  $key2=>$row2){
						if(stristr($row2['catepic'], 'http')){
			  				$index_cate[$key]['list'][$key2]['catepic'] = $row2['catepic'];
						}else{
			  				$index_cate[$key]['list'][$key2]['catepic'] = HTTPSHOST.$row2['catepic'];
						}
					}
					//var_dump($index_cate[$key]['list']);
					//var_dump("aaaa");
				}else if($row['list_type'] == 1){//展示栏目内容，获取文章标题等
					$index_cate[$key]['l_type'] = 'page';
					$index_cate[$key]['list']= array();//一级栏目list数组
					$index_cate[$key]['list'] = pdo_fetchall("SELECT id,cid,num,name,ename,catepic,cdesc,list_style,list_tstyle FROM ".tablename('sudu8_page_cate')." WHERE id=:cid and uniacid = :uniacid and statue =1 ORDER BY num DESC,id DESC"  , array(':uniacid' => $uniacid,':cid' => $id));//写入一级栏目list数组
					foreach ($index_cate[$key]['list'] as  $key2=>$row2){
						if(stristr($row2['catepic'], 'http')){
			  				$index_cate[$key]['list'][$key2]['catepic'] = $row2['catepic'];
						}else{
			  				$index_cate[$key]['list'][$key2]['catepic'] = HTTPSHOST.$row2['catepic'];
						}
						$index_cate[$key]['list'][$key2]['type'] = "page";
					}
					//var_dump($index_cate[$key]['list']);
					//var_dump("bbbb");
				}
			}
		}
		// echo "<pre>";
		// var_dump($index_cate);
		// echo "</pre>";
		// die();
		return $this->result(0, 'success', $index_cate);
	}
	//170821 获取列表页列表
	public function doPagelistPic(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$pindex = max(1, intval($_GPC['page']));
		$cid = intval($_GPC['cid']);
		// 判断栏目等级 根据等级显示不同的信息
		$cateinfo = pdo_fetch("SELECT id,cid,type,pagenum FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id = :cid" , array(':uniacid' => $uniacid,':cid' => $cid));
		$psize = $cateinfo['pagenum'];
		if(!$psize){
			$psize = 10;
		}
		if($cateinfo['cid'] == 0){
			$pcid = $cateinfo['id'];
	  		$slid = 'pcid';
  		}else{
  			$pcid = $cateinfo['cid'];
	  		$slid = 'cid';
  		}
  		// 获取顶级栏目基础信息
		$cateinfo = pdo_fetch("SELECT id,name,ename,type,list_type,list_style,list_tstyle,list_tstylel,list_stylet,list_style_more,cateslide FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id = :cid" , array(':uniacid' => $uniacid,':cid' => $pcid));
		if(!$cateinfo['list_style_more'] ){
			!$cateinfo['list_style_more'] =1;
		}
		$cateinfo['cateslide'] = unserialize($cateinfo['cateslide']);
		foreach($cateinfo['cateslide'] as $k => $v){
				if(stristr($v, 'http')){
	  				$cateinfo['cateslide'][$k] = $v;
				}else{
					$cateinfo['cateslide'][$k] = HTTPSHOST.$v;
				}
		}
  		//当前顶级栏目改为 全部
		$cate_first = pdo_fetch("SELECT id,name FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id = :cid" , array(':uniacid' => $uniacid,':cid' => $pcid));
		$cate_first['name'] = "全部";
		//获取子栏目
		$cateinfo['cate'] = pdo_fetchall("SELECT id,num,name FROM ".tablename('sudu8_page_cate')."WHERE uniacid = :uniacid and cid = :cid ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':cid' => $pcid));
		// 全部栏目数组
		array_unshift($cateinfo['cate'],$cate_first);
		//获取当前栏目基础信息
		$cateinfo['this'] = pdo_fetch("SELECT id,name,ename,type,list_type,list_style,list_tstyle,list_tstylel,list_stylet,slide_is FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id = :cid" , array(':uniacid' => $uniacid,':cid' => $cid));
		if(!$cateinfo['this']['list_style']){
			$cateinfo['this']['list_style'] = 2;
		}
		if(!$cateinfo['this']['list_tstyle']){
			$cateinfo['this']['list_tstyle'] = "t1";
		}
		if($cateinfo['type'] == 'showArt' or $cateinfo['type'] == 'showPic' or $cateinfo['type'] == 'showPro'){
			//获取所有数量
			$cateinfo['num'] = pdo_fetchall("SELECT id FROM ".tablename('sudu8_page_products')."WHERE uniacid = :uniacid and flag = 1 and ".$slid." = :cid", array(':uniacid' => $uniacid,':cid' => $cid));
	  		//获取栏目文章
			$cateinfo['list'] = pdo_fetchall("SELECT id,type,num,title,thumb,ctime,hits,`desc`,price,market_price,sale_num,sale_tnum,is_more,buy_type FROM ".tablename('sudu8_page_products')."WHERE uniacid = :uniacid and flag = 1 and ".$slid." = :cid ORDER BY num DESC,id DESC LIMIT ".($pindex - 1) * $psize.",".$psize , array(':uniacid' => $uniacid,':cid' => $cid));
			foreach ($cateinfo['list'] as  &$row){
				$row['ctime'] = date("y-m-d H:i:s",$row['ctime']);
				if(stristr($row['thumb'], 'http')){
	  				$row['thumb'] = $row['thumb'];
				}else{
	  				$row['thumb'] = HTTPSHOST.$row['thumb'];
				}
				if ($row['is_more']==1) {
					$row['type'] = 'showPro_lv';
				}
				if ($row['is_more']==3) {
					$row['sale_num'] = $row['sale_tnum'];
				}else{
					if(!$row['sale_num']){
						$row['sale_num'] = 0;
					}
				}
			}
		}else if($cateinfo['type'] == 'showWxapps'){
			//获取所有数量
			$cateinfo['num'] = pdo_fetchall("SELECT id FROM ".tablename('sudu8_page_wxapps')."WHERE uniacid = :uniacid and ".$slid." = :cid", array(':uniacid' => $uniacid,':cid' => $cid));
	  		//获取栏目文章
			$cateinfo['list'] = pdo_fetchall("SELECT id,type,num,title,thumb,appId,path,`desc` FROM ".tablename('sudu8_page_wxapps')."WHERE uniacid = :uniacid and ".$slid." = :cid ORDER BY num DESC,id DESC LIMIT ".($pindex - 1) * $psize.",".$psize , array(':uniacid' => $uniacid,':cid' => $cid));
			foreach ($cateinfo['list'] as  &$row){
				if(stristr($row['thumb'], 'http')){
	  				$row['thumb'] = $row['thumb'];
				}else{
	  				$row['thumb'] = HTTPSHOST.$row['thumb'];
				}
			}
		}
		if($cateinfo['list_style_more'] == 2){
			$newcate = pdo_fetchall("SELECT id,num,name FROM ".tablename('sudu8_page_cate')."WHERE uniacid = :uniacid and cid = :cid ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':cid' => $pcid));
			foreach ($newcate as $key5 => &$rebs) {
				$listarr = pdo_fetchall("SELECT id,type,num,title,thumb,ctime,hits,`desc`,price,market_price,sale_num,sale_tnum,is_more,buy_type FROM ".tablename('sudu8_page_products')."WHERE uniacid = :uniacid and cid = :cid ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':cid' => $rebs['id']));
				if($listarr){
					foreach ($listarr as $key6 => &$v) {
					if(stristr($v['thumb'], 'http')){
		  				$v['thumb'] = $v['thumb'];
					}else{
		  				$v['thumb'] = HTTPSHOST.$v['thumb'];
					}
					if($v['type']=="showPro"){  
						if($v['is_more']==1){
							$v['gurl'] = "sudu8_page/showPro/showPro?id=".$v['id'];
						}
						if($v['is_more']==2){
							$v['gurl'] = "sudu8_page/showPro_lv/showPro_lv?id=".$v['id'];
						}
					}else{
						$v['gurl'] = "sudu8_page/".$v['type']."/".$v['type']."?id=".$v['id'];
					}
					}
				}
				$rebs['goodsList'] = $listarr;
			}
			$cateinfo['list'] = '';
			$cateinfo['newlist'] = $newcate;
		}
		return $this->result(0, 'success', $cateinfo);
	}
	public function doPagelistCate(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$pindex = max(1, intval($_GPC['page']));
		$cid = intval($_GPC['cid']);
  		// 获取顶级栏目基础信息
		$cateinfo = pdo_fetch("SELECT id,name,ename,type,list_type,type,list_style,list_tstyle,list_tstylel,list_stylet FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id = :cid" , array(':uniacid' => $uniacid,':cid' => $cid));
		$cateinfo['list'] = pdo_fetchall("SELECT id,name,ename,catepic,cdesc,list_style,list_tstyle,list_stylet,list_tstylel FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and cid = :cid ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid,':cid' => $cid));
		//$cateinfo['l_type'] = 'list'.substr($cateinfo['type'],4,strlen($cateinfo['type']));;
		if($cateinfo['type']=='showPro'){
	  		$cateinfo['l_type'] = 'listPro';
	  	}else{
	  		$cateinfo['l_type'] = 'listPic';
	  	}
		foreach ($cateinfo['list'] as  &$row){
			if(stristr($row['catepic'], 'http')){
  				$row['catepic'] = $row['catepic'];
			}else{
  				$row['catepic'] = HTTPSHOST.$row['catepic'];
			}
		}
		//var_dump($cateinfo);
		return $this->result(0, 'success', $cateinfo);
	}
	//170821婚纱专用页
	public function doPageshowPic(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$pics = pdo_fetch("SELECT title,text,hits,cid,`desc`,buy_type FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $id ,':uniacid' => $uniacid));
		$pics['btn'] = pdo_fetch("SELECT pic_page_btn,pic_page_bg FROM ".tablename('sudu8_page_cate')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $pics['cid'] ,':uniacid' => $uniacid));
		$data = array(
            'hits' => $pics['hits'] + 1,
        );
		pdo_update('sudu8_page_products', $data, array('id' => $id ,'uniacid' => $uniacid));
		$pics['text'] = unserialize($pics['text']);
		$num = count($pics['text']);
		for($i = 0; $i < $num; $i++){
  			if(stristr($pics['text'][$i], 'http')){
  				$pics['text'][$i] = $pics['text'][$i];
			}else{
  				$pics['text'][$i] = HTTPSHOST.$pics['text'][$i];
			}
		}
		return $this->result(0, 'success', $pics);
	}
	//商品详情显示
	public function doPageshowPro(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$pro = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $id ,':uniacid' => $uniacid));
		$data = array(
            'hits' => $pro['hits'] + 1,
        );
		pdo_update('sudu8_page_products', $data, array('id' => $id ,'uniacid' => $uniacid));
		$pro['text'] = unserialize($pro['text']);
		$num = count($pro['text']);
		for($i = 0; $i < $num; $i++){
  			if(stristr($pro['text'][$i], 'http')){
  				$pro['text'][$i] = $pro['text'][$i];
			}else{
  				$pro['text'][$i] = HTTPSHOST.$pro['text'][$i];
			}
		}
		// 20170925  修改卖出总数
		$orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE pid = :id and uniacid = :uniacid and flag >0" , array(':id' => $id ,':uniacid' => $uniacid));
		// if($pro['is_more']==1){
		// 	if($orders){
		// 		$allnum = 0;
		// 		foreach ($orders as $rec) {
		// 			$duo = $rec['order_duo'];
		// 			$newduo = unserialize($duo);
		// 			foreach ($newduo as $key=>&$res) {
		// 				$allnum[$key] += $res[5];
		// 			}
		// 		}
		// 	}
		// }
		$sale_num = 0;
		if($orders){
			foreach ($orders as $rec) {
				$sale_num+= $rec['num'];
			}
		}
		$pro['sale_num'] = $pro['sale_num'] + $sale_num;
		//20170925  新增我的购买量
		$openid = $_GPC['openid'];
		$myorders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE pid = :id and openid = :openid and uniacid = :uniacid and flag>=0" , array(':id' => $id ,':openid' => $openid ,':uniacid' => $uniacid));
		$my_num = 0;
		// var_dump($myorders);
		// die();
 		//判断我又没有收藏过
		$collectcount = 0;
		if($openid){
			$user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid", array(':uniacid' => $uniacid,':openid' => $openid));
			$uid = $user['id'];
			$collect = pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_collect')." WHERE uniacid = :uniacid and uid = :uid and type = :type and cid = :cid", array(':uniacid' => $uniacid,':uid' => $uid,':type' => "showPro_lv", ':cid'=> $id));
			if($collect['n']>0){
				$collectcount = 1;
			}
		}
		$pro['collectcount'] = $collectcount;
		//刷新所有商品已过期订单且未支付
		if($pro['pro_kc']>=0 && $pro['is_more']==0){
			$now = time();
			$onum = 0;
			$allorders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE pid = :pid  and uniacid = :uniacid and flag = 0 and overtime < :nowtime" , array(':pid' => $id  ,':uniacid' => $uniacid, ':nowtime'=> $now));
			if($allorders){
				foreach ($allorders as $rec) {
					$onum+=$rec['num'];
					$kdata['flag'] = -1;
					$kdata['reback'] = 1;
					pdo_update('sudu8_page_order', $kdata, array('order_id' => $rec['order_id'] ,'uniacid' => $uniacid));
				}
				$ndata['pro_kc'] = $pro['pro_kc']+$onum;
				pdo_update('sudu8_page_products', $ndata, array('id' => $id ,'uniacid' => $uniacid));
			}
		}else if($pro['pro_kc']< 0 && $pro['is_more']==0){
			$now = time();
			$allorders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE pid = :pid  and uniacid = :uniacid and flag = 0 and overtime < :nowtime" , array(':pid' => $id  ,':uniacid' => $uniacid, ':nowtime'=> $now));
			if($allorders){
				foreach ($allorders as $rec) {
					$kdata['flag'] = -1;
					$kdata['reback'] = 1;
					pdo_update('sudu8_page_order', $kdata, array('order_id' => $rec['order_id'] ,'uniacid' => $uniacid));
				}
			}
		}
		if($pro['is_more']==1){
			$now = time();
			if($now>$orders['overtime'] && $orders['flag'] == 0){   //订单失效
				$kdata['flag'] = -1;
				pdo_update('sudu8_page_order', $kdata, array('order_id' => $id ,'uniacid' => $uniacid));
			}
		}
		if($myorders){
			foreach ($myorders as $res) {
				$my_num+= $res['num'];
			}
		}
		$pro['my_num'] = $my_num;
		$now = time();
		if($pro['sale_time'] == 0){
			$pro['is_sale'] = 1;
		}else{
			if($pro['sale_time'] > $now){
				$pro['is_sale'] = 0;			
			}else{
				$pro['is_sale'] = 1;
			}
		}
		if(stristr($pro['thumb'], 'http')){
				$pro['thumb'] = $pro['thumb'];
		}else{
				$pro['thumb'] = HTTPSHOST.$pro['thumb'];
		}
		if($pro['labels'] && $pro['is_more']==0){
			$labels = explode(",", $pro['labels']);
			$pro['labels'] = $labels;
		}elseif($pro['labels'] && $pro['is_more']==1){
			$labels = unserialize($pro['labels']);
			$arrkk = array();
			foreach ($labels as $key => $res) {
				$vvkk = array($key,$res);
				array_push($arrkk, $vvkk);
			}
			$pro['labels'] = $arrkk;
			// var_dump($arrkk);
			// die();
		}else{
			$pro['labels'] = array();
		}
		if($pro['more_type']){
			$more_type = unserialize($pro['more_type']);
			$newmore = array_chunk($more_type,4);
			$pro['more_type'] = $newmore;
			// var_dump($more_type);
			// die();
		}
		if($pro['more_type_x']){
			$more_type_x = unserialize($pro['more_type_x']);
			$pro['more_type_x'] = $more_type_x;
		}
		if($pro['more_type_num']){
			$more_type_num = unserialize($pro['more_type_num']);
			$pro['more_type_num'] = $more_type_num;
		}
		// echo "<pre>";
		// var_dump($pro);
		// echo "</pre>";
		// die();
		 $formset = $pro['formset'];
		if($formset!=0&&$formset!=""){
			$forms = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_formlist')." WHERE id = :id" , array(':id' => $formset));
			$forms2 = unserialize($forms['tp_text']);
			foreach($forms2 as $key=>&$res){
				if($res["type"]!=2 && $res["type"]!=5){
					$vals= explode(",", $res['tp_text']);
					$kk = array();
					foreach ($vals as $key => &$rec) {
						$kk['yval'] = $rec;
						$kk['checked'] = "false";
						$rec = $kk;
					}
					$res['tp_text'] = $vals;
				}
				if($res["type"]==2){
					$vals= explode(",", $res['tp_text']);
					$res['tp_text'] = $vals;
				}
				$res['val']='';
			}
		}else{
			$forms2 = "NULL";
		}
		// 
		// 
		// 
		// if($formset!=0&&$formset!=""){
		// 	$forms = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_formlist')." WHERE id = :id" , array(':id' => $formset));
		// 	$forms2 = unserialize($forms['tp_text']);
		// 	foreach($forms2 as $key=>&$res){
		// 		if($res['tp_text']){
		// 			$res['tp_text'] = explode(",", $res['tp_text']);
		// 		}
		// 		$res['val']='';
		// 	}
		// }else{
		// 	$forms2 = "NULL";
		// }
		$pro['forms'] = $forms2;
		// echo "<pre>";
		// var_dump($pro);
		// echo "</pre>";
		// die();
		// var_dump($pro);exit;
		return $this->result(0, 'success', $pro);
	}
	//商品生成订单页面
	public function doPageDingd(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$id =  $_GPC['id'];
		$flags = true;

		//获得用户信息
		$user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :id and uniacid = :uniacid" , array(':id' => $_GPC['openid'] ,':uniacid' => $uniacid));
		//获得商品信息
		$pro = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $id ,':uniacid' => $uniacid));
		if($pro['more_type_num']){
			$more_type_num = unserialize($pro['more_type_num']);
		}
		if($pro['is_more']=="1" or $pro['is_more']== 1 ){    //多规格产品处理
			$num = $_GPC['num'];
			$newnum = explode(',',substr($num, 1,strlen($num)-2));
			$numarr = array();
			foreach ($newnum as $rec) {
                $nnn = explode(':',$rec);
                $numarr[] = $nnn[1];
            }
			$guig = unserialize($pro['more_type_x']);
			foreach ($guig as $key => &$rec) {
				$rec[] = $numarr[$key];
			}
			$newgg =  serialize($guig);
			$order = $_GPC['order'];
			if($_GPC['order']){
				$order = $_GPC['order'];
			}else{
				$now = time();
				$order = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
			}
			// $cydat = $_GPC['chuydate']." ".$_GPC['chuytime'];
			// $zzcy = strtotime($cydat);
			$overtime = time() + 30*60;
			$data = array(
				"uniacid" => $_W['uniacid'],
				"order_id" => $order,
				"uid" => $user['id'],
				"openid" =>$_GPC['openid'],
				"pid" => $_GPC['id'],
				"thumb"=>$pro['thumb'],
				"product"=>$pro['title'],
				"yhq" => $_GPC['youhui'],
				"true_price" => $_GPC['zhifu'],
				"creattime" =>time(), 
				"flag"=>0,
				"pro_user_name"=>$_GPC['pro_name'],
				"pro_user_tel"=>$_GPC['pro_tel'],
				"pro_user_add"=>$_GPC['pro_address'],
				"pro_user_txt"=>$_GPC['pro_txt'],
				"overtime"=>$overtime,
				"is_more"=>1,
				"order_duo"=>$newgg,
				"coupon"=>$_GPC['yhqid']
			);
			// 新增自定义表单数据接收
			if($_GPC['pagedata'] && $_GPC['pagedata']!=="NULL"){
				$forms = stripslashes(html_entity_decode($_GPC['pagedata']));
				$forms = json_decode($forms,TRUE);
				$data['beizhu_val'] = serialize($forms);
			}
			// echo "<pre>";
			// var_dump($data);
			// echo "</pre>";
			// die();

			if($_GPC['order']){
				// die();
				$res = pdo_update('sudu8_page_order', $data, array('order_id' => $order ,'uniacid' => $uniacid));
				//var_dump("11--");
				//var_dump($res);
			}else{
				// die();
				$res = pdo_insert('sudu8_page_order', $data);
				//var_dump("22--");
				//var_dump($res);
			}
			if($res){
				$data['success'] = 1;
				$data['xg'] = $pro['pro_xz'];
				return $this->result(0, 'success', $data);
			}
		}

		//20170925  新增我的购买量
		$openid = $_GPC['openid'];
		$pid = $orders['pid'];
		$myorders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE pid = :pid and openid = :openid and uniacid = :uniacid and flag>=0" , array(':pid' => $pid ,':openid' => $openid ,':uniacid' => $uniacid));
		$my_num = 0;
		if($myorders){
			foreach ($myorders as $res) {
				$my_num+= $res['num'];
			}
		}
		//1.生成订单之前再判断次该商品有没有下架及库存剩余量
		$num = $_GPC['count'];
		$orderid = $_GPC['order'];
		if(!$orderid){                              //新下单的情况
			if($pro['pro_kc']==-1){                 //不限库存
				$flags = true;
				$syl = $pro['pro_kc'];
			}else{                                  //限制库存
				if($pro['pro_kc']+$my_num == 0){    //库存为空
					$syl = 0;
					$flags = false;
				}
 				if( $pro['pro_kc']+$my_num !=0 ){   //库存不为空
 					if($pro['pro_xz']==0){          //限量不限购
 						if($num > $pro['pro_kc']){
							$syl = $pro['pro_kc'];
							$flags = false;
						}
 					}else{                          //限量又限购
 						if($my_num + $num > $pro['pro_xz'] || $num > $pro['pro_kc']){
							$syl = $pro['pro_kc'];
							$flags = false;
						}
 					}	
				}
			}
		}else{
			$oinfo = pdo_fetch("SELECT num,uniacid,order_id FROM ".tablename('sudu8_page_order')." WHERE order_id = :order and uniacid = :uniacid" , array(':order' => $orderid ,':uniacid' => $uniacid));
			$ddnum = $oinfo['num'];
			if($pro['pro_kc']==-1){   //不限库存
				$flags = true;
				$syl = $pro['pro_kc'];
			}else{
				$cha = $ddnum - $num;  //订单号里面的数值相差几个
				$new_num = $my_num - $cha;  //获得现在新提交数
				if($new_num < 0){   //又增加了购买量
					$absnum = abs($new_num);
					if( $my_num + $absnum > $pro['pro_xz'] || $absnum > $pro['pro_kc']){
						$syl = $pro['pro_kc'];
						$flags = false;
					}	
				}else{
					$flags = true;
				}
			}
		}




		if($flags && $pro['pro_kc']>=0){    //限制库存 且有库存剩余
			if($_GPC['order']){
				$order = $_GPC['order'];
				//修改订单的时候商品总数变化
				$oinfo = pdo_fetch("SELECT num,uniacid,order_id FROM ".tablename('sudu8_page_order')." WHERE order_id = :order and uniacid = :uniacid" , array(':order' => $order ,':uniacid' => $uniacid));
				$onum = $oinfo['num'];
				$newnum = $num - $onum;
				$ndata['pro_kc'] = $pro['pro_kc'] - $newnum;
				pdo_update('sudu8_page_products', $ndata, array('id' => $id ,'uniacid' => $uniacid));
			}else{
				$now = time();
				$order = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
				//新下单的同时立即把商品数量减去
				$ndata['pro_kc'] = $pro['pro_kc'] - $num;
				pdo_update('sudu8_page_products', $ndata, array('id' => $id ,'uniacid' => $uniacid));
			}
			$overtime = time() + 30*60;
			$data = array(
				"uniacid" => $_W['uniacid'],
				"order_id" => $order,
				"uid" => $user['id'],
				"openid" =>$_GPC['openid'],
				"pid" => $_GPC['id'],
				"thumb"=>$pro['thumb'],
				"product"=>$pro['title'],
				"price" => $_GPC['price'],
				"num" => $_GPC['count'],
				"yhq" => $_GPC['youhui'],
				"true_price" => $_GPC['zhifu'],
				"creattime" =>time(), 
				"flag"=>0,
				"pro_user_name"=>$_GPC['pro_name'],
				"pro_user_tel"=>$_GPC['pro_tel'],
				"pro_user_add"=>$_GPC['pro_address'],
				"pro_user_txt"=>$_GPC['pro_txt'],
				"overtime"=>$overtime,
				"coupon"=>$_GPC['yhqid']
			);
			// 新增自定义表单数据接收
			if($_GPC['pagedata'] && $_GPC['pagedata']!=="NULL"){
				$forms = stripslashes(html_entity_decode($_GPC['pagedata']));
				$forms = json_decode($forms,TRUE);
				$data['beizhu_val'] = serialize($forms);
			}
			if($_GPC['order']){
				$res = pdo_update('sudu8_page_order', $data, array('order_id' => $order ,'uniacid' => $uniacid));
			}else{
				$res = pdo_insert('sudu8_page_order', $data);
			}
			if($res){
				$data['success'] = 1;
				$data['xg'] = $pro['pro_xz'];
				return $this->result(0, 'success', $data);
			}
		}
		if($flags && $pro['pro_kc']<0){    //不限制库存
			if($_GPC['order']){
				$order = $_GPC['order'];
			}else{
				$now = time();
				$order = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
			}
			$overtime = time() + 30*60;
			$data = array(
				"uniacid" => $_W['uniacid'],
				"order_id" => $order,
				"uid" => $user['id'],
				"openid" =>$_GPC['openid'],
				"pid" => $_GPC['id'],
				"thumb"=>$pro['thumb'],
				"product"=>$pro['title'],
				"price" => $_GPC['price'],
				"num" => $_GPC['count'],
				"yhq" => $_GPC['youhui'],
				"true_price" => $_GPC['zhifu'],
				"creattime" =>time(), 
				"flag"=>0,
				"pro_user_name"=>$_GPC['pro_name'],
				"pro_user_tel"=>$_GPC['pro_tel'],
				"pro_user_add"=>$_GPC['pro_address'],
				"pro_user_txt"=>$_GPC['pro_txt'],
				"overtime"=>$overtime,
				"coupon"=>$_GPC['yhqid']
			);
			// 新增自定义表单数据接收
			if($_GPC['pagedata'] && $_GPC['pagedata']!=="NULL"){
				$forms = stripslashes(html_entity_decode($_GPC['pagedata']));
				$forms = json_decode($forms,TRUE);
				$data['beizhu_val'] = serialize($forms);
			}

			if($_GPC['order']){
				$res = pdo_update('sudu8_page_order', $data, array('order_id' => $order ,'uniacid' => $uniacid));
			}else{
				$res = pdo_insert('sudu8_page_order', $data);
			}
			if($res){
				$data['success'] = 1;
				$data['xg'] = $pro['pro_xz'];
				return $this->result(0, 'success', $data);
			}
		}
		if(!$flags){
			$data['success'] = 0;
			$data['syl'] = $syl;
			$data['id'] = $id;
			return $this->result(0, 'error', $data);
		}
	}
	//订单号取数据
	public function doPageOrderinfo(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$id =  $_GPC['order'];
		$orders = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_order')." WHERE order_id = :id and uniacid = :uniacid" , array(':id' => $id ,':uniacid' => $uniacid));
		//获得商品信息
		$pro = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $orders['pid'] ,':uniacid' => $uniacid));
		if(stristr($orders['thumb'], 'http')){
			$orders['thumb'] = $orders['thumb'];
		}else{
			$orders['thumb'] = HTTPSHOST.$orders['thumb'];
		}
		//获得用户金钱
        $openid = $orders['openid'];
        $user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $uniacid));
        $money = $user['money'];
        $score = $user['score'];
        // 积分兑换金额
        $jf_gz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_rechargeconf')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
         if(!$jf_gz){
         	$jf_gz['scroe'] = 10000;
         	$jf_gz['money'] = 1;
         }
        $jf_money = intval($score/$jf_gz['scroe'])*$jf_gz['money'];   			//1.我的积分可以换取多少钱
        $jf_pro = intval($pro['score_num']/$jf_gz['scroe'])*$jf_gz['money'];    //2.商品最高抵扣换取多少钱
        $dikou_jf = 0;
        if($jf_pro >= $jf_money){   //商品设置的最大可使用积分 >= 我自己的积分
        	$dikou_jf = $jf_money;
        	if($dikou_jf*1000 > $orders['true_price']*1000){         //最终抵扣金钱和商品价格进行比较[抵扣钱大于订单钱]
        		$dikou_jf = $orders['true_price'];
        	}else{										   //抵扣钱<=订单钱
        		$dikou_jf = $dikou_jf;
        	}
        }else{						//商品设置的最大可使用积分 < 我自己的积分
        	$dikou_jf = $jf_pro;    
        	if($dikou_jf*1000 > $orders['true_price']*1000){         //最终抵扣金钱和商品价格进行比较[抵扣钱大于订单钱]
        		$dikou_jf = $orders['true_price'];
        	}else{										   //抵扣钱<=订单钱
        		$dikou_jf = $dikou_jf;
        	}
        }
		// 积分金钱转积分数
		$jf_score = ($dikou_jf/$jf_gz['money'])*$jf_gz['scroe'];
        // var_dump($orders['true_price']);
        // var_dump($jf_pro);
        // var_dump($dikou_jf);
        // die();
		//刷新该订单的状态【判断是否过期】
		if($pro['pro_kc']>=0 && $pro['is_more']==0){  //限制库存
			$now = time();
			if($now>$orders['overtime'] && $orders['reback'] ==0 && $orders['flag'] == 0){   //订单失效
				$onum = $orders['num'];
				$kdata['flag'] = -1;
				$kdata['reback'] = 1;
				pdo_update('sudu8_page_order', $kdata, array('order_id' => $id ,'uniacid' => $uniacid));
				$ndata['pro_kc'] = $pro['pro_kc']+$onum;
				pdo_update('sudu8_page_products', $ndata, array('id' => $orders['pid'] ,'uniacid' => $uniacid));
			}
		}elseif($pro['pro_kc']<0 && $pro['is_more']==0){
			$now = time();
			if($now>$orders['overtime'] && $orders['reback'] ==0 && $orders['flag'] == 0){   //订单失效
				$kdata['flag'] = -1;
				$kdata['reback'] = 1;
				pdo_update('sudu8_page_order', $kdata, array('order_id' => $id ,'uniacid' => $uniacid));
			}
		}
		if($pro['is_more']=="1" or $pro['is_more']==1){
			$now = time();
			if($now>$orders['overtime'] && $orders['flag'] == 0){   //订单失效
				$kdata['flag'] = -1;
				pdo_update('sudu8_page_order', $kdata, array('order_id' => $id ,'uniacid' => $uniacid));
			}
		}
		$new_orders = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_order')." WHERE order_id = :id and uniacid = :uniacid" , array(':id' => $id ,':uniacid' => $uniacid));
		// 获得优惠券信息
		$mycoupon = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :cid and uniacid = :uniacid" , array(':cid' => $new_orders['coupon'] ,':uniacid' => $uniacid));
		$coupon = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :cid and uniacid = :uniacid" , array(':cid' => $mycoupon['cid'] ,':uniacid' => $uniacid));
		//20170925  新增我的购买量
		$openid = $_GPC['openid'];
		$pid = $new_orders['pid'];
		$myorders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE pid = :pid and openid = :openid and uniacid = :uniacid and flag>=0" , array(':pid' => $pid ,':openid' => $openid ,':uniacid' => $uniacid));
		$my_num = 0;
		if($myorders){
			foreach ($myorders as $res) {
				$my_num+= $res['num'];
			}
		}
		// 我的订单数
		$cdd = count($myorders);
		// 20170925  修改卖出总数
		$orders_l = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE pid = :pid and uniacid = :uniacid and flag>0" , array(':pid' => $pid ,':uniacid' => $uniacid));
		$sale_num = 0;
		if($orders_l){
			foreach ($orders_l as $rec) {
				$sale_num+= $rec['num'];
			}
		}
		$new_orders['sale_num'] = $new_orders['sale_num'] + $sale_num;
		//订单有没有过期
		$now = time();
		$overtime = $orders['overtime'];
		if($now>$overtime){
			$new_orders['isover'] = 1;
		}else{
			$new_orders['isover'] = 0;
		}
		$new_orders['my_num'] = $my_num;
		$new_orders['mcount'] = $cdd;
		$new_orders['pro_flag'] = $pro['pro_flag'];
		$new_orders['pro_flag_tel'] = $pro['pro_flag_tel'];
		$new_orders['pro_flag_add'] = $pro['pro_flag_add'];
		$new_orders['pro_flag_data'] = $pro['pro_flag_data'];
		$new_orders['pro_flag_data_name'] = $pro['pro_flag_data_name'];
		$new_orders['pro_flag_time'] = $pro['pro_flag_time'];
		$new_orders['pro_flag_ding'] = $pro['pro_flag_ding'];
		$new_orders['pro_kc'] = $pro['pro_kc'];
		$new_orders['pro_xz'] = $pro['pro_xz'];
		if(stristr($new_orders['thumb'], 'http')){
			$new_orders['thumb'] = $new_orders['thumb'];
		}else{
			$new_orders['thumb'] = HTTPSHOST.$new_orders['thumb'];
		}
		$new_orders['more_type_x'] = unserialize($new_orders['order_duo']);
		$new_orders['chuydate'] = date("Y-m-d",$new_orders['overtime']);
		$new_orders['chuytime'] = date("H:i",$new_orders['overtime']);
		$new_orders['more_type_num'] = unserialize($pro['more_type_num']);
		$new_orders['couponid'] = $new_orders['coupon'];
		$new_orders['is_score'] = $pro['is_score'];
		$new_orders['jf_score'] = $jf_score;
		if($coupon){
		   $new_orders['coupon'] = $coupon;
		  }else{
		   $coupon['price'] = 0;
		   $new_orders['coupon'] = $coupon;
		}
		$new_orders['shengyutime'] = intval(($overtime - time())/60);
		$fomeval = unserialize($orders['beizhu_val']);
		foreach ($fomeval as $key => &$res) {
			if($res['type']==3){
				foreach ($res["tp_text"] as &$val) {
					if(in_array($val['yval'],$res["val"])){
						$val['checked'] = "true";
					}else{
						$val['checked'] = "false";
					}
				}
			}
			if($res['type']==4){
				foreach ($res["tp_text"] as &$val) {
					$kk = array();
					if($val['yval']==$res["val"]){
						$val['checked'] = "true";
					}else{
						$val['checked'] = "false";
					}
				}
			}
			if($res['type']==5){
				$imgall = $res['z_val'];
				foreach ($imgall as $key => &$rec) {
					$rec = HTTPSHOST.$rec;
				}
				$res["z_val"] = $imgall;
			}
		}
		$new_orders['beizhu_val'] = $fomeval;
		$new_orders['my_money'] = $money;
		$new_orders['dikou_jf'] = $dikou_jf;
		return $this->result(0, 'success', $new_orders);
	}
	//更新订单状态 20170925
	public function doPageorderpayover()
	{
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$id =  $_GPC['order_id'];
		$my_pay_money = $_GPC['my_pay_money'];
		$orders = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_order')." WHERE order_id = :id and uniacid = :uniacid" , array(':id' => $id ,':uniacid' => $uniacid));
		$pro = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $orders['pid'] ,':uniacid' => $uniacid));
		// 对备注进行相关操作
		if($orders['beizhu_val']){
			$addbeizh = unserialize($orders['beizhu_val']);
			foreach ($addbeizh as $key5 => &$rem) {
				if($rem['type']==14){
					$addbarr = array(
						"uniacid" => $uniacid,
						"cid" => $orders['pid'],
						"types" => "showPro_lv_buy",
						"datys" => strtotime($rem['days']),
	       				"pagedatekey"=>$rem['indexkey'],
	       				"arrkey" => $rem['xuanx'],
	       				"creattime" => time()
					);
					pdo_insert("sudu8_page_form_dd",$addbarr);
				}
			}
		}
		$coupondata = array(
			"flag"=>1
		);
		pdo_update('sudu8_page_coupon_user', $coupondata, array('id' => $orders['coupon'] ,'uniacid' => $uniacid));
		// 消费的积分
		$jifen = $_GPC["jf_score"];
		// 积分规则
		$jf_gz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_rechargeconf')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		if(!$jf_gz){
        	$jf_gz['scroe'] = 10000;
        	$jf_gz['money'] = 1;
        }
		// 积分金钱转积分数
		$jf_score = ($jifen/$jf_gz['money'])*$jf_gz['scroe'];
		//获得用户金钱,并更新金钱数
        $openid = $orders['openid'];
        $user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $uniacid));
        $money = $user['money'];
        $true_money = ($user['money'] * 1000 - $my_pay_money *1000)/1000;
        $true_score = $user['score'] - $jf_score;
        $tprice['money'] = $true_money;
        $tprice['score'] = $true_score;
        pdo_update('sudu8_page_user',$tprice,array('openid' => $openid ,'uniacid' => $uniacid));
        $jdata['uniacid'] = $uniacid;
        $jdata['orderid'] = $id;
        $jdata['uid'] = $user['id'];
        $jdata['type'] = "del";
        $jdata['score'] = $my_pay_money;
        $jdata['message'] = "消费";
        $jdata['creattime'] = time();
        if($my_pay_money>0){
        	$res = pdo_insert('sudu8_page_money', $jdata);
        }
        $kdata['uniacid'] = $uniacid;
        $kdata['orderid'] = $id;
        $kdata['uid'] = $user['id'];
        $kdata['type'] = "del";
        $kdata['score'] = $jf_score;
        $kdata['message'] = "消费";
        $kdata['creattime'] = time();
        if($jf_score>0){
        	pdo_insert('sudu8_page_score', $kdata);
        }
		// 判断有没有超出库存、并更新数据库
		if($pro['is_more']==1){
			$duock = 0;
			$more_type_num = unserialize($pro['more_type_num']);
			$num = unserialize($orders['order_duo']);
			$numarr = array();
			foreach ($num as $res) {
				array_push($numarr, $res[5]);
			}
			foreach ($more_type_num as $key => &$value) {
				if($value['shennum'] >= $numarr[$key]){
					$value['shennum'] = $value['shennum']-$numarr[$key];
					$value['salenum'] = $value['salenum']+$numarr[$key];
					$duock = 1;
				}else{
					$duock = 0;
				}
			}
			if($duock==1){
				$pid = $orders['pid'];
				$prodata['more_type_num'] = serialize($more_type_num);
				pdo_update('sudu8_page_products', $prodata, array('id' => $pid ,'uniacid' => $uniacid));
				if($pro['pro_flag_ding']==0){
					$data =  array(
						"flag" => 1
					);
				}
				if($pro['pro_flag_ding']==1){
					$data =  array(
						"flag" => 3
					);
				}
				$res = pdo_update('sudu8_page_order', $data, array('order_id' => $_GPC['order_id'] ,'uniacid' => $uniacid));
			}else{
				return $this->result(0, 'error', $data);
			}
		}
		if($pro['pro_kc']>=0 && $pro['is_more']==0){
			$now = time();   
			if($orders['overtime']<$now ){   //订单过期
				if($orders['reback'] == 0){
					$ndata['pro_kc'] = $pro['pro_kc']+$orders['num'];
					pdo_update('sudu8_page_products', $ndata, array('id' => $orders['pid'],'uniacid' => $uniacid));
					$cdata['reback'] =1;
					pdo_update('sudu8_page_order', $cdata, array('order_id' => $id,'uniacid' => $uniacid));
				}
				$data =  array(
					"flag" => -2
				);
			}else{
				$data =  array(
					"flag" => 1
				);
			}
			$res = pdo_update('sudu8_page_order', $data, array('order_id' => $id ,'uniacid' => $uniacid));
		}elseif($pro['pro_kc']<0 && $pro['is_more']==0){   //不限制库存
			$data =  array(
				"flag" => 1
			);
			$res = pdo_update('sudu8_page_order', $data, array('order_id' => $id ,'uniacid' => $uniacid));
		}
		if($res)
		{
			$applet = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
			$appid = $applet['key'];
			$appsecret = $applet['secret'];
			if($applet)
			{
				$mid =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_message')." WHERE uniacid = :uniacid and flag=1" , array(':uniacid' => $_W['uniacid']));
				if($mid)
				{
					if($mid['mid']!="")
					{
						$mids = $mid['mid'];
						$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
						$a_token = $this->_requestGetcurl($url);
						if($a_token)
						{
							$url_m="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$a_token['access_token'];
							$formId = $_GPC['formId'];
							$ftitle= $pro['title'];
							$fprice= $my_pay_money;
							$openid = $_GPC['openid'];
							$ftime=date('Y-m-d H:i:s',time());
							$furl = $mid['url'];
							$post_info = '{
									  "touser": "'.$openid.'",  
									  "template_id": "'.$mids.'", 
									  "page": "'.$furl.'",            
									  "form_id": "'.$formId.'",         
									  "data": {
									      "keyword1": {
									          "value": "'.$id.'", 
									          "color": "#173177"
									      }, 
									      "keyword2": {
									          "value": "'.$ftitle.'", 
									          "color": "#173177"
									      }, 
									      "keyword3": {
									          "value": "'.$fprice.'元", 
									          "color": "#173177"
									      }, 
									      "keyword4": {
									          "value": "'.$ftime.'", 
									          "color": "#173177"
									      },
									      "emphasis_keyword": "" 
									  }
									}';
								$this->_requestPost($url_m,$post_info);
						}
					}
				}
			}
			return $this->result(0, 'success', 1);
		}
	}
			//不带报头的curl
	public function _requestPost($url, $data, $ssl=true) {  
            //curl完成  
            $curl = curl_init();  
            //设置curl选项  
            curl_setopt($curl, CURLOPT_URL, $url);//URL  
            $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';  
            curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);//user_agent，请求代理信息  
            curl_setopt($curl, CURLOPT_AUTOREFERER, true);//referer头，请求来源  
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间  
            //SSL相关  
            if ($ssl) {  
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//禁用后cURL将终止从服务端进行验证  
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//检查服务器SSL证书中是否存在一个公用名(common name)。  
            }  
            // 处理post相关选项  
            curl_setopt($curl, CURLOPT_POST, true);// 是否为POST请求  
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);// 处理请求数据  
            // 处理响应结果  
            curl_setopt($curl, CURLOPT_HEADER, false);//是否处理响应头  
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//curl_exec()是否返回响应结果  
            // 发出请求  
            $response = curl_exec($curl);
            if (false === $response) {  
                echo '<br>', curl_error($curl), '<br>';  
                return false;  
            }  
            curl_close($curl);  
            return $response;  
    }
	public function _requestGetcurl($url){
    	//curl完成  
        $curl = curl_init();  
        //设置curl选项  
		$header = array(  
			"authorization: Basic YS1sNjI5dmwtZ3Nocmt1eGI2Njp1TlQhQVFnISlWNlkySkBxWlQ=",
			"content-type: application/json",
			"cache-control: no-cache",
			"postman-token: cd81259b-e5f8-d64b-a408-1270184387ca" 
		);
		curl_setopt($curl, CURLOPT_HEADER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER  , $header); 
        curl_setopt($curl, CURLOPT_URL, $url);//URL  
        curl_setopt($curl, CURLOPT_HEADER, 0);             // 0：不返回头信息
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间  
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
        // 发出请求  
        $response = curl_exec($curl);
        if (false === $response) {  
            echo '<br>', curl_error($curl), '<br>';  
            return false;  
        }  
        curl_close($curl);  
        $forms = stripslashes(html_entity_decode($response));
		$forms = json_decode($forms,TRUE);
        return $forms;  
    }
	//取消订单
	public function doPageDpass(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$id =  $_GPC['order'];
		$data =  array(
			"flag" => 1
		);
		$orders = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_order')." WHERE order_id = :id and uniacid = :uniacid" , array(':id' => $id ,':uniacid' => $uniacid));
		$now = time();
		$over = $orders["overtime"];
		$flag = $orders["flag"];
		$num = $orders["num"];
		$pid = $orders["pid"];
		$pro = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $pid ,':uniacid' => $uniacid));
		// var_dump((int)$pro['pro_kc']);
		// die();
		if((int)$pro['pro_kc']>=0){
			//优先判断订单有没有支付和过期
			if($flag==0 && $over > $now){
				$kc = $pro['pro_kc'];
				$ndata['pro_kc'] = $num + $kc;
				pdo_update('sudu8_page_products', $ndata, array('id' => $pid ,'uniacid' => $uniacid));
			}
		}
		//return $this->result(0, 'success', $id);
		$res = pdo_delete('sudu8_page_order', array('order_id' => $id ,'uniacid' => $uniacid));
		if($res){
			return $this->result(0, 'success', 1);
		}
	}
	//获取我的订单的相关信息
	public function doPageMyorder(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$type = $_GPC['type'];
		$where = "";
		if($type != 9){
			$where=" and flag = ".$type;
		}
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$OrdersList['list'] = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')."WHERE uniacid = :uniacid and openid = :openid ".$where." ORDER BY creattime DESC,flag  LIMIT ".($pindex - 1) * $psize.",".$psize ,array(':uniacid' => $uniacid,':openid'=>$openid));
		foreach ($OrdersList['list'] as  &$row){
			if(stristr($row['thumb'], 'http')){
				$row['thumb'] = $row['thumb'];
			}else{
				$row['thumb'] = HTTPSHOST.$row['thumb'];
			}
		}
		$alls = pdo_fetchall("SELECT id FROM ".tablename('sudu8_page_order')."WHERE uniacid = :uniacid and openid = :openid",array(':uniacid' => $uniacid,':openid'=>$openid));
		$OrdersList['allnum'] = count($alls);
		return $this->result(0, 'success', $OrdersList);
	}
	//支付流程
	public function doPageweixinpay(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		//先取对应数据
		$id = $_GPC['order_id'];
		$orders = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_order')." WHERE order_id = :id and uniacid = :uniacid" , array(':id' => $id ,':uniacid' => $uniacid));
		$pro = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $orders['pid'] ,':uniacid' => $uniacid));
		$more_type_num = unserialize($pro['more_type_num']);
		$num = unserialize($orders['order_duo']);
		//支付之前先处理下过期的优惠券
		$openid= $_GPC['openid'];
		$user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :id and uniacid = :uniacid" , array(':id' => $_GPC['openid'] ,':uniacid' => $uniacid));
		$uid = $user['id'];
		$yhqs =  pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE uniacid = :uniacid and uid = :uid and flag = 0 and etime>0" , array(':uniacid' => $_W['uniacid'],":uid" => $uid));
		$nowtime = time();
		// var_dump($yhqs);
		// die();
		foreach ($yhqs as $key => &$res) {
			$couponinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $res['cid'] ,':uniacid' => $uniacid));
			if($nowtime>$couponinfo['etime']){
				$updatas = array("flag"=>2);
				pdo_update('sudu8_page_coupon_user', $updatas, array('id' => $res['id'] ,'uniacid' => $uniacid));
			}
		}
		//支付之前判断下优惠券有没有在其他地方使用或者过期
		if($orders['coupon']!=0){
			$coupon =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $orders['coupon'] ,':uniacid' => $uniacid));
			$couponinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $coupon['cid'] ,':uniacid' => $uniacid));
			if($coupon['flag']==2){
				$data = array("message"=>"该优惠券已过期！");
				//删除该订单的优惠券信息，并恢复价格
				//删除该订单的优惠券信息，并恢复价格
				$true_price = $orders['true_price'];
				$yhjg = $couponinfo['price'];
				$newtrueprice = $true_price+$yhjg;
				$dataorder = array(
					"true_price" =>	$newtrueprice,
					"coupon" => 0
				);
				pdo_update('sudu8_page_order', $dataorder, array('order_id' => $id ,'uniacid' => $uniacid));
				return $this->result(0, 'error',$data);
			}
			if($coupon['flag']==1){
				$data = array("message"=>"该优惠券已经使用过了！");
				//删除该订单的优惠券信息，并恢复价格
				$true_price = $orders['true_price'];
				$yhjg = $couponinfo['price'];
				$newtrueprice = $true_price+$yhjg;
				$dataorder = array(
					"true_price" =>	$newtrueprice,
					"coupon" => 0
				);
				pdo_update('sudu8_page_order', $dataorder, array('order_id' => $id ,'uniacid' => $uniacid));
				return $this->result(0, 'error',$data);
			}
		}
		if($pro['is_more']==1){
			$numarr = array();
			foreach ($num as $res) {
				array_push($numarr, $res[5]);
			}
			$duock = 0;
			foreach ($more_type_num as $key => &$value) {
				if($value['shennum'] >= $numarr[$key]){
					$duock = 1;
				}else{
					$duock = 0;
				}
			}
			if($duock==1){
				$app = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
				$paycon = pdo_fetch("SELECT * FROM ".tablename('uni_settings')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
				$datas = unserialize($paycon['payment']);
				include 'WeixinPay.php';  
				$appid=$app['key'];  
				$openid= $_GPC['openid'];
				$mch_id=$datas['wechat']['mchid'];  
				$key=$datas['wechat']['signkey']; 

				if(isset($datas['wechat']['identity'])){
					$identity = $datas['wechat']['identity'];
				}else{
					$identity = 1;
				}

				if(isset($datas['wechat']['sub_mchid'])){
					$sub_mchid = $datas['wechat']['sub_mchid'];
				}else{
					$sub_mchid = 0;
				}

		

				$out_trade_no = $_GPC['order_id'];  //订单号
				$body = "商品支付";
				$total_fee = $_GPC['price']*100;
				$weixinpay = new WeixinPay($appid,$openid,$mch_id,$key,$out_trade_no,$body,$total_fee,$identity,$sub_mchid);  
				$return=$weixinpay->pay();  
				return $this->result(0, 'success',$return);
			}else{
				$data = array("message"=>"库存不足！");
				return $this->result(0, 'error',$data);
			}
		}else{
			$app = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
			$paycon = pdo_fetch("SELECT * FROM ".tablename('uni_settings')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
			$datas = unserialize($paycon['payment']);
			include 'WeixinPay.php';  
			$appid=$app['key'];  
			$openid= $_GPC['openid'];
			$mch_id=$datas['wechat']['mchid'];  
			$key=$datas['wechat']['signkey'];  
			if(isset($datas['wechat']['identity'])){
				$identity = $datas['wechat']['identity'];
			}else{
				$identity = 1;
			}

			if(isset($datas['wechat']['sub_mchid'])){
				$sub_mchid = $datas['wechat']['sub_mchid'];
			}else{
				$sub_mchid = 0;
			}


			$out_trade_no = $_GPC['order_id'];  //订单号
			$body = "商品支付";
			$total_fee = $_GPC['price']*100;
			$weixinpay = new WeixinPay($appid,$openid,$mch_id,$key,$out_trade_no,$body,$total_fee,$identity,$sub_mchid);  
			$return=$weixinpay->pay();  
			return $this->result(0, 'success',$return);
		}
	}
	//170821获取单页面
	public function doPagePage(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$pageInfo = pdo_fetch("SELECT name,ename,content FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id = :id " , array(':uniacid' => $uniacid,':id' => $id));
		return $this->result(0, 'success', $pageInfo);
	}
	//170823获取版权内容
	public function doPagecopycon(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$copycon = pdo_fetch("SELECT copycon FROM ".tablename('sudu8_page_copyright')." WHERE uniacid = :uniacid " , array(':uniacid' => $uniacid));
		return $this->result(0, 'success', $copycon);
	}
		//文章详情页表单提交成功邮件提醒
	public function doPagesendMail_form(){
		require_once(IA_ROOT."/framework/library/phpmailer/class.phpmailer.php");
		require_once(IA_ROOT."/framework/library/phpmailer/class.smtp.php");
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$cid = $_GPC['id']; //文章id
		$id = $_GPC['cid']; //表单id
// var_dump(11111);exit;
		$formsConfig = pdo_fetch("SELECT mail_sendto,mail_user,mail_password,mail_user_name FROM ".tablename('sudu8_page_forms_config')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		$mail_sendto = array();
		$mail_sendto =explode(",",$formsConfig['mail_sendto']);
			$row_mail_user = $formsConfig['mail_user'];
			$row_mail_pass = $formsConfig['mail_password'];
			$row_mail_name =$formsConfig['mail_user_name'];
// var_dump(11111);exit;
		$forms = pdo_fetch("SELECT a.*,b.title,b.type FROM ".tablename('sudu8_page_formcon')." as a LEFT JOIN ".tablename('sudu8_page_products')." as b on a.cid = b.id WHERE a.uniacid = :uniacid AND a.id = :id AND a.cid = :cid" , array(':uniacid' => $uniacid,':id' => $id,'cid' => $cid));
		if($forms['type'] == "showArt"){
			$forms['type'] = "文章";
		}
		if($forms['type'] == "showPro"){
			$forms['type'] = "产品";
		}
		$val = unserialize($forms['val']);
		$row_title = "文章名称：".$forms['title']."<br />";
		$row_type = "文章类型：".$forms['type']."<br />";
		$row_oid = "表单信息<br/>编号：".$forms['id']."<br />";
// var_dump(11111);exit;
		$forms_con = "";
		foreach ($val as $key => $v) {
			if($v['z_val']){
				$forms_con .= $v['name'].":<br/>";
				$img = "";
				foreach ($v['z_val'] as $k => $vi) {
					if(stristr($vi, 'http')){
						$img .= "<img src='".$vi."'><br/>";
					}else{
						$img .= "<img src='".HTTPSHOST.$vi."'><br/>";
					}
				}
				$forms_con.=$img;
			}else{
				if(is_array($v['val'])){
					$forms_con .= $v['name'].":";
					$txt_s = "";
					foreach ($v['val'] as $key => $value) {
						$txt_s=$txt_s.$value.",";
					}
					$forms_con.=$txt_s;
				}else{
					$forms_con .= $v['name'].":".$v['val']."<br />";
				}
			}
		}
	 		$mail = new PHPMailer();
	        $mail->CharSet ="utf-8";
	        $mail->Encoding = "base64";
	        $mail->SMTPSecure = "ssl";
	        $mail->IsSMTP();
	        $mail->Port=465;
	        $mail->Host = "smtp.qq.com";
	        $mail->SMTPAuth = true;
	        $mail->SMTPDebug  = false;
	        $mail->Username = $row_mail_user;
	        $mail->Password = $row_mail_pass;
	        $mail->setFrom($row_mail_user,$row_mail_name);
			foreach($mail_sendto as $v)
			{
			  $mail->AddAddress($v);
			}
			$mail->Subject = "新表单 - ".date("Y-m-d H:i:s",time());
			$mail->isHTML(true); 
			$mail->Body = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>表单详情：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>".$row_title.$row_type.$row_oid.$forms_con."<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>".$row_mail_name."</div></div>";
			if(!$mail->send()) {
			    $result = "send_err";
			} else {
			    $result = "send_ok";
			}
		return $this->result(0, 'success', $result);
	}
		//付款成功页面表单提醒 -- 多规格商品
	public function doPagesendMail_form2(){
		require_once(IA_ROOT."/framework/library/phpmailer/class.phpmailer.php");
		require_once(IA_ROOT."/framework/library/phpmailer/class.smtp.php");
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$orderid = $_GPC['orderid']; //订单id
		$id = $_GPC['cid']; //商品id
		$formsConfig = pdo_fetch("SELECT mail_sendto,mail_user,mail_password,mail_user_name FROM ".tablename('sudu8_page_forms_config')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		$mail_sendto = array();
		$mail_sendto =explode(",",$formsConfig['mail_sendto']);
			$row_mail_user = $formsConfig['mail_user'];
			$row_mail_pass = $formsConfig['mail_password'];
			$row_mail_name =$formsConfig['mail_user_name'];
		$orderinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_order')." WHERE uniacid = :uniacid AND id = :id" , array(':uniacid' => $uniacid,':id' => intval($orderid)));
		$forms['type'] = "产品";
		$val = unserialize($orderinfo['beizhu_val']);
		// var_dump($val);exit;
		$row_title = "文章名称：".$orderinfo['product']."<br />";
		$row_type = "文章类型：".$forms['type']."<br />";
		$row_oid = "表单信息<br/>";
// var_dump(11111);exit;
		$forms_con = "";
		foreach ($val as $key => $v) {
			if($v['z_val']){
				$forms_con .= $v['name'].":<br/>";
				$img = "";
				foreach ($v['z_val'] as $k => $vi) {
					if(stristr($vi, 'http')){
						$img .= "<img src='".$vi."'><br/>";
					}else{
						$img .= "<img src='".HTTPSHOST.$vi."'><br/>";
					}
				}
				$forms_con.=$img;
			}else{
				if(is_array($v['val'])){
					$forms_con .= $v['name'].":";
					$txt_s = "";
					foreach ($v['val'] as $key => $value) {
						$txt_s=$txt_s.$value.",";
					}
					$forms_con.=$txt_s;
				}else{
					$forms_con .= $v['name'].":".$v['val']."<br />";
				}
			}
		}
	 		$mail = new PHPMailer();
	        $mail->CharSet ="utf-8";
	        $mail->Encoding = "base64";
	        $mail->SMTPSecure = "ssl";
	        $mail->IsSMTP();
	        $mail->Port=465;
	        $mail->Host = "smtp.qq.com";
	        $mail->SMTPAuth = true;
	        $mail->SMTPDebug  = false;
	        $mail->Username = $row_mail_user;
	        $mail->Password = $row_mail_pass;
	        $mail->setFrom($row_mail_user,$row_mail_name);
			foreach($mail_sendto as $v)
			{
			  $mail->AddAddress($v);
			}
			$mail->Subject = "新表单 - ".date("Y-m-d H:i:s",time());
			$mail->isHTML(true); 
			$mail->Body = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>表单详情：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>".$row_title.$row_type.$row_oid.$forms_con."<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>".$row_mail_name."</div></div>";
			if(!$mail->send()) {
			    $result = "send_err";
			} else {
			    $result = "send_ok";
			}
		return $this->result(0, 'success', $result);
	}
	//付款成功邮件提醒 -- 普通商品
	public function doPagesendMail_order(){
		require_once(IA_ROOT."/framework/library/phpmailer/class.phpmailer.php");
		require_once(IA_ROOT."/framework/library/phpmailer/class.smtp.php");
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$order_id = $_GPC['order_id'];
		$formsConfig = pdo_fetch("SELECT mail_sendto,mail_user,mail_password,mail_user_name FROM ".tablename('sudu8_page_forms_config')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		$mail_sendto = array();
		$mail_sendto =explode(",",$formsConfig['mail_sendto']);
			$row_mail_user = $formsConfig['mail_user'];
			$row_mail_pass = $formsConfig['mail_password'];
			$row_mail_name =$formsConfig['mail_user_name'];
		$ord = pdo_fetch("SELECT order_id,product,price,num,true_price,pro_user_name,pro_user_tel,pro_user_add,pro_user_txt,is_more,order_duo,beizhu_val FROM ".tablename('sudu8_page_order')." WHERE uniacid = :uniacid AND order_id = :oid" , array(':uniacid' => $uniacid,':oid' => $order_id));
		$row_oid = "订单编号：".$ord['order_id']."<br />";
		$row_pro = "产品名称：".$ord['product']."<br />";
		if($ord['is_more'] == 1){
			$row_prc = "";
			if(count(unserialize($ord['order_duo']))>0){
				for($i =0;$i<count(unserialize($ord['order_duo']));$i++){
					$row_prc .= "规格：".unserialize($ord['order_duo'])[$i][0].",购买金额：".unserialize($ord['order_duo'])[$i][1]." x ".unserialize($ord['order_duo'])[$i][4]."<br />";
				}
				$row_prc .= "实付：".$ord['true_price']."<br />";
				if($ord['beizhu_val'] || $ord['pro_user_name'] || $ord['pro_user_tel'] || $ord['pro_user_add'] || $ord['pro_user_txt'] || $ord['overtime']){
					$row_prc.="===================订单留言===================<br />";
				}
				//万能表单的信息
				if($ord['beizhu_val']){
					$beizhuarr = unserialize($ord['beizhu_val']);
					foreach ($beizhuarr as $key33 => &$recb) {
						if($recb['val']){
							$row_prc.= $recb['name']."：". $recb['val']."<br />";
						}
					}
					$row_prc.="<br />";
				}
				//普通订单的信息
				if($ord['pro_user_name']){
					$row_prc.="姓名：". $ord['pro_user_name']."<br />";
				}
				if($ord['pro_user_tel']){
					$row_prc.="手机：". $ord['pro_user_tel']."<br />";
				}
				if($ord['pro_user_add']){
					$row_prc.="地址：". $ord['pro_user_add']."<br />";
				}
				if($ord['pro_user_txt']){
					$row_prc.="备注：". $ord['pro_user_txt']."<br />";
				}
				if($ord['overtime']){
					$row_prc.="时间：". date("Y-m-d H:i",$ord['overtime'])."<br />";
				}
			}
		}else{
			$row_prc = "购买金额：".$ord['price']." x ".$ord['num']." = ".$ord['true_price']."<br />";
			$row_nam = "联系姓名：".$ord['pro_user_name']."<br />";
			$row_tel = "联系电话：".$ord['pro_user_tel']."<br />";
			$row_add = "地址：".$ord['pro_user_add']."<br />";
			$row_txt = "留言备注：".$ord['pro_user_txt']."<br />";
		}
	 		$mail = new PHPMailer();
	        $mail->CharSet ="utf-8";
	        $mail->Encoding = "base64";
	        $mail->SMTPSecure = "ssl";
	        $mail->IsSMTP();
	        $mail->Port=465;
	        $mail->Host = "smtp.qq.com";
	        $mail->SMTPAuth = true;
	        $mail->SMTPDebug  = false;
	        $mail->Username = $row_mail_user;
	        $mail->Password = $row_mail_pass;
	        $mail->setFrom($row_mail_user,$row_mail_name);
			foreach($mail_sendto as $v)
			{
			  $mail->AddAddress($v);
			}
			$mail->Subject = "新订单 - ".date("Y-m-d H:i:s",time());
			$mail->isHTML(true); 
			if($ord['is_more'] == 1){
				$mail->Body    = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>订单详情：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>".$row_oid.$row_pro.$row_prc."<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>".$row_mail_name."</div></div>";
			}else{
				$mail->Body    = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>订单详情：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>".$row_oid.$row_tim.$row_pro.$row_prc.$row_nam.$row_tel.$row_address.$row_txt."<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>".$row_mail_name."</div></div>";
			}
			if(!$mail->send()) {
			    $result = "send_err";
			} else {
			    $result = "send_ok";
			}
		return $this->result(0, 'success', $result);
	}
	//付款成功邮件提醒 -- 餐饮
	public function doPagesendMail_foodorder(){
		require_once(IA_ROOT."/framework/library/phpmailer/class.phpmailer.php");
		require_once(IA_ROOT."/framework/library/phpmailer/class.smtp.php");
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$order_id = $_GPC['order_id'];
		$formsConfig = pdo_fetch("SELECT mail_sendto,mail_user,mail_password,mail_user_name FROM ".tablename('sudu8_page_forms_config')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		$mail_sendto = array();
		$mail_sendto =explode(",",$formsConfig['mail_sendto']);
			$row_mail_user = $formsConfig['mail_user'];
			$row_mail_pass = $formsConfig['mail_password'];
			$row_mail_name =$formsConfig['mail_user_name'];
		$ord = pdo_fetch("SELECT order_id,username,usertel,address,userbeiz,usertime,creattime,price,val FROM ".tablename('sudu8_page_food_order')." WHERE uniacid = :uniacid AND order_id = :oid" , array(':uniacid' => $uniacid,':oid' => $order_id));
			$pro = array();
			$pro = unserialize($ord['val']);
			foreach($pro as $v)
			{
			  $row_con = $v['title']."x".$v['num']." = ".$v['price']."<br/>".$row_con;
			}
			$row_oid = "订单编号：".$ord['order_id']."<br />";
			$row_pro = "订单内容：<br />".$row_con."<br />";
			$row_prc = "支付金额：".$ord['price']."<br />";
			$row_nam = "联系姓名：".$ord['username']."<br />";
			$row_tel = "联系电话：".$ord['usertel']."<br />";
			$row_add = "预定地址：".$ord['address']."<br />";
			$row_time = "预定时间：".$ord['usertime']."<br />";
			$row_txt = "留言备注：".$ord['userbeiz']."<br />";
	 		$mail = new PHPMailer();
	        $mail->CharSet ="utf-8";
	        $mail->Encoding = "base64";
	        $mail->SMTPSecure = "ssl";
	        $mail->IsSMTP();
	        $mail->Port=465;
	        $mail->Host = "smtp.qq.com";
	        $mail->SMTPAuth = true;
	        $mail->SMTPDebug  = false;
	        $mail->Username = $row_mail_user;
	        $mail->Password = $row_mail_pass;
	        $mail->setFrom($row_mail_user,$row_mail_name);
			foreach($mail_sendto as $v)
			{
			  $mail->AddAddress($v);
			}
			$mail->Subject = "新订单 - ".date("Y-m-d H:i:s",time());
			$mail->isHTML(true); 
			$mail->Body    = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>订单详情：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>".$row_oid.$row_pro.$row_prc.$row_nam.$row_tel.$row_add.$row_time.$row_txt."<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>".$row_mail_name."</div></div>";
			//var_dump($mail->Body);
			if(!$mail->send()) {
			    $result = "send_err";
			} else {
			    $result = "send_ok";
			}
		return $this->result(0, 'success', $result);
	}
	//付款成功邮件提醒 -- 拼团
	public function doPagesendMail_order_pt(){
		require_once(IA_ROOT."/framework/library/phpmailer/class.phpmailer.php");
		require_once(IA_ROOT."/framework/library/phpmailer/class.smtp.php");
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$order_id = $_GPC['order_id'];
		$formsConfig = pdo_fetch("SELECT mail_sendto,mail_user,mail_password,mail_user_name FROM ".tablename('sudu8_page_forms_config')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		$mail_sendto = array();
		$mail_sendto =explode(",",$formsConfig['mail_sendto']);
			$row_mail_user = $formsConfig['mail_user'];
			$row_mail_pass = $formsConfig['mail_password'];
			$row_mail_name =$formsConfig['mail_user_name'];
		$ord = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_order')." WHERE uniacid = :uniacid AND order_id = :oid" , array(':uniacid' => $uniacid,':oid' => $order_id));
		$row_oid = "订单编号：".$ord['order_id']."<br />";
		$pro = unserialize($ord['jsondata']);
		$row_pro = "产品名称：".$pro[0]['title']."<br />";
		$row_pro .= "产品规格：".$pro[0]['proinfo']['ggz']."<br />";
		$row_pro .= "支付金额：".$ord['price']."<br />";
		$row_prc = "<br />";
		$row_prc.="===================订单地址===================<br />";
		// 去查询订单的收货地址
		if($ord['nav']==2){//到店自提
			$row_prc.= "到店自提<br />";
		}else{
			$address = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_address')." WHERE uniacid = :uniacid AND id = :id" , array(':uniacid' => $uniacid,':id' => $ord['address']));
			$row_prc.= "联系姓名：".$address['name']."<br />";
			$row_prc.= "联系电话：".$address['mobile']."<br />";
			$row_prc.= "联系地址：".$address['address']."<br />";
			$row_prc.= "详细地址：".$address['more_address']."<br />";
			$row_prc.= "邮编：".$address['postalcode']."<br />";
		}
 		$mail = new PHPMailer();
        $mail->CharSet ="utf-8";
        $mail->Encoding = "base64";
        $mail->SMTPSecure = "ssl";
        $mail->IsSMTP();
        $mail->Port=465;
        $mail->Host = "smtp.qq.com";
        $mail->SMTPAuth = true;
        $mail->SMTPDebug  = false;
        $mail->Username = $row_mail_user;
        $mail->Password = $row_mail_pass;
        $mail->setFrom($row_mail_user,$row_mail_name);
		foreach($mail_sendto as $v)
		{
		  $mail->AddAddress($v);
		}
		$mail->Subject = "新订单 - ".date("Y-m-d H:i:s",time());
		$mail->isHTML(true); 
		$mail->Body    = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>订单详情：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>".$row_oid.$row_pro.$row_prc."<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>".$row_mail_name."</div></div>";
		if(!$mail->send()) {
		    $result = "send_err";
		} else {
		    $result = "send_ok";
		}
		return $this->result(0, 'success', $result);
	}
	//付款成功邮件提醒 -- 购物车
	public function doPagesendMail_order_gwc(){
		require_once(IA_ROOT."/framework/library/phpmailer/class.phpmailer.php");
		require_once(IA_ROOT."/framework/library/phpmailer/class.smtp.php");
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$order_id = $_GPC['order_id'];
		$formsConfig = pdo_fetch("SELECT mail_sendto,mail_user,mail_password,mail_user_name FROM ".tablename('sudu8_page_forms_config')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		$mail_sendto = array();
		$mail_sendto =explode(",",$formsConfig['mail_sendto']);
			$row_mail_user = $formsConfig['mail_user'];
			$row_mail_pass = $formsConfig['mail_password'];
			$row_mail_name =$formsConfig['mail_user_name'];
		$ord = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid AND order_id = :oid" , array(':uniacid' => $uniacid,':oid' => $order_id));
		$row_oid = "订单编号：".$ord['order_id']."<br />";
		$pro = unserialize($ord['jsondata']);
		$row_pro = "";
		foreach ($pro as $key5 => &$resb) {
			$row_pro .= "产品名称：".$resb['baseinfo']['title']."<br />";
			$row_pro .= "产品规格：".$resb['proinfo']['ggz']."<br />";
		}
		$row_pro .= "支付金额：".$ord['price']."<br />";
		$row_prc = "<br />";
		$row_prc.="===================订单地址===================<br />";
		// 去查询订单的收货地址
		if($ord['nav']==2){//到店自提
			$row_prc.= "到店自提<br />";
		}else{
			$address = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_address')." WHERE uniacid = :uniacid AND id = :id" , array(':uniacid' => $uniacid,':id' => $ord['address']));
			$row_prc.= "联系姓名：".$address['name']."<br />";
			$row_prc.= "联系电话：".$address['mobile']."<br />";
			$row_prc.= "联系地址：".$address['address']."<br />";
			$row_prc.= "详细地址：".$address['more_address']."<br />";
			$row_prc.= "邮编：".$address['postalcode']."<br />";
		}
 		$mail = new PHPMailer();
        $mail->CharSet ="utf-8";
        $mail->Encoding = "base64";
        $mail->SMTPSecure = "ssl";
        $mail->IsSMTP();
        $mail->Port=465;
        $mail->Host = "smtp.qq.com";
        $mail->SMTPAuth = true;
        $mail->SMTPDebug  = false;
        $mail->Username = $row_mail_user;
        $mail->Password = $row_mail_pass;
        $mail->setFrom($row_mail_user,$row_mail_name);
		foreach($mail_sendto as $v)
		{
		  $mail->AddAddress($v);
		}
		$mail->Subject = "新订单 - ".date("Y-m-d H:i:s",time());
		$mail->isHTML(true); 
		$mail->Body    = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>订单详情：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>".$row_oid.$row_pro.$row_prc."<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>".$row_mail_name."</div></div>";
		if(!$mail->send()) {
		    $result = "send_err";
		} else {
		    $result = "send_ok";
		}
		return $this->result(0, 'success', $result);
	}
	// 优惠券管理
	public function doPagecoupon(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		if($openid){
			$user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid", array(':uniacid' => $uniacid,':openid' => $openid));
		}
		$uid = $user['id'];
		// var_dump($openid);
		// var_dump($user);
  		//       die();
		$coupon= pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE uniacid = :uniacid and flag = 1 ORDER BY num DESC,id DESC", array(':uniacid' => $uniacid));
		foreach ($coupon as $key => &$res) {
            //1.判断优惠券有没有领完 0 领完了  1未领完
            $isover = 1;
            if($res['counts'] ==0){
            	$isover = 0;
            }else{
            	$isover = 1;
            }
            $res['isover'] = $isover;
            //2.判断优惠券有没有过期 0过期  1未过期
            $isover_time = 1;
            $nowtime = time();
            if($res['btime']!=0 && $res['etime']!=0){
            	if($nowtime>=$res['btime'] && $nowtime<=$res['etime']){   //现在的时间在设置时间区间内算未过期
            		$isover_time = 1;
            	}else{
            		$isover_time = 0;
            	}
            }
            if($res['btime']!=0 && $res['etime'] ==0){
            	if($nowtime>=$res['btime']){   // 现在的时间大于了开始的时间
					$isover_time = 1;
            	}else{
            		$isover_time = 0;
            	}
            }
            if($res['btime'] ==0 && $res['etime']!=0){
            	if($nowtime<=$res['btime']){   // 现在的时间小于了结束的时间
					$isover_time = 1;
            	}else{
            		$isover_time = 0;
            	}
            }
            if($res['btime']==0 && $res['etime']==0){
            	$isover_time = 1;
            }
            $res['isover_time'] = $isover_time;
            //3.判断我有没有领取过这个优惠券
            $is_get = 1;
            $yhqbuy = pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_coupon_user')." WHERE uniacid = :uniacid and cid = :id and uid = :uid" , array(':uniacid' => $_W['uniacid'],":id" => $res['id'],':uid'=>$uid));
            if($res['xz_count'] == 0){
            	$coupon[$key]['nowCount'] = "无限";
            }else{
            	$coupon[$key]['nowCount'] = intval($res['xz_count']) - intval($yhqbuy['n']);
            }
            if($res['xz_count']>0 && $yhqbuy['n']>=$res['xz_count']){
            	$is_get = 0;
            }
            $res['is_get'] = $is_get;
            $yhqs =  pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_coupon_user')." WHERE uniacid = :uniacid and cid = :id" , array(':uniacid' => $_W['uniacid'],":id" => $res['id']));
            $res['kc'] = $res['counts'];
            if($res['btime']!=0){
            	$res['btime'] = date("Y-m-d",$res['btime']);
            }
            if($res['etime']!=0){
            	$res['etime'] = date("Y-m-d",$res['etime']);
            }	
		}
		return $this->result(0, 'success', $coupon);
	}
	public function doPagegetcoupon(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$id = $_GPC['id'];
		if($openid){
			$user = pdo_fetch("SELECT * from".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid" , array(':uniacid' => $uniacid,":openid" => $openid));
		}
		$uid = $user['id']; 
		$coupon = pdo_fetch("SELECT * from".tablename('sudu8_page_coupon')." WHERE uniacid = :uniacid and id = :id" , array(':uniacid' => $_W['uniacid'],":id" => $id));
		$data = array(
			"uniacid" => $uniacid,
			"uid" => $uid,
			"cid"=>$id,
			"ltime" =>time(),
			"flag" => 0,
			"btime" => $coupon['btime'],
			"etime" => $coupon['etime']
		);
		// var_dump($data);
		// die();
		$kid = 1;
		if($coupon['counts'] >0 || $coupon['counts'] == -1){
			$res = pdo_insert('sudu8_page_coupon_user',$data);
			if($coupon['counts'] == -1){
				$counts = -1;
			}else{
				$counts = $coupon['counts']-1;
			}
			$data2 = array(
				"nownum" => $coupon['nownum']+ 1,
				"counts" => $counts,
			);
			pdo_update('sudu8_page_coupon',$data2,array("id"=>$id,"uniacid"=>$uniacid));
			$kid = 1;
		}else{
			$kid = 2;
		}
		return $this->result(0, 'success', $kid);
	}
	public function doPagemycoupon(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$flag = $_GPC['flag'];
		$tiaojian = " and flag <> 2 and flag = 0";
		if($flag == 0){
			$tiaojian = " and flag <> 2 and flag = 0";
		}
		if ($flag == 1) {
			$tiaojian = " and flag <> 2";
		}
		if($openid){
			$user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid", array(':uniacid' => $uniacid,':openid' => $openid));
		}
		$uid = $user['id'];
		$yhqsold =  pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE uniacid = :uniacid and uid = :id  ".$tiaojian." ORDER BY id DESC" , array(':uniacid' => $_W['uniacid'],":id" => $uid));
		$time = time();
		$aa = [];
		foreach ($yhqsold as $key => &$res) {
			$arrs = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE uniacid = :uniacid and id = :id ", array(':uniacid' => $uniacid,'id'=>$res['cid']));
			if($arrs['btime']!=0){
            	$arrs['btime'] = date("Y-m-d",$arrs['btime']);
            }
            if($arrs['etime']!=0){
            	if($time > $arrs['etime'] && $res['flag'] == 0){
            		$kdata=array(
						"flag" => 2
					);
					pdo_update("sudu8_page_coupon_user",$kdata,array("id"=>$res['id']));
            	}
            	$arrs['etime'] = date("Y-m-d",$arrs['etime']);
            }	
		}
		// 重新获取过滤后的我的优惠券
		$yhqs =  pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE uniacid = :uniacid and uid = :id  ".$tiaojian." ORDER BY id DESC" , array(':uniacid' => $_W['uniacid'],":id" => $uid));
		foreach ($yhqs as $key => &$res) {
			$arrss = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE uniacid = :uniacid and id = :id ", array(':uniacid' => $uniacid,'id'=>$res['cid']));
			if($arrss['btime']!=0){
            	$arrss['btime'] = date("Y-m-d",$arrss['btime']);
            }
            if($arrss['etime']!=0){
            	$arrss['etime'] = date("Y-m-d",$arrss['etime']);
            }	
            $res['coupon']= $arrss;
		}
		return $this->result(0, 'success', $yhqs);
	}
	public function doPageCollect(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$cid = $_GPC['id'];
		$openid = $_GPC['openid'];
		$type = $_GPC['types'];
		if($openid){
			$user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid", array(':uniacid' => $uniacid,':openid' => $openid));
		}
		$uid = $user['id'];
		//先判断有没有收藏过
		$collect = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_collect')." WHERE uniacid = :uniacid and uid = :uid and type = :type and cid = :cid", array(':uniacid' => $uniacid,':uid' => $uid,':type' => $type, ':cid'=> $cid));
		if($collect){
			$res = pdo_delete('sudu8_page_collect', array('uniacid' => $uniacid,'uid' => $uid,'type' => $type, 'cid'=> $cid));
			if($res){
				return $this->result(0, 'success', "取消收藏成功");
			}
		}else{
			$data=array(
				"uid" => $uid,
				"type" => $type,
				"cid" => $cid,
				"uniacid" => $uniacid
			);
			$res = pdo_insert('sudu8_page_collect', $data);
			if($res){
				return $this->result(0, 'success', "收藏成功");
			}
		}
	}
	public function doPagegetCollect(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		if($openid){
			$user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid", array(':uniacid' => $uniacid,':openid' => $openid));
			$uid = $user['id'];
			$collect = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_collect')." WHERE uniacid = :uniacid and uid = :uid LIMIT ".($pindex - 1) * $psize.",".$psize, array(':uniacid' => $uniacid,':uid' => $uid));
			$all = pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_collect')." WHERE uniacid = :uniacid and uid = :uid ", array(':uniacid' => $uniacid,':uid' => $uid));
			$num = $all['n'];
			$arr = array();
			foreach ($collect as $key => &$rec) {
				$pro = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid and flag = 1" , array(':id' => $rec['cid'] ,':uniacid' => $uniacid));
				if($pro['type']=="showPro" && $pro['is_more']==1){
					$pro['type'] = "showPro_lv";
				}
				if(!$pro['sale_num']){
					$pro['sale_num'] = 0;
				}
				if(stristr($pro['thumb'], 'http')){
					$pro['thumb'] = $pro['thumb'];
				}else{
					$pro['thumb'] = HTTPSHOST.$pro['thumb'];
				}
				$arr['list'][] = $pro;
			}
			$arr['num'] = ceil ($num/$psize);
			return $this->result(0, 'success', $arr);
		}
	}
	public function doPagegetorderv(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		if($openid){
			$collect = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_video_pay')." WHERE uniacid = :uniacid and openid = :openid LIMIT ".($pindex - 1) * $psize.",".$psize, array(':uniacid' => $uniacid,':openid' => $openid));
			$all = pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_video_pay')." WHERE uniacid = :uniacid and openid = :openid ", array(':uniacid' => $uniacid,':openid' => $openid));
			$num = $all['n'];
			$arr = array();
			foreach ($collect as $key => &$rec) {
				$pro = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid and flag = 1" , array(':id' => $rec['pid'] ,':uniacid' => $uniacid));
				$pro['paymoney'] = $rec['paymoney'];
				$pro['paytime'] = date("Y-m-d H:i:s",$rec['creattime']);
				if(stristr($pro['thumb'], 'http')){
					$pro['thumb'] = $pro['thumb'];
				}else{
					$pro['thumb'] = HTTPSHOST.$pro['thumb'];
				}
				$arr['list'][] = $pro;
			}
			$arr['num'] = ceil ($num/$psize);
			return $this->result(0, 'success', $arr);
		}
	}
	public function doPagestoreConf(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$store =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_storeconf')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		if($store == false){
			$store['flag'] = 0;
		}
		return $this->result(0, 'success', $store);
	}
	public function doPageStore(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$radius=6378.135;
		$keyword = $_GPC['keyword'];
		if($keyword){
			$store['list'] =  pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_store')." WHERE uniacid = :uniacid and title like '%".$keyword."%' ORDER BY id DESC" , array(':uniacid' => $uniacid));
			$store['num'] = pdo_fetchall("SELECT count(title) as num FROM ".tablename('sudu8_page_store')." WHERE uniacid = :uniacid and title like '%".$keyword."%' ORDER BY id DESC" , array(':uniacid' => $uniacid));
			foreach ($store['list'] as $key => &$res) {
				$res['logo'] = HTTPSHOST.$res['logo'];
				$rad = doubleval(M_PI/180.0);
			    $lat1 = doubleval($_GPC['lat']) * $rad;
			    $lon1 = doubleval($_GPC['lon']) * $rad;
			    $lat2 = doubleval($res['lat']) * $rad;
			    $lon2 = doubleval($res['lon']) * $rad;
			    $theta = $lon2 - $lon1;
			    $dist = acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($theta));
			    if($dist < 0) {
			      $dist += M_PI;
			    }
			    $dist = $dist * $radius;
			    $formatted = round($dist, 2);
			   	$res['kms'] = $formatted;
			}
			$arry = $store['list'];
			for ( $i = 0; $i < count($arry); $i++) {
			   for ($j = $i + 1; $j < count($arry); $j++) {   
			    if ($arry[$i]['kms']> $arry[$j]['kms']) {   
			    	$new = $arry[$i];   
			     	$arry[$i] = $arry[$j];   
			     	$arry[$j] = $new;   
			    }
			   }
			}
			$store['list'] = $arry;
		}else{
			$store['list'] =  pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_store')." WHERE uniacid = :uniacid ORDER BY id DESC" , array(':uniacid' => $uniacid));
			$store['num'] = pdo_fetchall("SELECT count(title) as num FROM ".tablename('sudu8_page_store')." WHERE uniacid = :uniacid ORDER BY id DESC" , array(':uniacid' => $uniacid));
			foreach ($store['list'] as $key => &$res) {
				$res['logo'] = HTTPSHOST.$res['logo'];
				$rad = doubleval(M_PI/180.0);
			    $lat1 = doubleval($_GPC['lat']) * $rad;
			    $lon1 = doubleval($_GPC['lon']) * $rad;
			    $lat2 = doubleval($res['lat']) * $rad;
			    $lon2 = doubleval($res['lon']) * $rad;
			    $theta = $lon2 - $lon1;
			    $dist = acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($theta));
			    if($dist < 0) {
			      $dist += M_PI;
			    }
			    $dist = $dist * $radius;
			    $formatted = round($dist, 2);
			   	$res['kms'] = $formatted;
			}
			$arry = $store['list'];
			for ( $i = 0; $i < count($arry); $i++) {
			   for ($j = $i + 1; $j < count($arry); $j++) {   
			    if ($arry[$i]['kms']> $arry[$j]['kms']) {   
			    	$new = $arry[$i];   
			     	$arry[$i] = $arry[$j];   
			     	$arry[$j] = $new;   
			    }
			   }
			}
			$store['list'] = $arry;
		}
		return $this->result(0, 'success', $store);
	}
	public function doPageStoreNew(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$radius=6378.135;
		$city = $_GPC['currentCity'];
		$store['list'] =  pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_store')." WHERE uniacid = :uniacid and city = :city ORDER BY id DESC" , array(':uniacid' => $uniacid,':city' => $city));
		$store['num'] = pdo_fetchall("SELECT count(title) as num FROM ".tablename('sudu8_page_store')." WHERE uniacid = :uniacid and city = :city ORDER BY id DESC" , array(':uniacid' => $uniacid,':city' => $city));
		foreach ($store['list'] as $key => &$res) {
			if(stristr($res['logo'], 'http')){
				$res['logo'] = $res['logo'];
			}else{
				$res['logo'] = HTTPSHOST.$res['logo'];
			}
			$rad = doubleval(M_PI/180.0);
		    $lat1 = doubleval($_GPC['lat']) * $rad;
		    $lon1 = doubleval($_GPC['lon']) * $rad;
		    $lat2 = doubleval($res['lat']) * $rad;
		    $lon2 = doubleval($res['lon']) * $rad;
		    $theta = $lon2 - $lon1;
		    $dist = acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($theta));
		    if($dist < 0) {
		      $dist += M_PI;
		    }
		    $dist = $dist * $radius;
		    $formatted = round($dist, 2);
		   	$res['kms'] = $formatted;
		}
		$arry = $store['list'];
		for ( $i = 0; $i < count($arry); $i++) {   
		   for ($j = $i + 1; $j < count($arry); $j++) {   
		    if ($arry[$i]['kms']> $arry[$j]['kms']) {   
		    	$new = $arry[$i];   
		     	$arry[$i] = $arry[$j];   
		     	$arry[$j] = $new;   
		    }   
		   }   
		}
		$store['list'] = $arry;
		return $this->result(0, 'success', $store);
	}
	public function doPageShowstore(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$id = $_GPC['id'];
		$store =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_store')." WHERE uniacid = :uniacid and id = :id ORDER BY id DESC" , array(':uniacid' => $uniacid,':id' => $id));
		if(stristr($store['thumb'], 'http')){
			$store['thumb'] =  $store['thumb'];
		}else{
			$store['thumb'] = HTTPSHOST.$store['thumb'];
		}
		if(stristr($store['logo'], 'http')){
			$store['logo'] = $store['logo'];
		}else{
			$store['logo'] = HTTPSHOST.$store['logo'];
		}
        $imgs = unserialize($store['text']);
        $newimgs = array();
        foreach ($imgs as $key => &$res) {
        	if(stristr( $res, 'http')){
				$newimgs[] = $res;
			}else{
				$newimgs[] = HTTPSHOST.$res;
			}
        }
        $store['text'] = $newimgs;
        $list_y_sp = pdo_fetchall("SELECT id,type,num,title,thumb,ctime,hits,`desc`,price,market_price,sale_num,buy_type,is_more FROM ".tablename('sudu8_page_products')." WHERE type_y=1 and flag = 1 and uniacid = :uniacid and (type = 'showPro' or type = 'showProMore') ORDER BY num DESC,id DESC LIMIT 0 , 10"  , array(':uniacid' => $uniacid));
		foreach ($list_y_sp as  &$row){
			if(stristr($row['thumb'], 'http')){
	  				$row['thumb'] = $row['thumb'];
				}else{
	  				$row['thumb'] = HTTPSHOST.$row['thumb'];
				}
			$row['ctime'] = date("y-m-d H:i:s",$row['ctime']);
			if($row['type']=="showPro" && $row['is_more'] == 1){
				$row['type'] = "showPro_lv";
			}
		}
		$store['prolist'] = $list_y_sp;
		return $this->result(0, 'success', $store);
	}
	public function doPageProductsearch(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$title = "%".$_GPC['title']."%";
		$flag = 1;
		$product = pdo_fetchall("SELECT id,title,thumb,type,`desc`,ctime,buy_type,price,sale_num,sale_tnum,hits,is_more FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and flag = :flag and title like :title  ORDER BY id DESC" , array(':uniacid' => $uniacid,':flag' => $flag,':title' => $title));
		foreach ($product as  &$row){
			if($row['is_more'] == 1){
				$row['type'] = "showPro_lv";
			}
			if($row['is_more'] == 3){
				$row['sale_num'] = $row['sale_tnum'];
			}
			if(stristr( $row['thumb'], 'http')){
				$row['thumb'] = $row['thumb'];
			}else{
				$row['thumb'] = HTTPSHOST.$row['thumb'];
			}
			$row['ctime'] = date("Y-m-d",$row['ctime']);
		}
		return $this->result(0, 'success', $product);
	}
	//餐饮开始
	public function doPageDingtype(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$types = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_food_cate')." WHERE uniacid = :uniacid  order by num,id desc" , array(':uniacid' => $uniacid));
		return $this->result(0, 'success', $types);
	}
	public function doPageDingcai(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$cates = pdo_fetchall("SELECT a.cid,b.title FROM ".tablename('sudu8_page_food')."as a LEFT JOIN".tablename('sudu8_page_food_cate')."as b on a.cid = b.id WHERE a.uniacid = :uniacid GROUP BY a.cid ORDER BY b.num,b.id desc ", array(':uniacid' => $uniacid));
		foreach ($cates as $key => &$rec) {
			$pro = pdo_fetchall("SELECT *,a.id as oid,a.title AS otitle FROM ".tablename('sudu8_page_food')."as a LEFT JOIN".tablename('sudu8_page_food_cate')."as b on a.cid = b.id WHERE a.uniacid = :uniacid and a.cid = :cid ORDER BY b.num,b.id desc", array(':uniacid' => $uniacid,':cid' => $rec['cid']));
			$arr = $this->gaichang($pro);
			$rec['val'] = $arr;
		}
		return $this->result(0, 'success', $cates);
	}
	function gaichang($pro){
		if($pro){
			foreach ($pro as $key => &$res) {
				$res['text'] = unserialize($res['text']);
				$labels = unserialize($res['labels']);
				$lab = $this->clabels($labels);
				$res['labels'] = $lab;
				if(stristr( $res['thumb'], 'http')){
					$res['thumb'] = $res['thumb'];
				}else{
					$res['thumb'] = HTTPSHOST.$res['thumb'];
				}
				if($res['descimg']){
					if(stristr( $res['descimg'], 'http')){
						$res['descimg'] = $res['descimg'];
					}else{
						$res['descimg'] = HTTPSHOST.$res['descimg'];
					}
				}else{
					$res['descimg'] = $res['thumb'];
				}
				if(empty($res['desccon'])){
					$res['desccon'] = $res['otitle'];
				}
			}
		}
		return $pro;
	}
	function clabels($labels){
		if($labels){
			$arr = array();
			foreach ($labels as $key => &$res) {
				$kk = explode(":", $res);
				$k1 = $kk[0];
				$k2 = $kk[1];
				if($k2){
					$karr = explode(",", $k2);
				}
				$arr[$key]['title'] = $k1;
				$arr[$key]['val'] = $karr;
			}
			return $arr;
		}else{
			return $arr;
		}
	}
	function doPageOrderpaymoney(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$allprice = $_GPC['price'];
		$now = time();
		$order_id = $order = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
		$app = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		$paycon = pdo_fetch("SELECT * FROM ".tablename('uni_settings')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		$datas = unserialize($paycon['payment']);
		include 'WeixinPay.php';  
		$appid=$app['key'];  
		$openid= $_GPC['openid'];
		$mch_id=$datas['wechat']['mchid'];  
		$key=$datas['wechat']['signkey'];  
		if(isset($datas['wechat']['identity'])){
			$identity = $datas['wechat']['identity'];
		}else{
			$identity = 1;
		}

		if(isset($datas['wechat']['sub_mchid'])){
			$sub_mchid = $datas['wechat']['sub_mchid'];
		}else{
			$sub_mchid = 0;
		}


		$out_trade_no = $order_id;  //订单号
		$body = "商品支付";
		$total_fee = $_GPC['price']*100;
		$weixinpay = new WeixinPay($appid,$openid,$mch_id,$key,$out_trade_no,$body,$total_fee,$identity,$sub_mchid);  

		$return=$weixinpay->pay(); 
		$return['order_id'] = $order_id;
		return $this->result(0, 'success',$return);
	}
	function doPageZhifdingd(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$gwc = $_GPC['gwc'];
		$order_id = $_GPC['order_id'];
		$openid = $_GPC['openid'];
		$my_pay_money = $_GPC['money_mypay'];
		$allprice = $_GPC['price'];
		$score = $_GPC['jifen_score'];
		$zh = $_GPC['zh'];
		$gwc = stripslashes(html_entity_decode($gwc));
		$gwc = json_decode($gwc,TRUE);
		$newgwc = serialize($gwc);
		$xinxi = $_GPC['xinxi'];
		$xinxi = stripslashes(html_entity_decode($xinxi));
		$xinxi = json_decode($xinxi,TRUE);
		$data['username'] = $xinxi['username'];
		$data['usertel'] = $xinxi['usertel'];
		$data['address'] = $xinxi['address'];
		$data['usertime'] = $xinxi['userdate']." ".$xinxi['usertime']; 
		$data['userbeiz'] = $xinxi['userbeiz']; 
		//获得用户信息
		$user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :id and uniacid = :uniacid" , array(':id' => $openid ,':uniacid' => $uniacid));
		$money_u = $user['money'];
		$score_u = $user['score']; 
		$kdata['money'] = $money_u - $my_pay_money;
		$kdata['score'] = $score_u - $score;
		$data['order_id'] = $order_id;
		$data['uniacid'] = $uniacid;
		$data['uid'] = $user['id'];
		$data['openid'] = $openid;
		$data['val'] = $newgwc;
		$data['price'] = $allprice;
		$data['creattime'] = time();
		$data['flag'] = 1;
		$data['zh'] = $zh;
		pdo_update('sudu8_page_user', $kdata, array('openid' => $openid ,'uniacid' => $uniacid));
		pdo_insert("sudu8_page_food_order",$data);
	}
	function doPageMycai(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$oepnid = $_GPC['openid'];
		$orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_food_order')." WHERE uniacid = :uniacid and openid = :openid ORDER BY `creattime` DESC ", array(':uniacid' => $uniacid,':openid' => $oepnid));
        foreach ($orders as &$res) {
   			$res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
   			$res['val'] = $this->chuli(unserialize($res['val']));
        }
        return $this->result(0, 'success',$orders);
	}
	function chuli($arr){
		global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        if($arr){
            foreach ($arr as $key => &$res) {
                $products = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_food')." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid,':id'=>$res['id']));
                if(stristr( $products['thumb'], 'http')){
					$res['thumb'] =  $products['thumb'];
				}else{
					$res['thumb'] =  HTTPSHOST.$products['thumb'];
				}
            }
            return $arr;
        }
	}
	function doPageShangjbs(){
		global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
		$shangjbase = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_food_sj')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
		if($shangjbase['thumb']){
			$shangjbase['thumb'] =  HTTPSHOST.$shangjbase['thumb'];
		}
		if($shangjbase['tags']){
			$shangjbase['tags'] =explode(",",$shangjbase['tags']);
		}
		//处理积分规则
		//获得用户金钱
        $user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $uniacid));
        $money = $user['money'];
        $score = $user['score'];
        // 积分兑换金额
        $jf_gz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_rechargeconf')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
        if(!$jf_gz){
        	$jf_gz['scroe'] = 10000;
        	$jf_gz['money'] = 1;
        }
        $jf_money = intval($score/$jf_gz['scroe'])*$jf_gz['money'];   			//1.我的积分可以换取多少钱
        $jf_pro = intval($shangjbase['score']/$jf_gz['scroe'])*$jf_gz['money'];    //2.订单最高抵扣换取多少钱
        $dikou_jf = 0;
        if($jf_pro >= $jf_money){   //商品设置的最大可使用积分 >= 我自己的积分
        	$dikou_jf = $jf_money;
        }else{						//商品设置的最大可使用积分 < 我自己的积分
        	$dikou_jf = $jf_pro;    
        }
		// 积分金钱转积分数
		$jf_score = ($dikou_jf/$jf_gz['money'])*$jf_gz['scroe'];
		$shangjbase['user_money'] = $money; 
		$shangjbase['dk_money'] = $dikou_jf;   //抵扣的金钱
		$shangjbase['dk_score'] = $jf_score;   //抵扣的积分
		$shangjbase['jf_gz'] = $jf_gz; //积分规则
		return $this->result(0, 'success',$shangjbase);
	}
	function doPageFormval(){
		global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
       	$cid = $_GPC['id'];
       	$pagedata = $_GPC['pagedata'];
       	$types = $_GPC['types'];
       	$datas = stripslashes(html_entity_decode($_GPC['datas']));
		$datas = json_decode($datas,TRUE);
		// 新增自定义表单数据接收
		if($_GPC['pagedata'] && $_GPC['pagedata']!=="NULL"){
			$forms = stripslashes(html_entity_decode($_GPC['pagedata']));
			$forms = json_decode($forms,TRUE);

		}
		foreach ($forms as $key1 => &$res) {
			if($res['type']==14){
				$strtime = strtotime($res['days']);
				$arrs = array(
					"uniacid" => $uniacid,
       				"cid" => $cid,
       				"types" => $types,
       				"datys" => $strtime,
       				"pagedatekey"=>$res['indexkey'],
       				"arrkey" => $res['xuanx'],
       				"creattime" => time()
				);
				pdo_insert("sudu8_page_form_dd",$arrs);
			}
		}
       	$data = array(
       		"uniacid" => $uniacid,
       		"cid" => $cid,
       		"creattime" => time(),
       		"val" => serialize($forms),
       		"flag" => 0
       	);
       	$res = pdo_insert('sudu8_page_formcon', $data);
		if($res){
			$form =  pdo_fetch("SELECT id FROM ".tablename('sudu8_page_formcon')." ORDER BY id desc" , array(':uniacid' => $uniacid));
			$form['con'] = "提交成功";
			return $this->result(0, 'success', $form);
		}
	}
	function doPageBalance(){
		global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $money = $_GPC['money'];
        $now = time();
        $order_id = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
        // 2.调起支付
        $app = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		$paycon = pdo_fetch("SELECT * FROM ".tablename('uni_settings')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		$datas = unserialize($paycon['payment']);
        include 'WeixinPay.php';  
		$appid=$app['key'];  
		$openid= $openid;
		$mch_id=$datas['wechat']['mchid'];  
		$key=$datas['wechat']['signkey'];  
		if(isset($datas['wechat']['identity'])){
			$identity = $datas['wechat']['identity'];
		}else{
			$identity = 1;
		}

		if(isset($datas['wechat']['sub_mchid'])){
			$sub_mchid = $datas['wechat']['sub_mchid'];
		}else{
			$sub_mchid = 0;
		}


		$out_trade_no = $order_id;  //订单号
		$body = "账户充值";
		$total_fee = $money*100;
		$weixinpay = new WeixinPay($appid,$openid,$mch_id,$key,$out_trade_no,$body,$total_fee,$identity,$sub_mchid);  
		$return=$weixinpay->pay();  
		$return['order_id'] = $order_id;
		return $this->result(0, 'success',$return);
	}

	// 充值
	function doPagePay_cz(){
		global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $money = $_GPC['money'];
        $order_id = $_GPC['order_id'];
        // 1.根据openid 取uid 和剩余 money
        $user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $uniacid));
        $uid = $user['id'];
        $my_money = $user['money'];
        $my_score = $user['score'];
        $new_money = ($my_money*1000 + $money*1000)/1000;
        $new_score = $my_score;
        // 预留接口
        $guize =  pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_recharge')." WHERE uniacid = :uniacid order by money asc" , array(':uniacid' => $uniacid));
        if($guize){   //有充值规则时
        	$key = count($guize)-1;
        	for($i=0; $i<count($guize); $i++){
        		if($money*1000 >= $guize[$i]['money']*1000 && $money*1000 < $guize[$i+1]['money']*1000 && $i+1<=count($guize)){
        			$new_money = ($new_money * 1000 + $guize[$i]['getmoney'] *1000)/1000;
        			$new_score = ($new_score * 1000 + $guize[$i]['getscore'] *1000)/1000;
        		}
        	}
        	if($money<$guize[0]['money']){
        		$new_money = $new_money + 0;
        		$new_score = $new_score + 0;
        	}
        	if($money>=$guize[$key]['money']){
        		$new_money = ($new_money * 1000 + $guize[$key]['getmoney'] *1000)/1000;
        		$new_score = ($new_score * 1000 + $guize[$key]['getscore'] *1000)/1000;
        	}
        }else{        //没有充值规则
        	$new_money = $new_money + 0;
        	$new_score = $new_score + 0;
        }
        $data['money'] = $new_money; 
        $data['score'] = $new_score; 
        $res = pdo_update('sudu8_page_user', $data, array('openid' => $openid ,'uniacid' => $uniacid));
        // 充值成功后生成流水
        $gghmoney = $new_money*1 - $my_money*1; //增加规格后的money
        $jdata['uniacid'] = $uniacid;
        $jdata['orderid'] = "";
        $jdata['uid'] = $uid;
        $jdata['type'] = "add";
        $jdata['score'] = $gghmoney;
        $jdata['message'] = "充值送金钱";
        $jdata['creattime'] = time();
        if($gghmoney>0){
			pdo_insert('sudu8_page_money', $jdata);
        }
        // 充值成功后生成积分流水
        $gghscore = $new_score*1 - $my_score*1;
        $sdata['uniacid'] = $uniacid;
        $sdata['orderid'] = "";
        $sdata['uid'] = $uid;
        $sdata['type'] = "add";
        $sdata['score'] = $gghscore;
        $sdata['message'] = "充值送积分";
        $sdata['creattime'] = time();
        if($gghscore>0){
        	pdo_insert('sudu8_page_score', $sdata);
        }
	}
	function doPagedosetmoney(){
		global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $yemoney  = $_GPC['yemoney'];
        $wxmoney  = $_GPC['wxmoney'];
        $uid = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $uniacid));

        $ddata['uniacid'] = $uniacid;
		$ddata['orderid'] = $_GPC['orderid'];
		$ddata['uid'] = $uid['id'];
		$ddata['type'] = "del";
		$ddata['creattime'] = time();
		if($yemoney>0){
			$umoney = $uid['money'] - $yemoney;
			pdo_update('sudu8_page_user', array("money"=>$umoney), array('openid' => $openid ,'uniacid' => $uniacid));
			$ddata['score'] = $yemoney;
			$ddata['message'] = "余额消费";
			pdo_insert('sudu8_page_money', $ddata);
		}
		if($wxmoney>0){
			$ddata['score'] = $wxmoney;
			$ddata['message'] = "微信支付";
			pdo_insert('sudu8_page_money', $ddata);
		}
	}

	//个人中心我的数据
	function doPageMymoney(){
		global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $user = pdo_fetch("SELECT id,money,score,vipid,uniacid,openid FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid", array(':openid' => $openid ,':uniacid' => $uniacid));
      	$user['couponNum'] = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_coupon_user')." WHERE uid = :uid and uniacid = :uniacid", array(':uid' => $user['id'] ,':uniacid' => $uniacid));
      	unset($user['id']);
      	//查询会员卡信息
      	$vipcard = pdo_fetch("SELECT name,isopen FROM ".tablename('sudu8_page_vip_config')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
      	$user['vipset'] = $vipcard['isopen'];
      	$user['cardname'] = $vipcard['name'] == ""?'会员卡':$vipcard['name'];
      	$user['userbg'] = MODULE_URL."static/img/ubg.png";
        return $this->result(0, 'success',$user);
	}
	function doPageGuiz(){
		global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
		$guize['list'] =  pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_recharge')." WHERE uniacid = :uniacid order by money asc" , array(':uniacid' => $uniacid));
		$guize['conf'] =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_rechargeconf')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		$guize['user'] =  pdo_fetch("SELECT money,score,uniacid,openid FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $uniacid));
		$guize['coupon'] =  pdo_fetchall("SELECT c.*,b.id as ids FROM ".tablename('sudu8_page_user')." as a LEFT JOIN ".tablename('sudu8_page_coupon_user')." as b on a.id = b.uid LEFT JOIN ".tablename('sudu8_page_coupon')." as c on b.cid = c.id WHERE a.openid = :openid and a.uniacid = :uniacid and b.flag = 0" , array(':openid' => $openid ,':uniacid' => $uniacid));
		return $this->result(0, 'success',$guize);
	}
	public function doPageZjkk(){
		global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $now = time();
		$order_id = $order = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
		$gwc = $_GPC['gwc'];
		$order_id = $order_id;
		$my_pay_money = $_GPC['money_mypay'];
		$allprice = $_GPC['price'];
		$score = $_GPC['jifen_score'];
		$zh = $_GPC['zh'];
		$gwc = stripslashes(html_entity_decode($gwc));
		$gwc = json_decode($gwc,TRUE);
		$newgwc = serialize($gwc);
		$xinxi = $_GPC['xinxi'];
		$xinxi = stripslashes(html_entity_decode($xinxi));
		$xinxi = json_decode($xinxi,TRUE);
		$data['username'] = $xinxi['username'];
		$data['usertel'] = $xinxi['usertel'];
		$data['address'] = $xinxi['address'];
		$data['usertime'] = $xinxi['userdate']." ".$xinxi['usertime']; 
		$data['userbeiz'] = $xinxi['userbeiz']; 
		//获得用户信息
		$user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :id and uniacid = :uniacid" , array(':id' => $openid ,':uniacid' => $uniacid));
		$money_u = $user['money'];
		$score_u = $user['score']; 
		$kdata['money'] = $money_u - $my_pay_money;
		$kdata['score'] = $score_u - $score;
		$data['order_id'] = $order_id;
		$data['uniacid'] = $uniacid;
		$data['uid'] = $user['id'];
		$data['openid'] = $openid;
		$data['val'] = $newgwc;
		$data['price'] = $allprice;
		$data['creattime'] = time();
		$data['flag'] = 1;
		$data['zh'] = $zh;
		pdo_update('sudu8_page_user', $kdata, array('openid' => $openid ,'uniacid' => $uniacid));
		pdo_insert("sudu8_page_food_order",$data);
		$printer = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_food_printer')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		if($printer){
			if(intval($printer['status']) == 1){
				$content = '';
				$content .= '下单时间：'.date('Y-m-d H:i:s',time()).'\r\n';  
				$content .= '订单号：'.$order_id.'\r\n';  
				var_dump($data['zh']);                    //打印内容
				if($data['zh'] != 0){
					$content .= '<center>'.$data['zh'].'</center>\r\n';
				}else{
					$content .= '<center>打包/外卖</center>\r\n';
				}
				$content .= '<table>';
				$content .= '<tr><td>商品</td><td>数量</td><td>价格</td></tr>';
				foreach ($gwc as $k => $v) {
					$content .= '<tr><td>'.$v['title'].'</td><td>x'.$v['num'].'</td><td>'.$v['price'].'</td></tr>\r\n';
				}
				$content .= '</table>\r\n\r\n';
				$content .= '<FS>金额: '.$data['price'].'元</FS>\r\n\r\n';
				if($data['username'] != ""){
					$content .= '姓名：'.$data['username'].'\r\n';
				}
				if($data['usertel'] != ""){
					$content .= '电话：'.$data['usertel'].'\r\n';
				}
				if($data['address'] != ""){
					$content .= '地址：'.$data['address'].'\r\n';
				}
				if($xinxi['userdate'] != "" || $xinxi['usertime'] != ""){
					$content .= '预约配送时间：'.$data['usertime'].'\r\n';
				}
				if($data['userbeiz'] != ""){
					$content .= '备注：'.$data['userbeiz'];
				}
				include 'Print.php';
				$print = new Yprint();
				$apiKey = $printer['apikey'];
				$msign = $printer['nkey'];
				//打印
				$print->action_print(intval($printer['uid']),$printer['nid'],$content,$apiKey,$msign);
			}
		}
	} 
	public function doPageHxmm(){
		global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $hxmm = $_GPC['hxmm'];
        $order_id = $_GPC['order_id'];
        $hxmmarr = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_base')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
        if($hxmmarr['hxmm'] != $hxmm){
        	return $this->result(0, 'success',0);
        }else{
        	$data['custime'] = time();
            $data['flag'] = 2; 
            $res = pdo_update('sudu8_page_order', $data, array('order_id' => $order_id));
            return $this->result(0, 'success',1);
        }
	} 
	public function doPageHxyhq(){
		global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $hxmm = $_GPC['hxmm'];
        $youhqid = $_GPC['youhqid'];
        $hxmmarr = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_base')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
        if($hxmmarr['hxmm'] != $hxmm){
        	return $this->result(0, 'success',0);
        }else{
        	$data['utime'] = time();
            $data['flag'] = 1; 
            $res = pdo_update('sudu8_page_coupon_user', $data, array('id' => $youhqid));
            return $this->result(0, 'success',1);
        }
	} 
	public function doPageWxupimg(){
		global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        load()->func('file');

        if($_W['setting']['remote']['type'] == 0){
        	$path = file_upload($_FILES['file']);
        	$path = $path['path'];
        }else{
        	$path = file_upload($_FILES['file']);
        	$rpath = $path['path'];
        	$path = file_remote_upload($rpath,false);
        	$path = $_W['attachurl_remote'].$rpath;
        }
        if(strpos($path,'http')===false){
        	$path = HTTPSHOST.$path;
        }
	    echo json_encode($path);
	}
	public function dopageShoppay_duo(){   //店内支付
		global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $ordermoeny = $_GPC['ordermoeny'];  //订单的总价格
        $yuemoney = $_GPC['yuemoney'];      //用余额支付的钱
        $money = $_GPC['money'];			//用微信支付的钱
        $order_id = $_GPC['order_id'];
        $jfscore = $_GPC['jfscore'];  //积分抵扣的积分
        $yhq_id = $_GPC['yhq_id'];  //优惠券id
        $now = time();
        if(empty($order_id)){
			$order_id = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
        }
        //获得用户信息
		$user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :id and uniacid = :uniacid" , array(':id' => $openid ,':uniacid' => $uniacid));
		$money_u = $user['money'];
		$score_u = $user['score'];
		$kdata['money'] = $money_u - $yuemoney;  //用的钱
		$kdata['score'] = $score_u - $jfscore;	//用的积分
		if($kdata['money'] !=0 || $kdata['score'] !=0){
			pdo_update('sudu8_page_user', $kdata, array('openid' => $openid ,'uniacid' => $uniacid));
		}
		//生成订单
		$ddata['uniacid'] = $uniacid;
		$ddata['orderid'] = $order_id;
		$ddata['uid'] = $user['id'];
		$ddata['type'] = "del";
		$ddata['creattime'] = time();
		if($yuemoney>0){
			$ddata['score'] = $yuemoney;
			$ddata['message'] = "消费扣金钱";
			pdo_insert('sudu8_page_money', $ddata);
		}
		if($money>0){
			$ddata['score'] = $money;
			$ddata['message'] = "微信支付";
			pdo_insert('sudu8_page_money', $ddata);
		}
		if($jfscore>0){
			$ddata['score'] = $jfscore;
			$ddata['message'] = "消费扣积分";
			pdo_insert('sudu8_page_money', $ddata);
		}
		if($yhq_id>0){
			pdo_update('sudu8_page_coupon_user', array("utime"=>time(),"flag"=>1), array('id' => $yhq_id));
		}
	}
	public function dopageShoppay_cz(){   //店内充值
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $money = $_GPC['money'];			//用微信支付的钱
        $order_id = $_GPC['order_id'];
        //获得用户信息
		$user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :id and uniacid = :uniacid" , array(':id' => $openid ,':uniacid' => $uniacid));
		$money_u = $user['money'];
		$kdata['money'] = $money_u + $money;
		pdo_update('sudu8_page_user', $kdata, array('openid' => $openid ,'uniacid' => $uniacid));
		//生成订单
		$ddata['uniacid'] = $uniacid;
		$ddata['orderid'] = $order_id;
		$ddata['uid'] = $user['id'];
		$ddata['type'] = "add";
		$ddata['score'] = $money;
		$ddata['message'] = "微信支付";
		$ddata['creattime'] = time();
		if($money>0){
			pdo_insert('sudu8_page_money', $ddata);
		}
	}
	public function dopageShoppay_jilu(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $types = $_GPC['types'];
        if($types == 1){
        	$where = "";
        }
        if($types == 2){
        	$where = " and type = 'del'";
        }
        if($types == 3){
        	$where = " and type = 'add'";
        }
        $user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :id and uniacid = :uniacid" , array(':id' => $openid ,':uniacid' => $uniacid));
        $userid = $user['id'];
        $jilu = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_money')." WHERE uid = :uid and uniacid = :uniacid". $where ." ORDER BY creattime DESC" , array(':uid' => $userid ,':uniacid' => $uniacid));
       	if($jilu){
       		foreach ($jilu as $key => &$res) {
       			$res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
       		}
       	}
        return $this->result(0, 'success', $jilu);
	}
	public function dopageDzborder(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$type = $_GPC['type'];
		$where = "";
		if($type != 9){
			$where=" and flag = ".$type;
		}
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$OrdersList['list'] = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')."WHERE uniacid = :uniacid and openid = :openid ".$where." and flag != -1 and flag != -2 and flag != 0 and flag != 3 ORDER BY creattime DESC,flag  LIMIT ".($pindex - 1) * $psize.",".$psize ,array(':uniacid' => $uniacid,':openid'=>$openid));
		foreach ($OrdersList['list'] as  &$row){
			if(stristr($row['thumb'], 'http')){
				$row['thumb'] = $row['thumb'];
			}else{
				$row['thumb'] = HTTPSHOST.$row['thumb'];
			}
		}
		$alls = pdo_fetchall("SELECT id FROM ".tablename('sudu8_page_order')."WHERE uniacid = :uniacid and openid = :openid",array(':uniacid' => $uniacid,':openid'=>$openid));
		$OrdersList['allnum'] = count($alls);
		return $this->result(0, 'success', $OrdersList);
	}
	//得到桌号
	public function doPageGetzh(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$zid = $_GPC['zid'];
		$zh = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_food_tables')." WHERE uniacid = :uniacid and tnum = :zid ORDER BY id DESC" , array(':uniacid' => $uniacid,':zid' => $zid));
		return $this->result(0, 'success', $zh);
	}
	//选择桌号
	public function doPageZhchange(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$zh = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_food_tables')." WHERE uniacid = :uniacid ORDER BY id DESC" , array(':uniacid' => $uniacid));
		$zhs = ['打包/拼桌'];
		foreach ($zh as $k => $v) {
			$zho = $v['title']."-".$v['tnum']."号桌";
			array_push($zhs,$zho);
		}
		$zh['zhs'] = $zhs;
		return $this->result(0, 'success', $zh);
	}
	// 分享获得积分
	public function dopagesharejf(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$id = $_GPC['id'];
		$types = $_GPC['types'];
		$numflag = 0;  //分享次数
		$typeflag = 0; //分享类型
		// 获取个人信息
		$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
		$userjf = $userinfo['score'];
		// 获取分享规则
		$pro = pdo_fetch("SELECT share_gz,share_type,share_score,share_num FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $id ,':uniacid' => $uniacid));
		$gz = $pro['share_gz'];
		if($gz == 1){  //公用规则
			$gzinfo = pdo_fetch("SELECT sharetype,sharejf,sharexz FROM ".tablename('sudu8_page_base')." where uniacid = :uniacid" , array(':uniacid' => $uniacid));
			$share_type = $gzinfo['sharetype'];
			$share_score = $gzinfo['sharejf'];
			$share_num = $gzinfo['sharexz'];
			// 判断今天还能不能获得积分
			$begintime = date("Y-m-d",time())." 00:00:00";
			$endtime = date("Y-m-d",time())." 23:59:59";
			$btime = strtotime($begintime);
			$etime = strtotime($endtime);
			$count = pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_share_user')." WHERE uid = :uid and pid = :pid and uniacid = :uniacid and creattime >= :btime and creattime <= :etime", array(':uid' => $userinfo['id'],':pid' => $id,':uniacid' => $_W['uniacid'],':btime' => $btime,':etime' => $etime));
			$n = $count['n'];
			if($n>=$share_num){
				$numflag = 0;
			}else{
				$numflag = 1;
			}
			// 判断你的分享对象
			if($share_type==3){  //个人+群
				$typeflag = 1;
			}else{
				if($types == $share_type){
					$typeflag = 1;
				}
			}
			$newscore = $userjf + $share_score;
			$kdata = array(
				'uniacid' => $uniacid,
				'uid' => $userinfo['id'],
				'pid' => $id,
				'creattime' => time()
			);
			if($numflag == 1 && $typeflag == 1){  //符合增加积分的规则
				$data['score'] = $newscore;
				$shareData['score'] = $share_score;
				$shareData['notice'] = 0;
				$res = pdo_update('sudu8_page_user', $data, array('openid' => $openid,"uniacid"=>$uniacid));
				pdo_insert('sudu8_page_share_user', $kdata);
				// 分享获得积分
				$xfscore = array(
					"uniacid" => $uniacid,
					"orderid" => "",
					"uid" => $userinfo['id'],
					"type" => "add",
					"score" => $share_score,
					"message" => "分享获得积分",
					"creattime" => time()
				);
				if($share_score>0){
					pdo_insert("sudu8_page_score",$xfscore);
				}
			}else{
				$shareData['score'] = "0";
				$shareData['notice'] = 1;
				pdo_insert('sudu8_page_share_user', $kdata);
			}
		}else{ //私有规则
			$share_type = $pro['share_type'];
			$share_score = $pro['share_score'];
			$share_num = $pro['share_num'];
			// 判断今天还能不能获得积分
			$begintime = date("Y-m-d",time())." 00:00:00";
			$endtime = date("Y-m-d",time())." 23:59:59";
			$btime = strtotime($begintime);
			$etime = strtotime($endtime);
			$count = pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_share_user')." WHERE uid = :uid and pid = :pid and uniacid = :uniacid and creattime >= :btime and creattime <= :etime", array(':uid' => $userinfo['id'],':pid' => $id,':uniacid' => $_W['uniacid'],':btime' => $btime,':etime' => $etime));
			$n = $count['n'];
			if($n>=$share_num){
				$numflag = 0;
			}else{
				$numflag = 1;
			}
			// 判断你的分享对象
			if($share_type==3){  //个人+群
				$typeflag = 1;
			}else{
				if($types == $share_type){
					$typeflag = 1;
				}
			}
			$newscore = $userjf + $share_score;
			$kdata = array(
				'uniacid' => $uniacid,
				'uid' => $userinfo['id'],
				'pid' => $id,
				'creattime' => time()
			);
			if($numflag == 1 && $typeflag == 1){  //符合增加积分的规则
				$data['score'] = $newscore;	
				$shareData['score'] = $share_score;
				$shareData['notice'] = 0;
				$res = pdo_update('sudu8_page_user', $data, array('openid' => $openid,"uniacid"=>$uniacid));
				pdo_insert('sudu8_page_share_user', $kdata);
				// 分享获得积分
				$xfscore = array(
					"uniacid" => $uniacid,
					"orderid" => "",
					"uid" => $userinfo['id'],
					"type" => "add",
					"score" => $share_score,
					"message" => "分享获得积分",
					"creattime" => time()
				);
				if($share_score>0){
					pdo_insert("sudu8_page_score",$xfscore);
				}
			}else{
				$shareData['score'] = "0";
				$shareData['notice'] = 1;
				pdo_insert('sudu8_page_share_user', $kdata);
			}
		}
		return $this->result(0, 'success',$shareData);
	}
	//多规格数据
	public function dopageduoproducts(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$id = $_GPC['id'];
		$openid = $_GPC['openid'];
		$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
        $products = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products') ." WHERE uniacid = :uniacid and id = :id", array(':uniacid' => $uniacid, ':id'=>$id));

        $hits = $products['hits']+1;

		pdo_update('sudu8_page_products',array('hits'=>$hits),array('uniacid' => $uniacid, 'id'=>$id));

        // 检查该商品有没有收藏过
		$shouc = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_collect') ." WHERE uniacid = :uniacid and uid = :uid and cid = :cid and type = 'showProMore'", array(':uniacid' => $uniacid, ':uid'=>$userinfo['id'], ':cid'=>$id));
		if($shouc){
			$shouc = 2;
		}else{
			$shouc = 1;
		}
        // if($products['types']==2){
        $products['mark_price'] = $products['market_price'];
        $products['texts'] = $products['product_txt'];
        $products['xsl'] = $products['sale_tnum'];
        $products['thumb'] = HTTPSHOST.$products['thumb'];
        $proarr = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_type_value') ." WHERE pid = :pid order by id desc", array(':pid'=>$id));
        // 处理库存量
        $kcl = 0;
        foreach ($proarr as $key => &$res) {
        	$kcl+=$res['kc'];
        }
        $products['kc'] = $kcl;
        $imgarr = unserialize($products['text']); 
        foreach ($imgarr as $key2 => &$reb) {
        	$reb = HTTPSHOST.$reb;
        }
        $products['imgtext'] = $imgarr;
        $types = $proarr[0]['comment'];
        //构建规格组
        $typesarr = explode(",", $types);  
        // 构建规格组json
        $typesjson = [];
        foreach ($typesarr as $key => &$rec) {
            $str = "type".($key+1);
            $ziji = pdo_fetchall("SELECT ".$str." FROM ".tablename('sudu8_page_duo_products_type_value') ." WHERE pid = :pid  group by ".$str." order by id desc", array(':pid'=>$id));    
            $xarr = array();
            foreach ($ziji as $key => $res) {
                array_push($xarr, $res[$str]);
            }
            $cdata["val"] = $xarr;
            $cdata['ck'] = 0;
            $typesjson[$rec] = $cdata;
        }
        $adata['grouparr'] = $typesarr;
        $adata['grouparr_val'] = $typesjson;
        // }
        $products['explains'] = explode(",", $products['labels']);
        $adata['products'] = $products;
        // 分销商的关系[1.绑定上下级关系 ]
		//获取该小程序的分销关系绑定规则
		$guiz = pdo_fetch("SELECT fx_cj,sxj_gx,uniacid FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		$fxsid = $_GPC['fxsid'];
		$fxsinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $fxsid ,':uniacid' => $_W['uniacid']));
		// 1.先进行上下级关系绑定[判断是不是首次下单]
		if($guiz['sxj_gx']==1 && $userinfo['parent_id'] == '0' && $fxsid != '0' && $userinfo['fxs'] !=2 && $fxsinfo['fxs']==2){
			$p_fxs = $fxsinfo['parent_id'];  //分销商的上级
			$p_p_fxs = $fxsinfo['p_parent_id']; //分销商的上上级
			// 判断启用几级分销 
			$fx_cj = $guiz['fx_cj'];
			// 分别做判断
			if($fx_cj == 1){
				$uuser = pdo_update("sudu8_page_user",array("parent_id"=>$fxsid),array("openid"=>$openid,'uniacid' => $_W['uniacid']));
			}
			if($fx_cj == 2){
				$uuser = pdo_update("sudu8_page_user",array("parent_id"=>$fxsid,"p_parent_id"=>$p_fxs),array("openid"=>$openid,'uniacid' => $_W['uniacid']));
			}
			if($fx_cj == 3){
				$uuser = pdo_update("sudu8_page_user",array("parent_id"=>$fxsid,"p_parent_id"=>$p_fxs,"p_p_parent_id"=>$p_p_fxs),array("openid"=>$openid,'uniacid' => $_W['uniacid']));
			}	
		}
		$adata['guiz'] = pdo_fetch("SELECT one_bili,two_bili,three_bili,uniacid FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		$adata['shouc'] = $shouc;
        return $this->result(0, 'success', $adata);
	}
	//多规格数据自己规格
	public function dopageduoproductsinfo(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$str = $_GPC['str'];
		$arr = explode("/", $str);
		$id = $_GPC['id'];
		$where = "";
		foreach ($arr as $key => &$res) {
			$vv = $key+1;
			$where .= " and type".$vv." = ". "'".$res."'";
		}
		$proinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_type_value') ." WHERE pid= ".$id . $where);
		$baseinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products') ." WHERE id = :id", array(':id'=>$proinfo['pid']));
		$adata['proinfo'] = $proinfo;
		$adata['baseinfo'] = $baseinfo;
		return $this->result(0, 'success', $adata);
	}
	//加入购物车
	public function dopagegwcadd(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$id = $_GPC['id'];
		$prokc = $_GPC['prokc'];
		$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
		$proinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_type_value') ." WHERE id = :id", array(':id'=>$id));
		$baseinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products') ." WHERE id = :id", array(':id'=>$proinfo['pid']));
		//判断该商品是不是已经存在
		$gwcinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_gwc') ." WHERE pid = :pid and flag = 1 and uid =:uid", array(':pid'=>$id,':uid'=>$userinfo['id']));
		if($gwcinfo){
			$kc = $gwcinfo['num'];
			$newkc = $kc+$prokc;
			$data = array(
				"num" => $newkc,
				"creattime" => time()
			);
			$res = pdo_update("sudu8_page_duo_products_gwc",$data,array("id"=>$gwcinfo['id']));
		}else{
			$data = array(
				"uniacid" => $uniacid,
				"uid" => $userinfo['id'],
				"pid" => $id,
				"pvid" => $proinfo['pid'],
				"num" => $prokc,
				"creattime" => time()
			);
			$res = pdo_insert("sudu8_page_duo_products_gwc",$data);
		}
		// 统计购物车里面的情况
		if($res){
			return $this->result(0, 'success', 1);
		}
	}
	//获取我的购物车数据
	public function dopagegetmygwc(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
		$uid = $userinfo['id'];
		$mygwc = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_gwc') ." WHERE uid = :uid and flag = 1", array(':uid'=>$uid));
		$guiz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		foreach ($mygwc as $key => &$res) {
			$proinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_type_value') ." WHERE id = :pid", array(':pid'=>$res['pid']));
			$baseinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products') ." WHERE id = :pvid", array(':pvid'=>$res['pvid']));
			$bb = array(
				"cid"=>$baseinfo['cid'],
				"id"=>$baseinfo['id'],
				"title"=>$baseinfo['title'],
				"thumb"=>$baseinfo['thumb'],
			);
			$gg = $proinfo['comment'];
			$ggarr = explode(",", $gg);
			$str = "";
			foreach ($ggarr as $index => $rec) {
				$i = $index+1;
				$kk = "type".$i;
				$str .= $rec.":".$proinfo[$kk].",";
			} 
			$str = substr($str, 0, strlen($str)-1);
			$proinfo['ggz'] = $str;
			$res['proinfo'] = $proinfo;
			$res['baseinfo'] = $bb;
			$res['ck'] = 0;
			$res['one_bili'] = $guiz['one_bili'];
			$res['two_bili'] = $guiz['two_bili'];
			$res['three_bili'] = $guiz['three_bili'];
		}
		return $this->result(0, 'success', $mygwc);
	}
	//删除购物车数据
	public function dopagedelmygwc(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$id = $_GPC['id'];
		pdo_delete("sudu8_page_duo_products_gwc",array("id"=>$id,"uniacid"=>$uniacid));
	}
	//增加我的地址
	public function dopagesetmyaddress(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$name = $_GPC['name'];
		$mobile = $_GPC['mobile'];
		$address = $_GPC['address'];
		$more_address = $_GPC['more_address'];
		$postalcode = $_GPC['postalcode'];
		$froms = $_GPC['froms'];
		$data = array(
			"uniacid" => $uniacid,
			"openid" => $openid,
			"name" => $name,
			"mobile" => $mobile,
			"address" => $address,
			"more_address" => $more_address,
			"postalcode" => $postalcode,
			"creattime" => time()
		);
		if($froms == "weixin"){
			$mywx = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_address') ." WHERE openid = :openid and froms = 'weixin'", array(':openid'=>$openid));
			if($mywx){
				pdo_update("sudu8_page_duo_products_address",$data,array("id"=>$mywx['id']));
			}else{
				$data['froms'] = "weixin";
				pdo_insert("sudu8_page_duo_products_address",$data);
			}
		}else{
			$id = $_GPC['id'];
			if($id != 0 && $froms!="weixin"){
				pdo_update("sudu8_page_duo_products_address",$data,array("id"=>$id));
			}else{
				$data['froms'] = "selfadd";
				pdo_insert("sudu8_page_duo_products_address",$data);
			}
		}
	}
	//获取我的地址礼拜
	public function dopagegetmyaddress(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$myaddress = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_address') ." WHERE openid = :openid", array(':openid'=>$openid));
		return $this->result(0, 'success', $myaddress);
	}
	//获取地址具体信息
	public function dopagegetaddressinfo(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$id = $_GPC['id'];
		$address = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_address') ." WHERE openid = :openid and id = :id", array(':openid'=>$openid,':id'=>$id));
		if($address){
			if(strpos($address['address'],",")===false){
				$address['region'] = explode(" ",$address['address']);
			}else{
				$address['region'] = explode(",",$address['address']);
			}
		}
		return $this->result(0, 'success', $address);
	}
	//删除我的地址
	public function dopagedelmyaddress(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$id = $_GPC['id'];
		$res = pdo_delete("sudu8_page_duo_products_address",array("id"=>$id));
		return $this->result(0, 'success', $res);
	}
	// 设置默认地址
	public function dopagesetmoaddress(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$id = $_GPC['id'];
		$data = array(
			"is_mo" => 1
		);
		// 先更新掉其他默认值
		pdo_update("sudu8_page_duo_products_address",$data,array("openid"=>$openid));
		$kdata = array(
			"is_mo" => 2
		);
		// 更新默认值
		pdo_update("sudu8_page_duo_products_address",$kdata,array("openid"=>$openid,"id"=>$id));
	}
	// 获取默认地址
	public function dopagegetmraddress(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$address = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_address') ." WHERE openid = :openid and is_mo = 2", array(':openid'=>$openid));
		return $this->result(0, 'success', $address);
	}
	// 获取指定地址
	public function dopagegetmraddresszd(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$id = $_GPC['id']; 
		$address = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_address') ." WHERE openid = :openid and id = :id", array(':openid'=>$openid,':id'=>$id));
		return $this->result(0, 'success', $address);
	}
	//获取运费
	public function dopageyunfeiget(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$yunfei = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_yunfei') ." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		if(!$yunfei){
			$yunfei = array(
				"yfei" => 0,
				"byou" => 0
			);
		}else{
			$formset = $yunfei['formset'];
			if($formset!=0&&$formset!=""){
				$forms = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_formlist')." WHERE id = :id" , array(':id' => $formset));
				$forms2 = unserialize($forms['tp_text']);
				foreach($forms2 as $key=>&$res){
					if($res['tp_text']){
						$res['tp_text'] = explode(",", $res['tp_text']);
					}
					$res['val']='';
				}
			}else{
				$forms2 = "NULL";
			} 
			$yunfei['forms'] = $forms2;
		}
		return $this->result(0, 'success', $yunfei);
	}
	//组装积分规则
	public function dopagesetgwcscore(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$jsdata = stripslashes(html_entity_decode($_GPC['jsdata']));
		$jsdata = json_decode($jsdata,TRUE);
		$arr = array();
		$jifen = 0;
		foreach ($jsdata as $key => $res) {
			$num = $res['num'];
			$baseinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products') ." WHERE id = :id", array(':id'=>$res['pvid']));
			$score = $baseinfo['score'];
			$jifen+= $score*$num;
		}
		//积分转换成金钱
		$jf_gz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_rechargeconf')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
		if(!$jf_gz){
        	$gzscore = 10000;
        	$gzmoney = 1;
        }else{
        	$gzscore = $jf_gz['scroe'];
        	$gzmoney = $jf_gz['money'];
        }
        // 我的积分抵用
        $userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
		$score = $userinfo['score'];
		//比较我的积分和扣除积分
		$data = array();
		if($score>=$jifen){
			$zhmoney = ($jifen * $gzmoney)/$gzscore;
			$moneycl = floor($zhmoney);
			$jf = $moneycl * $gzscore;
		}else{
			$zhmoney = ($score * $gzmoney)/$gzscore;
			$moneycl = floor($zhmoney);
			//消费掉的积分
			$jf = $moneycl * $gzscore; 
		}
		$data["moneycl"] = $moneycl;
		$data["jf"] = $jf;
		$data["gzscore"] = $gzscore;
		$data["gzmoney"] = $gzmoney;
		return $this->result(0, 'success', $data);
	}
	//创建订单
	public function dopageduosetorder(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$couponid = $_GPC['couponid'];
		$price = $_GPC['price'];
		$dkscore = $_GPC['dkscore'];
		$address = $_GPC['address'];
		$mjly = $_GPC['mjly'];
		$nav = $_GPC['nav'];
		$formid = $_GPC['formid'];
		$now = time();
		$order_id  = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
		$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
		$uid = $userinfo['id'];
		$jsdata = html_entity_decode($_GPC['jsdata']);
		$jsdatass = json_decode($jsdata,true);
		foreach ($jsdatass as $key12 => &$res) {
			$probaseinfo = pdo_fetch("SELECT id,title,thumb FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $res['baseinfo'] ,':uniacid' => $_W['uniacid']));
			$proproinfo = pdo_fetch("SELECT id,price,thumb,comment,type1,type2,type3,kc FROM ".tablename('sudu8_page_duo_products_type_value')." WHERE id = :id" , array(':id' => $res['proinfo']));
			$newproinfo['id'] = $probaseinfo['id'];
			$newproinfo['title'] = $probaseinfo['title'];
			$newproinfo['thumb'] = $probaseinfo['thumb'];
			$res['baseinfo'] = $newproinfo;
			$newproinfo['id'] = $proproinfo['id'];
			$newproinfo['price'] = $proproinfo['price'];
			$newproinfo['thumb'] = $proproinfo['thumb'];
			$newproinfo['kc'] = $proproinfo['kc'];
			$gg = $proproinfo['comment'];
			$ggarr = explode(",", $gg);
			$str = "";
			foreach ($ggarr as $index => $rec) {
				$i = $index+1;
				$kk = "type".$i;
				$str .= $rec.":".$proproinfo[$kk].",";
			} 
			$newproinfo['ggz'] = $str;
			$res['proinfo'] = $newproinfo;
		}
		// echo "<pre>";
		// var_dump($jsdatass);
		// echo "</pre>";
		// die();
		$data = array(
			"uniacid" => $uniacid,
			"uid" => $uid,
			"openid" => $openid,
			"order_id" => $order_id,
			"jsondata" => serialize($jsdatass),
			"coupon" => $couponid,
			"creattime" => time(),
			"price" => $price,
			"flag" => 0,
			"jf" => $dkscore,
			"address" => $address,
			"liuyan" => $mjly,
			"nav"=>$nav,
			"formid"=>$formid,
		);
		pdo_insert("sudu8_page_duo_products_order",$data);
		// 分销商的关系[1.绑定上下级关系 ]
		$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
		//获取该小程序的分销关系绑定规则
		$guiz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		$fxsid = $_GPC['fxsid'];
		$fxsinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $fxsid ,':uniacid' => $_W['uniacid']));
		// 1.先进行上下级关系绑定[判断是不是首次下单]
		if($guiz['sxj_gx']==2 && $userinfo['parent_id'] == '0' && $fxsid != '0' && $userinfo['fxs'] !=2 && $fxsinfo['fxs'] == 2){
			$p_fxs = $fxsinfo['parent_id'];  //分销商的上级
			$p_p_fxs = $fxsinfo['p_parent_id']; //分销商的上上级
			// 判断启用几级分销
			$fx_cj = $guiz['fx_cj'];
			// 分别做判断
			if($fx_cj == 1){
				$uuser = pdo_update("sudu8_page_user",array("parent_id"=>$fxsid),array("openid"=>$openid,'uniacid' => $_W['uniacid']));
			}
			if($fx_cj == 2){
				$uuser = pdo_update("sudu8_page_user",array("parent_id"=>$fxsid,"p_parent_id"=>$p_fxs),array("openid"=>$openid,'uniacid' => $_W['uniacid']));
			}
			if($fx_cj == 3){
				$uuser = pdo_update("sudu8_page_user",array("parent_id"=>$fxsid,"p_parent_id"=>$p_fxs,"p_p_parent_id"=>$p_p_fxs),array("openid"=>$openid,'uniacid' => $_W['uniacid']));
			}	
		}
		return $this->result(0, 'success', $order_id);
	}
	//获取新多产品订单
	public function dopageduoorderget(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$order_id = $_GPC['order'];
		$order = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE openid = :openid and uniacid = :uniacid and order_id = :orderid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid'],':orderid'=>$order_id));
		$order['jsondata'] = unserialize($order['jsondata']);
		$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
		$mymongy = $userinfo['money'];
		$order['mymoney'] = $mymongy;
		if($order['coupon']!=0){
			$coupon =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $order['coupon'] ,':uniacid' => $uniacid));
			$couponinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $coupon['cid'] ,':uniacid' => $uniacid));
			$order['mycoupon'] = $couponinfo['price'];
		}else{
			$order['mycoupon'] = 0;
		}
		return $this->result(0, 'success', $order);
	}
	// 支付过后更新对应状态
		public function doPageduoorderchange(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$order_id = $_GPC['order_id'];
		$openid = $_GPC['openid'];
		$true_price = $_GPC['true_price'];
		$dkscore = $_GPC['dkscore'];
		$couponid = $_GPC['couponid'];
		$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
		$mymongy = $userinfo['money'];
		$newmymoney = $mymongy - $true_price;
		$myscore = $userinfo['score'];
		$newmyscore = $myscore - $dkscore;
		if($newmymoney<0){
			$newmymoney = 0;
		}
		if($newmyscore<0){
			$newmyscore = 0;
		}
		$data = array(
			"money" => $newmymoney,
			"score" => $newmyscore
		);
		pdo_update("sudu8_page_user",$data,array('openid'=>$openid,'uniacid' => $_W['uniacid']));
		// 更改订单号
		pdo_update("sudu8_page_duo_products_order",array("flag"=>1),array("order_id"=>$order_id));
		//删除对应的优惠券
		pdo_update("sudu8_page_coupon_user",array("flag"=>1),array("id"=>$couponid));
		//删除对应的购物车
		$order = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE openid = :openid and order_id = :order_id" , array(':openid' => $openid ,':order_id' => $order_id));

		$jsdata = unserialize($order['jsondata']);






		
			$fmsg = "";
		foreach ($jsdata as $key => &$res) {
			pdo_update("sudu8_page_duo_products_gwc",array("flag"=>2),array("id"=>$res['id']));
			// 处理销售量
			$pvid = $res['pvid'];
			$num = $res['num'];
			$pro = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products') ." WHERE id = :id", array(':id'=>$pvid));
			$pronum = $pro['sale_tnum'];
			$newpronum = $pronum+$num;
			pdo_update("sudu8_page_products",array("sale_tnum"=>$newpronum),array("id"=>$pvid));
			// 减去对应的库存
			$spid = $res['proinfo']['id'];
			$spnum = $res['proinfo']['kc']; 
			$kc = $spnum - $num;
			// if($kc<0){
			// 	$kc=0;
			// }
			// 
			// pdo_update("sudu8_page_duo_products_type_value",array("kc"=>$kc),array("id"=>$spid));

			$pro_val = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_type_value') ." WHERE id = :id", array(':id'=>$spid));
			$fmsg .= "产品：".$pro['title']." 购买数：".$num." 购买规格：".$pro_val['type1']." ".$pro_val['type2']." ".$pro_val['type3']." "." 购买价格：".$pro_val['price']."元 ";
			//加销量
			$salenum = $pro_val['salenum'] + 1; 
			pdo_update("sudu8_page_duo_products_type_value",array("kc"=>$kc,"salenum" => $salenum),array("id"=>$spid));
			// Db::table('ims_sudu8_page_duo_products_type_value')->where('id',$spid)->update(array("kc"=>$kc,"salenum" => $salenum));

			
		}

		$applet = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		$appid = $applet['key'];
		$appsecret = $applet['secret'];
		if($applet){
			$mid =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_message')." WHERE uniacid = :uniacid and flag=6" , array(':uniacid' => $_W['uniacid']));

			if($mid){



				if($mid['mid']!=""){



					$mids = $mid['mid'];



					$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;




					$a_token = $this->_requestGetcurl($url);



					if($a_token)



					{



						$url_m="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$a_token['access_token'];



						$formId = $_GPC['formid'];


						$ftime=date('Y-m-d H:i:s',time());



	



						$openid=$_GPC['openid'];


						$fprice = $true_price."元";
						$furl = $mid['url'];



						$post_info = '{



								  "touser": "'.$openid.'",  



								  "template_id": "'.$mids.'", 



								  "page": "'.$furl.'",          



								  "form_id": "'.$formId.'",         



								  "data": {



								      "keyword1": {



								          "value": "'.$order_id.'", 



								          "color": "#173177"



								      }, 



								      "keyword2": {



								          "value": "'.$fprice.'", 



								          "color": "#173177"



								      }, 



								      "keyword3": {



								          "value": "'.$fmsg.'", 



								          "color": "#173177"



								      } , 



								      "keyword4": {



								          "value": "'.$ftime.'", 



								          "color": "#173177"



								      } 



								  },



								  "emphasis_keyword": "" 



								}';



								$this->_requestPost($url_m,$post_info);



					}



				}



			}



		}






		//生成支付流水
		// 1.支付金钱流水
		$xfmoney = array(
			"uniacid" => $uniacid,
			"orderid" => $order_id,
			"uid" => $userinfo['id'],
			"type" => "del",
			"score" => $true_price,
			"message" => "消费",
			"creattime" => time()
		);	
		if($true_price>0){
			pdo_insert("sudu8_page_money",$xfmoney);
		}
		// 2.支付积分流水
		$xfscore = array(
			"uniacid" => $uniacid,
			"orderid" => $order_id,
			"uid" => $userinfo['id'],
			"type" => "del",
			"score" => $dkscore,
			"message" => "消费",
			"creattime" => time()
		);
		if($dkscore>0){
			pdo_insert("sudu8_page_score",$xfscore);
		}
		// 分销商的关系[1.绑定上下级关系 2.上下级获取对应的金钱及记录[重新操作] 3.是否晋升为分销商]
		// 获取下单时对应的分销比例
		$one_bili = $jsdata[0]['one_bili'];
		$two_bili = $jsdata[0]['two_bili'];
		$three_bili = $jsdata[0]['three_bili'];
		//获取该小程序的分销关系绑定规则
		$guiz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		$fxsid = $_GPC['fxsid'];
		$fxsinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $fxsid ,':uniacid' => $_W['uniacid']));
		// 1.先进行上下级关系绑定[判断是不是首次付款]
		if($guiz['sxj_gx']==3 && $userinfo['parent_id'] == '0' && $fxsid != '0' && $userinfo['fxs'] !=2 && $fxsinfo['fxs']==2){
			$p_fxs = $fxsinfo['parent_id'];  //分销商的上级
			$p_p_fxs = $fxsinfo['p_parent_id']; //分销商的上上级
			// 判断启用几级分销
			$fx_cj = $guiz['fx_cj'];
			// 分别做判断
			if($fx_cj == 1){
				$uuser = pdo_update("sudu8_page_user",array("parent_id"=>$fxsid),array("openid"=>$openid,'uniacid' => $_W['uniacid']));
			}
			if($fx_cj == 2){
				$uuser = pdo_update("sudu8_page_user",array("parent_id"=>$fxsid,"p_parent_id"=>$p_fxs),array("openid"=>$openid,'uniacid' => $_W['uniacid']));
			}
			if($fx_cj == 3){
				$uuser = pdo_update("sudu8_page_user",array("parent_id"=>$fxsid,"p_parent_id"=>$p_fxs,"p_p_parent_id"=>$p_p_fxs),array("openid"=>$openid,'uniacid' => $_W['uniacid']));
			}	
		}
		// 重新获取该用户信息
		$userinfo_new = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
		// 2.上下级获取对应的金钱及记录
		// 只启用一级分销提成
		if($guiz['fx_cj'] == 1){
			$onemoney = round($true_price * ($one_bili*1) / 100 ,2);
			if($userinfo_new['parent_id'] != '0'){
				// 分销订单流水记录
				$lsdata = array(
					"uniacid" => $uniacid,
					"openid" => $openid,
					"parent_id" => $userinfo_new['parent_id'],
					"parent_id_get" => $onemoney,
					"p_parent_id" => 0,
					"p_parent_id_get" => 0,
					"p_p_parent_id" => 0,
					"p_p_parent_id_get" => 0,
					"order_id" => $order_id,
					"creattime" => time()
				);
				pdo_insert("sudu8_page_fx_ls",$lsdata);
			}
		}
		// 启动二级分销提成
		if($guiz['fx_cj'] == 2){
			$onemoney = round($true_price * ($one_bili*1) / 100 ,2);
			$twomoney = round($true_price * ($two_bili*1) / 100 ,2);
			$P = 0;
			$P_P = 0;
			if($userinfo_new['parent_id'] == '0'){
				$P = 0;
				$onemoney = 0;
			}else{
				$P = $userinfo_new['parent_id'];
				$onemoney = $onemoney;
			}
			if($userinfo_new['p_parent_id'] == '0'){
				$P_P = 0;
				$twomoney = 0;
			}else{
				$P_P = $userinfo_new['p_parent_id'];
				$twomoney = $twomoney;
			}
			// 分销订单流水记录
			$lsdata = array(
				"uniacid" => $uniacid,
				"openid" => $openid,
				"parent_id" => $P,
				"parent_id_get" => $onemoney,
				"p_parent_id" => $P_P,
				"p_parent_id_get" => $twomoney,
				"p_p_parent_id" => 0,
				"p_p_parent_id_get" => 0,
				"order_id" => $order_id,
				"creattime" => time()
			);
			pdo_insert("sudu8_page_fx_ls",$lsdata);
		}
		// 启动三级分销提成
		if($guiz['fx_cj'] == 3){
			$onemoney = round($true_price * ($one_bili*1) / 100 ,2);
			$twomoney = round($true_price * ($two_bili*1) / 100 ,2);
			$threemoney = round($true_price * ($three_bili*1) / 100 ,2);
			$P = 0;
			$P_P = 0;
			$P_P_P = 0;
			if($userinfo_new['parent_id'] == '0'){
				$P = 0;
				$onemoney = 0;
			}else{
				$P = $userinfo_new['parent_id'];
				$onemoney = $onemoney;
			}
			if($userinfo_new['p_parent_id'] == '0'){
				$P_P = 0;
				$twomoney = 0;
			}else{
				$P_P = $userinfo_new['p_parent_id'];
				$twomoney = $twomoney;
			}
			if($userinfo_new['p_p_parent_id'] == '0'){
				$P_P_P = 0;
				$threemoney = 0;
			}else{
				$P_P_P = $userinfo_new['p_p_parent_id'];
				$threemoney = $threemoney;
			}
			// 分销订单流水记录
			$lsdata = array(
				"uniacid" => $uniacid,
				"openid" => $openid,
				"parent_id" => $P,
				"parent_id_get" => $onemoney,
				"p_parent_id" => $P_P,
				"p_parent_id_get" => $twomoney,
				"p_p_parent_id" => $P_P_P,
				"p_p_parent_id_get" => $threemoney,
				"order_id" => $order_id,
				"creattime" => time()
			);
			pdo_insert("sudu8_page_fx_ls",$lsdata);
		}
		// 3.是否付钱升级为分销商
		if($userinfo_new['fxs'] == 1){   //支付完了还不是分销商
			$val = $guiz['fxs_sz_val'];
			if($guiz['fxs_sz'] == 3){  //消费次数
				// 获取我的消费次数
				$xf = pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_duo_products_order')." WHERE openid = :openid and uniacid = :uniacid and flag = 1 or flag =2" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
				if($xf['n']>=$val){
					pdo_update("sudu8_page_user",array("fxs"=>2,"fxstime"=>time()),array('openid' => $openid ,'uniacid' => $_W['uniacid']));
				}
			}
			if($guiz['fxs_sz'] == 4){  //消费过的金额？？？？？消费的金额？？？？？分销出去消费的金额？？？？？？
				// 获取我的消费
				$xf = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE openid = :openid and uniacid = :uniacid and flag = 1 or flag =2" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
				// 分销后重新下单的情况
				$jjmoney = 0;
				foreach ($xf as $key => &$res) {
					$jjmoney += $res['price'];
				}
				if($jjmoney >= $val){
					pdo_update("sudu8_page_user",array("fxs"=>2,"fxstime"=>time()),array('openid' => $openid ,'uniacid' => $_W['uniacid']));
				}
			}
		}
	}


	// 实时更新数据库数据
	public function doPageduogwcchange(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$id = $_GPC['id'];
		$num = $_GPC['num'];
		$data = array(
			"num" => $num
		);
		pdo_update("sudu8_page_duo_products_gwc",$data,array("id"=>$id));
	}
	// 购物车数量统计
	public function doPagegwcdata(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
		$uid = $userinfo['id'];
		$mygwc = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_gwc') ." WHERE uid = :uid and flag = 1", array(':uid'=>$uid));
		$counts = 0;
		foreach ($mygwc as $key => &$res) {
			$counts+=$res['num'];
		}
		return $this->result(0, 'success', $counts);
	}
	// 多规格的订单
	public function dopageduoorderlist(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		// 处理已发货并且过了7天还没有确定的订单
        $clorders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and flag = 4" , array(':uniacid' => $_W['uniacid']));
        foreach ($clorders as $key => &$res) {
            $st = $res['hxtime']*1 + 3600*24*7;
            if($st < time()){
                $adata = array(
                    "hxtime" => $st,
                    "flag" => 2
                );
                pdo_update("sudu8_page_duo_products_order",$adata,array('id'=>$res['id']));
                // 核销完成后去检测要不要进行分销商返现
                $order_id = $res['order_id'];
                $openid = $res['openid'];
                $fxsorder = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_ls')." WHERE uniacid = :uniacid and order_id = :orderid" , array(':uniacid' => $uniacid,':orderid'=>$order_id));
                if($fxsorder){
                    $this->dopagegivemoney($openid,$order_id);
                }
            }
        }
		// 先处理未支付并超过30分钟的订单
		$wforders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and flag = 0" , array(':uniacid' => $_W['uniacid']));
        foreach ($wforders as $key => &$res) {
            $st = $res['creattime'] + 1800;
            if($st < time()){
                $adata = array(
                    "flag" => 3
                );
                pdo_update("sudu8_page_duo_products_order",$adata,array('id'=>$res['id']));
                pdo_update("sudu8_page_fx_ls",$adata,array('uniacid' => $uniacid,'orderid'=>$res['order_id']));
            }
        }
        //订单状态 类型
        $flag = $_GPC['flag'];
        $type1 = $_GPC['type1'];
        $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and openid = :openid order by id desc" , array(':uniacid' => $_W['uniacid'],':openid' => $openid));


        if($flag == 0){
        	$orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and openid = :openid and flag = 0 order by id desc" , array(':uniacid' => $_W['uniacid'],':openid' => $openid));
        }

        if($flag == 1 && $type1 == 1){
        	$orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and openid = :openid and flag = 1 and nav =1 order by id desc" , array(':uniacid' => $_W['uniacid'],':openid' => $openid));
        }
        if($flag == 1 && $type1 == 2){
        	$orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and openid = :openid and flag = 1 and nav =2 order by id desc" , array(':uniacid' => $_W['uniacid'],':openid' => $openid));
        }
        if($flag == 2){
        	$orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and openid = :openid and flag = 2 order by id desc" , array(':uniacid' => $_W['uniacid'],':openid' => $openid));
        }
        if($flag == 3){
        	$orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and openid = :openid and flag = 3 order by id desc" , array(':uniacid' => $_W['uniacid'],':openid' => $openid));
        }
        if($flag == 4){
        	$orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and openid = :openid and flag = 4 order by id desc" , array(':uniacid' => $_W['uniacid'],':openid' => $openid));
        }

        foreach ($orders as $key => &$res) {
            $res['jsondata'] = unserialize($res['jsondata']);
            $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
            $res['hxtime'] = $res['hxtime'] == 0?"未核销":date("Y-m-d H:i:s",$res['hxtime']);
            $res['userinfo'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
            $res['counts'] = count($res['jsondata']);

            $val = pdo_fetch("SELECT val FROM ".tablename('sudu8_page_formcon')." WHERE uniacid = :uniacid and id = :id " , array(':id' => $res['formid'] ,':uniacid' => $_W['uniacid']));
            if($val){
	            $val = unserialize($val['val']);
	            foreach($val as $k => &$v){
	            	if(is_array($v['val'])){
	            		$vl = "";
	            		foreach($v['val'] as $kk => $vv){
	            			$vl=$vl.$vv.",";
	            		}
	            		$v['val'] = substr($vl,0,-1);;
	            	}
	            	if($v['type']==5){
	            		foreach($v['z_val'] as $ki =>&$vi){
	            			if(strpos($v,"http")===false){
	            				$vi = HTTPSHOST.$vi;
	            			}
	            		}
	            	}
	            }
            	$res['val'] = $val;
            }else{
            	$res['val'] = '';
            }
        }
        return $this->result(0, 'success', $orders);
	}
	//多规格的订单30分钟后结束
	public function dopagesetorderover(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$time = time();
		$orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and openid = :openid and flag = 0" , array(':uniacid' => $_W['uniacid'],':openid' => $openid));
		foreach ($orders as $key => &$res) {
			$overtime = $res['creattime'] + (30*60);
		}
	} 
	// 多规格订单详情
	public function dopageduoorderinfo(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$orderid = $_GPC['orderid'];
		$orders = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and order_id = :order_id" , array(':uniacid' => $_W['uniacid'],':order_id' => $orderid));
		$orders['jsondata'] = unserialize($orders['jsondata']);
		return $this->result(0, 'success', $orders);
	}
	// 修改多规格订单
	public function dopageduoorderchangegg(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$orderid = $_GPC['orderid'];
		$couponid = $_GPC['couponid'];
		$price = $_GPC['price'];
		$dkscore = $_GPC['dkscore'];
		$address = $_GPC['address'];
		$mjly = $_GPC['mjly'];
		$nav = $_GPC['nav'];
		$data = array(
			"coupon" => $couponid,
			"price" => $price,
			"jf" => $dkscore,
			"address" => $address,
			"liuyan" => $mjly,
			"nav"=>$nav
		);
		pdo_update("sudu8_page_duo_products_order",$data,array("uniacid"=>$uniacid,"order_id"=>$orderid));
	}
	// 申请成为分销商基本新
	public function dopagesqcwfxsbase(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$gz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_gz') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
		if($gz['sq_thumb']){
			$gz['sq_thumb'] = HTTPSHOST.$gz['sq_thumb'];
		}else{
			$gz['sq_thumb'] = MODULE_URL."static/img/fx_banner.jpg";
		}
		$sq = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_sq')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $uniacid));
		$user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
		$parent_id = $user['parent_id'];
		if($parent_id=='0' || !$user){
			$fxs = "总店";
		}else{
			$fxsinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $parent_id ,':uniacid' => $_W['uniacid']));	
			$fxs = $fxsinfo['nickname'];
		}
		$data['gz'] = $gz;
		$data['sq'] = $sq;
		$data['userinfo'] = $user;
		$data['fxs'] = $fxs;
		return $this->result(0, 'success', $data);
	}
	// 分销商中心
	public function dopagefxszhongx(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$sq = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_sq')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $uniacid));
		$user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $uniacid));
		$arr['sq'] = $sq;
		$arr['user'] = $user;
		$arr['order_counts'] = 0;
		$arr['team_counts'] = 0;
		$arr['tx_counts'] = 0;
		$arr['zuidi'] = 0;
		//我的团队数据
		$team_counts = pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_user')." WHERE  uniacid = :uniacid and (parent_id = :id or p_parent_id = :pid or p_p_parent_id = :ppid)" , array(':uniacid' => $_W['uniacid'],':id' => $openid ,':pid' => $openid ,':ppid' => $openid));
		$arr['team_counts'] = $team_counts['n']; 
		// 分销订单
		$order_counts = pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_fx_ls')." WHERE uniacid = :uniacid  and (parent_id = :openid1 or p_parent_id = :openid2 or p_p_parent_id = :openid3) " , array(':uniacid' => $_W['uniacid'], ':openid1'=>$openid,':openid2'=>$openid,':openid3'=>$openid));
		$arr['order_counts'] = $order_counts['n'];
		// 提现申请
		$tx_counts = pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_fx_tx')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
		$arr['tx_counts'] = $tx_counts['n'];
		// 最低提现规则
		$guiz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		$arr['zuidi'] = $guiz['txmoney'];
		$arr['guiz'] = $guiz;
		return $this->result(0, 'success', $arr);
	}
	// 申请成为分销商
	public function dopagesqcwfxs(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$truename = $_GPC['truename'];
		$truetel = $_GPC['truetel'];
		$openid = $_GPC['openid'];
		$sq = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_sq')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $uniacid));
		$guiz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		if($guiz['fxs_sz']==1){
			$data=array(
				"openid" => $openid,
				"uniacid" => $uniacid,
				"truename" => $truename,
				"truetel" => $truetel,
				"creattime" => time(),
				"flag" => 2
			);
			pdo_insert("sudu8_page_fx_sq",$data);
			pdo_update("sudu8_page_user",array("fxs"=>2), array('openid' => $openid ,'uniacid' => $_W['uniacid']));
			$flag = -1;
		}else{
			$flag = 0;
			if($sq){
				if($sq['flag'] == 1 || $sq['flag'] == 2){
					$flag = $sq['flag'];
				}else{
					$flag = 4;
				}
			}else{
				$flag = 4;
			}
			if($flag == 4){
				$data=array(
					"openid" => $openid,
					"uniacid" => $uniacid,
					"truename" => $truename,
					"truetel" => $truetel,
					"creattime" => time()
				);
				pdo_insert("sudu8_page_fx_sq",$data);
			}
		}
		return $this->result(0, 'success', $flag);
	}
	// 我的团队
	public function dopagemyteam(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$types = $_GPC['types']?$_GPC['types']:1;
		// 去获取开启了几级目录
		$guiz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		if($types==1){
			$user = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_user')." WHERE 	parent_id = :id and uniacid = :uniacid" , array(':id' => $openid ,':uniacid' => $_W['uniacid']));
		}
		if($types==2){
			$user = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_user')." WHERE 	p_parent_id = :id and uniacid = :uniacid" , array(':id' => $openid ,':uniacid' => $_W['uniacid']));
		}
		if($types==3){
			$user = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_user')." WHERE 	p_p_parent_id = :id and uniacid = :uniacid" , array(':id' => $openid ,':uniacid' => $_W['uniacid']));
		}
		foreach ($user as $key => &$res) {
			$counts = pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_user')." WHERE  uniacid = :uniacid and (parent_id = :id or p_parent_id = :pid or p_p_parent_id = :ppid)" , array(':uniacid' => $_W['uniacid'],':id' => $res['openid'] ,':pid' => $res['openid'] ,':ppid' => $res['openid']));
			$res['zjcount'] = $counts['n'];
			$res['createtime'] = date("Y-m-d H:i:s", $res['createtime']);
		}
		$data['user'] = $user;
		$data['cj'] = $guiz['fx_cj'];
		return $this->result(0, 'success', $data); 
	}
	// 分销订单数据统计
	public function dopagefxcount(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$orders1 = pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_fx_ls')." WHERE uniacid = :uniacid and flag = 1 and (parent_id = :openid1 or p_parent_id = :openid2 or p_p_parent_id = :openid3) " , array(':uniacid' => $_W['uniacid'], ':openid1'=>$openid,':openid2'=>$openid,':openid3'=>$openid));
		$orders2 = pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_fx_ls')." WHERE uniacid = :uniacid and flag = 2 and (parent_id = :openid1 or p_parent_id = :openid2 or p_p_parent_id = :openid3) " , array(':uniacid' => $_W['uniacid'], ':openid1'=>$openid,':openid2'=>$openid,':openid3'=>$openid));
		$orders3 = pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_fx_ls')." WHERE uniacid = :uniacid and flag = 3 and (parent_id = :openid1 or p_parent_id = :openid2 or p_p_parent_id = :openid3) " , array(':uniacid' => $_W['uniacid'], ':openid1'=>$openid,':openid2'=>$openid,':openid3'=>$openid));
		$data = array(
			"onecount" => $orders1['n'],
			"twocount" => $orders2['n'],
			"threecount" => $orders3['n'],
		);
		return $this->result(0, 'success', $data); 
	}
	// 分销订单
	public function dopagefxdingd(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$types = $_GPC['types'];
		$guiz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		if($types!=1){
			$nty = $types - 1;
			$orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_fx_ls')." WHERE uniacid = :uniacid and flag = :flag and (parent_id = :openid1 or p_parent_id = :openid2 or p_p_parent_id = :openid3) order by id desc" , array(':uniacid' => $_W['uniacid'], ':flag'=>$nty, ':openid1'=>$openid,':openid2'=>$openid,':openid3'=>$openid));
		}else{
			$orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_fx_ls')." WHERE uniacid = :uniacid and parent_id = :openid1 or p_parent_id = :openid2 or p_p_parent_id = :openid3 order by id desc" , array(':uniacid' => $_W['uniacid'],':openid1'=>$openid,':openid2'=>$openid,':openid3'=>$openid));
		}
		foreach ($orders as $key => &$res) {
			$v = 0;
			$bili = 0;
			// 根据订单号去订单里面去jsondata
			$orderinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and order_id = :order_id" , array(':uniacid' => $_W['uniacid'],':order_id' => $res['order_id']));		
			$jsdata = unserialize($orderinfo['jsondata']);
			$one_bili = $jsdata[0]['one_bili'];
			$two_bili = $jsdata[0]['two_bili'];
			$three_bili = $jsdata[0]['three_bili'];
			if($res['parent_id'] == $openid){
				$v = 1;
				$bili = $one_bili;
			}
			if($res['p_parent_id'] == $openid){
				$v = 2;
				$bili = $two_bili;
			}
			if($res['p_p_parent_id'] == $openid){
				$v = 3;
				$bili = $three_bili;
			}
			$order = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and order_id = :orderid" , array(':uniacid' => $uniacid,':orderid'=>$res['order_id']));
			$res['datas'] = unserialize($order['jsondata']);
			foreach ($res['datas'] as $key => &$reb) {
				$mm = $reb['num'] * $reb['proinfo']['price'] * $bili / 100;
				$reb['kmoney'] = $mm;
			}
			$res['creattime'] = date("Y-m-d H:i",$res['creattime']);
			$res['v'] = $v;
		} 
		return $this->result(0, 'success', $orders); 
	}
	// 我的账户
	public function dopagegetmzh(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
		// 申请提现中的钱
		$ord = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_fx_tx')." WHERE uniacid = :uniacid and flag = 1", array(':uniacid' => $uniacid));
		$wfmoney = 0;
		foreach ($ord as $key => &$res) {
			$wfmoney+=$res['money']*1;
		}
		$data['userinfo'] = $userinfo;
		$data['wfmoney'] = $wfmoney; 
		return $this->result(0, 'success', $data); 
	}
	// 向我的上级返钱操作['并生成流水记录']
	public function dopagegivemoney($openid,$orderid){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$guiz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		$order = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_ls')." WHERE uniacid = :uniacid and order_id = :orderid" , array(':uniacid' => $uniacid,':orderid'=>$orderid));
		pdo_update("sudu8_page_fx_ls",array("flag"=>2),array("order_id"=>$orderid));
		$me = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['openid'] ,':uniacid' => $_W['uniacid']));
        $me_p_get_money = $me['p_get_money'];
        $me_p_p_get_money = $me['p_p_get_money'];
        $me_p_p_p_get_money = $me['p_p_p_get_money'];
		// 启动一级分销提成
		if($guiz['fx_cj'] == 1){
			if($order['parent_id']){
				$puser = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['parent_id'] ,':uniacid' => $_W['uniacid']));
				$kdata = array(
					"fx_allmoney" => $puser['fx_allmoney'] + $order['parent_id_get'],
					"fx_money" => $puser['fx_money'] + $order['parent_id_get']
				);
				pdo_update("sudu8_page_user",$kdata,array('openid' => $order['parent_id'] ,'uniacid' => $uniacid));
				// 我给我的父级贡献的钱
                $new_p_get_money = $me_p_get_money*1 + $order['parent_id_get']*1;
                pdo_update("sudu8_page_user",array("p_get_money" => $new_p_get_money),array('openid' => $order['openid'] ,'uniacid' => $uniacid));
			}
		}
		// 启动二级分销提成
		if($guiz['fx_cj'] == 2){
			if($order['parent_id']){
				$puser = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['parent_id'] ,':uniacid' => $_W['uniacid']));
				$kdata = array(
					"fx_allmoney" => $puser['fx_allmoney'] + $order['parent_id_get'],
					"fx_money" => $puser['fx_money'] + $order['parent_id_get']
				);
				pdo_update("sudu8_page_user",$kdata,array('openid' => $order['parent_id'] ,'uniacid' => $uniacid));
				// 我给我的父级贡献的钱
                $new_p_get_money = $me_p_get_money*1 + $order['parent_id_get']*1;
                pdo_update("sudu8_page_user",array("p_get_money" => $new_p_get_money),array('openid' => $order['openid'] ,'uniacid' => $uniacid));
			}
			if($order['p_parent_id']){
				$puser = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['p_parent_id'] ,':uniacid' => $_W['uniacid']));
				$kdata = array(
					"fx_allmoney" => $puser['fx_allmoney'] + $order['p_parent_id_get'],
					"fx_money" => $puser['fx_money'] + $order['p_parent_id_get']
				);
				pdo_update("sudu8_page_user",$kdata,array('openid' => $order['p_parent_id'] ,'uniacid' => $uniacid));
				// 我给我的父级的父级贡献的钱
                $new_p_p_get_money = $me_p_p_get_money*1 + $order['p_parent_id_get']*1;
                pdo_update("sudu8_page_user",array("p_p_get_money" => $new_p_p_get_money),array('openid' => $order['openid'] ,'uniacid' => $uniacid));
			}
		}
		// 启动三级分销提成
		if($guiz['fx_cj'] == 3){
			if($order['parent_id']){
				$puser = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['parent_id'] ,':uniacid' => $_W['uniacid']));
				$kdata = array(
					"fx_allmoney" => $puser['fx_allmoney'] + $order['parent_id_get'],
					"fx_money" => $puser['fx_money'] + $order['parent_id_get']
				);
				pdo_update("sudu8_page_user",$kdata,array('openid' => $order['parent_id'] ,'uniacid' => $uniacid));
				// 我给我的父级贡献的钱
                $new_p_get_money = $me_p_get_money*1 + $order['parent_id_get']*1;
                pdo_update("sudu8_page_user",array("p_get_money" => $new_p_get_money),array('openid' => $order['openid'] ,'uniacid' => $uniacid));
			}
			if($order['p_parent_id']){
				$puser = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['p_parent_id'] ,':uniacid' => $_W['uniacid']));
				$kdata = array(
					"fx_allmoney" => $puser['fx_allmoney'] + $order['p_parent_id_get'],
					"fx_money" => $puser['fx_money'] + $order['p_parent_id_get']
				);
				pdo_update("sudu8_page_user",$kdata,array('openid' => $order['p_parent_id'] ,'uniacid' => $uniacid));
				// 我给我的父级的父级贡献的钱
                $new_p_p_get_money = $me_p_p_get_money*1 + $order['p_parent_id_get']*1;
                pdo_update("sudu8_page_user",array("p_p_get_money" => $new_p_p_get_money),array('openid' => $order['openid'] ,'uniacid' => $uniacid));
			}
			if($order['p_p_parent_id']){
				$puser = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['p_p_parent_id'] ,':uniacid' => $_W['uniacid']));
				$kdata = array(
					"fx_allmoney" => $puser['fx_allmoney'] + $order['p_p_parent_id_get'],
					"fx_money" => $puser['fx_money'] + $order['p_p_parent_id_get']
				);
				pdo_update("sudu8_page_user",$kdata,array('openid' => $order['p_p_parent_id'] ,'uniacid' => $uniacid));
				// 我给我的父级的父级的附近贡献的钱
                $new_p_p_p_get_money = $me_p_p_p_get_money*1 + $order['p_p_parent_id_get']*1;
                pdo_update("sudu8_page_user",array("p_p_p_get_money" => $new_p_p_p_get_money),array('openid' => $order['openid'] ,'uniacid' => $uniacid));
			}
		}
	}
	// 点击确认订单按钮
	public function dopagequerenxc(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$orderid = $_GPC['orderid'];
		$openid = $_GPC['openid'];
		$adata = array(
            "hxtime" => time(),
            "flag" => 2
        );
		// var_dump($orderid);
		// var_dump($adata);
		// die();
        pdo_update("sudu8_page_duo_products_order",$adata,array('order_id'=>$orderid));
        //pdo_update("sudu8_page_duo_products_order",array("flag"=>2),array('order_id'=>$orderid));
		$fxsorder = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_ls')." WHERE uniacid = :uniacid and order_id = :orderid" , array(':uniacid' => $uniacid,':orderid'=>$orderid));
        if($fxsorder){
            $this->dopagegivemoney($openid,$orderid);
        }
	}
	// 我要提现申请
	public function dopagewytixian(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
		$guiz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		$data['userinfo'] = $userinfo;
		$data['guiz'] = $guiz;
		return $this->result(0, 'success', $data); 
	}
	// 获取分销商规则
	public function dopagehuoqfxsgz(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$guiz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		return $this->result(0, 'success', $guiz); 
	}
   	// 分销商提现了
   	public function dopagefxstixian(){
   		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$money = $_GPC['money'];
		$data = array(
			"uniacid" => $uniacid,
			"openid" => $openid,
			"money" => $money,
			"types"=>$_GPC['xuanz'],
			"zfbzh"=>$_GPC['zfbzh'],
			"zfbxm"=>$_GPC['zfbxm'],
			"creattime" => time()
		);
		pdo_insert("sudu8_page_fx_tx",$data); 
		// 申请提现的同时减去提现的数据
		$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
		$fx_money = $userinfo['fx_money'];
		$new_fx_money = $fx_money*1 - $money*1;
		pdo_update("sudu8_page_user",array("fx_money"=>$new_fx_money),array('openid' => $openid ,'uniacid' => $_W['uniacid']));
   	}
   	// 分销商提现记录
   	public function dopagefxstxjl(){
   		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$val = $_GPC['val'];
		if($val==1){
			$txjl = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_fx_tx')." WHERE openid = :openid and uniacid = :uniacid order by id desc" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
		}else{
			$flag = $val-1;
			$txjl = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_fx_tx')." WHERE openid = :openid and uniacid = :uniacid and flag = :flag order by id desc" , array(':openid' => $openid ,':uniacid' => $_W['uniacid'], ':flag' => $flag));
		}
		foreach ($txjl as $key => &$res) {
			$res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
		}
		return $this->result(0, 'success', $txjl); 
   	}
   	// 付费视频操作
   	public function dopagevideozhifu(){
   		global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $money = $_GPC['money'];
        $mykoumoney = $_GPC['mykoumoney'];
        $types = $_GPC['types'];
        $id = $_GPC['id'];
        $now = time();
        $order_id = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
        $userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :id and uniacid = :uniacid" , array(':id' => $openid ,':uniacid' => $uniacid));
        if($types == 1){  //直接扣除余额
        	$newmoney = $userinfo['money']*1 - $mykoumoney*1;
        	pdo_update("sudu8_page_user",array("money"=>$newmoney),array("openid"=>$openid,"uniacid"=>$uniacid));
        	// 创建视频消费记录
        	$kdata = array(
        		"uniacid" => $uniacid,
        		"openid" => $openid,
        		"pid" => $id,
        		"orderid" => $order_id,
        		"paymoney" => $mykoumoney,
        		"creattime" => time()
        	);
        	pdo_insert("sudu8_page_video_pay",$kdata);
	        	// 创建消费流水
	        $xfmoney = array(
				"uniacid" => $uniacid,
				"orderid" => $order_id,
				"uid" => $userinfo['id'],
				"type" => "del",
				"score" => $mykoumoney,
				"message" => "视频消费",
				"creattime" => time()
			);	
			if($mykoumoney>0){
				pdo_insert("sudu8_page_money",$kdata);
			}
        }else{
        	// 2.调起支付
	        $app = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
			$paycon = pdo_fetch("SELECT * FROM ".tablename('uni_settings')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
			$datas = unserialize($paycon['payment']);
	        include 'WeixinPay.php';  
			$appid=$app['key'];  
			$openid= $openid;
			$mch_id=$datas['wechat']['mchid'];  
			$key=$datas['wechat']['signkey'];
			if(isset($datas['wechat']['identity'])){
				$identity = $datas['wechat']['identity'];
			}else{
				$identity = 1;
			}

			if(isset($datas['wechat']['sub_mchid'])){
				$sub_mchid = $datas['wechat']['sub_mchid'];
			}else{
				$sub_mchid = 0;
			}


			$out_trade_no = $order_id;  //订单号
			$body = "账户充值";
			$total_fee = $money*100;
			$weixinpay = new WeixinPay($appid,$openid,$mch_id,$key,$out_trade_no,$body,$total_fee,$identity,$sub_mchid);  


			// $out_trade_no = $order_id;  //订单号
			// $body = "账户充值";
			// $total_fee = $money*100;
			// $weixinpay = new WeixinPay($appid,$openid,$mch_id,$key,$out_trade_no,$body,$total_fee);  
			$return=$weixinpay->pay();  
			$return['order_id'] = $order_id;
			return $this->result(0, 'success',$return);
        }
   	}
   	// 更改付费视频的相关信息
   	public function dopagevideogeng(){
   		global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $openid = $_GPC['openid'];
        $money = $_GPC['money'];
        $mykoumoney = $_GPC['mykoumoney'];
        $order_id = $_GPC['orderid'];
        $id = $_GPC['id'];
        $userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :id and uniacid = :uniacid" , array(':id' => $openid ,':uniacid' => $uniacid));
        $newmoney = $userinfo['money']*1 - $mykoumoney*1;
        pdo_update("sudu8_page_user",array("money"=>0),array("openid"=>$openid,"uniacid"=>$uniacid));
        // 创建视频消费记录
    	$kdata = array(
    		"uniacid" => $uniacid,
    		"openid" => $openid,
    		"pid" => $id,
    		"orderid" => $order_id,
    		"paymoney" => $mykoumoney,
    		"creattime" => time()
    	);
    	pdo_insert("sudu8_page_video_pay",$kdata);
        // 创建消费流水个人账户
        if($mykoumoney>0){
        	$xfmoney1 = array(
				"uniacid" => $uniacid,
				"orderid" => $order_id,
				"uid" => $userinfo['id'],
				"type" => "del",
				"score" => $mykoumoney,
				"message" => "视频消费",
				"creattime" => time()
			);	
			if($mykoumoney>0){
				pdo_insert("sudu8_page_money",$xfmoney1);
			}
        }
		$xfmoney2 = array(
			"uniacid" => $uniacid,
			"orderid" => $order_id,
			"uid" => $userinfo['id'],
			"type" => "del",
			"score" => $money,
			"message" => "视频消费",
			"creattime" => time()
		);	
		if($money>0){
			pdo_insert("sudu8_page_money",$xfmoney2);
		}
   	}
   	public function dopagediypage(){
	    global $_W,$_GPC;

	    $uniacid = $_W['uniacid'];


	    $pageid = $_GPC['pageid'];
	    $sql = "SELECT * FROM ".tablename('sudu8_page_diypage')." WHERE `id` = {$pageid}";

	    $data = pdo_fetch($sql);
	    if($data['page'] != ''){
	        $data['page'] = unserialize($data['page']);

        }

        if($data['items'] != ''){
	        $data['items'] = unserialize($data['items']);
	        foreach($data['items'] as $k => &$v){
	        	if($v['id'] == "banner"){
	        		$v['data'] = array_values($v['data']);
	        	}
	        	if($v['id'] == "richtext"){
	        		$data['items']['richtext'] = base64_decode(array_values($v)[1]['content']);
	        	}
	        	if($v['id'] == "feedback"){
	        		$sourceid = explode(':',$v['params']['sourceid'])[1];
	        		$data['forminfo'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_formlist')." WHERE `uniacid` = {$_W['uniacid']}  AND `id` = {$sourceid}");
	        		if($data['forminfo']){
	        			$data['forminfo']['tp_text'] = unserialize($data['forminfo']['tp_text']);
	        			foreach($data['forminfo']['tp_text'] as $key=>&$res){
							if($res["type"]!=2 && $res["type"]!=5){
								$vals= explode(",", $res['tp_text']);
								$kk = array();
								foreach ($vals as $key => &$rec) {
									$kk['yval'] = $rec;
									$kk['checked'] = "false";
									$rec = $kk;
								}
								$res['tp_text'] = $vals;
							}
							if($res["type"]==2){
								$vals= explode(",", $res['tp_text']);
								$res['tp_text'] = $vals;
							}
							$res['val']='';
						}
	        		}
	        	}
	        	if($v['id'] == "msmk"){
	        		$sourceid = explode(':',$v['params']['sourceid'])[1];
	        		$count = $v['params']['goodsnum'];
	        		$sql = "SELECT title,thumb,id,`desc`,price,market_price,sale_num FROM ".tablename('sudu8_page_products')." WHERE `uniacid` = {$_W['uniacid']} AND `type` = 'showPro' AND `is_more` = 0 AND `cid` = {$sourceid} ORDER BY id DESC LIMIT 0,{$count}";
	        		$list = pdo_fetchall($sql);
	        		if($list){
	        			foreach($list as $kk => $vv){
	        				$list[$kk]['linkurl'] = "/sudu8_page/showPro/showPro?id=".$vv['id'];
	        				$list[$kk]['linktype'] = "page";
		        			if(strpos($vv['thumb'],'http') === false && $vv['thumb'] != ""){
	        					$list[$kk]['thumb'] = HTTPSHOST.$vv['thumb'];
	        				}
	        			}
	        			$data['items'][$k]['data'] = $list;
	        		}else{
	        			$data['items'][$k]['data'] = [];
	        		}
	        	}
	        	if($v['id'] == "pt"){
	        		$sourceid = explode(':',$v['params']['sourceid'])[1];
	        		$count = $v['params']['goodsnum'];
	        		$sql = "SELECT * FROM ".tablename('sudu8_page_pt_pro')." WHERE `uniacid` = {$_W['uniacid']}  AND `cid` = {$sourceid} ORDER BY id DESC LIMIT 0,{$count}";
	        		$list = pdo_fetchall($sql);
	        		if($list){
	        			foreach($list as $kk => $vv){
	        				$list[$kk]['linkurl'] = "/sudu8_page_plugin_pt/products/products?id=".$vv['id'];
	        				$list[$kk]['linktype'] = "page";
		        			if(strpos($vv['thumb'],'http') === false && $vv['thumb'] != ""){
	        					$list[$kk]['thumb'] = HTTPSHOST.$vv['thumb'];
	        				}
	        			}
	        			$data['items'][$k]['data'] = $list;
	        		}else{
	        			$data['items'][$k]['data'] = [];
	        		}
	        	}
	        	if($v['id'] == "cases"){
	        		$sourceid = explode(':',$v['params']['sourceid'])[1];
	        		$count = $v['params']['casenum'];
	        		$sql = "SELECT id,title,thumb FROM ".tablename('sudu8_page_products')." `type` = 'showPic' AND  WHERE `uniacid` = {$_W['uniacid']}  AND `cid` = {$sourceid} ORDER BY id DESC LIMIT 0,{$count}";
	        		$list = pdo_fetchall($sql);
	        		if($list){
	        			foreach($list as $kk => $vv){
	        				$list[$kk]['linkurl'] = "/sudu8_page/showPic/showPic?id=".$vv['id'];
		        			if(strpos($vv['thumb'],'http') === false && $vv['thumb'] != ""){
		        					$list[$kk]['thumb'] = HTTPSHOST.$vv['thumb'];
		        				}
	        			}
	        			$data['items'][$k]['data'] = $list;
	        		}else{
	        			$data['items'][$k]['data'] = [];
	        		}
	        	}
	        	if($v['id'] == "listdesc"){
	        		$sourceid = explode(':',$v['params']['sourceid'])[1];
	        		$count = $v['params']['newsnum'];
	        		$sql = "SELECT * FROM ".tablename('sudu8_page_products')." WHERE `type` = 'showArt' AND  `uniacid` = {$_W['uniacid']}  AND `cid` = {$sourceid} ORDER BY id DESC LIMIT 0,{$count}";
	        		$list = pdo_fetchall($sql);
	        		if($list){
	        			foreach($list as $kk => $vv){
	        				$count = count(pdo_fetchall("SELECT * FROM ".tablename("sudu8_page_comment")." WHERE `uniacid` = {$_W['uniacid']}  AND `id` = {$vv['id']}"));

	        				$list[$kk]['comments'] = $count;
	        				$list[$kk]['linkurl'] = "/sudu8_page/showArt/showArt?id=".$vv['id'];
		        			if(strpos($vv['thumb'],'http') === false && $vv['thumb'] != ""){
	        					$list[$kk]['thumb'] = HTTPSHOST.$vv['thumb'];
	        				}
	        				$list[$kk]['ctime'] = date('Y年m月d日',$vv['ctime']);
	        			}
	        			$data['items'][$k]['data'] = $list;
	        		}else{
	        			$data['items'][$k]['data'] = [];
	        		}
	        	}
	        	if(isset($v['params']['noticedata']) && intval($v['params']['noticedata']) == 0){
	        		/*读取系统公告*/
	        		$sourceid = explode(':',$v['params']['sourceid'])[1];
	        		$count = $v['params']['noticenum'];
	        		$sql = "SELECT id,title FROM ".tablename('sudu8_page_products')." WHERE `uniacid` = {$_W['uniacid']} AND `type` = 'showArt' AND `cid` = {$sourceid} ORDER BY id DESC LIMIT 0,{$count}";
	        		$list = pdo_fetchall($sql);
	        		if($list){
	        			foreach($list as $kk => $vv){
	        				$list[$kk]['linkurl'] = "/sudu8_page/showArt/showArt?id=".$vv['id'];
	        			}
	        			$data['items'][$k]['data'] = $list;
	        		}else{
	        			$data['items'][$k]['data'] = [];
	        		}
	        	}
	        	if($v['id'] == "kpgg" || $v['id'] == "tcgg"){
	        		if(intval($v['params']['navstyle']) == 0){
	        			$data['sec'] = $v['params']['sec'];
	        		}

	        		// if($v['data']['navstyle'])

	        	}
	        	if($v['id'] == "goods"){
	        		$sourceid = explode(':',$v['params']['sourceid'])[1];
	        		$count = $v['params']['goodsnum'];
	        		$sql = "SELECT * FROM ".tablename('sudu8_page_products')." WHERE `uniacid` = {$_W['uniacid']}  AND `cid` = {$sourceid} ORDER BY id DESC LIMIT 0,{$count}";
	        		$list = pdo_fetchall($sql);
	        		if($list){
	        			foreach($list as $kk => $vv){
	        				if($vv['type'] == "showPro"){
	        					$list[$kk]['linkurl'] = "/sudu8_page/showPro/showPro?id=".$vv['id'];
	        				}else{
	        					$list[$kk]['linkurl'] = "/sudu8_page/showProMore/showProMore?id=".$vv['id'];
	        				}
		        			if(strpos($vv['thumb'],'http') === false && $vv['thumb'] != ""){
		        					$list[$kk]['thumb'] = HTTPSHOST.$vv['thumb'];
		        				}
	        			}
	        			$data['items'][$k]['data'] = $list;
	        		}else{
	        			$data['items'][$k]['data'] = [];
	        		}
	        	}
	        	if($v['id'] == "footmenu"){
	        		$count = count($v['data']);
	        		$data['items'][$k]['count'] = $count;

	        		$text_is = $v['params']['textshow'];
	        		if($text_is==1){
	        			$data['footmenuh'] = $v['style']['paddingleft']*2 +$v['style']['textfont']+$v['style']['paddingtop']*2+ $v['style']['iconfont']+1;
	        			$data['foottext'] = 1;
	        		}else{
	        			$data['footmenuh'] = $v['style']['paddingtop']*2+ $v['style']['iconfont']+1;
	        			$data['foottext'] = 0;
	        		}
	        		$data['footmenu'] = 1;
	        	}
	        	if($v['id'] == "menu2"){
	        		$count = count($v['data']);
	        		$data['items'][$k]['count'] = $count;
	        	}
	        	if($v['id'] == "copyright"){
	        		$data['copyrights']['copyright_is'] = $v['params']['copyright_is'];
	        		$data['copyrights']['copyright_type'] = $v['params']['copyright_type'];
	        		$data['copyrights']['link'] = $v['params']['link'];
	        		$data['copyrights']['src'] = $v['params']['src'];
	        		$data['copyrights']['text'] = $v['params']['text'];
	        		$data['copyrights']['imgw'] = $v['style']['imgw'];
	        		$data['copyrights']['mt'] = $v['style']['mt'];
	        		$data['copyrights']['paddingtop'] = $v['style']['paddingtop'];
	        		$data['copyrights']['text_color'] = $v['style']['text_color'];
	        		$data['copyrights']['text_font'] = $v['style']['text_font'];
	        	}
	        	if($v['id'] == "tabbar"){
	        		$count = count($v['data']);
	        		$data['items'][$k]['count'] = $count;
	        	}
	        	if($v['id'] == "xxk"){
	        		$count = count($v['data']);
	        		$data['items'][$k]['count'] = $count;
	        	}
	        	if($v['id'] == "picturew"){
	        		$count = count($v['data']);
	        		$data['items'][$k]['count'] = $count;
	        		if($v['params']['row']==1){
	        			for($i=0;$i<=$count;$i++){
	        				$data['items'][$k]['data'] = array_values($v['data']);
	        			}
	        		}
	        	}
	        	if($v['id'] == "tabbar"){
	        		$datas = array();
	        		$i = 0;
	        		foreach($v['data'] as $kk =>$vv){
	        			$data['items'][$k]['datas'][$i] = $vv;
	        			$i++;
	        		}
	        		$count = count($v['data']);
	        		$data['items'][$k]['count'] = $count;
	        	}
	        	if($v['id'] == "xxk"){
	        		$datas = array();
	        		$i = 0;
	        		foreach($v['data'] as $kk =>$vv){
	        			$data['items'][$k]['datas'][$i] = $vv;
	        			$i++;
	        		}
	        		$count = count($v['data']);
	        		$data['items'][$k]['count'] = $count;
	        	}
	        }
        }
		$pageset = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_diypageset')." WHERE `uniacid` = {$uniacid}"); 
		$data['pageset'] = $pageset;
        return $this->result(0, 'success',$data);
        // echo json_encode($data);
	}
	// 省市区返回
	public function dopageprovincejson(){
		$province_string = include "province.json";
		return $province_string;
	}
	public function dopagecityjson(){
		$city_string = include "city.json";
		return $city_string;
	}
	public function dopageareajson(){
		$area_string = include "area.json";
		return $area_string;
	}
	//生成动态分享
	public function dopageshareewm(){
        global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid =  $_GPC['openid'];
		$types = $_GPC['types'];
		$frompage = $_GPC['frompage'];
		load()->func('file');
		// 先去找个人中心的二维码图片，如果存在直接取，否则去生成二维码
		$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
		// if($userinfo['ewm']){
		// 	$imgpath = HTTPSHOST.$userinfo['ewm'];
		// }else{}
			$app = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
	        $appid = $app['key'];
	        $appsecret = $app['secret'];
	        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
	        $weixin = file_get_contents($url);
	        $jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
	        $array = get_object_vars($jsondecode);//转换成数组
	        $access_token = $array['access_token'];//输出token
	        $ewmurl = "https://api.weixin.qq.com/wxa/getwxacode?access_token=".$access_token;
	        if($types==1){
		        	$sharepath = 'sudu8_page/index/index?fxsid='.$openid;
	        }else{
	        	$id = $_GPC['id'];
	        	if($frompage == "PT"){
			        	$sharepath = 'sudu8_page_plugin_pt/products/products?id='.$id."&fxsid=".$openid;
	        	}else{
			        	$sharepath = 'sudu8_page/'.$frompage.'/'.$frompage.'?id='.$id."&fxsid=".$openid;
	        	}
	        }
			$data = array(
	        	"path" => $sharepath,
	        	"width" => '80'
	        );
			$datas=json_encode($data);  
	        $result = $this->_Postrequest($ewmurl,$datas); 
	        $root = ATTACHMENT_ROOT;
			$path = "images/{$uniacid}/".date('Y/m/');
			$newpath = $root.$path;
			$sjc = time().rand(1000,9999);
			if(!file_exists($newpath)){
				mkdir($newpath);
			}
	    	file_put_contents($newpath.$sjc.".jpg", $result);
			if($_W['setting']['remote']['type'] == 0){  //没有开启远程附近
	        	$imgpath = "https://".$_SERVER['HTTP_HOST']."/attachment/".$path.$sjc.".jpg";
	        }else{
	        	$imgname = $path.$sjc.".jpg";
	        	if(is_file($newpath.$sjc.".jpg")){
	        		$pathqn = file_remote_upload($imgname,false);
	        		$imgpath = $_W['attachurl_remote'].$imgname;
	        	}
	        }
	        $crsjk = $path.$sjc.".jpg";
	        pdo_update("sudu8_page_user",array("ewm"=>$crsjk),array("openid"=>$openid,"uniacid"=>$uniacid));
		return $this->result(0, 'success',$imgpath);
	}
	function _Postrequest($url, $data, $ssl=true) {  
        //curl完成   
        $curl = curl_init();  
        //设置curl选项  
        curl_setopt($curl, CURLOPT_URL, $url);//URL  
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';  
        curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);//user_agent，请求代理信息  
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);//referer头，请求来源  
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间  
        //SSL相关  
        if ($ssl) {  
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//禁用后cURL将终止从服务端进行验证  
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//检查服务器SSL证书中是否存在一个公用名(common name)。  
        }  
        // 处理post相关选项  
        curl_setopt($curl, CURLOPT_POST, true);// 是否为POST请求  
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);// 处理请求数据  
        // 处理响应结果  
        curl_setopt($curl, CURLOPT_HEADER, false);//是否处理响应头  
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//curl_exec()是否返回响应结果  
        // 发出请求  
        $response = curl_exec($curl);
        if (false === $response) {  
            echo '<br>', curl_error($curl), '<br>';  
            return false;  
        }  
        curl_close($curl);  
        return $response;  
    }  
    // 下载完后删除服务器上面的图片
    public function dopageimgscdd(){
    	global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$imgsc = $_GPC['imgsc'];
		$arr = explode(HTTPSHOST, $imgsc);
		$path = $arr[1];
		$file = ATTACHMENT_ROOT.$path;
		unlink($file);
    }
    public function dopageshareguiz(){
    	global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$guiz = pdo_fetch("SELECT thumb FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		$neiw = HTTPSHOST.$guiz['thumb'];
		return $this->result(0, 'success',$neiw);
    }
    public function dopagebindfxs(){
    	global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$fxsid = $_GPC['fxsid'];
		// 分销商的关系[1.绑定上下级关系 ]
		$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
		// 分销商的信息
		$fxsinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $fxsid ,':uniacid' => $_W['uniacid']));
		//获取该小程序的分销关系绑定规则
		$guiz = pdo_fetch("SELECT fx_cj,sxj_gx,uniacid FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		// 1.先进行上下级关系绑定[判断是不是点击即成分销商]
		if($guiz['sxj_cj']!=4 && $guiz['sxj_gx']==1 && $userinfo['parent_id'] == '0' && $fxsid != '0' && $userinfo['fxs'] !=2 && $fxsinfo['fxs']==2){
			$p_fxs = $fxsinfo['parent_id'];  //分销商的上级
			$p_p_fxs = $fxsinfo['p_parent_id']; //分销商的上上级
			// 判断启用几级分销 
			$fx_cj = $guiz['fx_cj'];
			// 分别做判断
			if($fx_cj == 1){
				$uuser = pdo_update("sudu8_page_user",array("parent_id"=>$fxsid),array("openid"=>$openid,'uniacid' => $_W['uniacid']));
			}
			if($fx_cj == 2){
				$uuser = pdo_update("sudu8_page_user",array("parent_id"=>$fxsid,"p_parent_id"=>$p_fxs),array("openid"=>$openid,'uniacid' => $_W['uniacid']));
			}
			if($fx_cj == 3){
				$uuser = pdo_update("sudu8_page_user",array("parent_id"=>$fxsid,"p_parent_id"=>$p_fxs,"p_p_parent_id"=>$p_p_fxs),array("openid"=>$openid,'uniacid' => $_W['uniacid']));
			}
		}
		$adata['guiz'] = pdo_fetch("SELECT one_bili,two_bili,three_bili,uniacid FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		//return $this->result(0, 'success',$isbindfxs);
    }
    public function dopageupdatauserset(){
    	global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$items = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_usercenter_set') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
        $usercenterset = unserialize($items['usercenterset']);
        // 先组装成选择显示的数据
        $arrs = array();
        for($i = 1; $i <= 15; $i++){
            if($usercenterset['flag'.$i]==2){
                $jdata = array(
                    "title" => $usercenterset['title'.$i],
                    "thumb" => $usercenterset['thumb'.$i],
                    "num" => $usercenterset['num'.$i],
                    "url" => $usercenterset['url'.$i],
                    "icon" => $usercenterset['icon'.$i]
                );
                array_push($arrs, $jdata);
            }
        }
        // 对数据进行排序
        $counts = count($arrs);
        $temps = "";
        for($i = 0 ; $i < $counts-1; $i++){
            for($j = 0; $j < $counts - 1 -$i; $j++){
               if($arrs[$j+1]['num'] > $arrs[$j]['num']){
                    $temps = $arrs[$j];
                    $arrs[$j] = $arrs[$j+1];
                    $arrs[$j+1] = $temps;
               }
            }
        }
        foreach ($arrs as $key1 => &$reb) {
        	$reb['thumb'] = MODULE_URL.$reb['thumb'];
        }
		return $this->result(0, 'success', $arrs);
    }

    //新版个人中心功能列表请求接口
    public function dopageupdatausersetnew(){
    	global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$items = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_usercenter_set') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
        $usercenterset = unserialize($items['usercenterset']);
        // 先组装成选择显示的数据
        $arrs = array();
        $myorder = false;
        $mysign = false;
        for($i = 1; $i <= 15; $i++){
            if($usercenterset['flag'.$i]==2 && $usercenterset['num'.$i]!=5){
                $jdata = array(
                    "title" => $usercenterset['title'.$i],
                    "thumb" => $usercenterset['thumb'.$i],
                    "num" => $usercenterset['num'.$i],
                    "url" => $usercenterset['url'.$i],
                    "icon" => $usercenterset['icon'.$i]
                );
                array_push($arrs, $jdata);
            }
            if($usercenterset['flag'.$i]==2 && $usercenterset['num'.$i]== 5 ){
            	$myorder = true;
            }
            if($usercenterset['flag'.$i]==2 && $usercenterset['num'.$i]== 2 ){
            	$mysign = true;
            }
        }
        // 对数据进行排序
        $counts = count($arrs);
        $temps = "";
        for($i = 0 ; $i < $counts-1; $i++){
            for($j = 0; $j < $counts - 1 -$i; $j++){
               if($arrs[$j+1]['num'] > $arrs[$j]['num']){
                    $temps = $arrs[$j];
                    $arrs[$j] = $arrs[$j+1];
                    $arrs[$j+1] = $temps;
               }
            }
        }
        foreach ($arrs as $key1 => &$reb) {
        	$reb['thumb'] = MODULE_URL.$reb['thumb'];
        }
		return $this->result(0, 'success',array('arrs'=>$arrs, 'myorder'=>$myorder , 'mysign'=>$mysign));
    }

    // 获取对应独占预约的信息
    public function dopageDuzhan(){
    	global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$id = $_GPC['id'];
		$types = $_GPC['types'];
		$pagedatekey = $_GPC['pagedatekey'];
		$datys = $_GPC['days'];
		$strtime = strtotime($datys);
		$arrs = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_form_dd')." WHERE uniacid = :uniacid and cid = :cid and types = :types and datys = :datys and pagedatekey = :pagedatekey" , array(':uniacid' => $uniacid,':cid' => $id,':types' => $types,':datys' => $strtime,':pagedatekey' => $pagedatekey));
		$arrdata = array();
		foreach ($arrs as $key => &$res) {
			array_push($arrdata, $res['arrkey']);
		}
		return $this->result(0, 'success',$arrdata);  
    }
    // 获取优惠券开启设置
    public function dopagecouponset(){
    	global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$arrdata = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_set')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid'])); 
		return $this->result(0, 'success',$arrdata); 
    }
    // 302到图片
    public function dopagegetimg(){
    	global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$image_file = $_GPC['img'];
		Header("Location: ".$image_file);
    }
    // 更新手机号
    public function dopagemobilesetuser(){
    	global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$mobile = $_GPC['mobile'];
		$data = array(
			"mobile" => $mobile
		);
		$res = pdo_update('sudu8_page_user', $data, array('openid' => $openid ,'uniacid' => $uniacid));
    }
    public function dopagejiemi(){
    	global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$app = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
		$appid = $app['key'];
		$appsecret = $app['secret'];
		$code = $_GPC['code'];
		$url = "https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$appsecret."&js_code=".$code."&grant_type=authorization_code";
		$weixin = file_get_contents($url);
		$jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
		$array = get_object_vars($jsondecode);//转换成数组
		$sessionKey = $array['session_key'];
		$encryptedData=$_GPC['encryptedData'];
		$iv = $_GPC['iv'];
		include_once "wxBizDataCrypt.php";
		$pc = new WXBizDataCrypt($appid, $sessionKey); 
		$errCode = $pc->decryptData($encryptedData, $iv, $data);
		$arrdata = json_decode($data,TRUE);
		$tel = $arrdata['phoneNumber'];
		return $this->result(0, 'success', $tel);
    }
    //更新会员信息
	 public function dopageupdatehuiyuan(){
	  global $_GPC, $_W;
	  $uniacid = $_W['uniacid'];
	  $openid = $_GPC['openid'];
	  $data = array(
	   "realname" => $_GPC['myname'],
         "mobile" => $_GPC['mymobile'],
         "resideprovince" => $_GPC['provinceName'],
         "residecity" => $_GPC['cityName'],
         "residedist" => $_GPC['countyName'],
         "residecommunity" => $_GPC['detailInfo'],
         "birth" => $_GPC['birthday']
	  );
	  $res = pdo_update('sudu8_page_user', $data, array('openid' => $openid ,'uniacid' => $uniacid));
	 }
	 // 给我的上级积分了
	public function dopagegiveposcore(){
	 	global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];  //点击人
		$fxsid = $_GPC['fxsid'];  //分享人
		$id = $_GPC['id'];
		$types = $_GPC['types'];
		$today = strtotime(date("Y-m-d"),time());  
		$end = $today+60*60*24; 
		//判断今天有没有帮忙获取积分过
		$is_get = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pro_score_get')." WHERE uniacid = :uniacid and pid = :id and clickopenid = :openid and creattime > :btime and creattime < :etime" , array(':uniacid' => $uniacid,':id' => $id,':openid'=>$openid,':btime' => $today,':etime'=>$end));
		if($is_get){
			exit;
		}
		if($types != "PT"){
			$pro = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE uniacid = :uniacid and id = :id" , array(':uniacid' => $uniacid,':id' => $id)); 
		}
		// 开启了点击给上级积分规则
		if($pro['get_share_gz'] == 1){
			$score = $pro['get_share_score'];
			$num = $pro['get_share_num'];
			// 去判断今天获取的次数有没有达到上限
			$counts = pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_pro_score_get')." WHERE uniacid = :uniacid and pid = :pid and openid = :openid and creattime > ".$today." and creattime < ".$end." " , array(':uniacid' => $uniacid,':pid' => $id,':openid' => $fxsid));
			if($num > $counts['n']){ //今天还可以继续获得
				// 获取分享者的信息
				$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid", array(':uniacid' => $uniacid,':openid' => $fxsid));
				$newscore = $userinfo['score'] + $score;
				//给分享者加积分
				$res = pdo_update('sudu8_page_user', array("score"=>$newscore), array('openid' => $fxsid ,'uniacid' => $uniacid));
				// 插入今天的记录
				$data = array(
					"uniacid" => $uniacid,
					"openid" => $fxsid,
					"clickopenid" => $openid,
					"pid" => $id,
					"types" => $types,
					"score" => $score,
					"creattime" => time()
				);
				pdo_insert("sudu8_page_pro_score_get",$data);
				// 更新积分流水记录
				$order_id = date("Y",time()).date("m",time()).date("d",time()).date("H",time()).date("i",time()).date("s",time()).rand(1000,9999);
				$clickscore = array(
					"uniacid" => $uniacid,
					"orderid" => $order_id,
					"uid" => $userinfo['id'],
					"type" => "add",
					"score" => $score,
					"message" => "他人点击分享获取积分",
					"creattime" => time()
				);
				if($score>0){
					pdo_insert("sudu8_page_score",$clickscore);
				}
			}
		}
	}
	// 获取我的积分流水记录
	public function dopagegetmyscorelist(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$time = strtotime("2018-05-07");
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid", array(':uniacid' => $uniacid,':openid' => $openid));
		$counts = pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_score')." WHERE uniacid = :uniacid and uid = :uid and creattime > ".$time , array(':uniacid' => $uniacid,':uid' => $userinfo['id'])); 
		$list = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_score')." WHERE uniacid = :uniacid and uid = :uid and creattime > ".$time." order by creattime desc LIMIT ".($pindex - 1) * $psize.",".$psize , array(':uniacid' => $uniacid,':uid' => $userinfo['id'])); 
		foreach ($list as $key => &$res) {
			$res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
		}
		// 有没有下一页
		$show = $pindex * $psize;
		if($show >= $counts['n']){  //没有下一页了
			$isover = 2;
		}else{
			$isover = 1;
		}
		$adata['isover'] = $isover;
		$adata['lists'] = $list;
		return $this->result(0, 'success',$adata); 
	}
	// 获取我的积分流水记录
	public function dopagegetmymoneylist(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$openid = $_GPC['openid'];
		$time = strtotime("2018-05-07");
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid", array(':uniacid' => $uniacid,':openid' => $openid));
		$counts = pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_money')." WHERE uniacid = :uniacid and uid = :uid and creattime > ".$time , array(':uniacid' => $uniacid,':uid' => $userinfo['id'])); 
		$list = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_money')." WHERE uniacid = :uniacid and uid = :uid and creattime > ".$time." order by creattime desc LIMIT ".($pindex - 1) * $psize.",".$psize , array(':uniacid' => $uniacid,':uid' => $userinfo['id'])); 
		foreach ($list as $key => &$res) {
			$res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
		}
		// 有没有下一页
		$show = $pindex * $psize;
		if($show >= $counts['n']){  //没有下一页了
			$isover = 2;
		}else{
			$isover = 1;
		}
		$adata['isover'] = $isover;
		$adata['lists'] = $list;
		return $this->result(0, 'success',$adata); 
	}
	// 获取所有栏目
	public function dopageallCatep(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$allcate = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and cid = 0 and statue = 1 order by num desc " , array(':uniacid' => $uniacid)); 
		foreach($allcate as $k => $v){
			if($v['type']=="showArt" || $v['type']=="showPic" ||$v['type']=="showWxapps"){
				$allcate[$k]['url'] = "/sudu8_page/listPic/listPic?cid=".$v['id'];
			}else if($v['type']=="showPro"){
				$allcate[$k]['url'] = "/sudu8_page/listPro/listPro?cid=".$v['id'];
			}
		}
		$allcate_son = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and cid = :cid and statue = 1 order by num desc " , array(':uniacid' => $uniacid,':cid' => $allcate[0]['id'])); 
		foreach($allcate_son as $k => $v){
			if(strpos($v['catepic'],'http') === false){
				$allcate_son[$k]["catepic"] = HTTPSHOST.$v["catepic"];
			}
		}
		$result['list'] = $allcate;
		$result['son'] = $allcate_son;
		return $this->result(0, 'success',$result); 
	}
	// 获取子栏目
	public function dopagegetcateson(){
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$id = $_GPC['id'];
		$allcate_son = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and cid = :cid and statue = 1 order by num desc " , array(':uniacid' => $uniacid,':cid' => $id));
		foreach($allcate_son as $k => $v){
			if(strpos($v['catepic'],'http') === false){
				$allcate_son[$k]["catepic"] = HTTPSHOST.$v["catepic"];
			}
		} 
		return $this->result(0, 'success',$allcate_son); 
	}
  	
  	//开通vip
  	public function doPageregisterVIP(){
  		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];

		$openid = $_GPC['openid'];
		$vipid = pdo_fetchcolumn("SELECT vipid FROM ".tablename('sudu8_page_user')."WHERE uniacid = :uniacid and openid = :openid", array(':uniacid'=>$uniacid, ':openid'=>$openid));
		if(empty($vipid)){
			$region = str_replace('-', '|', $_GPC['region']);
			$vipid = time().''.rand(100000,999999);
			$data = array(
				'realname' => $_GPC['name'],
				'birth' => $_GPC['date'],
				'mobile' => $_GPC['phoneNumber'],
				'vipid' => $vipid,
				'vipcreatetime' => time(),
				'address' => $region . '|' . $_GPC['addressDetail']
			);
			$result = pdo_update('sudu8_page_user', $data, array('uniacid' => $uniacid, 'openid' => $openid));
			if(!$result){
				return $this->result(1, 'fail', '开通vip失败'); 
			}else{
				$applet = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
				$appid = $applet['key'];
				$appsecret = $applet['secret'];
				if($applet)
				{
					$mid =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_message')." WHERE uniacid = :uniacid and flag=8" , array(':uniacid' => $_W['uniacid']));
					if($mid)
					{
						if($mid['mid']!="")
						{
							$mids = $mid['mid'];
							$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
							$a_token = $this->_requestGetcurl($url);
							if($a_token)
							{
								$url_m="https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$a_token['access_token'];
								$formId=$_GPC['formId'];
								$ftitle=$_GPC['cardname'];
								$ftime=date('Y-m-d H:i:s',time());
								$fvipid=$vipid;
								$openid=$_GPC['openid'];
								$furl = $mid['url'];
								$frealname = $_GPC["name"];
								$post_info = '{
										  "touser": "'.$openid.'",  
										  "template_id": "'.$mids.'", 
										  "page": "'.$furl.'",          
										  "form_id": "'.$formId.'",         
										  "data": {
										      "keyword1": {
										          "value": "'.$ftitle.'", 
										          "color": "#173177"
										      }, 
										      "keyword2": {
										          "value": "'.$vipid.'", 
										          "color": "#173177"
										      }, 
										      "keyword3": {
										          "value": "'.$ftime.'", 
										          "color": "#173177"
										      }, 
										      "keyword4": {
										          "value": "'.$frealname.'", 
										          "color": "#173177"
										      } 
										  },
										  "emphasis_keyword": "" 
										}';
										$this->_requestPost($url_m,$post_info);
							}
						}
					}
				}
			}
		}
		return $this->result(0, 'success', $vipid); 
  	}

  	//查看个人vip信息
  	public function doPagegetVIPinfo(){
  		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];

		$openid = $_GPC['openid'];

		$info = pdo_fetch("SELECT realname,mobile,birth,address,vipid,vipcreatetime FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid", 
						array(':uniacid'=>$uniacid, ':openid'=>$openid));
		$info['address'] = str_replace('|', '', $info['address']);
		$info['year'] = date('Y', $info['vipcreatetime']);
		$info['month_day'] = date('m/d', $info['vipcreatetime']);
		$weeks = ['MON','TUE','WED','THUR','FRI','SAT','SUN'];
		$index = date('w', $info['vipcreatetime']);
		$info['week'] = $weeks[$index];
		return $this->result(0, 'success', $info); 
  	}

  	//检查会员卡设置
  	public function doPagecheckvip(){
  		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];

		$kwd = $_GPC['kwd'];
		$openid = $_GPC['openid'];

		$vipid = pdo_fetchcolumn("SELECT vipid FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid", array(':openid' => $openid ,':uniacid' => $uniacid));

		$needvip = pdo_fetchcolumn("SELECT ".$kwd." FROM ".tablename('sudu8_page_vip_config')." WHERE uniacid = :uniacid", array(':uniacid'=>$uniacid));

		//不是会员  会员可进
		if(empty($vipid) && ($needvip=='1')){
			$result = false;
			return $this->result(0, 'success', $result);
		}
		$result = true;
		return $this->result(0, 'success', $result);
  	}
}