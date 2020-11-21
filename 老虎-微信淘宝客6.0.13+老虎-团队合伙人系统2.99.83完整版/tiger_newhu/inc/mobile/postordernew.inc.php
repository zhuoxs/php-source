<?php
 global $_W,$_GPC;
        
        file_put_contents(IA_ROOT."/addons/tiger_newhu/log--ordernews.txt","\n 1old:".$_GPC['content'],FILE_APPEND);
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--order.txt","\n 1old:".json_encode($_GPC['content']),FILE_APPEND);
       $array1=explode('|||||',$_GPC['content']);
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--order.txt","\n 02old:".json_encode($array1),FILE_APPEND);
       $news=array();
        foreach($array1 as $k=>$v){
           $news[$k]=explode('|||',$v);
        }
//        file_put_contents(IA_ROOT."/addons/tiger_newhu/log--order.txt","\n 2old:".json_encode($news),FILE_APPEND);
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($news[0][1]),FILE_APPEND);

        //$content=htmlspecialchars_decode($_GPC['content']);

        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--order.txt","\n 1old:".$content,FILE_APPEND);

        //$news=@json_decode($content, true);
        file_put_contents(IA_ROOT."/addons/tiger_newhu/log--ordernews.txt","\n 02old:".json_encode($news),FILE_APPEND);

        if(!empty($news)){
            foreach($news as $k=>$v){               
               file_put_contents(IA_ROOT."/addons/tiger_newhu/log--ordernews.txt","\n 3old:".json_encode($v[2]."----------".$v[15]),FILE_APPEND);
               //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($v[0]),FILE_APPEND);
               $data=array(
                   'weid'=>$_W['uniacid'],
                   'addtime'=>strtotime($v[1]),
                   'orderid'=>$v[2],
                   'numid'=>$v[3],
                   'shopname'=>$v[4],
                   'title'=>$v[5],
                   'orderzt'=>$v[6],
                   'srbl'=>$v[7],
                   'fcbl'=>$v[8],
                   'fkprice'=>$v[9],
                   'xgyg'=>$v[10],
                   'jstime'=>strtotime($v[11]),
                   'pt'=>$v[12],
                   'mtid'=>$v[13],//媒体ID
                   'mttitle'=>$v[14],//媒体名称
                   'tgwid'=>$v[15],//推广位ID
                   'tgwtitle'=>$v[16],//推广位名称
                   'createtime'=>TIMESTAMP,
               );
               $ord=pdo_fetch ( 'select orderid from ' . tablename ( $this->modulename . "_tkorder" ) . " where weid='{$_W['uniacid']}'  and orderid='{$v[2]}'" );
               //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--order.txt","\n 4old-ord=:".json_encode($ord),FILE_APPEND);

               if($ord){
                  $b=pdo_update($this->modulename . "_tkorder",$data, array ('orderid' =>$data['orderid'],'weid'=>$_W['uniacid']));
                  //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--order.txt","\n 5old-ordup=:".json_encode($b),FILE_APPEND);
               }else{
                   if(!empty($data['addtime'])){
                     $a=pdo_insert ($this->modulename . "_tkorder", $data );
                     //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--order.txt","\n 6old-ordint=:".json_encode($ord),FILE_APPEND);
                  }                  
               }
                             
            }
        }
        

        exit(json_encode(array('status' => 1, 'content' => '成功')));