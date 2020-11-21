<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$type = isset($_GPC['status'])?$_GPC['status']:2;
$build_id = isset($_GPC['build'])?$_GPC['build']:-1;
$servies = pdo_getall('ymktv_sun_servies',array('uniacid'=>$_W['uniacid']));
$build = pdo_getall('ymktv_sun_building',array('uniacid'=>$_W['uniacid']));

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

//p($build);die;
if($_GPC['op']=='build'){
    $build_id = $_GPC['build'];
	$sql = "select * from ".tablename('ymktv_sun_roomorder')." where uniacid=".$_W['uniacid']." order by time desc";
	$total = pdo_fetchcolumn("select count(*) from ".tablename('ymktv_sun_roomorder')." where uniacid=".$_W['uniacid']." order by time desc");

	$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $orders=pdo_fetchall($select_sql);
	if($orders){
		foreach($orders as $k=>$v){
			$goods = pdo_get('ymktv_sun_goods',array('uniacid'=>$_W['uniacid'],'id'=>$v['gid']),array('room_num','type_id'));
			if(!$v['type_name']){
				$goodstype = pdo_get('ymktv_sun_type',array('uniacid'=>$_W['uniacid'],'id'=>$goods['type_id']),array('type_name'));
				
				if($goodstype){
					$orders[$k]['type_name'] = $goodstype['type_name'];
				}
			}
			if(!$v['room_num']){
				if($goods){
					$orders[$k]['room_num'] = $goods['room_num'];
				}
			}
		}
	}
    $order = array();
    if($build_id==-1){
        $order = $orders;
    }else{
        foreach ($orders as $k=>$v){
            if($build_id == $v['build_id']){
                $order[] = $v;
            }
        }
    }
}elseif($_GPC['op']=='status'){
    $type = $_GPC['status'];
    //$sql = ' SELECT * FROM ' . tablename('ymktv_sun_goods') . ' g ' . ' JOIN ' . tablename('ymktv_sun_roomorder') . ' r ' . ' ON ' . ' g.id=r.gid' . ' WHERE ' . ' r.uniacid=' . $_W['uniacid'] . ' AND ' . ' r.status=' . $_GPC['status'] . ' ORDER BY ' . ' r.time DESC';
    //$total = pdo_fetchcolumn(' SELECT count(*) FROM ' . tablename('ymktv_sun_goods') . ' g ' . ' JOIN ' . tablename('ymktv_sun_roomorder') . ' r ' . ' ON ' . ' g.id=r.gid' . ' WHERE ' . ' r.uniacid=' . $_W['uniacid'] . ' AND ' . ' r.status=' . $_GPC['status'] . ' ORDER BY ' . ' r.time DESC');

	$sql = "select * from ".tablename('ymktv_sun_roomorder')." where uniacid=".$_W['uniacid']." and status=".$_GPC['status']." order by time desc";
	$total = pdo_fetchcolumn("select count(*) from ".tablename('ymktv_sun_roomorder')." where uniacid=".$_W['uniacid']." and status=".$_GPC['status']." order by time desc");

	$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $order = pdo_fetchall($select_sql);

	if($order){
		foreach($order as $k=>$v){
			$goods = pdo_get('ymktv_sun_goods',array('uniacid'=>$_W['uniacid'],'id'=>$v['gid']),array('room_num','type_id'));
			if(!$v['type_name']){
				$goodstype = pdo_get('ymktv_sun_type',array('uniacid'=>$_W['uniacid'],'id'=>$goods['type_id']),array('type_name'));
				
				if($goodstype){
					$order[$k]['type_name'] = $goodstype['type_name'];
				}
			}
			if(!$v['room_num']){
				if($goods){
					$order[$k]['room_num'] = $goods['room_num'];
				}
			}
		}
	}

    /*foreach ($order as $k=>$v){
        $order[$k]['type_name'] = pdo_getcolumn('ymktv_sun_type',array('uniacid'=>$_W['uniacid'],'id'=>$v['type_id']),'type_name');
    }*/

}elseif($_GPC['op']=='search' && $_GPC['keywords']){
	if($_GPC['keywords']){
			
		//$keywords = $_GPC['keywords'];

		//$sql = " SELECT * FROM " . tablename('ymktv_sun_goods') . " g " . " JOIN " . tablename('ymktv_sun_roomorder') . " r " . " ON " . " g.id=r.gid" . " WHERE " . " r.uniacid=" . $_W['uniacid'] . " and r.order_num like '%".$_GPC['keywords']."%' ORDER BY " . " r.time DESC";
		//$total = pdo_fetchcolumn(" SELECT count(*) FROM " . tablename('ymktv_sun_goods') . " g " . " JOIN " . tablename('ymktv_sun_roomorder') . " r " . " ON " . " g.id=r.gid" . " WHERE " . " r.uniacid=" . $_W['uniacid'] . " and r.order_num like '%".$_GPC['keywords']."%' ORDER BY " . " r.time DESC");

		$sql = "select * from ".tablename('ymktv_sun_roomorder')." where uniacid=".$_W['uniacid']." and order_num like '%".$_GPC['keywords']."%' order by time desc";
		$total = pdo_fetchcolumn("select count(*) from ".tablename('ymktv_sun_roomorder')." where uniacid=".$_W['uniacid']." and order_num like '%".$_GPC['keywords']."%' order by time desc");
		
		$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
		$order=pdo_fetchall($select_sql);

		if($order){
			foreach($order as $k=>$v){
				$goods = pdo_get('ymktv_sun_goods',array('uniacid'=>$_W['uniacid'],'id'=>$v['gid']),array('room_num','type_id'));
				if(!$v['type_name']){
					$goodstype = pdo_get('ymktv_sun_type',array('uniacid'=>$_W['uniacid'],'id'=>$goods['type_id']),array('type_name'));
					
					if($goodstype){
						$order[$k]['type_name'] = $goodstype['type_name'];
					}
				}
				if(!$v['room_num']){
					if($goods){
						$order[$k]['room_num'] = $goods['room_num'];
					}
				}
			}
		}
		/*foreach ($order as $k=>$v){
			$order[$k]['type_name'] = pdo_getcolumn('ymktv_sun_type',array('uniacid'=>$_W['uniacid'],'id'=>$v['type_id']),'type_name');
		}*/
	}
}elseif($_GPC['op']=='changeroom'){
	$res=pdo_update('ymktv_sun_roomorder',array('sid'=>$_GPC['sid']),array('id'=>$_GPC['id']));
	if($res){
		message('更换成功',$this->createWebUrl('roomorder',array()),'success');
	}else{
		message('更换失败','','error');
	}
}else{
    //$sql = ' SELECT * FROM ' . tablename('ymktv_sun_goods') . ' g ' . ' JOIN ' . tablename('ymktv_sun_roomorder') . ' r ' . ' ON ' . ' g.id=r.gid' . ' WHERE ' . ' r.uniacid=' . $_W['uniacid'] . ' ORDER BY ' . ' r.time DESC';
    //$total = pdo_fetchcolumn(' SELECT count(*) FROM ' . tablename('ymktv_sun_goods') . ' g ' . ' JOIN ' . tablename('ymktv_sun_roomorder') . ' r ' . ' ON ' . ' g.id=r.gid' . ' WHERE ' . ' r.uniacid=' . $_W['uniacid'] . ' ORDER BY ' . ' r.time DESC');

	$sql = "select * from ".tablename('ymktv_sun_roomorder')." where uniacid=".$_W['uniacid']." order by time desc";
	$total = pdo_fetchcolumn("select count(*) from ".tablename('ymktv_sun_roomorder')." where uniacid=".$_W['uniacid']." order by time desc");
    
	$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
	$order = pdo_fetchall($select_sql);
    
	if($order){
		foreach($order as $k=>$v){
			$goods = pdo_get('ymktv_sun_goods',array('uniacid'=>$_W['uniacid'],'id'=>$v['gid']),array('room_num','type_id'));
			if(!$v['type_name']){
				$goodstype = pdo_get('ymktv_sun_type',array('uniacid'=>$_W['uniacid'],'id'=>$goods['type_id']),array('type_name'));
				
				if($goodstype){
					$order[$k]['type_name'] = $goodstype['type_name'];
				}
			}
			if(!$v['room_num']){
				if($goods){
					$order[$k]['room_num'] = $goods['room_num'];
				}
			}
		}
	}
	/*foreach ($order as $k=>$v){
        $order[$k]['type_name'] = pdo_getcolumn('ymktv_sun_type',array('uniacid'=>$_W['uniacid'],'id'=>$v['type_id']),'type_name');
    }*/
}
foreach ($order as $k=>$v){
    foreach ($servies as $kk=>$vv){
        if($order[$k]['build_id']==$vv['b_id']){
            $order[$k]['servies'][] = $vv;
        }
    }
	foreach($build as $k2=>$v2){
		if($v2['id']==$v['build_id']){
			$order[$k]['b_name']=$v2['b_name'];
		}
	}
}

$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op'] == 'delete'){
    $res = pdo_delete('ymktv_sun_roomorder',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
    if($res){
        message('删除成功！', $this->createWebUrl('roomorder'), 'success');
    }else{
        message('删除失败！','','error');
    }
}
/*if($_GPC['keywords']){
    $orderData = pdo_getall('ymktv_sun_roomorder',array('uniacid'=>$_W['uniacid'],'order_num like'=>'%'.$_GPC['keywords'].'%'),'','','time DESC');
    $order = [];
    foreach ($orderData as $k=>$v){
        $order[$k] = $v + pdo_get('ymktv_sun_goods',array('uniacid'=>$_W['uniacid'],'id'=>$v['gid']));
    }

    foreach ($order as $k=>$v){
        $order[$k]['type_name'] = pdo_getcolumn('ymktv_sun_type',array('uniacid'=>$_W['uniacid'],'id'=>$v['type_id']),'type_name');
    }
}*/
if($_GPC['op']=='delivery'){
    $res=pdo_update('ymktv_sun_roomorder',array('status'=>1),array('id'=>$_GPC['id']));
    if($res){
		/*======分销使用====== */
		include_once IA_ROOT . '/addons/ymktv_sun/inc/func/distribution.php';
		$distribution = new Distribution();
		$distribution->order_id = $_GPC['id'];
		$distribution->ordertype = 1;
		$distribution->settlecommission();
		/*======分销使用======*/
        message('操作成功',$this->createWebUrl('roomorder',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
if($_GPC['op']=='receipt'){
    $res=pdo_update('ymktv_sun_roomorder',array('status'=>0),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('roomorder',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
/*if($_GPC['submit']){
    if($_GPC['op']=='search'){
		if($_GPC['keywords']){
			
			$keywords = $_GPC['keywords'];

			$sql = " SELECT * FROM " . tablename('ymktv_sun_goods') . " g " . " JOIN " . tablename('ymktv_sun_roomorder') . " r " . " ON " . " g.id=r.gid" . " WHERE " . " r.uniacid=" . $_W['uniacid'] . " and r.order_num like '%".$_GPC['keywords']."%' ORDER BY " . " r.time DESC";
			
			$total = pdo_fetchcolumn(" SELECT count(*) FROM " . tablename('ymktv_sun_goods') . " g " . " JOIN " . tablename('ymktv_sun_roomorder') . " r " . " ON " . " g.id=r.gid" . " WHERE " . " r.uniacid=" . $_W['uniacid'] . " and r.order_num like '%".$_GPC['keywords']."%' ORDER BY " . " r.time DESC");
			
			$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
			
			$order=pdo_fetchall($select_sql);
			
			foreach ($order as $k=>$v){
				$order[$k]['type_name'] = pdo_getcolumn('ymktv_sun_type',array('uniacid'=>$_W['uniacid'],'id'=>$v['type_id']),'type_name');
			}
			foreach ($order as $k=>$v){
				foreach ($servies as $kk=>$vv){
					if($order[$k]['build_id']==$vv['b_id']){
						$order[$k]['servies'][] = $vv;
					}
				}
				foreach($build as $k2=>$v2){
					if($v2['id']==$v['build_id']){
						$order[$k]['b_name']=$v2['b_name'];
					}
				}
			}

			$pager = pagination($total, $pageindex, $pagesize);
		}
	}else{
		$res=pdo_update('ymktv_sun_roomorder',array('sid'=>$_GPC['sid']),array('id'=>$_GPC['id']));
		if($res){
			message('更换成功',$this->createWebUrl('roomorder',array()),'success');
		}else{
			message('更换失败','','error');
		}
	}
}*/

include $this->template('web/roomorder');