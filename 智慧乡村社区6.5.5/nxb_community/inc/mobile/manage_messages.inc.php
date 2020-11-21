<?php
global $_W, $_GPC;
include 'common.php';
load()->func('tpl');
$base=$this->get_base(); 
$title=$base['title'];
//查询缓存是否存在，如果有，就直接登录后台，如果没有就显示登录页
$webtoken = $_SESSION['webtoken']; //cache_load('webtoken');
if($webtoken==''){
	header('Location: '.$_W['siteroot'].'web/index.php?c=user&a=login&referer='.urlencode($_W['siteroot'].'app/'.$this->createMobileUrl('manage_login_go')));
}else{
	//通过缓存查找到管理员信息
	$manageid = $_SESSION['manageid']; //cache_load('manageid');
	$manage=pdo_fetch("SELECT * FROM ".tablename('bc_community_jurisdiction')." WHERE weid=:uniacid AND id=:id",array(':uniacid'=>$_W['uniacid'],'id'=>$manageid));
	$nav=intval($_GPC['nav']);
	if($nav==0){
		$nav=1;
	}
	$townid=$manage['townid'];



	if($_GPC['act'] == 'send_full'){
	    if(empty($_GPC['type'])){
	        message('请输入消息类别');
        }
        if(empty($_GPC['title'])){
            message('请输入消息标题');
        }
        if(empty($_GPC['content'])){
            message('请输入消息内容');
        }

        if(count($_GPC['receive_mid'])<1 && count($_GPC['receive_townid'])<1){
	        message('请选择接收对象');
        }

        if(count($_GPC['receive_townid'])>0){
            $_GPC['receive_mid'] = array();
	        foreach ($_GPC['receive_townid'] as $value){
	            if($manage['lev']==2){
                    $grade = pdo_getcolumn('bc_community_authority', array('town_id' => $value,'authortitle	'=>'村长'), 'id');
                    $tmp = pdo_getall("bc_community_member",array('grade'=>$grade),array('mid'));
                }else if($manage['lev']==0){
                    $grade = pdo_getcolumn('bc_community_authority', array('town_id' => $value,'authortitle	'=>'镇长'), 'id');
                    $tmp = pdo_getall("bc_community_member",array('grade'=>$grade),array('mid'));
                }
	            foreach ($tmp as $v){
                    $_GPC['receive_mid'][] = $v['mid'];
                }
            }
        }

        $data = array();
        $data['weid'] = $_W['uniacid'];
        if($manage['lev']==2) {
            $data['townid'] = $townid;
        }else if($manage['lev'] == 3){
            $data['villageid'] = $townid;
        }
        $data['type'] = addslashes($_GPC['type']);
        $data['manageid'] = $manageid;
        $data['title'] = addslashes($_GPC['title']);
        $data['content'] = addslashes($_GPC['content']);
        $data['status'] = 0;
        $data['ctime'] = time();
        $res = pdo_insert('bc_community_messages',$data);



        if($res){
            $message_id = pdo_insertid();
            foreach ($_GPC['receive_mid'] as $value){
                $data = array();
                $data['weid'] = $_W['uniacid'];
                $data['message_id'] = $message_id;
                $data['mid'] = $value;
                pdo_insert('bc_community_messages_record',$data);
            }
        }



        message('发送成功！',$this -> createMobileUrl('manage_messages',array('nav'=>15)), 'success');

	    exit;
    }


    if($_GPC['act'] == 'delete'){
        $id=intval($_GPC['id']);
        $result = pdo_delete('bc_community_messages', array('id' => $id));
        $result = pdo_delete('bc_community_messages_record', array('message_id' => $id));
        if (!empty($result)) {
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        } else {
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
        exit;
    }






	
    if($_GPC['act'] == 'send'){
        if($manage['lev']<=2){
           $townlist = pdo_fetchall("SELECT * FROM ".tablename("bc_community_town")." WHERE weid=:uniacid AND pid=$townid",array(':uniacid'=>$_W['uniacid']));
        }else if($manage['lev']==3){
            $userlist = pdo_fetchall("SELECT * FROM ".tablename("bc_community_member")." WHERE weid=:uniacid AND menpai=$townid",array(':uniacid'=>$_W['uniacid']));
        }
        include $this->template('manage_messages_send');
    }else{
        $sql = " AND manageid = $manageid";
        $count = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_messages')." WHERE weid=:uniacid $sql ",array(':uniacid'=>$_W['uniacid']));
        $page = intval($_GPC['page'])<1?1:intval($_GPC['page']);
        $psize = 10;
        $page_count = ceil($count / $psize);
        $start = ($page-1)*$psize;
        $list = pdo_fetchall("SELECT * FROM ".tablename('bc_community_messages')." WHERE weid=:uniacid $sql ORDER BY ctime DESC LIMIT $start,$psize",array(':uniacid'=>$_W['uniacid']));

        $prevpage = $page - 1;
        if($prevpage>=1){
            $prevpageurl = $this->createMobileUrl('manage_post',array('nav'=>12,'act'=>'comment','page'=>$prevpage));
        }
        $nextpage = $page + 1;
        if($nextpage<=$page_count){
            $nextpageurl = $this->createMobileUrl('manage_post',array('nav'=>12,'act'=>'comment','page'=>$nextpage));
        }
        $s = $page - 2;
        $pages = array();
        for($i = 0; $i<=4; $i++){
            $t = $i + $s;
            if($t>=1 && $t<=$page_count){
                $pages[] = array(
                    'page' => $t,
                    'url' => $this->createMobileUrl('manage_post',array('nav'=>11,'act'=>'comment','page'=>$t)),
                    'active' => ($t==$page?true:false)
                );
            }
        }
        foreach ($list as $key=>$value){
            $list[$key]['read_count'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_messages_record')." WHERE weid=:uniacid AND message_id=".$value['id']." AND status=1",array(':uniacid'=>$_W['uniacid'])));
            $list[$key]['total_count'] = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename('bc_community_messages_record')." WHERE weid=:uniacid AND message_id=".$value['id'],array(':uniacid'=>$_W['uniacid'])));
        }


        include $this->template('manage_messages');
    }

}





?>