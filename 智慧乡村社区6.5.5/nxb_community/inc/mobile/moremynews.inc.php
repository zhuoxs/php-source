<?php
	global $_W,$_GPC;
	include 'common.php';
	$id=$_GPC['id'];	
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	
	$res = pdo_fetchall("SELECT a.*,b.avatar,b.nickname FROM " . tablename('bc_community_news') . " as a left join ".tablename('bc_community_member')." as b on a.mid=b.mid WHERE a.weid=" . $_W['uniacid'] . " AND a.mid=".$id." ORDER BY nid DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
          $images=explode("|",$item['nimg']);
		
        $ht.='<a href="'.$this->createMobileUrl('newsinfo',array('id'=>$item['nid'])).'"><div class="mui-row oneinfo pt05 pb05 ubb b-gra">';
        		if(!empty($item['nimg'])){
					$ht.='<div class="mui-col-xs-3 pl05 pr05 img100">'
						.'<img src="'.tomedia($images[0]).'" height="72">'					
					.'</div>'
					.'<div class="mui-col-xs-9 pr05">'
						.'<div class="mui-row">'
							.'<div class="mui-col-xs-12 mb05 text_overflow">'.$item['ntitle'].'</div>'
							.'<div class="mui-col-xs-6 ulev-1 t-gra">'
								.'<img src="'.tomedia($item['avatar']).'" class="xtx">&nbsp;&nbsp;'.$item['nickname']
							.'</div>'
							.'<div class="mui-col-xs-6 tx-r ulev-1 t-gra">'
								.'<span class="am-icon-eye"> '.$item['browser'].'</span>&nbsp;&nbsp;<span class="am-icon-commenting"> '.getcommentnum($item['weid'],$item['nid']).'</span>'
							.'</div>'
						.'</div>'						
					.'</div>';
				}else{
					$ht.='<div class="mui-col-xs-12 pl05 pr05">'
						.'<div class="mui-row">'
							.'<div class="mui-col-xs-12 mb05 text_overflow">'.$item['ntitle'].'</div>'
							.'<div class="mui-col-xs-6 ulev-1 t-gra">'
								.'<img src="'.tomedia($item['avatar']).'" class="xtx">&nbsp;&nbsp;'.$item['nickname']
							.'</div>'
							.'<div class="mui-col-xs-6 tx-r ulev-1 t-gra">'
								.'<span class="am-icon-eye"> '.$item['browser'].'</span>&nbsp;&nbsp;<span class="am-icon-commenting"> '.getcommentnum($item['weid'],$item['nid']).'</span>'
							.'</div>'
						.'</div>'						
					.'</div>';
				}
				$ht.='</div></a>';
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>