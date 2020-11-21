var app = getApp();

Page({
    data: {
        list: [ {
            title: "今日预约",
            detail: "0"
        }, {
            title: "总预约量",
            detail: "0"
        } ]
    },
    onLoad: function(t) {
        var e = this, n = t.id;
        wx.setStorageSync("id", n), wx.getUserInfo({
            success: function(t) {
                e.setData({
                    thumb: t.userInfo.avatarUrl,
                    nickname: t.userInfo.nickName
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this, t = wx.getStorageSync("id");
        app.util.request({
            url: "entry/wxapp/Nowuser",
            cachetime: "0",
            data: {
                id: t
            },
            success: function(t) {
                e.setData({
                    count: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(t) {
                e.setData({
                    pt_name: t.data.pt_name
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    gocurrent: function(t) {
        var e = wx.getStorageSync("id");
        wx.navigateTo({
            url: "../current/current?id=" + e
        });
    },
    gofinish: function(t) {
        var e = wx.getStorageSync("id");
        wx.navigateTo({
            url: "../../backstage/finish/finish?id=" + e
        });
    },
    onShareAppMessage: function() {},
    scanCode: function(t) {
        wx.scanCode({
            success: function(t) {
                var e = t.result;
                wx.navigateTo({
                    url: e
                });
            }
        });
    },
    orderNum: function(t) {
        this.setData({
            orderNum: t.detail.value
        });
    },
    submit: function(t) {
        var e = this, n = e.data.orderNum;
        if (null == n) wx.showModal({
            content: "请输入订单号",
            showCancel: !1
        }); else {
            var a = wx.getStorageSync("id");
            app.util.request({
                url: "entry/wxapp/IsUserorder",
                cachetime: "0",
                data: {
                    orderNum: n,
                    hair_id: a
                },
                success: function(t) {
                    console.log(t), 1 == t.data ? (e.setData({
                        orderNum: ""
                    }), wx.showToast({
                        title: "确认成功",
                        icon: "success",
                        duration: 2e3,
                        success: function() {}
                    })) : wx.showToast({
                        title: "确认失败",
                        icon: "none",
                        duration: 2e3
                    });
                }
            });
        }
    }
});