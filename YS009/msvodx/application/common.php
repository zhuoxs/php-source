<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// +----------------------------------------------------------------------
use think\Db;
use think\captcha\Captcha;
use \app\model\Member as Member;
use \app\model\Order as Order;

/**
 * 从数据库获取配置项的值
 * @author Dreamer
 * @param $name 配置名称
 * @return bool|mixed
 */
function get_config($name)
{
    $name = trim($name);
    $config = \think\Db::name('admin_config')->where(['name' => $name])->find();
    if (!$config || empty($config['value'])) {
        return false;
    } else {
        return $config['value'];
    }
}

/**
 * 从数据库获取配置组的信息
 * @author Dreamer
 * @param $name 配置组名称
 * @return bool|mixed
 */
function get_config_by_group($group)
{
    $group = trim($group);
    $config = \think\Db::name('admin_config')->field("name,value")->where(['group' => $group])->select();

    if (!$config) return null;

    $returnData = [];
    foreach ($config as $v) {
        $returnData[$v['name']] = $v['value'];
    }

    return $returnData;
}

/**
 * 获取菜单
 * @author frs
 * @return mixed
 */
function getMenu($pid = 0)
{
    $field = 'id,pid,name,url,type';
    $current = 0;
    if (empty($pid)) {
        $menu = Db::name('menu')->where(array('pid' => 0, 'status' => 1))->order('sort asc')->field($field)->select();
        foreach ($menu as $k => $v) {
            if ($v['type'] == 2) {
                $url = json_decode($v['url'], true);
                $urls = getModuleUrl($url);
                $menu[$k]['current'] = matchUrl($urls, $v['id']) ? 1 : 0;
                $menu[$k]['url'] = $urls;
            } else {
                $spos = strpos($v['url'], 'http://');
                if ($spos === false && $spos != 0) {
                    $v['url'] .= 'http://' . $v['url'];
                }
                $menu[$k]['current'] = matchUrl($v['url'], $v['id']) ? 1 : 0;
            }
            if ($menu[$k]['current'] == 1) $current = 1;
            $sublist = Db::name('menu')->where(array('pid' => $v['id'], 'status' => 1))->order('sort asc')->field($field)->select();
            if (!empty($sublist)) {
                foreach ($sublist as $key => $val) {
                    if ($val['type'] == 2) {
                        $url = json_decode($val['url'], true);
                        $urls = getModuleUrl($url);
                        if (matchUrl($urls, $val['id'])) {
                            $sublist[$key]['current'] = 1;
                            $menu[$k]['current'] = 1;
                            $current = 1;
                        } else {
                            $sublist[$key]['current'] = 0;
                        }
                        $sublist[$key]['url'] = $urls;
                    } else {
                        $sublist[$key]['current'] = 0;
                        $spos = strpos($val['url'], 'http://');
                        if ($spos === false && $spos != 0) {
                            $val['url'] .= 'http://' . $val['url'];
                        }
                        if (matchUrl($val['url'], $val['id'])) {
                            $sublist[$key]['current'] = 1;
                            $menu[$k]['current'] = 1;
                            $current = 1;
                        }
                    }
                }
                $menu[$k]['sublist'] = $sublist;
            }
        }
        if (empty($current)) {
            //如果匹配不上，再读取session保存的数据进行匹配
            $controller = lcfirst(request()->controller());
            $action = request()->action();
            $allowType = ['images', 'novel', 'video'];
            if (in_array(lcfirst($controller), $allowType)) {
                $current_menu = session('current_menu');
                if ($controller == $current_menu['controller']) {
                    $parent_menu = db::name('menu')->where(array('id' => $current_menu['id']))->find();
                    $mate_id = empty($parent_menu['pid']) ? $current_menu['id'] : $parent_menu['pid'];
                    foreach ($menu as $k => $v) {
                        if ($v['id'] == $mate_id) {
                            $menu[$k]['current'] = 1;
                            $current = 1;
                            $matchData = array(
                                'controller' => $controller,
                                'action' => $action,
                                'id' => $mate_id,
                            );
                            session('current_menu', $matchData);
                        }
                    }
                }
                if (empty($current)) {
                    $where['url'] = '{"cid":"' . $controller . '"}';
                    $menu_info = db::name('menu')->where($where)->field('id')->find();
                    foreach ($menu as $k => $v) {
                        if ($v['id'] == $menu_info['id']) {
                            $menu[$k]['current'] = 1;
                            $current = 1;
                            $matchData = array(
                                'controller' => $controller,
                                'action' => $action,
                                'id' => $menu_info['id'],
                            );
                            session('current_menu', $matchData);
                        }
                    }
                }
            }
        }

    } else {
        $menu = Db::name('menu')->where(array('pid' => $pid, 'status' => 1))->field($field)->select();
        foreach ($menu as $k => $v) {
            if ($v['type'] == 2) {
                $url = json_decode($v['url'], true);
                $urls = getModuleUrl($url);
                $menu[$k]['current'] = matchUrl($urls, $v['id']) ? 1 : 0;
                $menu[$k]['url'] = $urls;
            }
        }
    }
    return $menu;
}

/**
 * 根据url判断是否是当前选中
 * @author frs
 * @param url 链接
 * @param mid 菜单id
 * @return match 是否匹配 1 or 0
 */
function matchUrl($url, $mid = 0)
{
    $pageURL = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $origin_url = empty($_SERVER['HTTP_REFERER']) ? $pageURL : $_SERVER['HTTP_REFERER'];
    /*
    $pageURL = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    $pos = strpos($pageURL, 'http://');
    if ($pos === false) $pageURL = 'http://' . $pageURL;
    */
    $url = !empty($url) ? $url : $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    $urlArray = array(
        'http://' . $url,
        $url . '/',
        $url . 'html',
        $url . 'php',
        'https://' . $url,
        $url,
        'http://' . $_SERVER['SERVER_NAME'] . $url,
        'https://' . $_SERVER['SERVER_NAME'] . $url,
    );
    $match = in_array($pageURL, $urlArray) ? 1 : 0;
    /* if(empty($match)){
         if($origin_url != $pageURL) $match = in_array($origin_url, $urlArray) ? 1 : 0;
     }*/
    if (!empty($match)) {
        $matchData = array(
            'controller' => lcfirst(request()->controller()),
            'action' => request()->action(),
            'id' => $mid,
        );
        session('current_menu', $matchData);
    }
    return $match;
}

/**
 * 根据模块信息获取url
 * @author frs
 * @param int $cid 分类id
 * @param int $type 资源类型
 * @return url
 */
function getModuleUrl($param = '')
{
    $cid = !empty($param['cid']) ? $param['cid'] : 0;
    $base_class = ['video', 'images', 'novel'];
    if (!in_array($cid, $base_class)) {
        $module = 'video';
        switch ($param['type']) {
            case 1:
                $module = 'video';
                break;
            case 2:
                $module = 'images';
                break;
            case 3:
                $module = 'novel';
                break;
        }
        $url = url("$module/lists", array('cid' => $cid));
    } else {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . "/$cid/lists.html";
    }
    return $url;
}

/**
 * 生成验证码
 * @author Dreamer
 * @param string $id 验证码id
 * @param int $len 验证码长度
 * @param array $conf 验证码配置数组
 * @return \think\Response 返回验证码
 */
function create_captcha($id = '', $len = 4, $conf = [])
{
    $config = [
        'fontSize' => 16,
        'length' => $len,
        'imageH' => 30,
        'imageW' => 120,
        'useNoise' => true,
        'useCurve' => false,
        'fontttf' => '4.ttf',
        'bg' => [255, 255, 255],
    ];

    $config = count($conf) > 0 ? array_merge($config, $conf) : $config;

    $verify_obj = new Captcha($config);
    return $verify_obj->entry($id);
}


/**
 * 验证码验证
 * @author Dreamer
 * @param $code 用户输入的验证码
 * @param string $id 验证码的id
 * @return bool true:验证正确 ， falsh：验证失败
 */
function verify_captcha($code, $id = '')
{
    $captcha_obj = new Captcha();
    if ($captcha_obj->check($code, $id)) {
        return true;
    } else {
        return false;
    }
}


/**
 * 会员密码加密算法,如果要改动的话，客户端后台算法方法也要修改
 * @author Dreamer
 * @param $pwd
 * @return string
 */
function encode_member_password($pwd)
{
    return md5(md5($pwd));
}

/**
 * 生成用户登录验证令牌
 * @author rusheng
 * @param $user_info
 * @return string
 */
function get_token($user_info)
{
    return md5(md5($user_info['id'] . $user_info['username'] . $user_info['password'] . time()));
}

/**
 * 检验用户登录状态
 * @author rusheng
 * @param $user_info
 * @return string
 */
function check_is_login()
{
    $user_id = session('member_id');
    $access_token = session('access_token');
    //验证登陆
    if (intval($user_id) <= 0) {
        $data = ['resultCode' => 2, 'error' => '用户未登陆'];
        return $data;
        die;
    }
    $user_info = db::name('member')->where(array('id' => $user_id, 'access_token' => $access_token))->find();
    if (!$user_info) {
        $data = ['resultCode' => 3, 'error' => '该用户已在其他地方登陆'];
        session('member_id', '0');
        session('member_info', '');
        session('access_token', '');
        return $data;
        die;
    }
    $data = ['resultCode' => 1, 'message' => '用户已经登录'];
    return $data;
}

/**
 * 验证用户名和密码正确性
 * @author Dreamer
 * @param $user 用户名
 * @param $pwd  密码
 * @return bool true:验证成功，false:验证失败
 */
function check_member_password($user, $pwd)
{
    if (empty(trim($user)) || empty(trim($pwd))) return false;
    if (get_config('register_validate')) {
        $userType = get_str_format_type($user);
    } else {
        $userType = 'string';
    }

    $where['password'] = encode_member_password($pwd);
    switch ($userType) {
        case 'string':
            $where['username'] = $user;
            break;

        case 'email':
            $where['email'] = $user;
            break;

        case 'mobile':
            $where['tel'] = $user;
            break;
    }

    $memberInfo = \think\Db::name('member')->where($where)->find();
    if (!$memberInfo) {
        return false;
    }
    if ($memberInfo['status'] == 0) return ['rs' => -1, 'msg' => '您的账户已被禁用!'];
    $access_token = get_token($memberInfo);
    \think\Db::name('member')->where($where)->update(array('access_token' => $access_token));
    $sessionUserInfo = [
        'username' => $memberInfo['username'],
        'nickname' => $memberInfo['nickname'],
        'email' => $memberInfo['email'],
        'tel' => $memberInfo['tel'],
        'sex' => $memberInfo['sex'],
        'is_agent' => $memberInfo['is_agent'],
        'headimgurl' => $memberInfo['headimgurl'],
        'is_permanent' => $memberInfo['is_permanent']
    ];
    //写入session
    session('access_token', $access_token);
    session('member_id', $memberInfo['id']);
    session('member_info', $sessionUserInfo);

    return true;
}


/**
 * 会员退出登陆
 * @author Dreamer
 * @return bool
 */
function member_logout()
{
    session('member_id', null);
    session('member_info', null);
    return true;
}


/**
 * 根据字符串获取字符串的字符类型
 * @author Dreamer
 * @param $str
 * @return string
 */
function get_str_format_type($str)
{
    if (preg_match("/^[0-9a-zA-Z]+@(([0-9a-zA-Z]+)[.])+[a-z]{2,30}$/i", $str)) {
        return 'email';
    }

    if (preg_match("/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/", $str)) {
        return 'mobile';
    }
    return 'string';
}


/**
 * 视频付费等检测
 * @author  $Dreamer
 * @param $videoInfo
 * @return  array()  result=>1:正常观看  2:需要扣金币观看，且金币够扣  3:需扣金币观看，且金币不够扣  4:视频收费，但未登陆
 */
function check_video_auth($videoInfo)
{
    $memberInfo = get_member_info();

    /* 视频免费-----------------start--------------------------------------------------------------- */
    if ($videoInfo['gold'] == 0 || empty($videoInfo['gold']) || $videoInfo['user_id'] === session('member_id')) return ['result' => 1];
    /* 视频免费-----------------end----------------------------------------------------------------- */

    /* 视频收费-----------------start--------------------------------------------------------------- */
    //会员为vip
    if (isset($memberInfo) && $memberInfo['isVip']) return ['result' => 1];

    //会员非vip
    if (isset($memberInfo) && $memberInfo['isVip'] == false) {
        //检测是否在重复消费周期内，如果是则免费观看，否则 "试看" 或 "扣除金币观看"
        $buyTimeExists = get_config('message_validity');
        $buyTimeExists = 60 * 60 * $buyTimeExists;
        $watchHistory = Db::name('video_watch_log')
            ->where(['user_id' => $memberInfo['id'], 'video_id' => $videoInfo['id'], 'is_try_see' => 0])
            ->order('id desc')
            ->find();

        if ($watchHistory && $watchHistory['view_time'] > (time() - $buyTimeExists)) {
            //消费周期内，免费看
            return ['result' => 1];
        }

        //如果不在消费周期内，则 "试看" 或 "扣除金币观看"
        if ($memberInfo['money'] >= $videoInfo['gold']) {
            return ['result' => 2, 'msg' => '需金币支付后观看(其金币够支付)', 'memberInfo' => $memberInfo];
        }

        //无观看记录，且金币不够支付
        return ['result' => 3, 'msg' => '需金币支付后观看(其金币不够支付)', 'memberInfo' => $memberInfo];
    }

    //未登陆
    //$videoConfig=get_config_by_group('video');  //video相关配置
    //return ['result'=>2,'msg'=>'当前系统允许试看','look_at_measurement'=>get_config('look_at_measurement'),'look_at_num'=>get_config('look_at_num')];
    return ['result' => 4, 'msg' => '视频需收费，但未登陆'];

    /* 视频收费-----------------end--------------------------------------------------------------- */

}

/**
 * 获取试看剩余次数
 * @return array|bool|int|mixed  返回数组则为试看的秒数，如int则为剩余次数
 */
function get_remainder_try_see()
{
    //video相关配置  look_at_measurement:试看单位 look_at_num:1为部 2为秒 look_at_on:是否启动试看(1为支持，0为不支持)
    $videoConfig = get_config_by_group('video');
    $todayBegin = strtotime(date('Y-m-d'));

    $where = [];
    if (session('member_id')) {
        #$where['user_id'] = session('member_id');
    } else {
        #$where['user_ip'] = request()->ip();
    }
    //以 user_ip 来统计试看次数。取消登陆前试看n次，登陆后也可试看n次 $dreamer 2018/3/13
    $where['user_ip'] = request()->ip();

    $where['view_time'] = ['>=', $todayBegin];

    if (isset($videoConfig['look_at_on']) && !$videoConfig['look_at_on']) return false;
    if (isset($videoConfig['look_at_on']) && $videoConfig['look_at_on'] && isset($videoConfig['look_at_measurement'])) {
        if (request()->isMobile()) $videoConfig['look_at_measurement'] = 1;//手机端只能按部试看
        switch ($videoConfig['look_at_measurement']) {
            case 1://部
                //查询浏览日志，是否超过限制(以天为结算)
                $rowCount = Db::name('video_watch_log')->where($where)->count();
                $data = ($rowCount >= $videoConfig['look_at_num']) ? 0 : ($videoConfig['look_at_num'] - $rowCount);
                if (request()->isMobile()) $data = $videoConfig['look_at_num_mobile'] - $rowCount;
                $data = $data >= 0 ? $data : 0;
                return $data;
                break;
            case 2://秒
                return ['look_at_num' => $videoConfig['look_at_num']];
                break;
        }
    }

    return false;
}


/**
 * 插入观看日志
 * @author  $Dreamer
 */
function insert_watch_log($type, $id, $gold = 0, $isTrySee = false, $userid)
{

    $isTrySee = $isTrySee ? true : false;

    if (!in_array($type, ['atlas', 'video', 'novel']) || $id <= 0) return false;

    $resourceTable = [
        'atlas' => 'atlas_watch_log',
        'video' => 'video_watch_log',
        'novel' => 'novel_watch_log'
    ];

    $memberId = session('member_id');
    if (isset($_SERVER['HTTP_ALI_CDN_REAL_IP'])) {
        $ip=$_SERVER['HTTP_ALI_CDN_REAL_IP'];
    }else{
        $ip =\think\Request::instance()->ip();
    }


    $where = [
        'user_ip' => $ip,
        "{$type}_id" => $id
    ];

    global $whereUID;
    $whereUID = [
        'user_id' => $memberId,
        "{$type}_id" => $id
    ];

    if ($isTrySee) {
        //为了防止数据库冗余，试看情况下:: 故 （同资源id且同Ip） 或者 （同资源id同user_id），在4小时内不重复写入  $Dreamer
        $limitTime = ['>', time() - 4 * 60 * 60];
        $where['view_time'] = $whereUID['view_time'] = $limitTime;
    } else {
        $where['is_try_see'] = $whereUID['is_try_see'] = 0;

        $buyTimeExists = get_config('message_validity');
        $buyTimeExists = 60 * 60 * $buyTimeExists;
        $where['view_time'] = ['>', time() - $buyTimeExists];
        $whereUID['view_time'] = ['>', time() - $buyTimeExists];
    }

    $db = Db::name($resourceTable[$type]);
    $watchLog = $db->where($where)->whereOr(function ($query) {
        global $whereUID;
        $query->where($whereUID);
    })->find();

    if (!$watchLog) {

        $returnRs = true;
        //扣除会员的gold
        if (!$isTrySee && $memberId > 0 && $gold > 0 && $userid != session('member_id')) {
            $memberModel = model('member')->get($memberId);
            $memberInfo = $memberModel->toArray();

            if ($memberInfo['is_permanent'] == 1 || $memberInfo['out_time'] > time()) {
                //如果是vip则不扣费
                $returnRs = true;
            } elseif (isset($memberInfo['money']) && $memberInfo['money'] >= $gold) {
                $memberModel->money -= $gold;
                $decMoneyRs = $memberModel->save();
                //作者分成
                author_divide('video', $id);
                //消费记录金币变动记录
                Db::name('gold_log')->data(['user_id' => session('member_id'), 'gold' => "-$gold", 'add_time' => time(), 'module' => $type, 'explain' => '视频内容扣费'])->insert();
                $returnRs = ($decMoneyRs) ? true : false;
            }
        }

        if ($returnRs) {
            $insertData = ["{$type}_id" => $id, 'user_id' => session('member_id'), 'user_ip' => $ip, 'view_time' => time(), 'gold' => $gold, 'is_try_see' => $isTrySee];
            ($userid == session('member_id') && $userid > 0) ? $insertData['is_myself'] = 1 : $insertData['is_myself'] = 0;  //发布者自己观看视频的标识

            $db->data($insertData)->insert();
            return true;
        } else {
            return false;
        }
    }

    return true;

}

/**
 * 用户消费作者参与分成
 * $type 1 视频 ，2 资讯 ，3 图片
 */
function author_divide($type, $project_id)
{
    if (!in_array($type, ['atlas', 'video', 'novel'])) return false;
    $resourceTable = [
        'atlas' => 'atlas',
        'video' => 'video',
        'novel' => 'novel'

    ];
    $project = Db::name($resourceTable[$type])->where(['id' => $project_id])->find();
    $num = floor((float)get_config($type . '_commission') * intval($project['gold']) * 0.01);
    $result = Db::name('member')->where(['id' => $project['user_id']])->setInc('money', $num);

    if ($result) {
        //写入
        $s = '';
        switch ($type) {
            case 'atlas':
                $s = '图册';
                break;
            case 'video':
                $s = '视频';
                break;
            case 'novel':
                $s = '小说';
                break;
            default:
                $s = '';
        }

        $data['user_id'] = $project['user_id'];
        $data['gold'] = $num;
        $data['add_time'] = time();
        $data['module'] = $resourceTable[$type];
        $data['explain'] = "上传{$s}项目分成";
        Db::name('gold_log')->insert($data);
    }
    return true;
}


/**
 * 插入观看日志 显示具体信息
 * @author
 */
function insert_watch_logshowmsg($type, $id, $user_id, $gold = 0, $isTrySee = false)
{
    $isTrySee = $isTrySee ? true : false;

    if (!in_array($type, ['atlas', 'video', 'novel']) || $id <= 0) return false;

    $resourceTable = [
        'atlas' => 'atlas_watch_log',
        'video' => 'video_watch_log',
        'novel' => 'novel_watch_log'
    ];

    $memberId = intval(session('member_id'));
    $ip = \think\Request::instance()->ip();

    $where = [
        'user_ip' => $ip,
        "{$type}_id" => $id
    ];

    global $whereUID;
    $whereUID = [
        'user_id' => $memberId,
        "{$type}_id" => $id
    ];

    if ($isTrySee) {
        //为了防止数据库冗余，试看情况下:: 故 （同资源id且同Ip） 或者 （同资源id同user_id），在4小时内不重复写入  $Dreamer
        $limitTime = ['>', time() - 4 * 60 * 60];
        $where['view_time'] = $whereUID['view_time'] = $limitTime;
    } else {
        $where['is_try_see'] = $whereUID['is_try_see'] = 0;

        $buyTimeExists = get_config('message_validity');
        $buyTimeExists = 60 * 60 * $buyTimeExists;
        $where['view_time'] = ['>', time() - $buyTimeExists];
        $whereUID['view_time'] = ['>', time() - $buyTimeExists];
    }

    $db = Db::name($resourceTable[$type]);
    $watchLog = $db->where($where)->whereOr(function ($query) {
        global $whereUID;
        $query->where($whereUID);
    })->find();

    if ($memberId <= 0 && $gold > 0) {
        return '1';
    }
    $memner_info = get_member_info($memberId);
    if (!$watchLog && $user_id != session('member_id') && !$memner_info['isVip']) {//判断是否是vip,是否是作者，是否观看记录在有效期内
        //扣除会员的gold
        if (!$isTrySee && $memberId > 0 && $gold > 0) {
            return '1';
        }
    }
    return '0';
}

//获取第三方登录
function get_sanfanlogin()
{
    $logininfo = Db::name('login_setting')->where(['status' => 1])->select();
    return $logininfo;
}

/**
 * 根据Id获取会员身份信息
 * @author  $Dreamer
 * @param int $memberId
 * @return array|null
 */
function get_member_info($memberId = 0)
{
    $memberId = $memberId == 0 ? session('member_id') : $memberId;
    if (!$memberId) return null;
    $memberInfo = Db::name('member')->field('id,headimgurl,is_permanent,tel,sex,email,nickname,gid,out_time,money')->where(['id' => $memberId])->find();
    if (!$memberInfo) return null;
    if ($memberInfo['is_permanent'] == 1 || $memberInfo['out_time'] > time()) {
        $memberInfo['isVip'] = true;
        if ($memberInfo['is_permanent'] == 1) $memberInfo['isEverVip'] = true;
    } else {
        $memberInfo['isVip'] = false;
    }
    return $memberInfo;
}


/**
 * 返回想要查询的值
 * @param $param array
 * @param db 要查询的数据库名称
 * @param  where 查询的条件
 * @param  field 查询的字段
 */
function get_field_values($param = '')
{
    $db = $param['db'];
    $where = $param['where'];
    $field = $param['field'];
    $type = empty($param['type']) ? 'array' : $param['type'];
    $data = Db::name($db)->where($where)->field($field)->select();
    if ($type == 'string') {
        $Result='';
    }else{
        $Result=array();
    }
    foreach ($data as $k => $v) {
        if ($type == 'string') {
            if (empty($k)) {
                $Result .= $v[$field];
            } else {
                $Result .= ',' . $v[$field];
            }
        } else {
            $Result[] = $v[$field];
        }
    }
    return $Result;
}

/**
 * 相关推荐数据
 * @author  $Dreamer
 * @param $param array
 * @param type  要查询的资源类型  image  novel  video
 * @param  cid 分类id
 * @param  limit  返回的数量，默认为8个
 * @param  field 查询的字段，如果该字段不存的话会根据资源类型读取默认的数据
 */
function get_recom_data($param = '')
{
    $ctype = [
        'image' => 2,
        'novel' => 3,
        'video' => 1
    ];
    $type = empty($param['type']) ? 'video' : $param['type'];
    $limit = empty($param['limit']) ? '8' : $param['limit'];
    $default_where = ($type == 'video') ? 'status = 1 and pid=0' : 'status = 1';
    if (!empty($param['cid'])) {
        $params = array(
            'db' => 'class',
            'where' => array('status' => 1, 'type' => $ctype[$type], 'pid' => $param['cid']),
            'field' => 'id',
            'type' => 'string',
        );
        $sub_array = get_field_values($params);
        $default_where .= empty($sub_array) ? ' and class = ' . $param['cid'] : ' and (class = ' . $param['cid'] . ' or class in (' . $sub_array . '))';
    }
    $where = empty($param['where']) ? $default_where : $param['where'];
    $resourceTable = [
        'image' => 'atlas',
        'novel' => 'novel',
        'video' => 'video'
    ];
    $fieldData = [
        'image' => 'id,title,thumbnail,good,play_time,add_time,gold,update_time',
        'novel' => 'id,title,thumbnail,good,click,add_time,gold,update_time',
        'video' => 'id,title,thumbnail,good,play_time,click,add_time,gold,update_time'
    ];
    $count = Db::name($resourceTable[$type])->where($where)->count();
    if ($count < $limit) {
        $data = Db::name($resourceTable[$type])->where($where)->field($fieldData[$type])->select();
    } else {
        $rand_num = rand(1, 99999);
        $start = $rand_num % $count;
        $result = Db::name($resourceTable[$type])->where($where)->field($fieldData[$type])->limit($start, $limit)->select();
        $data = empty($param['result']) ? $result : array_merge($param['result'], $result);
        if (count($result) < $limit) {
            $array = '';
            foreach ($data as $k => $v) {
                if (empty($k)) {
                    $array .= $v['id'];
                } else {
                    $array .= ',' . $v['id'];
                }
            }
            $param = array(
                'type' => $type,
                'limit' => $limit - count($result),
                'result' => $data,
                'where' => $default_where . ' and id not in (' . $array . ')',
            );
            $data = get_recom_data($param);
        }
    }
    shuffle($data);
    return $data;
}


/**
 * 检测用户是否为当前资源点过赞
 * @author  $Dreamer
 * @param $type
 * @param $id
 * @return bool
 */
function isGooded($type, $id)
{
    if (session('member_id') <= 0) return false;

    if ($id <= 0) return false;

    $allowType = ['atlas', 'novel', 'video'];
    if (!in_array($type, $allowType)) return false;

    $resourceTable = [
        'atlas' => 'atlas',
        'novel' => 'novel',
        'video' => 'video'
    ];

    $goodHistory = Db::name("{$type}_good_log")->where(["{$resourceTable[$type]}_id" => $id, 'user_id' => session('member_id')])->find();
    if (!$goodHistory) return false;
    return true;
}

/**
 * 判断当天是否已经点赞
 */
function isSign()
{
    if (session('member_id') <= 0) die(json_encode(['resultCode' => 4005, 'error' => '用户未登陆']));
    $user_id = session('member_id');
    $today = strtotime(date('Y-m-d'));
    $tomorrow = $today + (24 * 3600 - 1);
    $where = "user_id = $user_id and (sign_time between $today and $tomorrow)";
    $result = Db::name('sign')->where($where)->find();
    if (empty($result)) return false;
    return true;
}

/**
 * 检测用户是否收藏过当前资源
 * @author  $Dreamer
 * @param   $type
 * @param   $id
 * @return  bool
 */
function isCollected($type, $id)
{

    if (session('member_id') <= 0) return false;

    if ($id <= 0) return false;

    $allowType = ['image', 'novel', 'video'];
    if (!in_array($type, $allowType)) return false;

    $resourceTable = [
        'image' => 'atlas',
        'novel' => 'novel',
        'video' => 'video'
    ];

    $goodHistory = Db::name("{$type}_collection")->where(["{$resourceTable[$type]}_id" => $id, 'user_id' => session('member_id')])->find();
    if (empty($goodHistory)) {

        return false;
    } else {
        return true;
    }

}


/**
 * 产生随机字符串
 * @param int $length
 * @return 产生的随机字符串
 */
function get_random_str($length = 32)
{
    $chars = "abcdefghijklmnpqrstuvwxyz123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}

/**
 * 返回想要的分类
 * @param $param array
 * @param resourceType 资源类型 视频 1 ，图片 2，资讯 3
 * @param  pid  默认为0
 */
function get_resource_class($param = '')
{
    $db = db::name('class');
    $pid = empty($param['pid']) ? 0 : $param['pid'];
    $resourceType = empty($param['resourceType']) ? 1 : $param['resourceType'];
    $where = "status = 1 and type = $resourceType";
    $order = 'sort asc';
    if (empty($pid)) {
        $where .= ' and pid = 0';
        $pid = 0;
        $Result = $db->where($where)->order($order)->select();
        foreach ($Result as $k => $v) {
            $Result[$k]['childs'] = $db->where(['pid' => $v['id']])->select();
        }
    } else {
        $where .= "and pid = $pid";
        $Result = $db->where($where)->order($order)->select();
    }
    return $Result;
}

/**
 * 操作跳转的快捷方法
 * @access protected
 * @param mixed $msg 提示信息
 * @param string $url 跳转的URL地址要带http格式的完整网址
 * @param integer $icon 1为正确 2为错误
 * @param integer $wait 跳转等待时间
 * @param integer $type 提示完成的回调处理 1为当前界面的处理 2为子层处理，关闭子层并且刷新父层
 * @return void
 */
function layerJump($msg = '', $icon = 1, $type = 1, $wait = 1, $url = 'null')
{
    $script = '';
    $script .= '<script>';
    $script .= "parent.layer.msg('$msg', {icon: $icon, time: $wait*1000},function(){";
    if ($type == 2) {
        $script .= 'window.parent.location.reload();';
        $script .= 'parent.layer.close(index);';
    } elseif ($type == 1) {
        if (empty($url) || $url == 'null') {
            $script .= 'location.reload();';
        } else {
            $script .= "window.location.href='$url';";
        }
    } else {
        $script .= 'history.go(-1);';
    }
    $script .= '});';
    $script .= '</script>';
    echo $script;
}

/**
 * 获取seo相关设置
 * @author $dreamer
 * @param int $byUid
 * @return mixed|null
 */
function get_seo_info_plus()
{
    $request = request();
    $tablePrefix = config('database.prefix');
    $curDomain = $request->host();

    //检测来路域名是否在cname域名列表之中,从cname表中取所有记录进行in_array查询
    #$allCnameDomain=Db::table($tablePrefix.'domain_cname_binding')->where(['status'=>1])->field('uid,webhost')->cache(60)->select();
    $allCnameDomain = Db::table($tablePrefix . 'domain_cname_binding')->where(['status' => 1])->cache(60)->column('uid,webhost');
    if (is_array($allCnameDomain)) {
        foreach ($allCnameDomain as $uid => $domain) {
            if ($curDomain == strtolower($domain)) {
                session('cur_agent_id', $uid);
                break;
            }
        }
    }


    $__domain = $request->param('__domain__');
    $systemDomain = ['admin', 'system'];
    $seoInfo = null;

    if (!session('cur_agent_id')) {
        $preg = '/[aA](\d+)/i';
        $rs = preg_match($preg, $__domain, $pregRs);
        if (isset($__domain) && !in_array($__domain, $systemDomain) && $rs) {
            session("cur_agent_id", $pregRs[1]);
            //if(!$seoInfo)  $this->redirect('/',302);    //此处有可能会造成多次的重定向  $dreamer 20180224
        }else{
            $domain=$curDomain;
        }
    }
    $byUid = session('cur_agent_id')>0? session('cur_agent_id'):0;  //如果session里无agent_id，那么判定为无agent关系，则走域名站群判断 $dreamer

    $siteBaseInfo = null;

    //获取基础站信息
    $baseConfig = cache('site_base_info');
    if (empty($baseConfig)) $baseConfig = get_config_by_group('base');

    if ($byUid <= 0) {
        //默认域名直接从配置信息中取seo信息，否则从站群中取seo信息
        if (!empty($domain)) {
            $domain = str_replace(['http://', 'https://'], '', trim($domain));
            $siteBaseInfo = cache('site_base_info_' . md5($domain));
            if ($siteBaseInfo) return $siteBaseInfo;

            $websiteInfo = Db::name('website_group_setting')->where(['domain' => $domain])->find();

            if ($websiteInfo) {
                $siteBaseInfo = [
                    'site_logo_mobile' => isset($websiteInfo['site_logo_mobile'])?$websiteInfo['site_logo_mobile']:$baseConfig['site_logo_mobile'],
                    'site_logo' => isset($websiteInfo['logo_url'])?$websiteInfo['logo_url']:$baseConfig['logo_url'],
                    'site_title' => isset($websiteInfo['site_title'])?$websiteInfo['site_title']:$baseConfig['site_title'],
                    'site_keywords' => isset($websiteInfo['site_keywords'])?$websiteInfo['site_keywords']:$baseConfig['site_keywords'],
                    'site_description' => isset($websiteInfo['site_description'])?$websiteInfo['site_description']:$baseConfig['site_description'],
                    'site_statis' => isset($websiteInfo['site_statis'])? $websiteInfo['site_statis']:$baseConfig['site_statis'],
                    'friend_link' => isset($websiteInfo['friend_link'])?$websiteInfo['friend_link']:$baseConfig['friend_link'],
                    'site_icp' => isset($websiteInfo['site_icp'])?$websiteInfo['site_icp']:$baseConfig['site_icp'],
                  	'site_qq' => isset($websiteInfo['site_qq'])?$websiteInfo['site_qq']:$baseConfig['site_qq'],
                ];
                cache('site_base_info_' . md5($domain), $siteBaseInfo);

                return $siteBaseInfo;
            }
        }

        $siteBaseInfo = $baseConfig;
        return $siteBaseInfo;
    } else {
        $siteBaseInfo = cache("site_base_info_{$byUid}");
        if (empty($siteBaseInfo)) {
            $userSiteConfig = Db::name('member')->field('agent_config,is_agent')->where(['id' => $byUid])->find();
            if (isset($userSiteConfig['is_agent']) && $userSiteConfig['is_agent'] == 1) {
                $userSiteConfig = unserialize($userSiteConfig['agent_config']);
                $siteBaseInfo['site_logo_mobile'] = empty($userSiteConfig['site_logo_mobile']) ? $baseConfig['site_logo_mobile'] : $userSiteConfig['site_logo_mobile'];
                $siteBaseInfo['site_logo'] = empty($userSiteConfig['site_logo']) ? $baseConfig['site_logo'] : $userSiteConfig['site_logo'];
                $siteBaseInfo['site_title'] = empty($userSiteConfig['site_title']) ? $baseConfig['site_title'] : $userSiteConfig['site_title'];
                $siteBaseInfo['site_keywords'] = empty($userSiteConfig['site_keywords']) ? $baseConfig['site_keywords'] : $userSiteConfig['site_keywords'];
                $siteBaseInfo['site_description'] = empty($userSiteConfig['site_description']) ? $baseConfig['site_description'] : $userSiteConfig['site_description'];
              	$siteBaseInfo['site_qq'] = empty($userSiteConfig['site_qq']) ? $baseConfig['site_qq'] : $userSiteConfig['site_qq'];
                //cache("site_base_info_{$byUid}",$siteBaseInfo);
            } else {
                if (empty($siteBaseInfo)) {

                    $siteBaseInfo['site_logo_mobile'] = $baseConfig['site_logo_mobile'];
                    $siteBaseInfo['site_logo'] = $baseConfig['site_logo'];
                    $siteBaseInfo['site_title'] = $baseConfig['site_title'];
                    $siteBaseInfo['site_keywords'] = $baseConfig['site_keywords'];
                    $siteBaseInfo['site_description'] = $baseConfig['site_description'];
                    $siteBaseInfo['site_qq'] = $baseConfig['site_qq'];
                    cache('site_base_info', $siteBaseInfo);
                }

                return $siteBaseInfo;
            }
        }

        return $siteBaseInfo;
    }
}

/**
 * 获取seo相关设置
 * @author $dreamer
 * @param int $byUid
 * @return mixed|null
 */
function get_seo_info($byUid = 0, $domain = '')
{
    $siteBaseInfo = null;
    if ($byUid <= 0) {
        //默认域名直接从配置信息中取seo信息，否则从站群中取seo信息
        if (!empty($domain)) {

            $domain = str_replace(['http://', 'https://'], '', trim($domain));
            $siteBaseInfo = cache('site_base_info_' . md5($domain));

            if ($siteBaseInfo) return $siteBaseInfo;

            $websiteInfo = Db::name('website_group_setting')->where(['domain' => $domain])->find();
            if ($websiteInfo) {
                $siteBaseInfo = [
                    'site_logo_mobile' => $websiteInfo['site_logo_mobile'],
                    'site_logo' => $websiteInfo['logo_url'],
                    'site_title' => $websiteInfo['site_title'],
                    'site_keywords' => $websiteInfo['site_keywords'],
                    'site_description' => $websiteInfo['site_description'],
                    'site_statis' => $websiteInfo['site_statis'],
                    'friend_link' => $websiteInfo['friend_link'],
                    'site_icp' => $websiteInfo['site_icp'],
                  	'site_qq' => $websiteInfo['site_qq'],
                ];
                cache('site_base_info_' . md5($domain), $siteBaseInfo);

                return $siteBaseInfo;
            }


        }

        $siteBaseInfo = cache('site_base_info');

        if (empty($siteBaseInfo)) {
            $baseConfig = get_config_by_group('base');
            $siteBaseInfo['site_logo_mobile'] = $baseConfig['site_logo_mobile'];
            $siteBaseInfo['site_logo'] = $baseConfig['site_logo'];
            $siteBaseInfo['site_title'] = $baseConfig['site_title'];
            $siteBaseInfo['site_keywords'] = $baseConfig['site_keywords'];
            $siteBaseInfo['site_description'] = $baseConfig['site_description'];
          	$siteBaseInfo['site_qq'] = $baseConfig['site_qq'];
            cache('site_base_info', $siteBaseInfo);
        }
        return $siteBaseInfo;
    } else {
        $siteBaseInfo = cache("site_base_info_{$byUid}");
        if (empty($siteBaseInfo)) {
            $userSiteConfig = Db::name('member')->field('agent_config,is_agent')->where(['id' => $byUid])->find();
            if (isset($userSiteConfig['is_agent']) && $userSiteConfig['is_agent'] == 1) {
                $userSiteConfig = unserialize($userSiteConfig['agent_config']);
                $baseConfig = get_seo_info();
                $siteBaseInfo['site_logo_mobile'] = empty($userSiteConfig['site_logo_mobile']) ? $baseConfig['site_logo_mobile'] : $userSiteConfig['site_logo_mobile'];
                $siteBaseInfo['site_logo'] = empty($userSiteConfig['site_logo']) ? $baseConfig['site_logo'] : $userSiteConfig['site_logo'];
                $siteBaseInfo['site_title'] = empty($userSiteConfig['site_title']) ? $baseConfig['site_title'] : $userSiteConfig['site_title'];
                $siteBaseInfo['site_keywords'] = empty($userSiteConfig['site_keywords']) ? $baseConfig['site_keywords'] : $userSiteConfig['site_keywords'];
                $siteBaseInfo['site_description'] = empty($userSiteConfig['site_description']) ? $baseConfig['site_description'] : $userSiteConfig['site_description'];
              	$siteBaseInfo['site_qq'] = empty($userSiteConfig['site_qq']) ? $baseConfig['site_qq'] : $userSiteConfig['site_qq'];
                //cache("site_base_info_{$byUid}",$siteBaseInfo);
            } else {
                return false;
            }
        }

        return $siteBaseInfo;
    }
}

/**
 * 返回隐藏部分字符串后的邮箱地址
 * @author $dreamer
 * @param $mailUrl
 * @return string
 */
function hidden_mail_str($mailUrl)
{
    if (get_str_format_type($mailUrl) != 'email') {
        return '';
    }

    $mailStrArr = explode('@', $mailUrl);
    $frontStr = array_shift($mailStrArr);

    $mailBackStr = '@' . implode('', $mailStrArr);

    $frontStrLen = strlen($frontStr);

    if ($frontStrLen > 3) {
        return substr($frontStr, 0, 2) . "***" . substr($frontStr, $frontStrLen - 1, 1) . $mailBackStr;
    }
    return $frontStr . "***" . $mailBackStr;
}

/**
 * 检测是否为手机终端
 * $Dreamer
 */
function is_mobile()
{
    $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
    $mobile_browser = '0';
    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
        $mobile_browser++;
    if ((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') !== false))
        $mobile_browser++;
    if (isset($_SERVER['HTTP_X_WAP_PROFILE']))
        $mobile_browser++;
    if (isset($_SERVER['HTTP_PROFILE']))
        $mobile_browser++;
    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array(
        'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
        'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
        'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
        'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
        'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
        'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
        'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
        'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
        'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-'
    );
    if (in_array($mobile_ua, $mobile_agents))
        $mobile_browser++;
    if (strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
        $mobile_browser++;
    // Pre-final check to reset everything if the user is on Windows
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
        $mobile_browser = 0;
    // But WP7 is also Windows, with a slightly different characteristic
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)
        $mobile_browser++;
    if ($mobile_browser > 0)
        return 1;
    else
        return 0;
}

/**
 * 获取当前主域名
 * $Dreamer
 */
function get_top_domain($domain)
{
    $protocol = ['http://', 'https://'];
    $domain = str_replace($protocol, '', $domain);
    $domainArr = explode('/', $domain);
    $domain = $domainArr[0];
    $domainArr = explode('.', $domain);
    array_shift($domainArr);
    $domain = implode('.', $domainArr);
    return $domain;

}

/**
 * 获取目录下的支付方式
 * @author  $dreamer
 * @date    2017/12/28
 */
function get_payment_list($path = '../extend/systemPay')
{

    $dir = @opendir($path);
    $___setPayment = true;
    $payLists = [];
    while (($file = @readdir($dir)) !== false) {
        if (preg_match('/^[a-zA-z]{1}.*?\.php$/', $file)) {
            include_once($path . DS . $file);
        }
    }
    @closedir($dir);
    foreach ($payLists as $key => $value) {
        asort($payLists[$key]);
    }

    return $payLists;
}

/**
 * 订单号生成
 * @author  $dreamer
 * @date    2017/12/28
 */
function create_order_sn()
{
    list($microSec, $sec) = explode(' ', microtime());
    $seed = $sec + (float)$microSec * 10000;
    srand($seed);
    $rand = rand(11111, 99999);
    return date('YmdHis') . $rand;
}

/**
 * 过滤数组中的空值项
 * @author  $dreamer
 * @date    2017/12/28
 */
function filterArray($arr)
{
    if (!is_array($arr)) return $arr;
    if (count($arr) <= 0) return $arr;
    $tmpArr = [];
    foreach ($arr as $key => $value) {
        if ($value == '') continue;
        $tmpArr[$key] = $value;
    }

    return $tmpArr;
}

/*----------------------------------------云转码相关函数----------------------start--------------------*/
/** 云转码播放密钥生成 **/
function create_yzm_play_sign()
{
    $key = trim(get_config('yzm_play_secretkey'));
    if (empty($key)) return '';
    $time = time() . '000';
    $ip = request()->ip();
    $data = "timestamp=" . $time . "&ip=" . $ip;
    $padding = 16 - (strlen($data) % 16);
    $data .= str_repeat(chr($padding), $padding);
    $keySize = 16;
    $ivSize = 16;
    $rawKey = $key;
    $genKeyData = '';
    do {
        $genKeyData = $genKeyData . md5($genKeyData . $rawKey, true);
    } while (strlen($genKeyData) < ($keySize + $ivSize));
    $generatedKey = substr($genKeyData, 0, $keySize);
    $generatedIV = substr($genKeyData, $keySize, $ivSize);
    #return bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $generatedKey, $data, MCRYPT_MODE_CBC, $generatedIV));
    return bin2hex(openssl_encrypt($data, 'AES-128-CBC', $generatedKey, OPENSSL_RAW_DATA, $generatedIV)); //兼容 >=PHP7.1 $dreamer
}


//转换时间
function secondsToHour($seconds)
{
    if (intval($seconds) < 60) {
        $tt = "00:00:" . sprintf("%02d", intval($seconds % 60));
        return $tt;
    }
    if (intval($seconds) >= 60) {
        $h = sprintf("%02d", intval($seconds / 60));
        $s = sprintf("%02d", intval($seconds % 60));
        if ($s == 60) {
            $s = sprintf("%02d", 0);
            ++$h;
        }
        $t = "00";
        if ($h == 60) {
            $h = sprintf("%02d", 0);
            ++$t;
        }
        if ($t) {
            $t = sprintf("%02d", $t);
        }
        $tt = $t . ":" . $h . ":" . $s;
    }
    if (intval($seconds) >= 60 * 60) {
        $t = sprintf("%02d", intval($seconds / 3600));
        $h = sprintf("%02d", intval($seconds / 60) - $t * 60);
        $s = sprintf("%02d", intval($seconds % 60));
        if ($s == 60) {
            $s = sprintf("%02d", 0);
            ++$h;
        }
        if ($h == 60) {
            $h = sprintf("%02d", 0);
            ++$t;
        }
        if ($t) {
            $t = sprintf("%02d", $t);
        }
        $tt = $t . ":" . $h . ":" . $s;
    }
    if (!(int)$t) {
        $tt = $h . ":" . $s;
    }
    return $seconds > 0 ? $tt : '00:00:00';
}

//转换文件大小
function formatBytes($size)
{
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
    return round($size, 2) . $units[$i];
}

/*----------------------------------------云转码相关函数----------------------end--------------------*/
/**
 * 写入金币记录
 * @author  rusheng
 * @param user_id 用户id
 * @param gold 金币数
 * @param module 所属模块
 * @param explain 描述说明
 * @date    2017/1/18
 */
function write_gold_log($param)
{
    $param['add_time'] = time();
    return db::name('gold_log')->insert($param);
}

/** 获取目录或文件权限 */
function get_dir_chmod($dirName)
{
    $chmod = '';
    if (is_readable($dirName)) {
        $chmod = '可读,';
    }

    if (is_writable($dirName)) {
        $chmod .= '可写,';
    }

    if (is_executable($dirName)) {
        $chmod .= '可执行,';
    }

    return trim($chmod, ',');
}

/** 分解友情链接 */
function get_friend_link($baseConfig)
{
    if (!isset($baseConfig['friend_link']) || empty($baseConfig['friend_link'])) return false;

    $linksArr = explode("\n", $baseConfig['friend_link']);
    if (count($linksArr) < 1) return false;
    $linkList = [];
    foreach ($linksArr as $link) {
        $_arr = explode("|", $link);
        if (count($_arr) != 2) continue;
        $linkList[] = ['name' => $_arr[0], 'url' => str_replace(PHP_EOL, '', $_arr[1])];
    }
    return $linkList;
}

/** 兼容格式化时间 */
function safe_date($format = '', $timeStamp = '')
{

    $format = !empty($format) ? $format : 'Y/m/d';
    $timeStamp = !empty($timeStamp) ? $timeStamp : time();
    $date = new \DateTime('@' . $timeStamp);
    $date->setTimezone(new DateTimeZone('PRC'));

    return $date->format($format);
}

/**
 * 获取资源数据，为了方便前端获取数据
 * @author  rusheng
 * @param type 资源类型
 * @param limit 每页的数据条数
 * @param order 排序
 * @param where 查询条换
 * @param page 当前页数
 * @date    2018/2/2
 */
function get_content($param)
{
    $type = empty($param['type']) ? 'video' : $param['type'];
    $limit = empty($param['limit']) ? 20 : $param['limit'];
    $order = empty($param['order']) ? 'id desc' : $param['order'];
    $page = empty($param['page']) ? 1 : $param['page'];
    $start = ($page - 1) * $limit;
    $where = empty($param['where']) ? (($type == 'video') ? 'status = 1 and is_check=1  and pid = 0 ' : 'status = 1 and is_check=1 ') : $param['where'];
    $allowType = ['novel', 'video', 'atlas', 'image'];
    if (!in_array($type, $allowType)) return '资源类型不存在';
    $list = db::name($type)->where($where)->order($order)->limit($start, $limit)->select();
    return $list;
}

/**
 * 分销商提成计算
 * @author  rusheng
 * @param id  初始传入消费者id
 * @param gold 消费总金币数
 * @date    2018/3/1
 */
function distributor_divide($param)
{
    $divide_arr = array(
        '1' => 'three_level_distributor',
        '2' => 'second_level_distributor',
        '3' => 'one_level_distributor',
    );
    $i = isset($param['i']) ? $param['i'] : 1;
    $id = $param['id'];
    $gold = $param['gold'];
    //$gold = get_config('gold_exchange_rate');
    $userinfo = db::name('member')->where(array('id' => $id))->field('pid')->find();
    if (!empty($userinfo['pid']) && $i <= 3) {
        $status = 1;
        if ($i == 1) {
            $three_level_distributor_on = get_config('three_level_distributor_on');
            if ($three_level_distributor_on != 1) {
                $agent_id = empty(session("cur_agent_id")) ? 0 : session("cur_agent_id");
                if ($agent_id == $userinfo['pid']) {
                    $status = 0;
                }
            }
        }
        if ($status == 1) {
            $divide = get_config($divide_arr[$i]);
            if ($divide) {
                $result = ceil($gold * $divide / 100);
                db::name('member')->where(array('id' => $userinfo['pid']))->setInc('money', $result);
                $gold_log_data = array(
                    'user_id' => $userinfo['pid'],
                    'gold' => $result,
                    'module' => 'distributor',
                    'explain' => '分销提成'
                );
                write_gold_log($gold_log_data);
            }
        }
        $i++;
        distributor_divide(array('id' => $userinfo['pid'], 'gold' => $gold, 'i' => $i));
    }
}

/** 将内容生成二维码 */
function create_qr_cdoe($content)
{
    $coder = new Endroid\QrCode\QrCode($content);
    $coder->setErrorCorrectionLevel(Endroid\QrCode\ErrorCorrectionLevel::HIGH);
    header('Content-Type: ' . $coder->getContentType());
    echo $coder->writeString();
}

/** 判断微信端 */
function is_wechat()
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    if (strpos($user_agent, 'MicroMessenger') === false) {
        return false;
    } else {
        // 获取版本号
        #preg_match('/.*?(MicroMessenger\/([0-9.]+))\s*/', $user_agent, $matches);
        #echo '<br>Version:'.$matches[2];
        return true;
    }
}

/** 获取微信Openid */
function get_user_wechat_openid($appid, $secretKey)
{
    if (session('wx_openid')) return session('wx_openid');
    $request = request();
    $curUrl = $request->domain() . $request->url();
    if (!$request->param('code/s')) {
        $apiUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$curUrl}&response_type=code&scope=snsapi_base&state=test#wechat_redirect";
        header("Location:{$apiUrl}");
        exit;
    } else {
        $code = $request->param('code/s');
        $apiUrl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$secretKey}&code={$code}&grant_type=authorization_code";

        try {
            $rs = (file_get_contents($apiUrl));
            $wxOpenid = json_decode($rs, true)['openid'];
            session('wx_openid', $wxOpenid);
        } catch (\Exception $exception) {
            return false;
        }
        return session('wx_openid');
    }


}