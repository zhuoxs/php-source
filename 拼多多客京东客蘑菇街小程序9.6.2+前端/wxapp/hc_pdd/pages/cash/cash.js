var app = getApp();

Page({
    data: {
        ke: [ "可提现佣金", "可提现提成" ]
    },
    onLoad: function(t) {
        var a = t.kenif, e = t.path || 0, n = t.totalmoney;
        console.log(n), this.yemian(a), this.setData({
            kenif: a,
            path: e,
            money1: n
        });
    },
    yemian: function(t) {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Withdraw",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                kenif: t
            },
            success: function(t) {
                var a = t.data.data, e = t.data.data.user, n = t.data.data.set;
                o.setData({
                    aica: a,
                    useraica: e,
                    seat: n
                });
            }
        });
    },
    rtiqie: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            kenif: a
        }), this.yemian(a);
    },
    onReady: function() {},
    formSubmit: function(t) {
        console.log("form发生了submit事件，携带数据为：", t.detail.value);
        var a = t.detail.value, e = a.tel, n = a.name, o = a.tmoney, i = a.weixin, s = this, c = s.data.seat.wtype;
        if (0 == c) app.util.request({
            url: "entry/wxapp/Wxtixian",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                tmoney: o
            },
            success: function(t) {
                t.message;
                wx.showModal({
                    title: "提示",
                    content: "申请成功",
                    success: function(t) {
                        t.confirm ? console.log("用户点击确定") : console.log("用户点击取消");
                    }
                }), s.yemian();
            },
            fail: function(t) {
                var a = t.data.message;
                wx.showModal({
                    title: "提示",
                    content: a,
                    success: function(t) {
                        t.confirm ? console.log("用户点击确定") : console.log("用户点击取消");
                    }
                });
            }
        }); else if (1 == c) {
            var l = "";
            l = s.data.path ? "entry/wxapp/Treetixianzfb" : "entry/wxapp/Tixian", app.util.request({
                url: l,
                method: "POST",
                data: {
                    user_id: app.globalData.user_id,
                    tel: e,
                    name: n,
                    tmoney: o,
                    weixin: i,
                    kenif: s.data.kenif
                },
                success: function(t) {
                    t.message;
                    wx.showModal({
                        title: "提示",
                        content: "申请成功",
                        success: function(t) {
                            t.confirm ? console.log("用户点击确定") : console.log("用户点击取消");
                        }
                    }), s.yemian();
                },
                fail: function(t) {
                    var a = t.data.message;
                    wx.showModal({
                        title: "提示",
                        content: a,
                        success: function(t) {
                            t.confirm ? console.log("用户点击确定") : console.log("用户点击取消");
                        }
                    });
                }
            });
        }
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});