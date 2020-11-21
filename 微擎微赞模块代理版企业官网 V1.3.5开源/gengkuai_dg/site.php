<?php
defined('IN_IA') or die('Access Denied');
define('PATH', '../addons/gengkuai_dg/template/');
class gengkuai_dgModuleSite extends WeModuleSite
{
	public $_appid = '';
	public $_appsecret = '';
	public $_accountlevel = '';
	public $_account = '';
	public $_weid = '';
	public $_fromuser = '';
	public $_nickname = '';
	public $_headimgurl = '';
	public $_sex = '';
	public $_activeid = 0;
	public $_auth2_openid = '';
	public $_auth2_nickname = '';
	public $_auth2_headimgurl = '';
	public $_auth2_sex = '';
	public $_auth2_code = '';
	public $table_reply = "gengkuai_dg_reply";
	public $table_news = "gengkuai_dg_news";
 	public $table_goods = "gengkuai_dg_goods";
	public $table_link = "gengkuai_dg_link";
	public $table_case = "gengkuai_dg_case";
	public $table_page = "gengkuai_dg_page";
	public $table_switch = "gengkuai_dg_switch";
	public $table_class = "gengkuai_dg_classification";
	public $table_fatherClass = "gengkuai_dg_fatherclass";
	public $table_config = "gengkuai_dg_config";

	function __construct()
	{
		global $_W, $_GPC;
		$this->_weid = $_W["uniacid"];
		$this->_fromuser = $_W["fans"]["from_user"];
		if ($_SERVER['HTTP_HOST'] == '127.0.0.1' || $_SERVER['HTTP_HOST'] == 'localhost:888') {
			$this->_fromuser = "debug";
		}
		$this->_auth2_openid = "auth2_openid_" . $_W["uniacid"];
		$this->_auth2_nickname = "auth2_nickname_" . $_W["uniacid"];
		$this->_auth2_headimgurl = "auth2_headimgurl_" . $_W["uniacid"];
		$this->_auth2_sex = "auth2_sex_" . $_W["uniacid"];
		$this->_auth2_code = "auth2_code_" . $_W["uniacid"];
		$this->_appid = '';
		$this->_appsecret = '';
		$this->_accountlevel = $_W["account"]["level"];
		if (isset($_COOKIE[$this->_auth2_openid])) {
			$this->_fromuser = $_COOKIE[$this->_auth2_openid];
		}
		if ($this->_accountlevel < 4) {
			$setting = uni_setting($this->_weid);
			$oauth = $setting['oauth'];
			if (!empty($oauth) && !empty($oauth['account'])) {
				$this->_account = account_fetch($oauth["account"]);
				$this->_appid = $this->_account["key"];
				$this->_appsecret = $this->_account["secret"];
			}
		} else {
			$this->_appid = $_W["account"]["key"];
			$this->_appsecret = $_W["account"]["secret"];
		}
	}
 

	// public function doWebSetup()
	// {
	// 	global $_w, $_GPC;
	// 	load()->func('tpl');
	// 	load()->web('template');
	// 	include $this->template("BackStage/setup");
	// }


	/*setup*/
	public function doWebSetup()
	{
		global $_W, $_GPC;
		// load()->func('tpl');
		
		$weid = $this->_weid;
		$setting = pdo_get($this->table_reply, array("key" => "setting", "weid" => $weid));
		if (!empty($setting['value'])) {
			$setting = iunserializer($setting['value']);
		}
		if ($_W['ispost']) {
           $uni_setting['help'] = safe_gpc_string($_GPC['help']);
           $uni_setting['dzz'] = safe_gpc_string($_GPC['dzz']);
           $uni_setting['vod'] = safe_gpc_string($_GPC['vod']);
           $uni_setting['supergape'] = safe_gpc_string($_GPC['supergape']);
          
          $uni_setting['super'] = safe_gpc_string($_GPC['super']);
			$uni_setting['supera'] = safe_gpc_string($_GPC['supera']);
			$uni_setting['superb'] = safe_gpc_string($_GPC['superb']);
			$uni_setting['superc'] = safe_gpc_string($_GPC['superc']);
			$uni_setting['about'] = safe_gpc_string($_GPC['about']);
			$uni_setting['team'] = safe_gpc_string($_GPC['team']);
          $uni_setting['banquan'] = safe_gpc_string($_GPC['banquan']);
          $uni_setting['lxfs'] = safe_gpc_string($_GPC['lxfs']);
			$uni_setting['lueluelue'] = safe_gpc_string($_GPC['lueluelue']);
			$uni_setting['loginz'] = safe_gpc_string($_GPC['loginz']);
          
			$uni_setting['qq'] = safe_gpc_string($_GPC['qq']);
          $uni_setting['login'] = safe_gpc_string($_GPC['login']);
       		$uni_setting['icon'] = safe_gpc_string($_GPC['icon']);
			$uni_setting['name'] = safe_gpc_string($_GPC['name']);
			$uni_setting['tel'] = safe_gpc_string($_GPC['tel']);
			$uni_setting['address'] = safe_gpc_string($_GPC['address']);
			$uni_setting['slides'] = safe_gpc_string($_GPC['slides']);
			$uni_setting['contact'] = safe_gpc_string($_GPC['contact']);
			$uni_setting['history'] = safe_gpc_string($_GPC['history']);
			$uni_setting['job'] = safe_gpc_string($_GPC['job']);
			$uni_setting['copyright'] = safe_gpc_string($_GPC['copyright']);
			$uni_setting['flogo'] = safe_gpc_string($_GPC['flogo']);
			$uni_setting['keywords'] = safe_gpc_string($_GPC['keywords']);
			$uni_setting['description'] = safe_gpc_string($_GPC['description']);
			$uni_setting['title'] = safe_gpc_string($_GPC['title']);
			$uni_setting['code'] = safe_gpc_string($_GPC['code']);
     	    $uni_setting['gg'] = safe_gpc_string($_GPC['gg']);
          	$uni_setting['wx'] = safe_gpc_string($_GPC['wx']);
			$uni_setting = iserializer($uni_setting);
			if (!empty($setting)) {
				pdo_update($this->table_reply, array("value" => $uni_setting), array("key" => "setting", "weid" => $weid));
			} else {
				pdo_insert($this->table_reply, array("key" => "setting", "value" => $uni_setting, "weid" => $weid));
			}
			message('设置成功！', $this->createWebUrl("setup"), "success");
		}
		include $this->template("WQBackStage/setup");
	}
  

	public function doWebNews()
	{
		global $_GPC, $_W;
		load()->func("tpl");
		$weid = $this->_weid;
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$url = $this->createWebUrl("news", array("op" => "display"));
		if ($operation == 'display') {
			$status = intval($_GPC['status']);
			$strwhere = '';
			$pindex = max(1, intval($_GPC['page']));
			$psize = 12;
			$start = ($pindex - 1) * $psize;
			$limit = '';
			$limit .= " LIMIT {$start},{$psize}";
			$list = pdo_fetchall('SELECT * FROM ' . tablename($this->table_news) . " WHERE weid = :weid {$strwhere} ORDER BY id DESC " . $limit, array(':weid' => $weid));
			$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename($this->table_news) . " WHERE weid = :weid {$strwhere} ", array(':weid' => $weid));
			$pager = pagination($total, $pindex, $psize);
		} else {
			if ($operation == 'add') {
				$id = intval($_GPC['id']);
				$item = pdo_fetch('SELECT * FROM ' . tablename($this->table_news) . " WHERE id = :id", array(":id" => $id));
				$class = pdo_fetchall('SELECT * FROM ' . tablename($this->table_class) . " WHERE fatherClass = '新闻'");
				if (checksubmit()) {
					$data = array('weid' => $weid, 'cid' => trim($_GPC['cid']), 'pid' => trim($_GPC['pid']), 'pic' => trim($_GPC['pic']), 'name' => trim($_GPC['name']), 'pv' => trim($_GPC['pv']), 'info' => trim($_GPC['info']), 'iscom' => trim($_GPC['iscom']), 'ishot' => trim($_GPC['ishot']), 'content' => trim($_GPC['content']), 'status' => floatval($_GPC['status']), 'dateline' => TIMESTAMP);
					if (!empty($_GPC['pic'])) {
						$data['pic'] = $_GPC['pic'];
					}
					if (empty($item)) {
						pdo_insert($this->table_news, $data);
					} else {
						unset($data['dateline']);
						pdo_update($this->table_news, $data, array("id" => $id, "weid" => $weid));
					}
					message('操作成功！', $url, 'success');
				}
			} else {
				if ($operation == 'delete') {
					$id = intval($_GPC['id']);
					$item = pdo_fetch('SELECT id FROM ' . tablename($this->table_news) . " WHERE id = :id AND weid=:weid", array(":id" => $id, ":weid" => $weid));
					if (empty($item)) {
						message('抱歉，不存在或是已经被删除！', $url, 'error');
					}
					pdo_delete($this->table_news, array("id" => $id, "weid" => $weid));
					message('删除成功！', $url, 'success');
				}
			}
		}
		include $this->template("WQBackStage/news");
	}

	//案例管理
   	public function doWebGoods()
	{
		global $_GPC, $_W;
		load()->func("tpl");
		$weid = $this->_weid;
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$url = $this->createWebUrl("goods", array("op" => "display"));

		if ($operation == 'display') {
			$status = intval($_GPC['status']);
			$strwhere = '';
			$pindex = max(1, intval($_GPC['page']));
			$psize = 12;
			$start = ($pindex - 1) * $psize;
			$limit = '';
			$limit .= " LIMIT {$start},{$psize}";
			$list = pdo_fetchall('SELECT * FROM ' . tablename($this->table_goods) . " WHERE weid = :weid {$strwhere} ORDER BY id DESC " . $limit, array(':weid' => $weid));
			$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename($this->table_goods) . " WHERE weid = :weid {$strwhere} ", array(':weid' => $weid));
			$pager = pagination($total, $pindex, $psize);
		} else {
			if ($operation == 'add') {
				$id = intval($_GPC['id']);
				$goodspic = serialize($_GPC['goodspic']);
				$item = pdo_fetch('SELECT * FROM ' . tablename($this->table_goods) . " WHERE id = :id", array(":id" => $id));
				$class = pdo_fetchall('SELECT * FROM ' . tablename($this->table_class) . " WHERE fatherClass = '产品'");
				// echo var_dump($goodspic);
				if (checksubmit()) {
					$data = array('weid' => $weid, 'cid' => trim($_GPC['cid']), 'pid' => trim($_GPC['pid']), 'pic' => trim($_GPC['pic']), 'cj' => trim($_GPC['cj']), 'dp' => trim($_GPC['dp']), 'goodspic' => $goodspic, 'info' => trim($_GPC['info']), 'name' => trim($_GPC['name']), 'pv' => trim($_GPC['pv']), 'iscom' => trim($_GPC['iscom']), 'ishot' => trim($_GPC['ishot']), 'content' => trim($_GPC['content']), 'status' => floatval($_GPC['status']), 'color' => trim($_GPC['color']), 'dateline' => TIMESTAMP);
					if (!empty($_GPC['pic'])) {
						$data['pic'] = $_GPC['pic'];
					}
					if (empty($item)) {
						pdo_insert($this->table_goods, $data);
					} else {
						unset($data['dateline']);
						pdo_update($this->table_goods, $data, array("id" => $id, "weid" => $weid));
					}
					message('操作成功！', $url, 'success');
				}
			} else {
				if ($operation == 'delete') {
					$id = intval($_GPC['id']);
					$item = pdo_fetch('SELECT id FROM ' . tablename($this->table_goods) . " WHERE id = :id AND weid=:weid", array(":id" => $id, ":weid" => $weid));
					if (empty($item)) {
						message('抱歉，不存在或是已经被删除！', $url, 'error');
					}
					pdo_delete($this->table_goods, array("id" => $id, "weid" => $weid));
					message('删除成功！', $url, 'success');
				}
			}
		}
		include $this->template("WQBackStage/goods");
	}

	/*链接*/
	public function doWebLink()
	{
		global $_GPC, $_W;
		load()->func("tpl");
		$weid = $this->_weid;
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$url = $this->createWebUrl("link", array("op" => "display"));
		if ($operation == 'display') {
			$status = intval($_GPC['status']);
			$strwhere = '';
			$pindex = max(1, intval($_GPC['page']));
			$psize = 12;
			$start = ($pindex - 1) * $psize;
			$limit = '';
			$limit .= " LIMIT {$start},{$psize}";
			$list = pdo_fetchall('SELECT * FROM ' . tablename($this->table_link) . " WHERE weid = :weid {$strwhere} ORDER BY id DESC " . $limit, array(':weid' => $weid));
			$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename($this->table_link) . " WHERE weid = :weid {$strwhere} ", array(':weid' => $weid));
			$pager = pagination($total, $pindex, $psize);
		} else {
			if ($operation == 'add') {
				$id = intval($_GPC['id']);
				$item = pdo_fetch('SELECT * FROM ' . tablename($this->table_link) . " WHERE id = :id", array(":id" => $id));
				if (checksubmit()) {
					$data = array('weid' => $weid, 'cid' => trim($_GPC['cid']), 'pic' => trim($_GPC['pic']), 'name' => trim($_GPC['name']), 'url' => trim($_GPC['url']), 'content' => trim($_GPC['content']), 'status' => floatval($_GPC['status']), 'dateline' => TIMESTAMP, 'sort'=>intval($_GPC['sort']));
					if (!empty($_GPC['pic'])) {
						$data['pic'] = $_GPC['pic'];
					}
					if (empty($item)) {
						pdo_insert($this->table_link, $data);
					} else {
						unset($data['dateline']);
						pdo_update($this->table_link, $data, array("id" => $id, "weid" => $weid));
					}
					message('操作成功！', $url, 'success');
				}
			} else {
				if ($operation == 'delete') {
					$id = intval($_GPC['id']);
					$item = pdo_fetch('SELECT id FROM ' . tablename($this->table_link) . " WHERE id = :id AND weid=:weid", array(":id" => $id, ":weid" => $weid));
					if (empty($item)) {
						message('抱歉，不存在或是已经被删除！', $url, 'error');
					}
					pdo_delete($this->table_link, array("id" => $id, "weid" => $weid));
					message('删除成功！', $url, 'success');
				}
			}
		}
		include $this->template("WQBackStage/link");
	}

	/*案例管理*/
	public function doWebCase()
	{
		global $_GPC, $_W;
		load()->func("tpl");
		$weid = $this->_weid;
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$url = $this->createWebUrl("case", array("op" => "display"));
		if ($operation == 'display') {
			$status = intval($_GPC['status']);
			$strwhere = '';
			$pindex = max(1, intval($_GPC['page']));
			$psize = 12;
			$start = ($pindex - 1) * $psize;
			$limit = '';
			$limit .= " LIMIT {$start},{$psize}";
			$list = pdo_fetchall('SELECT * FROM ' . tablename($this->table_case) . " WHERE weid = :weid {$strwhere} ORDER BY id DESC " . $limit, array(':weid' => $weid));
			$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename($this->table_case) . " WHERE weid = :weid {$strwhere} ", array(':weid' => $weid));
			$pager = pagination($total, $pindex, $psize);
		} else {
			if ($operation == 'add') {
				$id = intval($_GPC['id']);
				$item = pdo_fetch('SELECT * FROM ' . tablename($this->table_case) . " WHERE id = :id", array(":id" => $id));
				$class = pdo_fetchall('SELECT * FROM ' . tablename($this->table_class) . " WHERE fatherClass = '案例'");
				if (checksubmit()) {
					$data = array('weid' => $weid, 'cid' => trim($_GPC['cid']),  'pid' => trim($_GPC['pid']),'pic' => trim($_GPC['pic']), 'name' => trim($_GPC['name']), 'url' => trim($_GPC['url']), 'info' => trim($_GPC['info']), 'iscom' => trim($_GPC['iscom']), 'ishot' => trim($_GPC['ishot']), 'content' => trim($_GPC['content']), 'status' => floatval($_GPC['status']), 'dateline' => TIMESTAMP, 'detail' => trim($_GPC['detail']));
					if (!empty($_GPC['pic'])) {
						$data['pic'] = $_GPC['pic'];
					}
					if (empty($item)) {
						pdo_insert($this->table_case, $data);
					} else {
						unset($data['dateline']);
						pdo_update($this->table_case, $data, array("id" => $id, "weid" => $weid));
					}
					message('操作成功！', $url, 'success');
				}
			} else {
				if ($operation == 'delete') {
					$id = intval($_GPC['id']);
					$item = pdo_fetch('SELECT id FROM ' . tablename($this->table_case) . " WHERE id = :id AND weid=:weid", array(":id" => $id, ":weid" => $weid));
					if (empty($item)) {
						message('抱歉，不存在或是已经被删除！', $url, 'error');
					}
					pdo_delete($this->table_case, array("id" => $id, "weid" => $weid));
					message('删除成功！', $url, 'success');
				}
			}
		}
		include $this->template("WQBackStage/case");
	}

	/*分类管理*/
	public function doWebClassification()
	{
		//全局变量
		global $_GPC, $_W;
		load()->func("tpl");
		$weid = $this->_weid;
		//判断op
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$url = $this->createWebUrl("classification", array("op" => "display"));


		if ($operation == 'display') {
			$status = intval($_GPC['status']);
			$strwhere = '';
			$pindex = max(1, intval($_GPC['page']));
			$psize = 12;
			$start = ($pindex - 1) * $psize;
			$limit = '';
			$limit .= " LIMIT {$start},{$psize}";
			$list = pdo_fetchall('SELECT * FROM ' . tablename($this->table_class));
			$total = pdo_fetchcolumn('SELECT count(1) FROM ' . tablename($this->table_class));
			$pager = pagination($total, $pindex, $psize);
		} elseif ( $operation == 'add') {
			$id = intval($_GPC['id']);
			$fatherClassList = pdo_fetchall('SELECT * FROM ' . tablename($this->table_fatherClass));
			$item = pdo_fetch('SELECT * FROM ' . tablename($this->table_class) . " WHERE id = :id", array(":id" => $id));
			if (checksubmit()) {
				$data = array("classificationName"=>trim($_GPC['classificationName']),"fatherClass"=>trim($_GPC['fatherClass']),"img"=>trim($_GPC['img']));
				if (!empty($_GPC['pic'])) {
					$data['pic'] = $_GPC['pic'];
				}
				if (empty($item)) {
					pdo_insert($this->table_class, $data);
				} else {
					unset($data['dateline']);
					pdo_update($this->table_class, $data, array("id" => $id));
				}
				message('操作成功！', $url, 'success');
			}
		} elseif ( $operation == 'delete' ) {
			$id = intval($_GPC['id']);
			$item = pdo_fetch('SELECT id FROM ' . tablename($this->table_class));
			if (empty($item)) {
				message('抱歉，不存在或是已经被删除！', $url, 'error');
			}
			pdo_delete($this->table_class, array("id" => $id));
			message('删除成功！', $url, 'success');
		} else {
			message('操作允许！', $url, 'error');
		}

		include $this->template("WQBackStage/classification");
	}


	/*选择前台模板*/
	public function doWebtemplate()
	{
		global $_GPC, $_W;
		load()->func("tpl");
		$weid = $this->_weid;
		//判断op
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$url = $this->createWebUrl("template", array("op" => "display"));
		if ( $operation == 'display' ) {
			$dir = "../addons/gengkuai_dg/template/";
			$config_template = pdo_get($this->table_config, array("key" => "template_name"), array("value"));
			$file_handle = opendir($dir);
			$file = array();
			array_push($file,array("name" => "原始模板", "img" => "/addons/gengkuai_dg/preview.jpg", "status" => 0, 'add' => 'webapp'));
			if ($config_template['value'] == 'webapp') {
				$file[0]['status'] = 1;
			}
			while ($fileName = readdir($file_handle)) {
				//array_push($file, $dir);
				if (strstr($fileName, "webapp_")) {
					$info['name'] = str_replace('webapp_', '', $fileName);
					$info['img'] = '/addons/'.$fileName.'/preview.jpg';
					$info['add'] = $fileName;
					if ( $config_template['value'] == $fileName ) {
						$info['status'] = 1;
					}else{
						$info['status'] = 1;
					}
					array_push($file,$info);
				}
			}
		} elseif ( $operation == 'changetpl') {
			$add = intval($_GPC['key']);
			pdo_update($this->table_config, array("value" => $_GPC['key']), array("key" => 'template_name'));
			message('使用'.$add['name'].'模板', $url, 'success');
		}

		include $this->template("WQBackStage/template");
	}
	public function doWebtemplate_bak()
	{
		global $_GPC, $_W;
		load()->func("tpl");
		$weid = $this->_weid;
		//判断op
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$url = $this->createWebUrl("template", array("op" => "display"));
		if ( $operation == 'display' ) {
			$dir = "../addons";
			$config_template = pdo_get($this->table_config, array("key" => "template_name"), array("value"));
			$file_handle = opendir($dir);
			$file = array();
			array_push($file,array("name" => "原始模板", "img" => "/addons/gengkuai_dg/preview.jpg", "status" => 0, 'add' => 'gengkuai_dg'));
			if ($config_template['value'] == 'gengkuai_dg') {
				$file[0]['status'] = 1;
			}
			while ($fileName = readdir($file_handle)) {
				//array_push($file, $dir);
				if (strstr($fileName, "gengkuai_web")) {
					$info['name'] = str_replace('gengkuai_web', '', $fileName);
					$info['img'] = '/addons/'.$fileName.'/preview.jpg';
					$info['add'] = $fileName;
					if ( $config_template['value'] == $fileName ) {
						$info['status'] = 1;
					}else{
						$info['status'] = 1;
					}
					array_push($file,$info);
				}
			}
		} elseif ( $operation == 'changetpl') {
			$add = intval($_GPC['key']);
			pdo_update($this->table_config, array("value" => $_GPC['key']), array("key" => 'template_name'));
			message('使用'.$add['name'].'模板', $url, 'success');
		}

		include $this->template("WQBackStage/template");
	}

	/*伪静态配置*/
	public function doWebhtaccess()
	{
		global $_GPC,$_W;

		$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

		if($op == 'display'){
			$ht_dir = IA_ROOT.'/.htaccess';
			$platform = '';
			$domain = '';
			$port = '';
			$server_version = explode(" ",$_SERVER['SERVER_SOFTWARE']);
			$server_version = $server_version[0];
			$php_version = PHP_VERSION;
		}
		include $this->template("WQBackStage/htaccess_set");
	}
}