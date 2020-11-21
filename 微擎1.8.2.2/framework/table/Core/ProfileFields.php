<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
namespace We7\Table\Core;

class ProfileFields extends \We7Table {
	protected $tableName = 'profile_fields';
	protected $primaryKey = 'id';
	protected $field = array(
		'field',
		'available',
		'title',
		'description',
		'displayorder',
		'required',
		'unchangeable',
		'showinregister',
		'field_length',
	);
	protected $default = array(
		'field' => '',
		'available' => 1,
		'title' => '',
		'description' => '',
		'displayorder' => 0,
		'required' => 0,
		'unchangeable' => 0,
		'showinregister' => 0,
		'field_length' => 0,
	);
	
	public function getProfileFields() {
		return $this->query->from($this->tableName)->getall('field');
	}
	
	public function searchKeyword($keyword) {
		$this->query->where('title LIKE', "%{$keyword}%");
		return $this;
	}
	
	public function getFieldsList() {
		return $this->query->from($this->tableName)->orderby('displayorder', 'DESC')->getall();
	}
	
	public function getExtraFields() {
		$default_field = array('realname', 'births', 'qq', 'mobile', 'address', 'resides');
		$fields = $this->getFieldsList();
		$extra_fields = array();
		if (!empty($fields) && is_array($fields)) {
			foreach ($fields as $field_info) {
				if ($field_info['available'] == 1 && $field_info['showinregister'] == 1 && !in_array($field_info['field'], $default_field)) {
					$extra_fields[] = $field_info;
				}
			}
		}
		return $extra_fields;
	}
}