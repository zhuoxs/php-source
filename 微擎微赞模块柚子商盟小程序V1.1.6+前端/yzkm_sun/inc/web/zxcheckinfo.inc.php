<?php
global $_GPC,$_W;
$GLOBALS['frames'] = $this->getMainMenu();
// $uniacid=$_W['uniacid'];
// $where="WHERE  a.uniacid=$uniacid";
 // $type=pdo_getall('yzkm_sun_zx_type',array('uniacid'=>$_W['uniacid']));
// $sql = " SELECT * FROM " . tablename('yzkm_sun_zx')."a left join ".tablename('yzkm_sun_user')."b on a.userId=b.id ".$where;
// $sql = " SELECT * FROM " . tablename('yzkm_sun_zx').$where;
// p($sql);
$data = pdo_getall('yzkm_sun_zx',array('uniacid'=>$_W['uniacid']));
// p($data);
$type= pdo_getall('yzkm_sun_zx',array('uniacid'=>$_W['uniacid']));

	foreach($type as $key=>$val) {
		// if ($val['id']==$_GPC['id']) {
		    if($val['content']){
		         $img = explode('</p>',$val['content']);
		    }else{
		       $img = '';
			}
		// }		
	}
	// p($img);die;
// $info=pdo_get('yzkm_sun_zx',array('id'=>$_GPC['id']));
// if($info['imgs']){
//             if(strpos($info['imgs'],',')){
//             $imgs= explode(',',$info['imgs']);
//         }else{
//             $imgs=array(
//                 0=>$info['imgs']
//                 );
//         }
//         }
// if(checksubmit('button')){
//         $data['type_id']=$_GPC['type_id'];
//         $data['title']=$_GPC['title'];
//         $data['content']=html_entity_decode($_GPC['content']);
//         $data['time']=date('Y-m-d H:i:s');
//         $data['uniacid']=$_W['uniacid'];
//         $data['cityname']=$_GPC['cityname'];
//        if($_GPC['imgs']){
//             $data['imgs']=implode(",",$_GPC['imgs']);
//         }else{
//             $data['imgs']='';
//         }
//         $res=pdo_update('yzkm_sun_zx',$data,array('id'=>$_GPC['id']));
//         if($res){
//              message('编辑成功！', $this->createWebUrl('zxcheckmanager'), 'success');
//         }else{
//              message('编辑失败！','','error');
//         }
    
// }
include $this->template('web/zxcheckinfo');
