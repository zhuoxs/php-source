var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Page({
    data: {
        paymoney: "0.00"
    },
    formSubmit: function(e) {
        var t = parseFloat(e.detail.value.getmoney), a = parseFloat(e.detail.value.proportion);
        if (t && a) {
            var n = t * a / 100;
            this.setData({
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
        var t = wx.getStorageSync("param") || null, a = wx.getStorageSync("user") || null;
        this.setData({
            param: t,
            user: a
        });
    },
    onReady: function() {
        app.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: this.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: this.data.param.wxappshareimageurl
        };
    }
});