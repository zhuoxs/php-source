<?php
	global $_GPC, $_W;
	$uniacid = $_W['uniacid'];
	$id = intval($_GPC['id']);

	$zan = $_GPC['zan'];
    $openid = $_GPC['openid'];

	$follow = pdo_fetch("SELECT id,follow FROM ".tablename('sudu8_page_comment') ."WHERE uniacid= :uniacid and id =:id",array(':uniacid' => $uniacid,':id' => $id));

	$zan_rec = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_art_comment_zan')." WHERE uniacid = :uniacid and comid = :comid and openid = :openid", array(":uniacid" => $uniacid, ":comid" => $id, ":openid" => $openid));
    if($zan == 2){
        if(!$zan_rec){
        	pdo_insert("sudu8_page_art_comment_zan",array(
        		'uniacid' => $uniacid,
        		'comid' => $id,
        		'openid' => $openid,
        		'zan' => 1,
        		'createtime' => time()
        		));
        }else{
        	pdo_update("sudu8_page_art_comment_zan", array('zan' => 1), array(
        		'uniacid' => $uniacid,
        		'comid' => $id,
        		'openid' => $openid
        		));
        }
        $follow = intval($follow['follow']) + 1;
        $data = array(
            'id' => $id,
            'follow' => $follow,
        );
        $result = pdo_update("sudu8_page_comment", $data, array("id" => $id));
        if ($result) {
        	$datas['result'] = 1; 
            return $this->result(0, 'success', $datas);
        }
    }else if($zan == 1){
        if(!$zan_rec){
        	pdo_insert("sudu8_page_art_comment_zan", array(
        			'uniacid' => $uniacid,
        			'comid' => $id,
        			'openid' => $openid,
        			'zan' => 2,
        			'createtime' => time()
        		));
        }else{
            pdo_update("sudu8_page_art_comment_zan", array('zan' => 2), array(
        		'uniacid' => $uniacid,
        		'comid' => $id,
        		'openid' => $openid
        		));
        }
        $follow = intval($follow['follow']) - 1;
        $data = array(
            'id' => $id,
            'follow' => $follow,
        );
        $result = pdo_update("sudu8_page_comment", $data, array("id" => $id));
        if ($result) {
        	$datas['result'] = 2; 
            return $this->result(0, 'success', $datas);
        }
    }