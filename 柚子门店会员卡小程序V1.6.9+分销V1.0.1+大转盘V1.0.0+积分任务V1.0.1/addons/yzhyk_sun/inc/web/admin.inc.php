<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//根据 op 执行不同操作
switch($_GPC['op']){
	case "query":
		$where = [];
		if($_GPC['key']){
			$where[] ="(name LIKE '%{$_GPC['key']}%' or code LIKE '%{$_GPC['key']}%')";
		}
		$this->query2($where);
		exit();
//    保存-新增、修改
	case "save":

		$data['name'] = $_GPC['name'];
		$data['code'] = $_GPC['code'];
		if($_GPC['password']){
			$data['password'] = md5($_GPC['password']);
		}

		$this->save($data);
		break;

//    调用公共的方法
	default:
		$fun_name = $_GPC['op'];
		if(method_exists($this,$fun_name)){
			$this->{$fun_name}();
		}else{
			$this->display();
		}
}
