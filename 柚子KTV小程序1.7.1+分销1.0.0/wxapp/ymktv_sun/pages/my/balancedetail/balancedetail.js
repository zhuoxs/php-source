var app = getApp();

Page({
    data: {
        list: [ {
            con: "雪津啤酒+美味水果",
            tiem: "2018年06月22日 20:16:58",
            num: "－100.00"
        }, {
            con: "周六周日黄金档欢唱",
            tiem: "2018年06月22日 20:16:58",
            num: "－100.00"
        }, {
            con: "普通充值300送50",
            tiem: "2018年06月22日 20:16:58",
            num: "+350.00"
        } ]
    },
    onLoad: function(n) {},
    onReady: function() {},
    onShow: function() {
        var t = this, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/FineBalance",
            cachetime: "0",
            data: {
                openid: n
            },
            success: function(n) {
                t.setData({
                    FineBalance: n.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});