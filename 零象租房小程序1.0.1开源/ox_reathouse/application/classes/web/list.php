<?php
/**

 * Created by PhpStorm.

 * User: Administrator

 * Date: 2018/5/7

 * Time: 15:07

 */

if (!(defined('IN_IA')))
{
    exit('Access Denied');
}
class Web_List extends Web_Base
{
    private $config;

    public function __construct()
    {
        $this->config = require IA_ROOT . '/addons/' . MODEL_NAME . '/config/house.php';
    }

    /**
     * 房源列表
     */
    public function index()
    {
        global $_GPC, $_W;

        $join = "";
        $uniacid = $_W['uniacid'];
        $uid = $_GPC['uid'];

        //搜索条件
        $where = " info.uniacid = {$_W['uniacid']} and info.status < 2";
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

        $pageSize = $_GPC['limit'] ?: 20;
        $pageCur = $_GPC['page'] ?: 1;

        $sql = "select info.* from " . tablename('ox_reathouse_house_info') . " as info  $join where $where order by  $order LIMIT " . ($pageCur - 1) * $pageSize . ",{$pageSize}";
        $list = pdo_fetchall($sql);
        $sql = "select info.* from " . tablename('ox_reathouse_house_info') . " as info  $join where $where order by  $order";
        $total = pdo_fetchall($sql);
        $page['total'] = count($total);
        foreach ($list as $k => &$v) {
            //房屋图片
            $v['img'] = $this->getImg($v['id'], $v['uniacid']);
            //房屋标签
            $v['tag'] = $this->getTag($v['tag_id']);
            //出租类型
            $v['type'] = $this->returnConfig('type', $v['type_id']);
            //装修状态
            $v['facility'] = $this->returnFacility($v['facility_id']);
            //装修状态
            $v['renovation_name'] = $this->returnConfig('renovation',$v['renovation']);
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
        if (isset($filter['renovation']) && $filter['renovation'] != ''  && $filter['renovation'] >= 0) {
            $where .= " and renovation in ({$filter['renovation']})";
        }
        if (isset($filter['oriented']) && $filter['oriented'] !=''  && $filter['oriented'] >= 0) {
            $where .= " and oriented_id in ({$filter['oriented']})";
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
     * 获取房屋图片
     * @param $hid int 房屋id
     * @param $acid int 小程序id
     * @return string
     * @author cheng.liu
     * @date 2019/3/12
     */
    public function getImg($hid, $acid)
    {

        $page = pdo_getall('ox_reathouse_img', array('uniacid' => $acid, 'house_id' => $hid), array('url','id'), '', array('sort asc'));
        foreach($page as &$v){
            $v['url'] = tomedia($v['url']);
            $v['name'] = $v['url'];
            $v['id'] = $v['id'];
        }
        return $page;
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
        if (!$type) return null;
        return $this->config[$type][$id];
    }

    /**
     * 返回房屋设施
     * @param $type string 配置类型
     * @return string
     * @author cheng.liu
     * @date 2019/3/12
     */
    public function returnFacility($type){

        $type_arr = explode(',',$type);
        $where = array('id in' => $type_arr);
        $list = pdo_getall('ox_reathouse_facility',$where,'name');
        foreach($list as $k=>$v){
            $data[$k] = $v['name'];
        }
        if(!empty($list)){
            $page = implode(',',$data);
        }else{
            $page = '暂无';
        }
        return $page;
    }

    /**
     * 删除
     * @return string
     * @author cheng.liu
     * @date 2019/3/12
     */

    function del(){
        global $_GPC, $_W;
        if( $_GPC['status'] == 0){
            $status = 1;
        }elseif($_GPC['status'] == 1){
            $status = 0;
        }
        $params = [
            'status' => $status,
        ];
        $result = pdo_update('ox_reathouse_house_info',$params,['id'=> $_GPC['id'],"uniacid" => $_W['uniacid']]);
        if($result){
            return $this->result('0','操作成功',$result);
        }else{
            return $this->result('-1','操作失败',$result);
        }
    }

    /**
     * 获取编辑信息
     * @return string
     * @author cheng.liu
     * @date 2019/3/12
     */
    public function getOther(){

        global $_GPC, $_W;

        $uniacid = $_W['uniacid'];

        $facility = pdo_getall('ox_reathouse_facility',array('uniacid'=>$uniacid));
        if(empty($facility)){
            $sheshi_add = new sheshi();
            $sheshi_add->add();
            $facility = pdo_getall('ox_reathouse_facility',array('uniacid'=>$uniacid));
        }
        $tag = pdo_getall('ox_reathouse_tag',array('uniacid'=>$uniacid));


        $data['facility'] = $facility;
        $data['tag'] = $tag;
        return $this->result('0','操作成功',$data);
    }

    /**
     * 编辑
     * @return string
     * @author cheng.liu
     * @date 2019/3/12
     */
    public function hEdit(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = $_GPC['id'];
        $op = $_GPC['op'];
        $data=[
            'name' => $_GPC['name'],
            'type_id' => $_GPC['type_id'],
            'img_id' => $_GPC['img_id'],
            'facility_id' => !empty($_GPC['facility_id']) ? implode(',',$_GPC['facility_id']) : '',
            'tag_id' => !empty($_GPC['tag_id']) ? implode(',',$_GPC['tag_id']) : '',
            'renovation' => $_GPC['renovation'],
            'floor1' => $_GPC['floor1'],
            'floor2' => $_GPC['floor2'],
            'oriented_id' => $_GPC['oriented_id'],
            'house_type_shi' => $_GPC['house_type_shi'],
            'house_type_wei' => $_GPC['house_type_wei'],
            'house_type_ting' => $_GPC['house_type_ting'],
            'area' => $_GPC['area'],
            'yafu_fu' => $_GPC['yafu_fu'],
            'yafu_ya' => $_GPC['yafu_ya'],
            'price' => $_GPC['price'],
            'address' => $_GPC['address'],
            'desc' => $_GPC['desc'],
            'uid' => $_GPC['uid'],
            'mapx' => $_GPC['mapx'],
            'mapy' => $_GPC['mapy'],
        ];
        $imgs = $_GPC['img'];

        if(!empty($imgs))foreach($imgs as $k=>$v){
            $d = htmlspecialchars_decode($v);
            $c = json_decode($d,true);
            if(!empty($c['id'])){
                $b[$k] = $c['id'];
            }else{
                $insert[$k] = $c;
            }
        }

        if(isset($id) && !empty($id)){
            $op_img = $this->getImg($id,$uniacid);
            foreach($op_img as $k=>$v){
                $p[$k] = $v['id'];
            }
            $dif = array_diff($p,$b);//要删除的图片
        }
        
        if($op === '1'){
            $data['update_time'] = time();
            //图片修改
            $res=pdo_update('ox_reathouse_house_info',$data,array('id'=>$id,'uniacid' => $uniacid));
            $msg = $res ? '修改成功' : '修改失败';
        }else{
            $data['uniacid'] = $uniacid;
            $data['create_time'] = time();
            $data['status'] = 0;
            $res = pdo_insert('ox_reathouse_house_info',$data);
            $id = pdo_insertid();
            $msg = $res ? '新增成功' : '新增失败';
        }
        if(!empty($insert))foreach($insert as $v){
            $imgPams = array(
                'uniacid' => $uniacid,
                'house_id' => $id,
                'url' => $v['filename'],
                'create_time' => time()
            );
            pdo_insert('ox_reathouse_img',$imgPams);
        }
        if(!empty($dif)){
            foreach($dif as$v){
                pdo_delete('ox_reathouse_img',array('id' => $v,'uniacid' => $uniacid));
            }
        }

        if($res){
            return $this->result('0',$msg,$_GPC);
        }else{
            return $this->result('-1',$msg,$_GPC);
        }
    }

    function remove_utf8_bom($text)
    {
        $bom = pack('H*','EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        return $text;
    }
}