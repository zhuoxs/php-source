-- 用户表
create table ims_longbing_card_user(
    id INT NOT NULL AUTO_INCREMENT,
    openid VARCHAR(100) NOT NULL DEFAULT '',
    nickName VARCHAR(100) NOT NULL DEFAULT '',
    avatarUrl VARCHAR(300) NOT NULL DEFAULT '',
    pid INT(10) NOT NULL DEFAULT 0 COMMENT '上级id',
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
);

-- 商品表
create table ims_longbing_card_goods(
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(500) NOT NULL DEFAULT '' COMMENT '',
    cover VARCHAR(500) NOT NULL DEFAULT '' COMMENT '商品封面图',
    images VARCHAR(5000) NOT NULL DEFAULT '' COMMENT '商品轮播图',
    price INT(10) NOT NULL DEFAULT 0 COMMENT '商品价格',
    view_count INT(10) NOT NULL DEFAULT 0 COMMENT '商品浏览量',
    sale_count INT(10) NOT NULL DEFAULT 0 COMMENT '商品销售量',
    `desc` VARCHAR(500) NOT NULL DEFAULT '' COMMENT '商品简介',
    content text,
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 企业咨询表
create table ims_longbing_card_articles(
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL DEFAULT '' COMMENT '标题',
    cover VARCHAR(500) NOT NULL DEFAULT '' COMMENT '封面图',
    view_count INT(10) NOT NULL DEFAULT 0 COMMENT '浏览量',
    top INT(10) NOT NULL DEFAULT 0 COMMENT '排序值',
    content text,
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 员工展示表
create table ims_longbing_card_staffs(
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL DEFAULT '' COMMENT '标题',
    cover VARCHAR(500) NOT NULL DEFAULT '' COMMENT '头像',
    job VARCHAR(20) NOT NULL DEFAULT 0 COMMENT '职位',
    experience1 VARCHAR(100) NOT NULL DEFAULT 0 COMMENT '经历1',
    experience2 VARCHAR(100) NOT NULL DEFAULT 0 COMMENT '经历2',
    experience3 VARCHAR(100) NOT NULL DEFAULT 0 COMMENT '经历3',
    top INT(10) NOT NULL DEFAULT 0 COMMENT '排序值',
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 官网模型表
create table ims_longbing_card_modular(
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL DEFAULT '' COMMENT '模块名',
    show_name INT(3) NOT NULL DEFAULT 1 COMMENT '前台是否显示模块名',
    cover VARCHAR(500) NOT NULL DEFAULT '' COMMENT '图标',
    identification VARCHAR(20) NOT NULL DEFAULT 0 COMMENT '模块标识',
    table_name VARCHAR(200) NOT NULL DEFAULT 0 COMMENT '表名',
    type INT(3) NOT NULL DEFAULT 1 COMMENT '1=>文章列表, 2=>图文详情, 3=>招聘信息, 4=>联系我们, 5=>员工展示',
    top INT(10) NOT NULL DEFAULT 0 COMMENT '排序值',
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 商品收藏表
create table ims_longbing_card_goods_collection(
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL COMMENT '用户的fans_id',
    goods_id INT NOT NULL COMMENT '商品id',
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 公司动态表
create table ims_longbing_card_timeline(
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL COMMENT '标题',
    cover VARCHAR(1200) NOT NULL DEFAULT '' COMMENT '封面图',
    content TEXT,
    top INT(10) NOT NULL DEFAULT 0 COMMENT '排序值',
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 公司动态点赞表
create table ims_longbing_card_timeline_thumbs(
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL,
    timeline_id INT(10) NOT NULL,
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 公司动态评论表
create table ims_longbing_card_timeline_comment(
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL,
    timeline_id INT(10) NOT NULL,
    content VARCHAR(1000) NOT NULL DEFAULT '' COMMENT '内容',
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 名片基础配置表
create table ims_longbing_card_config(
    id INT NOT NULL AUTO_INCREMENT,
    multi INT NOT NULL DEFAULT 0 COMMENT '是否允许一个用户拥有多张名片',
    show_card INT NOT NULL DEFAULT 0 COMMENT '是否显示名片',
    uniacid INT(10) NOT NULL,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 用户浏览内容记录表
create table ims_longbing_card_view_count(
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL,
    to_uid INT(10) NOT NUll,
    type INT(3) NOT NUll COMMENT '浏览内容, 1=>浏览商城列表 2=>浏览商品详情 3=>浏览动态列表 4=>点赞动态 5=>动态留言 6=>浏览公司官网 7=>浏览动态详情',
    target VARCHAR(200) NOT NULL DEFAULT '',
    uniacid INT(10) NOT NULL,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 用户操作内容记录表
create table ims_longbing_card_copy_count(
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL,
    to_uid INT(10) NOT NUll,
    type INT(3) NOT NUll COMMENT '操作内容, 1=>同步到通讯录 2=>拨打手机号 3=>拨打座机号 4=>复制微信 5=>复制邮箱 6=>复制公司名 7=>查看定位 8=>咨询产品 9=>播放语音',
    target VARCHAR(200) NOT NULL DEFAULT '',
    uniacid INT(10) NOT NULL,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 用户formId 记录表
create table ims_longbing_card_formId (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL,
    formId VARCHAR(100) NOT NULL,
    status INT(3) NOT NULL DEFAULT 0 COMMENT '1=>未使用过 2=>使用过',
    uniacid INT(10) NOT NULL,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 聊天记录表
create table ims_longbing_card_message (
    id INT NOT NULL AUTO_INCREMENT,
    chat_id INT(10) NOT NULL COMMENT '会话记录表id',
    user_id INT(10) NOT NULL COMMENT '发送消息用户id',
    target_id INT(10) NOT NULL COMMENT '接收消息用户id',
    content TEXT COMMENT '消息内容',
    status INT(3) NOT NULL DEFAULT 1 COMMENT '1=>未读消息 2=>已读 3=>已撤销 4=>已删除',
    uniacid INT(10) NOT NULL,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 会话记录表
create table ims_longbing_card_chat (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL COMMENT '发起会话的用户id',
    target_id INT(10) NOT NULL COMMENT '会话对象用户id',
    type INT(3) NOT NULL DEFAULT 1  COMMENT '类型: 1=>one2one 2=>gourp',
    gourp_ids TEXT COMMENT '此群组中的用户id',
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    uniacid INT(10) NOT NULL,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 用户授权手机号表
create table ims_longbing_card_user_phone (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL COMMENT '发起会话的用户id',
    to_uid INT(10) NOT NUll,
    phone VARCHAR(20) NOT NULL COMMENT '手机号',
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    uniacid INT(10) NOT NULL,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 员工主推产品表
create table ims_longbing_card_extension (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL COMMENT '员工id',
    goods_id INT(10) NOT NUll,
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    uniacid INT(10) NOT NULL,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

alter table ims_longbing_card_timeline add column user_id int (10) not null default 0;

-- 员工自定义码表
create table ims_longbing_card_custom_qr (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL COMMENT '员工id',
    title VARCHAR(100) NOT NULL COMMENT '自定义码标题',
    content VARCHAR(1000) NOT NULL COMMENT '自定义码内容',
    path VARCHAR(200) NOT NULL DEFAULT '',
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    uniacid INT(10) NOT NULL,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
alter table ims_longbing_card_config add column show_card int (3) not null default 0;

-- 客户标签表
create table ims_longbing_card_label (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL COMMENT '标签',
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    uniacid INT(10) NOT NULL,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 客户标签表
create table ims_longbing_card_user_label (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL COMMENT '用户id',
    staff_id INT(10) NOT NULL COMMENT '员工id',
    lable_id INT(10) NOT NULL COMMENT '标签id',
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    uniacid INT(10) NOT NULL,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 客户信息表
create table ims_longbing_card_client_info (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL COMMENT '用户id',
    staff_id INT(10) NOT NULL COMMENT '员工id',
    name VARCHAR(20) NOT NULL COMMENT '姓名',
    sex VARCHAR(10) NOT NULL COMMENT '性别',
    phone VARCHAR(20) NOT NULL COMMENT '手机号',
    email VARCHAR(20) NOT NULL COMMENT '邮箱',
    company VARCHAR(50) NOT NULL COMMENT '公司',
    position VARCHAR(20) NOT NULL COMMENT '职位',
    address VARCHAR(100) NOT NULL COMMENT '详细地址',
    birthday VARCHAR(20) NOT NULL COMMENT '生日',
    is_mask VARCHAR(3) NOT NULL COMMENT '是否屏蔽',
    remark VARCHAR(500) NOT NULL COMMENT '备注',
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    uniacid INT(10) NOT NULL,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

alter table ims_longbing_card_user add column is_qr int (3) not null default 0;
alter table ims_longbing_card_user add column is_group int (3) not null default 0;
-- type 1=>自定义码, 2=>产品, 3=>动态
alter table ims_longbing_card_user add column `type` int (3) not null default 0;
-- target_id 自定义码, 产品, 动态的 id
alter table ims_longbing_card_user add column `target_id` int (10) not null default 0;

-- 员工分享到群记录
create table ims_longbing_card_share_group (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL COMMENT '员工id',
    openGId VARCHAR(100) NOT NULL COMMENT '群对当前小程序的唯一 ID',
    view_card INT(10) NOT NULL DEFAULT 0 COMMENT '浏览名片的次数',
    view_custom_qr VARCHAR(1000) NOT NULL DEFAULT '' COMMENT '浏览自定义码集合',
    view_goods VARCHAR(1000) NOT NULL DEFAULT '' COMMENT '浏览商品集合',
    view_timeline VARCHAR(1000) NOT NULL DEFAULT '' COMMENT '浏览动态集合',
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    uniacid INT(10) NOT NULL,
    create_time INT(11) NOT NULL DEFAULT 0,
    update_time INT(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 转发记录
create table ims_longbing_card_forward (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL COMMENT '用户转发人的id',
    staff_id INT(10) NOT NULL COMMENT '员工id',
    type INT(3) NOT NULL DEFAULT 1 COMMENT '1=>转发名片 2=>转发商品 3=>转发动态 4=>转发公司官网',
    target_id INT(10) NOT NULL COMMENT '转发内容的id 当type=2,3时有效',
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    uniacid INT(10) NOT NULL,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 用户标记表
create table ims_longbing_card_user_mark (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL COMMENT '用户id',
    staff_id INT(10) NOT NULL COMMENT '员工id',
    mark INT(3) NOT NULL COMMENT '1=>跟进中,2=>已成交',
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    uniacid INT(10) NOT NULL,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 用户跟进记录表
create table ims_longbing_card_user_follow (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL COMMENT '用户id',
    staff_id INT(10) NOT NULL COMMENT '员工id',
    content VARCHAR(200) NOT NULL COMMENT '跟进内容',
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    uniacid INT(10) NOT NULL,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 用户自定义码浏览记录表
create table ims_longbing_card_custom_qr_record (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL COMMENT '用户id',
    staff_id INT(10) NOT NULL COMMENT '员工id',
    qr_id INT(10) NOT NULL DEFAULT 0 COMMENT '自定义码id',
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    uniacid INT(10) NOT NULL,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT '用户自定义码浏览记录表';


-- 用户记录表
create table ims_longbing_card_count(
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL,
    to_uid INT(10) NOT NUll,
    type INT(3) NOT NUll COMMENT '浏览内容,sign=view时 1=>浏览商城列表 2=>浏览商品详情 3=>浏览动态列表 4=>点赞动态 5=>动态留言 6=>浏览公司官网 7=>浏览动态详情  sign=copy时 1=>同步到通讯录 2=>拨打手机号 3=>拨打座机号 4=>复制微信 5=>复制邮箱 6=>复制公司名 7=>查看定位 8=>咨询产品 9=>播放语音 10=>保存名片  当sign=praise时 1 语音点赞 2 人气(查看),3 点赞   4 分享',
    sign VARCHAR(10) NOT NULL,
    target VARCHAR(200) NOT NULL DEFAULT '',
    uniacid INT(10) NOT NULL,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8

alter table ims_longbing_card_config add column mini_app_name varchar (20) not null default '';
alter table ims_longbing_card_articles add column modular_id int (5) not null;
alter table ims_longbing_card_jobs add column modular_id int (5) not null;
alter table ims_longbing_card_desc add column modular_id int (5) not null;
alter table ims_longbing_card_culture add column modular_id int (5) not null;
alter table ims_longbing_card_staffs add column modular_id int (5) not null;
alter table ims_longbing_card_contact add column modular_id int (5) not null;



-- 用户成交率表表
create table ims_longbing_card_rate(
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL,
    staff_id INT(10) NOT NUll,
    rate INT(10) NOT NULL DEFAULT 0,
    uniacid INT(10) NOT NULL,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8

alter table ims_longbing_card_user_info add column top int (5) not null default 0;

-- 设置用户的成交日期
create table ims_longbing_card_date(
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL,
    staff_id INT(10) NOT NUll,
    `date` varchar(20) NOT NULL DEFAULT 0,
    uniacid INT(10) NOT NULL,
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8
DROP INDEX uid ON ims_longbing_card_collection;

alter table ims_longbing_card_user add column scene int (10) not null default 0;
alter table ims_longbing_card_collection add column scene int (10) not null default 0;
alter table ims_longbing_card_count add column scene int (10) not null default 0;

alter table ims_longbing_card_user_info  modify column images text;
alter table ims_longbing_card_collection add column status int (5) not null default 1;
alter table ims_longbing_card_user add column openGId varchar (50) not null default '';
alter table ims_longbing_card_user add column qr_path varchar (200) not null default '';
alter table ims_longbing_card_user_info add column is_default int (5) not null default 1;


-- ---------------------------------------------------------------------------

-- 设置用户的成交日期
create table ims_longbing_card_value(
    id INT NOT NULL AUTO_INCREMENT,
    staff_id INT(10) NOT NULL,
    client INT(10) NOT NULL DEFAULT 0,
    charm INT(10) NOT NULL DEFAULT 0,
    interaction INT(10) NOT NULL DEFAULT 0,
    product INT(10) NOT NULL DEFAULT 0,
    website INT(10) NOT NULL DEFAULT 0,
    active INT(10) NOT NULL DEFAULT 0,
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4


-- ---------------------------------------------------------------------------

-- 商品分类表
create table ims_longbing_card_shop_type(
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(20) NOT NULL COMMENT '分类名',
    cover VARCHAR(200) NOT NULL DEFAULT 0,
    pid INT(10) NOT NULL DEFAULT 0 COMMENT '0=>顶级分类;其他=>上级分类id',
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 商品规格表
create table ims_longbing_card_shop_spe(
    id INT NOT NULL AUTO_INCREMENT,
    goods_id INT(10) NOT NULL,
    title VARCHAR(20) NOT NULL COMMENT '规格名',
    pid INT(10) NOT NULL DEFAULT 0 COMMENT '0=>顶级规格;其他=>上级规格id',
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 商品规格价格表
CREATE TABLE IF NOT EXISTS longbing_card_shop_spe_price(
    id INT NOT NULL AUTO_INCREMENT,
    goods_id INT(10) NOT NULL,
    spe_id_1 INT(10) NOT NULL,
    spe_id_2 INT(10) NOT NULL,
    price DECIMAL(10, 2) NOT NULL DEFAULT 0,
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 商品拼团条件表
CREATE TABLE IF NOT EXISTS ims_longbing_card_shop_collage(
    id INT NOT NULL AUTO_INCREMENT,
    goods_id INT(10) NOT NULL,
    spe_price_id INT(10) NOT NULL,
    `number` INT(10) NOT NULL,
    price DECIMAL(10, 2) NOT NULL DEFAULT 0,
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 购物车表
CREATE TABLE IF NOT EXISTS ims_longbing_card_shop_trolley(
    id INT NOT NULL AUTO_INCREMENT,
    goods_id INT(10) NOT NULL,
    user_id INT(10) NOT NULL,
    `name` VARCHAR(30) NOT NULL,
    `cover` VARCHAR(200) NOT NULL,
    spe_price_id INT(10) NOT NULL,
    content VARCHAR(50) NOT NULL,
    `number` INT(10) NOT NULL,
    price DECIMAL(10, 2) NOT NULL DEFAULT 0,
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 商品搜索记录表
CREATE TABLE IF NOT EXISTS ims_longbing_card_shop_search(
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL,
    `content` VARCHAR(30) NOT NULL,
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 收货地址表
CREATE TABLE IF NOT EXISTS ims_longbing_card_shop_address(
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL,
    `name` VARCHAR(30) NOT NULL,
    `sex` VARCHAR(30) NOT NULL,
    `phone` VARCHAR(30) NOT NULL,
    `address` VARCHAR(50) NOT NULL,
    `address_detail` VARCHAR(100) NOT NULL,
    `province` VARCHAR(30) NOT NULL,
    `city` VARCHAR(30) NOT NULL,
    `area` VARCHAR(30) NOT NULL,
    is_default INT(3) NOT NULL DEFAULT 0,
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 订单表
CREATE TABLE IF NOT EXISTS ims_longbing_card_shop_order(
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL,
    address_id INT(10) NOT NULL,
    pay_status INT(3) NOT NUll DEFAULT 0 COMMENT '支付状态 0=>未支付; 1=>已支付; 2=>已退款',
    `type` INT(3) NOT NULL DEFAULT 0 COMMENT '订单类型 0=>普通订单; 1=>拼团订单',
    `collage_id` INT(3) NOT NULL DEFAULT 0 COMMENT '拼团记录id',
    freight DECIMAL (10, 2) NOT NUll DEFAULT 0,
    price DECIMAL (10, 2) NOT NUll DEFAULT 0,
    total_price DECIMAL (10, 2) NOT NUll DEFAULT 0,
    `name` VARCHAR(30) NOT NULL,
    `sex` VARCHAR(30) NOT NULL,
    `phone` VARCHAR(30) NOT NULL,
    `address` VARCHAR(50) NOT NULL,
    `address_detail` VARCHAR(100) NOT NULL,
    `province` VARCHAR(30) NOT NULL,
    `city` VARCHAR(30) NOT NULL,
    `area` VARCHAR(30) NOT NULL,
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 订单商品表
CREATE TABLE IF NOT EXISTS ims_longbing_card_shop_order_item(
    id INT NOT NULL AUTO_INCREMENT,
    order_id INT(10) NOT NULL,
    goods_id INT(10) NOT NULL,
    `name` VARCHAR(30) NOT NULL,
    `cover` VARCHAR(200) NOT NULL,
    spe_price_id INT(10) NOT NULL,
    content VARCHAR(50) NOT NULL,
    `number` INT(10) NOT NULL,
    price DECIMAL(10, 2) NOT NULL DEFAULT 0,
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 快速回复表
CREATE TABLE IF NOT EXISTS ims_longbing_card_quick_reply(
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL,
    content VARCHAR(100) NOT NULL,
    `number` INT(10) NOT NULL DEFAULT 0,
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 底部菜单表
CREATE TABLE IF NOT EXISTS ims_longbing_card_tabbar(
    id INT NOT NULL AUTO_INCREMENT,
    menu1_name VARCHAR(20) NOT NULL DEFAULT '名片',
    menu2_name VARCHAR(20) NOT NULL DEFAULT '商城',
    menu3_name VARCHAR(20) NOT NULL DEFAULT '动态',
    menu4_name VARCHAR(20) NOT NULL DEFAULT '官网',
    menu1_is_hide INT(3) NOT NULL DEFAULT 1,
    menu2_is_hide INT(3) NOT NULL DEFAULT 1,
    menu3_is_hide INT(3) NOT NULL DEFAULT 1,
    menu4_is_hide INT(3) NOT NULL DEFAULT 1,
    menu1_url VARCHAR(500) NOT NULL DEFAULT '',
    menu2_url VARCHAR(500) NOT NULL DEFAULT '',
    menu3_url VARCHAR(500) NOT NULL DEFAULT '',
    menu4_url VARCHAR(500) NOT NULL DEFAULT '',
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 小程序页面表
CREATE TABLE IF NOT EXISTS ims_longbing_card_pages(
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(20) NOT NULL,
    page VARCHAR(200) NOT NULL,
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 官网打电话表
CREATE TABLE IF NOT EXISTS ims_longbing_card_call(
    id INT NOT NULL AUTO_INCREMENT,
    phone VARCHAR(20) NOT NULL,
    `modular_id` int(5) NOT NULL,
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 群人数表
CREATE TABLE IF NOT EXISTS ims_longbing_card_group_number(
    id INT NOT NULL AUTO_INCREMENT,
    staff_id int(10) NOT NULL,
    openGId varchar (100) NOT NULL,
    `number` int (10) NOT NULL,
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 话术分类表
CREATE TABLE IF NOT EXISTS ims_longbing_card_reply_type(
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(20) NOT NULL,
    top INT(10) NOT NULL DEFAULT 0 COMMENT '排序值',
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='名片--话术分类表';

-- 拼团列表
CREATE TABLE IF NOT EXISTS ims_longbing_card_shop_collage_list(
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT(10) NOT NULL COMMENT '发起拼团人',
    goods_id INT(10) NOT NULL,
    collage_id INT(10) NOT NULL COMMENT '拼团条件id',
    `name` VARCHAR(30) NOT NULL,
    `cover` VARCHAR(200) NOT NULL,
    `number` INT(10) NOT NULL COMMENT '拼团人数',
    `left_number` INT(10) NOT NULL COMMENT '剩余拼团人数',
    price DECIMAL(10, 2) NOT NULL DEFAULT 0 COMMENT '单价',
    collage_status INT(3) NOT NULL DEFAULT 0 COMMENT '拼团状态 0=>未支付; 1=>拼团中; 2=>拼团人满; 3=>拼团完成; 4=>拼团失败',
    uniacid INT(10) NOT NULL,
    status INT(3) NOT NULL DEFAULT 1 COMMENT '',
    create_time int(11) NOT NULL DEFAULT 0,
    update_time int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY ( id )
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='名片--拼团列表';



DROP INDEX openid ON ims_longbing_card_user;
ALTER TABLE ims_longbing_card_user ADD UNIQUE openid_uniacid(openid, uniacid);



