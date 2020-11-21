<?php
/**
 * 微商城公告模块微站定义
 *
 * @author 微擎团队
 * @url 
 */
defined('IN_IA') or exit('Access Denied');
global $_W;
include IA_ROOT."/addons/".$_W['current_module']['name']."/func/func.php";

class yzhyk_sun_plugin_eatvisitModuleSite extends WeModuleSite {


	//分销设置
	public function doWebsetting(){
		global $_GPC, $_W;
		$settype = intval($_GPC["settype"]);
		$todo = $_GPC["todo"];
		$tid = $_GPC["tid"];
		$urlarray = array();
		$urlarray["settype"] = $settype;

		$info = pdo_get('yzhyk_sun_eatvisit_set', array('uniacid' => $_W['uniacid']));
		switch ($settype) {
			case 1:
				if($todo=="set"){
    				$token = getaccess_token();
    				$url="https://api.weixin.qq.com/cgi-bin/wxopen/template/add?access_token=".$token;
				    if($tid=="tpl_winnotice"){//中奖通知模板消息
				        $data['id']='AT1186';
				        $data['keyword_id_list']=[23,6,7];
				    }elseif($tid=="tpl_newnotice"){//新活动发布成功提醒
				        $data['id']='AT0856';
				        $data['keyword_id_list']=[1,3,10];
				    }else{
				        message('设置失败,参数错误','','error');
				    }
				    $data=json_encode($data);
				    $info = tocurl($url,$data,0);
				    $add=json_decode($info,true);

				    if($add['errcode']==0&&$add['errmsg']=='ok'){
				        if(empty($_GPC['id'])){
				            $datas['uniacid']=trim($_W['uniacid']);
				            $datas[$tid] = $add['template_id'];
				            $res=pdo_insert('yzhyk_sun_eatvisit_set',$datas);
				        }else{
				            $res=pdo_update('yzhyk_sun_eatvisit_set',array($tid=>$add['template_id']),array('uniacid'=>$_W['uniacid']));
				        }
				        if($res){
				            message('模板消息设置成功',$this->createWebUrl('setting', $urlarray),'success');
				        }else{
				            message('设置失败!','','error');
				        }
				    }else{
				        message('设置失败!!'.$add['errmsg'],'','error');
				    }

				}elseif($todo=="savetemplate"){
					$data = array();
					$data_first = $_GPC["indata"];
					$data = $data_first;
					if (empty($_GPC['id'])) {
						$data["uniacid"] = $_W['uniacid'];
						$res = pdo_insert('yzhyk_sun_eatvisit_set', $data);
					}else{
						$res = pdo_update('yzhyk_sun_eatvisit_set', $data, array('uniacid' => $_W['uniacid']));
					}
					if($res){
						message('成功!', $this->createWebUrl('setting', $urlarray), 'success');
					}else{
						message('失败!', $this->createWebUrl('setting', $urlarray), 'error');
					}
				}
				break;
			case 2:
				
				break;
			case 3:
                if (checksubmit()) {
                    $data = array();
                    $data_first = $_GPC["indata"];
                    $code = $data_first["code"];
                    if(empty($code)){
                        message('请输入激活码进行激活!', $this->createWebUrl('setting',$urlarray), 'error');
                    }
                    $ip_arr = gethostbynamel($_SERVER['HTTP_HOST']);
                    $ip = $ip_arr?$ip_arr[0]:0;
                    $toactive = encryptcode("35bcr/gGmbqRZmM3gx9efUySl+Z0XHe+7qtHS412VSPG9dGuTbxFC4IcCo4KjVQt", 'D','',0) . '/toactive.php?c=1&p=30&k='.$code.'&i='.$ip.'&u=' . $_SERVER['HTTP_HOST'];
                    $toactive = tocurl($toactive,10);
                    $toactive = trim($toactive, "\xEF\xBB\xBF");//去除bom头
                    $json_toactive = json_decode($toactive,true);

                    if($json_toactive["code"]===0){
                        $input_data = array();
                        $input_data["we7.cc"] = md5("we7_key");
                        $input_data["keyid"] = $json_toactive["data"]["id"];
                        $input_data["domain"] = $json_toactive["data"]["domain"];
                        $input_data["ip"] = $json_toactive["data"]["ip"];
                        $input_data["loca_ip"] = "127.0.0.1";
                        $input_data["pid"] = $json_toactive["data"]["pid"];
                        $input_data["time"] = time();
                        $input_data_s = serialize($input_data);
                        $input_data_s = encryptcode($input_data_s, 'E','',0);
                        $res = pdo_update('yzhyk_sun_acode', array("code"=>$input_data_s), array('id' =>3));
                        if(!$res){
                            $res = pdo_insert('yzhyk_sun_acode', array("code"=>$input_data_s,"id"=>3,"time"=>time()));
                        }
                        message('激活成功!', $this->createWebUrl('setting'), '');
                    }else{
                        message('激活失败!', $this->createWebUrl('setting'), 'error');
                    }
                }
				break;
			default:
				if (checksubmit()) {
					$data = array();
					$data_first = $_GPC["indata"];
					$data = $data_first;
					if (empty($_GPC['id'])) {
						$data["uniacid"] = $_W['uniacid'];
						$res = pdo_insert('yzhyk_sun_eatvisit_set', $data);
					}else{
						$res = pdo_update('yzhyk_sun_eatvisit_set', $data, array('uniacid' => $_W['uniacid']));
					}
					if($res){
						message('成功!', $this->createWebUrl('setting',$urlarr), 'success');
					}else{
						message('失败!', $this->createWebUrl('setting',$urlarr), 'error');
					}
				}
				break;
		}
		include $this->template('web/setting');
	}

/* 	public function __construct(){
		global $_W;
		$the = creatmdcode('aulelethclass');
		$thecode = creatmdcode('auleletheclasscode');
        $the::$thecode();
    } */

	//添加修改商品
	public function doWebGoodsinfo() {
		global $_GPC, $_W;
		$id = intval($_GPC['id']);
		$info = pdo_get('yzhyk_sun_eatvisit_goods', array('id' => $id));
		//获取商家数据
		// $brand = pdo_getall('yzhyk_sun_store', array('uniacid' => $_W['uniacid'],'isdel !='=>1));
        $brand = pdo_fetchall("select id,name from ".tablename('yzhyk_sun_store')." where isdel != 1 and uniacid = ".$_W['uniacid']);
        // var_dump($brand);

		if (checksubmit()) {
			$data = array();
			$data_first = $_GPC["indata"];
			
			if(empty($data_first["bid"])){
				message('请选择商家!', $this->createWebUrl('goodsinfo',array("id"=>$id)), 'error');
			}

			$store = explode("$$$",$data_first["bid"]);
			if(count($store)>1){
				$data_first["bid"] = $store[0];
				$data_first["storename"] = $store[1];
			}
			$data_first["isshelf"] = 1;
			$data_first["status"] = 2;
			$data_first["astime"] = strtotime($data_first["astime"]);
			$data_first["antime"] = strtotime($data_first["antime"]);
			$data_first["expirationtime"] = strtotime($data_first["expirationtime"]);
			$data_first["content"] = html_entity_decode($data_first["content"]);
			$data_first["usenotice"] = html_entity_decode($data_first["usenotice"]);
			$data = $data_first;
			if ($id==0) {
				$data["uniacid"] = $_W['uniacid'];
				$res = pdo_insert('yzhyk_sun_eatvisit_goods', $data);
			}else{
				$res = pdo_update('yzhyk_sun_eatvisit_goods', $data, array('uniacid' => $_W['uniacid'],'id' => $id));
			}
			if($res){
				message('成功!', $this->createWebUrl('goodslist'), 'success');
			}else{
				message('失败!', $this->createWebUrl('goodslist'), 'error');
			}

		}
		include $this->template('web/goodsinfo');
	}

	//商品管理列表
	public function doWebgoodslist() {
		global $_GPC, $_W;
		$tidstr = array("","推荐","不推荐");
		$isvip = array("不是","是");
		$status = array("","审核中","审核通过","拒绝");
		$isshelf = array("下架","上架");
		$pageindex = max(1, intval($_GPC['page']));
		$pagesize=10;
		$uniacid = $_W['uniacid'];
		$where = " where uniacid=:uniacid ";
		$data[':uniacid']=$uniacid;
		$sql = "select * from ".tablename('yzhyk_sun_eatvisit_goods')." ".$where;
		$select_sql =$sql." order by id desc LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
		// echo $select_sql;exit;
		$list=pdo_fetchall($select_sql,$data);
		$total=pdo_fetchcolumn("select count(*) as wname from ".tablename('yzhyk_sun_eatvisit_goods')." ".$where,$data);
		$pager = pagination($total, $pageindex, $pagesize);

		include $this->template('web/goodslist');
	}

	//订单管理列表
	public function doWeborderlist() {
		global $_GPC, $_W;
		$award_arr = array("特等奖","一等奖","二等奖","三等奖","四等奖");
		$status = array("","<font color='red'>未使用</font>","<font color='blue'>已使用</font>","<font color='green'>已过期</font>");
		$pageindex = max(1, intval($_GPC['page']));
		$pagesize=10;
		$uniacid = $_W['uniacid'];
		$where = " where o.uniacid=:uniacid ";
		$data[':uniacid']=$uniacid;
		$sql = "select o.*,u.name,g.expirationtime from ".tablename('yzhyk_sun_eatvisit_order')." as o left join ".tablename('yzhyk_sun_user')." as u on o.openid=u.openid left join ".tablename('yzhyk_sun_eatvisit_goods')." as g on g.id=o.gid ".$where;
		$select_sql =$sql." order by o.id desc LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
		// echo $select_sql;exit;
		$list=pdo_fetchall($select_sql,$data);
		foreach($list as $key => $val){
			if($val["status"]!=2){
				if($val["expirationtime"]<time()){
					$list[$key]["status"] = 3;
				}
			}
		}
		$total=pdo_fetchcolumn("select count(o.id) as wname from ".tablename('yzhyk_sun_eatvisit_order')." as o ".$where,$data);
		$pager = pagination($total, $pageindex, $pagesize);

		include $this->template('web/orderlist');
	}

	//改变状态
    public function doWebSetGoodsStatus(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $ty = $_GPC["ty"];
        $tb = $_GPC["tb"];
        if($ty=="status"){
        	$field = "status";
        }elseif($ty=="isshelf"){
        	$field = "isshelf";
        }else{
        	message('参数错误!', $this->createWebUrl('goodslist'), 'error');
        }
        $status = intval($_GPC["status"]);
        $id = intval($_GPC["id"]);
        $data = array();
        $data[$field] = $status;

        $updatetable = 'yzhyk_sun_eatvisit_goods';
    	$url = 'goodslist';

        if($tb=="order"){
    		$updatetable = 'yzhyk_sun_eatvisit_order';
    		$url = 'orderlist';
    		if($status==2){
    			$data["finishtime"] = time();
    		}
    	}

        $res = pdo_update($updatetable, $data, array('uniacid' => $_W['uniacid'],'id' => $id));
        if($res){
			message('成功!', $this->createWebUrl($url), 'success');
		}else{
			message('失败!', $this->createWebUrl($url), 'error');
		}
    } 

    //删除
    public function doWebDeleteData(){
    	global $_GPC, $_W;
    	$uniacid = $_W['uniacid'];
    	$tb = $_GPC["tb"];
    	$id = intval($_GPC["id"]);

    	$deletetable = 'yzhyk_sun_eatvisit_goods';
    	$url = 'goodslist';
    	if($tb=="order"){
    		$deletetable = 'yzhyk_sun_eatvisit_order';
    		$url = 'orderlist';
    	}

    	$delres=pdo_delete($deletetable,array('uniacid'=>$uniacid,'id'=>$id));
    	if($delres){
    		message('删除成功!', $this->createWebUrl($url), 'success');
    	}else{
    		message('删除失败!', $this->createWebUrl($url), 'error');
    	}
    }
}