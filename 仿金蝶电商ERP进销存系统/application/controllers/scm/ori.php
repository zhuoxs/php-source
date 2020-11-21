<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ori extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
		$this->jxcsys = $this->session->userdata('jxcsys');
    }
	
	public function index() {
	    $action = $this->input->get('action',TRUE);
		switch ($action) {
			case 'initInc':
			    $this->common_model->checkpurview(135);
			    $this->load->view('scm/ori/initInc');	
				break; 
			case 'editInc':
			    $this->common_model->checkpurview(136);
			    $this->load->view('scm/ori/initInc');	
				break;  
			case 'initIncList':
			    $this->common_model->checkpurview(134);
			    $this->load->view('scm/ori/initIncList');
				break; 
			case 'initExp':
			    $this->common_model->checkpurview(140);
			    $this->load->view('scm/ori/initExp');	
				break; 
			case 'editExp':
			    $this->common_model->checkpurview(141);
			    $this->load->view('scm/ori/initExp');	
				break;  
			case 'initExpList':
			    $this->common_model->checkpurview(139);
			    $this->load->view('scm/ori/initExpList');
				break; 	 	
			default:  
		}
	}
	
	//其他收入列表
	public function listInc() {
	    $this->common_model->checkpurview(134);
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100);
		$transtypeid = intval($this->input->get_post('transTypeId',TRUE));
		$matchCon  = str_enhtml($this->input->get_post('matchCon',TRUE));
		$beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0 and a.transType=153401';
		$where .= $matchCon  ? ' and a.postData like "%'.$matchCon.'%"' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_admin_purview();                                
		$list = $this->data_model->get_invoice($where.' order by id desc limit '.$rows*($page-1).','.$rows);  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['id']           = intval($row['id']);
		    $v[$arr]['checkName']    = $row['checkName'];
			$v[$arr]['billDate']     = $row['billDate'];
			$v[$arr]['billType']     = $row['billType'];
		    $v[$arr]['amount']       = (float)$row['totalAmount'];
			$v[$arr]['transType']    = intval($row['transType']);;
			$v[$arr]['contactName']  = $row['contactName'];
			$v[$arr]['description']  = $row['description'];
			$v[$arr]['billNo']       = $row['billNo'];
			$v[$arr]['totalAmount']  = (float)$row['totalAmount'];
			$v[$arr]['userName']     = $row['userName'];
			$v[$arr]['transTypeName']= $row['transTypeName'];
			$v[$arr]['checked']      = intval($row['checked']);
		}
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['page']      = $page;
		$json['data']['records']   = $this->data_model->get_invoice($where,3);    
		$json['data']['total']     = ceil($json['data']['records']/$rows); 
		$json['data']['rows']      = isset($v) ? $v : array();
		die(json_encode($json));
	}
	
	//导出其他收入
	public function exportInc() {
	    $this->common_model->checkpurview(138);
		$name = 'other_receipt_record_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('导出其他收入单:'.$name);
		$transtypeid = intval($this->input->get_post('transTypeId',TRUE));
		$matchCon  = str_enhtml($this->input->get_post('matchCon',TRUE));
		$beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0 and a.transType=153401';
		$where .= $matchCon  ? ' and a.postData like "%'.$matchCon.'%"' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_admin_purview();
		$data['list'] = $this->data_model->get_invoice($where.' order by a.id desc'); 
		$data['category'] = array_column($this->mysql_model->get_results('category',array('typeNumber'=>'raccttype')),'name','id');  
		$this->load->view('scm/ori/exportInc',$data);
	}
	
	
	//其他收入新增
	public function addInc(){
	    $this->common_model->checkpurview(135);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->inc_validform((array)json_decode($data, true));
			$info = elements(array(
			    'billNo','billType','transType','transTypeName','postData','createTime',
				'totalAmount','buId','billDate','uid','userName','accId'),$data,NULL);
			$this->db->trans_begin();
			$iid = $this->mysql_model->insert('invoice',$info);
			$this->inc_account_info($iid,$data);
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误回滚'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('新增其他收入 单据编号：'.$data['billNo']);
				str_alert(200,'success',array('id'=>intval($iid))); 
			}
		}
		str_alert(-1,'提交的是空数据'); 
    }
	
	//新增  
	public function addNewInc(){
	    $this->addInc();
    }
	    
	//修改
	public function updateInc(){
	    $this->common_model->checkpurview(136);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->inc_validform((array)json_decode($data, true));
			$info = elements(array(
			    'billType','transType','transTypeName','totalAmount','postData','uid','userName',
				'buId','billDate','accId','modifytime'),$data,NULL);
			$this->db->trans_begin();
			$this->mysql_model->update('invoice',$info,array('id'=>$data['id']));
			$this->inc_account_info($data['id'],$data);
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('修改其他收入 单据编号：'.$data['billNo']);
				str_alert(200,'success',array('id'=>$data['id'])); 
			 }
		}
		str_alert(-1,'单据不存在'); 
    }
	
	
	//获取修改信息
	public function getIncDetail() {
	    $this->common_model->checkpurview(136);
	    $id   = intval($this->input->get_post('id',TRUE));
		$data = $this->data_model->get_invoice('a.isDelete=0 and a.id='.$id.' and a.transType=153401',1); 
		if (count($data)>0) {
			$info['status'] = 200;
			$info['msg']    = 'success'; 
			$info['data']['id']             = intval($data['id']);
			$info['data']['buId']           = intval($data['buId']);
			$info['data']['contactName']    = $data['contactName'];
			$info['data']['date']           = $data['billDate'];
			$info['data']['billNo']         = $data['billNo'];
			$info['data']['amount']         = (float)$data['totalAmount'];
			$info['data']['status']         = 'edit'; 
			$info['data']['accId']          = intval($data['accId']);
			$info['data']['acctName']       = ''; 
			$info['data']['userName']       = $data['userName'];
			$accounts = $this->data_model->get_account_info('a.iid='.$id.'  order by a.id');  
			foreach ($accounts as $arr=>$row) {
				$v[$arr]['amount']          = (float)$row['payment']; 
				$v[$arr]['categoryId']      = (float)$row['wayId']; 
				$v[$arr]['description']     = $row['remark'];
				$v[$arr]['categoryName']    = $row['categoryName']; 
		    }   
			$info['data']['entries']        = isset($v) ? $v : array();
			die(json_encode($info));
		}
		str_alert(-1,'单据不存在'); 
    }
	
	//删除
    public function deleteInc() {
	    $this->common_model->checkpurview(137);
	    $id   = intval($this->input->get('id',TRUE));
		$data = $this->mysql_model->get_rows('invoice',array('id'=>$id,'transType'=>153401));  
		if (count($data)>0) {
		    $this->db->trans_begin();
			$this->mysql_model->update('invoice',array('isDelete'=>1),array('id'=>$id));   
			$this->mysql_model->update('account_info',array('isDelete'=>1),array('iid'=>$id));   
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'删除失败'); 
			} else {
			    $this->db->trans_commit(); 
				$this->common_model->logs('删除单据编号：'.$data['billNo']);
				str_alert(200,'success'); 	 
			}
		}
		str_alert(-1,'单据不存在'); 
	}

	//其他支出单列表
	public function listExp() {
	    $this->common_model->checkpurview(139);
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100);
		$matchCon  = str_enhtml($this->input->get_post('matchCon',TRUE));
		$beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0 and a.transType=153402';
		$where .= $matchCon  ? ' and a.postData like "%'.$matchCon.'%"' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_admin_purview();
		$list = $this->data_model->get_invoice($where.' order by id desc limit '.$rows*($page-1).','.$rows);  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['checkName']    = $row['checkName'];
			$v[$arr]['billDate']     = $row['billDate'];
			$v[$arr]['billType']     = $row['billType'];
			$v[$arr]['id']           = intval($row['id']);
		    $v[$arr]['amount']       = (float)$row['totalAmount'];
			$v[$arr]['transType']    = intval($row['transType']);;
			$v[$arr]['contactName']  = $row['contactName'];
			$v[$arr]['description']  = $row['description'];
			$v[$arr]['billNo']       = $row['billNo'];
			$v[$arr]['totalAmount']  = (float)$row['totalAmount'];
			$v[$arr]['userName']     = $row['userName'];
			$v[$arr]['transTypeName']= '';
			$v[$arr]['checked']      = intval($row['checked']);
		}
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['page']        = $page;
		$json['data']['records']     = $this->data_model->get_invoice($where,3);    
		$json['data']['total']       = ceil($json['data']['records']/$rows);                     
		$json['data']['rows']        = isset($v) ? $v : array();
		die(json_encode($json));
	}
	
	//导出其他支出
	public function exportExp() {
	    $this->common_model->checkpurview(143);
		$name = 'other_payment_record_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('导出其他支出单:'.$name);
		$transtypeid = intval($this->input->get_post('transTypeId',TRUE));
		$matchCon  = str_enhtml($this->input->get_post('matchCon',TRUE));
		$beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0 and a.transType=153402';
		$where .= $matchCon  ? ' and a.postData like "%'.$matchCon.'%"' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : '';  
		$where .= $this->common_model->get_admin_purview();
		$data['list'] = $this->data_model->get_invoice($where.' order by id desc');
		$data['category'] = array_column($this->mysql_model->get_results('category','(typeNumber="paccttype")'),'name','id');  
		$this->load->view('scm/ori/exportExp',$data);
	}
	
	//新增
	public function addExp(){
	    $this->common_model->checkpurview(140);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->exp_validform((array)json_decode($data, true));
			$info = elements(array(
			    'billNo','billType','transType','transTypeName','postData',
				'totalAmount','buId','billDate','uid','userName','accId'),$data);
			$this->db->trans_begin();
			$iid = $this->mysql_model->insert('invoice',$info);
			$this->exp_account_info($iid,$data);
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误回滚'); 
			} else {
			    $this->db->trans_commit(); 
				$this->common_model->logs('新增其他收入 单据编号：'.$data['billNo']);
				str_alert(200,'success',array('id'=>intval($iid))); 
			}
		}
		str_alert(-1,'提交的是空数据'); 
    }
	
	//新增
	public function addNewExp(){
	    $this->addExp();
    }
	
	 
	//修改
	public function updateExp(){
	    $this->common_model->checkpurview(141);
	    $postData = $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->exp_validform((array)json_decode($data, true)); 
			$info = elements(array(
			    'billType','transType','transTypeName','totalAmount','postData',
				'buId','billDate','accId','modifytime','uid','userName'),$data);
			$this->db->trans_begin();
			$this->mysql_model->update('invoice',$info,array('id'=>$data['id']));
			$this->exp_account_info($data['id'],$data);
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误回滚'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('修改其他支出 单据编号：'.$data['billNo']);
				str_alert(200,'success',array('id'=>$data['id'])); 
			}
		}
		str_alert(-1,'参数错误'); 
    }
	
	
	//获取修改信息
	public function getExpDetail() {
	    $this->common_model->checkpurview(141);
	    $id   = intval($this->input->get_post('id',TRUE));
		$data = $this->data_model->get_invoice('a.isDelete=0 and a.id='.$id.' and a.transType=153402',1); 
		if (count($data)>0) {
			$info['status'] = 200;
			$info['msg']    = 'success'; 
			$info['data']['id']             = intval($data['id']);
			$info['data']['buId']           = intval($data['buId']);
			$info['data']['contactName']    = $data['contactName'];
			$info['data']['date']           = $data['billDate'];
			$info['data']['billNo']         = $data['billNo'];
			$info['data']['amount']         = (float)abs($data['amount']);
			$info['data']['status']         = 'edit'; 
			$info['data']['accId']          = intval($data['accId']);
			$info['data']['acctName']       = ''; 
			$info['data']['userName']       = $data['userName'];
			$accounts = $this->data_model->get_account_info('a.isDelete=0 and a.iid='.$id.'  order by a.id');  
			foreach ($accounts as $arr=>$row) {
				$v[$arr]['amount']          = $row['payment']>0 ? -abs($row['payment']) : abs($row['payment']); 
				$v[$arr]['categoryId']      = (float)$row['wayId']; 
				$v[$arr]['description']     = $row['remark'];
				$v[$arr]['categoryName']    = $row['categoryName']; 
		    }   
			$info['data']['entries']        = isset($v) ? $v : array();
			die(json_encode($info));
		} else { 
		    str_alert(-1,'参数错误'); 
		}
    }
	
	//删除
    public function deleteExp() {
	    $this->common_model->checkpurview(142);
	    $id   = intval($this->input->get('id',TRUE));
		$data = $this->mysql_model->get_rows('invoice',array('id'=>$id,'transType'=>153402));  
		if (count($data)>0) {
		    $this->db->trans_begin();
			$this->mysql_model->update('invoice',array('isDelete'=>1),array('id'=>$id));   
			$this->mysql_model->update('account_info',array('isDelete'=>1),array('iid'=>$id));   
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'删除失败'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('删除单据编号：'.$data['billNo']);
				str_alert(200,'success'); 	 
			}
		}
		str_alert(-1,'单据不存在'); 
	}
	
	
	//打印
    public function toPdf() {
	    $this->common_model->checkpurview(85);
	    $id   = intval($this->input->get('id',TRUE));
		$transType   = intval($this->input->get('transType',TRUE));
		$data = $this->data_model->get_invoice('a.isDelete=0 and a.id='.$id.' and a.transType='.$transType.'',1);  
		if (count($data)>0) { 
			$data['num']    = 8;
			$data['system'] = $this->common_model->get_option('system'); 
			$list = $this->data_model->get_account_info('a.isDelete=0 and a.iid='.$id.' order by a.id');  
			$data['countpage']  = ceil(count($list)/$data['num']);                      
			foreach($list as $arr=>$row) {
			    $data['list'][] = array(
				'i'=>$arr + 1,
				'amount'=>abs($row['payment']),
				'categoryId'=>intval($row['wayId']),
				'description'=>$row['remark'],
				'categoryName'=>$row['categoryName']
				);  
			}
		    ob_start();
			$this->load->view('scm/ori/toPdf',$data);
			$content = ob_get_clean();
			require_once('./application/libraries/html2pdf/html2pdf.php');
			try {
				$html2pdf = new HTML2PDF('P', 'A4', 'tr');
				$html2pdf->setDefaultFont('javiergb');
				$html2pdf->pdf->SetDisplayMode('fullpage');
				$html2pdf->writeHTML($content, '');
				$html2pdf->Output('ori_'.date('YmdHis').'.pdf');
			}catch(HTML2PDF_exception $e) {
				echo $e;
				exit;
			}  
		} 
		str_alert(-1,'单据不存在、或者已删除');  	   
	}
	
	
	//公共验证
	private function inc_validform($data) { 
	    $data['id']            = isset($data['id']) ? intval($data['id']) : 0;
		$data['buId']          = intval($data['buId']);
		$data['billDate']      = $data['date'] ? $data['date'] : date('Y-m-d');
		$data['accId']         = intval($data['accId']);
		$data['totalAmount']   = (float)$data['totalAmount'];
		$data['billType']      = 'QTSR';
		$data['transType']     = 153401;
		$data['transTypeName'] = '其他收入';
		$data['uid']           = $this->jxcsys['uid'];
		$data['userName']      = $this->jxcsys['name'];
		$data['modifytime']    = date('Y-m-d H:i:s');
		$data['createTime']    = $data['modifyTime'];
		$data['postData']      = serialize($data);
		$data['entries']       = isset($data['entries']) ? $data['entries'] : array();
		count($data['entries']) < 1 && str_alert(-1,'提交的是空数据'); 
		
		//修改的时候  
		if ($data['id']>0) {
		    $invoice = $this->mysql_model->get_rows('invoice',array('id'=>$data['id'],'transType'=>153401,'isDelete'=>0));  
			count($invoice)<1 && str_alert(-1,'单据不存在、或者已删除');
			$data['billNo'] = $invoice['billNo'];	
		} else {
		    $data['billNo'] = str_no('QTSR');    
		}
	    return $data;	
	}  
	
	//公共验证
	private function exp_validform($data) { 
	    $data['id']            = isset($data['id']) ? intval($data['id']) : 0;
		$data['buId']          = intval($data['buId']);
		$data['billDate']      = $data['date'] ? $data['date'] : date('Y-m-d');
		$data['accId']         = intval($data['accId']);
		$data['totalAmount']   = (float)$data['totalAmount'];
		$data['billNo']        = str_no('QTZC');
		$data['billType']      = 'QTZC';
		$data['transType']     = 153402;
		$data['transTypeName'] = '其他支出';
		$data['uid']           = $this->jxcsys['uid'];
		$data['userName']      = $this->jxcsys['name'];
		$data['modifytime']    = date('Y-m-d H:i:s');
		$data['createTime']    = $data['modifyTime'];
		$data['postData']      = serialize($data);
		$data['entries']       = isset($data['entries']) ? $data['entries'] : array();
		count($data['entries']) < 1 && str_alert(-1,'提交的是空数据');
		
		//修改的时候  
		if ($data['id']>0) {
		    $invoice = $this->mysql_model->get_rows('invoice',array('id'=>$data['id'],'transType'=>153402,'isDelete'=>0));  
			count($invoice)<1 && str_alert(-1,'单据不存在、或者已删除');
			$data['billNo'] = $invoice['billNo'];	
		} else {
		    $data['billNo'] = str_no('QTSR');    
		} 
	    return $data;	
	}  
	
	
	private function inc_account_info($iid,$data) {
	    foreach ($data['entries'] as $arr=>$row) {
			$v[$arr]['iid']           = $iid;
			$v[$arr]['uid']           = $data['uid'];
			$v[$arr]['billNo']        = $data['billNo'];
			$v[$arr]['buId']          = $data['buId'];
			$v[$arr]['billType']      = $data['billType'];
			$v[$arr]['billDate']      = $data['billDate']; 
			$v[$arr]['transTypeName'] = $data['transTypeName'];
			$v[$arr]['transType']     = $data['transType'];
			$v[$arr]['accId']         = $data['accId'];
			$v[$arr]['payment']       = $row['amount']; 
			$v[$arr]['wayId']         = $row['categoryId'];
			$v[$arr]['remark']        = $row['description'];
			
		} 
		if (isset($v)) {  
			if ($data['id']>0) {  
				$this->mysql_model->delete('account_info',array('iid'=>$iid));
			}
			$this->mysql_model->insert('account_info',$v);
		} 
    }
	
	private function exp_account_info($iid,$data) {
	    foreach ($data['entries'] as $arr=>$row) {
			$v[$arr]['iid']           = $iid;
			$v[$arr]['uid']           = $data['uid'];
			$v[$arr]['billNo']        = $data['billNo'];
			$v[$arr]['buId']          = $data['buId'];
			$v[$arr]['billType']      = $data['billType'];
			$v[$arr]['billDate']      = $data['billDate']; 
			$v[$arr]['transTypeName'] = $data['transTypeName'];
			$v[$arr]['transType']     = $data['transType'];
			$v[$arr]['accId']         = $data['accId'];
			$v[$arr]['payment']       = -$row['amount']; 
			$v[$arr]['wayId']         = $row['categoryId'];
			$v[$arr]['remark']        = $row['description'];
		}  
		if (isset($v)) {  
			if ($data['id']>0) {  
				$this->mysql_model->delete('account_info',array('iid'=>$iid));
			}
			$this->mysql_model->insert('account_info',$v);
		} 
    }

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

