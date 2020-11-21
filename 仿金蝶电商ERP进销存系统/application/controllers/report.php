<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
		$this->jxcsys    = $this->session->userdata('jxcsys');
		$this->systems   = $this->common_model->get_option('system');  
    }
	
	public function index() {
	    $profit = $this->data_model->get_profit('and billDate<="'.date('Y-m-d').'"'); 
	
		$inventory1  = $inventory2 = 0;
		$list   = $this->data_model->get_invBalance('a.isDelete=0 and a.billDate<="'.date('Y-m-d').'" '.$this->common_model->get_location_purview().' group by a.invId,a.locationId'); 
		foreach ($list as $arr=>$row) {
			$price = isset($profit['inprice'][$row['invId']][$row['locationId']]) ? $profit['inprice'][$row['invId']][$row['locationId']] : 0;
			$inventory1 += $row['qty']; 
			$inventory2 += $row['qty'] * $price;
		}
		$inventory1 = round($inventory1,$this->systems['qtyPlaces']); 
		$inventory2 = round($inventory2,2); 
	
		$fund1 = $fund2 = 0;
	    $list = $this->data_model->get_account($this->common_model->get_admin_purview(1),'a.isDelete=0');
		foreach ($list as $arr=>$row) {
		    if ($row['type']==1) {
			    $fund1 += $row['amount'];
			} else {
			    $fund2 += $row['amount'];
			} 
		}
		$fund1 = round($fund1,2); 
		$fund2 = round($fund2,2); 
		
		$contact1 = $contact2 = 0;
		$list = $this->data_model->get_contact($this->common_model->get_contact_purview(),'a.isDelete=0');
		foreach ($list as $arr=>$row) {
		    if ($row['type']==-10) {
			    $contact1 += $row['amount']; 
			} elseif ($row['type']==10) {
			    $contact2 += $row['amount']; 
			} else {	
			    $contact1 = 0; 
		        $contact2 = 0; 
			}
		}
		$contact1 = round($contact1,2); 
		$contact2 = round($contact2,2); 

		$list = $this->data_model->get_invoice_infosum('a.isDelete=0 and a.billType="PUR" and billDate>="'.date('Y-m-1').'" and billDate<="'.date('Y-m-d').'" '.$this->common_model->get_location_purview().' group by a.invId,a.locationId');
		$purchase1 = 0;
		foreach ($list as $arr=>$row) {
			$purchase1 += $row['sumamount']; 
		}
		$purchase2 = count($list);
		$purchase1 = round($purchase1,2); 
		$purchase2 = round($purchase2,$this->systems['qtyPlaces']); 
		
		$sales1 = $sales2 = 0;   
		$list   = $this->data_model->get_invoice_infosum('a.isDelete=0 and billType="SALE" and billDate>="'.date('Y-m-1').'" and billDate<="'.date('Y-m-d').'" '.$this->common_model->get_location_purview().' group by a.invId,a.locationId'); 
		foreach ($list as $arr=>$row) {
		    $qty = $row['sumqty']>0 ? -abs($row['sumqty']):abs($row['sumqty']);    
			$amount = $row['sumamount'];                  
			$price = isset($profit['inprice'][$row['invId']][$row['locationId']]) ? $profit['inprice'][$row['invId']][$row['locationId']] : 0;
			$cost = $price * $qty;                     
			$saleProfit = $amount - $cost;               
			$sales1 += $amount;                         
			$sales2 += $saleProfit;                     
		}
		$sales1 = round($sales1,2); 
		$sales2 = round($sales2,2); 
		$data['status'] = 200;
		$data['msg']    = 'success';
		$data['data']['items'] =  array(
									array('mod'=>'inventory','total1'=>$inventory1,'total2'=>$inventory2),
									array('mod'=>'fund','total1'=>$fund1,'total2'=>$fund2),
									array('mod'=>'contact','total1'=>$contact1,'total2'=>$contact2),
									array('mod'=>'sales','total1'=>$sales1,'total2'=>$sales2),
									array('mod'=>'purchase','total1'=>$purchase1,'total2'=>$purchase2)
		);
		$data['totalsize'] = 5;
		die(json_encode($data));
	}
	
	 
    
	public function pu_detail_new() {
	    $this->common_model->checkpurview(22);
		$data['beginDate']  = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = str_enhtml($this->input->get_post('endDate',TRUE));
		$this->load->view('report/pu-detail-new',$data);	
	}
	

	public function puDetail_detail() {
	    $this->common_model->checkpurview(22);
		$sum1 = $sum2 = $sum3 = 0;
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100); 
	    $storageNo  = str_enhtml($this->input->get_post('storageNo',TRUE));
		$customerNo = str_enhtml($this->input->get_post('customerNo',TRUE));
		$goodsNo    = str_enhtml($this->input->get_post('goodsNo',TRUE));
		$beginDate  = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate    = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0 and a.billType="PUR"';
		$where .= $storageNo ? ' and d.locationNo in('.str_quote($storageNo).')' : ''; 
		$where .= $customerNo ? ' and c.number in('.str_quote($customerNo).')' : ''; 
		$where .= $goodsNo ? ' and b.number in('.str_quote($goodsNo).')' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_admin_purview();
		$where .= $this->common_model->get_location_purview();
		$list   = $this->data_model->get_invoice_info($where.' order by a.billDate,a.id'); 
		foreach ($list as $arr=>$row) {
			$v[$arr]['billId']        = intval($row['iid']);
		    $v[$arr]['billNo']        = $row['billNo'];
			$v[$arr]['billType']      = $row['billType']; 
			$v[$arr]['date']          = $row['billDate']; 
			$v[$arr]['buId']          = intval($row['buId']);
			$v[$arr]['buName']        = $row['contactName'];
			$v[$arr]['invNo']         = $row['invNumber'];  
			$v[$arr]['invName']       = $row['invName'];   
			$v[$arr]['spec']          = $row['invSpec']; 
			$v[$arr]['unit']          = $row['mainUnit']; 
			$v[$arr]['location']      = $row['locationName']; 
			$v[$arr]['description']   = $row['description']; 
			$v[$arr]['baseQty']       = 0; 
			$v[$arr]['skuId']         = 0; 
			$v[$arr]['cost']          = 0;
			$v[$arr]['unitCost']      = 0;
			$v[$arr]['transType']     = $row['transTypeName'];
			$sum1 += $v[$arr]['qty']        = (float)$row['qty']; 
			$sum2 += $v[$arr]['unitPrice']  = (float)$row['price'];
		    $sum3 += $v[$arr]['amount']     = (float)$row['amount']; 
		}
		$data['status'] = 200;
		$data['msg']    = 'success';
		$data['data']['list']      = isset($v) ? $v :array();
		$data['data']['total']['amount']      = '';
		$data['data']['total']['baseQty']     = 'PUR';
		$data['data']['total']['billId']      = '';
		$data['data']['total']['billNo']      = '';
		$data['data']['total']['billType']    = '';
		$data['data']['total']['buName']      = '';
		$data['data']['total']['buNo']        = '';
		$data['data']['total']['date']        = '';
		$data['data']['total']['invName']     = '';
		$data['data']['total']['location']    = '';
		$data['data']['total']['locationNo']  = '';
		$data['data']['total']['spec']        = '';
		$data['data']['total']['unit']        = '';
		$data['data']['total']['transType']   = '';
		$data['data']['total']['skuId']       = '';
		$data['data']['total']['qty']         = $sum1;
		$data['data']['total']['unitPrice']   = $sum1>0 ? $sum3/$sum1 : 0;
		$data['data']['total']['amount']      = $sum3;
		$data['data']['total']['cost']        = '';
		$data['data']['total']['unitCost']    = '';
		die(json_encode($data));
	}

	public function puDetail_detailExporter() {
	    $this->common_model->checkpurview(23);
		$name = 'pu_detail_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('采购明细表导出:'.$name);
		$storageNo  = str_enhtml($this->input->get_post('storageNo',TRUE));
		$customerNo = str_enhtml($this->input->get_post('customerNo',TRUE));
		$goodsNo    = str_enhtml($this->input->get_post('goodsNo',TRUE));
		$data['beginDate']  = $beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = $endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0 and a.billType="PUR"';
		$where .= $storageNo ? ' and d.locationNo in('.str_quote($storageNo).')' : ''; 
		$where .= $customerNo ? ' and c.number in('.str_quote($customerNo).')' : ''; 
		$where .= $goodsNo ? ' and b.number in('.str_quote($goodsNo).')' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_admin_purview();
		$where .= $this->common_model->get_location_purview();
		$data['list'] = $this->data_model->get_invoice_info($where.' order by a.billDate,a.id'); 
		$this->load->view('report/puDetail-detailExporter',$data);	
	}
	
	public function pu_summary_new() {
	    $this->common_model->checkpurview(25);
		$data['beginDate']  = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = str_enhtml($this->input->get_post('endDate',TRUE));
		$this->load->view('report/pu-summary-new',$data);	
	}
	

	public function puDetail_inv() {
	    $this->common_model->checkpurview(25);
		$sum1 = $sum2 = $sum3 = 0;
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100); 
	    $storageNo  = str_enhtml($this->input->get_post('storageNo',TRUE));
		$customerNo = str_enhtml($this->input->get_post('customerNo',TRUE));
		$goodsNo    = str_enhtml($this->input->get_post('goodsNo',TRUE));
		$beginDate  = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate    = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0 and a.billType="PUR"';
		$where .= $storageNo ? ' and d.locationNo in('.str_quote($storageNo).')' : ''; 
		$where .= $customerNo ? ' and c.number in('.str_quote($customerNo).')' : ''; 
		$where .= $goodsNo ? ' and b.number in('.str_quote($goodsNo).')' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_location_purview();
		$list   = $this->data_model->get_invoice_infosum($where.' group by a.invId, a.locationId'); 
		foreach ($list as $arr=>$row) {
			$v[$arr]['billId']        = intval($row['iid']);
		    $v[$arr]['billNo']        = $row['billNo'];
			$v[$arr]['billType']      = $row['billType']; 
			$v[$arr]['date']          = $row['billDate']; 
			$v[$arr]['buId']          = intval($row['buId']);
			$v[$arr]['buName']        = $row['contactName'];
			$v[$arr]['invNo']         = $row['invNumber'];  
			$v[$arr]['invName']       = $row['invName'];   
			$v[$arr]['spec']          = $row['invSpec']; 
			$v[$arr]['unit']          = $row['mainUnit']; 
			$v[$arr]['location']      = $row['locationName']; 
			$v[$arr]['baseQty']       = 0; 
			$v[$arr]['skuId']         = 0; 
			$v[$arr]['cost']          = 0;
			$v[$arr]['unitCost']      = 0;
			$v[$arr]['transType']     = $row['transTypeName'];
			$sum1 += $v[$arr]['qty']        = (float)$row['sumqty']; 
			$sum2 += $v[$arr]['unitPrice']  = (float)$row['sumqty']!=0 ? (float)abs($row['sumamount']/$row['sumqty']) : 0;
		    $sum3 += $v[$arr]['amount']     = (float)$row['sumamount']; 
		}
		$data['status'] = 200;
		$data['msg']    = 'success';
		$data['data']['list']      = isset($v) ? $v :array();
		$data['data']['total']['amount']      = '';
		$data['data']['total']['baseQty']     = 'PUR';
		$data['data']['total']['billId']      = '';
		$data['data']['total']['billNo']      = '';
		$data['data']['total']['billType']    = '';
		$data['data']['total']['buName']      = '';
		$data['data']['total']['buNo']        = '';
		$data['data']['total']['date']        = '';
		$data['data']['total']['invName']     = '';
		$data['data']['total']['location']    = '';
		$data['data']['total']['locationNo']  = '';
		$data['data']['total']['spec']        = '';
		$data['data']['total']['unit']        = '';
		$data['data']['total']['transType']   = '';
		$data['data']['total']['skuId']       = '';
		$data['data']['total']['qty']         = $sum1;
		$data['data']['total']['unitPrice']   = $sum1!=0 ? abs($sum3/$sum1) : 0;
		$data['data']['total']['amount']      = $sum3;
		$data['data']['total']['cost']        = '';
		$data['data']['total']['unitCost']    = '';
		die(json_encode($data)); 
	}
	

	public function puDetail_invExporter() {
	    $this->common_model->checkpurview(26);
		$name = 'pu_summary_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('采购明细表(按商品)导出:'.$name);
		$storageNo  = str_enhtml($this->input->get_post('storageNo',TRUE));
		$customerNo = str_enhtml($this->input->get_post('customerNo',TRUE));
		$goodsNo    = str_enhtml($this->input->get_post('goodsNo',TRUE));
		$data['beginDate']  = $beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = $endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0 and a.billType="PUR"';
		$where .= $storageNo ? ' and d.locationNo in('.str_quote($storageNo).')' : ''; 
		$where .= $customerNo ? ' and c.number in('.str_quote($customerNo).')' : ''; 
		$where .= $goodsNo ? ' and b.number in('.str_quote($goodsNo).')' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_location_purview();
		$data['list'] = $this->data_model->get_invoice_infosum($where.' group by a.invId, a.locationId'); 
		$this->load->view('report/puDetail-invExporter',$data);	
	}
	

	public function pu_summary_supply_new() {
	    $this->common_model->checkpurview(28);
		$data['beginDate']  = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = str_enhtml($this->input->get_post('endDate',TRUE));
		$this->load->view('report/pu-summary-supply-new',$data);	
	}
	
	

	public function puDetail_supply() {
	    $this->common_model->checkpurview(28);
		$sum1 = $sum2 = $sum3 = 0;
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100); 
	    $storageNo  = str_enhtml($this->input->get_post('storageNo',TRUE));
		$customerNo = str_enhtml($this->input->get_post('customerNo',TRUE));
		$goodsNo    = str_enhtml($this->input->get_post('goodsNo',TRUE));
		$beginDate  = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate    = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0 and a.billType="PUR"';
		$where .= $storageNo ? ' and d.locationNo in('.str_quote($storageNo).')' : ''; 
		$where .= $customerNo ? ' and c.number in('.str_quote($customerNo).')' : ''; 
		$where .= $goodsNo ? ' and b.number in('.str_quote($goodsNo).')' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_location_purview();
		$list   = $this->data_model->get_invoice_infosum($where.' group by a.buId,a.invId, a.locationId');  
		foreach ($list as $arr=>$row) {
			$v[$arr]['billId']        = intval($row['iid']);
		    $v[$arr]['billNo']        = $row['billNo'];
			$v[$arr]['billType']      = $row['billType']; 
			$v[$arr]['date']          = $row['billDate']; 
			$v[$arr]['buId']          = intval($row['buId']);
			$v[$arr]['buName']        = $row['contactName'];
			$v[$arr]['invNo']         = $row['invNumber'];  
			$v[$arr]['invName']       = $row['invName'];   
			$v[$arr]['spec']          = $row['invSpec']; 
			$v[$arr]['unit']          = $row['mainUnit']; 
			$v[$arr]['location']      = $row['locationName']; 
			$v[$arr]['baseQty']       = 0; 
			$v[$arr]['skuId']         = 0; 
			$v[$arr]['cost']          = 0;
			$v[$arr]['unitCost']      = 0;
			$v[$arr]['transType']     = $row['transTypeName'];
			$sum1 += $v[$arr]['qty']        = (float)$row['sumqty']; 
			$sum2 += $v[$arr]['unitPrice']  = (float)$row['sumqty']!=0 ? (float)abs($row['sumamount']/$row['sumqty']) : 0;
		    $sum3 += $v[$arr]['amount']     = (float)$row['amount']; 
		}
		$data['status'] = 200;
		$data['msg']    = 'success';
		$data['data']['list']      = isset($v) ? $v :array();
		$data['data']['total']['amount']      = '';
		$data['data']['total']['baseQty']     = 'PUR';
		$data['data']['total']['billId']      = '';
		$data['data']['total']['billNo']      = '';
		$data['data']['total']['billType']    = '';
		$data['data']['total']['buName']      = '';
		$data['data']['total']['buNo']        = '';
		$data['data']['total']['date']        = '';
		$data['data']['total']['invName']     = '';
		$data['data']['total']['location']    = '';
		$data['data']['total']['locationNo']  = '';
		$data['data']['total']['spec']        = '';
		$data['data']['total']['unit']        = '';
		$data['data']['total']['transType']   = '';
		$data['data']['total']['skuId']       = '';
		$data['data']['total']['qty']         = $sum1;
		$data['data']['total']['unitPrice']   = $sum1!=0 ? abs($sum3/$sum1) : 0;
		$data['data']['total']['amount']      = $sum3;
		$data['data']['total']['cost']        = '';
		$data['data']['total']['unitCost']    = '';
		die(json_encode($data)); 
	}
	
	

	public function puDetail_supplyExporter() {
	    $this->common_model->checkpurview(29);
		$name = 'pu_supply_summary_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('采购明细表(按供应商)导出:'.$name);
		$storageNo  = str_enhtml($this->input->get_post('storageNo',TRUE));
		$customerNo = str_enhtml($this->input->get_post('customerNo',TRUE));
		$goodsNo    = str_enhtml($this->input->get_post('goodsNo',TRUE));
		$data['beginDate']  = $beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = $endDate = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0 and a.billType="PUR"';
		$where .= $storageNo ? ' and d.locationNo in('.str_quote($storageNo).')' : ''; 
		$where .= $customerNo ? ' and c.number in('.str_quote($customerNo).')' : ''; 
		$where .= $goodsNo ? ' and b.number in('.str_quote($goodsNo).')' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_location_purview();
		$data['list'] = $this->data_model->get_invoice_infosum($where.' group by a.buId,a.invId, a.locationId'); 
		$this->load->view('report/puDetail-supplyExporter',$data);	
	}
	
	

	public function sales_detail() {
	    $this->common_model->checkpurview(31);
		$this->load->view('report/sales-detail');	
	}
	

	public function salesDetail_detail() {
	    $this->common_model->checkpurview(31);
		$sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = $sum7 = 0;
	    $data['status'] = 200;
		$data['msg']    = 'success';
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100); 
		$profit     = intval($this->input->get_post('profit',TRUE));
		$salesId    = str_enhtml($this->input->get_post('salesId',TRUE));
	    $storageNo  = str_enhtml($this->input->get_post('storageNo',TRUE));
		$customerNo = str_enhtml($this->input->get_post('customerNo',TRUE));
		$goodsNo    = str_enhtml($this->input->get_post('goodsNo',TRUE));
		$beginDate  = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate    = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0 and a.billType="SALE"';
		$where .= $salesId ? ' and e.number  in('.str_quote($salesId).')' : ''; //a.salesId
		$where .= $storageNo ? ' and d.locationNo in('.str_quote($storageNo).')' : ''; 
		$where .= $customerNo ? ' and c.number in('.str_quote($customerNo).')' : ''; 
		$where .= $goodsNo ? ' and b.number in('.str_quote($goodsNo).')' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_admin_purview();
		$where .= $this->common_model->get_location_purview();
		$offset = $rows * ($page-1);
		$data['data']['page']      = $page;
		$data['data']['records']   = $this->data_model->get_invoice_info($where.' order by a.billDate,a.id',3);               
		$data['data']['total']     = ceil($data['data']['records']/$rows);                           
		$list   = $this->data_model->get_invoice_info($where.' order by a.billDate,a.id'); 
		foreach ($list as $arr=>$row) {
		    $sum1 += $qty    = $row['qty']>0 ? -abs($row['qty']) : abs($row['qty']);   //销售在数据库中是负数 在统计的时候应该是正数
			$sum3 += $amount = $row['amount'];                      //销售收入
			$v[$arr]['billId']        = intval($row['iid']);
		    $v[$arr]['billNo']        = $row['billNo'];
			$v[$arr]['billType']      = $row['billType']; 
			$v[$arr]['date']          = $row['billDate']; 
			$v[$arr]['buId']          = intval($row['buId']);
			$v[$arr]['buName']        = $row['contactName'];
			$v[$arr]['invNo']         = $row['invNumber'];  
			$v[$arr]['invName']       = $row['invName'];   
			$v[$arr]['spec']          = $row['invSpec']; 
			$v[$arr]['unit']          = $row['mainUnit']; 
			$v[$arr]['location']      = $row['locationName']; 
			$v[$arr]['description']   = $row['description']; 
			$v[$arr]['skuId']         = 0; 
			$v[$arr]['cost']          = '';   //销售成本
			$v[$arr]['unitCost']      = '';   //单位成本
			$v[$arr]['saleProfit']    = '';   //销售毛利
			$v[$arr]['salepPofitRate']= '';   //销售毛利率
			$v[$arr]['salesName']     = $row['salesName'];
			$v[$arr]['transType']     = $row['transTypeName'];
			$v[$arr]['unitPrice']     = round($row['price'],$this->systems['qtyPlaces']);
			$v[$arr]['qty']           = round($qty,$this->systems['qtyPlaces']);
		    $v[$arr]['amount']        = round($row['amount'],2);
		}
		$data['data']['rows']      = isset($v) ? $v : array();
		$data['data']['userdata']['billId']      = 0;
		$data['data']['userdata']['billType']    = 'SALE';
		$data['data']['userdata']['skuId']       = 0;
		$data['data']['userdata']['qty']         = round($sum1,$this->systems['qtyPlaces']);
		$data['data']['userdata']['unitPrice']   = $sum1>0 ? round($sum3/$sum1,$this->systems['qtyPlaces']) : 0;
		$data['data']['userdata']['amount']      = round($sum3,2);
		$data['data']['userdata']['cost']        = '';
		$data['data']['userdata']['unitCost']    = '';
		$data['data']['userdata']['saleProfit']      = '';
		$data['data']['userdata']['salepPofitRate']  = '';
		die(json_encode($data));
	}
	

	public function salesDetail_detailExporter() {
	    $this->common_model->checkpurview(32);
		$name = 'sales_detail_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('销售明细表导出:'.$name);
		$salesId    = str_enhtml($this->input->get_post('salesId',TRUE));
	    $storageNo  = str_enhtml($this->input->get_post('storageNo',TRUE));
		$customerNo = str_enhtml($this->input->get_post('customerNo',TRUE));
		$goodsNo    = str_enhtml($this->input->get_post('goodsNo',TRUE));
		$data['beginDate']  = $beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = $endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0 and a.billType="SALE"';
		$where .= $salesId ? ' and e.number  in('.str_quote($salesId).')' : ''; 
		$where .= $storageNo ? ' and d.locationNo in('.str_quote($storageNo).')' : ''; 
		$where .= $customerNo ? ' and c.number in('.str_quote($customerNo).')' : ''; 
		$where .= $goodsNo ? ' and b.number in('.str_quote($goodsNo).')' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_admin_purview();
		$where .= $this->common_model->get_location_purview();
		$data['list'] = $this->data_model->get_invoice_info($where.' order by a.id'); 
		$this->load->view('report/salesDetail-detailExporter',$data);	
	} 
	

	public function sales_summary() {
	    $this->common_model->checkpurview(34);
		$this->load->view('report/sales-summary');	
	}
	
	public function sales_profit(){
	    $this->common_model->checkpurview(34);
	    $this->load->view('report/sales-profit');
	}

	public function salesDetail_inv() {
	    $this->common_model->checkpurview(34);
		$sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = $sum7 = 0;
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100); 
		$profit     = intval($this->input->get_post('profit',TRUE));
		$salesId    = str_enhtml($this->input->get_post('salesId',TRUE));
	    $storageNo  = str_enhtml($this->input->get_post('storageNo',TRUE));
		$customerNo = str_enhtml($this->input->get_post('customerNo',TRUE));
		$goodsNo    = str_enhtml($this->input->get_post('goodsNo',TRUE));
		$beginDate  = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate    = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0 and a.billType="SALE"';
		$where .= $salesId ? ' and e.number  in('.str_quote($salesId).')' : ''; 
		$where .= $storageNo ? ' and d.locationNo in('.str_quote($storageNo).')' : ''; 
		$where .= $customerNo ? ' and c.number in('.str_quote($customerNo).')' : ''; 
		$where .= $goodsNo ? ' and b.number in('.str_quote($goodsNo).')' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_location_purview();
		$offset = $rows * ($page-1);  
		if ($profit==1) {
			$info  = $this->data_model->get_profit('and billDate<="'.$endDate.'"');  
		}                         
		$list  = $this->data_model->get_invoice_infosum($where.' group by a.invId, a.locationId'); 
		foreach ($list as $arr=>$row) {
		    $sum1 += $qty = $row['sumqty']>0 ? -abs($row['sumqty']):abs($row['sumqty']);   
			$sum3 += $amount = $row['sumamount'];                     
			$unitPrice = $qty!=0 ? $amount/$qty : 0;                  
			if ($profit==1) {
				$sum4 += $unitcost = isset($info['inprice'][$row['invId']][$row['locationId']]) ? $info['inprice'][$row['invId']][$row['locationId']] : 0;   //单位成本
				$sum5 += $cost = $unitcost * $qty;                    
				$sum6 += $saleProfit = $amount - $cost;               
				$sum7 += $salepPofitRate = $amount>0 ? ($saleProfit/$amount)*100 :0;   
			} 
			$v[$arr]['billId']        = intval($row['id']);
		    $v[$arr]['billNo']        = $row['billNo'];
			$v[$arr]['billType']      = $row['billType']; 
			$v[$arr]['date']          = $row['billDate']; 
			$v[$arr]['buId']          = intval($row['buId']);
			$v[$arr]['buName']        = $row['contactName'];
			$v[$arr]['invNo']         = $row['invNumber'];  
			$v[$arr]['invName']       = $row['invName'];   
			$v[$arr]['spec']          = $row['invSpec']; 
			$v[$arr]['unit']          = $row['mainUnit']; 
			$v[$arr]['location']      = $row['locationName']; 
			$v[$arr]['locationNo']    = $row['locationNo']; 
			$v[$arr]['skuId']         = 0; 
			if ($profit==1) {
				$v[$arr]['cost']          = round($cost,2);
				$v[$arr]['unitCost']      = round($unitcost,2);
				$v[$arr]['saleProfit']    = round($saleProfit,2);
				$v[$arr]['salepPofitRate']= round($salepPofitRate,2).'%';
			} 
			$v[$arr]['salesName']     = $row['salesName'];
			$v[$arr]['transType']     = $row['transTypeName'];
			$v[$arr]['qty']           = round($qty,$this->systems['qtyPlaces']); 
		    $v[$arr]['amount']        = round($amount,2); 
			$v[$arr]['unitPrice']     = round($unitPrice,2);  
		}
		
		$data['status'] = 200;
		$data['msg']    = 'success';
		$data['data']['page']      = $page;
		$data['data']['records']   = $this->data_model->get_invoice_infosum($where.' group by a.invId, a.locationId',3);  
		$data['data']['total']     = ceil($data['data']['records']/$rows);                 
		$data['data']['rows']      = isset($v) ? $v : array();
		$data['data']['userdata']['billId']      = 0;
		$data['data']['userdata']['billType']    = 'SALE';
		$data['data']['userdata']['skuId']       = 0;
		$data['data']['userdata']['qty']         = round($sum1,$this->systems['qtyPlaces']);
		$data['data']['userdata']['unitPrice']   = $sum1>0 ? round($sum3/$sum1,2) : 0; 
		$data['data']['userdata']['amount']      = round($sum3,2);
		if ($profit==1) {
			$data['data']['userdata']['cost']        = round($sum5,2);
			$data['data']['userdata']['unitCost']    = round($sum4,2);
			$data['data']['userdata']['saleProfit']      = round($sum6,2);
			$data['data']['userdata']['salepPofitRate']  = round($sum7,2).'%';
		} 
		die(json_encode($data));
	}
	

	public function salesDetail_invExporter() {
	    $this->common_model->checkpurview(35);
		$name = 'sales_inv_summary_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('导出销售汇总表(按商品):'.$name);
		$data['profit'] = $profit     = intval($this->input->get_post('profit',TRUE));
		$salesId    = str_enhtml($this->input->get_post('salesId',TRUE));
	    $storageNo  = str_enhtml($this->input->get_post('storageNo',TRUE));
		$customerNo = str_enhtml($this->input->get_post('customerNo',TRUE));
		$goodsNo    = str_enhtml($this->input->get_post('goodsNo',TRUE));
		$data['beginDate'] = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']   = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0 and a.billType="SALE"';
		$where .= $salesId ? ' and e.number  in('.str_quote($salesId).')' : ''; 
		$where .= $storageNo ? ' and d.locationNo in('.str_quote($storageNo).')' : ''; 
		$where .= $customerNo ? ' and c.number in('.str_quote($customerNo).')' : ''; 
		$where .= $goodsNo ? ' and b.number in('.str_quote($goodsNo).')' : ''; 
		$where .= $data['beginDate'] ? ' and a.billDate>="'.$data['beginDate'].'"' : ''; 
		$where .= $data['endDate'] ? ' and a.billDate<="'.$data['endDate'].'"' : ''; 
		$where .= $this->common_model->get_location_purview();
		if ($profit==1) {
			$data['info'] = $this->data_model->get_profit('and billDate<="'.$data['endDate'].'"');      
		}
		$data['list'] = $this->data_model->get_invoice_infosum($where.' group by invId, locationId'); 
		$this->load->view('report/salesDetail_invExporter',$data);	
	}
	
	public function salesProfit_inv() {
	    $this->common_model->checkpurview(34);
	    $page = max(intval($this->input->get_post('page',TRUE)),1);
	    $rows = max(intval($this->input->get_post('rows',TRUE)),100);
	    $salesId   = intval($this->input->get_post('salesId',TRUE));
	    $customerNo = str_enhtml($this->input->get_post('customerNo',TRUE));
	    $salesNo = str_enhtml($this->input->get_post('salesNo',TRUE));
	    $beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
	    $endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
	    $where = 'a.isDelete=0 and a.billType="SALE"';
	    $where .= $salesId>0    ? ' and a.salesId='.$salesId : '';
	    $where .= $customerNo ? ' and b.number in('.str_quote($customerNo).')' : '';
	    $where .= $salesNo ? ' and c.number in('.str_quote($salesNo).')' : '';
	    $where .= $beginDate    ? ' and a.billDate>="'.$beginDate.'"' : '';
	    $where .= $endDate      ? ' and a.billDate<="'.$endDate.'"' : '';
	    $list = $this->data_model->get_invoice($where.' order by a.id desc ');
	    
	    $info  = $this->data_model->get_profit('and billDate<="'.$endDate.'"');
	    
	    $sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = $sum7 = $sum8 = $sum9 = $sum10 = $sum11 = 0;
	    foreach ($list as $arr=>$row) {
	        $totalAmount = (float)$row['totalAmount'];
	        $amount = (float)$row['amount'];
	        $v[$arr]['salesNo'] = $row['salesNo'];
	        $v[$arr]['contactNo'] = $row['contactNo'];
	        $v[$arr]['billDate'] = $row['billDate'];//单据日期
	        $v[$arr]['salesName'] = $row['salesName'];//销售人员
	        $v[$arr]['contactName'] = $row['contactName'];//客户
	        $v[$arr]['billNo'] = $row['billNo'];//单据编号
	        $v[$arr]['transTypeName'] = $row['transTypeName'];//业务类型
	        $v[$arr]['totalQty'] = (float)$row['totalQty'];//数量
	        $v[$arr]['disAmount'] = (float)$row['disAmount'];//优惠金额
	        $v[$arr]['amount'] = (float)$row['amount'];//优惠后金额
	        $v[$arr]['totalAmount'] = (float)$row['totalAmount'];//销售收入
	        //$v[$arr]['totalCost'] = (float)$row['totalCost'];//销售成本
	        $v[$arr]['ysAmount'] = (float)$row['amount'];//应收金额
	        $v[$arr]['rpAmount'] = (float)$row['rpAmount'];//已收款金额
	        $v[$arr]['description'] = $row['description'];//整单备注
	        
	        $details = $this->data_model->get_invoice_info(' a.iid ='.$row['id']);
	        
	        $sum = 0;
	        foreach ($details as $key=>$detail) {
	            $qty = $detail['qty']>0 ? -abs($detail['qty']):abs($detail['qty']);
	            $unitcost = isset($info['inprice'][$detail['invId']][$detail['locationId']]) ? $info['inprice'][$detail['invId']][$detail['locationId']] : 0;   //单位成本
	            $sum += $cost = $unitcost * $qty;
	        }
	        $v[$arr]['totalCost'] = round($sum,2);//销售成本
	        $v[$arr]['saleProfit'] = round($totalAmount - $sum,2);//销售毛利=销售收入-销售成本
	        $salepPofitRate = $totalAmount>0? ($v[$arr]['saleProfit']/$totalAmount)*100 :0;
	        $v[$arr]['salepPofitRate'] = round($salepPofitRate,2).'%';//毛利率
	        $v[$arr]['pureProfit'] = $v[$arr]['saleProfit'] - $v[$arr]['disAmount'];//销售净利润=销售毛利-优惠金额
	        $pureProfitRate = $amount>0? ($v[$arr]['pureProfit']/$amount)*100 :0;
	        $v[$arr]['pureProfitRate'] = round($pureProfitRate,2).'%';//净利润率
	        	
	        $sum1 += $v[$arr]['totalQty'];
	        $sum2 += $v[$arr]['disAmount'];
	        $sum3 += $v[$arr]['amount'];
	        $sum4 += $v[$arr]['totalAmount'];
	        $sum5 += $v[$arr]['ysAmount'];
	        $sum6 += $v[$arr]['rpAmount'];
	        $sum7 += $v[$arr]['totalCost'];
	        $sum8 += $v[$arr]['saleProfit'];
	        $sum9 += $salepPofitRate;
	        $sum10 += $v[$arr]['pureProfit'];
	        $sum11 += $pureProfitRate;
	    }
	
	    $data['status'] = 200;
	    $data['msg']    = 'success';
	    $data['data']['page']      = $page;
	    $data['data']['records']   = $this->data_model->get_invoice($where.' order by a.id desc ',3);
	    $data['data']['total']     = ceil($data['data']['records']/$rows);
	    $data['data']['rows']      = isset($v) ? $v : array();
	    $data['data']['userdata']['billId']      = 0;
	    $data['data']['userdata']['billType']    = 'SALE';
	    $data['data']['userdata']['skuId']       = 0;
	    $data['data']['userdata']['qty']         = round($sum1,$this->systems['qtyPlaces']);
	    $data['data']['userdata']['unitPrice']   = $sum1>0 ? round($sum3/$sum1,2) : 0;
	    $data['data']['userdata']['totalQty']      = round($sum1,2);
	    $data['data']['userdata']['disAmount']      = round($sum2,2);
	    $data['data']['userdata']['amount']      = round($sum3,2);
	    $data['data']['userdata']['totalAmount']      = round($sum4,2);
	    $data['data']['userdata']['ysAmount']      = round($sum5,2);
	    $data['data']['userdata']['rpAmount']      = round($sum6,2);
	    $data['data']['userdata']['totalCost']      = round($sum7,2);
	    $data['data']['userdata']['saleProfit']      = round($sum8,2);
	    $data['data']['userdata']['salepPofitRate']      = round($sum9,2).'%';
	    $data['data']['userdata']['pureProfit']      = round($sum10,2);
	    $data['data']['userdata']['pureProfitRate']      = round($sum11,2).'%';
	    die(json_encode($data));
	}
	
	public function salesProfit_invExporter() {
	    $this->common_model->checkpurview(35);
	    $name = '销售利润表_'.date('YmdHis').'.xls';
	    sys_csv($name);
	    $this->common_model->logs('导出销售利润表:'.$name);
	    $salesId   = intval($this->input->get_post('salesId',TRUE));
	    $customerNo = str_enhtml($this->input->get_post('customerNo',TRUE));
	    $salesNo = str_enhtml($this->input->get_post('salesNo',TRUE));
	    $beginDate = str_enhtml($this->input->get_post('beginDate',TRUE));
	    $endDate   = str_enhtml($this->input->get_post('endDate',TRUE));
	    $data['beginDate'] = str_enhtml($this->input->get_post('beginDate',TRUE));
	    $data['endDate']   = str_enhtml($this->input->get_post('endDate',TRUE));
	    $where = 'a.isDelete=0 and a.billType="SALE"';
	    $where .= $salesId>0    ? ' and a.salesId='.$salesId : '';
	    $where .= $customerNo ? ' and b.number in('.str_quote($customerNo).')' : '';
	    $where .= $salesNo ? ' and c.number in('.str_quote($salesNo).')' : '';
	    $where .= $beginDate    ? ' and a.billDate>="'.$beginDate.'"' : '';
	    $where .= $endDate      ? ' and a.billDate<="'.$endDate.'"' : '';
	    $data['list'] = $this->data_model->get_invoice($where.' order by a.id desc ');
	    $data['info']  = $this->data_model->get_profit('and billDate<="'.$endDate.'"');
	    $this->load->view('report/salesProfit_invExporter',$data);
	}
	

	public function sales_summary_customer_new() {
	    $this->common_model->checkpurview(37);
		$this->load->view('report/sales-summary-customer-new');	
	}
	

	public function salesDetail_customer() {
	    $this->common_model->checkpurview(37);
		$sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = $sum7 = 0;
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100); 
		$profit     = intval($this->input->get_post('profit',TRUE));
		$salesId    = str_enhtml($this->input->get_post('salesId',TRUE));
	    $storageNo  = str_enhtml($this->input->get_post('storageNo',TRUE));
		$customerNo = str_enhtml($this->input->get_post('customerNo',TRUE));
		$goodsNo    = str_enhtml($this->input->get_post('goodsNo',TRUE));
		$beginDate  = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate    = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0 and a.billType="SALE"';
		$where .= $salesId ? ' and e.number  in('.str_quote($salesId).')' : ''; 
		$where .= $storageNo ? ' and d.locationNo in('.str_quote($storageNo).')' : ''; 
		$where .= $customerNo ? ' and c.number in('.str_quote($customerNo).')' : ''; 
		$where .= $goodsNo ? ' and b.number in('.str_quote($goodsNo).')' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_location_purview();
		if ($profit==1) {
			$info  = $this->data_model->get_profit('and billDate<="'.$endDate.'"');         
		}
		$list   = $this->data_model->get_invoice_infosum($where.' group by buId,invId,locationId'); 
		foreach ($list as $arr=>$row) {
		    $sum1 += $qty = $row['sumqty']>0 ? -abs($row['sumqty']):abs($row['sumqty']);  
			$sum3 += $amount = $row['sumamount'];                     
			$unitPrice = $qty!=0 ? $amount/$qty : 0;                  
			if ($profit==1) {
				$sum4 += $unitcost = isset($info['inprice'][$row['invId']][$row['locationId']]) ? $info['inprice'][$row['invId']][$row['locationId']] : 0;   //单位成本
				$sum5 += $cost = $unitcost * $qty;                    
				$sum6 += $saleProfit = $amount - $cost;               
				$sum7 += $salepPofitRate = $amount>0 ? ($saleProfit/$amount)*100 :0;  
			} 
			$v[$arr]['billId']        = intval($row['iid']);
		    $v[$arr]['billNo']        = $row['billNo'];
			$v[$arr]['billType']      = $row['billType']; 
			$v[$arr]['date']          = $row['billDate']; 
			$v[$arr]['buId']          = intval($row['buId']);
			$v[$arr]['buName']        = $row['contactName'];
			$v[$arr]['invNo']         = $row['invNumber'];  
			$v[$arr]['invName']       = $row['invName'];   
			$v[$arr]['spec']          = $row['invSpec']; 
			$v[$arr]['unit']          = $row['mainUnit']; 
			$v[$arr]['location']      = $row['locationName']; 
			$v[$arr]['locationNo']    = $row['locationNo']; 
			$v[$arr]['baseQty']       = 0; 
			$v[$arr]['skuId']         = 0; 
			if ($profit==1) {
				$v[$arr]['cost']          = round($cost,2);
				$v[$arr]['unitCost']      = round($unitcost,2);
				$v[$arr]['saleProfit']    = round($saleProfit,2);
				$v[$arr]['salepPofitRate']= round($salepPofitRate,2);
			} 
			$v[$arr]['salesName']     = $row['salesName'];
			$v[$arr]['transType']     = $row['transTypeName'];
			$v[$arr]['qty']           = round($qty,$this->systems['qtyPlaces']); 
		    $v[$arr]['amount']        = round($amount,2); 
			$v[$arr]['unitPrice']     = round($unitPrice,2); 
		}
		$data['status'] = 200;
		$data['msg']    = 'success';
		$data['data']['list']      = isset($v) ? $v : array(); 
		$data['data']['total']['amount']      = '';
		$data['data']['total']['baseQty']     = 'SALE';
		$data['data']['total']['billId']      = '';
		$data['data']['total']['billNo']      = '';
		$data['data']['total']['billType']    = '';
		$data['data']['total']['buName']      = '';
		$data['data']['total']['buNo']        = '';
		$data['data']['total']['date']        = '';
		$data['data']['total']['invName']     = '';
		$data['data']['total']['location']    = '';
		$data['data']['total']['locationNo']  = '';
		$data['data']['total']['spec']        = '';
		$data['data']['total']['unit']        = '';
		$data['data']['total']['transType']   = '';
		$data['data']['total']['skuId']       = '';
		
		$data['data']['total']['qty']         = round($sum1,$this->systems['qtyPlaces']);
		$data['data']['total']['unitPrice']   = $sum1>0 ? $sum3/$sum1 : 0; 
		$data['data']['total']['amount']      = round($sum3,2);
        if ($profit==1) {
			$data['data']['total']['cost']        = round($sum5,2);
			$data['data']['total']['unitCost']    = round($sum4,2);
			$data['data']['total']['saleProfit']      = round($sum6,2);
			$data['data']['total']['salepPofitRate']  = round($sum7,2);
		}
		die(json_encode($data));
	}
	


	public function salesDetail_customerExporter() {
	    $this->common_model->checkpurview(38);
		$name = 'sales_customer_summary_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('导出销售汇总表(按客户):'.$name);
		$data['profit'] = $profit     = intval($this->input->get_post('profit',TRUE));
		$salesId    = str_enhtml($this->input->get_post('salesId',TRUE));
	    $storageNo  = str_enhtml($this->input->get_post('storageNo',TRUE));
		$customerNo = str_enhtml($this->input->get_post('customerNo',TRUE));
		$goodsNo    = str_enhtml($this->input->get_post('goodsNo',TRUE));
		$data['beginDate']  = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0 and a.billType="SALE"';
		$where .= $salesId ? ' and e.number  in('.str_quote($salesId).')' : ''; 
		$where .= $storageNo ? ' and d.locationNo in('.str_quote($storageNo).')' : ''; 
		$where .= $customerNo ? ' and c.number in('.str_quote($customerNo).')' : ''; 
		$where .= $goodsNo ? ' and b.number in('.str_quote($goodsNo).')' : ''; 
		$where .= $data['beginDate'] ? ' and a.billDate>="'.$data['beginDate'].'"' : ''; 
		$where .= $data['endDate'] ? ' and a.billDate<="'.$data['endDate'].'"' : '';
		$where .= $this->common_model->get_location_purview();
		if ($profit==1) {
			$data['info'] = $this->data_model->get_profit('and billDate<="'.$data['endDate'].'"');                  
		}
		$data['list'] = $this->data_model->get_invoice_infosum($where.' group by buId,invId,locationId'); 
		$this->load->view('report/salesDetail-customerExporter',$data);	
	}
	
	

	public function contact_debt_new() {
	    $this->common_model->checkpurview(49);
		$this->load->view('report/contact-debt-new');	
	}
	

	public function contactDebt_detail() {
	    $this->common_model->checkpurview(49);
		$v = array();
		$sum1 = $sum2 = 0;
	    $data['status'] = 200;
		$data['msg']    = 'success';
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100); 
		$matchCon  = str_enhtml($this->input->get_post('matchCon',TRUE));
		$supplier  = str_enhtml($this->input->get_post('supplier',TRUE));
		$customer  = str_enhtml($this->input->get_post('customer',TRUE));
		$where = 'a.isDelete=0';
		if ($supplier && $customer) {
		} else {
			$where .= $supplier ? ' and type=10' : '';
			$where .= $customer ? ' and type=-10' : '';
		}
		$where .= $matchCon ? ' and (name like "%'.$matchCon.'%" or number like "%'.$matchCon.'%")' : '';
		$where .= $this->common_model->get_contact_purview(); 
		$list = $this->data_model->get_contact('',$where. ' order by type desc');
		foreach ($list as $arr=>$row) {
		    $v[$arr]['dbid']        = 0;
			$v[$arr]['debt']        = 0; 
			$v[$arr]['displayName'] = $row['type']==10 ? '供应商' : '客户'; 
			$v[$arr]['buId']        = intval($row['id']);
			$v[$arr]['name']        = $row['name'];
			$v[$arr]['number']      = $row['number'];   
			$sum1 += $v[$arr]['payable']     = $row['type']==10  ? $row['amount'] : 0; 
			$sum2 += $v[$arr]['receivable']  = $row['type']==-10 ? $row['amount'] : 0; 
			$v[$arr]['type']        = $row['type']; 
		}
		$data['data']['list']      = $v;
		$data['data']['total']['buid']        = 0;
		$data['data']['total']['dbid']        = 0;
		$data['data']['total']['debt']        = '';
		$data['data']['total']['displayName'] = '';
		$data['data']['total']['name']        = '';
		$data['data']['total']['number']      = '';
		$data['data']['total']['payable']     = $sum1;
		$data['data']['total']['receivable']  = $sum2;
		$data['data']['total']['type']        = '';
		die(json_encode($data));
	}
	
	
	public function contactDebt_exporter() {
	    $this->common_model->checkpurview(50);
		$name = 'contact_debt_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('导出往来单位欠款表:'.$name);
		$matchCon  = str_enhtml($this->input->get_post('matchCon',TRUE));
		$supplier  = str_enhtml($this->input->get_post('supplier',TRUE));
		$customer  = str_enhtml($this->input->get_post('customer',TRUE));
		$where = 'a.isDelete=0';
		if ($supplier && $customer) {
		} else {
			$where .= $supplier ? ' and type=10' : '';
			$where .= $customer ? ' and type=-10' : '';
		}
		$where .= $matchCon ? ' and (name like "%'.$matchCon.'%" or number like "%'.$matchCon.'%")' : '';
		$where .= $this->common_model->get_contact_purview(); 
		$data['list'] = $this->data_model->get_contact('',$where. ' order by type desc');
		$this->load->view('report/contactDebt-exporter',$data);	
	}
	
	
	
	public function goods_balance() {
	    $this->common_model->checkpurview(40);
		$this->load->view('report/goods-balance');	
	}
	
    
	public function invBalance() {
	    $this->common_model->checkpurview(40);
	    $i = 2;
		$select = '';
		$qty_1  = $cost_1 = $cost1 = 0;
		$stoNames = array();
		$colNames = array();
		$colIndex = array();
		$catId      = intval($this->input->get_post('catId',TRUE));
		$goodsNo    = str_enhtml($this->input->get_post('goodsNo',TRUE));
		$storageNo  = str_enhtml($this->input->get_post('storageNo',TRUE));
		$endDate    = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0';
		if ($catId > 0) {
		    $catId = array_column($this->mysql_model->get_results('category','(1=1) and find_in_set('.$catId.',path)'),'id'); 
			if (count($catId)>0) {
			    $catId = join(',',$catId);
			    $where .= ' and b.categoryid in('.$catId.')';
			} 
		} 
		$where .= $goodsNo ? ' and b.number="'.$goodsNo.'"' : ''; 
		$where .= $storageNo ? ' and c.locationNo in('.str_quote($storageNo).')' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_location_purview(); 
		$where1 = $storageNo ? ' and locationNo in('.str_quote($storageNo).')' : ''; 
		$where1 .= $this->common_model->get_location_purview(1); 
		$storage = $this->mysql_model->get_results('storage','(isDelete=0) '.$where1);
		foreach($storage as $arr=>$row) {
		    $qty['qty'.$i]  = $qty['cost'.$i] = 0;
		    $stoNames[] = $row['name'];
			$colNames[] = '数量';
			$colNames[] = '成本';
			$colIndex[] = 'qty_'.$i;
			$colIndex[] = 'cost_'.$i;
			$select .= 'sum(case when a.locationId='.$row['id'].' then qty else 0 end ) as qty'.$i.',';
		    $i++;
		}
		array_unshift($stoNames,'所有仓库');
		array_unshift($colNames,'商品编号','商品名称','规格型号','单位','数量','成本');
		array_unshift($colIndex,'invNo','invName','spec','unit','qty_1','cost_1');
		$profit = $this->data_model->get_profit('and billDate<="'.$endDate.'"');                
		$list   = $this->data_model->get_invBalance($where.' group by a.invId',$select); 
		foreach ($list as $arr=>$row) {
			$v[$arr]['invNo']         = $row['invNumber'];  
			$v[$arr]['invName']       = $row['invName'];   
			$v[$arr]['spec']          = $row['invSpec']; 
			$v[$arr]['unit']          = $row['mainUnit']; 
			$i = 2;
			$cost1 = 0;//add my michen 20170818 for bug
			foreach($storage as $arr1=>$row1) {
			    $price = isset($profit['inprice'][$row['invId']][$row1['id']]) ? $profit['inprice'][$row['invId']][$row1['id']] : 0;   //单位成本
				$v[$arr]['qty_'.$i]   = round($row['qty'.$i],$this->systems['qtyPlaces']);  
				$v[$arr]['cost_'.$i]  = round($row['qty'.$i] * $price,2);  
				$qty['qty'.$i] += $row['qty'.$i];
				$qty['cost'.$i] += $row['qty'.$i] * $price;
				$cost1 += $row['qty'.$i] * $price;
			    $i++;
			}
			$v[$arr]['qty_1']         = round($row['qty'],$this->systems['qtyPlaces']);  
			$v[$arr]['cost_1']        = round($cost1,2);  
			$qty_1  += $row['qty'];  
			$cost_1 += $cost1;  
		}
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['stoNames'] = $stoNames;
		$json['data']['colNames'] = $colNames;
		$json['data']['colIndex'] = $colIndex;
		$json['data']['total'] = 1;
		$json['data']['page']  = 1;
		$json['data']['records'] = 200;
		$json['data']['rows']  = isset($v) ? $v : array();
		$json['data']['userdata']['invNo']    = '';
		$json['data']['userdata']['invName']  = '';
		$json['data']['userdata']['spec']     = '';
		$json['data']['userdata']['unit']     = '';
		$json['data']['userdata']['qty_1']    = round($qty_1,$this->systems['qtyPlaces']);  
		$json['data']['userdata']['cost_1']   = round($cost_1,2); 
		$i = 2;
		foreach($storage as $arr1=>$row1) {
			$json['data']['userdata']['qty_'.$i]  = round($qty['qty'.$i],$this->systems['qtyPlaces']);  
			$json['data']['userdata']['cost_'.$i] = round($qty['cost'.$i],2);    
		    $i++;
		}
		die(json_encode($json));
	}
	
	

	public function invBalance_exporter() {
	    $this->common_model->checkpurview(41);
		sys_csv('inv_balance_'.date('YmdHis').'.xls');
		$i = 2;
		$select = '';
		$catId      = intval($this->input->get_post('catId',TRUE));
		$goodsNo    = str_enhtml($this->input->get_post('goodsNo',TRUE));
		$storageNo  = str_enhtml($this->input->get_post('storageNo',TRUE));
		$data['beginDate'] = $beginDate  = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']   = $endDate    = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0';
		if ($catId > 0) {
		    $catId = array_column($this->mysql_model->get_results('category','(1=1) and find_in_set('.$catId.',path)'),'id'); 
			if (count($catId)>0) {
			    $catId = join(',',$catId);
			    $where .= ' and b.categoryid in('.$catId.')';
			} 
		} 
		$where .= $goodsNo ? ' and b.number="'.$goodsNo.'"' : ''; 
		$where .= $storageNo ? ' and c.locationNo in('.str_quote($storageNo).')' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : ''; 
		$where .= $this->common_model->get_location_purview(); 
		$where1 = $storageNo ? ' and locationNo in('.str_quote($storageNo).')' : ''; 
		$where1 .= $this->common_model->get_location_purview(1); 
		$data['storage'] = $storage = $this->mysql_model->get_results('storage','(isDelete=0) '.$where1);
		foreach($storage as $arr=>$row) {
			$select .= 'sum(case when a.locationId='.$row['id'].' then qty else 0 end ) as qty'.$i.',';
		    $i++;
		}
		$data['profit'] = $this->data_model->get_profit('and billDate<="'.$endDate.'"');                      
		$data['list']   = $this->data_model->get_invBalance($where.' group by a.invId',$select); 
		$this->load->view('report/invBalance_exporter',$data);	
	}
	

	public function goods_flow_detail() {
	    $this->common_model->checkpurview(43);
		$this->load->view('report/goods-flow-detail');	
	}
	
 

	public function deliverDetail() {
	    $this->common_model->checkpurview(43);
		$sum1 = $sum2 = $sum3 = $sum4 = $sum5 = 0;
		$where = '';
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100); 
	    $storageNo  = str_enhtml($this->input->get_post('storageNo',TRUE));
		$goodsNo    = str_enhtml($this->input->get_post('goodsNo',TRUE));
		$beginDate  = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate    = str_enhtml($this->input->get_post('endDate',TRUE));
		$where1 =  'a.isDelete=0'; 
		$where1 .=  $goodsNo ? ' and a.number in('.str_quote($goodsNo).')' : ''; 
		$where2 = 'a.isDelete=0 and a.transType>0';
		$where2 .= $storageNo ? ' and d.locationNo in('.str_quote($storageNo).')' : ''; 
		$where2 .= $goodsNo ? ' and b.number in('.str_quote($goodsNo).')' : ''; 
		$where2 .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : '';
		$where2 .= $endDate ? ' and a.billDate<="'.$endDate.'"' : '';
		$where2 .= $this->common_model->get_location_purview();
		$list1   = $this->data_model->get_goods_beginning($where1.' order by a.id',$beginDate);                      
		$list2   = $this->data_model->get_invoice_info($where2.' order by a.billDate,a.id'); 
		foreach ($list1 as $arr=>$row) {
		    $v[$arr]['date']          = '';  
			$v[$arr]['billNo']        = '';  
			$v[$arr]['billId']        = '';  
			$v[$arr]['billType']      = '';  
			$v[$arr]['buName']        = '';  
			$v[$arr]['transType']     = '期初数量';  
			$v[$arr]['transTypeId']   = '';  
			$v[$arr]['invNo']         = $row['invNumber'];  
			$v[$arr]['invName']       = $row['invName']; 
			$v[$arr]['spec']          = ''; 
			$v[$arr]['unit']          = ''; 
			$v[$arr]['entryId']       = ''; 
			$v[$arr]['location']      = ''; 
			$v[$arr]['locationNo']    = ''; 
			$v[$arr]['inout']         = 0;
			$v[$arr]['qty']           = '';
			$v[$arr]['baseQty']       = '';
			$v[$arr]['inqty']         = '';
			$v[$arr]['outqty']        = '';
			$v[$arr]['totalqty']      = round($row['qty'],$this->systems['qtyPlaces']);
			foreach ($list2 as $arr1=>$row1) {
			    $arr = time() + $arr1;
				if ($row['id']==$row1['invId']) {
					$inqty         = $row1['qty']>0 ? abs($row1['qty']) : ''; 
					$outqty        = $row1['qty']<0 ? abs($row1['qty']) : '';  
					$sum1   += $inqty;             
					$sum2   += $outqty;            
					$totalqtys   = $row['qty']  + $sum1 - $sum2;         
					$v[$arr]['date']          = $row1['billDate'];  
					$v[$arr]['billNo']        = $row1['billNo'];  
					$v[$arr]['billId']        = $row1['iid'];  
					$v[$arr]['billType']      = $row1['billType'];  
					$v[$arr]['buName']        = $row1['contactName'];  
					$v[$arr]['transType']     = $row1['transTypeName'];  
					$v[$arr]['transTypeId']   = $row1['transType'];  
					$v[$arr]['invNo']         = $row1['invNumber'];  
					$v[$arr]['invName']       = $row1['invName'];   
					$v[$arr]['spec']          = $row1['invSpec']; 
					$v[$arr]['unit']          = $row1['mainUnit']; 
					$v[$arr]['entryId']       = ''; 
					$v[$arr]['location']      = $row1['locationName']; 
					$v[$arr]['locationNo']    = $row1['locationNo']; 
					$v[$arr]['inout']         = 0;
					$v[$arr]['qty']           = 0;
					$v[$arr]['baseQty']       = 0;
					$v[$arr]['unitCost']      = 0;
					$v[$arr]['cost']          = 0;
					$v[$arr]['inqty']         = round($inqty,$this->systems['qtyPlaces']);
					$v[$arr]['outqty']        = round($outqty,$this->systems['qtyPlaces']);
					$v[$arr]['totalqty']      = round($totalqtys,$this->systems['qtyPlaces']);
				}
			}
			$sum3   += $sum1;             
			$sum4   += $sum2;             
			$sum5   += $totalqtys;
			$totalqtys   = $sum1 = $sum2 =  0;
		}
		$data['status'] = 200;
		$data['msg']    = 'success'; 
		$data['data']['page']      = $page;
		$data['data']['records']   = 1;   
		$data['data']['total']     = ceil($data['data']['records']/$rows); 
		$data['data']['rows']    = isset($v) ? array_values($v) : array();
		$data['data']['userdata']['date']       = '';
		$data['data']['userdata']['billNo']     = '';
		$data['data']['userdata']['billId']     = '';
		$data['data']['userdata']['billType']   = '';
		$data['data']['userdata']['buName']     = '';
		$data['data']['userdata']['type']       = '';
		$data['data']['userdata']['transTypeId']= '';
		$data['data']['userdata']['invNo']      = '';
		$data['data']['userdata']['invName']    = '';
		$data['data']['userdata']['spec']       = '';
		$data['data']['userdata']['unit']       = '';
		$data['data']['userdata']['location']   = '';
		$data['data']['userdata']['locationNo'] = '';
		$data['data']['userdata']['inout']      = '';
		$data['data']['userdata']['qty']        = 0;
		$data['data']['userdata']['baseQty']    = '';
		$data['data']['userdata']['unitCost']   = '';
		$data['data']['userdata']['cost']       = '';
		$data['data']['userdata']['cost_5']     = '';
		$data['data']['userdata']['inqty']      = round($sum3,$this->systems['qtyPlaces']);
		$data['data']['userdata']['outqty']     = round($sum4,$this->systems['qtyPlaces']);
		$data['data']['userdata']['totalqty']   = round($sum5,$this->systems['qtyPlaces']);
		die(json_encode($data));
	}
	

	public function deliverDetail_exporter() {
	    $this->common_model->checkpurview(44);
		$name = 'deliver_Detail_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('商品收发明细表导出:'.$name); 
	    $storageNo  = str_enhtml($this->input->get_post('storageNo',TRUE));
		$goodsNo    = str_enhtml($this->input->get_post('goodsNo',TRUE));
		$data['beginDate'] = $beginDate  = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']   = $endDate    = str_enhtml($this->input->get_post('endDate',TRUE));
		$where1 =  'a.isDelete=0'; 
		$where1 .=  $goodsNo ? ' and b.number in('.str_quote($goodsNo).')' : ''; 
		$where2 = 'a.isDelete=0 and a.transType>0';
		$where2 .= $storageNo ? ' and d.locationNo in('.str_quote($storageNo).')' : ''; 
		$where2 .= $goodsNo ? ' and b.number in('.str_quote($goodsNo).')' : ''; 
		$where2 .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : '';
		$where2 .= $endDate ? ' and a.billDate<="'.$endDate.'"' : '';
		$where2 .= $this->common_model->get_location_purview();
		$data['list1']   = $this->data_model->get_goods_beginning($where1.' order by a.id',$beginDate);                   
		$data['list2']   = $this->data_model->get_invoice_info($where2.' order by a.billDate,a.id'); 
		$this->load->view('report/deliverDetail-exporter',$data);	
	}
	

	public function goods_flow_summary() {
	    $this->common_model->checkpurview(46);
		$this->load->view('report/goods-flow-summary');	
	}
	
	 
	

	public function deliverSummary() {
	    $this->common_model->checkpurview(46);
		for ($i=0;$i<15;$i++) {
			$sum['qty'.$i]   = 0;  
			$sum['cost'.$i]  = 0;  
		}
		$qty7   = $qty_7   = $qty13  = $qty_13 = 0; 
		$page   = max(intval($this->input->get_post('page',TRUE)),1);
		$rows   = max(intval($this->input->get_post('rows',TRUE)),100); 
		$storageNo  = str_enhtml($this->input->get_post('storageNo',TRUE));
		$goodsNo    = str_enhtml($this->input->get_post('goodsNo',TRUE));
		$beginDate  = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate    = str_enhtml($this->input->get_post('endDate',TRUE));
		$where  = 'a.isDelete=0';
		$where .= $storageNo ? ' and d.locationNo in('.str_quote($storageNo).')' : ''; 
		$where .= $goodsNo ? ' and b.number in('.str_quote($goodsNo).')' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : '';
		$where .= $this->common_model->get_location_purview();
		$profit1 = $this->data_model->get_profit('and billDate<"'.$beginDate.'"');    
		$profit2 = $this->data_model->get_profit('and billDate<="'.$endDate.'"');    
		$list  = $this->data_model->get_deliverSummary($where.' group by a.invId,a.locationId',$beginDate,$endDate); 
		foreach ($list as $arr=>$row) {
		    $price1 = isset($profit1['inprice'][$row['invId']][$row['locationId']]) ? $profit1['inprice'][$row['invId']][$row['locationId']] : 0;   
		    $price2 = isset($profit2['inprice'][$row['invId']][$row['locationId']]) ? $profit2['inprice'][$row['invId']][$row['locationId']] : 0;  

		    $qty_0      = $row['qty0']; 
		    $qty_14     = $row['qty14'];                       
		    for ($i=1;$i<7;$i++) {
			    if ($i==1) {                                    
				    $qty_7  += abs($row['qty1']);   
				} else {
					$qty_7  += abs($row['qty'.$i]);   
				}
			}
			for ($i=8;$i<13;$i++) {
				if ($i==10 || $i==11 || $i==12 || $i==8) {      
				    $qty_13  += abs($row['qty'.$i]);   
				} else {
					$qty_13  += abs($row['qty'.$i]);   
				}
			}
			$v[$arr]['invNo']         = $row['invNumber'];  
			$v[$arr]['invName']       = $row['invName'];   
			$v[$arr]['spec']          = $row['invSpec']; 
			$v[$arr]['unit']          = $row['mainUnit']; 
			$v[$arr]['location']      = $row['locationName']; 
			$v[$arr]['locationNo']    = $row['locationNo'];
			for ($i=0; $i<15; $i++) {
			    if ($i==0) {
				    $v[$arr]['qty_0']     = round($qty_0,$this->systems['qtyPlaces']);       
					$v[$arr]['cost_0']   = round($qty_0 * $price1,2);                           
					$sum['qty0']  += $qty_0;                                                    
					$sum['cost0'] += $qty_0 * $price1;                                        
				} elseif($i==7) {
				    $v[$arr]['qty_7']    = round($qty_7,$this->systems['qtyPlaces']);       
					$sum['qty7']  += $qty_7;               
				} elseif($i==13) {
				    $v[$arr]['qty_13']   = round($qty_13,$this->systems['qtyPlaces']);       
					$sum['qty13']  += $qty_13;             
				} elseif($i==14) {                                   
				    $v[$arr]['qty_14']   = round($qty_14,$this->systems['qtyPlaces']);        
					$v[$arr]['cost_14']   = round($qty_14 * $price2,2);            
					$sum['qty14']  += $qty_14;   
					$sum['cost14'] += $qty_14 * $price2;             
				} else {
				    if ($i==10 || $i==11 || $i==12 || $i==1 || $i==8) {                         
						$v[$arr]['qty_'.$i]   = round(abs($row['qty'.$i]),$this->systems['qtyPlaces']);  
						$sum['qty'.$i]   += abs($row['qty'.$i]); 
						$sum['cost'.$i]  += abs($row['qty'.$i]) * $price2;           
					} else { 
						$v[$arr]['qty_'.$i]   = round(abs($row['qty'.$i]),$this->systems['qtyPlaces']);   
						$sum['qty'.$i]  += abs($row['qty'.$i]);
						$sum['cost'.$i] += abs($row['qty'.$i]) * $price2;   
						           
					}
				}
			}
			$qty_7 = $cost_7 = $qty_13 = $cost_13 = 0;        
		}
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['stoNames']  = array("期初","调拨入库","普通采购","销售退回","盘盈","其他入库","成本调整","入库合计","调拨出库","采购退回","普通销售","盘亏","其他出库","出库合计","结存");
		$json['data']['colNames']  = array("商品编号","商品名称","规格型号","单位","仓库","数量","成本","数量","数量","数量","数量","数量","数量","数量","数量","数量","数量","数量","数量","数量","数量","成本");
		$json['data']['colIndex']  = array("invNo","invName","spec","unit","locationNo","qty_0","cost_0","qty_1","qty_2","qty_3","qty_4","qty_5","qty_6","qty_7","qty_8","qty_9","qty_10","qty_11","qty_12","qty_13","qty_14","cost_14");
		$json['data']['page']      = $page;
		$json['data']['records']   = 1;   
		$json['data']['total']     = ceil($json['data']['records']/$rows);   
		$json['data']['rows']      = isset($v) ? $v : array();
		$json['data']['userdata']['invNo']      = '';
		$json['data']['userdata']['invName']    = '';
		$json['data']['userdata']['spec']       = '';
		$json['data']['userdata']['unit']       = '';
		$json['data']['userdata']['location']   = '';
		$json['data']['userdata']['locationNo'] = '';
		for ($i=0;$i<15;$i++) {
			$json['data']['userdata']['qty_'.$i]   = round($sum['qty'.$i],$this->systems['qtyPlaces']);   
			$json['data']['userdata']['cost_'.$i]  = round($sum['cost'.$i],2); 
		}
		die(json_encode($json));
	}
	
	
	
	public function deliverSummary_exporter() {
	    $this->common_model->checkpurview(47);
		$name = 'deliver_summary_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('商品收发汇总表导出:'.$name); 
		$storageNo  = str_enhtml($this->input->get_post('storageNo',TRUE));
		$goodsNo    = str_enhtml($this->input->get_post('goodsNo',TRUE));
		$data['beginDate'] = $beginDate  = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']   = $endDate    = str_enhtml($this->input->get_post('endDate',TRUE));
		$where  = 'a.isDelete=0';
		$where .= $storageNo ? ' and d.locationNo in('.str_quote($storageNo).')' : ''; 
		$where .= $goodsNo ? ' and b.number in('.str_quote($goodsNo).')' : ''; 
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : '';
		$where .= $this->common_model->get_location_purview();
		$data['list']   = $this->data_model->get_deliverSummary($where.' group by a.invId,a.locationId',$beginDate,$endDate); 
		$this->load->view('report/deliverSummary-exporter',$data);	
	}
	
	 

	public function cash_bank_journal_new() {
	    $this->common_model->checkpurview(106);
	    $data['accountNo']  = $accountNo   = intval($this->input->get_post('accountNo',TRUE));
		$data['beginDate']  = $beginDate   = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = $endDate     = str_enhtml($this->input->get_post('endDate',TRUE));
		$this->load->view('report/cash-bank-journal-new', $data);	
	}
	
	

	public function bankBalance_detail() {
	    $this->common_model->checkpurview(106);
		$v = array();
		$sum1 = $sum2 = $sum3 = $sum4 = $sum5 = 0;
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100); 
		$accountNo   = str_enhtml($this->input->get_post('accountNo',TRUE));
		$beginDate   = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate     = str_enhtml($this->input->get_post('endDate',TRUE));
		$where1 = 'a.isDelete=0';
		$where1 .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : '';
		$where1 .= $endDate ? ' and a.billDate<="'.$endDate.'"' : '';
		$where1 .= $accountNo ? ' and d.number in('.str_quote($accountNo).')' : ''; 
		$where1 .= $this->common_model->get_admin_purview();
		$where2 = 'a.isDelete=0';
		$where2 .= $accountNo ? ' and a.number in('.str_quote($accountNo).')' : ''; 
		$list1 = $this->data_model->get_account('and billDate<"'.$beginDate.'"',$where2.' order by a.id'); 
		$list2 = $this->data_model->get_account_info($where1.' order by a.billDate');
		foreach ($list1 as $arr=>$row) {
			$v[$arr]['accountName']   = $row['accountName'];
		    $v[$arr]['accountNumber'] = $row['accountNumber'];
			$v[$arr]['billType']      = '期初余额'; 
			$v[$arr]['date']          = '';
			$v[$arr]['buId']          = intval($row['id']);
			$v[$arr]['buName']        = '';
			$v[$arr]['billTypeNo']    = '';
			$v[$arr]['balance']       = $row['amount'];  
			$v[$arr]['billId']        = 0;   
			$v[$arr]['billNo']        = '';   
			$v[$arr]['expenditure']   = 0; 
			$v[$arr]['income']        = 0; 
			$v[$arr]['type']          = 0;   
			foreach ($list2 as $arr1=>$row1) {
			    $arr = time() + $arr1;
			    if ($row['id']==$row1['accId']) {
				    $sum1 += $a1 = $row1['payment']>0 ? abs($row1['payment']) : 0;  
					$sum2 += $a2 = $row1['payment']<0 ? abs($row1['payment']) : 0;  
					$a3 = $row['amount'] + $sum1 - $sum2;
				    $v[$arr]['accountName']   = $row1['accountName'];
					$v[$arr]['accountNumber'] = $row1['accountNumber'];
					$v[$arr]['billType']      = $row1['transTypeName'];
					$v[$arr]['date']          = $row1['billDate']; 
					$v[$arr]['buId']          = intval($row1['buId']);
					$v[$arr]['buName']        = $row1['contactName']; 
					$v[$arr]['billTypeNo']    = '';
					$v[$arr]['balance']       = $a3;  
					$v[$arr]['billId']        = 0;   
					$v[$arr]['billNo']        = $row1['billNo']; ;   
					$v[$arr]['expenditure']   = $a2; 
					$v[$arr]['income']        = $a1; 
					$v[$arr]['type']          = 0;   
				}
			} 
			$sum3 += $sum1;
			$sum4 += $sum2;
			$sum5 += $row['amount'] + $sum1 - $sum2;
			$sum1 = $sum2 = 0; 
		}
		$json['status'] = 200;
		$json['msg']    = 'success';
		$json['data']['list']      = array_values($v);
		$json['data']['total']['accountName']    = '';
		$json['data']['total']['accountNumber']  = '';
		$json['data']['total']['balance']        = $sum5;
		$json['data']['total']['billNo']         = '';
		$json['data']['total']['billTypeNo']     = '';
		$json['data']['total']['billId']         = '';
		$json['data']['total']['billType']       = '';
		$json['data']['total']['buName']         = '';
		$json['data']['total']['buNo']           = '';
		$json['data']['total']['date']           = '';
		$json['data']['total']['expenditure']    = $sum4;   
		$json['data']['total']['income']         = $sum3;
		$json['data']['total']['type']           = '';
		$json['data']['params']['startTime']     = '';
		$json['data']['params']['numberFilter']  = '';
		$json['data']['params']['keyword']       = '';
		$json['data']['params']['dbid']          = '';
		$json['data']['params']['endDate']       = $endDate;
		$json['data']['params']['beginDate']     = $beginDate;
		die(json_encode($json));
	}
	
	

	public function bankBalance_exporter() {
	    $this->common_model->checkpurview(107);
		$name = 'BankBalanc_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('现金银行报表导出:'.$name);
	    $data['accountNo']  = $accountNo   = str_enhtml($this->input->get_post('accountNo',TRUE));
		$data['beginDate']  = $beginDate   = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = $endDate     = str_enhtml($this->input->get_post('endDate',TRUE));
		$where1 = 'a.isDelete=0';
		$where1 .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : '';
		$where1 .= $endDate ? ' and a.billDate<="'.$endDate.'"' : '';
		$where1 .= $accountNo ? ' and d.number in('.str_quote($accountNo).')' : ''; 
		$where1 .= $this->common_model->get_admin_purview();
		$where2 = 'a.isDelete=0';
		$where2 .= $accountNo ? ' and a.number in('.str_quote($accountNo).')' : ''; 
		$data['list1'] = $this->data_model->get_account('and billDate<"'.$beginDate.'"',$where2.' order by a.id'); 
		$data['list2'] = $this->data_model->get_account_info($where1.' order by a.accId desc');
		$this->load->view('report/bankBalance-exporter', $data);	
	}
 

	public function account_pay_detail_new() {
	    $this->common_model->checkpurview(52);
	    $data['accountNo']  = $accountNo  = intval($this->input->get_post('accountNo',TRUE));
		$data['beginDate']  = $beginDate   = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = $endDate     = str_enhtml($this->input->get_post('endDate',TRUE));
		$this->load->view('report/account-pay-detail-new', $data);	
	}
	 

	public function fundBalance_detailSupplier() {
	    $this->common_model->checkpurview(52);
		$sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = 0;
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100); 
		$type = intval($this->input->get_post('type',TRUE)); 
		$accountNo   = str_enhtml($this->input->get_post('accountNo',TRUE));
		$beginDate   = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate     = str_enhtml($this->input->get_post('endDate',TRUE));
		$where1 = ' and (billType="PUR" or billType="PAYMENT")';
		$where2 = 'a.isDelete=0 and a.type=10';
		$where2 .= $accountNo ? ' and a.number="'.$accountNo.'"' : '';
		$list1 = $this->data_model->get_contact('and billDate<"'.$beginDate.'" '.$where1 ,$where2.' order by a.id');
		$where3 = 'a.isDelete=0 and (a.billType="PUR" or a.billType="PAYMENT")';
		$where3 .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : '';
		$where3 .= $endDate ? ' and a.billDate<="'.$endDate.'"' : '';
		$where3 .= ' and (a.billType="PUR" or a.billType="PAYMENT")';
		$where3 .= $this->common_model->get_admin_purview();
		$list2 = $this->data_model->get_invoice($where3.' order by a.billDate');
		foreach ($list1 as $arr=>$row) {
			$v[$arr]['balance']     = $row['amount'];
		    $v[$arr]['billId']      = 0; 
			$v[$arr]['billNo']      = '期初余额'; 
			$v[$arr]['billType']    = 0;
			$v[$arr]['date']        = '';
			$v[$arr]['billTypeNo']  = 0;
			$v[$arr]['buId']        = 0;
			$v[$arr]['buName']      = $row['name'];
			$v[$arr]['number']      = $row['number'];
			$v[$arr]['transType']   = ''; 
			$v[$arr]['type']        = '';  
			$v[$arr]['expenditure'] = ''; 
			$v[$arr]['income']      = ''; 
			foreach ($list2 as $arr1=>$row1) {
			    $arr = time() + $arr1;
				if ($row['id']==$row1['buId']) {
				    $sum1 += $a1 = $row1['billType']=='PUR' ? $row1['arrears'] : 0;          
					$sum2 += $a2 = $row1['billType']=='PAYMENT' ? abs($row1['arrears']) : 0; 
					$a3 = $row['amount'] + $sum1 - $sum2;
					$v[$arr]['balance']     = $a3;   
					$v[$arr]['billId']      = $row1['id']; 
					$v[$arr]['billNo']      = $row1['billNo']; 
					$v[$arr]['date']        = $row1['billDate'];
					$v[$arr]['billTypeNo']  = $row1['billType'];
					$v[$arr]['buId']        = $row1['buId'];
					$v[$arr]['buName']      = $row1['contactName'];
					$v[$arr]['number']      = $row1['contactNo'];
					$v[$arr]['transType']   = $row1['transTypeName']; 
					$v[$arr]['type']        = -1;  
					$v[$arr]['expenditure'] = $a2; 
					$v[$arr]['income']      = $a1;  
				}
			}
			$sum3 = $row['amount'] + $sum1 - $sum2;
			$arr  = $arr + $row['id'];
			$v[$arr]['balance']     = $sum3;
		    $v[$arr]['billId']      = 0; 
			$v[$arr]['billNo']      = '小计'; 
			$v[$arr]['date']        = '';
			$v[$arr]['billTypeNo']  = 0;
			$v[$arr]['buId']        = 0;
			$v[$arr]['buName']      = '';
			$v[$arr]['number']      = '';
			$v[$arr]['transType']   = ''; 
			$v[$arr]['type']        = -1;  
			$v[$arr]['income']      = $sum1; 
			$v[$arr]['expenditure'] = $sum2; 
			$sum4 += $sum1;
			$sum5 += $sum2;
			$sum6 += $sum3;
		} 
		$json['status'] = 200;
		$json['msg']    = 'success';
		$json['data']['total']['balance']        = $sum6;
		$json['data']['total']['billId']         = '';
		$json['data']['total']['billNo']         = '';
		$json['data']['total']['billTypeNo']     = '';
		$json['data']['total']['buId']           = '';
		$json['data']['total']['buName']         = '';
		$json['data']['total']['date']           = '';
		$json['data']['total']['income']         = $sum4;
		$json['data']['total']['expenditure']    = $sum5;
		$json['data']['total']['number']         = '';
		$json['data']['total']['transType']      = '';
		$json['data']['total']['type']           = '';
		$json['data']['list']                    = isset($v) ? array_values($v) :'';
		$json['data']['params']['startTime']     = '';
		$json['data']['params']['numberFilter']  = '';
		$json['data']['params']['categoryId']    = '';
		$json['data']['params']['keyword']       = '';
		$json['data']['params']['dbid']          = '';
		$json['data']['params']['table']         = '';
		$json['data']['params']['serviceType']   = '';
		$json['data']['params']['customer']      = '';
		$json['data']['params']['type']          = '';
		$json['data']['params']['supplier']      = '';
		$json['data']['params']['endDate']       = $endDate;
		$json['data']['params']['beginDate']     = $beginDate;
		die(json_encode($json)); 
	}
	
	

	public function fundBalance_exporterSupplier() {
	    $this->common_model->checkpurview(53);
		$name = 'pay_balance_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('应付账款明细表导出:'.$name);
		$accountNo   = str_enhtml($this->input->get_post('accountNo',TRUE));
		$data['beginDate']  = $beginDate   = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = $endDate     = str_enhtml($this->input->get_post('endDate',TRUE));
		$where1 = ' and (billType="PUR" or billType="PAYMENT")';
		$where2 = 'a.isDelete=0 and a.type=10';
		$where2 .= $accountNo ? ' and a.number="'.$accountNo.'"' : '';
		$data['list1'] = $this->data_model->get_contact('and billDate<"'.$beginDate.'" '.$where1 ,$where2.' order by a.id');
		$where3 = 'a.isDelete=0 and (a.billType="PUR" or a.billType="PAYMENT")';
		$where3 .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : '';
		$where3 .= $endDate ? ' and a.billDate<="'.$endDate.'"' : '';
		$where3 .= ' and (a.billType="PUR" or a.billType="PAYMENT")';
		$where3 .= $this->common_model->get_admin_purview();
		$data['list2'] = $this->data_model->get_invoice($where3.' order by a.billDate');
		$this->load->view('report/fundBalance-exporterSupplier',$data);
	}
	
	
 

	public function account_proceeds_detail_new() {
	    $this->common_model->checkpurview(55);
	    $data['accountNo']  = $accountNo  = intval($this->input->get_post('accountNo',TRUE));
		$data['beginDate']  = $beginDate   = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = $endDate     = str_enhtml($this->input->get_post('endDate',TRUE));
		$this->load->view('report/account-proceeds-detail-new',$data);	
	}
	
	

	public function fundBalance_detail() {
	    $this->common_model->checkpurview(55);
		$sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = 0;
	    $data['status'] = 200;
		$data['msg']    = 'success';
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100); 
		$type = intval($this->input->get_post('type',TRUE)); 
		$accountNo   = str_enhtml($this->input->get_post('accountNo',TRUE));
		$beginDate   = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate     = str_enhtml($this->input->get_post('endDate',TRUE));
		$where1 = 'and (billType="SALE" or billType="RECEIPT") and billDate<"'.$beginDate.'"';
		$where2 = 'a.isDelete=0 and (a.type=-10)';
		$where2 .= $accountNo ? ' and a.number="'.$accountNo.'"' : '';
		$list1 = $this->data_model->get_contact($where1 ,$where2.' order by a.id');
		$where3 = 'a.isDelete=0  and (a.billType="SALE" or a.billType="RECEIPT")';
		$where3 .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : '';
		$where3 .= $endDate ? ' and a.billDate<="'.$endDate.'"' : '';
		$where3 .= $this->common_model->get_admin_purview();
		$list2 = $this->data_model->get_invoice($where3.' order by a.billDate');
		foreach ($list1 as $arr=>$row) {
			$v[$arr]['balance']     = $row['amount'];
		    $v[$arr]['billId']      = 0; 
			$v[$arr]['billNo']      = '期初余额'; 
			$v[$arr]['billType']    = 0;
			$v[$arr]['date']        = '';
			$v[$arr]['billTypeNo']  = 0;
			$v[$arr]['buId']        = 0;
			$v[$arr]['buName']      = $row['name'];
			$v[$arr]['number']      = $row['number'];
			$v[$arr]['transType']   = ''; 
			$v[$arr]['type']        = '';  
			$v[$arr]['expenditure'] = ''; 
			$v[$arr]['income']      = ''; 
			foreach ($list2 as $arr1=>$row1) {
			    $arr = time() + $arr1;
				if ($row['id']==$row1['buId']) {
				    $sum1 += $a1 = $row1['billType']=='SALE' ? $row1['arrears'] : 0; 
					$sum2 += $a2 = $row1['billType']=='RECEIPT' ? abs($row1['arrears']) : 0; 
					$a3 = $row['amount'] + $sum1 - $sum2;
					$v[$arr]['balance']     = $a3;   
					$v[$arr]['billId']      = $row1['id']; 
					$v[$arr]['billNo']      = $row1['billNo']; 
					$v[$arr]['date']        = $row1['billDate'];
					$v[$arr]['billTypeNo']  = $row1['billType'];
					$v[$arr]['buId']        = $row1['buId'];
					$v[$arr]['buName']      = $row1['contactName'];
					$v[$arr]['number']      = $row1['contactNo'];
					$v[$arr]['transType']   = $row1['transTypeName']; 
					$v[$arr]['type']        = -1;  
					$v[$arr]['expenditure'] = $a2; 
					$v[$arr]['income']      = $a1;  
				}
			}
			$sum3 = $row['amount'] + $sum1 - $sum2;
			$arr  = $arr + $row['id'];
			$v[$arr]['balance']     = $sum3;
		    $v[$arr]['billId']      = 0; 
			$v[$arr]['billNo']      = '小计'; 
			$v[$arr]['date']        = '';
			$v[$arr]['billTypeNo']  = 0;
			$v[$arr]['buId']        = 0;
			$v[$arr]['buName']      = '';
			$v[$arr]['number']      = '';
			$v[$arr]['transType']   = ''; 
			$v[$arr]['type']        = -1;  
			$v[$arr]['income']      = $sum1; 
			$v[$arr]['expenditure'] = $sum2; 
			$sum4 += $sum1;
			$sum5 += $sum2;
			$sum6 += $sum3;
		} 
		$data['data']['total']['balance']      = $sum6;
		$data['data']['total']['billId']       = '';
		$data['data']['total']['billNo']       = '';
		$data['data']['total']['billTypeNo']   = '';
		$data['data']['total']['buId']         = '';
		$data['data']['total']['buName']       = '';
		$data['data']['total']['date']         = '';
		$data['data']['total']['income']       = $sum4;
		$data['data']['total']['expenditure']  = $sum5;
		$data['data']['total']['number']       = '';
		$data['data']['total']['transType']    = '';
		$data['data']['total']['type']         = '';
		$data['data']['list']                  = isset($v) ? array_values($v) :'';
		$data['data']['params']['startTime']     = '';
		$data['data']['params']['numberFilter']  = '';
		$data['data']['params']['categoryId']    = '';
		$data['data']['params']['keyword']       = '';
		$data['data']['params']['dbid']          = '';
		$data['data']['params']['table']         = '';
		$data['data']['params']['serviceType']   = '';
		$data['data']['params']['customer']      = '';
		$data['data']['params']['type']          = '';
		$data['data']['params']['supplier']      = '';
		$data['data']['params']['endDate']       = $endDate;
		$data['data']['params']['beginDate']     = $beginDate;
		die(json_encode($data)); 
	}
	
	

	public function fundBalance_exporter() {
	    $this->common_model->checkpurview(56);
		$name = 'receive_balance_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('应收账款明细表导出:'.$name);
		$accountNo   = str_enhtml($this->input->get_post('accountNo',TRUE));
		$data['beginDate']  = $beginDate   = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = $endDate     = str_enhtml($this->input->get_post('endDate',TRUE));
		$where1 = 'and (billType="SALE" or billType="RECEIPT") and billDate<"'.$beginDate.'"';
		$where2 = 'a.isDelete=0 and (a.type=-10)';
		$where2 .= $accountNo ? ' and a.number="'.$accountNo.'"' : '';
		$data['list1'] = $this->data_model->get_contact($where1 ,$where2.' order by a.id');
		$where3 = 'a.isDelete=0  and (a.billType="SALE" or a.billType="RECEIPT")';
		$where3 .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : '';
		$where3 .= $endDate ? ' and a.billDate<="'.$endDate.'"' : '';
		$where3 .= $this->common_model->get_admin_purview();
		$data['list2'] = $this->data_model->get_invoice($where3.' order by a.billDate');
		$this->load->view('report/fundBalance-exporter',$data);	
	}
	
	
 

	public function customers_reconciliation_new() {
	    $this->common_model->checkpurview(109);
	    $data['customerId'] = $customerId  = intval($this->input->get_post('customerId',TRUE));
		$data['customerName']  = str_enhtml($this->input->get_post('customerName',TRUE));
		$data['beginDate']  = $beginDate   = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = $endDate     = str_enhtml($this->input->get_post('endDate',TRUE));
		$this->load->view('report/customers-reconciliation-new',$data);	
	}
	
 

	public function customerBalance_detail() {
	    $this->common_model->checkpurview(109);
		$sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = 0;
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100); 
		$showDetail   = str_enhtml($this->input->get_post('showDetail',TRUE));
		$customerId   = intval($this->input->get_post('customerId',TRUE));
		$customerName = str_enhtml($this->input->get_post('customerName',TRUE));
		$beginDate    = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate      = str_enhtml($this->input->get_post('endDate',TRUE));
		$list1 = $this->data_model->get_contact('and billDate<"'.$beginDate.'" and buId='.$customerId,'a.isDelete=0 and a.id="'.$customerId.'"',1);
		$where = 'a.isDelete=0 and (a.billType="SALE" or a.billType="RECEIPT")';
		$where .= ' and a.buId='.$customerId;
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : '';
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : '';
		$where .= $this->common_model->get_admin_purview();
		$list2 = $this->data_model->get_invoice($where.' order by a.id');
		$arrears = count($list1)>0 ? $list1['amount'] : 0;   
        $v[0]['amount']        = 0;
	    $v[0]['billId']        = 0; 
		$v[0]['billNo']        = '期初余额'; 
		$v[0]['billType']      = 'BAL'; 
		$v[0]['date']          = '';
		$v[0]['disAmount']     = 0;
		$v[0]['entryId']       = 0; 
		$v[0]['inAmount']      = $arrears;                   
		$v[0]['invName']       = ''; 
		$v[0]['invNo']         = ''; 
		$v[0]['price']         = '';  
		$v[0]['qty']           = '';  
		$v[0]['spec']          = '';
		$v[0]['rpAmount']      = 0;  
		$v[0]['totalAmount']   = 0;  
		$v[0]['transType']     = '';   
		$v[0]['type']          = -1;   
		$v[0]['unit']          = ''; 
		foreach ($list2 as $arr=>$row) {
		    $arr = $arr + 1;
		    $sum1 += $row['arrears'];             
			$sum2 += $row['amount'];               
			$sum3 += $row['totalAmount'];          
			$sum4 += $row['rpAmount'];             
			$sum5 += $row['disAmount'];            
			$v[$arr]['amount']      = (float)$row['amount']; 
		    $v[$arr]['billId']      = intval($row['id']); 
			$v[$arr]['billNo']      = $row['billNo']; 
			$v[$arr]['billType']    = $row['billType']; 
			$v[$arr]['date']        = $row['billDate'];
			$v[$arr]['disAmount']   = $row['disAmount'];
			$v[$arr]['entryId']     = 0; 
			$v[$arr]['inAmount']    = $sum1 + $arrears;     
			$v[$arr]['invName']     = ''; 
			$v[$arr]['invNo']       = ''; 
			$v[$arr]['price']       = '';  
			$v[$arr]['qty']         = '';  
			$v[$arr]['spec']        = '';
			$v[$arr]['rpAmount']    = $row['rpAmount'];  
			$v[$arr]['totalAmount'] = $row['totalAmount'];    
			$v[$arr]['transType']   = $row['transTypeName'];   
			$v[$arr]['type']        = 1;   
			$v[$arr]['unit']        = ''; 
			if ($showDetail == "true") {
			    if ($row['billType']=='SALE') {
					$postData = unserialize($row['postData']);
					foreach ($postData['entries'] as $arr1=>$row1) {
						$arr1 = time() + $arr;
						$v[$arr1]['amount']       = 0;
						$v[$arr1]['billId']       = intval($row['id']); 
						$v[$arr1]['billNo']       = ''; 
						$v[$arr1]['billType']     = ''; 
						$v[$arr1]['date']         = '';
						$v[$arr1]['disAmount']    = 0;
						$v[$arr1]['entryId']      = 1; 
						$v[$arr1]['inAmount']     = $sum1 + $arrears;  
						$v[$arr1]['invName']      = isset($row1['invName']) ? $row1['invName'] :'';
						$v[$arr1]['invNo']        = isset($row1['invNumber']) ? $row1['invNumber'] :'';
						$v[$arr1]['price']        = isset($row1['price']) ? $row1['price'] :'';   
						$v[$arr1]['qty']          = isset($row1['qty']) ? $row1['qty'] :0;   
						$v[$arr1]['rpAmount']     = 0;  
						$v[$arr1]['spec']         = isset($row1['invSpec']) ? $row1['invSpec'] :'';    
						$v[$arr1]['totalAmount']  = isset($row1['amount']) ? $row1['amount'] :0;   
						$v[$arr1]['transType']    = '';   
						$v[$arr1]['type']         = '';   
						$v[$arr1]['unit']         = 0; 
					}
				}
			} 
		}
		$data['status'] = 200;
		$data['msg']    = 'success';
		$data['data']['customerId']              = $customerId;
		$data['data']['showDetail']              = (bool)$showDetail;
		$data['data']['total']['amount']         = $sum2;
		$data['data']['total']['billNo']         = '';
		$data['data']['total']['billTypeNo']     = '';
		$data['data']['total']['billId']         = '';
		$data['data']['total']['billType']       = '';
		$data['data']['total']['buName']         = '';
		$data['data']['total']['buNo']           = '';
		$data['data']['total']['date']           = '';
		$data['data']['total']['disAmount']      = $sum5;
		$data['data']['total']['inAmount']       = $arrears + $sum1;
		$data['data']['total']['entryId']        = '';
		$data['data']['total']['invName']        = '';
		$data['data']['total']['invNo']          = '';
		$data['data']['total']['price']          = '';
		$data['data']['total']['qty']            = '';
		$data['data']['total']['rpAmount']       = $sum4;
		$data['data']['total']['spec']           = '';
		$data['data']['total']['totalAmount']    = $sum3;
		$data['data']['total']['transType']      = '';
		$data['data']['total']['type']           = '';
		$data['data']['total']['unit']           = '';
		$data['data']['list']                    = isset($v) ? array_values($v) : array();  
		die(json_encode($data));	
	}
	

	public function customerBalance_exporter() {
	    $this->common_model->checkpurview(110);
		$name = 'contact_balance_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('客户对账单导出:'.$name);
		$data['showDetail'] = $showDetail   = str_enhtml($this->input->get_post('showDetail',TRUE));
	    $data['customerId'] = $customerId  = intval($this->input->get_post('customerId',TRUE));
		$data['customerName']  = str_enhtml($this->input->get_post('customerName',TRUE));
		$data['beginDate']  = $beginDate   = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = $endDate     = str_enhtml($this->input->get_post('endDate',TRUE));
		$data['list1'] = $this->data_model->get_contact('and billDate<"'.$beginDate.'" and buId='.$customerId,'a.isDelete=0 and a.id="'.$customerId.'"',1);
		$where = 'a.isDelete=0';
		$where .= ' and a.buId='.$customerId;
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : '';
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : '';
		$where .= $this->common_model->get_admin_purview();
		$data['list2'] = $this->data_model->get_invoice($where.' order by a.id');
		$this->load->view('report/customerBalance-exporter',$data);	
	}
	

	public function suppliers_reconciliation_new() {
	    $this->common_model->checkpurview(112);
	    $data['supplierId'] = $supplierId  = intval($this->input->get_post('supplierId',TRUE));
		$data['supplierName']  = str_enhtml($this->input->get_post('supplierName',TRUE));
		$data['beginDate']  = $beginDate   = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = $endDate     = str_enhtml($this->input->get_post('endDate',TRUE));
		$this->load->view('report/suppliers-reconciliation-new',$data);	
	}
	

	public function supplierBalance_detail() {
	    $this->common_model->checkpurview(112);
		$sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = 0;
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100); 
		$showDetail   = str_enhtml($this->input->get_post('showDetail',TRUE));
		$supplierId   = intval($this->input->get_post('supplierId',TRUE));
		$supplierName = str_enhtml($this->input->get_post('supplierName',TRUE));
		$beginDate    = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate      = str_enhtml($this->input->get_post('endDate',TRUE));
		$list1 = $this->data_model->get_contact('and billDate<"'.$beginDate.'" and buId='.$supplierId,'a.isDelete=0 and a.id="'.$supplierId.'"',1);
		$where = 'isDelete=0 and (billType="PUR" or billType="PAYMENT")';
		$where .= ' and buId='.$supplierId;
		$where .= $beginDate ? ' and billDate>="'.$beginDate.'"' : '';
		$where .= $endDate ? ' and billDate<="'.$endDate.'"' : '';
		$where .= $this->common_model->get_admin_purview();
		$list2 = $this->data_model->get_invoice($where.' order by a.id');
		$arrears = count($list1)>0 ? $list1['amount'] : 0;   
		$v[0]['amount']        = 0;
	    $v[0]['billId']        = 0; 
		$v[0]['billNo']        = '期初余额'; 
		$v[0]['billType']      = 'BAL'; 
		$v[0]['date']          = '';
		$v[0]['disAmount']     = 0;
		$v[0]['entryId']       = 0; 
		$v[0]['inAmount']      = $arrears;   
		$v[0]['invName']       = ''; 
		$v[0]['invNo']         = ''; 
		$v[0]['price']         = '';  
		$v[0]['qty']           = '';  
		$v[0]['spec']          = '';
		$v[0]['rpAmount']      = 0;  
		$v[0]['totalAmount']   = 0;  
		$v[0]['transType']     = '';   
		$v[0]['type']          = -1;   
		$v[0]['unit']          = ''; 
		foreach ($list2 as $arr=>$row) {
		    $arr = $arr + 1;
		    $sum1 += $row['arrears']; 
			$sum2 += $row['amount'];              
			$sum3 += $row['totalAmount'];          
			$sum4 += $row['rpAmount'];            
			$sum5 += $row['disAmount'];           
			$v[$arr]['amount']      = (float)$row['amount'];
		    $v[$arr]['billId']      = intval($row['id']); 
			$v[$arr]['billNo']      = $row['billNo']; 
			$v[$arr]['billType']    = $row['billType']; 
			$v[$arr]['date']        = $row['billDate'];
			$v[$arr]['disAmount']   = $row['disAmount'];
			$v[$arr]['entryId']     = 0; 
			$v[$arr]['inAmount']    = $sum1 + $arrears;  
			$v[$arr]['invName']     = ''; 
			$v[$arr]['invNo']       = ''; 
			$v[$arr]['price']       = '';  
			$v[$arr]['qty']         = '';  
			$v[$arr]['spec']        = '';
			$v[$arr]['rpAmount']    = $row['rpAmount'];  
			$v[$arr]['totalAmount'] = $row['totalAmount'];  
			$v[$arr]['transType']   = $row['transTypeName'];   
			$v[$arr]['type']        = 1;   
			$v[$arr]['unit']        = ''; 
			if ($showDetail == "true") {
			    if ($row['billType']=='PUR') {
					$postData = unserialize($row['postData']);
					foreach ($postData['entries'] as $arr1=>$row1) {
						$arr1 = time() + $arr;
						$v[$arr1]['amount']       = 0;
						$v[$arr1]['billId']       = intval($row['id']); 
						$v[$arr1]['billNo']       = ''; 
						$v[$arr1]['billType']     = ''; 
						$v[$arr1]['date']         = '';
						$v[$arr1]['disAmount']    = 0;
						$v[$arr1]['entryId']      = 1; 
						$v[$arr1]['inAmount']     = $sum1 + $arrears;  
						$v[$arr1]['invName']      = isset($row1['invName']) ? $row1['invName'] :'';
						$v[$arr1]['invNo']        = isset($row1['invNumber']) ? $row1['invNumber'] :'';
						$v[$arr1]['price']        = isset($row1['price']) ? $row1['price'] :'';   
						$v[$arr1]['qty']          = isset($row1['qty']) ? $row1['qty'] :0;   
						$v[$arr1]['rpAmount']     = 0;  
						$v[$arr1]['spec']         = isset($row1['invSpec']) ? $row1['invSpec'] :'';    
						$v[$arr1]['totalAmount']  = isset($row1['amount']) ? $row1['amount'] :0;  
						$v[$arr1]['transType']    = '';   
						$v[$arr1]['type']         = '';   
						$v[$arr1]['unit']         = 0; 
					}
				}
			} 
		}
		$data['status'] = 200;
		$data['msg']    = 'success';
		$data['data']['supplierId']              = $supplierId;
		$data['data']['showDetail']              = (bool)$showDetail;
		$data['data']['total']['amount']         = $sum2;
		$data['data']['total']['billNo']         = '';
		$data['data']['total']['billTypeNo']     = '';
		$data['data']['total']['billId']         = '';
		$data['data']['total']['billType']       = '';
		$data['data']['total']['buName']         = '';
		$data['data']['total']['buNo']           = '';
		$data['data']['total']['date']           = '';
		$data['data']['total']['disAmount']      = $sum5;
		$data['data']['total']['inAmount']       = $arrears + $sum1;
		$data['data']['total']['entryId']        = '';
		$data['data']['total']['invName']        = '';
		$data['data']['total']['invNo']          = '';
		$data['data']['total']['price']          = '';
		$data['data']['total']['qty']            = '';
		$data['data']['total']['rpAmount']       = $sum4;
		$data['data']['total']['spec']           = '';
		$data['data']['total']['totalAmount']    = $sum3;
		$data['data']['total']['transType']      = '';
		$data['data']['total']['type']           = '';
		$data['data']['total']['unit']           = '';
		$data['data']['list']                    = isset($v) ? array_values($v) : array();  
		die(json_encode($data));	
	}
	
	

	public function supplierBalance_exporter() {
	    $this->common_model->checkpurview(113);
		$name = 'supplier_balance_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('供应商对账单导出:'.$name);
		$data['showDetail'] = $showDetail   = str_enhtml($this->input->get_post('showDetail',TRUE));
	    $data['supplierId'] = $supplierId  = intval($this->input->get_post('supplierId',TRUE));
		$data['supplierName']  = str_enhtml($this->input->get_post('supplierName',TRUE));
		$data['beginDate']  = $beginDate   = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = $endDate     = str_enhtml($this->input->get_post('endDate',TRUE));
		$data['list1'] = $this->data_model->get_contact('and billDate<"'.$beginDate.'" and (billType="PUR" or billType="PAYMENT") and buId='.$supplierId,'a.isDelete=0 and a.id="'.$supplierId.'"',1);
		$where = 'isDelete=0';
		$where .= ' and buId='.$supplierId;
		$where .= $beginDate ? ' and billDate>="'.$beginDate.'"' : '';
		$where .= $endDate ? ' and billDate<="'.$endDate.'"' : '';
		$where .= $this->common_model->get_admin_purview();
		$data['list2'] = $this->data_model->get_invoice($where.' order by a.id');
		$this->load->view('report/supplierBalance-exporter',$data);	
	}
	
	

	public function other_income_expense_detail() {
	    $this->common_model->checkpurview(115);
	    $data['supplierId'] = $supplierId  = intval($this->input->get_post('supplierId',TRUE));
		$data['beginDate']  = $beginDate   = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = $endDate     = str_enhtml($this->input->get_post('endDate',TRUE));
		$this->load->view('report/other-income-expense-detail',$data);	
	}
	

	public function oriDetail_detail() {
	    $this->common_model->checkpurview(115);
		$payment1 = $payment2 = 0;
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100); 
		$transType    = str_enhtml($this->input->get_post('transType',TRUE));
	    $typeName  = str_enhtml($this->input->get_post('typeName',TRUE));
		$beginDate  = str_enhtml($this->input->get_post('beginDate',TRUE));
		$endDate    = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0 and (a.transType=153401 or a.transType=153402)';
		$where .= $transType ? ' and a.transType='.$transType : ''; 
		$where .= $typeName  ? ' and c.name="'.$typeName.'"' : ''; 
		$where .= $beginDate ? ' and a.billDate>="'.$beginDate.'"' : '';
		$where .= $endDate ? ' and a.billDate<="'.$endDate.'"' : '';
		$where .= $this->common_model->get_admin_purview();
		$offset = $rows * ($page-1);                     
		$list   = $this->data_model->get_account_info($where.' order by a.billDate'); 
		foreach ($list as $arr=>$row) {
		    $v[$arr]['date']           = $row['billDate'];
			$v[$arr]['billId']         = intval($row['iid']);
		    $v[$arr]['billNo']         = $row['billNo'];
			$v[$arr]['transType']      = $row['transType'];
			$v[$arr]['transTypeName']  = $row['transTypeName'];
			$v[$arr]['contactNumber']  = $row['contactNo'];
			$v[$arr]['contactName']    = $row['contactName'];
			$v[$arr]['desc']           = $row['remark'];  
			$v[$arr]['typeName']       = $row['categoryName'];  
			if ($row['transType']==153401) {
				$payment1 += $v[$arr]['amountIn']       = $row['payment'];       
			} else {
				$payment2 += $v[$arr]['amountOut']      = abs($row['payment']);   
			}
		}
		$data['status'] = 200;
		$data['msg']    = 'success';
		$data['data']['page']      = $page;
		$data['data']['records']   = $this->data_model->get_account_info($where,3);   
		$data['data']['total']     = ceil($data['data']['records']/$rows);       
		$data['data']['rows']                      = isset($v) ? $v : array();
		$data['data']['userdata']['date']          = '';
		$data['data']['userdata']['billId']        = '';
		$data['data']['userdata']['billNo']        = '';
		$data['data']['userdata']['transType']     = '';
		$data['data']['userdata']['transTypeName'] = '';
		$data['data']['userdata']['contactNumber'] = '';
		$data['data']['userdata']['contactName']   = '';
		$data['data']['userdata']['desc']          = '';
		$data['data']['userdata']['typeName']      = '';
		$data['data']['userdata']['amountIn']      = $payment1;
		$data['data']['userdata']['amountOut']     = $payment2;
		die(json_encode($data));
	}
 
	 

	public function oriDetail_export() {
	    $this->common_model->checkpurview(116);
		$name = 'ori_detail_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('其他收支明细表导出:'.$name);
	    $data['transType']  = str_enhtml($this->input->get_post('transType',TRUE));
	    $data['typeName']   = str_enhtml($this->input->get_post('typeName',TRUE));
		$data['beginDate']  = str_enhtml($this->input->get_post('beginDate',TRUE));
		$data['endDate']    = str_enhtml($this->input->get_post('endDate',TRUE));
		$where = 'a.isDelete=0 and (a.transType=153401 or a.transType=153402)';
		$where .= $data['transType'] ? ' and a.transType='.$data['transType'] : ''; 
		$where .= $data['typeName']  ? ' and c.name="'.$data['typeName'].'"' : ''; 
		$where .= $data['beginDate'] ? ' and a.billDate>="'.$data['beginDate'].'"' : '';
		$where .= $data['endDate'] ? ' and a.billDate<="'.$data['endDate'].'"' : '';
		$where .= $this->common_model->get_admin_purview();
		$data['list'] = $this->data_model->get_account_info($where.' order by a.billDate'); 
		$this->load->view('report/oriDetail_export',$data);	
	}
	 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */