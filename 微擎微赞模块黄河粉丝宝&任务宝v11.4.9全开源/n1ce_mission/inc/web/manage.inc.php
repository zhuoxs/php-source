<?php
//这个操作被定义用来呈现 管理中心导航菜单
		global $_GPC, $_W;
        
        load()->model('reply');
        $pindex = max(1, intval($_GPC['page']));
        $psize = 20;
        $sql = "uniacid = :uniacid AND `module` = :module";
        $params = array();
        $params[':uniacid'] = $_W['uniacid'];
        $params[':module'] = 'n1ce_mission';
		file_put_contents(IA_ROOT . "/api/api.log", var_export($_W['uniaccount'], true) . PHP_EOL, FILE_APPEND);
        if (isset($_GPC['keywords'])) {
            $sql .= ' AND `name` LIKE :keywords';
            $params[':keywords'] = "%{$_GPC['keywords']}%";
        }

        $list = reply_search($sql, $params, $pindex, $psize, $total);
        $pager = pagination($total, $pindex, $psize);

        if (!empty($list)) {
            foreach ($list as &$item) {
                $condition = "`rid`={$item['id']}";
                $item['keywords'] = reply_keywords_search($condition);
                $item['name'] = $item['keywords']['0']['content'];
                $n1ce_mission = pdo_fetch("SELECT * FROM " . tablename($this->table_reply) . " WHERE rid = :rid ", array(':rid' => $item['id']));
                $item['viewnum'] = $item['viewnum`'];
                $item['starttime'] = date('Y-m-d H:i', $n1ce_mission['starttime']);
                $endtime = $n1ce_mission['endtime'];
                $item['endtime'] = date('Y-m-d H:i', $endtime);
                $nowtime = time();
                if ($n1ce_mission['starttime'] > $nowtime) {
                    $item['show'] = '<span class="label label-warning">未开始</span>';
                } elseif ($endtime < $nowtime) {
                    $item['show'] = '<span class="label label-default">已结束</span>';
                } else{
					$item['show'] = '<span class="label label-success">已开始</span>';
				}
                $item['uniacid'] = $n1ce_mission['uniacid'];
                $item['status'] = $n1ce_mission['status'];
                if($item['status'] == 2){
                	$item['show'] = '<span class="label label-default">已暂停</span>';
                }
                unset($item);
            }
        }
        //var_dump($list);die();
        include $this->template('manage');