<?php
global $_GPC, $_W;

//    根据 op 执行不同操作
switch($_GPC['op']){
//    数据查询
    case "query":
        $where = [];
        if($_GPC['key']){
            $where[] ="t1.name LIKE '%{$_GPC['key']}%'";
        }
        if($_GPC['menu_id']){
            $where[] ="t1.menu_id = ".$_GPC['menu_id'];
        }
        $this->query2($where);
        exit();
    case "menuselect":
        $sql = "select id,name as text,CONCAT(id,name,code) as keywords from ".tablename('yzhyk_sun_menu')."";

        $list = pdo_fetchall($sql);
        echo json_encode($list);
        break;
//    保存-新增、修改
    case "save":
        $rst=pdo_get('yzhyk_sun_menu',array('name'=>$_GPC['name'],'id !='=>$_GPC['id']));

        $data['name'] = $_GPC['name'];
        $data['code'] = $_GPC['code'];
        $data['icon'] = $_GPC['icon'];
        $data['menu_do'] = $_GPC['menu_do'];
        $data['menu_op'] = $_GPC['menu_op'];
        $data['prams'] = $_GPC['prams'];
        $data['memo'] = $_GPC['memo'];
        $data['menu_id'] = $_GPC['menu_id'];
        $data['menu_index'] = $_GPC['menu_index'];

        $this->save($data);
        break;
    case "reset":
        $res = pdo_query("
DROP TABLE IF EXISTS `".tablename('yzhyk_sun_menu')."`;
CREATE TABLE `".tablename('yzhyk_sun_menu')."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `menu_do` varchar(50) DEFAULT NULL,
  `menu_op` varchar(50) DEFAULT NULL,
  `prams` varchar(100) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `menu_index` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('2', '门店管理', '', '', '', '0', '', 'fa fa-bank', '', '3');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('3', '商品管理', '', '', '', '0', '', 'fa fa-hdd-o', '', '2');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('4', '营销管理', '', '', '', '0', '', 'fa fa-cny', '', '4');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('5', '订单管理', '', '', '', '0', '', 'fa fa-pencil-square', '', '6');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('6', '充值管理', '', '', '', '0', '', 'fa fa-pied-piper', '', '5');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('7', '会员管理', '', '', '', '0', '', 'fa fa-credit-card', 'member', '7');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('9', '权限管理', '', '', '', '0', '', 'fa fa-external-link', '', '10');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('10', '系统设置', '', '', '', '0', '', 'fa fa-cogs', '', '11');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('11', '门店列表', 'store', '', null, '2', null, null, null, null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('14', '门店商品', 'storegoods', '', null, '2', null, null, null, null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('15', '门店抢购', 'storeactivity', '', null, '2', null, null, null, null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('16', '商品列表', 'goods', '', null, '3', null, null, null, null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('18', '分类列表', 'goodsclass', '', null, '3', null, null, null, null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('19', '抢购列表', 'activity', '', null, '4', null, null, null, null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('21', '优惠券列表', 'coupon', '', null, '4', null, null, null, null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('23', '商城订单', 'order', '', null, '5', null, null, null, null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('24', '扫码购订单', 'orderscan', '', null, '5', null, null, null, null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('25', '线上支付订单', 'orderonline', '', null, '5', null, null, null, null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('26', '充值管理', 'recharge', '', null, '6', null, null, null, null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('27', '会员等级管理', 'cardlevel', '', null, '7', null, null, null, null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('28', '会员列表', 'user2', '', '', '7', '', 'fa fa-external-link', '', '0');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('29', '积分明细', 'integral', '', '', '7', '', 'fa fa-external-link', '', '0');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('30', '余额账单', 'bill', '', '', '7', '', 'fa fa-external-link', '', '0');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('32', '平台设置', 'system', 'baseinfo', '', '10', '', 'fa fa-external-link', '', '0');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('33', '技术支持', 'system', 'team', '', '10', '', 'fa fa-external-link', '', '0');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('34', '活动设置', 'system', 'activity', null, '10', null, null, null, null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('35', '积分设置', 'system', 'integral', null, '10', null, null, null, null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('36', '配送设置', 'system', 'postage', null, '10', null, null, null, null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('38', '广告设置', 'system', 'ad', '', '48', '', 'fa fa-external-link', 'assetting', null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('39', '小程序配置', 'system', 'smallapp', null, '10', null, null, null, null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('40', '小程序样式设置', 'system', 'smallappstyle', null, '10', null, null, null, null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('41', '角色管理', 'role', '', '', '9', '', 'fa fa-graduation-cap', null, null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('45', '用户角色', 'userrole', '', '', '9', '', 'fa fa-external-link', 'userrole', null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('46', '模板消息', 'system', 'template', '', '10', '', 'fa fa-external-link', 'template', null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('47', '充值说明', 'recharge', 'setting', '', '6', '', 'fa fa-external-link', 'sss', null);
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('48', '广告管理', '', '', '', '0', '', 'fa fa-file-audio-o', 'ad', '8');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('49', '平台数据', 'index', 'display', '', '0', '', 'fa fa-external-link', 'index', '1');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('50', '用户管理', 'admin', '', '', '9', '', 'fa fa-external-link', 'admin', '0');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('51', '底部菜单', 'tab', '', '', '10', '', 'fa fa-external-link', '', '0');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('52', '会员设置', 'system', 'member', '', '10', '', 'fa fa-external-link', '', '0');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('53', '会员充值卡', 'membercard', '', '', '7', '', 'fa fa-external-link', '', '0');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('54', '拼团列表', 'groupgoods', '', '', '4', '', 'fa fa-external-link', '', '0');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('55', '门店拼团', 'storegroupgoods', '', '', '2', '', 'fa fa-external-link', '', '0');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('56', '拼团订单', 'group', '', '', '5', '', 'fa fa-external-link', '', '0');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('57', '首页菜单', 'appmenu', '', '', '10', '', 'fa fa-external-link', '', '0');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('58', '砍价列表', 'cutgoods', '', '', '4', '', 'fa fa-external-link', '', '0');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('59', '门店砍价', 'storecutgoods', '', '', '2', '', 'fa fa-external-link', '', '0');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('60', '门店优惠券', 'storecoupon', '', '', '2', '', 'fa fa-external-link', '', '0');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('61', '报表管理', '', '', '', '0', '', 'fa fa-bar-chart-o', '', '9');
INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('62', '盘点表', 'report', 'display', '', '61', '', 'fa fa-external-link', '', '0');

-- INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('31', '菜单管理', 'menu', '', null, '9', null, null, null, null);
-- INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('42', '按钮管理', 'button', '', '', '9', '', 'fa fa-external-link', 'button', null);
-- INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('44', '菜单按钮', 'menubutton', '', '', '9', '', 'fa fa-external-link', 'menubutton', null);

-- INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('12', '门店新增', 'store', 'add', null, '2', null, null, null, null);
-- INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('17', '商品新增', 'goods', 'add', null, '3', null, null, null, null);
-- INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('20', '活动新增', 'activity', 'add', null, '4', null, null, null, null);
-- INSERT INTO ".tablename('yzhyk_sun_menu')." VALUES ('22', '优惠券新增', 'coupon', 'add', null, '4', null, null, null, null);

DROP TABLE IF EXISTS `".tablename('yzhyk_sun_button')."`;
CREATE TABLE `".tablename('yzhyk_sun_button')."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `memo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

INSERT INTO `".tablename('yzhyk_sun_button')."` VALUES ('11', '新增', 'add', '');
INSERT INTO `".tablename('yzhyk_sun_button')."` VALUES ('12', '批量删除', 'batchDelete', '');
INSERT INTO `".tablename('yzhyk_sun_button')."` VALUES ('13', '编辑', 'edit', '');
INSERT INTO `".tablename('yzhyk_sun_button')."` VALUES ('14', '删除', 'delete', '');
INSERT INTO `".tablename('yzhyk_sun_button')."` VALUES ('15', '复制新增', 'copyAdd', '');
INSERT INTO `".tablename('yzhyk_sun_button')."` VALUES ('16', '选择商品', 'chooseGoods', '');
INSERT INTO `".tablename('yzhyk_sun_button')."` VALUES ('17', '修改销售价', 'batchPrice', '');
INSERT INTO `".tablename('yzhyk_sun_button')."` VALUES ('18', '修改库存', 'batchStock', '');
INSERT INTO `".tablename('yzhyk_sun_button')."` VALUES ('19', '推荐', 'hot', '');
INSERT INTO `".tablename('yzhyk_sun_button')."` VALUES ('20', '取消推荐', 'unHot', '');
INSERT INTO `".tablename('yzhyk_sun_button')."` VALUES ('21', '选择活动', 'chooseActivity', '');
INSERT INTO `".tablename('yzhyk_sun_button')."` VALUES ('22', '启用', 'enable', '');
INSERT INTO `".tablename('yzhyk_sun_button')."` VALUES ('23', '禁用', 'unEnable', '');
INSERT INTO `".tablename('yzhyk_sun_button')."` VALUES ('24', '发货', 'send', '');
INSERT INTO `".tablename('yzhyk_sun_button')."` VALUES ('25', '绑定', 'bind', '');
INSERT INTO `".tablename('yzhyk_sun_button')."` VALUES ('26', '解绑', 'unBind', '');


DROP TABLE IF EXISTS `".tablename('yzhyk_sun_menubutton')."`;
CREATE TABLE `".tablename('yzhyk_sun_menubutton')."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT NULL,
  `button_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        ");
        message('还原成功',$this->createWebUrl('menu',array()),'success');
        break;
//    调用公共的方法
    default:
        $fun_name = $_GPC['op'];
        if(method_exists($this,$fun_name)){
            $this->{$fun_name}();
        }else{
            $this->display();
        }

}
