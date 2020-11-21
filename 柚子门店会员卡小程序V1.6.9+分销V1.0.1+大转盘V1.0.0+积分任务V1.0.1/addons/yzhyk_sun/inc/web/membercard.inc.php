<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//    根据 op 执行不同操作
switch($_GPC['op']){
//    保存-新增、修改
    case "save":
        $data['name'] = $_GPC['name'];
        $data['days'] = $_GPC['days'];
        $data['amount'] = $_GPC['amount'];

        $this->save($data);
        break;
    case "newcode":
        $code = md5($uniacid.uniqid());
        $id = $_GPC['id'];

        $data['recharge_code'] = $code;
        $data['membercard_id'] = $id;

        $rechargecode = new rechargecode();
        $res = $rechargecode->insert($data);

        if($res){
            echo json_encode(['code'=>0,'rechargecode'=>$code]);
        }else{
            echo json_encode(['code'=>1,'msg'=>'生成失败']);
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
