var o = require("../../../utils/base.js"), e = require("../../../../api.js"), i = new o.Base();

Page({
    data: {},
    onLoad: function(o) {},
    onShow: function() {
        this.getMobile();
    },
    onPullDownRefresh: function() {
        this.getMobile(), wx.showNavigationBarLoading(), setTimeout(function() {
            wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
        }, 500);
    },
    scanCode: function(o) {
        wx.scanCode({
            onlyFromCamera: !0,
            success: function(o) {
                if (o.path) {
                    var e = o.path.split("?")[1];
                    "boguan_mall/pages/Home/verification/verification" == o.path.split("?")[0] ? wx.navigateTo({
                        url: "../../Home/verification/verification?" + e
                    }) : wx.showModal({
                        title: "提示",
                        showCancel: !1,
                        content: "该二维码不是订单核销码，请扫描核销二维码"
                    });
                }
            }
        });
    },
    getMobile: function(o) {
        var t = this, n = {
            url: e.mobile.mobile_index,
            method: "GET"
        };
        i.getData(n, function(o) {
            wx.showLoading({
                title: "请稍后"
            }), 1 == o.errorCode ? t.setData({
                mobile: o.data
            }) : 10001 == o.error_code || wx.showModal({
                title: "提示",
                showCancel: !1,
                content: o.msg,
                success: function(o) {
                    wx.reLaunch({
                        url: "../../Tab/index/index"
                    });
                }
            }), setTimeout(function() {
                wx.hideLoading();
            }, 300), console.log(o);
        });
    }
});