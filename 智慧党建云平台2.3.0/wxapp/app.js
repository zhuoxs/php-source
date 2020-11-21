App({
    onLaunch: function() {},
    onShow: function() {},
    onHide: function() {},
    onError: function(e) {
        console.log(e);
    },
    tabBar: {
        color: "#888888",
        selectedColor: "#e64340",
        borderStyle: "#e64340",
        backgroundColor: "#fff",
        list: [ {
            pagePath: "/vlinke_cparty/pages/home/home",
            iconPath: "/vlinke_cparty/resource/icon/barhome.png",
            selectedIconPath: "/vlinke_cparty/resource/icon/barhomeon.png",
            text: "首页"
        }, {
            pagePath: "/vlinke_cparty/pages/art/arthome",
            iconPath: "/vlinke_cparty/resource/icon/bararthome.png",
            selectedIconPath: "/vlinke_cparty/resource/icon/bararthomeon.png",
            text: "动态"
        }, {
            pagePath: "/vlinke_cparty/pages/act/acthome",
            iconPath: "/vlinke_cparty/resource/icon/baracthome.png",
            selectedIconPath: "/vlinke_cparty/resource/icon/baracthomeon.png",
            text: "活动"
        }, {
            pagePath: "/vlinke_cparty/pages/edu/eduhome",
            iconPath: "/vlinke_cparty/resource/icon/bareduhome.png",
            selectedIconPath: "/vlinke_cparty/resource/icon/bareduhomeon.png",
            text: "学习"
        }, {
            pagePath: "/vlinke_cparty/pages/my/my",
            iconPath: "/vlinke_cparty/resource/icon/barmy.png",
            selectedIconPath: "/vlinke_cparty/resource/icon/barmyon.png",
            text: "我的"
        } ]
    },
    globalData: {
        userInfo: null
    },
    util: require("we7/resource/js/util.js"),
    siteInfo: require("siteinfo.js")
});