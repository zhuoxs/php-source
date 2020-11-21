<?php
global $_W, $_GPC;
include 'common.php';
load() -> func('tpl');
$all_net=$this->get_allnet(); 

$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid(); 


$gz=$this->guanzhu(); 
//判断是否需要进入强制关注页
if($gz==1){
	if ($_W['fans']['follow']==0){
		include $this -> template('follow');
		exit;
	};
}else{
	//取得用户授权
	mc_oauth_userinfo();
}

//获取当前用户的信息
$member=$this->getmember();
//热门排行TOP8
$hotlist = pdo_fetchall("SELECT * FROM " . tablename('bc_community_town') . " WHERE weid=:uniacid AND lev=3 ORDER BY rd DESC,id DESC LIMIT 0,8", array(':uniacid' => $_W['uniacid']));
//获取当前村镇
if($_GPC['town_id']) {
    $thistown = pdo_fetch("SELECT * FROM " . tablename('bc_community_town') . " WHERE weid=:uniacid AND id=" . intval($_GPC['town_id']), array(':uniacid' => $_W['uniacid']));
}


//获取本市所有镇级列表
$town=pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND lev=2 ORDER BY paixu ASC,id DESC",array(':uniacid'=>$_W['uniacid']));
$townnum=count($town);

foreach ($town as $key => $value) {
	$town[$key]['pinyin'] = zhcnToPinyin($value['name']);
	$town[$key]['townlist'] = pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND lev=3 AND pid=".$value['id']." ORDER BY paixu ASC,id DESC",array(':uniacid'=>$_W['uniacid']));
}

$zm = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
$zmtown = array();
foreach($zm as $v){
	foreach($town as $value){
		if($value['pinyin'] == $v){
			$zmtown[$v][] = $value;
		}
	}
}



include $this -> template('select_town');

	
	

function zhcnToPinyin($str)//汉字转拼音函数
{
  if(empty($str)){return '';}
  $fchar=ord($str{0});
  if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0});
  $s1=iconv('UTF-8','gb2312',$str);
  $s2=iconv('gb2312','UTF-8',$s1);
  $s=$s2==$str?$s1:$str;
  $asc=ord($s{0})*256+ord($s{1})-65536;
  if($asc>=-20319&&$asc<=-20284) return 'A';
  if($asc>=-20283&&$asc<=-19776) return 'B';
  if($asc>=-19775&&$asc<=-19219) return 'C';
  if($asc>=-19218&&$asc<=-18711) return 'D';
  if($asc>=-18710&&$asc<=-18527) return 'E';
  if($asc>=-18526&&$asc<=-18240) return 'F';
  if($asc>=-18239&&$asc<=-17923) return 'G';
  if($asc>=-17922&&$asc<=-17418) return 'H';
  if($asc>=-17417&&$asc<=-16475) return 'J';
  if($asc>=-16474&&$asc<=-16213) return 'K';
  if($asc>=-16212&&$asc<=-15641) return 'L';
  if($asc>=-15640&&$asc<=-15166) return 'M';
  if($asc>=-15165&&$asc<=-14923) return 'N';
  if($asc>=-14922&&$asc<=-14915) return 'O';
  if($asc>=-14914&&$asc<=-14631) return 'P';
  if($asc>=-14630&&$asc<=-14150) return 'Q';
  if($asc>=-14149&&$asc<=-14091) return 'R';
  if($asc>=-14090&&$asc<=-13319) return 'S';
  if($asc>=-13318&&$asc<=-12839) return 'T';
  if($asc>=-12838&&$asc<=-12557) return 'W';
  if($asc>=-12556&&$asc<=-11848) return 'X';
  if($asc>=-11847&&$asc<=-11056) return 'Y';
  if($asc>=-11055&&$asc<=-10247) return 'Z';
  return null;
}


?>