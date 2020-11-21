<?php

if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class Api_Home extends WeModuleWxapp
{

    private $config;

    public function __construct()
    {
        $this->config = require IA_ROOT . '/addons/' . MODEL_NAME . '/config/house.php';
    }


    /**
     * 租房信息首页接口加收藏
     * @author cheng.liu
     * @date 2019/3/12
     */
    public function index()
    {
        global $_GPC, $_W;

        $join = "";
        $uniacid = $_W['uniacid'];
        $uid = $_GPC['uid'];
        if(!empty($uid)){
            $this->add_user($_GPC['uid']);
        }
        $page['info'] = pdo_get('ox_reathouse_info',array('uniacid' => $uniacid));
        $page['banner'] = pdo_getall('ox_reathouse_banner', ['uniacid' => $uniacid, 'status' => 1], '', '', ['sort asc'], 5);
        $page['type'] = pdo_getall('ox_reathouse_reath_type', ['uniacid' => $uniacid, 'status' => 1], '', '', ['sort asc'], 4);
        foreach ($page['type'] as &$type_value){
            $type_value['icon'] = tomedia($type_value['icon']);
        }
        foreach ($page['banner'] as &$banner_value){
            $banner_value['img'] = tomedia($banner_value['img']);
        }
        //搜索条件
        $where = " info.uniacid = {$_W['uniacid']} and info.status =1";
        if (isset($_GPC['search']) && !empty($_GPC['search'])) {
            $where .= " and info.name like '%{$_GPC['search']}%'";
        }

        if (!empty($uid)) {
            $where .= " and fav.uid = {$uid} and fav.uniacid = {$uniacid}";
            $join = " left join " . tablename('ox_reathouse_fav') . " as fav on fav.hid = info.id";
        }

        $filter = $this->getFilter($_GPC);

        if (!empty($filter['where'])) {
            $where .= $filter['where'];
        }

        $order = "info.id desc";

        if (!empty($filter['order'])) {
            $order = $filter['order'];
        }

        $pageSize = 10;
        $pageCur = $_GPC['page'] ?: 1;

        $sql = "select info.* from " . tablename('ox_reathouse_house_info') . " as info  $join where $where order by  $order LIMIT " . ($pageCur - 1) * $pageSize . ",{$pageSize}";
        $list = pdo_fetchall($sql);

        foreach ($list as $k => &$v) {
            //房屋图片
            $v['img'] = $this->getImg($v['id'], $v['uniacid']);
            //房屋标签
            $v['tag'] = $this->getTag($v['tag_id']);
            //出租类型
            $v['type'] = $this->returnConfig('type', $v['type_id']);
            //装修状态
            $v['renovation'] = $this->returnConfig('renovation', $v['renovation']);
            //朝向
            $v['oriented'] = $this->returnConfig('oriented', $v['oriented_id']);
            $v['create_time'] = date('Y-m-d H:i', $v['create_time']);
        }
        $page['list'] = $list;

        return $this->result(0, '', $page);
    }

    public function getFilter($filter)
    {

        $where = '';
        $order = '';
        if (isset($filter['mode']) && $filter['mode'] >= 0) {
            if ($filter['mode'] != 0) {
                $where = " and info.type_id in ({$filter['mode']})";
            }
        }
        if (isset($filter['price']) && $filter['price'] >= 0) {
            switch ($filter['price']) {
                case 0:
                    $where .= '';
                    break;
                case 1:
                    $where .= " and info.price <= 1500 ";
                    break;
                case 2:
                    $where .= " and info.price between 1500 and 2000";
                    break;
                case 3:
                    $where .= " and info.price between 2000 and 2500";
                    break;
                case 4:
                    $where .= " and info.price between 2500 and 3000";
                    break;
                case 5:
                    $where .= " and info.price > 3000";
                    break;
            }
        }

        if (isset($filter['rec']) && $filter['rec'] >= 0) {
            switch ($filter['rec']) {
                case 0:
                    $order .= '';
                    break;
                case 1:
                    $order .= " info.create_time desc ";
                    break;
                case 2:
                    $order .= " info.price asc ";
                    break;
                case 3:
                    $order .= " info.price desc ";
                    break;
                case 4:
                    $order .= " info.area asc ";
                    break;
                case 5:
                    $order .= " info.area desc ";
                    break;
            }
        }
        if (isset($filter['renovation']) && $filter['renovation'] != '' && $filter['renovation'] >= 0) {
            if ($filter['renovation'] != 0) {
                $where .= " and renovation in ({$filter['renovation']})";
            }
        }
        if (isset($filter['oriented']) && $filter['renovation'] != '' && $filter['oriented'] >= 0) {
            if ($filter['oriented'] != 0) {
                $where .= " and oriented_id in ({$filter['oriented']})";
            }
        }
        if (isset($filter['layer']) && $filter['layer'] >= 0) {
            switch ($filter['layer']) {
                case 1:
                    $where .= " and info.floor1 <= 6 ";
                    break;
                case 2:
                    $where .= " and info.floor1 between 7 and 18 ";
                    break;
                case 3:
                    $where .= " and info.floor1 > 18";
                    break;
            }
        }
        $param = array();

        $param['where'] = $where;
        $param['order'] = $order;
        return $param;
    }


    /**
     * 租房信息首页接口加收藏
     * @author cheng.liu
     * @date 2019/3/12
     */
    public function filterConfig()
    {

        global $_GPC, $_W;

        $params = require IA_ROOT . '/addons/' . MODEL_NAME . '/config/hconfig.php';
        //更多筛选
        return $this->result(0, '', $params);

    }

    /**
     * 添加收藏
     * @return string
     * @author cheng.liu
     * @date 2019/3/12
     */
    public function fav()
    {
        global $_GPC, $_W;

        $uniacid = $_W['uniacid'];
        $uid = $_GPC['uid'];
        $hid = $_GPC['hid'];

        if (empty($uid) && empty($hid)) {
            return $this->result(-1, '缺少必要参数');
        }
        //判断是否收藏过
        $exist = pdo_getcolumn('ox_reathouse_fav', array('uniacid' => $uniacid, 'hid' => $hid, 'uid' => $uid), 'id');
        if ($exist) {
            return $this->result(-1, '已经收藏过');
        }

        $param = array(
            'uniacid' => $uniacid,
            'uid' => $uid,
            'hid' => $hid,
            'create_time' => time()
        );
        $result = pdo_insert('ox_reathouse_fav', $param);
        if (!empty($result)) {
            return $this->result(0, '收藏成功');
        } else {
            return $this->result(-1, '收藏失败');
        }

    }

    /**
     * 取消收藏
     * @return string
     * @author cheng.liu
     * @date 2019/3/12
     */
    public function cleanFav()
    {

        global $_GPC, $_W;

        $uniacid = $_W['uniacid'];
        $uid = $_GPC['uid'];
        $hid = $_GPC['hid'];

        if (empty($uid) && empty($hid)) {
            return $this->result(-1, '缺少必要参数');
        }

        //判断是否收藏过
        $exist = pdo_getcolumn('ox_reathouse_fav', array('uniacid' => $uniacid, 'hid' => $hid, 'uid' => $uid), 'id');
        if (!$exist) {
            return $this->result(-1, '已经删除过');
        }

        $param = array(
            'uniacid' => $uniacid,
            'uid' => $uid,
            'hid' => $hid,
        );
        $result = pdo_delete('ox_reathouse_fav', $param);
        if (!empty($result)) {
            return $this->result(0, '删除成功');
        } else {
            return $this->result(-1, '删除失败');
        }
    }


    /**
     * 获取房屋图片
     * @param $hid int 房屋id
     * @param $acid int 小程序id
     * @return string
     * @author cheng.liu
     * @date 2019/3/12
     */
    public function getImg($hid, $acid)
    {

        $page = pdo_getall('ox_reathouse_img', array('uniacid' => $acid, 'house_id' => $hid), array('url'), '', array('sort asc'), array(0, 1));
        return tomedia($page[0]['url']);
    }

    /**
     * 获取房屋标签
     * @param $tid string 标签id
     * @return string
     * @author cheng.liu
     * @date 2019/3/12
     */
    public function getTag($tid)
    {

        $data = array();
        $tid = explode(',', $tid);

        $page = pdo_getall('ox_reathouse_tag', array('id' => $tid), array('name'), '');

        foreach ($page as $k => $v) {
            $data[$k] = $v['name'];
        }
        return $data;
    }

    /**
     * 返回配置文件
     * @param $type string 配置类型
     * @param $id int 配置id
     * @return string
     * @author cheng.liu
     * @date 2019/3/12
     */
    function returnConfig($type, $id)
    {
        if (!$type || empty($id)) return null;
        return $this->config[$type][$id];
    }

    /*
     * 自定义文本
     */
    function webView(){
        global $_GPC, $_W;
        $info = pdo_get('ox_reathouse_reath_type',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
        return $this->result(0, '', $info);
    }

    public function add_user($uid){
        global $_W;
        $have_user = pdo_get('ox_reathouse_member',array('uniacid'=>$_W['uniacid'],'uid'=>$uid));
        if(empty($have_user)){
            $member = pdo_get('mc_members',array('uid'=>$uid));
            $fans = pdo_get('mc_mapping_fans',array('uid'=>$uid));
            if(empty($member)){
                return;
            }
            $data = array(
                'uniacid'=>$_W['uniacid'],
                'uid'=>$uid,
                'nickname'=>$member['nickname'],
                'avatar'=>$member['avatar'],
                'openid'=>$fans['openid'],
                'create_time'=>time(),
            );
            pdo_insert('ox_reathouse_member',$data);
        }
        return;
    }

}