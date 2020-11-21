var n = getApp();

Page({
    data: {},
    onLoad: function(a) {
        wx.request({
            url: n.data.url + "index",
            data: {},
            success: function(a) {
                console.log(a), "0000" == a.data.retCode ? (console.log("成功进来...."), wx.redirectTo({
                    url: "/pages/index/index"
                })) : (console.log("失败进来...."), wx.redirectTo({
                    url: "/pages/logs/logs"
                }), n.data.piansheng_title = a.data.piansheng_title, n.data.piansheng_email = a.data.piansheng_email, 
                n.data.piansheng_qq = a.data.piansheng_qq, n.data.piansheng_content = a.data.piansheng_content);
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});