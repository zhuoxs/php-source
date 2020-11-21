<?php
   global $_GPC, $_W;
$_W = self::$_W;

$act = isset(self::$_GPC['act']) ? self::$_GPC['act'] : '';



if($act == ''){

        $group = pdo_fetchall("SELECT id,name FROM ".tablename("sudu8_page_usergroup")." order by id desc");
        $search_keys = $_GPC['search_keys'];
        $search_group = $_GPC['search_group'];
        $where = "";
        if(!empty($search_group)){
            $where .= " and b.id = ".$search_group;
        }
        if(!empty($search_keys)){
            $where .= " and a.username like '%".$search_keys."%'";
        }
        $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('users')." as a left join" .tablename('sudu8_page_usergroup')." as b ON a.gid = b.id WHERE a.uid <> 1 and a.type = 1 ".$where);
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;  
        $start = ($pageindex-1) * $pagesize;
        $pager = pagination($total, $pageindex, $pagesize);  
        $sql = "SELECT a.*,b.*,b.name as groupname FROM ".tablename('users')." AS a LEFT JOIN ".tablename('sudu8_page_usergroup')." AS b ON a.gid = b.id WHERE a.uid <> 1 and a.type = 1 ".$where." ORDER BY a.uid DESC LIMIT ".$start.",".$pagesize;
        $user = pdo_fetchall($sql);
    return include self::template('web/Auth/userlist');

}

