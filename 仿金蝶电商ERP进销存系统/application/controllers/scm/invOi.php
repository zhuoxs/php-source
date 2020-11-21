<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class InvOi extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
		$this->jxcsys = $this->session->userdata('jxcsys');
    }
	
	public function index() {
	    $type   = $this->input->get('type',TRUE);
	    $action = $this->input->get('action',TRUE);
		switch ($action) {
			case 'initOi':
				$info = array('in'=>15,'out'=>19,'cbtz'=>152);
				$this->common_model->checkpurview($info[$type]);
			    $this->load->view('scm/invOi/initOi-'.$type);	
				break;  
			case 'editOi':
				//$info = array('in'=>16,'out'=>20,'cbtz'=>153);
				$info = array('in'=>14,'out'=>18,'cbtz'=>151);
				$this->common_model->checkpurview($info[$type]);
			    $this->load->view('scm/invOi/initOi-'.$type);	
				break;  	
			case 'initOiList':
			    $info = array('in'=>14,'out'=>18,'cbtz'=>151);
				$this->common_model->checkpurview($info[$type]);
			    $this->load->view('scm/invOi/initOiList-'.$type);
				break; 
		}
	}
	

	public function listIn() {
	    $this->common_model->checkpurview(14);
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100);
		$matchCon  = str_enhtml($this->input->get_post('matchCon',TRUE));
		$beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
		$transTypeId  = intval($this->input->get_post('transTypeId',TRUE));
		$locationId   = intval($this->input->get_post('locationId',TRUE));
		$where = '(a.isDelete=0) and a.billType="OI"';
		$where .= $matchCon     ? ' and a.postData like "%'.$matchCon.'%"' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $transTypeId>0 ? ' and a.transType='.$transTypeId.'' : ''; 
		$where .= $locationId>0 ? ' and find_in_set('.$locationId.',inLocationId)' : ''; 
		$where .= $this->common_model->get_admin_purview();                          
		$list = $this->data_model->get_invoice($where.' order by id desc limit '.$rows*($page-1).','.$rows);  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['checkName']    = $row['checkName'];
			$v[$arr]['checked']      = intval($row['checked']);
			$v[$arr]['billDate']     = $row['billDate'];
			$v[$arr]['billType']     = $row['billType'];
			$v[$arr]['id']           = intval($row['id']);
		    $v[$arr]['amount']       = (float)abs($row['totalAmount']);
			$v[$arr]['transType']    = intval($row['transType']);;
			$v[$arr]['contactName']  = $row['contactName'];
			$v[$arr]['description']  = $row['description'];
			$v[$arr]['billNo']       = $row['billNo'];
			$v[$arr]['totalAmount']  = (float)abs($row['totalAmount']);
			$v[$arr]['userName']     = $row['userName'];
			$v[$arr]['transTypeName']= $row['transTypeName']; 
		}
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['page']      = $page;
		$json['data']['records']   = $this->data_model->get_invoice($where,3);                           
		$json['data']['total']     = ceil($json['data']['records']/$rows);  
		$json['data']['rows']      = isset($v) ? $v : array();
		die(json_encode($json));
	}
	

	public function exportInvOi() { 
		$name = 'qtrk_record_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('导出其他入库单:'.$name);
		$matchCon  = str_enhtml($this->input->get_post('matchCon',TRUE));
		$beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
		$transTypeId  = intval($this->input->get_post('transTypeId',TRUE));
		$locationId   = intval($this->input->get_post('locationId',TRUE));
		$where = 'a.isDelete=0 and a.billType="OI"';
		$where .= $matchCon     ? ' and a.postData like "%'.$matchCon.'%"' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $transTypeId>0 ? ' and a.transType='.$transTypeId.'' : ''; 
		$where .= $locationId>0 ? ' and find_in_set('.$locationId.',inLocationId)' : ''; 
		$where .= $this->common_model->get_admin_purview();
		$data['list'] = $this->data_model->get_invoice($where.' order by id desc');  
		$this->load->view('scm/invOi/exportInvOi',$data);
	}


	public function queryTransType(){
	    $type   = $this->input->get_post('type',TRUE) == 'out' ? 'out' : 'in';
		$list = $this->mysql_model->get_results('invoice_type',array('type'=>$type),'id desc');  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['acctId']       = 0;
			$v[$arr]['calCost']      = 1;
			$v[$arr]['commission']   = false;
			$v[$arr]['direction']    = 1;
		    $v[$arr]['free']         = false;
			$v[$arr]['id']           = intval($row['number']);
			$v[$arr]['inOut']        = 1;
			$v[$arr]['name']         = $row['name'];
			$v[$arr]['process']      = false;
			$v[$arr]['sysDefault']   = true;
			$v[$arr]['sysDelete']    = false;
			$v[$arr]['tableName']    = 't_scm_inventryoi';
			$v[$arr]['typeId']       = 1507;
			$v[$arr]['voucher']      = true;
		}
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['totalsize']   = count($list);    
		$json['data']['items']       = isset($v) ? $v : array();
		die(json_encode($json));
    }
	
	

	public function add(){
	    $this->common_model->checkpurview(15);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->Oi_validform((array)json_decode($data, true));
			$info = elements(array(
				'billNo','billType','transType','transTypeName','buId','inLocationId',
				'billDate','description','totalQty','totalAmount','postData','createTime',
				'uid','userName','modifyTime'),$data,NULL);
			$this->db->trans_begin();
			$iid = $this->mysql_model->insert('invoice',$info);
			$this->Oi_invoice_info($iid,$data);
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误回滚'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('新增其他入库 单据编号：'.$data['billNo']);
				str_alert(200,'success',array('id'=>intval($iid))); 
			}
		}
		str_alert(-1,'提交的是空数据'); 
    }
	

	public function addnew(){
	    $this->add();
    }
	
	 

	public function updateOi(){
	    $this->common_model->checkpurview(16);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->Oi_validform((array)json_decode($data, true));
			$info = elements(array(
				'transType','transTypeName','buId','postData','inLocationId','uid','userName',
				'billDate','description','totalQty','totalAmount','modifyTime'),$data,NULL);
			$this->db->trans_begin();
			$this->mysql_model->update('invoice',$info,array('id'=>$data['id']));
			$this->Oi_invoice_info($data['id'],$data);
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误回滚'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('修改其他入库 单据编号：'.$data['billNo']);
				str_alert(200,'success',array('id'=>$data['id'])); 
			}
		}
		str_alert(-1,'提交的是空数据'); 
    }
	
	

	public function updateIn() {
	    $this->common_model->checkpurview(14);
	    $id   = intval($this->input->get_post('id',TRUE)); 
		$data = $this->data_model->get_invoice('a.isDelete=0 and a.id='.$id.' and a.billType="OI"',1);
		if (count($data)>0) {
			$list = $this->data_model->get_invoice_info('a.isDelete=0 and a.iid='.$id.'  order by a.id desc');   
			foreach ($list as $arr=>$row) {
				$v[$arr]['invSpec']      = $row['invSpec'];
				$v[$arr]['goods']        = $row['invNumber'].' '.$row['invName'].' '.$row['invSpec'];
				$v[$arr]['invName']      = $row['invName'];
				$v[$arr]['qty']          = (float)abs($row['qty']);
				$v[$arr]['amount']       = (float)abs($row['amount']);
				$v[$arr]['price']        = (float)abs($row['price']);
				$v[$arr]['mainUnit']     = $row['mainUnit'];
				$v[$arr]['description']  = $row['description'];
				$v[$arr]['invId']        = intval($row['invId']);
				$v[$arr]['invNumber']    = $row['invNumber'];
				$v[$arr]['locationId']   = intval($row['locationId']);
				$v[$arr]['locationName'] = $row['locationName'];
				$v[$arr]['unitId']       = intval($row['unitId']);
				$v[$arr]['skuId']        = intval($row['skuId']);
				$v[$arr]['skuName']      = '';
			}
			$json['status']              = 200;
			$json['msg']                 = 'success'; 
			$json['data']['id']          = intval($data['id']);
			$json['data']['buId']        = intval($data['buId']);
			$json['data']['contactName'] = $data['contactName'];
			$json['data']['date']        = $data['billDate'];
			$json['data']['billNo']      = $data['billNo'];
			$json['data']['billType']    = $data['billType'];
			$json['data']['modifyTime']  = $data['modifyTime'];
			$json['data']['createTime']  = $data['createTime']; 
			$json['data']['transType']   = intval($data['transType']);
			$json['data']['totalQty']    = (float)$data['totalQty'];
			$json['data']['totalAmount'] = (float)$data['totalAmount'];
			$json['data']['userName']    = $data['userName'];
			$json['data']['description'] = $data['description']; 
			$json['data']['amount']      = (float)abs($data['totalAmount']);
			$json['data']['checked']     = intval($data['checked']); 
			$json['data']['status']      = intval($data['checked'])==1 ? 'view' : 'edit'; 
			$json['data']['entries']     = isset($v) ? $v : array();
			die(json_encode($json));
		}
		str_alert(-1,'提交的是空数据'); 
    }
	
	

    public function toOiPdf() {
	    $this->common_model->checkpurview(9);
	    $id   = intval($this->input->get('id',TRUE));
		$data = $this->data_model->get_invoice('a.isDelete=0 and a.id='.$id.' and a.billType="OI"',1);  
		if (count($data)>0) { 
			$data['num']    = 53;
			$data['system'] = $this->common_model->get_option('system'); 
			$postData = unserialize($data['postData']);
		    foreach ($postData['entries'] as $arr=>$row) {
			    $v[$arr]['i']               = $arr + 1;
				$v[$arr]['invNumber']       = $row['invNumber'];
				$v[$arr]['invSpec']         = $row['invSpec'];
				$v[$arr]['invName']         = $row['invName'];
				$v[$arr]['goods']           = $row['invNumber'].' '.$row['invName'].' '.$row['invSpec'];
				$v[$arr]['qty']             = (float)abs($row['qty']);
				$v[$arr]['price']           = $row['price'];
				$v[$arr]['mainUnit']        = $row['mainUnit'];
				$v[$arr]['amount']          = $row['amount'];
				$v[$arr]['locationName']    = $row['locationName'];
			}  
			$data['countpage']  = ceil(count($postData['entries'])/$data['num']); ;   
			$data['list']       = isset($v) ? $v : array();  
		    ob_start();
			$this->load->view('scm/invOi/toOiPdf',$data);
			$content = ob_get_clean();
			require_once('./application/libraries/html2pdf/html2pdf.php');
			try {
				$html2pdf = new HTML2PDF('P', 'A4', 'en');
				$html2pdf->setDefaultFont('javiergb');
				$html2pdf->pdf->SetDisplayMode('fullpage');
				$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
				$html2pdf->Output('toOiPdf_'.date('ymdHis').'.pdf');
			}catch(HTML2PDF_exception $e) {
				echo $e;
				exit;
			}    
		}  
		str_alert(-1,'单据不存在、或者已删除');  	  
	}
	

	 
	

    public function deletein() {
	    $this->common_model->checkpurview(17);
	    $id   = intval($this->input->get('id',TRUE));
		$data = $this->mysql_model->get_rows('invoice',array('id'=>$id,'billType'=>'OI'));  
		if (count($data)>0) {
		    $this->db->trans_begin();
			$this->mysql_model->update('invoice',array('isDelete'=>1),array('id'=>$id));   
			$this->mysql_model->update('invoice_info',array('isDelete'=>1),array('iid'=>$id));     
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'删除失败'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('删除单据编号：'.$data['billNo']);
				str_alert(200,'success'); 	 
			}
		}
		str_alert(-1,'参数错误'); 
	}
	


	public function listout() {
	    $this->common_model->checkpurview(18);
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100);
		$matchCon     = str_enhtml($this->input->get_post('matchCon',TRUE));
		$beginDate    = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate      = str_enhtml($this->input->get_post('endDate',TRUE));
		$locationId   = intval($this->input->get_post('locationId',TRUE));
		$transTypeId  = intval($this->input->get_post('transTypeId',TRUE));
		$where = 'a.isDelete=0 and a.billType="OO"';
		$where .= $matchCon  ? ' and a.postData like "%'.$matchCon.'%"' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $transTypeId>0 ? ' and a.transType='.$transTypeId.'' : ''; 
		$where .= $locationId>0 ? ' and find_in_set('.$locationId.',outLocationId)' : ''; 
		$where .= $this->common_model->get_admin_purview();               
		$list = $this->data_model->get_invoice($where.' order by id desc limit '.$rows*($page-1).','.$rows);  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['checkName']    = $row['checkName'];
			$v[$arr]['checked']      = intval($row['checked']);
			$v[$arr]['billDate']     = $row['billDate'];
			$v[$arr]['billType']     = $row['billType'];
			$v[$arr]['id']           = intval($row['id']);
		    $v[$arr]['amount']       = (float)abs($row['totalAmount']);
			$v[$arr]['transType']    = intval($row['transType']);;
			$v[$arr]['contactName']  = $row['contactName'];
			$v[$arr]['description']  = $row['description'];
			$v[$arr]['billNo']       = $row['billNo'];
			$v[$arr]['totalAmount']  = (float)abs($row['totalAmount']);
			$v[$arr]['userName']     = $row['userName'];
			$v[$arr]['transTypeName']= $row['transTypeName'];
		}
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['page']        = $page;
		$json['data']['records']     = $this->data_model->get_invoice($where,3);                           
		$json['data']['total']       = ceil($json['data']['records']/$rows);               
		$json['data']['rows']        = isset($v) ? $v : array();
		die(json_encode($json));
	} 
	

	public function exportInvOo() { 
	    $this->common_model->checkpurview(105);
		$name = 'qtck_record_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('导出其他出库单:'.$name);
		$matchCon  = str_enhtml($this->input->get_post('matchCon',TRUE));
		$beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
		$transTypeId  = intval($this->input->get_post('transTypeId',TRUE));
		$locationId   = intval($this->input->get_post('locationId',TRUE));
		$where = 'a.isDelete=0 and a.billType="OO"';
		$where .= $matchCon     ? ' and a.postData like "%'.$matchCon.'%"' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $transTypeId>0 ? ' and a.transType='.$transTypeId.'' : ''; 
		$where .= $locationId>0 ? ' and find_in_set('.$locationId.',outLocationId)' : '';
		$where .= $this->common_model->get_admin_purview();
		$data['list'] = $this->data_model->get_invoice($where.' order by id desc');  
		$this->load->view('scm/invOi/exportInvOo',$data);
	}
	

	public function addOo(){
	    $this->common_model->checkpurview(19);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->Oo_validform((array)json_decode($data, true));
			$info = elements(array(
				'billNo','billType','transType','transTypeName','buId','createTime',
				'billDate','description','totalQty','totalAmount','outLocationId',
				'uid','userName','modifyTime','postData'),$data);
			$this->db->trans_begin();
			$iid = $this->mysql_model->insert('invoice',$info);
			$this->Oo_invoice_info($iid,$data);
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误回滚'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('新增其他出库 单据编号：'.$data['billNo']);
				$this->get_updateOut($iid);
			}
		}
		str_alert(-1,'提交的是空数据'); 
    }
	

	public function addnewOo(){
	    $this->addOo();
    }
	
	 

	public function updateOo(){
	    $this->common_model->checkpurview(20);
	    $postData = $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->Oo_validform((array)json_decode($data, true));
			$info = elements(array(
				'transType','transTypeName','buId','postData','outLocationId','uid','userName',
				'billDate','description','totalQty','totalAmount','modifyTime'),$data);
			$this->db->trans_begin();
			$this->mysql_model->update('invoice',$info,array('id'=>$data['id']));
			$this->Oo_invoice_info($data['id'],$data);
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误回滚'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('修改单据：'.$data['billNo']);
				$this->get_updateOut($data['id']);
			}
		}
		str_alert(-1,'提交数据不为空'); 
    }
	
	

	public function updateOut() {
	    $this->common_model->checkpurview(18);
	    $id   = intval($this->input->get_post('id',TRUE));
		$this->get_updateOut($id);
    }
	
	

	private function get_updateOut($id) {
	    $data = $this->data_model->get_invoice('a.isDelete=0 and a.id='.$id.' and a.billType="OO"',1);
		if (count($data)>0) {
			$list = $this->data_model->get_invoice_info('a.isDelete=0 and a.iid='.$id.'  order by a.id desc');   
			foreach ($list as $arr=>$row) {
			    $v[$arr]['invSpec']      = $row['invSpec'];
				$v[$arr]['goods']        = $row['invNumber'].' '.$row['invName'].' '.$row['invSpec'];
				$v[$arr]['invName']      = $row['invName'];
				$v[$arr]['qty']          = (float)abs($row['qty']);
				$v[$arr]['amount']       = (float)abs($row['amount']);
				$v[$arr]['price']        = (float)$row['price'];
				$v[$arr]['mainUnit']     = $row['mainUnit'];
				$v[$arr]['description']  = $row['description'];
				$v[$arr]['invId']        = intval($row['invId']);
				$v[$arr]['invNumber']    = $row['invNumber'];
				$v[$arr]['locationId']   = intval($row['locationId']);
				$v[$arr]['locationName'] = $row['locationName'];
				$v[$arr]['unitId']       = intval($row['unitId']);
				$v[$arr]['skuId']        = intval($row['skuId']);
				$v[$arr]['skuName']      = '';
			}
			$json['status']              = 200;
			$json['msg']                 = 'success'; 
			$json['data']['id']          = intval($data['id']);
			$json['data']['buId']        = intval($data['buId']);
			$json['data']['contactName'] = $data['contactName'];
			$json['data']['date']        = $data['billDate'];
			$json['data']['billNo']      = $data['billNo'];
			$json['data']['billType']    = $data['billType'];
			$json['data']['modifyTime']  = $data['modifyTime'];
			$json['data']['createTime']  = $data['createTime']; 
			$json['data']['transType']   = intval($data['transType']);
			$json['data']['totalQty']    = (float)$data['totalQty'];
			$json['data']['totalAmount'] = (float)abs($data['totalAmount']);
			$json['data']['userName']    = $data['userName'];
			$json['data']['description'] = $data['description']; 
			$json['data']['amount']      = (float)abs($data['totalAmount']);
			$json['data']['checked']     = intval($data['checked']); 
			$json['data']['status']      = intval($data['checked'])==1 ? 'view' : 'edit'; 
			$json['data']['entries']     = isset($v) ? $v : array();
			die(json_encode($json));
		}
		str_alert(-1,'单据不存在'); 
	} 
 
	
    public function toOoPdf() {
	    $this->common_model->checkpurview(9);
	    $id   = intval($this->input->get('id',TRUE));
		$data = $this->data_model->get_invoice('a.isDelete=0 and a.id='.$id.' and a.billType="OO"',1);  
		if (count($data)>0) { 
			$data['num']    = 53;
			$data['system'] = $this->common_model->get_option('system'); 
			$postData = unserialize($data['postData']);
		    foreach ($postData['entries'] as $arr=>$row) {
			    $v[$arr]['i']               = $arr + 1;
				$v[$arr]['invNumber']       = $row['invNumber'];
				$v[$arr]['invSpec']         = $row['invSpec'];
				$v[$arr]['invName']         = $row['invName'];
				$v[$arr]['goods']           = $row['invNumber'].' '.$row['invName'].' '.$row['invSpec'];
				$v[$arr]['qty']             = (float)abs($row['qty']);
				$v[$arr]['price']           = $row['price'];
				$v[$arr]['mainUnit']        = $row['mainUnit'];
				$v[$arr]['amount']          = $row['amount'];
				$v[$arr]['locationName']    = $row['locationName'];
			}  
			$data['countpage']  = ceil(count($postData['entries'])/$data['num']); ;   
			$data['list']       = isset($v) ? $v : array();  
		    ob_start();
			$this->load->view('scm/invOi/toOoPdf',$data);
			$content = ob_get_clean();
			require_once('./application/libraries/html2pdf/html2pdf.php');
			try {
				$html2pdf = new HTML2PDF('P', 'A4', 'en');
				$html2pdf->setDefaultFont('javiergb');
				$html2pdf->pdf->SetDisplayMode('fullpage');
				$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
				$html2pdf->Output('toOoPdf_'.date('ymdHis').'.pdf');
			}catch(HTML2PDF_exception $e) {
				echo $e;
				exit;
			}  	  
		} 
		str_alert(-1,'单据不存在、或者已删除'); 
	}
	

    public function deleteOut() {
	    $this->common_model->checkpurview(21);
	    $id   = intval($this->input->get('id',TRUE));
		$data = $this->mysql_model->get_rows('invoice',array('id'=>$id,'billType'=>'OO'));  
		if (count($data)>0) {
		    $this->db->trans_begin();
			$this->mysql_model->update('invoice',array('isDelete'=>1),array('id'=>$id));   
			$this->mysql_model->update('invoice_info',array('isDelete'=>1),array('iid'=>$id)); 
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
	

	public function listCbtz() {
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100);
		$matchCon     = str_enhtml($this->input->get_post('matchCon',TRUE));
		$beginDate    = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate      = str_enhtml($this->input->get_post('endDate',TRUE));
		$locationId   = intval($this->input->get_post('locationId',TRUE));
		$where = 'a.isDelete=0 and transType=150807';
		$where .= $matchCon     ? ' and a.postData like "%'.$matchCon.'%"' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $locationId>0 ? ' and find_in_set('.$locationId.',locationId)' : ''; 
		$where .= $this->common_model->get_admin_purview();
		$offset = $rows * ($page-1);                        
		$list = $this->data_model->get_invoice($where.' order by id desc limit '.$offset.','.$rows);  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['checkName']    = $row['checkName'];
			$v[$arr]['checked']      = intval($row['checked']);
			$v[$arr]['billDate']     = $row['billDate'];
			$v[$arr]['billType']     = $row['billType'];
			$v[$arr]['id']           = intval($row['id']);
		    $v[$arr]['amount']       = (float)$row['totalAmount'];
			$v[$arr]['transType']    = intval($row['transType']); 
			$v[$arr]['contactName']  = $row['contactName'];
			$v[$arr]['description']  = $row['description'];
			$v[$arr]['billNo']       = $row['billNo'];
			$v[$arr]['totalAmount']  = (float)$row['totalAmount'];
			$v[$arr]['userName']     = $row['userName'];
			$v[$arr]['transTypeName']= $row['transTypeName'];
		}
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['page']        = $page;
		$json['data']['records']     = $this->data_model->get_invoice($where,3);  
		$json['data']['total']       = ceil($json['data']['records']/$rows);      
		$json['data']['rows']        = isset($v) ? $v : array();
		die(json_encode($json));
	}
	
	
	public function exportInvCadj() {
	    $name = 'adjustment_record_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('导出成本调整单:'.$name);
		$matchCon  = str_enhtml($this->input->get_post('matchCon',TRUE));
		$beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
		$locationId   = intval($this->input->get_post('locationId',TRUE));
		$where = 'a.isDelete=0 and transType=150807';
		$where .= $matchCon     ? ' and a.postData like "%'.$matchCon.'%"' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $locationId>0 ? ' and find_in_set('.$locationId.',locationId)' : ''; 
		$where .= $this->common_model->get_admin_purview();
		$data['list'] = $this->data_model->get_invoice($where.' order by id desc');  
		$this->load->view('scm/invOi/exportInvCadj',$data);  
	} 
	
	
	public function addCADJ() {
	    $this->common_model->checkpurview(19);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->cadj_validform((array)json_decode($data, true));
			$info = elements(array(
				'transType','transTypeName','postData','locationId','createTime',
				'billDate','description','totalAmount','billNo','billType',
				'uid','userName','modifyTime'),$data);
			$this->db->trans_begin();
			$iid = $this->mysql_model->insert('invoice',$info);
			$this->cadj_invoice_info($iid,$data);
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误回滚'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('新增成本调整 单据编号：'.$data['billNo']);
				str_alert(200,'success',$data); 
			 }
		}
		str_alert(-1,'提交的是空数据'); 
	} 
	
	public function addNewCADJ() {
	     $this->addCADJ();
	} 
	
	
	public function updateCbtz() {
	    $this->common_model->checkpurview(20);
	    $id   = intval($this->input->get_post('id',TRUE));
		$data = $this->data_model->get_invoice('a.isDelete=0 and a.id='.$id.' and a.transType=150807',1);
		if (count($data)>0) {
			$list = $this->data_model->get_invoice_info('a.isDelete=0 and a.iid='.$id.'  order by a.id desc');   
			foreach ($list as $arr=>$row) {
			    $v[$arr]['invSpec']      = $row['invSpec'];
				$v[$arr]['goods']        = $row['invNumber'].' '.$row['invName'].' '.$row['invSpec'];
				$v[$arr]['invName']      = $row['invName'];
				$v[$arr]['amount']       = (float)$row['amount'];
				$v[$arr]['mainUnit']     = $row['mainUnit'];
				$v[$arr]['description']  = $row['description'];
				$v[$arr]['invId']        = intval($row['invId']);
				$v[$arr]['invNumber']    = $row['invNumber'];
				$v[$arr]['locationId']   = intval($row['locationId']);
				$v[$arr]['locationName'] = $row['locationName'];
				$v[$arr]['unitId']       = intval($row['unitId']);
				$v[$arr]['skuId']        = intval($row['skuId']);
				$v[$arr]['skuName']      = '';
			}
			$json['status']              = 200;
			$json['msg']                 = 'success'; 
			$json['data']['id']          = intval($data['id']);
			$json['data']['date']        = $data['billDate'];
			$json['data']['billNo']      = $data['billNo'];
			$json['data']['billType']    = $data['billType'];
			$json['data']['modifyTime']  = $data['modifyTime'];
			$json['data']['createTime']  = $data['createTime']; 
			$json['data']['transType']   = intval($data['transType']);
			$json['data']['totalQty']    = (float)$data['totalQty'];
			$json['data']['totalAmount'] = (float)$data['totalAmount'];
			$json['data']['userName']    = $data['userName'];
			$json['data']['description'] = $data['description']; 
			$json['data']['amount']      = (float)$data['totalAmount'];
			$json['data']['checked']     = intval($data['checked']); 
			$json['data']['status']      = intval($data['checked'])==1 ? 'view' : 'edit'; 
			$json['data']['entries']     = isset($v) ? $v :'';
			die(json_encode($json));
		}
		str_alert(-1,'单据不存在'); 
	} 
 
 
	public function updateCADJ() {
	    $this->common_model->checkpurview(20);
	    $postData = $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->cadj_validform((array)json_decode($data, true));
			$info = elements(array(
				'transType','transTypeName','postData','locationId','uid','userName',
				'billDate','description','totalAmount','billNo','billType','modifyTime'),$data);
			$this->db->trans_begin();
			$this->mysql_model->update('invoice',$info,array('id'=>$data['id']));
			$this->cadj_invoice_info($data['id'],$data);
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误回滚'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('修改成本调整 单据编号：'.$data['billNo']);
				die('{"status":200,"msg":"success","data":'.$postData.'}');
			}
		}
		str_alert(-1,'提交数据不为空'); 
	} 
	

    public function toCBTZPdf() {
	    $this->common_model->checkpurview(9);
	    $id   = intval($this->input->get('id',TRUE));
		$data = $this->data_model->get_invoice('a.isDelete=0 and a.id='.$id.' and a.transType=150807',1);  
		if (count($data)>0) { 
			$data['num']    = 53;
			$data['system'] = $this->common_model->get_option('system'); 
			$list = $this->data_model->get_invoice_info('a.isDelete=0 and a.iid='.$id.' order by a.id');  
			$data['countpage']  = ceil(count($list)/$data['num']);   //共多少页
			foreach($list as $arr=>$row) {
			    $data['list'][] = array(
				'i'=>$arr + 1,
				'goods'=>$row['invNumber'].' '.$row['invName'],
				'invSpec'=>$row['invSpec'],
				'qty'=>abs($row['qty']),
				'price'=>$row['price'],
				'amount'=>$row['amount'],
				'locationName'=>$row['locationName']
				);  
			}
		    ob_start();
			$this->load->view('scm/invOi/toCBTZPdf',$data);
			$content = ob_get_clean();
			require_once('./application/libraries/html2pdf/html2pdf.php');
			try {
				$html2pdf = new HTML2PDF('L', 'A4', 'en');
				$html2pdf->setDefaultFont('javiergb');
				$html2pdf->pdf->SetDisplayMode('fullpage');
				$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
				$html2pdf->Output('exemple_cn.pdf');
			}catch(HTML2PDF_exception $e) {
				echo $e;
				exit;
			}   	  
		} 
		str_alert(-1,'单据不存在、或者已删除');   
	}

	

    public function deleteCbtz() {
	    $this->common_model->checkpurview(21);
	    $id   = intval($this->input->get('id',TRUE));
		$data = $this->mysql_model->get_rows('invoice',array('id'=>$id,'transType'=>150807));  
		if (count($data)>0) {
		    $this->db->trans_begin();
			$this->mysql_model->update('invoice',array('isDelete'=>1),array('id'=>$id));   
			$this->mysql_model->update('invoice_info',array('isDelete'=>1),array('iid'=>$id)); 
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
	
 

	public function queryToPD() {
	    $this->common_model->checkpurview(11);
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100);
		$showZero   = intval($this->input->get_post('showZero',TRUE));
		$categoryId = intval($this->input->get_post('categoryId',TRUE));
		$locationId = intval($this->input->get_post('locationId',TRUE));
		$goods = str_enhtml($this->input->get_post('goods',TRUE));
		$where = '(a.isDelete=0)';
		$where .= strlen($goods)>0 ? ' and (b.name like "%'.$goods.'%")' : '';
		$where .= $locationId>0 ? ' and a.locationId='.$locationId.'' : ''; 
		if ($categoryId > 0) {
		    $cid = array_column($this->mysql_model->get_results('category','(1=1) and find_in_set('.$categoryId.',path)'),'id'); 
			if (count($cid)>0) {
			    $cid = join(',',$cid);
			    $where .= ' and b.categoryId in('.$cid.')';
			} 
		}
		$where .= $this->common_model->get_location_purview();
		$having = $showZero == 1 ? ' HAVING qty=0' : '';   
		$list = $this->data_model->get_inventory($where.' GROUP BY a.invId,a.locationId '.$having.' limit '.$rows*($page-1).','.$rows);  
		foreach ($list as $arr=>$row) {
		    $v[$arr]['assistName']    = $row['categoryName'];
			$v[$arr]['invSpec']       = $row['invSpec'];
			$v[$arr]['locationId']    = $locationId > 0 ? intval($row['locationId']) : 0;
			$v[$arr]['skuName']       = '';
		    $v[$arr]['qty']           = (float)$row['qty'];
			$v[$arr]['locationName']  = $row['locationName'];
			$v[$arr]['assistId']      = 0;
			$v[$arr]['invCost']       = 0;
			$v[$arr]['unitName']      = $row['unitName']; 
			$v[$arr]['skuId']         = 0;
			$v[$arr]['invId']         = intval($row['invId']);
			$v[$arr]['invNumber']     = $row['invNumber']; 
			$v[$arr]['invName']       = $row['invName']; 	 
		}
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['page']         = $page;
		$json['data']['records']      = $this->data_model->get_inventory($where.' GROUP BY a.invId,a.locationId'.$having,3);    
		$json['data']['total']        = ceil($json['data']['records']/$rows);                           
		$json['data']['rows']         = isset($v) ? $v : array();
		die(json_encode($json));
	}
	

	public function exportToPD() {
	    $this->common_model->checkpurview(13);
		$name = 'pdReport_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('导出盘点单据:'.$name);
		$showZero   = intval($this->input->get_post('showZero',TRUE));
		$categoryId = intval($this->input->get_post('categoryId',TRUE));
		$data['locationId'] = $locationId = intval($this->input->get_post('locationId',TRUE));
		$goods = str_enhtml($this->input->get_post('goods',TRUE));
		$where = '(a.isDelete=0)';
		$where .= strlen($goods)>0 ? ' and (b.name like "%'.$goods.'%")' : '';
		$where .= $locationId>0 ? ' and a.locationId='.$locationId.'' : ''; 
		if ($categoryId > 0) {
		    $cid = array_column($this->mysql_model->get_results('category','(1=1) and find_in_set('.$categoryId.',path)'),'id'); 
			if (count($cid)>0) {
			    $cid = join(',',$cid);
			    $where .= ' and b.categoryId in('.$cid.')';
			} 
		}
		$where .= $this->common_model->get_location_purview();
		$having = $showZero == 1 ? ' HAVING qty=0' : '';
		$data['list'] = $this->data_model->get_inventory($where.' GROUP BY a.invId,a.locationId'.$having); 
		$this->load->view('scm/invOi/exportToPD',$data); 
	}
	

	public function generatorPD() {
	    $this->common_model->checkpurview(12);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
		     $data = (array)json_decode($data, true); 
			 if (is_array($data['entries'])) {
			     foreach ($data['entries'] as $arr=>$row) {
				     intval($row['locationId']) < 1 && str_alert(-1,'必须选择某一仓库进行盘点'); 
					 if (intval($row['invId'])>0) {
						 if (intval($row['change'])>0) {  //盘盈
							 $v[$arr]['goods']         = $row['invNumber'].' '.$row['invName'].' '.$row['invSpec'];
							 $v[$arr]['description']   = '';
							 $v[$arr]['invId']         = intval($row['invId']);
							 $v[$arr]['invNumber']     = $row['invNumber'];
							 $v[$arr]['invName']       = $row['invName'];
							 $v[$arr]['invSpec']       = $row['invSpec'];
							 $v[$arr]['skuId']         = intval($row['skuId']);
							 $v[$arr]['skuName']       = $row['skuName'];
							 $v[$arr]['unitId']        = intval($row['unitId']);
							 $v[$arr]['amount']        = 0;
							 $v[$arr]['price']         = 0;
							 $v[$arr]['qty']           = (float)abs($row['change']);
							 $v[$arr]['mainUnit']      = $row['mainUnit'];
							 $v[$arr]['locationId']    = intval($row['locationId']);
							 $v[$arr]['locationName']  = $row['locationName']; 
						 } elseif(intval($row['change'])<0) {	 //盘亏 
							 $s[$arr]['goods']         = $row['invNumber'].' '.$row['invName'].' '.$row['invSpec'];
							 $s[$arr]['description']   = '';
							 $s[$arr]['invId']         = intval($row['invId']);
							 $s[$arr]['invNumber']     = $row['invNumber'];
							 $s[$arr]['invName']       = $row['invName'];
							 $s[$arr]['invSpec']       = $row['invSpec'];
							 $s[$arr]['skuId']         = intval($row['skuId']);
							 $s[$arr]['skuName']       = $row['skuName'];
							 $s[$arr]['unitId']        = intval($row['unitId']);
							 $s[$arr]['amount']        = 0;
							 $s[$arr]['price']         = 0;
							 $s[$arr]['qty']           = (float)abs($row['change']);
							 $s[$arr]['mainUnit']      = $row['mainUnit'];
							 $s[$arr]['locationId']    = intval($row['locationId']);
							 $s[$arr]['locationName']  = $row['locationName'];
						 }
					 }
				}  
				$json['status'] = 200;
				$json['msg']    = 'success'; 
				$json['data']['items'][0]['id']          = -1;
				$json['data']['items'][0]['billType']    = 'OI';
				$json['data']['items'][0]['transType']   = 150701;
				$json['data']['items'][0]['description'] = '';
				$json['data']['items'][0]['buId']        = 0;
				$json['data']['items'][0]['billNo']      = str_no('QTRK');
				$json['data']['items'][0]['totalAmount'] = 0;
				$json['data']['items'][0]['userName']    = '';
				$json['data']['items'][0]['totalQty']    = 1;
				$json['data']['items'][0]['date']        = date('Y-m-d');
				$json['data']['items'][0]['entries']     = isset($v) ? array_merge(array() , $v) :'';
				$json['data']['items'][1]['id']          = -1;
				$json['data']['items'][1]['billType']    = 'OO';
				$json['data']['items'][1]['transType']   = 150801;
				$json['data']['items'][1]['description'] = '';
				$json['data']['items'][1]['buId']        = 0;
				$json['data']['items'][1]['billNo']      = str_no('QTCK');
				$json['data']['items'][1]['totalAmount'] = 0;
				$json['data']['items'][1]['userName']    = '';
				$json['data']['items'][1]['totalQty']    = 1;
				$json['data']['items'][1]['date']        = date('Y-m-d');
				$json['data']['items'][1]['entries']     = isset($s) ? array_merge(array() , $s) :''; 
				$json['data']['totalsize']                   = 2;
		        die(json_encode($json));
			}
		}
		str_alert(-1,'提交的是空数据'); 
    }
 
	

	private function Oi_validform($data) {
	    $data['id']              = isset($data['id']) ? intval($data['id']) : 0;
		$data['buId']            = intval($data['buId']);
		$data['transType']       = intval($data['transTypeId']);
		$data['totalQty']        = (float)$data['totalQty'];
		$data['billType']        = 'OI';
		$data['billDate']        = $data['date'];   
		$data['transTypeName']   = $data['transTypeName'];
	    $data['uid']             = $this->jxcsys['uid'];
		$data['userName']        = $this->jxcsys['name'];
		$data['modifyTime']      = date('Y-m-d H:i:s');
		$data['createTime']      = $data['modifyTime'];
		$data['accounts']        = isset($data['accounts']) ? $data['accounts'] : array();
		$data['entries']         = isset($data['entries']) ? $data['entries'] : array();
		
		count($data['entries']) < 1 && str_alert(-1,'提交的是空数据'); 
		
		
		if ($data['id']>0) {
		    $invoice = $this->mysql_model->get_rows('invoice',array('id'=>$data['id'],'billType'=>'OI','isDelete'=>0));  
			count($invoice)<1 && str_alert(-1,'单据不存在、或者已删除');
			$data['checked'] = $invoice['checked'];	
			$data['billNo']  = $invoice['billNo'];	
		} else {
		    $data['billNo']  = str_no('QTRK');    
		}


		$system    = $this->common_model->get_option('system'); 
		if ($system['requiredCheckStore']==1) {  
		    $inventory = $this->data_model->get_invoice_info_inventory();
		}
		$storage   = array_column($this->mysql_model->get_results('storage','(disable=0)'),'id');  
		foreach ($data['entries'] as $arr=>$row) {
		    intval($row['invId']) < 1 && str_alert(-1,'请选择商品');    
			(float)$row['qty'] < 0  && str_alert(-1,'商品数量要为数字，请输入有效数字！'); 
			(float)$row['price'] < 0  && str_alert(-1,'商品销售单价要为数字，请输入有效数字！'); 
			intval($row['locationId']) < 1 && str_alert(-1,'请选择相应的仓库！'); 
			!in_array($row['locationId'],$storage) && str_alert(-1,$row['locationName'].'不存在或不可用！');

		
			if ($system['requiredCheckStore']==1 && $data['id']<1) {  
				if (intval($data['transType'])==150806) {                        //其他出库才验证 
					if (isset($inventory[$row['invId']][$row['locationId']])) {
						$inventory[$row['invId']][$row['locationId']] < (float)$row['qty'] && str_alert(-1,$row['locationName'].$row['invName'].'商品库存不足！'); 
					} else {
						str_alert(-1,$row['invName'].'库存不足！');
					}
				}
			}
			if ($data['transType']==150706) {  	
				$inLocationId[]  = $row['locationId'];
			} else {
				$outLocationId[] = $row['locationId'];
			}
		}
		if ($data['transType']==150706) {  	
			$data['inLocationId']  = join(',',array_unique($inLocationId));
		} else {
			$data['outLocationId'] = join(',',array_unique($outLocationId));
		}
		$data['postData'] = serialize($data);
		return $data;  
	}  
	
	

	private function Oi_invoice_info($iid,$data) {
	    foreach ($data['entries'] as $arr=>$row) {
			$v[$arr]['iid']           = $iid;
			$v[$arr]['billNo']        = $data['billNo'];
			$v[$arr]['buId']          = $data['buId'];
			$v[$arr]['transType']     = $data['transType'];
			$v[$arr]['transTypeName'] = $data['transTypeName'];
			$v[$arr]['billDate']      = $data['billDate']; 
			$v[$arr]['billType']      = $data['billType'];
			$v[$arr]['invId']         = intval($row['invId']);
			$v[$arr]['skuId']         = intval($row['skuId']);
			$v[$arr]['unitId']        = intval($row['unitId']);
			$v[$arr]['locationId']    = intval($row['locationId']);
			$v[$arr]['qty']           = abs($row['qty']); 
			$v[$arr]['amount']        = abs($row['amount']); 
			$v[$arr]['price']         = abs($row['price']);  
			$v[$arr]['description']   = $row['description'];   
		} 
		if (isset($v)) {  
		    if ($data['id']>0) {      
				$this->mysql_model->delete('invoice_info',array('iid'=>$iid)); 
			}
			$this->mysql_model->insert('invoice_info',$v);
		}
	}
	

	private function Oo_validform($data) {
	    $data['id']              = isset($data['id']) ? intval($data['id']) : 0;
		$data['buId']            = intval($data['buId']);
		$data['transType']       = intval($data['transTypeId']);
		$data['totalQty']        = (float)$data['totalQty'];
		$data['billType']        = 'OO';
		$data['billDate']        = $data['date'];   
		$data['transTypeName']   = $data['transTypeName'];
	    $data['uid']             = $this->jxcsys['uid'];
		$data['userName']        = $this->jxcsys['name'];
		$data['modifyTime']      = date('Y-m-d H:i:s');
		$data['createTime']      = $data['modifyTime'];
		$data['accounts']        = isset($data['accounts']) ? $data['accounts'] : array();
		$data['entries']         = isset($data['entries']) ? $data['entries'] : array();
		
		count($data['entries']) < 1 && str_alert(-1,'提交的是空数据'); 
		

		if ($data['id']>0) {
		    $invoice = $this->mysql_model->get_rows('invoice',array('id'=>$data['id'],'billType'=>'OO','isDelete'=>0));  
			count($invoice)<1 && str_alert(-1,'单据不存在、或者已删除');
			$data['checked'] = $invoice['checked'];	
			$data['billNo'] = $invoice['billNo'];	
		} else {
		    $data['billNo'] = str_no('QTCK');    
		}


		$system    = $this->common_model->get_option('system'); 
		if ($system['requiredCheckStore']==1) {  
		    $inventory = $this->data_model->get_invoice_info_inventory();
		}
		$storage   = array_column($this->mysql_model->get_results('storage','(disable=0)'),'id');  
		foreach ($data['entries'] as $arr=>$row) {
		    intval($row['invId']) < 1 && str_alert(-1,'请选择商品');    
			(float)$row['qty'] < 0  && str_alert(-1,'商品数量要为数字，请输入有效数字！'); 
			(float)$row['price'] < 0  && str_alert(-1,'商品销售单价要为数字，请输入有效数字！'); 
			intval($row['locationId']) < 1 && str_alert(-1,'请选择相应的仓库！'); 
			!in_array($row['locationId'],$storage) && str_alert(-1,$row['locationName'].'不存在或不可用！');


			if ($system['requiredCheckStore']==1 && $data['id']<1) {  
				if (intval($data['transType'])==150806) {                        
					if (isset($inventory[$row['invId']][$row['locationId']])) {
						$inventory[$row['invId']][$row['locationId']] < (float)$row['qty'] && str_alert(-1,$row['locationName'].$row['invName'].'商品库存不足！'); 
					} else {
						str_alert(-1,$row['invName'].'库存不足！');
					}
				}
			}
			if ($data['transType']==150706) {  	
				$inLocationId[]  = $row['locationId'];
			} else {
				$outLocationId[] = $row['locationId'];
			}
		}
		if ($data['transType']==150706) {  	
			$data['inLocationId']  = join(',',array_unique($inLocationId));
		} else {
			$data['outLocationId'] = join(',',array_unique($outLocationId));
		}
		$data['postData'] = serialize($data);
		return $data;  
	}  
	
	

	private function Oo_invoice_info($iid,$data) {
	    $amount = 0;
		$profit = $this->data_model->get_profit('and billDate<="'.date('Y-m-d').'"');    
		foreach ($data['entries'] as $arr=>$row) {
		    $price = isset($profit['inprice'][$row['invId']][$row['locationId']]) ? $profit['inprice'][$row['invId']][$row['locationId']] : 0;  
			$amount   += -abs($row['qty']) * $price; 
			$v[$arr]['iid']           = $iid;
			$v[$arr]['billNo']        = $data['billNo'];
			$v[$arr]['buId']          = $data['buId'];
			$v[$arr]['transType']     = $data['transType'];
			$v[$arr]['transTypeName'] = $data['transTypeName'];
			$v[$arr]['billDate']      = $data['billDate']; 
			$v[$arr]['billType']      = $data['billType'];
			$v[$arr]['invId']         = intval($row['invId']);
			$v[$arr]['skuId']         = intval($row['skuId']);
			$v[$arr]['unitId']        = intval($row['unitId']);
			$v[$arr]['locationId']    = intval($row['locationId']);
			$v[$arr]['qty']           = -abs($row['qty']); 
			$v[$arr]['amount']        = -abs($row['qty']) * $price; 
			$v[$arr]['price']         = $price; 
			$v[$arr]['description']   = $row['description'];   
		} 
		if (isset($v)) {
		    if ($data['id']>0) {      
				$this->mysql_model->delete('invoice_info',array('iid'=>$iid));
			}
			$this->mysql_model->insert('invoice_info',$v);
			$this->mysql_model->update('invoice',array('totalAmount'=>$amount),array('id'=>$iid));
		}
	}

	private function cadj_validform($data) {
	    $data['id']              = isset($data['id']) ? intval($data['id']) : 0;
		$data['totalAmount']     = (float)$data['totalAmount'];
		$data['billNo']          = str_no('CBTZ');
		$data['billDate']        = $data['date'];   
		$data['transTypeName']   = '成本调整';
		$data['transType']       = 150807;
		$data['billType']        = 'CADJ';
	    $data['uid']             = $this->jxcsys['uid'];
		$data['userName']        = $this->jxcsys['name'];
		$data['modifyTime']      = date('Y-m-d H:i:s');
		$data['createTime']      = $data['modifyTime'];
		$data['entries']         = isset($data['entries']) ? $data['entries'] : array();
		count($data['entries']) < 1 && str_alert(-1,'提交的是空数据'); 
		$storage   = array_column($this->mysql_model->get_results('storage','(disable=0)'),'id');  
		foreach ($data['entries'] as $arr=>$row) {
		    intval($row['invId'])<1 && str_alert(-1,'选择商品');    
			(float)$row['amount'] < 0 && str_alert(-1,'调整金额要为数字，请输入有效数字！'); 
			intval($row['locationId']) < 1 && str_alert(-1,'请选择相应的仓库！'); 
			!in_array($row['locationId'],$storage) && str_alert(-1,$row['locationName'].'不存在或不可用！');
			$locationId[]    = $row['locationId'];
		}
		$data['postData']    = serialize($data);	
		$data['locationId']  = join(',',array_unique($locationId));
		return $data;
		  
	}  
	
	private function cadj_invoice_info($iid,$data) {
		foreach ($data['entries'] as $arr=>$row) {
			$v[$arr]['iid']           = $iid;
			$v[$arr]['billNo']        = $data['billNo'];
			$v[$arr]['transType']     = $data['transType'];
			$v[$arr]['transTypeName'] = $data['transTypeName'];
			$v[$arr]['billDate']      = $data['billDate']; 
			$v[$arr]['billType']      = $data['billType'];
			$v[$arr]['invId']         = intval($row['invId']);
			$v[$arr]['skuId']         = intval($row['skuId']);
			$v[$arr]['unitId']        = intval($row['unitId']);
			$v[$arr]['locationId']    = intval($row['locationId']); 
			$v[$arr]['amount']        = abs($row['amount']); 
			$v[$arr]['description']   = $row['description'];    
		} 
		if (isset($v)) {
		    if ($data['id']>0) {      
				$this->mysql_model->delete('invoice_info',array('iid'=>$iid)); 
			}
			$this->mysql_model->insert('invoice_info',$v);
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */