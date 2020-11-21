<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Warranty extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
    }
	
 
	public function index() {
		 
	}
	
	
	public function getAdvancedList(){
		$data['status'] = 200;
		$data['msg']    = 'success'; 
		$data['data']['page']      = 1;
		$data['data']['total']     = 0;
		$data['data']['records']   = 0;
		$data['data']['rows']      = array();
		die(json_encode($data));
	}
	
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */