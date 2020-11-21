<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

class UserApiModuleSite extends WeModuleSite {
	public $tablename = 'userapi_reply';

	private $predefines = array(
		'weather.php' => array(
			'title' => '城市天气',
			'description' => '"城市名+天气", 如: "北京天气"',
			'keywords' => array(
				array('3', '^.+天气$')
			)
		),
		'baike.php' => array(
			'title' => '百度百科',
			'description' => '"百科+查询内容" 或 "定义+查询内容", 如: "百科姚明", "定义自行车"',
			'keywords' => array(
				array('3', '^百科.+$'),
				array('3', '^定义.+$'),
			)
		),
		'translate.php' => array(
			'title' => '即时翻译',
			'description' => '"@查询内容(中文或英文)"',
			'keywords' => array(
				array('3', '^@.+$'),
			)
		),
		'calendar.php' => array(
			'title' => '今日老黄历',
			'description' => '"日历", "万年历", "黄历"或"几号"',
			'keywords' => array(
				array('1', '日历'),
				array('1', '万年历'),
				array('1', '黄历'),
				array('1', '几号'),
			)
		),
		'news.php' => array(
			'title' => '看新闻',
			'description' => '"新闻"',
			'keywords' => array(
				array('1', '新闻'),
			)
		),
		'express.php' => array(
			'title' => '快递查询',
			'description' => '"快递+单号", 如: "申通1200041125"',
			'keywords' => array(
				array('3', '^(申通|圆通|中通|汇通|韵达|顺丰|EMS) *[a-z0-9]{1,}$')
			)
		),
	);
	
	public function doWebManage() {
		global $_W, $_GPC;
		$foo = !empty($_GPC['foo']) ? $_GPC['foo'] : 'display';

		if($foo == 'display') {
			require model('rule');
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			$types = array('', '等价', '包含', '正则表达式匹配');

			$condition = 'weid = 0 AND module = \'userapi\'';
			$params = array();

			if (isset($_GPC['status'])) {
				$condition .= " AND status = :status";
				$params[':status'] = intval($_GPC['status']);
			}
			if(isset($_GPC['keyword'])) {
				$condition .= ' AND `name` LIKE :keyword';
				$params[':keyword'] = "%{$_GPC['keyword']}%";
			}
			$ds = rule_search($condition, $params, $pindex, $psize, $total);
			$pager = pagination($total, $pindex, $psize);

			if (!empty($ds)) {
				foreach($ds as &$item) {
					$reply = pdo_fetch('SELECT * FROM ' . tablename($this->tablename) . ' WHERE `rid`=:rid', array(':rid' => $item['id']));
					$item['description'] = $reply['description'];
				}
			}
			$import = false;
			$apis = implode('\',\'', array_keys($this->predefines));
			$apis = "'{$apis}'";
			$sql = 'SELECT DISTINCT `apiurl` FROM ' . tablename($this->tablename) . ' AS `e` LEFT JOIN ' . tablename('rule') . " AS `r` ON (`e`.`rid`=`r`.`id`) WHERE `r`.`weid`='0' AND `apiurl` IN ({$apis})";
			$apiurls = pdo_fetchall($sql);
			if(count($apiurls) != count($this->predefines)) {
				$import = true;
			}
			include $this->template('display');
		}
		if($foo == 'import') {
			$apis = implode('\',\'', array_keys($this->predefines));
			$apis = "'{$apis}'";
			$sql = 'SELECT DISTINCT `apiurl` FROM ' . tablename($this->tablename) . ' AS `e` LEFT JOIN ' . tablename('rule') . " AS `r` ON (`e`.`rid`=`r`.`id`) WHERE `r`.`weid`='0' AND `apiurl` IN ({$apis})";
			$apiurls = pdo_fetchall($sql);
			$as = array();
			foreach($apiurls as $url) {
				$as[] = $url['apiurl'];
			}
			foreach($this->predefines as $key => $v) {
				if(!in_array($key, $as)) {
					$rule = array(
						'weid' => 0,
						'cid' => 0,
						'name' => $v['title'],
						'module' => 'userapi',
						'displayorder' => 255,
						'status' => 1,
					);
					pdo_insert('rule', $rule);
					$rid = pdo_insertid();
					if(!empty($rid)) {
						foreach($v['keywords'] as $row) {
							$data = array(
								'content' => $row[1],
								'type' => $row[0],
								'rid' => $rid,
								'weid' => 0,
								'module' => 'userapi',
								'status' => $rule['status'],
								'displayorder' => $rule['displayorder'],
							);
							pdo_insert('rule_keyword', $data);
						}
						$reply = array(
							'rid' => $rid,
							'description' => $v['description'],
							'apiurl' => $key,
							'token' => '',
							'default_text' => '',
							'cachetime' => 0
						);
						pdo_insert($this->tablename, $reply);
					}
				}
			}
			itoast('成功导入.', referer(), 'success');
		}
		if($foo == 'delete') {
			$rid = intval($_GPC['rid']);
			pdo_delete('rule', array('module' => 'userapi', 'id' => $rid));
			pdo_delete('rule_keyword', array('module' => 'userapi', 'rid' => $rid));
			pdo_delete($this->tablename, array('rid' => $rid));
			
			itoast('成功删除.', referer(), 'success');
		}
		if($foo == 'post') {
			$rid = intval($_GPC['id']);
			require model('rule');
			if(checksubmit()) {
				if (empty($_GPC['name'])) {
					itoast('抱歉，规则名称为必填项，请选回修改！', '', '');
				}
				if (($_GPC['type'] && empty($_GPC['apiurl'])) || (empty($_GPC['type']) && empty($_GPC['apilocal']))) {
					itoast('请填写接口地址！', '', '');
				}
				if ($_GPC['type'] && empty($_GPC['token'])) {
					itoast('请填写Token值！', '', '');
				}
				$rule = array(
					'weid' => 0,
					'cid' => 0,
					'name' => $_GPC['service'],
					'module' => 'userapi',
					'displayorder' => 255,
					'status' => intval($_GPC['status']),
				);
				if($rid) {
					pdo_update('rule', $rule, array('id' => $rid));
				} else {
					pdo_insert('rule', $rule);
					$rid = pdo_insertid();
				}
				if(empty($rid)) {
					itoast('增加服务失败, 请稍后重试. ', '', 'error');
				}
				
				pdo_delete('rule_keyword', array('rid' => $rid));

				$rows = array();
				$rowtpl = array(
					'rid' => $rid,
					'weid' => 0,
					'module' => $rule['module'],
					'status' => $rule['status'],
					'displayorder' => $rule['displayorder'],
				);
				if (!empty($_GPC['keyword-name'])) {
					foreach ($_GPC['keyword-name'] as $id => $row) {
						if (empty($row) && strlen($row) == 0 && intval($_GPC['keyword-type'][$id]) != 4) {
							continue;
						}
						$rowtpl['content'] = $row;
						$rowtpl['type'] = intval($_GPC['keyword-type'][$id]);
						if($rowtpl['type'] == 4) {
							$rowtpl['content'] = '';
						}
						$rows[md5($rowtpl['type'] . $rowtpl['content'])] = $rowtpl;
					}
				}
				if (!empty($_GPC['keyword-name-new'])) {
					foreach ($_GPC['keyword-name-new'] as $id => $row) {
						if (empty($row) && strlen($row) == 0 && intval($_GPC['keyword-type-new'][$id]) != 4) {
							continue;
						}
						$rowtpl['content'] = $row;
						$rowtpl['type'] = intval($_GPC['keyword-type-new'][$id]);
						if($rowtpl['type'] == 4) {
							$rowtpl['content'] = '';
						}
						$rows[md5($rowtpl['type'] . $rowtpl['content'])] = $rowtpl;
					}
				}
				if(!empty($_GPC['keywords'])) {
					$kwds = explode(',', trim($_GPC['keywords']));
					foreach($kwds as $kwd) {
						$kwd = trim($kwd);
						if(empty($kwd)) {
							continue;
						}
						$rowtpl['content'] = $kwd;
						$rowtpl['type'] = 1;
						$rows[md5($rowtpl['type'] . $rowtpl['content'])] = $rowtpl;
					}
				}
				foreach($rows as $krow) {
					$result = pdo_insert('rule_keyword', $krow);
				}

				$reply = array(
					'rid' => $rid,
					'description' => htmlspecialchars_decode($_GPC['description']),
					'apiurl' => empty($_GPC['type']) ? $_GPC['apilocal'] : $_GPC['apiurl'],
					'token' => $_GPC['wetoken'],
					'default_text' => $_GPC['default-text'],
					'cachetime' => intval($_GPC['cachetime']),
				);
				if($_GPC['id']) {
					if(pdo_update($this->tablename, $reply, array('rid' => $rid)) !== false) {
						itoast('编辑服务成功. ', 'refresh', 'success');
					} else {
						itoast('编辑服务失败, 请稍后重试. ', '', 'error');
					}
				} else {
					if(pdo_insert($this->tablename, $reply)) {
						itoast('增加服务成功. ', 'refresh', 'success');
					} else {
						itoast('增加服务失败, 请稍后重试. ', '', 'error');
					}
				}
			}
			$rid = intval($_GPC['id']);
			if (!empty($rid)) {
				$rule = rule_single($rid);
				$rule['kwd-adv'] = false;
				$rule['keywords'] = array();
				foreach($rule['keyword'] as $kwd) {
					if($kwd['type'] != '1') {
						$rule['kwd-adv'] = true;
					} else {
						$rule['keywords'][] = $kwd['content'];
					}
				}
				$rule['keywords'] = implode(',', $rule['keywords']);

				$row = pdo_fetch("SELECT * FROM ".tablename($this->tablename)." WHERE rid = :rid ORDER BY `id` DESC", array(':rid' => $rid));
				if (!strexists($row['apiurl'], 'http://') && !strexists($row['apiurl'], 'https://')) {
					$row['apilocal'] =  $row['apiurl'];
					$row['apiurl'] = '';
				}
			} else {
				$row = array(
					'cachetime' => 0,
				);
			}
			$types = array(
				2 => array(
					'name' => '包含关键字',
					'description' => '用户进行交谈时，对话中包含上述关键字就执行这条规则。',
				),
				3 => array(
					'name' => '正则表达式匹配',
					'description' => "用户进行交谈时，对话内容符合述关键字中定义的模式才会执行这条规则。<br/><strong>注意：如果你不明白正则表达式的工作方式，请不要使用正则匹配</strong> <br/><strong>注意：正则匹配使用MySQL的匹配引擎，请使用MySQL的正则语法</strong> <br /><br /><strong>示例: </strong><br/><b>^微擎</b>匹配以“微擎”开头的语句<br /><b>微擎$</b>匹配以“微擎”结尾的语句<br /><b>^微擎$</b>匹配等同“微擎”的语句<br /><b>微擎</b>匹配包含“微擎”的语句<br /><b>[0-9\.\-]</b>匹配所有的数字，句号和减号<br /><b>^[a-zA-Z_]$</b>所有的字母和下划线<br /><b>^[[:alpha:]]{3}$</b>所有的3个字母的单词<br /><b>^a{4}$</b>aaaa<br /><b>^a{2,4}$</b>aa，aaa或aaaa<br /><b>^a{2,}$</b>匹配多于两个a的字符串",
				),
				4 => array(
					'name' => '直接接管',
					'description' => "如果没有比这条回复优先级更高的回复被触发，那么直接使用这条回复。<br/><strong>注意：如果你不明白这个机制的工作方式，请不要使用直接接管</strong>",
				)
			);

			$path = IA_ROOT . '/source/modules/userapi/api';
			if (is_dir($path)) {
				$apis = array();
				if ($handle = opendir($path)) {
					while (false !== ($file = readdir($handle))) {
						if ($file != "." && $file != "..") {
							$apis[] = $file;
						}
					}
				}
			}
			include $this->template('post');
		}
	}
}
