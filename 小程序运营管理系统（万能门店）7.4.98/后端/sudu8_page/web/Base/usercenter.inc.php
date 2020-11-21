<?php 

global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$cateid = $_GPC['cateid'];
$chid = $_GPC['chid'];

$items = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_usercenter_set') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
$usercenterset = unserialize($items['usercenterset']);

// echo "<pre>";
// var_dump($usercenterset);
// echo "</pre>";
// die();

// 先组装成选择显示的数据
$arrs = array();
for($i = 1; $i <= 9; $i++){
    if($usercenterset['flag'.$i]==2){
        $jdata = array(
            "title" => $usercenterset['title'.$i],
            "thumb" => $usercenterset['thumb'.$i],
            "num" => $usercenterset['num'.$i],
            "url" => $usercenterset['url'.$i]
        );
        array_push($arrs, $jdata);
    }
}

// 对数据进行排序
$counts = count($arrs);
$temps = "";

for($i = 0 ; $i < $counts-1; $i++){
    for($j = 0; $j < $counts - 1 -$i; $j++){
       if($arrs[$j+1]['num'] > $arrs[$j]['num']){
            $temps = $arrs[$j];
            $arrs[$j] = $arrs[$j+1];
            $arrs[$j+1] = $temps;
       }
    }
}





if (checksubmit('submit')) {

    $data = array(

        'title1' => $_GPC['title1'],
        'num1' => $_GPC['num1'],
        'thumb1' => $_GPC['img1'],
        'flag1' => $_GPC['flag1'],
        'url1' => $_GPC['url1'],

        'title2' => $_GPC['title2'],
        'num2' => $_GPC['num2'],
        'thumb2' => $_GPC['img2'],
        'flag2' => $_GPC['flag2'],
        'url2' => $_GPC['url2'],

        'title3' => $_GPC['title3'],
        'num3' => $_GPC['num3'],
        'thumb3' => $_GPC['img3'],
        'flag3' => $_GPC['flag3'],
        'url3' => $_GPC['url3'],

        'title4' => $_GPC['title4'],
        'num4' => $_GPC['num4'],
        'thumb4' => $_GPC['img4'],
        'flag4' => $_GPC['flag4'],
        'url4' => $_GPC['url4'],

        'title5' => $_GPC['title5'],
        'num5' => $_GPC['num5'],
        'thumb5' => $_GPC['img5'],
        'flag5' => $_GPC['flag5'],
        'url5' => $_GPC['url5'],

        'title6' => $_GPC['title6'],
        'num6' => $_GPC['num6'],
        'thumb6' => $_GPC['img6'],
        'flag6' => $_GPC['flag6'],
        'url6' => $_GPC['url6'],

        'title7' => $_GPC['title7'],
        'num7' => $_GPC['num7'],
        'thumb7' => $_GPC['img7'],
        'flag7' => $_GPC['flag7'],
        'url7' => $_GPC['url7'],

        'title8' => $_GPC['title8'],
        'num8' => $_GPC['num8'],
        'thumb8' => $_GPC['img8'],
        'flag8' => $_GPC['flag8'],
        'url8' => $_GPC['url8'],

        'title9' => $_GPC['title9'],
        'num9' => $_GPC['num9'],
        'thumb9' => $_GPC['img9'],
        'flag9' => $_GPC['flag9'],
        'url9' => $_GPC['url9']

    );
    
    $strs = serialize($data);

    $data = array(

        'uniacid' => $uniacid,

        'usercenterset' => $strs

    );

    if($items){
        pdo_update("sudu8_page_usercenter_set",array("usercenterset"=>$strs),array("uniacid"=>$uniacid));
    }else{
        pdo_insert("sudu8_page_usercenter_set",$data);
    }
    message('个人中心配置成功!', $this->createWebUrl('base', array('op'=>'usercenter',"cateid"=>$cateid,"chid"=>$chid)), 'success');

}













return include self::template('web/Base/usercenter');