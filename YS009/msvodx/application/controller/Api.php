<?php
/**
 * Api接口层
 * LastDate:    2017/11/27
 */

namespace app\controller;

use app\model\Atlas;
use app\model\Image;
use think\captcha\Captcha;
use phpmailer\SendEmail;
use sms\Sms;
use think\Controller;
use think\Request;
use think\Db;

class Api extends Controller
{

    public function __construct(Request $request)
    {
        //$origin=$request->header('origin'); //"http://sp.msvodx.com"
        //$allowDomain=['msvodx.com','meisicms.com'];

        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With');

        $noAuthAct = ['getatlas', 'getcaptcha', 'givegood',
            'delcollection', 'control_imgs', 'collect_atlas',
            'is_login', 'rewardranking', 'getthemeinfos', 'createqrcode'
        ];

        if (!in_array(strtolower($request->action()), $noAuthAct)) {
            if ($request->isPost() && $request->isAjax()) {

            } else {
                $returnData = ['statusCode' => '4001', 'error' => '请求方式错误'];
                die(json_encode($returnData, JSON_UNESCAPED_UNICODE));
            }
        }
    }

    public function _empty()
    {
        $returnData = ['statusCode' => '4001', 'error' => '请求接口不存在'];
        die(json_encode($returnData, JSON_UNESCAPED_UNICODE));
    }


    /**
     * 获取用户收藏相册API
     */
    function getatlas()
    {
        $user_id = session('member_id');
        $atlas_list = null;
        if (intval($user_id) > 0) {
            $atlas_list = Db::name('user_atlas')->where(['user_id' => $user_id])->order('add_time', 'desc')->select();
            if (empty($atlas_list)) {
                die(json_encode(['resultCode' => 1, 'message' => '用户没有图册']));
            }
            die(json_encode(['resultCode' => 0, 'data' => $atlas_list, 'message' => "谢谢你,打赏成功"]));
        } else {
            die(json_encode(['resultCode' => 4005, 'error' => '请登录后再试！']));
        }
    }

    /**
     * 获取用户打赏排名
     */
    function rewardranking()
    {
        $num = get_config('reward_num');
        $reward_result = Db::name('gratuity_record')->group('user_id')->order('sums desc')->limit(0, $num)->field('SUM(price) as sums,user_id')->select();
        foreach ($reward_result as $k => $v) {
            $mamber_info = Db::name('member')->where(['id' => $v['user_id']])->field('id,nickname,headimgurl')->find();
            $reward_result[$k]['nickname'] = $mamber_info['nickname'];
            $reward_result[$k]['headimgurl'] = $mamber_info['headimgurl'];
            $reward_result[$k]['no'] = $k + 1;
        }
        if (!$reward_result) {
            die(json_encode(['resultCode' => 4003, 'error' => '还没有人打赏！']));
        }
        die(json_encode(['resultCode' => 0, 'data' => $reward_result, 'message' => "获取成功"]));
    }

    /**
     * 扣费接口资讯和收费
     */
    function permit(Request $request)
    {
        $id = $request->param('id/d');
        $type = $request->param('type/d');
        $user_id = session('member_id');
        //验证登陆
        $login_status = check_is_login();
        if ($login_status['resultCode'] != 1) die(json_encode(['resultCode' => 4005, 'error' => $login_status['error']]));
        if ($id <= 0 || $type <= 0) {
            die(json_encode(['resultCode' => 4003, 'error' => '缺少请求参数。']));
        }
        $table = '';
        $s = '';
        if ($type == 3) {
            $table = Db::name('novel');
            $db = Db::name('novel_watch_log');
            $type = 'novel';
            $s = '小说';
        } elseif ($type == 2) {
            $table = Db::name('atlas');
            $db = Db::name('atlas_watch_log');
            $type = 'atlas';
            $s = '图片';
        } else {
            die(json_encode(['resultCode' => 5002, 'error' => '非法请求,参数有误。']));
        }
        $info = $table->where(['id' => $id])->find();
        if ($info) {
            $memberModel = model('member')->get($user_id);
            $memberInfo = $memberModel->toArray();
            if (isset($memberInfo['money']) && $memberInfo['money'] >= $info['gold']) {
                $memberModel->money -= $info['gold'];
                $decMoneyRs = $memberModel->save();
                if (!$decMoneyRs) {
                    die(json_encode(['resultCode' => 5002, 'error' => '出错啦，扣费失败！']));
                };
                //作者分成
                author_divide($type, $id);
                //用户消费金币变动记录
                Db::name('gold_log')->data(['user_id' => session('member_id'), 'gold' => "-{$info['gold']}", 'add_time' => time(), 'module' => $type, 'explain' => $s . '内容扣费'])->insert();
                $db->data(["{$type}_id" => $id, 'user_id' => session('member_id'), 'user_ip' => $request->ip(), 'view_time' => time(), 'gold' => $info['gold'], 'is_try_see' => 0])->insert();
                die(json_encode(['resultCode' => 0, 'message' => '购买成功，正在为您加载……']));
            } else {
                die(json_encode(['resultCode' => 5002, 'error' => '你的金币不足,请充值后再试！']));
            }
        } else {
            die(json_encode(['resultCode' => 5002, 'error' => '该资讯可能被删除啦！']));
        }
    }

    /**
     * 打赏礼物api
     * itemid 礼物id ,itemprice 礼物价格，projectid 打赏目标id ,type 类型ID
     **/
    public function reward(Request $request)
    {
        $user_id = session('member_id');
        //验证登陆
        $login_status = check_is_login();
        if ($login_status['resultCode'] != 1) die(json_encode(['resultCode' => 4005, 'error' => $login_status['error']]));
        //判断用户参数是否合法
        $itemid = $request->post('itemid/d');
        $itemprice = $request->post('itemprice/d');
        $projectid = $request->post('projectid/d');
        $type = $request->post('type/d');
        if ($itemid <= 0 || $projectid <= 0 || $type <= 0) {
            die(json_encode(['resultCode' => 4003, 'error' => '缺少请求参数。']));
        }
        //判断礼物是否存在
        $gift_info = Db::name('gift')->where(['id' => $itemid, 'price' => $itemprice, 'status' => 1])->field('id,name,images,price,info')->find();
        if (empty($gift_info)) die(json_encode(['resultCode' => 5002, 'error' => "打赏的礼物不{$itemid}存在！{$itemprice}"]));
        //判断用户金币是否足够
        $user_info = model('member')->get($user_id);
        if (intval($user_info->money) < intval($gift_info['price'])) die(json_encode(['resultCode' => 5002, 'error' => '你的金币不足']));
        //打赏记录入库
        $gift_data = [
            'user_id' => $user_id,
            'gratuity_time' => time(),
            'content_type' => $type,
            'content_id' => $projectid,
            'gift_info' => json_encode($gift_info),
            'price' => intval($gift_info['price'])
        ];
        $result = Db::name('gratuity_record')->insert($gift_data);
        if ($result) {
            $user_info->money = $user_info->money - $gift_info['price'];
            $user_info->save();
        }
        //统计该视频的打赏
        $gratuity = Db::name('gratuity_record')->where(['content_type' => $type, 'content_id' => $projectid])->select();
        $count = Db::name('gratuity_record')->where(['content_type' => $type, 'content_id' => $projectid])->field(" count(distinct user_id) as count ")->find();
        $gold_log_data = array(
            'user_id' => $user_id,
            'gold' => '-' . intval($gift_info['price']),
            'module' => 'reward',
            'explain' => '打赏消费'
        );
        write_gold_log($gold_log_data);
        $count_price = 0;
        foreach ($gratuity as $k => $v) {
            $json_relust = json_decode($v['gift_info']);
            $count_price = $json_relust->price + $count_price;
        }
        $returndata = ['countprice' => $count_price, 'counts' => $count['count']];
        die(json_encode(['resultCode' => 0, 'data' => $returndata, 'message' => "谢谢你,打赏成功"]));
    }

    //检测登录
    public function is_login()
    {
        $user_id = session('member_id');
        $access_token = session('access_token');
        //验证登陆
        if (intval($user_id) <= 0) die(json_encode(['resultCode' => 4005, 'error' => '用户未登陆']));
        $user_info = db::name('member')->where(array('id' => $user_id, 'access_token' => $access_token))->find();
        if (!$user_info) {
            session('member_id', '0');
            session('member_info', '');
            session('access_token', '');
            die(json_encode(['resultCode' => 4005, 'error' => '该用户已在其他地方登陆']));
        }
        die(json_encode(['resultCode' => 0, 'message' => '用户已经登录']));
    }

    //用户收藏照片到用户相册内
    public function collect_atlas(Request $request)
    {
        $user_id = session('member_id');
        //验证登陆
        $login_status = check_is_login();
        if ($login_status['resultCode'] != 1) die(json_encode(['resultCode' => 4005, 'error' => $login_status['error']]));
        $atlasid = $request->param('atlasid/d');
        $collectid = $request->param('collectid/d');
        if ($atlasid <= 0 || $collectid <= 0) {
            die(json_encode(['resultCode' => 5002, 'error' => '非法请求,参数有误。']));
        }
        $imagecolle = Db::name('image_collection');
        $info = $imagecolle->where(['user_id' => $user_id, 'image_id' => $collectid, 'atlas_id' => $atlasid])->find();
        if (!$info) {
            $data = [
                'user_id' => $user_id,
                'image_id' => $collectid,
                'collection_time' => time(),
                'atlas_id' => $atlasid
            ];
            $result = $imagecolle->insert($data);
            if ($result) {
                die(json_encode(['resultCode' => 0, 'message' => '收藏成功']));
            }
            die(json_encode(['resultCode' => 5002, 'error' => '收藏失败']));
        }
        die(json_encode(['resultCode' => 5002, 'error' => '你已经收藏过了']));
    }


    /***
     * 用户新建图册,修改相册
     */
    public function control_imgs(Request $request)
    {
        $imgsname = $request->param('name/s');
        $type = $request->param('type/s');
        $user_id = session('member_id');
        //验证登陆
        $login_status = check_is_login();
        if ($login_status['resultCode'] != 1) die(json_encode(['resultCode' => 4005, 'error' => $login_status['error']]));
        if (empty(trim($imgsname))) {
            die(json_encode(['resultCode' => 5002, 'error' => '非法请求,参数有误。']));
        }
        if (empty(trim($type))) {
            die(json_encode(['resultCode' => 5002, 'error' => '非法请求,参数有误。']));
        }
        if ($type == '2') {
            $data = [
                'user_id' => $user_id,
                'title' => $imgsname,
                'add_time' => time()
            ];
            $result = Db::name("user_atlas")->insert($data);
            if ($result) {
                die(json_encode(['resultCode' => 0, 'message' => '创建成功']));
            }
            die(json_encode(['resultCode' => 5002, 'error' => '创建失败']));
        } elseif ($type == '1') {
            $id = $request->param('id/s');
            if (empty(trim($id))) {
                die(json_encode(['resultCode' => 5002, 'error' => '非法请求,参数有误。']));
            }
            $result = Db::name('user_atlas')->where(['user_id' => $user_id, 'id' => $id])->update(['title' => $imgsname]);
            if ($result) {
                die(json_encode(['resultCode' => 0, 'message' => '修改成功']));
            }
            die(json_encode(['resultCode' => 5002, 'error' => '请修改后提交']));
        }
    }

    /**
     * 收藏资讯视频相册
     * @param Request $request
     */
    public function delcollection(Request $request)
    {
        $type = $request->param('type/s');
        $id = $request->param('id/d', 0);
        $user_id = session('member_id');
        //验证登陆
        $login_status = check_is_login();
        if ($login_status['resultCode'] != 1) die(json_encode(['resultCode' => 4005, 'error' => $login_status['error']]));

        $allowType = ['novel', 'video', 'user_atlas', 'image'];
        if (!in_array($type, $allowType)) die(json_encode(['resultCode' => 5002, 'error' => '非法请求,参数有误。']));

        //执行资讯或者视频操作
        if (in_array($type, ['novel', 'video', 'image'])) {
            $arr = ["{$type}_id" => $id, 'user_id' => $user_id];
            if ($type == 'image') {
                $colle_id = $request->param('colle_id/d', 0);
                $arr['id'] = $colle_id;
            }

            $result = Db::name("{$type}_collection")->where($arr)->delete();
            if ($result) {
                die(json_encode(['resultCode' => 0, 'message' => '删除成功']));
            } else {
                die(json_encode(['resultCode' => 5002, 'error' => '删除失败']));
            }
        } elseif ($type == 'user_atlas') {//删除用户相册
            $results = Db::name("user_atlas")->where(["id" => $id])->delete();
            $result = Db::name("image_collection")->where(["id" => $id])->delete();
            if ($results) {
                die(json_encode(['resultCode' => 0, 'message' => '删除成功']));
            } else {
                die(json_encode(['resultCode' => 5002, 'error' => '删除失败']));
            }

        }

    }

    /*  登陆接口 */
    public function login(Request $request)
    {
        if (get_config('verification_code_on')) {
            $verifyCode = $request->post('verifyCode/s', '', '');
            if (!captcha_check($verifyCode)) die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败:验证码错误']));
        }
        $userName = $request->post('userName/s', '', '');
        $password = $request->post('password/s', '', '');

        if (empty($userName) || empty($password)) die(json_encode(['statusCode' => 4004, 'error' => '参数格式不正确:用户名或密码不能为空']));

        if ($loginRs = check_member_password($userName, $password)) {
            if (is_array($loginRs) && isset($loginRs['rs']) && isset($loginRs['msg'])) {
                die(json_encode(['statusCode' => 4005, 'error' => $loginRs['msg']]));
            }
            $user_id = session('member_id');
            $login_reward = get_config('login_reward');
            if ($login_reward) {
                $today = strtotime(date('Y-m-d'));
                $yesterday = $today + (24 * 3600 - 1);
                $where = "user_id =  $user_id and (login_time between $today and $yesterday)";
                $result = Db::name('login_log')->where($where)->find();
                if (empty($result)) {
                    Db::name('member')->where(array('id' => $user_id))->setInc('money', $login_reward);
                    $gold_log_data = array(
                        'user_id' => $user_id,
                        'gold' => $login_reward,
                        'module' => 'login',
                        'explain' => '登录奖励'
                    );
                    write_gold_log($gold_log_data);
                }
            }
            $log_data = array(
                'user_id' => $user_id,
                'login_time' => time(),
                'ip' => $request->ip(),
            );
            Db::name('login_log')->insert($log_data);

            Db::name('member')->update(['last_time' => time(), 'last_ip' => $request->ip(), 'id' => $user_id, 'login_count' => '+1']);
            $member = model('Member')->get($user_id);
            $member->last_time = time();
            $member->last_ip = $request->ip();
            $member->login_count++;
            $member->save();

            die(json_encode(['statusCode' => 0, 'message' => '登陆成功']));
        }

        die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败:用户名或密码不正确']));
    }

    /* 第三方登录绑定用户信息 */
    public function binding_third(Request $request)
    {
        $data['username'] = $request->post('username/s', '', '');
        $data['password'] = $request->post('password/s', '', '');
        $data['confirm_password'] = $request->post('confirm_password/s', '', '');
        if (empty($data['username']) || empty($data['password'])) die(json_encode(['statusCode' => 4004, 'error' => '参数格式不正确:用户名或密码不能为空']));
        if ($data['password'] != $data['confirm_password']) die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败:两次密码不一致']));


        $userdata['username'] = $data['username'];
        $result = $this->validate($data, 'Member.username_register');
        if ($result !== true) die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败:' . $result]));
        //添加账号处理
        $userdata['password'] = encode_member_password($data['password']);
        $userdata['last_time'] = $userdata['add_time'] = time();
        $userdata['pid'] = empty(session("cur_agent_id")) ? 0 : session("cur_agent_id");
        $member_id = session('member_id');
        if (db::name('member')->where(['id' => $member_id])->update($userdata)) {
            $register_reward = get_config('register_reward');
            if ($register_reward) {
                $gold_log_data = array(
                    'user_id' => $member_id,
                    'gold' => $register_reward,
                    'module' => 'register',
                    'explain' => '注册奖励'
                );
                write_gold_log($gold_log_data);
                Db::name('member')->where(array('id' => $member_id))->setInc('money', $register_reward);
            }
            check_member_password($userdata['username'], $data['password']);
            die(json_encode(['statusCode' => 0, 'error' => '绑定成功', 'memberId' => $member_id]));
        } else {
            die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败']));
        }
    }

    /* 注册 */
    public function register(Request $request)
    {
        $data['username'] = $request->post('username/s', '', '');
        $data['password'] = $request->post('password/s', '', '');
        $userdata['nickname'] = $data['nickname'] = $request->post('nickname/s', '', '');
        $data['verifyCode'] = trim($request->post('verifyCode/s', '', ''));         //邮箱or手机的验证码
        $data['confirm_password'] = $request->post('confirm_password/s', '', '');

        if (empty($data['username']) || empty($data['password'])) die(json_encode(['statusCode' => 4004, 'error' => '参数格式不正确:用户名或密码不能为空']));
        if ($data['password'] != $data['confirm_password']) die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败:两次密码不一致']));
        if (get_config('register_validate')) {
            if (empty($data['verifyCode'])) die(json_encode(['statusCode' => 4004, 'error' => '参数格式不正确:验证码不能为空']));
            $userType = get_str_format_type($data['username']);
            switch ($userType) {
                case 'email':
                    $userdata['username'] = $userdata['email'] = $data['email'] = $data['username'];
                    $session_name = 'register_email_code';
                    break;
                case 'mobile':
                    $userdata['username'] = $userdata['tel'] = $data['tel'] = $data['username'];
                    $session_name = 'register_mobile_code';
                    break;
            }
            $result = $this->validate($data, 'Member.' . $userType . '_register');
            if ($result !== true) die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败:' . $result]));
            //验证验证码
            $codeData = session($session_name);
            if (empty($codeData)) die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败:验证码错误']));
            if ($codeData['username'] != $data['username']) die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败:验证码错误']));
            if ($codeData['code'] != $data['verifyCode']) die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败:验证码错误']));
            if ($codeData['expiry_time'] < (time() - 60 * 30)) die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败:验证码过期']));
            session($session_name, null);
        } else {
            if (get_config('verification_code_on')) {
                $verifyCode = $request->post('verifyCode/s', '', '');
                if (!captcha_check($verifyCode)) die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败:验证码错误']));
            }
            $userdata['username'] = $data['username'];
            $result = $this->validate($data, 'Member.username_register');
            if ($result !== true) die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败:' . $result]));

        }

        //添加账号处理
        $userdata['headimgurl'] = '/static/images/user_dafault_headimg.jpg';
        $userdata['password'] = encode_member_password($data['password']);
        $userdata['last_time'] = $userdata['add_time'] = time();
        $userdata['pid'] = empty(session("cur_agent_id")) ? 0 : session("cur_agent_id");
        if (db::name('member')->insert($userdata)) {
            $member_id = Db::name('member')->getLastInsID();
            $register_reward = get_config('register_reward');
            if ($register_reward) {
                $gold_log_data = array(
                    'user_id' => $member_id,
                    'gold' => $register_reward,
                    'module' => 'register',
                    'explain' => '注册奖励'
                );
                write_gold_log($gold_log_data);
                Db::name('member')->where(array('id' => $member_id))->setInc('money', $register_reward);
            }
            check_member_password($userdata['username'], $data['password']);
            die(json_encode(['statusCode' => 0, 'error' => '注册成功', 'memberId' => $member_id]));
        } else {
            die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败']));
        }
    }

    /* 注册获取证码接口 */
    public function getRegisterCode(Request $request)
    {
        $username = $request->param('username/s', '', '');
        $userinfo = db::name('member')->where(array('username' => $username))->find();
        if (!empty($userinfo)) die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败: 该用户名已经存在']));
        $userType = get_str_format_type($username);
        if (empty($username)) die(json_encode(['statusCode' => 4003, 'error' => '缺少请求参数:用户名不能为空']));
        //$code = get_random_str(6);
        $code = rand(111111, 999999);
        $session_name = array(
            'email' => 'register_email_code',
            'mobile' => 'register_mobile_code',
        );
        $codeData = array(
            'username' => $username,
            'code' => $code,
            'expiry_time' => (time() + 5 * 60),
        );
        session($session_name[$userType], $codeData);
        switch ($userType) {
            case 'email':
//                    邮箱发送验证码处理
                $site_title = get_config('site_title');
                $SendEmail = new SendEmail();
                $param = array(
                    'email' => $username,
                    'username' => $username,
                    'subject' => $site_title . '注册验证邮件',
                    'body' => '亲爱的用户，您好!您注册验证码为<h2 style="color:green;">' . $code . '</h2>',
                );
                $msg = '请登录您的邮箱查看验证码';
                $SendEmail->send($param);
                break;
            case 'mobile':
                $Sms = new Sms();
                $param = array(
                    'tel' => $username,
                    'msg' => '【MSVOD】亲爱的用户，您好 ! 您注册验证码是： ' . $code,
                );
                $Sms->send($param);
                //手机发送验证码处理
                $msg = '请查看您的手机短信验证码';
                break;
        }
        die(json_encode(['statusCode' => 0, 'error' => '发送成功，' . $msg]));
    }

    /* 退出登陆接口 */
    public function logout(Request $request)
    {
        if (member_logout()) {
            die(json_encode(['statusCode' => 0, 'message' => '退出成功']));
        }
    }

    /**
     * 获取礼物列表接口
     * @param orders  排序的方式
     * @param  where 查询的条件
     * @param  field 查询的字段
     */
    public function getGift(Request $request)
    {
        $data = $request->post();
        $where = empty($data['where']) ? "status = 1" : $data['where'];
        $orders = empty($data['orders']) ? 'sort DESC' : $data['orders'];
        $field = empty($data['field']) ? 'id,name,images,price,info' : $data['field'];
        $list = Db::name('gift')->where($where)->order($orders)->field($field)->select();
        echo json_encode($list);
    }

    /**
     * 图片资讯视频收藏接口
     * @param type 1为视频，2为图片，3资讯
     * @param id    收藏id
     */
    public function colletion(Request $request)
    {
        $member_id = session('member_id');
        $type = $request->post('type/d', 0);
        $id = $request->post('id/d', 0);
        //验证登陆
        if (intval($member_id) <= 0) die(json_encode(['resultCode' => 4005, 'error' => '用户未登陆']));

        if (empty($type) || intval($type) <= 0 || empty($id) || intval($id) <= 0) {
            die(json_encode(['statusCode' => 4003, 'error' => '补足参数后重试']));
        }
        switch ($type) {
            case 1:
                $db = Db::name('video');
                $collect_db = Db::name('video_collection');
                //判断存如视频id是否存在
                $result_video = $db->where(['status' => 1, 'id' => $id])->find();
                if (empty($result_video)) {
                    die(json_encode(['resultCode' => 4005, 'error' => '当前视频不存在']));
                }
                //判断视频是否已经收藏
                $result_collect = $collect_db->where(['user_id' => $member_id, 'video_id' => $id])->find();
                if ($result_collect) {
                    die(json_encode(['resultCode' => 4005, 'error' => '该视频已经收藏过了']));
                }
                //插入用户收藏日志
                $collect_data = [
                    'user_id' => $member_id,
                    'video_id' => $id,
                    'collection_time' => $request->time()
                ];
                $insert_result = $collect_db->data($collect_data)->insert();
                if ($insert_result) {
                    die(json_encode(['resultCode' => 0, 'message' => '收藏成功']));
                } else {
                    die(json_encode(['resultCode' => 5002, 'error' => '收藏失败']));
                }
                break;
            case 2:
                $db = Db::name('image');
                $collect_db = Db::name('image_collection');
                //判断存如视频id是否存在
                $result_image = $db->where(['status' => 1, 'id' => $id])->find();
                if (empty($result_image)) {
                    die(json_encode(['resultCode' => 4005, 'error' => '当前图片不存在']));
                }
                //判断视频是否已经收藏
                $result_collect = $collect_db->where(['user_id' => $member_id, 'image_id' => $id])->find();
                if ($result_collect) {
                    die(json_encode(['resultCode' => 4005, 'error' => '该图片已经收藏过了']));
                }
                //插入用户收藏日志
                $collect_data = [
                    'user_id' => $member_id,
                    'image_id' => $id,
                    'collection_time' => $request->time()
                ];
                $insert_result = $collect_db->data($collect_data)->insert();
                if ($insert_result) {
                    die(json_encode(['resultCode' => 0, 'message' => '收藏成功']));
                } else {
                    die(json_encode(['resultCode' => 5002, 'error' => '收藏失败']));
                }
                break;
            case 3:
                $db = Db::name('novel');
                $collect_db = Db::name('novel_collection');
                //判断存如视频id是否存在
                $result_novel = $db->where(['status' => 1, 'id' => $id])->find();
                if (empty($result_novel)) {
                    die(json_encode(['resultCode' => 4005, 'error' => '当前资讯不存在']));
                }
                //判断视频是否已经收藏
                $result_collect = $collect_db->where(['user_id' => $member_id, 'novel_id' => $id])->find();
                if ($result_collect) {
                    die(json_encode(['resultCode' => 4005, 'error' => '该资讯已经收藏过了']));
                }
                //插入用户收藏日志
                $collect_data = [
                    'user_id' => $member_id,
                    'novel_id' => $id,
                    'collection_time' => $request->time()
                ];
                $insert_result = $collect_db->data($collect_data)->insert();
                if ($insert_result) {
                    die(json_encode(['resultCode' => 0, 'message' => '收藏成功']));
                } else {
                    die(json_encode(['resultCode' => 5002, 'error' => '收藏失败']));
                }
                break;
            default :
                die(json_encode(['resultCode' => 4004, 'error' => '请求参数错误']));
                break;
        }


    }

    /**
     * 验证码接口
     */

    public function getCaptcha()
    {
        return create_captcha();
    }

    /**
     * 点赞接口
     * @param resourceType  点赞资料对象类型：  image / novel / video
     * @param id            点赞对象id
     */
    public function giveGood(Request $request)
    {
        //验证登陆
        if (session('member_id') <= 0) die(json_encode(['resultCode' => 4005, 'error' => '用户未登陆']));

        $resourceType = $request->post('resourceType/s', '');
        $resourceId = $request->post('resourceId/d', 0);
        $allowType = ['atlas', 'novel', 'video'];
        $resourceTable = [
            'atlas' => 'atlas',
            'novel' => 'novel',
            'video' => 'video'
        ];

        $goodHistory = Db::name("{$resourceType}_good_log")->where(["{$resourceType}_id" => $resourceId, 'user_id' => session('member_id')])->find();
        if ($goodHistory) die(json_encode(['resultCode' => 4005, 'error' => '已点过赞.']));

        if (empty($resourceType)) die(json_encode(['resultCode' => 4003, 'error' => '缺少请求参数:resourceType ']));
        if ($resourceId <= 0) die(json_encode(['resultCode' => 4004, 'error' => '参数格式不正确:resourceId ']));
        if (!in_array($resourceType, $allowType)) die(json_encode(['resultCode' => 4004, 'error' => '参数格式不正确:resourceType只能是' . implode(',', $allowType) . '中的一个']));

        $resource = model($resourceTable[$resourceType]);
        $dataObj = $resource::get($resourceId);
        if (!$dataObj) die(json_encode(['resultCode' => 4005, 'error' => '数据验证失败:资源不存在.']));
        $dataObj->good += 1;
        $dataObj->save();


        //写入点赞日志表
        $goodLogData = [
            'add_time' => time(),
            $resourceTable[$resourceType] . '_id' => $resourceId,
            'user_id' => session('member_id'),
        ];

        $iRs = Db::name("{$resourceType}_good_log")->data($goodLogData)->insert();

        die(json_encode(['resultCode' => 0, 'message' => '点赞成功', 'data' => ['resourceId' => $dataObj->id, 'good' => $dataObj->good]]));

    }

    /**
     * 签到接口
     */
    function sign(Request $request)
    {
        if (session('member_id') <= 0) die(json_encode(['resultCode' => 4005, 'error' => '用户未登陆']));
        $user_id = session('member_id');
        if (isSign()) die(json_encode(['resultCode' => 4005, 'error' => '您今天已经签过了，请明天再签']));
        //判断当前用户是否已经签到
        $sign_reward = get_config('sign_reward');
        if (!empty($sign_reward)) {
            Db::name('member')->where(array('id' => $user_id))->setInc('money', $sign_reward);
            $gold_log_data = array(
                'user_id' => $user_id,
                'gold' => $sign_reward,
                'module' => 'sign',
                'explain' => '签到奖励'
            );
            write_gold_log($gold_log_data);
        } else {
            $sign_reward = 0;
        }
        $signData = array(
            'user_id' => $user_id,
            'sign_time' => time(),
        );
        Db::name('sign')->insert($signData);

        die(json_encode(['resultCode' => 0, 'data' => array('value' => $sign_reward), 'message' => '签到成功']));
    }


    /**
     * 评论接口
     * @param resourceType  评论资料对象类型： 2/3/1  image / novel / video  图片/资讯/视频
     * @param resourceId       资源对象id
     * @param content           内容
     * @param to_user            被评论者（可为空）
     */
    function comment(Request $request)
    {
        $wheres = "name in ('comment_on','comment_examine_on')";
        $config = Db::name('admin_config')->where($wheres)->column('name,value');
        if ($config['comment_on'] != 1) die(json_encode(['resultCode' => 4005, 'error' => '当前暂未支持评论']));
        if (session('member_id') <= 0) die(json_encode(['resultCode' => 4005, 'error' => '用户未登陆']));

        $resourceType = $request->post('resourceType/d', '1');
        $resourceId = $request->post('resourceId/d', 0);
        $content = $request->post('content/s', '');
        $content = htmlspecialchars(trim($content), ENT_QUOTES);
        $to_user = $request->post('to_user/s', '');
        $insertData = [
            'add_time' => time(),
            'last_time' => time(),
            'resources_type' => $resourceType,
            'resources_id' => $resourceId,
            'content' => $content,
            'send_user' => session('member_id'),
            'to_user' => $to_user,
        ];
        if (empty($config['comment_examine_on'])) {
            $data['comment_examine_on'] = 0;
            $insertData['status'] = 1;
            $message = '评论成功';
        } else {
            $data['comment_examine_on'] = 1;
            $insertData['status'] = 0;
            $message = '评论成功,待审核后才显示';
        }
        $insertData['status'] = empty($config['comment_examine_on']) ? 1 : 0;
        $insert_result = Db::name("comment")->data($insertData)->insert();
        if ($insert_result) {
            $data['userinfo'] = session('member_info');
            $data['content'] = $content;
            die(json_encode(['resultCode' => 0, 'data' => $data, 'message' => $message]));
        } else {
            die(json_encode(['resultCode' => 5002, 'error' => '评论失败']));
        }
    }

    /**
     * 评论列表接口
     * @param resourceType  评论资料对象类型： 2/3/1  image / novel / video  图片/资讯/视频
     * @param resourceId       资源对象id
     * @param limit       请求的数量
     * @param page      当前的页数，默认为0
     */
    function getCommentList(Request $request)
    {
        $resourceType = $request->post('resourceType/d', '1');
        $resourceId = $request->post('resourceId/d', 25);
        $limit = $request->post('limit/d', 8);
        $page = $request->post('page/d', 0);
        $where = "status = 1 and  resources_type = $resourceType and resources_id = $resourceId";
        $order = 'last_time desc';
        $start = $limit * $page;
        $end = $start + $limit;
        $field = 'id,send_user,content,last_time';
        $list = Db::view('comment', $field)
            ->view('member', 'username,headimgurl,nickname', 'comment.send_user=member.id', 'LEFT')
            ->where('comment.' . $where)
            ->limit($start, $limit)
            ->order($order)
            ->select();
        //$list = Db::name("comment")->where($where)->order($order)->limit($start,$limit)->field($field)->select();
        $count = Db::name("comment")->where($where)->count();
        $data['count'] = $count;
        $data['isMore'] = ($count > $end) ? 1 : 0;
        if (!empty($list)) {
            $data['list'] = $list;
            die(json_encode(['resultCode' => 0, 'data' => $data, 'message' => '加载完成']));
        } else {
            die(json_encode(['resultCode' => 0, 'data' => $data, 'message' => '没用更多数据了']));
        }

    }

    /* 获取标签接口 */
    function getTags(Request $request)
    {
        $allowType = ['image', 'novel', 'video'];
        $resourceType = $request->post('resourceType/s', '');
        if (!in_array($resourceType, $allowType)) die(json_encode(['resultCode' => 4004, 'error' => '参数格式不正确:resourceType,只能是' . implode(',', $allowType) . '中的一个.']));
    }

    /**
     * 视频播放接口
     * @author Dreamer
     * @param Request $request
     */
    function payVideo(Request $request)
    {
        $videoId = $request->post('id/d', 0);
        if (!$videoId) die(json_encode(['resultCode' => 4004, 'error' => '参数格式不正确:id']));
        $videoInfo = Db::name('video')->where(['id' => $videoId])->find();
        //视频密钥
        $videoInfo['url'] .= "?sign=" . create_yzm_play_sign();

        if (!$videoInfo) die(json_encode(['resultCode' => 4005, 'error' => '视频资源不存在.']));

        $surePlay = $request->post('surePlay/d', 0);

        //视频播放权限验证
        $authRs = check_video_auth($videoInfo);

        //播放剩余次/秒数
        $remainderTrySee = get_remainder_try_see();
        $freePlayInfo = [];
        if (is_array($remainderTrySee)) {
            $freePlayInfo['freeType'] = 2;    //按秒数
            $freePlayInfo['freeNum'] = $remainderTrySee['look_at_num'];
        }

        if (is_numeric($remainderTrySee)) {
            $freePlayInfo['freeType'] = 1;    //按部
            $freePlayInfo['freeNum'] = $remainderTrySee;
        }

        if (isset($authRs['result'])) {
            //result=>1:正常观看  2:需要扣金币观看，且金币够扣  3:需扣金币观看，且金币不够扣  4:视频收费，但未登陆
            $returnData = [];
            switch ($authRs['result']) {
                case 1:
                    $returnData = ['resultCode' => 0, 'message' => '正常播放', 'data' => ['rs' => 1, 'videoInfo' => $videoInfo]];
                    break;
                case 2:
                    $returnData = ['resultCode' => 0, 'message' => '可扣费播放', 'data' => ['rs' => 2, 'videoInfo' => $videoInfo, 'memberInfo' => $authRs['memberInfo']]];
                    break;
                case 3:
                    $returnData = ['resultCode' => 0, 'message' => '金币不足扣费,请充值后观看', 'data' => ['rs' => 3, 'videoInfo' => $videoInfo, 'memberInfo' => $authRs['memberInfo']]];
                    break;
                case 4:
                    $returnData = ['resultCode' => 0, 'message' => '视频需要付费,请登陆后观看', 'data' => ['rs' => 4, 'videoInfo' => $videoInfo]];
                    break;
            }
            //TODO 防止IOS+UC试看问题,无法识别UC浏览器
            /***视频地址加截部分视频资源（防止IOS+UC试看问题）******************$dreamer 2018/1/9****************************/
            if (in_array($authRs['result'], [2, 3, 4]) && get_config('look_at_measurement') == 2 && $request->isMobile()) {
                #$returnData['data']['videoInfo']['url'].="%26end=".(get_config('look_at_num'));
            }
            /***视频地址加截部分视频资源（防止IOS+UC试看问题）**************************************************************/

            if (isset($returnData['data'])) $returnData['data'] = array_merge($returnData['data'], $freePlayInfo);

            if (!$surePlay) {
                //返回播放前处理数据
                die(json_encode($returnData));
            } else {
                $successFlag = false;

                if ($request->post('isTrySee') == 'true') {
                    //试看
                    $successFlag = insert_watch_log('video', $returnData['data']['videoInfo']['id'], 0, true, $videoInfo['user_id']);
                } else {
                    //扣费观看
                    $successFlag = insert_watch_log('video', $returnData['data']['videoInfo']['id'], $returnData['data']['videoInfo']['gold'], false, $videoInfo['user_id']);
                }

            }

            if ($successFlag) {
                die(json_encode(['resultCode' => 0, 'message' => '记录写入成功', 'data' => $returnData['data']]));
            } else {
                die(json_encode(['resultCode' => 4005, 'error' => '记录写入时发生异常']));
            }
        }
    }

    /**
     * 删除接口
     * @param table     数据库
     * @param pk        对象主键，可以是单值或数组 如 id = 1 or id = [1,2] or id = array(1,2,3)
     */
    public function del(Request $request)
    {
        if (session('member_id') <= 0) die(json_encode(['resultCode' => 4005, 'error' => '用户未登陆']));
        $id = $request->post('id/d', 0);
        $type = $request->post('type/d', 0);
        $table = $request->post('table/s', '');
        $arr = ['images', 'atlas', 'video', 'novel'];
        if (!in_array($table, $arr)) {
            die(json_encode(['resultCode' => 5002, 'error' => '非法请求']));
        }
        if (empty($id)) die(json_encode(['resultCode' => 4003, 'error' => '缺少请求参数:id']));
        if (empty($table)) die(json_encode(['resultCode' => 4003, 'error' => '缺少请求参数:table']));
        // 获取主键
        $pk = Db::name($table)->getPk();
        $map = [];
        $map[$pk] = ['in', $id];
        if ($type == 0) {
            $map['user_id'] = session('member_id');
        }
        $res = Db::name($table)->where($map)->delete();

        /* 已在改良方法中实现
        //删除对应的收藏表  2018/01/16 $dreamer
        $needSycDel=[
            'video'=>['table'=>'video_collection','key'=>'video_id'],
            'images'=>['table'=>'image_collection','key'=>'image_id'],
            'video'=>['table'=>'novel_collection','key'=>'novel_id'],
        ];

        if(in_array($table,array_keys($needSycDel))){
            Db::name($needSycDel[$table]['table'])->where($needSycDel[$table]['key']."_id={$id}")->delete();
        }
        */

        if ($res === false) {
            die(json_encode(['resultCode' => 4005, 'message' => '数据验证失败']));
        }
        die(json_encode(['resultCode' => 0, 'message' => '删除成功']));
    }

    /**
     * 修改用户信息
     * @param key     要修改的字段
     * @param value    要修改的值
     */
    public function editUserInfo(Request $request)
    {
        if (session('member_id') <= 0) die(json_encode(['resultCode' => 4005, 'error' => '用户未登陆']));
        $key = $request->post('key');
        $value = $request->post('value');
        if (empty($key)) die(json_encode(['resultCode' => 4003, 'error' => '缺少请求参数:key']));
        if (empty($value)) die(json_encode(['resultCode' => 4003, 'error' => '缺少请求参数:value']));
        $allow = ['sex', 'nickname', 'headimgurl', 'email', 'tel'];   //$dreamer add 'email' 171221
        if (!in_array($key, $allow)) die(json_encode(['resultCode' => 5002, 'error' => '非法请求,参数有误。']));
        $member_info = db::name('member')->where(array('id' => session('member_id')))->find();
        if ($member_info[$key] == $value) die(json_encode(['resultCode' => 4005, 'error' => '数据未修改']));
        $member_info[$key] = $value;
        //.当修改的是用户昵称的时候，判断当前昵称是否已经存在
        if ($key == 'nickname') {
            $isset = db::name('member')->where(array('nickname' => $value))->find();
            if ($isset) die(json_encode(['resultCode' => 4005, 'error' => '该用户昵称已经被占用']));
        }
        db::name('member')->where(array('id' => session('member_id')))->update(array($key => $value));
        session('member_info', $member_info);
        die(json_encode(['resultCode' => 0, 'message' => '修改成功']));
    }

    /**
     * 代理商申请接口
     */
    public function agentApply()
    {
        if (session('member_id') <= 0) die(json_encode(['resultCode' => 4005, 'error' => '用户未登陆']));
        $user_info = db::name('member')->where(array('id' => session('member_id')))->find();
        if ($user_info['is_agent'] == 1) die(json_encode(['resultCode' => 4005, 'error' => '您已经是代理商了']));
        $apply = db::name('agent_apply')->where(array('user_id' => session('member_id')))->find();
        if (!empty($apply)) die(json_encode(['resultCode' => 4005, 'error' => '您已经申请过了，不能重复申请！']));
        $data = array(
            'user_id' => session('member_id'),
            'apply_time' => time(),
            'last_time' => time(),
        );
        db::name('agent_apply')->insert($data);
        die(json_encode(['resultCode' => 0, 'message' => '申请成功']));
    }

    /** 用户邮箱验证码/更换邮箱的验证码发送 */
    public function member_email_send(Request $request)
    {
        $toMail = strtolower($request->post('email/s', ''));
        $sendType = $request->post('type/s', 'checkOld');
        if (empty(session('last_send_member_mail_time_' . $sendType)) || session('last_send_member_mail_time_' . $sendType) < time() - 30) {
            $memberId = session('member_id');
            if ($memberId <= 0) die(json_encode(['resultCode' => 4005, 'message' => '请登陆后操作.']));
            switch ($sendType) {
                case 'checkOld':
                    $inputMail = $toMail;
                    if (empty($inputMail)) die(json_encode(['resultCode' => 4003, 'error' => '缺少请求参数:email']));
                    $rs = Db::name('member')->where(['id' => $memberId])->field('email')->find();
                    if (!$rs) die(json_encode(['resultCode' => 4005, 'message' => '数据验证失败']));   //用户不存在
                    $checkRs = $inputMail == strtolower($rs['email']);
                    if (!$checkRs) die(json_encode(['resultCode' => 4005, 'message' => '邮箱不匹配']));

                    $memberInfo = Db::name('member')->where(['id' => $memberId])->field('email')->find();
                    if (!$memberInfo || $memberInfo['email'] != $toMail)
                        die(json_encode(['resultCode' => 4005, 'message' => '用户或邮箱未在本系统注册过,系统将不会发送邮件.']));

                    $checkMailCode = rand(11111, 99999);
                    session('member_mail_old_check_code', $checkMailCode);
                    session('last_send_member_mail_time_' . $sendType, time());
                    SendEmail::send([
                        'email' => $memberInfo['email'],
                        'username' => 'username',
                        'subject' => '邮箱变更验证码',
                        'body' => '亲爱的会员，您好！您正在进行邮箱更换操作，安全验证码为：<h2>' . $checkMailCode . '</h2><br />如果不是您自己操作，请无视。'
                    ]);
                    die(json_encode(['resultCode' => 0, 'message' => '验证邮件已发送']));
                    break;

                case 'authNew':
                    $memberInfo = Db::name('member')->where(['email' => $toMail])->field('email')->find();
                    if ($memberInfo)
                        die(json_encode(['resultCode' => 4005, 'message' => '此邮箱已被绑定，请使用其他重试.']));

                    $checkMailCode = rand(11111, 99999);
                    session('member_mail_new_auth_code', $checkMailCode);
                    session('last_send_member_mail_time_' . $sendType, time());
                    SendEmail::send([
                        'email' => $toMail,
                        'username' => 'username',
                        'subject' => '邮箱绑定验证码',
                        'body' => '亲爱的会员，您好！您正在进行邮箱绑定操作，安全验证码为：<h2>' . $checkMailCode . '</h2><br /><i>如果不是您自己操作，请无视。</i>'
                    ]);
                    die(json_encode(['resultCode' => 0, 'message' => '验证邮件已发送']));
                    break;
            }
        }
        die(json_encode(['resultCode' => 4005, 'message' => '系统限制30秒内只能发送一封邮件']));

    }

    /** 用户手机验证码/更换手机的验证码发送 */
    public function member_mobile_send(Request $request)
    {
        $toMobile = strtolower($request->post('mobile', ''));
        $sendType = $request->post('type/s', 'checkOld');
        if (empty(session('last_send_member_mobile_time_' . $sendType)) || session('last_send_member_mobile_time_' . $sendType) < time() - 30) {
            $memberId = session('member_id');
            if ($memberId <= 0) die(json_encode(['resultCode' => 4005, 'message' => '请登陆后操作.']));
            switch ($sendType) {
                case 'checkOld':
                    $status = 1;
                    $inputMobile = $toMobile;
                    if (empty($inputMobile)) die(json_encode(['resultCode' => 4003, 'error' => '缺少请求参数:mobile']));
                    $rs = Db::name('member')->where(['id' => $memberId])->field('tel')->find();
                    if (!$rs) die(json_encode(['resultCode' => 4005, 'message' => '数据验证失败']));   //用户不存在
                    $checkRs = $inputMobile == strtolower($rs['tel']);
                    if (!$checkRs) die(json_encode(['resultCode' => 4005, 'message' => '手机号码不匹配']));
                    $checkMailCode = rand(111111, 999999);
                    session('member_mobile_old_check_code', $checkMailCode);
                    session('last_send_member_mobile_time_' . $sendType, time());
                    $smsdata = array(
                        'tel' => $rs['tel'],
                        'msg' => '【MSVOD】亲爱的用户，您好 !您正在进行手机更换操作，安全验证码为： ' . $checkMailCode
                    );
                    break;

                case 'authNew':
                    $status = 1;
                    $memberInfo = Db::name('member')->where(['tel' => $toMobile])->field('tel')->find();
                    if ($memberInfo)
                        die(json_encode(['resultCode' => 4005, 'message' => '此手机号码已被绑定，请使用其他重试.']));

                    $checkMailCode = rand(111111, 999999);
                    session('member_mobile_new_auth_code', $checkMailCode);
                    session('last_send_member_mobile_time_' . $sendType, time());
                    $smsdata = array(
                        'tel' => $toMobile,
                        'msg' => '【MSVOD】亲爱的用户，您好 !您正在进行手机绑定操作，安全验证码为： ' . $checkMailCode
                    );
                    break;
            }
            if ($status == 1) {
                $sms = new Sms();
                $sms->send($smsdata);
            }
            die(json_encode(['resultCode' => 0, 'message' => '验证短信已发送']));
        }
        die(json_encode(['resultCode' => 4005, 'message' => '系统限制30秒内只能发送一封验证短信']));

    }

    /** 验证会员收到的手机验证码的正确性 **/
    function member_mobile_verify_code(Request $request)
    {
        $type = $request->post('type/s', 'checkOld');  //authNew
        $code = $request->post('code/s', '');
        $mobile = $request->post('mobile/s', '');
        $checkRs = null;
        if (empty($code) || empty($mobile)) die(json_encode(['resultCode' => 4005, 'message' => '参数不能为空: code/mobile']));
        switch ($type) {
            case 'checkOld':
                $checkRs = session('member_mobile_old_check_code') == $code;
                break;
            case 'authNew':
                $checkRs = session('member_mobile_new_auth_code') == $code;
                if ($checkRs) {
                    session('member_mobile_old_check_code', null);
                    session('member_mobile_new_auth_code', null);
                    $request->post(['key' => 'tel']);
                    $request->post(['value' => $mobile]);
                    $this->editUserInfo($request);
                }
                break;
        }
        if ($checkRs) die(json_encode(['resultCode' => 0, 'message' => '验证码正确']));
        die(json_encode(['resultCode' => 4005, 'message' => '验证码错误']));
    }

    /** 验证会员收到的邮箱验证码的正确性 **/
    function member_mail_verify_code(Request $request)
    {
        $type = $request->post('type/s', 'checkOld');  //authNew
        $code = $request->post('code/s', '');
        $mailUrl = $request->post('mail/s', '');
        $checkRs = null;
        if (empty($code) || empty($mailUrl)) die(json_encode(['resultCode' => 4005, 'message' => '参数不能为空: code/mail']));
        switch ($type) {
            case 'checkOld':
                $checkRs = session('member_mail_old_check_code') == $code;
                break;
            case 'authNew':
                $checkRs = session('member_mail_new_auth_code') == $code;
                if ($checkRs) {
                    session('member_mail_old_check_code', null);
                    session('member_mail_new_auth_code', null);

                    $request->post(['key' => 'email']);
                    $request->post(['value' => $mailUrl]);
                    $this->editUserInfo($request);
                }
                break;
        }

        if ($checkRs) die(json_encode(['resultCode' => 0, 'message' => '验证码正确']));
        die(json_encode(['resultCode' => 4005, 'message' => '验证码错误']));
    }

    /**
     * 找回密码获取证码接口
     * @param type     找回密码的方式 email or mobile
     * @param content       内容 邮箱地址 OR 手机号码
     */

    public function getFindPassWordCode(Request $request)
    {
        $content = $request->param('content/s', '', '');
        $type = $request->post('type/s', 'email');
        $userinfo = db::name('member')->where(array("$type" => $content))->find();
        $type_name = array(
            'email' => '邮箱',
            'tel' => '手机号',
        );
        $session_name = array(
            'email' => 'findpassword_email_code',
            'tel' => 'findpassword_mobile_code',
        );
        if (empty($content)) die(json_encode(['statusCode' => 4003, 'error' => '缺少请求参数:' . $type_name[$type] . '不能为空']));
        if (empty($userinfo)) die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败: 该' . $type_name[$type] . '未绑定用户账号']));
        $code = rand(111111, 999999);
        $codeData = array(
            'content' => $content,
            'code' => $code,
            'expiry_time' => (time() + 5 * 60),
        );
        session($session_name[$type], $codeData);
        switch ($type) {
            case 'email':
//                    邮箱发送验证码处理
                $site_title = get_config('site_title');
                $SendEmail = new SendEmail();
                $param = array(
                    'email' => $content,
                    'username' => $content,
                    'subject' => $site_title . '找回密码验证',
                    'body' => '亲爱的用户，您好!您正在进行找回密码操作，验证码为<h2>' . $code . '</h2><br /><i>如果不是您自己操作，请无视。</i>',
                );
                $msg = '请登录您的邮箱查看验证码';
                $SendEmail->send($param);
                break;
            case 'tel':
//                   手机发送验证码处理
                $msg = '请查看您的手机短信验证码';
                $smsdata = array(
                    'tel' => $content,
                    'msg' => '【MSVOD】亲爱的用户，您好 !您正在进行找回密码操作，安全验证码为： ' . $code
                );
                $sms = new Sms();
                $sms->send($smsdata);
                break;
        }
        die(json_encode(['statusCode' => 0, 'error' => $msg]));
    }

    /**
     * 找回密码获取证码接口
     * @param type     找回密码的方式 email or mobile
     * @param content       内容 邮箱地址 OR 手机号码
     */
    public function checkPassWordCode(Request $request)
    {
        $content = $request->param('content/s', '', '');
        $code = $request->param('code/s', '', '');
        $type = $request->post('type/s', 'email');
        $type_name = array(
            'email' => '邮箱',
            'tel' => '手机号',
        );
        $session_name = array(
            'email' => 'findpassword_email_code',
            'tel' => 'findpassword_mobile_code',
        );
        if (empty($content)) die(json_encode(['statusCode' => 4003, 'message' => '缺少请求参数:' . $type_name[$type] . '不能为空']));
        if (empty($code)) die(json_encode(['statusCode' => 4005, 'message' => '验证码不能为空']));
        //验证验证码
        $codeData = session($session_name[$type]);
        if (empty($codeData)) die(json_encode(['statusCode' => 4005, 'message' => '数据验证失败:验证码错误']));
        if ($codeData['content'] != $content) die(json_encode(['statusCode' => 4005, 'message' => '数据验证失败:验证码错误']));
        if ($codeData['code'] != $code) die(json_encode(['statusCode' => 4005, 'message' => '数据验证失败:验证码错误']));
        if ($codeData['expiry_time'] < (time() - 60 * 30)) die(json_encode(['statusCode' => 4005, 'message' => '数据验证失败:验证码过期']));
        session($session_name[$type], null);
        die(json_encode(['statusCode' => 0, 'message' => '验证码正确']));
    }

    /**
     * 会员中心、金币记录
     * */
    function record_gold(Request $request)
    {
        $limit = $request->post('limit/d', 8);
        $offset = $request->post('offset/d', '0');
        $page = $request->post('page/d', 0);
        $user_id = session('member_id');
        //验证登陆
        $login_status = check_is_login();
        if ($login_status['resultCode'] != 1) die(json_encode(['resultCode' => 4005, 'error' => $login_status['error']]));
        $count = Db::name('gold_log')->where(['user_id' => $user_id])->order('add_time', 'desc')->count();
        $data['count'] = $count;
        $start = ($limit * $page) + $offset;
        $data_list = Db::name('gold_log')->where(['user_id' => $user_id])->order('add_time', 'desc')->limit($start, $limit)->select();
        if (!empty($data_list)) {
            $data['list'] = $data_list;
            die(json_encode(['resultCode' => 0, 'data' => $data, 'message' => '加载完成']));
        } else {
            die(json_encode(['resultCode' => 0, 'data' => $data, 'message' => '没用更多数据了']));
        }
    }

    //会员中心、充值记录
    public function record_pay(Request $request)
    {
        $limit = $request->post('limit/d', 8);
        $offset = $request->post('offset/d', '0');
        $page = $request->post('page/d', 0);
        $user_id = session('member_id');
        //验证登陆
        $login_status = check_is_login();
        if ($login_status['resultCode'] != 1) die(json_encode(['resultCode' => 4005, 'error' => $login_status['error']]));
        $count = Db::name('order')->where(['user_id' => $user_id])->order('add_time', 'desc')->count();
        $data['count'] = $count;
        $start = ($limit * $page) + $offset;
        $data_list = Db::name('order')->where(['user_id' => $user_id])->order('add_time', 'desc')->limit($start, $limit)->select();
        foreach ($data_list as $k => $v) {
            if ($v['buy_type'] == 2) {
                $data_list[$k]['buy_vip_info'] = json_decode($v['buy_vip_info'], true);
            }
        }
        if (!empty($data_list)) {
            $data['list'] = $data_list;
            die(json_encode(['resultCode' => 0, 'data' => $data, 'message' => '加载完成']));
        } else {
            die(json_encode(['resultCode' => 0, 'data' => $data, 'message' => '没用更多数据了']));
        }
    }


    //会员中心、消费记录
    public function record_img(Request $request)
    {
        $limit = $request->post('limit/d', 8);
        $offset = $request->post('offset/d', '0');
        $page = $request->post('page/d', 0);
        $user_id = session('member_id');
        if (intval($user_id) <= 0) {
            die(json_encode(['resultCode' => 4005, 'message' => '请登陆后操作.']));
        }
        //视频观看记录
        $count = Db::view('atlas_watch_log', 'id,user_ip,gold,user_id,view_time')
            ->view('atlas', 'title,class,id as atlas_id', 'atlas_watch_log.atlas_id=atlas.id')
            ->view('class', 'type,name', 'atlas.class=class.id')
            ->where(['type' => 2, 'user_id' => $user_id])
            ->order('view_time', 'desc')
            ->count();
        $start = ($limit * $page) + $offset;

        $result = Db::view('atlas_watch_log', 'id,user_ip,gold,user_id,view_time')
            ->view('atlas', 'title,class,id as atlas_id', 'atlas_watch_log.atlas_id=atlas.id')
            ->view('class', 'type,name', 'atlas.class=class.id')
            ->where(['type' => 2, 'user_id' => $user_id])
            ->order('view_time', 'desc')
            ->limit($start, $limit)->select();
        $data['count'] = $count;
        if (!empty($result)) {
            $data['list'] = $result;
            die(json_encode(['resultCode' => 0, 'data' => $data, 'message' => '加载完成']));
        } else {
            die(json_encode(['resultCode' => 0, 'data' => $data, 'message' => '没用更多数据了']));
        }

    }


    //会员中心、消费记录
    public function record_novel(Request $request)
    {
        $limit = $request->post('limit/d', 8);
        $offset = $request->post('offset/d', '0');
        $page = $request->post('page/d', 0);
        $user_id = session('member_id');

        $count = Db::view('novel_watch_log', 'id,user_ip,gold,user_id,view_time')
            ->view('novel', 'title,class,id as novel_id', 'novel_watch_log.novel_id=novel.id')
            ->view('class', 'type,name', 'novel.class=class.id')
            ->where(['type' => 3, 'user_id' => $user_id])
            ->order('view_time', 'desc')
            ->count();
        $start = ($limit * $page) + $offset;
        $result = Db::view('novel_watch_log', 'id,user_ip,gold,user_id,view_time')
            ->view('novel', 'title,class,id as novel_id', 'novel_watch_log.novel_id=novel.id')
            ->view('class', 'type,name', 'novel.class=class.id')
            ->where(['type' => 3, 'user_id' => $user_id])
            ->order('view_time', 'desc')
            ->limit($start, $limit)->select();
        $data['count'] = $count;
        if (!empty($result)) {
            $data['list'] = $result;
            die(json_encode(['resultCode' => 0, 'data' => $data, 'message' => '加载完成']));
        } else {
            die(json_encode(['resultCode' => 0, 'data' => $data, 'message' => '没用更多数据了']));
        }
    }

    //会员中心、提现记录
    public function record_out_pay(Request $request)
    {
        $limit = $request->post('limit/d', 8);
        $offset = $request->post('offset/d', '0');
        $page = $request->post('page/d', 0);
        $user_id = session('member_id');
        $count = Db::name('draw_money_log')->where(['user_id' => $user_id])->order('add_time', 'desc')->count();
        $start = ($limit * $page) + $offset;
        $result = Db::name('draw_money_log')->where(['user_id' => $user_id])->order('add_time', 'desc')
            ->limit($start, $limit)->select();
        foreach ($result as $k => $v) {
            $result[$k]['info'] = json_decode($v['info'], true);
        }
        $data['count'] = $count;
        if (!empty($result)) {
            $data['list'] = $result;
            die(json_encode(['resultCode' => 0, 'data' => $data, 'message' => '加载完成']));
        } else {
            die(json_encode(['resultCode' => 0, 'data' => $data, 'message' => '没用更多数据了']));
        }
    }

    //会员中心、消费记录
    public function record_video(Request $request)
    {
        $limit = $request->post('limit/d', 8);
        $offset = $request->post('offset/d', '0');
        $page = $request->post('page/d', 0);
        $user_id = session('member_id');
        //视频观看记录
        $count = Db::view('video_watch_log', 'id,user_ip,gold,user_id,view_time')
            ->view('video', 'title,class,id as video_id', 'video_watch_log.video_id=video.id')
            ->view('class', 'type,name', 'video.class=class.id')
            ->where(['type' => 1, 'user_id' => $user_id])
            ->order('view_time', 'desc')
            ->count();
        $start = ($limit * $page) + $offset;
        $result = Db::view('video_watch_log', 'id,user_ip,gold,user_id,view_time')
            ->view('video', 'title,class,id as video_id', 'video_watch_log.video_id=video.id')
            ->view('class', 'type,name', 'video.class=class.id')
            ->where(['type' => 1, 'user_id' => $user_id])
            ->order('view_time', 'desc')
            ->limit($start, $limit)->select();
        $data['count'] = $count;
        if (!empty($result)) {
            $data['list'] = $result;
            die(json_encode(['resultCode' => 0, 'data' => $data, 'message' => '加载完成']));
        } else {
            die(json_encode(['resultCode' => 0, 'data' => $data, 'message' => '没用更多数据了']));
        }
    }

    public function moreData(Request $request)
    {
        $tag_id = $request->post('tag_id/d', '0');
        $sub_cid = $request->post('sub_cid/d', '0');
        $cid = $request->post('cid/d', '0');
        $offset = $request->post('offset/d', '0');
        $type = $request->post('type/s', 'video');
        $wheres = $request->post('where/s', '');
        $limit = $request->post('limit/d', 8);
        $page = $request->post('page/d', 0);
        $field = array(
            'atlas' => 'id,title,cover,click,good,update_time',
            'novel' => 'id,title,click,good,gold,thumbnail,tag,short_info,update_time',
            'video' => 'id,title,click,good,thumbnail,play_time,reco,update_time,gold,type',
            'image' => 'id,url,add_time,atlas_id',
        );
        $orderCode = empty($request->post('orderCode')) ? 'lastTime' : $request->post('orderCode');
        switch ($orderCode) {
            case 'lastTime':
                $order = ($type == 'image') ? "add_time,id desc" : "update_time desc";
                break;
            case 'lastTimeASC':
                $order = "update_time asc";
                break;
            case 'hot':
                $order = "click desc";
                break;
            case 'hotASC':
                $order = "click asc";
                break;
            case 'reco':
                $order = "reco desc";
                break;
            case 'recoASC':
                $order = "reco asc";
                break;
            default:
                $order = "update_time desc";
                break;
        }
        $order = empty($order) ? 'id desc' : $order;
        if ($type == 'video') {
            $where = "status = 1 and is_check=1  and pid = 0 ";
        } else {
            $where = 'status = 1 and is_check=1 ';
        }
        if (!empty($wheres)) {
            $where = $wheres;
        }
        if (!empty($tag_id)) {
            $where .= " and FIND_IN_SET( $tag_id, tag)";
        }
        if (!empty($cid)) {
            $class_sublist = Db::name('class')->where(array('status' => 1, 'pid' => $cid))->field('id,name')->select();
            if (empty($sub_cid)) {
                if (empty($class_sublist)) {
                    $where .= " and class = $cid";
                } else {
                    $param = array(
                        'db' => 'class',
                        'where' => array('status' => 1, 'pid' => $cid),
                        'field' => 'id',
                    );
                    $sub_array = get_field_values($param);
                    $where .= " and (class = $cid or class in (" . implode(',', $sub_array) . "))";
                }
            } else {
                $where .= " and class = $sub_cid";
            }

        }
        $count = Db::name($type)->where($where)->count();
        $start = ($limit * $page) + $offset;
        $end = $start + $limit;
        $list = Db::name($type)->where($where)->order($order)->limit($start, $limit)->field($field[$type])->select();
        $data['count'] = $count;
        $data['isMore'] = ($count > $end) ? 1 : 0;
        if (!empty($list)) {
            $data['list'] = $list;
            die(json_encode(['resultCode' => 0, 'data' => $data, 'message' => '加载完成']));
        } else {
            die(json_encode(['resultCode' => 0, 'data' => $data, 'message' => '没用更多数据了']));
        }

    }

    /**
     * 查询订单支付状态
     */
    public function getOrderStatus(Request $request)
    {
        $orderSn = $request->post('orderSn/s', '');
        if (empty($orderSn)) die(json_encode(['statusCode' => 4003, 'message' => '缺少请求参数:orderSn不能为空']));
        $orderInfo = Db::name('order')->where("order_sn='$orderSn'")->find();
        if (!$orderInfo) die(json_encode(['statusCode' => 4005, 'message' => "can't find the orderSn"]));
        die(json_encode(['statusCode' => 0, 'message' => '', 'data' => ['orderStatus' => $orderInfo['status']]]));
    }

    /* 更多收藏 */
    public function moreCollection(Request $request)
    {
        $user_id = session('member_id');
        $type = $request->post('type/s', 'video');
        $offset = $request->post('offset/d', '0');
        $limit = $request->post('limit/d', 8);
        $page = $request->post('page/d', 0);
        $start = ($limit * $page) + $offset;
        $end = $start + $limit;
        $wheres = ['user_id' => $user_id];
        switch ($type) {
            case 'video':
                $field = 'id,good,click,title,play_time,thumbnail,reco';
                $list = Db::view('video_collection', 'id,video_id')
                    ->view('video', $field, 'video_collection.video_id=video.id')
                    ->where('video.status=1 and video.is_check=1 and video_collection.user_id=' . $user_id)
                    ->limit($start, $limit)
                    ->select();
                $count = Db::view('video_collection', 'id,video_id')
                    ->view('video', $field, 'video_collection.video_id=video.id')
                    ->where('video.status=1 and video.is_check=1 and video_collection.user_id=' . $user_id)
                    ->limit($start, $limit)
                    ->count();
                break;
            case 'novel':
                $field = 'id,good,click,title,short_info,thumbnail,add_time,tag,update_time';
                $list = Db::view('novel_collection', 'id,novel_id')
                    ->view('novel', $field, 'novel_collection.novel_id=novel.id')
                    ->where('novel.status=1 and novel.is_check=1 and novel_collection.user_id=' . $user_id)
                    ->limit($start, $limit)
                    ->select();
                $count = Db::view('novel_collection', 'id')
                    ->view('novel', $field, 'novel_collection.novel_id=novel.id')
                    ->where('novel.status=1 and novel.is_check=1 and novel_collection.user_id=' . $user_id)
                    ->limit($start, $limit)
                    ->count();
                break;
            case 'user_atlas':
                $list = Db::name('user_atlas')->where($wheres)->order('add_time', 'desc')->limit($start, $limit)->select();
                $count = Db::name('user_atlas')->where($wheres)->count();
                if (!empty($list)) {
                    foreach ($list as $k => $v) {
                        $imgs = Db::name('image_collection')->where(['atlas_id' => $v['id'], 'user_id' => $user_id])->order('collection_time', 'asc')->field('id,image_id,collection_time')->find();
                        if (!empty($imgs)) {
                            $imgs_url = Db::name('image')->where(['id' => $imgs['image_id'], 'status' => 1])->field('id,url')->find();
                            if (!empty($imgs_url)) {
                                $list[$k]['first_img'] = $imgs_url['url'];
                            }
                        } else {
                            $list[$k]['first_img'] = 'default';
                        }
                    }
                }
            case 'image':
                $imgid = $request->post('imgid/d', 0);
                $where = ['user_id' => $user_id, 'atlas_id' => $imgid];
                $count = Db::name('image_collection')->where($where)->count();
                $list = Db::view('image_collection', 'id,user_id,image_id,collection_time,atlas_id')
                    ->view('image', 'title,url,status,add_time', 'image_collection.image_id=image.id and image.status=1')
                    ->where($where)
                    ->limit($start, $limit)->select();
            default:
                break;
        }
        $data['count'] = $count;
        $data['isMore'] = ($count > $end) ? 1 : 0;
        if (!empty($list)) {
            $data['list'] = $list;
            die(json_encode(['resultCode' => 0, 'data' => $data, 'message' => '加载完成']));
        } else {
            die(json_encode(['resultCode' => 0, 'data' => $data, 'message' => '没用更多数据了']));
        }
    }

    /* 删除用户自已图册里的图片 */
    public function deleteMyselfImg(Request $request)
    {
        $memberId = session('member_id');
        if ($memberId == 0) die(json_encode(['resultCode' => 4005, 'message' => '用户未登陆']));
        $atlasId = $request->post('aId/d', 0);//相册id
        $imageId = $request->post('iId/d', 0);//图片id
        if ($atlasId == 0 || $imageId == 0) die(json_encode(['statusCode' => 4003, 'message' => '缺少请求参数:aId,iId']));

        $atlasM = Atlas::get($atlasId);
        if (!$atlasM) die(json_encode(['statusCode' => 4005, 'message' => "图片归属相册不存在"]));
        try {
            if ($atlasM->user_id === $memberId) {
                $imageM = Image::get($imageId);
                if (!$imageM) die(json_encode(['statusCode' => 4005, 'message' => "您要删除的图片不存在"]));
                $delRs = $imageM->delete();

                //删除对应的收藏表  2018/01/16 $dreamer
                Db::name('image_collection')->where("image_id={$imageId}")->delete();

                if ($delRs) {
                    die(json_encode(['statusCode' => 0, 'message' => "删除成功"]));
                } else {
                    die(json_encode(['statusCode' => 5002, 'message' => "删除图片未能成功"]));
                }
            } else {
                die(json_encode(['statusCode' => 4005, 'message' => "您只能删除您自己的图片"]));
            }
        } catch (\Exception $e) {
            die(json_encode(['statusCode' => 5002, 'message' => "删除图片未能成功"]));
        }

    }

    /**
     * @param Request $request
     * 用户提现API
     */

    public function get_pay(Request $request)
    {
        $memberId = session('member_id');
        if ($memberId == 0) die(json_encode(['resultCode' => 4005, 'message' => '用户未登陆']));
        $type = $request->post('type/d', 0);//获取提现方式
        $gold = $request->post('gold/d', 0);//用户兑换金币
        $money = $request->post('money/d', 0);//用户提现的金钱
        //判断管理员是否开启了用户提现功能
        $is_withdrawals = get_config('is_withdrawals');
        if (!$is_withdrawals) {
            die(json_encode(['statusCode' => 4005, 'message' => "管理员没有开启用户提现功能！"]));
        }
        //判断用户提现频率
        $log = Db::name('draw_money_log')->where(['user_id' => $memberId])->order('add_time', 'desc')->find();
        $withdrawals_frequency = get_config('withdrawals_frequency');
        $ltime = (intval($withdrawals_frequency) * 3600);
        $newtime = intval(time() - $log['add_time']);
        if ($ltime > $newtime) {
            die(json_encode(['statusCode' => 4005, 'message' => "你的提现频率过快，请隔一段时间后再试"]));
        }
        //判断提现最低限额
        $menber_info = get_member_info($memberId);
        $min_withdrawals = get_config('min_withdrawals');
        if (intval($gold) < intval($min_withdrawals)) {
            die(json_encode(['statusCode' => 4005, 'message' => "你提现金币未达到提现最低提现金币数"]));
        }
        //判断用户提现方式是否存在
        $money_account = Db::name('draw_money_account')->where(['id' => $type, 'user_id' => $memberId])->find();
        if (empty($money_account)) {
            die(json_encode(['statusCode' => 4005, 'message' => "你的收款方式不存在！"]));
        }
        //判断用户是否够金币
        if (intval($menber_info['money']) < intval($gold)) {
            die(json_encode(['statusCode' => 4005, 'message' => "你账户金币少于兑换金币"]));
        }
        //判断用户提交过来的提现额度是否正确
        $gold_exchange_rate = get_config('gold_exchange_rate');
        if (intval($money) != floor($gold / $gold_exchange_rate)) {
            die(json_encode(['statusCode' => 4005, 'message' => "你提交的额度有误"]));
        }
        //验证通过，写入数据库,更新用户金币
        $result = Db::name('member')->where(['id' => $memberId])->setDec('money', $gold);

        if ($result) {
            $gold_log_data = array(
                'user_id' => $memberId,
                'gold' => '-' . $gold,
                'module' => 'draw_money',
                'explain' => '金币提现'
            );
            write_gold_log($gold_log_data);
            //写入提现记录
            $data = array(
                'user_id' => $memberId,
                'gold' => $gold,
                'money' => $money,
                'add_time' => time(),
                'update_time' => time(),
                'status' => 0,
                'info' => json_encode($money_account)
            );
            $insert_info = Db::name('draw_money_log')->insert($data);
            if ($insert_info) die(json_encode(['statusCode' => 0, 'message' => "提现成功"]));
        }
        die(json_encode(['statusCode' => 4005, 'message' => "未知错误"]));
    }

    /**
     * 用户提现方式信息录入
     */
    function pay_way(Request $request)
    {
        $memberId = session('member_id');
        if ($memberId == 0) die(json_encode(['resultCode' => 4005, 'message' => '用户未登陆']));
        $count = Db::name('draw_money_account')->where(['user_id' => $memberId])->count();

        if (intval($count) >= 5) {
            die(json_encode(['statusCode' => 4005, 'message' => '你的支付方式已经达到上限']));
        }
        $msg = '';
        if ($request->isAjax()) {
            $data = array();
            $type = $request->post('type');
            if ($type == 'Bank') {
                $account_name = trim($request->post('account_name/s'));
                $bank = trim($request->post('bank/s'));
                $bankaccount = trim($request->post('bankaccount/s'));

                if (empty($account_name) || empty($bank) || empty($bankaccount)) $msg = '请填写必要的选项后再试';
                if ($msg != '') {
                    die(json_encode(['statusCode' => 4005, 'message' => $msg]));
                }
                $data['user_id'] = $memberId;
                $data['title'] = '银行卡' . substr($bankaccount, 0, 4) . '****' . substr($bankaccount, -4);
                $data['type'] = 2;
                $data['account'] = $bankaccount;
                $data['account_name'] = $account_name;
                $data['bank'] = $bank;
            } elseif ($type == 'Alipay') {
                $alipayaccount = trim($request->post('alipayaccount/s'));
                if (empty($alipayaccount)) $msg = '请填写必要的选项后再试';
                if ($msg != '') {
                    die(json_encode(['statusCode' => 4005, 'message' => $msg]));
                }
                $data['account'] = $alipayaccount;
                $data['type'] = 1;
                $data['user_id'] = $memberId;
                $data['title'] = '支付宝' . $alipayaccount;
            }
            //支付方式入库
            $result = Db::name('draw_money_account')->insert($data);
            if ($result) die(json_encode(['statusCode' => 0, 'message' => '添加成功']));
        }
        die(json_encode(['statusCode' => 4005, 'message' => '未知错误，请联系管理员']));
    }

    public function way_del(Request $request)
    {
        $id = $request->post('id/d', 0);
        $memberId = session('member_id');
        if ($memberId == 0) die(json_encode(['resultCode' => 4005, 'message' => '用户未登陆']));
        Db::name('draw_money_account')->where(['user_id' => $memberId, 'id' => $id])->delete();
        die(json_encode(['statusCode' => 0, 'message' => '删除成功']));
    }

    /** 刷新缓存 */
    function refreshCache()
    {
        cache(null); //clear cache data
        array_map('unlink', glob(TEMP_PATH . '*.php')); //delete temp files

        //delete log files
        foreach (glob(LOG_PATH . "/*") as $file) {
            array_map('unlink', glob($file . "/*.*"));
            @rmdir($file);
        }

        die(json_encode(['statusCode' => 0, 'message' => '刷新成功!']));
    }

    /** 获取用户信息 */
    function memberInfo()
    {

    }

    /**
     * 返回想要的分类
     * @param $param array
     * @param card_number  卡号
     * @param verifyCode 验证码
     */
    function get_card_password_info(Request $request)
    {
        $card_number = $request->post('card_number/s');
        $verifyCode = $request->post('verifyCode/s', '', '');
        if (empty($card_number)) die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败:卡号不能为空']));
        if (!captcha_check($verifyCode)) die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败:验证码错误']));
        $field = 'id,card_number,card_type,out_time,status,price,gold,vip_time';
        $where['card_number'] = $card_number;
        $info = Db::name('card_password')->where($where)->field($field)->find();
        if (empty($info)) die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败:该卡不存在']));
        $info['out_times'] = ($info['out_time'] < time()) ? '已过期' : date('Y-m-d H:i', $info['out_time']);
        die(json_encode(['statusCode' => 0, 'message' => '查询成功', 'data' => $info]));
    }

    /**
     * 使用卡密
     * @param $param array
     * @param card_number  卡号
     * @param id 卡id
     */
    function use_card_password(Request $request)
    {
        $memberId = session('member_id');
        if ($memberId == 0) die(json_encode(['resultCode' => 4005, 'message' => '用户未登陆']));
        $card_number = $request->post('card_number/s');
        $id = $request->post('id/d', '0');
        if (empty($card_number) || empty($id)) die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败:缺少card_number/id']));
        $field = 'id,card_number,card_type,out_time,status,price,gold,vip_time';
        $where['card_number'] = $card_number;
        $where['id'] = $id;
        $info = Db::name('card_password')->where($where)->field($field)->find();
        if (empty($info)) die(json_encode(['statusCode' => 4005, 'error' => '数据验证失败:信息不匹配']));
        if ($info['status'] == 1) die(json_encode(['statusCode' => 4005, 'error' => '该卡密已经使用过了']));
        if ($info['out_time'] < time()) die(json_encode(['statusCode' => 4005, 'error' => '该卡密已过期了']));
        if ($info['card_type'] == 1) {
            $userinfo = db::name('member')->where(array('id' => $memberId))->field('out_time,is_permanent')->find();
            if ($userinfo['is_permanent'] == 1) die(json_encode(['statusCode' => 4005, 'error' => '您无需再充值vip']));
            if ($info['vip_time'] == 999999999) {
                db::name('member')->where(array('id' => $memberId))->update(array('is_permanent' => 1));
            } else {
                if ($userinfo['out_time'] < time()) {
                    $out_time = time() + $info['vip_time'] * 3600 * 24;
                } else {
                    $out_time = $userinfo['out_time'] + $info['vip_time'] * 3600 * 24;
                }
                db::name('member')->where(array('id' => $memberId))->update(array('out_time' => $out_time));
            }
            db::name('card_password')->where($where)->update(array('status' => 1, 'use_time' => time()));
        } else {
            db::name('member')->where(array('id' => $memberId))->setInc('money', $info['gold']);
            db::name('card_password')->where($where)->update(array('status' => 1, 'use_time' => time()));
            $gold_log_data = array(
                'user_id' => $memberId,
                'gold' => intval($info['gold']),
                'module' => 'card_password',
                'explain' => '卡密充值'
            );
            write_gold_log($gold_log_data);
        }
        die(json_encode(['statusCode' => 0, 'message' => '充值成功']));
    }


    function get_login_status()
    {
        $data = check_is_login();
        die(json_encode($data));
    }

    /** 获取主题数据 */
    function getThemeInfos()
    {
        $mustHava = ["agent", "common", "images", "index", "install", "member",
            "mobile", "novel", "poster", "static", "systemMsg", "system_pay", "video"];
        $jsonField = ["title", "author", "update_time", "thumb", "description"];
        $dir = './tpl/';
        $themeDirs = glob($dir . '*', GLOB_ONLYDIR);
        $themeList = [];
        foreach ($themeDirs as $themeDir) {
            $subDirs = array_map('basename', glob($themeDir . '/*', GLOB_ONLYDIR));
            if (!array_diff($mustHava, $subDirs)) {
                if (file_exists($themeDir . "/info.json") && $json = \json_decode(file_get_contents($themeDir . "/info.json"), true)) {
                    if (!array_diff($jsonField, array_keys($json))) {
                        $theme['basename'] = basename($themeDir);
                        $theme['title'] = $json['title'];
                        $theme['author'] = $json['author'];
                        $theme['update_time'] = $json['update_time'];
                        $theme['thumb'] = $json['thumb'];
                        $theme['description'] = $json['description'];
                        $themeList[] = $theme;
                    }

                }
            }
        }

        die(json_encode(['statusCode' => 0, 'message' => '获取成功', 'data' => $themeList], JSON_UNESCAPED_UNICODE));
    }

    /** 生成二维码 */
    function createQrCode()
    {
        $content = request()->param('content/s');
        if (empty(trim($content))) {
            $content = 'content is empty.';
        } else {
            $content = base64_decode($content);
        }
        return create_qr_cdoe($content);
    }

    /** 数据采集入库接口  */
    function addResourceFromGather(Request $request)
    {
        $key = trim($request->param('key'));
        if (!isset($key) || empty($key)) exit('错误:采集密钥不能为空');
        $gatherConf = get_config_by_group('gather');
        $gatherIsOpen = $gatherConf['resource_gather_status'] ? true : false;
        if (!$gatherIsOpen) exit('采集接口已关闭');
        if ($key !== $gatherConf['resource_gather_key']) exit('密钥错误');


        $type = $request->post('resourceType/s', '');
        if (empty($type)) exit('错误:采集数据类型错误');
        switch ($type) {
            case 'novel':
                $thumbnail = trim($request->post('thumbnail/s', '')) ? trim($request->post('thumbnail/s', '')) : "/static/images/images_default.png";
                $is_check = (isset($gatherConf['resource_gather_novel_need_review']) && $gatherConf['resource_gather_novel_need_review'] == 0) ? 1 : 0;
                $class_id = (isset($gatherConf['resource_gather_novel_classid']) && $gatherConf['resource_gather_novel_classid'] > 0) ? $gatherConf['resource_gather_novel_classid'] : 0;
                $gold = (isset($gatherConf['resource_gather_novel_view_gold']) && $gatherConf['resource_gather_novel_view_gold'] > 0) ? $gatherConf['resource_gather_novel_view_gold'] : 0;

                $data = [
                    'title' => !empty(trim($request->post('title'))) ? trim($request->post('title')) : exit('错误:资讯标题不能为空'),//标题
                    'content' => !empty(trim($request->post('content'))) ? trim($request->post('content')) : exit('错误:资讯内容不能为空'),//内容主体
                    'short_info' => trim($request->post('short_info')),//简介
                    'key_word' => trim($request->post('key_word')),//关键词
                    'thumbnail' => $thumbnail,//封面
                    'status' => 1,
                    'class' => $class_id,
                    'tag' => null,//标签
                    'gold' => $gold,
                    'is_check' => $is_check,
                    'user_id' => 0,//发布者id，0为管理员
                    'add_time' => time(),
                    'update_time' => time()
                ];

                $rs = Db::name('novel')->data($data)->insert();
                if ($rs) exit('采集数据录入成功');
                exit('采集数据录入失败');
                break;
            case 'video':
                $thumbnail = trim($request->post('thumbnail/s', '')) ? trim($request->post('thumbnail/s', '')) : "/static/images/images_default.png";
                $is_check = (isset($gatherConf['resource_gather_video_need_review']) && $gatherConf['resource_gather_video_need_review'] == 0) ? 1 : 0;
                $class_id = (isset($gatherConf['resource_gather_video_classid']) && $gatherConf['resource_gather_video_classid'] > 0) ? $gatherConf['resource_gather_video_classid'] : 0;
                $gold = (isset($gatherConf['resource_gather_video_view_gold']) && $gatherConf['resource_gather_video_view_gold'] > 0) ? $gatherConf['resource_gather_video_view_gold'] : 0;

                $data = [
                    'title' => !empty(trim($request->post('title'))) ? trim($request->post('title')) : exit('错误:视频标题不能为空')//标题
                    , 'info' => $request->post('info')//说明
                    , 'short_info' => $request->post('short_info')//短说明
                    , 'key_word' => $request->post('key_word')//关键词
                    , 'url' => !empty(trim($request->post('url'))) ? trim($request->post('url')) : exit('错误:视频播放地址不能为空')//视频播放地址 Mp4/m3u8
                    , 'download_url' => $request->post('download_url')//视频下载地址
                    , 'add_time' => $curTime = time()
                    , 'update_time' => $curTime
                    , 'play_time' => $request->post('play_time')//播放时间
                    , 'click' => $request->post('click/d', 1)//观看数
                    , 'good' => $request->post('good/d', 1)//点赞数
                    , 'thumbnail' => $thumbnail//封面图
                    , 'user_id' => 0//上传者id
                    , 'class' => $request->post('class')
                    , 'tag' => null//标签
                    , 'status' => 1
                    , 'gold' => $gold
                    , 'is_check' => $is_check
                ];
                $rs = Db::name('video')->insert($data);
                if ($rs) exit('采集数据录入成功');
                exit('采集数据录入失败');
                break;
            case 'images':
                $thumbnail = trim($request->post('thumbnail/s', '')) ? trim($request->post('thumbnail/s', '')) : "/static/images/images_default.png";
                $is_check = (isset($gatherConf['resource_gather_atlas_need_review']) && $gatherConf['resource_gather_atlas_need_review'] == 0) ? 1 : 0;
                $class_id = (isset($gatherConf['resource_gather_atlas_classid']) && $gatherConf['resource_gather_atlas_classid'] > 0) ? $gatherConf['resource_gather_atlas_classid'] : 0;
                $gold = (isset($gatherConf['resource_gather_atlas_view_gold']) && $gatherConf['resource_gather_atlas_view_gold'] > 0) ? $gatherConf['resource_gather_atlas_view_gold'] : 0;
                //1.新增图册，记录图册id
                $data = [
                    'title' => !empty(trim($request->post('title'))) ? trim($request->post('title')) : exit('错误:图册标题不能为空')//标题
                    , 'info' => $request->post('info')//说明
                    , 'short_info' => $request->post('short_info')//说明
                    , 'key_word' => $request->post('key_word')//关键词
                    , 'cover' => $thumbnail
                    , 'add_time' => $curTime = time()
                    , 'update_time' => $curTime
                    , 'gold' => $gold
                    , 'click' => $request->post('click/d', 1)//观看数
                    , 'good' => $request->post('good/d', 1)//点赞数
                    , 'user_id' => 0
                    , 'class' => $class_id
                    , 'tag' => null
                    , 'status' => 1
                    , 'is_check' => $is_check
                ];

                //创建图册
                if (!$rs=Db::name('atlas')->insert($data)) {
                    exit('创建图册时发生错误');
                }
                $atlasId = Db::getLastInsID();

                //2.先获图片，将分别将图片插入到images表，并关联id
                $images = !empty(trim($request->post('images/s', ''))) ? trim($request->post('images/s')) : exit('错误:图册的图片不能为空');
                $images = explode('|', $images);

                $tablePrefix = config('database.prefix');
                $insertImgSql = " INSERT INTO {$tablePrefix}image(`atlas_id`,`url`,`status`,`add_time`) VALUES";
                foreach ($images as $url) {
                    $insertImgSql .= " ({$atlasId},'{$url}',1,{$curTime}),";
                }
                $insertImgSql=rtrim($insertImgSql,',');

                try {
                    if(Db::execute($insertImgSql)) exit('采集数据录入成功');
                } catch (\Exception $exception) {
                    exit("错误：".$exception->getMessage());
                }
                exit('采集数据录入失败');
                break;
            default:
                break;
        }


    }


}

