<?php
/*
 * 密码管理
 * [增删改查]
*/
defined('IN_IA') or exit('Access Denied');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'passwdsManager';
if ($operation == 'passwdsAdd') {
    $zhongleis = pdo_fetchall("SELECT * FROM " . tablename('wg_fenxiao_passwd_type') . " WHERE `weid`=:weid ORDER BY id asc",array(':weid'=>$_W['uniacid']));
    if (checksubmit('passwdsAdd')) {
        if (empty($_GPC['type'])) {
            message('请选择种类名称，没有请先添加');
        }
        load()->func('file');
        if (!empty($_FILES['passwdtxt']['name'])) {
            $file = file_upload($_FILES['passwdtxt']);
            if (is_error($file)) {
                message('保存失败,' . $file['message']);
            } else {
                $path = ATTACHMENT_ROOT . $file['path'];
                $file = fopen($path, "r");
                //读取文件
                
                while (!feof($file)) {
                    $code = trim(fgets($file));
                    $code = str_replace(array("\r\n", "\r", "\n"), "", $code);
                    if(!$code) {
                        continue;
                    }
                    $data = array(
                        'type'       => intval($_GPC['type']),
                        'code'       => $code,
                        'weid'       => $_W['uniacid'],
                        'createtime' => time()
                    );
                    pdo_insert('wg_fenxiao_passwds', $data);
                }
                fclose($file);
            }
        }
        message('新增完成', $this->createWebUrl('passwds') , 'success');
    }
} elseif ($operation == 'passwdsManager') {
    $zhongleis = pdo_fetchall("SELECT * FROM " . tablename('wg_fenxiao_passwd_type') . " WHERE `weid`=:weid ORDER BY id asc",array(':weid'=>$_W['uniacid']),'id');
    $pindex = max(1, intval($_GPC['page']));

    $sql = 'SELECT COUNT(*) FROM ' . tablename('wg_fenxiao_passwds') . ' WHERE `weid` = :weid';
    if ($_GPC['keyword']) {
        $sql .=" AND code=:code";
        $where[':code'] = trim($_GPC['keyword']);
    }
    $psize = 15;

    $where[':weid'] = $_W['uniacid'];
    $total = pdo_fetchcolumn($sql, $where);
    if (!empty($total)) {
        $sql = 'SELECT * FROM ' . tablename('wg_fenxiao_passwds') . ' WHERE `weid` = :weid ORDER BY `createtime` DESC,
	                    `id` DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;


        $where = [];
        if ($_GPC['keyword']) {
            $sql = 'SELECT * FROM ' . tablename('wg_fenxiao_passwds') . ' WHERE `weid` = :weid AND code=:code  ORDER BY `createtime` DESC,
	                    `id` DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;

            $where[':code'] = trim($_GPC['keyword']);
        }

        $where[':weid'] = $_W['uniacid'];
        $list = pdo_fetchall($sql, $where);
        $pager = pagination($total, $pindex, $psize);
    }
} elseif ($operation == 'passwdsDelete') {
    $id = intval($_GPC['id']);
    pdo_delete('wg_fenxiao_passwds', array(
        'id' => $id
    ));
    message('删除成功！', referer() , 'success');
} elseif ($operation == 'piliangDel') {
    $ids = $_GPC['mid'];
    $mid_string = '(';
    if (!empty($ids)) {
        $mid_string.= implode(',', $ids);
    }
    $mid_string.= ')';
    $sql = "DELETE FROM " . tablename('wg_fenxiao_passwds') . " WHERE id in " . $mid_string;
    pdo_query($sql);
    message('删除成功！', referer() , 'success');
}elseif ($operation == 'check') {
    $id = intval($_GPC['id']);
    pdo_update('wg_fenxiao_passwds', array(
        'status' => 2
    ),[
        'id' => $id,
        'status' => 1
    ]);
    message('核销成功！', referer() , 'success');
}
include $this->template('passwds');
