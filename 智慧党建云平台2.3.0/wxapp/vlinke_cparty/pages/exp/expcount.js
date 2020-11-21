!function(e) {
    e && e.__esModule;
}(require("../../util/request.js"));

var e = getApp();

Page({
    data: {
        paymoney: "0.00"
    },
    formSubmit: function(e) {
        var t = this, a = parseFloat(e.detail.value.getmoney), o = parseFloat(e.detail.value.proportion);
        if (a && o) {
            var n = a * o / 100;
            t.setData({
                paymoney: n.toFixed(2)
            });
        } else wx.showModal({
            title: "提示",
            content: "税后月收入以及缴纳标准不能为空！",
            showCancel: !1,
            success: function(e) {}
        });
    },
    onLoad: function(e) {
        var t = this, a = wx.getStorageSync("param") || null, o = wx.getStorageSync("user") || null;
        t.setData({
            param: a,
            user: o
        });
    },
    onReady: function() {
        e.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var e = this;
        return {
            title: e.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: e.data.param.wxappshareimageurl
        };
    }
});