var app = getApp();

Page({
    data: {
        ke: [ "可提现佣金", "可提现提成" ]
    },
    onLoad: function(t) {
        this.setData({
            backgroundColor: app.globalData.Headcolor
        }), this.yemian();
    },
    yemian: function(t) {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Treewith",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(t) {
                var e = t.data.data.user.treemoney;
                o.setData({
                    treemoney: e
                });
            }
        });
    },
    rtiqie: function(t) {
        var e = t.currentTarget.dataset.index;
        this.setData({
            kenif: e
        }), this.yemian(e);
    },
    onReady: function() {},
    formSubmit: function(t) {
        console.log("form发生了submit事件，携带数据为：", t.detail.value);
        var e = t.detail.value, o = e.tmoney, n = this;
        app.util.request({
            url: "entry/wxapp/Treetixian",
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
                }), n.yemian();
            },
            fail: function(t) {
                var e = t.data.message;
                wx.showModal({
                    title: "提示",
                    content: e,
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