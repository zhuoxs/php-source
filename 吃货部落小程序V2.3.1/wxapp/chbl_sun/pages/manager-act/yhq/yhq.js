var app = getApp();

Page({
    data: {},
    onLoad: function(o) {},
    onReady: function() {},
    onShow: function() {
        var t = this, o = wx.getStorageSync("openid"), n = wx.getStorageSync("auth_type");
        app.util.request({
            url: "entry/wxapp/GetBranchCoupon",
            cachetime: "0",
            data: {
                openid: o,
                auth_type: n
            },
            success: function(o) {
                console.log(o), t.setData({
                    couponlist: o.data.data
                });
            }
        });
    },
    goUseNow: function(o) {
        console.log(o);
        var t = this, n = o.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "是否确认删除？",
            success: function(o) {
                o.confirm ? app.util.request({
                    url: "entry/wxapp/DelCoupon",
                    cachetime: "0",
                    data: {
                        id: n
                    },
                    success: function(o) {
                        console.log(o), 1 == o.data.data && (wx.showToast({
                            title: "删除成功！"
                        }), setTimeout(function() {
                            t.onShow();
                        }, 1e3));
                    }
                }) : o.cancel && console.log("用户点击取消");
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});