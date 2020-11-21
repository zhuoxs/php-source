<?php

class Controller
{
	public function template($name = '')
	{
		global $_W;
		$style = ES_STYLE;
		$basicset = $this->basicset();
		$style = $basicset['template'];
		$source = ES_TEMPLATE_PATH . $style . '/' . $name . '.html';

		if (!is_file($source)) {
			$source = ES_TEMPLATE_PATH . ES_STYLE . '/' . $name . '.html';
		}

		if (!is_file($source)) {
			trigger_error('Template <b>' . $name . '</b> Not Found!');
			exit();
		}

		$compile = IA_ROOT . '/data/tpl/web/ewei_shop_web/' . ES_STYLE . ('/' . $name . '.tpl.php');
		if (DEVELOPMENT || !is_file($compile) || filemtime($compile) < filemtime($source)) {
			template_compile($source, $compile, true);
		}

		return $compile;
	}

	public function basicset()
	{
		global $_W;
		$basicset = pdo_fetch('select * from ' . tablename('ewei_shop_system_site') . ' where `type`=:type', array(':type' => 'set'));
		$data = iunserializer($basicset['content'], true);
		return $data;
	}

	public function pagination($total, $pageIndex, $pageSize = 15, $url = '', $context = array('before' => 5, 'after' => 4, 'ajaxcallback' => '', 'callbackfuncname' => ''))
	{
		global $_W;
		$pdata = array('tcount' => 0, 'tpage' => 0, 'cindex' => 0, 'findex' => 0, 'pindex' => 0, 'nindex' => 0, 'lindex' => 0, 'options' => '');

		if ($context['ajaxcallback']) {
			$context['isajax'] = true;
		}

		$pdata['tcount'] = $total;
		$pdata['tpage'] = ceil($total / $pageSize);

		if ($pdata['tpage'] <= 1) {
			return '';
		}

		$cindex = $pageIndex;
		$cindex = min($cindex, $pdata['tpage']);
		$cindex = max($cindex, 1);
		$pdata['cindex'] = $cindex;
		$pdata['findex'] = 1;
		$pdata['pindex'] = 1 < $cindex ? $cindex - 1 : 1;
		$pdata['nindex'] = $cindex < $pdata['tpage'] ? $cindex + 1 : $pdata['tpage'];
		$pdata['lindex'] = $pdata['tpage'];

		if ($context['isajax']) {
			if (!$url) {
				$url = $_W['script_name'] . '?' . http_build_query($_GET);
			}

			$pdata['faa'] = 'href="javascript:;" page="' . $pdata['findex'] . '" ' . ($callbackfunc ? 'onclick="' . $callbackfunc . '(\'' . $_W['script_name'] . $url . '\', \'' . $pdata['findex'] . '\', this);return false;"' : '');
			$pdata['paa'] = 'href="javascript:;" page="' . $pdata['pindex'] . '" ' . ($callbackfunc ? 'onclick="' . $callbackfunc . '(\'' . $_W['script_name'] . $url . '\', \'' . $pdata['pindex'] . '\', this);return false;"' : '');
			$pdata['naa'] = 'href="javascript:;" page="' . $pdata['nindex'] . '" ' . ($callbackfunc ? 'onclick="' . $callbackfunc . '(\'' . $_W['script_name'] . $url . '\', \'' . $pdata['nindex'] . '\', this);return false;"' : '');
			$pdata['laa'] = 'href="javascript:;" page="' . $pdata['lindex'] . '" ' . ($callbackfunc ? 'onclick="' . $callbackfunc . '(\'' . $_W['script_name'] . $url . '\', \'' . $pdata['lindex'] . '\', this);return false;"' : '');
		}
		else if ($url) {
			$pdata['faa'] = 'href="?' . str_replace('*', $pdata['findex'], $url) . '"';
			$pdata['paa'] = 'href="?' . str_replace('*', $pdata['pindex'], $url) . '"';
			$pdata['naa'] = 'href="?' . str_replace('*', $pdata['nindex'], $url) . '"';
			$pdata['laa'] = 'href="?' . str_replace('*', $pdata['lindex'], $url) . '"';
		}
		else {
			$_GET['page'] = $pdata['findex'];
			$pdata['faa'] = 'href="' . $_W['script_name'] . '?' . http_build_query($_GET) . '"';
			$_GET['page'] = $pdata['pindex'];
			$pdata['paa'] = 'href="' . $_W['script_name'] . '?' . http_build_query($_GET) . '"';
			$_GET['page'] = $pdata['nindex'];
			$pdata['naa'] = 'href="' . $_W['script_name'] . '?' . http_build_query($_GET) . '"';
			$_GET['page'] = $pdata['lindex'];
			$pdata['laa'] = 'href="' . $_W['script_name'] . '?' . http_build_query($_GET) . '"';
		}

		$html = '<div class="list-page">';

		if (1 < $pdata['cindex']) {
			$html .= '<a ' . $pdata['faa'] . ' class="pager-nav">首页</a>';
			$html .= '<a ' . $pdata['paa'] . ' class="pager-nav">上一页</a>';
		}

		if (!$context['before'] && $context['before'] != 0) {
			$context['before'] = 5;
		}

		if (!$context['after'] && $context['after'] != 0) {
			$context['after'] = 4;
		}

		if ($context['after'] != 0 && $context['before'] != 0) {
			$range = array();
			$range['start'] = max(1, $pdata['cindex'] - $context['before']);
			$range['end'] = min($pdata['tpage'], $pdata['cindex'] + $context['after']);

			if ($range['end'] - $range['start'] < $context['before'] + $context['after']) {
				$range['end'] = min($pdata['tpage'], $range['start'] + $context['before'] + $context['after']);
				$range['start'] = max(1, $range['end'] - $context['before'] - $context['after']);
			}

			$i = $range['start'];

			while ($i <= $range['end']) {
				if ($context['isajax']) {
					$aa = 'href="javascript:;" page="' . $i . '" ' . ($callbackfunc ? 'onclick="' . $callbackfunc . '(\'' . $_W['script_name'] . $url . '\', \'' . $i . '\', this);return false;"' : '');
				}
				else if ($url) {
					$aa = 'href="?' . str_replace('*', $i, $url) . '"';
				}
				else {
					$_GET['page'] = $i;
					$aa = 'href="?' . http_build_query($_GET) . '"';
				}

				$html .= $i == $pdata['cindex'] ? '<a href="javascript:void(0);" class="active">' . $i . '</a>' : '<a ' . $aa . '>' . $i . '</a>';
				++$i;
			}
		}

		if ($pdata['cindex'] < $pdata['tpage']) {
			$html .= '<a ' . $pdata['naa'] . ' class="pager-nav">下一页</a>';
			$html .= '<a ' . $pdata['laa'] . ' class="pager-nav">尾页</a>';
		}

		$html .= '</div>';
		return $html;
	}

	public function message($msg, $redirect = '', $type = '')
	{
		global $_W;
		global $_GPC;

		if ($redirect == 'refresh') {
			$redirect = $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
		}

		if ($redirect == 'referer') {
			$redirect = referer();
		}

		if ($redirect == '') {
			$type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'info';
		}
		else {
			$type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'success';
		}

		if ($_W['isajax'] || !empty($_GET['isajax']) || $type == 'ajax') {
			if ($type != 'ajax' && !empty($_GPC['target'])) {
				exit('
<script type="text/javascript">
parent.require([\'jquery\', \'util\'], function($, util){
	var url = ' . (!empty($redirect) ? 'parent.location.href' : '\'\'') . ';
	var modalobj = util.message(\'' . $msg . '\', \'\', \'' . $type . '\');
	if (url) {
		modalobj.on(\'hide.bs.modal\', function(){$(\'.modal\').each(function(){if($(this).attr(\'id\') != \'modal-message\') {$(this).modal(\'hide\');}});top.location.reload()});
	}
});
</script>');
			}
			else {
				$vars = array();
				$vars['message'] = $msg;
				$vars['redirect'] = $redirect;
				$vars['type'] = $type;
				exit(json_encode($vars));
			}
		}

		if (empty($msg) && !empty($redirect)) {
			header('location: ' . $redirect);
		}

		$label = $type;

		if ($type == 'error') {
			$label = 'danger';
		}

		if ($type == 'ajax' || $type == 'sql') {
			$label = 'warning';
		}

		include $this->template('common/message');
		exit();
	}
}

if (!defined('ES_PATH')) {
	exit('Access Denied');
}

?>
