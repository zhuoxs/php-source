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

	public function searchWithRecycle() {
		return $this->query->from('modules', 'a')->select('a.*')->leftjoin('modules_recycle', 'b')->on(array('a.name' => 'b.name'))->where('b.name', 'NULL')->orderby('a.mid', 'DESC')->getall('name');
	}
}