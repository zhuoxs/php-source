<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Noteprinttemp extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
    }
	
	public function index() {
	
	}
	
	
	 
	 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */