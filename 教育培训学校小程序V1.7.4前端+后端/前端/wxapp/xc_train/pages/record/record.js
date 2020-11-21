var a = getApp(), t = require("../common/common.js"), e = require("../../../utils/qrcode.js");

Page({
    data: {
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    code: function(a) {
        var t = this, e = a.currentTarget.dataset.index;
        t.setData({
            maskHidden: !1
        }), wx.showToast({
            title: "生成中...",
            icon: "loading",
            duration: 2e3
        });
        var o = setTimeout(function() {
            wx.hideToast();
            var a = t.setCanvasSize();
            t.createQrCode(t.data.list[e].out_trade_no, "mycanvas", a.w, a.h), t.setData({
                maskHidden: !0,
                shadow: !0,
                menu: !0
            }), clearTimeout(o);
        }, 2e3);
    },
    menu_close: function() {
        this.setData({
            menu: !1,
            shadow: !1,
            use_time: !1
        });
    },
    use_on: function(a) {
        var t = this, e = a.currentTarget.dataset.index;
        t.setData({
            shadow: !0,
            use_time: !0,
            index: e
        });
    },
    onLoad: function(e) {
        var o = this;
        t.config(o), t.theme(o), "" != e.order_type && "" != e.order_type && o.setData({
            order_type: e.order_type
        }), a.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "order",
                page: o.data.page,
                pagesize: o.data.pagesize,
                order_type: o.data.order_type
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? o.setData({
                    list: t.data,
                    page: o.data.page + 1
                }) : o.setData({
                    isbottom: !0
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        t.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var t = this;
        t.setData({
            page: 1,
            isbottom: !1
        }), a.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "order",
                page: t.data.page,
                pagesize: t.data.pagesize,
                order_type: t.data.order_type
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var e = a.data;
                "" != e.data ? t.setData({
                    list: e.data,
                    page: t.data.page + 1
                }) : t.setData({
                    isbottom: !0
                });
            }
        });
    },
    onReachBottom: function() {
        var t = this;
        t.data.isbottom || a.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "order",
                page: t.data.page,
                pagesize: t.data.pagesize,
                order_type: t.data.order_type
            },
            success: function(a) {
                var e = a.data;
                "" != e.data ? t.setData({
                    list: t.data.list.concat(e.data),
                    page: t.data.page + 1
                }) : t.setData({
                    isbottom: !0
                });
            }
        });
    },
    setCanvasSize: function() {
        var a = {};
        try {
            var t = .426666 * wx.getSystemInfoSync().windowWidth, e = t;
            a.w = t, a.h = e;
        } catch (a) {
            console.log("获取设备信息失败" + a);
        }
        return a;
    },
    createQrCode: function(a, t, o, s) {
        e.qrApi.draw(a, t, o, s);
        var n = this, r = setTimeout(function() {
            n.canvasToTempImage(), clearTimeout(r);
        }, 3e3);
    },
    canvasToTempImage: function() {
        var a = this;
        wx.canvasToTempFilePath({
            canvasId: "mycanvas",
            success: function(t) {
                var e = t.tempFilePath;
                console.log(e), a.setData({
                    imagePath: e
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    previewImg: function(a) {
        var t = this.data.imagePath;
        wx.previewImage({
            current: t,
            urls: [ t ]
        });
    }
});