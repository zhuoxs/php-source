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
	
//查询当前管理员级别，获取该级别的管理的所有村镇列表

$townid=$manage['townid'];
if($townid==0){
	$townlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND lev=2 ORDER BY id DESC",array(':uniacid'=>$_W['uniacid']));
}else{
	$townlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND pid=:pid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid'],':pid'=>$townid));
}




	$nav=intval($_GPC['nav']);
	if($nav==0){
		$nav=1;
	}
	
//添加村镇
if ($_W['ispost']) {
	if (checksubmit('submit')) {
		/*
		if($_GPC['ntitle']=='' || $_GPC['ntext']=='' || $_GPC['nmenu']==''){
			message('帖子分类、帖子标题、帖子内容必填的哦~',$this->createMobileUrl('subform',array()),'error');          
     	} 

		 */
				
		$images=implode("|",$_GPC['photo']);
		$newdata = array(
			'weid'=>$_W['uniacid'],
			'lev'=>$_GPC['lev'],
			'pid'=>$manage['townid'],
			'name'=>$_GPC['uname'],
			'cover'=>$_GPC['cover'],
			'photo'=>$images,
			'remark'=>$_GPC['remark'],
			'comment'=>$_GPC['comment'],
			'status'=>0,
			'paixu'=>$_GPC['paixu'],	
			'latlong'=>$_GPC['latlong'],
			'contacts'=>$_GPC['contacts'],	
			'tel'=>$_GPC['tel'],
			'color'=>$_GPC['color'],
            'province'=>$_GPC['province'],
			'rd'=>0,	
			'ctime'=>time(),
			 );
		$res = pdo_insert('bc_community_town', $newdata);
		if (!empty($res)) {
			message('恭喜，提交成功', $this -> createMobileUrl('manage_town'), 'success');
		} else {
			message('抱歉，提交失败！', $this -> createMobileUrl('manage_town'), 'error');
		}

	}

}



    $region = array(
        '北京',
        '天津',
        '上海',
        '重庆',
        '河北',
        '河南',
        '云南',
        '辽宁',
        '黑龙江',
        '湖南',
        '安徽',
        '山东',
        '新疆',
        '江苏',
        '浙江',
        '江西',
        '湖北',
        '广西',
        '甘肃',
        '山西',
        '内蒙古',
        '陕西',
        '吉林',
        '福建',
        '贵州',
        '广东',
        '青海',
        '西藏',
        '四川',
        '宁夏',
        '海南',
        '台湾',
        '香港',
        '澳门'
    );
	
	
	include $this->template('manage_town');
}





?>