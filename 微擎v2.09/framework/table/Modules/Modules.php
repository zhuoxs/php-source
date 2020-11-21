<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
namespace We7\Table\Modules;

class Modules extends \We7Table {
	protected $tableName = 'modules';
	protected $primaryKey = 'mid';
	protected $field = array(
		'name',
		'type',
		'title',
		'title_initial',
		'version',
		'ability',
		'description',
		'author',
		'url',
		'settings',
		'subscribes',
		'handles',
		'isrulefields',
		'issystem',
		'target',
		'iscard',
		'permissions',
		'wxapp_support',
		'account_support',
		'welcome_support',
		'webapp_support',
		'xzapp_support',
		'aliapp_support',
		'oauth_type',
		'phoneapp_support',
		'baiduapp_support',
		'toutiaoapp_support',
	);

	public function bindings() {
		return $this->hasMany('modules_bindings', 'module', 'name');
	}

	public function getByName($modulename) {
		if (empty($modulename)) {
			return array();
		}
		return $this->query->where('name', $modulename)->get();
	}

	public function getByNameList($modulename_list, $get_system = false) {
		$this->query->whereor('name', $modulename_list)->orderby('mid', 'desc');
		if (!empty($get_system)) {
			$this->whereor('issystem', 1);
		}
		return $this->query->getall('name');
	}

	public function deleteByName($modulename) {
		return $this->query->where('name', $modulename)->delete();
	}

	public function getByHasSubscribes() {
		return $this->query->select('name', 'subscribes')->where('subscribes !=', '')->getall();
	}

	public function getSupportWxappList() {
		return $this->query->where('wxapp_support', MODULE_SUPPORT_WXAPP)->getall('mid');
	}

	public function searchWithType($type, $method = '=') {
		if ($method == '=') {
			$this->query->where('type', $type);
		} else {
			$this->query->where('type <>', $type);
		}
		return $this;
	}

	public function getNonRecycleModules() {
		load()->model('module');
		$modules = $this->where('issystem' , 0)->orderby('mid', 'DESC')->getall('name');
		if (empty($modules)) {
			return array();
		}
		foreach ($modules as &$module) {
			$module_info = module_fetch($module['name']);
			if (empty($module_info)) {
				unset($module);
			}
			if (!empty($module_info['recycle_info'])) {
				foreach (module_support_type() as $support => $value) {
					if ($module_info['recycle_info'][$support] > 0 && $module_info[$support] == $value['support']) {
						$module[$support] = $value['not_support'];
					}
				}
			}
		}
		return $modules;
	}

	public function getInstalled() {
		return $this->query->select(array('name', 'version'))->where(array('issystem' => '0'))->getall('name');
	}
}