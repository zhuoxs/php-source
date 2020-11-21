var wxbarcode = require("../../../../we7/js/utils/index.js"), app = getApp();

Page({
    data: {
        tabs: [ "待确认", "已存入", "已提取" ],
        activeIndex: 0
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
        var a = '{ "id": ' + e.id + ', "ordertype": 3}';
        wxbarcode.qrcode("qrcode", a, 280, 280);
    },
    onReady: function() {},
    onShow: function() {
        var t = this, e = wx.getStorageSync("id");
        app.util.request({
            url: "entry/wxapp/KeepwineOrder",
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
    tabClick: function(e) {
        this.setData({
            sliderOffset: e.currentTarget.offsetLeft,
            activeIndex: e.currentTarget.id
        });
    }
});