<?php
/**
 * 行业宝模块微站定义
 *
 * @author wangbosichuang
 * @url 
 */
defined('IN_IA') or exit('Access Denied');
error_reporting(E_ALL || ~E_NOTICE);
class Hyb_ylModuleSite extends WeModuleSite {
	/*
		支付管理
	*/
		public function doWebPay()
		{
            //require_once dirname(__FILE__) .'/inc/AlOss.php';
			global $_GPC, $_W;
			load()->func('tpl');
			$uniacid = $_W['uniacid'];
			$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
			load()->func('file'); //调用上传函数
			$dir_url=$_SERVER['DOCUMENT_ROOT'].'/web/cert/'; //上传路径
			mkdirs($dir_url); 
			//创建目录
			if ($_FILES["upfile"]["name"]){
				$upfile=$_FILES["upfile"]; 
			//获取数组里面的值 
			$name=$upfile["name"];//上传文件的文件名 
			$size=$upfile["size"];//上传文件的大小 
			if($size>2*1024*1024) {  

				message("文件过大，不能上传大于2M的文件!",$this->createWebUrl("pay",array("op"=>"display")),"success"); 
				exit();  
			} 
			if(file_exists($dir_url))@unlink ($dir_url);

			$cfg['upfile']=TIMESTAMP.".pem";
			move_uploaded_file($_FILES["upfile"]["tmp_name"],$dir_url.$upfile["name"]); //移动到目录下
			$upfiles = $dir_url.$name;
			
		}
		if ($_FILES["keypem"]["name"]){
			$upfile=$_FILES["keypem"]; 
			//获取数组里面的值 
			$name=$upfile["name"];//上传文件的文件名 
			//$type=$upfile["type"];//上传文件的类型 
			$size=$upfile["size"];//上传文件的大小 
			if($size>2*1024*1024) {  
				message("文件过大，不能上传大于2M的文件!",$this->createWebUrl("pay",array("op"=>"display")),"success");  
				exit();  
			}  	
			if(file_exists($dir_url))@unlink ($dir_url);
			move_uploaded_file($_FILES["keypem"]["tmp_name"],$dir_url.$upfile["name"]); //移动到目录下
			$keypems = $dir_url.$name;

		}
		if ($op == "display") {

			$item = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_parameter")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
			if (checksubmit("submit")) {
					// $upname = $_FILES["keypem"]["name"];
					// $helper = new AliOss($dir_url,$upname);
	    //             $return = $helper->Alyunos($mp4);

				$data = array(
					"uniacid"=>$uniacid,
					"appid"=>$_GPC['appid'],
					"appsecret"=>$_GPC['appsecret'],
					"mch_id"=>$_GPC['mch_id'],
					"appkey"=>$_GPC['appkey'],
					'upfile'=>$upfiles,
					'keypem'=>$keypems,
					);
				if (empty($item['p_id'])) {
					pdo_insert("hyb_yl_parameter",$data);
					message("添加成功!",$this->createWebUrl("pay",array("op"=>"display")),"success");
				}
				else
				{
					pdo_update("hyb_yl_parameter",$data,array("p_id"=>$item['p_id']));
					message("修改成功!",$this->createWebUrl("pay",array("op"=>"display")),"success");
				}
			}
		}
		include $this->template("pay");
	}


	/*
		基础信息
	*/
		public function doWebBase () {
			global $_GPC, $_W;
			load()->func("tpl");
			$op = $_GPC['op'];

			$ops = array('display', 'post');
			$op = in_array($op, $ops) ? $op : 'display';
			$uniacid = $_W['uniacid'];
			if($op == "display")
			{

				$id = $_GPC['id'];
				$item = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_bace")." where uniacid='{$uniacid}'",array("uniacid"=>$uniacid));
				$item['show_thumb'] = unserialize($item['show_thumb']);
				$item['zx_thumb'] = unserialize($item['zx_thumb']);
				$item['goodslunb'] = unserialize($item['goodslunb']);
				$item['back_zjthumb'] = unserialize($item['back_zjthumb']);
				if (checksubmit('submit')) {

					$data = array(
						"uniacid"=>$uniacid,
						"show_title"=>$_GPC['show_title'],
						"show_thumb"=>serialize($_GPC['show_thumb']),
						"zx_thumb"=>serialize($_GPC['zx_thumb']),
						"yy_thumb"=>$_GPC['yy_thumb'],
						"yy_title"=>$_GPC['yy_title'],
						"yy_content"=>$_GPC['yy_content'],
						"latitude"=>$_GPC['latitude'],
						"longitude"=>$_GPC['longitude'],
						"yy_telphone"=>$_GPC['yy_telphone'],
						"yy_address"=>$_GPC['yy_address'],
						"bq_name"=>$_GPC['bq_name'],
						"bq_thumb"=>$_GPC['bq_thumb'],
						"bq_telphone"=>$_GPC['bq_telphone'],
						"tj_thumb"=>$_GPC['tj_thumb'],
						"tjl_thumb"=>$_GPC['tjl_thumb'],
						"back_thumb" =>$_GPC['back_thumb'],
						"back_zjthumb"=>serialize($_GPC['back_zjthumb']),
						"ztcolor"=>$_GPC['ztcolor'],
						"blkcolor"=>$_GPC['blkcolor'],
						'fwsite'=>$_GPC['fwsite'],
						'tztim'=>$_GPC['tztim'],
						'fwtim'=>$_GPC['fwtim'],
						'pstatus'=>$_GPC['pstatus'],
						'slide'=>serialize($_GPC['slide']),
						'txxz'=>$_GPC['txxz'],
						'zdtx'=>$_GPC['zdtx'],
						'txsx'=>$_GPC['txsx'],
						'zhciheng'=>$_GPC['zhciheng'],
						'goodslunb'=>serialize($_GPC['goodslunb']),
						'zuozdoc_thumb'=>$_GPC['zuozdoc_thumb'],
						'dianm_thumb'=>$_GPC['dianm_thumb'],
						'baidukey'=>$_GPC['baidukey']
						);
					
					if(empty($id)){
						pdo_insert("hyb_yl_bace",$data);
						message("添加成功!",$this->createWebUrl("base",array("op"=>"display")),"success");
					}
					else
					{
						pdo_update("hyb_yl_bace",$data,array("id"=>$item['id'],'uniacid'=>$item['uniacid']));
						message("修改成功!",$this->createWebUrl("base",array("op"=>"display")),"success");
					}
				}
			}		
			include $this -> template('base');
		}

	/*
		导航分类
	*/
		public function doWebDaohang ()
		{
			global $_GPC, $_W;
			load()->func("tpl");
			$op = $_GPC['op'];
			$ops = array('display', 'post',"delete");
			$op = in_array($op, $ops) ? $op : 'display';
			$uniacid = $_W['uniacid'];
			if ($op == "display") {
				$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_daohang")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
			}
			if($op == "post")
			{
				$id = $_GPC['id'];
				$item = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_daohang")." where id=:id and uniacid=:uniacid",array(":id"=>$id,":uniacid"=>$uniacid));
				if(checksubmit("submit"))
				{
					$data = array("uniacid"=>$_W['uniacid'],"name"=>$_GPC['name'],"thumb"=>$_GPC['thumb'],"content_thumb"=>$_GPC['content_thumb'],"content_title"=>$_GPC['content_title'],"content"=>$_GPC['content']);
					if (empty($id)) {
						pdo_insert("hyb_yl_daohang",$data);
						message("添加成功!",$this->createWebUrl("daohang",array("op"=>"display")),"success");
					}
					else
					{
						pdo_update("hyb_yl_daohang",$data,array("id"=>$id));
						message("修改成功!",$this->createWebUrl("daohang",array("op"=>"display")),"success");
					}
				}
			}
			if ($op == "delete") {
				$id = $_GPC['id'];
				pdo_delete("hyb_yl_daohang",array("id"=>$id));
				message("删除成功!",$this->createWebUrl("daohang",array("op"=>"display")),"success");
			}
			include $this->template("daohang");
		}

	/*
		疾病课堂分类
	*/
		public function doWebJbfenl()
		{
			global $_GPC, $_W;
			load()->func("tpl");
			$op = $_GPC['op'];
			$ops = array('display', 'post',"delete");
			$op = in_array($op, $ops) ? $op : 'display';
			$uniacid = $_W['uniacid'];
			if ($op == "display") {
				$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_jfenl")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
			}
			if($op == "post")
			{
				$id = $_GPC['fl_id'];
			//var_dump($id);
				$item = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_jfenl")." where fl_id='{$id}' and uniacid='$uniacid'",array("fl_id"=>$id,"uniacid"=>$uniacid));
				if(checksubmit("submit"))
				{
					$data = array("uniacid"=>$_W['uniacid'],"j_name"=>$_GPC['j_name'],"j_thumb"=>$_GPC['j_thumb']);
					if (empty($id)) {
						pdo_insert("hyb_yl_jfenl",$data);
						message("添加成功!",$this->createWebUrl("jbfenl",array("op"=>"display")),"success");
					}
					else
					{
						pdo_update("hyb_yl_jfenl",$data,array("fl_id"=>$id));
						message("修改成功!",$this->createWebUrl("jbfenl",array("op"=>"display")),"success");
					}
				}
			}
			if ($op == "delete") {
				$id = $_GPC['fl_id'];
				pdo_delete("hyb_yl_jfenl",array("fl_id"=>$id));
				message("删除成功!",$this->createWebUrl("jbfenl",array("op"=>"display")),"success");
			}
			include $this->template("jbfenl");
		}
	/*
		课程管理
	*/
		public function doWebJblist ()
		{
			global $_GPC, $_W;
			load()->func("tpl");
			$op = $_GPC['op'];
			$ops = array('display', 'post',"delete");
			$op = in_array($op, $ops) ? $op : 'display';
			$id = $_GPC['id'];
			$uniacid = $_W['uniacid'];
			if ($op == "display") {
				$total = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename("hyb_yl_schoolroom")."where room_parentid ='{$id}' and uniacid = '{$uniacid}'");

				$pindex = max(1, intval($_GPC['page'])); 
				$pagesize = 10;
				$p = ($pindex-1) * $pagesize; 

				$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_schoolroom")."where room_parentid ='{$id}' and uniacid = '{$uniacid}' order by sord  limit ".$p.",".$pagesize);
				$pager = pagination($total,$pindex,$pagesize);
			}
			if ($op == "post") {
				$id = $_GPC['id'];
				$items =  pdo_fetch("SELECT * FROM ".tablename("hyb_yl_schoolroom")." as zj left join ".tablename("hyb_yl_jfenl")." as k on zj.room_fl=k.fl_id  where zj.id=:id and zj.uniacid=:uniacid",array(":id"=>$id,":uniacid"=>$_W['uniacid']));

				$keshi = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_jfenl")." where uniacid=:uniacid",array(":uniacid"=>$_W['uniacid']));

				if (checksubmit("submit")) {
					if($_GPC['room_money'] == '' || $_GPC['room_money'] == 0){
						$room_type = '0';
					}else{
						$room_type = '1';
					}
					$data = array(
						"uniacid"=>$_W['uniacid'],
						"sroomtitle"=>$_GPC['sroomtitle'],
						"room_money"=>$_GPC['room_money'],
						"room_liulan"=>$_GPC['room_liulan'],
						"room_thumb"=>$_GPC['room_thumb'],
						"room_video"=>$_GPC['room_video'],
						"room_tj" => $_GPC['room_tj'],
						"room_per"=>$_GPC['room_per'],
						"room_fl"=>$_GPC['room_fl'],
						"room_desc" => $_GPC['room_desc'],
						"room_teacher" => $_GPC['room_teacher'],
						"tea_pic" => $_GPC['tea_pic'],
						"tea_desc" =>$_GPC['tea_desc'],
						"room_type"=>$room_type,
						"room_parentid"=>0,
						'iflouc'=>$_GPC['iflouc'],
						'mp3'=>$_GPC['mp3'],
						'al_video'=>$_GPC['al_video'],
						'mp3m'=>$_GPC['mp3m'],
						'ypkg'=>$_GPC['ypkg'],
						'spkg'=>$_GPC['spkg'],
						'kaiguan'=>$_GPC['kaiguan'],
						'ymoney'=>$_GPC['ymoney']
						);
					if (empty($id)) {
						pdo_insert("hyb_yl_schoolroom",$data);
						message("添加成功!",$this->createWebUrl("jblist",array("op"=>"display")),"success");
					}
					else
					{
						pdo_update("hyb_yl_schoolroom",$data,array("id"=>$id));
						message("修改成功!",$this->createWebUrl("jblist",array("op"=>"display")),"success");
					}
				}
			}

			if(checksubmit("paixu")){
				$zid=$_GPC['id'];
				$sord = $_GPC['sord'];
				for($i=0;$i<count($zid);$i++){
					$id = $zid[$i];
					$sid = $sord[$i];
					$data= array(
						'sord'=>$sid
						);
					$update_sql=pdo_update('hyb_yl_schoolroom',$data,array('id'=>$id,'uniacid'=>$uniacid));
				}
				message('排序成功', $this->createWebUrl('jblist',array('op'=>'display')), 'success');
			}
			if ($op == "delete") {
				$id = $_GPC['id'];
				pdo_delete("hyb_yl_schoolroom",array("id"=>$id));
				message("删除成功!",$this->createWebUrl("jblist",array("op"=>"display")),"success");
			}
			include $this->template("jblist");
		}
		/*
		课堂分类列表
		*/
		public function doWebFllists(){
			global $_GPC, $_W;
			load()->func("tpl");
			$pid = $_GPC['id'];
			$op = $_GPC['op'];
			$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
			if ($op == "display") {
				$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_schoolroom")."where uniacid=:uniacid and room_parentid = '{$pid}' order by sord ",array(":uniacid"=>$_W['uniacid']));
			}
			if ($op == "post") {
				$id = $_GPC['id'];
				$items =  pdo_fetch("SELECT * FROM ".tablename("hyb_yl_schoolroom")."  where uniacid=:uniacid and id='{$id}'",array(":uniacid"=>$_W['uniacid']));
				if (checksubmit("submit")) {
					$data = array(
						"uniacid"=>$_W['uniacid'],
						"sroomtitle"=>$_GPC['sroomtitle'],
						"room_video"=>$_GPC['room_video'],
						"room_tj" => $_GPC['room_tj'],
						"room_parentid"=>$id,
						"demo"=>$_GPC['demo'],
						'al_video'=>$_GPC['al_video'],
						'mp3'=>$_GPC['mp3'],
						'mp3m'=>$_GPC['mp3m'],
						'ypkg'=>$_GPC['ypkg'],
						'spkg'=>$_GPC['spkg'],
						'kaiguan'=>$_GPC['kaiguan'],
						);
					$sql = pdo_insert("hyb_yl_schoolroom",$data);
					message("添加成功!",$this->createWebUrl("fllists",array("op"=>"display","id"=>$pid)),"success");
				}

			}
			if(checksubmit("paixu")){
				$zid=$_GPC['id'];
				$sord = $_GPC['sord'];
				for($i=0;$i<count($zid);$i++){
					$id = $zid[$i];
					$sid = $sord[$i];
					$data= array(
						'sord'=>$sid
						);
					$update_sql=pdo_update('hyb_yl_schoolroom',$data,array('id'=>$id,'uniacid'=>$_W['uniacid']));
				}
				message('排序成功', $this->createWebUrl('fllists',array('op'=>'display')), 'success');
			}
			include $this->template("fllists");
		}
//课程编辑
		public function doWebSchoolroombj(){
			global $_GPC,$_W;
			load()->func("tpl");
			$id = $_GPC['id'];
			$url = $_W['attachurl'];
			$itemdata =  pdo_fetch("SELECT * FROM ".tablename("hyb_yl_schoolroom")." where uniacid=:uniacid and id = '{$id}' ",array(":uniacid"=>$_W['uniacid']));
			$pid =  $itemdata['room_parentid'];
			$items =  pdo_fetch("SELECT * FROM ".tablename("hyb_yl_schoolroom")."  where uniacid=:uniacid and id='{$pid}' and room_parentid=0",array(":uniacid"=>$_W['uniacid']));
			if (checksubmit("submit")) {
				$data = array(
					"uniacid"=>$_W['uniacid'],
					"sroomtitle"=>$_GPC['sroomtitle'],
					"room_video"=>$_GPC['room_video'],
					"room_tj" => $_GPC['room_tj'],
					"demo"=>$_GPC['demo'],
					'al_video'=>$_GPC['al_video'],
					'mp3'=>$_GPC['mp3'],
					'mp3m'=>$_GPC['mp3m'],
					'ypkg'=>$_GPC['ypkg'],
					'spkg'=>$_GPC['spkg'],
					'kaiguan'=>$_GPC['kaiguan'],
					);
				$sql = pdo_update("hyb_yl_schoolroom",$data,array('id'=>$id,'uniacid'=>$_W['uniacid']));
					message("修改成功!",$this->createWebUrl("fllists",array("op"=>"display","id"=>$pid)),"success");
			}
			include $this->template("schoolroombj");
		}
	/*
		底部导航设置
	*/
		public function doWebButton()
		{
			global $_GPC, $_W;
			load()->func("tpl");
			$op = $_GPC['op'];

			$ops = array('display', 'post',"delete");
			$op = in_array($op, $ops) ? $op : 'display';
			if ($op == "display") {
				$items = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_button_daohang")." where uniacid=:uniacid",array(":uniacid"=>$_W['uniacid']));
				foreach ($items as &$value) {
					$value['fw_title']=unserialize($value['fw_title']);
					$value['fw_thumb']=unserialize($value['fw_thumb']);
					$value['fw_title2']=unserialize($value['fw_title2']);
					$value['title'] = $value['fw_title']['title'];
					$value['titlecp'] = $value['fw_title']['titlecp'];
					$value['tilt2'] = $value['fw_title2']['title2'];
					$value['tilt2cp'] = $value['fw_title2']['title2cp'];
					$value['title3'] = $value['fw_thumb']['title3'];
					$value['title3cp'] = $value['fw_thumb']['title3cp'];
				}

			}
			if ($op=="post") {
				$id = $_GPC['id'];
				$uniacid = $_W['uniacid'];
				$item = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_button_daohang")." where uniacid=:uniacid and id=:id ",array(":uniacid"=>$_W['uniacid'],":id"=>$id));
				$item['fw_title']=unserialize($item['fw_title']);
				$item['fw_title2']=unserialize($item['fw_title2']);
				$item['fw_thumb']=unserialize($item['fw_thumb']);
				if (checksubmit("submit")) {

					$titl1 =serialize(array(
						'title'=>$_GPC['fw_title'],
						'titlecp'=>$_GPC['fw_titlecp']
						)) ;

					$titl2 =serialize(array(
						'title2'=>$_GPC['fw_title2'],
						'title2cp'=>$_GPC['fw_title2cp']
						)) ;

					$titl3 =serialize(array(
						'title3'=>$_GPC['fw_thumb'],
						'title3cp'=>$_GPC['fw_thumbcp']
						)) ;
					$data = array("uniacid"=>$_W['uniacid'],"fw_title"=>$titl1,"fw_title2"=>$titl2,"fw_thumb"=>$titl3);
					if (empty($id)) {
						pdo_insert("hyb_yl_button_daohang",$data);
						message("添加成功!",$this->createWebUrl("button",array("op"=>"display")),"success");
					}
					else
					{
						pdo_update("hyb_yl_button_daohang",$data,array("id"=>$id));
						message("修改成功!",$this->createWebUrl("button",array("op"=>"display")),"success");
					}
				}
			}

			if ($op=="delete") {
				$id = $_GPC['id'];
				pdo_delete("hyb_yl_button_daohang",array("id"=>$id));
				message("删除成功!",$this->createWebUrl("button",array("op"=>"display")),"success");
			}
			include $this->template("button_daohang");
		}
	//处方管理
		public function doWebCfsite(){
			global $_GPC,$_W;
			$uniacid = $_W['uniacid'];
			load()->func("tpl");
			$keyword = $_GPC['keyword'];
			$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
			if(empty($keyword)){
				$pindex = max(1, intval($_GPC['page']));
				$psize = 10;
				$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_yl_recipe")." as a left join ".tablename("hyb_yl_myinfors")." as b on b.my_id=a.userid LEFT JOIN ".tablename("hyb_yl_zhuanjia")."as c on c.zid=a.docid where a.uniacid = '{$uniacid}'",array(":uniacid"=>$uniacid));
				$pager = pagination($count, $pindex, $psize);
				$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_recipe")." as a left join ".tablename("hyb_yl_myinfors")." as b on b.my_id=a.userid left JOIN ".tablename("hyb_yl_zhuanjia")."as c on c.zid=a.docid where a.uniacid = '{$uniacid}' order by a.cid desc limit ". (($pindex - 1) * $psize) . ',' . $psize);

			}else{
				$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_recipe")." as a left join ".tablename("hyb_yl_myinfors")." as b on b.my_id=a.userid where a.uniacid = '{$uniacid}' and a.orderarr like '%{$keyword}%'");
			}

			if ($op == "delete") {
				$id = $_GPC['cid'];
				$del = pdo_delete("hyb_yl_recipe",array("cid"=>$id));
				message("删除成功!",$this->createWebUrl("cfsite",array("op"=>"display")),"success");
			}
			if($op=='enter'){
				$id = $_GPC['cid'];

				$result = pdo_update('hyb_yl_recipe', array('state' => 1), array('cid' => $id,'uniacid'=>$uniacid));
				if ($result) {
					//短信通知
                    require_once dirname(__FILE__) .'/inc/SignatureHelper.php';
				    $params = array ();
					$docname =$_GPC['docname'];
					$mtname =$_GPC['mtname'];
					$store =$_GPC['store'];
				    
				    //var_dump($docname,$mtname,$store,$phoneNum);exit();
				    $aliduanxin = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_duanxin")."WHERE uniacid = '{$uniacid}' " ,array("uniacid"=>$uniacid)); 
				    $phoneNum = $aliduanxin['tel'];//管理员手机号
				    $accessKeyId = $aliduanxin['key'];
				    $accessKeySecret = $aliduanxin['scret'];
				    $params["PhoneNumbers"] = $phoneNum;
				    $params["SignName"] = $aliduanxin['qianming'];
				    $params["TemplateCode"] = $aliduanxin['cfmb'];
				    $code = rand (1000,9999);
				    $params['TemplateParam'] = Array (
				      "mtname" => $mtname,
				      "docname" => $docname,
				      "store" => $store,
				      "times" => date('Y-m-d H:i:s',time()),
				      "product" => "sms"
				      );
				    if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
				      $params["TemplateParam"] = json_encode($params["TemplateParam"]);
				    }
				    $helper = new SignatureHelper();
				    $content = $helper->request(
				      $accessKeyId,
				      $accessKeySecret,
				      "dysmsapi.aliyuncs.com",
				      array_merge($params, array(
				        "RegionId" => "cn-hangzhou",
				        "Action" => "SendSms",
				        "Version" => "2017-05-25",
				        ))
				      );
					message('确定成功', $this->createWebUrl('cfsite', array('op'=>'display')), 'success');
				} else {
					message('确定失败', '', 'error');
				}
			}
			include $this->template("cfsite");
		}
			public function doWebOrderinfo(){
				global $_GPC,$_W;
				$uniacid = $_W['uniacid'];
				load()->func("tpl");
				$op = $_GPC['op'];
			    $cid = $_GPC['cid'];
			    $useropenid = $_GPC['useropenid'];
				if($op =='display'){
                   $res = pdo_fetch('SELECT * FROM'.tablename('hyb_yl_recipe')."as a left join".tablename('hyb_yl_zhuanjia')."as b on b.zid=a.docid left join ".tablename('hyb_yl_userinfo')."as c on c.openid = a.useropenid where a.cid='{$cid}' and a.uniacid='{$uniacid}' and a.useropenid ='{$useropenid}'");

                    $res['pic'] = unserialize($res['pic']);
                    $num =count($res['pic']);
                    for ($i=0; $i <$num ; $i++) { 
                    	$res['pic'][$i] =$_W['attachurl'].$res['pic'][$i];
                    }
                   if(checksubmit()){
                     //模板消息通知1、获取用户formid
					//1.查询信息配置
					  $userid =$_GPC['userid'];
					//var_dump($_GPC['orderarr'],$_GPC['dmoney'],$userid);exit();
					  $wxappaid = pdo_get('hyb_yl_parameter',array('uniacid'=>$uniacid));
					  //2.查询微信模板
					  $wxapptemp = pdo_get('hyb_yl_wxapptemp',array('uniacid'=>$uniacid));
					  //3.获取appid and appsecret
					  $appid = $wxappaid['appid'];
					  $appsecret = $wxappaid['appsecret'];
					  //4.获取模板
					  $template_id = $wxapptemp['cforder'];
					  $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
					  $getArr=array();
					  $tokenArr=json_decode($this->send_post($tokenUrl,$getArr,"GET"));
					  $access_token=$tokenArr->access_token;
					  $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
					  //5.查询当前医生formid
					  $member = pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_userinfo')."where uniacid='{$uniacid}' and  openid='{$useropenid}'");
					  $nummoney = ($_GPC['dmoney'] + $_GPC['cfzhenj']);
					  //1专家ID 2.用户openid 2.问题ID
					  foreach($member as $key => $value){
					    $out_time = strtotime('-7 days',time());
					    $formids = unserialize($value['form_id']);
					    foreach($formids as $k => $v){
					      if($out_time >= $v['form_time']){
					        unset($formids[$k]);
					      }
					    }
					    $formids = array_values($formids); 
					    $form_id = $formids[0]['form_id'];
					    $dd['form_id'] = $form_id;
					    $dd['touser'] = $value['openid'];
					    $content = array(
					      "keyword1"=>array(
					        "value"=> $_GPC['orderarr'],
					        "color"=>"#4a4a4a"
					        ),
					      "keyword2"=>array(
					        "value"=>$nummoney,
					        "color"=>""
					        ),
					      "keyword3"=>array(
					        "value"=>'您有最新处方订单,点击查看',
					        "color"=>""
					        ),
					      );
					      $dd['template_id']=$template_id;
					      $dd['page']='hyb_yl/mysubpages/pages/my_hzprescription/my_hzprescription?userid='.$userid;  
					      //跳转医生id 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,该字段不填则模板无跳转。
					      $dd['data']=$content;                        //模板内容，不填则下发空模板
					      $dd['color']='';                        //模板内容字体的颜色，不填默认黑色
					      $dd['emphasis_keyword']='';    //模板需要放大的关键词，不填则默认无放大
					      $result1 = $this->https_curl_json($url,$dd,'json');
					      foreach($formids as $k => $v){
					        if($form_id == $v['form_id']){
					          unset($formids[$k]);
					        }
					      }
					      $new_formids = array_values($formids); 
					      $datas['form_id'] = serialize($new_formids);
					      pdo_update('hyb_yl_userinfo',$datas,array('u_id'=>$value['u_id']));
					    }
					    //更新为已通知
					   
					    pdo_update('hyb_yl_recipe',array('iftz'=>1,'dmoney'=>$_GPC['dmoney'],'ifxians'=>1,'nummoney'=>$nummoney),array('cid'=>$cid,'uniacid'=>$uniacid));
					    message("通知成功!",$this->createWebUrl("cfsite",array("op"=>"display")),"success");
                   }
				}
				include $this->template("orderinfo");
			}

			private function send_post($url, $post_data,$method='POST') {
			  $postdata = http_build_query($post_data);
			  $options = array(
			    'http' => array(
			        'method' => $method, //or GET
			        'header' => 'Content-type:application/x-www-form-urlencoded',
			        'content' => $postdata,
			        'timeout' => 15 * 60 // 超时时间（单位:s）
			        )
			    );
			  $context = stream_context_create($options);
			  $result = file_get_contents($url, false, $context);
			  return $result;
			}
        private function https_curl_json($url,$data,$type){
          if($type=='json'){
            $headers = array("Content-type: application/json;charset=UTF-8","Accept: application/json","Cache-Control: no-cache", "Pragma: no-cache");
            $data=json_encode($data);
          }
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
	        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	        if (!empty($data)){
	          curl_setopt($curl, CURLOPT_POST, 1);
	          curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
	        }
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
	        $output = curl_exec($curl);
	        if (curl_errno($curl)) {
	            echo 'Errno'.curl_error($curl);//捕抓异常
	          }
	          curl_close($curl);
	          return $output;
          } 
			private function api_notice_increment($url, $data){
			  $ch = curl_init();
			       // $header = "Accept-Charset: utf-8";
			  curl_setopt($ch, CURLOPT_URL, $url);
			  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			        //curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
			  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
			  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			  curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
			  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			  $tmpInfo = curl_exec($ch);
			  if (curl_errno($ch)) {
			    return false;
			  }else{
			    return $tmpInfo;
			  }
			}

		public function doWebButton1(){
			global $_GPC, $_W;
			load()->func("tpl");
			$op = $_GPC['op'];
			if($op == 'postss'){
				$id = $_GPC['id'];
				$uniacid = $_W['uniacid'];
				$item = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_button_daohang")." where uniacid=:uniacid and id=:id ",array(":uniacid"=>$_W['uniacid'],":id"=>$id));

				if(checksubmit("tijao")){
					$data = array(
						'fw_title'=>$_GPC['fw_title'],
						);
					$saq = pdo_update('hyb_yl_button_daohang',$data,array('uniacid'=>$uniacid,'id'=>$id));
					if($saq){
						message("修改成功!",$this->createWebUrl("button",array("op"=>"display")),"success");
					}else{
						message("修改失败!",$this->createWebUrl("button",array("op"=>"display")),"success");
					}  
				}
			}
			include $this->template("button_daohang");
		}

		public function doWebButton2(){
			global $_GPC, $_W;
			load()->func("tpl");
			$op = $_GPC['op'];
			if($op == 'postss'){
				$id = $_GPC['id'];
				$uniacid = $_W['uniacid'];
				$item = pdo_fetch("SELECT `fw_title2` FROM ".tablename("hyb_yl_button_daohang")." where uniacid=:uniacid and id=:id ",array(":uniacid"=>$_W['uniacid'],":id"=>$id));

				if(checksubmit("tijao")){
					$data = array(
						'fw_title2'=>$_GPC['fw_title2'],
						);
					$saq = pdo_update('hyb_yl_button_daohang',$data,array('uniacid'=>$uniacid,'id'=>$id));
					if($saq){
						message("修改成功!",$this->createWebUrl("button",array("op"=>"display")),"success");
					}else{
						message("修改失败!",$this->createWebUrl("button",array("op"=>"display")),"success");
					}  
				}
			}
			include $this->template("button_daohang");
		}

		public function doWebButton3(){
			global $_GPC, $_W;
			load()->func("tpl");
			$op = $_GPC['op'];
			if($op == 'postss'){
				$id = $_GPC['id'];
				$uniacid = $_W['uniacid'];
				$items = pdo_fetch("SELECT `fw_thumb` FROM ".tablename("hyb_yl_button_daohang")." where uniacid=:uniacid and id=:id ",array(":uniacid"=>$_W['uniacid'],":id"=>$id));

				if(checksubmit("tijao")){
					$data = array(
						'fw_thumb'=>$_GPC['fw_thumb'],
						);
					$saq = pdo_update('hyb_yl_button_daohang',$data,array('uniacid'=>$uniacid,'id'=>$id));
					if($saq){
						message("修改成功!",$this->createWebUrl("button",array("op"=>"display")),"success");
					}else{
						message("修改失败!",$this->createWebUrl("button",array("op"=>"display")),"success");
					}  
				}
			}
			include $this->template("button_daohang");
		}
	/*
		导航
	*/
		public function doWebService ()
		{
			global $_GPC, $_W;
			load()->func("tpl");
			$op = $_GPC['op'];
			$ops = array('display', 'post',"delete");
			$op = in_array($op, $ops) ? $op : 'display';
			if ($op == "display") {
				$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_fuwu")." where uniacid=:uniacid",array(":uniacid"=>$_W['uniacid']));

			}
			if ($op == "post") {
				$items = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_fuwu")." where id=:id and uniacid=:uniacid",array(":id"=>$_GPC['id'],":uniacid"=>$_W['uniacid']));
			//$lianjie = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_fuwu_lianjie"));
				if (checksubmit("submit")) {

					$data = array("uniacid"=>$_W['uniacid'],
						"l_names"=>$_GPC['l_names'],
						"fuwu_name"=>$_GPC['fuwu_name'],
						"fuwu_money"=>$_GPC['fuwu_money'],
						"fuwu_thumb"=>$_GPC['fuwu_thumb'],
						"webviewurl"=>$_GPC['webviewurl'],
						"wxname"=>$_GPC['wxname'],
						"wxappid"=>$_GPC['wxappid'],
						'check1'=>$_GPC['check1']
						);

					if (empty($_GPC['id'])) {
						pdo_insert("hyb_yl_fuwu",$data);
						message("添加成功!",$this->createWebUrl("service",array("op"=>"display")),"success");
					}
					else
					{
						pdo_update("hyb_yl_fuwu",$data,array("id"=>$_GPC['id']));
						message("修改成功!",$this->createWebUrl("service",array("op"=>"post",'id'=>$_GPC['id'])),"success");
					}
				}
			}
			if ($op == "delete") {
				$id = $_GPC['id'];
				pdo_delete("hyb_yl_fuwu",array("id"=>$id));
				message("删除成功!",$this->createWebUrl("service",array("op"=>"display")),"success");
			}
			include $this->template("fuwu");
		}

/*
		我们的服务
	*/
		public function doWebMyser ()
		{
			global $_GPC, $_W;
			load()->func("tpl");
			$op = $_GPC['op'];
			$ops = array('display', 'post',"delete");
			$op = in_array($op, $ops) ? $op : 'display';

			$tree=array(
				'1'=>'/hyb_yl/tabBar/index/index',
				'2'=>'/hyb_yl/zhuanjiasubpages/pages/zhuanjialiebiao/zhuanjialiebiao',
				'3'=>'/hyb_yl/userLife/pages/faxian/faxian',
				'4'=>'/hyb_yl/userLife/pages/jibing/jibing',
				'5'=>'/hyb_yl/userLife/pages/index/index',
				);
			$url=array(
				'1'=>'首页',
				'2'=>'专家列表',
				'3'=>'问答大厅',
				'4'=>'课程管理',
				'5'=>'快速问诊',
				);
			foreach ($tree as $key => $value) {

				$newdate[$key]['name']=$url[$key];  
				$newdate[$key]['url']=$tree[$key];
			}

			if ($op == "display") {
				$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_myser")." where uniacid=:uniacid",array(":uniacid"=>$_W['uniacid']));

			}
			if ($op == "post") {
				$items = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_myser")." where id=:id and uniacid=:uniacid",array(":id"=>$_GPC['id'],":uniacid"=>$_W['uniacid']));
				if (checksubmit("submit")) {
					$data = array(
						"uniacid"=>$_W['uniacid'],
						"s_names"=>$_GPC['s_names'],
						"ser_name"=>$_GPC['ser_name'],
						"ser_money"=>$_GPC['ser_money'],
						"ser_thumb"=>$_GPC['ser_thumb'],
						"ser_lujing"=>$_GPC['ser_lujing'],
						"ser_type"=>$_GPC['ser_type']
						);

					if (empty($_GPC['id'])) {
						pdo_insert("hyb_yl_myser",$data);
						message("添加成功!",$this->createWebUrl("myser",array("op"=>"display")),"success");
					}
					else
					{
						pdo_update("hyb_yl_myser",$data,array("id"=>$_GPC['id']));
						message("修改成功!",$this->createWebUrl("myser",array("op"=>"display")),"success");
					}
				}
			}
			if ($op == "delete") {
				$id = $_GPC['id'];
				pdo_delete("hyb_yl_myser",array("id"=>$id));
				message("删除成功!",$this->createWebUrl("myser",array("op"=>"display")),"success");
			}
			include $this->template("myser");
		}

	/*
		患者管理
	*/
		public function doWebHzanl ()
		{
			global $_GPC, $_W;
			load()->func("tpl");
			$op = $_GPC['op'];
			$ops = array('display', 'post',"delete");
			$op = in_array($op, $ops) ? $op : 'display';
			$id = $_GPC['hz_id'];
			$uniacid = $_W['uniacid'];
			if ($op == "display") {
			// $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_huanzhe")."WHERE uniacid='{$uniacid}'",array(":uniacid"=>$_W['uniacid']));

				$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_huanzhe")." as zj left join ".tablename("hyb_yl_keshi")." as k on zj.hz_zlks=k.k_id where zj.uniacid=:uniacid order by sord",array(":uniacid"=>$_W['uniacid']));

			}
			if ($op == "post") {
				$id = $_GPC['hz_id'];

				$uniacid = $_W['uniacid'];
				$items = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_huanzhe")." where hz_id='{$id}' and uniacid='{$uniacid}'");
				$keshi = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_keshi")." where uniacid='{$uniacid}'");

				if (checksubmit("submit")) {
					$data = array(
						"uniacid"=>$_W['uniacid'],
						"hz_mp3" => $_GPC['hz_mp3'],
						"hz_name"=>$_GPC['hz_name'],
						"hz_thumb"=>$_GPC['hz_thumb'], 
						"hz_count"=>$_GPC['hz_count'],
						"hz_type"=>$_GPC['hz_type'],
						"hz_zlks" =>$_GPC['hz_zlks'],
						"hz_desction"=>$_GPC['hz_desction'],
						"hz_time"=>date('Y-m-d H:i:s',time()),
						"iflouc"=>$_GPC['iflouc'],
						'dianj'=>$_GPC['dianj'],
						'aliaut'=>$_GPC['aliaut'],
						'kiguan'=>$_GPC['kiguan']
						);
					if (empty($id)) {
						pdo_insert("hyb_yl_huanzhe",$data);
						message("添加成功!",$this->createWebUrl("hzanl",array("op"=>"display")),"success");
					}
					else
					{
						pdo_update("hyb_yl_huanzhe",$data,array("hz_id"=>$id));
						message("修改成功!",$this->createWebUrl("hzanl",array("op"=>"display")),"success");
					}
				}

			}
			if(checksubmit("paixu")){
				$zid=$_GPC['hz_id'];
				$sord = $_GPC['sord'];
				for($i=0;$i<count($zid);$i++){
					$id = $zid[$i];
					$sid = $sord[$i];
					$data= array(
						'sord'=>$sid
						);
					$update_sql=pdo_update('hyb_yl_huanzhe',$data,array('hz_id'=>$id,'uniacid'=>$_W['uniacid']));
				}
				message('排序成功', $this->createWebUrl('hzanl',array('op'=>'display')), 'success');
			}
			if ($op == "delete") {
				$id = $_GPC['hz_id'];
				pdo_delete("hyb_yl_huanzhe",array("hz_id"=>$id));
				message("删除成功!",$this->createWebUrl("hzanl",array("op"=>"display")),"success");
			}
			include $this->template("hzanl");
		}



	/*
		专家管理
	*/
		public function doWebTeam()
		{
			global $_GPC, $_W;
			load()->func("tpl");
			$uniacid = $_W['uniacid'];
			$subcatess = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_addresshospitai') . " WHERE uniacid = '{$uniacid}' ");
			$parentpfxm = array();  
			$childrenpfxm = array();  
			if (!empty($subcatess)) {  
				$childrenpfxm = '';  
				foreach ($subcatess as $cidpfxm => $catepfxm) {  
					if (!empty($catepfxm['parentid'])) {  
						$childrenpfxm[$catepfxm['parentid']][] = $catepfxm;  
					} else {  
						$parentpfxm[$catepfxm['id']] = $catepfxm;  
					}  
				}
			} 
			$op = $_GPC['op'];
			$ops = array('display', 'post',"delete","visible");
			$op = in_array($op, $ops) ? $op : 'display';
			if ($op == "display") {
				$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' .tablename("hyb_yl_zhuanjia")." as a left join ".tablename("hyb_yl_addresshospitai")." as b on a.z_room=b.id where a.uniacid=:uniacid order by a.sord asc",array(":uniacid"=>$_W['uniacid']));

				$pindex = max(1, intval($_GPC['page'])); 
				$pagesize = 10;
				$pager = pagination($total,$pindex,$pagesize);
				$p = ($pindex-1) * $pagesize; 

				$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_zhuanjia")." as a left join ".tablename("hyb_yl_addresshospitai")." as b on a.z_room=b.id where a.uniacid=:uniacid order by a.sord asc limit ".$p.",".$pagesize ,array(":uniacid"=>$_W['uniacid']));

				if(checksubmit("paixu")){
					$zid=$_GPC['zid'];
					$sord = $_GPC['sord'];
					for($i=0;$i<count($zid);$i++){
						$id = $zid[$i];
						$sid = $sord[$i];
						$data= array(
							'sord'=>$sid
							);
						$update_sql=pdo_update('hyb_yl_zhuanjia',$data,array('zid'=>$id,'uniacid'=>$uniacid));
					}
					message('排序成功', $this->createWebUrl('team',array('op'=>'display')), 'success');
				}
			}
			if ($op == "post") {
			$id = $_GPC['zid'];//医生ID
            $z_yy_money =$_GPC['z_yy_money'];//医生挂号金额
            $z_room =$_GPC['z_room'];//医生所在科室
            $get =  pdo_fetch("SELECT  * FROM ".tablename("hyb_yl_zhuanjia")." as a left join ".tablename("hyb_yl_addresshospitai")." as b on a.nksid=b.id where a.zid='{$id}' and a.uniacid='{$uniacid}'",array("uniacid"=>$_W['uniacid']));

            if(!empty($get['openid'])){
            	$items =  pdo_fetch("SELECT * FROM ".tablename("hyb_yl_zhuanjia")." as a left join ".tablename("hyb_yl_addresshospitai")." as b on a.nksid=b.id left join".tablename('hyb_yl_userinfo')." as c on c.openid = a.openid where a.zid='{$id}' and a.uniacid='{$uniacid}'",array("uniacid"=>$_W['uniacid']));
            	
            }else{
            	$items =  pdo_fetch("SELECT * FROM ".tablename("hyb_yl_zhuanjia")." as a left join ".tablename("hyb_yl_addresshospitai")." as b on a.nksid=b.id where a.zid='{$id}' and a.uniacid='{$uniacid}'",array("uniacid"=>$_W['uniacid']));
            }
            $items['z_thumb'] = unserialize($items['z_thumb']);
            $items['url']=unserialize($items['url']);

            if (checksubmit("submit")) {
            	$hosid = $_GPC['team']['parentid'];//医院ID
            	$nksid = $_GPC['team']['childid'];//医院ID
            	//查询医院经纬度
            	$docjwd = pdo_get('hyb_yl_addresshospitai',array('id'=>$hosid),array('lat','lng'));
            	
            	$lat = $docjwd['lat'];
            	$lng = $docjwd['lng'];
            	
            	$telmoney=$_GPC['telmoney'];
            	$timeshic=$_GPC['timeshic'];
            	$url=$_GPC['url'];
            	foreach ($url as $key => $value) {
            		$newdate[$key]['url']=$url[$key];  
            		$newdate[$key]['timeshic']=$timeshic[$key];
            		$newdate[$key]['telmoney']=$telmoney[$key];   
            	}
		        //查询父类名称
            	$parentname = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_addresshospitai")." WHERE uniacid=:uniacid and parentid=:parentid",array(":uniacid"=>$uniacid,":parentid"=>$hosid));

            	$data = array(
            		"uniacid"=>$_W['uniacid'],
            		"z_name"=>$_GPC['z_name'],
            		"z_zhicheng"=>$_GPC['z_zhicheng'],
            		"z_zhiwu"=>$_GPC['z_zhiwu'],
            		"z_telephone"=>$_GPC['z_telephone'],
            		"z_zhenzhi"=>$_GPC['z_zhenzhi'],
            		"z_room"=>$parentid,
            		"z_content"=>$_GPC['z_content'],
            		"z_tw_money"=>$_GPC['z_tw_money'],
            		"z_zx_money"=>$_GPC['z_zx_money'],
            		"z_yy_money"=>$_GPC['z_yy_money'],
            		"z_yy_type"=>$_GPC['z_yy_type'],
            		"z_yy_fens"=>$_GPC['z_yy_fens'],
            		"z_yiyuan" =>$_GPC['z_yiyuan'],
            		"z_thumbs" =>$_GPC['z_thumbs'],
            		"z_shenfengzheng" =>$_GPC['z_shenfengzheng'],
            		"z_thumb"=>serialize($_GPC['z_thumb']),
            		'z_lt_money'=>$_GPC['z_lt_money'],
            		'futype'=>$_GPC['futype'],
            		'lttype'=>$_GPC['lttype'],
            		'helpnum'=>$_GPC['helpnum'],
            		'url'=>serialize($newdate),
            		'goby'=>$_GPC['goby'],
            		'ifzz'=>$_GPC['ifzz'],
            		'openid'=>$_GPC['info']['fromuser'],
                    'hosid'=>$hosid,
                    'nksid'=>$nksid,
                    'wzmoney'=>$_GPC['wzmoney'],
                    'lat1'=>$lat,
                    'lng1'=>$lng
            		);

            	if (empty($id)) {
            		pdo_insert("hyb_yl_zhuanjia",$data);
            		message("添加成功!",$this->createWebUrl("team",array("op"=>"display")),"success");
            	}
            	else
            	{
            		pdo_update("hyb_yl_zhuanjia",$data,array("zid"=>$id));
            		message("修改成功!",$this->createWebUrl("team",array("op"=>"display")),"success");
            	}
            }
        }
        if ($op == "delete") {
        	$id = $_GPC['zid'];
        	pdo_delete("hyb_yl_zhuanjia",array("zid"=>$id));
        	message("删除成功!",$this->createWebUrl("team",array("op"=>"display")),"success");
        }
		if ($op == 'visible') {
		    $zid = $_GPC['zid'];
		    $z_shenfengzheng = $_GPC['z_shenfengzheng'];
            $data=array(
                'z_shenfengzheng'=>$z_shenfengzheng
             	);  
            pdo_update('hyb_yl_zhuanjia', $data, array('zid' => $zid));
            $res = pdo_fetchall("SELECT * FROM".tablename("hyb_yl_chat_msg")."WHERE uniacid='{$uniacid}'");
            if($res){
            	foreach ($res as $key => $value) {
            		$m_id =$value['m_id'];
            		pdo_update('hyb_yl_chat_msg', array('kfid'=>$zid), array('m_id' => $m_id));
            	}
            }
            pdo_update('hyb_yl_zhuanjia', $data, array('zid' => $zid));
		    message(error(0, '操作成功'));  
		    $result['errno'] = 1;
		    $result['message'] = '操作失败 : 没有找到指定ID';
		    message($result, '', 'ajax');
		}

        include $this->template("team");
    }

	//用户提升专家
    public function doWebTszj()
    {
    	global $_GPC, $_W;
    	load()->func("tpl");
    	$uniacid = $_W['uniacid'];
    	$subcatess = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_category') . " WHERE uniacid = '{$uniacid}' ");

    	$parentpfxm = array();  
    	$childrenpfxm = array();  
    	if (!empty($subcatess)) {  
    		$childrenpfxm = '';  
    		foreach ($subcatess as $cidpfxm => $catepfxm) {  
    			if (!empty($catepfxm['parentid'])) {  
    				$childrenpfxm[$catepfxm['parentid']][] = $catepfxm;  
    			} else {  
    				$parentpfxm[$catepfxm['id']] = $catepfxm;  
    			}  
    		}
    	} 
    	$op = $_GPC['op'];
    	$ops = array('display', 'post',"delete");
    	$op = in_array($op, $ops) ? $op : 'display';
    	if ($op == "post") {
    		$id = $_GPC['id'];
    		$openid = $_GPC['openid'];


    		$items =  pdo_fetch("SELECT * FROM ".tablename("hyb_yl_zhuanjia")." as a left join ".tablename("hyb_yl_category")." as b on a.z_room=b.id where a.zid='{$id}' and a.uniacid='{$uniacid}'",array("uniacid"=>$_W['uniacid']));

    		if($zhuanjia['openid'] == $openid){
    			message("该用户已经成为医院专家");
    		}
    		if (checksubmit("submit")) {
    			$parentid = $_GPC['team']['childid'];
    			$u_name = $_GPC['z_thumb'];
    			$images = '';
    			foreach ($u_name as $key => $value) {
    				$images = $_W['attachurl'].$value;
    				$u_name[$key] = $images;
    			}             
    			$imagess = substr(implode(";",$u_name),0,strlen(implode(";",$u_name))); 

    			$data = array(
    				"uniacid"=>$_W['uniacid'],
    				"z_name"=>$_GPC['z_name'],
    				"z_thumbs"=>$_W['attachurl'].$_GPC['z_thumbs'],
    				"z_thumb"=>$imagess,
    				"z_zhicheng"=>$_GPC['z_zhicheng'],
    				"z_zhiwu"=>$_GPC['z_zhiwu'],
    				"z_telephone"=>$_GPC['z_telephone'],
    				"z_zhenzhi"=>$_GPC['z_zhenzhi'],
    				"z_room"=>$parentid,
    				"openid" =>$_GPC['openid'],
    				"z_content"=>$_GPC['z_content'],
    				"z_tw_money"=>$_GPC['z_tw_money'],
    				"z_zx_money"=>$_GPC['z_zx_money'],
    				"z_yy_money"=>$_GPC['z_yy_money'],
    				"z_yy_type"=>$_GPC['z_yy_type'],
    				"z_yy_fens"=>$_GPC['z_yy_fens'],
    				"z_yy_sheng" =>1,
    				"z_yiyuan" =>$_GPC['z_yiyuan'],
					// "zdy_title"=>$_GPC['zdy_title']
    				);
    			if (empty($id)) {
    				pdo_insert("hyb_yl_zhuanjia",$data);
    				message("添加成功!",$this->createWebUrl("team",array("op"=>"display")),"success");
    			}

    		}
    	}

    	include $this->template("tszj");
    }

	///平台专家

	//用户提升专家
    public function doWebPtzj()
    {
    	global $_GPC, $_W;
    	load()->func("tpl");
    	$uniacid = $_W['uniacid'];
    	$subcatess = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_category') . " WHERE uniacid = '{$uniacid}' ");
    	$parentpfxm = array();  
    	$childrenpfxm = array();  
    	if (!empty($subcatess)) {  
    		$childrenpfxm = '';  
    		foreach ($subcatess as $cidpfxm => $catepfxm) {  
    			if (!empty($catepfxm['parentid'])) {  
    				$childrenpfxm[$catepfxm['parentid']][] = $catepfxm;  
    			} else {  
    				$parentpfxm[$catepfxm['id']] = $catepfxm;  
    			}  
    		}
    	}
		//  
    	$op = $_GPC['op'];

    	$ops = array('display', 'post',"delete");
    	$op = in_array($op, $ops) ? $op : 'display';
    	if ($op == "post") {
    		$id = $_GPC['id'];
    		$openid = $_GPC['openid'];

    		if (checksubmit("submit")) {

    			$parentid = $_GPC['ptzj']['childid'];

		        //查询父类名称
    			$parentname = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_category")." WHERE uniacid=:uniacid and parentid=:parentid",array(":uniacid"=>$uniacid,":parentid"=>$parentid));

    			$u_name = $_GPC['z_thumb'];
    			$images = '';
    			foreach ($u_name as $key => $value) {
    				$images = $_W['attachurl'].$value;
    				$u_name[$key] = $images;
    			}

    			$imagess = substr(implode(";",$u_name),0,strlen(implode(";",$u_name))); 

    			error_reporting();

    			$data = array(
    				"uniacid"=>$_W['uniacid'],
    				"z_name"=>$_GPC['z_name'],
    				"z_thumbs"=>$_GPC['z_thumbs'],
    				"z_thumb"=>$imagess,
    				"z_zhicheng"=>$_GPC['z_zhicheng'],
    				"z_zhiwu"=>$_GPC['z_zhiwu'],
    				"z_telephone"=>$_GPC['z_telephone'],
    				"z_zhenzhi"=>$_GPC['z_zhenzhi'],
    				"z_room"=>$parentid,
    				"openid" =>$_GPC['openid'],
    				"z_content"=>$_GPC['z_content'],
    				"z_tw_money"=>$_GPC['z_tw_money'],
    				"z_zx_money"=>$_GPC['z_zx_money'],
    				"z_yy_money"=>$_GPC['z_yy_money'],
    				"z_yy_type"=>$_GPC['z_yy_type'],
    				"z_yy_fens"=>$_GPC['z_yy_fens'],
    				"z_yy_sheng" =>1,
    				"z_yiyuan" =>$_GPC['z_yiyuan'],
    				"z_shenfengzheng" =>$_GPC['z_shenfengzheng'],
					// "zdy_title"=>$_GPC['zdy_title']
    				);
    			if (empty($id)) {
    				pdo_insert("hyb_yl_zhuanjia",$data);
    				message("添加成功!",$this -> createWebUrl('team'),'success');
    			}

    		}
    	}

    	include $this->template("tszj");
    }
    public function doWebShenghe(){
    	global $_W,$_GPC;
    	load()->func('tpl');
    	$uniacid =$_W['uniacid'];
    	if($_GPC['z_yy_sheng'] ==1){
    		$data =array(
    			'z_yy_sheng'=>0
    			);
    	}else{
    		$data =array(
    			'z_yy_sheng'=>1
    			);
    	}

    	$zid = $_GPC['zid'];
    	$res = pdo_update('hyb_yl_zhuanjia',$data, array('zid'=>$zid,'uniacid'=>$uniacid));
    	message('审核成功',$this -> createWebUrl('team'),'success');


		//include $this->template('shenghe');
    }
	/*
		专家预约管理
	*/
		public function doWebTeamyy ()
		{
			global $_GPC, $_W;
			load()->func("tpl");
			$op = $_GPC['op'];
			$ops = array('display', 'post','delete');
			$op = in_array($op, $ops) ? $op : 'display';
			$uniacid = $_W['uniacid'];
			if ($op == "display") {
				$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_zhuanjia_yuyue")." as a left join ".tablename("hyb_yl_myinfors")." as b on a.zy_name=b.my_id "."left join ".tablename("hyb_yl_userinfo")."as c on b.openid=c.openid "."left join ".tablename("hyb_yl_zhuanjia")."as d on a.z_name=d.zid where a.uniacid = '{$uniacid}' and d.z_shenfengzheng =1 ORDER BY a.zy_id");

			}
			if ($op == "delete") {
				$id = $_GPC['zy_id'];
				pdo_delete("hyb_yl_zhuanjia_yuyue",array("zy_id"=>$id));
				message("删除成功!",$this->createWebUrl("teamyy",array("op"=>"display")),"success");
			}
			include $this->template("teamyy");
		}

	/*
	案例分类
	*/
	public function doWebObjectinfo ()
	{
		global $_GPC, $_W;
		load()->func("tpl");
		$op = $_GPC['op'];
		$ops = array('display', 'post','delete');
		$op = in_array($op, $ops) ? $op : 'display';
		if ($op == "display") {
			$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_keshi")." where uniacid=:uniacid",array(":uniacid"=>$_W['uniacid']));
		}
		if ($op == "post") {
			$id = $_GPC['k_id'];
			$item = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_keshi")." where k_id=:k_id and uniacid=:uniacid",array(":k_id"=>$id,":uniacid"=>$_W['uniacid']));
			if (checksubmit("submit")) {
				$data = array("uniacid"=>$_W['uniacid'],"k_name"=>$_GPC['k_name']);
				if (empty($id)) {
					pdo_insert("hyb_yl_keshi",$data);
					message("添加成功!",$this->createWebUrl("objectinfo",array("op"=>"display")),"success");
				}
				else
				{
					pdo_update("hyb_yl_keshi",$data,array("k_id"=>$id));
					message("修改成功!",$this->createWebUrl("objectinfo",array("op"=>"display")),"success");
				}
			}
		}
		if ($op == "delete") {
			$id = $_GPC["k_id"];
			pdo_delete("hyb_yl_keshi",array("k_id"=>$id));
			message("删除成功!",$this->createWebUrl("objectinfo",array("op"=>"display")),"success");
		}
		include $this->template("objectinfo");
	}

	/*
		科室预约管理
	*/
		public function doWebObject ()
		{
			global $_GPC, $_W;
			load()->func("tpl");
			$op = $_GPC['op'];
			$ops = array('display', 'post','delete');
			$op = in_array($op, $ops) ? $op : 'display';
			$uniacid = $_W['uniacid'];

			if ($op == "display") {


				$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_zhuanjia_yuyue")." as a left join ".tablename("hyb_yl_myinfors")." as b on a.zy_name=b.my_id "."left join ".tablename("hyb_yl_userinfo")."as c on b.openid=c.openid "."left join ".tablename("hyb_yl_zhuanjia")."as d on a.z_name=d.zid where a.uniacid = '{$uniacid}' and d.z_shenfengzheng =0 ORDER BY a.zy_id");

			}
			if ($op == "delete") {
				$id = $_GPC['zy_id'];
				pdo_delete("hyb_yl_zhuanjia_yuyue",array("zy_id"=>$id));
				message("删除成功!",$this->createWebUrl("teamyy",array("op"=>"display")),"success");
			}
			include $this->template("objectyy");
		}
		public function doWebConfirmss(){
			global $_W, $_GPC;
			load()->func('tpl');
			$id = $_GPC['zy_id'];
			$result = pdo_update('hyb_yl_zhuanjia_yuyue', array('zy_zhenzhuang' => 1), array('zy_id' => $id));

			if ($result) {
				message('确定成功', $this->createWebUrl('teamyy', array()), 'success');
			} else {
				message('确定失败', '', 'error');
			}
		}
	/*
		资讯管理
	*/
		public function doWebAlticle ()
		{
			global $_W,$_GPC;
			load()->func("tpl");
			$op = $_GPC['op'];
			$ops = array('display', 'post',"delete");
			$op = in_array($op, $ops) ? $op : 'display';
			if ($op == "display") {
				$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_zixun")." as z left join ".tablename("hyb_yl_zixun_type")." as zt on z.zx_names=zt.zx_id where z.uniacid=:uniacid order by sord",array(":uniacid"=>$_W['uniacid']));
			}
			if ($op == "post") {
				$type = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_zixun_type")." where uniacid=:uniacid",array(":uniacid"=>$_W['uniacid']));
				$id = $_GPC['id'];
				$items = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_zixun")." as z left join ".tablename("hyb_yl_zixun_type")." as zt on z.zx_names=zt.zx_id where z.uniacid=:uniacid and z.id=:id",array(":uniacid"=>$_W['uniacid'],":id"=>$id));

				if (checksubmit("submit")) {
					$data = array("uniacid"=>$_W['uniacid'],
						"zx_names"=>$_GPC['zx_name'],
						"title"=>$_GPC['title'],
						"title_fu"=>$_GPC['title_fu'],
						"content_thumb"=>serialize($_GPC['content_thumb']),
						"content"=>$_GPC['content'],
						"status"=>$_GPC['status'],
						"time"=>time(),
						'thumb'=>$_GPC['thumb'],
						'mp3'=>$_GPC['mp3'],
						'iflouc'=>$_GPC['iflouc'],
						'dianj'=>$_GPC['dianj'],
						'aliaut'=>$_GPC['aliaut'],
						'kiguan'=>$_GPC['kiguan']
						);
					if (empty($id)) {
						pdo_insert("hyb_yl_zixun",$data);
						message("添加成功!",$this->createWebUrl("alticle",array("op"=>"display")),"success");
					}
					else
					{
						pdo_update("hyb_yl_zixun",$data,array("id"=>$id));
						message("修改成功!",$this->createWebUrl("alticle",array("op"=>"display")),"success");
					}
				}
			}
			if(checksubmit("paixu")){
				$zid=$_GPC['id'];
				$sord = $_GPC['sord'];
				for($i=0;$i<count($zid);$i++){
					$id = $zid[$i];
					$sid = $sord[$i];
					$data= array(
						'sord'=>$sid
						);
					$update_sql=pdo_update('hyb_yl_zixun',$data,array('id'=>$id,'uniacid'=>$_W['uniacid']));
				}
				message('排序成功', $this->createWebUrl('alticle',array('op'=>'display')), 'success');
			}
			if($op=="delete")
			{
				$id = $_GPC['id'];
				pdo_delete("hyb_yl_zixun",array("id"=>$id));
				message("删除成功!",$this->createWebUrl("alticle",array("op"=>"display")),"success");
			}
			include $this->template("alticle");
		}

	/*
		资讯分类管理
	*/
		public function doWebAlticletype ()
		{
			global $_GPC, $_W;
			load()->func("tpl");
			$op = $_GPC['op'];
			$ops = array('display', 'post',"delete");
			$op = in_array($op, $ops) ? $op : 'display';
			if($op == "display")
			{
				$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_zixun_type")." where uniacid=:uniacid",array(":uniacid"=>$_W['uniacid']));
			}
			if ($op == "post") {
				$id = $_GPC['zx_id'];
				$item = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_zixun_type")." where zx_id=:zx_id and uniacid=:uniacid",array(":zx_id"=>$id,":uniacid"=>$_W['uniacid']));
				if (checksubmit("submit")) {
					$data = array(
						"uniacid"=>$_W['uniacid'],
						"zx_name"=>$_GPC['zx_name'],
						"zx_thumb"=>$_GPC['zx_thumb'],
						"zx_type"=>$_GPC['zx_type']
						);
					if (empty($id)) {
						pdo_insert("hyb_yl_zixun_type",$data);
						message("添加成功!",$this->createWebUrl("alticletype",array("op"=>"display")),"success");
					}
					else
					{
						pdo_update("hyb_yl_zixun_type",$data,array("zx_id"=>$id));
						message("修改成功!",$this->createWebUrl("alticletype",array("op"=>"display")),"success");
					}
				}
			}
			if($op=="delete")
			{
				$id = $_GPC['zx_id'];
				pdo_delete("hyb_yl_zixun_type",array("zx_id"=>$id));
				message("删除成功!",$this->createWebUrl("alticletype",array("op"=>"display")),"success");
			}
			include $this->template("alticletype");
		}

	/*
		消息通知
	*/
		public function doWebNews ()
		{
			global $_GPC, $_W;
			load()->func("tpl");
			$op = $_GPC['op'];
			$ops = array('display', 'post','msg');
			$op = in_array($op, $ops) ? $op : 'display';
			$uniacid = $_W['uniacid'];
			if ($op == 'display') {
				$item = pdo_fetch("SELECT * FROM " . tablename('hyb_yl_email')." where uniacid=:uniacid",array(":uniacid"=>$_W['uniacid']));
				if (checksubmit('submit')) {
					$data = array(
						'uniacid' => $_W['uniacid'],
						'mailhost'=> $_GPC['mailhost'],
						'mailport'=> $_GPC['mailport'],
						'mailhostname'=>$_GPC['mailhostname'],
						'mailformname'=>$_GPC['mailformname'],
						'mailusername'=>$_GPC['mailusername'],
						'mailpassword'=>$_GPC['mailpassword'],
						'mailsend'	=>$_GPC['mailsend']
						);
					if (empty($item['id'])) {
						pdo_insert('hyb_yl_email', $data);
						message('添加成功!', $this -> createWebUrl('news', array('op' => 'display')), 'success');
					} else {
						pdo_update('hyb_yl_email', $data , array('id' => $item['id']));
						message('修改成功!', $this -> createWebUrl('news', array('op' => 'display')), 'success');
					} 


				} 
			}
			if ($op == 'post') {
				$item = pdo_fetch("SELECT * FROM " . tablename('hyb_yl_duanxin')." where uniacid=:uniacid",array(":uniacid"=>$_W['uniacid']));
				if (checksubmit('submit')) {
					$data = array(
						'uniacid' => $_W['uniacid'],
						'key'=>$_GPC['key'],
						'scret'=>$_GPC['scret'],
						'qianming'=>$_GPC['qianming'],
						'moban_id'=>$_GPC['moban_id'],
						'stadus'=>$_GPC['stadus'],
						'templateid'=>$_GPC['templateid'],
						'tel'=>$_GPC['tel'],
						'cfmb'=>$_GPC['cfmb']
						);

					if (empty($item['id'])) {
						pdo_insert('hyb_yl_duanxin', $data);
						message('添加成功!', $this -> createWebUrl('news', array('op' => 'display')), 'success');
					} else {
						pdo_update('hyb_yl_duanxin', $data , array('id' => $item['id']));
						message('修改成功!', $this -> createWebUrl('news', array('op' => 'post')), 'success');
					} 


				} 
			}
			if($op == 'msg'){
				$item = pdo_fetch("SELECT * FROM " . tablename('hyb_yl_wxapptemp')." where uniacid=:uniacid",array(":uniacid"=>$_W['uniacid']));
				if (checksubmit('submit')) {
					$data = array(
						'uniacid' => $_W['uniacid'],
						'doctemp' => $_GPC['doctemp'],
						'kaiguan' => $_GPC['kaiguan'],
						'txtempt' => $_GPC['txtempt'],
						"weidbb"  => $_GPC['weidbb'],
						'cforder' => $_GPC['cforder'],
						'paymobel'=> $_GPC['paymobel'],
						'kzyytongz' =>$_GPC['kzyytongz'],
						'tixuser' =>$_GPC['tixuser'],
						'yqtemp'  =>$_GPC['yqtemp'],
						'jujyaoqi'  =>$_GPC['jujyaoqi'],
						'qiany'  =>$_GPC['qiany'],
						);
				
					if (empty($item['w_id'])) {
						pdo_insert('hyb_yl_wxapptemp', $data);
						message('添加成功!', $this -> createWebUrl('news', array('op' => 'display')), 'success');
					} else {
						pdo_update('hyb_yl_wxapptemp', $data , array('w_id' => $item['w_id']));
						message('修改成功!', $this -> createWebUrl('news', array('op' => 'msg')), 'success');
					} 


				} 
			}

			include $this->template("news");
		}

		public function doWebDyj() {
			global $_W, $_GPC;
			load() -> func('tpl');
			$list = pdo_get('hyb_yl_dyj', array('uniacid' => $_W['uniacid']));
			if (checksubmit('submit')) {
				$data['dyj_title'] = $_GPC['dyj_title'];
				$data['dyj_id'] = $_GPC['dyj_id'];
				$data['dyj_key'] = $_GPC['dyj_key'];
				$data['dyj_title2'] = $_GPC['dyj_title2'];
				$data['dyj_id2'] = $_GPC['dyj_id2'];
				$data['dyj_key2'] = $_GPC['dyj_key2'];
				$data['uniacid'] = $_W['uniacid'];
				if ($_GPC['id'] == '') {
					$res = pdo_insert('hyb_yl_dyj', $data);
					if ($res) {
						message('添加成功', $this -> createWebUrl('dyj', array()), 'success');
					} else {
						message('添加失败', '', 'error');
					} 
				} else {
					$res = pdo_update('hyb_yl_dyj', $data, array('id' => $_GPC['id']));
					if ($res) {
						message('编辑成功', $this -> createWebUrl('dyj', array()), 'success');
					} else {
						message('编辑失败', '', 'error');
					} 
				} 
			} 
			include $this -> template('adddyj');
		}
	//问题库疾病
		public function doWebDisease()
		{
			global $_GPC, $_W;
			load()->func('tpl');
			$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
			$uniacid = $_W['uniacid'];
			if ($op =="display") {
				$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_bingzheng")." as bj left join ".tablename("hyb_yl_bingzheng_type")." as bt on bj.jibing=bt.t_id "."left join ".tablename("hyb_yl_userinfo")."as cp on bj.us_openid=cp.openid where bj.uniacid = '{$uniacid}'");
			}		

			if ($op == "post") {
			//疾病分类
				$jibing = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_bingzheng_type")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
				$id = $_GPC['id'];		

				$items = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_bingzheng")." as bj left join ".tablename("hyb_yl_bingzheng_type")." as bt on bj.jibing=bt.t_id left join".tablename('hyb_yl_userinfo')."as cp on bj.us_openid=cp.openid where bj.uniacid=:uniacid and bj.id=:id",array(":id"=>$id,":uniacid"=>$uniacid));

				if (checksubmit("submit")) {
					$openid =$_GPC['info']['openid'];

					$data = array(
						"uniacid"=>$uniacid,
						"us_name"=>$_GPC['us_name'],
						"thumb"=>serialize($_GPC['thumb']),
						"title_content"=>$_GPC['title_content'],
						"us_jhospital"=>$_GPC['us_jhospital'],
						"us_xhospital"=>$_GPC['us_xhospital'],
						"jida"=>$_GPC['jida'],
						"time"=>date('Y-m-d H:i:s',time()),
						"us_openid"=>$openid,
						"keshi"=>$_GPC['keshi']
						);
					if (empty($id)) {
						pdo_insert("hyb_yl_bingzheng",$data);
						message("添加成功!",$this->createWebUrl("disease"),"success");
					}
					else
					{
						pdo_update("hyb_yl_bingzheng",$data,array("id"=>$id));
						message("修改成功!",$this->createWebUrl("disease"),"success");
					}
				}
			}
			if ($op=="delete") {
				$id = $_GPC['id'];
				pdo_delete("hyb_yl_bingzheng",array("id"=>$id));
				message("删除成功!",$this->createWebUrl("disease"),"success");
			}
			include $this->template("diease");
		}

		public function doWebAlluser(){
			global $_GPC, $_W;
			load()->func('tpl');
			$op = $_GPC['op'];
			$uniacid = $_W['uniacid'];

			if($op == 'user'){
				if(!empty($_GPC['user_u_thumb'])){
					$keyword=$_GPC['user_u_thumb'];
					$condition="uniacid=".$uniacid." AND u_name='".$keyword."'";
					$records=pdo_fetch("SELECT openid,u_name,u_thumb,u_id FROM ".tablename("hyb_yl_userinfo")." WHERE ".$condition." LIMIT 1");
					if(!empty($records)){
						$fmdata = array(
							"success" => 1,
							"data" =>$records['openid'],
							);	 
					}else{
						$fmdata = array(

							"success" => -1,

							'data'=>'此用户未找到',
							);	
					}	 
					echo json_encode($fmdata);
					exit;
				}
				$keyword=$_GPC['keyword_user'];
				$condition="uniacid=".$uniacid." AND (u_name LIKE '%".$keyword."%')";
				$records=pdo_fetchall("SELECT openid,u_name,u_thumb,u_id FROM ".tablename("hyb_yl_userinfo")." WHERE ".$condition);
				$fmdata = array(
					"success" => 1,
					"data" =>$records,
					);	 
				echo json_encode($fmdata);
				exit;
			}
		}

		public function doWebAlldoctor(){
			global $_GPC, $_W;
			load()->func('tpl');
			$op = $_GPC['op'];
			$uniacid = $_W['uniacid'];
			if($op == 'user'){
				if(!empty($_GPC['user_u_thumb'])){
					$keyword=$_GPC['user_u_thumb'];
					$condition="uniacid=".$uniacid." AND z_name='".$keyword."'";
					$records=pdo_fetch("SELECT zid,z_name,z_thumbs,openid FROM ".tablename("hyb_yl_zhuanjia")." WHERE ".$condition."AND z_yy_sheng =1 LIMIT 1");
					$records['z_thumbs']=$_W['attachurl'].$records['z_thumbs'];
					if(!empty($records)){
						$fmdata = array(
							"success" => 1,
							"data" =>$records['openid'],
							);	 
					}else{
						$fmdata = array(

							"success" => -1,

							'data'=>'此用户未找到',
							);	
					}	 
					echo json_encode($fmdata);
					exit;
				}
				$keyword=$_GPC['keyword_user'];
				$condition="uniacid=".$uniacid." AND (z_name LIKE '%".$keyword."%')";
				$records=pdo_fetchall("SELECT zid,z_name,z_thumbs,openid FROM ".tablename("hyb_yl_zhuanjia")." WHERE ".$condition."AND z_yy_sheng =1");

				foreach ($records as &$value) {
					$value['z_thumbs']=$_W['attachurl'].$value['z_thumbs'];
				}
				$fmdata = array(
					"success" => 1,
					"data" =>$records,
					);	 
				echo json_encode($fmdata);
				exit;
			}
		}
  //视频评价
		public function doWebKccom()
		{
			global $_GPC, $_W;
			load()->func('tpl');
			$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
			$uniacid = $_W['uniacid'];
			if ($op =="display") {

				$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('hyb_yl_sorder') . " WHERE uniacid = :uniacid and m_comment !='' ", array(':uniacid' => $uniacid));

				$pindex = max(1, intval($_GPC['page'])); 
				$pagesize = 5;
				$pager = pagination($total,$pindex,$pagesize);
				$p = ($pindex-1) * $pagesize; 

				$products = pdo_fetchall("SELECT * FROM " . tablename("hyb_yl_sorder") . " as a left join " . tablename("hyb_yl_schoolroom") . " as b on a.s_pid=b.id  where a.uniacid='{$uniacid}' and a.m_comment !=''  order by a.s_id desc limit ".$p.",".$pagesize);

			}
	 //    if ($op == "post") {
		// 	$id = $_GPC['m_id'];
		// 	//var_dump($id);
		// 	$items = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_sorder")." where uniacid='{$uniacid}' and m_id='{$id}'",array(":id"=>$id,":uniacid"=>$uniacid));

		// 	if (checksubmit("submit")) {

		// 	$items = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_sorder")." where uniacid='{$uniacid}' and m_id='{$id}'",array(":id"=>$id,":uniacid"=>$uniacid));

  //           $t_comment = pdo_getcolumn('hyb_yl_mcoment', array('m_id' => $items['m_id']), 't_comment'); 
  //           $m_tj = pdo_getcolumn('hyb_yl_mcoment', array('m_id' => $items['m_id']), 'm_tj');
		// 	$data = array('t_comment'=>$t_comment=$_GPC['t_comment'],'m_tj'=> $m_tj=1);

		// 			pdo_update("hyb_yl_mcoment",$data,array("m_id"=>$id));

		// 			message("回复成功!",$this->createWebUrl("kccom"),"success");	
		// 	}
		// }
			if ($op=="delete") {
				$id = $_GPC['s_id'];
				$data =array(
					'm_comment'=>''
					);
				pdo_update("hyb_yl_sorder",$data,array("s_id"=>$id,'uniacid'=>$uniacid));
				message("删除成功!",$this->createWebUrl("kccom"),"success");
			}
			include $this->template("kccom");
		}

//资讯评价
		public function doWebZixcom()
		{
			global $_GPC, $_W;
			load()->func('tpl');
			$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
			$uniacid = $_W['uniacid'];
			if ($op =="display") {
				$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('hyb_yl_mcoment') . " WHERE uniacid = :uniacid and m_type=2", array(':uniacid' => $uniacid));
				$pindex = max(1, intval($_GPC['page'])); 
				$pagesize = 5;
				$pager = pagination($total,$pindex,$pagesize);
				$p = ($pindex-1) * $pagesize; 

			// $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_mcoment")." as a left join ".tablename("hyb_yl_zixun")." as b on a.kc_id=b.id where a.uniacid='{$uniacid}' and a.m_type = 2 order by a.m_id asc");

				$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_mcoment")." as a left join ".tablename("hyb_yl_zixun")." as b on a.kc_id=b.id where a.uniacid='{$uniacid}' and a.m_type = 2 order by a.m_id desc limit ".$p.",".$pagesize , array(':uniacid' => $uniacid));


			}
			if ($op == "post") {
				$id = $_GPC['m_id'];
				$items = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_mcoment")." where uniacid='{$uniacid}' and m_id='{$id}'",array(":id"=>$id,":uniacid"=>$uniacid));

				if (checksubmit("submit")) {

					$items = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_mcoment")." where uniacid='{$uniacid}' and m_id='{$id}'",array(":id"=>$id,":uniacid"=>$uniacid));

					$t_comment = pdo_getcolumn('hyb_yl_mcoment', array('m_id' => $items['m_id']), 't_comment'); 
					$m_tj = pdo_getcolumn('hyb_yl_mcoment', array('m_id' => $items['m_id']), 'm_tj');
					$data = array('t_comment'=>$t_comment=$_GPC['t_comment'],'m_tj'=> $m_tj=1);

					pdo_update("hyb_yl_mcoment",$data,array("m_id"=>$id));

					message("回复成功!",$this->createWebUrl("zixcom"),"success");	
				}
			}
			if ($op=="delete") {
				$id = $_GPC['m_id'];
				pdo_delete("hyb_yl_mcoment",array("m_id"=>$id));
				message("删除成功!",$this->createWebUrl("zixcom"),"success");
			}
			include $this->template("zixcom");
		}

//患者案例评价

		public function doWebHzcom()
		{
			global $_GPC, $_W;
			load()->func('tpl');
			$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
			$uniacid = $_W['uniacid'];
			if ($op =="display") {
			// $products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_mcoment")." as a left join ".tablename("hyb_yl_huanzhe")." as b on a.kc_id=b.hz_id where a.uniacid='{$uniacid}' and a.m_type = 3 order by a.m_id asc ");

				$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('hyb_yl_mcoment') . " WHERE uniacid = :uniacid and m_type=3", array(':uniacid' => $uniacid));
				$pindex = max(1, intval($_GPC['page'])); 
				$pagesize = 5;
				$pager = pagination($total,$pindex,$pagesize);
				$p = ($pindex-1) * $pagesize; 
				$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_mcoment")." as a left join ".tablename("hyb_yl_huanzhe")." as b on a.kc_id=b.hz_id where a.uniacid='{$uniacid}'and a.m_type = 3 order by a.m_id desc limit ".$p.",".$pagesize , array(':uniacid' => $uniacid));

			}
			if ($op == "post") {
				$id = $_GPC['m_id'];
				$items = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_mcoment")." where uniacid='{$uniacid}' and m_id='{$id}'",array(":id"=>$id,":uniacid"=>$uniacid));

				if (checksubmit("submit")) {

					$items = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_mcoment")." where uniacid='{$uniacid}' and m_id='{$id}'",array(":id"=>$id,":uniacid"=>$uniacid));

					$t_comment = pdo_getcolumn('hyb_yl_mcoment', array('m_id' => $items['m_id']), 't_comment'); 
					$m_tj = pdo_getcolumn('hyb_yl_mcoment', array('m_id' => $items['m_id']), 'm_tj');
					$data = array('t_comment'=>$t_comment=$_GPC['t_comment'],'m_tj'=> $m_tj=1);

					pdo_update("hyb_yl_mcoment",$data,array("m_id"=>$id));

					message("回复成功!",$this->createWebUrl("hzcom"),"success");	
				}
			}
			if ($op=="delete") {
				$id = $_GPC['m_id'];
				pdo_delete("hyb_yl_mcoment",array("m_id"=>$id));
				message("删除成功!",$this->createWebUrl("hzcom"),"success");
			}
			include $this->template("hzcom");
		}


	//问题疾病分类
		public function doWebDisease_type ()
		{
			global $_GPC, $_W;
			load()->func('tpl');
			$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
			$uniacid = $_W['uniacid'];
			if ($op == "display") {
				$items = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_bingzheng_type")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
			}
			if ($op == "post") {
				$id = $_GPC['t_id'];
				$item = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_bingzheng_type")." where uniacid=:uniacid and t_id=:t_id",array(":uniacid"=>$uniacid,":t_id"=>$id));
				if (checksubmit("submit")) {
					$data = array("uniacid"=>$uniacid,"type"=>$_GPC['type'],"icon" =>$_GPC['icon']);
					if (empty($id)) {
						pdo_insert("hyb_yl_bingzheng_type",$data);
						message("添加成功!",$this->createWebUrl("disease_type"),"success");
					}
					else
					{
						pdo_update("hyb_yl_bingzheng_type",$data,array("t_id"=>$id));
						message("修改成功!",$this->createWebUrl("disease_type"),"success");
					}
				}
			}if ($op=="delete") {
				$id = $_GPC['t_id'];
				pdo_delete("hyb_yl_bingzheng_type",array("t_id"=>$id));
				message("删除成功!",$this->createWebUrl("disease_type",array("op"=>"display")),"success");
			}
			include $this->template("diease_type");
		}
		public function doWebDiease_wentiback()
		{
			global $_GPC, $_W;
			load()->func('tpl');
			$uniacid = $_W['uniacid'];
			$length=15;
			$arr = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
			$str = '';
			$arr_len = count($arr);
			for ($i = 0; $i < $length; $i++)
			{
				$rand = mt_rand(0, $arr_len-1);
				$str.=$arr[$rand];
			}
			$qid=$_GPC['qid'];
			$user_openid = $_GPC['user_openid'];
			$item = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_question")." as a left join ".tablename("hyb_yl_zhuanjia")." as b on a.p_id=b.zid  where a.uniacid='{$uniacid}' and a.qid ='{$qid}' order by a.qid desc");
			$categorys = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_category') . "WHERE uniacid = :uniacid ", array(':uniacid' => $this->uniacid));
			$tree = $this->getTree($categorys, 0);

			if(checksubmit()){
				$fromuser1= $_GPC['info']['fromuser'];
				if(empty($fromuser1)){
					$fromuser1= random(32);
				}else{
					$fromuser1= $_GPC['info']['fromuser'];
				}
				if(empty($_GPC['q_dname'])){
					$q_dname =$_GPC['info']['link_name'];
				}else{
					$q_dname =$_GPC['q_dname'];
				}

				$data = array(
					"uniacid"=>$_W['uniacid'],
					"q_thumb"=>tomedia($_GPC['q_thumb']),
					"q_username"=>$_GPC['q_username'],
					"question"=>$_GPC['question'], 
					'q_docthumb'=>$_W['attachurl'].$_GPC['q_docthumb'],
					'q_zhiwei'=>$_GPC['q_zhiwei'],
					'q_dname'=>$q_dname,
					'q_category'=>$_GPC['q_category'],
					'q_type'=>0,
					'q_category'=>$_GPC['q_category'],
					'user_openid'=>$_GPC['user_openid'],
					'p_id'=>$_GPC['info']['zid'],
					'user_picture'=>serialize($_GPC['user_picture']),
					'if_over'=>$_GPC['if_over'],
					'gbmoney'=>$_GPC['gbmoney'],
					'q_time' =>date('Y-m-d H:i:s',time()),
					'fromuser'=>$fromuser1,
					'q_docthumb'=>$_GPC['info']['q_docthumb'],
					);
				if(empty($qid)){
					$pdo = pdo_insert("hyb_yl_question",$data);
					message("添加成功!",$this->createWebUrl("disease_wenti",array('op'=>'display')),"success");
				}else{
					$pdo = pdo_update("hyb_yl_question",$data,array('qid'=>$_GPC['qid'],'uniacid'=>$_W['uniacid']));
					message("修改成功!",$this->createWebUrl("disease_wenti",array('op'=>'display')),"success");
				}

			}
			include $this->template("diease_wentiback");
		}
		public function doWebDisease_wenti()
		{
			global $_GPC, $_W;
			load()->func('tpl');
			$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
			$uniacid = $_W['uniacid'];
			if ($op == "display") {
				$pindex = max(1, intval($_GPC['page']));
				$psize = 10;
				$count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_yl_question")." as a left join ".tablename("hyb_yl_zhuanjia")." as b on a.p_id=b.zid where a.uniacid=:uniacid and a.usertype=0 order by a.q_time desc ",array(":uniacid"=>$uniacid));
				$p = ($pindex - 1) * $psize;
				$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_question")." as a left join ".tablename("hyb_yl_zhuanjia")." as b on a.p_id=b.zid where a.uniacid=:uniacid  and a.usertype=0 order by a.q_time desc limit ".$p. ',' . $psize,array(":uniacid"=>$uniacid));
				$pager = pagination($count, $pindex, $psize);
			}
			$ptype = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_bingzheng_type")."where uniacid=:uniacid",array(":uniacid"=>$uniacid));
			$categorys = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_category') . "WHERE uniacid = :uniacid ", array(':uniacid' => $this->uniacid));

			$tree = $this->getTree($categorys, 0);
			if($op =="sendMsg"){
				$data['uniacid']=$_W['uniacid'];
				$data['question'] =$_GPC['content'];
				$data['parentid'] = $_GPC['parentid'];
				$data['q_dname'] = $_GPC['q_dname'];
				$data['q_thumb'] = $_GPC['q_thumb'];
				$data['fromuser'] = $_GPC['user_openid'];
				$data['usertype'] = 1;
				$data['q_username'] =$_GPC['q_username'];
				$data['user_openid'] = $_GPC['fromuser'];
				$data['q_zhiwei'] = $_GPC['q_zhiwei'];
				$data['q_docthumb'] = $_GPC['q_docthumb'];
				$data['p_id'] = $_GPC['p_id'];
				$data['q_time'] = date('Y-m-d H:i:s',time());
				$request = pdo_insert('hyb_yl_question',$data);
				pdo_update('hyb_yl_question',array('yuedu'=>1),array('qid'=>$_GPC['parentid'],'uniacid'=>$_W['uniacid']));
			}
			if ($op == "post") {
				$qid = $_GPC['qid'];

            $zids = $_GPC['p_id'];//医生ID
            $user_openid =$_GPC['user_openid'];
            $fromuser =$_GPC['fromuser'];
            //查询当前用户的所有问题
            $msgs=pdo_fetchall("SELECT * from".tablename("hyb_yl_question")."as a left join".tablename('hyb_yl_userinfo')."as b on a.user_openid=b.openid where a.uniacid ='{$uniacid}' and a.user_openid='{$user_openid}' and a.fromuser ='{$fromuser}' or (a.user_openid='{$fromuser}' and a.fromuser ='{$user_openid}') ");

            foreach ($msgs as &$value) {
            	$value['user_picture'] = unserialize($value['user_picture']);
            }


            $item = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_question")." as a left join ".tablename("hyb_yl_zhuanjia")." as b on a.p_id=b.zid left join".tablename('hyb_yl_overquestion')."as d on d.qid1 = a.qid where a.uniacid='{$uniacid}' and a.qid ='{$qid}' order by a.qid desc");
            

            if (checksubmit("submit")) {

            	$data = array(
            		"uniacid"=>$_W['uniacid'],
            		"q_thumb"=>tomedia($_GPC['q_thumb']),
            		"q_username"=>$_GPC['q_username'],
            		"question"=>$_GPC['question'], 
            		'q_docthumb'=>$_GPC['q_docthumb'],
            		'q_zhiwei'=>$_GPC['q_zhiwei'],
            		'q_dname'=>$_GPC['q_dname'],
            		'q_category'=>$_GPC['q_category'],
            		'q_type'=>0,
            		'p_id'=>$_GPC['info']['zid'],
            		'user_picture'=>serialize($_GPC['user_picture']),
            		'if_over'=>$_GPC['if_over'],
            		);
            	$res =pdo_get('hyb_yl_overquestion',array('uniacid'=>$uniacid,'useropenid'=>$_GPC['useropenid'],'zid'=>$_GPC['zid']));

            	if($_GPC['if_over'] ==1){
		             //公开到发现
            		$ovedata=array(
            			'uniacid'=>$uniacid,
            			'useropenid'=>$_GPC['useropenid'],
            			'zid'=>$_GPC['info']['zid'],
            			'money'=>$_GPC['money'],
            			'steta'=>$_GPC['if_over'],
            			'kid'=>$_GPC['q_category'],
            			'qid1'=>$_GPC['qid'],
            			);
            		if(empty($res)){
            			$inser = pdo_insert('hyb_yl_overquestion',$ovedata);
            		}else{
            			pdo_update('hyb_yl_overquestion',$ovedata,array('uniacid'=>$uniacid,'sid'=>$res['sid']));
            		}
            	}else{
            		$ovedata=array(
            			'uniacid'=>$uniacid,
            			'useropenid'=>$_GPC['useropenid'],
            			'zid'=>$_GPC['info']['zid'],
            			'money'=>$_GPC['money'],
            			'steta'=>$_GPC['if_over'],
            			'kid'=>$_GPC['q_category']
            			);
            		pdo_update('hyb_yl_overquestion',$ovedata,array('uniacid'=>$uniacid,'sid'=>$res['sid']));
            	}
            	if (empty($qid)) {
            		$pdo = pdo_insert("hyb_yl_question",$data);
            		message("添加成功!",$this->createWebUrl("disease_wenti"),"success");
            	}
            	else{
            		pdo_update("hyb_yl_question",$data,array("qid"=>$qid));
            		$data1['hd_question'] = $_GPC['value'];
            		$data1['z_name'] =$_GPC['z_name'];
            		$data1['z_thumbs'] =$_GPC['z_thumbs'];
            		$data1['z_zhiwu'] =$_GPC['z_zhiwu'];
            		$data1['form_time'] = date('Y-m-d H:i:s',time());
            		$member = pdo_fetch("select * from".tablename('hyb_yl_question')."where uniacid='{$uniacid}' and qid='{$qid}'");
            		if($member['hd_question'] == ''){
            			$arr = array();
            		}else{
            			$arr = unserialize($member['hd_question']);
            		}
            		array_push($arr,$data1);
            		$new_arr = serialize($arr);
            		$ret = pdo_update('hyb_yl_question',array('hd_question' =>$new_arr),array('qid'=>$qid,'uniacid'=>$uniacid));
            		message("更新成功!",$this->createWebUrl("disease_wenti"),"success");
            	}

            }
        }
        if ($op == "delete") {
        	$qid = $_GPC['qid'];
        	pdo_delete("hyb_yl_question",array("qid"=>$qid,"uniacid" => $uniacid));
        	message("删除成功!",$this->createWebUrl("disease_wenti"),"success");
        }
        if($op == "gongkai"){
        	$qid =$_GPC['qid'];
        	$sj_type =$_GPC['sj_type'];

        	$sj =array(
        		'sj_type'=>$sj_type
        		);
        	pdo_update("hyb_yl_question",$sj,array("qid"=>$qid));
        	message("状态修改成功!",$this->createWebUrl("disease_wenti"),"success");
        }
        if(!empty($_GPC['deleteall']))
        {

        	for($i=0;$i<count($_GPC['deleteall']);$i++)
        	{
        		pdo_delete('hyb_yl_question', array('qid' =>$_GPC['deleteall'][$i]));
        	}
        	message('删除成功!', $this -> createWeburl('disease_wenti', array('op' => 'display')), 'success');

        }
        include $this->template("diease_wenti");
    }

    public function doWebTijian()
    {
    	global $_GPC, $_W;
    	load()->func('tpl');
    	$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
    	$uniacid = $_W['uniacid'];
    	if ($op == "display") {
    		$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_tijian_yuyue")." WHERE uniacid=:uniacid",array(":uniacid"=>$uniacid));
    	}
    	if ($op == "delete") {
    		$tjyy_id = $_GPC['tjyy_id'];
    		pdo_delete("hyb_yl_tijian_yuyue",array("tjyy_id"=>$tjyy_id));
    		message("删除成功!",$this->createWebUrl("tijian"),"success");

    	}
    	include $this->template("tijian");
    }


    public function doWebTijian_yiyuan ()
    {
    	global $_GPC, $_W;
    	load()->func('tpl');
    	$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
    	$uniacid = $_W['uniacid'];
    	if ($op == "display") {
    		$items = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_tijian_yiyuan")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
    	}
    	if ($op == "post") {
    		$id = $_GPC['ty_id'];
    		$item = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_tijian_yiyuan")." where uniacid=:uniacid and ty_id=:ty_id",array(":uniacid"=>$uniacid,":ty_id"=>$id));
    		if (checksubmit("submit")) {
    			$data = array("uniacid"=>$uniacid,"ty_name"=>$_GPC['ty_name'],"ty_thumb"=>$_GPC['ty_thumb'],"ty_dengji"=>$_GPC['ty_dengji'],"ty_address"=>$_GPC['ty_address'],"longitude"=>$_GPC['longitude'],"latitude"=>$_GPC['latitude'],'ifzz'=>$_GPC['ifzz']);
    			if (empty($id)) {
    				pdo_insert("hyb_yl_tijian_yiyuan",$data);
    				message("添加成功!",$this->createWebUrl("tijian_yiyuan"),"success");
    			}
    			else
    			{
    				pdo_update("hyb_yl_tijian_yiyuan",$data,array("ty_id"=>$id));
    				message("修改成功!",$this->createWebUrl("tijian_yiyuan"),"success");
    			}
    		}
    	}
    	if ($op == "delete") {
    		$id = $_GPC['ty_id'];
    		pdo_delete("hyb_yl_tijian_yiyuan",array("ty_id"=>$id));
    		message("删除成功!",$this->createWebUrl("tijian_yiyuan"),"success");	
    	}
    	include $this->template("tijian_yiyuan");
    }

    public function doWebTijian_taocan()
    {
    	global $_GPC, $_W;
    	load()->func('tpl');
    	$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
    	$uniacid = $_W['uniacid'];
    	if ($op == "display") {
    		$items = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_tijian_taocan")." as tt left join ".tablename("hyb_yl_tijian_yiyuan")." as ty on tt.tt_yiyuan=ty.ty_id left join ".tablename("hyb_yl_tijian_taocan_type")." as ttt on tt.tt_type=ttt.tjt_id   where tt.uniacid=:uniacid order by tt.tt_id asc",array(":uniacid"=>$uniacid));
    	}
    	if ($op == "post") {
			//查询体检医院
    		$tijian_yiyuan = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_tijian_yiyuan")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
			//查询套餐分类
    		$taocan_type = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_tijian_taocan_type")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
    		$tt_id = $_GPC['tt_id'];
    		$items = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_tijian_taocan")." as tt left join ".tablename("hyb_yl_tijian_yiyuan")." as ty on tt.tt_yiyuan=ty.ty_id left join ".tablename("hyb_yl_tijian_taocan_type")." as ttt on tt.tt_type=ttt.tjt_id where tt.uniacid=:uniacid and tt.tt_id=:tt_id",array(":uniacid"=>$uniacid,":tt_id"=>$tt_id));
    		if (checksubmit("submit")) {
    			$data = array("uniacid"=>$uniacid,"tt_yiyuan"=>$_GPC['tt_yiyuan'],"tt_name"=>$_GPC['tt_name'],"tt_type"=>$_GPC['tt_type'],"tt_num"=>$_GPC['tt_num'],"tt_tongzhi"=>$_GPC['tt_tongzhi'],"tt_money"=>$_GPC['tt_money']);
    			if (empty($tt_id)) {
    				pdo_insert("hyb_yl_tijian_taocan",$data);
    				message("添加成功!",$this->createWebUrl("tijian_taocan"),"success");
    			}
    			else
    			{
    				pdo_update("hyb_yl_tijian_taocan",$data,array("tt_id"=>$tt_id));
    				message("修改成功!",$this->createWebUrl("tijian_taocan"),"success");
    			}
    		}
    	}
    	if($op == "delete")
    	{
    		$tt_id = $_GPC['tt_id'];
    		pdo_delete("hyb_yl_tijian_taocan",array("tt_id"=>$tt_id));
    		message("删除成功!",$this->createWebUrl("tijian_taocan"),"success");
    	}
    	include $this->template("tijian_taocan");
    }


    public function doWebTijian_taocan_xiangmu()
    {
    	global $_GPC, $_W;
    	load()->func('tpl');
    	$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
    	$uniacid = $_W['uniacid'];
    	if ($op == "display") {
    		$items = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_tijian_taocan_xiangmu")." as tx left join ".tablename("hyb_yl_tijian_taocan")." as tt on tx.tm_taocanname=tt.tt_id where tx.uniacid=:uniacid ",array(":uniacid"=>$uniacid));
    	}
    	if ($op == "post") {
			//查询套餐名称
    		$taocan = pdo_fetchall("SELECT tt_id,tt_name FROM ".tablename("hyb_yl_tijian_taocan")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
    		$tm_id = $_GPC['tm_id'];
    		$items = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_tijian_taocan_xiangmu")." as tx left join ".tablename("hyb_yl_tijian_taocan")." as tt on tx.tm_taocanname=tt.tt_id where tx.uniacid=:uniacid AND tx.tm_id=:tm_id",array(":uniacid"=>$uniacid,":tm_id"=>$tm_id));
    		if (checksubmit("submit")) {
    			$data = array("uniacid"=>$uniacid,"tm_taocanname"=>$_GPC['tm_taocanname'],"tm_name"=>$_GPC['tm_name'],"tm_miaoshu"=>$_GPC['tm_miaoshu']);
    			if (empty($tm_id)) {
    				pdo_insert("hyb_yl_tijian_taocan_xiangmu",$data);
    				message("添加成功!",$this->createWebUrl("tijian_taocan_xiangmu"),"success");
    			}
    			else{
    				pdo_update("hyb_yl_tijian_taocan_xiangmu",$data,array("tm_id"=>$tm_id));
    				message("修改成功!",$this->createWebUrl("tijian_taocan_xiangmu"),"success");
    			}
    		}
    	}
    	if($op == "delete")
    	{
    		$tm_id = $_GPC['tm_id'];
    		pdo_delete("hyb_yl_tijian_taocan_xiangmu",array("tm_id"=>$tm_id));
    		message("删除成功!",$this->createWebUrl("tijian_taocan_xiangmu"),"success");
    	}
    	include $this->template("tijian_taocan_xiangmu");
    }

    public function doWebTijian_taocantype ()
    {
    	global $_GPC, $_W;
    	load()->func('tpl');
    	$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
    	$uniacid = $_W['uniacid'];
    	if($op == "display")
    	{
    		$items = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_tijian_taocan_type")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
    	}
    	if ($op == "post") {
    		$tjt_id = $_GPC['tjt_id'];
    		$item = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_tijian_taocan_type")." where uniacid=:uniacid and tjt_id=:tjt_id",array(":uniacid"=>$uniacid,":tjt_id"=>$tjt_id));
    		if (checksubmit("submit")) {
    			$data = array("uniacid"=>$uniacid,"type"=>$_GPC['type'],"type_thumb"=>$_GPC['type_thumb'],"type_shijian"=>$_GPC['type_shijian']);
    			if (empty($tjt_id)) {
    				pdo_insert("hyb_yl_tijian_taocan_type",$data);
    				message("添加成功!",$this->createWebUrl("tijian_taocantype"),"success");
    			}
    			else
    			{
    				pdo_update("hyb_yl_tijian_taocan_type",$data,array("tjt_id"=>$tjt_id));
    				message("修改成功!",$this->createWebUrl("tijian_taocantype"),"success");
    			}
    		}
    	}
    	if ($op == "delete") {
    		$tjt_id = $_GPC['tjt_id'];
    		pdo_delete("hyb_yl_tijian_taocan_type",array("tjt_id"=>$tjt_id));
    		message("删除成功!",$this->createWebUrl("tijian_taocantype"),"success");
    	}
    	include $this->template("tijian_taocantype");
    }


//体检报告添加
    public function doWebTijianbaogao()
    {
    	global $_GPC, $_W;
    	load()->func('tpl');
    	$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
    	$uniacid = $_W['uniacid'];

    	if ($op == "display") {
    		$items = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_tijianbaogao")."where uniacid=:uniacid order by t_id asc",array(":uniacid"=>$uniacid));

    	}
    	if ($op == "post") {
			//查询体检医院
    		$openid = $_GPC['openid'];
			//var_dump($openid);
    		$tijian_yiyuan = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_tijian_yiyuan")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
    		$t_id = $_GPC['t_id'];
    		$datas = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_tijianbaogao")." where t_id='{$t_id}'",array(":uniacid"=>$uniacid));

    		if (checksubmit("submit")) {
    			$t_id = $_GPC['t_id'];
    			$openid = $_GPC['openid'];
    			var_dump($openid);
    			$data = array(
    				"uniacid"=>$uniacid,
    				"tiyiyuan"=>$_GPC['tiyiyuan'],
    				"thumbarr"=>$_GPC['thumbarr'],
    				"openid" =>$openid,
    				"picfengm" =>$_GPC['picfengm'],
    				"timearr" =>date('Y-m-d H:i:s',time()),
    				);
    			if (empty($t_id)) {
    				pdo_insert("hyb_yl_tijianbaogao",$data);
    				message("添加成功!",$this->createWebUrl("tijianbaogao"),"success");
    			}
    			else
    			{
    				pdo_update("hyb_yl_tijianbaogao",$data,array("t_id"=>$t_id));
    				message("修改成功!",$this->createWebUrl("tijianbaogao"),"success");
    			}
    		}
    	}
    	if($op == "delete")
    	{
    		$t_id = $_GPC['t_id'];
    		pdo_delete("hyb_yl_tijianbaogao",array("t_id"=>$t_id));
    		message("删除成功!",$this->createWebUrl("tijianbaogao"),"success");
    	}
    	include $this->template("tijianbaogao");
    }

//检验报告

    public function doWebJianybaogao()
    {
    	global $_GPC, $_W;
    	load()->func('tpl');
    	$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
    	$op1 =$_GPC['op1'];
    	$uniacid = $_W['uniacid'];

    	if ($op == "display") {
    		$items = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_jianybaogao")."where uniacid=:uniacid order by j_id asc",array(":uniacid"=>$uniacid));
    	}
    	if ($op == "post") {
			//查询体检医院
    		$openid = $_GPC['openid'];
    		$tijian_yiyuan = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_tijian_yiyuan")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
    		$j_id = $_GPC['j_id'];
    		$datas = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_jianybaogao")." where j_id='{$j_id}'",array(":uniacid"=>$uniacid));
    		if (checksubmit("submit")) {
    			$j_id = $_GPC['j_id'];
    			$openid = $_GPC['openid'];
    			$data = array(
    				"uniacid"=>$uniacid,
    				"tiyiyuan"=>$_GPC['tiyiyuan'],
    				"thumbarr"=>$_GPC['thumbarr'],
    				"openid" =>$openid,
    				"picfengm" =>$_GPC['picfengm'],
    				"timearr" =>date('Y-m-d H:i:s',time()),
    				);
    			if (empty($j_id)) {
    				pdo_insert("hyb_yl_jianybaogao",$data);
    				message("添加成功!",$this->createWebUrl("jianybaogao"),"success");
    			}
    			else
    			{
    				pdo_update("hyb_yl_jianybaogao",$data,array("j_id"=>$j_id));
    				message("修改成功!",$this->createWebUrl("jianybaogao"),"success");
    			}
    		}
    	}
    	if($op == "delete")
    	{
    		$j_id = $_GPC['j_id'];
    		pdo_delete("hyb_yl_jianybaogao",array("j_id"=>$j_id));
    		message("删除成功!",$this->createWebUrl("jianybaogao"),"success");
    	}
    	include $this->template("jianybaogao");
    }

    public function doWebCategory(){
    	global $_GPC, $_W;
    	load()->func('tpl');
    	$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
    	$uniacid = $_W['uniacid'];
    	$keyword = $_GPC['keywords'];

    	if($op == "display")
    	{

    		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('hyb_yl_userinfo') . " WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
    		$pindex = max(1, intval($_GPC['page'])); 
    		$pagesize = 10;
    		$pager = pagination($total,$pindex,$pagesize);
    		$p = ($pindex-1) * $pagesize;
    		$category = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_userinfo")." where uniacid=:uniacid order by u_id asc limit ".$p.",".$pagesize , array(':uniacid' => $uniacid));

    		if(!empty($keyword)){
    			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('hyb_yl_userinfo') . " WHERE uniacid = :uniacid and u_name like '%{$keyword}%'", array(':uniacid' => $uniacid));
    			$pindex = max(1, intval($_GPC['page'])); 
    			$pagesize = 10;
    			$pager = pagination($total,$pindex,$pagesize);
    			$p = ($pindex-1) * $pagesize;
    			$category = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_userinfo")." where uniacid=:uniacid and u_name like '%{$keyword}%' order by u_id asc limit ".$p.",".$pagesize , array(':uniacid' => $uniacid));
    		}
    	}


    	if(checksubmit('u_id')){ 
    		$u_id = $_GPC['u_id'];
    		$uniacid = $_W['uniacid'];
    		$data = array('u_type'=>1);
    		foreach ($u_id as $key => $value) {
    			$query=pdo_update('hyb_yl_userinfo',$data,array('u_id'=>$value,'uniacid'=>$uniacid));
    		}
    		if($query){
    			message('开启成功', $this->createWebUrl('category'), 'success');
    		}
    	}
    	if(checksubmit('guanbi')){ 
    		$u_id = $_GPC['u_id'];
    		$uniacid = $_W['uniacid'];
    		$data = array('u_type'=>0);
    		foreach ($u_id as $key => $value) {
    			$query=pdo_update('hyb_yl_userinfo',$data,array('u_id'=>$value,'uniacid'=>$uniacid));
    		}
    		if($query){
    			message('关闭成功', $this->createWebUrl('category'), 'success');
    			foreach ($u_id as $key => $v) {
    				$select = pdo_fetch('SELECT * FROM'.tablename('hyb_yl_userinfo')."WHERE u_id = {$v} and uniacid = '{$uniacid}'");

    			}

    		}

    	}
    	if($op =='delete'){ 
    		$u_id = $_GPC['u_id'];
    		$res = pdo_delete('hyb_yl_userinfo',array('uniacid'=>$uniacid,'u_id'=>$u_id));
    		message('删除成功', $this->createWebUrl('category'), 'success');
    	}	   
    	include $this->template("category");
    }

		//用户管理
    public function doWebUser(){
    	global $_W,$_GPC;
    	$uniacid=$_W['uniacid'];
    	load()->func('tpl');
    	if (checksubmit('submit')) {
    		$op = $_GPC['keywords'];
    		$where = "%{$op}%";
    	} else {
    		$where = '%%';
    	}
    	$keyword = $_GPC['keywords'];
    	if(empty($keyword)){
    		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('hyb_yl_userinfo') . " WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
    		$pindex = max(1, intval($_GPC['page'])); 
    		$pagesize = 10;
    		$pager = pagination($total,$pindex,$pagesize);
    		$p = ($pindex-1) * $pagesize;
    		$rowss = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_userinfo")." where uniacid=:uniacid order by u_id asc limit ".$p.",".$pagesize , array(':uniacid' => $uniacid));
    	}else{
    		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('hyb_yl_userinfo') . " WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
    		$total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_ylmz_userinfo")." where uniacid=:uniacid and u_name like '%{$keyword}%' ",array(":uniacid"=>$uniacid));
    		$pindex = max(1, intval($_GPC['page'])); 
    		$pagesize = 10;
    		$pager = pagination($total,$pindex,$pagesize);
    		$p = ($pindex-1) * $pagesize;
    		$rowss = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_userinfo")." where uniacid=:uniacid and u_name like '%{$keyword}%' order by u_id asc limit ".$p.",".$pagesize , array(':uniacid' => $uniacid));
    	}

    	include $this->template('user');
    }

	//提现管理
    public function doWebJsfl()
    {
    	global $_W, $_GPC;
    	load()->func('tpl');
    	$uniacid = $_W['uniacid'];
    	if (checksubmit('submit')) {
    		$op = $_GPC['keywords'];
    		$where = "%{$op}%";
    	} else {
    		$where = '%%';
    	}

    	$type = isset($_GPC['type']) ? $_GPC['type'] : 'all';

    	if ($type == 'all') {
    		if (checksubmit('submit2')) {
		    $start = empty($_GPC['time']['start']) ? strtotime('-1 month') : strtotime($_GPC['time']['start']);
		    $end = empty($_GPC['time']['end']) ? TIMESTAMP : strtotime($_GPC['time']['end']) + 86399;
			$where1 .= "AND a.cerated_time >= '{$start}' AND a.cerated_time <= '{$end}'";
	    	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('hyb_yl_yltx') . 'as a left join ' . tablename('hyb_yl_userinfo')."as b on b.openid=a.user_openid WHERE a.uniacid = :uniacid  $where1 ", array(':uniacid' => $_W['uniacid']));
			$pindex = max(1, intval($_GPC['page'])); 
			$pagesize = 10;
			$pager = pagination($total,$pindex,$pagesize);
			$p = ($pindex-1) * $pagesize; 
	        $list = pdo_fetchall('SELECT * FROM'. tablename('hyb_yl_yltx') . 'as a left join ' . tablename('hyb_yl_userinfo')."as b on b.openid=a.user_openid WHERE a.uniacid = '{$uniacid}'  $where1 ORDER BY a.id DESC limit ".$p.",".$pagesize);

    			   foreach ($list as &$value) {

            	     $value['cerated_time']=date('Y-m-d H:i:s',$value['cerated_time']);
                  }

    		} else {
    			if (checksubmit('submit')) {
    				$list = pdo_fetchall('select a.*,b.u_name from ' . tablename('hyb_yl_yltx') . ' a' . ' left join ' . tablename('hyb_yl_userinfo') . ' b on b.openid=a.user_openid WHERE  a.account LIKE :account || b.u_name LIKE :name and a.uniacid=:uniacid ORDER BY a.id DESC limit '.$p.",".$pagesize, array(':account' => $where, ':name' => $where, ':uniacid' => $_W['uniacid']));
    				    foreach ($list as &$value) {
            	     $value['cerated_time']=date('Y-m-d H:i:s',$value['cerated_time']);
            	     
                  }
    			} else {
			    	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('hyb_yl_yltx') . ' a' . ' left join ' . tablename('hyb_yl_userinfo') . ' b on b.openid=a.user_openid  WHERE a.uniacid=:uniacid ORDER BY a.id DESC', array(':uniacid' => $_W['uniacid']));
					$pindex = max(1, intval($_GPC['page'])); 
					$pagesize = 10;
					$pager = pagination($total,$pindex,$pagesize);
					$p = ($pindex-1) * $pagesize;
    				$list = pdo_fetchall('select a.*,b.u_name from ' . tablename('hyb_yl_yltx') . ' a' . ' left join ' . tablename('hyb_yl_userinfo') . ' b on b.openid=a.user_openid  WHERE a.uniacid=:uniacid ORDER BY a.id DESC limit '.$p.",".$pagesize, array(':uniacid' => $_W['uniacid']));
    				   foreach ($list as &$value) {
            	     $value['cerated_time']=date('Y-m-d H:i:s',$value['cerated_time']);
                  }
    			}
    		}
    	} else {
    		if ($type == 'wait') {
    			$list = pdo_fetchall('select a.*,b.u_name from ' . tablename('hyb_yl_yltx') . ' a' . ' left join ' . tablename('hyb_yl_userinfo') . ' b on b.openid=a.user_openid  WHERE a.uniacid= :uniacid and a.status=:state ORDER BY a.id DESC', array(':uniacid' => $_W['uniacid'], ':state' => 1));
    			    			   foreach ($list as &$value) {
            	     $value['cerated_time']=date('Y-m-d H:i:s',$value['cerated_time']);
                  }
    		} else {
    			if ($type == 'ok') {
    				$list = pdo_fetchall('select a.*,b.u_name from ' . tablename('hyb_yl_yltx') . ' a' . ' left join ' . tablename('hyb_yl_userinfo') . ' b on b.openid=a.user_openid WHERE a.uniacid =:uniacid and a.status=:state ORDER BY a.id DESC', array(':uniacid' => $_W['uniacid'], ':state' => 2));
    				    foreach ($list as &$value) {
            	     $value['cerated_time']=date('Y-m-d H:i:s',$value['cerated_time']);
                  }
    			} else {
    				if ($type == 'no') {
    					 $list = pdo_fetchall('select a.*,b.u_name from ' . tablename('hyb_yl_yltx') . ' a' . ' left join ' . tablename('hyb_yl_userinfo') . ' b on b.openid=a.user_openid  WHERE a.uniacid = :uniacid and a.status=:state ORDER BY a.id DESC', array(':uniacid' => $_W['uniacid'], ':state' => 3));
    					 foreach ($list as &$value) {
            	         $value['cerated_time']=date('Y-m-d H:i:s',$value['cerated_time']);
                       }
    				}
    			}
    		}
    	}
    	include $this->template('jsfl');
    }
   //拒绝
    public function doWebRejt()
    {
    	global $_W, $_GPC;
    	load()->func('tpl');
    	$id = $_GPC['id'];
    	$zjid =$_GPC['zjid'];
    	$uniacid =$_W['uniacid'];
    	$result = pdo_update('hyb_yl_yltx', array('status' => 3), array('id' => $id));
    	$res =pdo_get('hyb_yl_zhuanjia',array('zid'=>$zjid));
    	$data =array(
             'overmoney'=>($res['overmoney']+$_GPC['tx_cost'])
    		);
    	pdo_update('hyb_yl_zhuanjia',$data,array('zid'=>$zjid,'uniacid'=>$uniacid));
        message('拒绝成功', $this->createWebUrl('jsfl', array()), 'success');
    }
	//重新通过
    public function doWebConfirm()
    {
    	global $_W, $_GPC;
    	include 'wxtx.php';
    	load()->func('tpl');
    	$uniacid = $_W['uniacid'];
    	$id = $_GPC['id'];
    	$zjid =$_GPC['zjid'];
    	if($_GPC['tx_type'] ==1){
           //更新状态
             $result = pdo_update('hyb_yl_yltx', array('status' => 2), array('id' => $id));
            //清除专家收益
             $uoinfo = array(
             	 'overmoney'=>'0',
                 'scover_time'=>date('Y-m-d H:i:s',time())
             	);
             pdo_update('hyb_yl_zhuanjia',$uoinfo,array('zid'=>$zjid,'uniacid'=>$uniacid));
             message('结算成功', $this->createWebUrl('jsfl', array()), 'success');
    	}else{
		  	$user_openid = $_GPC['user_openid'];
			$tx_cost = intval($_GPC['sj_cost'] * 100);
			$u_name = $_GPC['u_name'];
			$key = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_parameter")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
				$appid = $key['appid'];   //微信公众平台的appid
				$mch_id = $key['mch_id'];  //商户号id
				$openid = $user_openid;    //用户openid
				$amount = $tx_cost;  //提现金额$money_sj
				$desc = "提现";     //企业付款描述信息
				$appkey = $key['appkey'];   //商户号支付密钥
				$re_user_name = $u_name;   //收款用户姓名
				$Weixintx = new WeixinTx($appid,$mch_id,$openid,$amount,$desc,$appkey,$re_user_name);
				$notify_url = $Weixintx->Wxtx();
				if($notify_url['return_code']=="SUCCESS" && $notify_url['result_code']=="SUCCESS"){
					$result = pdo_update('hyb_yl_yltx', array('status' => 2), array('id' => $id));
					if ($result) {
						message('确认成功', $this->createWebUrl('jsfl', array()), 'success');
					} else {
						message('删除失败', '', 'error');
					}
				}else{
					message($notify_url['return_msg'], '', 'error');
				}
    	    }
  
		}
	//删除
		public function doWebDeltable()
		{
			global $_W, $_GPC;
			load()->func('tpl');
			$id = $_GPC['id'];
			$result = pdo_delete('hyb_yl_yltx', array('id' => $id));
			if ($result) {
				message('删除成功', $this->createWebUrl('jsfl', array()), 'success');
			} else {
				message('删除失败', '', 'error');
			}
		}
	//qiuniu
		//七牛云设置
		public function doWebQiniu ()
		{
			global $_GPC,$_W;
			$uniacid = $_W['uniacid'];
			load()->func("tpl");
			$op = !empty($_GPC['op'])?$_GPC['op']:"display";
			if($op == "display")
			{
				$settings = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_qiniu")." WHERE uniacid=:uniacid",array(":uniacid"=>$uniacid));
				if (checksubmit("submit")) {
					$data = array("uniacid"=>$uniacid,"qn_accesskey"=>$_GPC['qn_accesskey'],"qn_secretkey"=>$_GPC['qn_secretkey'],"qn_bucket"=>$_GPC['qn_bucket'],"qn_queuename"=>$_GPC['qn_queuename'],"qn_domain"=>$_GPC['qn_domain']);
					if (empty($settings['qn_id'])) {
						pdo_insert("hyb_yl_qiniu",$data);
						message("添加成功!",$this->createWebUrl("qiniu",array("op"=>"display")),"success");
					}
					else
					{
						pdo_update("hyb_yl_qiniu",$data,array("qn_id"=>$settings['qn_id']));
						message("修改成功!",$this->createWebUrl("qiniu",array("op"=>"display")),"success");
					}
				}
			}
			include $this->template("qiniu");
		}

		//活动分类添加
		public function doWebDcategory() {
			global $_GPC, $_W;
			$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
			$id = intval($_GPC['id']);

			if ($op == 'post') {
				$ck =$_GPC['ck'];

				if (!empty($id)) {
					$item = pdo_fetch("SELECT * FROM" . tablename('hyb_yl_category') . "WHERE id='{$id}'");
				}
				if ($_W['ispost']) {

					$data = array('uniacid' => $_W['uniacid'], 'name' => $_GPC['cname'], 'parentid' => $_GPC['parentid'], 'enabled' => $_GPC['enabled'] ? 1 : 0, 'icon' => $_GPC['icon'],'ksdesc' =>$_GPC['ksdesc']);
					if (empty($id)) {
						pdo_insert('hyb_yl_category', $data);
						message('添加成功', $this->createWebUrl('dcategory'), 'success');
					} else {
						pdo_update('hyb_yl_category', $data, array('id' => $id));
						message('更新成功', $this->createWebUrl('dcategory'), 'success');
					}
				}
			} elseif ($op == 'display') {
				$o = '';
				$parents = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_category') . " WHERE uniacid = '{$_W['uniacid']}' AND parentid = 0");
				foreach ($parents AS $parent) {
					$enable = intval($parent['enabled']) ? '<button class="btn btn-success btn-sm">是</button>' : '<button class="btn btn-danger btn-sm">否</button>';
					$o.= "<tr><td><input type=\"checkbox\" name=\"select[]\" value=\"{$parent['id']}\" /></td>";
					$o.= "<td>" . $parent['name'] . "</td>";
					$o.= "<td> —— </td>";
					$o.= "<td>" . $enable . "</td>";
					$o.= "<td><a href=" . $this->createWebUrl('dcategory', array('op' => 'post', 'id' => $parent['id'])) . " >编辑</a></td></tr>";
					$subcates = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_category') . " WHERE parentid = {$parent['id']}");

					foreach ($subcates AS $subcate) {
						$enable = intval($subcate['enabled']) ? '<button class="btn btn-success btn-sm">是</button>' : '<button class="btn btn-danger btn-sm">否</button>';
						$o.= "<tr><td><input type=\"checkbox\" name=\"select[]\" value=\"{$subcate['id']}\" /></td>";
						$o.= "<td>&nbsp;&nbsp;&nbsp;&nbsp;|——" . $subcate['name'] . "</td>";
						$o.= "<td>" . $parent['name'] . "</td>";
						$o.= "<td>" . $enable . "</td>";
						$o.= "<td><a href=" . $this->createWebUrl('dcategory', array('op' => 'post', 'id' => $subcate['id'])) . ">编辑</a></td></tr>";
						$parentncalss = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_category') . " WHERE parentid = {$subcate['id']}");
						foreach ($parentncalss AS $pcalss) {
							$enable = intval($pcalss['enabled']) ? '<button class="btn btn-success btn-sm">是</button>' : '<button class="btn btn-danger btn-sm">否</button>';
							$o.= "<tr><td><input type=\"checkbox\" name=\"select[]\" value=\"{$pcalss['id']}\" /></td>";
							$o.= "<td>&nbsp;&nbsp;&nbsp;&nbsp;|————————" . $pcalss['name'] . "</td>";
							$o.= "<td>" . $parent['name'] . "</td>";
							$o.= "<td>" . $enable . "</td>";
							$o.= "<td><a href=" . $this->createWebUrl('dcategory', array('op' => 'post', 'id' => $pcalss['id'])) . ">编辑</a></td></tr>";
						}
					}

				}
			}
			if (checksubmit('delete')) {
				pdo_delete('hyb_yl_category', " id  IN  ('" . implode(",", $_GPC['select']) . "')");
				message('删除成功', referer(), 'success');
			}
			$categorys = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_category') . "WHERE uniacid = :uniacid ", array(':uniacid' => $this->uniacid));

			$tree = $this->getTree($categorys, 0);
        //$this->procHtml($tree);

			include $this->template('dcategory');
		}
		private function getTree($data, $pId)
		{
			$tree = '';
			foreach($data as $k => $v)
			{

				if($v['parentid'] == $pId)
			 { //父亲找到儿子
			 	$v['parent'] =$this->getTree($data,$v['id']);
			 	$tree[] = $v;
			 //unset($data[$k]);
			 }
			}
			return $tree;
		}
	// private function procHtml($tree)

	// 	{
	// 		$html = '';
	// 		foreach($tree as $t)
	// 		{

	// 		 if($t['parentid'] == '')
	// 			 {	
	// 			   $html .= "<li>{$t['name']}</li>";  
	// 			 }
	// 			 else
	// 			 {
	// 				 $html .= "<li>".$t['name'];
	// 				 $html .= $this->procHtml($t['parent']);
	// 				 $html = $html."</li>";
	// 	        }
	// 	     }

	//   return $html ? '<ul>'.$html.'</ul>' : $html ;

	// }
		public function doWebKslist(){
			global $_GPC,$_W;
			$uniacid = $_W['uniacid'];
			load()->func("tpl");
			$categorys = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_category') . "WHERE uniacid = :uniacid AND parentid = 0", array(':uniacid' => $this->uniacid));
			include $this->template('kslist');

		}
		public function doWebCztime(){
			global $_GPC,$_W;
			$uniacid = $_W['uniacid'];
			load()->func("tpl");
			$z_room = $_GPC['id'];

			$parentid = $_GPC['parentid']['id'];

			$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_category")." as a left join ".tablename("hyb_yl_zhuanjia")." as b on a.id=b.z_room where a.uniacid=:uniacid and b.z_room = '{$z_room}'",array(":uniacid"=>$_W['uniacid']));

			include $this->template('cztime');

		}

		public function doWebTimesite(){
			global $_GPC,$_W;
			$uniacid = $_W['uniacid'];
			load()->func("tpl");
			$pp_id = $_GPC['zid'];
			$z_room = $_GPC['z_room'];
			$endtime=$_GPC['endTime'];
			$startime=$_GPC['startTime'];
			$time=$_GPC['endTime'].'-'.$startime;
			$d_id = $_GPC['d_id'];
			$select = pdo_fetch('SELECT * FROM '.tablename('hyb_yl_dozhuantime')."WHERE d_id='{$d_id}' and uniacid ='{$uniacid}'",array('uniacid' => $uniacid));
			$arr = explode('-', $select['startTime']);
			$endTime = $arr[0];
			$starTime = $arr[1];
			if(checksubmit("submit")){
				$data = array(
					'uniacid' =>$_W['uniacid'],
					'date'=>$_GPC['date'],
					'day'=>$_GPC['day'],
					'startTime' =>$time,
					'tijiatime' =>date('Y-m-d H:i:s',time()),
					'yyperson' =>$_GPC['yyperson'],
					'pp_id' => $pp_id
					);


				if($select){
					$datas = array(
						'uniacid' =>$_W['uniacid'],
						'date'=>$_GPC['date'],
						'day'=>$_GPC['day'],
						'startTime' =>$time,
						'tijiatime' =>date('Y-m-d H:i:s',time()),
						'yyperson' =>$_GPC['yyperson'],
						'pp_id' => $select['pp_id']

						);
					pdo_update('hyb_yl_dozhuantime',$datas,array('d_id'=>$d_id));
					message('更新成功',$this->createWebUrl('timesjduan',array('zid'=>$_GPC['zid'],'z_room'=>$_GPC['z_room'])), 'success');
				}else{
					pdo_insert('hyb_yl_dozhuantime',$data);
					message('添加成功', $this->createWebUrl('timesjduan',array('zid'=>$_GPC['zid'],'z_room'=>$_GPC['z_room'])), 'success');
				}
			}

			include $this->template('timesite');

		}
		public function doWebTimesjduan(){
			global $_GPC,$_W;
			$uniacid = $_W['uniacid'];
			$pp_id = $_GPC['zid'];
			$z_room = $_GPC['z_room'];

			$success = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_dozhuantime")." as a left join ".tablename("hyb_yl_zhuanjia")." as b on a.pp_id=b.zid where a.uniacid=:uniacid and a.pp_id = '{$pp_id}' ORDER BY CAST(`sort_id` AS DECIMAL) ",array(":uniacid"=>$_W['uniacid']));
			if(checksubmit("submit")){
				$d_id=$_GPC['d_id'];
				$sort_id = $_GPC['sort_id'];
				for($i=0;$i<count($d_id);$i++){
					$id = $d_id[$i];
					$sid = $sort_id[$i];
					$data= array(
						'sort_id'=>$sid
						);
					$update_sql=pdo_update('hyb_yl_dozhuantime',$data,array('d_id'=>$id,'uniacid'=>$uniacid));
				}
				message('排序成功', $this->createWebUrl('timesjduan',array('zid'=>$_GPC['zid'],'z_room'=>$_GPC['z_room'])), 'success');
			}
			if ($_GPC['op']) {
				$id = $_GPC['d_id'];
				pdo_delete('hyb_yl_dozhuantime', array('d_id' => $id));
				message('删除成功', referer(), 'success');
			}
			load()->func("tpl");
			include $this->template('timesjduan');

		}
    //查看科室二级分类
		public function doWebKserjifenl(){
			global $_GPC,$_W;
			$uniacid = $_W['uniacid'];
    	//var_dump($_GPC['id']);
			$parentid = $_GPC['id'];
			load()->func("tpl");
			$parenss = $_GPC['parentid']['id'];
			if(!empty($parenss)){
				$subcatessss = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_category') . " WHERE parentid = '{$parenss}' and uniacid = '{$uniacid}'");
        //var_dump($subcatessss);
			}
			$subcates = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_category') . " WHERE parentid = '{$parentid}' and uniacid = '{$uniacid}'");

			include $this->template('kserjifenl');

		}
		public function doWebGuhaosite(){
			global $_GPC,$_W;
			$uniacid = $_W['uniacid'];
			load()->func("tpl");
    	    $pp_id = $_GPC['zid'];//专家ID
            $z_room = $_GPC['z_room'];//科室ID
            $z_yy_money =$_GPC['z_yy_money'];//预约价格
            $op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
            $ifweek = pdo_fetch('SELECT * from '.tablename('hyb_yl_guatime')."where zid ='{$pp_id}' and uniacid ='{$uniacid}'");
            if($op =='display'){
        	$res = pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_guatime')."where uniacid ='{$uniacid}' and zid='{$pp_id}'");
        	$zjweek =unserialize($ifweek['week']);
        	$zjweek1 =unserialize($ifweek['week1']);
        	$zjweek2 =unserialize($ifweek['week2']);
        	$zjweek3 =unserialize($ifweek['week3']);
        	$zjweek4 =unserialize($ifweek['week4']);
        	$zjweek5 =unserialize($ifweek['week5']);
        	$zjweek6 =unserialize($ifweek['week6']);
        	if(checksubmit("submit")){
    		  //周一
        		$endtime =array_values(array_filter($_GPC['endtime'])) ;
        		$startime =array_values(array_filter($_GPC['startime']));
        		$num =array_values(array_filter($_GPC['num']));

        		// $endtime = $_GPC['endtime'];
        		// $startime =$_GPC['startime'];
        		// $num =$_GPC['num'];
        		foreach ($endtime as $key => $value) {
        			$data[$key]['endtime']=$endtime[$key];  
        			$data[$key]['startime']=$startime[$key];
        			$data[$key]['num']=$num[$key]; 
        			$data[$key]['index']=0; 
        		}
			 //周二
        		$endtime = array_values(array_filter($_GPC['erendtime']));
        		$startime =array_values(array_filter($_GPC['erstartime']));
        		$num =array_values(array_filter($_GPC['ernum']));

        		// $endtime = $_GPC['erendtime'];
        		// $startime =$_GPC['erstartime'];
        		// $num =$_GPC['ernum'];
        		foreach ($endtime as $key => $value) {
        			$data1[$key]['erendtime']=$endtime[$key];  
        			$data1[$key]['erstartime']=$startime[$key];
        			$data1[$key]['ernum']=$num[$key]; 
        			$data1[$key]['index']=1; 
        		}
            //周三
        		$endtime =array_values(array_filter($_GPC['sanendtime'])) ;
        		$startime =array_values(array_filter($_GPC['sanstartime']));
        		$num =array_values(array_filter($_GPC['sannum']));

         	// 	$endtime = $_GPC['sanendtime'];
        		// $startime =$_GPC['sanstartime'];
        		// $num =$_GPC['sannum'];       		
        		foreach ($endtime as $key => $value) {
        			$data2[$key]['sanendtime']=$endtime[$key];  
        			$data2[$key]['sanstartime']=$startime[$key];
        			$data2[$key]['sannum']=$num[$key];
        			$data2[$key]['index']=2; 
        		}
            //周四
        		$endtime =array_values(array_filter($_GPC['sistartime'])) ;
        		$startime =array_values(array_filter($_GPC['siendtime']));
        		$num =array_values(array_filter($_GPC['sinum']));

        		// $endtime = $_GPC['sistartime'];
        		// $startime =$_GPC['siendtime'];
        		// $num =$_GPC['sinum'];
        		foreach ($endtime as $key => $value) {	
        			$data3[$key]['sistartime']=$endtime[$key];  
        			$data3[$key]['siendtime']=$startime[$key];
        			$data3[$key]['sinum']=$num[$key];
        			$data3[$key]['index']=3;

        		}
        	
            //周五
        		$endtime =array_values(array_filter($_GPC['wustartime'])) ;
        		$startime =array_values(array_filter($_GPC['wuendtime'])) ;
        		$num =array_values(array_filter($_GPC['wunum']));

        		// $endtime = $_GPC['wustartime'];
        		// $startime =$_GPC['wuendtime'];
        		// $num =$_GPC['wunum'];
        		foreach ($endtime as $key => $value) {
        			$data4[$key]['wustartime']=$endtime[$key];  
        			$data4[$key]['wuendtime']=$startime[$key];
        			$data4[$key]['wunum']=$num[$key];
        			$data4[$key]['index']=4; 
        		} 
            //周六
        		$endtime = array_values(array_filter($_GPC['liustartime']));
        		$startime =array_values(array_filter($_GPC['liuendtime']));
        		$num =array_values(array_filter($_GPC['liunum']));

        		// $endtime = $_GPC['liustartime'];
        		// $startime =$_GPC['liuendtime'];
        		// $num =$_GPC['liunum'];        		
        		foreach ($endtime as $key => $value) {
        			$data5[$key]['liustartime']=$endtime[$key];  
        			$data5[$key]['liuendtime']=$startime[$key];
        			$data5[$key]['liunum']=$num[$key];
        			$data5[$key]['index']=5; 
        		}
            //周日
        		$endtime = array_values(array_filter($_GPC['ristartime']));
        		$startime =array_values(array_filter($_GPC['riendtime']));
        		$num =array_values(array_filter($_GPC['rinum']));

        		// $endtime = $_GPC['ristartime'];
        		// $startime =$_GPC['riendtime'];
        		// $num =$_GPC['rinum'];
        		foreach ($endtime as $key => $value) {
        			$data6[$key]['ristartime']=$endtime[$key];  
        			$data6[$key]['riendtime']=$startime[$key];
        			$data6[$key]['rinum']=$num[$key];
        			$data6[$key]['index']=6; 
        		}
        		
        		$week  = !empty($data)?serialize($data):'';
        		$week1 = !empty($data1)?serialize($data1):'';
        		$week2 = !empty($data2)?serialize($data2):'';
        		$week3 = !empty($data3)?serialize($data3):'';
        		$week4 = !empty($data4)?serialize($data4):'';
        		$week5 = !empty($data5)?serialize($data5):'';
        		$week6 = !empty($data6)?serialize($data6):'';
        		$zhuo=array(
        			'uniacid'=>$uniacid,
        			'z_yy_money'=>$z_yy_money,
        			'time'=>date('Y-m-d',time()),
        			'week'=>$week,
        			'week1'=>$week1,
        			'week2'=>$week2,
        			'week3'=>$week3,
        			'week4'=>$week4,
        			'week5'=>$week5,
        			'week6'=>$week6,
        			'zid'=>$pp_id
        			);

        		if(empty($ifweek)){
        			pdo_insert('hyb_yl_guatime',$zhuo);
        			message('添加成功', $this->createWebUrl('guhaosite', array('zid'=>$pp_id,"z_room"=>$z_room,'z_yy_money'=>$z_yy_money)), 'success');
        		}else{
        			$tid=$_GPC['tid'];

        			pdo_update('hyb_yl_guatime',$zhuo,array('tid'=>$tid));
        			message('更新成功', $this->createWebUrl('guhaosite', array('zid'=>$pp_id,"z_room"=>$z_room,'z_yy_money'=>$z_yy_money)), 'success');
        		}
        	} 

        }

        include $this->template('guhaosite');

    }
    public function doWebZjshouy(){
    	global $_GPC,$_W;
    	$uniacid = $_W['uniacid'];
    	load()->func("tpl");
    	$op =$_GPC['op'];
    	$z_name =$_GPC['z_name'];
        $scover_time =$_GPC['scover_time'];
    	$zid =$_GPC['zid'];
		$starttime = empty($_GPC['time']['start']) ? strtotime('-1 month') : strtotime($_GPC['time']['start']);
		$endtime = empty($_GPC['time']['end']) ? TIMESTAMP : strtotime($_GPC['time']['end']) + 86399;
		$where .= "AND times > '{$starttime}' AND times < '{$endtime}'";
    	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('hyb_yl_docshouyi') . " WHERE uniacid = :uniacid AND z_ids='{$zid}' AND type!=1 AND type!=5", array(':uniacid' => $uniacid));
		$pindex = max(1, intval($_GPC['page'])); 
		$pagesize = 10;
		$pager = pagination($total,$pindex,$pagesize);
		$p = ($pindex-1) * $pagesize; 
        $res = pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_docshouyi')."where uniacid ='{$uniacid}' AND z_ids='{$zid}' AND type!=1 AND type!=5  ORDER by sy_id desc limit ".$p.",".$pagesize);
        foreach ($res as &$value) {
        	$value['timess']=date("Y-m-d H:i:s",$value['times']); 
        }
        if(checksubmit('submit3')){
         $res = pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_docshouyi')."where uniacid ='{$uniacid}' AND z_ids='{$zid}' AND type!=1 AND type!=5 $where ORDER by sy_id desc limit ".$p.",".$pagesize);
         foreach ($res as $key => $value) {
         	$sy_id[] = $value['sy_id'];
          }
        }
        if($op =='down'){
        	if(!empty($_GPC['sy_id'])){
                 //查询匹配数据导出xls
        		$sy_id=$_GPC['sy_id'];
        		$innerdata=array();
	    		foreach ($sy_id as $key => $value) {
					$sql = "SELECT * FROM ".tablename("hyb_yl_docshouyi")."where uniacid = '{$uniacid}' AND sy_id='{$value}'";
	                $innerdata[] =pdo_fetch($sql);
	    		}
	    		$num = count($innerdata);
	    		//var_dump($innerdata);
	    		$filename=$_GPC['z_name'].'专家收益表'.date("Y-m-d H:i:s",time());
				header("Content-type:application/vnd.ms-excel");      
			    header("Content-Disposition:filename=".$filename.".xls");
				$strexport="序号\t时间\t项目\t金额\r"; 
	    		for ($i=0; $i <$num ; $i++) { 
		            $strexport.=$innerdata[$i]['sy_id']."\t"; 
		            $strexport.=date("Y-m-d H:i:s",$innerdata[$i]['times'])."\t";  
		            $strexport.=$innerdata[$i]['funame']."\t";  
		            $strexport.=$innerdata[$i]['symoney']."\r"; 
	    		}
			        $strexport=iconv('UTF-8',"GB2312//IGNORE",$strexport); 
				    exit($strexport);
        	}else{
                $zid =$_GPC['zid'];
        		$sy_id=pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_docshouyi')."where uniacid ='{$uniacid}' AND z_ids='{$zid}' AND type!=1 AND type!=5 $where ORDER by sy_id desc ");
        		
        		$innerdata=array();
	    		foreach ($sy_id as $key => $value) {
					$sql = "SELECT * FROM ".tablename("hyb_yl_docshouyi")."where uniacid = '{$uniacid}' AND sy_id='{$value['sy_id']}'";
	                $innerdata[] =pdo_fetch($sql);
	    		}
	    		$num = count($innerdata);
	    		//var_dump($innerdata);
	    		$filename=$_GPC['z_name'].'专家收益表'.date("Y-m-d H:i:s",time());
				header("Content-type:application/vnd.ms-excel");      
			    header("Content-Disposition:filename=".$filename.".xls");
				$strexport="序号\t时间\t项目\t金额\r"; 
	    		for ($i=0; $i <$num ; $i++) { 
		            $strexport.=$innerdata[$i]['sy_id']."\t"; 
		            $strexport.=date("Y-m-d H:i:s",$innerdata[$i]['times'])."\t";  
		            $strexport.=$innerdata[$i]['funame']."\t";  
		            $strexport.=$innerdata[$i]['symoney']."\r"; 
	    		}
			        $strexport=iconv('UTF-8',"GB2312//IGNORE",$strexport); 
				    exit($strexport);
        	}
        }
        foreach ($res as &$value) {
         $value['times']=date('Y-m-d H:i:s',time($value['times']));
        }
    	include $this->template('zjshouy');
    }
    public function doWebGuhaojl(){
    	global $_GPC,$_W;
    	$uniacid = $_W['uniacid'];
    	load()->func("tpl");
    	$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
    	$zid =$_GPC['zid'];
    	$pindex = max(1, intval($_GPC['page']));
    	$psize = 10;
    	if ($op == "display") {
    		$params = array();
    		$status = $_GPC['zy_zhenzhuang'];
    		$paystate = $_GPC['paystate'];
    		$keywords = $_GPC['keywords'];
    		$zy_telephone = $_GPC['zy_telephone'];
    		$starttime = empty($_GPC['time']['start']) ? strtotime('-1 month') : strtotime($_GPC['time']['start']);
    		$endtime = empty($_GPC['time']['end']) ? TIMESTAMP : strtotime($_GPC['time']['end']) + 86399;
    		$where .= "AND a.zy_time > '{$starttime}' AND a.zy_time < '{$endtime}'";
			//var_dump($starttime,$endtime);
    		if(!empty($keywords)){
    			$where .= "and (b.myphone like :myphone or b.myname like :myname)" ;
    			$params[':myphone'] = "%{$_GPC['keywords']}%";
    			$params[':myname'] = "%{$_GPC['keywords']}%";

    		}
    		if(!empty($zy_telephone)){
    			$where .= ' and (a.zy_telephone like :zy_telephone)';
    			$params[':zy_telephone'] = "%{$_GPC['zy_telephone']}%";
    		}
    		if ($status != '') {
    			if ($status == 2) {
    				$allstatus .= " and ( a.zy_zhenzhuang=2 )";
    			} elseif ($status == 0 && $paystate==1) {
    				$allstatus .= "and a.zy_zhenzhuang=0 and a.paystate=1";
    			}else{
    				$allstatus .= "and a.zy_zhenzhuang='{$status}'";
    			}
    		}
    		if ($paystate != '') {
    			$allstatus .= " and a.paystate='{$paystate}'";
    		}
    		$sql = "SELECT * FROM ".tablename("hyb_yl_zhuanjia_yuyue")." as a left join ".tablename("hyb_yl_myinfors")." as b on a.zy_name=b.my_id "."left join ".tablename("hyb_yl_userinfo")."as c on b.openid=c.openid "."left join ".tablename("hyb_yl_zhuanjia")."as d on a.z_name=d.zid where a.uniacid = '{$uniacid}' and a.z_name='{$zid}'  $where $allstatus ORDER BY a.zy_id  desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize;

    		$products = pdo_fetchall($sql, $params);
	         foreach ($products as $key => $value) {
	         	$zy_id[] = $value['zy_id'];

	          }
    		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename("hyb_yl_zhuanjia_yuyue")." as a left join ".tablename("hyb_yl_myinfors")." as b on a.zy_name=b.my_id "."left join ".tablename("hyb_yl_userinfo")."as c on b.openid=c.openid "."left join ".tablename("hyb_yl_zhuanjia")."as d on a.z_name=d.zid where a.uniacid = '{$uniacid}' and a.z_name='{$zid}'  $where ORDER BY a.zy_id ", $params);
    		$pager = pagination($total, $pindex, $psize);
    	}

    	if($op=='Confirmss'){
    		$zy_id = $_GPC['zy_id'];
    		$res = pdo_fetch('SELECT * FROM'.tablename('hyb_yl_zhuanjia_yuyue')."where uniacid ='{$uniacid}' and zy_id='{$zy_id}'");
    		if($res['remove'] =='0'){
    			message("无法核销，该订单已取消",$this->createWebUrl("guhaojl",array("op"=>"display",'zid'=>$zid )),"error");
    		}
    		$result = pdo_update('hyb_yl_zhuanjia_yuyue', array('zy_zhenzhuang' => 1), array('zy_id' => $zy_id));

    		if ($result) {
    			message('确定成功', $this->createWebUrl('guhaojl', array('zid'=>$zid,"op"=>"display")), 'success');
    		} else {
    			message('确定失败', '', 'error');
    		}
    	}
    	if($op =='jujue'){
    		$zy_id = $_GPC['zy_id'];
    		$res = pdo_fetch('SELECT * FROM'.tablename('hyb_yl_zhuanjia_yuyue')."where uniacid ='{$uniacid}' and zy_id='{$zy_id}'");
    		if($res['zy_zhenzhuang']=='1'){
    			message("无法拒绝，订单已核销",$this->createWebUrl("guhaojl",array("op"=>"display",'zid'=>$zid )),"error");
    		}else{
    			$result = pdo_update('hyb_yl_zhuanjia_yuyue', array('states' => 1), array('zy_id' => $zy_id,'uniacid'=>$uniacid));
    			message("已拒绝",$this->createWebUrl("guhaojl",array("op"=>"display",'zid'=>$zid )),"success");
    		}
    	}

    	if ($op == "delete") {
    		$id = $_GPC['zy_id'];
    		pdo_delete("hyb_yl_zhuanjia_yuyue",array("zy_id"=>$id,'uniacid'=>$uniacid));
    		message("删除成功!",$this->createWebUrl("teamyy",array("op"=>"display",'zid'=>$zid)),"success");
    	}
    	if(!empty($_GPC['deleteall']))
    	{
    		for($i=0;$i<count($_GPC['deleteall']);$i++)
    		{
    			pdo_delete('hyb_yl_zhuanjia_yuyue', array('zy_id' =>$_GPC['deleteall'][$i]));
    		}
    		message('删除成功!', $this -> createWeburl('guhaojl', array('op' => 'display','zid'=>$zid)), 'success');

    	}
    	if($op =='daochu'){


	    	if(!empty($_GPC['zy_id'])){
	         //查询id数据
	    		$zy_id =$_GPC['zy_id'];
	    		$innerdata=array();
	    		foreach ($zy_id as $key => $value) {
					$sql = "SELECT * FROM ".tablename("hyb_yl_zhuanjia_yuyue")." as a left join ".tablename("hyb_yl_myinfors")." as b on a.zy_name=b.my_id "."left join ".tablename("hyb_yl_userinfo")."as c on b.openid=c.openid "."left join ".tablename("hyb_yl_zhuanjia")."as d on a.z_name=d.zid where a.uniacid = '{$uniacid}' AND a.zy_id='{$value}'";
	                $innerdata[] =pdo_fetch($sql);
	    		}
	    		$num = count($innerdata);
	    		//var_dump($innerdata);
	    		$filename='患者预约列表'.time();
				header("Content-type:application/vnd.ms-excel");      
				header("Content-Disposition:filename=".$filename.".xls");
				$strexport="序号\t姓名\t昵称\t手机\t订单单号\t下单时间\t预约科室\t支付状态\t金额\t订单状态\r"; 
	    		for ($i=0; $i <$num ; $i++) { 
                    if($innerdata[$i]['paystate'] =='1'){
                        $count = '已支付';
                    }else{
                    	$count = '未支付';
                    }
                    if($innerdata[$i]['remove'] =='1'){
                        $count1 = '已完成';
                    }else{
                    	$count1 = '患者已取消';
                    }
		            $strexport.=$innerdata[$i]['zy_id']."\t"; 
		            $strexport.=$innerdata[$i]['myname']."\t";  
		            $strexport.=$innerdata[$i]['u_name']."\t";  
		            $strexport.=$innerdata[$i]['myphone']."\t";  
		            $strexport.=$innerdata[$i]['zy_telephone']."\t";  
		            $strexport.=date('Y-m-d H:i:s', $row['zy_time'])."\t";  
		            $strexport.=$innerdata[$i]['ksname']."\t";  
		            $strexport.=$count."\t"; 
		            $strexport.=$innerdata[$i]['zy_money']."\t";           
		            $strexport.=$count1."\r"; 
			        //echo json_encode($strexport);
			        
	    		}
			        $strexport=iconv('UTF-8',"GB2312//IGNORE",$strexport); 
				exit($strexport);

	    	}
    	}

    	include $this->template('guhaojl');
    }
    public function doWebSelffl() {
    	global $_GPC, $_W;
    	$uniacid =$_W['uniacid'];
    	$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
    	$id = intval($_GPC['id']);
    	$records=pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_zhuanjia")." WHERE uniacid='{$uniacid}' AND z_yy_sheng =1");
    	
    	if ($op == 'post') {
    		if (!empty($id)) {
    			$item = pdo_fetch("SELECT * FROM" . tablename('hyb_yl_selfhelp') . "WHERE id='{$id}'");
    			$item['zids'] =explode(',', $item['zids']);

    		}
    		if ($_W['ispost']) {
    			$zname =$_GPC['zname'];
    			$zids = $_GPC['zids'];
    			$zidsss = implode(',', $zids);
    			$data = array('uniacid' => $_W['uniacid'], 'name' => $_GPC['cname'], 'parentid' => $_GPC['parentid'], 'enabled' => $_GPC['enabled'] ? 1 : 0, 'icon' => $_GPC['icon'],'ksdesc' =>$_GPC['ksdesc'],'zids'=>$zidsss,'zname'=>$zname);
    			if (empty($id)) {
    				pdo_insert('hyb_yl_selfhelp', $data);
    				message('添加成功', $this->createWebUrl('selffl'), 'success');
    			} else {
    				pdo_update('hyb_yl_selfhelp', $data, array('id' => $id));
    				message('更新成功', $this->createWebUrl('selffl'), 'success');
    			}
    		}
    	} elseif ($op == 'display') {
    		$o = '';
    		$parents = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_selfhelp') . " WHERE uniacid = '{$_W['uniacid']}' AND parentid = 0");
    		foreach ($parents AS $parent) {
    			$enable = intval($parent['enabled']) ? '<button class="btn btn-success btn-sm">是</button>' : '<button class="btn btn-danger btn-sm">否</button>';
    			$o.= "<tr><td><input type=\"checkbox\" name=\"select[]\" value=\"{$parent['id']}\" /></td>";
    			$o.= "<td>" . $parent['name'] . "</td>";
    			$o.= "<td> —— </td>";
    			$o.= "<td>" . $enable . "</td>";
    			$o.= "<td><a href=" . $this->createWebUrl('selffl', array('op' => 'post', 'id' => $parent['id'])) . " >编辑</a><br><a href=" . $this->createWebUrl('fuwu', array('op' => 'display', 'id' => $parent['id'])) . " style='color:#428bca;'>服务</a></td><td><a  href=" . $this->createWebUrl('zzanl', array('op' => 'display', 'id' => $parent['id'])) . " style='color:#428bca;'>案例</a></td></tr>";
    			$subcates = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_selfhelp') . " WHERE parentid = {$parent['id']}");
    			foreach ($subcates AS $subcate) {
    				$enable = intval($subcate['enabled']) ? '<button class="btn btn-success btn-sm">是</button>' : '<button class="btn btn-danger btn-sm">否</button>';
    				$o.= "<tr><td><input type=\"checkbox\" name=\"select[]\" value=\"{$subcate['id']}\" /></td>";
    				$o.= "<td>&nbsp;&nbsp;&nbsp;&nbsp;|——" . $subcate['name'] . "</td>";
    				$o.= "<td>" . $parent['name'] . "</td>";
    				$o.= "<td>" . $enable . "</td>";
    				$o.= "<td><a href=" . $this->createWebUrl('selffl', array('op' => 'post', 'id' => $subcate['id'])) . ">编辑</a><br><a  href=" . $this->createWebUrl('fuwu', array('op' => 'display', 'id' => $subcate['id'])) . " style='color:#428bca;'>服务</a></td><td><a  href=" . $this->createWebUrl('zzanl', array('op' => 'display', 'id' => $subcate['id'])) . " style='color:#428bca;'>案例</a></td></tr>";
    			}
    		}
    	}
    	if (checksubmit('delete')) {
    		pdo_delete('hyb_yl_selfhelp', " id  IN  ('" . implode(",", $_GPC['select']) . "')");
    		message('删除成功', referer(), 'success');
    	}

    	$categorys = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_selfhelp') . "WHERE uniacid = :uniacid AND parentid = 0", array(':uniacid' => $this->uniacid));
    	include $this->template('selffl');
    }
    public function doWebFuirderlist(){
    	global $_W,$_GPC;
    	$uniacid = $_W['uniacid'];
    	load()->func("tpl");
    	$op= 'order';
    	$type = !empty($_GPC['type'])?$_GPC['type']:"display";
    	if($type =='display'){
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename('hyb_yl_usergoods')." AS a left join".tablename('hyb_yl_yzfuwu')."as b on b.f_id=a.types left join".tablename('hyb_yl_myinfors')."as c on c.openid=a.openid where a.uniacid='{$uniacid}'");
		$pindex = max(1, intval($_GPC['page'])); 
		$pagesize = 10;
		$pager = pagination($total,$pindex,$pagesize);
		$p = ($pindex-1) * $pagesize; 

	    $res = pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_usergoods')." AS a left join".tablename('hyb_yl_yzfuwu')."as b on b.f_id=a.types left join".tablename('hyb_yl_myinfors')."as c on c.openid=a.openid where a.uniacid='{$uniacid}' limit ".$p.",".$pagesize);
    	}
    	if($type == 'no'){
            $m_oid =$_GPC['m_oid'];
            $onedrder = pdo_fetch('SELECT * FROM'.tablename('hyb_yl_usergoods')." AS a left join".tablename('hyb_yl_yzfuwu')."as b on b.f_id=a.types left join".tablename('hyb_yl_myinfors')."as c on c.openid=a.openid where a.uniacid='{$uniacid}' AND  a.m_oid='{$m_oid}'");

    	}
    	if($type=='delete'){
    	$m_oid =$_GPC['m_oid'];
         pdo_delete('hyb_yl_usergoods',array('m_oid'=>$m_oid));
         message("删除成功!",$this->createWebUrl("fuirderlist",array("op"=>"display")),"success");
    	}
    	include $this->template('fuirderlist');
    }
    public function doWebFuwu(){
    	global $_W,$_GPC;
    	$uniacid = $_W['uniacid'];
    	$parid =$_GPC['id'];
    	load()->func("tpl");
    	$op = !empty($_GPC['op'])?$_GPC['op']:"display";
    	if($op=='display'){
    		$request =pdo_fetchall('SELECT * from'.tablename('hyb_yl_yzfuwu')."where uniacid ='{$uniacid}' and parid='{$parid}'");
    	}
    	if($op=='post'){
    		$f_id=$_GPC['f_id'];
    		$items =pdo_fetch('SELECT * FROM'.tablename('hyb_yl_yzfuwu')."where uniacid='{$uniacid}' and f_id='{$f_id}' and parid='{$parid}'");
    		$taocanm=unserialize($items['taocanm']);
    		$items['mor_thumb'] = unserialize($items['mor_thumb']);
    		if(checksubmit()){
    			$tcname=$_GPC['tcname'];
    			$tcmoney =$_GPC['tcmoney'];
    			foreach ($tcname as $key => $value) {
    				$tc[$key]['tcname']=$tcname[$key];
    				$tc[$key]['tcmoney']=$tcmoney[$key];
    			}
    			$data=array(
    				'uniacid'=>$_W['uniacid'],
    				'fname'=>$_GPC['fname'],
    				'futj'=>$_GPC['futj'],
    				'fthumb'=>$_GPC['fthumb'],
    				'biaoqian'=>$_GPC['biaoqian'],
    				'jieshao'=>$_GPC['jieshao'],
    				'taocanm'=>serialize($tc),
    				'parid'=>$parid,
    				'zmoney'=>$_GPC['zmoney'],
    				'mor_thumb'=>serialize($_GPC['mor_thumb'])
    				);

    			if(empty($f_id)){
    				pdo_insert('hyb_yl_yzfuwu',$data);
    				message("添加成功!",$this->createWebUrl("fuwu",array("op"=>"display",'id'=>$parid)),"success");
    			}else{
    				pdo_update('hyb_yl_yzfuwu',$data,array('uniacid'=>$uniacid,'f_id'=>$f_id));
    				message("修改成功!",$this->createWebUrl("fuwu",array("op"=>"post",'id'=>$parid,'f_id'=>$f_id)),"success");
    			}
    		}
    	}
    	if($op == 'delete'){
           $f_id=$_GPC['f_id'];
           pdo_delete('hyb_yl_yzfuwu',array('f_id'=>$f_id,'uniacid'=>$uniacid));
           message("删除成功!",$this->createWebUrl("fuwu",array("op"=>"display",'id'=>$parid)),"success");
    	}
    	include $this->template('yzfw');
    }
//骗审
    public function doWebPian()
    {
    	global $_W,$_GPC;
    	$uniacid = $_W['uniacid'];
    	load()->func("tpl");
    	$op = !empty($_GPC['op'])?$_GPC['op']:"display";
    	if ($op == "display") {
    		$items = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_pian")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
    	}
    	if ($op == "post") {
    		$id = $_GPC['id'];
    		$item = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_pian")." where uniacid=:uniacid and id=:id",array(":uniacid"=>$uniacid,":id"=>$id));
    		if (checksubmit("submit")) {
    			$data = array("uniacid"=>$uniacid,"title"=>$_GPC['title'],"content"=>$_GPC['content'],"thumb"=>$_GPC['thumb']);

    			if (empty($id)) {
    				pdo_insert("hyb_yl_pian",$data);
    				message("添加成功!",$this->createWebUrl("pian",array("op"=>"display")),"success");
    			}
    			else
    			{
    				pdo_update("hyb_yl_pian",$data,array("id"=>$id));
    				message("修改成功!",$this->createWebUrl("pian",array("op"=>"display")),"success");
    			}
    		}
    	}
    	if ($op == "delete") {
    		$id = $_GPC['id'];
    		pdo_delete("hyb_yl_pian",array("id"=>$id));
    		message("删除成功!",$this->createWebUrl("pian",array("op"=>"display")),"success");
    	}
    	include $this->template("pian");

    }

	//骗审导航设置
    public function doWebPian_daohang()
    {
    	global $_GPC,$_W;
    	$uniacid = $_W['uniacid'];
    	load()->func("tpl");
    	$op = !empty($_GPC['op'])?$_GPC['op']:"display";
    	if ($op == "display") {
    		$items = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_pian_daohang")." where uniacid=:uniacid",array(":uniacid"=>$uniacid));
    	} 
    	if ($op == "post") {
    		$id = $_GPC['id'];
    		$item = pdo_fetch("SELECT * FROM".tablename("hyb_yl_pian_daohang")." where uniacid=:uniacid and id=:id",array(":uniacid"=>$uniacid,":id"=>$id));
    		if (checksubmit("submit")) {
    			$data = array("uniacid"=>$uniacid,"title"=>$_GPC['title'],"thumb"=>$_GPC['thumb'],"appid"=>$_GPC['appid'],"lianjie"=>$_GPC['lianjie'],'text'=>$_GPC['text']);
    			if (empty($id)) {
    				pdo_insert("hyb_yl_pian_daohang",$data);
    				message("添加成功!",$this->createWebUrl("pian_daohang",array("op"=>"display")),"success");
    			}else{
    				pdo_update("hyb_yl_pian_daohang",$data,array("id"=>$id));
    				message("修改成功!",$this->createWeburl("pian_daohang",array("op"=>"display")),"success");
    			}
    		}
    	}
    	if ($op == "delete") {
    		$id = $_GPC['id'];
    		pdo_delete("hyb_yl_pian_daohang",array("id"=>$id));
    		message("删除成功!",$this->createWeburl("pian_daohang",array("op"=>"display")),"success");
    	}

    	include $this->template("pian_daohang");
    }
    public function doWebLipei(){
    	global $_GPC,$_W;
    	$uniacid = $_W['uniacid'];
    	load()->func("tpl");
    	$type = isset($_GPC['type']) ? $_GPC['type'] : 'all';

    	if($type =='all'){
    		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('hyb_yl_fwlxing') . " WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
    		$pindex = max(1, intval($_GPC['page'])); 
    		$pagesize = 10;
    		$pager = pagination($total,$pindex,$pagesize);
    		$p = ($pindex-1) * $pagesize; 
    		$res = pdo_fetchall("select * from ".tablename('hyb_yl_fwlxing')."where uniacid ='{$uniacid}' limit ".$p.",".$pagesize );
    	}

    	if($type == 'ok'){
    		$fid =$_GPC['fid'];
    		$info = pdo_get('hyb_yl_fwlxing',array('uniacid'=>$uniacid,'fid'=>$fid));
    		if(checksubmit('tijiao')){
    			$data=array(
    				'uniacid'=>$uniacid,
    				'fwname'=>$_GPC['fwname'],
    				);
    			if(empty($info)){
    				pdo_insert('hyb_yl_fwlxing',$data);
    				message('添加成功！',$this->createWebUrl("lipei",array('type'=>'all')),"success");
    			}else{
    				pdo_update('hyb_yl_fwlxing',$data,array('uniacid'=>$uniacid,'fid'=>$fid));
    				message('修改成功！',$this->createWebUrl("lipei",array('type'=>'all')),"success");
    			}
    		}

    	}
    	if($type == 'delete'){
    		$fid =$_GPC['fid'];
    		pdo_delete('hyb_yl_fwlxing',array('fid'=>$fid,'uniacid'=>$uniacid)); 
    		message('删除成功！',$this->createWebUrl("lipei",array('type'=>'all')),"success");
    	}
    	if ($type == 'no') {
    		$item = pdo_fetch("SELECT * FROM " . tablename('hyb_yl_goodsemail')." where uniacid=:uniacid",array(":uniacid"=>$_W['uniacid']));
    		if (checksubmit('submit1')) {
    			$data = array(
    				'uniacid' => $_W['uniacid'],
    				'mailhost'=> $_GPC['mailhost'],
    				'mailport'=> $_GPC['mailport'],
    				'mailhostname'=>$_GPC['mailhostname'],
    				'mailformname'=>$_GPC['mailformname'],
    				'mailusername'=>$_GPC['mailusername'],
    				'mailpassword'=>$_GPC['mailpassword'],
    				'mailsend'	=>$_GPC['mailsend']
    				);
    			if (empty($item['id'])) {
    				pdo_insert('hyb_yl_goodsemail', $data);
    				message('添加成功!', $this -> createWebUrl("lipei",array('type'=>'no')),"success");
    			} else {
    				pdo_update('hyb_yl_goodsemail', $data , array('id' => $item['id']));
    				message('修改成功!', $this -> createWebUrl("lipei",array('type'=>'no')),"success");
    			} 


    		} 
    	}
	    if($type =='kaiguan'){
	    	$res =pdo_get('hyb_yl_likaiguan',array('uniacid'=>$_W['uniacid']));
	    	$data =array(
                 'uniacid'=>$_W['uniacid'],
                 'liptype'=>$_GPC['liptype']
	    		);
	    	if(checksubmit('submit1')){

		    	if(!$res){
		           pdo_insert('hyb_yl_likaiguan',$data);
		           message('添加成功!', $this -> createWebUrl("lipei",array('type'=>'kaiguan')),"success");
		    	}else{
		    	   pdo_update('hyb_yl_likaiguan',$data,array('uniacid'=>$_W['uniacid']));
		    	   message('更新成功!', $this -> createWebUrl("lipei",array('type'=>'kaiguan')),"success");
		    	}
	    	}
	    }
    	include $this->template("lipei");

    }
    public function doWebLpgoods(){
    	global $_GPC,$_W;
    	$uniacid = $_W['uniacid'];
    	load()->func("tpl");
    	$type = isset($_GPC['type']) ? $_GPC['type'] : 'all';

    	if($type =='all'){
    		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM"  .tablename('hyb_yl_lipei')."as a left join".tablename('hyb_yl_fwlxing')."as b on b.fid = a.userTpye where a.uniacid ='{$uniacid}");
    		$pindex = max(1, intval($_GPC['page'])); 
    		$pagesize = 10;
    		$pager = pagination($total,$pindex,$pagesize);
    		$p = ($pindex-1) * $pagesize; 
    		$res = pdo_fetchall("select * from ".tablename('hyb_yl_lipei')."as a left join".tablename('hyb_yl_fwlxing')."as b on b.fid = a.userTpye where a.uniacid ='{$uniacid}' limit ".$p.",".$pagesize );
    	}
    	if($type =='no'){
    		$lpid = $_GPC['lpid'];
    		$info = pdo_fetch("SELECT * from".tablename('hyb_yl_lipei')."as a left join".tablename('hyb_yl_fwlxing')."as b on b.fid = a.userTpye where a.uniacid ='{$uniacid}' and lpid='{$lpid}'");
    		$fw =pdo_fetchall('SELECT * from '.tablename('hyb_yl_fwlxing')."where uniacid='{$uniacid}'");
    		if(checksubmit()){
    			$data = array(
    				'uerName'=>$_GPC['uerName'],
    				'sex'=>$_GPC['sex'],
    				'uerAge'=>$_GPC['uerAge'],
    				'uerPhone'=>$_GPC['uerPhone'],
    				'userpic'=>serialize($_GPC['userpic']),
    				'uerinfor'=>$_GPC['uerinfor'],
    				'userHospital'=>$_GPC['userHospital'],
    				'usershoushu'=>$_GPC['usershoushu'],
    				'date1'=>$_GPC['activityTime']['start'],
    				'date'=>$_GPC['activityTime']['end'],
    				'userMoney'=>$_GPC['userMoney'],
    				'userTpye'=>$_GPC['userTpye']
					// 'sex'=>$_GPC['sex'],
					// 'uerName'=>$_GPC['uerName'],
					// 'sex'=>$_GPC['sex'],
    				);
    			if(!empty($lpid)){
    				pdo_update('hyb_yl_lipei',$data,array("lpid"=>$lpid,'uniacid'=>$uniacid));
    				message("更新成功!",$this->createWebUrl("lpgoods",array("op"=>"display")),"success");
    			}
    		}
    	}
    	if($_GPC['type'] =='delete'){
    		$lpid = $_GPC['lpid'];
    		pdo_delete("hyb_yl_lipei",array("lpid"=>$lpid,'uniacid'=>$uniacid));
    		message("删除成功!",$this->createWebUrl("lpgoods",array("op"=>"display")),"success");
    	}
    	include $this->template("lpgoods");
    }
    public function doWebActivity(){
    	global $_GPC,$_W;
    	$uniacid = $_W['uniacid'];
    	load()->func("tpl");
    	$ops = array('option', 'form', 'formitem', 'spec', 'specitem');
    	$op = $_GPC['op'];
    	$op = in_array($op, $ops) ? $op : 'option';
    	if ($op == 'option') {
    		$tag = random(32);
    		include $this->template('activity/option');
    	}
    	if ($op == 'form') {
    		$type = $_GPC['type'];

    		$form_type = trim($_GPC['form_type']);
    		switch ($form_type)
    		{
    			case '0': $placeholder = '输入单选标题'; break;
    			case '1': $placeholder = '输入多选标题'; break;
    			case '2': $placeholder = '输入下拉选框标题';break;
    			case '3': $placeholder = '输入单行文本标题';break;
    			case '4': $placeholder = '输入多行文本标题';break;
    			case '5': $placeholder = '输入单图上传标题';break;
    			case '6': $placeholder = '输入多图上传标题';break;
    			case '7': $placeholder = '输入日期标题';break;
    			default: $placeholder = '输入'.$_GPC['title'].'标题';
    		}
    		$form = array(
    			"id" => $type=='sys'?$form_type:random(32),
    			$form_lowStandard = 
    			"title" => $type=='sys'?$_GPC['title']:'',
    			"fieldstype" => $type=='sys'?$form_type:'',
    			"displaytype" => $type=='diy'?$form_type:'',
    			"placeholder" => $placeholder,
    			"lowStandard"=>$type=='sys'?$_GPC['lowStandard']:'',
    			"highStandard"=>$type=='sys'?$_GPC['highStandard']:'',
    			);

    		include $this->template('activity/form');
    	}

    	if ($op == 'formitem') {
    		$form = array(
    			"id" => $_GPC['formid']
    			);
    		$formitem = array(
    			"id" => random(32),
    			"title" => $_GPC['title'],
    			"show" => 1,
    			"placeholder" => $_GPC['placeholder']
    			);
    		include $this->template('activity/form_item');
    	}

    	if ($op == 'spec') {
    		$spec = array(
    			"id" => random(32),
    			"title" => $_GPC['title']
    			);
    		include $this->template('activity/spec');
    	}

    	if ($op == 'specitem') {
    		$spec = array(
    			"id" => $_GPC['specid']
    			);
    		$specitem = array(
    			"id" => random(32),
    			"title" => $_GPC['title'],
    			"show" => 1
    			);
    		include $this->template('activity/spec_item');
    	}

    }
	//建档
    public function doWebDocjiand1(){
    	global $_GPC, $_W;
    	load()->func("tpl");
    	$op = isset($_GPC['op']) ? $_GPC['op'] : 'display';
    	if($op =='display'){
    		$o = '';
    		$parents = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_jdcategory') . " WHERE uniacid = '{$_W['uniacid']}' AND parentid = 0");
    		foreach ($parents AS $parent) {
    			$id = 	$parent['id'];
    			$ifkq = $parent['ifkq'];
    			$enable = intval($parent['ifkq']) ? "<a class='btn btn-success btn-sm js-switch' data-id='{$id}' data-data='{$ifkq}'>是</a>" : "<a class='btn btn-danger btn-sm js-switch' data-id='{$id}' data-data='{$ifkq}'>否</a>";
    			$o.= "<tr><td><input type=\"checkbox\" name=\"select[]\" value=\"{$parent['id']}\" /></td>";
    			$o.= "<td>" . $parent['name'] . "</td>";
    			$o.= "<td> —— </td>";
    			$o.= "<td>" . $enable . "</td>";
    			$o.= "</tr>";
    			$subcates = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_jdcategory') . " WHERE parentid = {$parent['id']}");
    			foreach ($subcates AS $subcate) {
    				$id = 	$subcate['id'];
    				$ifkq = $subcate['ifkq'];
    				$enable = intval($subcate['ifkq']) ? "<a class='btn btn-success btn-sm js-switch' data-id='{$id}' data-data='{$ifkq}'>是</a>" : "<a class='btn btn-danger btn-sm js-switch' data-id='{$id}' data-data='{$ifkq}'>否</a>";
    				$o.= "<tr><td><input type=\"checkbox\" name=\"select[]\" value=\"{$subcate['id']}\" /></td>";
    				$o.= "<td>&nbsp;&nbsp;&nbsp;&nbsp;|——" . $subcate['name'] . "</td>";
    				$o.= "<td>" . $parent['name'] . "</td>";
    				$o.= "<td>" . $enable . "</td>";
    				$o.= "<td><a href=" . $this->createWebUrl('docjiand', array('op' => 'post', 'id' => $subcate['id'])) . ">查看</a></td></tr>";
    			}

    		}

    	}
    	if($op == 'post'){
    		$id =intval($_GPC['id']);
    		$condition = " uniacid = '{$_W['uniacid']}'";
    		$allforms = pdo_fetchall("select * from " . tablename('hyb_yl_jiandang')." where".$condition." and activityid=:id order by displayorder asc",array(":id"=>$id));
    		$condition.= " and `show`=1";
    		foreach ($allforms as &$s) {
    			$s['items'] = pdo_fetchall("select * from " . tablename('hyb_yl_jderj') . " where".$condition." and formid=".$s['id']." order by displayorder asc");
    		}
    		if(checksubmit()){
    			$form_ids = $_GPC['form_id'];
    			$form_titles = $_GPC['form_title'];
    			$form_displaytypes = $_GPC['form_displaytype'];
    			$form_essentials = $_GPC['form_essential'];
    			$form_fieldstypes = $_GPC['form_fieldstype'];
    			$form_lowStandard = $_GPC['form_lowStandard'];
    			$form_highStandard = $_GPC['form_highStandard'];
    			$len = count($form_ids);
    			$formids = array();
    			$form_items = array();
    			for ($k = 0; $k < $len; $k++) {
    				$form_id = "";
    				$get_form_id = $form_ids[$k];
    				$a = array(
    					"uniacid" => $_W['uniacid'],
    					"activityid" => $id,
    					"displayorder" => $k,
    					"title" => $form_titles[$get_form_id],
    					"displaytype" => $form_displaytypes[$get_form_id],
    					"essential" => $form_essentials[$get_form_id],
    					"fieldstype" => $form_fieldstypes[$get_form_id],
    					"lowStandard"=>$form_lowStandard[$get_form_id],
    					"highStandard"=>$form_highStandard[$get_form_id],
    					);
    				if (is_numeric($get_form_id)) {
    					pdo_update("hyb_yl_jiandang", $a, array("id" => $get_form_id));
    					$form_id = $get_form_id;
    				} else {
    					pdo_insert("hyb_yl_jiandang", $a);
    					$form_id = pdo_insertid();
    				}

    				$form_item_ids = $_GPC["form_item_id_".$get_form_id];
    				$form_item_titles = $_GPC["form_item_title_".$get_form_id];
    				$form_item_shows = $_GPC["form_item_show_".$get_form_id];
    				$form_item_thumbs = $_GPC["form_item_thumb_".$get_form_id];
    				$form_item_oldthumbs = $_GPC["form_item_oldthumb_".$get_form_id];
    				$itemlen = count($form_item_ids);
    				$itemids = array();
    				for ($n = 0; $n < $itemlen; $n++) {
    					$item_id = "";
    					$get_item_id = $form_item_ids[$n];
    					$d = array(
    						"uniacid" => $_W['uniacid'],
    						"formid" => $form_id,
    						"displayorder" => $n,
    						"title" => $form_item_titles[$n],
    						"show" => $form_item_shows[$n],
    						"thumb"=>$form_item_thumbs[$n]
    						);
    					$f = "form_item_thumb_" . $get_item_id;
    					if (is_numeric($get_item_id)) {
    						pdo_update("hyb_yl_jderj", $d, array("id" => $get_item_id));
    						$item_id = $get_item_id;
    					} else {
    						pdo_insert("hyb_yl_jderj", $d);
    						$item_id = pdo_insertid();

    					}
    					$itemids[] = $item_id;
					//临时记录，用于保存表单项
    					$d['get_id'] = $get_item_id;
    					$d['id']= $item_id;
    					$form_items[] = $d;
    				}
				//删除其他的
    				if(count($itemids)>0){
    					pdo_query("delete from " . tablename('hyb_yl_jderj') . " where uniacid={$_W['uniacid']} and formid=$form_id and id not in (" . implode(",", $itemids) . ")");	
    				}
    				else{
    					pdo_query("delete from " . tablename('hyb_yl_jderj') . " where uniacid={$_W['uniacid']} and formid=$form_id");	
    				}
				//更新id
    				pdo_update("hyb_yl_jiandang", array("content" => serialize($itemids)), array("id" => $form_id));
    				$formids[] = $form_id;

    			}
			//删除
    			if( count($formids)>0){
    				$result = pdo_fetchall("select id from " . tablename('hyb_yl_jiandang')." where uniacid={$_W['uniacid']} and activityid=$id and id not in (" . implode(",", $formids) . ")");		
    				pdo_query("delete from " . tablename('hyb_yl_jiandang') . " where uniacid={$_W['uniacid']} and activityid=$id and id not in (" . implode(",", $formids) . ")");
    				if(!empty($result)) {
    					$dl_formids = array();
    					foreach($result as $k => $row) {
    						$dl_formids[] = $row['id'];
    					}
    					pdo_query("delete from " . tablename('hyb_yl_jderj') . " where uniacid={$_W['uniacid']} and formid in (" . implode(",", $dl_formids) . ")");
    				}
    			}
    			else{
    				$result = pdo_fetchall("select id from " . tablename('hyb_yl_jiandang')." where uniacid={$_W['uniacid']} and activityid=$id");
    				pdo_query("delete from " . tablename('hyb_yl_jiandang') . " where uniacid={$_W['uniacid']} and activityid=$id");
    				if(!empty($result)) {
    					$dl_formids = array();
    					foreach($result as $k => $row) {
    						$dl_formids[] = $row['id'];
    					}
    					pdo_query("delete from " . tablename('hyb_yl_jderj') . " where uniacid={$_W['uniacid']} and formid in (" . implode(",", $dl_formids) . ")");
    				}

    			}
    			message('成功', $this->createWebUrl('docjiand',array('op'=>'display')), 'success');
    		}
    	}
    	include $this->template('jiandang');
    }
    public function doWebFormzidiny(){
    	global $_GPC, $_W;
    	load()->func("tpl");
    	$op = isset($_GPC['op']) ? $_GPC['op'] : 'display';

    	if($op =='display'){
    		$o = '';
    		$parents = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_category') . " WHERE uniacid = '{$_W['uniacid']}' AND parentid = 0");
    		foreach ($parents AS $parent) {
    			$id = 	$parent['id'];
    			$ifkq = $parent['ifkq'];
    			$enable = intval($parent['ifkq']) ? "<a class='btn btn-success btn-sm js-switch' data-id='{$id}' data-data='{$ifkq}'>是</a>" : "<a class='btn btn-danger btn-sm js-switch' data-id='{$id}' data-data='{$ifkq}'>否</a>";
    			$o.= "<tr><td><input type=\"checkbox\" name=\"select[]\" value=\"{$parent['id']}\" /></td>";
    			$o.= "<td>" . $parent['name'] . "</td>";
    			$o.= "<td> —— </td>";
    			$o.= "<td>" . $enable . "</td>";
    			$o.= "<td><a href=" . $this->createWebUrl('formzidiny', array('op' => 'post', 'id' => $parent['id'])) . " >查看</a></td></tr>";
    			$subcates = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_category') . " WHERE parentid = {$parent['id']}");

    			foreach ($subcates AS $subcate) {
    				$id = 	$subcate['id'];
    				$ifkq = $subcate['ifkq'];
    				$enable = intval($subcate['ifkq']) ? "<a class='btn btn-success btn-sm js-switch' data-id='{$id}' data-data='{$ifkq}'>是</a>" : "<a class='btn btn-danger btn-sm js-switch' data-id='{$id}' data-data='{$ifkq}'>否</a>";
    				$o.= "<tr><td><input type=\"checkbox\" name=\"select[]\" value=\"{$subcate['id']}\" /></td>";
    				$o.= "<td>&nbsp;&nbsp;&nbsp;&nbsp;|——" . $subcate['name'] . "</td>";
    				$o.= "<td>" . $parent['name'] . "</td>";
    				$o.= "<td>" . $enable . "</td>";
    				$o.= "<td><a href=" . $this->createWebUrl('formzidiny', array('op' => 'post', 'id' => $subcate['id'])) . ">查看</a></td></tr>";
    				$parentncalss = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_category') . " WHERE parentid = {$subcate['id']}");
    				foreach ($parentncalss AS $pcalss) {
    					$id = 	$pcalss['id'];
    					$ifkq = $pcalss['ifkq'];
    					$enable = intval($pcalss['ifkq']) ? "<a class='btn btn-success btn-sm js-switch' data-id='{$id}' data-data='{$ifkq}'>是</a>" : "<a class='btn btn-danger btn-sm js-switch' data-id='{$id}' data-data='{$ifkq}'>否</a>";
    					$o.= "<tr><td><input type=\"checkbox\" name=\"select[]\" value=\"{$pcalss['id']}\" /></td>";
    					$o.= "<td>&nbsp;&nbsp;&nbsp;&nbsp;|————————" . $pcalss['name'] . "</td>";
    					$o.= "<td>" . $parent['name'] . "</td>";
    					$o.= "<td>" . $enable . "</td>";
    					$o.= "<td><a href=" . $this->createWebUrl('formzidiny', array('op' => 'post', 'id' => $pcalss['id'])) . ">查看</a></td></tr>";
    				}
    			}

    		}
    	}
    	if($op=='upkg'){
    		$ids= $_GPC['id'];
    		pdo_update('hyb_yl_category',array('ifkq'=>$_GPC['status']),array('id'=>$ids,'uniacid'=>$_W['uniacid']));
    	}
    	if($op == 'post'){
    		$id =intval($_GPC['id']);
    		$condition = " uniacid = '{$_W['uniacid']}'";
    		$allforms = pdo_fetchall("select * from " . tablename('hyb_yl_formdate')." where".$condition." and activityid=:id order by displayorder asc",array(":id"=>$id));
    		$condition.= " and `show`=1";
    		foreach ($allforms as &$s) {
    			$s['items'] = pdo_fetchall("select * from " . tablename('hyb_yl_item') . " where".$condition." and formid=".$s['id']." order by displayorder asc");
    		}

        //$form = pdo_get('hyb_yl_formdate', array('id' => $id,'uniacid'=>$_W['uniacid']));

    		if(checksubmit()){
    			$form_ids = $_GPC['form_id'];
    			$form_titles = $_GPC['form_title'];
    			$form_displaytypes = $_GPC['form_displaytype'];
    			$form_essentials = $_GPC['form_essential'];
    			$form_fieldstypes = $_GPC['form_fieldstype'];
    			$form_lowStandard = $_GPC['form_lowStandard'];
    			$form_highStandard = $_GPC['form_highStandard'];
    			$len = count($form_ids);
    			$formids = array();
    			$form_items = array();
    			for ($k = 0; $k < $len; $k++) {
    				$form_id = "";
    				$get_form_id = $form_ids[$k];
    				$a = array(
    					"uniacid" => $_W['uniacid'],
    					"activityid" => $id,
    					"displayorder" => $k,
    					"title" => $form_titles[$get_form_id],
    					"displaytype" => $form_displaytypes[$get_form_id],
    					"essential" => $form_essentials[$get_form_id],
    					"fieldstype" => $form_fieldstypes[$get_form_id],
    					"lowStandard"=>$form_lowStandard[$get_form_id],
    					"highStandard"=>$form_highStandard[$get_form_id],
    					);
    				if (is_numeric($get_form_id)) {
    					pdo_update("hyb_yl_formdate", $a, array("id" => $get_form_id));
    					$form_id = $get_form_id;
    				} else {
    					pdo_insert("hyb_yl_formdate", $a);
    					$form_id = pdo_insertid();
    				}

    				$form_item_ids = $_GPC["form_item_id_".$get_form_id];
    				$form_item_titles = $_GPC["form_item_title_".$get_form_id];
    				$form_item_shows = $_GPC["form_item_show_".$get_form_id];
    				$form_item_thumbs = $_GPC["form_item_thumb_".$get_form_id];
    				$form_item_oldthumbs = $_GPC["form_item_oldthumb_".$get_form_id];
    				$itemlen = count($form_item_ids);
    				$itemids = array();
    				for ($n = 0; $n < $itemlen; $n++) {
    					$item_id = "";
    					$get_item_id = $form_item_ids[$n];
    					$d = array(
    						"uniacid" => $_W['uniacid'],
    						"formid" => $form_id,
    						"displayorder" => $n,
    						"title" => $form_item_titles[$n],
    						"show" => $form_item_shows[$n],
    						"thumb"=>$form_item_thumbs[$n]
    						);
    					$f = "form_item_thumb_" . $get_item_id;
    					if (is_numeric($get_item_id)) {
    						pdo_update("hyb_yl_item", $d, array("id" => $get_item_id));
    						$item_id = $get_item_id;
    					} else {
    						pdo_insert("hyb_yl_item", $d);
    						$item_id = pdo_insertid();

    					}
    					$itemids[] = $item_id;
				//临时记录，用于保存表单项
    					$d['get_id'] = $get_item_id;
    					$d['id']= $item_id;
    					$form_items[] = $d;
    				}
			//删除其他的
    				if(count($itemids)>0){
    					pdo_query("delete from " . tablename('hyb_yl_item') . " where uniacid={$_W['uniacid']} and formid=$form_id and id not in (" . implode(",", $itemids) . ")");	
    				}
    				else{
    					pdo_query("delete from " . tablename('hyb_yl_item') . " where uniacid={$_W['uniacid']} and formid=$form_id");	
    				}
			//更新id
    				pdo_update("hyb_yl_formdate", array("content" => serialize($itemids)), array("id" => $form_id));
    				$formids[] = $form_id;

    			}
		//删除
    			if( count($formids)>0){
    				$result = pdo_fetchall("select id from " . tablename('hyb_yl_formdate')." where uniacid={$_W['uniacid']} and activityid=$id and id not in (" . implode(",", $formids) . ")");		
    				pdo_query("delete from " . tablename('hyb_yl_formdate') . " where uniacid={$_W['uniacid']} and activityid=$id and id not in (" . implode(",", $formids) . ")");
    				if(!empty($result)) {
    					$dl_formids = array();
    					foreach($result as $k => $row) {
    						$dl_formids[] = $row['id'];
    					}
    					pdo_query("delete from " . tablename('hyb_yl_item') . " where uniacid={$_W['uniacid']} and formid in (" . implode(",", $dl_formids) . ")");
    				}
    			}
    			else{
    				$result = pdo_fetchall("select id from " . tablename('hyb_yl_formdate')." where uniacid={$_W['uniacid']} and activityid=$id");
    				pdo_query("delete from " . tablename('hyb_yl_formdate') . " where uniacid={$_W['uniacid']} and activityid=$id");
    				if(!empty($result)) {
    					$dl_formids = array();
    					foreach($result as $k => $row) {
    						$dl_formids[] = $row['id'];
    					}
    					pdo_query("delete from " . tablename('hyb_yl_item') . " where uniacid={$_W['uniacid']} and formid in (" . implode(",", $dl_formids) . ")");
    				}

    			}
    			message('成功', $this->createWebUrl('formzidiny',array('op'=>'display')), 'success');
    		}

    	}
    	include $this->template('form');
    }
    public function doWebDocjiand(){
    	global $_GPC, $_W;
    	load()->func("tpl");
    	$id=$_GPC['id'];
    	$op = isset($_GPC['op']) ? $_GPC['op'] : 'display';
    	if ($op == 'ck') {
    		if (!empty($id)) {
    			$item = pdo_fetch("SELECT * FROM" . tablename('hyb_yl_jdcategory') . "WHERE id='{$id}'");
    		}
    		if ($_W['ispost']) {
    			$data = array('uniacid' => $_W['uniacid'], 'name' => $_GPC['cname'], 'parentid' => $_GPC['parentid'], 'enabled' => $_GPC['enabled'] ? 1 : 0, 'icon' => $_GPC['icon'],'ksdesc' =>$_GPC['ksdesc']);
    			if (empty($id)) {
    				pdo_insert('hyb_yl_jdcategory', $data);
    				message('添加成功', $this->createWebUrl('docjiand'), 'success');
    			} else {
    				pdo_update('hyb_yl_jdcategory', $data, array('id' => $id));
    				message('更新成功', $this->createWebUrl('docjiand'), 'success');
    			}
    		}
    	}
    	if($op =='display'){
    		$o = '';
    		$parents = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_jdcategory') . " WHERE uniacid = '{$_W['uniacid']}' AND parentid = 0 order by id asc");
    		foreach ($parents AS $parent) {
    			$id = 	$parent['id'];
    			$ifkq = $parent['ifkq'];
    			$enable = intval($parent['ifkq']) ? "<a class='btn btn-success btn-sm js-switch' data-id='{$id}' data-data='{$ifkq}'>是</a>" : "<a class='btn btn-danger btn-sm js-switch' data-id='{$id}' data-data='{$ifkq}'>否</a>";
    			$o.= "<tr><td><input type=\"checkbox\" name=\"select[]\" value=\"{$parent['id']}\" /></td>";
    			$o.= "<td>" . $parent['name'] . "</td>";
    			$o.= "<td> —— </td>";
    			$o.= "<td>" . $enable . "</td>";
    			$o.= "<td><a href=" . $this->createWebUrl('docjiand', array('op' => 'ck', 'id' => $parent['id'])) . " >编辑</a></td></tr>";
               // $o.= "<td><a href=" . $this->createWebUrl('docjiand', array('op' => 'post', 'id' => $parent['id'])) . " ><text style='color:#428bca'>自定义表单</text></a></td></tr>";
    			$subcates = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_jdcategory') . " WHERE parentid = {$parent['id']} order by id asc");

    			foreach ($subcates AS $subcate) {
    				$id = 	$subcate['id'];
    				$ifkq = $subcate['ifkq'];
    				$enable = intval($subcate['ifkq']) ? "<a class='btn btn-success btn-sm js-switch' data-id='{$id}' data-data='{$ifkq}'>是</a>" : "<a class='btn btn-danger btn-sm js-switch' data-id='{$id}' data-data='{$ifkq}'>否</a>";
    				$o.= "<tr><td><input type=\"checkbox\" name=\"select[]\" value=\"{$subcate['id']}\" /></td>";
    				$o.= "<td>&nbsp;&nbsp;&nbsp;&nbsp;|——" . $subcate['name'] . "</td>";
    				$o.= "<td>" . $parent['name'] . "</td>";
    				$o.= "<td>" . $enable . "</td>";
    				$o.= "<td><a href=" . $this->createWebUrl('docjiand', array('op' => 'ck', 'id' => $subcate['id'])) . ">编辑</a></td><td><a href=" . $this->createWebUrl('docjiand', array('op' => 'post', 'id' => $subcate['id'],'name'=>$parent['name'])) . " ><text style='color:#428bca'>添加功能</text></a></td></tr>";
    				$parentncalss = pdo_fetchall("SELECT * FROM " . tablename('hyb_yl_jdcategory') . " WHERE parentid = {$subcate['id']} order by id asc");
    				foreach ($parentncalss AS $pcalss) {
    					$id = 	$pcalss['id'];
    					$ifkq = $pcalss['ifkq'];
    					$enable = "";
    					$o.= "<tr><td><input type=\"checkbox\" name=\"select[]\" value=\"{$pcalss['id']}\" /></td>";
    					$o.= "<td>&nbsp;&nbsp;&nbsp;&nbsp;|————————" . $pcalss['name'] . "</td>";
    					$o.= "<td>" . $parent['name'] . "</td>";
    					$o.= "<td>" . $enable . "</td>";
    					$o.= "<td><a href=" . $this->createWebUrl('docjiand', array('op' => 'ck', 'id' => $pcalss['id'])) . " >编辑</a></td><td><a href=" . $this->createWebUrl('docjiand', array('op' => 'post', 'id' => $pcalss['id'],'name'=>$parent['name'])) . " ><text style='color:#428bca'>添加功能</text></a></td></tr>";
    				}
    			}

    		}
    	}
    	if($op=='upkg'){
    		$ids= $_GPC['id'];
    		pdo_update('hyb_yl_jdcategory',array('ifkq'=>$_GPC['status']),array('id'=>$ids,'uniacid'=>$_W['uniacid']));
    	}
    	if($op == 'post'){
    		$id =intval($_GPC['id']);
    		$condition = " uniacid = '{$_W['uniacid']}'";
    		$allforms = pdo_fetchall("select * from " . tablename('hyb_yl_jiandang')." where".$condition." and activityid=:id order by displayorder asc",array(":id"=>$id));
    		$condition.= " and `show`=1";
    		foreach ($allforms as &$s) {
    			$s['items'] = pdo_fetchall("select * from " . tablename('hyb_yl_jderj') . " where".$condition." and formid=".$s['id']." order by displayorder asc");
    		}

        //$form = pdo_get('hyb_yl_jiandang', array('id' => $id,'uniacid'=>$_W['uniacid']));

    		if(checksubmit()){
    			$form_ids = $_GPC['form_id'];
    			$form_titles = $_GPC['form_title'];
    			$form_displaytypes = $_GPC['form_displaytype'];
    			$form_essentials = $_GPC['form_essential'];
    			$form_fieldstypes = $_GPC['form_fieldstype'];
    			$form_lowStandard = $_GPC['form_lowStandard'];
    			$form_highStandard = $_GPC['form_highStandard'];
    			$len = count($form_ids);
    			$formids = array();
    			$form_items = array();
    			for ($k = 0; $k < $len; $k++) {
    				$form_id = "";
    				$get_form_id = $form_ids[$k];
    				$a = array(
    					"uniacid" => $_W['uniacid'],
    					"activityid" => $id,
    					"displayorder" => $k,
    					"title" => $form_titles[$get_form_id],
    					"displaytype" => $form_displaytypes[$get_form_id],
    					"essential" => $form_essentials[$get_form_id],
    					"fieldstype" => $form_fieldstypes[$get_form_id],
    					"lowStandard"=>$form_lowStandard[$get_form_id],
    					"highStandard"=>$form_highStandard[$get_form_id],
    					);
    				if (is_numeric($get_form_id)) {
    					pdo_update("hyb_yl_jiandang", $a, array("id" => $get_form_id));
    					$form_id = $get_form_id;
    				} else {
    					pdo_insert("hyb_yl_jiandang", $a);
    					$form_id = pdo_insertid();
    				}

    				$form_item_ids = $_GPC["form_item_id_".$get_form_id];
    				$form_item_titles = $_GPC["form_item_title_".$get_form_id];
    				$form_item_shows = $_GPC["form_item_show_".$get_form_id];
    				$form_item_thumbs = $_GPC["form_item_thumb_".$get_form_id];
    				$form_item_oldthumbs = $_GPC["form_item_oldthumb_".$get_form_id];
    				$itemlen = count($form_item_ids);
    				$itemids = array();
    				for ($n = 0; $n < $itemlen; $n++) {
    					$item_id = "";
    					$get_item_id = $form_item_ids[$n];
    					$d = array(
    						"uniacid" => $_W['uniacid'],
    						"formid" => $form_id,
    						"displayorder" => $n,
    						"title" => $form_item_titles[$n],
    						"show" => $form_item_shows[$n],
    						"thumb"=>$form_item_thumbs[$n]
    						);
    					$f = "form_item_thumb_" . $get_item_id;
    					if (is_numeric($get_item_id)) {
    						pdo_update("hyb_yl_jderj", $d, array("id" => $get_item_id));
    						$item_id = $get_item_id;
    					} else {
    						pdo_insert("hyb_yl_jderj", $d);
    						$item_id = pdo_insertid();

    					}
    					$itemids[] = $item_id;
				//临时记录，用于保存表单项
    					$d['get_id'] = $get_item_id;
    					$d['id']= $item_id;
    					$form_items[] = $d;
    				}
			//删除其他的
    				if(count($itemids)>0){
    					pdo_query("delete from " . tablename('hyb_yl_jderj') . " where uniacid={$_W['uniacid']} and formid=$form_id and id not in (" . implode(",", $itemids) . ")");	
    				}
    				else{
    					pdo_query("delete from " . tablename('hyb_yl_jderj') . " where uniacid={$_W['uniacid']} and formid=$form_id");	
    				}
			//更新id
    				pdo_update("hyb_yl_jiandang", array("content" => serialize($itemids)), array("id" => $form_id));
    				$formids[] = $form_id;

    			}
		//删除
    			if( count($formids)>0){
    				$result = pdo_fetchall("select id from " . tablename('hyb_yl_jiandang')." where uniacid={$_W['uniacid']} and activityid=$id and id not in (" . implode(",", $formids) . ")");		
    				pdo_query("delete from " . tablename('hyb_yl_jiandang') . " where uniacid={$_W['uniacid']} and activityid=$id and id not in (" . implode(",", $formids) . ")");
    				if(!empty($result)) {
    					$dl_formids = array();
    					foreach($result as $k => $row) {
    						$dl_formids[] = $row['id'];
    					}
    					pdo_query("delete from " . tablename('hyb_yl_jderj') . " where uniacid={$_W['uniacid']} and formid in (" . implode(",", $dl_formids) . ")");
    				}
    			}
    			else{
    				$result = pdo_fetchall("select id from " . tablename('hyb_yl_jiandang')." where uniacid={$_W['uniacid']} and activityid=$id");
    				pdo_query("delete from " . tablename('hyb_yl_jiandang') . " where uniacid={$_W['uniacid']} and activityid=$id");
    				if(!empty($result)) {
    					$dl_formids = array();
    					foreach($result as $k => $row) {
    						$dl_formids[] = $row['id'];
    					}
    					pdo_query("delete from " . tablename('hyb_yl_jderj') . " where uniacid={$_W['uniacid']} and formid in (" . implode(",", $dl_formids) . ")");
    				}

    			}
    			message('成功', $this->createWebUrl('docjiand',array('op'=>'display')), 'success');
    		}

    	}
    	 if (checksubmit('delete')) {
            pdo_delete('hyb_yl_jdcategory', " id  IN  ('" . implode(",", $_GPC['select']) . "')");
            message('删除成功', referer(), 'success');
        }
    	$categorys = pdo_fetchall("SELECT * FROM" . tablename('hyb_yl_jdcategory') . "WHERE uniacid = :uniacid ", array(':uniacid' => $this->uniacid));
    	$tree = $this->getTree($categorys, 0);

    	include $this->template('jiandangdiv');
    }
    public function doWebHzbingc(){
    	global $_GPC, $_W;
    	load()->func("tpl");
    	$uniacid =$_W['uniacid'];
    	if (checksubmit('submit')) {
    		$op = $_GPC['keywords'];
    		$where = "%{$op}%";
    	} else {
    		$where = '%%';
    	}
    	$keyword = $_GPC['keywords'];
    	if(empty($keyword)){
    		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('hyb_yl_userinfo') . " WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
    		$pindex = max(1, intval($_GPC['page'])); 
    		$pagesize = 10;
    		$pager = pagination($total,$pindex,$pagesize);
    		$p = ($pindex-1) * $pagesize;
    		$rows = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_userinfo")." where uniacid=:uniacid order by u_id asc limit ".$p.",".$pagesize , array(':uniacid' => $uniacid));
			foreach ($rows as $key => $value) {
				$useropenid =$value['openid'];
				$rows[$key]['new'] = pdo_fetch("SELECT * FROM".tablename('hyb_yl_jiandangbaogaoinfo')."where useropenid='{$useropenid}' and jd_id in(select max(jd_id) from".tablename('hyb_yl_jiandangbaogaoinfo')."group by useropenid)");
			}
    	}else{
    		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('hyb_yl_userinfo') . " WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
    		$total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("hyb_ylmz_userinfo")." where uniacid=:uniacid and u_name like '%{$keyword}%' ",array(":uniacid"=>$uniacid));
    		$pindex = max(1, intval($_GPC['page'])); 
    		$pagesize = 10;
    		$pager = pagination($total,$pindex,$pagesize);
    		$p = ($pindex-1) * $pagesize;
    		$rows = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_userinfo")." where uniacid=:uniacid and u_name like '%{$keyword}%' order by u_id asc limit ".$p.",".$pagesize , array(':uniacid' => $uniacid));
			foreach ($rowss as $key => $value) {
				$useropenid =$value['openid'];
				$rows[$key]['new'] = pdo_fetch("SELECT * FROM".tablename('hyb_yl_jiandangbaogaoinfo')."where useropenid='{$useropenid}' and jd_id in(select max(jd_id) from".tablename('hyb_yl_jiandangbaogaoinfo')."group by useropenid)");
			}
    	}
		if(checksubmit('deletealls')){
	        if(!empty($_GPC['deleteall']))
	        {
	        for($i=0;$i<count($_GPC['deleteall']);$i++)
		        {
		        pdo_delete('hyb_yl_userinfo', array('u_id' =>$_GPC['deleteall'][$i]));
		        }
		        message('删除成功!', $this -> createWeburl('hzbingc'), 'success');

		        }
	        }
		include $this->template('hzbingc');
	}
	public function doWebUserbcinfo(){
		global $_GPC, $_W;
		load()->func("tpl");
		$jd_id=$_GPC['jd_id'];
	}
	public function doWebLookstep(){
		global $_W,$_GPC;
		$uniacid = $_W['uniacid'];
		$type = !empty($_GPC['type']) ? $_GPC['type'] : 'ok';
		$useropenid =$_GPC['useropenid'];
		if($type =='ok'){
            $uniacid =$_W['uniacid'];
			$condition = " uniacid = '{$_W['uniacid']}'";
			$allforms = pdo_fetchall("select * from " . tablename('hyb_yl_jdcategory')." where".$condition."AND parentid = 0 order by id ASC");
			///var_dump($allforms);
		}
		if($type =="post"){
          $useropenid =$_GPC['useropenid'];
		  $id =$_GPC['id'];
		  $ejid =$_GPC['ejid'];
		  $condition = " uniacid = '{$_W['uniacid']}'";
		  $res =pdo_fetchall("select * from " . tablename('hyb_yl_jdcategory') . " where".$condition." and parentid=".$id." order by id ASC");
          //查询是否存在三级
          $ifsan = pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_jdcategory')."where uniacid ='{$uniacid}' AND parentid='{$id}' order by id ASC");
          $fuleiid = $ifsan[0]['id'];
		  $resinfo1 =pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_jiandangbaogaoinfo')."as a left join ".tablename('hyb_yl_userinfo')."as b on b.openid=a.useropenid where a.uniacid ='{$uniacid}' and a.fuleiid='{$fuleiid}' and a.useropenid='{$useropenid}' order by a.jd_id desc");
			  foreach ($resinfo1 as &$value) {
			   $value['info']=unserialize($value['info']);
			   $value['org_pic']=unserialize($value['org_pic']);
			   $slinum =count($value['org_pic']);
			   for($i = 0; $i < $slinum; $i++) {
			    $value['org_pic'][$i] = $_W['attachurl'] . $value['org_pic'][$i];
			  }
          }
          if(!empty($ejid)){
           $ifsan = pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_jdcategory')."where uniacid ='{$uniacid}' AND parentid='{$erjid}'");
           if(!empty($ifsan)){
           //查询三级下面的内容
			  $resinfo1 =pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_jiandangbaogaoinfo')."as a left join ".tablename('hyb_yl_userinfo')."as b on b.openid=a.useropenid where a.uniacid ='{$uniacid}' and a.fuleiid='{$ejid}' and a.useropenid='{$useropenid}' order by a.jd_id desc");
				  foreach ($resinfo1 as &$value) {
				   $value['info']=unserialize($value['info']);
				   $value['org_pic']=unserialize($value['org_pic']);
				   $slinum =count($value['org_pic']);
				   for($i = 0; $i < $slinum; $i++) {
				    $value['org_pic'][$i] = $_W['attachurl'] . $value['org_pic'][$i];
				  }
	          }
	          // var_dump($resinfo1);
          }else{
          	//查询二级下面的内容
              $resinfo1 =pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_jiandangbaogaoinfo')."as a left join ".tablename('hyb_yl_userinfo')."as b on b.openid=a.useropenid where a.uniacid ='{$uniacid}' and a.fuleiid='{$ejid}' and a.useropenid='{$useropenid}' order by a.jd_id desc");
				  foreach ($resinfo1 as &$value) {
				   $value['info']=unserialize($value['info']);
				   $value['org_pic']=unserialize($value['org_pic']);
				   $slinum =count($value['org_pic']);
				   for($i = 0; $i < $slinum; $i++) {
				    $value['org_pic'][$i] = $_W['attachurl'] . $value['org_pic'][$i];
				  }
                }

	    	}
          }
		}
	      if($type=='delete'){
	      	$jd_id=$_GPC['jd_id'];
	      	$id =$_GPC['id'];
	        $res =pdo_delete('hyb_yl_jiandangbaogaoinfo',array('jd_id'=>$jd_id,'uniacid'=>$uniacid));
	        message('删除成功', $this->createWebUrl('lookstep',array('type'=>'post','id'=>$id,'useropenid'=>$_GPC['useropenid'])), 'success');
	      }
		include $this->template('activity/step');
	}
    public function doWebInfosetp(){
	  global $_GPC, $_W;
	  load()->func("tpl");
	  $uniacid=$_W['uniacid'];
	  $jd_id=$_GPC['jd_id'];
	  $op =$_GPC['op'];
	  $res1 =pdo_fetch('SELECT * FROM'.tablename('hyb_yl_jiandangbaogaoinfo')."where uniacid ='{$uniacid}' and  jd_id='{$jd_id}'");
	  $res1['org_pic']=unserialize($res1['org_pic']);
	  $piccount =count($res1['org_pic']);
   
	  $res1['info']=unserialize($res1['info']);

	  include $this->template('activity/infostep');
    }
	public function doWebShujutj(){
		global $_GPC, $_W;
		load()->func("tpl");
		$uniacid=$_W['uniacid'];
		//unlink ("");
		$path = "../attachment/tongjitu/";
		if(is_dir($path)){
		    //扫描一个文件夹内的所有文件夹和文件并返回数组
			$p = scandir($path);
			foreach($p as $val){
		    //排除目录中的.和..
				if($val !="." && $val !=".."){
		     //如果是目录则递归子目录，继续操作
					if(is_dir($path.$val)){
		      //子目录中操作删除文件夹和文件
						deldir($path.$val.'/');
					}else{
		      //如果是文件直接删除
						unlink($path.$val);
					}
				}
			}
		}
		header("Content-Type:text/html;charset=utf-8");
		require_once dirname(__FILE__) .'/jpgraph/jpgraph.php';
		require_once dirname(__FILE__) .'/jpgraph/jpgraph_pie.php';
		require_once dirname(__FILE__) .'/jpgraph/jpgraph_pie3d.php';
		$t1=0;
		$t2=0;
		$t3=0;
		$rowss =pdo_fetchall('SELECT * from'.tablename('hyb_yl_jiandangbaogaoinfo')."as a left join ".tablename('hyb_yl_userinfo')."as b on b.openid=a.useropenid where a.uniacid ='{$uniacid}' GROUP BY useropenid  desc");
		foreach ($rowss as &$value) {
			$value['info']=unserialize($value['info']);
			foreach ($value['info'] as &$val) {
				if ($val['title'] == '姓名') {
					$value['xing']= $val['title'].':'.$val['description'];
				}
				if ($val['title'] == '试管次数') {
					$value['qita']  = $val['title'].':'.$val['description'].'次';
				}
				if ($val['title'] == '年龄') {
					$value['nianl'] = $val['title'].':'.$val['description'].'岁';
				}
			}
		}
		foreach($rowss as &$v){
			$shiguan =$v['info'];
			foreach($shiguan as &$value){ 
				if ($value['title'] == '试管次数') {
					if($value['description']>=0&&$value['description']<=3){
						  $t1+=1; //10-20岁的数量
						}
						if($value['description']>3&&$value['description']<=5){
						   $t2+=1; //20-30岁的数量
						}
						if($value['description']>5&&$value['description']<=10){
						   $t3+=1; //20-30岁的数量
						}	
					}     
				}	
			}
			//var_dump($t1,$t2,$t3);exit();
			if($t1=='0'){
               $t1=1;
			}
			$data=array($t1,$t2,$t3);
				//创建画布
			$graph=new PieGraph(800,500);
				//设置图像边界范围
			$graph->img->SetMargin(30,30,80,30);
				//设置标题
			$graph->title->Set("试管次数统计");
			$graph->title->SetFont(FF_SIMSUN,FS_BOLD);
				//得到饼图对象
			$piePlot=new PiePlot($data);
				//设置图例
			$graph->legend->font_family = FF_SIMSUN;
			$piePlot->SetLegends(array('1-3次','3-5次','5-10次'));
				//设置图例位置
			$graph->legend->Pos(0.01,0.60,"left","top");
				//添加到画布中
			$graph->Add($piePlot);
				//输出
				//$graph->Stroke();
			$gdimg = $graph->Stroke(_IMG_HANDLER);
			$imagelex = md5(uniqid(rand())).".png";
				$dir_url=$_SERVER['DOCUMENT_ROOT'].'/attachment/tongjitu/'; //上传路径
				mkdirs($dir_url); 
				$filename="../attachment/tongjitu/{$imagelex}";
				$graph->img->Stream($filename);//将生成的图片保存到本地
				$siteroot = $_W['siteroot'];
				$filepathsss= "{$siteroot}".'attachment/tongjitu'."/{$imagelex}";
         // var_dump($t1,$t2,$t3);

				include $this->template('tongjitu');
			}
			public function doWebNianl(){
				global $_GPC, $_W;
				load()->func("tpl");
				$uniacid=$_W['uniacid'];
				$path = "../attachment/tongjitu/";
				if(is_dir($path)){
		           //扫描一个文件夹内的所有文件夹和文件并返回数组
					$p = scandir($path);
					foreach($p as $val){
		              //排除目录中的.和..
						if($val !="." && $val !=".."){
		            //如果是目录则递归子目录，继续操作
							if(is_dir($path.$val)){
		            //子目录中操作删除文件夹和文件
								deldir($path.$val.'/');
							}else{
		           //如果是文件直接删除
								unlink($path.$val);
							}
						}
					}
				}
				header("Content-Type:text/html;charset=utf-8");
				require_once dirname(__FILE__) .'/jpgraph/jpgraph.php';
				require_once dirname(__FILE__) .'/jpgraph/jpgraph_pie.php';
				require_once dirname(__FILE__) .'/jpgraph/jpgraph_pie3d.php';
				$t1=0;
				$t2=0;
				$t3=0;
				$rowss =pdo_fetchall('SELECT * from'.tablename('hyb_yl_jiandangbaogaoinfo')."as a left join ".tablename('hyb_yl_userinfo')."as b on b.openid=a.useropenid where a.uniacid ='{$uniacid}' GROUP BY useropenid  desc");
				foreach ($rowss as &$value) {
					$value['info']=unserialize($value['info']);
					foreach ($value['info'] as &$val) {
						if ($val['title'] == '姓名') {
							$value['xing']= $val['title'].':'.$val['description'];
						}
						if ($val['title'] == '试管次数') {
							$value['qita']  = $val['title'].':'.$val['description'].'次';
						}
						if ($val['title'] == '年龄') {
							$value['nianl'] = $val['title'].':'.$val['description'].'岁';
						}
					}
				}

				foreach($rowss as &$v){
					$shiguan =$v['info'];
					foreach($shiguan as &$value){ 
						if ($value['title'] == '年龄') {
							if($value['description']>=20&&$value['description']<=25){
							$t1+=1; //10-20岁的数量
						}
						if($value['description']>25&&$value['description']<=30){
						   $t2+=1; //20-30岁的数量
						}
						if($value['description']>35&&$value['description']<=40){
						   $t3+=1; //20-30岁的数量
						}
					} 	
				}
			}
			if($t1=='0'){
               $t1=1;
			}
			$data=array($t1,$t2,$t3);
				//创建画布
			$graph=new PieGraph(800,500);
				//设置图像边界范围
			$graph->img->SetMargin(30,30,80,30);
				//设置标题
			$graph->title->Set("年龄统计");
			$graph->title->SetFont(FF_SIMSUN,FS_BOLD);
				//得到饼图对象
			$piePlot=new PiePlot($data);
				//设置图例
			$graph->legend->font_family = FF_SIMSUN;
			$piePlot->SetLegends(array('20-25岁','25-30岁','35-40岁'));
				//设置图例位置
			$graph->legend->Pos(0.01,0.60,"left","top");
				//添加到画布中
			$graph->Add($piePlot);
				//输出
				//$graph->Stroke();
			$gdimg = $graph->Stroke(_IMG_HANDLER);
			$imagelex = md5(uniqid(rand())).".png";
				$dir_url=$_SERVER['DOCUMENT_ROOT'].'/attachment/tongjitu/'; //上传路径
				mkdirs($dir_url); 
				$filename="../attachment/tongjitu/{$imagelex}";
				$graph->img->Stream($filename);//将生成的图片保存到本地
				$siteroot = $_W['siteroot'];
				$filepathsss= "{$siteroot}".'attachment/tongjitu'."/{$imagelex}";
         //var_dump($t1,$t2,$t3);

				include $this->template('tongjitu');
			}
			public function doWebHisinfo(){
				global $_GPC, $_W;
				load()->func("tpl");
				$uniacid=$_W['uniacid'];
				$type = $_GPC['type'];
				$type = !empty($_GPC['type']) ? $_GPC['type'] : 'all';
				if($type =='all'){
          //all 地区
					$res =pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_csaddress')."where uniacid ='{$uniacid}'");
				}
				if($type =='add'){
					$diz_id =$_GPC['diz_id'];
					$get =pdo_fetch('SELECT * from'.tablename('hyb_yl_csaddress')."where uniacid='{$uniacid}' and diz_id='{$diz_id}'");
					if(checksubmit('tijiao')){
						$data=array(
							'uniacid'=>$_W['uniacid'],
							'dz_name'=>$_GPC['dz_name'],
							);
						if(empty($diz_id)){
							pdo_insert('hyb_yl_csaddress',$data);
							message('添加成功', $this->createWebUrl('hisinfo',array('type'=>'all')), 'success');
						}else{
							pdo_update('hyb_yl_csaddress',$data,array('uniacid'=>$uniacid,'diz_id'=>$diz_id));
							message('更新成功', $this->createWebUrl('hisinfo',array('type'=>'all')), 'success');
						}
					} 
				}
				if($type=='delete'){
					$diz_id =$_GPC['diz_id'];
					pdo_delete('hyb_yl_csaddress',array('diz_id'=>$diz_id));
					message('删除成功', $this->createWebUrl('hisinfo',array('type'=>'all')), 'success');
				}
				include $this->template('hisinfo');
			}
			public function doWebAddhospital(){
				global $_GPC, $_W;
				load()->func("tpl");
				$uniacid=$_W['uniacid'];
				$type = $_GPC['type'];
				$diz_id =$_GPC['diz_id'];
				$type = !empty($_GPC['type']) ? $_GPC['type'] : 'no';
				if($type =='no'){
          //all 地区
					$res =pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_duhospital')."where uniacid ='{$uniacid}' and diz_id='{$diz_id}'");
				}
				if($type =='add'){
					$dq_id =$_GPC['dq_id'];

					$get =pdo_fetch('SELECT * from'.tablename('hyb_yl_duhospital')."where uniacid='{$uniacid}' and dq_id='{$dq_id}'");
					if(checksubmit('tijiao')){
						$data=array(
							'uniacid'=>$_W['uniacid'],
							'yname'=>$_GPC['yname'],
							'diz_id'=>$_GPC['diz_id']
							);
						if(empty($dq_id)){
							pdo_insert('hyb_yl_duhospital',$data);
							message('添加成功', $this->createWebUrl('addhospital',array('type'=>'no','diz_id'=>$diz_id)), 'success');
						}else{
							pdo_update('hyb_yl_duhospital',$data,array('uniacid'=>$uniacid,'dq_id'=>$dq_id));
							message('更新成功', $this->createWebUrl('addhospital',array('type'=>'no','diz_id'=>$diz_id)), 'success');
						}
					} 
				}
				if($type=='delete'){
					$dq_id =$_GPC['dq_id'];
					pdo_delete('hyb_yl_duhospital',array('dq_id'=>$dq_id));
					message('删除成功', $this->createWebUrl('addhospital',array('type'=>'no','diz_id'=>$diz_id)), 'success');
				}
				include $this->template('addhospital');
			}
		public function doWebZzanl(){
			global $_GPC, $_W;
			load()->func("tpl");
			$op = $_GPC['op'];
			$ops = array('display', 'post',"delete");
			$op = in_array($op, $ops) ? $op : 'display';
			$hz_id = $_GPC['hz_id'];
			$parid=$_GPC['id'];
			$uniacid = $_W['uniacid'];
			if ($op == "display") {
				$products = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_zizhuanl")." where uniacid=:uniacid and parid = '{$parid}' order by sord",array(":uniacid"=>$_W['uniacid']));
			}
			if ($op == "post") {
				$hz_id = $_GPC['hz_id'];
				$uniacid = $_W['uniacid'];
				$items = pdo_fetch("SELECT * FROM ".tablename("hyb_yl_zizhuanl")." where hz_id='{$hz_id}' and uniacid='{$uniacid}' ");
				if (checksubmit("submit")) {
					$data = array(
						"uniacid"=>$_W['uniacid'],
						"hz_mp3" => $_GPC['hz_mp3'],
						"hz_name"=>$_GPC['hz_name'],
						"hz_thumb"=>$_GPC['hz_thumb'], 
						"hz_count"=>$_GPC['hz_count'],
						"hz_type"=>$_GPC['hz_type'],
						"hz_zlks" =>$_GPC['hz_zlks'],
						"hz_desction"=>$_GPC['hz_desction'],
						"hz_time"=>date('Y-m-d H:i:s',time()),
						"iflouc"=>$_GPC['iflouc'],
						'dianj'=>$_GPC['dianj'],
						'aliaut'=>$_GPC['aliaut'],
						'kiguan'=>$_GPC['kiguan'],
						'parid'=>$parid
						);
					if (empty($hz_id)) {
						pdo_insert("hyb_yl_zizhuanl",$data);
						message("添加成功!",$this->createWebUrl("zzanl",array("op"=>"display",'id'=>$parid)),"success");
					}
					else
					{
						pdo_update("hyb_yl_zizhuanl",$data,array("hz_id"=>$hz_id));
						message("修改成功!",$this->createWebUrl("zzanl",array("op"=>"display",'id'=>$parid)),"success");
					}
				}

			}
			if ($op == "delete") {
				$hz_id = $_GPC['hz_id'];
				pdo_delete("hyb_yl_zizhuanl",array("hz_id"=>$hz_id));
				message("删除成功!",$this->createWebUrl("zzanl",array("op"=>"display",'id'=>$parid)),"success");
			}
			include $this->template("zzanl");
			}
			public function doWebJcxm(){
				global $_GPC, $_W;
				load()->func("tpl");
				$op = $_GPC['op'];
				$ops = array('display', 'post',"delete");
				$op = in_array($op, $ops) ? $op : 'display';
				$p_id=$_GPC['id'];
				$uniacid = $_W['uniacid'];
                if($op == 'display'){
					$total = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename("hyb_yl_jdxm")."where p_id ='{$p_id}' and uniacid = '{$uniacid}'");
					$pindex = max(1, intval($_GPC['page'])); 
					$pagesize = 10;
					$p = ($pindex-1) * $pagesize; 
					$res = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_jdxm")."where p_id ='{$p_id}' and uniacid = '{$uniacid}' order by xm_id  limit ".$p.",".$pagesize);
					$pager = pagination($total,$pindex,$pagesize);
                }
                if($op == 'post'){
                	$get =pdo_get('hyb_yl_jdxm',array('uniacid'=>$_W['uniacid'],'xm_id'=>$_GPC['xm_id']));
                	if(checksubmit('tijiao')){

                       $data=array(
                          'uniacid'=>$_W['uniacid'],
                          'p_id' =>$p_id,
                          'xmname' =>$_GPC['xmname'],
                          'jc_type'=>$_GPC['jc_type'],
                          'jc_jgtype'=>$_GPC['jc_jgtype']

                       	);
                      if(empty($_GPC['xm_id'])){
                        pdo_insert('hyb_yl_jdxm',$data);
                        message("添加成功!",$this->createWebUrl("jcxm",array("op"=>"display",'id'=>$p_id)),"success");
                      }else{
                      	pdo_update('hyb_yl_jdxm',$data,array('xm_id'=>$_GPC['xm_id'],'uniacid'=>$_W['uniacid']));
                      	message("修改成功!",$this->createWebUrl("jcxm",array("op"=>"display",'id'=>$p_id)),"success");
                      }
                	}
                }
                if($op == 'delete'){
                    $xm_id=$_GPC['xm_id'];
                    pdo_delete('hyb_yl_jdxm',array('xm_id'=>$xm_id,'uniacid'=>$uniacid));
                    message("删除成功!",$this->createWebUrl("jcxm",array("op"=>"display",'id'=>$p_id)),"success");
                }
				include $this->template("jcxm");
			}
			public function doWebJcjg(){
				global $_GPC, $_W;
				load()->func("tpl");
				$op = $_GPC['op'];
				$ops = array('jiguo', 'post',"delete");
				$op = in_array($op, $ops) ? $op : 'display';
				$xm_id=$_GPC['xm_id'];
				$uniacid = $_W['uniacid'];
				if($op =='jiguo'){
					$total = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename("hyb_yl_jcjg")."where jc_parentid ='{$xm_id}' and uniacid = '{$uniacid}'");
					$pindex = max(1, intval($_GPC['page'])); 
					$pagesize = 10;
					$p = ($pindex-1) * $pagesize; 
					$res = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_jcjg")."where jc_parentid ='{$xm_id}' and uniacid = '{$uniacid}' order by jc_id  limit ".$p.",".$pagesize);
					$pager = pagination($total,$pindex,$pagesize);
				}
				if($op =='post'){
					$get =pdo_get('hyb_yl_jcjg',array('jc_id'=>$_GPC['jc_id'],'uniacid'=>$uniacid));
                   if(checksubmit('tijiao')){
                   	$danwei = $_GPC['danwei'];
                        $data =array(
                           'uniacid'=>$_W['uniacid'], 
                           'jc_parentid'=>$xm_id,
                           'jc_name'=>$_GPC['jc_name'],
                           'jc_jgtype'=>$_GPC['jc_jgtype'],
                           'jc_danwei'=>serialize($danwei)
                        );
                        if(empty($_GPC['jc_id'])){
                           pdo_insert('hyb_yl_jcjg',$data);
                           message("添加成功!",$this->createWebUrl("jcjg",array("op"=>"jiguo",'id'=>$_GPC['id'],'xm_id'=>$xm_id)),"success");
                        }else{
                           pdo_update('hyb_yl_jcjg',$data,array('jc_id'=>$_GPC['jc_id'],'uniacid'=>$_W['uniacid']));
                           message("修改成功!",$this->createWebUrl("jcjg",array("op"=>"jiguo",'id'=>$_GPC['id'],'xm_id'=>$xm_id)),"success");
                        }
                   }
				}
				if($op =='delete'){

				}
				include $this->template("jcjg");
			}
			public function doWebDownword(){
				global $_GPC, $_W;
				load()->func("tpl");
				$uniacid = $_W['uniacid'];	
				$jd_id =$_GPC['jd_id'];
				$res = pdo_get('hyb_yl_jiandangbaogaoinfo',array('jd_id'=>$_GPC['jd_id'],'uniacid'=>$uniacid));
				$useropenid = $res['useropenid'];
				$row = pdo_fetchall('SELECT * from'.tablename('hyb_yl_jiandangbaogaoinfo')." where uniacid = '{$uniacid}' and useropenid='{$useropenid}' ");
                $u_thumb =$_GPC['u_thumb'];
				foreach ($row as &$value) {
					$value['info'] = unserialize($value['info']);
					foreach($value['info'] as $k=>$v) $res[$k][] = $v;

				}
				//var_dump($row);
				require_once dirname(__FILE__) .'/inc/DownWord.php';
				$helper = new DownWord($row,$u_thumb);
                $return = $helper->Word();
			}
		}