App({
    onLaunch: function() {},
    onShow: function() {},
    onHide: function() {},
    onError: function(n) {
        console.log(n);
    },
    util: require("we7/resource/js/util.js"),
    globalData: {
        userInfo: null
    },
    siteInfo: require("siteinfo.js")
});