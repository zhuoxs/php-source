<?php
	global $_W,$_GPC;
	include 'common.php';
	$weid=$_W['uniacid'];
	$id=intval($_GPC['id']);	
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	
	$meid=intval($_GPC['meid']);
	$cx1=$_GPC['cx1'];
	$cxtj="";
	if(!empty($meid) && $meid!=0){
		$cxtj=" AND nmenu=".$meid;
	}
	
	
	
	
	$res = pdo_fetchall("SELECT a.*,b.avatar,b.nickname,b.realname,b.grade FROM " . tablename('bc_community_news') . " as a left join ".tablename('bc_community_member')." as b on a.mid=b.mid WHERE a.weid=" . $_W['uniacid'] . $cxtj.$cx1." AND status=0 ORDER BY top DESC,nid DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
        	
		//查询本条帖子的点赞数
		$thumbsnum=pdo_fetchcolumn("SELECT count(thid) FROM ".tablename('bc_community_thumbs')." WHERE weid=" . $_W['uniacid']." AND newsid=".$item['nid']." AND thstatus=1");
	 	//查询本条帖子的评论数
		$commentnum=pdo_fetchcolumn("SELECT count(cid) FROM ".tablename('bc_community_comment')." WHERE weid=" . $_W['uniacid']." AND newsid=".$item['nid']);
	
        $images=explode("|",$item['nimg']);
		$imgnum=count($images);
        $ht.='<div class="mui-row oneinfo ubb b-gra1">';
        		
					$ht.='<div class="mui-col-xs-2 pt1 pb1 tx-c">'
						.'<img src="'.tomedia($item['avatar']).'" class="xtx">'					
					.'</div>'
					.'<div class="mui-col-xs-10 pt1 pb1">'
						.'<div class="mui-row">'
								.'<div class="mui-col-xs-6 text_overflow1">'
									.'<span class="t-blu pl05">';
									if ($item['realname']){
										$ht.=$item['realname'];
									}else{
										$ht.=$item['nickname'];
									}
									$ht.='</span><span class="ulev-1 t-gra pl05">('.getrolename($item['grade']).')</span>'
								.'</div><div class="mui-col-xs-6 tx-r pr05">';
								if($item['top']==1){
									
									$ht.='<span class="pt02 pb02 pl05 pr05 uba b-org t-red uc-a1 ulev-2">置顶</span>';
															
								}								
								
								$ht.='&nbsp;<span class="pt02 pb02 pl05 pr05 uba b-org t-org uc-a1 ulev-2">'.getmenuname($item['weid'],$item['nmenu']).'</span></div>'
								.'<a href="'.$this->createMobileUrl('newsinfo',array('id'=>$item['nid'])).'"><div class="mui-col-xs-12 mt05 t-sbla ulev-1 pl05 text_overflow">'.$item['ntitle'].'</div>';
								
								if($item['ntext']!==''){
									$ht.='<div class="mui-col-xs-12 pl05 pr05 mb05 ulev-1 t-gra text_overflow">'.$item['ntext'].'</div>';
								}
								
								$ht.='<div class="mui-col-xs-12 pl05 pr05">';
								if ($item['time']){
									$ht.='<p class="mb0">时间：'.$item['time'].'</p>';
								}
								if ($item['qidian']){
									$ht.='<p class="mb0">起点：'.$item['qidian'].'</p>';
								}
								if ($item['zhongdian']){
									$ht.='<p class="mb0">终点：'.$item['zhongdian'].'</p>';
								}
								if ($item['dunwei']){
									$ht.='<p class="mb0">吨位：'.$item['dunwei'].'</p>';
								}
								if ($item['yunfei']){
									$ht.='<p class="mb0">运费：'.$item['yunfei'].'</p>';
								}
								if ($item['lxfs']){
									$ht.='<p class="mb0">联系方式：<a href="tel:'.$item['lxfs'].'" class="t-red"><span class="mui-icon mui-icon-phone ulev1"> </span>一键拨号</a></p>';
								}	
								if ($item['didian']){
									$ht.='<p class="mb0">地点：'.$item['didian'].'</p>';
								}	
								if ($item['peoplenum']){
									$ht.='<p class="mb0">人数：'.$item['peoplenum'].'</p>';
								}	
								if ($item['njmc']){
									$ht.='<p class="mb0">农机名称：'.$item['njmc'].'</p>';
								}
								if ($item['jxdx']){
									$ht.='<p class="mb0">机型大小：'.$item['jxdx'].'</p>';
								}
								if ($item['ts']){
									$ht.='<p class="mb0">台数：'.$item['ts'].'</p>';
								}
								if ($item['dwgs']){
									$ht.='<p class="mb0">单位/工时：'.$item['dwgs'].'</p>';
								}
								if ($item['name']){
									$ht.='<p class="mb0">联系人：'.$item['name'].'</p>';
								}
								if ($item['qsl']){
									$ht.='<p class="mb0">起收量：'.$item['qsl'].'</p>';
								}
								if ($item['fmzl']){
									$ht.='<p class="mb0">贩卖种类：'.$item['fmzl'].'</p>';
								}
								if ($item['producttype']){
									$ht.='<p class="mb0">产品类型：'.$item['producttype'].'</p>';
								}
								if ($item['remark']!=''){
									$ht.='<p class="text_overflow">备注：'.$item['remark'].'</p>';
								}
													
								$ht.='</div>';
								
								if (getmenuname($item['weid'],$item['nmenu'])=='志愿活动' || getmenuname($item['weid'],$item['nmenu'])=='社区活动'){
									$ht.='<div class="mui-col-xs-12 mt05 pl15 pr15"><button type="button" class="uw mui-btn mui-btn-default" onclick="zyfwbm('.$item['nid'].');">报名入口&nbsp;(&nbsp;'.getreportnum($item['weid'],$item['nid']).'&nbsp;人已报名)</button></div>';
								}
								
								
								if (getmenuname($item['weid'],$item['nmenu'])=='微心愿'){

									$ht.='<div class="ui-col-xs-12 pl05 pr05 mt1">';
										if ($item['wishrl']==0){
											$ht.='<button type="button" class="uw mui-btn mui-btn-default" onclick="rlwish('.$item['nid'].');">帮TA实现</button>';										
										}
									$ht.='</div>';				
								}
																
								
								
								$ht.='<div class="mui-col-xs-12 mt1">';
									if ($images[0]!=''){
										if($imgnum==1){
											$ht.='<img src="'.tomedia($images[0]).'" class="onepic pl05">';
										}else if($imgnum==2){
											$ht.='<img src="'.tomedia($images[0]).'" class="twopic pl05"><img src="'.tomedia($images[1]).'" class="twopic pl05">';
										}else if($imgnum>=3){
											$ht.='<img src="'.tomedia($images[0]).'" class="therepic pl05"><img src="'.tomedia($images[1]).'" class="therepic pl05"><img src="'.tomedia($images[2]).'" class="therepic pl05">';
										}
									}

								$ht.='</div></a>'
								.'<div class="mui-col-xs-3 tx-l t-gra ulev-1"><span class="pl05 ulev-1 t-gra">'.getgaptime($item['nctime']).'</span></div>'
								.'<div class="mui-col-xs-3 tx-c t-gra ulev-1"><span class="am-icon-eye"> '.$item['browser'].'</span></div>'
								.'<div class="mui-col-xs-3 tx-c t-gra ulev-1"><a href="'.$this->createMobileUrl('newsinfo',array('id'=>$item['nid'])).'" class="t-gra"><span class="am-icon-commenting-o"> '.getcommentnum($item['weid'],$item['nid']).'</span></a></div>'
								.'<div class="mui-col-xs-3 tx-c t-gra ulev-1">'
									.'<span class="am-icon-heart-o dz '.getzancolor($item['weid'],$id,$item['nid']).'" onclick="zan('.$item['nid'].');" >&nbsp;'.getzannum($item['weid'],$item['nid']).'</span>&nbsp;&nbsp;'
								.'</div>'
								
								.'<div class="mui-col-xs-12 pl05 pr05">';
									if ($thumbsnum!=0 || $commentnum!=0){
										$ht.='<div class="uw pl05"><img src="../addons/nx_community/myui/img/sjx.png" style="display:block;width:20px;"></div>';
									}
									$ht.='<div class="c-hh uc-a1">';
									
										if ($thumbsnum!=0){
										$ht.='<div class="uw t-gra pt05 pb05 ulev-1 pl05 pr05">'
											.'<span class="am-icon-heart-o t-org"> </span>'
											.'<span class="t-blu pl05">'.getthumbslist($item['weid'],$item['nid']).'&nbsp;觉得赞。</span>'
										.'</div>';
										}
										if ($thumbsnum!=0 && $commentnum!=0){
											$ht.='<div class="uw ubt b-gra1 pb05"></div>';
										}
										if ($commentnum!=0){								
											$ht.='<div class="uw pb05 ulev-1 pl05 pr05">'.getcommentlist6($item['weid'],$item['nid']).'</div>';
										}
										
										if ($commentnum>6){
											$ht.='<a href="'.$this->createMobileUrl('newsinfo',array('id'=>$item['nid'])).'"><p class="tx-c t-blu pb05 ">查看全部'.$commentnum.'条评论 <span class="am-icon-angle-double-down t-blu"></span></p></a>';
										}	
									$ht.='</div>'
								.'</div>'
							.'</div>'					
					.'</div>';
				
				$ht.='</div>';

        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht,'cx1'=>$cx1));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>