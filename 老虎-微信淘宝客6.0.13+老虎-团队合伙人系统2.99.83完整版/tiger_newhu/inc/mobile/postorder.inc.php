<?php
 global $_W,$_GPC;
//        file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($_GPC),FILE_APPEND);
//        file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($_GPC['content']),FILE_APPEND);
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".$_GPC['content'],FILE_APPEND);
        //$abc=array("2016-11-29 12:45:39","2750872092027153","17143939324","知我药妆官方旗舰店","纯棉薄款化妆棉脸部一次性卸妆棉粉扑厚棉片盒装洁面巾压边洗脸扑","订单失效","21.00 %","100.00 %","--","--","--","无线");

        $cfg = $this->module['config'];
        $miyao=$_GPC['miyao'];
        if($miyao!==$cfg['miyao']){
          exit(json_encode(array('status' => 2, 'content' => '密钥错误，请检测秘钥，或更新缓存！')));
        }


        
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/log--order.txt","\n 1old:".$_GPC['content'],FILE_APPEND);
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/log--order.txt","\n 1old:".$_GPC['miyao'],FILE_APPEND);
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--order.txt","\n 1old:".json_encode($_GPC['content']),FILE_APPEND);
        //$array1=explode('|',$_GPC['content']);
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--order.txt","\n 02old:".json_encode($array1),FILE_APPEND);
//        $news=array();
//        foreach($array1 as $k=>$v){
//           $news[$k]=explode(',',$v);
//        }
//        file_put_contents(IA_ROOT."/addons/tiger_newhu/log--order.txt","\n 2old:".json_encode($news),FILE_APPEND);
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($news[0][1]),FILE_APPEND);

        $content=htmlspecialchars_decode($_GPC['content']);
        

        //file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/log--order.txt","\n 33333333old:".$content,FILE_APPEND);

        $news=@json_decode($content, true);
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--order.txt","\n 02old:".json_encode($news),FILE_APPEND);

        if(!empty($news)){
            foreach($news as $k=>$v){               
               //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--order.txt","\n 3old:".json_encode($v[s2]."----------".$v[s15]),FILE_APPEND);
               //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($v[0]),FILE_APPEND);
               $tbsbuid6=substr($v[s2],-6);
               $data=array(
                   'weid'=>$_W['uniacid'],
                   'addtime'=>strtotime($v[s1]),
                   'orderid'=>$v[s2],
                   'numid'=>$v[s3],
                   'shopname'=>$v[s4],
                   'title'=>$v[s5],
                   'orderzt'=>$v[s6],
                   'srbl'=>$v[s7],
                   'fcbl'=>$v[s8],
                   'fkprice'=>$v[s9],
                   'xgyg'=>$v[s10],
                   'jstime'=>strtotime($v[s11]),
                   'pt'=>$v[s12],
                   'mtid'=>$v[s13],//媒体ID
                   'mttitle'=>$v[s14],//媒体名称
                   'tgwid'=>$v[s15],//推广位ID
                   'tgwtitle'=>$v[s16],//推广位名称
                   'tbsbuid6'=>$tbsbuid6,
                   'createtime'=>TIMESTAMP,
               );
               $ord=pdo_fetch ( 'select orderid,orderzt from ' . tablename ( $this->modulename . "_tkorder" ) . " where weid='{$_W['uniacid']}' and numid='{$v[s3]}'  and orderid='{$v[s2]}'" );
               //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--order.txt","\n 4old-ord=:".json_encode($ord),FILE_APPEND);

               if($ord){
               	if($ord['orderzt']!='订单失效'){
               		$updata=array(
	                   'weid'=>$_W['uniacid'],
	                   'addtime'=>strtotime($v[s1]),
	                   'orderid'=>$v[s2],
	                   'numid'=>$v[s3],
	                   'shopname'=>$v[s4],
	                   'title'=>$v[s5],
	                   'orderzt'=>$v[s6],
	                   'srbl'=>$v[s7],
	                   'fcbl'=>$v[s8],
	                   'fkprice'=>$v[s9],
	                   'xgyg'=>$v[s10],
	                   'jstime'=>strtotime($v[s11]),
	                   'pt'=>$v[s12],
	                   //'mtid'=>$v[s13],//媒体ID
	                   //'mttitle'=>$v[s14],//媒体名称
	                   //'tgwid'=>$v[s15],//推广位ID
	                   //'tgwtitle'=>$v[s16],//推广位名称
	                   'createtime'=>TIMESTAMP,
	               );
               		 $b=pdo_update($this->modulename . "_tkorder",$updata, array ('orderid' =>$data['orderid'],'numid'=>$data['numid'],'weid'=>$_W['uniacid']));
               	}                 
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