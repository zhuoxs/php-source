<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;

load()->func('tpl');
$operation = $_GPC['op'] ? $_GPC['op'] : 'display';

if ($operation == 'display') {


} else if ($operation == 'display_table') {
    $keyword = $_GPC['keyword'];

    $condition = ' AND uniacid=:uniacid ';
    $params = array(':uniacid' => $_W['uniacid']);
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    if ($keyword != '') {
        $condition .= ' AND (CONCAT(`last_name`,`middle_name`,`first_name`) LIKE :theName OR mobile_show LIKE :mobile_show) ';
        $params[':theName'] = '%'.$keyword.'%';
        $params[':mobile_show'] = '%'.$keyword.'%';
    }

    $sql = "SELECT * FROM " . tablename('slwl_aicard_card'). ' WHERE 1 '
        . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

    $list = pdo_fetchall($sql, $params);

    if ($list) {
        foreach ($list as $k => $v) {
            $list[$k]['thumb_url'] = tomedia($v['thumb']);
            $list[$k]['qrcode_url'] = $v['qrcode'] ? tomedia($v['qrcode']) : 'resource/images/nopic-107.png';

            if ($v['attr']) {
                $smeta = '';
                $smeta = json_decode($v['attr'], true);

                if ($smeta['items']) {
                    foreach ($smeta['items'] as $key => $value) {
                        if ($value['page_url'] == 'people') {
                            $list[$k]['mobile'] = $value['content'];
                        }
                    }
                }
            }
        }
        $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition, $params);
        // $pager = pagination($total, $pindex, $psize);
    }
    $data_return = array(
        'code' => '0',
        'msg' => '',
        'count' => $total,
        'data' => $list,
    );
    echo json_encode($data_return);
    exit;


} elseif ($operation == 'set') {

    if ($_W['ispost']) {

        $list_qy = get_address_book_all_user();

        // dump($list_qy);exit;

        // $arr = $list_qy['data'];
        //数组排序
        // foreach ($arr as $val) {
           // $key_arrays[] = $val['userid'];
        // }
        // array_multisort($key_arrays, SORT_DESC, SORT_NUMERIC, $arr);

        // dump($list_qy);
        // echo gettype($list_qy);
        // dump($list_qy['ErrMsg']);

        if ($list_qy['errcode'] == '0') {
            if (empty($list_qy['data'])) {
                iajax(1, '获取企业微信用户为空');
            }

            $condition_card_set = " AND uniacid=:uniacid AND setting_name=:setting_name ";
            $params_card_set = array(':uniacid' => $_W['uniacid'], ':setting_name'=>'set_card_set_settings');
            $set_card_set = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_settings') . ' WHERE 1 ' . $condition_card_set, $params_card_set);

            $card_count = 0;
            $card_num = 0;  // 可以同步的名片数
            if ($set_card_set) {
                $set_card_set_str = json_decode($set_card_set['setting_value'], true);

                if ($set_card_set_str['card_num']) {
                    $card_num = $set_card_set_str['card_num'];
                }
            }

            // 查出所有用户
            $condition_alluser = " AND uniacid=:uniacid ";
            $params_alluser = array(':uniacid' => $_W['uniacid']);
            $sql_alluser = "SELECT id,userid,attr FROM " . tablename('slwl_aicard_card'). ' WHERE 1 ' . $condition_alluser . " ORDER BY id ASC ";
            $list_alluser = pdo_fetchall($sql_alluser, $params_alluser);

            // dump($list_alluser);exit;

            // 删除本地多余账号
            // $del_user = array();
            // $del_num = 0;
            // foreach ($list_alluser as $k => $v) {
            //     $del_item = '1';
            //     foreach ($list_qy['data'] as $key => $value) {
            //         if ($v['userid'] == $value['userid']) {
            //             if ($card_num == 0 || $card_num > $del_num) {
            //                 $del_num += 1;
            //                 $del_item = '0';
            //                 break;
            //             }
            //         }
            //     }
            //     if ($del_item == '1') {
            //         array_push($del_user, $v);
            //     }
            // }
            // // dump($del_user);exit;
            // if ($del_user) {
            //     foreach ($del_user as $item) {
            //         $flags .= $item['id'] . ',';
            //     }
            //     $flags = substr($flags, 0, strlen($flags)-1);
            //     $where = ' WHERE id IN(' . $flags . ') AND uniacid='.$_W['uniacid'];

            //     $sql = 'DELETE FROM ' . tablename('slwl_aicard_card') . $where;
            //     pdo_run($sql); // 执行SQL语句
            // }

            // 先清除所有默认
            if ($list_alluser) {
                pdo_update('slwl_aicard_card', array('isdefault'=>'0'), array('uniacid' => $_W['uniacid']));
            }

            // $is_default = '0';

            foreach ($list_qy['data'] as $k => $v) {
                if ($card_num > 0) {
                    $card_count += 1;
                }
                if ($card_count > $card_num) {
                    iajax(1, '已超出最大名片数，可以在名片其他设置->名片设置中配置');
                    break;
                }
                if ($list_alluser) {
                    $ins = '0';
                } else {
                    $ins = '1';
                }
                foreach ($list_alluser as $key => $value) {
                    if ($v['userid']==$value['userid']) {
                        $data_1 = array();
                        // if ($v['name']!='')  { $data_1['first_name']   = $v['name']; }
                        // if ($v['position']!='')  { $data_1['honour']   = $v['position']; }
                        if ($v['mobile']!='')  { $data_1['mobile']   = $v['mobile']; }
                        if ($v['email']!='')  { $data_1['email']   = $v['email']; }

                        pdo_update('slwl_aicard_card', $data_1, array('userid' => $value['userid']));
                        $ins = '0';
                        break;
                    } else {
                        $ins = '1';
                    }

                }

                if ($ins == '1') {
                    $smeta_2 = array();
                    $smeta_2['enabled'] = '1';
                    $smeta_2['items'] = array();

                    $data_2 = array(
                        'userid' => $v['userid'],
                        'uniacid' => $_W['uniacid'],
                        'first_name' => $v['name'],
                        'honour' => $v['position'],
                        'mobile' => $v['mobile'],
                        'mobile_show' => $v['mobile'],
                        'email' => $v['email'],
                        'thumb' => $v['avatar'],
                        'view' => '100',
                        'like' => '200',
                        'relay' => '50',
                        'enabled' => '1',
                    );

                    // if ($is_default == '0') {
                    //     $data_2['isdefault'] = '1';
                    // }

                    $res = pdo_insert('slwl_aicard_card', $data_2);

                    // $is_default = '1';
                }
            }

            iajax(0, '操作成功！');
            exit;
        } else {
            iajax(1, $list_qy['errmsg'].'-'.$list_qy['data']);
            exit;
        }
    }


} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);

    if ($_W['ispost']) {
        $def = intval($_GPC['isdefault']);

        if ($def > 0) {
            pdo_update('slwl_aicard_card', array('isdefault' => '0'), array('uniacid' => $_W['uniacid']));
        }

        $other_attr_data = array(
            'sign_show' => intval($_GPC['sign_show']),
            'sign' => $_GPC['sign'],
            'impression_show' => intval($_GPC['impression_show']),
            'video_show' => intval($_GPC['video_show']),
            'video_poster' => $_GPC['video_poster'],
            'video' => $_GPC['video'],
            'audio_title' => $_GPC['audio_title'],
            'audio_show' => intval($_GPC['audio_show']),
            'audio' => $_GPC['audio'],
            'audio_autoplay' => intval($_GPC['audio_autoplay']),
            'share_title_status' => intval($_GPC['share_title_status']),
            'share_title_cont' => $_GPC['share_title_cont'],
            'welcomes_status' => intval($_GPC['welcomes_status']),
            'welcomes_cont' => $_GPC['welcomes_cont'],
            'official_account_status' => intval($_GPC['official_account_status']),
            'address_books_status' => intval($_GPC['address_books_status']),
            'recommend_goods_status' => intval($_GPC['recommend_goods_status']),
        );

        $data = array(
            'uniacid' => $_W['uniacid'],
            'userid' => $_GPC['mobile'],
            'displayorder' => $_GPC['displayorder'],
            'title' => $_GPC['title'],
            'nick_name' => $_GPC['nick_name'],
            'last_name' => $_GPC['last_name'],
            'middle_name' => $_GPC['middle_name'],
            'first_name' => $_GPC['first_name'],
            'honour' => $_GPC['honour'],
            'thumb' => $_GPC['thumb'],
            'mobile' => $_GPC['mobile'],
            'mobile_show' => $_GPC['mobile_show'],
            'email' => $_GPC['email'],
            'view' => $_GPC['view'],
            'like' => $_GPC['like'],
            'relay' => $_GPC['relay'],
            'isdefault' => $def,
            'other_attr' => json_encode($other_attr_data),
            'pic_show' => intval($_GPC['pic_show']),
            'pic_title' => $_GPC['pic_title'],
            'pic_content' => htmlspecialchars_decode($_GPC['pic_content']),
            'card_style' => $_GPC['card_style'],
            'enabled' => intval($_GPC['enabled']),
        );
        if ($id) {
            unset($data['userid']);
            unset($data['mobile']);
            unset($data['email']);
            $rst = pdo_update('slwl_aicard_card', $data, array('id' => $id));

            $rst = set_card_head($id);
            if ($rst !== false) {
                iajax(0, '保存成功！');
            } else {
                iajax(1, '保存失败！');
            }
        } else {
            $add_user_data = array(
                'user_id'=>$_GPC['mobile'],
                'uname'=>$_GPC['last_name'].$_GPC['first_name'],
                'mobile'=>$_GPC['mobile'],
                'email'=>$_GPC['email'],
                'head_img'=>tomedia($_GPC['thumb']),
            );
            $rst_add_user = address_book_user_add($add_user_data);

            @putlog('通讯录用户-添加', $rst_add_user);

            // dump($rst_add_user);exit;
            if ($rst_add_user['errcode'] == '0') {
                $data['addtime'] = $_W['slwl']['datetime']['now'];
                pdo_insert('slwl_aicard_card', $data);
                $id = pdo_insertid();

                iajax(0, '保存成功！');
            } else {
                iajax(1, $rst_add_user['errmsg']);
            }
        }
    }
    $condition = " AND uniacid=:uniacid AND id=:id ";
    $params = array(':uniacid' => $_W['uniacid'], ':id' => $id);
    $one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition, $params);

    if ($one) {
        $other_attr = json_decode($one['other_attr'], true);

        $one['sign_show'] = $other_attr['sign_show'];
        $one['sign'] = $other_attr['sign'];
        // 印象
        $one['impression_show'] = $other_attr['impression_show'];
        // 视频
        $one['video_show'] = $other_attr['video_show'];
        $one['video_poster'] = $other_attr['video_poster'];
        $one['video'] = $other_attr['video'];
        // 音频
        $one['audio_title'] = $other_attr['audio_title'];
        $one['audio_show'] = $other_attr['audio_show'];
        $one['audio'] = $other_attr['audio'];
        $one['audio_autoplay'] = $other_attr['audio_autoplay'];
        $one['share_title_status'] = $other_attr['share_title_status'];
        $one['share_title_cont'] = $other_attr['share_title_cont'];
        $one['welcomes_status'] = $other_attr['welcomes_status'];
        $one['welcomes_cont'] = $other_attr['welcomes_cont'];
        $one['official_account_status'] = $other_attr['official_account_status'];
        $one['address_books_status'] = $other_attr['address_books_status'];
        $one['recommend_goods_status'] = $other_attr['recommend_goods_status'];
    }


} elseif ($operation == 'post_switch_ai') {
    $id = intval($_GPC['id']);
    $s_status = intval($_GPC['status']);

    $rst = set_card_status_ai($id, $s_status);

    if ($rst['errcode'] == '0') {
        iajax(0, '调整成功！');
    } else {
        iajax(1, $rst['errmsg']);
    }
    exit;


} elseif ($operation == 'post_switch_boss') {
    $id = intval($_GPC['id']);
    $s_status = intval($_GPC['status']);

    $rst = set_card_status_boss($id, $s_status);

    if ($rst['errcode'] == '0') {
        iajax(0, '调整成功！');
    } else {
        iajax(1, $rst['errmsg']);
    }
    exit;


} elseif ($operation == 'post_switch_enabled') {
    $id = intval($_GPC['id']);
    $s_status = intval($_GPC['status']);

    $se_data = array(
        'enabled' => $s_status,
    );
    $rst = pdo_update('slwl_aicard_card', $se_data, array('id' => $id));

    if ($rst !== false) {
        iajax(0, '调整成功！');
    } else {
        iajax(1, '调整失败！');
    }
    exit;


} elseif ($operation == 'post_switch_isdefault') {
    $id = intval($_GPC['id']);
    $s_status = intval($_GPC['status']);

    pdo_update('slwl_aicard_card', array('isdefault' => '0'), array('uniacid' => $_W['uniacid']));
    $rst = pdo_update('slwl_aicard_card', array('isdefault' => '1'), array('id' => $id));

    if ($rst !== false) {
        iajax(0, '调整成功！');
    } else {
        iajax(1, '调整失败！');
    }
    exit;


} elseif ($operation == 'post_info') {
    $id = intval($_GPC['id']);

    if ($_W['ispost']) {

        $options = array();
        $data = array();
        $photo = array();
        $tmp_pic = array();

        if ($_GPC['options']) {
            $options = $_GPC['options'];
            // dump($options);exit;

            foreach ($options['title'] as $k => $v) {
                $tmp_pic[$k]['title'] = $v;
            }
            foreach ($options['content'] as $k => $v) {
                $tmp_pic[$k]['content'] = $v;
            }
            foreach ($options['page_url'] as $k => $v) {
                $tmp_pic[$k]['page_url'] = $v;
            }
            foreach ($options['optips'] as $k => $v) {
                $tmp_pic[$k]['optips'] = $v;
            }
            foreach ($tmp_pic as $k=>$v){
                $photo['items'][] = $v;
            }
        }
        $photo['enabled'] = $_GPC['enabled'];
        $photo['style'] = $_GPC['style'];

        $data['attr'] = json_encode($photo); // 压缩

        if ($id > 0) {
            pdo_update('slwl_aicard_card', $data, array('id' => $id));
        }
        iajax(0, '保存成功！');
    }

    $card_mobile = '';
    $card_email = '';

    $condition = " AND uniacid=:uniacid AND id=:id ";
    $params = array(':uniacid' => $_W['uniacid'], ':id' => $id);
    $one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition, $params);

    if ($one) {
        $smeta = json_decode($one['attr'], true);

        if ($smeta['items']) {
            foreach ($smeta['items'] as $key => $value) {
                if ($value['page_url'] == 'people') {
                    $card_mobile= $value['content'];
                    break;
                }
                if ($value['page_url'] == 'email') {
                    $card_email= $value['content'];
                    break;
                }
            }
        }
    }

    $condition_set = ' AND uniacid=:uniacid AND setting_name=:setting_name ';
    $params_set = array(':uniacid' => $_W['uniacid'], ':setting_name'=>'site_settings');
    $set_set = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_settings') . ' WHERE 1 ' . $condition_set, $params_set);

    if ($set_set) {
        $smeta_set = json_decode($set_set['setting_value'], true);

        if (empty($smeta_set['company'])) { $smeta_set['company'] = 'AI超级智能名片'; }
        if ($card_mobile == '') {
            if (empty($one['mobile_show'])) {
                $card_mobile = $smeta_set['tel']==''?'07566951614':$smeta_set['tel'];
            } else {
                $card_mobile = $one['mobile_show'];
            }
        }
        if ($card_email == '') {
            if (empty($one['email'])) {
                $card_email = $smeta_set['email']==''?'email@163.com':$smeta_set['email'];
            } else {
                $card_email = $one['email'];
            }
        }
    }


} elseif ($operation == 'post_goods') {
    $card_id = intval($_GPC['id']);

    $condition = " AND uniacid=:uniacid AND id=:id ";
    $params = array(':uniacid' => $_W['uniacid'], ':id' => $card_id);
    $one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition, $params);


} elseif ($operation == 'post_goods_table') {
    $card_id = intval($_GPC['id']);

    $condition = " AND uniacid=:uniacid AND id=:id ";
    $params = array(':uniacid' => $_W['uniacid'], ':id' => $card_id);
    $one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition, $params);

    $condition_mygood = " AND uniacid=:uniacid AND card_id=:card_id ";
    $params_mygood = array(':uniacid' => $_W['uniacid'], ':card_id' => $card_id);
    $pindex_mygood = max(1, intval($_GPC['page']));
    $psize_mygood = 10;
    $sql_mygood = "SELECT * FROM " . tablename('slwl_aicard_card_goods') . ' WHERE 1 '
        . $condition_mygood . " ORDER BY id DESC LIMIT " . ($pindex_mygood - 1) * $psize_mygood .',' .$psize_mygood;
    $list_mygood = pdo_fetchall($sql_mygood, $params_mygood);

    if ($list_mygood) {
        $flags = '';
        foreach ($list_mygood as $item) {
            $flags .= $item['good_id'] . ',';
        }
        $flags = substr($flags, 0, strlen($flags)-1);
        $where =' AND id IN(' . $flags . ')';

        $condition = " AND uniacid=:uniacid AND deleted='0' ";
        $condition .= $where;
        $params = array(':uniacid' => $_W['uniacid']);
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $sql = "SELECT * FROM " . tablename('slwl_aicard_store_goods'). ' WHERE 1 '
            . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

        $list_goods = pdo_fetchall($sql, $params);
        if ($list_goods) {
            foreach ($list_goods as $k => $v) {
                foreach ($list_mygood as $key => $value) {
                    if ($v['id'] == $value['good_id']) {
                        $list_goods[$k]['good_id'] = $v['id'];
                        $list_goods[$k]['id'] = $value['id'];
                        break;
                    }
                }
            }
            $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_card_goods') . ' WHERE 1 '
                . $condition_mygood, $params_mygood);
            // $pager = pagination($total, $pindex_mygood, $psize_mygood);
        }
    }
    $data_return = array(
        'code' => '0',
        'msg' => '',
        'count' => $total,
        'data' => $list_goods,
    );
    echo json_encode($data_return);
    exit;


} elseif ($operation == 'delete_post_goods') {

    $post = file_get_contents('php://input');
    if (!$post) {iajax(1, '参数不存在'); }

    $params = @json_decode($post, true);
    if (!$params) { iajax(1, '参数解析出错'); }

    $ids = isset($params['ids']) ? $params['ids'] : '';
    if (!$ids) { iajax(1, 'ID为空'); }

    foreach ($ids as $k => $v) {
        $flags .= $v . ',';
    }
    $flags = substr($flags, 0, strlen($flags)-1);
    $where = ' id IN(' . $flags . ')';

    $rst = @pdo_delete('slwl_aicard_card_goods', $where);

    if ($rst !== false) {
        iajax(0, '成功');
    } else {
        iajax(1, '不存在或已删除');
    }


} elseif ($operation == 'delete_good_all') {
    $card_id = intval($_GPC['cid']);

    if ($_W['ispost']) {
        $bak_id = pdo_delete('slwl_aicard_card_goods', array('card_id' => $card_id, 'uniacid'=>$_W['uniacid']));
        if ($bak_id) {
            iajax(0, '删除成功！');
        } else {
            iajax(1, '删除失败或没有内容被删除！');
        }
    }


} elseif ($operation == 'build') {
    $id = intval($_GPC['id']);

    require_once MODULE_ROOT . "/lib/Common.class.php";

    $app = Common::get_app_info($_W['uniacid']);

    require_once MODULE_ROOT . "/lib/jssdk/jssdk.php";
    $jssdk = new JSSDK($app['appid'], $app['secret'], 'token_name_'.$_W['uniacid']);

    $rets = $jssdk->qrcode_create($id);

    if ($rets && $rets['errcode'] == 0) {
        pdo_update('slwl_aicard_card', array('qrcode' => $rets['data']), array('id' => $id));

        $res = array(
            'thumb_url'=> tomedia($rets['data']),
        );

        iajax(0, $res);
    } else {
        iajax(1, $rets['errmsg'].'-'.$rets['data']);
    }


} elseif ($operation == 'delete') {

    $post = file_get_contents('php://input');
    if (!$post) {iajax(1, '参数不存在'); }

    $params = @json_decode($post, true);
    if (!$params) { iajax(1, '参数解析出错'); }

    $ids = isset($params['ids']) ? $params['ids'] : '';
    if (!$ids) { iajax(1, 'ID为空'); }

    foreach ($ids as $k => $v) {
        $flags .= $v . ',';
    }
    $flags = substr($flags, 0, strlen($flags)-1);
    $where = ' id IN(' . $flags . ')';

    $rst = @pdo_delete('slwl_aicard_card', $where);

    if ($rst !== false) {
        $data_add_user = array(
            'user_id'=>$one['userid'],
        );
        $rst_add_del = address_book_user_del($data_add_user);

        @putlog('通讯录用户-删除', $rst_add_del);

        iajax(0, '成功');
    } else {
        iajax(1, '不存在或已删除');
    }





// 我的印象
} elseif ($operation == 'post_impression') {
    $id = intval($_GPC['id']);

    $condition = " AND uniacid=:uniacid AND id=:id ";
    $params = array(':uniacid' => $_W['uniacid'], ':id' => $id);
    $one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition, $params);


} else if ($operation == 'post_impression_table') {
    $card_id = intval($_GPC['id']);

    $condition = " AND uniacid=:uniacid AND id=:id ";
    $params = array(':uniacid' => $_W['uniacid'], ':id' => $card_id);
    $one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition, $params);

    if (empty($one)) { message('名片不存在'); }

    $keyword = $_GPC['keyword'];

    $condition_impression = " AND uniacid=:uniacid AND card_id=:card_id ";
    $params_impression = array(':uniacid' => $_W['uniacid'], ':card_id' => $card_id);
    $pindex_impression = max(1, intval($_GPC['page']));
    $psize_impression = 10;

    if ($keyword != '') {
        $condition_impression .= " AND title LIKE :title ";
        $params_impression[':title'] = '%'.$keyword.'%';
    }

    $sql_impression = "SELECT * FROM " . tablename('slwl_aicard_impression') . ' WHERE 1 '
        . $condition_impression . " ORDER BY id DESC LIMIT " . ($pindex_impression - 1) * $psize_impression .','
        . $psize_impression;
    $list_impression = pdo_fetchall($sql_impression, $params_impression);

    if ($list_impression) {
        foreach ($list_impression as $k => $v) {
            $list_impression[$k]['enabled_format'] = $v['enabled'] ? '启用':'禁用';
        }
        $total_impression = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_impression') . ' WHERE 1 '
            . $condition_impression, $params_impression);
        // $pager = pagination($total_impression, $pindex_impression, $psize_impression);
    }
    $data_return = array(
        'code' => '0',
        'msg' => '',
        'count' => $total_impression,
        'data' => $list_impression,
    );
    echo json_encode($data_return);
    exit;


// 我的印象-添加-编辑
} elseif ($operation == 'post_impression_post') {
    $card_id = intval($_GPC['id']);
    $id_im = intval($_GPC['id_im']);

    if (empty($card_id)) { iajax(1, '名片ID不存在'); }

    if ($_W['ispost']) {
        $data = array(
            'displayorder' => $_GPC['displayorder'],
            'title' => $_GPC['title'],
            'card_id' => $card_id,
            'enabled' => intval($_GPC['enabled']),
            'like_count' => intval($_GPC['like_count']),
        );
        if ($id_im) {
            pdo_update('slwl_aicard_impression', $data, array('id' => $id_im));
        } else {
            $data['uniacid'] = $_W['uniacid'];
            $data['addtime'] = $_W['slwl']['datetime']['now'];
            pdo_insert('slwl_aicard_impression', $data);
            $id = pdo_insertid();
        }
        iajax(0, '保存成功！');
    }

    $condition = " AND uniacid=:uniacid AND id=:id ";
    $params = array(':uniacid' => $_W['uniacid'], ':id' => $card_id);
    $one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition, $params);

    $condition_im = " AND uniacid=:uniacid AND id=:id ";
    $params_im = array(':uniacid' => $_W['uniacid'], ':id' => $id_im);
    $one_im = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_impression') . ' WHERE 1 ' . $condition_im, $params_im);


} elseif ($operation == 'delete_impression') {

    $post = file_get_contents('php://input');
    if (!$post) {iajax(1, '参数不存在'); }

    $params = @json_decode($post, true);
    if (!$params) { iajax(1, '参数解析出错'); }

    $ids = isset($params['ids']) ? $params['ids'] : '';
    if (!$ids) { iajax(1, 'ID为空'); }

    foreach ($ids as $k => $v) {
        $flags .= $v . ',';
    }
    $flags = substr($flags, 0, strlen($flags)-1);
    $where = ' id IN(' . $flags . ')';

    $rst = @pdo_delete('slwl_aicard_impression', $where);

    if ($rst !== false) {
        iajax(0, '成功');
    } else {
        iajax(1, '不存在或已删除');
    }


} else {
    message('请求方式不存在');
}

include $this->template('web/card');

?>