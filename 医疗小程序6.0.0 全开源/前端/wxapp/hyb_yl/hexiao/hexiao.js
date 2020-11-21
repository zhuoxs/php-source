var app = getApp();

Page({
    data: {
        path: ""
    },
    onLoad: function(o) {
        var n = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: n
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    tap_scanCode: function() {
        var e = this;
        wx.scanCode({
            success: function(o) {
                wx.showToast({
                    title: "扫码成功,信息查询中!"
                }), console.log(o);
                var t = o.path;
                e.setData({
                    path: t
                }), app.util.request({
                    url: "entry/wxapp/Store",
                    data: {
                        ky_yibao: t
                    },
                    success: function(o) {
                        console.log(o);
                        var n = o.data.data;
                        return console.log(n), e.setData({
                            order: n
                        }), "1" == n.zy_zhenzhuang ? (wx.showModal({
                            title: "核销失败",
                            content: "该订单已核销过,无法再次核销!",
                            showCancel: !1
                        }), !1) : n.zy_telephone != t ? (wx.showModal({
                            title: "核销失败",
                            content: "该订单不存在!",
                            showCancel: !1
                        }), !1) : void wx.showModal({
                            title: "提示",
                            content: "是否核销该订单",
                            confirmText: "确认核销",
                            success: function(o) {
                                console.log(o.confirm), o.confirm ? app.util.request({
                                    url: "entry/wxapp/Save_order",
                                    data: {
                                        oncode: n.zy_telephone,
                                        openid: wx.getStorageSync("openid")
                                    },
                                    success: function(o) {
                                        console.log(o), e.setData({
                                            hexiaop: o.data.data
                                        }), wx.showModal({
                                            title: "核销成功",
                                            content: "该订单已成功核销!",
                                            showCancel: !1
                                        });
                                    }
                                }) : o.cancel && console.log("用户点击取消");
                            }
                        });
                    }
                });
            },
            fail: function(o) {
                wx.showToast({
                    image: "../images/error.png",
                    title: "扫码失败!"
                });
            }
        });
    }
});