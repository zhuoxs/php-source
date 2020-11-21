<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');


class JobTable extends We7Table {

	protected $tableName = 'core_job';
	protected $field = array('type', 'payload', 'status', 'handled', 'uniacid', 'title', 'total', 'createtime', 'endtime', 'updatetime', 'isdeleted', 'uid');

	protected $default = array('status'=>0, 'handled'=>0, 'total'=>0, 'createtime'=>'custom', 'updatetime'=>'custom', 'isdeleted'=>0, 'uid'=>0);
	const DELETE_ACCOUNT = 10;
	const SYNC_FANS = 20;

	
	protected function defaultCreatetime() {
		return TIMESTAMP;
	}

	
	protected function defaultUpdatetime() {
		return TIMESTAMP;
	}
	
	public 	function jobs() {
		return $this->where('status', 0)->getall();
	}

	
	public function alljobs() {
		return $this->getall();
	}

	
	public function exitsJob($uniacid, $type)
	{
		$result = table('job')->where('uniacid', $uniacid)->where('type', $type)->get();
		return !empty($result);
	}
	
	public function createDeleteAccountJob($uniacid, $accountName, $total, $uid)
	{
				if ($this->exitsJob($uniacid, self::DELETE_ACCOUNT)) {
			return error(1, '任务已存在');
		}

		$data = array(
			'type' => self::DELETE_ACCOUNT,
			'title'=> "删除{$accountName}的素材数据",
			'uniacid'=>$uniacid,
			'total'=> $total,
			'uid'=>$uid
		);
		return $this->createJob($data);
	}

	
	public function createSyncFans($uniacid, $accountName, $total ) {
				if ($this->exitsJob($uniacid, self::SYNC_FANS)) {
			return error(1, '同步任务已存在');
		}
		$data = array(
			'type' => self::SYNC_FANS,
			'title'=> "同步 $accountName ($uniacid) 的公众号粉丝数据",
			'uniacid'=>$uniacid,
		);
		return $this->createJob($data);
	}

	private function createJob($data)
	{
		$this->fill($data);
		$result = $this->save();
		if ($result) {
			return pdo_insertid();
		}
		return $result;
	}

	
	public function clear($uid, $isfounder) {
		$table = table('job')
			->where('status', 1)
			->fill('isdeleted', 1);
		if (!$isfounder) {
			$table->where('uid', $uid);
		}
		return $table->save();
	}
}