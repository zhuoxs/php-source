<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model{

	public function __construct(){
  		parent::__construct();
		$this->jxcsys = $this->session->userdata('jxcsys');
	}
	
	 
	public function get_admin() { 
		return $this->mysql_model->get_rows('admin',array('uid'=>$this->jxcsys['uid'],'status'=>1)); 
	}
	
	 
	 
	public function checkpurview($id=0) { 
	    !$this->jxcsys && redirect(site_url('login'));
		if ($id>0) {
			$data = $this->get_admin(); 
			if (count($data)>0) {  
			    if ($data['roleid']==0) return true;
				if (in_array($id,explode(',',$data['lever']))) return true; 	
			}
			str_alert(-1,'对不起，您没有此页面的管理权');  
		}
	}
	
	
	public function checkpurviews($id=0) { 
	    !$this->jxcsys && redirect(site_url('login'));
		if ($id>0) {
			$data = $this->get_admin(); 
			if (count($data)>0) {  
			    if ($data['roleid']==0) return true;
				if (in_array($id,explode(',',$data['lever']))) return true; 	
			}
			return false; 	
		}
	}
 
	
	public function get_admin_rights() { 
		$data = $this->get_admin();  
		if (count($data)>0) {  
			if ($data['roleid']==0) { 
				$list = $this->mysql_model->get_results('menu','(1=1)'); 
			} else {
			    $data['lever'] = strlen($data['lever'])>0 ? $data['lever'] : 0;
				$list = $this->mysql_model->get_results('menu','(id in('.$data['lever'].'))'); 
			}
			foreach($list as $arr=>$row){
				$json[$row['module']] = true;
			}
		}
		return isset($json) ? json_encode($json) : '{}'; 
	}
	
	 
	public function get_admin_purview($type='') { 
	    $data = $this->get_admin();  
		$rightids = explode(',',$data['rightids']);	
		if ($type==1) {
			$where = in_array(8,$rightids) && $data['roleid']>0 && strlen($data['righttype8'])>0  ? ' and uid in('.$data['righttype8'].')' : '';
		} else {	
			$where = in_array(8,$rightids) && $data['roleid']>0 && strlen($data['righttype8'])>0  ? ' and a.uid in('.$data['righttype8'].')' : '';
		}
	    return $where; 
	}
	
	 
	public function get_location_purview($type='') { 
	    $data     = $this->get_admin(); 
		$rightids = explode(',',$data['rightids']);	
		if ($type==1) {
			$where = in_array(1,$rightids) && $data['roleid']>0 && strlen($data['righttype1'])>0  ? ' and id in('.$data['righttype1'].')' : '';
		} else {	
			$where = in_array(1,$rightids) && $data['roleid']>0 && strlen($data['righttype1'])>0 ? ' and a.locationId in('.$data['righttype1'].')' : '';
		}
	    return $where; 
	}
	
	 
	public function get_vendor_purview() { 
	    $data     = $this->get_admin(); 
		$rightids = explode(',',$data['rightids']);	
		$where    = in_array(4,$rightids) && $data['roleid']>0 && strlen($data['righttype4'])>0 ? ' and id in('.$data['righttype4'].')' : '';
	    return $where; 
	}
	
	 
	public function get_customer_purview() { 
	    $data     = $this->get_admin(); 
		$rightids = explode(',',$data['rightids']);	
		$where    = in_array(2,$rightids) && $data['roleid']>0 && strlen($data['righttype2'])>0 ? ' and id in('.$data['righttype2'].')' : '';
	    return $where; 
	}
	
	 
	public function get_contact_purview() { 
	    $data  = $this->get_admin(); 
		$rightids = explode(',',$data['rightids']);	
		if (in_array(2,$rightids)) {
		    $arr[] = $data['righttype2'];
		}
		if (in_array(4,$rightids)) {
		    $arr[] = $data['righttype4'];
		}
		$id  = isset($arr) ? join(',',array_filter($arr)) : 0;
		$id  = strlen($id)>0 ? $id : 0;
		$where = $data['roleid']>0 ? ' and id in('.$id.')' : '';
	    return $where; 
	}
	
 
	public function logs($info) {
		$data['userId']     =  $this->jxcsys['uid'];
		$data['name']       =  $this->jxcsys['name'];
		$data['ip']         =  $this->input->ip_address();
		$data['log']        =  $info;
		$data['loginName']  =  $this->jxcsys['username'];
		$data['adddate']    =  date('Y-m-d H');
		$data['modifyTime'] =  date('Y-m-d H:i:s');
		$this->mysql_model->insert('log',$data);		
	}	
	
 
	public function insert_option($key,$val) {
		if (!$this->get_option($key)) {
			$data['option_name']  = $key;
			$data['option_value'] = serialize($val);
			return $this->mysql_model->insert('options',$data);
		}
		return $this->update_option($key,$val);
	}
	
	 
	public function update_option($key,$val) {
		$data['option_value'] = serialize($val);
		return $this->mysql_model->update('options',$data,array('option_name'=>$key));
	}
 
	 
	public function get_option($key) {
		$option_value = $this->mysql_model->get_row('options',array('option_name'=>$key),'option_value'); 
		return $option_value ? unserialize($option_value) : ''; 
	}
	
	
	
}