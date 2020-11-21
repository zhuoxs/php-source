<?php
global $_W, $_GPC;


       if($_GPC['op']=='post'){
           $data=array(
               'weid'=>$_W['uniacid'],
               'tbuid'=>$_GPC['tbuid'],
               'sign'=>$_GPC['sign'],
							 'tbnickname'=>$_GPC['tbnickname'],
               'endtime'=>$_GPC['endtime'],
               'createtime' => TIMESTAMP
           );
           $go = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$_GPC['tbuid']}'");
            if(empty($go)){
                  $res=pdo_insert($this->modulename."_tksign",$data);
                  if($res=== false){
                    echo '授权失败';
                  }else{
                    //echo '授权成功:'.$_GPC['sign'];
                    //$url=$_W['siteroot']."web/index.php?c=module&a=manage-account&do=setting&&m=tiger_newhu";
										$url=$_W['siteroot']."web/index.php?c=site&a=entry&op=display&do=yunkong&m=tiger_newhu";
                    //echo $url;
                    echo "<a href='".$url."' style='font-size:20px;width:60%;height:50px;text-height:50px;text-align: center'>授权成功！点击返回</a>";
                   // message('授权成功！',$url, 'success');
                  }
            }else{                          
                  $res=pdo_update($this->modulename."_tksign", $data, array('tbuid' =>$_GPC['tbuid']));
                  if($res=== false){
                    echo '授权失败';
                  }else{
                   //$url=$_W['siteroot']."web/index.php?c=module&a=manage-account&do=setting&&m=tiger_newhu";
									 $url=$_W['siteroot']."web/index.php?c=site&a=entry&op=display&do=yunkong&m=tiger_newhu";
                    echo "<a href='".$url."' style='font-size:20px;width:60%;height:50px;text-height:50px;text-align: center'>授权成功！点击返回</a>";
                    //message('授权成功！',$url, 'success');
                  }
            }
       }
?>