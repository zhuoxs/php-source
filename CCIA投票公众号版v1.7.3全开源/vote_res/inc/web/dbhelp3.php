<?php
/****************************************
 * pdo防注入版第3.4版
 * pdo_value():返回查询的某个字段[返回字符串|空串:''|fasle]
 * pdo_find($keyfile):返回查询的单行数据[返回数据|空数组:[]|fasle]
 * pdo_count():返回查询的总行数[返回数字|0|fasle]
 * pdo_select():返回查询的所有数据[返回数据|空数组:[]|fasle]
 * pdo_findcoll($keyfile,$type=''):返回字段一列数据;($keyfile:查询的字段;$type:返回格式的链接符号;为空返回数组,代参数返回带符号的字符串符)[返回数据|空数组:[]|fasle]
 * pdo_save($savedata):保存数据;带where()查询或者$savedata参数包含主键ID为修改,否则为添加.[返回受影响的行数|0|fasle]
 * pdo_insertGetId($savedata):添加数据并返回添加的ID[返回ID|false]
 * pdo_insertAll($dataAll):批量添加数据.[返回受影响的行数|fasle]
 * pdo_delete():删除数据[返回受影响的行数|0|fasle]
 * buildsql():返回查询的语句[返回带()的查询语句]
 * getnumhtml($pageno,$rows,$limit='10',$pplimit='10'):返回分页的页码信息;($pageno:当前页码,$rows:总行数,$limit:每页显示数量,$pplimit:分页每页显示页码数量)
 * 
 * getmsg():返回报错的消息
 * getinsertid():返回最后一次插入数据的ID 
 * callback_tableindex():返回表的所有字段
 * callback_primarykey():返回表的主键字段
 * 
 * where($content,$val='',$val=''):查询条件,可传一个参数(数组|字符串),或者两个字符串参数，三个字符串参数
 * 查询参数:$key健名,$s查询条件(默认为=,可不填),$value查询的值
 * $s支持:=,>=,<=,<>,>,<,!=,like,in,notin(in和ontin的值$value输写格式为"1,2,3,4")
 * 查询模式:
 * 	数组模式-(只传一个参数)
 * 		简易查询:([$key=>$value])
 * 		常规查询:(["$key $s"=>$value,"$key $s"=>$value])		
 * 		关键词查询:(["$key1|$key2|$key3 $s"=>$value]);
 * 		多条件OR查询:([  ["$key1 $s"=>$value1,"$key2 $s"=>$value2] ])
 * 	字符串模式-	(只传一个参数)
 * 		查询条件:('and a.id=1 and b.name=2')
 *  字符串模式-	(可传两个参数)
 *  	查询条件:('id','1')
 *  字符串模式-	(可传三个参数)
 *  	查询条件:('name','like','李')
 *  
 * table($tablename):查询的主表字符串;支持驼峰命名和带别名(不需要表索引),(例如'EweiShopMemberCart a')
 * filed($field);查询的字段;支持一维数组和字符串,可带别名(['a.id','b.name','b.mobile']|'a.id,b.name bname')
 * group($group):分组字段字符串;支持多字段用逗号并列(例如'g.goodsid'|'a.goodsid,a.pointid')
 * having($having):函数条件|别名条件字符串;(例如 'and zmoney>100 and ztotal>5')
 * order($order):排序字符串;(例如 'a.createtime desc,a toal desc')
 * page($limit='10',$page='1'):分页设置;
 *  
 */
		
class dbhelp3{
	private $tofen=true;		//是否开启驼峰命名
	private $tablepere;			//设置表前缀
	private $limit;				//分页每页显示数量
	private $page;				//分页默认页码
	private $pplimit;			//页码分页默认显示数量					
	
	//构造函数
	public function __construct(){
		global $_W;
		if (!defined('IN_IA')) {
			exit('Access Denied');
		}
		$this->tablepere=(empty($_W['config']['db']['tablepre']))?$_W['config']['db']['master']['tablepre']:$_W['config']['db']['tablepre'];
		$this->limit=10;
		$this->page=1;
		$this->pplimit=10;
				
	}
	
	
	/********************
	 * buildsql:返回查询语句
	 * joinsql:返回带（）的sql语句,用于子链接和代替join的表链接
	 * params:查询条件的站位数据
	 */
	public function buildsql(){
		if(!($this->getsql())){
			return false;
		};
		$getsql=$this->getsql();
		$getsql.=(isset($this->limitpage) && !empty($this->limitpage))?$this->limitpage:'';
		
		return '('.$getsql.')';
	}
	
	/********************
	 * pdo_value:返回查询的某个字段
	 * $keyfile:待查询的字段
	 */
	public function pdo_value($keyfile){
		if(!($this->getsql())){
			return false;
		};
		
		if(isset($this->field) && !empty($this->field)){
			$this->msg='查询单值不能调用field()方法';
			return false;
		}
				
		$this->field=$keyfile;
		$result=pdo_fetchcolumn($this->getsql(),$this->params);
		if(!$result){
			$count=$this->pdo_count();			//底层没有查询为空的返回,给它补上
			if ($count=='0'){
				$result='';
			}else{
				$this->msg='查询语句错误,请仔细检查下';
			}
		}
		return $result;
	}
	
	/********************
	 * pdo_count:返回查询的总行数
	*/
	public function pdo_count(){
		
		if(!($this->getsql())){
			return false;
		};
		
		if(!isset($this->group) && !isset($this->having)){			//没有group分组或having别名的时候，修改查询的类容
			$this->field='count(*)';
			$this->order='';
			$result=pdo_fetchcolumn($this->getsql(),$this->params);
			$result=($result===false)?false:intval($result);		//转成INT类型
		}else{
			$gresult=pdo_fetchall($this->getsql(),$this->params);	//存在group分组或having别名的时候，总行数统计变更
			$result=($gresult===false)?false:count($gresult);
		}
		if ($result===false){
			$this->msg='查询出错|查询为空,请仔细检查下';
			return false;
		}
		return $result;
		
	}
	
	/********************
	 * pdo_find:返回查询的单行数据
	*/
	public function pdo_find(){
		(!isset($this->field) || empty($this->field))?$this->field='*':'';
	
		if(!($this->getsql())){
			return false;
		};
		
		$result=pdo_fetch($this->getsql(),$this->params);
		if(!$result){
			$count=$this->pdo_count();			//底层没有查询为空的返回,给它补上
			if ($count=='0'){
				$result='';
			}else{
				$this->msg='查询语句错误,请仔细检查下';
			}
		}
		return $result;		
	
	}
	
	/********************
	 * pdo_select:返回查询的所有数据
	 * 如果实例化page方法,则返回分页数据
	*/
	public function pdo_select(){
		(!isset($this->field) || empty($this->field))?$this->field='*':'';
	
		if(!($this->getsql())){
			return false;
		};
		
		if(isset($this->limitpage) && !empty($this->limitpage)){		//判断是否有分页
			$list=pdo_fetchall($this->getsql().$this->limitpage,$this->params);
			$count=$this->pdo_count();
			if($list===false){
				$this->msg='查询语句出错了,请仔细检查下';
				return false;
			}
			if($count===false){
				$this->msg='总行数统计错误,请检测下';
				return false;
			}
			return array('list'=>$list,'count'=>$count);
		}else{
			$result=pdo_fetchall($this->getsql(),$this->params);

			if ($result===false){
				$this->msg='查询语句出错了,请仔细检查下';
				return false;
			}
			return $result;
		}
		
	}	
	
	/********************
	 * pdo_findcoll:返回字段一列数据(多用于查询查询三级联动的ID)
	 * $keyfield:字段ID
	 * $type:返回格式的链接符号;为空返回数组,代参数返回带符号的字符串符
	 */
	public function pdo_findcoll($keyfield,$type=''){
		
		if(!($this->getsql())){
			return false;
		};
		
		$sql=$this->getsql();
		$sql.=(isset($this->limitpage) && !empty($this->limitpage))?$this->limitpage:'';

		$list=pdo_fetchall($sql,$this->params);
		
		if ($list===false){
			$this->msg='查询语句出错了,请仔细检查下';
			return false;
		}

		$result=array();	
		if(is_array($list) && count($list)>0){
			$key=trim(trim(strrchr($keyfield, '.'),'.'));		//截取.后面的部分,避免别名的a.找不到数据
			$key=(!empty($key))?$key:$keyfield;
			
			foreach ($list as $hang){
				(isset($hang[$key]) && !empty($hang[$key]))?array_push($result,$hang[$key]):'';
			}
		}
		return (!empty($result) && !empty($type))?implode($type,$result):$result;
		
	}

	
	/********************
	 * pdo_save 保存数据:
	 * $savedata:保存的数据,内含主键自动识别为修改;如:array("real_name"=>"a","mobile"=>"18888942039");
	 * 如果在调用此方法前先调用了where方法则为修改,若$savedata里有主键ID执行$savedata里的主键修改,不会执行查询后的修改
	*/
	public function pdo_save($savedata){
		if(!is_array($savedata) || count($savedata)<=0){
			$this->msg='保存的数据不能为空';
			return false;
		}

		$dbobj=$this->showsql();												//得到对象数据
		if(!isset($dbobj['table']['table']) || empty($dbobj['table']['table'])){
			$this->msg='操作的主表不存在!';
			return false;
		}
		if(isset($this->where) && !empty($this->where)){						//有where条件执行修改
			$condtext=$this->save_checkdata($savedata);							//处理参数
			$result=pdo_query('update '.$dbobj['table']['table'].' set '.$condtext.' where 1 '.$this->where,$this->params);
			(!isset($result))?$this->msg='数据保存失败!':'';
		}else{
			$datakeys=array_keys($savedata);										//返回参数所有的索引
			$primarykey=$this->callback_primarykey();								//返回表的主键|fasle
			
			if($primarykey && in_array($primarykey, $datakeys)){					//索引中存在主键ID,执行修改
				$idnum=$savedata[$primarykey];
				unset($savedata[$primarykey]);
				$condtext=$this->save_checkdata($savedata);							//处理参数
				$this->params[':whereid'.$primarykey]=$idnum;
				$result=pdo_query('update '.$dbobj['table']['table'].' set '.$condtext.' where 1  and '.$primarykey.'=:whereid'.$primarykey,$this->params);
				(!isset($result))?$this->msg='数据保存失败!':'';
			}else{
				$condtext=$this->save_checkdata($savedata);							//处理参数
				$result=pdo_query('insert into '.$dbobj['table']['table'].' set '.$condtext,$this->params);
				(!isset($result))?$this->msg='数据添加失败!':'';
			} 	
		}
		
		return $result;
		
	}
	
	//填改的数据处理
	private function save_checkdata($savedata=array()){
		$condtext='';
		if($savedata && count($savedata)>0){
			foreach ($savedata as $index=>$hang){
				$condtext.='`'.$index.'`=:'.$index.',';
				$this->params[":".$index]=$hang;	
			}
		}
		return (!empty($condtext))?substr($condtext,0,-1):'';
	}
	
	/********************
	 * pdo_insertGetId 添加字段并返回ID
	 * $savedata:待添加的数据数组
	 */
	public function pdo_insertGetId($savedata){
		if(!is_array($savedata) || count($savedata)<=0){
			$this->msg='保存的数据不能为空';
			return false;
		}

		$dbobj=$this->showsql();												//得到对象数据
		if(!isset($dbobj['table']['table']) || empty($dbobj['table']['table'])){
			$this->msg='操作的主表不存在!';
			return false;
		}
		
		$condtext='';
		$params=array();
		foreach ($savedata as $index=>$hang){
			$condtext.='`'.$index.'`=:'.$index.',';
			$params[":".$index]=$hang;
		}
		$condtext=(!empty($condtext))?substr($condtext,'0','-1'):"";

		$query=pdo_query('insert into '.$dbobj['table']['table'].' set '.$condtext,$params);
		if(isset($query) && $query=='1'){
			return pdo_insertid();
		}else{
			$this->msg='数据添加失败!';
			return false;
		}
		
	}
	
	
	
	/********************
	 * pdo_insertAll 批量添加数据
	 * $dataAll:待保存的数据二维数组
	 * 若在调用此方法前先调用了where方法或者$dataAll里有主键ID字段则为修改，否则执行新增
	 */
	public function pdo_insertAll($dataAll){
		if(!is_array($dataAll) || count($dataAll)<=0){
			$this->msg='保存的数据不能为空';
			return false;
		}
		
		$dbobj=$this->showsql();												//得到对象数据
		if(!isset($dbobj['table']['table']) || empty($dbobj['table']['table'])){
			$this->msg='操作的主表不存在!';
			return false;
		}
		
		$result=0;
		foreach ($dataAll as $key=>$hang){
			$condtext="";
			$parms=array();
			if(is_array($hang) && count($hang)>0){
				foreach ($hang as $index=>$lie){
					$condtext.='`'.$index.'`=:'.$index.',';
					$parms[":".$index]=$lie;
				}
				$condtext=(!empty($condtext))?substr($condtext,'0','-1'):"";
			}
			$execute=pdo_query("insert into ".$dbobj['table']['table']." set $condtext ",$parms);
			$result+=($execute)?1:0;											//执行成功，增加受影响的行数
		}
		
		return ($result && !empty($result))?$result:false;		
			
	}
	
	
	/********************
	 * pdo_delete 安全删除:
	 */
	public function pdo_delete(){
		$dbobj=$this->showsql();												//得到对象数据
		if(!isset($dbobj['table']['table']) || empty($dbobj['table']['table'])){
			$this->msg='操作的主表不存在!';
			return false;
		}
		$result=pdo_query("delete from ".$dbobj['table']['table']." where 1 $this->where ",$this->params);
		return $result;
	}
	
	
	
	/********************
	 * 分页以及页码分页信息
	 * $pageno:当前页页码
	 * $rows:总行数
	 * $limit:每页显示行数
	 * $pplimit:页码每页显示数量
	 * $showtype:显示方式(默认0);0不开启,1:开启ul,li显示;2:开启select,option显示
	*/
	public function  getnumhtml($pageno,$rows,$limit='10',$pplimit='10',$showtype='0'){
		$limit=(isset($limit) && is_numeric($limit) && $limit>0)?$limit:$this->limit;
		$pplimit=(isset($pplimit) && is_numeric($pplimit) && $pplimit>0)?$pplimit:$this->pplimit;
		if(!is_numeric($rows) || $rows<=0){
			return false;
		}
		$pages=(int)(($rows-1)/$limit)+1;						//得到总行数
		$toppage=(($pageno-1)>0)?$pageno-1:1;					//上一页
		$onpage=($pageno>0 && $pageno<$pages)?$pageno+1:$pages;	//得到下一页
		
		$avg=(int)(($pplimit-1)/2);	//算出一半的数量
		$strat="1";
		if($pageno>$avg){				//当前页码不够一半的时候,默认为1
			if(($pages-$pageno)>$avg){	//尾部不够一半的时候,起始值不变;否则为焦点减去一半
				$strat=$pageno-$avg;
			}else{
				if($pages-$pplimit>0){	//总页数小于显示页码数量的时候,起始值也为1
					$strat=$pages-$pplimit+1;
				}
			}
		}
		
		$html='';
		if(!empty($showtype) && !empty($rows)){
			$fornum=($pages<$pplimit)?$pages:$pplimit;	//循环次数
			if($showtype=='1'){
				$html.='<ul>';
				for($i=0;$i<$fornum;$i++){
					$html.='<li><a href="javascript:void(0)" pageno="'.($strat+$i).'">'.($strat+$i).'</a></li>';
				}
				$html.='</ul>';
			}
			if($showtype=='2'){
				$html.='<select>';
				for($i=0;$i<$fornum;$i++){
					$html.='<option value="'.($strat+$i).'">'.($strat+$i).'</option>';
				}
				$html.='</select>';
			}
		}
		return array('pageno'=>$pageno,'toppage'=>$toppage,'onpage'=>$onpage,'pages'=>$pages,'rows'=>$rows,'pplimit'=>$pplimit,'ppstart'=>$strat,'pagehtml'=>$html);
		
	}
	
	
	//返回出错的消息
	public function getmsg(){
		return $this->msg;
	}
	
	
	//返回最后一次插入的ID
	public function getinsertid(){
		return pdo_insertid();
	}
	
	//得到表的所有字段详情
	private function callback_tableinfo(){
		$dbobj=$this->showsql();												//得到对象数据
		if(!isset($dbobj['table']['table']) || empty($dbobj['table']['table'])){
			$this->msg='操作的主表不存在!';
			return false;
		}
		$sql="describe ".$dbobj['table']['table'];
		return pdo_fetchall($sql);		
	}
	
	//得到表的字段列表
	public function callback_tableindex(){
		$query=$this->callback_tableinfo();
		if(!$query || !is_array($query)){
			$this->msg='操作的表没有字段!';
			return false;
		}
		$result=array();
		foreach ($query as $hang){
			$result[]= $hang['Field'];
		}
		return $result;
	}
	
	//得到表的主键ID
	public function callback_primarykey(){
		$query=$this->callback_tableinfo();
		if(!$query || !is_array($query)){
			$this->msg='操作的表没有字段!';
			return false;
		}
		$result=false;
		foreach ($query as $key=>$hang){
			if($query[$key]['Key']=='PRI'){
				$result = $hang['Field'];
				break;
			}
		}
		return $result;
	}
	
	/********************
	 * 查询的表,自带表前缀
	 * 支持大小驼峰命名法:例如EweiShopMemberAddress;
	 * 可带表的别名:如 EweiShopMemberAddress a 
	 */
	public function table($table){					//新的table清除掉旧的数据
		unset($this->table);
		unset($this->field);
		unset($this->join);
		unset($this->where);
		unset($this->group);
		unset($this->having);
		unset($this->order);
		unset($this->limitpage);
		unset($this->params);
		$this->table=$this->tablename($table);
		
		return $this;
	}
	
	/********************
	 * 查询条件
	 * $field:可为字符串格式a.id,a.name;
	 * $field:可为数组格式array(a.id,a.name);
	 */
	public function field($field){
		if(is_array($field)){
			$field=implode(',' , $field);
		}
		$this->field=$field;
		return $this;
	}
	
	/********************
	 * 链接条件
	 * $jointable:链接的表名,可带别名。如:EweiShopMember b
	 * $joinon:链接条件
	 * $jointype:链接方式inner|left|right
	 */
	public function join($jointable,$joinon,$jointype='inner'){
		$tableinfo=$this->tablename($jointable);
		$this->join[]=array(
			'table'=>$tableinfo['table'],
			'as'=>$tableinfo['as'],
			'joinon'=>$joinon,
			'jointype'=>$jointype,
		);
		return $this;		
	}
	
	/********************
	 * 数组格式:$condition=array("$key $s"=>$value);
	 * $s支持:=,>=,<=,<>,>,<,!=,like,in,notin(in和ontin的值输写格式为:"1,2,3"")
	 * 常规查询:array("$key $s"=>$value,"$key $s"=>$value),	
	 * 关键词查询:array("$key1|$key2|$key3 $s"=>$value);		
	 * 多条件OR查询:array(array("$key1 $s"=>$value1,"$key2 $s"=>$value2))
	 * 字符串格式：'and a.id=1 and b.name=2'---没有防注入不推荐 
	 * 单条件简易查询('id','1')|('name','like','小李');	--有防注入
	 */
	public function where($condition,$idval='',$val=''){
		if(!empty($condition)){
			if(is_array($condition)){
				$condition=$this->handel($condition);
			}else{
				if (!empty($idval)){
					$conditions=(isset($val) && !empty($val))?array("$condition $idval"=>$val):array($condition=>$idval);
					$condition=$this->handel($conditions);
				}
			}
		}
		(!empty($condition))?$this->where.=$condition:'';
		return $this;
	}
	
	/********************
	 * group by:分组字段
	 * 多分组格式:a,b,c
	 */
	public function group($filed){
		$this->group=$filed;
		return $this;	
	}
	
	/********************
	 * having:分组查询字符串
	* 多用于group后的数据条件/或者查询的别名条件
	*/
	public function having($having){
		$this->having=$having;
		return $this;
	}
	
	/********************
	 * order by:排序字段
	 * 多排序格式:a desc,b desc
	*/
	public function order($filed){
		$this->order=$filed;
		return $this;
	}
	
	/********************
	 * page :分页信息
	 * $limit:每页显示行数,默认10
	 * $page:页码,默认1
	 */
	public function page($limit='10',$page='1'){
		(isset($limit) && is_numeric($limit) && $limit>0)?$this->limit=$limit:'';
		(isset($page) && is_numeric($page) && $page>0)?$this->page=$page:'';
		$this->pageinfo();
		return $this;
	}
	
	
	
	/********************
	 * page 分页参数处理
	*/
	private function pageinfo(){
		if(!isset($this->limit) || empty($this->limit)){
			$this->msg='分页每页显示的行数未设置!';
			return false;
		}
		
		if(!isset($this->page) || empty($this->page)){
			$this->msg='分页显示的页码未设置!';
			return false;
		}
		$page=(int)($this->page);
		$limit=(int)($this->limit);
		$start=($page-1)*$limit;
		$this->limitpage=' limit '.$start.','.$limit;
	}
	
	
	//显示查询的相关字段
	private function showsql(){
		$result=array(
			'table'=>$this->table,
			'field'=>$this->field,
			'joinarr'=>$this->join,
			'wherearr'=>$this->where,
			'group'=>$this->group,
			'having'=>$this->having,
			'order'=>$this->order,
			'limitpage'=>$this->limitpage,		
			'params'=>$this->params,
		);
		return $result;
	}
	
	//整合对象，返回查询的语句
	private function getsql(){
		$dbobj=$this->showsql();
		if(!isset($dbobj['table']['table']) || empty($dbobj['table']['table'])){
			$this->msg='查询的主表不存在!';
			return false;
		}
		$field=(isset($dbobj['field']) && !empty($dbobj['field']))?$dbobj['field']:'*';
		$sql='select '.$field.' from '.$dbobj['table']['table'].' '.$dbobj['table']['as'];
		
		if (isset($dbobj['joinarr']) && is_array($dbobj['joinarr']) && count($dbobj['joinarr'])>0){
			foreach ($dbobj['joinarr'] as $key=>$hang){
				$sql.=' '.$hang['jointype'].' join '.$hang['table'].' '.$hang['as'].' on '.$hang['joinon'];
			}
		}
		
		$sql.=(isset($dbobj['wherearr']) && !empty($dbobj['wherearr']))?' where 1 '.$dbobj['wherearr']:'';
		$sql.=(isset($dbobj['group']) && !empty($dbobj['group']))?' group by '.$dbobj['group']:'';
		$sql.=(isset($dbobj['having']) && !empty($dbobj['having']))?' having 1 '.$dbobj['having']:'';
		$sql.=(isset($dbobj['order']) && !empty($dbobj['order']))?' order by '.$dbobj['order']:'';
		
		return $sql;
		
	}
	
	
	//下划线转驼峰
	private function convertUnderline($str){
		$str = preg_replace_callback('/([-_]+([a-z]{1}))/i',function($matches){
			return strtoupper($matches[2]);
		},$str);
		return $str;
	}
	
	//驼峰转下划线
	private function humpToLine($str){
		if($this->tofen){
			$str = preg_replace_callback('/([A-Z]{1})/',function($matches){
				return '_'.strtolower($matches[0]);
			},$str);
			$str=(strpos($str,'_')=='0')?substr($str, 1):$str;		//针对大驼峰的处理
		}
		return $str;
	}
	
	//表名字处理
	private function tablename($table){
		$tname=$this->getxkhnr($table);
		if(!empty($tname)){						//如果是外链表是子查询，则处理
			$seltable=$this->getxkhnr($table);
			$tablename='('.$this->getxkhnr($table).')';
			$as=trim(trim(strrchr($table, ')'),')'));
		}else{
			$tableinfo=$this->explodekey($table);
			$tablename=$this->tablepere.$this->humpToLine($tableinfo['0']);
			$as=(isset($tableinfo['1']) && !empty($tableinfo['1']))?$tableinfo['1']:'';
		}
		return array('table'=>$tablename,'as'=>$as);
	}
	
	//提取字符串括号中的类容
	private function getxkhnr($str){
		$result = array();
		preg_match_all("/(?:\()(.*)(?:\))/i",$str, $result);
		return $result[1][0];
	}
	
	
	/*******************************
	 * 查询数组处理
	* 查询格式:$key $s =>$value条件($s支持:=,>=,<=,<>,>,<,!=,like,in,notin)
	*	array("$key $s"=>$value,"$key $s"=>$value),	//常规查询
	* 	array("$key1|$key2|$key3 $s"=>$value);		//关键词查询
	* 	array(array("$key1 $s"=>$value1,"$key2 $s"=>$value2))多条件查询
	*/
	private function handel($condition){
		$content='';
		if(is_array($condition) && count($condition)>0){
			foreach($condition as $key=>$hang){
				if(!is_array($hang)){				//常规处理-条件是一个值
					$content.=$this->checkkey($key,$hang);
				}else{								//多条件处理-条件是一个二维数组
					$content.=" and (";
					$i=0;
					foreach ($hang as $index=>$lie){
						if($i=='0'){			//OR条件,第一个没有OR链接符号
							$content.=$this->checkkey2($index,$lie,'');
						}else{
							$content.=$this->checkkey2($index,$lie,'or');
						}
						$i++;
					}
					$content.=")";
				}
			}
		}
		return $content;
	
	}
	
	/**************************
	 * 一维数组查询条件解析
	* $key:条件;支持[title|shorttitle|subtitle like]和[subtitle like]
	* $value:值
	*/
	private function checkkey($key,$value){
		$keyarr=$this->explodekey($key,'=');
		$index=$keyarr['0'];		//得到字段名
		$s=$keyarr['1'];				//得到查询条件
		
		$isword=explode("|",$index);					//是否是关键词
		$conten='';
		$param=array();
		if(count($isword)>0){
			if(count($isword)=='1'){			//常规数据处理
				$conten=$this->checks($index,$s,$value);	
			}else{								//关键词处理
				$conten.=" and (";
				for ($i=0;$i<count($isword);$i++){
					if($i=='0'){			//OR条件,第一个没有OR链接符号
						$conten.=$this->checks($isword[$i],$s,$value,'');
					}else{
						$conten.=$this->checks($isword[$i],$s,$value,'or');
					}
				}
				$conten.=")";
			}
		}
	
		return $conten;
	}
	
	
	/************************
	 * 二维数组查询条件解析
	* $key:条件;[subtitle like]
	* $value:值
	* $lj:链接符号,默认为and
	*/
	private function checkkey2($key,$value,$lj='and'){
		$keyarr=$this->explodekey($key,'=');
		$index=$keyarr['0'];			//得到字段名
		$s=$keyarr['1'];				//得到查询条件
		return $this->checks($index,$s,$value,$lj);
	}
	
	/************************
	 * $key 的安全解析
	 * $key:待解析的字符串
	 * $ms:没有$s的时候的默认值
	 */
	private function explodekey($key,$ms=''){
		$key=mb_ereg_replace('(　| )+$', '',trim($key));				//去掉$key首位的空格
		$index=substr($key,0,strpos($key, ' '));	//得到第一个index
		if(empty($index)){
			$index=$key;
			$s=$ms;
		}else{
			$s=trim(trim(strrchr($key, ' '),' '));
		};
		return array($index,$s);
	}
	
	/************************
	 * 查询符号判断
	* $key:字段索引
	* $s:查询符号(支持:=,>=,<=,<>,>,<,!=,like,in,notin)
	* $value:查询的值
	* $lj:链接方式:默认and
	*/
	private function checks($key,$s,$value,$lj='and'){
		
		if((strpos($key,'.')!==false)){			//处理表连接的点
			$smname=str_replace('.','',$key);
			$keyarr=explode('.',$key);
			$selkey=$keyarr['0'].'.`'.$keyarr['1'].'`';
		}else{
			$selkey='`'.$key.'`';
			$smname=$key;	
		}
		
		if($s=="like"){
			$content.=" $lj $selkey like :$smname";
			$this->params[':'.$smname]="%".$value."%";
		}elseif($s=="notin"){
			$value=$this->checkzifu($value);
			$content=" $lj $selkey not in ($value)";
		}elseif($s=="in"){
			$value=$this->checkzifu($value);
			$content=" $lj $selkey in ($value)";
		}else{
			$content=" $lj $selkey $s :$smname";
			$this->params[':'.$smname]=$value;
		}
		return $content;
	}
	
	//判断in数据是否是字符创类型
	private function checkzifu($values){
		$isword=explode(",",$values);					//转移值为数组进行安全解析
		$result='';
		if(count($isword)>0){
			for ($i=0;$i<count($isword);$i++){
				if(is_numeric($isword[$i])){			//如果是数字就叠加，支持0
					$result.=$isword[$i].',';
				}else{									//如果不是数字类型，先验证非空
					$result.=(!empty($isword[$i]))?"'".$isword[$i]."',":"";
				}
			}
			$result=substr($result, '0','-1');
		}
		
		return $result;
	}
	

}
