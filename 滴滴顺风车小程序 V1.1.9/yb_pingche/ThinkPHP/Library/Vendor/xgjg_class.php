<?php
	//session_start();
	/*网页时间项设定*/
	ini_set("date.timezone","Asia/Chongqing");
	$jym_prefix="xgjg_";
	/*海博网站通用参数配置类*/
	class redis_fun{
		private $redis_ip="127.0.0.1";						    /*redis数据库链接服务器地址*/
		private $redis_port=6379;								/*redis数据库链接服务器端口*/
		private $redis_auth="tangfengme";						/*redis数据库认证口令*/
		private $redis_db=0;									/*redis数据库*/
		private $key_prefix="xgjg_";							/*redis键名前缀定义*/
		private $redis;											/*redis对象变量*/
		private $separator='@@';								/*pcom字符串分隔符*/
		private $host="192.168.91.58";							/*pcom主机IP*/
		private $port="14321";			    					/*pcom端口参数*/


		/**
		 * @redis链接方法，直接链接redis
		 * 作者：唐锋
		 * QQ:593894955
		 * */
		function  redis_link(){
			$this->redis =new redis();								//定义redis对象
			$result=$this->redis->pconnect($this->redis_ip,$this->redis_port);
			if(!$result){
				exit("服务器连接失败！");
			}
			if(!$result=$this->redis->auth($this->redis_auth)){
				exit("redis服务器数据库口令认证失败！");
			}
			$this->redis->select($this->redis_db);
		}		
		
		/**
		 * @pcom链据参数配置以及定义说明
		 * */
		function pcom_link($str){						//$str是报文，格式是json
			$result=cbznetpcom($this->host,$this->port,$str);	//返回报文结果
			return $result;										//回收报文信息
		}		
		
		/**
		 * @自定义组成json报文字符串
		 * */
		function temp_json($arr){
			$str="";
			if(is_array($arr)){
				foreach($arr as $k=>$v){
					$str.='"'.$k.'":'.'"'.$v.'",';
				}
				$str="{".substr($str,0,-1)."}";
			}
			return $str;
		}
		
		/**
		 * @获取IP函数*/
		function get_client_ip()
		{
			if ($_SERVER['REMOTE_ADDR']) {
				$cip = $_SERVER['REMOTE_ADDR'];
			} elseif (getenv("REMOTE_ADDR")) {
				$cip = getenv("REMOTE_ADDR");
			} elseif (getenv("HTTP_CLIENT_IP")) {
				$cip = getenv("HTTP_CLIENT_IP");
			} else {
				$cip = "unknown";
			}
			return $cip;
		}		
		
		
		
		/**
		 * @字符串转义并且去空格，用于上传数据库*/
		function addslashes_trim($str){
			return addslashes(trim($str));
		}

		/**
		 * @字符串转义并且去空格，用于在界面上显示*/
		function stripslashes_trim($str){
			return stripslashes(trim($str));
		}

		/**获取当前时间
		 @flag参数 
		 1的格式  date("Y-m-d H:i:s") 
		 2的格式 date("Y-m-d")	
		 3的格式time()
		 4的格式strtotime(date("Y-m-d"))
		 */
		function show_curr_date($flag){
			if($flag==1){
				return date("Y-m-d H:i:s");
			}
			if($flag==2)
			{
				return date("Y-m-d");
			}
			if($flag==3)
			{
				return time();
			}
			if($flag==4)
			{
				return strtotime(date("Y-m-d"));
			}			
		}
		
		/**
		 * @只显示当前值的留两位小数
		 */
		function  get_yushu($zhe){
			$temp=explode(".",$zhe);
			if(isset($temp[1]) && $temp[1]!=""){
				return $temp[0].".".substr($temp[1],0,2);
			}else{
				return $temp[0];
			}
		}
		
		/**
		 * @php的json格式转数组
		 * */
		function php_json_decode($str){
			if(trim($str)!=""){
				return json_decode($str,true);
			}else{
				echo "数据异常，请查看数据是否正常";
			}
		}
		
		
		/**
		 *@读取固定的记录条数 
		 *redis的zrange方法
		 *参数说明
		 *keyName：key名
		 *int1:从什么位置读取记录
		 *int2:读到什么位置记录
		 **/
		function redis_zrange($key,$int1,$int2){
			$arr=array();
			$this->redis_link();
			$result=$this->redis->zrange($this->key_prefix.$key,$int1,$int2);
			if(count($result)>0){
				for($i=0;count($result)>$i;$i++){
					$data=json_decode($result[$i],true);
					array_push($arr, $data);
				}
				return $arr;
			}else{
				return $arr;
			}
		}
		/**
		 * @获取hash值
		 * 参数说明
		 * key是k名
		 * field是字段名
		 *redis的hget方法*/
		function redis_hget($key,$field){
			$this->redis_link();
			return $this->redis->hget($this->key_prefix.$key,$field);			 
		}
		
		/**
		 * @查找一条记录
		 * 参数说明
		 * key是键名
		 * index是索引号
		 *redis的 zrangebyscore方法
		 */
		function redis_zrangebyscore($key,$index){
			$this->redis_link();
			$result=$this->redis->zrangebyscore($this->key_prefix.$key,$index, $index);
			return json_decode($result[0],true);			 			
		}
		
		/**
		 * @删除原来的redis记录
		 * 参数说明
		 * key是键名
		 * index是索引号
		 *redis的 zremrangebyscore方法
		 */		
		function redis_zremrangebyscore($key,$index){
			$this->redis_link();
			$result=$this->redis->zremrangebyscore($this->key_prefix.$key,$index, $index);
			return $result;
		}
		/**
		 * @修改redis原来记录
		 * 参数说明
		 * key是键名
		 * index是索引号
		 * str是报文内容
		 *redis的 zremrangebyscore方法
		 */
		function redis_zadd($key,$index,$str){
			$this->redis_link();
			$result=$this->redis->zadd($this->key_prefix.$key,$index, $str);
			return $result;
		}		
		/**
		 * @获取redis字符值
		 * 参数说明
		 * key是键名
		 *redis的 get方法
		 */
		function redis_get($key){
			$this->redis_link();
			$result=$this->redis->get($this->key_prefix.$key);
			return $result;
		}		
		
		/**
		 * @获取list的记录数
		 * 参数说明
		 * key是键名
		 * redis的zcard方法
		 */
		function redis_zcard($key){
			$this->redis_link();
			return $this->redis->zcard($this->key_prefix.$key);			 		
		}
		
		/**
		 *@ 获取list降序排序的记录
		 * 参数说明
		 * key是键名
		 *int1:从什么位置读取记录
		 *int2:读到什么位置记录
		 * redis的zrevrange方法
		 */
		function redis_zrevrange($key,$int1,$int2){
			$arr=array();
			$this->redis_link();
			$result=$this->redis->zrevrange($this->key_prefix.$key,$int1,$int2);
			if(count($result)>0){
				for($i=0;count($result)>$i;$i++){
					$data=json_decode($result[$i],true);
					array_push($arr, $data);
				}
				return $arr;
			}else{
				return $arr;
			}			
		}
		
		/**
		 *@去掉默认的前缀 
		 *key是从hash中获取的带有前缀的键名
		 */
		function redis_kill_prefix($key){
			if(trim($key)==""){
				die("键名为空，无法实现去掉前缀") ;
			}else{
				return $ke=substr($key,7,strlen($key));
			}
		}
		
		/**
		 *@本函数用于前台，新闻不同类型数据列表分页
		 *三部曲
		 *主要用到的redis命令zrevrange、zrangebyscore
		 *参数说明
		 *key是键名
		 *int1:从什么位置读取记录
		 *int2:读到什么位置记录
		 */
		function redis_f_read_record($key1,$key2,$int1,$int2){
			$arr=array();
			//$this->redis_link();
			$result=$this->redis->zrevrange($this->key_prefix.$key1,$int1,$int2);
			if(count($result)>0){
				for($i=0;count($result)>$i;$i++){
					$temp=$this->redis->zrangebyscore($this->key_prefix.$key2,$result[$i],$result[$i]);
					$data=json_decode($temp[0],true);
					array_push($arr, $data);					
				}
				return $arr;
			}else{
				return $arr;
			}
		}
		
		/**
		 * @网站前台获取没有前缀的list的记录数
		 * 参数说明
		 * key是键名
		 * redis的zcard方法
		 */
		function redis_zcard_f_noprefix($key){
			return $this->redis->zcard($key);
		}		
		
		/**
		 *@测试方法 
		 */
		public function test(){
		    return date("Y-m-d H:i:s");
		}

	}
?>