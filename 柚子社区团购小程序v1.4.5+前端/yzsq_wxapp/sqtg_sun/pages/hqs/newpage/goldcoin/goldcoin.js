var app = getApp();

Page({
    data: {
        page: 1,
        limit: 10,
        hasMore: !0,
        coinData: []
    },
    onLoad: function(a) {
        var t = this;
        t.checkLogin(function(a) {
            console.log(a), t.setData({
                user: a,
                coin: a.coin
            }), t.getCoindateils();
        }, "/sqtg_sun/pages/hqs/newpage/goldcoin/goldcoin", !0);
    },
    getCoindateils: function() {
        var t = this;
        app.ajax({
            url: "Cuser|coinDetail",
            data: {
                user_id: t.data.user.id,
                ordertype: "desc",
                orderfield: "create_time"
            },
            success: function(a) {
                t.setData({
                    coinData: a.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var n = this;
        console.log("上拉触底"), n.data.hasMore ? (n.setData({
            page: ++n.data.page,
            limit: n.data.limit
        }), app.ajax({
            url: "Cuser|coinDetail",
            data: {
                user_id: n.data.user.id,
                page: n.data.page,
                limit: n.data.limit,
                ordertype: "desc",
                orderfield: "create_time"
            },
            success: function(a) {
                console.log(a);
                var t = n.data.coinData.concat(a.data), e = parseInt(a.other.count), o = n.data.page * n.data.limit < e;
                n.setData({
                    coinData: t,
                    hasMore: o
                });
            }
        })) : wx.showToast({
            title: "没有更多数据了",
            icon: "none"
        });
    },
    onShareAppMessage: function() {}
});