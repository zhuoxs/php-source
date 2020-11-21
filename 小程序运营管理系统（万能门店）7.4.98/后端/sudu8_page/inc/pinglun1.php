<?php



	global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$flag = intval($_GPC['comms']);
		$openid = $_GPC['openid'];
		if($flag==1){
			$comment = pdo_fetchAll("SELECT distinct  a.id,a.text,a.createtime,a.follow,b.avatar,b.nickname FROM ".tablename('sudu8_page_comment')." as a LEFT JOIN ".tablename('sudu8_page_user')." as b on a.openid = b.openid and a.uniacid = b.uniacid WHERE a.uniacid = :uniacid and a.aid = :id and a.flag = 1 order by a.follow desc,a.id desc" , array(':uniacid' => $uniacid,':id' => $id));
		}else{
			$comment = pdo_fetchAll("SELECT distinct  a.id,a.text,a.createtime,a.follow,b.avatar,b.nickname FROM ".tablename('sudu8_page_comment')." as a LEFT JOIN ".tablename('sudu8_page_user')." as b on a.openid = b.openid and a.uniacid = b.uniacid WHERE a.uniacid = :uniacid and a.aid = :id and a.flag != 2 order by a.follow desc,a.id desc" , array(':uniacid' => $uniacid,':id' => $id));

		}
		if($comment){
			foreach ($comment as $k => &$v) {
				$comment[$k]['ctime'] = date('Y年m月d日 H:i:s',$v['createtime']);
				$comment[$k]['nickname'] = rawurldecode($comment[$k]['nickname']);
                //查询该评论下的点赞
                $zans = pdo_fetchall("SELECT zan, openid FROM ".tablename('sudu8_page_art_comment_zan')." WHERE uniacid = :uniacid and comid = :comid", array(':uniacid' => $uniacid, ':comid' => $v['id']));
                if($zans){
                    foreach ($zans as $key => $value) {
                        if($value['openid'] == $openid && $value['zan'] == 1){
                            $v['zan'] = 1;
                        }else{
                            $v['zan'] = 2;
                        }
                    }
                }else{
                    $v['zan'] = 2;
                }
           }
      	}
		return $this->result(0, 'success', $comment);