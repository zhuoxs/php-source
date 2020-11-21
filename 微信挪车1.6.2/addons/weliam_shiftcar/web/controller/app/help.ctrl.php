<?php 
defined('IN_IA') or exit('Access Denied');
$ops = array('category_list','answer_list','category_edit','answer_edit','change_status','category_delete','answer_delete','change_im');
$op = in_array($op, $ops) ? $op : 'answer_list';

if($op == 'answer_list'){
	//解答列表
	$category_list = pdo_getall('weliam_shifcar_category',array('uniacid'=>$_W['uniacid'],'is_show'=>2));
	
	$condition_ca = !empty($_GPC['categoryid']) ? ' and categoryid='.$_GPC['categoryid'] : ' ';
	$condition_se = !empty($_GPC['search']) ? " and title like '%".$_GPC['search']."%'" : ' ';
	$where = " where uniacid=".$_W['uniacid'].$condition_ca.$condition_se;
	
	$size = 15;
	$page = $_GPC['page'];
	$sqlTotal = pdo_sql_select_count_from('weliam_shifcar_question') . $where;
	$sqlData = pdo_sql_select_all_from('weliam_shifcar_question') . $where ." order by sort desc,createtime desc";
	$list = pdo_pagination($sqlTotal, $sqlData, $params, '', $total, $page, $size);
	foreach($list as $key => $value){
		$category = pdo_get('weliam_shifcar_category',array('uniacid'=>$_W['uniacid'],'id'=>$value['categoryid']));
		$list[$key]['category_name'] = $category['name'];
	}
	$pager = pagination($total, $page, $size);

	include wl_template('app/help/answer');
}

if($op == 'answer_edit'){
	//编辑解答
	$answerid = $_GPC['answerid'];
	$category_list = pdo_getall('weliam_shifcar_category',array('uniacid'=>$_W['uniacid']));
	if(!empty($answerid)){
		$list = pdo_get('weliam_shifcar_question',array('uniacid'=>$_W['uniacid'],'id'=>$answerid));
	}
	
	if (checksubmit('submit')) {
		$data['uniacid'] = $_W['uniacid'];
		$data['title'] = $_GPC['title'];
		$data['answer'] = htmlspecialchars_decode($_GPC['answer']);
		$data['categoryid'] = $_GPC['categoryid'];
		$is_show = $_GPC['is_show'];
		if($is_show == 'on'){
			$data['is_show'] = 2;
		}else{
			$data['is_show'] = 1;
		}
		$data['sort'] = $_GPC['sort'];
		if(empty($answerid)){
			$data['createtime'] = time();
			$data['scan'] = 0;
			if(pdo_insert('weliam_shifcar_question',$data)){
				message('创建成功',web_url('app/help/answer_list'),'success');
			}else{
				message('创建失败',web_url('app/help/answer_list'),'error');
			}
		}else{
			pdo_update('weliam_shifcar_question',$data,array('id'=>$answerid));
			message('修改成功',web_url('app/help/answer_list'),'success');
		}
	}
	include wl_template('app/help/answer');
}

if($op == 'answer_delete'){
	//删除解答
	$answerid = $_GPC['answerid'];
	if(empty($answerid)){
		message('未查询到该记录',web_url('app/help/answer_list'),'error');
	}
	
	if(pdo_delete('weliam_shifcar_question',array('uniacid'=>$_W['uniacid'],'id'=>$answerid))){
		message('删除成功',web_url('app/help/answer_list'),'success');
	}else{
		message('删除失败',web_url('app/help/answer_list'),'error');
	}
}

if($op == 'category_list'){
	//解答分类
	$list = pdo_fetchall("select * from".tablename('weliam_shifcar_category')."where uniacid=:uniacid order by sort desc,createtime desc",array(':uniacid'=>$_W['uniacid']));
	$all_answer_num = 0;
	$all_scan = 0;
	foreach($list as $key => $value){
		$answer_num = pdo_fetch("select count(id),sum(scan) from".tablename('weliam_shifcar_question')." where uniacid=:uniacid and categoryid=:categoryid",array(':uniacid'=>$_W['uniacid'],':categoryid'=>$value['id']));
		$list[$key]['answer_num'] = $answer_num['count(id)'];
		$list[$key]['scan'] = !empty($answer_num['sum(scan)'])?$answer_num['sum(scan)']:0;
		$all_answer_num += $list[$key]['answer_num'];
		$all_scan += $list[$key]['scan'];
	}
	$all_scan = $all_scan == 0 ? 1 : $all_scan;
	$all_answer_num = $all_answer_num == 0 ? 1 : $all_answer_num;
	include wl_template('app/help/category');
}

if($op == 'category_edit'){
	//编辑解答
	$categoryid = $_GPC['categoryid'];
	if(!empty($categoryid)){
		$list = pdo_get('weliam_shifcar_category',array('uniacid'=>$_W['uniacid'],'id'=>$categoryid));
	}
	if (checksubmit('submit')) {
		$categoryid = $_GPC['categoryid'];
		
		$data['uniacid'] = $_W['uniacid'];
		$data['name'] = $_GPC['name'];
		$data['picture'] = $_GPC['picture'];
		$data['sort'] = $_GPC['sort'];
		$is_show = $_GPC['is_show'];
		$data['createtime'] = time();
		
		if($is_show == 'on'){
			$data['is_show'] = 2;
		}else{
			$data['is_show'] = 1;
		}

		if(empty($categoryid)){
			if(pdo_insert('weliam_shifcar_category',$data)){
				message('新分类创建成功！',web_url('app/help/category_list'),'success');
			}else{
				message('新分类创建失败！',web_url('app/help/category_list'),'error');
			}
		}else{
			pdo_update('weliam_shifcar_category',$data,array('id'=>$categoryid));
			message('修改成功',web_url('app/help/category_list'),'success');
		}
	}
	include wl_template('app/help/category');
}

if($op == 'category_delete'){
	//删除分类
	$categoryid = $_GPC['categoryid'];
	if(empty($categoryid)){
		message('未查询到该记录',web_url('app/help/category_list'),'error');
	}
	
	if(pdo_delete('weliam_shifcar_category',array('id'=>$categoryid,'uniacid'=>$_W['uniacid']))){
		pdo_delete('weliam_shifcar_question',array('categoryid'=>$categoryid,'uniacid'=>$_W['uniacid']));
		message('删除成功',web_url('app/help/category_list'),'success');
	}else{
		message('删除失败',web_url('app/help/category_list'),'error');
	}
}

if($op == 'change_status'){
	$categoryid = $_GPC['categoryid'];
	$re = pdo_get('weliam_shifcar_category',array('id'=>$categoryid));
	$is_show = $re['is_show'] == 1 ? 2 : 1;
	pdo_update('weliam_shifcar_category',array('is_show'=>$is_show),array('id'=>$categoryid));
}

if($op == 'change_im'){
	//确定是否是热点
	$answerid = $_GPC['answerid'];
	$re = pdo_get('weliam_shifcar_question',array('id'=>$answerid));
	$is_importent = $re['is_importent'] == 2 ? 1 : 2;
	pdo_update('weliam_shifcar_question',array('is_importent'=>$is_importent),array('id'=>$answerid));
	die(json_encode(array('status'=>2,'data'=>$is_importent,'msg'=>'')));
}
