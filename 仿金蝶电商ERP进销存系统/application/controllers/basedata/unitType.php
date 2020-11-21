<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Unittype extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
    }
	
	public function index() {
		$list = $this->mysql_model->get_results('unittype',array('isDelete'=>0),'id desc');  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['entries']     = array();
			$v[$arr]['guid']        = '';
			$v[$arr]['id']          = intval($row['id']);
			$v[$arr]['name']        = $row['name'];
		}
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['items']      = isset($v) ? $v : array();
		$json['data']['totalsize']  = count($list);
		die(json_encode($json));  
	}
	
	//新增
	public function add() {
		$this->common_model->checkpurview(59);
		$data['name'] = $name = $this->input->post('name',TRUE);
		strlen($name) < 1 && str_alert(-1,'名称不能为空');
		$this->mysql_model->get_count('unittype',array('name'=>$name)) && str_alert(-1,'单位组名称重复');
		$sql = $this->mysql_model->insert('unittype',$data);
		if ($sql) {
			$data['id'] = $sql;
			$this->common_model->logs('新增单位组:'.$name);
			str_alert(200,'success',$data);
		}
		str_alert(-1,'添加失败');
	}
	
	//修改
	public function update(){
		$this->common_model->checkpurview(59);
		$id   = intval($this->input->post('id',TRUE));
		$name = str_enhtml($this->input->post('name',TRUE));
		$info = $this->mysql_model->get_rows('unittype','(id='.$id.') and (isDelete=0)'); 
		if (count($info)>0) {
			strlen($name) < 1 && str_alert(-1,'名称不能为空');
			$this->mysql_model->get_count('unittype',array('isDelete'=>$isDelete,'name'=>$name,'id !='=>$id)) > 0 && str_alert(-1,'单位组名称重复');
			$sql = $this->mysql_model->update('unittype',array('name'=>$name),array('id'=>$id));
			if ($sql) {
				$data['id']      = $id;
				$data['name']    = $name;
				$data['entries'] = array();
				$data['guid']    = '';
				$this->common_model->logs('更新单位组:'.$data['name']);
				str_alert(200,'success',$data);
			}
		}
		str_alert(-1,'更新失败');
	}
	
	//删除
	public function delete(){
		$this->common_model->checkpurview(59);
		$id = intval($this->input->post('id',TRUE));
		$data = $this->mysql_model->get_rows('unittype',array('isDelete'=>$isDelete,'id'=>$id)); 
		if (count($data)>0) {
		    $this->mysql_model->get_count('unit',array('isDelete'=>$isDelete,'unittypeid'=>$id))>0 && str_alert(-1,'发生业务不可删除');
			$sql = $this->mysql_model->update('unittype',array('isDelete'=>1),array('id'=>$id));         
		    if ($sql) {
				$this->common_model->logs('删除单位组:ID='.$id.' 名称:'.$data['name']);
				str_alert(200,'success',array('msg'=>'成功删除','id'=>'['.$id.']'));
			}
		}
		str_alert(-1,'删除失败');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */