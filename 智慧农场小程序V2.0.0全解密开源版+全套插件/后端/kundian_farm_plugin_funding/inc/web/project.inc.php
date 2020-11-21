<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/13
 * Time: 16:54
 */
defined("IN_IA")or exit("Access Denied");
!defined('ROOT_PATH_FARM_FUND') && define('ROOT_PATH_FARM_FUND', IA_ROOT . '/addons/kundian_farm_plugin_funding/');
require_once ROOT_PATH_FARM_FUND .'model/order.php';
require_once ROOT_PATH_FARM_FUND .'model/project.php';
require_once ROOT_PATH .'model/user.php';
require_once ROOT_PATH .'model/common.php';
$orderModel=new Order_KundianFarmPluginFundingModel('cqkundian_farm_plugin_funding_order');
$projectModel=new Project_KundianFarmPluginFundingModel('cqkundian_farm_plugin_funding_project');
$userModel=new User_KundianFarmModel('cqkundian_farm_user');
$commonModel=new Common_KundianFarmModel('cqkundian_farm_plugin_funding_set');
checklogin();  //验证是否登录
global $_GPC,$_W;
$uniacid=$_W['uniacid'];
$op=$_GPC['op'] ? $_GPC['op'] : "index";
if($op=='index'){
    $project_total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cqkundian_farm_plugin_funding_project')." WHERE uniacid=:uniacid",array(":uniacid"=>$uniacid));
    $pageIndex=$_GPC['page'] ? $_GPC['page'] : 1;
    $pager=pagination($project_total,$pageIndex,10);
    $list=$projectModel->getProjectList(array('uniacid'=>$uniacid),$pageIndex,10);
    for ($i=0;$i<count($list);$i++){
        if($list[$i]['begin_time']>time()){
            $list[$i]['status']='未开始';
            $list[$i]['status_code']=0;
        }elseif ($list[$i]['end_time']<time()){
            $list[$i]['status']='已结束';
            $list[$i]['status_code']=1;
        }elseif ($list[$i]['target_money']<=$list[$i]['fund_money']){
            $list[$i]['status']='众筹成功';
            $list[$i]['status_code']=1;
        }else{
            $list[$i]['status']='进行中';
            $list[$i]['status_code']=2;
        }
        $list[$i]['begin_time']=date("Y-m-d",$list[$i]['begin_time']);
        $list[$i]['end_time']=date("Y-m-d",$list[$i]['end_time']);
        $list[$i]['profit_send_time']=date("Y-m-d",$list[$i]['profit_send_time']);
        $list[$i]['order_count']=pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('cqkundian_farm_plugin_funding_order')." WHERE uniacid=:uniacid AND pid=:pid",array(":uniacid"=>$uniacid,'pid'=>$list[$i]['id']));
    }
    include $this->template("web/project/index");
}

if($op=='project_edit'){
    $live=pdo_getall('cqkundian_farm_live',array('uniacid'=>$uniacid));
    if($_GPC['id']){
        $list=$projectModel->getProjectById($_GPC['id'],$uniacid);
        $list['begin_time']=date("Y-m-d",$list['begin_time']);
        $list['end_time']=date("Y-m-d",$list['end_time']);
        $list['profit_send_time']=date("Y-m-d",$list['profit_send_time']);
        $proSpec=$projectModel->getProjectSpec(array('uniacid'=>$uniacid,'pid'=>$_GPC['id']));
    }
    include $this->template("web/project/project_edit");
}

if($op=='project_save'){
    $data=array(
        'project_name'=>$_GPC['project_name'],
        'cover'=>tomedia($_GPC['cover']),
        'live_id'=>$_GPC['live_id'],
        'target_money'=>$_GPC['target_money'],
        'project_username'=>$_GPC['project_username'],
        'begin_time'=>strtotime($_GPC['begin_time']),
        'end_time'=>strtotime($_GPC['end_time']),
        'profit_send_time'=>strtotime($_GPC['profit_send_time']),
        'project_desc'=>$_GPC['project_desc'],
        'rank'=>$_GPC['rank'],
        'project_detail'=>$_GPC['project_detail'],
        'is_hot'=>$_GPC['is_hot'],
        'return_percent'=>$_GPC['return_percent'],
        'fund_fictitious_money'=>$_GPC['fund_fictitious_money'],
        'fictitious_person'=>$_GPC['fictitious_person'],
        'uniacid'=>$uniacid,
        'create_time'=>time(),
    );
    if(empty($_GPC['id'])){
        $res=pdo_insert('cqkundian_farm_plugin_funding_project',$data);
        $pid=pdo_insertid();
        $spec_price=$_GPC['spec_price'];
        $spec_desc=$_GPC['spec_desc'];
        $res1=0;
        for ($i=0;$i<count($spec_price);$i++){
            $updateSpec=array(
                'pid'=>$pid,
                'price'=>$spec_price[$i],
                'spec_desc'=>$spec_desc[$i],
                'uniacid'=>$uniacid,
            );
            $res1+=pdo_insert('cqkundian_farm_plugin_funding_project_spec',$updateSpec);
        }
    }else{
        $res=$projectModel->updateProjectData($data,array('uniacid'=>$uniacid,'id'=>$_GPC['id']));
        $spec_id=$_GPC['spec_id'];
        $spec_price=$_GPC['spec_price'];
        $spec_desc=$_GPC['spec_desc'];
        $res1=0;
        for ($i=0;$i<count($spec_price);$i++){
            $updateSpec=array(
                'pid'=>$_GPC['id'],
                'price'=>$spec_price[$i],
                'spec_desc'=>$spec_desc[$i],
                'uniacid'=>$uniacid,
            );
            $con=array('uniacid'=>$uniacid,'id'=>$spec_id[$i],'pid'=>$_GPC['id']);
            $is_exits=pdo_get('cqkundian_farm_plugin_funding_project_spec',$con);
            if(empty($is_exits)){
                $res1+=pdo_insert('cqkundian_farm_plugin_funding_project_spec',$updateSpec);
            }else{
                $res1+=pdo_update('cqkundian_farm_plugin_funding_project_spec',$updateSpec,$con);
            }
        }
    }
    if($res || $res1){
        message('操作成功',url('site/entry/project',array('m'=>'kundian_farm_plugin_funding','cate_id'=>$_GPC['cate_id'],'version_id'=>$_GPC['version_id'])));
    }else{
        message('操作失败');die;
    }
}

if($op=='pro_spec_del'){
    $id=$_GPC['id'];
    $res=pdo_delete('cqkundian_farm_plugin_funding_project_spec',array('uniacid'=>$uniacid,'id'=>$id));
    echo $res ? json_encode(array('status'=>1)) :json_encode(array('status'=>2));die;
}

if($op=='progress_list'){
    $pid=$_GPC['pid'];
    $list=$projectModel->getProgressList(array('pid'=>$_GPC['pid'],'uniacid'=>$uniacid));
    for ($i=0;$i<count($list);$i++){
        $list[$i]['pro_time']=date("m月d日",$list[$i]['pro_time']);
    }
    include $this->template('web/project/progress_list');
}

if($op=='progress_edit'){
    $pid=$_GPC['pid'];
    $id=$_GPC['id'];
    if($id){
        $list=pdo_get('cqkundian_farm_plugin_funding_progress',array('uniacid'=>$uniacid,'id'=>$id));
        $list['src']=unserialize($list['src']);
        $list['pro_time']=date("Y-m-d",$list['pro_time']);
    }else{
        $list['pro_time']=date('Y-m-d',time());
    }

    include $this->template('web/project/progress_edit');
}

if($op=='progress_save'){
    $data=array(
        'pro_time'=>strtotime($_GPC['pro_time']),
        'content'=>$_GPC['content'],
        'src'=>serialize($_GPC['src']),
        'pid'=>$_GPC['pid'],
        'uniacid'=>$uniacid,
        'create_time'=>time(),
    );
    if(empty($_GPC['id'])){
        $res=pdo_insert('cqkundian_farm_plugin_funding_progress',$data);
    }else{
        $res=pdo_update('cqkundian_farm_plugin_funding_progress',$data,array('uniacid'=>$uniacid,'id'=>$_GPC['id']));
    }
    if($res){
        message('操作成功',url('site/entry/project',array('m'=>"kundian_farm_plugin_funding",'op'=>'progress_list','pid'=>$_GPC['pid'])));
    }else{
        message('操作成功');
    }
}

if($op=='progress_del'){
    $id=$_GPC['id'];
    $res=pdo_delete('cqkundian_farm_plugin_funding_progress',array('uniacid'=>$uniacid,'id'=>$id));
    echo $res ? json_encode(array('status'=>1,'msg'=>'操作成功')) : json_encode(array('status'=>2,'msg'=>'操作失败'));die;
}

if($op=='project_del'){
    $id=$_GPC['id'];
    $res=pdo_delete('cqkundian_farm_plugin_funding_project',array('uniacid'=>$uniacid,'id'=>$_GPC['id']));
    $res1=pdo_delete('cqkundian_farm_plugin_funding_project_spec',array('uniacid'=>$uniacid,'pid'=>$_GPC['id']));
    echo $res ? json_encode(array('status'=>1,'msg'=>"删除成功")) : json_encode(array('status'=>1,'msg'=>'删除失败'));die;
}

//众筹列表
if($op=='funding_list'){
    $pid=$_GPC['pid'];
    $fundList=$orderModel->getFundOrder(['uniacid'=>$uniacid,'pid'=>$pid,'is_pay'=>1,'apply_delete'=>0]);
    for ($i=0;$i<count($fundList);$i++){
        $user=$userModel->getUserByUid($fundList[$i]['uid'],$uniacid);
        $fundList[$i]['user']=$user;
        $fundList[$i]['address']=unserialize($fundList[$i]['address']);
        $project=$projectModel->getProjectById($pid,$uniacid);
        $project['profit_send_time']=date('Y-m-d H:i',$project['profit_send_time']);
        $fundList[$i]['project']=$project;
        $spec=$projectModel->getProjectSpec(['id'=>$fundList[$i]['spec_id'],'uniacid'=>$uniacid],false);
        $fundList[$i]['spec']=$spec;
    }

    include $this->template('web/project/funding_list');
}

//一键全部分红
if($op=='shareOutBonus'){
    $pid=$_GPC['pid'];
    $project=$projectModel->getProjectById($pid,$uniacid);
    $cond=array('pid'=>$pid,'uniacid'=>$uniacid,'is_pay'=>1,'apply_delete'=>0,'return_type'=>1,'is_return'=>0);
    $orderData=$orderModel->getFundOrder($cond);
    if(!empty($orderData)) {
        $res = 0;
        $condition=array(
            'ikey'=>array('sms_service_provider','sms_appkey','sms_secret','sms_sign','sms_access_key','sms_access_key_secret'),
            'uniacid'=>$uniacid,
        );
        $list1=pdo_getall('cqkundian_farm_manager_set',$condition);
        $messageSet=array();
        foreach ($list1 as $key => $value) {
            $messageSet[$value['ikey']]=$value['value'];
        }
        $fundSet=$commonModel->getSetData(array('funding_return_sms'),$uniacid);
        for ($i = 0; $i < count($orderData); $i++) {
//            $money = $orderData[$i]['total_price'] * (1 + $project['return_percent'] / 100);

            $lirun=$orderData[$i]['total_price']*($project['return_percent']/100);
            $money=$orderData[$i]['total_price']+$lirun;

            if ($orderData[$i]['uid']) {

                //更新用户信息
                $res+=$userModel->updateUser(array('money +=' => $money), array('uid' => $orderData[$i]['uid'], 'uniacid' => $uniacid));
                $orderModel->updateFundOrder(array('is_return' => 1,'return_time'=>time()), array('id' => $orderData[$i]['id'], 'uniacid' => $uniacid));
                $userModel->insertRecordMoney($orderData[$i]['uid'],$money,'1','众筹' . $project['project_name'] . '分红',$uniacid);

                $orderData[$i]['address']=unserialize($orderData[$i]['address']);
                $phone=$orderData[$i]['address']['phone'];
                $project_name=$project['project_name'];
                $sms_param="{name:'$phone',project:'$project_name'}";
                $commonModel->sendAliyunSms($messageSet,$fundSet['funding_return_sms'],$orderData[$i]['address']['phone'],$sms_param);
            }
        }
        if ($res) {
            $projectModel->updateProjectData(array('is_return' => 1), array('id' => $pid, 'uniacid' => $uniacid));
            echo json_encode(['code'=>0,'msg'=>'操作成功']);die;
        } else {
            echo json_encode(['code'=>-1,'msg'=>'操作失败']);die;
        }
    }else{
        $projectModel->updateProjectData(array('is_return' => 1), array('id' => $pid, 'uniacid' => $uniacid));
        echo json_encode(['code'=>0,'msg'=>'没有要分红的订单']);die;
    }
}


