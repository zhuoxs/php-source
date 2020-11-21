<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Backup_EweiShopV2Page extends SystemPage
{
	protected function table2sql($table)
	{
		global $db;
		$tabledump = 'DROP TABLE IF EXISTS ' . $table . ';
';
		$createtable = pdo_fetch('SHOW CREATE TABLE ' . $table);
		$tabledump .= $createtable['Create Table'] . ';
';
		$rows = pdo_fetchall('SELECT * FROM ' . $table);

		foreach ($rows as $row) {
			$comma = '';
			$tabledump .= 'INSERT INTO ' . $table . ' VALUES(';

			foreach ($row as $k => $v) {
				$tabledump .= $comma . '\'' . addslashes($v) . '\'';
				$comma = ',';
			}

			$tabledump .= ');
';
		}

		return $tabledump;
	}

	public function main()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$sqls = '';
			$sql = 'SHOW TABLES LIKE \'%ewei_shop_%\'';
			$tables = pdo_fetchall($sql);

			foreach ($tables as $k => $t) {
				$table = array_values($t);
				$tablename = $table[0];
				$sqls .= $this->table2sql($tablename) . '

';
			}

			$filename = 'ewei_shop_data_' . date('Y_m_d_H_i_s') . '.sql';
			header('Pragma: public');
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
			header('Cache-Control: no-store, no-cache, must-revalidate');
			header('Cache-Control: pre-check=0, post-check=0, max-age=0');
			header('Content-Encoding: UTF8');
			header('Content-type: application/force-download');
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			m('cache')->set('systembackuptime', date('Y-m-d H:i:s'), 'global');
			exit($sqls);
		}

		$lasttime = m('cache')->getString('systembackuptime', 'global');
		load()->func('tpl');
		include $this->template('system/data/backup');
	}
}

?>
