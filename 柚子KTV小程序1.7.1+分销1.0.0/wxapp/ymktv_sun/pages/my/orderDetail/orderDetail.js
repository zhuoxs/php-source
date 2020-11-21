var app = getApp(), wxbarcode = require("../../../../we7/js/utils/index.js");

Page({
    data: {},
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
        var a = '{ "id": ' + e.id + ', "ordertype": 1}';
        wxbarcode.qrcode("qrcode", a, 280, 280);
    },
    onReady: function() {},
    onShow: function() {
        var t = this, e = wx.getStorageSync("id");
        app.util.request({
            url: "entry/wxapp/RoomOrderDetails",
            cachetime: "0",
            data: {
                id: e
            },
            success: function(e) {
                t.setData({
                    details: e.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});