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
        var s = setTimeout(function() {
            wx.hideToast();
            var a = t.setCanvasSize();
            t.createQrCode(t.data.list[e].code, "mycanvas", a.w, a.h), t.setData({
                maskHidden: !0,
                shadow: !0,
                menu: !0
            }), clearTimeout(s);
        }, 2e3);
    },
    menu_close: function() {
        this.setData({
            menu: !1,
            shadow: !1
        });
    },
    onLoad: function(e) {
        var s = this;
        t.config(s), t.theme(s), a.util.request({
            url: "entry/wxapp/user",
            data: {
                op: "prize",
                page: s.data.page,
                pagesize: s.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? s.setData({
                    list: t.data,
                    page: s.data.page + 1
                }) : s.setData({
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
            url: "entry/wxapp/user",
            data: {
                op: "prize",
                page: t.data.page,
                pagesize: t.data.pagesize
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
            url: "entry/wxapp/user",
            data: {
                op: "prize",
                page: t.data.page,
                pagesize: t.data.pagesize
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
    createQrCode: function(a, t, s, o) {
        e.qrApi.draw(a, t, s, o);
        var i = this, n = setTimeout(function() {
            i.canvasToTempImage(), clearTimeout(n);
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