<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//根据 op 执行不同操作
switch($_GPC['op']){
//		数据查询
	case "query":
		$where = [];
		$time = time();
		if($_GPC['key']){
			$where[] ="(t1.name LIKE '%{$_GPC['key']}%' or t1.tel LIKE '%{$_GPC['key']}%' or t2.name LIKE '%{$_GPC['key']}%')";
		}
		if($_GPC['is_member'] == 1){
			$where[] = "t1.end_time > {$time}";
		}
		if($_GPC['is_member'] == 2){
			$where[] = "(t1.end_time is null or t1.end_time < {$time})";
		}
        $_GPC['do'] = 'user';
		$this->query2($where);
		exit();
//	绑定后台用户
	case "bind":
		$user_id = $_GPC['id'];
		$admin_id = $_GPC['admin_id'];
		$ret=pdo_update("yzhyk_sun_user",['admin_id'=>$admin_id],array('id'=>$user_id));
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'绑定失败',
            ));
        }
		break;
//	后台用户解绑
	case "batchunbind":
		$ids = explode(',',$_GPC['ids']);
		$ret=pdo_update("yzhyk_sun_user",['admin_id'=>''],array('id'=>$ids));
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'解绑失败',
            ));
        }
		break;
//	会员充值
	case "recharge":
		$user_id = $_GPC['id'];
		$recharge = $_GPC['recharge'];
		$user = pdo_get("yzhyk_sun_user",array('id'=>$user_id));
		$ret=pdo_update("yzhyk_sun_user",['balance'=>($user['balance']?:0)+$recharge],array('id'=>$user_id));
        if($ret){
            // 余额账单
            $bill_data['type']  = 8;
            $bill_data['user_id'] = $user_id;
            $bill_data['balance'] = $recharge;
            $bill_data['content'] = '后台充值';
            $bill = new bill();
            $bill->insert($bill_data);
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'充值失败',
            ));
        }
		break;
//  会员减值
    case "recharge1":
        $user_id = $_GPC['id'];
        $recharge = $_GPC['recharge'];
        $user = pdo_get("yzhyk_sun_user",array('id'=>$user_id));
        if($user['balance']-$recharge<0){
            echo json_encode(array(
                'code'=>1,
                'msg'=>'操作失败',
            ));
        }else{
            $ret=pdo_update("yzhyk_sun_user",['balance'=>($user['balance']?:0)-$recharge],array('id'=>$user_id));
            if($ret){
                // 余额账单
                $bill_data['type']  = 9;
                $bill_data['user_id'] = $user_id;
                $bill_data['balance'] = $recharge;
                $bill_data['content'] = '后台扣除';
                $bill = new bill();
                $bill->insert($bill_data);
                echo json_encode(array(
                    'code'=>0,
                ));
            }else{
                echo json_encode(array(
                    'code'=>1,
                    'msg'=>'操作失败',
                ));
            }
        }
        
        break;
	case "delete":
		global $_GPC, $_W;
		$ret=pdo_delete("yzhyk_sun_user",array('id'=>$_GPC['id']));
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'删除失败',
            ));
        }
		break;
	case "batchdelete":
		global $_GPC, $_W;
		$ids = explode(',',$_GPC['ids']);
		$ret=pdo_delete("yzhyk_sun_user",array('id'=>$ids));
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'删除失败',
            ));
        }
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
