<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Invlocation extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
    }

    //仓库列表
	public function index(){
		$list = $this->mysql_model->get_results('storage','(isDelete=0) '.$this->common_model->get_location_purview(1).' order by id desc');  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['address']     = $row['address'];
			$v[$arr]['delete']      = $row['disable'] > 0 ? true : false;
		    $v[$arr]['allowNeg']    = false;
			$v[$arr]['deptId']      = intval($row['deptId']);;
			$v[$arr]['empId']       = intval($row['empId']);;
			$v[$arr]['groupx']      = $row['groupx'];
			$v[$arr]['id']          = intval($row['id']);
			$v[$arr]['locationNo']  = $row['locationNo'];
			$v[$arr]['name']        = $row['name'];
			$v[$arr]['phone']       = $row['phone'];
			$v[$arr]['type']        = intval($row['type']);
		}
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['rows']       = isset($v) ? $v : array();
		$json['data']['total']      = 1;
		$json['data']['records']    = count($list);
		$json['data']['page']       = 1;
		die(json_encode($json));
	}
	
	
	//新增
	public function add(){
		$this->common_model->checkpurview(156);
		$data = str_enhtml($this->input->post(NULL,TRUE));
		if (count($data)>0) {
			$data = $this->validform($data);
			$sql  = $this->mysql_model->insert('storage',elements(array('name','locationNo'),$data));
			if ($sql) {
				$data['id'] = $sql;
				$this->common_model->logs('新增仓库:'.$data['name']);
				str_alert(200,'success',$data);
			}  
		}
		str_alert(-1,'添加失败');
	}
	
	//修改
	public function update(){
		$this->common_model->checkpurview(157);
		$data = str_enhtml($this->input->post(NULL,TRUE));
		if (count($data)>0) {
			$data = $this->validform($data);
			$sql  = $this->mysql_model->update('storage',elements(array('name','locationNo'),$data),array('id'=>$data['locationId']));
			if ($sql) {
				$data['id'] = $data['locationId'];
				$this->common_model->logs('更新仓库:'.$data['name']);
				str_alert(200,'success',$data);
			}
		}
		str_alert(-1,'更新失败');
	}
	
	//删除
	public function delete(){
		$this->common_model->checkpurview(158);
		$id   = intval($this->input->post('locationId',TRUE));
		$data = $this->mysql_model->get_rows('storage',array('id'=>$id,'isDelete'=>0)); 
		if (count($data) > 0) {
		    $this->mysql_model->get_count('invoice_info',array('locationId'=>$id,'isDelete'=>0))>0 && str_alert(-1,'不能删除有业务关联的仓库！');
		    $sql = $this->mysql_model->update('storage',array('isDelete'=>1),array('id'=>$id));   
		    if ($sql) {
				$this->common_model->logs('删除仓库:ID='.$id.' 名称:'.$data['name']);
				str_alert(200,'success');
			}
		}
		str_alert(-1,'删除失败');
	}
	
	//启用禁用
	public function disable(){
		$this->common_model->checkpurview(158);
		$id = intval($this->input->post('locationId',TRUE));
		$data = $this->mysql_model->get_rows('storage',array('id'=>$id,'isDelete'=>0)); 
		if (count($data) > 0) {
			$info['disable'] = intval($this->input->post('disable',TRUE));
			$sql = $this->mysql_model->update('storage',$info,array('id'=>$id));
		    if ($sql) {
			    $actton = $info['disable']==0 ? '仓库启用' : '仓库禁用';
				$this->common_model->logs($actton.':ID='.$id.' 名称:'.$data['name']);
				str_alert(200,'success');
			}
		}
		str_alert(-1,'操作失败');
	}
	
	//公共验证
	private function validform($data) {
        strlen($data['name']) < 1 && str_alert(-1,'仓库名称不能为空');
		strlen($data['locationNo']) < 1 && str_alert(-1,'编号不能为空');
		$data['locationId'] = intval($data['locationId']);
		$where = $data['locationId']>0 ? ' and id<>'.$data['locationId'].'' :'';
		$this->mysql_model->get_count('storage','(isDelete=0) and name="'.$data['name'].'" '.$where) > 0 && str_alert(-1,'名称重复');
		$this->mysql_model->get_count('storage','(isDelete=0) and locationNo="'.$data['locationNo'].'" '.$where) > 0 && str_alert(-1,'编号重复');
		return $data;
	}  
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */