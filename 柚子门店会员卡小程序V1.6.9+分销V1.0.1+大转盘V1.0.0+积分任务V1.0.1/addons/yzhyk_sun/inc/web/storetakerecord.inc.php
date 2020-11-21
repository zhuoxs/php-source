 <?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//根据 op 执行不同操作
switch($_GPC['op']){
//		数据查询
	case "query":
		$where = [];
		if($_GPC['key']){
			$where[] ="t2.name LIKE '%{$_GPC['key']}%'";
		}
		if($_GPC['state']){
			$where[] = "t1.state = {$_GPC['state']}";
		}
		$this->query2($where);
		exit();
//  批量审核通过
    case "check":
         $id = explode(',',$_GPC['id']);
         $model = new storetakerecord();
         $ret= $model->check($id);
         if($ret){
             echo json_encode(array(
                 'code'=>0,
             ));
         }else{
             echo json_encode(array(
                 'code'=>1,
                 'msg'=>'审核失败',
             ));
         }
         break;
		//	拒绝
	case "uncheck":
		$id = $_GPC['id'];
		$reason = $_GPC['reason'];

        $model = new storetakerecord();
		$ret= $model->uncheck($id,$reason);
        if($ret){
            echo json_encode(array(
                'code'=>0,
            ));
        }else{
            echo json_encode(array(
                'code'=>1,
                'msg'=>'拒绝失败',
            ));
        }
		break;
     //  打款
     case "take":
         $id = explode(',',$_GPC['id']);
         $model = new storetakerecord();
         $ret= $model->taked($id);
         if($ret){
             echo json_encode(array(
                 'code'=>0,
             ));
         }else{
             echo json_encode(array(
                 'code'=>1,
                 'msg'=>'打款失败',
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
