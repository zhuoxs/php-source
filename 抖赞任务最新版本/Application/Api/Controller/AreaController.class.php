<?php
namespace Api\Controller;
use Common\Controller\HomeBaseController;

class AreaController extends HomeBaseController{

    /**
     * 列表
     */
    public function index() {
        $p = I('get.p', 0);
        $val = I('get.val');
        $list = M('province_city_area')->where(array('pid'=>$p))->select();

        $html = '';
        foreach( $list as $v) {
            $selected = $val == $v['id'] ? 'selected' :'';
            $html .= "<option value='".$v['id']."' {$selected}>".$v['name']."</option>";
        }
        echo $html;
    }


    public function ajax() {
        $pid = $_REQUEST['pid'];
        $list = D('Area')->where(array('pid'=>$pid))->select();
        $html = '';
        foreach( $list as $k=>$v ) {
            $html .= '<option value="'.$v["area_id"].'">'.$v["title"].'</option>';
        }
        echo $html;
    }
}
