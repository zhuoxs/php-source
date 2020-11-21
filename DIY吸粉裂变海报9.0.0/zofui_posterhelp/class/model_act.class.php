<?php 

class model_act {


	// 检查是否可参与活动
	static function isCanJoinAct($actinfo){
		global $_W;

		if( empty( $actinfo['id'] ) ) return '活动不存在';
        if( $actinfo['start'] > TIMESTAMP ) return '活动还没开始';
        if( $actinfo['end'] < TIMESTAMP ) return '活动已结束';

        if( $actinfo['status'] == 1 ) return '活动已下架了';
        return 1;
	}


	// 查询活动
	static function getAct($id){
		global $_W;
		$id = intval( $id );
		if( $id <= 0 ) return false;
		$cache = Util::getCache('act',$id);
		if(empty($cache)){
			$cache = pdo_get('zofui_posterhelp_act',array('id'=>$id,'uniacid'=>$_W['uniacid']));
			if( !empty( $cache ) ){

				if( !empty( $cache['area'] ) ){
					$cache['area'] = iunserializer( $cache['area'] );
				}
				if( !empty( $cache['admin'] ) ){
					$cache['admin'] = iunserializer( $cache['admin'] );
				}
				if( !empty( $cache['przieslider'] ) ){
					$cache['przieslider'] = iunserializer( $cache['przieslider'] );
				}
				
			}
			
			Util::setCache('act',$id,$cache);
		}
		return $cache;  //需删除缓存
	}
	
	
	
}