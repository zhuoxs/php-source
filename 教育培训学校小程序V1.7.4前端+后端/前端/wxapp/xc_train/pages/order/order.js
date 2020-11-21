var a = getApp(), t = require("../common/common.js"), e = require("../../../utils/qrcode.js");

Page({
    data: {
        navHref: "",
        tab: [ "全部", "待核销", "已核销", "售后/退款" ],
        tabCurr: 0,
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    tabChange: function(t) {
        var e = this, n = t.currentTarget.id;
        if (n != e.data.tabCurr) {
            e.setData({
                tabCurr: n,
                page: 1,
                isbottom: !1
            });
            var s = {
                op: "mall_order",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curr: e.data.tabCurr
            };
            a.util.request({
                url: "entry/wxapp/order",
                data: s,
                success: function(a) {
                    var t = a.data;
                    "" != t.data ? e.setData({
                        list: t.data,
                        page: e.data.page + 1
                    }) : e.setData({
                        isbottom: !0,
                        list: []
                    });
                }
            });
        }
    },
    shFunc: function(a) {
        var t = this, e = a.currentTarget.dataset.index, n = t.data.list, s = t.setCanvasSize();
        t.createQrCode(n[e].out_trade_no, "mycanvas", s.w, s.h), t.setData({
            canshow: !0,
            menu: !0
        });
    },
    canshow: function() {
        this.setData({
            canshow: !1,
            menu: !1,
            menu2: !1
        });
    },
    tui: function(a) {
        var t = this, e = a.currentTarget.dataset.index;
        t.setData({
            tui_index: e,
            menu2: !0,
            canshow: !0
        });
    },
    menu_close: function() {
        this.setData({
            menu2: !1,
            canshow: !1
        });
    },
    input: function(a) {
        this.setData({
            content: a.detail.value
        });
    },
    menu_btn: function() {
        var t = this;
        "" != t.data.content && null != t.data.content ? a.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "mall_tui",
                id: t.data.list[t.data.tui_index].id,
                content: t.data.content
            },
            success: function(a) {
                if ("" != a.data.data) {
                    wx.showToast({
                        title: "提交成功",
                        icon: "success",
                        duration: 2e3
                    });
                    var e = t.data.list;
                    e[t.data.tui_index].status = 2, t.setData({
                        list: e,
                        content: "",
                        menu2: !1,
                        canshow: !1
                    });
                }
            }
        }) : wx.showModal({
            title: "提示",
            content: "请输入退款原因",
            showCancel: !1
        });
    },
    onLoad: function(e) {
        var n = this;
        t.config(n), t.theme(n);
        var s = {
            op: "mall_order",
            page: n.data.page,
            pagesize: n.data.pagesize,
            curr: n.data.tabCurr
        };
        a.util.request({
            url: "entry/wxapp/order",
            data: s,
            success: function(a) {
                var t = a.data;
                "" != t.data ? n.setData({
                    list: t.data,
                    page: n.data.page + 1
                }) : n.setData({
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
        });
        var e = {
            op: "mall_order",
            page: t.data.page,
            pagesize: t.data.pagesize,
            curr: t.data.tabCurr
        };
        a.util.request({
            url: "entry/wxapp/order",
            data: e,
            success: function(a) {
                var e = a.data;
                wx.stopPullDownRefresh(), "" != e.data ? t.setData({
                    list: e.data,
                    page: t.data.page + 1
                }) : t.setData({
                    isbottom: !0,
                    list: []
                });
            }
        });
    },
    onReachBottom: function() {
        var t = this;
        if (!t.data.isbottom) {
            var e = {
                op: "mall_order",
                page: t.data.page,
                pagesize: t.data.pagesize,
                curr: t.data.tabCurr
            };
            a.util.request({
                url: "entry/wxapp/order",
                data: e,
                success: function(a) {
                    var e = a.data;
                    "" != e.data ? t.setData({
                        list: e.data,
                        page: t.data.page + 1
                    }) : t.setData({
                        isbottom: !0
                    });
                }
            });
        }
    },
    onShareAppMessage: function(t) {
        var e = this, n = a.config.webname, s = "/xc_train/pages/base/base", o = "";
        if ("button" === t.from) {
            var i = t.target.dataset.index, r = e.data.list;
            n = r[i].title;
            var u = "/xc_train/pages/shared/shared?&group=" + r[i].group_id;
            s = s + "?&share=" + (u = escape(u)), o = r[i].simg;
        }
        return console.log(s), {
            title: n,
            path: s,
            imageUrl: o,
            success: function(a) {
                console.log(a);
            },
            fail: function(a) {
                console.log(a);
            }
        };
    },
    setCanvasSize: function() {
        var a = {};
        try {
            var t = .4 * wx.getSystemInfoSync().windowWidth, e = t;
            a.w = t, a.h = e;
        } catch (a) {
            console.log("获取设备信息失败" + a);
        }
        return a;
    },
    createQrCode: function(a, t, n, s) {
        e.qrApi.draw(a, t, n, s);
        var o = this, i = setTimeout(function() {
            o.canvasToTempImage(), clearTimeout(i);
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
    }
});