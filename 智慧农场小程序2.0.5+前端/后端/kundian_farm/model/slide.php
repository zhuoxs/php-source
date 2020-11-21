<?php
/**
 * Created by Sublime Text
 * User: 坤典科技
 * Date: 2018/10/10
 * Time: 10:47
 */
defined('IN_IA') or exit('Access Denied');
class Slide_KundianFarmModel{
	public $tableName='cqkundian_farm_slide';

	public function __construct($tableName='cqkundian_farm_slide'){
		$this->tableName=$tableName;
	}

	/** 添加轮播图 */
	public function addSlide($formData){
	    global $_W;
        $data=array(
            'slide_src'=>tomedia($formData['slide_src']),
            'slide_type'=>$formData['slide_type'],
            'link_type'=>$formData['link_type'],
            'link_param'=>$formData['link_param'],
            'status'=>$formData['status'],
            'rank'=>$formData['rank'],
            'uniacid'=>$_W['uniacid'],
        );
        if(empty($formData['id'])){  //新增
            return pdo_insert($this->tableName,$data);
        }
        return pdo_update($this->tableName,$data,['id'=>$formData['id'],'uniacid'=>$_W['uniacid']]);
    }

}

