<?php
//QQ63779278
function cashierUrl($do = '', $query = NULL, $full = false)
{
	global $_W;
	global $_GPC;
	$dos = explode('/', trim($do));
	$routes = array();
	$routes[] = $dos[0];

	if (isset($dos[1])) {
		$routes[] = $dos[1];
	}

	if (isset($dos[2])) {
		$routes[] = $dos[2];
	}

	if (isset($dos[3])) {
		$routes[] = $dos[3];
	}

	$r = implode('.', $routes);

	if (!is_array($query)) {
		$query = array();
	}

	if (!empty($r)) {
		$query = array_merge(array('r' => $r), $query);
	}

	$query = array_merge(array('i' => (int) $_GPC['i']), $query);
	return str_replace('./index.php', './cashier.php', wurl('', $query));
}

if ($_GPC['r'] != 'cashier.manage.login') {
	session_start();

	if (empty($_SESSION['__cashier_' . (int) $_GPC['i'] . '_session'])) {
		header('location: ' . cashierUrl('login'));
		exit();
	}

	$GLOBALS['_W']['cashieruser'] = $_SESSION['__cashier_' . (int) $_GPC['i'] . '_session'];
	$GLOBALS['_W']['cashierid'] = $GLOBALS['_W']['cashieruser']['id'];
}

?>
