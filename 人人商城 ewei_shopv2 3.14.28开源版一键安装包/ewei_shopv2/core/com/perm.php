<?php
//易---福-网
if (!defined("IN_IA")) {
    exit("Access Denied");
}
class Perm_EweiShopV2ComModel extends ComModel {
    static public $allPerms = array();
    static public $getLogTypes = array();
    static public $formatPerms = array();
    public function allPerms() {
        if (empty(self::$allPerms)) {
            $perms          = array(
                "shop" => $this->perm_shop(),
                "goods" => $this->perm_goods(),
                "member" => $this->perm_member(),
                "order" => $this->perm_order(),
                "store" => $this->perm_store(),
                "finance" => $this->perm_finance(),
                "statistics" => $this->perm_statistics(),
                "sysset" => $this->perm_sysset(),
                "sale" => $this->perm_sale(),
                "bargain" => $this->perm_bargain(),
                "exchange" => $this->perm_exchange(),
                "commission" => $this->perm_commission(),
                "diyform" => $this->perm_diyform(),
                "poster" => $this->perm_poster(),
                "postera" => $this->perm_postera(),
                "taobao" => $this->perm_taobao(),
                "article" => $this->perm_article(),
                "creditshop" => $this->perm_creditshop(),
                "exhelper" => $this->perm_exhelper(),
                "diypage" => $this->perm_diypage(),
                "groups" => $this->perm_groups(),
                "perm" => $this->perm_perm(),
                "globonus" => $this->perm_globonus(),
                "merch" => $this->perm_merch(),
                "mr" => $this->perm_mr(),
                "qa" => $this->perm_qa(),
                "abonus" => $this->perm_abonus(),
                "pstore" => $this->perm_pstore(),
                "sign" => $this->perm_sign(),
                "wangdian" => $this->perm_wangdian(),
                "quick" => $this->perm_quick(),
                "author" => $this->perm_author(),
                "sns" => $this->perm_sns(),
                "backone" => $this->perm_backone(),
                "task" => $this->perm_task(),
                "cashier" => $this->perm_cashier(),
                "seckill" => $this->perm_seckill(),
                "lottery" => $this->perm_lottery(),
                "threen" => $this->perm_threen(),
                "messages" => $this->perm_messages(),
                "app" => $this->perm_app(),
                "polyapi" => $this->perm_polyapi(),
                "mmanage" => $this->perm_mmanage(),
                "newstore" => $this->perm_newstore(),
                "live" => $this->perm_live(),
                "invitation" => $this->perm_invitation(),
                "offic" => $this->perm_offic(),
                "cycelbuy" => $this->perm_cycelbuy(),
                "dividend" => $this->perm_dividend(),
                "membercard" => $this->perm_membercard(),
                "friendcoupon" => $this->perm_friendcoupon(),
                "messikefu" => $this->perm_openmessikefu(),
                "goodscircle" => $this->perm_goodscircle(),
                "pc" => $this->perm_pc(),
                "open_farm" => $this->perm_openfarm()
            );
            self::$allPerms = $perms;
        }
        return self::$allPerms;
    }
    protected function perm_threen() {
        return $this->isopen("threen") && $this->is_perm_plugin("threen") ? array(
            "text" => m("plugin")->getName("threen"),
            "manage" => array(
                "text" => "VIP管理",
                "main" => "查看列表",
                "view" => "查看内容",
                "add" => "添加-log",
                "edit" => "修改-log",
                "check" => "审核-log"
            ),
            "increase" => array(
                "text" => "分销商增长趋势",
                "main" => "查看列表"
            ),
            "relation" => array(
                "text" => "VIP关系",
                "main" => "查看列表",
                "view" => "查看内容"
            ),
            "apply" => array(
                "text" => "提现申请",
                "main" => "查看",
                "check" => "审核-log"
            ),
            "setting" => array(
                "text" => "基础设置",
                "main" => "编辑-log"
            ),
            "rank" => array(
                "text" => "排行榜设置",
                "main" => "编辑-log"
            ),
            "notice" => array(
                "text" => "通知设置",
                "main" => "编辑-log"
            ),
            "cover" => array(
                "text" => "入口设置",
                "main" => "编辑-log"
            )
        ) : array();
    }
    protected function perm_app() {
        return $this->isopen("app") && $this->is_perm_plugin("app") ? array(
            "text" => m("plugin")->getName("app"),
            "page" => array(
                "text" => "页面设计",
                "main" => "查看",
                "add" => "添加-log",
                "edit" => "编辑-log",
                "xxx" => array(
                    "delete" => "edit",
                    "status" => "edit",
                    "setdefault" => "edit",
                    "cancel_default" => "edit"
                )
            ),
            "goods" => array(
                "text" => "商品二维码",
                "main" => "查看"
            ),
            "setting" => array(
                "text" => "基本设置",
                "main" => "查看",
                "edit" => "基本设置-log",
                "pay" => "支付设置-log"
            ),
            "tabbar" => array(
                "text" => "底部导航",
                "main" => "保存-log",
                "xxx" => array(
                    "submit" => "main"
                )
            ),
            "tongrelease" => array(
                "text" => "新版发布",
                "main" => "提交-log",
                "xxx" => array(
                    "audit" => "main"
                )
            ),
            "release" => array(
                "text" => "旧版发布",
                "main" => "提交-log",
                "xxx" => array(
                    "audit" => "main"
                )
            ),
            "tmessage" => array(
                "text" => "模板消息",
                "main" => "查看",
                "add" => "添加-log",
                "edit" => "编辑-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "status" => "edit"
                )
            ),
            "poster" => array(
                "text" => "分销海报",
                "main" => "查看",
                "add" => "添加-log",
                "edit" => "编辑-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "status" => "edit"
                )
            ),
            "startadv" => array(
                "text" => "启动广告",
                "main" => "查看",
                "add" => "添加-log",
                "edit" => "编辑-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "status" => "edit"
                )
            )
        ) : array();
    }
    protected function perm_polyapi() {
        return $this->isopen("polyapi") && $this->is_perm_plugin("polyapi") ? array(
            "text" => m("plugin")->getName("polyapi"),
            "set" => array(
                "text" => "基本设置",
                "edit" => "修改-log"
            )
        ) : array();
    }
    protected function perm_store() {
        $perm = array(
            "text" => "门店管理",
            "main" => "浏览列表",
            "view" => "查看详情",
            "add" => "添加-log",
            "edit" => "修改-log",
            "delete" => "删除-log",
            "set" => "关键词设置-log",
            "goods" => array(
                "text" => "门店商品管理",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log"
            ),
            "goodsgroup" => array(
                "text" => "门店商品组管理",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "view" => "查看",
                "delete" => "删除-log"
            ),
            "storegroup" => array(
                "text" => "门店分组管理",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "view" => "查看",
                "delete" => "删除-log"
            ),
            "saler" => array(
                "text" => "店员管理",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "view" => "查看",
                "delete" => "删除-log"
            ),
            "verifygoods" => array(
                "text" => "记次时商品核销管理",
                "edit" => "修改-log",
                "detail" => "修改详情",
                "view" => "查看",
                "deletelog" => "删除核销记录"
            ),
            "verifyorder.log" => array(
                "text" => "核销订单记录",
                "export" => "导出-log",
                "view" => "查看"
            ),
            "verify.log" => array(
                "text" => "记次时商品统计",
                "main" => "查看列表"
            )
        );
        if (p("newstore")) {
            $perm["staff"]    = array(
                "text" => "服务人员管理",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "view" => "查看",
                "delete" => "删除-log"
            );
            $perm["role"]     = array(
                "text" => "店员角色管理",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "view" => "查看",
                "delete" => "删除-log"
            );
            $perm["category"] = array(
                "text" => "门店分类管理",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "view" => "查看",
                "delete" => "删除-log"
            );
            $perm["diypage"]  = array(
                "text" => "门店装修",
                "setting" => "设置门店默认模板-log",
                "add" => "装修模板添加-log",
                "edit" => "装修模板编辑-log",
                "delete" => "装修模板删除-log",
                "preview" => "门店页面/模板预览",
                "xxx" => array(
                    "status" => "edit"
                ),
                "page" => array(
                    "text" => "门店页面设置",
                    "add" => "添加-log",
                    "edit" => "编辑-log",
                    "delete" => "删除-log",
                    "xxx" => array(
                        "status" => "edit"
                    )
                )
            );
        }
        return $perm;
    }
    protected function perm_newstore() {
        return $this->isopen("newstore") && $this->is_perm_plugin("newstore") ? array(
            "text" => m("plugin")->getName("newstore"),
            "temp" => array(
                "text" => "模板管理",
                "main" => "查看列表",
                "view" => "查看内容",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "delete1" => "彻底删除-log"
            ),
            "ngoods" => array(
                "text" => "预约商品管理",
                "main" => "查看列表",
                "view" => "查看内容",
                "add" => "添加-log",
                "edit" => "修改-log",
                "deleted" => "删除-log"
            ),
            "norder" => array(
                "text" => "预约订单",
                "main" => "查看列表",
                "view" => "查看内容"
            ),
            "set" => array(
                "text" => "基础设置",
                "edit" => "编辑-log"
            )
        ) : array();
    }
    protected function perm_invitation() {
        return $this->isopen("invitation") && $this->is_perm_plugin("invitation") ? array(
            "text" => m("plugin")->getName("invitation"),
            "main" => "查看列表",
            "view" => "查看内容",
            "add" => "添加-log",
            "edit" => "修改-log",
            "log" => "扫描记录-log",
            "delete" => "删除-log"
        ) : array();
    }
    protected function perm_offic() {
        return $this->isopen("offic") && $this->is_perm_plugin("offic") ? array(
            "text" => m("plugin")->getName("offic"),
            "system" => array(
                "text" => "系统文案管理",
                "main" => "查看列表",
                "view" => "查看内容",
                "add" => "添加-log",
                "edit" => "修改-log",
                "log" => "扫描记录-log",
                "deleted" => "删除-log"
            ),
            "agent" => array(
                "text" => "用户文案管理",
                "main" => "查看列表",
                "view" => "查看内容",
                "add" => "添加-log",
                "edit" => "修改-log",
                "log" => "扫描记录-log",
                "deleted" => "删除-log"
            ),
            "adv" => array(
                "text" => "幻灯片",
                "main" => "查看列表",
                "view" => "查看内容",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "displayorder" => "edit",
                    "enabled" => "edit"
                )
            ),
            "banner" => array(
                "text" => "广告",
                "main" => "查看列表",
                "view" => "查看内容",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "displayorder" => "edit",
                    "enabled" => "edit"
                )
            ),
            "cover" => array(
                "text" => "入口设置",
                "edit" => "编辑-log"
            ),
            "setting" => array(
                "text" => "基础设置",
                "edit" => "编辑-log"
            )
        ) : array();
    }
    protected function perm_live() {
        return $this->isopen("live") && $this->is_perm_plugin("live") ? array(
            "text" => m("plugin")->getName("live"),
            "room" => array(
                "text" => "直播间管理",
                "main" => "查看列表",
                "view" => "查看内容",
                "add" => "添加-log",
                "edit" => "修改-log",
                "console" => "控制台-log",
                "deleted" => "删除-log"
            ),
            "category" => array(
                "text" => "分类管理",
                "main" => "查看列表",
                "view" => "查看内容",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log"
            ),
            "banner" => array(
                "text" => "幻灯片管理",
                "main" => "查看列表",
                "view" => "查看内容",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log"
            ),
            "cover" => array(
                "text" => "入口设置",
                "edit" => "编辑-log"
            ),
            "set" => array(
                "text" => "基础设置",
                "edit" => "编辑-log"
            )
        ) : array();
    }
    protected function perm_shop() {
        return array(
            "text" => "商城管理",
            "adv" => array(
                "text" => "幻灯片",
                "main" => "查看列表",
                "view" => "查看内容",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "displayorder" => "edit",
                    "enabled" => "edit"
                )
            ),
            "nav" => array(
                "text" => "首页导航图标",
                "main" => "查看列表",
                "view" => "查看内容",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "displayorder" => "edit",
                    "status" => "edit"
                )
            ),
            "banner" => array(
                "text" => "首页广告",
                "main" => "查看列表",
                "view" => "查看内容",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "displayorder" => "edit",
                    "enabled" => "edit",
                    "setswipe" => "edit"
                )
            ),
            "cube" => array(
                "text" => "首页魔方",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "recommand" => array(
                "text" => "首页商品推荐",
                "main" => "编辑推荐商品-log",
                "setstyle" => "设置商品组样式-log"
            ),
            "sort" => array(
                "text" => "首页元素排版",
                "main" => "修改-log"
            ),
            "dispatch" => array(
                "text" => "配送方式",
                "main" => "查看列表",
                "view" => "查看内容",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "displayorder" => "edit",
                    "enabled" => "edit",
                    "setdefault" => "edit"
                )
            ),
            "cityexpress" => array(
                "text" => "同城配送",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "notice" => array(
                "text" => "公告",
                "main" => "查看列表",
                "view" => "查看内容",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "displayorder" => "edit",
                    "status" => "edit"
                )
            ),
            "comment" => array(
                "text" => "评价",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "编辑-log",
                "post" => "回复-log",
                "delete" => "删除-log"
            ),
            "refundaddress" => array(
                "text" => "退货地址",
                "main" => "查看列表",
                "view" => "查看内容",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "setdefault" => "edit"
                )
            ),
            "verify" => $this->isopen("verify", true) && $this->is_perm_plugin("verify", true) ? array(
                "text" => "O2O核销",
                "saler" => array(
                    "text" => "店员管理",
                    "main" => "查看列表",
                    "view" => "查看内容",
                    "add" => "添加-log",
                    "edit" => "修改-log",
                    "delete" => "删除-log",
                    "xxx" => array(
                        "status" => "edit"
                    )
                ),
                "store" => array(
                    "text" => "门店管理",
                    "main" => "查看列表",
                    "view" => "查看内容",
                    "add" => "添加-log",
                    "edit" => "修改-log",
                    "delete" => "删除-log",
                    "xxx" => array(
                        "displayorder" => "edit",
                        "status" => "edit"
                    )
                ),
                "set" => array(
                    "text" => "关键词设置",
                    "main" => "查看",
                    "edit" => "编辑-log"
                )
            ) : array()
        );
    }
    protected function perm_goods() {
        return array(
            "text" => "商品管理",
            "main" => "浏览列表",
            "view" => "查看详情",
            "add" => "添加-log",
            "edit" => "修改-log",
            "delete" => "删除-log",
            "delete1" => "彻底删除-log",
            "restore" => "恢复到仓库-log",
            "list" => "列表修改-log",
            "xxx" => array(
                "status" => "edit",
                "property" => "edit",
                "goodsprice" => "edit",
                "change" => "edit",
                "ajax_batchcates" => "edit"
            ),
            "category" => array(
                "text" => "商品分类",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "enabled" => "edit"
                )
            ),
            "group" => array(
                "text" => "商品组",
                "view" => "浏览",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "enabled" => "edit"
                )
            ),
            "label" => array(
                "text" => "标签管理",
                "view" => "浏览",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "enabled" => "edit"
                )
            ),
            "fixedinfo" => array(
                "text" => "固定信息",
                "view" => "浏览",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "enabled" => "edit"
                )
            ),
            "virtual" => $this->isopen("virtual", true) && $this->is_perm_plugin("virtual", true) ? array(
                "text" => "虚拟卡密",
                "temp" => array(
                    "text" => "卡密模板管理",
                    "view" => "浏览",
                    "add" => "添加-log",
                    "edit" => "修改-log",
                    "delete" => "删除-log"
                ),
                "category" => array(
                    "text" => "卡密分类管理",
                    "add" => "添加-log",
                    "edit" => "编辑-log",
                    "delete" => "删除-log"
                ),
                "data" => array(
                    "text" => "卡密数据",
                    "add" => "添加-log",
                    "edit" => "修改-log",
                    "delete" => "删除-log",
                    "export" => "导出-log",
                    "temp" => "下载模板",
                    "import" => "导入-log"
                )
            ) : array()
        );
    }
    protected function perm_member() {
        return array(
            "text" => "会员管理",
            "group" => array(
                "text" => "会员组",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log"
            ),
            "level" => array(
                "text" => "会员等级",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "enable" => "edit"
                )
            ),
            "list" => array(
                "text" => "会员管理",
                "main" => "浏览",
                "edit" => "修改-log",
                "view" => "查看-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "setblack" => "edit"
                )
            ),
            "rank" => array(
                "text" => "排行榜",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "tmessage" => array(
                "text" => "会员群发",
                "send" => "群发消息-log",
                "xxx" => array(
                    "sendmessage" => "send",
                    "fetch" => "send"
                )
            ),
            "card" => array(
                "text" => "微信会员卡管理",
                "add" => "添加",
                "edit" => "修改",
                "delete" => "删除",
                "stock" => "修改库存",
                "active" => "激活设置"
            )
        );
    }
    protected function perm_bargain() {
        return $this->isopen("bargain") && $this->is_perm_plugin("bargain") ? array(
            "text" => m("plugin")->getName("bargain"),
            "main" => "查看砍价中列表",
            "soldout" => "查看已售罄列表",
            "notstart" => "查看未开始列表",
            "complete" => "查看已结束列表",
            "out" => "查看已下架列表",
            "recycle" => "查看回收站列表",
            "warehouse" => "添加砍价商品",
            "react" => "编辑商品",
            "huishou" => "删除商品",
            "delete" => "彻底删除商品",
            "recover" => "恢复已删除商品",
            "set" => "分享设置",
            "messageset" => "消息通知设置",
            "otherset" => "其他设置"
        ) : array();
    }
    protected function perm_exchange() {
        return $this->isopen("exchange") && $this->is_perm_plugin("exchange") ? array(
            "text" => m("plugin")->getName("exchange"),
            "goods" => array(
                "text" => "商品兑换",
                "edit" => "添加/编辑兑换",
                "creat" => "生成兑换券",
                "status" => "修改状态",
                "destroy" => "删除兑换码",
                "delete" => "删除兑换任务"
            ),
            "balance" => array(
                "text" => "余额兑换",
                "edit" => "添加/编辑兑换",
                "creat" => "生成兑换券",
                "status" => "修改状态",
                "destroy" => "删除兑换码",
                "delete" => "删除兑换任务"
            ),
            "redpacket" => array(
                "text" => "红包兑换",
                "edit" => "添加/编辑兑换",
                "creat" => "生成兑换券",
                "status" => "修改状态",
                "destroy" => "删除兑换码",
                "delete" => "删除兑换任务"
            ),
            "score" => array(
                "text" => "积分兑换",
                "edit" => "添加/编辑兑换",
                "creat" => "生成兑换券",
                "status" => "修改状态",
                "destroy" => "删除兑换码",
                "delete" => "删除兑换任务"
            ),
            "coupon" => array(
                "text" => "优惠券兑换",
                "edit" => "添加/编辑兑换",
                "creat" => "生成兑换券",
                "status" => "修改状态",
                "destroy" => "删除兑换码",
                "delete" => "删除兑换任务"
            ),
            "group" => array(
                "text" => "组合兑换",
                "edit" => "添加/编辑兑换",
                "creat" => "生成兑换券",
                "status" => "修改状态",
                "destroy" => "删除兑换码",
                "delete" => "删除兑换任务"
            ),
            "record" => array(
                "text" => "兑换订单",
                "main" => "全部订单",
                "daifahuo" => "待发货",
                "daishouhuo" => "待收货",
                "daifukuan" => "待收货",
                "yiguanbi" => "待收货",
                "yiwancheng" => "已完成"
            ),
            "setting" => array(
                "text" => "文件管理",
                "download" => "文件管理",
                "other" => "其他设置"
            ),
            "history" => array(
                "text" => "兑换记录",
                "history" => "兑换记录"
            )
        ) : array();
    }
    protected function perm_sale() {
        $array = array(
            "text" => "营销",
            "coupon" => $this->isopen("coupon", true) && $this->is_perm_plugin("coupon", true) ? array(
                "text" => "优惠券管理",
                "view" => "浏览",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "send" => "发放-log",
                "set" => "修改设置-log",
                "xxx" => array(
                    "displayorder" => "edit"
                ),
                "category" => array(
                    "text" => "优惠券分类",
                    "main" => "查看",
                    "edit" => "修改-log"
                ),
                "log" => array(
                    "text" => "优惠券记录",
                    "main" => "查看",
                    "export" => "导出记录"
                ),
                "sendcoupon" => array(
                    "text" => "手动发券",
                    "main" => "查看"
                ),
                "goodssend" => array(
                    "text" => "购物送券",
                    "main" => "查看",
                    "add" => "添加",
                    "edit" => "编辑"
                ),
                "sendtask" => array(
                    "text" => "满额送券",
                    "main" => "查看",
                    "add" => "添加",
                    "edit" => "编辑"
                ),
                "usesendtask" => array(
                    "text" => "用券送券",
                    "main" => "查看",
                    "add" => "添加",
                    "edit" => "编辑"
                ),
                "setticket" => array(
                    "text" => "新人发券",
                    "main" => "查看"
                ),
                "shareticket" => array(
                    "text" => "分享发券",
                    "main" => "查看",
                    "add" => "添加活动",
                    "edit" => "编辑活动",
                    "status" => "编辑状态",
                    "delete1" => "删除活动",
                    "change" => "修改参数"
                )
            ) : array(),
            "wxcard" => array(
                "text" => "微信卡券管理",
                "view" => "浏览",
                "add" => "添加",
                "edit" => "修改",
                "stock" => "修改库存",
                "qrcode" => "下载推送二维码",
                "delete" => "删除",
                "set" => "修改设置-log"
            ),
            "virtual" => array(
                "text" => "关注回复",
                "view" => "浏览",
                "edit" => "修改-log"
            ),
            "package" => array(
                "text" => "套餐管理",
                "view" => "浏览",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete1" => "彻底删除-log",
                "xxx" => array(
                    "status" => "edit",
                    "change" => "edit"
                )
            ),
            "gift" => array(
                "text" => "赠品管理",
                "view" => "浏览",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete1" => "彻底删除-log",
                "xxx" => array(
                    "status" => "edit",
                    "change" => "edit"
                )
            ),
            "fullback" => array(
                "text" => "全返管理",
                "view" => "浏览",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete1" => "彻底删除-log",
                "xxx" => array(
                    "status" => "edit",
                    "change" => "edit"
                )
            ),
            "peerpay" => array(
                "text" => "找人代付",
                "main" => "查看",
                "edit" => "编辑"
            ),
            "bindmobile" => array(
                "text" => "绑定送积分",
                "main" => "查看",
                "edit" => "编辑"
            )
        );
        if ($this->isopen("sale", true) && $this->is_perm_plugin("sale", true)) {
            $sale  = array(
                "deduct" => "修改抵扣设置-log",
                "enough" => "修改满额立减-log",
                "enoughfree" => "修改满额包邮-log",
                "recharge" => "修改充值优惠设置-log",
                "credit1" => "积分优惠优惠设置-log"
            );
            $array = array_merge($array, $sale);
        }
        return $array;
    }
    protected function perm_finance() {
        return array(
            "text" => "财务管理",
            "log" => array(
                "text" => "财务管理",
                "recharge" => "充值记录",
                "withdraw" => "提现申请",
                "refund" => "充值退款-log",
                "alipay" => "支付宝提现-log",
                "wechat" => "微信提现-log",
                "manual" => "手动提现-log",
                "refuse" => "拒绝提现-log",
                "recharge.export" => "充值记录导出-log",
                "withdraw.export" => "提现申请导出-log"
            ),
            "downloadbill" => array(
                "text" => "对账单",
                "main" => "下载-log"
            ),
            "recharge" => array(
                "text" => "充值",
                "credit1" => "充值积分-log",
                "credit2" => "充值余额-log"
            ),
            "credit" => array(
                "text" => "积分余额明细",
                "credit1" => "积分明细",
                "credit1.export" => "导出积分明细",
                "credit2" => "余额明细",
                "credit2.export" => "导出余额明细"
            )
        );
    }
    protected function perm_statistics() {
        return array(
            "text" => "数据统计",
            "sale" => array(
                "text" => "销售统计",
                "main" => "查看",
                "export" => "导出-log"
            ),
            "sale_analysis" => array(
                "text" => "销售指标",
                "main" => "查看"
            ),
            "order" => array(
                "text" => "订单统计",
                "main" => "查看",
                "export" => "导出-log"
            ),
            "goods" => array(
                "text" => "商品销售明细",
                "main" => "查看",
                "export" => "导出-log"
            ),
            "goods_rank" => array(
                "text" => "商品销售排行",
                "main" => "查看",
                "export" => "导出-log"
            ),
            "goods_trans" => array(
                "text" => "商品销售转化率",
                "main" => "查看",
                "export" => "导出-log"
            ),
            "member_cost" => array(
                "text" => "会员消费排行",
                "main" => "查看",
                "export" => "导出-log"
            ),
            "member_increase" => array(
                "text" => "会员增长趋势",
                "main" => "查看"
            )
        );
    }
    protected function perm_order() {
        return array(
            "text" => "订单",
            "detail" => array(
                "text" => "订单详情",
                "edit" => "编辑"
            ),
            "export" => array(
                "text" => "自定义导出-log",
                "main" => "浏览页面",
                "xxx" => array(
                    "save" => "main",
                    "delete" => "main",
                    "gettemplate" => "main",
                    "reset" => "main"
                )
            ),
            "batchsend" => array(
                "text" => "批量发货",
                "main" => "批量发货-log",
                "xxx" => array(
                    "import" => "main"
                )
            ),
            "list" => array(
                "text" => "订单管理",
                "main" => "浏览全部订单",
                "status_1" => "浏览关闭订单",
                "status0" => "浏览待付款订单",
                "status1" => "浏览已付款订单",
                "status2" => "浏览已发货订单",
                "status3" => "浏览完成的订单",
                "status4" => "浏览退货申请订单",
                "status5" => "浏览已退货订单"
            ),
            "op" => array(
                "text" => "操作",
                "pay" => "确认付款-log",
                "send" => "发货-log",
                "sendcancel" => "取消发货-log",
                "finish" => "确认收货(快递单)-log",
                "verify" => "确认核销(核销单)-log",
                "fetch" => "确认取货(自提单)-log",
                "close" => "关闭订单-log",
                "changeprice" => "订单改价-log",
                "changeaddress" => "修改收货地址-log",
                "remarksaler" => "订单备注-log",
                "paycancel" => "订单取消付款-log",
                "fetchcancel" => "订单取消取货-log",
                "refund" => array(
                    "text" => "维权",
                    "main" => "维权信息-log",
                    "submit" => "提交维权申请-log"
                ),
                "xxx" => array(
                    "changeexpress" => "send"
                )
            )
        );
    }
    protected function perm_sysset() {
        return array(
            "text" => "设置",
            "shop" => array(
                "text" => "商城设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "follow" => array(
                "text" => "分享及关注",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "notice" => array(
                "text" => "消息提醒",
                "edit" => "编辑-log"
            ),
            "trade" => array(
                "text" => "交易设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "payset" => array(
                "text" => "支付方式",
                "edit" => "修改-log"
            ),
            "payment" => array(
                "text" => "支付管理",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log"
            ),
            "templat" => array(
                "text" => "模板设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "member" => array(
                "text" => "会员等级设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "category" => array(
                "text" => "分类层级",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "contact" => array(
                "text" => "联系方式",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "area" => array(
                "text" => "地址库设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "qiniu" => $this->isopen("qiniu", true) && $this->is_perm_plugin("qiniu", true) ? array(
                "text" => "七牛存储",
                "main" => "查看",
                "edit" => "修改-log"
            ) : array(),
            "close" => array(
                "text" => "商城关闭",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "tmessage" => array(
                "text" => "模板消息库",
                "main" => "查看",
                "add" => "添加",
                "edit" => "修改",
                "delete" => "删除"
            ),
            "sms" => $this->isopen("sms", true) && $this->is_perm_plugin("sms", true) ? array(
                "text" => "短信提醒",
                "set" => array(
                    "text" => "短信设置",
                    "main" => "设置-log"
                ),
                "temp" => array(
                    "text" => "短信模板库",
                    "main" => "查看列表",
                    "view" => "查看",
                    "add" => "添加-log",
                    "edit" => "修改-log",
                    "delete" => "删除-log",
                    "testsend" => "发送测试短信",
                    "xxx" => array(
                        "status" => "edit"
                    )
                )
            ) : array(),
            "wap" => array(
                "text" => "全网通设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "express" => array(
                "text" => "物流信息接口",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "printer" => array(
                "text" => "小票打印机",
                "main" => "模板库",
                "printer_list" => "打印机管理",
                "printer_add" => "打印机添加-log",
                "printer_edit" => "打印机编辑-log",
                "printer_delete" => "打印机删除-log",
                "add" => "打印模板添加-log",
                "edit" => "打印模板编辑-log",
                "delete" => "打印模板删除-log",
                "set" => "打印设置-log"
            ),
            "cover" => array(
                "shop" => array(
                    "text" => "商城入口",
                    "main" => "查看",
                    "edit" => "修改-log"
                ),
                "member" => array(
                    "text" => "会员中心入口",
                    "main" => "查看",
                    "edit" => "修改-log"
                ),
                "favorite" => array(
                    "text" => "收藏入口",
                    "main" => "查看",
                    "edit" => "修改-log"
                ),
                "cart" => array(
                    "text" => "购物车入口",
                    "main" => "查看",
                    "edit" => "修改-log"
                ),
                "order" => array(
                    "text" => "订单入口",
                    "main" => "查看",
                    "edit" => "修改-log"
                ),
                "coupon" => array(
                    "text" => "优惠券入口",
                    "main" => "查看",
                    "edit" => "修改-log"
                )
            )
        );
    }
    protected function perm_commission() {
        return $this->isopen("commission") && $this->is_perm_plugin("commission") ? array(
            "text" => m("plugin")->getName("commission"),
            "agent" => array(
                "text" => "分销商管理",
                "main" => "查看列表",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "user" => "查看下线",
                "export" => "导出-log",
                "changeagent" => "修改上级分销商-log",
                "xxx" => array(
                    "check" => "edit",
                    "agentblack" => "edit"
                )
            ),
            "level" => array(
                "text" => "分销商等级",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log"
            ),
            "buylevel" => array(
                "text" => "购买分销商等级",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log"
            ),
            "statistics" => array(
                "order" => array(
                    "text" => "分销订单",
                    "main" => "查看列表"
                ),
                "agent" => array(
                    "text" => "分销商统计",
                    "main" => "查看列表",
                    "edit" => "修改-log",
                    "delete" => "删除-log"
                ),
                "user" => array(
                    "text" => "分销关系",
                    "main" => "查看列表",
                    "edit" => "修改-log",
                    "delete" => "删除-log"
                )
            ),
            "apply" => array(
                "text" => "佣金审核",
                "view1" => "待审核浏览",
                "view2" => "待打款浏览",
                "view3" => "已打款浏览",
                "view_1" => "无效佣金浏览",
                "detail" => "详细佣金",
                "check" => "审核-log",
                "pay" => "打款-log",
                "cancel" => "重新审核-log",
                "refuse" => "驳回申请-log",
                "changecommission" => "修改佣金-log",
                "export" => "导出-log"
            ),
            "increase" => array(
                "text" => "分销商趋势图",
                "main" => "查看"
            ),
            "rank" => array(
                "text" => "佣金排行榜",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "notice" => array(
                "text" => "通知设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "cover" => array(
                "text" => "入口设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "set" => array(
                "text" => "基本设置",
                "main" => "查看",
                "edit" => "修改-log"
            )
        ) : array();
    }
    protected function perm_diyform() {
        return $this->isopen("diyform") && $this->is_perm_plugin("diyform") ? array(
            "text" => m("plugin")->getName("diyform"),
            "temp" => array(
                "text" => "模板",
                "main" => "查看列表",
                "view" => "查看",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log"
            ),
            "data" => array(
                "text" => "数据",
                "main" => "查看"
            ),
            "category" => array(
                "text" => "分类",
                "main" => "查看",
                "edit" => "修改-log",
                "xxx" => array(
                    "delete" => "edit",
                    "add" => "edit"
                )
            ),
            "set" => array(
                "text" => "设置",
                "main" => "查看",
                "edit" => "修改-log"
            )
        ) : array();
    }
    protected function perm_poster() {
        return $this->isopen("poster") && $this->is_perm_plugin("poster") ? array(
            "text" => m("plugin")->getName("poster"),
            "main" => "查看列表",
            "view" => "查看",
            "add" => "添加-log",
            "edit" => "修改-log",
            "delete" => "删除-log",
            "clear" => "清除缓存-log",
            "xxx" => array(
                "setdefault" => "edit"
            ),
            "log" => array(
                "text" => "关注记录",
                "main" => "查看"
            ),
            "scan" => array(
                "text" => "扫描记录",
                "main" => "查看"
            )
        ) : array();
    }
    protected function perm_postera() {
        return $this->isopen("postera") && $this->is_perm_plugin("postera") ? array(
            "text" => m("plugin")->getName("postera"),
            "main" => "查看列表",
            "view" => "查看",
            "add" => "添加-log",
            "edit" => "修改-log",
            "delete" => "删除-log",
            "clear" => "清除缓存-log",
            "xxx" => array(
                "setdefault" => "edit"
            ),
            "log" => array(
                "text" => "关注记录",
                "main" => "查看"
            )
        ) : array();
    }
    protected function perm_groups() {
        return $this->isopen("groups") && $this->is_perm_plugin("groups") ? array(
            "text" => m("plugin")->getName("groups"),
            "goods" => array(
                "text" => "商品管理",
                "view" => "查看",
                "edit" => "编辑-log",
                "add" => "添加-log",
                "delete" => "删除-log",
                "delete1" => "彻底删除-log",
                "restore" => "恢复到仓库-log",
                "xxx" => array(
                    "property" => "edit",
                    "status" => "edit"
                )
            ),
            "category" => array(
                "text" => "分类管理",
                "view" => "查看",
                "edit" => "编辑-log",
                "add" => "添加-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "displayorder" => "edit",
                    "enabled" => "edit"
                )
            ),
            "adv" => array(
                "text" => "幻灯片管理",
                "view" => "查看",
                "edit" => "编辑-log",
                "add" => "添加-log",
                "delete" => "删除-log"
            ),
            "order" => array(
                "text" => "订单管理",
                "view" => "查看",
                "pay" => "确认付款",
                "send" => "确认发货",
                "sendcancel" => "取消发货",
                "delete" => "删除订单",
                "remarksaler" => "商家备注",
                "finish" => "确认收货",
                "close" => "关闭订单",
                "changeaddress" => "编辑收货信息",
                "changeexpress" => "修改订单物流"
            ),
            "verify" => array(
                "text" => "核销查询",
                "view" => "查看"
            ),
            "team" => array(
                "text" => "拼团管理",
                "view" => "查看",
                "group" => "立即成团"
            ),
            "refund" => array(
                "text" => "维权设置",
                "view" => "查看",
                "submit" => "处理申请",
                "receipt" => "确认收货",
                "send" => "确认发货",
                "express" => "修改物流",
                "close" => "关闭订单",
                "note" => "商家备注"
            ),
            "cover" => array(
                "text" => "入口设置",
                "view" => "查看",
                "edit" => "编辑-log"
            ),
            "notice" => array(
                "text" => "通知设置",
                "view" => "查看",
                "edit" => "编辑-log"
            ),
            "set" => array(
                "text" => "基础设置",
                "view" => "查看",
                "edit" => "编辑-log"
            ),
            "exhelper" => array(
                "text" => "快递打印",
                "view" => "查看",
                "edit" => "编辑-log"
            ),
            "batchsend" => array(
                "text" => "批量发货",
                "view" => "查看",
                "edit" => "编辑-log"
            )
        ) : array();
    }
    protected function perm_messages() {
        return $this->isopen("messages") && $this->is_perm_plugin("messages") ? array(
            "text" => m("plugin")->getName("messages"),
            "main" => "消息群发",
            "run" => "消息发送",
            "add" => "新建任务",
            "edit" => "编辑任务",
            "view" => "查看任务",
            "delete" => "删除任务",
            "template" => array(
                "text" => "模板编辑",
                "view" => "查看模板",
                "add" => "新建模板",
                "edit" => "编辑模板",
                "delete" => "删除模板"
            )
        ) : array();
    }
    protected function perm_taobao() {
        return $this->isopen("taobao") && $this->is_perm_plugin("taobao") ? array(
            "text" => m("plugin")->getName("taobao"),
            "main" => "获取宝贝",
            "jingdong" => array(
                "text" => "京东助手",
                "main" => "获取宝贝"
            ),
            "one688" => array(
                "text" => "1688宝贝助手",
                "main" => "获取宝贝"
            ),
            "taobaocsv" => array(
                "text" => "淘宝CSV助手",
                "main" => "获取宝贝"
            ),
            "set" => array(
                "text" => "淘宝助手客户端",
                "main" => "获取宝贝"
            )
        ) : array();
    }
    protected function perm_article() {
        return $this->isopen("article") && $this->is_perm_plugin("article") ? array(
            "text" => m("plugin")->getName("article"),
            "main" => "查看列表",
            "add" => "添加-log",
            "edit" => "修改-log",
            "delete" => "删除-log",
            "record" => "查看统计",
            "xxx" => array(
                "displayorder" => "edit",
                "state" => "edit"
            ),
            "category" => array(
                "text" => "分类管理",
                "main" => "查看",
                "edit" => "修改-log",
                "delete" => "删除-log"
            ),
            "report" => array(
                "text" => "举报记录",
                "main" => "查看"
            ),
            "set" => array(
                "text" => "其他设置",
                "view" => "查看",
                "edit" => "修改-log"
            )
        ) : array();
    }
    protected function perm_creditshop() {
        return $this->isopen("creditshop") && $this->is_perm_plugin("creditshop") ? array(
            "text" => m("plugin")->getName("creditshop"),
            "goods" => array(
                "text" => "商品",
                "main" => "查看列表",
                "view" => "查看详细",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "property" => "edit",
                    "query" => "edit",
                    "querygoods" => "edit",
                    "status" => "edit",
                    "recycle" => "edit",
                    "deleted" => "delete"
                )
            ),
            "category" => array(
                "text" => "分类",
                "main" => "查看列表",
                "view" => "查看详细",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "enabled" => "edit",
                    "query" => "edit",
                    "displayorder" => "edit"
                )
            ),
            "adv" => array(
                "text" => "幻灯片",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "view" => "查看详细",
                "delete" => "删除-log",
                "xxx" => array(
                    "displayorder" => "edit",
                    "enabled" => "edit"
                )
            ),
            "log" => array(
                "text" => "订单/记录",
                "exchange" => "兑换记录",
                "draw" => "抽奖记录",
                "order" => "待发货",
                "convey" => "待收货",
                "finish" => "已完成",
                "verifying" => "待核销",
                "verifyover" => "已核销",
                "verify" => "全部核销",
                "detail" => "详情",
                "doexchange" => "确认兑换-log",
                "goodsfinish" => "确认收货-log",
                "export" => "导出明细-log"
            ),
            "comment" => array(
                "text" => "评价管理",
                "edit" => "回复评价",
                "check" => "审核评价"
            ),
            "cover" => array(
                "text" => "入口设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "notice" => array(
                "text" => "通知设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "set" => array(
                "text" => "基础设置",
                "main" => "查看",
                "edit" => "修改-log"
            )
        ) : array();
    }
    protected function perm_diypage() {
        return $this->isopen("diypage") && $this->is_perm_plugin("diypage") ? array(
            "text" => m("plugin")->getName("diypage"),
            "page" => array(
                "sys" => array(
                    "text" => "系统页面",
                    "main" => "查看列表",
                    "add" => "添加-log",
                    "edit" => "编辑-log",
                    "delete" => "删除-log",
                    "savetemp" => "另存为模板-log"
                ),
                "plu" => array(
                    "text" => "应用页面",
                    "main" => "查看列表",
                    "add" => "添加-log",
                    "edit" => "编辑-log",
                    "delete" => "删除-log",
                    "savetemp" => "另存为模板-log"
                ),
                "diy" => array(
                    "text" => "自定义页面",
                    "main" => "查看列表",
                    "add" => "添加-log",
                    "edit" => "编辑-log",
                    "delete" => "删除-log",
                    "savetemp" => "另存为模板-log"
                ),
                "mod" => array(
                    "text" => "公用模块",
                    "main" => "查看列表",
                    "add" => "添加-log",
                    "edit" => "编辑-log",
                    "delete" => "删除-log"
                )
            ),
            "menu" => array(
                "text" => "自定义菜单",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "编辑-log",
                "delete" => "删除-log"
            ),
            "shop" => array(
                "text" => "商城页面设置",
                "page" => array(
                    "text" => "页面设置",
                    "main" => "查看",
                    "save" => "保存-log"
                ),
                "menu" => array(
                    "text" => "按钮设置",
                    "main" => "查看",
                    "save" => "保存-log"
                ),
                "layer" => array(
                    "text" => "悬浮按钮",
                    "main" => "编辑-log"
                ),
                "followbar" => array(
                    "text" => "关注条",
                    "main" => "编辑-log"
                ),
                "danmu" => array(
                    "text" => "下单提醒",
                    "main" => "编辑-log"
                ),
                "adv" => array(
                    "text" => "启动广告",
                    "main" => "查看列表",
                    "add" => "添加-log",
                    "edit" => "编辑-log",
                    "delete" => "删除-log"
                )
            ),
            "temp" => array(
                "text" => "模板管理",
                "main" => "通过模板创建页面",
                "delete" => "删除模板",
                "category" => array(
                    "text" => "模板分类",
                    "main" => "查看",
                    "add" => "添加-log",
                    "edit" => "编辑-log",
                    "delete" => "删除-log"
                )
            )
        ) : array();
    }
    protected function perm_sign() {
        return $this->isopen("sign") && $this->is_perm_plugin("sign") ? array(
            "text" => m("plugin")->getName("sign"),
            "rule" => array(
                "text" => "签到规则",
                "main" => "查看",
                "edit" => "编辑-log"
            ),
            "set" => array(
                "text" => "签到入口",
                "main" => "查看",
                "edit" => "编辑-log"
            ),
            "records" => array(
                "text" => "签到记录",
                "main" => "查看"
            )
        ) : array();
    }
    protected function perm_mmanage() {
        return $this->isopen("mmanage") && $this->is_perm_plugin("mmanage") ? array(
            "text" => m("plugin")->getName("mmanage"),
            "setting" => array(
                "text" => "基本设置",
                "main" => "查看",
                "save" => "保存-log"
            )
        ) : array();
    }
    protected function perm_wangdian() {
        return $this->isopen("wangdian") && $this->is_perm_plugin("wangdian") ? array(
            "text" => m("plugin")->getName("wangdian"),
            "set" => array(
                "text" => "设同步置",
                "main" => "查看设置",
                "save" => "保存-log"
            )
        ) : array();
    }
    protected function perm_quick() {
        return $this->isopen("quick") && $this->is_perm_plugin("quick") ? array(
            "text" => m("plugin")->getName("quick"),
            "adv" => array(
                "text" => "幻灯片管理",
                "main" => "查看列表",
                "view" => "查看",
                "add" => "添加-log",
                "edit" => "编辑-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "enabled" => "edit"
                )
            ),
            "pages" => array(
                "text" => "页面管理",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "编辑-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "status" => "edit"
                )
            )
        ) : array();
    }
    protected function perm_backone() {
        return $this->isopen("backone") && $this->is_perm_plugin("backone") ? array(
            "text" => m("plugin")->getName("backone"),
            "goods" => array(
                "text" => "商品管理",
                "main" => "查看列表",
                "view" => "查看",
                "edit" => "编辑-log",
                "add" => "添加-log",
                "delete" => "删除-log"
            ),
            "apply" => array(
                "text" => "返还申请",
                "main" => "查看列表",
                "view" => "查看",
                "edit" => "审核-log",
                "xxx" => array(
                    "submit" => "edit"
                )
            ),
            "set" => array(
                "text" => "基本设置",
                "main" => "查看",
                "edit" => "编辑-log"
            ),
            "cover" => array(
                "text" => "入口设置",
                "main" => "查看",
                "edit" => "编辑-log"
            )
        ) : array();
    }
    protected function perm_exhelper() {
        return $this->isopen("exhelper") && $this->is_perm_plugin("exhelper") ? array(
            "text" => m("plugin")->getName("exhelper"),
            "print" => array(
                "single" => array(
                    "text" => "单个打印",
                    "express" => "打印快递单-log",
                    "invoice" => "打印发货单-log",
                    "dosend" => "一键发货-log"
                ),
                "batch" => array(
                    "text" => "批量打印",
                    "express" => "打印快递单-log",
                    "invoice" => "打印发货单-log",
                    "dosend" => "一键发货-log"
                )
            ),
            "esheetprint" => array(
                "single" => array(
                    "text" => "单个打印",
                    "express" => "打印电子面单-log",
                    "dosend" => "一键发货-log"
                ),
                "batch" => array(
                    "text" => "批量打印",
                    "express" => "打印电子面单-log",
                    "dosend" => "一键发货-log"
                )
            ),
            "temp" => array(
                "express" => array(
                    "text" => "快递单模板管理",
                    "add" => "添加-log",
                    "edit" => "修改-log",
                    "delete" => "删除-log",
                    "xxx" => array(
                        "setdefault" => "edit"
                    )
                ),
                "invoice" => array(
                    "text" => "发货单模板管理",
                    "add" => "添加-log",
                    "edit" => "修改-log",
                    "delete" => "删除-log",
                    "xxx" => array(
                        "setdefault" => "edit"
                    )
                ),
                "esheet" => array(
                    "text" => "电子面单模板管理",
                    "add" => "添加-log",
                    "edit" => "修改-log",
                    "delete" => "删除-log",
                    "xxx" => array(
                        "setdefault" => "edit"
                    )
                )
            ),
            "sender" => array(
                "text" => "发货人信息管理",
                "main" => "查看列表",
                "view" => "查看",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "setdefault" => "edit"
                )
            ),
            "short" => array(
                "text" => "商品简称",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "printset" => array(
                "text" => "打印端口设置",
                "main" => "查看",
                "edit" => "修改-log"
            )
        ) : array();
    }
    protected function perm_perm() {
        return array(
            "text" => "权限系统",
            "log" => array(
                "text" => "操作日志",
                "main" => "查看列表"
            ),
            "role" => array(
                "text" => "角色管理",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "status" => "edit",
                    "query" => "main"
                )
            ),
            "user" => array(
                "text" => "操作员管理",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "status" => "edit"
                )
            )
        );
    }
    protected function perm_globonus() {
        return $this->isopen("globonus") && $this->is_perm_plugin("globonus") ? array(
            "text" => m("plugin")->getName("globonus"),
            "partner" => array(
                "text" => "股东管理",
                "main" => "查看列表",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "export" => "导出-log",
                "xxx" => array(
                    "check" => "edit",
                    "partnerblack" => "edit"
                )
            ),
            "level" => array(
                "text" => "股东等级",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log"
            ),
            "bonus" => array(
                "text" => "分红管理",
                "status0" => "待确认浏览",
                "status1" => "待结算浏览",
                "status2" => "已结算浏览",
                "build" => "创建结算单-log",
                "confirm" => "确认结算单-log",
                "pay" => "结算结算单-log",
                "export" => "导出结算单-log",
                "delete" => "删除结算单-log",
                "detail" => "查看结算单详情",
                "detail.export" => "导出结算单股东详情-log",
                "xxx" => array(
                    "payp" => "pay",
                    "paymoney" => "confirm"
                )
            ),
            "notice" => array(
                "text" => "通知设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "cover" => array(
                "text" => "入口设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "set" => array(
                "text" => "基本设置",
                "main" => "查看",
                "edit" => "修改-log"
            )
        ) : array();
    }
    protected function perm_abonus() {
        return $this->isopen("abonus") && $this->is_perm_plugin("abonus") ? array(
            "text" => m("plugin")->getName("abonus"),
            "agent" => array(
                "text" => "代理管理",
                "main" => "查看列表",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "export" => "导出-log",
                "xxx" => array(
                    "check" => "edit",
                    "aagentblack" => "edit"
                )
            ),
            "level" => array(
                "text" => "代理等级",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log"
            ),
            "bonus" => array(
                "text" => "分红管理",
                "status0" => "待确认浏览",
                "status1" => "待结算浏览",
                "status2" => "已结算浏览",
                "build" => "创建结算单-log",
                "confirm" => "确认结算单-log",
                "pay" => "结算结算单-log",
                "export" => "导出结算单-log",
                "delete" => "删除结算单-log",
                "detail" => "查看结算单详情",
                "detail.export" => "导出结算单详情-log",
                "xxx" => array(
                    "payp" => "pay",
                    "paymoney_level" => "confirm",
                    "paymoney_aagent" => "confirm"
                )
            ),
            "notice" => array(
                "text" => "通知设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "cover" => array(
                "text" => "入口设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "set" => array(
                "text" => "基本设置",
                "main" => "查看",
                "edit" => "修改-log"
            )
        ) : array();
    }
    protected function perm_hotelreservation() {
        return $this->isopen("hotelreservation") && $this->is_perm_plugin("hotelreservation") ? array(
            "text" => m("plugin")->getName("hotelreservation"),
            "goods" => array(
                "text" => "民宿商品管理",
                "view" => "查看",
                "add" => "添加-log",
                "edit" => "编辑-log"
            ),
            "adv" => array(
                "text" => "幻灯片管理",
                "main" => "查看列表",
                "view" => "查看",
                "add" => "添加-log",
                "edit" => "编辑-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "displayorder" => "edit",
                    "enabled" => "edit"
                )
            ),
            "recommend" => array(
                "text" => "民宿推荐管理",
                "main" => "查看列表",
                "view" => "查看",
                "add" => "添加-log",
                "edit" => "编辑-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "displayorder" => "edit",
                    "enabled" => "edit"
                )
            )
        ) : array();
    }
    protected function perm_merch() {
        return $this->isopen("merch") && $this->is_perm_plugin("merch") ? array(
            "text" => m("plugin")->getName("merch"),
            "reg" => array(
                "text" => "入驻申请",
                "detail" => "查看详情",
                "delete" => "删除-log"
            ),
            "user" => array(
                "text" => "商户管理",
                "view" => "查看详情",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log"
            ),
            "group" => array(
                "text" => "商户分组",
                "view" => "查看详情",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log"
            ),
            "category" => array(
                "text" => "商户分类",
                "view" => "查看详情",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "swipe" => array(
                    "text" => "商户分类幻灯管理",
                    "view" => "查看详情",
                    "add" => "添加-log",
                    "edit" => "编辑-log",
                    "delete" => "删除-log"
                )
            ),
            "statistics" => array(
                "text" => "数据统计",
                "order" => "订单统计",
                "order.export" => "导出订单统计-log",
                "merch" => "商户统计",
                "merch.export" => "导出商户统计-log"
            ),
            "check" => array(
                "text" => "提现申请",
                "status1" => "待确认的申请",
                "status2" => "待打款的申请",
                "status3" => "已打款的申请",
                "status_1" => "无效的申请",
                "confirm" => "审核通过-log",
                "pay" => "打款-log",
                "refuse" => "驳回申请-log",
                "export" => "导出申请单-log",
                "detail" => "申请详情",
                "detail.export" => "导出申请单订单详情-log"
            ),
            "notice" => array(
                "text" => "通知设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "cover" => array(
                "text" => "入口设置",
                "main" => "查看",
                "edit" => "修改-log",
                "register" => "申请入住",
                "merchlist" => "商户导航",
                "merchuser" => "商户导航(含定位距离)"
            ),
            "set" => array(
                "text" => "基本设置",
                "main" => "查看",
                "edit" => "修改-log"
            )
        ) : array();
    }
    protected function perm_mr() {
        return $this->isopen("mr") && $this->is_perm_plugin("mr") ? array(
            "text" => m("plugin")->getName("mr"),
            "goods" => array(
                "text" => "商品管理",
                "main" => "查看列表",
                "view" => "查看",
                "add" => "添加-log",
                "edit" => "编辑-log",
                "delete" => "删除-log"
            ),
            "adv" => array(
                "text" => "幻灯片管理",
                "main" => "查看列表",
                "view" => "查看",
                "add" => "添加-log",
                "edit" => "编辑-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "displayorder" => "edit",
                    "enabled" => "edit"
                )
            ),
            "order" => array(
                "text" => "订单管理",
                "main" => "查看",
                "recharge" => "手动充值-log",
                "refund" => "退款-log",
                "export" => "导出-log"
            ),
            "api" => array(
                "text" => "接口设置",
                "main" => "查看列表",
                "view" => "查看",
                "edit" => "编辑-log"
            ),
            "set" => array(
                "text" => "全局设置",
                "main" => "查看",
                "save" => "编辑-log"
            )
        ) : array();
    }
    protected function perm_qa() {
        return $this->isopen("qa") && $this->is_perm_plugin("qa") ? array(
            "text" => m("plugin")->getName("qa"),
            "adv" => array(
                "text" => "幻灯片",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "view" => "查看详细",
                "delete" => "删除-log",
                "xxx" => array(
                    "displayorder" => "edit",
                    "enabled" => "edit"
                )
            ),
            "question" => array(
                "text" => "问题管理",
                "main" => "查看列表",
                "view" => "查看",
                "add" => "添加-log",
                "edit" => "编辑-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "displayorder" => "edit",
                    "enabled" => "edit",
                    "isrecommand" => "edit"
                )
            ),
            "category" => array(
                "text" => "分类管理",
                "main" => "查看列表",
                "view" => "查看",
                "add" => "添加-log",
                "edit" => "编辑-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "displayorder" => "edit",
                    "enabled" => "edit",
                    "isrecommand" => "edit"
                )
            ),
            "set" => array(
                "text" => "基础设置",
                "main" => "查看",
                "save" => "编辑-log"
            )
        ) : array();
    }
    protected function perm_pstore() {
        return $this->isopen("pstore") && $this->is_perm_plugin("pstore") ? array(
            "text" => m("plugin")->getName("pstore"),
            "user" => array(
                "text" => "门店管理",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "view" => "查看详细",
                "delete" => "删除-log",
                "xxx" => array(
                    "status" => "edit"
                )
            ),
            "category" => array(
                "text" => "门店分类",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "view" => "查看详细",
                "delete" => "删除-log",
                "xxx" => array(
                    "status" => "edit"
                )
            ),
            "set" => array(
                "text" => "基础设置",
                "view" => "查看",
                "edit" => "编辑-log"
            ),
            "notice" => array(
                "text" => "消息通知",
                "view" => "查看",
                "edit" => "编辑-log"
            ),
            "clearing" => array(
                "text" => "门店结算",
                "main" => "查看",
                "edit" => "编辑-log"
            )
        ) : array();
    }
    protected function perm_author() {
        return $this->isopen("author") && $this->is_perm_plugin("author") ? array(
            "text" => m("plugin")->getName("author"),
            "partner" => array(
                "text" => "创始人管理",
                "main" => "查看列表",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "export" => "导出-log",
                "xxx" => array(
                    "check" => "edit",
                    "authorblack" => "edit"
                )
            ),
            "level" => array(
                "text" => "创始人等级",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log"
            ),
            "bonus" => array(
                "text" => "分红管理",
                "status0" => "待确认浏览",
                "status1" => "待结算浏览",
                "status2" => "已结算浏览",
                "build" => "创建结算单-log",
                "confirm" => "确认结算单-log",
                "pay" => "结算结算单-log",
                "export" => "导出结算单-log",
                "delete" => "删除结算单-log",
                "detail" => "查看结算单详情",
                "detail.export" => "导出结算单创始人详情-log",
                "xxx" => array(
                    "payp" => "pay",
                    "paymoney" => "confirm"
                )
            ),
            "notice" => array(
                "text" => "通知设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "cover" => array(
                "text" => "入口设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "set" => array(
                "text" => "基本设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "team" => array(
                "text" => "团队结算",
                "main" => "查看",
                "status0" => "待结算浏览",
                "status1" => "已结算浏览",
                "delete" => "删除结算单-log",
                "detail" => "查看结算单详情",
                "detail.edit" => "修改团队结算单"
            )
        ) : array();
    }
    protected function perm_task() {
        if (!($this->isopen("task") && $this->is_perm_plugin("task"))) {
            return array();
        }
        if (p("task")) {
            if (method_exists(p("task"), "isnew")) {
                $isnew = true;
            }
            if ($isnew && p("task")->isnew()) {
                return array(
                    "text" => m("plugin")->getName("task"),
                    "main" => "首页",
                    "tasklist" => "查看列表",
                    "add" => "添加-log",
                    "edit" => "编辑-log",
                    "delete" => "删除-log",
                    "record" => array(
                        "text" => "任务记录",
                        "main" => "查看"
                    ),
                    "reward" => array(
                        "text" => "奖励记录",
                        "main" => "查看"
                    ),
                    "notice" => array(
                        "text" => "消息通知",
                        "main" => "编辑"
                    ),
                    "setting" => array(
                        "text" => "系统设置",
                        "edit" => "编辑"
                    )
                );
            }
            return array(
                "text" => m("plugin")->getName("task"),
                "main" => "查看列表",
                "view" => "查看",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "clear" => "清除缓存-log",
                "xxx" => array(
                    "setdefault" => "edit"
                ),
                "extension.single" => array(
                    "text" => "单次任务",
                    "main" => "查看"
                ),
                "extension.repeat" => array(
                    "text" => "周期任务",
                    "main" => "查看"
                ),
                "log" => array(
                    "text" => "关注记录",
                    "main" => "查看"
                ),
                "adv" => array(
                    "text" => "幻灯片",
                    "main" => "查看列表",
                    "add" => "添加-log",
                    "edit" => "修改-log",
                    "view" => "查看详细",
                    "delete" => "删除-log",
                    "xxx" => array(
                        "displayorder" => "edit",
                        "enabled" => "edit"
                    )
                ),
                "default" => array(
                    "text" => "系统设置",
                    "main" => "查看",
                    "add" => "添加-log",
                    "edit" => "修改-log",
                    "view" => "查看详细",
                    "setstart" => "入口设置",
                    "xxx" => array(
                        "displayorder" => "edit",
                        "enabled" => "edit"
                    )
                )
            );
        }
        return array();
    }
    protected function perm_lottery() {
        return $this->isopen("lottery") && $this->is_perm_plugin("lottery") ? array(
            "text" => m("plugin")->getName("lottery"),
            "main" => "查看列表",
            "view" => "查看",
            "add" => "添加-log",
            "edit" => "修改-log",
            "delete" => "删除-log",
            "clear" => "清除缓存-log",
            "xxx" => array(
                "setdefault" => "edit"
            ),
            "log" => array(
                "text" => "关注记录",
                "main" => "查看"
            ),
            "setting" => array(
                "text" => "系统设置",
                "main" => "查看",
                "add" => "添加-log",
                "edit" => "修改-log",
                "view" => "查看详细",
                "setlottery" => "说明&通知设置",
                "setstart" => "入口设置",
                "xxx" => array(
                    "displayorder" => "edit",
                    "enabled" => "edit"
                )
            )
        ) : array();
    }
    protected function perm_cashier() {
        return $this->isopen("cashier") && $this->is_perm_plugin("cashier") ? array(
            "text" => m("plugin")->getName("cashier"),
            "user" => array(
                "text" => "收银台管理",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "view" => "查看详细",
                "delete" => "删除-log",
                "xxx" => array(
                    "status" => "edit"
                )
            ),
            "category" => array(
                "text" => "收银台分类",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "view" => "查看详细",
                "delete" => "删除-log",
                "xxx" => array(
                    "status" => "edit"
                )
            ),
            "set" => array(
                "text" => "基础设置",
                "view" => "查看",
                "edit" => "编辑-log"
            ),
            "notice" => array(
                "text" => "消息通知",
                "view" => "查看",
                "edit" => "编辑-log"
            ),
            "clearing" => array(
                "text" => "门店结算",
                "main" => "查看",
                "edit" => "编辑-log"
            )
        ) : array();
    }
    protected function perm_cycelbuy() {
        return $this->isopen("cycelbuy") && $this->is_perm_plugin("cycelbuy") ? array(
            "text" => m("plugin")->getName("cycelbuy"),
            "goods" => array(
                "text" => "商品管理",
                "main" => "浏览列表",
                "detail" => "查看详情",
                "add" => "添加",
                "edit" => "修改",
                "delete" => "删除",
                "delete1" => "彻底删除"
            ),
            "order" => array(
                "text" => "订单管理",
                "status_1" => "浏览关闭订单",
                "status0" => "浏览待付款订单",
                "status1" => "浏览已付款订单",
                "status2" => "浏览已发货订单",
                "status3" => "浏览完成的订单",
                "status4" => "维权申请",
                "status5" => "维权完成"
            ),
            "op" => array(
                "text" => "操作",
                "delete" => "订单删除-log",
                "pay" => "确认付款-log",
                "send" => "发货-log",
                "sendcancel" => "取消发货-log",
                "finish" => "确认收货(快递单)-log",
                "close" => "关闭订单-log",
                "changeprice" => "订单改价-log",
                "changeaddress" => "修改收货地址-log",
                "remarksaler" => "订单备注-log",
                "paycancel" => "订单取消付款-log",
                "xxx" => array(
                    "changeexpress" => "send"
                )
            ),
            "refund" => array(
                "text" => "地址修改审核",
                "main" => "浏览申请",
                "detail" => "浏览详情",
                "disagree" => "审批操作",
                "save" => "添加修改"
            ),
            "comment" => array(
                "text" => "评价管理",
                "main" => "浏览评价",
                "edit" => "修改虚拟评价",
                "add" => "添加虚拟评价",
                "post" => "修改评价",
                "virtual" => "虚拟评价操作"
            ),
            "notice" => array(
                "text" => "通知设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "set" => array(
                "text" => "基本设置",
                "main" => "查看",
                "edit" => "修改-log"
            )
        ) : array();
    }
    public function perm_dividend() {
        return $this->isopen("dividend") && $this->is_perm_plugin("dividend") ? array(
            "text" => m("plugin")->getName("dividend"),
            "agent" => array(
                "text" => "团员管理",
                "main" => "查看列表",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "user" => "查看团员",
                "export" => "导出-log",
                "xxx" => array(
                    "check" => "edit"
                )
            ),
            "statistics" => array(
                "order" => array(
                    "text" => "分红订单",
                    "main" => "查看列表"
                )
            ),
            "apply" => array(
                "text" => "分红审核",
                "view1" => "待审核浏览",
                "view2" => "待打款浏览",
                "view3" => "已打款浏览",
                "view_1" => "无效分红浏览",
                "detail" => "详细分红",
                "check" => "审核-log",
                "pay" => "打款-log",
                "cancel" => "重新审核-log",
                "refuse" => "驳回申请-log",
                "export" => "导出-log"
            ),
            "notice" => array(
                "text" => "通知设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "cover" => array(
                "text" => "入口设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "set" => array(
                "text" => "基本设置",
                "main" => "查看",
                "edit" => "修改-log"
            )
        ) : array();
    }
    public function perm_membercard() {
        return $this->isopen("membercard") && $this->is_perm_plugin("membercard") ? array(
            "text" => m("plugin")->getName("membercard"),
            "cardmanage" => array(
                "text" => "会员卡管理",
                "main" => "会员卡列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log"
            ),
            "getrecord" => array(
                "text" => "领取记录",
                "main" => "查看"
            )
        ) : array();
    }
    public function perm_friendcoupon() {
        return $this->isopen("friendcoupon") && $this->is_perm_plugin("friendcoupon") ? array(
            "text" => m("plugin")->getName("friendcoupon"),
            "activity_list" => array(
                "text" => "活动设置",
                "main" => "查看列表",
                "add" => "添加-log",
                "edit" => "编辑-log",
                "delete" => "删除-log",
                "copy" => "复制-log",
                "stop" => "停止-log"
            ),
            "statistics" => array(
                "text" => "数据统计",
                "main" => "查看列表"
            )
        ) : array();
    }
    public function perm_openmessikefu() {
        return $this->isopen("open_messikefu") && $this->is_perm_plugin("open_messikefu") ? array(
            "text" => m("plugin")->getName("open_messikefu"),
            "set" => array(
                "text" => "基本设置",
                "edit" => "修改"
            )
        ) : array();
    }
    public function perm_goodscircle() {
        return $this->isopen("goodscircle") && $this->is_perm_plugin("goodscircle") ? array(
            "text" => m("plugin")->getName("goodscircle"),
            "set" => array(
                "text" => "基本设置",
                "main" => "修改-log"
            )
        ) : array();
    }
    public function perm_pc() {
        return $this->isopen("pc") && $this->is_perm_plugin("pc") ? array(
            "text" => m("plugin")->getName("pc"),
            "goods" => array(
                "text" => "商品组管理",
                "main" => "商品组列表",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log"
            ),
            "menu" => array(
                "text" => "菜单管理",
                "top" => "顶部导航",
                "bottom" => "底部导航",
                "add" => "添加-log",
                "edit" => "修改-log",
                "xxx" => array(
                    "switchChange" => "edit"
                )
            ),
            "adv" => array(
                "text" => "广告管理",
                "banner" => "首页轮播",
                "recommend" => "推荐广告"
            ),
            "typesetting" => array(
                "text" => "排版设置",
                "main" => "查看"
            ),
            "setting" => array(
                "text" => "基本设置",
                "main" => "查看"
            )
        ) : array();
    }
    public function perm_openfarm() {
        return $this->isopen("open_farm") && $this->is_perm_plugin("open_farm") ? array(
            "text" => m("plugin")->getName("open_farm"),
            "main" => "用户统计",
            "xxx" => array(
                "getList" => "main"
            ),
            "notice" => array(
                "text" => "公告管理",
                "main" => "公告列表",
                "addInfo" => "添加",
                "getInfo" => "修改",
                "deleteInfo" => "删除",
                "xxx" => array(
                    "getList" => "main",
                    "deleteAll" => "deleteInfo"
                )
            ),
            "reply" => array(
                "text" => "回复管理",
                "main" => "回复列表",
                "addInfo" => "添加",
                "getInfo" => "修改",
                "deleteInfo" => "删除",
                "xxx" => array(
                    "getList" => "main",
                    "deleteAll" => "deleteInfo"
                )
            ),
            "mood" => array(
                "text" => "心情管理",
                "main" => "查看",
                "addInfo" => "添加",
                "xxx" => array(
                    "getInfo" => "main",
                    "getSon" => "addInfo",
                    "addMood" => "addInfo",
                    "addMoodPicture" => "addInfo"
                )
            ),
            "task" => array(
                "text" => "任务管理",
                "main" => "任务列表",
                "addInfo" => "添加",
                "editInfo" => "修改",
                "deleteInfo" => "删除",
                "xxx" => array(
                    "getList" => "main",
                    "getInfo" => "editInfo",
                    "getCategory" => "editInfo",
                    "getMemberLevel" => "editInfo",
                    "getTaskCore" => "editInfo",
                    "getGoods" => "editInfo"
                )
            ),
            "grade" => array(
                "text" => "等级管理",
                "main" => "等级列表",
                "addInfo" => "添加",
                "saveInfo" => "修改",
                "deleteInfo" => "删除",
                "xxx" => array(
                    "getList" => "main"
                )
            ),
            "surprised" => array(
                "text" => "彩蛋管理",
                "main" => "彩蛋列表",
                "addInfo" => "添加",
                "getInfo" => "修改",
                "deleteInfo" => "删除",
                "xxx" => array(
                    "getList" => "main",
                    "deleteAll" => "deleteInfo",
                    "getCoupon" => "getInfo",
                    "getCategory" => "getInfo"
                )
            ),
            "seting" => array(
                "text" => "农场设置",
                "main" => "查看",
                "editInfo" => "修改",
                "xxx" => array(
                    "getInfo" => "main",
                    "getAdvertisementMax" => "editInfo"
                )
            ),
            "configure" => array(
                "text" => "农场配置",
                "main" => "查看",
                "editInfo" => "修改",
                "xxx" => array(
                    "getInfo" => "main",
                    "getAdvertisementMax" => "editInfo",
                    "setReplyKeywordRule" => "editInfo",
                    "getRule" => "editInfo",
                    "setReply" => "editInfo",
                    "setKeyword" => "editInfo"
                )
            )
        ) : array();
    }
    public function isopen($pluginname = "", $iscom = false) {
        return com_perm_isopen($pluginname, $iscom);
    }
    public function is_perm_plugin($pluginname = "", $iscom = false) {
        if ($iscom) {
            return com_perm_check_com($pluginname);
        }
        return com_perm_check_plugin($pluginname);
    }
    public function check_edit($permtype = "", $item = array()) {
        if (empty($permtype)) {
            return false;
        }
        if (!$this->check_perm($permtype)) {
            return false;
        }
        if (empty($item["id"])) {
            $add_perm = $permtype . ".add";
            if (!$this->check($add_perm)) {
                return false;
            }
            return true;
        }
        $edit_perm = $permtype . ".edit";
        if (!$this->check($edit_perm)) {
            return false;
        }
        return true;
    }
    public function check_perm($permtypes = "") {
        global $_W;
        $check = true;
        if (empty($permtypes)) {
            return false;
        }
        if (!strexists($permtypes, "&") && !strexists($permtypes, "|")) {
            $check = $this->check($permtypes);
        } else {
            if (strexists($permtypes, "&")) {
                $pts = explode("&", $permtypes);
                foreach ($pts as $pt) {
                    $check = $this->check($pt);
                    if (!$check) {
                        break;
                    }
                }
            } else {
                if (strexists($permtypes, "|")) {
                    $pts = explode("|", $permtypes);
                    foreach ($pts as $pt) {
                        $check = $this->check($pt);
                        if ($check) {
                            break;
                        }
                    }
                }
            }
        }
        return $check;
    }
    private function check($permtype = "") {
        global $_W;
        global $_GPC;
        if ($_W["role"] == "manager" || $_W["role"] == "founder" || $_W["role"] == "owner") {
            return true;
        }
        $uid = $_W["uid"];
        if ($_W["role"] == "vice_founder") {
            $vice_founder = pdo_fetchcolumn("SELECT COUNT(id)FROM " . tablename("uni_account_users") . "WHERE uid=:uid AND role=:role AND uniacid=:uniacid", array(
                ":uid" => $uid,
                ":role" => "vice_founder",
                ":uniacid" => intval($_W["uniacid"])
            ));
            if (!empty($vice_founder)) {
                return true;
            }
            $info = pdo_get("uni_account_users", array(
                "uniacid" => intval($_W["uniacid"]),
                "uid" => $uid
            ));
            if (!empty($info) && $info["role"] == "owner") {
                return true;
            }
            return false;
        }
        if (empty($permtype)) {
            return false;
        }
        $user = pdo_fetch("select u.status as userstatus,r.status as rolestatus,u.perms2 as userperms,r.perms2 as roleperms,u.roleid from " . tablename("ewei_shop_perm_user") . " u " . " left join " . tablename("ewei_shop_perm_role") . " r on u.roleid = r.id " . " where u.uid=:uid and u.uniacid = :uniacid limit 1 ", array(
            ":uid" => $uid,
            ":uniacid" => intval($_W["uniacid"])
        ));
        if (empty($user) || empty($user["userstatus"])) {
            return false;
        }
        if (!empty($user["roleid"]) && empty($user["rolestatus"])) {
            return false;
        }
        $role_perms = explode(",", $user["roleperms"]);
        $user_perms = explode(",", $user["userperms"]);
        $perms      = array_merge($role_perms, $user_perms);
        if (empty($perms)) {
            return false;
        }
        $is_xxx = $this->check_xxx($permtype);
        if ($is_xxx) {
            if (!in_array($is_xxx, $perms)) {
                return false;
            }
        } else {
            if (!in_array($permtype, $perms)) {
                return false;
            }
        }
        return true;
    }
    /**
     * 查看是不是继承
     * @param $permtype
     * @return bool|string
     */
    public function check_xxx($permtype) {
        if ($permtype) {
            $allPerm = $this->allPerms();
            $permarr = explode(".", $permtype);
            if (isset($permarr[3])) {
                $is_xxx = isset($allPerm[$permarr[0]][$permarr[1]][$permarr[2]]["xxx"][$permarr[3]]) ? $allPerm[$permarr[0]][$permarr[1]][$permarr[2]]["xxx"][$permarr[3]] : false;
            } else {
                if (isset($permarr[2])) {
                    $is_xxx = isset($allPerm[$permarr[0]][$permarr[1]]["xxx"][$permarr[2]]) ? $allPerm[$permarr[0]][$permarr[1]]["xxx"][$permarr[2]] : false;
                } else {
                    if (isset($permarr[1])) {
                        $is_xxx = isset($allPerm[$permarr[0]]["xxx"][$permarr[1]]) ? $allPerm[$permarr[0]]["xxx"][$permarr[1]] : false;
                    } else {
                        $is_xxx = false;
                    }
                }
            }
            if ($is_xxx) {
                $permarr = explode(".", $permtype);
                array_pop($permarr);
                $is_xxx = implode(".", $permarr) . "." . $is_xxx;
            }
            return $is_xxx;
        }
        return false;
    }
    public function check_plugin($pluginname = "") {
        return com_perm_check_plugin($pluginname);
    }
    public function getPermset() {
        return com_perm_getPermset();
    }
    public function check_com($comname = "") {
        return com_perm_check_com($comname);
    }
    public function getLogName($type = "", $logtypes = NULL) {
        if (!$logtypes) {
            $logtypes = $this->getLogTypes();
        }
        foreach ($logtypes as $t) {
            if ($t["value"] == $type) {
                return $t["text"];
            }
        }
        return "";
    }
    public function getLogTypes($all = false) {
        if (empty(self::$getLogTypes)) {
            $perms = $this->allPerms();
            $array = array();
            foreach ($perms as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $ke => $val) {
                        if (!is_array($val)) {
                            if ($all) {
                                if ($ke == "text") {
                                    $text = str_replace("-log", "", $value["text"]);
                                } else {
                                    $text = str_replace("-log", "", $value["text"] . "-" . $val);
                                }
                                $array[] = array(
                                    "text" => $text,
                                    "value" => str_replace(".text", "", $key . "." . $ke)
                                );
                            } else {
                                if (strexists($val, "-log")) {
                                    $text = str_replace("-log", "", $value["text"] . "-" . $val);
                                    if ($ke == "text") {
                                        $text = str_replace("-log", "", $value["text"]);
                                    }
                                    $array[] = array(
                                        "text" => $text,
                                        "value" => str_replace(".text", "", $key . "." . $ke)
                                    );
                                }
                            }
                        }
                        if (is_array($val) && $ke != "xxx") {
                            foreach ($val as $k => $v) {
                                if (!is_array($v)) {
                                    if ($all) {
                                        if ($ke == "text") {
                                            $text = str_replace("-log", "", $value["text"] . "-" . $val["text"]);
                                        } else {
                                            $text = str_replace("-log", "", $value["text"] . "-" . $val["text"] . "-" . $v);
                                        }
                                        $array[] = array(
                                            "text" => $text,
                                            "value" => str_replace(".text", "", $key . "." . $ke . "." . $k)
                                        );
                                    } else {
                                        if (strexists($v, "-log")) {
                                            $text = str_replace("-log", "", $value["text"] . "-" . $val["text"] . "-" . $v);
                                            if ($k == "text") {
                                                $text = str_replace("-log", "", $value["text"] . "-" . $val["text"]);
                                            }
                                            $array[] = array(
                                                "text" => $text,
                                                "value" => str_replace(".text", "", $key . "." . $ke . "." . $k)
                                            );
                                        }
                                    }
                                }
                                if (is_array($v) && $k != "xxx") {
                                    foreach ($v as $kk => $vv) {
                                        if (!is_array($vv)) {
                                            if ($all) {
                                                if ($ke == "text") {
                                                    $text = str_replace("-log", "", $value["text"] . "-" . $val["text"] . "-" . $v["text"]);
                                                } else {
                                                    $text = str_replace("-log", "", $value["text"] . "-" . $val["text"] . "-" . $v["text"] . "-" . $vv);
                                                }
                                                $array[] = array(
                                                    "text" => $text,
                                                    "value" => str_replace(".text", "", $key . "." . $ke . "." . $k . "." . $kk)
                                                );
                                            } else {
                                                if (strexists($vv, "-log")) {
                                                    if (empty($val["text"])) {
                                                        $text = str_replace("-log", "", $value["text"] . "-" . $v["text"] . "-" . $vv);
                                                    } else {
                                                        $text = str_replace("-log", "", $value["text"] . "-" . $val["text"] . "-" . $v["text"] . "-" . $vv);
                                                    }
                                                    if ($kk == "text") {
                                                        $text = str_replace("-log", "", $value["text"] . "-" . $val["text"] . "-" . $v["text"]);
                                                    }
                                                    $array[] = array(
                                                        "text" => $text,
                                                        "value" => str_replace(".text", "", $key . "." . $ke . "." . $k . "." . $kk)
                                                    );
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            self::$getLogTypes = $array;
        }
        return self::$getLogTypes;
    }
    public function log($type = "", $op = "") {
        global $_W;
        $is_xxx = $this->check_xxx($type);
        if ($is_xxx) {
            $type = $is_xxx;
        }
        static $_logtypes = NULL;
        if (!$_logtypes) {
            $_logtypes = $this->getLogTypes();
        }
        $log = array(
            "uniacid" => $_W["uniacid"],
            "uid" => $_W["uid"],
            "name" => $this->getLogName($type, $_logtypes),
            "type" => $type,
            "op" => $op,
            "ip" => CLIENT_IP,
            "createtime" => time()
        );
        pdo_insert("ewei_shop_perm_log", $log);
    }
    public function formatPerms() {
        if (empty(self::$formatPerms)) {
            $perms = $this->allPerms();
            $array = array();
            foreach ($perms as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $ke => $val) {
                        if (!is_array($val)) {
                            $array["parent"][$key][$ke] = $val;
                        }
                        if (is_array($val) && $ke != "xxx") {
                            foreach ($val as $k => $v) {
                                if (!is_array($v)) {
                                    $array["son"][$key][$ke][$k] = $v;
                                }
                                if (is_array($v) && $k != "xxx") {
                                    foreach ($v as $kk => $vv) {
                                        if (!is_array($vv)) {
                                            $array["grandson"][$key][$ke][$k][$kk] = $vv;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            self::$formatPerms = $array;
        }
        return self::$formatPerms;
    }
    protected function perm_sns() {
        return $this->isopen("sns") && $this->is_perm_plugin("sns") ? array(
            "text" => m("plugin")->getName("sns"),
            "adv" => array(
                "text" => "幻灯片",
                "main" => "查看列表",
                "view" => "查看详细",
                "add" => "添加-log",
                "edit" => "修改-log",
                "view" => "查看详细",
                "delete" => "删除-log",
                "xxx" => array(
                    "displayorder" => "edit",
                    "enabled" => "edit"
                )
            ),
            "category" => array(
                "text" => "分类管理",
                "main" => "查看列表",
                "view" => "查看详细",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "enabled" => "edit",
                    "displayorder" => "edit"
                )
            ),
            "level" => array(
                "text" => "等级管理",
                "main" => "查看列表",
                "view" => "查看详细",
                "add" => "添加-log",
                "edit" => "修改-log",
                "view" => "查看详细",
                "delete" => "删除-log",
                "xxx" => array(
                    "enabled" => "edit"
                )
            ),
            "member" => array(
                "text" => "会员管理",
                "main" => "查看列表",
                "delete" => "删除-log",
                "setblack" => "设置黑名单-log"
            ),
            "manage" => array(
                "text" => "版主管理",
                "main" => "查看列表",
                "view" => "查看详细",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log"
            ),
            "board" => array(
                "text" => "版块管理",
                "main" => "查看列表",
                "view" => "查看详细",
                "add" => "添加-log",
                "edit" => "修改-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "status" => "edit",
                    "displayorder" => "edit"
                )
            ),
            "posts" => array(
                "text" => "话题管理",
                "main" => "查看",
                "add" => "发表话题-log",
                "edit" => "编辑话题-log",
                "delete" => "删除-log",
                "delete1" => "彻底删除-log",
                "check" => "审核-log",
                "best" => "精华-log",
                "top" => "置顶-log"
            ),
            "replys" => array(
                "text" => "评论管理",
                "main" => "查看",
                "delete" => "删除-log",
                "delete1" => "彻底删除-log",
                "check" => "审核-log"
            ),
            "complain" => array(
                "text" => "投诉管理",
                "main" => "查看",
                "category" => "投诉类别",
                "delete" => "删除-log",
                "delete1" => "彻底删除-log",
                "check" => "审核-log"
            ),
            "cover" => array(
                "text" => "入口设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "notice" => array(
                "text" => "通知设置",
                "main" => "查看",
                "edit" => "修改-log"
            ),
            "set" => array(
                "text" => "基础设置",
                "main" => "查看",
                "edit" => "修改-log"
            )
        ) : array();
    }
    protected function perm_seckill() {
        return $this->isopen("seckill") && $this->is_perm_plugin("seckill") ? array(
            "text" => m("plugin")->getName("seckill"),
            "task" => array(
                "text" => "专题管理",
                "view" => "查看",
                "edit" => "编辑-log",
                "add" => "添加-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "enabled" => "edit"
                )
            ),
            "room" => array(
                "text" => "会场管理",
                "view" => "查看",
                "edit" => "编辑-log",
                "add" => "添加-log",
                "delete" => "删除-log",
                "xxx" => array(
                    "enabled" => "edit"
                )
            ),
            "goods" => array(
                "text" => "商品管理",
                "view" => "查看",
                "delete" => "取消-log"
            ),
            "category" => array(
                "text" => " 分类管理",
                "view" => "查看",
                "edit" => "编辑-log",
                "add" => "添加-log",
                "delete" => "删除-log"
            ),
            "adv" => array(
                "text" => "幻灯片管理",
                "view" => "查看",
                "edit" => "编辑-log",
                "add" => "添加-log",
                "delete" => "删除-log"
            ),
            "calendar" => array(
                "text" => "任务设置",
                "view" => "查看",
                "edit" => "编辑-log"
            ),
            "cover" => array(
                "text" => "入口设置",
                "view" => "查看",
                "edit" => "编辑-log"
            )
        ) : array();
    }
}
?>