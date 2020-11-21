<?php
	global $_W,$_GPC;
	include 'common.php';	
	$words=$_GPC['words'];

	$res = pdo_fetchall("SELECT a.*,b.avatar,b.nickname FROM " . tablename('bc_community_news') . " as a left join ".tablename('bc_community_member')." as b on a.mid=b.mid WHERE a.weid=" . $_W['uniacid'] ." AND ntitle LIKE '%".$words."%' ORDER BY nid DESC");	
	
		$ht = '';
        foreach ($res as $key => $item) {		
        $ht.='<a href="'.$this->createMobileUrl('newsinfo',array('id'=>$item['nid'])).'"><div class="mui-row oneinfo pt05 pb05 ubb b-gra">';
					$ht.='<div class="mui-col-xs-2 tx-c"><img src="'.tomedia($item['avatar']).'" class="xtx"></div><div class="mui-col-xs-10 pl05 pr05">'
						.'<div class="mui-row">'
							.'<div class="mui-col-xs-12 mb05 text_overflow">'.$item['ntitle'].'</div>'
							.'<div class="mui-col-xs-6 ulev-1 t-gra">'
								.$item['nickname'].'&nbsp;&nbsp;'.getgaptime($item['nctime'])
							.'</div>'
							
						.'</div>'						
					.'</div>';
				$ht.='</div></a>';


        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>