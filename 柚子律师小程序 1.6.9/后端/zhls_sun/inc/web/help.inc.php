<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {

   $list = pdo_getall('zhls_sun_help',array('uniacid'=>$_W['uniacid']),array() , '' , 'sort ASC');
       
} elseif ($operation == 'post') {
   $list = pdo_get('zhls_sun_help',array('id'=>$_GPC['id']));
        if(checksubmit('submit')){
           
            $data['created_time']=date("Y-m-d H:i:s");
            $data['question']=$_GPC['question'];
            $data['answer']=$_GPC['answer'];
            $data['sort']=$_GPC['sort'];
            $data['uniacid']=$_W['uniacid'];
            if($_GPC['id']==''){
                $res=pdo_insert('zhls_sun_help',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('help',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('zhls_sun_help', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('help',array()),'success');
                }else{
                message('编辑失败','','error');
                }
            }
        }
} elseif ($operation == 'delete') {
    $id=$_GPC['id'];
   
        $result = pdo_delete('zhls_sun_help', array('id'=>$id));
        if($result){
            message('删除成功',$this->createWebUrl('help',array()),'success');
        }else{
            message('删除失败','','error');
        }
}
include $this->template('web/help');