var app = getApp(), wxbarcode = require("../../../../style/utils/index.js");

Page({
    data: {
        state: 1
    },
    onLoad: function(e) {
        var t = this;
        wx.setStorageSync("id", e.id), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        });
        var a = '{ "id": ' + e.id + "}";
        wxbarcode.qrcode("qrcode", a, 320, 320);
    },
    onReady: function() {},
    onShow: function() {
        var t = this, e = wx.getStorageSync("id");
        app.util.request({
            url: "entry/wxapp/OrderDetails",
            cachetime: "0",
            data: {
                id: e
            },
            success: function(e) {
                console.log(e.data), t.setData({
                    details: e.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    confirmOrder: function(e) {
        var t = e.currentTarget.dataset.id, a = this, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/comfOrder",
            cachetime: "0",
            data: {
                openid: n,
                id: t
            },
            success: function(e) {
                console.log(e), 1 == e.data && wx.showToast({
                    title: "确认成功！"
                }), a.onShow();
            }
        });
    },
    deleteOrder: function(e) {
        var t = this, a = e.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "确定取消订单吗",
            success: function(e) {
                e.confirm ? (curorder.splice(index, 1), t.setData({
                    curorder: curorder
                }), app.util.request({
                    url: "entry/wxapp/cancelOrder",
                    cachetime: "0",
                    data: {
                        id: a
                    },
                    success: function(e) {
                        wx.showToast({
                            title: "删除成功！"
                        }), t.onShow();
                    }
                })) : e.cancel && console.log("用户点击取消");
            }
        });
    }
});