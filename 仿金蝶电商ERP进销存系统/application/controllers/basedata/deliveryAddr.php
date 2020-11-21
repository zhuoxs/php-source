<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Deliveryaddr extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
    }
	
	//发货地址列表
	public function index(){
		$list = $this->mysql_model->get_results('address',array('isDelete'=>0),'id desc');  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['id']          = $row['id'];
			$v[$arr]['shortName']   = $row['shortName'];
		    $v[$arr]['postalcode']  = $row['postalcode'];
			$v[$arr]['province']    = $row['province'];
			$v[$arr]['city']        = $row['city'];
			$v[$arr]['area']        = $row['area'];
			$v[$arr]['address']     = $row['address'];
			$v[$arr]['linkman']     = $row['linkman'];
			$v[$arr]['phone']       = $row['phone'];
			$v[$arr]['mobile']      = $row['mobile'];
			$v[$arr]['isDefault']   = 1;
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
		$data = str_enhtml($this->input->post(NULL,TRUE));
		if (count($data)>0) { 
			$sql = $this->mysql_model->insert('address',$data);
			if ($sql) {
				$data['id'] = $sql;
				$this->common_model->logs('新增地址:'.$data['shortName']);
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
			$sql = $this->mysql_model->update('address',$data,array('id'=>$id));
			if ($sql) {
				$data['id'] = $id;
				$this->common_model->logs('更新地址:ID='.$id.',名称:'.$data['shortName']);
				str_alert(200,'success',$data);
			}
		}
		str_alert(-1,'更新失败');
	}
	
	//删除
	public function delete(){
		$this->common_model->checkpurview(59);
		$id = intval($this->input->post('id',TRUE));
		$data = $this->mysql_model->get_rows('address',array('id'=>$id)); 
		if (count($data)>0) {
		    //$this->mysql_model->get_count(INVSA,'(contactid in('.$id.'))')>0 && str_alert(-1,'其中有客户发生业务不可删除');
			$sql = $this->mysql_model->update('address',array('isDelete'=>1),array('id'=>$id));    
		    if ($sql) {
				$this->common_model->logs('删除地址:ID='.$id.' 名称:'.$data['shortname']);
				str_alert(200,'success',array('msg'=>'成功删除'));
			}
		}
		str_alert(-1,'删除失败');
	}
	
	//查询
	public function query(){
	    $id = intval($this->input->post('id',TRUE));
		$data = $this->mysql_model->get_rows('address',array('id'=>$id)); 
		if (count($data)>0) {
		    $json['data']['id']          = intval($data['id']);
			$json['data']['shortName']   = $data['shortName'];
		    $json['data']['postalcode']  = $data['postalcode'];
			$json['data']['province']    = $data['province'];
			$json['data']['city']        = $data['city'];
			$json['data']['area']        = $data['area'];
			$json['data']['address']     = $data['address'];
			$json['data']['linkman']     = $data['linkman'];
			$json['data']['phone']       = $data['phone'];
			$json['data']['mobile']      = $data['mobile'];
			$json['data']['isDefault']   = intval($data['isdefault']);
			$json['status']   = 200;
			$json['msg']      = 'success'; 
			die(json_encode($json));
		}
		str_alert(-1,'地址不存在');
	}
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */