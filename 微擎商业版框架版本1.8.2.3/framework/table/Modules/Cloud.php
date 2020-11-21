<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
namespace We7\Table\Modules;

class Cloud extends \We7Table {
	protected $tableName = 'modules_cloud';
	protected $primaryKey = 'id';
	protected $field = array(
		'name',
		'title',
		'title_initial',
		'logo',
		'version',
		'install_status',
		'account_support',
		'wxapp_support',
		'webapp_support',
		'phoneapp_support',
		'welcome_support',
		'xzapp_support',
		'aliapp_support',
		'main_module_name',
		'main_module_logo',
		'has_new_version',
		'has_new_branch',
		'is_ban',
		'lastupdatetime',
	);
	protected $default = array(
		'name' => '',
		'title' => '',
		'title_initial' => '',
		'logo' => '',
		'version' => '',
		'install_status' => 0,
		'account_support' => 1,
		'wxapp_support' => 1,
		'webapp_support' => 1,
		'phoneapp_support' => 1,
		'welcome_support' => 1,
		'xzapp_support' => 1,
		'aliapp_support' => 1,
		'main_module_name' => '',
		'main_module_logo' => '',
		'has_new_version' => 0,
		'has_new_branch' => 0,
		'is_ban' => 0,
		'lastupdatetime' => 0,
	);

	public function getByName($name) {
		if (empty($name)) {
			return array();
		}
		return $this->query->where('name', $name)->get('name');
	}

	public function getUpgradeByModuleNameList($module_name_list, $account_type = ACCOUNT_TYPE_SIGN) {
		if (empty($module_name_list)) {
			return array();
		}

		return $this->query->where('name', $module_name_list)->where(function ($query){
			$query->where('has_new_version', 1)->whereor('has_new_branch', 1);
		})->orderby('lastupdatetime', 'desc')->getall('name');
	}

	
	public function searchWithoutRecycle() {
		return $this->query->from('modules_cloud', 'a')->select('a.*')->leftjoin('modules_recycle', 'b')->on(array('a.name' => 'b.name'))->where('b.name', 'NULL');
	}

	public function getUninstallTotalBySupportType($support) {
		return $this->searchWithoutRecycle()->where('a.' . $support. '_support', MODULE_SUPPORT_ACCOUNT)->where('install_status', array(MODULE_LOCAL_UNINSTALL, MODULE_CLOUD_UNINSTALL))->getcolumn('COUNT(*)');
	}

	public function deleteByName($modulename) {
		return $this->query->where('name', $modulename)->delete();
	}

	public function getUninstallModule() {
		return $this->searchWithoutRecycle()->where(function ($query){
			$query->where('a.install_status', MODULE_LOCAL_UNINSTALL)->whereor('a.install_status', MODULE_CLOUD_UNINSTALL);
		})->orderby('a.lastupdatetime', 'desc')->getall('a.name');
	}

	public function getUpgradeTotalBySupportType($support) {
		return $this->searchWithoutRecycle()->where('a.' . $support. '_support', 2)->where(function ($query){
			$query->where('a.has_new_version', 1)->whereor('a.has_new_branch', 1);
		})->getcolumn('COUNT(*)');
	}
}