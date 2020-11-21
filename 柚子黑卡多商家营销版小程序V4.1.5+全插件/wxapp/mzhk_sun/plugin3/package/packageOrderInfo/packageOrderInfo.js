/*   time:2019-08-09 13:18:47*/
var app = getApp(),
    wxbarcode = require("../../../../style/utils/index.js");
Page({
    data: {
        show: !1,
        setInter4: ""
    },
    onLoad: function(t) {
        this.setData({
            id: t.order_id
        })
    },
    onShow: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/orderdet",
            data: {
                oid: a.data.id,
                m: app.globalData.Plugin_package
            },
            success: function(t) {
                console.log(t), a.setData({
                    orderinfo: t.data,
                    imgLink: wx.getStorageSync("url")
                })
            }
        })
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    hx: function(t) {
        var a = this,
            e = this,
            o = t.currentTarget.dataset.id,
            n = t.currentTarget.dataset.sid,
            r = t.currentTarget.dataset.lid,
            i = t.currentTarget.dataset.bid,
            s = t.currentTarget.dataset.iid,
            d = 1 == r ? 4 : 2 == r ? 2 : 3 == r ? 1 : 0,
            c = e.data.orderinfo.id;
        n = s || n, console.log(o), console.log(d), console.log(c), console.log(n), app.util.request({
            url: "entry/wxapp/iscancel",
            data: {
                id: o,
                oid: c,
                m: app.globalData.Plugin_package
            },
            success: function(t) {
                1 == t.data ? (e.setData({
                    show: !0
                }), clearInterval(a.data.setInter4), e.data.setInter4 = setInterval(function() {
                    var t = '{ "id": ' + n + ', "ordertype": ' + d + ', "bid": ' + i + "}";
                    wxbarcode.qrcode("qrcode", t, 420, 420), clearInterval(e.data.setInter4)
                }, 50)) : wx.showToast({
                    title: t.data.message,
                    icon: "none",
                    duration: 2e3
                })
            }
        })
    },
    close: function(t) {
        this.setData({
            show: !1
        })
    },
    canvas_code: function(t) {
        wx.getStorageSync("brand_info").bid, this.data.hx_id, wx.getStorageSync("users").id;
        timestamp /= 1e3, console.log(timestamp)
    },
    openlocation: function(t) {
        wx.openLocation({
            latitude: parseFloat(t.currentTarget.dataset.lat),
            longitude: parseFloat(t.currentTarget.dataset.lng)
        })
    }
});