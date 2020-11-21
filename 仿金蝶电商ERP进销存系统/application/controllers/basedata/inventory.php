<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inventory extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
    }
	
    //商品列表
	public function index() {
		$page = max(intval($this->input->get_post('page',TRUE)),1);
		$rows = max(intval($this->input->get_post('rows',TRUE)),100);
		$skey = str_enhtml($this->input->get_post('skey',TRUE));
		$categoryid   = intval($this->input->get_post('assistId',TRUE));
		$barCode = intval($this->input->get_post('barCode',TRUE));
		$where = '(a.isDelete=0)';
		$where .= $skey ? ' and (sonGoods like "%'.$skey.'%" or name like "%'.$skey.'%" or number like "%'.$skey.'%" or spec like "%'.$skey.'%")' : '';
		$where .= $barCode ? ' and barCode="'.$barCode.'"' : '';
		if ($categoryid > 0) {
		    $cid = array_column($this->mysql_model->get_results('category','(isDelete=0) and find_in_set('.$categoryid.',path)'),'id'); 
			if (count($cid)>0) {
			    $cid = join(',',$cid);
			    $where .= ' and categoryid in('.$cid.')';
			} 
		}          
		$list = $this->data_model->get_goods($where.' order by a.id desc limit '.$rows*($page-1).','.$rows);
		foreach ($list as $arr=>$row) {
		    $v[$arr]['amount']        = (float)$row['iniamount'];
			$v[$arr]['barCode']       = $row['barCode'];
			$v[$arr]['categoryName']  = $row['categoryName'];
			$v[$arr]['currentQty']    = $row['totalqty'];                            //当前库存
			$v[$arr]['delete']        = intval($row['disable'])==1 ? true : false;   //是否禁用
			$v[$arr]['discountRate']  = 0;
			$v[$arr]['id']            = intval($row['id']);
			$v[$arr]['isSerNum']      = intval($row['isSerNum']);
			$v[$arr]['josl']          = $row['josl'];
			$v[$arr]['name']          = $row['name'];
			$v[$arr]['number']        = $row['number'];
			$v[$arr]['pinYin']        = $row['pinYin'];
			$v[$arr]['locationId']    = intval($row['locationId']);
			$v[$arr]['locationName']  = $row['locationName'];
			$v[$arr]['locationNo']    = '';
			$v[$arr]['purPrice']      = $row['purPrice'];
			$v[$arr]['quantity']      = $row['iniqty'];
			$v[$arr]['salePrice']     = $row['salePrice'];
			$v[$arr]['skuClassId']    = $row['skuClassId'];
			$v[$arr]['spec']          = $row['spec'];
			$v[$arr]['unitCost']      = $row['iniunitCost'];
			$v[$arr]['unitId']        = intval($row['unitId']);
			$v[$arr]['unitName']      = $row['unitName'];
			$v[$arr]['remark']        = $row['remark'];
			
		}
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['page']      = $page;                                                            
		$json['data']['records']   = $this->data_model->get_goods($where,3);    
		$json['data']['total']     = ceil($json['data']['records']/$rows);                   
		$json['data']['rows']      = isset($v) ? $v :'';
		die(json_encode($json));
   
	}
	
	//商品选择 最近出售价格
	public function listBySelected() { 
	    $arr = array('so'=>150601,'sa'=>150501);
	    $contactid = intval($this->input->post('contactId',TRUE));
		$type = str_enhtml($this->input->post('type',TRUE));
		$id   = intval($this->input->post('ids',TRUE));
		$list = $this->data_model->get_invoice_info('a.isDelete=0 and transType='.$arr[$type].' and a.invId='.$id.' and a.buId='.$contactid.' limit 0,3',2);
		foreach ($list as $arr=>$row) {
		    $v[$arr]['advanceDays']  = 0;
		    $v[$arr]['amount']       = (float)$row['amount'];
			$v[$arr]['barCode']      = '';
			$v[$arr]['categoryName'] = '';
			$v[$arr]['currentQty']   = 0;                                          
			$v[$arr]['delete']       = false;   
			$v[$arr]['discountRate'] = 0;
			$v[$arr]['id']           = intval($row['invId']);
			$v[$arr]['isSerNum']     = 0;
			$v[$arr]['isWarranty']   = 0;
			$v[$arr]['josl']         = '';
			$v[$arr]['locationId']   = intval($row['locationId']);
			$v[$arr]['locationName'] = $row['locationName'];
			$v[$arr]['locationNo']   = $row['locationNo'];
			$v[$arr]['name']         = $row['invName'];
			$v[$arr]['nearPrice']    = $row['price'];
			$v[$arr]['number']       = $row['invNumber'];
			$v[$arr]['pinYin']       = $row['pinYin'];
			$v[$arr]['purPrice']     = $row['purPrice'];
			$v[$arr]['quantity']     = $row['quantity'];
			$v[$arr]['salePrice']    = $row['salePrice'];
			$v[$arr]['skuClassId']   = 0;
			$v[$arr]['skuId']        = 0;
			$v[$arr]['skuName']      = 0;
			$v[$arr]['skuNumber']    = 0;
			$v[$arr]['spec']         = $row['invSpec'];
			$v[$arr]['unitCost']     = 0;
			$v[$arr]['unitId']       = intval($row['unitId']);
			$v[$arr]['unitName']     = $row['mainUnit'];
		}
		$json['status'] = 200;
		$json['msg']    = 'success';
		$json['data']['result']      = isset($v) ? $v : array();
		die(json_encode($json)); 
	}
	
	
	//获取信息
	public function query() {
	    $id = intval($this->input->post('id',TRUE));
		str_alert(200,'success',$this->get_goods_info($id)); 
	}
	
	
	//检测编号
	public function getNextNo() {
		$skey = str_enhtml($this->input->post('skey',TRUE));
		$this->mysql_model->get_count('goods',array('isDelete'=>0,'number'=>$skey)) > 0 && str_alert(-1,'商品编号已经存在');
		str_alert(200,'success');
	}
	
	//检测条码 
	public function checkBarCode() {
		 $barCode = str_enhtml($this->input->post('barCode',TRUE));
		 $this->mysql_model->get_count('goods',array('isDelete'=>0,'barCode'=>$barCode)) > 0 && str_alert(-1,'商品条码已经存在');
		 str_alert(200,'success');
	}
	
	//检测规格
	public function checkSpec() {
		 $spec = str_enhtml($this->input->post('spec',TRUE));
		 $this->mysql_model->get_count('assistsku',array('isDelete'=>0,'skuName'=>$spec)) > 0 && str_alert(-1,'商品规格已经存在');
		 str_alert(200,'success');
	}
	
	//检测名称
	public function checkname() {
		 $skey = str_enhtml($this->input->post('barCode',TRUE));
		 echo '{"status":200,"msg":"success","data":{"number":""}}';
	}
	
	//获取图片信息
	public function getImagesById() {
	    $id = intval($this->input->post('id',TRUE));
	    $list = $this->mysql_model->get_results('goods_img',array('isDelete'=>0,'invId'=>$id));
		foreach ($list as $arr=>$row) {
		    $v[$arr]['pid']          = $row['id'];
			$v[$arr]['status']       = 1;
			$v[$arr]['name']         = $row['name'];
			$v[$arr]['url']          = site_url().'/basedata/inventory/getImage?action=getImage&pid='.$row['id'];
			$v[$arr]['thumbnailUrl'] = site_url().'/basedata/inventory/getImage?action=getImage&pid='.$row['id'];
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
	    require_once './application/libraries/UploadHandler.php';
		$config = array(
			'script_url' => base_url().'inventory/uploadimages',
			'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']).'/data/upfile/goods/',
			'upload_url' => base_url().'data/upfile/goods/',
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
		$files[0]['url']          = site_url().'/basedata/inventory/getImage?action=getImage&pid='.$newid;
		$files[0]['thumbnailUrl'] = site_url().'/basedata/inventory/getImage?action=getImage&pid='.$newid;
		$files[0]['deleteUrl']    = '';
		$files[0]['deleteType']   = '';
		$json['status'] = 200;
		$json['msg']    = 'success';
		$json['files']  = $files;
        die(json_encode($json)); 
	}
	
	//保存上传图片信息
	public function addImagesToInv() {
	    $data = $this->input->post('postData');
		if (strlen($data)>0) {
		    $v = $s = array();
		    $data = (array)json_decode($data, true); 
			$id   = isset($data['id']) ? $data['id'] : 0;
		    !isset($data['files']) || count($data['files']) < 1 && str_alert(-1,'请先添加图片！'); 
			foreach($data['files'] as $arr=>$row) {
			    if ($row['status']==1) {
					$v[$arr]['id']       = $row['pid'];
					$v[$arr]['invId']    = $id;
				} else {
				    $s[$arr]['id']       = $row['pid'];
					$s[$arr]['invId']    = $id;
					$s[$arr]['isDelete'] = 1;
				}
			}
			$this->mysql_model->update('goods_img',array_values($v),'id');
			$this->mysql_model->update('goods_img',array_values($s),'id');
			str_alert(200,'success'); 
	    }
		str_alert(-1,'保存失败'); 
	}
	
	//获取图片信息
	public function getImage() {
	    $id = intval($this->input->get_post('pid',TRUE));
	    $data = $this->mysql_model->get_rows('goods_img',array('id'=>$id));
		if (count($data)>0) {
		    $url     = './data/upfile/goods/'.$data['name'];
			$info    = getimagesize($url);  
			$imgdata = fread(fopen($url,'rb'),filesize($url));   
			header('content-type:'.$info['mime'].'');  
			echo $imgdata;   
		}	 
	}
     
	//新增
	public function add(){
		$this->common_model->checkpurview(69);
		$data = $this->input->post(NULL,TRUE);
		if ($data) {
			$data = $this->validform($data);
			$this->mysql_model->get_count('goods',array('isDelete'=>0,'number'=>$data['number'])) > 0 && str_alert(-1,'商品编号重复');
			$this->db->trans_begin();
			$info = array(
			    'barCode','baseUnitId','unitName','categoryId','categoryName','propertys',
				'discountRate1','discountRate2','highQty','locationId','pinYin',
				'locationName','lowQty','name','number','purPrice','warehouseWarning',
				'remark','salePrice','spec','vipPrice','wholesalePrice','warehousePropertys','sonGoods','dopey'
			);
			//add by michen 20170715
			$data['dopey']=0;
			if(strlen($data['sonGoods'])>0){
				$sonlist = (array)json_decode($data['sonGoods'],true) ;
				if(count($sonlist)>0){
				    $data['dopey']=1;
				    foreach ($sonlist as $sonkey => $sonrow){
				        if(empty($sonrow['gid']))
				            str_alert(-1,'您所选择的商品ID不存在！请重新选择！');
				        else if($this->mysql_model->get_count('goods',array('isDelete'=>0,'id'=>$sonrow['gid'],'number'=>$sonrow['number'])) <= 0)
				            str_alert(-1,'您所选择的子商品编号“'.$sonrow['number'].'”不存在！请重新选择！');
				    }
				}
			}
			$info = elements($info,$data,NULL);			
			$data['id'] = $this->mysql_model->insert('goods',$info);
			if (strlen($data['propertys'])>0) {                            
				$list = (array)json_decode($data['propertys'],true);
				foreach ($list as $arr=>$row) {
					$v[$arr]['invId']         = $data['id'];
					$v[$arr]['locationId']    = intval($row['locationId']);
					$v[$arr]['qty']           = (float)$row['quantity']; 
					$v[$arr]['price']         = (float)$row['unitCost']; 
					$v[$arr]['amount']        = (float)$row['amount']; 
					$v[$arr]['skuId']         = intval($row['skuId']);  
					$v[$arr]['billDate']      = date('Y-m-d');;
					$v[$arr]['billNo']        = '期初数量';
					$v[$arr]['billType']      = 'INI';
					$v[$arr]['transTypeName'] = '期初数量';
				} 
				if (isset($v)) {
					$this->mysql_model->insert('invoice_info',$v);
				}
			}
			if (strlen($data['warehousePropertys'])>0) {    
			    $list = (array)json_decode($data['warehousePropertys'],true);
				foreach ($list as $arr=>$row) {
					$s[$arr]['invId']         = $data['id'];
					$s[$arr]['locationId']    = intval($row['locationId']);
					$s[$arr]['highQty']       = (float)$row['highQty']; 
					$s[$arr]['lowQty']        = (float)$row['lowQty']; 
				} 
				if (isset($s)) {
					$this->mysql_model->insert('warehouse',$s);
				}     
			}
            if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误回滚');
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('新增商品:'.$data['name']);
				str_alert(200,'success',$data);
			}
		}
		str_alert(-1,'添加失败');
	} 
	
	//修改
	public function update(){
		$this->common_model->checkpurview(70);
		$data = $this->input->post(NULL,TRUE);
		if ($data) {
			$data = $this->validform($data);
			$this->mysql_model->get_count('goods',array('id !='=>$data['id'],'isDelete'=>0,'number'=>$data['number'])) > 0 && str_alert(-1,'商品编号重复');
			$this->db->trans_begin();
			$info = array(
			    'barCode','baseUnitId','unitName','categoryId','categoryName','propertys',
				'discountRate1','discountRate2','highQty','locationId','pinYin',
				'locationName','lowQty','name','number','purPrice','warehouseWarning',
				'remark','salePrice','spec','vipPrice','wholesalePrice','warehousePropertys','sonGoods','dopey'
			);
			//add by michen 20170715
			$data['dopey']=0;
			if(strlen($data['sonGoods'])>0){
				$sonlist = (array)json_decode($data['sonGoods'],true) ;
			    if(count($sonlist)>0){
				    $data['dopey']=1;
				    foreach ($sonlist as $sonkey => $sonrow){
				        if(empty($sonrow['gid']))
				            str_alert(-1,'您所选择的商品ID不存在！请重新选择！');
				        else if($this->mysql_model->get_count('goods',array('isDelete'=>0,'id'=>$sonrow['gid'],'number'=>$sonrow['number'])) <= 0)
				            str_alert(-1,'您所选择的子商品编号“'.$sonrow['number'].'”不存在！请重新选择！');
				    }
				}
			}
			$info = elements($info, $data,NULL);			
			$this->mysql_model->update('goods',$info,array('id'=>$data['id']));
			if (strlen($data['propertys'])>0) {                          
				$list = (array)json_decode($data['propertys'],true);
				foreach ($list as $arr=>$row) {
					$v[$arr]['invId']         = $data['id'];
					$v[$arr]['locationId']    = isset($row['locationId']) ? $row['locationId'] : 0;
					$v[$arr]['qty']           = isset($row['quantity']) ? $row['quantity']:0; 
					$v[$arr]['price']         = isset($row['unitCost']) ? $row['unitCost']:0; 
					$v[$arr]['amount']        = isset($row['amount']) ? $row['amount']:0; 
					$v[$arr]['skuId']         = isset($row['skuId']) ? $row['skuId']:0;  
					$v[$arr]['billDate']      = date('Y-m-d');
					$v[$arr]['billNo']        = '期初数量';
					$v[$arr]['billType']      = 'INI';
					$v[$arr]['transTypeName'] = '期初数量';
				} 
				if (isset($v)) {
				    $this->mysql_model->delete('invoice_info',array('invId'=>$data['id'],'billType'=>'INI'));
					$this->mysql_model->insert('invoice_info',$v);
				}
			}
			if (strlen($data['warehousePropertys'])>0) {    
			    $list = (array)json_decode($data['warehousePropertys'],true);
				foreach ($list as $arr=>$row) {
					$s[$arr]['invId']         = $data['id'];
					$s[$arr]['locationId']    = isset($row['locationId']) ? $row['locationId'] : 0;
					$s[$arr]['highQty']       = isset($row['highQty']) ? $row['highQty']:0; 
					$s[$arr]['lowQty']        = isset($row['lowQty']) ? $row['lowQty']:0;  	
				} 
				if (isset($s)) {
				    $this->mysql_model->delete('warehouse',array('invId'=>$data['id']));
					$this->mysql_model->insert('warehouse',$s);
				}     
			}
            if ($this->db->trans_status() === FALSE) {
			    $this->db->trans_rollback();
				str_alert(-1,'SQL错误回滚');
			} else {
			    $this->db->trans_commit();
				$this->common_model->logs('修改商品:ID='.$data['id'].'名称:'.$data['name']);
				str_alert(200,'success',$this->get_goods_info($data['id']));
			}	 
		}
		str_alert(-1,'修改失败');
	} 
	
	//删除
	public function delete(){
		$this->common_model->checkpurview(71);
		$id = str_enhtml($this->input->post('id',TRUE));
		$data = $this->mysql_model->get_results('goods','(id in('.$id.')) and (isDelete=0)'); 
		if (count($data) > 0) {
		    $this->mysql_model->get_count('invoice_info','(invId in('.$id.')) and (isDelete=0)')>0 && str_alert(-1,'其中有商品发生业务不可删除');
		    $sql  = $this->mysql_model->update('goods',array('isDelete'=>1),'(id in('.$id.'))');   
		    if ($sql) {
			    $name = array_column($data,'name'); 
				$this->common_model->logs('删除商品:ID='.$id.' 名称:'.join(',',$name));
				str_alert(200,'success',array('msg'=>'','id'=>'['.$id.']'));
			}
			str_alert(-1,'删除失败');
		}
	}
	
    //导出
	public function exporter() {
	    $this->common_model->checkpurview(72);
		$name = 'goods_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('导出商品:'.$name);
		$skey = str_enhtml($this->input->get_post('skey',TRUE));
		$categoryid   = intval($this->input->get_post('assistId',TRUE));
		$barCode      = intval($this->input->get_post('barCode',TRUE));
		$where = '(a.isDelete=0)';
		$where .= $skey ? ' and (name like "%'.$skey.'%" or number like "%'.$skey.'%" or spec like "%'.$skey.'%")' : '';
		$where .= $barCode ? ' and barCode="'.$barCode.'"' : '';
		if ($categoryid > 0) {
		    $cid = array_column($this->mysql_model->get_results('category','(isDelete=1) and find_in_set('.$categoryid.',path)'),'id'); 
			if (count($cid)>0) {
			    $cid = join(',',$cid);
			    $where .= ' and categoryid in('.$cid.')';
			} 
		}  
		$data['storage']  =  array_column($this->mysql_model->get_results('storage'),'name','id'); 
		$data['list']     = $this->data_model->get_goods($where.' order by a.id desc');  
        $this->load->view('settings/goods-export',$data);
		  
	}
	
	//状态
	public function disable(){
		$this->common_model->checkpurview(72);
		$disable = intval($this->input->post('disable',TRUE));
		$id = str_enhtml($this->input->post('invIds',TRUE));
		if (strlen($id) > 0) { 
			$sql = $this->mysql_model->update('goods',array('disable'=>$disable),'(id in('.$id.'))');
		    if ($sql) {
				$this->common_model->logs('商品'.$disable==1?'禁用':'启用'.':ID:'.$id.'');
				str_alert(200,'success');
			}
		}
		str_alert(-1,'操作失败');
	}
	
	//库存预警 
	public function listinventoryqtywarning() {
		$locationId  = intval($this->input->get_post('locationId',TRUE));
		$warnType    = intval($this->input->get_post('warnType',TRUE));
		$assistId    = intval($this->input->get_post('assistId',TRUE));
		$skey        = str_enhtml($this->input->get_post('skey',TRUE));
		$page        = max(intval($this->input->get_post('page',TRUE)),1);
		$rows        = max(intval($this->input->get_post('rows',TRUE)),20);
		$where = 'a.isDelete=0';
		if ($warnType==1) {
		    $having = 'HAVING qty<lowQty'; 
		} elseif($warnType==2) {
		    $having = 'HAVING qty>highQty'; 
		} else {
		    $having = 'HAVING qty>highQty or qty<lowQty'; 
		}
		if ($assistId > 0) {
		    $cid = array_column($this->mysql_model->get_results('category','(isDelete=1) and find_in_set('.$assistId.',path)'),'id'); 
			if (count($cid)>0) {
			    $cid = join(',',$cid);
			    $where .= ' and b.categoryId in('.$cid.')';
			} 
		}
		$where .= $skey ? ' and (b.name like "%'.$skey.'%" or b.number like "%'.$skey.'%" or b.spec like "%'.$skey.'%")' : '';
		$where .= $locationId>0 ? ' and a.locationId='.$locationId.'' : '';
		$where .= $this->common_model->get_location_purview();
		$offset = $rows*($page-1);                           
		$list = $this->data_model->get_inventory($where.' GROUP BY invId,locationId '.$having.' limit '.$offset.','.$rows);    
		foreach ($list as $arr=>$row) {
			$v[$arr]['highQty']       = (float)$row['highQty']; 
			$v[$arr]['id']            = intval($row['invId']);
			$v[$arr]['lowQty']        = (float)$row['lowQty']; 
			$v[$arr]['name']          = $row['invName'];
			$v[$arr]['locationName']  = $row['locationName'];
			$v[$arr]['number']        = $row['invNumber'];
			$v[$arr]['categoryName']  = $row['categoryName'];
			$v[$arr]['warning']       = $row['qty1'] > 0 ? $row['qty1'] : $row['qty2']; 
			$v[$arr]['qty']           = (float)$row['qty'];
			$v[$arr]['unitName']      = $row['unitName'];
			$v[$arr]['spec']          = $row['invSpec'];
		}
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['page']      = $page;                                                            
		$json['data']['records']   = $this->data_model->get_inventory($where.' GROUP BY invId,locationId '.$having,3);    
		$json['data']['total']     = ceil($json['data']['records']/$rows); 
		$json['data']['rows']      = isset($v) ? array_values($v) : array();
		die(json_encode($json));
	} 
	
	
	public function warningExporter() {
	    $this->common_model->checkpurview();
		$name = 'InventoryWarning_'.date('YmdHis').'.xls';
		sys_csv($name);
		$this->common_model->logs('导出库存预警商品:'.$name);
		$locationId  = intval($this->input->get_post('locationId',TRUE));
		$warnType    = intval($this->input->get_post('warnType',TRUE));
		$assistId    = intval($this->input->get_post('assistId',TRUE));
		$skey        = str_enhtml($this->input->get_post('skey',TRUE));
		$where = 'a.isDelete=0';
		if ($warnType==1) {
		    $having = 'HAVING qty<lowQty'; 
		} elseif($warnType==2) {
		    $having = 'HAVING qty>highQty'; 
		} else {
		    $having = 'HAVING qty>highQty or qty<lowQty'; 
		}
		if ($assistId > 0) {
		    $cid = array_column($this->mysql_model->get_results('category','(isDelete=1) and find_in_set('.$assistId.',path)'),'id'); 
			if (count($cid)>0) {
			    $cid = join(',',$cid);
			    $where .= ' and b.categoryId in('.$cid.')';
			} 
		}
		$where .= $skey ? ' and (b.name like "%'.$skey.'%" or b.number like "%'.$skey.'%" or b.spec like "%'.$skey.'%")' : '';
		$where .= $locationId>0 ? ' and a.locationId='.$locationId.'' : ''; 
		$where .= $this->common_model->get_location_purview();
		$data['list']  = $this->data_model->get_inventory($where.' GROUP BY invId,locationId '.$having);    
		$this->load->view('settings/inventory-warning-exporter',$data);
	} 
	
	 
	
	//通过ID 获取商品信息
	private function get_goods_info($id) {
	    $data = $this->mysql_model->get_rows('goods',array('id'=>$id,'isDelete'=>0));
		if (count($data)>0) {
			$data['id']            = $id; 
			$data['count']         = 0;
			$data['name']          = $data['name'];
			$data['spec']          = $data['spec'];
			$data['number']        = $data['number'];
			$data['salePrice']     = (float)$data['salePrice'];
			$data['purPrice']      = (float)$data['purPrice'];
			$data['wholesalePrice']= (float)$data['wholesalePrice'];
			$data['vipPrice']      = (float)$data['vipPrice'];
			$data['discountRate1'] = (float)$data['discountRate1'];
			$data['discountRate2'] = (float)$data['discountRate2'];
			$data['unitTypeId']    = intval($data['unitTypeId']);
			$data['baseUnitId']    = intval($data['baseUnitId']);
			$data['locationId']    = intval($data['locationId']);
			$data['assistIds']     = '';
			$data['assistName']    = '';
			$data['assistUnit']    = '';
			$data['remark']        = $data['remark'];
			$data['categoryId']    = intval($data['categoryId']);
			$data['unitId']        = intval($data['unitId']); 
			$data['length']        = ''; 
			$data['weight']        = ''; 
			$data['jianxing']      = ''; 
			$data['barCode']       = $data['barCode'];
			$data['josl']          = ''; 
			$data['warehouseWarning']          = intval($data['warehouseWarning']); 
			$data['warehouseWarningSku']       = 0; 
			$data['skuClassId']          = 0; 
			$data['isSerNum']            = 0; 
			$data['pinYin']              = $data['pinYin'];
			$data['delete']              = false; 
			$data['isWarranty']    = 0;
			$data['safeDays']      = 0; 
			$data['advanceDay']    = 0; 
			$data['property']      = $data['property'] ? $data['property'] : NULL;
			$propertys = $this->data_model->get_invoice_info('a.isDelete=0 and a.invId='.$id.' and a.billType="INI"'); 
			foreach ($propertys as $arr=>$row) { 
				$v[$arr]['id']            = intval($row['id']);
				$v[$arr]['locationId']    = intval($row['locationId']);
				$v[$arr]['inventoryId']   = intval($row['invId']);
				$v[$arr]['locationName']  = $row['locationName'];
				$v[$arr]['quantity']      = (float)$row['qty'];
				$v[$arr]['unitCost']      = (float)$row['price'];
				$v[$arr]['amount']        = (float)$row['amount'];
				$v[$arr]['skuId']         = intval($row['skuId']);
				$v[$arr]['skuName']       = '';
				$v[$arr]['date']          = $row['billDate'];
				$v[$arr]['tempId']        = 0;
				$v[$arr]['batch']         = '';
				$v[$arr]['invSerNumList'] = '';
			} 
			$data['propertys']            = isset($v) ? $v : array();
			if ($data['warehousePropertys']) {
			    $warehouse = (array)json_decode($data['warehousePropertys'],true);
				foreach ($warehouse as $arr=>$row) { 
					$s[$arr]['locationId']    = intval($row['locationId']);
					$s[$arr]['locationName']  = $row['locationName'];
					$s[$arr]['highQty']       = (float)$row['highQty'];
					$s[$arr]['lowQty']        = (float)$row['lowQty'];
				} 
			}
			$data['warehousePropertys']   = isset($s) ? $s : array();
			if (strlen($data['sonGoods'])>0) {
				$list = (array)json_decode($data['sonGoods'],true);
				foreach ($list as $arr=>$row) {
					$v[$arr]['number']          = $row['number'];
					$v[$arr]['name']            = $row['name'];
					$v[$arr]['spec']            = $row['spec'];
					$v[$arr]['unitName']        = $row['unitName'];
					$v[$arr]['qty']             = intval($row['qty']);
					$v[$arr]['salePrice']       = intval($row['salePrice']);
					$v[$arr]['gid']             = intval($row['gid']);//add by michen 20170719
				}
			}
			$data['sonGoods']  = isset($v) ? $v : array();
			
		}
		return $data;
	}
	
	
	//公共验证
	private function validform($data) {
	    $this->load->library('lib_cn2pinyin');
	    strlen($data['name']) < 1 && str_alert(-1,'商品名称不能为空');
		strlen($data['number']) < 1 && str_alert(-1,'商品编号不能为空');
		$data['categoryId'] = intval($data['categoryId']);
		$data['baseUnitId'] = intval($data['baseUnitId']);
		$data['categoryId'] < 1 && str_alert(-1,'商品类别不能为空');
		$data['baseUnitId'] < 1 && str_alert(-1,'计量单位不能为空');
		$data['id']        = isset($data['id']) ? intval($data['id']):0;
		$data['lowQty']    = isset($data['lowQty']) ? (float)$data['lowQty'] :0;
		$data['highQty']   = isset($data['highQty']) ? (float)$data['highQty']:0;
		$data['purPrice']  = isset($data['purPrice']) ? (float)$data['purPrice']:0;
		$data['salePrice'] = isset($data['salePrice']) ? (float)$data['salePrice']:0;
		$data['vipPrice']  = isset($data['vipPrice']) ? (float)$data['vipPrice']:0;
		$data['warehouseWarning']  = isset($data['warehouseWarning']) ? intval($data['warehouseWarning']):0;
		$data['discountRate1']  = (float)$data['discountRate1'];
		$data['discountRate2']  = (float)$data['discountRate2'];
		$data['wholesalePrice'] = isset($data['wholesalePrice']) ? (float)$data['wholesalePrice']:0;
		$data['unitName']     = $this->mysql_model->get_row('unit',array('id'=>$data['baseUnitId']),'name');
		$data['categoryName'] = $this->mysql_model->get_row('category',array('id'=>$data['categoryId']),'name');
		$data['pinYin'] = $this->lib_cn2pinyin->encode($data['name']); 
		!$data['categoryName'] && str_alert(-1,'商品类别不存在');
	    if (strlen($data['propertys'])>0) {                            
			$list         = (array)json_decode($data['propertys'],true);
			$storage      = $this->mysql_model->get_results('storage',array('disable'=>0));  
			$locationId   =  array_column($storage,'id'); 
			$locationName =  array_column($storage,'name','id');
			foreach ($list as $arr=>$row) {
				!in_array($row['locationId'],$locationId) && str_alert(-1,$locationName[$row['locationId']].'仓库不存在或不可用！'); 
			} 
		}
		$data['warehousePropertys'] = isset($data['warehousePropertys']) ? $data['warehousePropertys'] :'[]';
		$data['warehousePropertys'] = count(json_decode($data['warehousePropertys'],true))>0 ? $data['warehousePropertys'] :'';
		return $data;
	}  
	
	


}


		    
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */