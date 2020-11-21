<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('ymktv_sun_system',array('uniacid'=>$_W['uniacid']));

    if(checksubmit('submit')){
            $data['pt_name']=$_GPC['pt_name'];
            $data['tel']=$_GPC['tel'];
            $data['details']=html_entity_decode($_GPC['details']);
            $data['uniacid']=$_W['uniacid'];       
            $data['total_num']=$_GPC['total_num'];
            $data['support']=$_GPC['support'];
            $data['bq_name']=$_GPC['bq_name'];
            $data['link_name']=$_GPC['link_name'];
            $data['link_logo']=$_GPC['link_logo'];
            $data['bq_logo']=$_GPC['bq_logo'];
            $data['tz_appid']=trim($_GPC['tz_appid']);
            $data['tz_name']=$_GPC['tz_name'];
            $data['fontcolor']=$_GPC['fontcolor'];
            $data['address']=$_GPC['address'];
            $data['integral']=$_GPC['integral'];
            $data['shop_img'] = $_GPC['shop_img'];
            $data['integral_img'] = $_GPC['integral_img'];
            $data['js_font'] = $_GPC['js_font'];
            $data['js_logo'] = $_GPC['js_logo'];
            $data['js_tel'] = $_GPC['js_tel'];
            $data['address_zb'] = $_GPC['address_zb'];
            $data['jie_tel'] = $_GPC['jie_tel'];
            $data['drink_open'] = $_GPC['drink_open'];
			$data['over_open'] = $_GPC['over_open'];
        if($_GPC['color']){
                $data['color']=$_GPC['color'];
            }else{
                $data['color']="#ffffff";
            }

        if ($_GPC['id'] == '') {
            $res = pdo_insert('ymktv_sun_system', $data);
            if ($res) {
                message('添加成功', $this->createWebUrl('settings', array()), 'success');
            } else {
                message('添加失败', '', 'error');
            }
        } else {
            $res = pdo_update('ymktv_sun_system', $data, array('id' => $_GPC['id']));
            if ($res) {
                message('编辑成功', $this->createWebUrl('settings', array()), 'success');
            } else {
                message('编辑失败', '', 'error');
            }
        }
        }
include $this->template('web/settings');