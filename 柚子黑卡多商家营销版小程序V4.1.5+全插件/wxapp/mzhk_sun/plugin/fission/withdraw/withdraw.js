/*   time:2019-08-09 13:18:39*/
var app = getApp(),
    wxbarcode = require("../../../../style/utils/index.js");
Page({
    data: {},
    onLoad: function(o) {
        var t = this,
            n = o.oid,
            e = o.bid,
            a = wx.getStorageSync("openid");
        n && e && a && app.util.request({
            url: "entry/wxapp/Getorder",
            showLoading: !1,
            data: {
                oid: n,
                bid: e,
                openid: a,
                m: app.globalData.Plugin_fission
            },
            success: function(o) {
                console.log(o.data), t.setData({
                    content: o.data
                })
            }
        });
        var i = '{ "id": ' + n + ', "ordertype": 11}';
        wxbarcode.qrcode("qrcode", i, 360, 360)
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    getCode: function(o) {
        console.log(o), this.setData({
            code: o.detail.value
        })
    },
    toHx: function(o) {
        var t = this.data.code,
            n = parseInt(o.currentTarget.dataset.oid);
        if (!t) return wx.showToast({
            title: "请填写验证密码！",
            icon: "none",
            duration: 2e3
        }), !1;
        n && t && app.util.request({
            url: "entry/wxapp/Writeoffcode",
            showLoading: !1,
            data: {
                oid: n,
                code: t,
                m: app.globalData.Plugin_fission
            },
            success: function(o) {
                if (console.log(o.data), 2 == o.data) return wx.showToast({
                    title: "验证密码错误！",
                    icon: "none",
                    duration: 2e3
                }), !1;
                wx.reLaunch({
                    url: "/mzhk_sun/pages/index/index"
                })
            }
        })
    }
});