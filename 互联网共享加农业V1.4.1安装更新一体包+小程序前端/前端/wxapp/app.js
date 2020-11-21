App({
    onLaunch: function(t) {},
    onShow: function(t) {},
    onHide: function() {},
    onError: function(t) {},
    util: require("we7/resource/js/util.js"),
    footer: [ {
        pagePath: "../index/index",
        text: "首页",
        iconPath: "../../images/bottom_icon01.png",
        selectedIconPath: "../../images/bottom_icon01_h.png",
        status: 1
    }, {
        pagePath: "../live/live",
        text: "视频",
        iconPath: "../../images/bottom_icon02.png",
        selectedIconPath: "../../images/bottom_icon02_h.png",
        status: 1
    }, {
        pagePath: "../shop/shop",
        text: "商城",
        iconPath: "../../images/bottom_icon03.png",
        selectedIconPath: "../../images/bottom_icon03_h.png",
        status: 1
    }, {
        pagePath: "../event/event",
        text: "乐游",
        iconPath: "../../images/bottom_icon04.png",
        selectedIconPath: "../../images/bottom_icon04_h.png",
        status: 1
    }, {
        pagePath: "../my/my",
        text: "我的",
        iconPath: "../../images/bottom_icon05.png",
        selectedIconPath: "../../images/bottom_icon05_h.png",
        status: 1
    } ],
    admin: [ {
        pagePath: "../../index/index",
        text: "首页",
        iconPath: "../../../images/bottom_icon01.png",
        selectedIconPath: "../../../images/bottom_icon01_h.png",
        status: 1
    }, {
        pagePath: "../../admin/order/order",
        text: "管理中心",
        iconPath: "../../../images/bottom_icon06.png",
        selectedIconPath: "../../../images/bottom_icon06_h.png",
        status: 1
    }, {
        pagePath: "../../admin/index/index",
        text: "我的",
        iconPath: "../../../images/bottom_icon05.png",
        selectedIconPath: "../../../images/bottom_icon05_h.png",
        status: 1
    } ],
    admin2: [ {
        pagePath: "../../admin/index2/index2",
        text: "主页",
        iconPath: "../../../images/bottom_icon01.png",
        selectedIconPath: "../../../images/bottom_icon01_h.png",
        status: 1
    }, {
        pagePath: "../../admin/service/service?&admin=2",
        text: "生产记录",
        iconPath: "../../../images/bottom_icon07.png",
        selectedIconPath: "../../../images/bottom_icon07_h.png",
        status: 1
    }, {
        pagePath: "../../trace/trace?&admin=2",
        text: "销售出库",
        iconPath: "../../../images/bottom_icon08.png",
        selectedIconPath: "../../../images/bottom_icon08_h.png",
        status: 1
    }, {
        pagePath: "../../admin/order/order?&admin=2",
        text: "订单管理",
        iconPath: "../../../images/bottom_icon09.png",
        selectedIconPath: "../../../images/bottom_icon09_h.png",
        status: 1
    }, {
        pagePath: "../../admin/store/store",
        text: "我的店铺",
        iconPath: "../../../images/bottom_icon06.png",
        selectedIconPath: "../../../images/bottom_icon06_h.png",
        status: 1
    } ],
    admin3: [ {
        pagePath: "../../fen_admin/index/index",
        text: "主页",
        iconPath: "../../../images/bottom_icon01.png",
        selectedIconPath: "../../../images/bottom_icon01_h.png",
        status: 1
    }, {
        pagePath: "../../fen_admin/service/service",
        text: "推荐大厅",
        iconPath: "../../../images/bottom_icon10.png",
        selectedIconPath: "../../../images/bottom_icon10_h.png",
        status: 1
    }, {
        pagePath: "../../fen_admin/center/center",
        text: "收入管理",
        iconPath: "../../../images/bottom_icon11.png",
        selectedIconPath: "../../../images/bottom_icon11_h.png",
        status: 1
    }, {
        pagePath: "../../fen_admin/order/order",
        text: "订单查看",
        iconPath: "../../../images/bottom_icon09.png",
        selectedIconPath: "../../../images/bottom_icon09_h.png",
        status: 1
    }, {
        pagePath: "../../fen_admin/store/store",
        text: "我的店铺",
        iconPath: "../../../images/bottom_icon06.png",
        selectedIconPath: "../../../images/bottom_icon06_h.png",
        status: 1
    } ],
    theme: {
        name: 1,
        color: "#77d4c0",
        icon: [ "../../images/radio.png", "../../images/bottom_icon02_h.png", "../../images/share.png", "../../images/nd_icon01.png", "../../images/info.png", "../../images/mapping.png", "../../images/user.png", "../../images/phone2.png", "../../images/laj_icon01.png", "../../images/laj_icon02.png", "../../images/border.jpg" ]
    },
    config: {
        webname: ""
    },
    app_add_status: !1,
    globalData: {
        userInfo: null,
        login: -1,
        version: "1.4.1"
    },
    siteInfo: require("siteinfo.js")
});