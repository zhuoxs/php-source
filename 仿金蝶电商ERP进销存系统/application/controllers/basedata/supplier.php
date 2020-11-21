<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview(67);
    }
	
	public function exporter(){
		$name = 'supplier_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('导出供应商:'.$name);
		$skey         = str_enhtml($this->input->get_post('skey',TRUE));
		$categoryId   = intval($this->input->get_post('categoryId',TRUE));
		$where = '(isDelete=0) and type=10 '; 
		$where .= $this->common_model->get_vendor_purview();
		$where .= $skey ? ' and (number like "%'.$skey.'%" or name like "%'.$skey.'%" or linkMans like "%'.$skey.'%")' : '';
		$where .= $categoryId >0 ? ' and cCategory = '.$categoryId.'' : '';                  
		$data['list'] = $this->mysql_model->get_results('contact',$where,'id desc');   
		$this->load->view('settings/vendor-export',$data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */