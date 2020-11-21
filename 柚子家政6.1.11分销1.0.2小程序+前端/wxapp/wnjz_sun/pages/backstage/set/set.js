var app = getApp();

Page({
    data: {
        Completed: [ {
            orderNum: 11111,
            cname: 1111111,
            name: "1111",
            time: "11111"
        }, {
            orderNum: 11111,
            cname: 1111111,
            name: "1111",
            time: "11111"
        } ],
        nav: [ "全部", "待服务", "已完成" ],
        curIndex: 0,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(n) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toIndex: function(n) {
        wx.redirectTo({
            url: "../index/index"
        });
    },
    bargainTap: function(n) {
        var e = parseInt(n.currentTarget.dataset.index);
        this.setData({
            curIndex: e
        });
    }
});