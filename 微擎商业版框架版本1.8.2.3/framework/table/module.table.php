<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

defined('IN_IA') or exit('Access Denied');

class ModuleTable extends We7Table {

	protected $tableName = 'modules';
	protected $primaryKey = 'mid';
	protected $modulesRecycle = 'modules_recycle';

	public function bindings() {
		return $this->hasMany('modulebinding', 'module', 'name');
	}

	public function getModuleInfo($module, $fields = '*') {
		return $this->query->from($this->tableName)->select($fields)->where('name', $module)->get();
	}

	public function getInstalledModuleInfo($module) {
		return $this->query->from('modules', 'a')->leftjoin('modules_recycle', 'b')->on(array('a.name' => 'b.modulename'))->where('a.name', $module)->where('b.modulename', 'NULL')->get();
	}

	public function moduleBindingsInfo($module, $do = '', $entry = '') {
		$condition = array(
			'module' => $module,
			'do' => $do,
		);
		if (!empty($do)) {
			$condition['do'] = $do;
		}
		if (!empty($entry)) {
			$condition['entry'] = $entry;
		}
		return $this->query->from('modules_bindings')->where($condition)->get();
	}

	public function moduleLists($package_group_module) {
		return $this->query->from('modules')->where('issystem', 1)->whereor('name', $package_group_module)->orderby('mid', 'desc')->getall('name');
	}

	public function moduleRank($module_name = '') {
		global $_W;
		$this->query->from('modules_rank')->where('uid', $_W['uid']);
		if (!empty($module_name)) {
			$this->query->where('module_name', $module_name);
		}
		return $this->query->getall('module_name');
	}

	public function moduleMaxRank() {
		global $_W;
		$rank_info = $this->query->from('modules_rank')->select('max(rank)')->where('uid', $_W['uid'])->get();
		return $rank_info['0'];
	}

	public function moduleSetRankTop($module_name) {
		global $_W;
		if (empty($module_name)) {
			return false;
		}
		$max_rank = $this->moduleMaxRank();
		$exist = $this->moduleRank($module_name);
		if (!empty($exist)) {
			pdo_update('modules_rank', array('rank' => ($max_rank + 1)), array('module_name' => $module_name));
		} else {
			pdo_insert('modules_rank', array('uid' => $_W['uid'], 'module_name' => $module_name, 'rank' => ($max_rank + 1)));
		}
		return true;
	}

	public function modulesWxappList() {
		return $this->query->from('modules')->where('wxapp_support', MODULE_SUPPORT_WXAPP)->getall('mid');
	}

	public function moduleLinkUniacidInfo($module_name) {
		if (empty($module_name)) {
			return array();
		}
		$result = $this->query->from('uni_account_modules')->where('module', $module_name)->getall();
		if (!empty($result)) {
			foreach ($result as $key => $value) {
				$result[$key]['settings'] = iunserializer($value['settings']);
				if (empty($result[$key]['settings']) || empty($result[$key]['settings']['link_uniacid'])) {
					unset($result[$key]);
				}
			}
			return $result;
		}
		return array();
	}

	public function uniAccountModuleInfo($module_name) {
		global $_W;
		if (empty($module_name)) {
			return array();
		}
		$result = $this->query->from('uni_account_modules')->where('module', $module_name)->where('uniacid', $_W['uniacid'])->get();
		if (!empty($result)) {
			$result['settings'] = iunserializer($result['settings']);
			return $result;
		}
		return array();
	}

	public function getModulesList() {
		return $this->query->from($this->tableName)->getall('name');
	}

	public function searchWithType($type, $method = '=') {
		if ($method == '=') {
			$this->query->where('type', $type);
		} else {
			$this->query->where('type <>', $type);
		}
		return $this;
	}

	public function getInstalledModuleList() {
		return $this->query->from($this->tableName, 'a')->leftjoin('modules_recycle', 'b')->on(array('a.name' => 'b.modulename'))->where('b.modulename', 'NULL')->getall('name');
	}

	public function getModuleRecycle() {
		return $this->query->select('modulename')->from($this->modulesRecycle)->getall('modulename');
	}

	public function getSubscribesModules() {
		return $this->query->select('name', 'subscribes')->from($this->tableName)->where('subscribes !=', '')->getall();
	}

	public function cleanModuleInfo($modulename, $isCleanRule = false) {
		$this->query->from('core_queue')->where('module', $modulename)->delete();
		$this->query->from($this->tableName)->where('name', $modulename)->delete();
		$this->query->from('modules_bindings')->where('module', $modulename)->delete();

		if (!empty($isCleanRule)) {
			$this->query->from('rule')->where('module', $modulename)->delete();
			$this->query->from('rule_keyword')->where('module', $modulename)->delete();

			$cover_rule = $this->query->from('cover_reply')->where('module', $modulename)->getall('rid');

			if (!empty($cover_rule)) {
				$rids = array_keys($cover_rule);
				$this->query->from('rule_keyword')->where('module', 'cover')->where('rid', $rids)->delete();
				$this->query->from('rule')->where('module', 'cover')->where('id', $rids)->delete();
				$this->query->from('cover_reply')->where('module', $modulename)->delete();
			}
		}
		$this->query->from('site_nav')->where('module', $modulename)->delete();
		$this->query->from('uni_account_modules')->where('module', $modulename)->delete();

		return true;
	}
}