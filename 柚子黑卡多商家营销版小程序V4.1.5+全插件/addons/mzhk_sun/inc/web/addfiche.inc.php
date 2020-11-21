<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('mzhk_sun_gift',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']) );
$goods=pdo_getall('mzhk_sun_goods',array('uniacid'=>$_W['uniacid'],'lid'=>4));

if(checksubmit('submit')){

            $gname=$_GPC['gname'];
            $gnamearr = explode("$$$", $gname);
            if(is_array($gnamearr) && sizeof($gnamearr)>0){
                $data['gid']=$gnamearr[0];
                $data['gname']=$gnamearr[1];
            }

			$data['title']=$_GPC['title'];
			$data['content']=html_entity_decode($_GPC['content']);
			$data['pic']=$_GPC['pic'];
			$data['sort']=$_GPC['sort'];
            $data['probability']=$_GPC['probability'];
			$data['uniacid']=$_W['uniacid'];

		 	$data['createtime']=time();
		 	if(!$_GPC['id']){
                $res = pdo_insert('mzhk_sun_gift', $data);
                if($res){
                    message('新增成功',$this->createWebUrl('fiche',array()),'success');
                }else{
                    message('新增失败','','error');
                }
            }else{
                $res = pdo_update('mzhk_sun_gift',$data,array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
                if($res){
                    message('编辑成功',$this->createWebUrl('fiche',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }


		}
include $this->template('web/addfiche');