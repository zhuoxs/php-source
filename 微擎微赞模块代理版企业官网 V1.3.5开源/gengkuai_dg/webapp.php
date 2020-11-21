<?php
defined("IN_IA") or die("Access Denied");
define("PATH", "../addons/gengkuai_dg/template/");

class gengkuai_dgModuleWebapp extends WeModuleWebapp
{
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
	public $table_url_setting = "gengkuai_dg_url_setting";

	//public $config = pdo_get($this->table_config, array("key" => "template_name"), array("value"));
	//
	function __construct()
	{
		global $_W;
		$_W['siteurl'];
		$url_list = pdo_getall($this->table_url_setting);
		foreach ($url_list as $key => $value) {
			if ('http://'.$value['a'].'/' == $_W['siteroot'] || 'https://'.$value['a'].'/' == $_W['siteroot']) {
				$_W['uniacid'] = intval($value['b']);
				break;
			}
		}
	}

	public function doPageIndex()
	{
		global $_W;

		/*产品部分*/
		$goodsClass = pdo_getall($this->table_class, array('fatherClass' => "产品"));
		//$item = pdo_getall($this->table_class, array("" => $))
		$all_class_goods_12 = pdo_getslice($this->table_goods, array("weid" => $_W["uniacid"]), array(1, 12), $total, array(), '', "pid asc");
		$all_goodsClass = array();
		if (is_array($goodsClass)) {
			foreach ($goodsClass as $key => $value) {
				$data =  pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => (int)$value['id']), '', "pid asc", array(1, 20));
				if (!empty($data)) {
					$all_goodsClass = array_merge($all_goodsClass, $data);
				}
			}
		}
		//var_dump($all_class_goods_12);die;

		/*新闻部分*/
		$newsClass = pdo_getall($this->table_class, array('fatherClass' => "新闻"));
		$all_class_news_12 = pdo_getslice($this->table_news, array("weid" => $_W["uniacid"]), array(1, 6), $total, array(), '', "pid asc");
		$all_newsClass = array();
		if(is_array($newsClass))
		{
			foreach ($newsClass as $key => $value) {
				$data =  pdo_getall($this->table_news, array("weid" => $_W["uniacid"], "cid" => (int)$value['id']), '', "pid asc", array(1, 6));
				if (!empty($data)) {
					$all_newsClass = array_merge($all_newsClass, $data);
				}
			}
		}
		// echo "<script>alert('".json_encode($goodsClass)."')</script>";
		// echo "<script>alert('".json_encode($all_goodsClass)."')</script>";


		/*案例部分*/
		$caselists = pdo_getall($this->table_case, array("weid" => $_W["uniacid"]), '', "pid asc", array(1, 8));
		// /echo "<script>alert('".json_encode($caselists)."')</script>";

     	$lists = pdo_getslice($this->table_goods, array("weid" => $_W["uniacid"]), array(1, 12), $total, array(), '', "pid asc");
        // $goodspage1 = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 1), '', "pid asc", array(1, 20));
   	    // $goodspage2 = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 2), '', "pid asc", array(1, 20));
        // $goodspage3 = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 3), '', "pid asc", array(1, 20));
        // $goodspage4 = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 4), '', "pid asc", array(1, 20));
        // $goodspage5 = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 5), '', "pid asc", array(1, 20));
        // $goodspage6 = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 6), '', "pid asc", array(1, 20));
        // $goodspage7 = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 7), '', "pid asc", array(1, 20));
        // $goodspage8 = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 8), '', "pid asc", array(1, 20));
        // $goodspage9 = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 9), '', "pid asc", array(1, 20));
        // $goodspage10 = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 10), '', "pid asc", array(1, 20));
        // $newspage1 = pdo_getall($this->table_news, array("weid" => $_W["uniacid"], "cid" => 1), '', "pid asc", array(1, 20));
   	    // $newspage2 = pdo_getall($this->table_news, array("weid" => $_W["uniacid"], "cid" => 2), '', "pid asc", array(1, 20));
        // $newspage3 = pdo_getall($this->table_news, array("weid" => $_W["uniacid"], "cid" => 3), '', "pid asc", array(1, 20));
        // $newspage4 = pdo_getall($this->table_news, array("weid" => $_W["uniacid"], "cid" => 4), '', "pid asc", array(1, 20));
        // $newspage5 = pdo_getall($this->table_news, array("weid" => $_W["uniacid"], "cid" => 5), '', "pid asc", array(1, 20));
        // $newspage6 = pdo_getall($this->table_news, array("weid" => $_W["uniacid"], "cid" => 6), '', "pid asc", array(1, 20));
        // $newspage7 = pdo_getall($this->table_news, array("weid" => $_W["uniacid"], "cid" => 7), '', "pid asc", array(1, 20));
        // $newspage8 = pdo_getall($this->table_news, array("weid" => $_W["uniacid"], "cid" => 8), '', "pid asc", array(1, 20));
        // $newspage9 = pdo_getall($this->table_news, array("weid" => $_W["uniacid"], "cid" => 9), '', "pid asc", array(1, 20));
        // $newspage10 = pdo_getall($this->table_news, array("weid" => $_W["uniacid"], "cid" => 10), '', "pid asc", array(1, 20));
		$newsiscom = pdo_getall($this->table_news, array("weid" => $_W["uniacid"], "iscom" => 1), '', "pid asc", array(1, 20));
		$newsishot = pdo_getall($this->table_news, array("weid" => $_W["uniacid"], "ishot" => 1), '', "pid asc", array(1, 20));
     	
     	$menulist = pdo_fetchall('select * from '.tablename($this->table_link).' where weid='.$_W["uniacid"].' and cid = 1 order by sort asc');

		$linklist = pdo_getall($this->table_link, array("weid" => $_W["uniacid"], "cid" => 2), '', "pid asc", array(1, 100));
     	$gjlist = pdo_getall($this->table_link, array("weid" => $_W["uniacid"], "cid" => 3), '', "pid asc", array(1, 100));
		$setting = $this->getWebSetting();
		$config = pdo_get($this->table_config, array("key" => "template_name"), array("value"));
		$template = "../../../gengkuai_dg/template/".$config['value'].'/';
		define("PATHTMP", "../addons/gengkuai_dg/template/".$config['value']);
		include $this->template($template."index");
	}
	public function doPageAbout()
	{
		global $_GPC, $_W;
		$setting = $this->getWebSetting();
		$setting['title'] = '公司简介-'.$setting['title'];

		/*header中的goods部分*/
		$goodsClass = pdo_getall($this->table_class, array('fatherClass' => "产品"));
		//$item = pdo_getall($this->table_class, array("" => $))
		$all_class_goods_12 = pdo_getslice($this->table_goods, array("weid" => $_W["uniacid"]), array(1, 12), $total, array(), '', "pid asc");
		$all_goodsClass = array();
		if (is_array($goodsClass)) {
			foreach ($goodsClass as $key => $value) {
				$data =  pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => (int)$value['id']), '', "pid asc", array(1, 20));
				if (!empty($data)) {
					$all_goodsClass = array_merge($all_goodsClass, $data);
				}
			}
		}
		
		$menulist = pdo_fetchall('select * from '.tablename($this->table_link).' where weid='.$_W["uniacid"].' and cid = 1 order by sort asc');
		$config = pdo_get($this->table_config, array("key" => "template_name"), array("value"));
		$template = "../../../gengkuai_dg/template/".$config['value'].'/';
		define("PATHTMP", "../addons/gengkuai_dg/template/".$config['value']);
		include $this->template($template."about");
	}
	/*超级页面*/
 //  	public function doPageSuper()
	// {
	// 	global $_GPC, $_W;
	// 	$setting = $this->getWebSetting();
	// 	$setting['title'] = '-'.$setting['title'];
	// 	$config = pdo_get($this->table_config, array("key" => "template_name"), array("value"));
	// 	$template = "../../../".$config['value']."/template/webapp/";
	// 	include $this->template($template."super");
	// }
    public function doPageJob()
	{
		global $_GPC, $_W;
		$setting = $this->getWebSetting();
		$setting['title'] = '诚聘英才-'.$setting['title'];

		/*header中的goods部分*/
		$goodsClass = pdo_getall($this->table_class, array('fatherClass' => "产品"));
		//$item = pdo_getall($this->table_class, array("" => $))
		$all_class_goods_12 = pdo_getslice($this->table_goods, array("weid" => $_W["uniacid"]), array(1, 12), $total, array(), '', "pid asc");
		$all_goodsClass = array();
		if (is_array($goodsClass)) {
			foreach ($goodsClass as $key => $value) {
				$data =  pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => (int)$value['id']), '', "pid asc", array(1, 20));
				if (!empty($data)) {
					$all_goodsClass = array_merge($all_goodsClass, $data);
				}
			}
		}
		/*动态链接部分*/
		
		$menulist = pdo_fetchall('select * from '.tablename($this->table_link).' where weid='.$_W["uniacid"].' and cid = 1 order by sort asc');
		$config = pdo_get($this->table_config, array("key" => "template_name"), array("value"));
		$template = "../../../gengkuai_dg/template/".$config['value'].'/';
		define("PATHTMP", "../addons/gengkuai_dg/template/".$config['value']);
		include $this->template($template."job");
	}
	public function doPageNews()
	{
		global $_GPC, $_W;

		/*产品部分*/
		$goodsClass = pdo_getall($this->table_class, array('fatherClass' => "产品"));
		//$item = pdo_getall($this->table_class, array("" => $))
		$all_class_goods_12 = pdo_getslice($this->table_goods, array("weid" => $_W["uniacid"]), array(1, 12), $total, array(), '', "pid asc");
		$all_goodsClass = array();
		if (is_array($goodsClass)) {
			foreach ($goodsClass as $key => $value) {
				$data =  pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => (int)$value['id']), '', "pid asc", array(1, 20));
				if (!empty($data)) {
					$all_goodsClass = array_merge($all_goodsClass, $data);
				}
			}
		}

		/*新闻部分*/
		$newsClass = pdo_getall($this->table_class, array('fatherClass' => "新闻"));
		$all_class_news_12 = pdo_getslice($this->table_news, array("weid" => $_W["uniacid"]), array(1, 12), $total, array(), '', "pid asc");
		$all_newsClass = array();
		if(is_array($newsClass))
		{
			foreach ($newsClass as $key => $value) {
				$data =  pdo_getall($this->table_news, array("weid" => $_W["uniacid"], "cid" => (int)$value['id']), '', "pid asc", array(1, 20));
				if (!empty($data)) {
					$all_newsClass = array_merge($all_newsClass, $data);
				}
			}
		}

		$pindex = max(1, intval($_GPC["page"]));
		$cid = $_GPC["cid"];
		$psize = 8;
     	
     	$menulist = pdo_fetchall('select * from '.tablename($this->table_link).' where weid='.$_W["uniacid"].' and cid = 1 order by sort asc');
        $goodspage = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 1), '', "pid asc", array(1, 20));
        if (!empty($_GPC["cid"])) {
        	$lists = pdo_getslice($this->table_news, array("weid" => $_W["uniacid"], 'cid' => $_GPC["cid"]), array($pindex, $psize), $total, array(), '', "pid asc");
        }else{
			$lists = pdo_getslice($this->table_news, array("weid" => $_W["uniacid"]), array($pindex, $psize), $total, array(), '', "pid asc");
		}
		$newspv = pdo_getall($this->table_news, array("weid" => $_W["uniacid"]), '', "pv desc", array(1, 8));

		$pager = pagination($total, $pindex, $psize);
		$setting = $this->getWebSetting();
		$linklist = pdo_getall($this->table_link, array("weid" => $_W["uniacid"]), '', "pid asc", array(1, 100));
		$config = pdo_get($this->table_config, array("key" => "template_name"), array("value"));
		$template = "../../../gengkuai_dg/template/".$config['value'].'/';
		define("PATHTMP", "../addons/gengkuai_dg/template/".$config['value']);
		include $this->template($template."news");
	}
  	public function doPageNewsDetail()
	{
		global $_GPC, $_W;

		/*产品部分*/
		$goodsClass = pdo_getall($this->table_class, array('fatherClass' => "产品"));
		//$item = pdo_getall($this->table_class, array("" => $))
		$all_class_goods_12 = pdo_getslice($this->table_goods, array("weid" => $_W["uniacid"]), array(1, 12), $total, array(), '', "pid asc");
		$all_goodsClass = array();
		if (is_array($goodsClass)) {
			foreach ($goodsClass as $key => $value) {
				$data =  pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => (int)$value['id']), '', "pid asc", array(1, 20));
				if (!empty($data)) {
					$all_goodsClass = array_merge($all_goodsClass, $data);
				}
			}
		}
		
		$id = $_GPC["id"];
		$setting = $this->getWebSetting();
        
        $menulist = pdo_fetchall('select * from '.tablename($this->table_link).' where weid='.$_W["uniacid"].' and cid = 1 order by sort asc');
        $goodspage = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 1), '', "pid asc", array(1, 20));
		$newspv = pdo_getall($this->table_news, array("weid" => $_W["uniacid"]), '', "pv desc", array(1, 20));
		$item = pdo_get($this->table_news, array("id" => $id));
		if (empty($item)) {
			message("抱歉，文章不存在");
		}
		pdo_update($this->table_news, array("pv" => $item["pv"] + 1), array("id" => $item["id"]));
		$linklist = pdo_getall($this->table_link, array("weid" => $_W["uniacid"]), '', "pid asc", array(1, 100));
		$config = pdo_get($this->table_config, array("key" => "template_name"), array("value"));
		$template = "../../../gengkuai_dg/template/".$config['value'].'/';
		define("PATHTMP", "../addons/gengkuai_dg/template/".$config['value']);
		include $this->template($template."detail");
	}
    public function doPageGoods()
	{
		global $_GPC, $_W;
		$pindex = max(1, intval($_GPC["page"]));
		$psize = 20;

		/*header中的goods部分*/
		$goodsClass = pdo_getall($this->table_class, array('fatherClass' => "产品"));
		//$item = pdo_getall($this->table_class, array("" => $))
		$all_class_goods_12 = pdo_getslice($this->table_goods, array("weid" => $_W["uniacid"]), array(1, 12), $total, array(), '', "pid asc");
		$all_goodsClass = array();
		if (is_array($goodsClass)) {
			foreach ($goodsClass as $key => $value) {
				$data =  pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => (int)$value['id']), '', "pid asc", array(1, 20));
				if (!empty($data)) {
					$all_goodsClass = array_merge($all_goodsClass, $data);
				}
			}
		}

		/*动态链接部分*/
		
		$menulist = pdo_fetchall('select * from '.tablename($this->table_link).' where weid='.$_W["uniacid"].' and cid = 1 order by sort asc');

        $goodspage1 = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 1), '', "pid asc", array(1, 999));
   	    $goodspage2 = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 2), '', "pid asc", array(1, 290));
        $goodspage3 = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 3), '', "pid asc", array(1, 290));
        $goodspage4 = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 4), '', "pid asc", array(1, 209));
        $goodspage5 = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 5), '', "pid asc", array(1, 209));
        $goodspage6 = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 6), '', "pid asc", array(1, 209));
        $goodspage7 = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 7), '', "pid asc", array(1, 209));
        $goodspage8 = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 8), '', "pid asc", array(1, 209));
        $goodspage9 = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => 9), '', "pid asc", array(1, 209));
		$lists = pdo_getslice($this->table_goods, array("weid" => $_W["uniacid"]), array($pindex, $psize), $total, array(), '', "pid asc");
		$newspv = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"]), '', "pv desc", array(1, 90));
		$pager = pagination($total, $pindex, $psize);
		$setting = $this->getWebSetting();
		$linklist = pdo_getall($this->table_link, array("weid" => $_W["uniacid"]), '', "pid asc", array(1, 100));
      $gjlist = pdo_getall($this->table_link, array("weid" => $_W["uniacid"], "cid" => 3), '', "pid asc", array(1, 100));
		$config = pdo_get($this->table_config, array("key" => "template_name"), array("value"));
		$template = "../../../gengkuai_dg/template/".$config['value'].'/';
		define("PATHTMP", "../addons/gengkuai_dg/template/".$config['value']);
		include $this->template($template."goods");
	}


  	public function doPageGoodsDetail()
	{
		global $_GPC, $_W;
        
        $menulist = pdo_fetchall('select * from '.tablename($this->table_link).' where weid='.$_W["uniacid"].' and cid = 1 order by sort asc');
		$id = $_GPC["id"];
		$setting = $this->getWebSetting();
		$newspv = pdo_getall($this->table_goods, array("weid" => $_W["uniacid"]), '', "pv desc", array(1, 20));
		$item = pdo_get($this->table_goods, array("id" => $id));
		if (empty($item)) {
			message("抱歉，产品不存在");
		}
		pdo_update($this->table_news, array("pv" => $item["pv"] + 1), array("id" => $item["id"]));
		$linklist = pdo_getall($this->table_link, array("weid" => $_W["uniacid"]), '', "pid asc", array(1, 100));
    	$gjlist = pdo_getall($this->table_link, array("weid" => $_W["uniacid"], "cid" => 3), '', "pid asc", array(1, 100));

		/*header中的goods部分*/
		$goodsClass = pdo_getall($this->table_class, array('fatherClass' => "产品"));
		//$item = pdo_getall($this->table_class, array("" => $))
		$all_class_goods_12 = pdo_getslice($this->table_goods, array("weid" => $_W["uniacid"]), array(1, 12), $total, array(), '', "pid asc");
		$all_goodsClass = array();
		if (is_array($goodsClass)) {
			foreach ($goodsClass as $key => $value) {
				$data =  pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => (int)$value['id']), '', "pid asc", array(1, 20));
				if (!empty($data)) {
					$all_goodsClass = array_merge($all_goodsClass, $data);
				}
			}
		}
		/*动态链接部分*/
		
		$menulist = pdo_fetchall('select * from '.tablename($this->table_link).' where weid='.$_W["uniacid"].' and cid = 1 order by sort asc');

		/*轮播图*/
		$goodspiclist = unserialize($item['goodspic']);

		$config = pdo_get($this->table_config, array("key" => "template_name"), array("value"));
		$template = "../../../gengkuai_dg/template/".$config['value'].'/';
		define("PATHTMP", "../addons/gengkuai_dg/template/".$config['value']);
		include $this->template($template."detaila");
	}
	public function doPageCase()
	{
		global $_GPC, $_W;
		$id = $_GPC["id"];

		/*header中的goods部分*/
		$goodsClass = pdo_getall($this->table_class, array('fatherClass' => "产品"));
		//$item = pdo_getall($this->table_class, array("" => $))
		$all_class_goods_12 = pdo_getslice($this->table_goods, array("weid" => $_W["uniacid"]), array(1, 12), $total, array(), '', "pid asc");
		$all_goodsClass = array();
		if (is_array($goodsClass)) {
			foreach ($goodsClass as $key => $value) {
				$data =  pdo_getall($this->table_goods, array("weid" => $_W["uniacid"], "cid" => (int)$value['id']), '', "pid asc", array(1, 20));
				if (!empty($data)) {
					$all_goodsClass = array_merge($all_goodsClass, $data);
				}
			}
		}

		/*动态链接部分*/
		
		$menulist = pdo_fetchall('select * from '.tablename($this->table_link).' where weid='.$_W["uniacid"].' and cid = 1 order by sort asc');

		$caseClass = pdo_getall($this->table_class, array('fatherClass' => "案例"));
		//$item = pdo_getall($this->table_class, array("" => $))
		$all_class_case_12 = pdo_getslice($this->table_case, array("weid" => $_W["uniacid"]), array(1, 12), $total, array(), '', "pid asc");
		$all_caseClass = array();
		if (is_array($caseClass)) {
			foreach ($caseClass as $key => $value) {
				$data =  pdo_getall($this->table_case, array("weid" => $_W["uniacid"], "cid" => (int)$value['id']), '', "pid asc", array(1, 20));
				if (!empty($data)) {
					$all_caseClass = array_merge($all_caseClass, $data);
				}
			}
		}


		if (empty($id)) {
			$pindex = max(1, intval($_GPC["page"]));
			$psize = 20;
			$lists = pdo_getslice($this->table_case, array("weid" => $_W["uniacid"]), array($pindex, $psize), $total, array(), '', "pid asc");
			$pager = pagination($total, $pindex, $psize);
		} else {
			$item = pdo_get($this->table_case, array("id" => $id));
			if (empty($item)) {
				message("抱歉，案例不存在");
			}
			pdo_update($this->table_news, array("pv" => $item["pv"] + 1), array("id" => $item["id"]));
		}
		$setting = $this->getWebSetting();
		$linklist = pdo_getall($this->table_link, array("weid" => $_W["uniacid"]), '', "pid asc", array(1, 100));
      $gjlist = pdo_getall($this->table_link, array("weid" => $_W["uniacid"], "cid" => 3), '', "pid asc", array(1, 100));
		$config = pdo_get($this->table_config, array("key" => "template_name"), array("value"));
		$template = "../../../gengkuai_dg/template/".$config['value'].'/';
		define("PATHTMP", "../addons/gengkuai_dg/template/".$config['value']);
		include $this->template($template."case");
	}
	public function getWebSetting()
	{
		global $_W, $_GPC;
		$setting = pdo_get($this->table_reply, array("key" => "setting", "weid" => $_W["uniacid"]));
     
		if (!empty($setting["value"])) {
			$setting = iunserializer($setting["value"]);
		}
		return $setting;
	}
	
}