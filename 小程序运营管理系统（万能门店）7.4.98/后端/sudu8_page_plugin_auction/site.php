<?php
/**
 * Sudu8_page_plugin_auction-拍卖插件
 *
 * @author 懒人源码
 * @url  www.lanrenzhijia.com
 */
defined('IN_IA') or exit('Access Denied');
define("HTTPSHOST",$_W['attachurl']);
define("ROOT_PATH",IA_ROOT.'/addons/sudu8_page/');

class Sudu8_page_plugin_auctionModuleSite extends WeModuleSite {

//栏目管理
public function doWebCatelist(){
  global $_GPC, $_W;
  $op=$_GPC['op'];
  $title=$_GPC['title'];
  $uid=$_W['uniacid'];
  $id=$_GPC['id'];
  $page=$_GPC['page'];
  $backdo='';
  if ($op=='post') {
    $backdo='add';
  }else {
    $backdo='toedit';
  }
  if ($op=='add') {
    $t= pdo_get('sudu8_page_auction_column',array('name'=>$title,'uniacid'=>$uid));//判断是否存在
    if ($t==false) {
      pdo_insert('sudu8_page_auction_column',array('name'=>$title,'uniacid'=>$uid));
      message('添加栏目成功', $this->createWebUrl('catelist'), 'success',array('op'=>'display'));
    }else {
      message('您添加的栏目已经存在！', $this->createWebUrl('catelist'), 'success',array('op'=>'display'));
    }
  }

  if ($op==null) {
    $op='display';
  }
  if ($page!=null&&$page!='') {
    $op='display';
  }
  if ($op=='display'&&$page=='') {
    $page=1;
  }
  $cates=array();
  $cate=array();
  if ($op=='display') {//列表
    if ($page<1||$page==''||$page==null) {
      $page==1;
    }
    $pnum=0;
    $pnum=($page-1)*10;
    $cates=pdo_fetch('select count(*) as snum from  '.tablename('sudu8_page_auction_column').' where uniacid=:uid ',array(':uid'=>$_W['uniacid']));
    $num=$cates['snum'];
    $cates=pdo_fetchall('select * from  '.tablename('sudu8_page_auction_column').' where uniacid=:uid ORDER by id desc LIMIT '.$pnum.',10',array(':uid'=>$_W['uniacid']));
    $page=pagination($num,$page,10);
  }
  elseif ($op=='edit') {//编辑
    $cate=pdo_get('sudu8_page_auction_column',array('uniacid'=>$uid,'id'=>$id));
    $op='post';
  }
  elseif ($op=='toedit') {//保存编辑
    $cid=$_GPC['cid'];
    pdo_update("sudu8_page_auction_column",array('name'=>$title),array('id'=>$cid));
    message('保存成功', $this->createWebUrl('catelist'), 'success',array('op'=>'display'));

  }
  elseif ($op=='delete') {
    $temp=pdo_getall('sudu8_page_auction_goodslist',array('cid'=>$_GPC['id']));
    if (sizeof($temp)>0) {
      message('该栏目下存在拍卖品，禁止删除！', $this->createWebUrl('catelist'), 'success',array('op'=>'display'));
    }else {
      pdo_delete('sudu8_page_auction_column',array('id'=>$_GPC['id']));
      message('删除成功', $this->createWebUrl('catelist'), 'success',array('op'=>'display'));
    }

  }
  include $this->template("catelist");
}


//订单列表
public function doWeborderlist(){
  global $_GPC, $_W;
  $uid=$_W['uniacid'];
  $order_id=$_GPC['order_id'];
  $opt = $_GPC['opt'];

  $page=$_GPC['page'];
  if ($page==null) {
    $page=1;
  }
  $order="%".$order_id."%";
  $t1=($page-1)*5;
  $d=pdo_fetchall("select a.*,b.img,b.name from ".tablename('sudu8_page_auction_order')." as a left join ".tablename('sudu8_page_auction_goodslist')." as b on a.auction_id = b.id where a.uniacid = :uid AND a.id like :or group by a.id order by a.id desc limit ".$t1.",5",array(':uid'=>$uid,':or'=>$order));
  // var_dump($d);die;
  for ($i=0; $i <sizeof($d) ; $i++) {
    $dd=pdo_fetchAll("select * from ".tablename('sudu8_page_user')." where uniacid = :uniacid and openid = :oid ",array(':uniacid' => $uid,':oid'=>$d[$i]['user_id']));
    $d[$i]['nickname']= rawurldecode($dd[0]['nickname']);
    $d[$i]['uniacid']=$_W['uniacid'];
    $d[$i]['img']=HTTPSHOST.$d[$i]['img'];
  }
  if($opt == 'deletes'){
    $orderid = $_GPC['orderid'];
    $is = pdo_get("sudu8_page_auction_order", array('id' => $orderid));
    if(!empty($is)){
      $res = pdo_delete("sudu8_page_auction_order", array('id' => $orderid));
      if($res){
        message("删除成功", $this->createWebUrl('orderlist'), 'success');
      }else{
        message("删除失败，订单已删除或不存在",$this->createWebUrl('orderlist'), 'error');
      }
    }else{
      message("删除失败，订单已删除或不存在",$this->createWebUrl('orderlist'), 'error');
    }
  }
  // var_dump($d);die;
  if($opt == 'excel'){
    $d1=pdo_fetchall("select a.*,b.img,b.name from ".tablename('sudu8_page_auction_order')." as a left join ".tablename('sudu8_page_auction_goodslist')." as b on a.auction_id = b.id where a.uniacid = :uid AND a.id like :or group by a.id order by a.id desc ",array(':uid'=>$uid,':or'=>$order));
    // var_dump($d);die;
    for ($i=0; $i <sizeof($d1) ; $i++) {
      $dd=pdo_fetchall("select * from ".tablename('sudu8_page_user')." where  openid = :oid ",array(':oid'=>$d1[$i]['user_id']));
      $d1[$i]['nickname']=rawurldecode($dd[0]['nickname']);
      $d1[$i]['uniacid']=$_W['uniacid'];
      $d1[$i]['img']=HTTPSHOST.$d[$i]['img'];
    }
    // var_dump($d1[1]['nickname']);die;
    include IA_ROOT.'/addons/sudu8_page/plugin/phpexcel/Classes/PHPExcel.php';
    $objPHPExcel = new \PHPExcel();

    /*以下是一些设置*/
    $objPHPExcel->getProperties()->setCreator("拍卖订单记录")
        ->setLastModifiedBy("拍卖订单记录")
        ->setTitle("拍卖订单记录")
        ->setSubject("拍卖订单记录")
        ->setDescription("拍卖订单记录")
        ->setKeywords("拍卖订单记录")
        ->setCategory("拍卖订单记录");
    $objPHPExcel->getActiveSheet()->setCellValue('A1', '时间');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', '订单编号');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', '拍卖商品名');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', '总价');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', '姓名');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', '联系方式');
    $objPHPExcel->getActiveSheet()->setCellValue('G1', '联系地址');
    $objPHPExcel->getActiveSheet()->setCellValue('H1', '状态');
    // $objPHPExcel->getActiveSheet()->setCellValue('I1', '姓名');
    // $objPHPExcel->getActiveSheet()->setCellValue('J1', '联系方式');
    // $objPHPExcel->getActiveSheet()->setCellValue('K1', '联系地址');
    // $objPHPExcel->getActiveSheet()->setCellValue('L1', '状态');

    foreach($d1 as $k => $v){
        $num=$k+2;

        // if($v['utime'] > 0){
        //     $utime = date("Y-m-d H:i:s", $v['utime']);
        // }else{
        //     $utime = "";
        // }

        if($v['stat'] == 0){
            $v['flag1'] = '待付款';
        }else if($v['stat'] == 1){
            $v['flag1'] = '待发货';
        }else if($v['stat'] == 2){
            $v['flag1'] = '已发货';
        }else if($v['stat'] == 3){
            $v['flag1'] = '已签收';
        }else if($v['stat'] == 4){
            $v['flag1'] = '订单超时';
        }
        // var_dump($v['nickname']);exit;
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValueExplicit('A'.$num, $v['created_at'],'s')
                    ->setCellValueExplicit('B'.$num, $v['id'],'s')
                    ->setCellValueExplicit('C'.$num, $v['name'],'s') 
                    ->setCellValueExplicit('D'.$num, $v['cost'],'s')
                    ->setCellValueExplicit('E'.$num, $v['nickname'], 's')
                    ->setCellValueExplicit('F'.$num, $v['phone'], 's')
                    ->setCellValueExplicit('G'.$num, $v['address'].$v['address_more'], 's')
                    ->setCellValueExplicit('H'.$num, $v['flag1'], 's');
          
    }

    // var_dump($d1);exit;

    $objPHPExcel->getActiveSheet()->setTitle('导出拍卖订单');
    $objPHPExcel->setActiveSheetIndex(0);
    $excelname="拍卖订单记录表";
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$excelname.'.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
  }
  $num=pdo_fetchall('select count(*)  from  '.tablename('sudu8_page_auction_order').' where uniacid = :uid',array(':uid'=>$uid));
  $num=end($num);
  $num=$num['count(*)'];
  $page=pagination($num,$page,5);
  include $this->template("orderlist");
}

//拍卖品添加、修改、编辑
public function doWebaddauctiongoods(){
   global $_GPC, $_W;
   $do=$_GPC['cc'];
   $gid=$_GPC['gid'];
   $name=$_GPC['title'];
   $img=$_GPC['img'];//图标
   $instructions=$_GPC['instructions'];//配送说明
   $basccost=$_GPC['basccost'];//起拍价
   $onececost=$_GPC['onececost'];//加价幅度
   $startdate=$_GPC['startdate'];
   $enddate=$_GPC['enddate'];
   $startdate=str_replace('T'," ",$startdate);
   $enddate=str_replace('T'," ",$enddate);
   $text=$_GPC['product_txt'];//物品说明
   $cid=$_GPC['cid'];
   $data=array('name'=>$name,
                'img'=>$img,
                'introduce'=>$text,
                'Distribution_instructions'=>$instructions,
                'rules'=>$onececost,
                'starttime'=>$startdate,
                'flow'=>$_GPC['flow'],
                'endtime'=>$enddate,
                'basc_cost'=>$basccost,
                'imglist'=> serialize($_GPC['imgtext']),
                'bond'=>$_GPC['bprice'],
                'price'=>$_GPC['price'],
                'uniacid'=>$_W['uniacid'],
                'isindex'=>$_GPC['flag'],
                'cid'=>$cid,
                );
  $listAll=pdo_getall('sudu8_page_auction_column',array('uniacid'=>$_W['uniacid']));
   if ($do=='add') {//物品添加
     pdo_insert('sudu8_page_auction_goodslist', $data,$replace=false);
     message('添加成功!', $this->createWebUrl('goodslist'), 'success');
   }
   if ($do=='againtoonline') {//重新上架
     //http://wxkf2.nttrip.cn/attachment/
     //$data['img']=str_replace('http://wxkf2.nttrip.cn/attachment/', '', $data['img']);
     //$data['imglist']=str_replace('http://wxkf2.nttrip.cn/attachment/', '', $data['imglist']);
     pdo_update('sudu8_page_auction_goodslist',array('stat'=>-1),array('id'=>$gid));
     pdo_insert('sudu8_page_auction_goodslist',$data,$replace=false);
     message('重新上架成功!', $this->createWebUrl('goodslist'), 'success');

   }
   if ($do=='edit') {
     pdo_update('sudu8_page_auction_goodslist',$data,array('id'=>$gid));
     message('修改成功!', $this->createWebUrl('goodslist'), 'success');
   }
  include $this->template("addauctiongoods");
}

//保证金退单记录
public function doWebDeslog(){
  global $_GPC, $_W;
  $uid=$_W['uniacid'];
  $gid=$_GPC['gid'];//$gid
  $d= pdo_getall('sudu8_page_auction_deposit',array('auction_id'=>$gid));
  for ($i=0; $i <sizeof($d) ; $i++) {
    $dd=$d[$i];
    $username=pdo_get('sudu8_page_user',array('uniacid'=>$uid,'openid'=>$dd['user_id']));
    $d[$i]['nickname']=rawurldecode($username['nickname']);
  }
  include $this->template("despositlog");
}

//浏览拍卖物品一览
public function doWebgoodslist(){
  global $_GPC, $_W;
  //$d=pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_auction_goodslist') , array());
  $page=$_GPC['page'];
  if ($page==null) {
    $page=1;
  }
  $pnum=($page-1)*10;
  $d=pdo_fetchall('select * from  '.tablename('sudu8_page_auction_goodslist').' where uniacid=:uid ORDER by id desc LIMIT '.$pnum.',10',array(':uid'=>$_W['uniacid']));
  for ($i=0; $i <sizeof($d) ; $i++) {
    $d[$i]['img']=HTTPSHOST.$d[$i]['img'];
  }
  $num=pdo_fetchall('select count(*) from '.tablename('sudu8_page_auction_goodslist').' where uniacid=:uid',array(':uid'=>$_W['uniacid']));
  $num=end($num);
  $num=$num['count(*)'];
  $page=pagination($num,$page,10);
  include $this->template('goodslist');
}

//消息模板
public function doWebmessage(){
  global $_GPC, $_W;
  $uid=$_W['uniacid'];

  if ($_GPC['cc']=='setmessage') {
    if (!pdo_get('sudu8_page_auction_message',array('class'=>'appointment','uniacid'=>$uid))) {
      pdo_insert("sudu8_page_auction_message", array('mid'=>$_GPC['mid1'],'url'=>$_GPC['murl1'],"class"=>'appointment','uniacid'=>$uid));
      pdo_insert("sudu8_page_auction_message", array('mid'=>$_GPC['mid2'],'url'=>$_GPC['murl2'],"class"=>'deposit','uniacid'=>$uid));
      pdo_insert("sudu8_page_auction_message", array('mid'=>$_GPC['mid3'],'url'=>$_GPC['murl3'],"class"=>'depositout','uniacid'=>$uid));
      pdo_insert("sudu8_page_auction_message", array('mid'=>$_GPC['mid4'],'url'=>$_GPC['murl4'],"class"=>'payok','uniacid'=>$uid));


    }else {
      pdo_update("sudu8_page_auction_message", array('mid'=>$_GPC['mid1'],'url'=>$_GPC['murl1']), array("class"=>'appointment','uniacid'=>$uid));
      pdo_update("sudu8_page_auction_message", array('mid'=>$_GPC['mid2'],'url'=>$_GPC['murl2']), array("class"=>'deposit','uniacid'=>$uid));
      pdo_update("sudu8_page_auction_message", array('mid'=>$_GPC['mid3'],'url'=>$_GPC['murl3']), array("class"=>'depositout','uniacid'=>$uid));
      pdo_update("sudu8_page_auction_message", array('mid'=>$_GPC['mid4'],'url'=>$_GPC['murl4']), array("class"=>'payok','uniacid'=>$uid));
    }

  }
  $one=pdo_get("sudu8_page_auction_message",array("class"=>'appointment','uniacid'=>$uid));
  $two=pdo_get("sudu8_page_auction_message",array("class"=>'deposit','uniacid'=>$uid));
  $three=pdo_get("sudu8_page_auction_message",array("class"=>'depositout','uniacid'=>$uid));
  $four=pdo_get("sudu8_page_auction_message",array("class"=>'payok','uniacid'=>$uid));

  include $this->template('message');
}

//发货流程
public function doWebSetorderstat(){
  global $_GPC, $_W;

  pdo_update("sudu8_page_auction_order", array('stat'=>2,'fast_no'=>$_GPC['fastorder'],'fastname'=>$_GPC['fastname'],'fast'=>0), array("id"=>$_GPC['orderid']));
  return 'ok';
}

//拍卖记录
public function doWebOfferloglist(){
  global $_GPC, $_W;
  $gid=$_GPC['gid'];
  $uid=$_W['uniacid'];
  $d=pdo_fetchall("select * from ".tablename('sudu8_page_auction_log')." where auction_id=:gid  order by id desc",array(':gid'=>$gid));
  $ddd=array();
  for ($i=0; $i <sizeof($d) ; $i++) {
    $dd=$d[$i];
    $user=pdo_get("sudu8_page_user",array('openid'=>$dd['user_id'],'uniacid'=>$uid));
    $user=rawurldecode($user['nickname']);
    $ddd[$i]=$d[$i];
    $ddd[$i]['nickname']=$user;
    $ddd[$i]['uid']=$uid;
  }
  include $this->template("offerlog");
}

//下架
public function doWebOffline(){
  global $_GPC, $_W;
  $gid=$_GPC['gid'];
  $uid=$_W['uniacid'];
  $d=pdo_get('sudu8_page_auction_goodslist',array('id'=>$gid));
  if ($d['stat']>1) {
    return "update";
  }
  pdo_update('sudu8_page_auction_goodslist',array('stat'=>0),array('id'=>$gid));
 return 'ok';
}

//上架
public function doWebOnline(){
  global $_GPC, $_W;
  $gid=$_GPC['gid'];
  $uid=$_W['uniacid'];
  pdo_update('sudu8_page_auction_goodslist',array('stat'=>1),array('id'=>$gid));
 return "ok";
}

//编辑
public function doWebEdit(){
  global $_GPC, $_W;
  $gid=$_GPC['gid'];
  $uid=$_W['uniacid'];
  $d=pdo_get('sudu8_page_auction_goodslist',array('id'=>$gid));
  if ($d['stat']>1) {
    message('监测到物品状态不同步,已执行同步操作!', $this->createWebUrl('goodslist'), 'success');
  }

  $d=pdo_get('sudu8_page_auction_goodslist',array('id'=>$gid));
  $cc="edit";
  $sdate=$d['starttime']."";
  $edate=$d['endtime']."";
  $on=unserialize($d['imglist']);
  $listAll=pdo_getall('sudu8_page_auction_column',array('uniacid'=>$_W['uniacid']));
  for ($i=0; $i < sizeof($listAll); $i++) {
    if ($listAll[$i]['id']==$d['cid']) {
      $listAll[$i]['stat']='selected';
    }
  }
  include $this->template("addauctiongoods");

}

//重新上架
public function doWebAgaintoonline(){
  global $_GPC, $_W;
  $gid=$_GPC['gid'];
  $uid=$_W['uniacid'];
  $cc='againtoonline';
  $d=pdo_get('sudu8_page_auction_goodslist',array('id'=>$gid));
  $on=unserialize($d['imglist']);
  $listAll=pdo_getall('sudu8_page_auction_column',array('uniacid'=>$_W['uniacid']));
  for ($i=0; $i < sizeof($listAll); $i++) {
    if ($listAll[$i]['id']==$d['cid']) {
      $listAll[$i]['stat']='selected';
    }
  }
  include $this->template("addauctiongoods");

}

//360测试通道10分钟一次
public function doWebGoodtest(){
  global $_GPC, $_W;
  $num=pdo_get("sudu8_page_auction_360baby",array('id'=>1));
  $num=$num['num']+1;
  pdo_update("sudu8_page_auction_360baby", array('uptime'=>date("Y-m-d H:i:s"),'num'=>$num), array("id"=>1));
  $message= "接触监测服务成功!<br>开始主动进行监测...<br>";
  //操作内容------------------------------------------------------------------------------------------------------
  //监测物品是否结束------------------------------------------------------------------------------------------------------
  $date=date("Y-m-d H:i:s");
  $d=pdo_fetchall("select * from ".tablename('sudu8_page_auction_goodslist')." where stat=1 AND endtime < :d",array(':d'=>$date));
  for ($i=0; $i <sizeof($d) ; $i++) {
    $dd=$d[$i];
      if ($dd['max_user']=='') {
        pdo_update("sudu8_page_auction_goodslist", array('stat'=>3), array("id"=>$dd['id']));
      }else {
        pdo_update("sudu8_page_auction_goodslist", array('stat'=>2), array("id"=>$dd['id']));
        $data=array('user_id'=>$dd['max_user'],
                    'cost'=>$dd['max_cost'],
                    'auction_id'=>$dd['id'],
                    'created_at'=>date("Y-m-d H:i:s"),
                    'update_at'=>date("Y-m-d H:i:s"),
                    'stat'=>0,
                    'uniacid'=>$dd['uniacid'],
                    );
        pdo_insert("sudu8_page_auction_order",$data);
      }

  }
  $message=$message. "拍卖物品进度监测完成...<br>";
  //监测过期的支付
  $d=pdo_fetchall('select * from  '.tablename('sudu8_page_auction_order').' where created_at < date_add(now(), interval -7 day) and stat = 0',array());
  for ($i=0; $i <sizeof($d) ; $i++) {
    pdo_update('sudu8_page_auction_order',array('stat'=>4),array('id'=>$d[$i]['id']));
    pdo_update('sudu8_page_auction_goodslist',array('stat'=>3),array('id'=>$d[$i]['auction_id']));
  }
  $message=$message. "用户订单监测完成...<br>";
  //结束
  //开始执行退款
  $d=pdo_fetchall('select a.*,b.max_user,b.stat as state,b.name as gname from '.tablename('sudu8_page_auction_deposit').'  as a left join  '.tablename('sudu8_page_auction_goodslist').' as b on a.auction_id=b.id
                  where b.stat>=2 AND a.stat = 2');
  for ($i=0; $i <sizeof($d) ; $i++) {
    sleep(0.01);
    $dd=$d[$i];
    if ($dd['state']==3) {
      $info="{"."auction"."}|{".$dd['form_id']."}|{".$dd['uniacid']."}";
      $sth= $this->getweixinpayinfo($dd['user_id'],$dd['out_trade_no'],$dd['out_refund_no'],$dd['deposit_wx'],$info,$dd['deposit_wx'],$dd['uniacid']);

      //退款到余额
      $umoney=pdo_get('sudu8_page_user',array('uniacid'=>$dd['uniacid'],'openid'=>$dd['user_id']));
      $umoney=$umoney['money'];
      pdo_update('sudu8_page_user',array('money'=>$dd['deposit']+$umoney),array('uniacid'=>$dd['uniacid'],'openid'=>$dd['user_id']));
      pdo_update('sudu8_page_auction_deposit',array('stat'=>1),array('id'=>$dd['id']));

      if ($sth['return_code']=='SUCCESS') {
        $message=$message.$dd['id']."号退款成功!".'<br>';
        pdo_update('sudu8_page_auction_deposit',array('stat'=>1),array('id'=>$dd['id']));
        $backgoods=pdo_get('sudu8_page_auction_deposit',array('id'=>$dd['auction_id']));
        $backdata=array('orderid'=>$dd['out_refund_no'],
                        'price'=>$dd['deposit_wx'],
                        'other'=>"您在竞拍".$dd['gname']."时，出局了，现退您保证金，祝您下次竞拍成功!");
        $message="<br>".$message. $this->sendTplMessage($dd['uniacid'],'depositout', $dd['user_id'], $dd['prepayid'], 'depositout', $backdata);
      }else {
        $message=$message.$dd['id']."号退款遇到问题!".'<br>';
      }
    }else {
      if ($dd['max_user']!=$dd['user_id']) {
        $info="{"."auction"."}|{".$dd['form_id']."}|{".$dd['uniacid']."}";
      $sth= $this->getweixinpayinfo($dd['user_id'],$dd['out_trade_no'],$dd['out_refund_no'],$dd['deposit_wx'],$info,$dd['deposit_wx'],$dd['uniacid']);

      //退款到余额
      $umoney=pdo_get('sudu8_page_user',array('uniacid'=>$dd['uniacid'],'openid'=>$dd['user_id']));
      $umoney=$umoney['money'];
      pdo_update('sudu8_page_user',array('money'=>$dd['deposit']+$umoney),array('uniacid'=>$dd['uniacid'],'openid'=>$dd['user_id']));
      pdo_update('sudu8_page_auction_deposit',array('stat'=>1),array('id'=>$dd['id']));

      //返回提醒
      if ($sth['return_code']=='SUCCESS') {
        pdo_update('sudu8_page_auction_deposit',array('stat'=>1),array('id'=>$dd['id']));
        $message=$message.$dd['id']."号退款成功!".'<br>';

        $backgoods=pdo_get('sudu8_page_auction_deposit',array('id'=>$dd['auction_id']));
        $backdata=array('orderid'=>$dd['out_refund_no'],
                        'price'=>$dd['deposit_wx'],
                        'other'=>"您在竞拍".$dd['gname']."时，出局了，现退您保证金，祝您下次竞拍成功!");
        $message="<br>".$message. $this->sendTplMessage($dd['uniacid'],'depositout', $dd['user_id'], $dd['prepayid'], 'depositout', $backdata);

      }else {
        $message=$message.$dd['id']."号退款遇到问题!".'<br>';
      }
      }
    }

  }


  $message=$message. "退款检测完成...<br>";
  //提醒监测
  $message=$message."进行提醒消息推送<br>";
  $d=pdo_getall('sudu8_page_auction_remind',array('stat'=>0));
  for ($i=0; $i <sizeof($d) ; $i++) {
    $dd=$d[$i];
    $t=pdo_get('sudu8_page_auction_goodslist',array('id'=>$dd['auction_id'],'stat'=>1));
    if ($t!=false) {
      $stime=$t['starttime'];
      $stime=strtotime($stime);
      $n=strtotime(date("Y-m-d H:i:s"));
      $n=$stime-$n;
      //$message=$message.$n."<br>";
      if ($n<7200) {
        //开始发送预约提醒
        $message=$message."执行一条提醒推送...<br>";
        $data=array('gname'=>$t['name'],'msg'=>"您预约的拍卖物品".$t['name']."即将开始拍卖！开拍时间：".$t['starttime']."不要错过机会哦！");
        $tt= $this->sendTplMessage($dd['uniacid'],'appointment', $dd['user_id'], $dd['formid'], 'appointment', $data);
        pdo_update('sudu8_page_auction_remind',array('stat'=>1),array('id'=>$dd['id']));
        $message=$message.$tt."<br>";
      }
    }
  }
  $message=$message."提醒消息执行完毕...<br>";
  $message=$message. "完成所有监测!";
  include $this->template("teststh");

}

//退款操作
public function getweixinpayinfo($openid, $out_trade_no,$out_refund_no, $payprice, $info,$refund_fee,$uniacid){
  global $_GPC, $_W;
      $uniacid = $_W['uniacid'];
      //return $openid."-".$out_trade_no."-".$payprice."-".$info;
      $app = pdo_get("account_wxapp", array("uniacid"=>$uniacid));
      $paycon = pdo_get("uni_settings", array("uniacid"=>$uniacid));
      $datas = unserialize($paycon['payment']);


      include_once '../addons/sudu8_page/WeixinRefund.php';
      $appid=$app['key'];
      $mch_id=$datas['wechat']['mchid'];
      $key=$datas['wechat']['signkey'];

      if(isset($datas['wechat']['identity'])){
          $identity = $datas['wechat']['identity'];
      }else{
          $identity = 1;
      }

      if(isset($datas['wechat']['sub_mchid'])){
          $sub_mchid = $datas['wechat']['sub_mchid'];
      }else{
          $sub_mchid = 0;
      }

      $body = "商品支付";
      $total_fee = $payprice * 100;
      $refund_fee=$refund_fee *100;//退款金额

      $weixinrefund = new WeixinRefund($appid,$key,$mch_id,$out_trade_no,$out_refund_no,$total_fee,$refund_fee,$uniacid,'auction');
      return $weixinrefund->refund();
}
//模板消息处理
public function sendTplMessage($uniacid,$flag, $openid, $formId, $types, $data){ //$fmsg, $orderid, $fprice){
  global $_GPC, $_W;
    $applet = pdo_get("account_wxapp", array("uniacid" => $uniacid));
    $appid = $applet['key'];
    $appsecret = $applet['secret'];

    if($applet){
      $mid = pdo_get("sudu8_page_auction_message", array("class" => $flag,'uniacid'=>$uniacid));//找到模板id
      if($mid && $mid['mid'] != ""){
        $mids = $mid['mid'];
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
        $a_token = $this->_requestGetcurl($url);
        if($a_token){
          $url_m = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$a_token['access_token'];
          $ftime = date('Y-m-d H:i:s',time());
          $furl = $mid['url'];
          if($types == 'auction_buy'){
            $post_info = '{
                      "touser": "'.$openid.'",
                      "template_id": "'.$mids.'",
                      "page": "'.$furl.'",
                      "form_id": "'.$formId.'",
                      "data": {
                          "keyword1": {
                              "value": "'.$data['auctionname'].'",
                              "color": "#173177"
                          },
                          "keyword2": {
                              "value": "'.$data['price'].'元",
                              "color": "#173177"
                          },
                          "keyword3": {
                              "value": "'.$data['time'].'",
                              "color": "#173177"
                          } ,
                          "keyword4": {
                              "value": "'.$data['other'].'",
                              "color": "#173177"
                          }
                      },
                      "emphasis_keyword": ""
                    }';
                }
                elseif ($types=='appointment') {
                  $post_info = '{
                            "touser": "'.$openid.'",
                            "template_id": "'.$mids.'",
                            "page": "'.$furl.'",
                            "form_id": "'.$formId.'",
                            "data": {
                                "keyword1": {
                                    "value": "'.$data['gname'].'",
                                    "color": "#173177"
                                },
                                "keyword2": {
                                    "value": "'.$data['msg'].'",
                                    "color": "#173177"
                                }
                            },
                            "emphasis_keyword": ""
                          }';

                }
                elseif ($types=='depositout') {
                  $post_info = '{
                            "touser": "'.$openid.'",
                            "template_id": "'.$mids.'",
                            "page": "'.$furl.'",
                            "form_id": "'.$formId.'",
                            "data": {
                                "keyword1": {
                                    "value": "'.$data['orderid'].'",
                                    "color": "#173177"
                                },
                                "keyword2": {
                                    "value": "'.$data['price'].'元",
                                    "color": "#173177"
                                },
                                "keyword3": {
                                    "value": "'.$data['other'].'",
                                    "color": "#173177"
                                }
                            },
                            "emphasis_keyword": ""
                          }';

                }
                  $gg = $this->ggpost($url_m,$post_info);
                  //return "步骤";
                  file_put_contents(__DIR__."/debug2.txt",$gg);

                  return $gg;
        }
      }
    }
}

//模板消息后续
public function ggpost($url, $data, $ssl=true) {
                    //curl完成
                    $curl = curl_init();
                    //设置curl选项
                    curl_setopt($curl, CURLOPT_URL, $url);//URL
                    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';
                    curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);//user_agent，请求代理信息
                    curl_setopt($curl, CURLOPT_AUTOREFERER, true);//referer头，请求来源
                    curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间
                    //SSL相关

                    if ($ssl) {
                            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//禁用后cURL将终止从服务端进行验证
                            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//检查服务器SSL证书中是否存在一个公用名(common name)。
                    }
                    // 处理post相关选项
                    curl_setopt($curl, CURLOPT_POST, true);// 是否为POST请求
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);// 处理请求数据
                    // 处理响应结果
                    curl_setopt($curl, CURLOPT_HEADER, false);//是否处理响应头
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//curl_exec()是否返回响应结果
                    // 发出请求
                    $out = curl_exec($curl);

                    if (false === $out) {
                            echo '<br>', curl_error($curl), '<br>';
                            return "错误汇报:".curl_error($curl);
                    }
                    curl_close($curl);
                    return $out;
    }

public function _requestGetcurl($url){
        //curl完成
        $curl = curl_init();
        //设置curl选项
        $header = array(
            "authorization: Basic YS1sNjI5dmwtZ3Nocmt1eGI2Njp1TlQhQVFnISlWNlkySkBxWlQ=",
            "content-type: application/json",
            "cache-control: no-cache",
            "postman-token: cd81259b-e5f8-d64b-a408-1270184387ca"
        );
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER  , $header);
        curl_setopt($curl, CURLOPT_URL, $url);//URL
        curl_setopt($curl, CURLOPT_HEADER, 0);             // 0：不返回头信息
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // 发出请求
        $response = curl_exec($curl);
        if (false === $response) {
            echo '<br>', curl_error($curl), '<br>';
            return false;
        }
        curl_close($curl);
        $forms = stripslashes(html_entity_decode($response));
        $forms = json_decode($forms,TRUE);
        return $forms;
    }

}
