<?php 
load()->func('tpl');
global $_GPC, $_W;
        $opt = $_GPC['opt'];
        $ops = array('display', 'change','delete');
        $opt = in_array($opt, $ops) ? $opt : 'display';
        $uniacid = $_W['uniacid'];
        if ($opt == 'display'){

            $_W['page']['title'] = '评论列表';
            $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_comment') ." as a LEFT JOIN ".tablename('sudu8_page_products') ." as b on a.aid = b.id WHERE a.uniacid = :uniacid and b.type = :type", array(':uniacid' => $uniacid,":type"=>"showArt"));
            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 10;  
            $start = ($pageindex-1) * $pagesize;
            $pager = pagination($total, $pageindex, $pagesize);  
            $list = pdo_fetchall("SELECT b.title,b.type,a.id,a.aid,a.text,a.flag,a.createtime FROM ".tablename('sudu8_page_comment') ." as a LEFT JOIN ".tablename('sudu8_page_products') ." as b on a.aid = b.id WHERE a.uniacid = :uniacid and b.type = :type order by b.id desc LIMIT ".$start.",".$pagesize, array(':uniacid' => $uniacid,":type"=>"showArt"));

            foreach($list as $k => $v){
                $list[$k]['createtime']= date("Y-m-d H:i:s",$v['createtime']);
            }
        }
         //评论单个审核查下
        if ($opt == 'change') {
            $id = intval($_GPC['id']);
            
            $list = pdo_fetch("SELECT b.title,b.type,a.id,a.aid,a.text,a.flag,a.createtime FROM ".tablename('sudu8_page_comment') ." as a LEFT JOIN ".tablename('sudu8_page_products') ." as b on a.aid = b.id WHERE a.uniacid = :uniacid and a.id = :id", array(':uniacid' => $uniacid,':id'=>$id));
            $list['createtime']= date("Y-m-d H:i:s",$list['createtime']);
            if (checksubmit('submit')) {
                $flag = intval($_GPC['flag']);
                $data = array(
                    'flag' => $flag         
                );
                $res = pdo_update('sudu8_page_comment', $data, array('id' => $id ,'uniacid' => $uniacid));
                message('审核提交成功!', $this->createWebUrl('Commentset', array('op'=>'pinglun','opt'=>"display",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
            };
        }
        //删除评论
        if ($opt == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_comment')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('评论不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_comment', array('id' => $id ,'uniacid' => $uniacid));
            message('删除成功!', $this->createWebUrl('Commentset', array('op'=>'pinglun','opt'=>"display",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }

return include self::template('web/Commentset/pinglun');
