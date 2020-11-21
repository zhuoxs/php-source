var app = getApp();

Page({
    data: {
        ke: [ "可提现佣金", "可提现提成" ]
    },
    onLoad: function(t) {
        var a = t.kenif;
        this.yemian(a), this.setData({
            kenif: a
        });
    },
    yemian: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Withdraw",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                kenif: t
            },
            success: function(t) {
                var a = t.data.data, n = t.data.data.user;
                e.setData({
                    aica: a,
                    useraica: n
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
        var a = t.detail.value, n = a.tel, e = a.name, o = a.tmoney, i = a.weixin, s = this;
        app.util.request({
            url: "entry/wxapp/Ctixian",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                tel: n,
                name: e,
                tmoney: o,
                weixin: i
            },
            success: function(t) {
                t.message;
                wx.showModal({
                    title: "提示",
                    content: "申请成功",
                    success: function(t) {
                        t.confirm ? console.log("用户点击确定") : console.log("用户点击取消");
                    }
                }), s.yemian(1);
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
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});