<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
    }
	
	//员工列表
	public function index(){ 
		$list = $this->mysql_model->get_results('staff',array('isDelete'=>0),'id desc');  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['birthday']    =$row['birthday'];
		    $v[$arr]['allowNeg']    = false;
			$v[$arr]['commissionrate'] = $row['commissionrate'];
			$v[$arr]['creatorId']    = $row['creatorId'];
			$v[$arr]['deptId']       = $row['deptId'];
			$v[$arr]['description']  = $row['description'];
			$v[$arr]['email']        = $row['name'];
			$v[$arr]['empId']        = $row['empId'];
			$v[$arr]['empType']      = $row['empType'];
			$v[$arr]['fullId']       = $row['fullId'];
			$v[$arr]['id']           = intval($row['id']);
			$v[$arr]['leftDate']     = NULL;
			$v[$arr]['mobile']       = $row['mobile'];
			$v[$arr]['name']         = $row['name'];
			$v[$arr]['number']       = $row['number'];
			$v[$arr]['parentId']     = $row['parentId'];
			$v[$arr]['sex']          = $row['sex'];
			$v[$arr]['userName']     = $row['userName'];
			$v[$arr]['delete']       = intval($row['disable'])==1 ? true : false;   //是否禁用
		}
		$json['status'] = 200;
		$json['msg']    = 'success';
		$json['data']['items']       = isset($v) ? $v : array();
		$json['data']['totalsize']   = count($list);
		die(json_encode($json));	  
	}
	
	//新增
	public function add(){
		$this->common_model->checkpurview(59);
		$data = str_enhtml($this->input->post(NULL,TRUE));
		if (count($data)>0) {
			$data = $this->validform($data);
			$this->mysql_model->get_count('staff',array('isDelete'=>0,'number'=>$data['number'])) > 0 && str_alert(-1,'员工编号重复');
			$sql  = $this->mysql_model->insert('staff',elements(array('name','number'),$data));
			if ($sql) {
				$data['id'] = $sql;
				$this->common_model->logs('新增员工:编号'.$data['number'].' 名称'.$data['name']);
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
			$data = $this->validform($data);
			$this->mysql_model->get_count('staff',array('isDelete'=>0,'number'=>$data['number'],'id !='=>$data['id'])) > 0 && str_alert(-1,'员工编号重复');
			$sql  = $this->mysql_model->update('staff',elements(array('name','number'),$data),array('id'=>$data['id']));
			if ($sql) {
				$this->common_model->logs('更新员工:编号'.$data['number'].' 名称'.$data['name']);
				str_alert(200,'success',$data);
			}
		}
		str_alert(-1,'更新失败');
	}
	
	//删除
	public function delete(){
		$this->common_model->checkpurview(59);
		$id = intval($this->input->post('id',TRUE));
		$data = $this->mysql_model->get_rows('staff',array('id'=>$id)); 
		if (count($data)>0) {
		    $this->mysql_model->get_count('invoice',array('isDelete'=>0,'salesId'=>$data['id']))>0 && str_alert(-1,'其中有客户发生业务不可删除');
			$info['isDelete'] = 1;
			$sql = $this->mysql_model->update('staff',$info,array('id'=>$id));     
		    if ($sql) {
				$this->common_model->logs('删除员工:ID='.$id.' 名称:'.$data['name']);
				str_alert(200,'success',array('msg'=>'成功删除'));
			}
		}
		str_alert(-1,'删除失败');
	}
	
	//状态
	public function disable(){
		$this->common_model->checkpurview(59);
		$id = str_enhtml($this->input->post('employeeIds',TRUE));
		$data = $this->mysql_model->get_rows('staff',array('id'=>$id)); 
		if (count($data) > 0) {
			$info['disable'] = intval($this->input->post('disable',TRUE));
			$sql = $this->mysql_model->update('staff',$info,'(id in('.$id.'))');
		    if ($sql) {
			    $action = $info['disable']==1 ? '员工禁用' : '员工启用';
				$this->common_model->logs($action.':ID:'.$id.'名称:'.$data['name']);
				str_alert(200,'success');
			}
		}
		str_alert(-1,'操作失败');
	}
	
	//名称查询
	public function findByNumberOrName(){
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100);
		$skey = str_enhtml($this->input->get_post('skey',TRUE));
		$where  = $skey ? 'name like "%'.$skey.'%" or number like "%'.$skey.'%"' : '';
		$offset = $rows * ($page-1); 
		$list = $this->mysql_model->get_results('staff',$where,'id desc',$offset,$rows);  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['id']         = intval($row['id']); 
			$v[$arr]['name']       = $row['name'];
			$v[$arr]['number']     = $row['number'];
		}
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['totalsize'] = $this->mysql_model->get_count('staff',$where);   
		$json['data']['items']     = isset($v) ? $v : array();
		die(json_encode($json));
	}
	
	//公共验证
	private function validform($data) {
	    $data['id']  = intval($data['id']); 
        strlen($data['name']) < 1 && str_alert(-1,'名称不能为空');
		strlen($data['number']) < 1 && str_alert(-1,'编号不能为空');
		return $data;
	}  
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */