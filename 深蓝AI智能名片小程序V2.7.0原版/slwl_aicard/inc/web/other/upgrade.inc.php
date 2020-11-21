<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');

$domain = trim(preg_replace('/http(s)?:\\/\\//', '', rtrim($_W['siteroot'], '/')));
$ip = gethostbyname($_SERVER['HTTP_HOST']);

$operation = $_GPC['op'] ? $_GPC['op'] : 'display';

if ($operation == 'display') {

} else if ($operation == 'post') {
	if ($_W['ispost']) {
		load()->func('file');

		$agreement_1 = intval($_GPC['agreement_1']);
		$agreement_2 = intval($_GPC['agreement_2']);
		$agreement_3 = intval($_GPC['agreement_3']);

		if ($agreement_1 != '1' || $agreement_2 != '1' || $agreement_3 != '1') {
			sl_ajax(1, '抱歉，同步前请仔细阅读更新协议');
		}

		$path =  MODULE_ROOT . '/data/';
		if (!is_dir($path)) {
			mkdirs($path);
		}

		if ($_W['slwl']['set']['auth_settings']) {
			$settings = $_W['slwl']['set']['auth_settings'];
		} else {
			sl_ajax(1, '系统还没有受权');
		}

		$param = array();
		$param['host'] = $settings['domain'];
		$param['ip'] = $settings['ip'];
		$param['family'] = SLWL_FAMILY;
		$param['code'] = $settings['code'];

		load()->func('communication');

		$resp = ihttp_request(SLWL_AUTH_URL . 'Index/download', $param);
		$result = @json_decode($resp['content'], true);

		// 执行升级
		if (!array_key_exists('ErrMsg', $result)) {

			$file_url = $result['Data']['file_url']; // 文件URL
			$file_address = $path . 'test.zip';
			$file_md5 = $result['Data']['file_md5']; // 文件MD5
			$file_version = $result['Data']['version']; // 文件MD5

			$file = httpGet($file_url);
			$rs = file_put_contents($file_address, $file);

			if (strcasecmp($file_md5, md5_file($file_address)) == 0) {
				$updatedir = $path . 'temp';

				if(!is_dir($updatedir)) {
					mkdirs($updatedir);
				}

				require SLWL_PATH . "lib/PHPExcel/PHPExcel/Shared/PCLZip/pclzip.lib.php";
				$thisfolder = new PclZip($file_address);
				$isextract = $thisfolder->extract(PCLZIP_OPT_PATH, $updatedir);
				if ($isextract == 0) {
					sl_ajax(1, '解压更新包失败');
					exit;
				}

				$archive = new PclZip($file_address);
				$list = $archive->extract(PCLZIP_OPT_PATH, MODULE_ROOT, PCLZIP_OPT_REPLACE_NEWER);

				if ($list == 0) {
					sl_ajax(1, '升级失败-远程升级文件不存在或站点没有修改权限');
					exit;
				}

				@unlink($file_address); //删除文件

				$tablepre = $_W['config']['db']['tablepre']; // 表前缀

				// 库更新
				$file_app_slwl = $updatedir . '/data/temp/app.slwl';
				if (file_exists($file_app_slwl)) {
					$app_slwl = file_get_contents($file_app_slwl);
					$app_slwl = str_ireplace('ims_', $tablepre, $app_slwl); // 替换现有的表前缀

					@unlink($file_app_slwl);

					$sql_list = array();
					load()->func('db');
					if ($app_slwl) {
						$tables = unserialize($app_slwl);

						foreach ($tables as $k => $remote) {
							$name_table = str_ireplace($tablepre, '', $remote['tablename']);
							$local = db_table_schema(pdo(), $name_table);
							$sqls = db_table_fix_sql($local, $remote);

							foreach ($sqls as $key => $value) {
								$sql_list[] = $value;
							}
						}

						$err = 0;
						foreach ($sql_list as $k => $v) {
							// 执行SQL语句
							if (pdo_run($v) === false) {
								$err += 1;
							}
						}
					}

					if ($err > 0) {
						sl_ajax(1, '更新出错，请重新运行升级程序');
						exit;
					}
				}

				$file_sql = $updatedir . '/data/temp/update.sql';
				if (file_exists($file_sql)) {
					$sql_update = file_get_contents($file_sql); // 把SQL语句以字符串读入$sql
					$sql_update = str_ireplace('ims_', $tablepre, $sql_update); // 替换现有的表前缀
					@unlink($file_sql); //执行之前就删除

					pdo_run($sql_update); // 执行SQL语句
				}

				deldir($updatedir);

				$rst = slwl_upgrade_data();

				if ($rst && $rst['code']=='0') {

					if (function_exists('cache_updatecache')) {
						@cache_updatecache(); // 刷新框架缓存 2.0
					}

					sl_ajax(0, '更新完成');
				} else {
					sl_ajax(1, $rst['msg']);
				}

			} else {
				@unlink($file_address); //删除文件
				sl_ajax(1, '网络传输错误, 文件MD5值不符');
			}
		} else {
			$msg = $result['ErrMsg'];
			sl_ajax(1, $msg);
		}
		sl_ajax(0, '更新系统成功');
	}


} else if ($operation == 'check') {

	load()->func('communication');
	if ($_W['slwl']['set']['auth_settings']) {
		$settings = $_W['slwl']['set']['auth_settings'];
	} else {
		sl_ajax(1, '系统还没有受权');
	}

	$param = array();
	$param['user'] = $_W['setting']['copyright']['sitename'] . '-' . $_W['current_module']['title'];
	$param['host'] = $domain;
	$param['ip'] = $ip;
	$param['family'] = SLWL_FAMILY;
	$param['code'] = $settings['code'];
	$param['version'] = SLWL_VERSION;
	$param['release'] = SLWL_RELEASE;

	$resp = ihttp_request(SLWL_AUTH_URL . 'Index/online', $param);
	$result = @json_decode($resp['content'], true);

	if ($result['IsSuccess']) {
		sl_ajax(0, $result['Data']);
	} else {
		@putlog('检查更新', $result);
		sl_ajax(1, $result);
	}
	exit;


} else {
	message('请求方法不存在');
}

include $this->template('web/other/upgrade');

?>
