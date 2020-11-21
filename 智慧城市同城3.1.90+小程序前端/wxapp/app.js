App({
    onLaunch: function() {},
    onShow: function() {},
    onHide: function() {},
    onError: function(o) {
        console.log(o);
    },
    util: require("we7/resource/js/util.js"),
    tabBar: {
        color: "#123",
        selectedColor: "#1ba9ba",
        borderStyle: "#1ba9ba",
        backgroundColor: "#fff",
        list: []
    },
    globalData: {
        userInfo: null
    },
    userInfo: {
        sessionid: null
    },
    siteInfo: require("siteinfo.js")
});