<?php 



global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $opt = $_GPC['opt'];
        $ops = array('display', 'post','delete','getcate','posts','mulitelist','delmultis','editmultis');
        $opt = in_array($opt, $ops) ? $opt : 'display';
        //栏目列表

        if($opt == 'delmultis'){
            $id = $_GPC['id'];
            $result = pdo_delete("sudu8_page_multicates",array('id' => $id));
            if($result){
                pdo_delete("sudu8_page_multicates",array('pid' => $id));
                message('删除成功',$this->createWebUrl('commentset', array('opt'=>'mulitelist','op' => 'nrk', 'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
            }
        }

        if($opt == 'editmultis'){
            $id = $_GPC['id'];
            $sql = "SELECT * FROM ".tablename("sudu8_page_multicates")." WHERE `id` = {$id} and `uniacid` = ".$uniacid;
            $list = pdo_fetch($sql);

            $sql = "SELECT * FROM ".tablename('sudu8_page_multicates')." WHERE `pid` = {$id} and `uniacid` = ".$uniacid;

            $sons = pdo_fetchall($sql);

            $temp = [];

            foreach ($sons as $k => $v){
                array_push($temp,$v['varible']);
            }
			

            $list['content'] = implode(',',$temp);

            if($_W['ispost']){
                $data = $_POST;
                $id = $data['id'];
				
                $pdata['varible'] = $data['varible'];
                $pdata['sort'] = $data['sort'];
                $pdata['status'] = $data['status'];
                $pdata['pid'] = 0;

                $isdata = pdo_get("sudu8_page_multicates",array('pid' => $id));

                $content = explode(',',$data['content']);

                $ids = $_GPC['ids'];
                $varibles = $_GPC['varibles'];

				$status_fet = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_multicates') ." WHERE pid = :pid and uniacid = :uniacid ", array(':pid' => $id,':uniacid' => $uniacid));
				foreach($status_fet as $key => $value){
					if(!in_array($value['id'],$ids)){
						pdo_update("sudu8_page_multicates",['status' => 0],array('id' => $value['id']));
					} else{
						pdo_update("sudu8_page_multicates",['status' => 1],array('id' => $value['id']));
					}
				}

                for ($i = 0 ; $i < count($ids);$i++){
					/*if(！$ids[$i]){
						pdo_update("sudu8_page_multicates",['stauts' => 0,array('id' => $ids[$i]));
					} else{
						pdo_update("sudu8_page_multicates",['stauts' => 1,array('id' => $ids[$i]));
					}*/
                    if($ids[$i] > 0){
                        pdo_update("sudu8_page_multicates",['varible' => $varibles[$i]],array('id' => $ids[$i]));
                    }else{
                        pdo_insert("sudu8_page_multicates",['sort' => 1,'status' => 1,'varible' => $varibles[$i],'pid' => $id,'uniacid' => $_W['uniacid']]);
                    }
                }
				pdo_update("sudu8_page_multicates",['varible' => $pdata['varible'], 'sort' => $pdata['sort'],'status' => $pdata['status']],array('id' => $id));

                message('编辑成功',$this->createWebUrl('commentset', array('opt'=>'mulitelist','op' => 'nrk', 'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');

            }
        }

        if($opt == 'mulitelist'){
            $sql = "SELECT * FROM ".tablename("sudu8_page_multicates")." WHERE `pid` = 0 AND `uniacid` = ".$_W['uniacid'];
            $list = pdo_fetchall($sql);

            foreach ($list as $k => $v){
                $sql = "SELECT * FROM ".tablename('sudu8_page_multicates')." WHERE `pid` = {$v['id']} and `status` = 1 and `uniacid` = ".$uniacid;
                $data = pdo_fetchall($sql);
                $temp = [];
                foreach ($data as $ks => $vs){
                    array_push($temp,$vs['varible']);
                }

                $list[$k]['content'] = implode(',',$temp);
            }
        }

        if ($opt == 'display'){
            $listAll = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_multicate') ." WHERE uniacid = :uniacid ORDER BY id DESC", array(':uniacid' => $uniacid));
        }

        if($opt == 'posts'){
            if ($_W['ispost']) {
                $data = $_GPC;

                if ($data['content'] == '') {
                    message('请填写筛选内容', $this->createWebUrl('commentset', array('opt' => 'display','op' => 'nrk', 'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'error');
                    exit;
                }
                $result = pdo_insert("sudu8_page_multicates", ['sort' => $data['sort'], 'status' => $data['status'], 'varible' => $data['name'], 'pid' => 0, 'uniacid' => $_W['uniacid']]);
                if ($result) {
                    $pid_key = pdo_insertid();
                    $varible = explode(',', $data['content']);
                    foreach ($varible as $v) {
                        $pdata['status'] = $data['status'];
                        $pdata['varible'] = $v;
                        $pdata['pid'] = $pid_key;
                        $pdata['uniacid'] = $_W['uniacid'];
                        pdo_insert("sudu8_page_multicates", $pdata);
                    }

                    message('添加成功',$this->createWebUrl('commentset', array('opt' => 'mulitelist','op' => 'nrk', 'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
                } else {
                    message('添加失败', $this->createWebUrl('commentset', array('opt' => 'display','op' => 'nrk', 'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'error');
                }
            }
        }

        //添加栏目
        if ($opt == 'post'){

            $id = intval($_GPC['id']);

            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_multicate') ." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));


           

            $top_catat = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_multicates')." WHERE `uniacid` = {$_W['uniacid']} AND `pid` = 0 AND `status` = 1");

            if($_W['ispost']) {
                if (empty($_GPC['name'])) {
                    message('请输入栏目标题！');
                }
                if(is_null($_GPC['statue'])){
                    $statue = 1;
                }else{
                    $statue = $_GPC['statue'];
                }
                $list_style = intval($_GPC['list_style']);
                $top_catas = implode(',',$_GPC['top_cats']);
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'name' => $_GPC['name'],
                    'type' => $_GPC['type'],
                    'statue' => $statue,
                    'list_style' => $list_style,
                    'list_stylet' => $_GPC['list_stylet'],
                    'top_catas' => $top_catas,
                    'psize' => $_GPC['psize'] ? $_GPC['psize'] : 10
                );
                if (empty($id)) {
                    pdo_insert('sudu8_page_multicate', $data);
                } else {
                    pdo_update('sudu8_page_multicate', $data, array('id' => $id ,'uniacid' => $uniacid));
                }
                message('多栏目 添加/修改 成功!', $this->createWebUrl('commentset', array('opt'=>'display','op' => 'nrk', 'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');

            }
        }
        //删除栏目
        if ($opt == 'delete') {
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_multicate')." WHERE id = :id and uniacid = :uniacid ", array(':id' => $id ,':uniacid' => $uniacid));
            if (empty($row)) {
                message('栏目不存在或是已经被删除！');
            }
            pdo_delete('sudu8_page_multicate', array('id' => $id ,'uniacid' => $uniacid));
            message('多栏目删除成功!', $this->createWebUrl('commentset', array('opt'=>'display','op' => 'nrk', 'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
        }






return include self::template('web/Commentset/nrk');

