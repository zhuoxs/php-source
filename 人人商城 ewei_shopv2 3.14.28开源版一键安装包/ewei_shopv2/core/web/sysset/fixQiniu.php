<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class FixQiniu_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$_W['ispost'] && $this->handler();
		include $this->template();
	}

	protected function handler()
	{
		global $_W;
		global $_GPC;
		$originDomain = trim($_GPC['originDomain']);
		$newDomain = trim($_GPC['newDomain']);
		if (empty($originDomain) || empty($newDomain)) {
			show_json(0, '原始域名和现在域名不能为空');
		}

		$originDomain = trim($originDomain, '/');
		$newDomain = trim($newDomain, '/');
		if (strpos($originDomain, 'http') === false && strpos($originDomain, 'https') === false) {
			show_json(0, '原域名请带http或https协议头');
		}

		if (strpos($newDomain, 'http') === false && strpos($newDomain, 'https') === false) {
			show_json(0, '新域名请带http或https协议头');
		}

		$goodsTable = tablename('ewei_shop_goods');
		$categoryTable = tablename('ewei_shop_category');
		$questionTable = tablename('ewei_shop_qa_question');

		try {
			$this->createTableCopyIfNotExists($goodsTable, time());
			$this->createTableCopyIfNotExists($categoryTable, time());
			p('qa') && $this->createTableCopyIfNotExists($questionTable, time());
		}
		catch (Exception $exception) {
			show_json(0, $exception->getMessage());
		}

		$updateGoodsTableSQL = '            update ' . $goodsTable . ' 
            set 
              `thumb` = replace(`thumb`, \'' . $originDomain . '\', \'' . $newDomain . '\'),
              `content` = replace(`content`, \'' . $originDomain . '\', \'' . $newDomain . '\'),
              `thumb_url` = replace(`thumb_url`, \'' . $originDomain . '\', \'' . $newDomain . '\')
            where 
              `uniacid` = ' . $_W['uniacid'];
		$updateCategorySQL = '            update ' . $categoryTable . ' 
            set 
              `thumb` = replace(`thumb`, \'' . $originDomain . '\', \'' . $newDomain . '\')
            where 
              `uniacid` = ' . $_W['uniacid'];
		$updateQuestionSQL = '            update ' . $questionTable . ' 
            set 
              `content` = replace(`content`, \'' . $originDomain . '\', \'' . $newDomain . '\')
            where 
              `uniacid` = ' . $_W['uniacid'];
		pdo_run($updateGoodsTableSQL);
		pdo_run($updateCategorySQL);
		p('qa') && pdo_run($updateQuestionSQL);
		$account = pdo_fetchcolumn('select name from ' . tablename('account_wechats') . (' where uniacid = ' . $_W['uniacid']));
		$logInfo = array('sql' => '
updateGoods:
' . $updateGoodsTableSQL . PHP_EOL . 'updateCategory:
' . $updateCategorySQL, 'originDomain' => $originDomain, 'newDomain' => $newDomain, 'uniacid' => $_W['uniacid'], 'account' => $account);
		p('qa') && ($logInfo .= '
updateQuestion:
' . $updateQuestionSQL);
		$this->log($logInfo);
		show_json(1, '修复成功');
	}

	/**
     * 生成备份表
     * ims_ewei_shop_member (原表名称)
     * 生成后
     * ims_ewei_shop_member_copy_{$hash}表名 (备份表名)
     * @param $tableName string 表名
     * @param $hash number|string 随机字符串
     * @return bool
     * @throws Exception string
     */
	protected function createTableCopyIfNotExists($tableName, $hash)
	{
		$tableCopyName = trim($tableName, '`');
		$tableCopyPrefixName = $tableCopyName . '_copy_';
		$tableCopyName .= '_copy_' . $hash;
		$tableCopyExists = pdo_fetch('show tables like \'' . $tableCopyPrefixName . '%\'');

		if (!$tableCopyExists) {
			pdo_run('create table ' . $tableCopyName . ' select * from ' . $tableName . ' where 1');
			$tableCopyExists = pdo_fetch('show tables like \'' . $tableCopyPrefixName . '%\'');
		}

		return true;
	}

	/**
     * @param $log array 要写入的数据内容
     * @param $append bool 是否开启追加模式
     */
	protected function log($log, $append = true)
	{
		$logPath = IA_ROOT . '/addons/ewei_shopv2/data/backup';

		if (!is_dir($logPath)) {
			mkdir($logPath);
		}

		$currentDay = date('Ymd', time());
		$logFile = $logPath . ('/fixQiniu' . $currentDay . '.log');
		$logTime = date('Y-m-d H:i:s', time());
		$logFormat = '[时间]' . $logTime . ',
[sql]' . $log['sql'] . ',
[修复前域名]' . $log['originDomain'] . '
[修复后域名]' . $log['newDomain'] . '
[公众号ID]' . $log['uniacid'] . '
[公众号名称]' . $log['account'];
		$logFormatContent = $logFormat . PHP_EOL . '-----------------------------------------------
';
		$append = $append == true ? FILE_APPEND : 0;
		file_put_contents($logFile, $logFormatContent, $append);
	}
}

?>
