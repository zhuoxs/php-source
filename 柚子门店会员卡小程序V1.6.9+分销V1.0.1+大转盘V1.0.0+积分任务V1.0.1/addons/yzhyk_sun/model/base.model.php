<?php
require_once IA_ROOT."/addons/yzhyk_sun/inc/func/func.php";

class base{
	public $pre_fix = 'yzhyk_sun_';
	public $required_fields = array();//必填
	public $unique = array();//唯一分组
	public $order = '';//默认排序
	public $has_uniacid = true;//是否有 uniacid 字段
	public $where = '';//默认条件
    public $auto_update_time = false;//'update_time';//自动添加更新时间
    public $auto_create_time = false;//'create_time';//自动添加更新时间
//    public $relations = array( //关联
//        array(
//            'as'=>'t2',
//            'table'=>'goodsclass',
//            'on'=>array(
//                'id'=>'class_id',
//            ),
//            'columns'=>array(
//                'name'=>'class_name',
//            ),
//        ),
//    );


	// 通过 id 获取数据
	public function get_data_by_id($id = 0){
		// p($id);
		$info = pdo_get($this->get_table_name(),array('id'=>$id));
		// p($info);
		return $info;
	}
	// 插入数据
	public function insert($data){
		global $_W, $_GPC;
		if($this->has_uniacid){
			$data['uniacid'] = $_W['uniacid'] ?: $_SESSION['admin']['uniacid'];
		}

		$this->check_required($data);

		$this->check_unique($data);

		$res = pdo_insert($this->get_table_name(),$data);
		$id = pdo_insertid();

		if ($res) {
			return array(
				'code'=>'0',
				'data'=>$id,
			);
		}else{
            throw new ZhyException('新增失败');
        }

	}
	// 更新数据
	public function update($data,$where){
		// $this->check_required($data);

		// $this->check_unique($data);

		$res = pdo_update($this->get_table_name(),$data,$where);
		
		if ($res === false) {
            throw new ZhyException('更新失败');
        }
        return array(
            'code'=>'0',
            'data'=>$res,
        );
	}
	// 通过 id 更新数据
	public function update_by_id($data,$id){
	    //自动维护更新时间字段
		if ($this->auto_update_time){
		    $field = $this->auto_update_time === true?'update_time':$this->auto_update_time;
		    $data[$field] = time();
        }

	    // $this->check_required($data);

		// $this->check_unique($data,$id);

		$old_data= $this->get_data_by_id($id);
		$res = pdo_update($this->get_table_name(),$data,array('id'=>$id));

		if ($res === false) {
            throw new ZhyException('更新失败');
        }
        return array(
            'code'=>'0',
            'data'=>$res,
        );
	}
	// 删除数据
	public function delete($where){
		$res = pdo_delete($this->get_table_name(),$where);
		return $res;
	}
	// 通过 id 删除数据
	public function delete_by_id($id){
		$res = pdo_delete($this->get_table_name(),array('id'=>$id));
		return $res;
	}

	public function query($where= [], $limit=[], $order=[]){
		global $_W, $_GPC;

		$sql = "select * from ".$this->get_full_table_name();
		
		// where
		$where_sql = '';
		if($this->has_uniacid){
			$uniacid = $_W['uniacid'] ?: $_SESSION['admin']['uniacid'];
			$where[] ='uniacid = '.$uniacid;
		}
		if($this->where){
			$wehre[] = $this->where;
		}
		if(count($where)){
			$where_sql = ' where '.implode(' and ', $where);
		}

		// order
		$order_sql = '';
		if ($this->order) {
			$order[] = "`$this->order`";
		}
		if (count($order)) {
			$order_sql = ' order by '.implode(',', $order);
		}
		// limit
		$limit_sql = '';
		if ($limit) {
			$pageindex = max(1, intval($limit['page']));
	        $pagesize=$limit['limit']?:10;
	        $limit_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;	
		}
        
        $list = pdo_fetchall($sql.$where_sql.$order_sql.$limit_sql);

        $sql = "select count(*) from ".$this->get_full_table_name();
        $total=pdo_fetchcolumn($sql.$where_sql);

        return array(
        	'code'=>0,
            'count'=>$total,
            'data'=>$list,
            'msg'=>''
        );
	}
    public function query2($where= [], $limit=[], $order=[]){
        global $_W, $_GPC;

        $sql_head = "select t1.*";
        $sql_body = " from ".$this->get_full_table_name()." t1 ";
        // load()->func('logging');

            // logging_run(json_encode($sql_body), 'trace','test333' );
        //判断是否存在关联
        if ($this->relations){
            //遍历关联
            foreach ($this->relations as $relation) {
                //添加引用字段
                foreach ($relation['columns'] as $key => $column) {
                    $sql_head .= ",".$relation['as'].".".$key." as ".$column;
                }
                //添加关联表
                $table = $relation['table'];
                $table = new $table();
                $sql_body .= " left join ".$table->get_full_table_name()." as ".$relation['as'];
                $on = array();
                foreach ($relation['on'] as $key => $value) {
                    if (strstr($value,'.')){
                        $on[] = $relation['as'].'.'.$key." = ".$value;
                    }else{
                        $on[] = $relation['as'].'.'.$key." = t1.".$value;
                    }
                }
                $sql_body .= ' on '.implode(' and ',$on);
            }
        }

        // where
        $where_sql = '';
        if($this->has_uniacid){
            $uniacid = $_W['uniacid'] ?: $_SESSION['admin']['uniacid'];
            $where[] ='t1.uniacid = '.$uniacid;
        }
        if($this->where){
            $wehre[] = $this->where;
        }
        if(count($where)){
            $where_sql = ' where '.implode(' and ', $where);
        }

        // order
        $order_sql = '';
        if ($this->order) {
            $order[] = "`$this->order`";
        }
            

        // if($this->get_full_table_name()=='ims_yzhyk_sun_bill'){


        //     $order_sql = ' order by t1.time desc';

        // }

        if (count($order)) {
            $order_sql = ' order by '.implode(',', $order);
        }
		

        // limit
        $limit_sql = '';
        if ($limit) {
            $pageindex = max(1, intval($limit['page']));
            $pagesize=$limit['limit']?:10;
            $limit_sql = " LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
        }
        $list = pdo_fetchall($sql_head.$sql_body.$where_sql.$order_sql.$limit_sql);

        $sql_head = "select count(*) ";
        $total=pdo_fetchcolumn($sql_head.$sql_body.$where_sql);

        return array(
            'code'=>0,
            'count'=>$total,
            'data'=>$list,
            'msg'=>''
        );
    }
	// 验证必填
	public function check_required($data){
		if ($this->required_fields != array()) {
			foreach ($this->required_fields as $field) {
				if (!isset($data[$field])) {
				    throw new ZhyException("[ $field ]字段不能为空");
				}
			}
		}
		return false;
	}
	// 验证唯一
	public function check_unique($data,$id = 0){
	    global $_W;
		if ($this->unique != array()) {
			foreach ($this->unique as $item) {
				$where = array();
                if($this->has_uniacid){
                    $where['uniacid'] = $_W['uniacid'] ?: $_SESSION['admin']['uniacid'];
                }
				// 组合
				if (is_array($item)) {
					foreach ($item as $value) {
						$where[$value] = $data[$value];
					}
					$item = implode(',', $item);
					$msg = "[ $item ]字段组合唯一";
				}else{
					$where[$item] = $data[$item];
					$msg = "[ $item ]字段唯一";
				}
				if ($id) {
					$where['id !='] = $id;
				}
				$info = pdo_get($this->get_table_name(),$where);
				if($info){
                    throw new ZhyException($msg);
				}
			}
		}
		return false;
	}

	// 获取表名称
	public function get_table_name(){
		if(!$this->table_name){
			$this->table_name = get_class($this);
		}
		return $this->pre_fix.$this->table_name;
	}
	public function get_full_table_name(){
		if(!$this->table_name){
			$this->table_name = get_class($this);
		}
		return tablename($this->pre_fix.$this->table_name);
	}
}