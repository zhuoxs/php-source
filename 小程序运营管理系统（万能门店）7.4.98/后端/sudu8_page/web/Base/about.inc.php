<?php 
	
	global $_GPC, $_W;
    $uniacid = $_W['uniacid'];
    $cateid = $_GPC['cateid'];
    $chid = $_GPC['chid'];

	$item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_about') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));

    if (checksubmit('submit')) {

        $data = array(

            'uniacid' => $_W['uniacid'],

            'header' => intval($_GPC['header']),

            'tel_box' => intval($_GPC['tel_box']),

            'serv_box' => intval($_GPC['serv_box']),

            'content' => htmlspecialchars_decode($_GPC['content'], ENT_QUOTES),

        );

        if(empty($item)){

            pdo_insert('sudu8_page_about', $data);

        }

        else{

            pdo_update('sudu8_page_about', $data ,array('uniacid' => $uniacid));

        }

        //var_dump($data);

        message('公司介绍信息更新成功!', $this->createWebUrl('base', array('op'=>'about',"cateid"=>$cateid,"chid"=>$chid)), 'success');

    }



return include self::template('web/Base/about');