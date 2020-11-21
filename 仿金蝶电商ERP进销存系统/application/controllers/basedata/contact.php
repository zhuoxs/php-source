<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

    public function __construct(){
        parent::__construct();
		$this->common_model->checkpurview();
    }
	
    //客户、供应商列表
	public function index() {
		$type   = intval($this->input->get('type',TRUE))==10 ? 10 : -10;
		$skey   = str_enhtml($this->input->get_post('skey',TRUE));
		$page   = max(intval($this->input->get_post('page',TRUE)),1);
		$categoryid   = intval($this->input->get_post('categoryId',TRUE));
		$rows   = max(intval($this->input->get_post('rows',TRUE)),100);
		$where  = '(isDelete=0) and type='.$type;
		$where .= $this->common_model->get_contact_purview();
	    $where .= $skey ? ' and (number like "%'.$skey.'%" or name like "%'.$skey.'%" or linkMans like "%'.$skey.'%")' : '';
		$where .= $categoryid>0 ? ' and cCategory = '.$categoryid.'' : '';                
		$list = $this->mysql_model->get_results('contact',$where,'id desc',$rows*($page-1),$rows); 
		//if($type == 10){
    		foreach ($list as $arr=>$row) {
    		    $v[$arr]['id']           = intval($row['id']);
    			$v[$arr]['number']       = $row['number'];
    			$v[$arr]['cCategory']    = intval($row['cCategory']);
    			$v[$arr]['customerType'] = $row['cCategoryName'];
    			$v[$arr]['pinYin']       = $row['pinYin'];
    			$v[$arr]['name']         = $row['name'];
    			$v[$arr]['type']         = $row['type'];
    			$v[$arr]['delete']       = intval($row['disable'])==1 ? true : false;  
    			$v[$arr]['cLevel']       = intval($row['cLevel']);
    			$v[$arr]['amount']       = (float)$row['amount'];
    			$v[$arr]['periodMoney']  = (float)$row['periodMoney'];
    			$v[$arr]['difMoney']     = (float)$row['difMoney'];
    			$v[$arr]['remark']       = $row['remark'];
    			$v[$arr]['taxRate']      = (float)$row['taxRate'];
    			$v[$arr]['links']        = '';
    			$v[$arr]['linkMen']      = $row['linkMans'];//add by michen 20170724
    			if (strlen($row['linkMans'])>0) {                            
    				$list = (array)json_decode($row['linkMans'],true);
    				foreach ($list as $arr1=>$row1) {
    					if ($row1['linkFirst']==1) {
    						$v[$arr]['contacter']            = $row1['linkName']; 
    						$v[$arr]['mobile']               = $row1['linkMobile']; 
    						$v[$arr]['place']               = $row1['linkPlace'];
    						$v[$arr]['telephone']            = $row1['linkPhone']; 
    						$v[$arr]['linkIm']               = $row1['linkIm']; 
    						$v[$arr]['city']                 = $row1['city']; 
    						$v[$arr]['county']               = $row1['county']; 
    			            $v[$arr]['province']             = $row1['province']; 
    						$v[$arr]['deliveryAddress']      = $row1['address']; 
    						$v[$arr]['firstLink']['first']   = $row1['linkFirst']; 
    					}
    				} 
    		    }
    		}
		/*}else{
		    //add by michen 20170720 begin
		    $gid = 1;
		    foreach ($list as $arr=>$row) {
		        $v[$arr]['id']           = intval($row['id']);
		        $v[$arr]['number']       = $row['number'];
		        $v[$arr]['cCategory']    = intval($row['cCategory']);
		        $v[$arr]['customerType'] = $row['cCategoryName'];
		        $v[$arr]['pinYin']       = $row['pinYin'];
		        $v[$arr]['name']         = $row['name'];
		        $v[$arr]['type']         = $row['type'];
		        $v[$arr]['delete']       = intval($row['disable'])==1 ? true : false;
		        $v[$arr]['cLevel']       = intval($row['cLevel']);
		        $v[$arr]['amount']       = (float)$row['amount'];
		        $v[$arr]['periodMoney']  = (float)$row['periodMoney'];
		        $v[$arr]['difMoney']     = (float)$row['difMoney'];
		        $v[$arr]['remark']       = $row['remark'];
		        $v[$arr]['taxRate']      = (float)$row['taxRate'];
		        $v[$arr]['links']        = '';
		        $i = 1;
		        if (strlen($row['linkMans'])>0) {
		        				$list = (array)json_decode($row['linkMans'],true);
		        				foreach ($list as $arr1=>$row1) {
		        				    if ($i==1) {
		        				        $v[$arr]['contacter']            = $row1['linkName'];
		        				        $v[$arr]['mobile']               = $row1['linkMobile'];
		        				        $v[$arr]['place']                = $row1['linkPlace'];
		        				        $v[$arr]['telephone']            = $row1['linkPhone'];
		        				        $v[$arr]['linkIm']               = $row1['linkIm'];
		        				        $v[$arr]['city']                 = $row1['city'];
		        				        $v[$arr]['county']               = $row1['county'];
		        				        $v[$arr]['province']             = $row1['province'];
		        				        $v[$arr]['deliveryAddress']      = $row1['address'];
		        				        $v[$arr]['firstLink']['first']   = $row1['linkFirst'];
		        				        $v[$arr]['isFirst']              = $row1['linkFirst']==1?1:2;
		        				        $v[$arr]['gid']      = $gid;
		        				    }else{
		        				        $v[$arr.$i]['id']           = intval($row['id']);
		        				        $v[$arr.$i]['number']       = $row['number'];
		        				        $v[$arr.$i]['cCategory']    = intval($row['cCategory']);
		        				        $v[$arr.$i]['customerType'] = $row['cCategoryName'];
		        				        $v[$arr.$i]['pinYin']       = $row['pinYin'];
		        				        $v[$arr.$i]['name']         = $row['name'];
		        				        $v[$arr.$i]['type']         = $row['type'];
		        				        $v[$arr.$i]['delete']       = intval($row['disable'])==1 ? true : false;
		        				        $v[$arr.$i]['cLevel']       = intval($row['cLevel']);
		        				        $v[$arr.$i]['amount']       = (float)$row['amount'];
		        				        $v[$arr.$i]['periodMoney']  = (float)$row['periodMoney'];
		        				        $v[$arr.$i]['difMoney']     = (float)$row['difMoney'];
		        				        $v[$arr.$i]['remark']       = $row['remark'];
		        				        $v[$arr.$i]['taxRate']      = (float)$row['taxRate'];
		        				        $v[$arr.$i]['links']        = '';
		        				        $v[$arr.$i]['contacter']            = $row1['linkName'];
		        				        $v[$arr.$i]['mobile']               = $row1['linkMobile'];
		        				        $v[$arr.$i]['place']                = $row1['linkPlace'];
		        				        $v[$arr.$i]['telephone']            = $row1['linkPhone'];
		        				        $v[$arr.$i]['linkIm']               = $row1['linkIm'];
		        				        $v[$arr.$i]['city']                 = $row1['city'];
		        				        $v[$arr.$i]['county']               = $row1['county'];
		        				        $v[$arr.$i]['province']             = $row1['province'];
		        				        $v[$arr.$i]['deliveryAddress']      = $row1['address'];
		        				        $v[$arr.$i]['firstLink']['first']   = $row1['linkFirst'];
		        				        $v[$arr.$i]['isFirst']              = $row1['linkFirst']==1?1:2;
		        				        $v[$arr]['gid']      = $gid;
		        				    }
		        				    $i++;
		        				    $gid++;
		        				}
		        }
		    }
		    //add by michen 20170720 end
		}
		//add by michen 20170720 begin
		uasort($v,function ($x,$y){
                  return strcasecmp($x['id'].$x['isFirst'],$y['id'].$x['isFirst']);
                }
		      );
		$values = array_values($v);
		//add by michen 20170720 end
		*/
		$json['status'] = 200;
		$json['msg']    = 'success'; 
		$json['data']['page']      = $page;                                                      
		$json['data']['records']   = $this->mysql_model->get_count('contact',$where);  
		$json['data']['total']     = ceil($json['data']['records']/$rows);   
		$json['data']['rows']      = isset($v) ? array_values($v) : array();
		die(json_encode($json));
	}
	
	//校验客户编号 
	public function getNextNo(){
	     $type = intval($this->input->get('type',TRUE));
		 $skey = intval($this->input->post('skey',TRUE));
		 str_alert(200,'success',array('number'=>$skey)); 
	}
	
	
	//检测客户名称
	public function checkName(){
	    $id   = intval($this->input->post('id',TRUE));
		$name = str_enhtml($this->input->post('name',TRUE));
		$where['name']      = $name;
		$where['isDelete']  = 0;
		$where['id !='] = $id>0 ? $id :'';
	    $data = $this->mysql_model->get_rows('contact',array_filter($where)); 
		if (count($data)>0) {
		    str_alert(-1,'客户名称重复'); 
		}
		str_alert(200,'success'); 
	}
	
	function my_filter($item){
	    if($item['linkFirst'] === 1)
	        return true;
	    else
	    return false;
	}
	
	public function getRecentlyContact(){
		$billType  = str_enhtml($this->input->post('billType',TRUE));
		$transType = intval($this->input->post('transType',TRUE));
		$where = '(isDelete=0)'; 
		$where .= ($transType==150501||$transType==150502) ? ' and type=10' :' and type=-10';//mody by michen 20170820 修正购货退货单默认供应商不正确
		$where .= $this->common_model->get_contact_purview();
	    $data = $this->mysql_model->get_rows('contact',$where); 
	    //die(var_export($data,true));
		if (count($data)>0) {
		    //add by michen 20170724 begin
		    /*$linkMen = (array)json_decode($data['linkMans'],true);
		    $linkMan = "null";
		    if(count($linkMen)>0){
		        foreach ($linkMen as $key => $item){
		            if($item['linkFirst'] === 1){
		                $linkMan = $item;
		                break;
		             }
		        }
		    }*/
		    //add by michen 20170724 end
			die('{"status":200,"msg":"success","data":{"linkMen":'.$data['linkMans'].',"contactName":"'.$data['name'].'","buId":'.$data['id'].',"cLevel":0}}');
		} else {
		    str_alert(-1,''); 
		}
	}
	
	public function getLinkMen(){
	    $buId  = intval($this->input->get('buId',TRUE));
	    $data = $this->mysql_model->get_rows('contact','(isDelete=0) and id='.$buId);
	    die($data['linkMans']);
	}
 
 
	//获取信息
	public function query() {    
	    $id   = intval($this->input->get_post('id',TRUE));
		$type = intval($this->input->get_post('type',TRUE));
		$data = $this->mysql_model->get_rows('contact',array('isDelete'=>0,'id'=>$id));
		if (count($data)>0) {
			$info['id']           = $id;
			$info['cCategory']    = intval($data['cCategory']);
			$info['cLevel']       = intval($data['cLevel']);
			$info['number']       = $data['number'];
			$info['name']         = $data['name'];
			$info['amount']       = (float)$data['amount'];
			$info['remark']       = $data['remark'];
			$info['beginDate']    = $data['beginDate'];
			$info['periodMoney']  = (float)$data['periodMoney'];
			$info['difMoney']     = (float)$data['difMoney'];
			if ($type==10) {
			    $info['taxRate']  = (float)$data['taxRate'];
			}
			$info['pinYin']       = $data['pinYin'];
			if (strlen($data['linkMans'])>0) {                            
				$list = (array)json_decode($data['linkMans'],true);
				foreach ($list as $arr=>$row) {
					$v[$arr]['address']         = $row['address'];
					$v[$arr]['city']            = $row['city'];
					$v[$arr]['contactId']       = $id;
					$v[$arr]['county']          = $row['county'];
					$v[$arr]['email']           = isset($row['email']) ? $row['email'] : '';
					$v[$arr]['first']           = $row['linkFirst']==1 ? true : ''; 
					$v[$arr]['id']              = $id;
					$v[$arr]['im']              = $row['linkIm'];
					$v[$arr]['mobile']          = $row['linkMobile'];
					$v[$arr]['place']          = $row['linkPlace']; 
					$v[$arr]['name']            = $row['linkName'];
					$v[$arr]['phone']           = $row['linkPhone'];
					$v[$arr]['province']        = $row['province'];
					$v[$arr]['tempId']          = 0;
				} 
		    }
			$info['links']  = isset($v) ? $v : array();
			$json['status'] = 200;
			$json['msg']    = 'success'; 
			$json['data']   = $info;                                                      
			die(json_encode($json));
		}  
		str_alert(-1,'没有数据');
	}
	
	//新增
	public function add(){
		$data = $this->validform($this->input->post(NULL,TRUE));
		switch ($data['type']) {
			case 10:
				$this->common_model->checkpurview(59);
				$success = '新增客户:';	
				break;  
			case -10:
				$this->common_model->checkpurview(64);
				$success = '新增供应商:';	
				break;  			 
			default: 
				str_alert(-1,'参数错误');
		}	
		$this->mysql_model->get_count('contact',array('isDelete'=>0,'type'=>$data['type'],'number'=>$data['number'])) > 0 && str_alert(-1,'编号重复');
		$data = elements(array(
					'name','number','amount','beginDate','cCategory',
					'cCategoryName','cLevel','cLevelName','linkMans'
					,'periodMoney','remark','type','difMoney'),$data,NULL);
		$sql = $this->mysql_model->insert('contact',$data);
		if ($sql) {
			$data['id'] = $sql;
			$data['cCategory'] = intval($data['cCategory']);
			$data['linkMans']  = (array)json_decode($data['linkMans'],true);
			$this->common_model->logs($success.$data['name']);
			str_alert(200,'success',$data);
		}
		str_alert(-1,'添加失败');
	}
	
	
	//修改
	public function update(){
		$data = $this->validform($this->input->post(NULL,TRUE));
		switch ($data['type']) {
			case 10:
				$this->common_model->checkpurview(60);
				$success = '修改客户:';	
				break;  
			case -10:
				$this->common_model->checkpurview(65);
				$success = '修改供应商:';	
				break;  			 
			default: 
				str_alert(-1,'参数错误');
		}	
		$this->mysql_model->get_count('contact',array('id !='=>$data['id'],'isDelete'=>0,'type'=>$data['type'],'number'=>$data['number'])) > 0 && str_alert(-1,'编号重复');
		$info = elements(array(
					'name','number','amount','beginDate','cCategory',
					'cCategoryName','cLevel','cLevelName','linkMans'
					,'periodMoney','remark','type','difMoney'),$data,NULL);
		$sql = $this->mysql_model->update('contact',$info,array('id'=>$data['id']));
		if ($sql) {
			$data['cCategory']    = intval($data['cCategory']);
			$data['customerType'] = $data['cCategoryName'];
			$data['linkMans']     = (array)json_decode($data['linkMans'],true);
			$this->common_model->logs($success.$data['name']);
			str_alert(200,'success',$data);
		}
		str_alert(-1,'更新失败');
	}
	
	//删除
	public function delete(){
	    $id   = str_enhtml($this->input->post('id',TRUE));
		$type = intval($this->input->get_post('type',TRUE))==10 ? 10 : -10;
		switch ($type) {
			case 10:
				$this->common_model->checkpurview(61);
				$success = '删除客户:';	
				break;  
			case -10:
				$this->common_model->checkpurview(66);
				$success = '删除供应商:';	
				break;  			 
			default: 
				str_alert(-1,'参数错误');
		}	
		$data = $this->mysql_model->get_results('contact','(id in('.$id.'))'); 
		if (count($data) > 0) {
		    $info['isDelete'] = 1;
		    $this->mysql_model->get_count('invoice','(isDelete=0) and (buId in('.$id.'))')>0 && str_alert(-1,'不能删除有业务往来的客户或供应商！');
		    $sql = $this->mysql_model->update('contact',$info,'(id in('.$id.'))');   
		    if ($sql) {
			    $name = array_column($data,'name'); 
				$this->common_model->logs($success.'ID='.$id.' 名称:'.join(',',$name));
				die('{"status":200,"msg":"success","data":{"msg":"","id":['.$id.']}}');
			}
		}
		str_alert(-1,'客户或供应商不存在');
	}
	
	
	//状态
	public function disable(){
		$this->common_model->checkpurview();
		$disable = intval($this->input->post('disable',TRUE));
		$id = str_enhtml($this->input->post('contactIds',TRUE));
		if (strlen($id) > 0) { 
			$sql = $this->mysql_model->update('contact',array('disable'=>$disable),'(id in('.$id.'))');
		    if ($sql) {
				$this->common_model->logs('客户'.$disable==1?'禁用':'启用'.':ID:'.$id.'');
				str_alert(200,'success');
			}
		}
		str_alert(-1,'操作失败');
	}
	
	//公共验证
	private function validform($data) {
	    $this->load->library('lib_pinyin');
	    strlen($data['name']) < 1 && str_alert(-1,'名称不能为空');
		strlen($data['number']) < 1 && str_alert(-1,'编号不能为空');
		$data['cCategory']     = intval($data['cCategory']);
		$data['cLevel']        = (float)$data['cLevel'];
		$data['taxRate']       = isset($data['taxRate']) ? (float)$data['taxRate'] :0;
		$data['periodMoney']   = (float)$data['periodMoney'];
		$data['amount']        = (float)$data['amount'];
		$data['linkMans']      = $data['linkMans'] ? $data['linkMans'] :"[]";
		$data['beginDate']     = $data['beginDate'] ? $data['beginDate'] : date('Y-m-d');
		$data['type']          = intval($this->input->get_post('type',TRUE))==10 ? 10 : -10;
		$data['pinYin']        = $this->lib_pinyin->str2pinyin($data['name']);
		$data['contact']       = $data['number'].' '.$data['name'];
		$data['difMoney']      = $data['amount'] - $data['periodMoney'];
		$data['cCategoryName'] = $this->mysql_model->get_row('category',array('id'=>$data['cCategory']),'name');
		$data['cCategory'] < 1 && str_alert(-1,'类别名称不能为空');
		return $data;
	}  
	
	 
   
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */