Page({
    data: {
        list: [ {
            title: "今日总访客数",
            detail: "0"
        }, {
            title: "今日总成交额",
            detail: "0"
        }, {
            title: "今日订单数",
            detail: "0"
        }, {
            title: "待接单",
            detail: "0"
        }, {
            title: "代配送",
            detail: "0"
        }, {
            title: "退款订单",
            detail: "0"
        } ],
        finance: [ {
            title: "今日收益",
            detail: "0"
        }, {
            title: "昨日收益",
            detail: "0"
        }, {
            title: "总计收益",
            detail: "0"
        } ]
    },
    onLoad: function(t) {
        var e = this;
        wx.getUserInfo({
            success: function(t) {
                e.setData({
                    thumb: t.userInfo.avatarUrl,
                    nickname: t.userInfo.nickName
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toMessage: function(t) {
        wx.redirectTo({
            url: "../message/message"
        });
    },
    toSet: function(t) {
        wx.redirectTo({
            url: "../set/set"
        });
    },
    scanCode: function(t) {
        wx.scanCode({
            success: function(t) {
                var e = t.result;
                wx.navigateTo({
                    url: e
                });
            }
        });
    }
});