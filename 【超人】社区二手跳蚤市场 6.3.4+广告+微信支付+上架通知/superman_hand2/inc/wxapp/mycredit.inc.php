<?php
/**
 * 【超人】模块定义
 *
 * @author 超人
 * @url https://s.we7.cc/index.php?c=home&a=author&do=index&uid=59968
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$do = $_GPC['do'];
$act = in_array($_GPC['act'], array(
    'display',   //积分记录页
    'get',       //赚积分项
))?$_GPC['act']:'display';
if ($act == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $limit = 'LIMIT '.($pindex-1)* $psize.','.$psize;
    $orderby = 'createtime DESC';
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
    );
    if ($_GPC['type'] == 'block') {   //冻结积分记录
        $list = pdo_getall('superman_hand2_member_block_credit', $filter, '', '', $orderby, $limit);
        if ($list) {
            foreach ($list as &$li) {
                $li['createtime'] = date('Y-m-d H:i:s', $li['createtime']);
                $li['num'] = '-'.$li['credit'];
            }
            unset($li);
        }
    } else {  //积分明细
        $filter['credittype'] = 'credit1';
        $list = pdo_getall('mc_credits_record', $filter, '', '', $orderby, $limit);
        if ($list) {
            foreach ($list as &$li) {
                $li['createtime'] = date('Y-m-d H:i:s', $li['createtime']);
                if ($li['num'] > 0) {
                    $li['num'] = '+'.$li['num'];
                }
            }
            unset($li);
        }
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $list);
} else if ($act == 'get') {
    $result = array();
    $category = pdo_getall('superman_hand2_category', array(
        'uniacid' => $_W['uniacid'],
    ), '', 'id', 'displayorder DESC');
    $member_log = pdo_get('superman_hand2_member_log', array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
    ));
    $credit_setting = $this->module['config']['credit'];
    if ($credit_setting['open'] == 1) {
        foreach ($credit_setting as $k => $cs) {
            if ($k == 'open') {
                continue;
            } else if (in_array($k, array('login', 'upload', 'day')) && $cs > 0) {
                if ($k == 'login') {
                    $title = '首次登录';
                    $disabled = $member_log['login']==1?true:false;
                } else if ($k == 'upload') {
                    $title = '首次上传';
                    $disabled = $member_log['upload']==1?true:false;
                } else if ($k == 'day') {
                    $member_login = pdo_get('superman_hand2_member_login', array(
                        'uniacid' => $_W['uniacid'],
                        'uid' => $_W['member']['uid'],
                        'dateline >' => strtotime(date('Y-m-d 0:0:0', TIMESTAMP)),
                    ));
                    $title = '每天登录';
                    $disabled = $member_login?true:false;
                }
                $result['list'][] = array(
                    'type' => $k,
                    'title' => $title,
                    'disabled' => $disabled,
                    'credit' => $cs,
                    'url' => $k == 'upload'?'/pages/post/index':'',
                    'status_title' => $disabled?'已赚积分':'去赚积分',
                );
            } else if ($k == 'category') {
                foreach ($cs as $c => $cate) {
                    if ($cate > 0) {
                        $result['list'][] = array(
                            'type' => $k,
                            'title' => '上传分类为'.$category[$c]['title'].'物品',
                            'disabled' => false,
                            'credit' => $cate,
                            'url' => '/pages/post/index',
                            'status_title' => '去赚积分',
                        );
                    }
                }
            }
        }
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
}
