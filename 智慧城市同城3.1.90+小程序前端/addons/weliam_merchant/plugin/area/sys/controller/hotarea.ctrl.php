<?php
defined('IN_IA') or exit('Access Denied');

class Hotarea_WeliamController {

	public function oparealist() {
		global $_W, $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$where['uniacid'] = $_W['uniacid'];
		//状态
		if($_GPC['statusflag']){
			if($_GPC['status'] == 2){
				$where['status'] = 0;
			}else{
				$where['status'] = 1;
			}
		}
		//热门
		if($_GPC['ishotflag']>0){
			if($_GPC['ishot'] == 2){
				$where['ishot'] = 0;
			}else{
				$where['ishot'] = 1;
			}
		}
		//搜索名字
		if($_GPC['agentname']){
			$keyword = trim($_GPC['agentname']);
			$keywordtype = $_GPC['keywordtype'];
			if($keywordtype == 1){
				$areas = pdo_fetchall("SELECT * FROM ".tablename('wlmerchant_area')."WHERE name LIKE '%{$keyword}%' ORDER BY id DESC");
				if($areas){
					$areaids = "(";
					foreach ($areas as $key => $v) {
						if($key == 0){
							$areaids.= $v['id'];
						}else{
							$areaids.= ",".$v['id'];
						}	
					}
					$areaids.= ")";
					$where['areaid#'] .= $areaids;
				}else{
					$where['areaid#'] .= "(0)";
				}
			}else if($keywordtype == 2){
				$areas = pdo_fetchall("SELECT * FROM ".tablename('wlmerchant_agentusers')."WHERE agentname LIKE '%{$keyword}%' ORDER BY id DESC");
				if($areas){
					$areaids = "(";
					foreach ($areas as $key => $v) {
						if($key == 0){
							$areaids.= $v['id'];
						}else{
							$areaids.= ",".$v['id'];
						}	
					}
					$areaids.= ")";
					$where['aid#'] .= $areaids;
				}else{
					$where['aid#'] .= "(0)";
				}
			}
		}
		
		$addresses = Util::getNumData('*', PDO_NAME.'oparea', $where, 'sort DESC,aid ASC', $pindex,$psize, 1);
		$pager = $addresses[1];
 		$addresses = $addresses[0];
		if (checksubmit()) {
			$status = $_GPC['status'];
			$ishot = $_GPC['ishot'];
			$group = $_GPC['group'];
			$sort = $_GPC['sort'];
			foreach ($addresses as $key => $value) {
				$onstatus = !empty($status[$value['id']]) ? 1 : 0;
				$onhot = !empty($ishot[$value['id']]) ? 1 : 0;
				$ongroup = intval($group[$value['id']]);
				$addresssort = intval($sort[$value['id']]);
				pdo_update(PDO_NAME . 'oparea', array('status' => $onstatus, 'ishot' => $onhot, 'gid' => $ongroup, 'sort' => $addresssort), array('id' => $value['id']));
			}
            Cache::deleteCache('area', 'terarea' . $_W['uniacid']);
			wl_message('更新地区信息成功', 'referer', 'success');
		}
		
		$hasaid = FALSE;
		foreach ($addresses as $key => $value) {
			if ($value['aid'] == 0) {
				$hasaid = TRUE;
			}
			$addresses[$key]['addressname'] = pdo_getcolumn(PDO_NAME . 'area', array('id' => $value['areaid']), 'name');
			$addresses[$key]['agentname'] = empty($value['aid']) ? '总后台' : pdo_getcolumn(PDO_NAME . 'agentusers', array('id' => $value['aid']), 'agentname');
		}
//		if (!$hasaid) {
//			$data = array('uniacid' => $_W['uniacid'], 'areaid' => 110100, 'ishot' => 1, 'level' => 2, 'status' => $addresses ? 0 : 1);
//			pdo_insert(PDO_NAME . 'oparea', $data);
//			$data['id'] = pdo_insertid();
//			$data['addressname'] = '北京市';
//			$data['agentname'] = '总后台';
//			$addresses[] = $data;
//		}
		
		$remark_arr = pdo_getall(PDO_NAME . 'areagroup', array('uniacid' => $_W['uniacid']));
		include wl_template('area/oparealist');
	}

	public function opareaedit() {
		global $_W, $_GPC;
		$id = intval($_GPC['id']);
        //id存在 修改操作
        $area = pdo_get(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid'], 'id' => intval($id)));

        if ($_W['ispost']) {
            Area::save_agent_area($_GPC['districts'], $_GPC['districtslevel'], $area['aid']);
            wl_message('更新地区信息成功', web_url('area/hotarea/oparealist'), 'success');
        }

        //区域操作
        $AreaTab = tablename(PDO_NAME."area");
        $orderBy = " ORDER BY id ASC ";
        //获取一级省/直辖市
        $province = pdo_fetchall("SELECT id,name FROM ".$AreaTab." WHERE level = 1 ".$orderBy);
        $province_id = $area['areaid'];//省/直辖市id
        $city_id     = $area['areaid'];//市id
        $district_id = $area['areaid'];//区/县id
        $town_id     = $area['areaid'];//镇/乡id
        //逆推 获取当前代理商的省/市/区/镇的信息
        if($area['level'] >= 4){
            $district_id = pdo_fetchcolumn("SELECT pid FROM ".$AreaTab." WHERE level = 4 AND id = {$town_id}");
            $town = pdo_fetchall("SELECT id,name FROM ".$AreaTab." WHERE level = 4 AND pid = {$district_id}".$orderBy);
        }
        if($area['level'] >= 3){
            $city_id = pdo_fetchcolumn("SELECT pid FROM ".$AreaTab." WHERE level = 3 AND id = {$district_id}");
            $district = pdo_fetchall("SELECT id,name FROM ".$AreaTab." WHERE level = 3 AND pid = {$city_id}".$orderBy);
        }
        if($area['level'] >= 2){
            $province_id = pdo_fetchcolumn("SELECT pid FROM ".$AreaTab." WHERE level = 2 AND id = {$city_id}");
            $city = pdo_fetchall("SELECT id,name FROM ".$AreaTab." WHERE level = 2 AND pid = {$province_id}".$orderBy);
        }








		/*$oparea = pdo_get(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid'], 'id' => $id));
		
		if ($_W['ispost']) {
			Area::save_agent_area($_GPC['districts'], $_GPC['districtslevel'], $oparea['aid']);
			wl_message('更新地区信息成功', web_url('area/hotarea/oparealist'), 'success');
		}
		
		if ($oparea['level'] == 1) {
			$districts['province'] = $oparea['areaid'];
		} elseif ($oparea['level'] == 2) {
			$districts['province'] = pdo_getcolumn(PDO_NAME . 'area', array('id' => $oparea['areaid']), 'pid');
			$districts['city'] = $oparea['areaid'];
		} else {
			$districts['district'] = $oparea['areaid'];
			$districts['city'] = pdo_getcolumn(PDO_NAME . 'area', array('id' => $oparea['areaid']), 'pid');
			$districts['province'] = pdo_getcolumn(PDO_NAME . 'area', array('id' => $districts['city']), 'pid');
		}*/
		
		include wl_template('area/opareaedit');
	}

	public function group() {
		global $_W, $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 15;
		$lists = pdo_getslice(PDO_NAME . 'areagroup', array('uniacid' => $_W['uniacid']), array($pindex, $psize), $total, array(), '', "id DESC");
		$pager = pagination($total, $pindex, $psize);
		include   wl_template('area/areagroup');
	}

	public function groupedit() {
		global $_W, $_GPC;
		if (checksubmit()) {
			if (empty($_GPC['name'])) {
				wl_message('请填写分组名称');
			}
			if(empty($_GPC['id'])){
				pdo_insert(PDO_NAME . 'areagroup', array('uniacid' => $_W['uniacid'], 'name' => $_GPC['name'], 'sort' => $_GPC['sort']));
			}else{
				pdo_update(PDO_NAME . 'areagroup', array('name' => $_GPC['name'], 'sort' => $_GPC['sort']), array('id' => $_GPC['id']));
			}
			wl_message('编辑分组成功',web_url('area/hotarea/group'),'success');
		}
		$area = pdo_get(PDO_NAME . 'areagroup', array('id' => $_GPC['id']));
		include wl_template('area/areagroupedit');
	}

	public function groupdel() {
		global $_W, $_GPC;
		if ($_GPC['id']) {
			pdo_delete(PDO_NAME . 'areagroup', array('id' => $_GPC['id']));
			wl_message('删除成功',web_url('area/hotarea/group'),'success');
		}
		wl_message('删除失败');
	}

}
