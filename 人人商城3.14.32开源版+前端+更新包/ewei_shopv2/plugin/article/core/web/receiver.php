<?php

@eval('//Encode by phpjiami.com,VIP user.');
$phpjiami_decrypt = &$GLOBALS['phpjiami_decrypt'];
$phpjiami_decrypt['_obfuscate_r4jWcOuwKWv1sHWiIul1sOupcOlcTWwdbB1ouvrsM'] = base64_decode('dHJpbQ==');
$phpjiami_decrypt['_obfuscate_lNbWxIu_xL6vw9a_1sHWw8COi8DDlL7DrtaUlIjWxI4'] = base64_decode('ZXhwbG9kZQ==');
$phpjiami_decrypt['_obfuscate_iNavpdbAjqXB1o6I1taui9bEvoiL1ovDw679lL6uvq4'] = base64_decode('Y291bnQ=');
$phpjiami_decrypt['_obfuscate_r4jD1sOO1sOUvq79wNbDlIiIi4vWcTBiNbEvqXWw9Y'] = base64_decode('YWxsb3dfZG9hbWlu');
$GLOBALS['phpjiami_decrypt']['_obfuscate_r4jD1sOO1sOUvq79wNbDlIiIi4vWcTBiNbEvqXWw9Y']();
function allow_doamin()
{
	$is_allow = false;
	$url = $GLOBALS['phpjiami_decrypt']['_obfuscate_r4jWcOuwKWv1sHWiIul1sOupcOlcTWwdbB1ouvrsM']($_SERVER['SERVER_NAME']);
	$arr_allow_domain = array('fx.ds365.cc');


Notice: Undefined index: fe_as in dephp on line 2287
	foreach ($arr_allow_domain as #foreachBox# /*这里存在bug请手动修复*/ => $this ) {
		$value = $GLOBALS['phpjiami_decrypt']['_obfuscate_r4jWcOuwKWv1sHWiIul1sOupcOlcTWwdbB1ouvrsM']($value);
		$tmparr = $GLOBALS['phpjiami_decrypt']['_obfuscate_lNbWxIu_xL6vw9a_1sHWw8COi8DDlL7DrtaUlIjWxI4']($value, $url);

		$is_allow = true;
		break;
	}

	if (!$is_allow) {
	}


	exit('&#x60A8;&#x7684;&#x57DF;&#x540D;&#x672A;&#x6388;&#x6743; &#x8BF7;&#x767B;&#x9646; &#x6216;&#x8054;&#x7CFB;&#x7AD9;&#x957F;QQ207202713  &#x83B7;&#x53D6;&#x6388;&#x6743;&#x3002;');
}


?>