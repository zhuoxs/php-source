<?php
/**
 * 地址管理
 */
defined('IN_IA') or exit('Access Denied');
load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'addressManager'; //默认是分类管理
$title = '收货地址';
if ($operation == 'addressAdd') {
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $sql = 'SELECT * FROM ' . tablename('wg_fenxiao_member_address') . ' WHERE `id` = :id';
        $address = pdo_fetch($sql, array(
            ':id' => $id
        ));
    } else { //如果地址为空
        if (!isset($_GPC['code'])) {
            $url = $url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
            $callback = urlencode($url);
            $oauth_account = WeAccount::create($_W['uniacid']);
            $forward = $oauth_account->getOauthCodeUrl($callback, $state = 0);
            header('Location: ' . $forward);
            exit();
        }
        if (isset($_GPC['code']) && $_GPC['code'] != 'authdeny') {
            $state = $_GPC['state'];
            $code = $_GPC['code'];
            $addressSignInfo = $this->getAddressSignInfo($code, 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        }
    }
    if (checksubmit('addressAdd')) {
        $address = $_GPC['address'];
        if (empty($address['username'])) {
            message('请输入您的姓名', referer() , 'error');
        }
        if (empty($address['mobile'])) {
            message('请输入您的手机号', referer() , 'error');
        }
        if (empty($address['zipcode'])) {
            message('请输入您的邮政编码', referer() , 'error');
        }
        if (empty($address['province'])) {
            message('请输入您的所在省', referer() , 'error');
        }
        if (empty($address['city'])) {
            message('请输入您的所在市', referer() , 'error');
        }
        if (empty($address['address'])) {
            message('请输入您的详细地址', referer() , 'error');
        }
       
        if (!empty($_GPC['id'])) {
             $address['uniacid'] = $_W['uniacid'];
             $address['uid'] = $_W['fans']['uid'];
            if (pdo_update('wg_fenxiao_member_address', $address, array(
                'id' => $_GPC['id'],
                'uid' => $_W['fans']['uid']
            ))) {
                 $returnurl = $_COOKIE['returnurl'];
                message('修改收货地址失败，请稍后重试', $this->createMobileUrl('address', array(
                    'op' => 'addressManager'
                )) , 'success');
            } else {
                message('修改收货地址失败，请稍后重试', $this->createMobileUrl('address', array(
                    'op' => 'addressManager'
                )) , 'error');
            }
        } else {
             $address['uniacid'] = $_W['uniacid'];
             $address['uid'] = $_W['fans']['uid'];
            pdo_update('wg_fenxiao_member_address', array(
                'isdefault' => 0
            ) , array(
                'uniacid' => $_W['uniacid'],
                'uid' => $_W['fans']['uid']
            ));
            $address['isdefault'] = 1;
            $returnurl = $_COOKIE['returnurl'];
            if (pdo_insert('wg_fenxiao_member_address',$address)) {
                message('地址添加成功', $returnurl, 'success');
            }
        }
    }
} elseif ($operation == 'addressDefault') {
    $id = intval($_GPC['id']);
    $sql = 'SELECT `isdefault` FROM ' . tablename('wg_fenxiao_member_address') . ' WHERE `id` = :id AND `uniacid` = :uniacid
                     AND `uid` = :uid';
    $params = array(
        ':id' => $id,
        ':uniacid' => $_W['uniacid'],
        ':uid' => $_W['fans']['uid']
    );
    $address = pdo_fetch($sql, $params);
    if (!empty($address) && empty($address['isdefault'])) {
        pdo_update('wg_fenxiao_member_address', array(
            'isdefault' => 0
        ) , array(
            'uniacid' => $_W['uniacid'],
            'uid' => $_W['fans']['uid']
        ));
        pdo_update('wg_fenxiao_member_address', array(
            'isdefault' => 1
        ) , array(
            'uniacid' => $_W['uniacid'],
            'uid' => $_W['fans']['uid'],
            'id' => $id
        ));
        message('设置默认成功', $this->createMobileUrl('address', array(
            'op' => 'addressManager'
        )) , 'success');
    }
} elseif ($operation == 'addressDel') {
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $where = ' AND `uniacid` = :uniacid AND `uid` = :uid';
        $sql = 'SELECT `isdefault` FROM ' . tablename('wg_fenxiao_member_address') . ' WHERE `id` = :id' . $where;
        $params = array(
            ':id' => $id,
            ':uniacid' => $_W['uniacid'],
            ':uid' => $_W['fans']['uid']
        );
        $address = pdo_fetch($sql, $params);
        if (!empty($address)) {
            pdo_delete('wg_fenxiao_member_address', array(
                'id' => $id
            ));
            message('删除成功', $this->createMobileUrl('address') , 'success');
        }
    }
} elseif ($operation == 'addressManager') {
    $sql = 'SELECT * FROM ' . tablename('wg_fenxiao_member_address') . ' WHERE `uid` = :uid AND `uniacid` = :uniacid';
    $params = array(
        ':uniacid' => $_W['uniacid'],
        ':uid' => $_W['fans']['uid']
    );
    $addresses = pdo_fetchall($sql, $params);
}
include $this->template('address');
