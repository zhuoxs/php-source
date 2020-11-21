<?php
	global $_W,$_GPC;
	include 'common.php';
	$cx=$_GPC['cx'];
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	
	$res = pdo_fetchall("SELECT * FROM " . tablename('bc_community_help') . " WHERE weid=" . $_W['uniacid'] .$cx."  ORDER BY id DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
         
		
        $ht.='<tr class="gradeX tx-c" id="help'.$item['id'].'">'
				.'<td>救助人姓名:'.$item['uname'].'</td>'
				.'<td>年龄:'.$item['age'].'</td>'
				.'<td><img src="'. tomedia($item['cover']).'" class="cover"></td>'
				.'<td>申请救助时间:'. gettime($item['createtime']).'</td>'
				.'<td>'
					.'<div class="tpl-table-black-operation">'
						.'<a href="'. $this->createMobileUrl('manage_help_edit',array('id'=>$item['id'])).'" >'
							.'<button type="button" class="mui-btn mui-btn-primary"><i class="am-icon-pencil"></i> 查看</button>'
						.'</a>'
						.'<a href="javascript:;" class="tpl-table-black-operation-del" onclick="helpdel('.$item['id'].');">'   
							.'&nbsp;&nbsp;<button type="button" class="mui-btn mui-btn-danger"><i class="am-icon-trash"></i> 删除</button>'
						.'</a>'
					.'</div>'
				.'</td>'
			.'</tr>';
				
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>