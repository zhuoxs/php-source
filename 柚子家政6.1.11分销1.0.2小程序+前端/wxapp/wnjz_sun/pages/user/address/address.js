var app = getApp();

Page({
    data: {
        status: !1,
        addr: []
    },
    onLoad: function(t) {
        0 == (n = this).data.addr.length && n.setData({
            status: !0
        });
        var n = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = wx.getStorageSync("openid"), n = this;
        app.util.request({
            url: "entry/wxapp/FuwuAddress",
            method: "GET",
            data: {
                userid: t
            },
            success: function(t) {
                console.log(t), n.setData({
                    addr: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toEditaddr: function(t) {
        t.currentTarget.dataset.adid;
        wx.navigateTo({
            " url": "../editaddr/editaddr?id=".ids
        });
    },
    clickCancel: function(t) {
        var n = t.currentTarget.dataset.adid;
        wx.showModal({
            title: "提示",
            content: "确定删除该地址吗",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/Deteleadd",
                    method: "GET",
                    data: {
                        id: n
                    },
                    success: function(t) {
                        wx.showModal({
                            content: "删除成功",
                            showCancel: !1
                        }), wx.redirectTo({});
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    }
});