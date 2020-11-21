<?php
defined('IN_IA') or exit('Access Denied');

class Custom_WeliamController{
    /**
     * Comment: 进入自定义地区列表编辑
     * Author: zzw
     */
	public function index(){
		global $_W,$_GPC;
        $categorys = pdo_fetchall("SELECT id,name,pid,displayorder,visible FROM ".tablename(PDO_NAME."area")." WHERE (displayorder = {$_W['uniacid']} OR displayorder = 0 ) AND level = 1 ");
        include wl_template('area/diyArea');

	}
    /**
     * Comment: 编辑自定义地区
     */
	public function edit(){
		global $_W,$_GPC;
		if(checksubmit('submit')){
			$id = intval($_GPC['id']);
			if($_GPC['parentid'] > 0){
				$category['pid'] = intval($_GPC['parentid']);
				if($_GPC['level']){
                    $category['level'] = intval($_GPC['level']);
                }
			}else{
                $category['pid'] = 0;
                $category['level'] = 1;
            }
			$category['name'] = trim($_GPC['name']);
			$category['displayorder'] = $_W['uniacid'];
			$category['visible'] = intval($_GPC['visible']);
			if(!empty($id)){
				if(pdo_update(PDO_NAME.'area',$category,array('id'=>$id))) wl_message('保存成功',web_url('area/custom/index'),'success');
			}else{
				if(pdo_insert(PDO_NAME.'area',$category)) wl_message('保存成功',web_url('area/custom/index'),'success');
			}
			wl_message('保存失败',referer(),'error');
		}
		if(!empty($_GPC['id'])) $category = pdo_get(PDO_NAME.'area',array('id'=>$_GPC['id']));
		if(!empty($_GPC['parentid'])) $pidname = pdo_getcolumn(PDO_NAME.'area',array('id'=>$_GPC['parentid']),'name');
		
		include wl_template('area/customedit');
	}
    /**
     * Comment: 删除自定义地区
     */
	public function delete(){
		global $_W,$_GPC;
		$pid = pdo_getcolumn(PDO_NAME.'area', array('id'=>$_GPC['id']),'pid');
		if(empty($pid)){
			pdo_delete(PDO_NAME.'area',array('pid'=>$_GPC['id']));
		}
		if(pdo_delete(PDO_NAME.'area',array('id'=>$_GPC['id']))){
			show_json(1,'删除成功');
		} else {
			show_json(0,'删除失败，请重试');
		}
	}
    /**
     * Comment: 根据id与等级获取当前区域的所有下级区域信息
     * Author: zzw
     */
	public function getAreaInfo(){
	    global $_W,$_GPC;
	    $id = $_GPC['id'];
	    $lv = $_GPC['lv'];
        $info = pdo_fetchall("SELECT id,name,pid,displayorder FROM ".tablename(PDO_NAME."area") ." WHERE (displayorder = {$_W['uniacid']} OR displayorder = 0 ) AND level = ".$lv." AND pid = ".$id);
        wl_json(1,'获取下级区域信息',$info);
    }
}
