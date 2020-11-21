<?php
    load()->func('tpl');
    global $_GPC, $_W;
    $uniacid = $_W['uniacid'];

    //删除评论
    $id_arr = $_GPC['id_arr'];
    $id_arr_str = implode(',', $id_arr);
    $type = $_GPC['type'];
    if($type == 'cate'){
        $list2 = pdo_fetchall("SELECT id FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and id in (:id)", array(':uniacid' => $uniacid, ':id' => $id_arr_str));
        $num=0;
        for($i=0;$i<count($list2);$i++){
             $list1 = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_cate')." WHERE uniacid = :uniacid and cid in (:cid)", array(':uniacid' => $uniacid, ':cid' => $list2[$i]['id']));
             for($j=0;$j<count($list1);$j++){
                 if(!in_array($list1[$j]["id"],$id_arr)){
                    $num=$num+1;
                 }
             }
        }
        if($num==0){
            $res = pdo_query("DELETE FROM ".tablename('sudu8_page_cate')." WHERE id in ({$id_arr_str})");
            if($res){
                echo json_encode(['code' => 1,'message' => '删除成功']);exit;
            }else{
                echo json_encode(['code' => 0,'message' => '所删栏目存在子栏目未被选择，删除失败']);exit;
            }
        }else{
            echo json_encode(['code' => 0,'message' => '所删栏目存在子栏目未被选择，删除失败']);
            exit;
        }
    }else if($type == "showArt" || $type == "showProMore" || $type == "showPic" || $type == "showPro"){
        $res = pdo_query("DELETE FROM ".tablename('sudu8_page_products')." WHERE id in ({$id_arr_str})");
    }else if($type == "wxapps"){
        $res = pdo_query("DELETE FROM ".tablename('sudu8_page_wxapps')." WHERE id in ({$id_arr_str})");
    }else if($type == "evaluate"){
        $res = pdo_query("DELETE FROM ".tablename('sudu8_page_evaluate')." WHERE id in ({$id_arr_str})");
    }else if($type == "pinglun"){
        $res = pdo_query("DELETE FROM ".tablename('sudu8_page_comment')." WHERE id in ({$id_arr_str})");
    }else if($type == "duocate"){
        $res = pdo_query("DELETE FROM ".tablename('sudu8_page_multicate')." WHERE id in ({$id_arr_str})");
    }else if($type == "duowhere"){
        $res = pdo_query("DELETE FROM ".tablename('sudu8_page_multicates')." WHERE id in ({$id_arr_str})");
    }else if($type == "staff"){
        $res = pdo_query("DELETE FROM ".tablename('sudu8_page_staff')." WHERE id in ({$id_arr_str})");
    }else if($type == "art_nav"){
        $res = pdo_query("DELETE FROM ".tablename('sudu8_page_art_nav')." WHERE id in ({$id_arr_str})");
    }else if($type == "art_navlist"){
        $res = pdo_query("DELETE FROM ".tablename('sudu8_page_art_navlist')." WHERE id in ({$id_arr_str})");
    }

    if($res){
        echo json_encode(['code' => 1,'message' => '删除成功']);exit;
    }else{
        echo json_encode(['code' => 0,'message' => '所删对象不存在或已删除，删除失败']);exit;
    }

