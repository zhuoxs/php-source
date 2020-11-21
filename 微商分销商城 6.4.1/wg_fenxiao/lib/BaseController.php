<?php
/**
 * 控制器基础类
 * Created by PhpStorm.
 * @property AdvModel $AdvModel
 * @property CategoryModel $CategoryModel
 * @property GoodsModel $GoodsModel
 * @property GoodsTypeModel $GoodsTypeModel
 * @property GoodsAttributeModel $GoodsAttributeModel
 * @property AddressModel $AddressModel
 * @property MemberModel $MemberModel
 * @property MemberLevelModel $MemberLevelModel
 * @property ShoppingCartModel $ShoppingCartModel
 * @property MemberAddressModel $MemberAddressModel
 * @property OrderModel $OrderModel
 * @property OrderDetailModel $OrderDetailModel
 * @property RedPackModel $RedPackModel
 * @property GouModel $GouModel
 * @property CollectModel $CollectModel
 * @property CommissionModel $CommissionModel
 * @property AccModel $AccModel
 * @property PasswdsModel $PasswdsModel
 * @property JifenModel $JifenModel
 * @property AgentApplyModel $AgentApplyModel
 * @property PosterModel $PosterModel
 * @property PosterQrModel $PosterQrModel
 * @property ArticleModel $ArticleModel
 * @property CouponModel $CouponModel
 */
class BaseController  {
    /**
     * @var Wg_fenxiaoModuleSite
     */
    public $site;
    public $W;
    public $GPC;
    public static $ACC;
    public static $PAY_USER_INFO;
    public static $ADVS = [
        1 => [
            'value' => 'advs_image',
            'name'  => '首页banner'
            ],
        2 => [
            'value' => 'category_image',
            'name'  => '首页栏目'
        ],
        3 => [
            'value' => 'toutiao_image',
            'name'  => '首页头条(不用图片)'
        ],
        4 => [
            'value' => 'theme_image',
            'name'  => '首页主题图片(最多一张)'
        ],
        5 => [
            'value' => 'adv_1',
            'name'  => '广告位(3-4张)'
        ],
        6 =>  [
            'value' => 'adv_2',
            'name'  => 'ad轮播图'
        ],
        7 =>  [
            'value' => 'member_notice',
            'name'  => '会员中心提示消息'
        ],
        8 =>  [
            'value' => 'gou_notice',
            'name'  => '购物车顶部提示'
        ],
        9 =>  [
            'value' => 'gou_gou',
            'name'  => '购物圈'
        ],
    ];

    public static $LEVEL_DEFAULT = [
        'level'       => '0',
        'levelname'   => '会员',
        'jifen'       => '0',
        'zhekou'      => '10',
        'yicijiangli' => '0',
    ];

    public static $ORDER_SPECIAL = [
        'comment'   => 0B1,//评论
    ];

    public static $MEMBER_SPECIAL = [
        'cash'   => 0B1,//提现
    ];

    public static $ARTICLE_TYPE = [
        1 => '新闻',
        2 => '图集',
        3 => '视频',
    ];

    public static $ARTICLE_VIDEO_TYPE = [
        1 => 'hls',
        2 => 'mp4',
        3 => 'iframe',
    ];

    public static $ARTICLE_SPECIAL = [
        'comment'   => 0B1,//评论
        'pay'       => 0B10,//打赏
//        'first'     => 0B100,//置顶
        'uncomment' => 0B1000,//匿名评论
    ];

    const AGENT_ORDER_AMOUNT = 2;
    const AGENT_MONEY_AMOUNT = 3;

    public function __construct()
    {
        global $_GPC, $_W;
        $this->GPC = $_GPC;
        $this->W   = $_W;
    }

    public function __call($name, $arguments)
    {
        if (!method_exists($this, $name)) {
            return call_user_func_array([$this->site, $name], $arguments);
        } else {
            return call_user_func_array([$this, $name], $arguments);
        }
    }


    /**
     * 构造Web页面URL
     *
     * @param       $do
     * @param array $query 附加的查询参数
     *
     * @return string 返回的 URL
     */
    protected function createWebUrl($do, $query = [])
    {
        $route       = explode('/', $do);
        $query['do'] = $route[0];

        if (isset($route[1])) {
            $query['wdo'] = $route[1];
        }
        $query['m'] = strtolower($this->site->modulename);
        return wurl('site/entry', $query);
    }

    /**
     * 构造手机页面URL
     *
     * @param         $do         /action 默认action为index
     * @param array   $query      附加的查询参数
     * @param boolean $noredirect mobile 端url是否要附加 &wxref=mp.weixin.qq.com#wechat_redirect
     *
     * @return string 返回的 URL
     */
    protected function createMobileUrl($do, $query = [], $noredirect = true)
    {
        global $_W;
        $route       = explode('/', $do);
        $query['do'] = $route[0];
        if (isset($route[1])) {
            $query['wdo'] = $route[1];
        }
        $query['m'] = strtolower($this->site->modulename);
        return murl('entry', $query, $noredirect);
    }


    /**
     * @brief 模板变量赋值
     * @param        $name
     * @param string $value
     */
    public function assign($name,$value=''){
        $this->site->assign($name, $value);
    }

    public function __get($name)
    {
        return $this->site->$name;
    }

    /**
     * 展示模版
     *
     * @param $tpl
     */
    protected function display($filename = '')
    {
        $this->site->display($filename);
    }

    public function arrayIndex($arr, $key) {
        $new_arr = [];
        foreach($arr as $value) {
            $new_arr[$value[$key]] = $value;
        }
        return $new_arr;
    }

    /**
     * ajax返回格式化
     *
     * @param  $error_code
     * @param  $error_msg
     */
    protected function ajaxReturn($error_code, $error_msg, $error_data = '')
    {
        $result = [
            'code' => $error_code,
            'msg'  => $error_msg,
            'data'       => $error_data,
        ];
        echo json_encode($result);
        exit;
    }

    function getMyParentAndAgentInfo($id) {
        $sql = "SELECT weid,isagent,jifen,agentlevel,parent_id FROM " . tablename('wg_fenxiao_member') . " WHERE `id`=:id";
        $data = pdo_fetch($sql, array(
            ':id' => $id
        ));

        return $data;
    }


    protected function sendMyPaySuccessPush($userinfo, $templateid, $order, $weid, $jifen) {
        $acc  = self::getWeAccount($weid);//获取account
        $data = array(
            'first' => array(
                'value' => '您好，您购买的商品支付成功',
                'color' => '#173177'
            ) ,
            'keyword1' => array(
                'value' => $order['ordersn'],
                'color' => '#173177'
            ) ,
            'keyword2' => array(
                'value' => $order['total'],
                'color' => '#173177'
            ) ,
            'keyword3' => array(
                'value' => $order['orderprice'],
                'color' => '#173177'
            ) ,
            'keyword4' => array(
                'value' => $jifen,
                'color' => '#173177'
            ) ,
            'remark' => array(
                'value' => '欢迎再次光临',
                'color' => '#173177'
            )
        );
        $acc->sendTplNotice($userinfo['openid'], $templateid, $data);
    }

    public function sendSellerPush($weid, $seller, $templateid, $order, $goods,$user_info = []) {
        //获取account
        $acc = self::getWeAccount($weid);
        if($user_info) {
            $remark = '购买数量为：' . $order['total'] . ','.$order['orderprice'].'元,【'.$user_info['nickname'].'】已付款';
        }else {
            $remark = '购买数量为 x ' . $order['total'] . '，商品总价：'.$order['orderprice'].'元,买家已付款';
        }
        $data = array(
            'first' => array(
                'value' => '商家您好，有客户新下订单',
                'color' => '#173177'
            ) ,
            'keyword1' => array(
                'value' => date('Y-m-d H:i:s', time()) ,
                'color' => '#173177'
            ) ,
            'keyword2' => array(
                'value' => $goods['title'],
                'color' => '#173177'
            ) ,
            'keyword3' => array(
                'value' => $order['ordersn'],
                'color' => '#173177'
            ) ,
            'keyword4' => array(
                'value' => $order['orderprice'],
                'color' => '#173177'
            ) ,
            'remark' => array(
                'value' => $remark,
                'color' => '#173177'
            )
        );
        if (!empty($goods['seller'])) {
            $seller = $goods['seller'];
        }
        $acc->sendTplNotice($seller, $templateid, $data);
    }

    /**
     * @param $parent_info
     * @param $templateid
     * @param $nickname
     */
    public function sendXinZengGuanZhuTongZhi($parent_info, $templateid, $nickname){
        $acc = self::getWeAccount($parent_info['weid']);
        $name = '虎将';
        $data = array (
            'first' => array('value' => '恭喜您增加一员'.$name.':'.$nickname,'color'=>'#173177'),
            'keyword1' => array('value' => $nickname,'color'=>'#173177'),
            'keyword2' => array('value' => date('Y-m-d H:i',strtotime('now')),'color'=>'#173177'),
            'remark' => array(
                'value' => '系统推荐人：'.$parent_info['nickname'],
                'color' => '#173177'
            )
        );
        $acc->sendTplNotice($parent_info['openid'], $templateid, $data);
    }


    /**
     * 发放获得佣金push
     * @param $userinfo
     * @param $templateid
     * @param $order
     * @param $weid
     */
    public function sendSanJiGouMai($from, $to, $templateid, $order, $weid, $jifen, $money, $key, $day) {
        $acc     = self::getWeAccount($weid);
        $to_info = self::getPayUserInfo($to);
        if($key == 1){
            $name = '虎将';
        } elseif($key == 2){
            $name = '大将';
        } elseif($key == 3){
            $name = '福将';
        }

        $data = array(
            'first' => array(
                'value' => '恭喜您的' . $name . ':' . $from['nickname'] . '购买了商品，您将获得佣金:'.$money.'元，'.$day.'天后可提取',
                'color' => '#173177'
            ) ,
            'keyword1' => array(
                'value' => $order['ordersn'],
                'color' => '#173177'
            ) ,
            'keyword2' => array(
                'value' => $order['total'],
                'color' => '#173177'
            ) ,
            'keyword3' => array(
                'value' => $order['orderprice'],
                'color' => '#173177'
            ) ,
            'keyword4' => array(
                'value' => $jifen,
                'color' => '#173177'
            ) ,
            'remark' => array(
                'value' => '感谢您的推广',
                'color' => '#173177'
            )
        );
        $acc->sendTplNotice($to_info['openid'], $templateid, $data);
    }

    /**
     * @brief 获取配置
     * @param $uniacid
     * @return array|mixed
     */
    public function getSettings($uniacid  = 0) {

        if($uniacid) {
            $set = pdo_fetch("SELECT `settings` FROM " . tablename('uni_account_modules') . " WHERE module = :module AND uniacid = :uniacid", array(':module' => 'wg_fenxiao', ':uniacid' => $uniacid));
            if($set) {
                return unserialize($set['settings']);
            }
        }else {
            $set = pdo_fetchall("SELECT `uniacid`,`settings` FROM " . tablename('uni_account_modules') . " WHERE module = :module", array(':module' => 'wg_fenxiao'));
            if($set) {
                foreach($set as &$value) {
                    $value['settings'] = unserialize($value['settings']);
                }
                return $set;
            }
        }
        return [];
    }

    /**
     * @param $uid
     * @param $num
     * @return bool
     */
    public function addJifen($uid, $num, $shuoming, $userinfo = [], $uniacid) {

        $data = $this->_editLevel($uid, $num, $userinfo, $uniacid);
        if($data['level_jiang']) {
            $res = $this->MemberModel->update([
                'id' => $uid
            ],[
                'jifen +='    => $num,
                'agentlevel'  => $data['agent_level'],
                'level_jiang' => $data['level_jiang']
            ]);
        }else {
            $res = $this->MemberModel->update([
                'id' => $uid
            ],[
                'jifen +='    => $num,
                'agentlevel'  => $data['agent_level'],
            ]);
        }

        if($res) {
            return $this->addJifenMingXi($uid, $num, $shuoming);//写入明细
        }
        return $res;

    }

    private function _editLevel($uid, $num, $info, $uniacid) {

        if(!$info) {
            $info = self::getPayUserInfo($uid);
        }

        $agent_level = self::$LEVEL_DEFAULT['level'];

        //增加积分 不管是不是代理
        $level_jiang = 0;
        if($info['isagent']) {
            $levels = $this->getAllLevel('', $uniacid);
            foreach($levels as $level) {
                if($info['jifen']+$num >= $level['jifen']) {
                    $agent_level = $level['level'];
                    break;
                }
            }
            //升级奖，只有升级才有奖
            if($agent_level > $info['agentlevel']) {
                $level_jiang = $level['level'];
            }
        }


        return [
            'agent_level' => $agent_level,
            'level_jiang' => $level_jiang
        ];
    }

    public function addJifenMingXi($memberid,$jifen,$shuoming){
        $data = array(
            'memberid'   => $memberid+0,
            'jifen'      => $jifen+0,
            'shuoming'   => $shuoming,
            'createtime' => time()
        );
        return pdo_insert('wg_fenxiao_jifen_mingxi',$data);
    }


    /**
     * gou list
     * @param $page
     * @param $size
     * @param $where
     * @param $fields
     * @param $zhekou
     * @return array
     */
    public function _getGouList($page, $size, $where = [], $fields = '*', $zhekou = false) {

        $list  = $this->GouModel->getList($where, $fields, ['weight desc','id desc'], [$page, $size]);
        $goods_ids = [];
        foreach($list as $gou) {
            $goods_ids[] = $gou['goods_id'];
        }
        if($zhekou) {
            $w = [
                'start <' => time(),
                'end >'   => time(),
                'type'    => 1,
                'goods_id' => $goods_ids
            ];
            $z  = $this->GouModel->getList($w, ['goods_id','zhekou']);
            $z = $this->arrayIndex($z,'goods_id');
            foreach($list as &$vv) {
                $vv['zhekou'] = $z[$vv['goods_id']]['zhekou'];
            }
        }

        if($goods_ids) {
            $goods = $this->GoodsModel->getList([
                'id' => $goods_ids,
                'status' => 1
            ],['id','goodsname','label','marketprice','thumb','total','sell_total']);
            $goods = $this->arrayIndex($goods, 'id');
        }
        $new = [];

        foreach($list as $value) {
            if(isset($goods[$value['goods_id']])) {
                $v = array_merge($value,$goods[$value['goods_id']]);
                //format
                $v['image']   = formatArrImage($v['thumb']);
                $v['url']     = $this->createMobileUrl('goods',array('goods_id'=>$v['id']));
                $v['remain']  = $v['total']-$v['sell_total'];
                $v['percent'] = 100*$v['sell_total']/$v['total'];
                $v['display'] = $v['label'] ? 'inline-block;' : 'none';
                $new[] = $v;
            }
        }

        return $new;
    }

    public function ispost() {
        return $_SERVER['REQUEST_METHOD'] == "POST" ? true : false;
    }

    public function crontab_log($msg, $type = 'info') {
        if($type == 'info') {
            file_put_contents(dirname(__FILE__) . '/../info.log', date('Y-m-d H:i:s') . '|'.$msg."\n", FILE_APPEND);
        }else {
            file_put_contents(dirname(__FILE__) . '/../error.log', date('Y-m-d H:i:s') . '|'.$msg."\n", FILE_APPEND);
        }
    }


    public function getAllLevel($jifen = '', $uniacid) {
        $key = 'members:level:uid:%s';
        $key = sprintf($key, $uniacid);
        $list = cache_read($key);
        if(!$list) {
            $data = $this->MemberLevelModel->getList([
                'weid' => $uniacid
            ],['level','levelname','jifen','zhekou','yicijiangli'],'level desc');
            $data = $this->arrayIndex($data, 'level');
            cache_write($key, [
                'data' => $data
            ],3600*12);
        }else {
            $data =  $list['data'];
        }

        if($jifen) {
            foreach($data as $value) {
                if($jifen >= $value['jifen']) {
                    return $value;
                }
            }
            return self::$LEVEL_DEFAULT;
        }
        return $data;
    }

    public static function getWeAccount($weid) {
        if(self::$ACC[$weid]) {
            return self::$ACC[$weid];
        }else {
            self::$ACC[$weid] = WeAccount::create($weid);
        }
        return self::$ACC[$weid];

    }

    /**
     * 支付回调使用 PayresultController
     * @param $uid
     * @return mixed
     */
    public function getPayUserInfo($uid) {
        if(self::$PAY_USER_INFO[$uid]) {
            return self::$PAY_USER_INFO[$uid];
        }else {
            self::$PAY_USER_INFO[$uid] = $this->MemberModel->getOne([
                'id' => $uid
            ],['isagent','id','agentlevel','jifen','nickname','openid']);
        }
        return self::$PAY_USER_INFO[$uid];
    }
}