<?php
namespace Admin\Widget;
use Think\Controller;

/**
 * 地区选择 widget
 * @example W('Area',array('curPro'=>1,'curCity'=>2,'area'=>3,'tpl'=>''))
 * @author Dav
 */
class AreaWidget extends Controller {
	
    /**
     * @param integer curPro 当前省的ID
     * @param integer curCity 当前城市的ID
     * @param integer area 当前地区的ID
     * @param string  tpl 选用的地区选择模版 loadCity(链接方式) loadArea(文本框形式)
     */
	public function index($pro, $city, $area, $tpl='selectArea') {

        $city_ids = '';
		if(!empty($area)){
			$city_ids .=','.$area;
		}

        $selectedarea = '';
		if($tpl == 'selectArea') {
			$selectedArea = explode(',', $_GET['selected']);
			if(!empty($selectedArea[0])) {
				$selectedarea = $_GET['selected'];
			}
			
			$list = D('Area')->getNetworkList();

            $tmp = array();
            foreach ($list as $key => $value) {
                $tmp['area_'.$key] = $value;
            }
            $list = $tmp;
            unset($tmp);

			$list = json_encode($list);
		}

        $selected= '';
		if($pro != '' || $city != '' && $area != ''){
			$selected= $pro.','.$city.','.$area;

            $city_names = array();
            if( $pro > 0 ) {
                $city_names[] = D('area')->where(array('area_id'=>$pro))->getField('title');
            }
            if( $city > 0 ) {
                $city_names[] = D('area')->where(array('area_id'=>$city))->getField('title');
            }
            if( $area > 0 ) {
                $city_names[] = D('area')->where(array('area_id'=>$area))->getField('title');
            }
            if( !empty($city_names) ) {
                $city_names = implode(' ', $city_names);
            }

            $this->assign('city_names', $city_names);
		}
		$this->assign('list',$list);
		$this->assign('selected',$selected);
		$this->assign('selectedarea',$selectedarea);
		$this->assign('city_ids',$city_ids);
        $this->display('Area:selectArea');
	}
	

	public function ajax($pro, $city, $area, $tpl) {
		$model = D('Area');
		$list['province'] = $model->where(array('pid'=>0))->select();
		$list['city']	  = $model->where(array('pid'=>$pro))->select();
		$list['area']	  = $model->where(array('pid'=>$city))->select();
		$this->assign('list',$list);
		$this->assign('province',$pro);
		$this->assign('city',$city);
		$this->assign('area',$area);
		$this->display('Area:ajax');
	}
	
}