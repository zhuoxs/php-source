<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

define('IA_ROOT', str_replace('\\', '/', dirname(dirname(__FILE__))));
require_once IA_ROOT . '/framework/library/phpexcel/PHPExcel/Reader/CSV.php';
require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Taobaocsv_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$this->model->CheckPlugin('taobao');
		$merchid = $_W['merchid'];
		$uploadStart = '0';
		$uploadnum = '0';
		$excelurl = $_W['siteroot'] . 'addons/ewei_shopv2/plugin/taobao/data/test.xlsx';
		$zipurl = $_W['siteroot'] . 'addons/ewei_shopv2/plugin/taobao/data/test.zip';

		if ($_W['ispost']) {
			$rows = m('excel')->import('excelfile');
			$num = count($rows);
			$i = 0;
			$colsIndex = array();

			foreach ($rows[1] as $cols => $col) {
				if ($col == 'title') {
					$colsIndex['title'] = $i;
				}

				if ($col == 'price') {
					$colsIndex['price'] = $i;
				}

				if ($col == 'num') {
					$colsIndex['num'] = $i;
				}

				if ($col == 'description') {
					$colsIndex['description'] = $i;
				}

				if ($col == 'skuProps') {
					$colsIndex['skuProps'] = $i;
				}

				if ($col == 'picture') {
					$colsIndex['picture'] = $i;
				}

				if ($col == 'propAlias') {
					$colsIndex['propAlias'] = $i;
				}

				++$i;
			}

			$filename = $_FILES['excelfile']['name'];
			$filename = substr($filename, 0, strpos($filename, '.'));
			$rows = array_slice($rows, 3, count($rows) - 3);
			$items = array();
			$this->get_zip_originalsize($_FILES['zipfile']['tmp_name'], '../attachment/images/' . $_W['uniacid'] . '/' . date('Y') . '/' . date('m') . '/');
			$num = 0;

			foreach ($rows as $rownu => $col) {
				$item = array();
				$item['merchid'] = $merchid;
				$item['title'] = $col[$colsIndex[title]];
				$item['marketprice'] = $col[$colsIndex[price]];
				$item['total'] = $col[$colsIndex[num]];
				$item['content'] = $col[$colsIndex[description]];
				$picContents = $col[$colsIndex[picture]];
				$allpics = explode(';', $picContents);
				$pics = array();
				$optionpics = array();

				foreach ($allpics as $imgurl) {
					if (empty($imgurl)) {
						continue;
					}

					$picDetail = explode('|', $imgurl);
					$picDetail = explode(':', $picDetail[0]);
					$imgurl = 'http://' . $_SERVER['SERVER_NAME'] . '/attachment/images/' . $_W['uniacid'] . '/' . date('Y') . '/' . date('m') . '/' . $picDetail[0] . '.png';

					if (@fopen($imgurl, 'r')) {
						if ($picDetail[1] == 1) {
							$pics[] = $imgurl;
						}

						if ($picDetail[1] == 2) {
							$optionpics[$picDetail[0]] = $imgurl;
						}
					}
				}

				$item['pics'] = $pics;
				$items[] = $item;
				++$num;
			}

			session_start();
			$_SESSION['taobaoCSV'] = $items;
			m('cache')->set('taobaoCSV', $items, $_W['uniacid'] . $_W['merchid']);
			$uploadStart = '1';
			$uploadnum = $num;
		}

		include $this->template();
	}

	public function fetch()
	{
		global $_W;
		global $_GPC;
		$merchid = $_W['merchid'];
		set_time_limit(0);
		$num = intval($_GPC['num']);
		$totalnum = intval($_GPC['totalnum']);
		session_start();
		$items = $_SESSION['taobaoCSV'];

		if (empty($items)) {
			$items = m('cache')->get('taobaoCSV', $_W['uniacid'] . $_W['merchid']);
		}

		$taobao_plugin = p('taobao');
		$ret = $taobao_plugin->save_taobaocsv_goods($items[$num], $merchid);
		plog('taobaoCSV.main', '淘宝CSV宝贝批量导入' . $ret[goodsid]);

		if ($totalnum <= $num + 1) {
			unset($_SESSION['taobaoCSV']);
		}

		exit(json_encode($ret));
	}

	public function get_zip_originalsize($filename, $path)
	{
		if (!file_exists($filename)) {
			exit('文件 ' . $filename . ' 不存在！');
		}

		$filename = iconv('utf-8', 'gb2312', $filename);
		$path = iconv('utf-8', 'gb2312', $path);
		$resource = zip_open($filename);
		$i = 1;

		while ($dir_resource = zip_read($resource)) {
			if (zip_entry_open($resource, $dir_resource)) {
				$file_name = $path . zip_entry_name($dir_resource);
				$file_path = substr($file_name, 0, strrpos($file_name, '/'));

				if (!is_dir($file_path)) {
					mkdir($file_path, 511, true);
				}

				if (!is_dir($file_name)) {
					$file_size = zip_entry_filesize($dir_resource);

					if ($file_size < 1024 * 1024 * 10) {
						$file_content = zip_entry_read($dir_resource, $file_size);
						$ext = strrchr($file_name, '.');

						if ($ext == '.png') {
							file_put_contents($file_name, $file_content);
						}
						else {
							if ($ext == '.tbi') {
								$file_name = substr($file_name, 0, strlen($file_name) - 4);
								file_put_contents($file_name . '.png', $file_content);
							}
						}
					}
				}

				zip_entry_close($dir_resource);
			}
		}

		zip_close($resource);
	}
}

?>
