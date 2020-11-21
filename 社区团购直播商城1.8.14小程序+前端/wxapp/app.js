App({
    onLaunch: function(e) {},
    version: "1.8.14",
    location: null,
    ex_company: null,
    getUserInfo: !1,
    accredit: null,
    systeminfo: null,
    address: null,
    order: null,
    voucher: null,
    user_set: null,
    module_url: null,
    toolbar: null,
    club: null,
    floaticon: null,
    globalData: {
        m: "xc_xinguwu",
        userInfo: null,
        theme: null,
        webset: null,
        express: null,
        home_set: {
            style: 2
        }
    },
    sale: {
        rownum: 1
    },
    util: require("we7/resource/js/util.js"),
    look: require("utils/look.js"),
    tabBar: {
        color: "#acacac",
        selectedColor: "#f93d3d",
        backgroundColor: "#ffffff",
        borderStyle: "#fff",
        number: 0,
        userinfo: 0,
        list: [ {
            pagePath: "/xc_xinguwu/pages/index/index",
            iconPath: "/xc_xinguwu/images/index/index.png",
            selectedIconPath: "/xc_xinguwu/images/index/index_selected.png",
            text: "首页"
        }, {
            pagePath: "/xc_xinguwu/pages/list/sale/sale",
            iconPath: "/xc_xinguwu/images/index/list.png",
            selectedIconPath: "/xc_xinguwu/images/index/list_selected.png",
            text: "列表"
        }, {
            pagePath: "/xc_xinguwu/pages/cart/cart",
            iconPath: "/xc_xinguwu/images/index/cart.png",
            selectedIconPath: "/xc_xinguwu/images/index/cart_selected.png",
            text: "购物车"
        }, {
            pagePath: "/xc_xinguwu/pages/user/user",
            iconPath: "/xc_xinguwu/images/index/user.png",
            selectedIconPath: "/xc_xinguwu/images/index/user_selected.png",
            text: "个人中心"
        } ]
    },
    group_tabBar: {
        color: "#444444",
        selectedColor: "#f04043",
        backgroundColor: "#ffffff",
        borderStyle: "white",
        number: 0,
        list: [ {
            pagePath: "/xc_xinguwu/pages/index/index",
            iconPath: "/xc_xinguwu/images/groupbuy/back.png",
            selectedIconPath: "/xc_xinguwu/images/groupbuy/back_selected.png",
            text: "返回"
        }, {
            pagePath: "/xc_xinguwu/pages/grouplist/grouplist",
            iconPath: "/xc_xinguwu/images/groupbuy/list.png",
            selectedIconPath: "/xc_xinguwu/images/groupbuy/list_selected.png",
            text: "拼团"
        }, {
            pagePath: "/xc_xinguwu/pages/mygroup/mygroup",
            iconPath: "/xc_xinguwu/images/groupbuy/attend.png",
            selectedIconPath: "/xc_xinguwu/images/groupbuy/attend_selected.png",
            text: "我的团"
        } ]
    },
    sport_tabBar: {
        color: "#F93D3D",
        selectedColor: "#F93D3D",
        backgroundColor: "#ffffff",
        borderStyle: "white",
        list: [ {
            pagePath: "/xc_xinguwu/sport/sport/sport",
            iconPath: "/xc_xinguwu/images/sport/s-index.png",
            selectedIconPath: "/xc_xinguwu/images/sport/s-indexed.png",
            text: "首页"
        }, {
            pagePath: "/xc_xinguwu/sport/sportChange/sportChange",
            iconPath: "/xc_xinguwu/images/sport/s-change.png",
            selectedIconPath: "/xc_xinguwu/images/sport/s-changed.png",
            text: "兑换"
        }, {
            pagePath: "/xc_xinguwu/sport/sportChall/sportChall",
            iconPath: "/xc_xinguwu/images/sport/s-chall.png",
            selectedIconPath: "/xc_xinguwu/images/sport/s-challed.png",
            text: "挑战"
        }, {
            pagePath: "/xc_xinguwu/sport/sportUser/sportUser",
            iconPath: "/xc_xinguwu/images/sport/s-user.png",
            selectedIconPath: "/xc_xinguwu/images/sport/s-usered.png",
            text: "我的"
        } ]
    },
    onError: function(e) {
        console.log(e);
    },
    siteInfo: require("siteinfo.js")
});