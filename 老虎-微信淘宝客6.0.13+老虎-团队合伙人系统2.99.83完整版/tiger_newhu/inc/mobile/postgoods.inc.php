<?php
 global $_W,$_GPC;
//        file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($_GPC),FILE_APPEND);
//        file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($_GPC['content']),FILE_APPEND);
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".$_GPC['content'],FILE_APPEND);
        //$abc=array("2016-11-29 12:45:39","2750872092027153","17143939324","知我药妆官方旗舰店","纯棉薄款化妆棉脸部一次性卸妆棉粉扑厚棉片盒装洁面巾压边洗脸扑","订单失效","21.00 %","100.00 %","--","--","--","无线");

        
        
        file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n 111111old:".json_encode($_GPC['content']),FILE_APPEND);
        //$array1=explode('|',$_GPC['content']);
        file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n 222222old:".json_decode($_GPC['content']),FILE_APPEND);
        file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n 333333old:".$_GPC['content'],FILE_APPEND);
//        $news=array();
//        foreach($array1 as $k=>$v){
//           $news[$k]=explode(',',$v);
//        }
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($news),FILE_APPEND);
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($news[0][1]),FILE_APPEND);

//        if(!empty($news)){
//            foreach($news as $k=>$v){               
//               file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($v[2]),FILE_APPEND);
//               //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($v[0]),FILE_APPEND);
//               $data=array(
//                   'weid'=>$_W['uniacid'],
//                   'addtime'=>strtotime($v[0]),
//                   'orderid'=>$v[1],
//                   'numid'=>$v[2],
//                   'shopname'=>$v[3],
//                   'title'=>$v[4],
//                   'orderzt'=>$v[5],
//                   'srbl'=>$v[6],
//                   'fcbl'=>$v[7],
//                   'fkprice'=>$v[8],
//                   'xgyg'=>$v[9],
//                   'jstime'=>strtotime($v[10]),
//                   'pt'=>$v[11],
//                   'mtid'=>$v[12],//媒体ID
//                   'mttitle'=>$v[13],//媒体名称
//                   'tgwid'=>$v[14],//推广位ID
//                   'tgwtitle'=>$v[15],//推广位名称
//                   'createtime'=>TIMESTAMP,
//               );
//               $ord=pdo_fetch ( 'select orderid from ' . tablename ( $this->modulename . "_tkorder" ) . " where weid='{$_W['uniacid']}'  and orderid='{$v[1]}'" );
//               if(empty($ord)){
//                  if(!empty($data['addtime'])){
//                     pdo_insert ($this->modulename . "_tkorder", $data );
//                  } 
//               }else{
//                 pdo_update($this->modulename . "_tkorder",$data, array ('orderid' =>$data['orderid'],'weid'=>$_W['uniacid']));
//               }
//                             
//            }
//        }
        

        exit(json_encode(array('status' => 1, 'content' => '成功')));