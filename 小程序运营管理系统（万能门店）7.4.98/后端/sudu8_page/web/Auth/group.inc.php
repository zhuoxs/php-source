<?php 
   	global $_GPC, $_W;
	$act = isset(self::$_GPC["act"])?self::$_GPC["act"]:"display";
	if($act == "display"){
		global $_GPC, $_W;
	    $uniacid = $_W['uniacid'];
	    $cateid = $_GPC['cateid'];
	    $chid = $_GPC['chid'];
        $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_usergroup'));
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;  
        $start = ($pageindex-1) * $pagesize;
        $pager = pagination($total, $pageindex, $pagesize); 
		$item = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_usergroup') ." ORDER BY id DESC LIMIT ".$start.",".$pagesize);
		return include self::template('web/Auth/group');
	}

	if($act == "add"){
		return include self::template('web/Auth/addgroup');
	}
	
    if($act == 'saveaddgroup'){
	    global $_W,$_GPC;
	    $insert_group = array(
	        'name' => trim($_GPC['name']),
	        'remark' => trim($_GPC['remark']),
	        'createtime' => date('Y-m-d H:i:s',time())
	    );
	    if (empty($insert_group['name'])) {
	        echo json_encode(['code' => 0,'message' => '必须输入权限组名，可以包括汉字、字母（不区分大小写）、数字、下划线和句点。']);exit;
	    }
	
	    
	    $groups = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_usergroup')." WHERE `name` = :name", array(":name" => $insert_group['name']));
	    if(!empty($groups)){
	        echo json_encode(['code' => 0,'message' => '权限组名称重复']);exit;
	    }

	    pdo_insert("sudu8_page_usergroup",$insert_group);
	    return $this->returnResult(1,'添加成功');
	}

	if($act == 'info'){
		global $_W,$_GPC;
	    $id = $_GPC['id'];
	    $group = pdo_get("sudu8_page_usergroup",array("id" => $id));
	    echo json_encode($group);
	    exit;
	}

	if($act == 'update'){
		global $_W,$_GPC;
	    $id = $_GPC['id'];
	    $name = $_GPC['name'];
	    $remark = $_GPC['remark'];
	    $group = pdo_get("sudu8_page_usergroup",array("id" => $id));
	    $group1 = pdo_get("sudu8_page_usergroup",array("name" => $name, "id <>" => $id));
	    if(empty($group)){
	        echo json_encode(['code' => 0,'message' => "该权限组不存在"]);exit;
	    }else if(!empty($group1)){
			echo json_encode(['code' => 0,'message' => "权限组名称重复"]);exit;
	    }else{
	    	$res = pdo_update("sudu8_page_usergroup", array("name" => $name, "remark" => $remark), array("id" => $id));
	    }
	    if($res){
			echo json_encode(['code' => 1,'message' => "修改成功"]);
			exit;	    	
	    }else{
			echo json_encode(['code' => 0,'message' => "修改失败"]);
	    }
	}