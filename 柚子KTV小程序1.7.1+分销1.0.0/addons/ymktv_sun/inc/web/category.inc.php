<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$type= isset($_GPC['type'])?$_GPC['type']:0;
$list = pdo_getall('fyly_sun_category',array('uniacid'=>$_W['uniacid']),'','','cid ASC');
$list = getTree($list);



if($_GPC['op']=='delete'){
    $data = pdo_getall('fyly_sun_category',array('uniacid'=>$_W['uniacid'],'pid'=>$_GPC['cid']));
    if($data){
        message('存在子分类，请先删除子类！','','error');
    }else{
        $res=pdo_delete('fyly_sun_category',array('cid'=>$_GPC['cid']));
        if($res){
            message('删除成功！', $this->createWebUrl('category'), 'success');
        }else{
            message('删除失败！','','error');
        }
    }

}
function getTree($data){
   $data = tree($data,'cname');
    return $data;
}

function tree( $data, $title, $fieldPri = 'cid', $fieldPid = 'pid' ) {
    if ( ! is_array( $data ) || empty( $data ) ) {
        return [ ];
    }
    $arr = channelList( $data, 0, '', $fieldPri, $fieldPid );
    foreach ( $arr as $k => $v ) {
        $str = "";
        if ( $v['_level'] > 2 ) {
            for ( $i = 1; $i < $v['_level'] - 1; $i ++ ) {
                $str .= "│&nbsp;&nbsp;&nbsp;&nbsp;";
            }
        }
        if ( $v['_level'] != 1 ) {
            $t = $title ? $v[ $title ] : '';
            if ( isset( $arr[ $k + 1 ] ) && $arr[ $k + 1 ]['_level'] >= $arr[ $k ]['_level'] ) {
                $arr[ $k ][ '_' . $title ] = $str . "├─ " . $v['_html'] . $t;
            } else {
                $arr[ $k ][ '_' . $title ] = $str . "└─ " . $v['_html'] . $t;
            }
        } else {
            $arr[ $k ][ '_' . $title ] = $v[ $title ];
        }
    }
    //设置主键为$fieldPri
    $data = [ ];
    foreach ( $arr as $d ) {
        //            $data[$d[$fieldPri]] = $d;
        $data[] = $d;
    }

    return $data;
}
function channelList( $data, $pid = 0, $html = "&nbsp;", $fieldPri = 'cid', $fieldPid = 'pid', $level = 1 ) {
    $data = _channelList( $data, $pid, $html, $fieldPri, $fieldPid, $level );
    if ( empty( $data ) ) {
        return $data;
    }
    foreach ( $data as $n => $m ) {
        if ( $m['_level'] == 1 ) {
            continue;
        }
        $data[ $n ]['_first'] = false;
        $data[ $n ]['_end']   = false;
        if ( ! isset( $data[ $n - 1 ] ) || $data[ $n - 1 ]['_level'] != $m['_level'] ) {
            $data[ $n ]['_first'] = true;
        }
        if ( isset( $data[ $n + 1 ] ) && $data[ $n ]['_level'] > $data[ $n + 1 ]['_level'] ) {
            $data[ $n ]['_end'] = true;
        }
    }
    //更新key为栏目主键
    $category = [ ];
    foreach ( $data as $d ) {
        $category[ $d[ $fieldPri ] ] = $d;
    }

    return $category;
}

//只供channelList方法使用
function _channelList( $data, $pid = 0, $html = "&nbsp;", $fieldPri = 'cid', $fieldPid = 'pid', $level = 1 ) {
    if ( empty( $data ) ) {
        return [ ];
    }
    $arr = [ ];
    foreach ( $data as $v ) {
        $id = $v[ $fieldPri ];
        if ( $v[ $fieldPid ] == $pid ) {
            $v['_level'] = $level;
            $v['_html']  = str_repeat( $html, $level - 1 );
            array_push( $arr, $v );
            $tmp = _channelList( $data, $id, $html, $fieldPri, $fieldPid, $level + 1 );
            $arr = array_merge( $arr, $tmp );
        }
    }

    return $arr;
}

include $this->template('web/category');