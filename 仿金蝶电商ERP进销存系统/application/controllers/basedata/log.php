<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Log extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview(83);
    }
	
	public function index(){
		$fromDate = str_enhtml($this->input->get_post('fromDate',TRUE));
		$toDate   = str_enhtml($this->input->get_post('toDate',TRUE));
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100);
		$skey = str_enhtml($this->input->get_post('skey',TRUE));
		$user = str_enhtml($this->input->get_post('user',TRUE));
		$where['name'] = $user ? $user :'';
		$where['adddate >='] = $fromDate ? $fromDate :''; 
		$where['adddate <='] = $toDate ? $toDate :'';                   
		$list = $this->mysql_model->get_results('log',array_filter($where),'id desc',$rows*($page-1),$rows);  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['id']              = intval($row['id']);
			$v[$arr]['name']            = $row['name'];
			$v[$arr]['loginName']       = $row['loginName'];
			$v[$arr]['operateTypeName'] = $row['operateTypeName'];
			$v[$arr]['operateType']     = 255;
			$v[$arr]['userId']          = $row['userId'];
			$v[$arr]['log']             = $row['log'];
			$v[$arr]['modifyTime']      = $row['modifyTime'];
		}
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['page']      = $page;                                                      
		$json['data']['records']   = $this->mysql_model->get_count('log',array_filter($where));     
		$json['data']['total']     = ceil($json['data']['records']/$rows); 
		$json['data']['rows']      = isset($v) ? $v : array();
		die(json_encode($json));
	}
	
	public function initloglist(){
		$this->load->view('settings/log-initloglist');	
	}
	
	//用户列表
	public function queryAllUser(){ 
		$list = $this->mysql_model->get_results('admin','(1=1)','uid desc',0,0,'uid,name');  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['userid']   = intval($row['uid']);
			$v[$arr]['name']     = $row['name'];
		}
		$json['status'] = 200;
		$json['msg']    = 'success';                                             
		$json['data']['totalsize']  = count($list);    
		$json['data']['items']      = isset($v) ? $v : array();
		die(json_encode($json));
	}
	
		
    //操作类型
	public function queryAllOperateType(){
		$menu = array_column($this->mysql_model->get_results('menu',array('pid'=>0),'id desc'),'title','id');     
		$list = $this->mysql_model->get_results('menu',array('depth>'=>1),'id desc');  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['indexid']           = $row['id'];
			$v[$arr]['operateTypeName']   = $row['title'].isset($menu[$row['pid']]) ? $menu[$row['pid']] : '';
		}
		$json['status'] = 200;
		$json['msg']    = 'success';                                             
		$json['data']['totalsize']   = count($list);  
		$json['data']['items']       = isset($v) ? $v : array();
		die(json_encode($json));
	}
	
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */