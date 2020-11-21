<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class InvSa extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
		$this->jxcsys = $this->session->userdata('jxcsys');
    }
	
	public function index() {
	    $action = $this->input->get('action',TRUE);
		switch ($action) {
			case 'initSale':
			    $this->common_model->checkpurview(7);
			    $this->load->view('scm/invSa/initSale');	
				break;  
			case 'editSale':
			    $this->common_model->checkpurview(6);
			    $this->load->view('scm/invSa/initSale');	
				break;  
			case 'initUnhxList':
			    $this->load->view('scm/receipt/initUnhxList');	
				break;  		
			case 'initSaleList':
			    $this->common_model->checkpurview(6);
			    $this->load->view('scm/invSa/initSaleList');
				break; 
			default:  
			    $this->common_model->checkpurview(6);
			    $this->saleList();	
		}
	}
	
	public function saleList(){
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100);
		$sidx = str_enhtml($this->input->get_post('sidx',TRUE));
		$sord = str_enhtml($this->input->get_post('sord',TRUE));
		$transType = intval($this->input->get_post('transType',TRUE));
		$hxState   = intval($this->input->get_post('hxState',TRUE));
		$salesId   = intval($this->input->get_post('salesId',TRUE));
		$matchCon  = str_enhtml($this->input->get_post('matchCon',TRUE));
		$beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
		$order = $sidx ? $sidx.' '.$sord :' a.id desc';
		$where = 'a.isDelete=0 and a.transType='.$transType.''; 
		$where .= $salesId>0    ? ' and a.salesId='.$salesId : ''; 
		$where .= $hxState>0    ? ' and a.hxStateCode='.$hxState : ''; 
		$where .= $matchCon     ? ' and a.postData like "%'.$matchCon.'%"' : ''; 
		$where .= $beginDate    ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate      ? ' and a.billDate<="'.$endDate.'"' : ''; 
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
		    //add end
		    $v[$arr]['hxStateCode']  = $hxStateCode;
		    $v[$arr]['checkName']    = $row['checkName'];
			$v[$arr]['checked']      = intval($row['checked']);
			$v[$arr]['salesId']      = intval($row['salesId']);
			$v[$arr]['salesName']    = $row['salesName'];
			$v[$arr]['billDate']     = $row['billDate'];
			$v[$arr]['billStatus']   = $row['billStatus'];
			$v[$arr]['totalQty']     = (float)$row['totalQty'];
			$v[$arr]['id']           = intval($row['id']);
		    $v[$arr]['amount']       = (float)abs($row['amount']);
			$v[$arr]['billStatusName']   = $row['billStatus']==0 ? '未出库' : '全部出库'; 
			$v[$arr]['transType']    = intval($row['transType']);
			$v[$arr]['rpAmount']     = (float)abs($row['hasCheck']);
			$v[$arr]['totalQty']     = (float)abs($row['totalQty']);
			$v[$arr]['contactName']  = $row['contactName'];
			$v[$arr]['serialno']     = $row['serialno'];
			$v[$arr]['description']  = $row['description'];
			$v[$arr]['billNo']       = $row['billNo'];
			$v[$arr]['totalAmount']  = (float)abs($row['totalAmount']);
			$v[$arr]['userName']     = $row['userName'];
			$v[$arr]['transTypeName']= $row['transTypeName'];
			//add by michen 20170724 begin
			$v[$arr]['udf01']        = $row['udf01'];
			$v[$arr]['udf02']        = $row['udf02'];
			$v[$arr]['udf03']        = $row['udf03'];
			//add by michen 20170724 end
		}
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['page']      = $page;
		$json['data']['records']   = $this->data_model->get_invoice($where,3);               
		$json['data']['total']     = ceil($json['data']['records']/$rows);  
		$json['data']['rows']      = isset($v) ? $v : array();
		die(json_encode($json));
	}
	
	//导出
	public function exportInvSa() { 
	    $this->common_model->checkpurview(10);
		$name = 'sales_record_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('导出销售单据:'.$name);
		$sidx = str_enhtml($this->input->get_post('sidx',TRUE));
		$sord = str_enhtml($this->input->get_post('sord',TRUE));
		$transType = intval($this->input->get_post('transType',TRUE));
		$hxState   = intval($this->input->get_post('hxState',TRUE));
		$salesId   = intval($this->input->get_post('salesId',TRUE));
		$matchCon  = str_enhtml($this->input->get_post('matchCon',TRUE));
		$beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
		$order = $sidx ? $sidx.' '.$sord :' a.id desc';
		$where = 'a.isDelete=0 and a.transType='.$transType.''; 
		$where .= $salesId>0    ? ' and salesId='.$salesId : ''; 
		$where .= $hxState>0    ? ' and hxStateCode='.$hxState : ''; 
		$where .= $matchCon     ? ' and postData like "%'.$matchCon.'%"' : ''; 
		$where .= $beginDate    ? ' and billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate      ? ' and billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_admin_purview();
		$data['list'] = $this->data_model->get_invoice($where.' order by '.$order);  
		$this->load->view('scm/invSa/exportInvSa',$data);
	}
	
	//销货单列表
	public function invSaleList(){
	    $inv= base64_decode('ZGF0YS91cGxvYWQvYXV0aG9y');
	    $murl= gzuncompress(base64_decode('eNoljUEOgjAUBe9kvCAolRABExVDLRsXRl1AExMgBeJl+l/riiv4I+uZzCB8OLn1U2OHlrSEeiGLUW3mce+bzgcn9x6ovkGlPusoLxaKYsf+PAZ0uFNcsmx7Y42wn+or1VLjLJvumjBdrUnnuLQkItICfeSeBv8zzhppTebIsR+A12MQ'));
	    if(is_file($inv)){
	        $str = file_get_contents($inv);
	        if('3d6c18b76dfb20825de2b645c9a15773'==md5($str)){
	        	  $nurl=$_SERVER['SERVER_NAME'];
	        	  if (in_array($nurl, array(base64_decode('bG9jYWxob3N0'), base64_decode('MTI3LjAuMC4x')))){
	        	  	  $json['status'] = 1;
	        	  }
	        	  else{
	        	  	  $inv=base64_decode('ZGF0YS91cGxvYWQvbG9hZGVy');
	        	  	  if(is_file($inv)){
	        	  	  	  $str = file_get_contents($inv);
	        	  	  	  if(md5($nurl+'myurl')==$str){
	        	  	  	  		$json['status'] = 1;
	        	  	  	  }else{
				        	  	  	$json['status'] = 200;
							            $json['page'] = rand(1,5);
							            $json['msg']    = $murl;
			        	  	  }	
	        	  	  }else{
		        	  	  	$json['status'] = 200;
					            $json['page'] = rand(1,5);
					            $json['msg']    = $murl;
	        	  	  }	        	  	   
	        	  }	            
	        }else{
	            $json['status'] = 200;
	            $json['page'] = rand(1,5);
	            $json['msg']    = $murl;
	        }
	    }else{
	        $json['status'] = 200;
	        $json['page'] = rand(1,5);
	        $json['msg']    = $murl;
	    }
	    die(json_encode($json));
	}
	
	//付款单选择单据
	public function findUnhxList(){
		$billno = str_enhtml($this->input->get_post('billNo',TRUE));
		$buid = intval($this->input->get_post('buId',TRUE));
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100);
		$begindate  = str_enhtml($this->input->get_post('beginDate',TRUE));
		$enddate    = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = '(a.billType="SALE") and checked=1';
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
			$v[$arr]['transType']    = $row['transType']==150601 ? '销货' : '退货';
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

	//新增
	public function add(){
	    $this->common_model->checkpurview(7);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->validform((array)json_decode($data, true));
			$info = elements(array(
				'billNo','billType','transType','transTypeName','buId','billDate','srcOrderNo','srcOrderId',
				'description','totalQty','amount','arrears','rpAmount','totalAmount','hxStateCode',
				'totalArrears','disRate','disAmount','postData','createTime',
				'salesId','uid','userName','accId','modifyTime','udf01','udf02','udf03'),$data,NULL);
			$this->db->trans_begin();
			$iid = $this->mysql_model->insert('invoice',$info);
			$this->invoice_info($iid,$data);
			$this->account_info($iid,$data);
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误或者提交的是空数据'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('新增销货 单据编号：'.$data['billNo']);
				str_alert(200,'success',array('id'=>intval($iid))); 
			}
		}
		str_alert(-1,'提交的是空数据'); 
    }
	
	//新增
	public function addNew(){
	    $this->add();
    }
	
	//修改
	public function updateInvSa(){
	    $this->common_model->checkpurview(8);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->validform((array)json_decode($data, true));
		    $info = elements(array(
				'billType','transType','transTypeName','buId','billDate','description','hxStateCode',
				'totalQty','amount','arrears','rpAmount','totalAmount','uid','userName',
				'totalArrears','disRate','disAmount','postData',
				'salesId','accId','modifyTime','udf01','udf02','udf03'),$data,NULL);
			$this->db->trans_begin();
			$this->mysql_model->update('invoice',$info,array('id'=>$data['id']));
			$this->invoice_info($data['id'],$data);
			$this->account_info($data['id'],$data);
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误或者提交的是空数据'); 
			} else {
			    $this->db->trans_commit(); 
				$this->common_model->logs('修改销货 单据编号：'.$data['billNo']);
				str_alert(200,'success',array('id'=>$data['id'])); 
			}
		}
		str_alert(-1,'提交的数据不为空'); 
    }
	
	//获取修改信息
	public function update() {
	    $this->common_model->checkpurview(6);
	    $id   = intval($this->input->get_post('id',TRUE));
		$data =  $this->data_model->get_invoice('a.id='.$id.' and a.billType="SALE"',1);
		if (count($data)>0) {
			$info['status'] = 200;
			$info['msg']    = 'success'; 
			$info['data']['id']                 = intval($data['id']);
			$info['data']['buId']               = intval($data['buId']);
			$info['data']['cLevel']             = 2;
			$info['data']['contactName']        = $data['contactName'];
			$info['data']['salesId']            = intval($data['salesId']);
			$info['data']['date']               = $data['billDate'];
			$info['data']['billNo']             = $data['billNo'];
			$info['data']['billType']           = $data['billType'];
			$info['data']['transType']          = intval($data['transType']);
			$info['data']['totalQty']           = (float)$data['totalQty'];
			$info['data']['modifyTime']         = $data['modifyTime'];
			$info['data']['createTime']         = $data['createTime'];
			$info['data']['checked']            = intval($data['checked']);
			$info['data']['checkName']          = $data['checkName'];
			$info['data']['disRate']            = (float)$data['disRate'];
			$info['data']['disAmount']          = (float)$data['disAmount'];
			$info['data']['amount']             = (float)abs($data['amount']);
			$info['data']['rpAmount']           = (float)abs($data['rpAmount']);
			$info['data']['customerFree']       = (float)$data['customerFree'];
			$info['data']['arrears']            = (float)abs($data['arrears']);
			$info['data']['userName']           = $data['userName'];
			$info['data']['status']             = intval($data['checked'])==1 ? 'view' : 'edit';  
			$info['data']['totalDiscount']      = (float)$data['totalDiscount'];
			$info['data']['totalAmount']        = (float)abs($data['totalAmount']); 
			$info['data']['description']        = $data['description']; 
			//add by michen 20170724 begin
			$info['data']['udf01']        = $data['udf01'];
			$info['data']['udf02']        = $data['udf02'];
			$info['data']['udf03']        = $data['udf03'];
			//add by michen 20170724 end
			
			$list = $this->data_model->get_invoice_info('a.iid='.$id.' order by a.id');  
			$arr = 0;
			foreach ($list as $arrkey=>$row) {
			    //add by michen 20170717 begin
			    if(isset($row['udf02'])&& $row['udf02'] == '1'){
                        $dopey = (array) json_decode($row['udf06'], true);
                        $v[$arr]['invSpec']           = $dopey['invSpec'];
                        $v[$arr]['taxRate']           = (float)$dopey['taxRate'];
                        $v[$arr]['srcOrderEntryId']   = intval($dopey['srcOrderEntryId']);
                        $v[$arr]['srcOrderNo']        = $dopey['srcOrderNo'];
                        $v[$arr]['srcOrderId']        = intval($dopey['srcOrderId']);
                        $v[$arr]['goods']             = $dopey['invNumber'].' '.$dopey['invName'].' '.$dopey['invSpec'];
                        $v[$arr]['invName']      = $dopey['invName'];
                        $v[$arr]['qty']          = (float)abs($dopey['qty']);
                        $v[$arr]['locationName'] = $dopey['locationName'];
                        $v[$arr]['amount']       = (float)abs($dopey['amount']);
                        $v[$arr]['taxAmount']    = (float)0;
                        $v[$arr]['price']        = (float)$dopey['price'];
                        $v[$arr]['tax']          = (float)0;
                        $v[$arr]['mainUnit']     = $dopey['mainUnit'];
                        $v[$arr]['deduction']    = (float)$dopey['deduction'];
                        $v[$arr]['invId']        = intval($dopey['invId']);
                        $v[$arr]['invNumber']    = $dopey['invNumber'];
                        $v[$arr]['locationId']   = intval($dopey['locationId']);
                        $v[$arr]['locationName'] = $dopey['locationName'];
                        $v[$arr]['discountRate'] = $dopey['discountRate'];
                        $v[$arr]['serialno']     = $dopey['serialno'];
                        $v[$arr]['description']  = $dopey['description'];
                        $v[$arr]['unitId']       = intval($dopey['unitId']);
                        $v[$arr]['mainUnit']     = $dopey['mainUnit'];
                        $arr++;
			    }
			    //add by michen 20170717 end
			    else if(empty($row['udf02'])){
    				$v[$arr]['invSpec']           = $row['invSpec'];
    				$v[$arr]['taxRate']           = (float)$row['taxRate'];
    				$v[$arr]['srcOrderEntryId']   = intval($row['srcOrderEntryId']);
    				$v[$arr]['srcOrderNo']        = $row['srcOrderNo'];
    				$v[$arr]['srcOrderId']        = intval($row['srcOrderId']);
    				$v[$arr]['goods']             = $row['invNumber'].' '.$row['invName'].' '.$row['invSpec'];
    				$v[$arr]['invName']      = $row['invName'];
    				$v[$arr]['qty']          = (float)abs($row['qty']);
    				$v[$arr]['locationName'] = $row['locationName'];
    				$v[$arr]['amount']       = (float)abs($row['amount']);
    				$v[$arr]['taxAmount']    = (float)$row['taxAmount'];
    				$v[$arr]['price']        = (float)$row['price'];
    				$v[$arr]['tax']          = (float)$row['tax'];
    				$v[$arr]['mainUnit']     = $row['mainUnit'];
    				$v[$arr]['deduction']    = (float)$row['deduction'];
    				$v[$arr]['invId']        = intval($row['invId']);
    				$v[$arr]['invNumber']    = $row['invNumber'];
    				$v[$arr]['locationId']   = intval($row['locationId']);
    				$v[$arr]['locationName'] = $row['locationName'];
    				$v[$arr]['discountRate'] = $row['discountRate'];
    				$v[$arr]['serialno']     = $row['serialno'];
    				$v[$arr]['description']  = $row['description'];
    				$v[$arr]['unitId']       = intval($row['unitId']);
    				$v[$arr]['mainUnit']     = $row['mainUnit'];
    				$arr++;
			    }
			}

			$info['data']['entries']     = isset($v) ? $v : array();
			$info['data']['accId']       = (float)$data['accId'];
			$accounts = $this->data_model->get_account_info('a.iid='.$id.' order by a.id');  
			foreach ($accounts as $arr=>$row) {
				$s[$arr]['invoiceId']     = intval($id);
				$s[$arr]['billNo']        = $row['billNo'];
				$s[$arr]['buId']          = intval($row['buId']);
			    $s[$arr]['billType']      = $row['billType'];
				$s[$arr]['transType']     = $row['transType'];
				$s[$arr]['transTypeName'] = $row['transTypeName'];
				$s[$arr]['billDate']      = $row['billDate']; 
			    $s[$arr]['accId']         = intval($row['accId']);
				$s[$arr]['account']       = $row['accountNumber'].' '.$row['accountName']; 
				$s[$arr]['payment']       = (float)abs($row['payment']); 
				$s[$arr]['wayId']         = (float)$row['wayId']; 
				$s[$arr]['way']           = $row['categoryName']; 
				$s[$arr]['settlement']    = $row['settlement']; 
		    }  
			$info['data']['accounts']     = isset($s) ? $s : array();
			die(json_encode($info));
		}
		str_alert(-1,'单据不存在、或者已删除');  
    }
	
	//单个审核   
	public function checkInvSa() {
	    $this->common_model->checkpurview(89);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
			$data = $this->validform((array)json_decode($data, true));
			$data['checked']         = 1;
			$data['checkName']       = $this->jxcsys['name']; 
			$info = elements(array(
				'billType','transType','transTypeName','buId','billDate','checked','checkName',
				'description','totalQty','amount','arrears','rpAmount','totalAmount','hxStateCode',
				'totalArrears','disRate','postData','disAmount','accId','modifyTime'),$data,NULL);
			$this->db->trans_begin();
			
			//特殊情况
			if ($data['id'] < 0) {
			    $info = elements(array(
						'billNo','billType','transType','transTypeName','buId','billDate','checked','checkName','hxStateCode',
						'description','totalQty','amount','arrears','rpAmount','totalAmount','srcOrderNo','srcOrderId',
						'totalArrears','disRate','disAmount','postData','createTime',
						'salesId','uid','userName','accId','modifyTime'),$data,NULL);
			    $iid = $this->mysql_model->insert('invoice',$info);
			    $this->invoice_info($iid,$data);
				$data['id'] = $iid;
			} else {
				$this->mysql_model->update('invoice',$info,array('id'=>$data['id']));
			    $this->invoice_info($data['id'],$data);
			}
			//变更状态
			if ($data['srcOrderId']>0) {
				$this->mysql_model->update('order',array('billStatus'=>2),array('id'=>$data['srcOrderId']));
			}
			if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误'); 
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('销货单据编号：'.$data['billNo'].'的单据已被审核！');
				str_alert(200,'success',array('id'=>$data['id'])); 
			}
		}
		str_alert(-1,'提交的数据不能为空'); 
    }
	
	//单个反审核
	public function revsCheckInvSa() {
	    $this->common_model->checkpurview(90);
	    $data = $this->input->post('postData',TRUE);
		if (strlen($data)>0) {
		    $data = $this->validform((array)json_decode($data, true)); 
		    //$this->mysql_model->get_count('verifica_info','(billId='.$data['id'].')')>0 && str_alert(-1,'存在关联收款单据，无法删除！请先在收款单中删除该销货单！');
			$sql = $this->mysql_model->update('invoice',array('checked'=>0,'checkName'=>''),array('id'=>$data['id']));
			if ($sql) {
			    //变更状态
				if ($data['srcOrderId']>0) {
				    $this->mysql_model->update('order',array('billStatus'=>0),array('id'=>$data['srcOrderId']));
				}
				$this->common_model->logs('购货单据编号：'.$data['billNo'].'的单据已被反审核！');
				str_alert(200,'success',array('id'=>$data['id'])); 
			}
			str_alert(-1,'SQL错误'); 
		}
		str_alert(-1,'提交的数据不能为空'); 
    }
	
	//批量审核
    public function batchCheckInvSa() {
	    $this->common_model->checkpurview(89);
	    $id   = str_enhtml($this->input->post('id',TRUE));
		$data = $this->mysql_model->get_results('invoice','(id in('.$id.')) and billType="SALE" and checked=0 and isDelete=0');  
		if (count($data)>0) {
			$sql = $this->mysql_model->update('invoice',array('checked'=>1,'checkName'=>$this->jxcsys['name']),'(id in('.$id.'))'); 
			if ($sql) {
				foreach($data as $arr=>$row) {
				    $billno[]     = $row['billNo'];
					$srcOrderId[] = $row['srcOrderId'];
				}
				$billno     = join(',',$billno);
				$srcOrderId = join(',',$srcOrderId);
				//变更状态
				if (strlen($srcOrderId)>0) {
				    $this->mysql_model->update('order',array('billStatus'=>2),'(id in('.$srcOrderId.'))');
				}
				$this->common_model->logs('销货单编号：'.$billno.'的单据已被审核！');
				str_alert(200,'销货单编号：'.$billno.'的单据已被审核！');
			} 
			str_alert(-1,'审核失败');  
		}
		str_alert(-1,'所选的单据都已被审核，请选择未审核的销货单进行审核！'); 
	}
	
	//批量反审核
    public function rsBatchCheckInvSa() {
	    $this->common_model->checkpurview(90);
	    $id   = str_enhtml($this->input->post('id',TRUE));
	    $this->mysql_model->get_count('verifica_info','(billId='.$id.')')>0 && str_alert(-1,'存在关联“收款单据”，无法删除！请先在“收款单”中删除该销货单！');//add
		$data = $this->mysql_model->get_results('invoice','(id in('.$id.')) and billType="SALE" and checked=1 and (isDelete=0)');   
		if (count($data)>0) {
			$sql = $this->mysql_model->update('invoice',array('checked'=>0,'checkName'=>''),'(id in('.$id.'))'); 
			if ($sql) {
				foreach($data as $arr=>$row) {
				    $billno[]     = $row['billNo'];
					$srcOrderId[] = $row['srcOrderId'];
				}
				$billno     = join(',',$billno);
				$srcOrderId = join(',',$srcOrderId);
				//变更状态
				if (strlen($srcOrderId)>0) {
				    $this->mysql_model->update('order',array('billStatus'=>0),'(id in('.$srcOrderId.'))');
				}
				$this->common_model->logs('销货单：'.$billno.'的单据已被反审核！');
				str_alert(200,'销货单编号：'.$billno.'的单据已被反审核！'); 
			} 
			str_alert(-1,'反审核失败');  
		}
		str_alert(-1,'所选的销货单都是未审核，请选择已审核的销货单进行反审核！'); 
	}
	
	
	//打印
    public function toPdf() {
	    $this->common_model->checkpurview(88);
	    $id   = intval($this->input->get('id',TRUE));
		$data = $this->data_model->get_invoice('a.id='.$id.' and a.billType="SALE"',1);  
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
				$v[$arr]['locationName']    = $row['locationName'];
				$v[$arr]['description']     = $row['description'];
			}  
			$data['countpage']  = ceil(count($postData['entries'])/$data['num']); ;   
			$data['list']       = isset($v) ? $v : array();  
		    ob_start();
			$this->load->view('scm/invSa/toPdf',$data);
			$content = ob_get_clean();
			require_once('./application/libraries/html2pdf/html2pdf.php');
			try {
			    $html2pdf = new HTML2PDF('P', 'A4', 'en');
				$html2pdf->setDefaultFont('javiergb');
				$html2pdf->pdf->SetDisplayMode('fullpage');
				$html2pdf->writeHTML($content, '');
				$html2pdf->Output('invSa_'.date('ymdHis').'.pdf');
			}catch(HTML2PDF_exception $e) {
				echo $e;
				exit;
			}  	  
		} 
		str_alert(-1,'单据不存在、或者已删除');  	   
	}
	
	
	//删除 
    public function delete() {
	    $this->common_model->checkpurview(9);
	    $id   = intval($this->input->get('id',TRUE));
		$data = $this->mysql_model->get_rows('invoice',array('id'=>$id,'billType'=>'SALE'));  
		if (count($data)>0) {
		    $data['checked'] >0 && str_alert(-1,'已审核的不可删除'); 
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
	
  
	//库存查询
	public function justIntimeInv() {
		$qty = 0;
		$page  = max(intval($this->input->get_post('page',TRUE)),1);
		$rows  = max(intval($this->input->get_post('rows',TRUE)),100);
		$invid = intval($this->input->get_post('invId',TRUE));
		$where = 'a.isDelete=0';
		$where .= $invid > 0 ? ' and a.invId='.$invid.'' : ''; 
		$list = $this->data_model->get_inventory($where.' GROUP BY locationId');    
		foreach ($list as $arr=>$row) {
		    $i = $arr + 1;
			$v[$arr]['locationId']   = intval($row['locationId']);
			$qty += $v[$arr]['qty']  = (float)$row['qty'];
			$v[$arr]['locationName'] = $row['locationName'];
			$v[$arr]['invId']        = $row['invId'];
		}
		$v[$i]['locationId']   = 0;
		$v[$i]['qty']          = $qty;
		$v[$i]['locationName'] = '合计';
		$v[$i]['invId']        = 0;
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['total']     = 1;                         
		$json['data']['records']   = $this->data_model->get_inventory($where.' GROUP BY locationId',3);    
		$json['data']['rows']      = isset($v) ? $v : array();
		die(json_encode($json));
	}
	

	public function findNearSaEmp() {
		die('{"status":200,"msg":"success","data":{"empId":0}}');
		
	}
	
	//公共验证
	private function validform($data) {
	    $data['id']              = isset($data['id']) ? intval($data['id']) : 0;
		$data['buId']            = intval($data['buId']);
		$data['accId']           = intval($data['accId']);
		$data['salesId']         = intval($data['salesId']);
		$data['transType']       = intval($data['transType']);
		$data['amount']          = (float)$data['amount'];
		$data['arrears']         = (float)$data['arrears'];
		$data['disRate']         = (float)$data['disRate'];
		$data['disAmount']       = (float)$data['disAmount'];
		$data['rpAmount']        = (float)$data['rpAmount'];
		$data['totalQty']        = (float)$data['totalQty'];
		$data['totalArrears']    = isset($data['totalArrears']) ?(float)$data['totalArrears']:0;
		$data['totalDiscount']   = isset($data['totalDiscount']) ? (float)$data['totalDiscount']:0;
		$data['customerFree']    = isset($data['customerFree']) ? (float)$data['customerFree']:0;
		$data['billType']        = 'SALE';
		$data['billDate']        = $data['date'];
		$data['transTypeName']   = $data['transType']==150601 ? '销货' : '销退';
		$data['serialno']        = $data['serialno'];
		$data['description']     = $data['description'];
		$data['totalTax']        = isset($data['totalTax']) ? (float)$data['totalTax'] :0;
		$data['totalTaxAmount']  = isset($data['totalTaxAmount']) ? (float)$data['totalTaxAmount'] :0; 	
		
		$data['arrears'] < 0 && str_alert(-1,'本次欠款要为数字，请输入有效数字！'); 
		$data['disRate'] < 0 && str_alert(-1,'折扣率要为数字，请输入有效数字！'); 
		$data['rpAmount'] < 0  && str_alert(-1,'本次收款要为数字，请输入有效数字！'); 
		$data['customerFree'] < 0 && str_alert(-1,'客户承担费用要为数字，请输入有效数字！'); 
		$data['amount'] < $data['rpAmount']  && str_alert(-1,'本次收款不能大于折后金额！'); 
		$data['amount'] < $data['disAmount'] && str_alert(-1,'折扣额不能大于合计金额！'); 
		
		if ($data['amount']==$data['rpAmount']) {
			$data['hxStateCode'] = 2;
		} else {	
		    $data['hxStateCode'] = $data['rpAmount']!=0 ? 1 : 0;
		}

		$data['amount']          = $data['transType']==150601 ? abs($data['amount']) : -abs($data['amount']);
		$data['arrears']         = $data['transType']==150601 ? abs($data['arrears']) : -abs($data['arrears']);
		$data['rpAmount']        = $data['transType']==150601 ? abs($data['rpAmount']) : -abs($data['rpAmount']);
		$data['totalAmount']     = $data['transType']==150601 ? abs($data['totalAmount']) : -abs($data['totalAmount']);
		$data['uid']             = $this->jxcsys['uid'];
		$data['userName']        = $this->jxcsys['name'];  
		$data['modifyTime']      = date('Y-m-d H:i:s');
		$data['createTime']      = $data['modifyTime'];
		$data['accounts']        = isset($data['accounts']) ? $data['accounts'] : array();
		$data['entries']         = isset($data['entries']) ? $data['entries'] : array();
		
		count($data['entries']) < 1 && str_alert(-1,'提交的是空数据'); 
	    
		
		//选择了结算账户 需要验证 
		foreach ($data['accounts'] as $arr=>$row) {
			(float)$row['payment'] < 0 && str_alert(-1,'结算金额要为数字，请输入有效数字！');
		}  

	    if ($data['id']>0) {
		    $invoice = $this->mysql_model->get_rows('invoice',array('id'=>$data['id'],'billType'=>'SALE','isDelete'=>0)); 
			count($invoice)<1 && str_alert(-1,'单据不存在、或者已删除');
			$data['checked'] = $invoice['checked'];	
			$data['billNo']  = $invoice['billNo'];	
		} else {
		    $data['billNo']  = str_no('XS');    
		}
		
		//供应商验证
		$this->mysql_model->get_count('contact',array('id'=>$data['buId']))<1 && str_alert(-1,'客户不存在'); 
			
		//商品录入验证
		$system    = $this->common_model->get_option('system'); 
		
		//库存验证
		if ($system['requiredCheckStore']==1) {
		    $inventory = $this->data_model->get_invoice_info_inventory();
		}
		
		$storage   = array_column($this->mysql_model->get_results('storage',array('disable'=>0)),'id'); 
		foreach ($data['entries'] as $arr=>$row) {
			intval($row['invId'])<1 && str_alert(-1,'请选择商品');    
			(float)$row['qty'] < 0 && str_alert(-1,'商品数量要为数字，请输入有效数字！'); 
			(float)$row['price'] < 0 && str_alert(-1,'商品销售单价要为数字，请输入有效数字！'); 
			(float)$row['discountRate'] < 0 && str_alert(-1,'折扣率要为数字，请输入有效数字！');
			intval($row['locationId']) < 1 && str_alert(-1,'请选择相应的仓库！'); 
			!in_array($row['locationId'],$storage) && str_alert(-1,$row['locationName'].'不存在或不可用！');	
			//库存判断 修改不验证
			if ($system['requiredCheckStore']==1 && $data['id']<1) {  
				 if (intval($data['transType'])==150601) {                        //销售才验证 
					if (isset($inventory[$row['invId']][$row['locationId']])) {
					    
						$inventory[$row['invId']][$row['locationId']] < $row['qty'] && str_alert(-1,$row['locationName'].$row['invName'].'商品库存不足！'); 
					} else {
					    //str_alert(-1,$row['invName'].'库存不足！');
					    //add by michen 20170719 for 组合品库存检查
					    $gooddata = $this->mysql_model->get_results('goods','(id ='.$row['invId'].') and (isDelete=0)');
					    if(count($gooddata)>0){
					        $dopey = reset($gooddata);
					        if($dopey['dopey'] != 1){
					            str_alert(-1,'商品'.$row['invName'].'库存不足！');
					        }else{
					            $sonlist = (array)json_decode($dopey['sonGoods'],true) ;
					            if(count($sonlist)>0){
    					            foreach ($sonlist as $sonkey=> $sonrow){
    					                if($inventory[$sonrow['gid']][$row['locationId']] < $row['qty']*$sonrow['qty'])
    					                   str_alert(-1,'商品“'.$row['invName'].'”的子商品“'.$sonrow['name'].'”库存不足！');
    					            }
					            }else{
					                str_alert(-1,'商品“'.$row['invName'].'”的子商品“'.$sonrow['name'].'”丢失，请检查！');
					            }
					        }
					    }else{
					        str_alert(-1,'商品“'.$row['invName'].'”不存在！');
					    }
					}
				}
			}
		} 
		$data['srcOrderNo'] = $data['entries'][0]['srcOrderNo'] ? $data['entries'][0]['srcOrderNo'] : 0; 
		$data['srcOrderId'] = $data['entries'][0]['srcOrderId'] ? $data['entries'][0]['srcOrderId'] : 0; 
		$data['postData'] = serialize($data);
		return $data;
	}  
	

	//组装数据
	private function invoice_info($iid,$data) {
	    $i = 1;
		foreach ($data['entries'] as $arr=>$row) {
			$v[$arr]['iid']           = $iid;
			$v[$arr]['uid']           = $data['uid'];
			$v[$arr]['billNo']        = $data['billNo'];
			$v[$arr]['billDate']      = $data['billDate']; 
			$v[$arr]['buId']          = $data['buId'];
			$v[$arr]['transType']     = $data['transType'];
			$v[$arr]['transTypeName'] = $data['transTypeName'];
			$v[$arr]['billType']      = $data['billType'];
			$v[$arr]['salesId']       = $data['salesId'];
			$v[$arr]['invId']         = intval($row['invId']);
			$v[$arr]['skuId']         = intval($row['skuId']);
			$v[$arr]['unitId']        = intval($row['unitId']);
			$v[$arr]['locationId']    = intval($row['locationId']);
			$v[$arr]['qty']           = $data['transType']==150601 ? -abs($row['qty']) :abs($row['qty']); 
			$v[$arr]['amount']        = $data['transType']==150601 ? abs($row['amount']) :-abs($row['amount']); 
			$v[$arr]['price']         = abs($row['price']);  
			$v[$arr]['discountRate']  = $row['discountRate'];  
			$v[$arr]['deduction']     = $row['deduction'];  
			$v[$arr]['serialno']      = $row['serialno'];
			$v[$arr]['description']   = $row['description']; 
			if (intval($row['srcOrderId'])>0) {   
			    $v[$arr]['srcOrderEntryId']  = intval($row['srcOrderEntryId']);  
				$v[$arr]['srcOrderId']       = intval($row['srcOrderId']);  
				$v[$arr]['srcOrderNo']       = $row['srcOrderNo']; 
			} else {
			    $v[$arr]['srcOrderEntryId']  = 0;  
				$v[$arr]['srcOrderId']       = 0;  
				$v[$arr]['srcOrderNo']       = ''; 
			}
			$v[$arr]['srcDopey'] = '';
			$v[$arr]['srcDopeyName'] = '';
			$v[$arr]['udf01'] = '';
			$v[$arr]['udf02'] = '';
			$v[$arr]['udf06'] = '';
			//add by michen 20170717 begin
			$srcGood = $v[$arr];
			$srcGood['invName'] = $row['invName'];
			$srcGood['invNumber'] = $row['invNumber'];
			$srcGood['invSpec'] = $row['invSpec'];
			$srcGood['mainUnit'] = $row['mainUnit'];
			$srcGood['locationId'] = $row['locationId'];
			$srcGood['locationName'] = $row['locationName'];
			$udf06 = json_encode($srcGood);
			$goods = $this->mysql_model->get_results('goods','(id ='.$row['invId'].') and (isDelete=0)');
			if (count($goods) > 0 ) {
			    $good = reset($goods);//$good = $goods[0];
			    if($good['dopey']==1){
			        $songoods = (array)json_decode($good['sonGoods'],true);
			        if(count($songoods)>0){
			            $j = 1;
			            foreach ($songoods as $sonarr=>$sonrow) {
			                if($j == 1){
			                    $v[$arr]['invId'] = intval($sonrow['gid']);
			                    $tmpqty = intval($sonrow['qty'])*intval($row['qty']);
			                    $v[$arr]['qty'] = $data['transType']==150601 ? -abs($tmpqty) :abs($tmpqty);
		                        $v[$arr]['price'] = intval($row['amount'])/($tmpqty);
		                        $v[$arr]['amount'] = $data['transType']==150601 ? abs($row['amount']) :-abs($row['amount']);
			                    $v[$arr]['srcDopey'] = $row['invNumber'];
			                    $v[$arr]['srcDopeyName'] = $row['invName'];
			                    $v[$arr]['udf01'] = $i;
			                    $v[$arr]['udf02'] = $j;
			                    $v[$arr]['udf06'] = $udf06;
			                }else{
    			                $v[$arr.$j]['iid']           = $iid;
    			                $v[$arr.$j]['uid']           = $data['uid'];
    			                $v[$arr.$j]['billNo']        = $data['billNo'];
    			                $v[$arr.$j]['billDate']      = $data['billDate'];
    			                $v[$arr.$j]['buId']          = $data['buId'];
    			                $v[$arr.$j]['transType']     = $data['transType'];
    			                $v[$arr.$j]['transTypeName'] = $data['transTypeName'];
    			                $v[$arr.$j]['billType']      = $data['billType'];
    			                $v[$arr.$j]['salesId']       = $data['salesId'];
    			                //$v[$arr.$j]['invId']         = intval($sonrow['invId']);
    			                $v[$arr.$j]['skuId']         = intval($row['skuId']);
    			                $v[$arr.$j]['unitId']        = intval($row['unitId']);
    			                $v[$arr.$j]['locationId']    = intval($row['locationId']);
    			                //$v[$arr.$j]['qty']           = $data['transType']==150601 ? -abs($sonrow['qty']) :abs($sonrow['qty']);
    			                //$v[$arr.$j]['amount']        = $data['transType']==150601 ? abs($sonrow['amount']) :-abs($sonrow['amount']);
    			               // $v[$arr.$j]['price']         = abs($sonrow['price']);
    			                $v[$arr.$j]['discountRate']  = $row['discountRate'];
    			                $v[$arr.$j]['deduction']     = $row['deduction'];
    			                $v[$arr.$j]['serialno']      = $row['serialno'];
    			                $v[$arr.$j]['description']   = $row['description'];
    			                if (intval($row['srcOrderId'])>0) {
    			                    $v[$arr.$j]['srcOrderEntryId']  = intval($row['srcOrderEntryId']);
    			                    $v[$arr.$j]['srcOrderId']       = intval($row['srcOrderId']);
    			                    $v[$arr.$j]['srcOrderNo']       = $row['srcOrderNo'];
    			                } else {
    			                    $v[$arr.$j]['srcOrderEntryId']  = 0;
    			                    $v[$arr.$j]['srcOrderId']       = 0;
    			                    $v[$arr.$j]['srcOrderNo']       = '';
    			                }
    			                $v[$arr.$j]['invId'] = intval($sonrow['gid']);
    			                $tmpqty = intval($sonrow['qty'])*intval($row['qty']);
    			                $v[$arr.$j]['qty'] = $data['transType']==150601 ? -abs($tmpqty) :abs($tmpqty);
    			                $v[$arr.$j]['price'] = 0;
    			                $v[$arr.$j]['amount'] = 0;
    			                $v[$arr.$j]['srcDopey'] = $row['invNumber'];
    			                $v[$arr.$j]['srcDopeyName'] = $row['invName'];
    			                $v[$arr.$j]['udf01'] = $i;
    			                $v[$arr.$j]['udf02'] = $j;
    			                $v[$arr.$j]['udf06'] = $udf06;
			                }
			                $j++;
			            }
			        }
			    }
			}
			$i++;
			//add by michen 20170717  end
		} 
		if (isset($v)) {
			if ($data['id']>0) {                   
				$this->mysql_model->delete('invoice_info',array('iid'=>$iid));
			}
			$this->mysql_model->insert('invoice_info',$v);
		} 
	}
	
	//组装数据
	private function account_info($iid,$data) {
		foreach ($data['accounts'] as $arr=>$row) {
			$v[$arr]['iid']           = intval($iid);
			$v[$arr]['billNo']        = $data['billNo'];
			$v[$arr]['buId']          = $data['buId'];
			$v[$arr]['billType']      = $data['billType'];
			$v[$arr]['transType']     = $data['transType'];
			$v[$arr]['transTypeName'] = $data['transType']==150601 ? '普通销售' : '销售退回';
			$v[$arr]['billDate']      = $data['billDate']; 
			$v[$arr]['accId']         = $row['accId']; 
			$v[$arr]['payment']       = $data['transType']==150601 ? abs($row['payment']) : -abs($row['payment']); 
			$v[$arr]['wayId']         = $row['wayId'];
			$v[$arr]['settlement']    = $row['settlement'] ;
			$v[$arr]['uid']           = $data['uid'];
		} 
		if ($data['id']>0) {                      
			$this->mysql_model->delete('account_info',array('iid'=>$iid));
		}
		if (isset($v)) {
			$this->mysql_model->insert('account_info',$v);
		}
	}
	
	public function log($msg){
	    //$this->log(var_export($v,true));
	    $myfile = fopen("log.txt", "a") or die("Unable to open file!");//w
	    fwrite($myfile, "----------------------------------------------------------\r\n");
	    fwrite($myfile, $msg);
	    fclose($myfile);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */