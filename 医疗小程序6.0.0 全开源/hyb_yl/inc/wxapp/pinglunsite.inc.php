<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$a_id =$_GPC['a_id'];
$op=$_GPC['op'];
if($op =='post'){
       $data_arr1 =$_GPC['data_arr1'];
       $pl_content =$_GPC['pl_content'];
       $useropenid =$_GPC['useropenid'];
       $adminopenid = $_GPC['adminopenid'];
       $idarr = htmlspecialchars_decode($data_arr1);
       $array = json_decode($idarr);
       $object = json_decode(json_encode($array), true);
       //
       $text =array(
         'estimatePicSmallUrl'=>$object,
         'rcontent'=>$pl_content
              );

       $data =array(
            'uniacid'=>$uniacid,
            'a_id'=>$a_id,
            'useropenid'=>$useropenid,
            'adminopenid'=>$adminopenid,
            'pl_text'=>serialize($text),
            'types'=>$_GPC['types'],
            'usertoux'=>$_GPC['usertoux'],
            'name'=>$_GPC['name'],
            'pl_time'=>strtotime('now'),
            'parentid'=>$_GPC['parentid'],
            'replyType'=>$_GPC['replyType'],
            'author' =>$_GPC['author']
              );

       $res  =pdo_insert("hyb_yl_pinglunsite",$data);
    echo json_encode($res);
}
if($op =='all'){
       $res = pdo_fetchall("SELECT * FROM".tablename('hyb_yl_pinglunsite')."where uniacid='{$uniacid}' and a_id='{$a_id}' and parentid=0  and types=0 order by pl_time desc");
       foreach ($res as $key => $value) {
              $res[$key]['pl_text']= unserialize($res[$key]['pl_text']);
              $res[$key]['rcontent'] =$res[$key]['pl_text']['rcontent'];
              $res[$key]['userIcon'] =$res[$key]['usertoux'];
        $count =count($res[$key]['pl_text']['estimatePicSmallUrl']);
        for ($i=0; $i <$count ; $i++) { 
              $res[$key]['estimatePicSmallUrl'][]=$_W['attachurl'].$res[$key]['pl_text']['estimatePicSmallUrl'][$i];
        }
              $res[$key]['rtimeDay'] =date("Y-m-d H:i:s",$res[$key]['pl_time']); 
              $pl_id=$value['pl_id'];
              $res[$key]['listPatientBbsReplyReplyVO']=pdo_fetchall("SELECT * FROM".tablename('hyb_yl_pinglunsite')."where uniacid='{$uniacid}' and a_id='{$a_id}' and parentid='{$pl_id}' and types=0 order by pl_time asc");

              foreach ($res[$key]['listPatientBbsReplyReplyVO'] as &$value1) {
                     $value1['pl_text']=unserialize($value1['pl_text']);
                     $value1['content'] =$value1['pl_text']['rcontent'];
                     $value1['fromUidName'] =$value1['name'];
                     $value1['hideFlag'] =6;
               $count2 =count($value1['pl_text']['estimatePicSmallUrl']);
               for ($i=0; $i <$count2 ; $i++) { 
                     $value1['estimatePicSmallUrl'][]=$_W['attachurl'].$value1['pl_text']['estimatePicSmallUrl'][$i];
               }
              }
       }
       echo json_encode($res);
}

