<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Assisttype extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
    }
	
	//辅助属性列表
	public function index() { 
		$list = $this->mysql_model->get_results('assistingprop',array('isDelete'=>0),'id desc');  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['id']       = intval($row['id']);
			$v[$arr]['name']     = $row['name'];
			$v[$arr]['del']      = false;
		}
		$json['status'] = 200;
		$json['msg']    = 'success';
		$json['data']['items']      = isset($v) ? $v : array();
		$json['data']['totalsize']  = count($list);
		die(json_encode($json));
	}
	
	//新增
	public function add(){
		$this->common_model->checkpurview(59);
		$type = $this->input->post('type',TRUE);
		$data = str_enhtml($this->input->post(NULL,TRUE));
		if (count($data)>0) {
			strlen($data['name']) < 1 && str_alert(-1,'名称不能为空');
			$this->mysql_model->get_count('assistingprop','(isDelete=0) and (name="'.$data['name'].'")') > 0 && str_alert(-1,'名称重复');
			$sql = $this->mysql_model->insert('assistingprop',$data);
			if ($sql) {
				$data['id'] = $sql;
				$this->common_model->logs('新增辅助属性:'.$data['name']);
				str_alert(200,'success',$data);
			}
		}
		str_alert(-1,'添加失败');
	}
	
	
	//修改
	public function update(){
		$this->common_model->checkpurview(59);
		$data = str_enhtml($this->input->post(NULL,TRUE));
		if (count($data)>0) {
			$id   = intval($data['id']); 
			unset($data['id']);
			strlen($data['name']) < 1 && str_alert(-1,'名称不能为空');
			$this->mysql_model->get_count('assistingprop','(id<>'.$id.') and (name="'.$data['name'].'")') > 0 && str_alert(-1,'名称重复');
			$sql = $this->mysql_model->update('assistingprop',$data,'(id='.$id.')');
			if ($sql) {
				$data['id'] = $id;
				$this->common_model->logs('更新辅助属性:'.$data['name']);
				str_alert(200,'success',$data);
			}
		}
		str_alert(-1,'更新失败');
	}
	
	//删除
	public function delete(){
		$this->common_model->checkpurview(59);
		$id = intval($this->input->get_post('id',TRUE));
		$data = $this->mysql_model->get_rows('assistingprop','(id='.$id.')'); 
		if (count($data)>0) {
		    $this->mysql_model->get_count(GOODS,'(isDelete=0) and find_in_set('.$id.',skuAssistId)')>0 && str_alert(-1,'数据在使用中,不能删除'); 
			$info['isDelete'] = 1;
			$sql = $this->mysql_model->update('assistingprop',$info,'(id='.$id.')');    
		    if ($sql) {
				$this->common_model->logs('删除辅助属性:ID='.$id.' 名称:'.$data['name']);
				str_alert(200,'success');
			}
		}
		str_alert(-1,'删除失败');
	}
    
	
	//公共验证
	private function validform($data) {
	    $data['id']  = intval($data['id']); 
        strlen($data['name']) < 1 && str_alert(-1,'名称不能为空');
		strlen($data['type']) < 1 && str_alert(-1,'编号不能为空');
		return $data;
	} 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */