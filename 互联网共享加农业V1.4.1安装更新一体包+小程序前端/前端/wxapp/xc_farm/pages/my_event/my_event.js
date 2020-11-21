var common = require("../common/common.js"), app = getApp(), QR = require("../../../utils/qrcode.js"), scales = .195;

Page({
    data: {
        navHref: "",
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    menu_on: function(a) {
        var e = this, t = a.currentTarget.dataset.index, s = e.data.list;
        if (parseInt(s[t].member) > parseInt(s[t].is_member)) {
            scales = .4;
            var i = e.setCanvasSize(), o = "mycanvas" + s[t].id + Math.round(1e4 * Math.random());
            console.log(o), e.createQrCode("../active/detail?&id=" + s[t].service + "&order=" + s[t].id, o, i.w, i.h), 
            e.setData({
                canshow: !0,
                menu: !0,
                index: t,
                code: o
            });
        }
    },
    canshow: function() {
        this.setData({
            canshow: !1,
            menu: !1
        });
    },
    onLoad: function(a) {
        var i = this;
        common.config(i), scales = .195, app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "sign",
                openid: 1,
                page: i.data.page,
                pagesize: i.data.pagesize
            },
            success: function(a) {
                var e = a.data;
                if ("" != e.data) {
                    for (var t = 0; t < e.data.length; t++) {
                        var s = i.setCanvasSize();
                        i.createQrCode("../active/detail?&id=" + e.data[t].service + "&order=" + e.data[t].id, "mycanvas" + e.data[t].id, s.w, s.h);
                    }
                    i.setData({
                        list: e.data,
                        page: i.data.page + 1
                    });
                } else i.setData({
                    isbottom: !0
                });
            }
        });
    },
    onReachBottom: function() {
        var i = this;
        i.data.isbottom || (scales = .195, app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "sign",
                openid: 1,
                page: i.data.page,
                pagesize: i.data.pagesize
            },
            success: function(a) {
                var e = a.data;
                if ("" != e.data) {
                    for (var t = 0; t < e.data.length; t++) {
                        var s = i.setCanvasSize();
                        i.createQrCode("../active/detail?&id=" + e.data[t].service + "&order=" + e.data[t].id, "mycanvas" + e.data[t].id, s.w, s.h);
                    }
                    i.setData({
                        list: i.data.list.concat(e.data),
                        page: i.data.page + 1
                    });
                } else i.setData({
                    isbottom: !0
                });
            }
        }));
    },
    onPullDownRefresh: function() {
        var i = this;
        i.setData({
            page: 1,
            isbottom: !1
        }), scales = .195, app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "sign",
                openid: 1,
                page: i.data.page,
                pagesize: i.data.pagesize
            },
            success: function(a) {
                var e = a.data;
                if ("" != e.data) {
                    wx.stopPullDownRefresh();
                    for (var t = 0; t < e.data.length; t++) {
                        var s = i.setCanvasSize();
                        i.createQrCode("../active/detail?&id=" + e.data[t].service + "&order=" + e.data[t].id, "mycanvas" + e.data[t].id, s.w, s.h);
                    }
                    i.setData({
                        list: e.data,
                        page: i.data.page + 1
                    });
                } else i.setData({
                    isbottom: !0
                });
            }
        });
    },
    setCanvasSize: function() {
        var a = {};
        try {
            var e = wx.getSystemInfoSync(), t = scales, s = e.windowWidth * t, i = s;
            a.w = s, a.h = i;
        } catch (a) {
            console.log("获取设备信息失败" + a);
        }
        return a;
    },
    createQrCode: function(a, e, t, s) {
        QR.qrApi.draw(a, e, t, s);
        var i = this, o = setTimeout(function() {
            i.canvasToTempImage(), clearTimeout(o);
        }, 3e3);
    },
    canvasToTempImage: function() {
        var t = this;
        wx.canvasToTempFilePath({
            canvasId: "mycanvas",
            success: function(a) {
                var e = a.tempFilePath;
                console.log(e), t.setData({
                    imagePath: e
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    }
});