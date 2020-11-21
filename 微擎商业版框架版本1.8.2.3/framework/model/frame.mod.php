<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

function frame_lists(){
	$data = pdo_fetchall('SELECT * FROM ' . tablename('core_menu') . ' WHERE pid = 0 ORDER BY is_system ASC, displayorder ASC, id ASC');
	if(!empty($data)) {
		foreach($data as &$da) {
			$childs = pdo_fetchall('SELECT * FROM ' . tablename('core_menu') . ' WHERE pid = :pid ORDER BY is_system ASC, displayorder ASC, id ASC', array(':pid' => $da['id']));
			if(!empty($childs)) {
				foreach($childs as &$child) {
					$grandchilds = pdo_fetchall('SELECT * FROM ' . tablename('core_menu') . ' WHERE pid = :pid ORDER BY is_system ASC, displayorder ASC, id ASC', array(':pid' => $child['id']));
					if(!empty($grandchilds)) {
						foreach($grandchilds as &$grandchild) {
							$greatsons = pdo_fetchall('SELECT * FROM ' . tablename('core_menu') . ' WHERE pid = :pid ORDER BY is_system ASC, displayorder ASC, id ASC', array(':pid' => $grandchild['id']));
							$grandchild['greatsons'] = $greatsons;
						}
					}
					$child['grandchild'] = $grandchilds;
				}
				$da['child'] = $childs;
			}
		}
	}
	return $data;
}