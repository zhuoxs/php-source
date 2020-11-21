<?php
defined('IN_IA') or exit('Access Denied');

class Yzxgwpc_sunModuleSite extends WeModuleSite {

	//配置
	public function doWebConfig() {
		global $_W, $_GPC;

        $acid = $_W['acid'];

        //获取数据并分页
		$pindex  = max(1, intval($_GPC['page']));
		$psize   = 5;
		$limit   = " ORDER BY id DESC LIMIT " . ($pindex -1) * $psize . ", {$psize}";
		$total   = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('yzxgwpc_sun_config') . " WHERE acid = :acid", array(':acid' => $acid));
		$listres = pdo_fetchall('SELECT * FROM ' . tablename('yzxgwpc_sun_config') . " WHERE acid = :acid{$limit}", array(':acid' => $acid));
		$pager   = pagination($total, $pindex, $psize);
        
		include $this->template('configlist');
	}

	public function doWebConfigadd() {
		global $_W, $_GPC;
		
		$acid = $_W['acid'];
		$data = array(
			'cname'   => trim($_GPC['cname']),
			'ename'   => trim($_GPC['ename']),
			'cf_type' => trim($_GPC['cf_type']),
			'value'   => trim($_GPC['value']),
			'img'     => trim($_GPC['img']),
			'qvalue'  => trim($_GPC['qvalue']),
			'tel'     => trim($_GPC['tel']),
			'acid'    => $acid,
		);

		if(checksubmit('submit')) {
			$result = pdo_insert('yzxgwpc_sun_config', $data);
			if (!empty($result)) {
				message('配置添加成功！', $this->createWebUrl('config'));
			}
		}

		include $this->template('configadd');
	}

	public function doWebConfigedit() {
		global $_W, $_GPC;

		$id = $_GPC['id'];
		$list = pdo_fetch("SELECT * FROM ".tablename('yzxgwpc_sun_config')." WHERE id = :id LIMIT 1", array(':id' => $id));

		$acid = $_W['acid'];
		$data = array(
			'cname'   => trim($_GPC['cname']),
			'ename'   => trim($_GPC['ename']),
			'cf_type' => trim($_GPC['cf_type']),
			'value'   => trim($_GPC['value']),
			'img'     => trim($_GPC['img']),
			'qvalue'  => trim($_GPC['qvalue']),
			'tel'     => trim($_GPC['tel']),
			'acid'    => $acid,
		);

		if(checksubmit('submit')) {
			$result = pdo_update('yzxgwpc_sun_config', $data, array('id' => $id));
			if (!empty($result)){
				message('配置更新成功！', $this->createWebUrl('config'));
			}
		}

		include $this->template('configedit');
	}

	public function doWebConfigdel() {
		global $_W, $_GPC;

		$id = $_GPC['id'];
		pdo_delete('yzxgwpc_sun_config',array('id'=>$id));
		message('配置删除成功！',$this->createWebUrl('config'));

	}

	//首页设置
	public function doWebIndex() {
		global $_W, $_GPC; 
		$acid = $_W['acid'];

        $item = pdo_fetch("SELECT * FROM " .tablename('yzxgwpc_sun_index'). " WHERE acid = :acid", array(':acid' => $acid));

        if($_GPC['status1']=='on'){
		    $_GPC['status1']=1;
		}else{
		    $_GPC['status1']=0;
		}

		if($_GPC['status2']=='on'){
		    $_GPC['status2']=1;
		}else{
		    $_GPC['status2']=0;
		}

		if($_GPC['status3']=='on'){
		    $_GPC['status3']=1;
		}else{
		    $_GPC['status3']=0;
		}

		if($_GPC['status']=='on'){
		    $_GPC['status']=1;
		}else{
		    $_GPC['status']=0;
		}

		if($_GPC['hot']=='on'){
		    $_GPC['hot']=1;
		}else{
		    $_GPC['hot']=0;
		}

        $data = array(
			'index'  => trim($_GPC['index']),
			'status'=> trim($_GPC['status']),
			'hot'=> trim($_GPC['hot']),

        	'titlef1' => trim($_GPC['titlef1']),
			'titlef2' => trim($_GPC['titlef2']),
			'titlef3' => trim($_GPC['titlef3']),
			'titlef4' => trim($_GPC['titlef4']),
			'titlef5' => trim($_GPC['titlef5']),
			'titlef6' => trim($_GPC['titlef6']),
			'titlef7' => trim($_GPC['titlef7']),
			'titlef8' => trim($_GPC['titlef8']),
			'titlef9' => trim($_GPC['titlef9']),
			'titlef10' => trim($_GPC['titlef10']),
			'status1' => trim($_GPC['status1']),
			'img1'    => trim($_GPC['img1']),

			'titles1' => trim($_GPC['titles1']),
			'titles2' => trim($_GPC['titles2']),
			'titles3' => trim($_GPC['titles3']),
			'titles4' => trim($_GPC['titles4']),
			'titles5' => trim($_GPC['titles5']),
			'titles6' => trim($_GPC['titles6']),
			'titles7' => trim($_GPC['titles7']),
			'titles8' => trim($_GPC['titles8']),
			'titles9' => trim($_GPC['titles9']),
			'titles10' => trim($_GPC['titles10']),
			'status2' => trim($_GPC['status2']),
			'img2'    => trim($_GPC['img2']),

			'titlet1' => trim($_GPC['titlet1']),
			'titlet2' => trim($_GPC['titlet2']),
			'titlet3' => trim($_GPC['titlet3']),
			'titlet4' => trim($_GPC['titlet4']),
			'titlet5' => trim($_GPC['titlet5']),
			'titlet6' => trim($_GPC['titlet6']),
			'titlet7' => trim($_GPC['titlet7']),
			'titlet8' => trim($_GPC['titlet8']),
			'titlet9' => trim($_GPC['titlet9']),
			'titlet10' => trim($_GPC['titlet10']),
			'status3' => trim($_GPC['status3']),
			'img3'    => trim($_GPC['img3']),
        	'acid'   => $acid,
        );

        if (checksubmit('submit')){
        	if (empty($item)){
        		$int = pdo_insert('yzxgwpc_sun_index', $data);
        		if (!empty($int)){
	        			message('新增成功！', $this->createWebUrl('index'));
	        		}
        	}else{
        		$up= pdo_update('yzxgwpc_sun_index', $data, array('acid' => $acid));
	    		if (!empty($up)){
	    			message('更新成功！', $this->createWebUrl('index'));
	    		}
        	}
        }
        include $this->template('index');
	}

	public function doWebIndex2() {
		global $_W, $_GPC;
        $acid = $_W['acid'];

        $item = pdo_fetch("SELECT * FROM " .tablename('yzxgwpc_sun_index2'). " WHERE acid = :acid", array(':acid' => $acid));
		$slide = unserialize($item['slides']);

		$slides = serialize($_GPC['slides']);

		if($_GPC['status']=='on'){
		    $_GPC['status']=1;
		}else{
		    $_GPC['status']=0;
		}

		if($_GPC['hot']=='on'){
		    $_GPC['hot']=1;
		}else{
		    $_GPC['hot']=0;
		}

        $data = array(
			'about'  => trim($_GPC['about']),
			'status'=> trim($_GPC['status']),
			'hot'=> trim($_GPC['hot']),

        	'etitle' => trim($_GPC['etitle']),
			'ctitle' => trim($_GPC['ctitle']),
        	'desc'   => trim($_GPC['desc']),
        	'pnum1'  => trim($_GPC['pnum1']),
        	'num1'   => trim($_GPC['num1']),
			'com1'   => trim($_GPC['com1']),
        	'pnum2'  => trim($_GPC['pnum2']),
        	'num2'   => trim($_GPC['num2']),
			'com2'   => trim($_GPC['com2']),
			'pnum3'  => trim($_GPC['pnum3']),
			'num3'   => trim($_GPC['num3']),
			'com3'   => trim($_GPC['com3']),
			'pnum4'  => trim($_GPC['pnum4']),
			'num4'   => trim($_GPC['num4']),
			'com4'   => trim($_GPC['com4']),
			'img'    => trim($_GPC['img']),
			'slides' => $slides,
        	'acid'   => $acid,
        );
		
        if (checksubmit('submit')){
        	if (empty($item)){
        		$int = pdo_insert('yzxgwpc_sun_index2', $data);
        		if (!empty($int)){
	        			message('新增成功！', $this->createWebUrl('index2'));
	        		}
        	}else{
        		$up= pdo_update('yzxgwpc_sun_index2', $data, array('acid' => $acid));
	    		if (!empty($up)){
	    			message('更新成功！', $this->createWebUrl('index2'));
	    		}
        	}
        }
        include $this->template('index2');
	}

	public function doWebIndex3() {
		global $_W, $_GPC;
        $acid = $_W['acid'];

        $item = pdo_fetch("SELECT * FROM " .tablename('yzxgwpc_sun_index3'). " WHERE acid = :acid", array(':acid' => $acid));

		if($_GPC['status']=='on'){
		    $_GPC['status']=1;
		}else{
		    $_GPC['status']=0;
		}

		if($_GPC['hot']=='on'){
		    $_GPC['hot']=1;
		}else{
		    $_GPC['hot']=0;
		}

        $data = array(
			'product'  => trim($_GPC['product']),
			'status'=> trim($_GPC['status']),
			'hot'=> trim($_GPC['hot']),
        	'title'  => trim($_GPC['title']),
        	'img'    => trim($_GPC['img']),
        	'acid'  => $acid,
        );
        if (checksubmit('submit')){
        	if (empty($item)){
        		$int = pdo_insert('yzxgwpc_sun_index3', $data);
        		if (!empty($int)){
	        			message('新增成功！', $this->createWebUrl('index3'));
	        		}
        	}else{
        		$up= pdo_update('yzxgwpc_sun_index3', $data, array('acid' => $acid));
	    		if (!empty($up)){
	    			message('更新成功！', $this->createWebUrl('index3'));
	    		}
        	}
        }
        include $this->template('index3');
	}

	public function doWebIndexlist() {
		global $_W, $_GPC;
		$acid = $_W['acid'];
        
		//获取数据并分页
		$pindex   = max(1, intval($_GPC['page']));
		$psize    = 5;
		$limit    = " ORDER BY id DESC LIMIT " . ($pindex -1) * $psize . ", {$psize}";
		$total    = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('yzxgwpc_sun_video') . " WHERE acid = :acid", array(':acid' => $acid));
		$videores = pdo_fetchall('SELECT * FROM ' . tablename('yzxgwpc_sun_video') . " WHERE acid = :acid{$limit}", array(':acid' => $acid));
		$pager    = pagination($total, $pindex, $psize);

		include $this->template('indexlist');
	}

	public function doWebIndexadd() {
		global $_W, $_GPC;
		$acid = $_W['acid'];

		$data = array(
			'title'    => trim($_GPC['title']),
			'language' => trim($_GPC['language']),
			'source'   => trim($_GPC['source']),
			'type'     => trim($_GPC['type']),
			'desc'     => trim($_GPC['desc']),
			'img'      => trim($_GPC['img']),
			'video'    => trim($_GPC['video']),
			'time'     => time(),
			'acid'     => $acid,
		);

		if(checksubmit('submit')) {
			$result = pdo_insert('yzxgwpc_sun_video', $data);
			if (!empty($result)) {
				message('视频添加成功！', $this->createWebUrl('indexlist'));
			}
		}

		include $this->template('indexadd');
	}

	public function doWebIndexedit() {
		global $_W, $_GPC;

		$id = $_GPC['id'];
		$video = pdo_fetch("SELECT * FROM ".tablename('yzxgwpc_sun_video')." WHERE id = :id LIMIT 1", array(':id' => $id));

		$acid = $_W['acid'];

		$data = array(
			'title'    => trim($_GPC['title']),
			'language' => trim($_GPC['language']),
			'source'   => trim($_GPC['source']),
			'type'     => trim($_GPC['type']),
			'desc'     => trim($_GPC['desc']),
			'img'      => trim($_GPC['img']),
			'video'    => trim($_GPC['video']),
			'acid'     => $acid,
		);

		if(checksubmit('submit')) {
			$result = pdo_update('yzxgwpc_sun_video', $data, array('id' => $id));
			if (!empty($result)){
				message('视频更新成功！', $this->createWebUrl('indexlist'));
			}
		}

		include $this->template('indexedit');
	}

	public function doWebIndexdel() {
		global $_W, $_GPC;
		$id = $_GPC['id'];
		pdo_delete('yzxgwpc_sun_video',array('id'=>$id));
		message('视频删除成功！',$this->createWebUrl('indexlist'));
	}

	public function doWebIndex4() {
		global $_W, $_GPC;
        $acid = $_W['acid'];

        $item = pdo_fetch("SELECT * FROM " .tablename('yzxgwpc_sun_index4'). " WHERE acid = :acid", array(':acid' => $acid));

        if($_GPC['status']=='on'){
		    $_GPC['status']=1;
		}else{
		    $_GPC['status']=0;
		}

		if($_GPC['hot']=='on'){
		    $_GPC['hot']=1;
		}else{
		    $_GPC['hot']=0;
		}

        $data = array(
			'case'  => trim($_GPC['case']),
			'status'=> trim($_GPC['status']),
			'hot'=> trim($_GPC['hot']),
        	'title'  => trim($_GPC['title']),
			'desc'  => trim($_GPC['desc']),
        	'img'    => trim($_GPC['img']),
        	'acid'  => $acid,
        );
        if (checksubmit('submit')){
        	if (empty($item)){
        		$int = pdo_insert('yzxgwpc_sun_index4', $data);
        		if (!empty($int)){
	        			message('新增成功！', $this->createWebUrl('index4'));
	        		}
        	}else{
        		$up= pdo_update('yzxgwpc_sun_index4', $data, array('acid' => $acid));
	    		if (!empty($up)){
	    			message('更新成功！', $this->createWebUrl('index4'));
	    		}
        	}
        }
        include $this->template('index4');
	}

	public function doWebIndex5() {
		global $_W, $_GPC;
        $acid = $_W['acid'];

        $item = pdo_fetch("SELECT * FROM " .tablename('yzxgwpc_sun_index5'). " WHERE acid = :acid", array(':acid' => $acid));

		if($_GPC['status']=='on'){
		    $_GPC['status']=1;
		}else{
		    $_GPC['status']=0;
		}

		if($_GPC['hot']=='on'){
		    $_GPC['hot']=1;
		}else{
		    $_GPC['hot']=0;
		}

        $data = array(
			'news'  => trim($_GPC['news']),
			'status'=> trim($_GPC['status']),
			'hot'=> trim($_GPC['hot']),
        	'title'    => trim($_GPC['title']),
		    'img'    => trim($_GPC['img']),
        	'acid'  => $acid,
        );
        if (checksubmit('submit')){
        	if (empty($item)){
        		$int = pdo_insert('yzxgwpc_sun_index5', $data);
        		if (!empty($int)){
	        			message('新增成功！', $this->createWebUrl('index5'));
	        		}
        	}else{
        		$up= pdo_update('yzxgwpc_sun_index5', $data, array('acid' => $acid));
	    		if (!empty($up)){
	    			message('更新成功！', $this->createWebUrl('index5'));
	    		}
        	}
        }
        include $this->template('index5');
	}

	public function doWebIndex6() {
		global $_W, $_GPC;
        $acid = $_W['acid'];

        $item = pdo_fetch("SELECT * FROM " .tablename('yzxgwpc_sun_index6'). " WHERE acid = :acid", array(':acid' => $acid));

		if($_GPC['status']=='on'){
		    $_GPC['status']=1;
		}else{
		    $_GPC['status']=0;
		}

		if($_GPC['hot']=='on'){
		    $_GPC['hot']=1;
		}else{
		    $_GPC['hot']=0;
		}

        $data = array(
			'contact'  => trim($_GPC['contact']),
			'status'=> trim($_GPC['status']),
			'hot'=> trim($_GPC['hot']),
        	'address' => trim($_GPC['address']),
			'tel'     => trim($_GPC['tel']),
			'email'   => trim($_GPC['email']),
			'explain' => trim($_GPC['explain']),
			'name'    => trim($_GPC['name']),
			'num'     => trim($_GPC['num']),
			'qr'      => trim($_GPC['qr']),
			'img'     => trim($_GPC['img']),
			'pnum1'   => trim($_GPC['pnum1']),
			'num1'    => trim($_GPC['num1']),
			'lng'    => trim($_GPC['lng']),
			'lat'    => trim($_GPC['lat']),
        	'acid'    => $acid,
        );
        if (checksubmit('submit')){
        	if (empty($item)){
        		$int = pdo_insert('yzxgwpc_sun_index6', $data);
        		if (!empty($int)){
	        			message('新增成功！', $this->createWebUrl('index6'));
	        		}
        	}else{
        		$up= pdo_update('yzxgwpc_sun_index6', $data, array('acid' => $acid));
	    		if (!empty($up)){
	    			message('更新成功！', $this->createWebUrl('index6'));
	    		}
        	}
        }
        include $this->template('index6');
	}

	public function doWebIndex7() {
		global $_W, $_GPC;
        $acid = $_W['acid'];

        $item = pdo_fetch("SELECT * FROM " .tablename('yzxgwpc_sun_index7'). " WHERE acid = :acid", array(':acid' => $acid));

		if($_GPC['status']=='on'){
		    $_GPC['status']=1;
		}else{
		    $_GPC['status']=0;
		}

		if($_GPC['hot']=='on'){
		    $_GPC['hot']=1;
		}else{
		    $_GPC['hot']=0;
		}

        $data = array(
			'video'  => trim($_GPC['video']),
			'status'=> trim($_GPC['status']),
			'hot'=> trim($_GPC['hot']),
			'img'     => trim($_GPC['img']),
        	'acid'    => $acid,
        );

        if (checksubmit('submit')){
        	if (empty($item)){
        		$int = pdo_insert('yzxgwpc_sun_index7', $data);
        		if (!empty($int)){
	        			message('新增成功！', $this->createWebUrl('index7'));
	        		}
        	}else{
        		$up= pdo_update('yzxgwpc_sun_index7', $data, array('acid' => $acid));
	    		if (!empty($up)){
	    			message('更新成功！', $this->createWebUrl('index7'));
	    		}
        	}
        }
        include $this->template('index7');
	}

	public function doWebIndex8() {
		global $_W, $_GPC;
        $acid = $_W['acid'];

        $item = pdo_fetch("SELECT * FROM " .tablename('yzxgwpc_sun_index8'). " WHERE acid = :acid", array(':acid' => $acid));

		if($_GPC['status']=='on'){
		    $_GPC['status']=1;
		}else{
		    $_GPC['status']=0;
		}

		if($_GPC['hot']=='on'){
		    $_GPC['hot']=1;
		}else{
		    $_GPC['hot']=0;
		}

        $data = array(
			'join'  => trim($_GPC['join']),
			'status'=> trim($_GPC['status']),
			'hot'=> trim($_GPC['hot']),

        	'etitle' => trim($_GPC['etitle']),
			'ctitle' => trim($_GPC['ctitle']),
			'slide'    => trim($_GPC['slide']),
			'img'    => trim($_GPC['img']),
        	'acid'   => $acid,
        );
		
        if (checksubmit('submit')){
        	if (empty($item)){
        		$int = pdo_insert('yzxgwpc_sun_index8', $data);
        		if (!empty($int)){
	        			message('新增成功！', $this->createWebUrl('index8'));
	        		}
        	}else{
        		$up= pdo_update('yzxgwpc_sun_index8', $data, array('acid' => $acid));
	    		if (!empty($up)){
	    			message('更新成功！', $this->createWebUrl('index8'));
	    		}
        	}
        }
        include $this->template('index8');
	}

	public function doWebIndex9() {
		global $_W, $_GPC;
        $acid = $_W['acid'];

        $item = pdo_fetch("SELECT * FROM " .tablename('yzxgwpc_sun_index9'). " WHERE acid = :acid", array(':acid' => $acid));

		if($_GPC['status']=='on'){
		    $_GPC['status']=1;
		}else{
		    $_GPC['status']=0;
		}

		if($_GPC['hot']=='on'){
		    $_GPC['hot']=1;
		}else{
		    $_GPC['hot']=0;
		}

        $data = array(
			'help'  => trim($_GPC['help']),
			'status'=> trim($_GPC['status']),
			'hot'=> trim($_GPC['hot']),
        	'title'  => trim($_GPC['title']),
			'slide'  => trim($_GPC['slide']),
        	'img'    => trim($_GPC['img']),
        	'acid'  => $acid,
        );
        if (checksubmit('submit')){
        	if (empty($item)){
        		$int = pdo_insert('yzxgwpc_sun_index9', $data);
        		if (!empty($int)){
	        			message('新增成功！', $this->createWebUrl('index9'));
	        		}
        	}else{
        		$up= pdo_update('yzxgwpc_sun_index9', $data, array('acid' => $acid));
	    		if (!empty($up)){
	    			message('更新成功！', $this->createWebUrl('index9'));
	    		}
        	}
        }
        include $this->template('index9');
	}

	//栏目管理
	public function catetree($cateRes){
        return $this->sort($cateRes);
    }

    public function sort($cateRes,$pid=0,$level=0){

        static $arr=array();
        foreach ($cateRes as $k => $v) {
            if($v['pid']==$pid){
                $v['level']=$level;
                $arr[]=$v;
                $this->sort($cateRes,$v['id'],$level+1);
            }
        }

        return $arr;
    }

	public function doWebCate() {
		global $_W, $_GPC;
        
		$acid = $_W['acid'];

		$_cateres=pdo_fetchall("SELECT * FROM " .tablename('yzxgwpc_sun_cate'). " WHERE acid = :acid ORDER BY `id`",array(':acid' => $acid));
        $cateres=$this->catetree($_cateres);

		include $this->template('catelist');
	}

	public function doWebCateadd() {
		global $_W, $_GPC;

		$acid = $_W['acid'];

		if($_GPC['bottom_nav']=='on'){
		    $_GPC['bottom_nav']=1;
		}else{
		    $_GPC['bottom_nav']=0;
		}

		if($_GPC['status']=='on'){
		    $_GPC['status']=1;
		}else{
		    $_GPC['status']=0;
		}

		if($_GPC['hot']=='on'){
		    $_GPC['hot']=1;
		}else{
		    $_GPC['hot']=0;
		}

		$pid = $_GPC['pid'];
		if($pid != '0'){
		    $pcate = pdo_fetch("SELECT * FROM " .tablename('yzxgwpc_sun_cate'). " WHERE acid = :acid AND id = :id",array(':acid' => $acid,':id' => $pid));
		    $ppid = $pcate['pid'];
		}else{
		    $ppid = 0;
		}

		$data = array(
			'catename'   => trim($_GPC['catename']),
			'ename'      => trim($_GPC['ename']),
			'title'      => trim($_GPC['title']),
			'desc'       => trim($_GPC['desc']),
			'keywords'   => trim($_GPC['keywords']),
			'cicon'      => trim($_GPC['cicon']),
			'thumb'      => trim($_GPC['thumb']),
			'img'        => trim($_GPC['img']),
			'status'     => trim($_GPC['status']),
			'sort'       => trim($_GPC['sort']),
			'bottom_nav' => trim($_GPC['bottom_nav']),
			'hot'        => trim($_GPC['hot']),
			'cate_attr'  => trim($_GPC['cate_attr']),
			'pid'        => trim($_GPC['pid']),
			'ppid'       => $ppid,
			'acid'       => $acid,
		);

		if(checksubmit('submit')) {
			$result = pdo_insert('yzxgwpc_sun_cate', $data);
			if (!empty($result)) {
				message('栏目添加成功！', $this->createWebUrl('cate'));
			}
		}

		$_cateres=pdo_fetchall("SELECT * FROM " .tablename('yzxgwpc_sun_cate'). " WHERE acid = :acid ORDER BY `id`",array(':acid' => $acid));
        $cateres=$this->catetree($_cateres);

		include $this->template('cateadd');
	}

	public function doWebCateedit() {
		global $_W, $_GPC;

		$id = $_GPC['id'];
		$cate = pdo_fetch("SELECT * FROM ".tablename('yzxgwpc_sun_cate')." WHERE id = :id LIMIT 1", array(':id' => $id));

		$acid = $_W['acid'];

		if($_GPC['bottom_nav']=='on'){
		    $_GPC['bottom_nav']=1;
		}else{
		    $_GPC['bottom_nav']=0;
		}

		if($_GPC['status']=='on'){
		    $_GPC['status']=1;
		}else{
		    $_GPC['status']=0;
		}

		if($_GPC['hot']=='on'){
		    $_GPC['hot']=1;
		}else{
		    $_GPC['hot']=0;
		}

		$pid = $_GPC['pid'];
		if($pid != '0'){
		    $pcate = pdo_fetch("SELECT * FROM " .tablename('yzxgwpc_sun_cate'). " WHERE acid = :acid AND id = :id",array(':acid' => $acid,':id' => $pid));
		    $ppid = $pcate['pid'];
		}else{
		    $ppid = 0;
		}

		$data = array(
			'catename'   => trim($_GPC['catename']),
			'ename'      => trim($_GPC['ename']),
			'title'      => trim($_GPC['title']),
			'desc'       => trim($_GPC['desc']),
			'keywords'   => trim($_GPC['keywords']),
			'cicon'      => trim($_GPC['cicon']),
			'thumb'      => trim($_GPC['thumb']),
			'img'        => trim($_GPC['img']),
			'status'     => trim($_GPC['status']),
			'sort'       => trim($_GPC['sort']),
			'bottom_nav' => trim($_GPC['bottom_nav']),
			'hot'        => trim($_GPC['hot']),
			'cate_attr'  => trim($_GPC['cate_attr']),
			'pid'        => trim($_GPC['pid']),
			'ppid'       => $ppid,
			'acid'       => $acid,
		);

		if(checksubmit('submit')) {
			$result = pdo_update('yzxgwpc_sun_cate', $data, array('id' => $id));
			if (!empty($result)){
				message('栏目更新成功！', $this->createWebUrl('cate'));
			}
		}

		$_cateres=pdo_fetchall("SELECT * FROM " .tablename('yzxgwpc_sun_cate'). " WHERE acid = :acid ORDER BY `id`",array(':acid' => $acid));
        $cateres=$this->catetree($_cateres);

		include $this->template('cateedit');
	}

	public function doWebCatedel() {
		global $_W, $_GPC;
		$id = $_GPC['id'];
		pdo_delete('yzxgwpc_sun_cate',array('id'=>$id));
		message('栏目删除成功！',$this->createWebUrl('cate'));
	}

	public function doWebChangestatus() {
		global $_W, $_GPC;
        
		$id = $_GPC['id'];

		$status = pdo_fetch("SELECT * FROM ".tablename('yzxgwpc_sun_cate')." WHERE id = :id LIMIT 1", array(':id' => $id));
		$status = $status['status'];

		if($status=='1'){
		    pdo_update('yzxgwpc_sun_cate', array('status'=>'0'), array('id' => $id));
			echo 1; //显示改为隐藏
		}else{
		    pdo_update('yzxgwpc_sun_cate', array('status'=>'1'), array('id' => $id));
			echo 2; //隐藏改为显示
		}
	}

	public function doWebChangenav() {
		global $_W, $_GPC;
        
		$id = $_GPC['id'];

		$bottom_nav = pdo_fetch("SELECT * FROM ".tablename('yzxgwpc_sun_cate')." WHERE id = :id LIMIT 1", array(':id' => $id));
		$bottom_nav = $bottom_nav['bottom_nav'];

		if($bottom_nav=='1'){
		    pdo_update('yzxgwpc_sun_cate', array('bottom_nav'=>'0'), array('id' => $id));
			echo 1; //显示改为隐藏
		}else{
		    pdo_update('yzxgwpc_sun_cate', array('bottom_nav'=>'1'), array('id' => $id));
			echo 2; //隐藏改为显示
		}
	}

	public function doWebChangehot() {
		global $_W, $_GPC;
        
		$id = $_GPC['id'];

		$hot = pdo_fetch("SELECT * FROM ".tablename('yzxgwpc_sun_cate')." WHERE id = :id LIMIT 1", array(':id' => $id));
		$hot = $hot['hot'];

		if($hot=='1'){
		    pdo_update('yzxgwpc_sun_cate', array('hot'=>'0'), array('id' => $id));
			echo 1; //显示改为隐藏
		}else{
		    pdo_update('yzxgwpc_sun_cate', array('hot'=>'1'), array('id' => $id));
			echo 2; //隐藏改为显示
		}
	}

	public function childrenids($cateid){
		global $_W, $_GPC;
		$acid = $_W['acid'];

        $data=pdo_fetchall("SELECT * FROM " .tablename('yzxgwpc_sun_cate') . " WHERE acid = :acid",array(':acid' => $acid));
        return $this->_childrenids($data,$cateid);
	}

	private function _childrenids($data,$cateid){
        static $arr=array();
        foreach ($data as $k => $v) {
            if($v['pid']==$cateid){
                $arr[]=$v['id'];
                $this->_childrenids($data,$v['id']);
            }
        }
        return $arr;
	}

	public function doWebAjaxlst(){
		global $_W, $_GPC;
		$cateid=$_GPC['cateid'];
		$sonids=$this->childrenids($cateid);
		echo json_encode($sonids);
    }

	//文章管理
	public function doWebArticle() {
		global $_W, $_GPC;
		$acid = $_W['acid'];

		//获取数据并分页
		$pindex     = max(1, intval($_GPC['page']));
		$psize      = 5;
		$limit      = " ORDER BY id DESC LIMIT " . ($pindex -1) * $psize . ", {$psize}";
		$total      = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('yzxgwpc_sun_article') . " WHERE acid = :acid", array(':acid' => $acid));
		$articleres = pdo_fetchall('SELECT a.*, c.catename, c.cate_attr FROM ' . tablename('yzxgwpc_sun_article') . 'as a,' . tablename('yzxgwpc_sun_cate') . "as c WHERE a.cateid=c.id AND a.acid = :acid{$limit}", array(':acid' => $acid));
		$pager      = pagination($total, $pindex, $psize);

		include $this->template('articlelist');
	}

	//文章查询
	public function doWebSarticle() {
		global $_W, $_GPC;
		$acid = $_W['acid'];

		//搜索
		$keyword = $_GPC['keyword'];
		$articleres = pdo_fetchall("SELECT a.*, c.catename, c.cate_attr FROM " . tablename('yzxgwpc_sun_article') . 'as a,' . tablename('yzxgwpc_sun_cate') . "as c WHERE a.cateid=c.id AND a.acid = :acid AND a.ctitle LIKE :ctitle",array(':acid' => $acid,':ctitle' => "%$keyword%"));
		
		include $this->template('articlelist');
	}

	public function doWebChangerec() {
		global $_W, $_GPC;
        
		$id = $_GPC['id'];

		$rec = pdo_fetch("SELECT * FROM ".tablename('yzxgwpc_sun_article')." WHERE id = :id LIMIT 1", array(':id' => $id));
		$rec = $rec['rec'];

		if($rec=='1'){
		    pdo_update('yzxgwpc_sun_article', array('rec'=>'0'), array('id' => $id));
			echo 1; //推荐改为不推荐
		}else{
		    pdo_update('yzxgwpc_sun_article', array('rec'=>'1'), array('id' => $id));
			echo 2; //不推荐改为推荐
		}
	}

	public function doWebArticleaddlist() {
		global $_W, $_GPC;
		$acid = $_W['acid'];

		$_cateres=pdo_fetchall("SELECT * FROM " .tablename('yzxgwpc_sun_cate'). " WHERE acid = :acid ORDER BY `id`",array(':acid' => $acid));
        $cateres=$this->catetree($_cateres);

		include $this->template('articleaddlist');
	}

	public function doWebArticleadd() {
		global $_W, $_GPC;

        $cateid = $_GPC['cateid'];
		$cate = pdo_fetch("SELECT * FROM " .tablename('yzxgwpc_sun_cate'). " WHERE id = :id LIMIT 1", array(':id' => $cateid));
		$cate_attr = $cate['cate_attr'];

		include $this->template('articleadd');
	}

	public function doWebArticleadd2() {
		global $_W, $_GPC;
		$acid = $_W['acid'];

		$img = serialize($_GPC['img']);

		if($_GPC['rec']=='on'){
		    $_GPC['rec']=1;
		}else{
		    $_GPC['rec']=0;
		}

		$pid = $_GPC['pid'];
		if($pid != '0'){
		    $pcate = pdo_fetch("SELECT * FROM " .tablename('yzxgwpc_sun_cate'). " WHERE acid = :acid AND id = :id",array(':acid' => $acid,':id' => $pid));
		    $ppid = $pcate['pid'];
		}else{
		    $ppid = 0;
		} 

		$data = array(
			'snav'    => trim($_GPC['snav']),
		    'etitle'  => trim($_GPC['etitle']),
			'ctitle'  => trim($_GPC['ctitle']),
			'ctitle2'  => trim($_GPC['ctitle2']),
			'sort'     => trim($_GPC['sort']),
			'desc'    => trim($_GPC['desc']),
			'img'     => $img,
			'img2'    => trim($_GPC['img2']),
			'author'  => trim($_GPC['author']),
			'tag'     => trim($_GPC['tag']),
			'rec'     => trim($_GPC['rec']),
			'content' => htmlspecialchars_decode($_GPC['content']),
			'time'    => time(),
			'click'   => trim($_GPC['click']),
			'pid'     => trim($_GPC['pid']),
			'ppid'       => $ppid,
			'cateid'  => trim($_GPC['cateid']),
			'acid'    => $acid,
		);

		if(checksubmit('submit')) {
			$result = pdo_insert('yzxgwpc_sun_article', $data);
			if (!empty($result)) {
				message('文章添加成功！', $this->createWebUrl('article'));
			}
		}

	}

	public function doWebArticleedit() {
		global $_W, $_GPC;
		$acid = $_W['acid'];

		$id = $_GPC['id'];
		$article = pdo_fetch("SELECT * FROM ".tablename('yzxgwpc_sun_article')." WHERE id = :id LIMIT 1", array(':id' => $id));
		$cateid = $article['cateid'];
		$cate = pdo_fetch("SELECT * FROM ".tablename('yzxgwpc_sun_cate')." WHERE id = :id LIMIT 1", array(':id' => $cateid));
		$imgs = unserialize($article['img']);
		$cate_attr = $cate['cate_attr'];

		$img = serialize($_GPC['img']);

		if($_GPC['rec']=='on'){
		    $_GPC['rec']=1;
		}else{
		    $_GPC['rec']=0;
		}

		$pid = $_GPC['pid'];
		if($pid != '0'){
		    $pcate = pdo_fetch("SELECT * FROM " .tablename('yzxgwpc_sun_cate'). " WHERE acid = :acid AND id = :id",array(':acid' => $acid,':id' => $pid));
		    $ppid = $pcate['pid'];
		}else{
		    $ppid = 0;
		} 

		$data = array(
			'snav'    => trim($_GPC['snav']),
		    'etitle'  => trim($_GPC['etitle']),
			'ctitle'  => trim($_GPC['ctitle']),
			'ctitle2' => trim($_GPC['ctitle2']),
			'sort'    => trim($_GPC['sort']),
			'desc'    => trim($_GPC['desc']),
			'img'     => $img,
			'img2'    => trim($_GPC['img2']),
			'author'  => trim($_GPC['author']),
			'tag'     => trim($_GPC['tag']),
			'rec'     => trim($_GPC['rec']),
			'content' => htmlspecialchars_decode($_GPC['content']),
			'time'    => time(),
			'click'   => trim($_GPC['click']),
			'pid'     => trim($_GPC['pid']),
			'ppid'       => $ppid,
			'cateid'  => trim($_GPC['cateid']),
			'acid'    => $acid,
		);

		if(checksubmit('submit')) {
			$result = pdo_update('yzxgwpc_sun_article', $data, array('id' => $id));
			if (!empty($result)){
				message('文章更新成功！', $this->createWebUrl('article'));
			}
		}

		include $this->template('articleedit');
	}

	public function doWebArticledel() {
		global $_W, $_GPC;
		$id = $_GPC['id'];
		pdo_delete('yzxgwpc_sun_article',array('id'=>$id));
		message('文章删除成功！',$this->createWebUrl('article'));
	}

	//外链管理
	public function doWebLink() {
		global $_W, $_GPC;
		$acid = $_W['acid'];
        
		//获取数据并分页
		$pindex  = max(1, intval($_GPC['page']));
		$psize   = 5;
		$limit   = " ORDER BY id DESC LIMIT " . ($pindex -1) * $psize . ", {$psize}";
		$total   = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('yzxgwpc_sun_link') . " WHERE acid = :acid", array(':acid' => $acid));
		$linkres = pdo_fetchall('SELECT * FROM ' . tablename('yzxgwpc_sun_link') . " WHERE acid = :acid{$limit}", array(':acid' => $acid));

		$pager   = pagination($total, $pindex, $psize);

		include $this->template('linklist');
	}

	public function doWebLinkadd() {
		global $_W, $_GPC;
		$acid = $_W['acid'];

        if((stripos($_GPC['url'],'http'))===false){
		    $_GPC['url'] = 'http://' . $_GPC['url'];
		}else{
		    $_GPC['url'] = $_GPC['url'];	
		}

		$data = array(
			'title' => trim($_GPC['title']),
			'url'   => trim($_GPC['url']),
			'acid'  => $acid,
		);

		if(checksubmit('submit')) {
			$result = pdo_insert('yzxgwpc_sun_link', $data);
			if (!empty($result)) {
				message('外链添加成功！', $this->createWebUrl('link'));
			}
		}

		include $this->template('linkadd');
	}

	public function doWebLinkedit() {
		global $_W, $_GPC;
		$acid = $_W['acid'];

		$id = $_GPC['id'];
		$link = pdo_fetch("SELECT * FROM ".tablename('yzxgwpc_sun_link')." WHERE id = :id LIMIT 1", array(':id' => $id));

        if((stripos($_GPC['url'],'http'))===false){
		    $_GPC['url'] = 'http://' . $_GPC['url'];
		}else{
		    $_GPC['url'] = $_GPC['url'];	
		}

		$data = array(
			'title' => trim($_GPC['title']),
			'url'   => trim($_GPC['url']),
			'acid'  => $acid,
		);

		if(checksubmit('submit')) {
			$result = pdo_update('yzxgwpc_sun_link', $data, array('id' => $id));
			if (!empty($result)){
				message('外链更新成功！', $this->createWebUrl('link'));
			}
		}

		include $this->template('linkedit');
	}

	public function doWebLinkdel() {
		global $_W, $_GPC;
		$id = $_GPC['id'];
		pdo_delete('yzxgwpc_sun_link',array('id'=>$id));
		message('外链删除成功！',$this->createWebUrl('link'));
	}

	//留言管理
	public function doWebContact() {
		global $_W, $_GPC;
		$acid = $_W['acid'];
        
		//获取数据并分页
		$pindex  = max(1, intval($_GPC['page']));
		$psize   = 5;
		$limit   = " ORDER BY id DESC LIMIT " . ($pindex -1) * $psize . ", {$psize}";
		$total   = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('yzxgwpc_sun_message') . " WHERE acid = :acid", array(':acid' => $acid));
		$contactres = pdo_fetchall('SELECT * FROM ' . tablename('yzxgwpc_sun_message') . " WHERE acid = :acid{$limit}", array(':acid' => $acid));
		$pager   = pagination($total, $pindex, $psize);

		include $this->template('contactlist');
	}

	public function doWebContactedit() {
		global $_W, $_GPC;

		$id = $_GPC['id'];
		$contact = pdo_fetch("SELECT * FROM ".tablename('yzxgwpc_sun_message')." WHERE id = :id LIMIT 1", array(':id' => $id));

        $data = array(
			'status' => 1,
		);
		pdo_update('yzxgwpc_sun_message', $data, array('id' => $id));


		include $this->template('contactedit');
	}

	public function doWebContactdel() {
		global $_W, $_GPC;
		$id = $_GPC['id'];
		pdo_delete('yzxgwpc_sun_message',array('id'=>$id));
		message('留言删除成功！',$this->createWebUrl('contact'));
	}

    //ajax修改留言推荐状态
	public function doWebChangemerec() {
		global $_W, $_GPC;

		$id = $_GPC['id'];

		$rec = pdo_fetch("SELECT * FROM ".tablename('yzxgwpc_sun_message')." WHERE id = :id LIMIT 1", array(':id' => $id));
		$rec = $rec['rec'];

		if($rec=='1'){
		    pdo_update('yzxgwpc_sun_message', array('rec'=>'0'), array('id' => $id));
			echo 1; //推荐改为不推荐
		}else{
		    pdo_update('yzxgwpc_sun_message', array('rec'=>'1'), array('id' => $id));
			echo 2; //不推荐改为推荐
		}
	}

	//经销加盟
	public function doWebJoinlist() {
		global $_W, $_GPC;
		$acid = $_W['acid'];
        
		//获取数据并分页
		$pindex  = max(1, intval($_GPC['page']));
		$psize   = 5;
		$limit   = " ORDER BY id DESC LIMIT " . ($pindex -1) * $psize . ", {$psize}";
		$total   = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('yzxgwpc_sun_joinlist') . " WHERE acid = :acid", array(':acid' => $acid));
		$joinres = pdo_fetchall('SELECT * FROM ' . tablename('yzxgwpc_sun_joinlist') . " WHERE acid = :acid{$limit}", array(':acid' => $acid));
		$pager   = pagination($total, $pindex, $psize);

		include $this->template('joinlist');
	}

	public function doWebJoinedit() {
		global $_W, $_GPC;

		$id = $_GPC['id'];
		$join = pdo_fetch("SELECT * FROM ".tablename('yzxgwpc_sun_joinlist')." WHERE id = :id LIMIT 1", array(':id' => $id));

        $data = array(
			'status' => 1,
		);
		pdo_update('yzxgwpc_sun_joinlist', $data, array('id' => $id));


		include $this->template('joinedit');
	}

	public function doWebJoindel() {
		global $_W, $_GPC;
		$id = $_GPC['id'];
		pdo_delete('yzxgwpc_sun_joinlist',array('id'=>$id));
		message('加盟留言删除成功！',$this->createWebUrl('joinlist'));
	}

    //经销加盟设置
	public function doWebJoin() {
		global $_W, $_GPC;
        $acid = $_W['acid'];

        $item = pdo_fetch("SELECT * FROM " .tablename('yzxgwpc_sun_join'). " WHERE acid = :acid", array(':acid' => $acid));

        $data = array(
        	'title1' => trim($_GPC['title1']),
			'title2' => trim($_GPC['title2']),
        	'title3' => trim($_GPC['title3']),
        	'title4' => trim($_GPC['title4']),
			'pnum1'  => trim($_GPC['pnum1']),
        	'num1'   => trim($_GPC['num1']),
			'com1'   => trim($_GPC['com1']),
        	'pnum2'  => trim($_GPC['pnum2']),
        	'num2'   => trim($_GPC['num2']),
			'com2'   => trim($_GPC['com2']),
			'pnum3'  => trim($_GPC['pnum3']),
			'num3'   => trim($_GPC['num3']),
			'com3'   => trim($_GPC['com3']),
			'pnum4'  => trim($_GPC['pnum4']),
			'num4'   => trim($_GPC['num4']),
			'com4'   => trim($_GPC['com4']),
			'pnum5'  => trim($_GPC['pnum5']),
			'num5'   => trim($_GPC['num5']),
			'com5'   => trim($_GPC['com5']),
			'pnum6'  => trim($_GPC['pnum6']),
			'num6'   => trim($_GPC['num6']),
			'com6'   => trim($_GPC['com6']),
        	'acid'   => $acid,
        );
		
        if (checksubmit('submit')){
        	if (empty($item)){
        		$int = pdo_insert('yzxgwpc_sun_join', $data);
        		if (!empty($int)){
	        			message('新增成功！', $this->createWebUrl('join'));
	        		}
        	}else{
        		$up= pdo_update('yzxgwpc_sun_join', $data, array('acid' => $acid));
	    		if (!empty($up)){
	    			message('更新成功！', $this->createWebUrl('join'));
	    		}
        	}
        }
        include $this->template('join');
	}

	//域名绑定
	public function doWebDomain()
    {
        global $_W, $_GPC;

        $yzxgwpc_sun_domain = pdo_get('yzxgwpc_sun_domain', array("module" => $_W['current_module']['name'], "uniacid" => $_W['uniacid']));
        if ($_W['ispost']) {
            $domain = safe_gpc_string($_GPC['domain']);
            $status = safe_gpc_int($_GPC['status']);
            $host = $_SERVER['HTTP_HOST'];
            if ($host == $domain) {
                message('域名不能设置的跟管理域名一样');
            }
            if (!preg_match('/[0-9a-z-.]{1,}/i', $domain)) {
                message('域名只能输入英文,数字,下划线组成！');
            }
            $bind = array();
            $bind['domain'] = $domain;
            $bind['status'] = $status;
            $modules_bindings = pdo_get('modules_bindings', array("module" => $_W['current_module']['name'], "entry" => "cover"));
            $bind['url'] = 'http://' . $domain . '/app/index.php?i=' . $_W['account']['uniacid'] . '&j=' . $_W['account']['acid'] . '&a=webapp&c=entry&eid=' . $modules_bindings['eid'];
            $this->saveBindSet($bind);
            if ($yzxgwpc_sun_domain['uniacid']) {
                $data['uniacid'] = $_W['uniacid'];
                $data['domain'] = $domain;
                $data['status'] = $status;
                $data['addtime'] = time();
                $data['entry'] = '/app/index.php?i=' . $_W['account']['uniacid'] . '&j=' . $_W['account']['acid'] . '&a=webapp&c=entry&eid=' . $modules_bindings['eid'];
                pdo_update('yzxgwpc_sun_domain', $data, array("uniacid" => $_W['uniacid'], "module" => $_W['current_module']['name']));
            } else {
                $data['uniacid'] = $_W['uniacid'];
                $data['domain'] = $domain;
                $data['status'] = $status;
                $data['addtime'] = time();
                $data['module'] = $_W['current_module']['name'];
                $data['entry'] = '/app/index.php?i=' . $_W['account']['uniacid'] . '&j=' . $_W['account']['acid'] . '&a=webapp&c=entry&eid=' . $modules_bindings['eid'];
                pdo_insert('yzxgwpc_sun_domain', $data);
            }
            itoast('域名绑定成功');
        }
        $set = pdo_get('yzxgwpc_sun_domain', array("module" => $_W['current_module']['name'], "uniacid" => $_W['uniacid']));
        include $this->template('domain');
    }

    protected function saveBindSet($bind, $delete = false)
    {
        $path = IA_ROOT . '/data/yzxgwpc_sun_domain/';
        $file = $path . str_replace('.', '_', $bind['domain']) . '.php';
        if (!is_dir($path)) {
            @mkdir($path);
        }
        if ($delete) {
            if (file_exists($file)) {
                @unlink($file);
            }
            return true;
        }
        $write = array("domain" => $bind['domain'], "url" => $bind['url'], "status" => $bind['status']);
        $context = base64_decode('PD9waHA=') . "\n".'defined(\'IN_IA\') or exit(\'Access Denied\');'."\n";
        $context .= '$set=unserialize(base64_decode(\'' . base64_encode(serialize($write)) . '\'));'."\n";
        $context .= 'return $set;' . ''."\n";
        return @file_put_contents($file, $context);
    }
    public function doWebBindDomain()
    {
        global $_W;
        $file = IA_ROOT . '/data/config.php';
        $context = file_get_contents($file);
        $context = preg_replace('|\\n//\\+\\+[^+]*\\+\\+\\/\\/|', '', $context);
        $msg = '检查成功';
        $pos = strpos($context, 'addons/' . $_W['current_module']['name'] . '/domain.php');
        if (!$pos) {
            $context .= "\n".'//++--------------- yzxgwpc_sun_domain 域名绑定配置请不要手工修改  ---------------//'."\n";
            $context .= 'if(file_exists(IA_ROOT . "/addons/' . $_W['current_module']['name'] . '/domain.php"))' . '{';
            $context .= '   include IA_ROOT . "/addons/' . $_W['current_module']['name'] . '/domain.php";' . '}'."\n";
            $context .= '//----------------- yzxgwpc_sun_domain 域名绑定配置请不要手工修改  -------------++//'."\n";
            $msg = '检查成功';
        }
        if (!@file_put_contents($file, $context)) {
            $msg = '修改失败,不允许写入';
        }
        message($msg);
    }
}
