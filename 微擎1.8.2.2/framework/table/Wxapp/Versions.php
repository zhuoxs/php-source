<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
namespace We7\Table\Wxapp;

class Versions extends \We7Table {
	protected $tableName = 'wxapp_versions';
	protected $primaryKey = 'id';
	protected $field = array(
		'uniacid',
		'multiid',
		'version',
		'description',
		'modules',
		'design_method',
		'template',
		'quickmenu',
		'createtime',
		'appjson',
		'default_appjson',
		'use_default',
		'type',
		'entry_id',
		'last_modules',
	);
	protected $default = array(
		'uniacid' => '',
		'multiid' => '',
		'version' => '',
		'description' => '',
		'modules' => '',
		'design_method' => '',
		'template' => '',
		'quickmenu' => '',
		'createtime' => '',
		'appjson' => '',
		'default_appjson' => '',
		'use_default' => 1,
		'type' => 0,
		'entry_id' => 0,
		'last_modules' => '',
	);

	
	public function latestVersion($uniacid) {
		return $this->query->where('uniacid', $uniacid)->orderby('id', 'desc')->limit(4)->getall('id');
	}

	public function getById($version_id) {
		$result = $this->query->where('id', $version_id)->get();
		if (!empty($result)) {
			$result['modules'] = iunserializer($result['modules']);
			$result['quickmenu'] = iunserializer($result['quickmenu']);
			$result['last_modules'] = iunserializer($result['last_modules']);
		}
		return $result;
	}

	public function getByUniacidAndVersion($uniacid, $version) {
		$result = $this->query->where('uniacid', $uniacid)->where('version', $version)->get();
		if (!empty($result)) {
			$result['modules'] = iunserializer($result['modules']);
			$result['quickmenu'] = iunserializer($result['quickmenu']);
			$result['last_modules'] = iunserializer($result['last_modules']);
		}
		return $result;
	}
}