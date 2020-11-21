<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Receipt extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
		$this->jxcsys = $this->session->userdata('jxcsys');
    }
	
	public function index() {
	    $action = $this->input->get('action',TRUE);
		switch ($action) {
			case 'initReceipt':
			    $this->common_model->checkpurview(125);
			    $this->load->view('scm/receipt/initReceipt');	
				break;  
			case 'editReceipt':
			    $this->common_model->checkpurview(124);
			    $this->load->view('scm/receipt/initReceipt');	
				break;  	
			case 'initUnhxList':
			    $this->load->view('scm/receipt/initUnhxList');
				break; 
			case 'initReceiptList':
			    $this->common_model->checkpurview(124);
			    $this->load->view('scm/receipt/initReceiptList');
				break;
			default:  
			    $this->common_model->checkpurview(124);
			    $this->receiptList();	
		}
	}
	
	public function receiptList() {
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100);
		$matchCon  = str_enhtml($this->input->get_post('matchCon',TRUE));
		$beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
		$where  = 'a.isDelete=0 and a.transType=153001'; 
		$where .= $matchCon  ? ' and a.postData like "%'.$matchCon.'%"' : ''; 
		$where .= $beginDate ? ' and billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_admin_purview();                  
		$list = $this->data_model->get_invoice($where.' order by id desc limit '.$rows*($page-1).','.$rows);  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['id']           = intval($row['id']);
		    $v[$arr]['amount']       = (float)$row['rpAmount']; 
			$v[$arr]['adjustRate']   = (float)$row['discount'];   //整单折扣
			$v[$arr]['deAmount']     = (float)$row['payment'];    //本次预收款
			$v[$arr]['billDate']     = $row['billDate'];
			$v[$arr]['bDeAmount']    = (float)$row['hxAmount'];   //本次核销
			$v[$arr]['hxAmount']     = (float)$row['hxAmount'];   //本次核销
			$v[$arr]['contactName']  = $row['contactName'];
			$v[$arr]['description']  = $row['description'];
			$v[$arr]['billNo']       = $row['billNo'];
			$v[$arr]['checked']      = intval($row['checked']); 
			$v[$arr]['checkName']    = $row['checkName'];
			$v[$arr]['userName']     = $row['userName'];
		}
		$json['status']              = 200;
		$json['msg']                 = 'success'; 
		$json['data']['page']        = $page;
		$json['data']['records']     = $this->data_model->get_invoice($where,3);  
		$json['data']['total']       = ceil($json['data']['records']/$rows);        
		$json['data']['rows']        = isset($v) ? $v : array();
		die(json_encode($json));
	}
	
	public function exportReceipt(){
	    $this->common_model->checkpurview(128);
		$name = 'receipt_record_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('导出收款单:'.$name);
		$matchCon  = str_enhtml($this->input->get_post('matchCon',TRUE));
		$beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
		$locationId   = intval($this->input->get_post('locationId',TRUE));
		$where = 'a.isDelete=0 and transType=153001';
		$where .= $matchCon  ? ' and a.postData like "%'.$matchCon.'%"' : ''; 
		$where .= $beginDate ? ' and billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_admin_purview();
		$data['list'] = $this->data_model->get_invoice($where.' order by id desc'); 
		$data['account']  = array_column($this->mysql_model->get_results('account','(isDelete=0)'),'name','id'); 
		$data['category'] = array_column($this->mysql_model->get_results('category','(typeNumber="PayMethod")'),'name','id'); 
		$this->load->view('scm/receipt/exportReceipt',$data);  
	}
	 
	
    //新增
	public function add(){
	    $this->common_model->checkpurview(125);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->validform((array)json_decode($data, true));
			$info = elements(array(
			    'billNo','billType','transType','transTypeName','postData','buId','createTime',
				'billDate','description','uid','userName','rpAmount','arrears','hxAmount','discount','payment','modifyTime'),$data,NULL);
			$this->db->trans_begin();
			$iid = $this->mysql_model->insert('invoice',$info);
			$amount = $this->account_info($iid,$data);
			//add begin
			$rpAmount = 0;
			$duplicate = array();
			if (is_array($data['entries']) && count($data['entries'])>0) {
			    $v = '';
			    foreach ($data['entries'] as $arr=>$row) {
			        $v[$arr]['iid']         = $iid;
			        $v[$arr]['billId']      = $row['billId'];
			        $v[$arr]['billNo']      = $row['billNo'];
			        $v[$arr]['billDate']    = $row['billDate'];
			        $v[$arr]['transType']   = $row['transType'];
			        $v[$arr]['billType']    = $row['billType'];
			        $v[$arr]['billPrice']   = (float)$row['billPrice'];
			        $v[$arr]['hasCheck']    = (float)$row['hasCheck'];
			        $v[$arr]['notCheck']    = (float)$row['notCheck'];
			        //$rpAmount         +=    $v[$arr]['nowCheck']    = (float)$row->nowCheck;
			        $rpAmount           +=    $v[$arr]['nowCheck']    = (float)$row['nowCheck'];
			        $duplicate[$arr] = $row['billId'];
			    }
			    if(count($duplicate)!= count(array_unique($duplicate))){
			        $this->db->trans_rollback();
			        str_alert(-1,'存在重复的源单编号，请核实！');
			    }
			    if($rpAmount != $amount || $data['payment']!=0){
			        $this->db->trans_rollback();
			        str_alert(-1,'收款金额总和与核销金额总和不相等，请核实！'.$amount.$rpAmount);
			    }
			    $this->mysql_model->insert('verifica_info',$v);
			}
			//$info['amount']    =  $amount;
			//$info['rpAmount']  =  $rpAmount;
			//$this->mysql_model->update(INVOICE,$info,'(id='.$iid.')');
			//add end
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误回滚'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('新增收款单 单据编号：'.$data['billNo']);
				str_alert(200,'success',array('id'=>intval($iid))); 
			}
		}
		str_alert(-1,'提交的是空数据'); 
    } 
	
	
	public function addnew(){
	    $this->add();
    } 
	
	//修改
	public function updateReceipt(){
	    $this->common_model->checkpurview(126);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->validform((array)json_decode($data, true));
			$info = elements(array(
			    'billType','transType','transTypeName','buId','billDate','uid','userName',
				'description','postData','rpAmount','arrears','hxAmount','discount','payment','modifyTime'),$data,NULL);
			$this->db->trans_begin();
			$this->mysql_model->update('invoice',$info,array('id'=>$data['id']));
			$amount = $this->account_info($data['id'],$data);
			//add begin
			$this->mysql_model->delete('verifica_info','(iid='.$data['id'].')');
			$rpAmount = 0;
			$duplicate = array();
			if (isset($data['entries']) && count($data['entries'])>0) {
			    $v = '';
			    foreach ($data['entries'] as $arr=>$row) {
			        $v[$arr]['iid']         = $data['id'];
			        $v[$arr]['billId']      = $row['billId'];
			        $v[$arr]['billNo']      = $row['billNo'];
			        $v[$arr]['billDate']    = $row['billDate'];
			        $v[$arr]['transType']   = $row['transType'];
			        $v[$arr]['billType']    = $row['billType'];
			        $v[$arr]['billPrice']   = (float)$row['billPrice'];
			        $v[$arr]['hasCheck']    = (float)$row['hasCheck'];
			        $v[$arr]['notCheck']    = (float)$row['notCheck'];
			        $rpAmount         +=    $v[$arr]['nowCheck']    = (float)$row['nowCheck'];
			        $duplicate[$arr] = $row['billId'];
			    }
			    if(count($duplicate)!= count(array_unique($duplicate))){
			        $this->db->trans_rollback();
			        str_alert(-1,'存在重复的源单编号，请核实！');
			    }
			    if($rpAmount != $amount || $data['payment']!=0){
			        $this->db->trans_rollback();
			        str_alert(-1,'收款金额总和与核销金额总和不相等，请核实！');
			    }
			    $this->mysql_model->insert('verifica_info',$v);
			}
			//add end
			
 
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误回滚'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('修改收款单 单据编号：'.$data['billNo']);
				str_alert(200,'success',array('id'=>$data['id'])); 
			}
		}
		str_alert(-1,'参数错误'); 
    }	
    
	//信息 
    public function update() {
	    $this->common_model->checkpurview(124);
	    $id   = intval($this->input->get_post('id',TRUE));
		$data = $this->data_model->get_invoice('a.isDelete=0 and a.id='.$id.' and a.transType=153001',1); 
		if (count($data)>0) {
			$list = $this->data_model->get_account_info('a.iid='.$id);  
			foreach ($list as $arr=>$row) {
			    $v[$arr]['id']            = intval($arr+1);
				$v[$arr]['payment']       = (float)$row['payment']; 
				$v[$arr]['remark']        = $row['remark'];  
				$v[$arr]['accName']       = $row['accountNumber'].' '.$row['accountName']; 
				$v[$arr]['settlement']    = $row['settlement']; 
				$v[$arr]['wayName']       = $row['categoryName']; 
				$v[$arr]['wayId']         = $row['wayId'];
				$v[$arr]['accId']         = intval($row['accId']);
		    } 
			 
			$json['status']               = 200;
			$json['msg']                  = 'success'; 
			$json['data']['id']           = $id;
			$json['data']['buId']         = intval($data['buId']);
			$json['data']['contactName']  = $data['contactName'];
			$json['data']['date']         = $data['billDate'];
			$json['data']['billNo']       = $data['billNo'];
			$json['data']['discount']     = (float)$data['discount'];
			$json['data']['payment']      = (float)$data['payment'];
			$json['data']['checkName']    = $data['checkName'];
			$json['data']['userName']     = $data['userName']; 
			$json['data']['createTime']   = $data['createTime'];
			$json['data']['modifyTime']   = $data['modifyTime'];
			$json['data']['description']  = $data['description'];
			$json['data']['checked']      = intval($data['checked']); 
			$json['data']['status']       = intval($data['checked'])==1 ? 'view' : 'edit';     
			$json['data']['accounts']     = isset($v) ? $v : array();
			$json['data']['entries']      = array();
			//add begin
			$s = array();
			$list = $this->mysql_model->get_results('verifica_info','(iid='.$id.') order by id desc');
			foreach ($list as $arr=>$row) {
			    $s[$arr]['billId']      = intval($row['billId']);
			    $s[$arr]['billNo']      = $row['billNo'];
			    $s[$arr]['billDate']    = $row['billDate'];
			    $s[$arr]['transType']   = $row['transType'];
			    $s[$arr]['billType']    = $row['billType'];
			    $s[$arr]['billPrice']   = (float)$row['billPrice'];
			    $s[$arr]['hasCheck']    = (float)$row['hasCheck'];
			    $s[$arr]['notCheck']    = (float)$row['notCheck'];
			    $s[$arr]['nowCheck']    = (float)$row['nowCheck'];
			    $s[$arr]['type']        = 1;
			}
			$json['data']['entries']    = $s;
			//add end
			die(json_encode($json));
		}
		str_alert(-1,'参数错误'); 
    }
	
	 
	 
	
	//删除
    public function delete() {
	    $this->common_model->checkpurview(127);
	    $id   = intval($this->input->get('id',TRUE));
		$data = $this->mysql_model->get_rows('invoice',array('id'=>$id,'transType'=>153001));  
		if (count($data)>0) {
		    $this->db->trans_begin();
			$this->mysql_model->update('invoice',array('isDelete'=>1),array('id'=>$id));   
			$this->mysql_model->update('account_info',array('isDelete'=>1),array('iid'=>$id));    
			//$this->mysql_model->update('verifica_info',array('isDelete'=>1),array('iid'=>$id));
			$this->mysql_model->delete('verifica_info','(iid='.$id.')');//add
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'删除失败'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('删除收款单 单据编号：'.$data['billNo']);
				str_alert(200,'success'); 	 
			}
		}
		str_alert(-1,'单据不存在,或已被删除'); 
	}
	
	//公共验证
	private function validform($data) {
	    $data['id']            = isset($data['id']) ? intval($data['id']) : 0;
		$data['buId']          = intval($data['buId']);
		$data['billDate']      = $data['date'] ? $data['date'] : date('Y-m-d');
		$data['billType']      = 'RECEIPT';
		$data['transType']     = 153001;
		$data['transTypeName'] = '收款';
		$data['uid']           = $this->jxcsys['uid'];
		$data['userName']      = $this->jxcsys['name'];
		$data['modifyTime']    = date('Y-m-d H:i:s');
		$data['createTime']    = $data['modifyTime'];
        $data['hxAmount']      = $data['rpAmount']      = 0;
		$data['entries']       = isset($data['entries']) ? $data['entries'] : array();
		$data['accounts']      = isset($data['accounts']) ? $data['accounts'] : array();
		count($data['accounts']) < 1 && str_alert(-1,'提交的是空数据'); 
		
		//修改的时候 
		if ($data['id']>0) {
		    $invoice = $this->mysql_model->get_rows('invoice',array('id'=>$data['id'],'billType'=>'RECEIPT','isDelete'=>0));  
			count($invoice)<1 && str_alert(-1,'单据不存在、或者已删除');
			$data['billNo']  = $invoice['billNo'];
			$data['checked'] = $invoice['checked'];		
		} else {
		    $data['billNo'] = str_no('SKD');    
		}
		
		$this->mysql_model->get_count('contact',array('id'=>$data['buId']))<1 && str_alert(-1,'请选择客户，客户不能为空！'); 
		
		foreach ($data['accounts'] as $arr=>$row) {
		    (float)$row['payment'] < 0 && str_alert(-1,'收款金额不能为负数！'); 
			$data['rpAmount'] += abs($row['payment']);
		} 
		/*foreach ($data['entries'] as $arr=>$row) {
		    (float)$row['nowCheck'] < 0 && str_alert(-1,'核销金额不能为负数！'); 
			$data['hxAmount'] += abs($row['nowCheck']);
		} */
		
		$data['arrears'] = -$data['rpAmount'];
		$data['postData'] = serialize($data);
		return $data;
	}  
	
	
	private function account_info($iid,$data) {
	    $amount = 0;
		foreach ($data['accounts'] as $arr=>$row) {
			$v[$arr]['iid']           = $iid;
			$v[$arr]['uid']           = $data['uid'];
			$v[$arr]['billNo']        = $data['billNo'];
			$v[$arr]['buId']          = $data['buId'];
			$v[$arr]['billType']      = $data['billType'];
			$v[$arr]['transType']     = $data['transType'];
			$v[$arr]['transTypeName'] = $data['transTypeName'];
			$v[$arr]['billDate']      = $data['billDate']; 
			$v[$arr]['accId']         = $row['accId'];
			$v[$arr]['payment']       = abs($row['payment']); 
			$v[$arr]['wayId']         = $row['wayId'];
			$v[$arr]['settlement']    = $row['settlement'];
			$v[$arr]['remark']        = $row['remark'];
			$amount            +=     (float)$row['payment'];
		}  
		if (isset($v)) { 
		    if ($data['id']>0) {  
				$this->mysql_model->delete('account_info',array('iid'=>$iid));
			}
			$this->mysql_model->insert('account_info',$v);
		} 
		
		return $amount;	
    }
    
    private function write_back_invoice($id){
        /*$s = array();
        $list = $this->mysql_model->get_results('verifica_info','(iid='.$id.') order by id desc');
        foreach ($list as $arr=>$row) {
            $s[$arr]['billId']      = intval($row['billId']);
            $s[$arr]['billNo']      = $row['billNo'];
            $s[$arr]['billDate']    = $row['billDate'];
            $s[$arr]['transType']   = $row['transType'];
            $s[$arr]['billType']    = $row['billType'];
            $s[$arr]['billPrice']   = (float)$row['billPrice'];
            $s[$arr]['hasCheck']    = (float)$row['hasCheck'];
            $s[$arr]['notCheck']    = (float)$row['notCheck'];
            $s[$arr]['nowCheck']    = (float)$row['nowCheck'];
            $s[$arr]['type']        = 1;
        }*/
    }
	
	 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */