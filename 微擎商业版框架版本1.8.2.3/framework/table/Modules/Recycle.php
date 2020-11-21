<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
namespace We7\Table\Modules;

class Recycle extends \We7Table {
	protected $tableName = 'modules_recycle';
	protected $primaryKey = 'id';
	protected $field = array(
		'name',
		'type',
	);
	protected $default = array(
		'name' => '',
		'type' => 0,
	);

	public function getByName($modulename) {
		return $this->query->where('name', $modulename)->get();
	}

	public function deleteByName($modulename) {
		return $this->query->where('name', $modulename)->delete();
	}

	public function addModule($modulename, $type = 1) {
		return $this->fill(array(
			'name' => $modulename,
			'type' => $type,
		))->save();
	}

	public function searchWithModulesCloud() {
		return $this->query->from('modules_cloud', 'a')->select('a.*')->leftjoin('modules_recycle', 'b')->on(array('a.name' => 'b.name'));

	}

	public function searchWithModules() {
		return $this->query->from('modules', 'a')->select('a.*')->leftjoin('modules_recycle', 'b')->on(array('a.name' => 'b.name'));

	}
}