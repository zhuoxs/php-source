<?php
defined('IN_IA') or exit('Access Denied');

class Diyset_WeliamController {
	/**
	 * Comment: 页面设置
	 * Author: zzw
	 */
	public function pageset() {
		global $_W, $_GPC;
        //---提交内容的操作:储存提交的数据
		if (checksubmit('submit')) {
			$base = Util::trimWithArray($_GPC['data']);
			Setting::agentsetting_save($base, 'diypageset');
			wl_message('保存成功！', web_url('diypage/diyset/pageset'), 'success');
		}
        //---进入页面的操作
        #1、获取页面信息。2=商城首页;3=抢购首页;4=团购首页;5=卡卷首页;6=拼团首页;7=砍价首页
        $table = tablename(PDO_NAME."diypage");
		$where = " WHERE (aid = {$_W['aid']} OR is_public = 1) AND uniacid = {$_W['uniacid']} AND page_class = 1 ";
		$select = "SELECT id,name FROM ";
        //获取平台首页页面
        $indexpages = pdo_fetchall($select.$table.$where." AND type = 2");
        //获取抢购首页页面
        $rushpages = pdo_fetchall($select.$table.$where." AND type = 3");
        //获取团购首页页面
        $grouponpages = pdo_fetchall($select.$table.$where." AND type = 4");
        //获取卡卷首页页面
        $wlcouponpages = pdo_fetchall($select.$table.$where." AND type = 5");
        //获取拼团首页页面
        $wlfightgrouppages = pdo_fetchall($select.$table.$where." AND type = 6");
        //获取砍价首页页面
        $bargainpages = pdo_fetchall($select.$table.$where." AND type = 7");


        #2、获取菜单&广告信息
        $menus = pdo_fetchall($select.tablename(PDO_NAME .'diypage_menu') ." WHERE (aid = {$_W['aid']} OR is_public = 1) AND uniacid = {$_W['uniacid']} AND menu_class = 1 ");
        $advs = pdo_fetchall($select.tablename(PDO_NAME .'diypage_adv') ." WHERE (aid = {$_W['aid']} OR is_public = 1) AND uniacid = {$_W['uniacid']} AND adv_class = 1 ");

        #3、获取设置信息
        $settings = Setting::agentsetting_read('diypageset');

		include  wl_template('diypage/pageset');
	}

    /**
     * Comment: 将页面/广告/菜单设置为公共的
     * Author: zzw
     */
    public function pageSetPublic(){
        global $_W,$_GPC;
        $id = $_GPC['id'];//页面/广告/菜单的id
        $type = $_GPC['type'];//1=页面，2=广告，3=菜单
        //获取表
        switch ($type){
            case 1:$table = PDO_NAME."diypage";break;
            case 2:$table = PDO_NAME."diypage_adv";break;
            case 3:$table = PDO_NAME."diypage_menu";break;
        }
        //获取当前页面的信息
        $is_public = pdo_getcolumn($table,array('id'=>$id),'is_public');
        if($is_public == 1){
            $data['is_public'] = 0;//设为私有
        }else{
            $data['is_public'] = 1;//设为公共
        }
        //修改内容
        pdo_update($table,$data,array('id'=>$id));
	    wl_json($is_public);
    }

}
