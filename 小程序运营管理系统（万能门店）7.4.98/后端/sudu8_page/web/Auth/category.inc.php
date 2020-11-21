<?php



/*具体操作*/

$act = isset(self::$_GPC['act']) ? self::$_GPC['act'] : '';



if($act == 'savecategory'){

    $data = $_POST;

    if($data['pid'] == 0 && $data['opt'] == ''){

        $data['opt'] = 'display';

    }

    if($data['icon'] == ''){

        $data['icon'] = 'wb-dashboard';

    }

    #$data['uniacid'] = self::$_W['uniacid'];



    if(isset($data['id']) && $data['id'] > 0){

        $isdata = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_mcategory')." WHERE `cate_name` = '{$data['cate_name']}' AND `id` != {$data['id']}");

    }else{

        $isdata = pdo_get("sudu8_page_mcategory",['cate_name' => $data['cate_name'],'pid' => 0]);

    }



    if(isset($data['id']) && $data['id'] > 0){

        $id = $data['id'];unset($data['id']);

        $result = pdo_update("sudu8_page_mcategory",$data,array('id' => $id));

    }else{

        if($isdata){

            $this->returnResult($result?1:0,'栏目名称已存在');

        }
        $result = pdo_insert("sudu8_page_mcategory",$data);

    }
    $userid = self::$_W['user']['uid'];
    cache_delete($userid.'catelist');

    return $this->returnResult($result?1:0,'保存成功');

}

if($act == 'addcategory'){
    $pid = isset(self::$_GPC['pid']) ? self::$_GPC['pid'] : 0;
    

    if($pid > 0){

        $sql = "SELECT id,cate_name,pid FROM ".tablename('sudu8_page_mcategory')." WHERE `id` = {$pid}";

        $parent = pdo_fetch($sql);

    }

    return include self::template('web/Auth/addcategory');

}



if($act == 'editcategory'){

    $id = self::$_GPC['id'];

    $data = pdo_get("sudu8_page_mcategory",array('id' => $id));

    if($data['pid'] > 0){

        $pid = $data['pid'];

        $parent = pdo_get("sudu8_page_mcategory",array('id' => $pid));

    }

    return include self::template('web/Auth/editcategory');

}



if($act == 'delcategory'){

    $id = self::$_GPC['id'];

    $p = isset(self::$_GPC['p']) ? self::$_GPC['p'] : 1;



    pdo_delete("sudu8_page_mcategory",array('id' => $id));



    if($p == 0){

        pdo_delete("sudu8_page_mcategory",array('pid' => $id));

    }



    message("删除成功",referer(),'success');

}