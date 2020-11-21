<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class InvPu extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
		$this->jxcsys  = $this->session->userdata('jxcsys');
    }
	
	public function index() {
	    $action = $this->input->get('action',TRUE);
		switch ($action) {
			case 'initPur':
			    $this->common_model->checkpurview(2);
				$data['billNo'] = str_no('CG');
			    $this->load->view('scm/invPu/initPur',$data);	
				break;  
			case 'editPur':
			    $this->common_model->checkpurview(1);
				$id = intval($this->input->get_post('id',TRUE));
				$data['billNo'] = $this->mysql_model->get_row('invoice',array('id'=>$id,'billType'=>'PUR'),'billNo');  
			    $this->load->view('scm/invPu/initPur',$data);	
				break;  	
			case 'initPurList':
			    $this->common_model->checkpurview(1); 
			    $this->load->view('scm/invPu/initPurList');
				break; 
			default: 
			    $this->common_model->checkpurview(1); 
			    $this->purList();	
		}
	}
	
	public function purList() {
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100);
		$sidx = str_enhtml($this->input->get_post('sidx',TRUE));
		$sord = str_enhtml($this->input->get_post('sord',TRUE));
		$transType = intval($this->input->get_post('transType',TRUE));
		$matchCon  = str_enhtml($this->input->get_post('matchCon',TRUE));
		$beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
		$order = $sidx ? $sidx.' '.$sord :' a.id desc';
		$where = 'a.isDelete=0 and a.billType="PUR"'; 
		$where .= $transType ? ' and a.transType='.$transType : ''; 
		$where .= $matchCon  ? ' and a.postData like "%'.$matchCon.'%"' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate   ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_admin_purview();                               
		$list = $this->data_model->get_invoice($where.' order by '.$order.' limit '.$rows*($page-1).','.$rows);  
		foreach ($list as $arr=>$row) {
			$v[$arr]['hxStateCode']  = intval($row['hxStateCode']);
			//add begin
			$hasCheck = (float)abs($row['hasCheck']);
			if($hasCheck <= 0)
			    $hxStateCode = 0;
			else if($hasCheck >= (float)abs($row['amount']))
			    $hxStateCode = 2;
			else
			    $hxStateCode = 1;
			$v[$arr]['hxStateCode']  = $hxStateCode;
			//add end
		    $v[$arr]['id']           = intval($row['id']);
		    $v[$arr]['checkName']    = $row['checkName'];
			$v[$arr]['checked']      = intval($row['checked']);
			$v[$arr]['billDate']     = $row['billDate'];
		    $v[$arr]['amount']       = (float)abs($row['amount']);
			$v[$arr]['transType']    = intval($row['transType']); 
			$v[$arr]['rpAmount']     = (float)abs($row['hasCheck']);
			$v[$arr]['totalQty']     = (float)abs($row['totalQty']);
			$v[$arr]['contactName']  = $row['contactNo'].' '.$row['contactName'];
			$v[$arr]['serialno']  = $row['serialno'];
			$v[$arr]['description']  = $row['description'];
			$v[$arr]['billNo']       = $row['billNo'];
			$v[$arr]['totalAmount']  = (float)abs($row['totalAmount']);
			$v[$arr]['userName']     = $row['userName'];
			$v[$arr]['transTypeName']= $row['transTypeName'];
			$v[$arr]['disEditable']  = 0;
		}
		$json['status']              = 200;
		$json['msg']                 = 'success'; 
		$json['data']['page']        = $page;
		$json['data']['records']     = $this->data_model->get_invoice($where,3);                             
		$json['data']['total']       = ceil($json['data']['records']/$rows);
		$json['data']['rows']        = isset($v) ? $v : array();
		die(json_encode($json));
	}
	
	
	public function exportInvPu(){
	    $this->common_model->checkpurview(5);
		$name = 'purchase_record_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('导出采购单据:'.$name);
		$sidx = str_enhtml($this->input->get_post('sidx',TRUE));
		$sord = str_enhtml($this->input->get_post('sord',TRUE));
		$transType = intval($this->input->get_post('transType',TRUE));
		$matchCon  = str_enhtml($this->input->get_post('matchCon',TRUE));
		$beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
		$order = $sidx ? $sidx.' '.$sord :' a.id desc';
		$where = 'a.isDelete=0 and a.transType='.$transType.''; 
		$where .= $matchCon  ? ' and a.postData like "%'.$matchCon.'%"' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_admin_purview();
		$data['list'] = $this->data_model->get_invoice($where.' order by '.$order);  
		$this->load->view('scm/invPu/exportInvPu',$data);	
	}
	

	public function findUnhxList(){
		$billno = str_enhtml($this->input->get_post('billNo',TRUE));
		$buid = intval($this->input->get_post('buId',TRUE));
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100);
		$begindate  = str_enhtml($this->input->get_post('beginDate',TRUE));
		$enddate    = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = '(a.billType="PUR") and checked=1';
		$where .= $billno ? ' and a.billNo="'.$billno.'"' : ''; 
		$where .= $buid > 0 ? ' and a.buId='.$buid.'' : ''; 
		$where .= strlen($begindate)>0 ? ' and a.billDate>="'.$begindate.'"' : ''; 
		$where .= strlen($enddate)>0 ? ' and a.billDate<="'.$enddate.'"' : ''; 
		$list = $this->data_model->get_unhx($where.' HAVING notCheck<>0');  
		foreach ($list as $arr=>$row) {
			$v[$arr]['type']         = 1;
			$v[$arr]['billId']       = intval($row['id']);
			$v[$arr]['billNo']       = $row['billNo'];
			$v[$arr]['billType']     = $row['billType'];
			$v[$arr]['transType']    = $row['transType']==150501 ? '购货' : '退货';
			$v[$arr]['billDate']     = $row['billDate'];
			$v[$arr]['billPrice']    = (float)$row['amount'];
			$v[$arr]['hasCheck']     = (float)$row['nowCheck'];
			$v[$arr]['notCheck']     = (float)$row['notCheck'];
		}
		$json['status']              = 200;
		$json['msg']                 = 'success'; 
		$json['data']['totalsize']   = $this->data_model->get_unhx($where.' HAVING notCheck>0',3);    
		$json['data']['items']       = isset($v) ? $v : array();
		die(json_encode($json));
	}

	
	

	public function add(){
	    $this->common_model->checkpurview(2); 
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->validform((array)json_decode($data, true));
			$info = elements(array(
				'billNo','billType','transType','transTypeName','buId','billDate','postData','hxStateCode',
				'serialno','description','totalQty','amount','arrears','rpAmount','totalAmount','createTime',
				'totalArrears','disRate','disAmount','uid','userName','srcOrderNo','srcOrderId',
				'accId','modifyTime'),$data,NULL);
			$this->db->trans_begin();
			$iid = $this->mysql_model->insert('invoice',$info);   
			$this->invoice_info($iid,$data);
			$this->account_info($iid,$data);
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误'); 
			} else {
			    $this->db->trans_commit(); 
				$this->common_model->logs('新增购货 单据编号：'.$info['billNo']);//.'，报文：'.$_POST['postData']//stripslashes(json_encode($info))
				str_alert(200,'success',array('id'=>intval($iid))); 
			}
		}
		str_alert(-1,'提交的是空数据'); 
    }
	

	public function addnew(){
	    $this->add();
    }
	
	 

	public function updateInvPu(){
	    $this->common_model->checkpurview(3);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->validform((array)json_decode($data, true));
			$info = elements(array(
				'billType','transType','transTypeName','buId','billDate','hxStateCode',
				'serialno','description','totalQty','amount','arrears','rpAmount','uid','userName',
				'totalAmount','totalArrears','disRate','postData',
				'disAmount','accId','modifyTime'),$data,NULL);
			$this->db->trans_begin();
			$this->mysql_model->update('invoice',$info,array('id'=>$data['id']));
			$this->invoice_info($data['id'],$data);
			$this->account_info($data['id'],$data);
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('修改购货单 单据编号：'.$data['billNo']);
				str_alert(200,'success',array('id'=>$data['id'])); 
			}
		}
		str_alert(-1,'提交的数据不能为空'); 
    }
	
	

	public function update() {
	    $this->common_model->checkpurview(1);
	    $id   = intval($this->input->get_post('id',TRUE));
		$data =  $this->data_model->get_invoice('a.isDelete=0 and a.id='.$id.' and a.billType="PUR"',1);
		if (count($data)>0) {
			$info['status'] = 200;
			$info['msg']    = 'success'; 
			$info['data']['id']                 = intval($data['id']);
			$info['data']['buId']               = intval($data['buId']);
			$info['data']['contactName']        = $data['contactName'];
			$info['data']['date']               = $data['billDate'];
			$info['data']['billNo']             = $data['billNo'];
			$info['data']['billType']           = $data['billType'];
			$info['data']['modifyTime']         = $data['modifyTime'];
			$info['data']['createTime']         = $data['createTime'];
			$info['data']['checked']            = intval($data['checked']); 
			$info['data']['checkName']          = $data['checkName'];
			$info['data']['transType']          = intval($data['transType']);
			$info['data']['totalQty']           = (float)$data['totalQty'];
			$info['data']['totalTaxAmount']     = (float)$data['totalTaxAmount'];
			$info['data']['billStatus']         = intval($data['billStatus']);
			$info['data']['disRate']            = (float)$data['disRate'];
			$info['data']['disAmount']          = (float)$data['disAmount'];
			$info['data']['amount']             = (float)abs($data['amount']);
			$info['data']['rpAmount']           = (float)abs($data['rpAmount']);
			$info['data']['arrears']            = (float)abs($data['arrears']);
			$info['data']['userName']           = $data['userName'];
			$info['data']['status']             = intval($data['checked'])==1 ? 'view' : 'edit';    //edit
			$info['data']['totalDiscount']      = (float)$data['totalDiscount'];
			$info['data']['totalTax']           = (float)$data['totalTax'];
			$info['data']['totalAmount']        = (float)abs($data['totalAmount']);
			$info['data']['serialno']        = $data['serialno']; 
			$info['data']['description']        = $data['description'];
			$list = $this->data_model->get_invoice_info('a.isDelete=0 and a.iid='.$id.' order by a.id');  
			foreach ($list as $arr=>$row) {
				$v[$arr]['invSpec']             = $row['invSpec'];
				$v[$arr]['srcOrderEntryId']     = $row['srcOrderEntryId'];
				$v[$arr]['srcOrderNo']          = $row['srcOrderNo'];
				$v[$arr]['srcOrderId']          = $row['srcOrderId'];
				$v[$arr]['goods']               = $row['invNumber'].' '.$row['invName'].' '.$row['invSpec'];
				$v[$arr]['invName']             = $row['invNumber'];
				$v[$arr]['qty']                 = (float)abs($row['qty']);
				$v[$arr]['amount']              = (float)abs($row['amount']);
				$v[$arr]['taxAmount']           = (float)abs($row['taxAmount']);
				$v[$arr]['price']               = (float)$row['price'];
				$v[$arr]['tax']                 = (float)$row['tax'];
				$v[$arr]['taxRate']             = (float)$row['taxRate'];
				$v[$arr]['mainUnit']            = $row['mainUnit'];
				$v[$arr]['deduction']           = (float)$row['deduction'];
				$v[$arr]['invId']               = intval($row['invId']);
				$v[$arr]['invNumber']           = $row['invNumber'];
				$v[$arr]['locationId']          = intval($row['locationId']);
				$v[$arr]['locationName']        = $row['locationName'];
				$v[$arr]['discountRate']        = $row['discountRate'];
				$v[$arr]['unitId']              = intval($row['unitId']);
				$v[$arr]['serialno']         = $row['serialno'];
				$v[$arr]['description']         = $row['description'];
				$v[$arr]['skuId']               = intval($row['skuId']);
				$v[$arr]['skuName']             = '';
			}
			$info['data']['entries']            = isset($v) ? $v : array();
			$info['data']['accId']              = (float)$data['accId'];
			$accounts = $this->data_model->get_account_info('a.isDelete=0 and a.iid='.$id.' order by a.id');  
			foreach ($accounts as $arr=>$row) {
				$s[$arr]['invoiceId']           = intval($id);
				$s[$arr]['billNo']              = $row['billNo'];
				$s[$arr]['buId']                = intval($row['buId']);
			    $s[$arr]['billType']            = $row['billType'];
				$s[$arr]['transType']           = $row['transType'];
				$s[$arr]['transTypeName']       = $row['transTypeName'];
				$s[$arr]['billDate']            = $row['billDate']; 
			    $s[$arr]['accId']               = intval($row['accId']);
				$s[$arr]['account']             = $row['accountNumber'].''.$row['accountName']; 
				$s[$arr]['payment']             = (float)abs($row['payment']); 
				$s[$arr]['wayId']               = (float)$row['wayId']; 
				$s[$arr]['way']                 = $row['categoryName']; 
				$s[$arr]['settlement']          = $row['settlement']; 
		    }  
			$info['data']['accounts']           = isset($s) ? $s : array();
			die(json_encode($info));
		}
		str_alert(-1,'单据不存在、或者已删除');  
    }
	

	 
	
 
    public function toPdf() {
	    $this->common_model->checkpurview(85);
	    $id   = intval($this->input->get('id',TRUE));
		$data = $this->data_model->get_invoice('a.isDelete=0 and a.id='.$id.' and a.billType="PUR"',1);  
		if (count($data)>0) { 
			$data['num']    = 8;
			$data['system'] = $this->common_model->get_option('system'); 
			$postData = unserialize($data['postData']);
		    foreach ($postData['entries'] as $arr=>$row) {
			    $v[$arr]['i']               = $arr + 1;
				$v[$arr]['invId']           = intval($row['invId']);
				$v[$arr]['invNumber']       = $row['invNumber'];
				$v[$arr]['invSpec']         = $row['invSpec'];
				$v[$arr]['invName']         = $row['invName'];
				$v[$arr]['goods']           = $row['invNumber'].' '.$row['invName'].' '.$row['invSpec'];
				$v[$arr]['qty']             = (float)abs($row['qty']);
				$v[$arr]['price']           = $row['price'];
				$v[$arr]['mainUnit']        = $row['mainUnit'];
				$v[$arr]['amount']          = $row['amount'];
				$v[$arr]['deduction']       = $row['deduction'];
				$v[$arr]['discountRate']    = $row['discountRate'];
				$v[$arr]['unitId']          = intval($row['unitId']);
				$v[$arr]['locationName']    = $row['locationName'];
			}  
			$data['countpage']  = ceil(count($postData['entries'])/$data['num']); 
			$data['list']       = isset($v) ? $v : array();                           
		    ob_start();
			$this->load->view('scm/invPu/toPdf',$data);
			$content = ob_get_clean();
			require_once('./application/libraries/html2pdf/html2pdf.php');
			try {
				$html2pdf = new HTML2PDF('P', 'A4', 'tr');
				$html2pdf->setDefaultFont('javiergb');
				$html2pdf->pdf->SetDisplayMode('fullpage');
				$html2pdf->writeHTML($content, '');
				$html2pdf->Output('invPur_'.date('YmdHis').'.pdf');
			}catch(HTML2PDF_exception $e) {
				echo $e;
				exit;
			}  	  
		} 
		str_alert(-1,'单据不存在、或者已删除');  	   
	}
	
	
	
	//购购单删除
    public function delete() {
	    $this->common_model->checkpurview(4);
		$id   = str_enhtml($this->input->get_post('id',TRUE));
		$data = $this->mysql_model->get_results('invoice','(isDelete=0) and (id in('.$id.')) and billType="PUR"');  
		if (count($data)>0) {
		    foreach($data as $arr=>$row) {
			    $row['checked'] >0 && str_alert(-1,'其中已有审核的不可删除'); 
				$ids[]           = $row['id'];
				$billNo[]        = $row['billNo'];
				$msg[$arr]['id'] = $row['billNo'];
				$msg[$arr]['isSuccess'] = 1;
				$msg[$arr]['msg'] = '删除成功！';
			}
			$id     = join(',',$ids);
			$billNo = join(',',$billNo); 
			 
		    $this->db->trans_begin();
			$this->mysql_model->update('invoice',array('isDelete'=>1),'(id in('.$id.'))');   
			$this->mysql_model->update('invoice_info',array('isDelete'=>1),'(iid in('.$id.'))');   
			$this->mysql_model->update('account_info',array('isDelete'=>1),'(iid in('.$id.'))');   
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'删除失败'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('删除购货订单 单据编号：'.$billNo);
				str_alert(200,$msg); 	 
			}
		}
		str_alert(-1,'单据不存在');  
	}
	
	
	 
    public function delete1() {
	    $this->common_model->checkpurview(4);
	    $id   = intval($this->input->get('id',TRUE));
		$data = $this->mysql_model->get_rows('invoice',array('id'=>$id,'billType'=>'PUR'));  
		if (count($data)>0) {
		    //$data['checked'] >0 && str_alert(-1,'已审核的不可删除'); 
		    $this->db->trans_begin();
			$this->mysql_model->update('invoice',array('isDelete'=>1),array('id'=>$id));   
			$this->mysql_model->update('invoice_info',array('isDelete'=>1),array('iid'=>$id));  
			if ($data['accId']>0) { 
				$this->mysql_model->update('account_info',array('isDelete'=>1),array('iid'=>$id));   
			}
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'删除失败'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('删除购货订单 单据编号：'.$data['billNo']);
				str_alert(200,'success'); 	 
			}
		}
		str_alert(-1,'单据不存在、或者已删除');  
	}
	
	
	
	
	//单个审核   
	public function checkInvPu() {
	    $this->common_model->checkpurview(86);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->validform((array)json_decode($data, true));
			$data['checked']         = 1;
			$data['checkName']       = $this->jxcsys['name']; 
			$info = elements(array(
				'billType','transType','transTypeName','buId','billDate','checked','checkName',
				'serialno','description','totalQty','amount','arrears','rpAmount','totalAmount','hxStateCode',
				'totalArrears','disRate','postData','disAmount','accId','modifyTime'),$data,NULL);
			$this->db->trans_begin();
			
			//特殊情况
			if ($data['id'] < 0) {
			    $info = elements(array(
						'billNo','billType','transType','transTypeName','buId','billDate','checked','checkName',
						'serialno','description','totalQty','amount','arrears','rpAmount','totalAmount','hxStateCode', 
						'totalArrears','disRate','disAmount','postData','createTime',
						'salesId','uid','userName','accId','modifyTime'),$data,NULL);
			    $iid = $this->mysql_model->insert('invoice',$info);
			    $this->invoice_info($iid,$data);
				$data['id'] = $iid;
			} else {
				$this->mysql_model->update('invoice',$info,array('id'=>$data['id']));
			    $this->invoice_info($data['id'],$data);
			}
			 
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('采购单据编号：'.$data['billNo'].'的单据已被审核！');
				str_alert(200,'success',array('id'=>$data['id'])); 
			}
		}
		str_alert(-1,'提交的数据不能为空'); 
    }
	
	
	//批量审核  
    public function batchCheckInvPu() {
	    $this->common_model->checkpurview(86);
	    $id   = str_enhtml($this->input->post('id',TRUE));
		$data = $this->mysql_model->get_results('invoice','(id in('.$id.')) and billType="PUR" and isDelete=0');  
		if (count($data)>0) {
		    foreach($data as $arr=>$row) {
			    $row['checked'] > 0 && str_alert(-1,'勾选当中已有审核，不可重复审核'); 
			    $ids[]        = $row['id'];
				$billNo[]     = $row['billNo'];
			    $srcOrderId[] = $row['srcOrderId'];
			}
			$id         = join(',',$ids);
			$billNo     = join(',',$billNo);
			$srcOrderId = join(',',array_filter($srcOrderId));
			$sql = $this->mysql_model->update('invoice',array('checked'=>1,'checkName'=>$this->jxcsys['name']),'(id in('.$id.'))'); 
			if ($sql) {
			    //$this->mysql_model->update('invoice_info',array('checked'=>1),'(iid in('.$id.'))'); 
				$this->common_model->logs('购货单编号：'.$billNo.'的单据已被审核！');
				str_alert(200,'单据编号：'.$billNo.'的单据已被审核！');
			} 
			str_alert(-1,'审核失败');  
		}
		str_alert(-1,'单据不存在！'); 
	}
	
	//批量反审核
    public function rsBatchCheckInvPu() {
	    $this->common_model->checkpurview(87);
	    $id   = str_enhtml($this->input->post('id',TRUE));
	    $this->mysql_model->get_count('verifica_info','(billId='.$id.')')>0 && str_alert(-1,'存在关联的“付款单据”，无法删除！请先在“付款单”中删除该销货单！');//add
		$data = $this->mysql_model->get_results('invoice','(id in('.$id.')) and billType="PUR" and isDelete=0');  
		if (count($data)>0) {
		    foreach($data as $arr=>$row) {
			    $row['checked'] < 1 && str_alert(-1,'勾选当中已有未审核，不可重复反审核'); 
				$ids[]        = $row['id'];
				$billNo[]     = $row['billNo'];
				$srcOrderId[] = $row['srcOrderId'];
			}
			$id         = join(',',$ids);
			$billNo     = join(',',$billNo);
			$srcOrderId = join(',',array_filter($srcOrderId));
			
			$sql = $this->mysql_model->update('invoice',array('checked'=>0,'checkName'=>''),'(id in('.$id.'))'); 
			if ($sql) {
			    //$this->mysql_model->update('invoice_info',array('checked'=>0),'(iid in('.$id.'))'); 
				$this->common_model->logs('购货单单号：'.$billNo.'的单据已被反审核！');
				str_alert(200,'购货单编号：'.$billNo.'的单据已被反审核！'); 
			} 
			str_alert(-1,'反审核失败');  
		}
		str_alert(-1,'单据不存在！'); 
	}

	//公共验证
	private function validform($data) {
	    $data['id']              = isset($data['id']) ? intval($data['id']) : 0;
		$data['billType']        = 'PUR';
		$data['transTypeName']   = $data['transType']==150501 ? '购货' : '退货';
		$data['billDate']        = $data['date'];
		$data['buId']            = intval($data['buId']);
		$data['accId']           = intval($data['accId']);
		$data['transType']       = intval($data['transType']);
		$data['amount']          = (float)$data['amount'];
		$data['arrears']         = (float)$data['arrears'];
		$data['disRate']         = (float)$data['disRate'];
		$data['disAmount']       = (float)$data['disAmount'];
		$data['rpAmount']        = (float)$data['rpAmount'];
		$data['totalQty']        = (float)$data['totalQty'];
		$data['totalArrears']    = (float)$data['totalArrears'];
		$data['accounts']        = isset($data['accounts']) ? $data['accounts'] : array();
		$data['entries']         = isset($data['entries']) ? $data['entries'] : array();
		
		$data['arrears'] < 0 && str_alert(-1,'本次欠款要为数字，请输入有效数字！'); 
		$data['disRate'] < 0 && str_alert(-1,'折扣率要为数字，请输入有效数字！'); 
		$data['rpAmount'] < 0  && str_alert(-1,'本次收款要为数字，请输入有效数字！'); 
		$data['amount'] < $data['rpAmount']  && str_alert(-1,'本次收款不能大于折后金额！'); 
		$data['amount'] < $data['disAmount'] && str_alert(-1,'折扣额不能大于合计金额！'); 
		
		if ($data['amount']==$data['rpAmount']) {
			$data['hxStateCode'] = 2;
		} else {	
		    $data['hxStateCode'] = $data['rpAmount']!=0 ? 1 : 0;
		}
		
		$data['amount']          = $data['transType']==150501 ? abs($data['amount']) : -abs($data['amount']);
		$data['arrears']         = $data['transType']==150501 ? abs($data['arrears']) : -abs($data['arrears']);
		$data['rpAmount']        = $data['transType']==150501 ? abs($data['rpAmount']) : -abs($data['rpAmount']);
		$data['totalAmount']     = $data['transType']==150501 ? abs($data['totalAmount']) : -abs($data['totalAmount']);
		$data['uid']             = $this->jxcsys['uid'];
		$data['userName']        = $this->jxcsys['name'];
		$data['modifyTime']      = date('Y-m-d H:i:s');
		$data['createTime']      = $data['modifyTime'];
		
		
		
		strlen($data['billNo']) < 1 && str_alert(-1,'单据编号不为空');  
		count($data['entries']) < 1 && str_alert(-1,'提交的是空数据'); 
		
		
		
		 
		if ($data['id']>0) {
		    $invoice = $this->mysql_model->get_rows('invoice',array('id'=>$data['id'],'billType'=>'PUR','isDelete'=>0));  
			count($invoice)<1 && str_alert(-1,'单据不存在、或者已删除');
			$data['checked'] = $invoice['checked'];	
			$data['billNo']  = $invoice['billNo'];	
		} else {
		    //$data['billNo']  = str_no('CG');    
		}
	    
		 
		foreach ($data['accounts'] as $arr=>$row) {
			(float)$row['payment'] < 0 && str_alert(-1,'结算金额要为数字，请输入有效数字！');
		} 
		
 
		$this->mysql_model->get_count('contact',array('id'=>$data['buId'])) < 1 && str_alert(-1,'购货单位不存在');   
		
		 
		$system  = $this->common_model->get_option('system');
		
	 
		if ($system['requiredCheckStore']==1) {
		    $inventory = $this->data_model->get_invoice_info_inventory();
		}
		 
		$storage = array_column($this->mysql_model->get_results('storage',array('disable'=>0)),'id');  
		foreach ($data['entries'] as $arr=>$row) {
			intval($row['invId'])<1 && str_alert(-1,'请选择商品');    
			(float)$row['qty'] < 0  && str_alert(-1,'商品数量要为数字，请输入有效数字！'); 
			(float)$row['price'] < 0  && str_alert(-1,'商品销售单价要为数字，请输入有效数字！'); 
			(float)$row['discountRate'] < 0  && str_alert(-1,'折扣率要为数字，请输入有效数字！');
			intval($row['locationId']) < 1 && str_alert(-1,'请选择相应的仓库！'); 
			!in_array($row['locationId'],$storage) && str_alert(-1,$row['locationName'].'不存在或不可用！');
		 
			if ($system['requiredCheckStore']==1 && $data['id']<1) {  
				if ($data['transType']==150502) {                        
					if (isset($inventory[$row['invId']][$row['locationId']])) {
						$inventory[$row['invId']][$row['locationId']] < $row['qty'] && str_alert(-1,$row['locationName'].$row['invName'].'商品库存不足！'); 
					} else {
						str_alert(-1,$row['invName'].'库存不足！');
					}
				}
			}
		} 
		$data['srcOrderNo'] = $data['entries'][0]['srcOrderNo'] ? $data['entries'][0]['srcOrderNo'] : 0; 
		$data['srcOrderId'] = $data['entries'][0]['srcOrderId'] ? $data['entries'][0]['srcOrderId'] : 0; 
		$data['postData'] = serialize($data);
		
		return $data;
	}
	
	
 
	private function invoice_info($iid,$data) {
		foreach ($data['entries'] as $arr=>$row) {
			$v[$arr]['iid']              = $iid;
			$v[$arr]['uid']              = $data['uid'];
			$v[$arr]['billNo']           = $data['billNo'];
			$v[$arr]['buId']             = $data['buId'];
			$v[$arr]['billDate']         = $data['billDate']; 
			$v[$arr]['billType']         = $data['billType'];
			$v[$arr]['transType']        = $data['transType'];
			$v[$arr]['transTypeName']    = $data['transTypeName'];
			$v[$arr]['invId']            = intval($row['invId']);
			$v[$arr]['skuId']            = intval($row['skuId']);
			$v[$arr]['unitId']           = intval($row['unitId']);
			$v[$arr]['locationId']       = intval($row['locationId']);
			$v[$arr]['qty']              = $data['transType']==150501 ? abs($row['qty']) :-abs($row['qty']); 
			$v[$arr]['amount']           = $data['transType']==150501 ? abs($row['amount']) :-abs($row['amount']); 
			$v[$arr]['price']            = abs($row['price']);  
			$v[$arr]['discountRate']     = $row['discountRate'];  
			$v[$arr]['deduction']        = $row['deduction'];  
			$v[$arr]['serialno']      = $row['serialno'];
			$v[$arr]['description']      = $row['description']; 
			if (intval($row['srcOrderId'])>0) {   
			    $v[$arr]['srcOrderEntryId']  = intval($row['srcOrderEntryId']);  
				$v[$arr]['srcOrderId']       = intval($row['srcOrderId']);  
				$v[$arr]['srcOrderNo']       = $row['srcOrderNo']; 
			} else {
			    $v[$arr]['srcOrderEntryId']  = 0;  
				$v[$arr]['srcOrderId']       = 0;  
				$v[$arr]['srcOrderNo']       = ''; 
			}
		}
		if (isset($v)) {
			if ($data['id']>0) {                     
				$this->mysql_model->delete('invoice_info',array('iid'=>$iid));
			}
			$this->mysql_model->insert('invoice_info',$v);
		}
	}
	
 
	private function account_info($iid,$data) {
		foreach ($data['accounts'] as $arr=>$row) {
			$v[$arr]['iid']               = $iid;
			$v[$arr]['uid']               = $data['uid'];
			$v[$arr]['billNo']            = $data['billNo'];
			$v[$arr]['buId']              = $data['buId'];
			$v[$arr]['billType']          = $data['billType'];
			$v[$arr]['transType']         = $data['transType'];
			$v[$arr]['transTypeName']     = $data['transType']==150501 ? '普通采购' : '采购退回'; 
			$v[$arr]['payment']           = $data['transType']==150501 ? -abs($row['payment']) : abs($row['payment']); 
			$v[$arr]['billDate']          = $data['billDate']; 
			$v[$arr]['accId']             = $row['accId']; 
			$v[$arr]['wayId']             = $row['wayId'];
			$v[$arr]['settlement']        = $row['settlement'];
		} 
		if ($data['id']>0) {                      
			$this->mysql_model->delete('account_info',array('iid'=>$iid));
		}
		if (isset($v)) {
			$this->mysql_model->insert('account_info',$v);
		}
	}
	
	
	public function getImagesById() {
	    if (!$this->common_model->checkpurviews(204)){
		    str_alert(-1,'没有上传权限'); 
		}
	    $id = str_enhtml($this->input->post('id',TRUE));
	    $list = $this->mysql_model->get_results('invoice_img',array('isDelete'=>0,'billNo'=>$id));
		foreach ($list as $arr=>$row) {
		    $v[$arr]['pid']          = $row['id'];
			$v[$arr]['status']       = 1;
			$v[$arr]['name']         = $row['name'];
			$v[$arr]['url']          = site_url().'/scm/invPu/getImage?action=getImage&pid='.$row['id'];
			$v[$arr]['thumbnailUrl'] = site_url().'/scm/invPu/getImage?action=getImage&pid='.$row['id'];
			$v[$arr]['deleteUrl']    = '';
			$v[$arr]['deleteType']   = '';
		}
		$json['status'] = 200;
		$json['msg']    = 'success';
		$json['files']  = isset($v) ? $v : array();
		die(json_encode($json));  
	}
	
	
	//上传图片信息
	public function uploadImages() {
	    if (!$this->common_model->checkpurviews(203)){
		    str_alert(-1,'没有上传权限'); 
		}
	    require_once './application/libraries/UploadHandler.php';
		$config = array(
			'script_url' => base_url().'inventory/uploadimages',
			'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']).'/data/upfile/Contract/',
			'upload_url' => base_url().'data/upfile/Contract/',
			'delete_type' =>'',
			'print_response' =>false
		);
		$uploadHandler = new UploadHandler($config);
		$list  = (array)json_decode(json_encode($uploadHandler->response['files'][0]), true); 
		$info  = elements(array('name','size','type','url','thumbnailUrl','deleteUrl','deleteType'),$list,NULL);
		$newid = $this->mysql_model->insert('goods_img',$info);
		
		 
		$files[0]['pid']          = intval($newid);
		$files[0]['status']       = 1;
		$files[0]['size']         = (float)$list['size'];
		$files[0]['name']         = $list['name'];
		$files[0]['url']          = site_url().'/scm/invPu/getImage?action=getImage&pid='.$newid;
		$files[0]['thumbnailUrl'] = site_url().'/scm/invPu/getImage?action=getImage&pid='.$newid;
		$files[0]['deleteUrl']    = '';
		$files[0]['deleteType']   = '';
		$json['status'] = 200;
		$json['msg']    = 'success';
		$json['files']  = $files;
        die(json_encode($json)); 
	}
	
	//保存上传图片信息
	public function addImagesToInv() {
	    if (!$this->common_model->checkpurviews(205)){
		    str_alert(-1,'没有上传权限'); 
		}
	    $data = $this->input->post('postData');
		if (strlen($data)>0) {
		    $v = $s = array();
		    $data = (array)json_decode($data, true); 
			$id   = isset($data['id']) ? $data['id'] : 0;
		    !isset($data['files']) || count($data['files']) < 1 && str_alert(-1,'请先添加图片！'); 
			foreach($data['files'] as $arr=>$row) {
			    if ($row['status']==1) {
					$v[$arr]['id']       = $row['pid'];
					$v[$arr]['billNo']   = $id;
				} else {
				    $s[$arr]['id']       = $row['pid'];
					$s[$arr]['billNo']   = $id;
					$s[$arr]['isDelete'] = 1;
				}
			}
			$this->mysql_model->update('invoice_img',array_values($v),'id');
			$this->mysql_model->update('invoice_img',array_values($s),'id');
			str_alert(200,'success'); 
	    }
		str_alert(-1,'保存失败'); 
	}
	
	//获取图片信息
	public function getImage() {
	    $id = intval($this->input->get_post('pid',TRUE));
	    $data = $this->mysql_model->get_rows('invoice_img',array('id'=>$id));
		if (count($data)>0) {
		    $url     = './data/upfile/Contract/'.$data['name'];
			$info    = getimagesize($url);  
			$imgdata = fread(fopen($url,'rb'),filesize($url));   
			header('content-type:'.$info['mime'].'');  
			echo $imgdata;   
		}	 
	}
	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */