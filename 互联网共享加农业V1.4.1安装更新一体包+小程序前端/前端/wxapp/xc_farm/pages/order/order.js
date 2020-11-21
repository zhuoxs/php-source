var common = require("../common/common.js"), app = getApp(), init1 = "", QR = require("../../../utils/qrcode.js");

function wxpay(a, n, o) {
    a.appId;
    var t = a.timeStamp.toString(), e = a.package, s = a.nonceStr, r = a.paySign.toUpperCase();
    wx.requestPayment({
        timeStamp: t,
        nonceStr: s,
        package: e,
        signType: "MD5",
        paySign: r,
        success: function(a) {
            var s = setInterval(function() {
                app.util.request({
                    url: "entry/wxapp/check",
                    showLoading: !1,
                    data: {
                        out_trade_no: n.data.list[o].out_trade_no
                    },
                    success: function(a) {
                        var t = a.data;
                        if ("" != t.data && 1 == t.data.status) {
                            clearInterval(s), wx.showToast({
                                title: "支付成功",
                                icon: "success",
                                duration: 2e3
                            });
                            var e = n.data.list;
                            e.splice(o, 1), n.setData({
                                list: e
                            });
                        }
                    }
                });
            }, 1e3);
        }
    });
}

Page({
    data: {
        navHref: "",
        tab: [ "全部", "待付款", "待分享", "待发货", "待收货", "待评价" ],
        tabCurr: 0,
        page: 1,
        pagesize: 20,
        isbottom: !1,
        canload: !0
    },
    tabChange: function(a) {
        var e = this, t = a.currentTarget.id;
        if (t != e.data.tabCurr) {
            e.setData({
                tabCurr: t,
                page: 1,
                isbottom: !1
            });
            var s = {
                op: "order",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curr: e.data.tabCurr
            };
            app.util.request({
                url: "entry/wxapp/order",
                method: "POST",
                data: s,
                success: function(a) {
                    var t = a.data;
                    "" != t.data ? e.setData({
                        list: t.data,
                        page: e.data.page + 1
                    }) : e.setData({
                        isbottom: !1,
                        list: []
                    });
                }
            });
        }
    },
    qxFunc: function(a) {
        var t = this, e = t.data.list, s = a.currentTarget.dataset.index;
        wx.showModal({
            title: "确认取消",
            content: "是否要取消该订单？",
            success: function(a) {
                a.confirm ? app.util.request({
                    url: "entry/wxapp/order",
                    method: "POST",
                    data: {
                        op: "order_del",
                        id: e[s].id
                    },
                    success: function(a) {
                        "" != a.data.data && (wx.showToast({
                            title: "取消成功",
                            icon: "success",
                            duration: 2e3
                        }), e.splice(s, 1), t.setData({
                            list: e
                        }));
                    }
                }) : a.cancel && console.log("用户点击取消");
            }
        });
    },
    shFunc: function(a) {
        var t = this, e = t.data.list, s = a.currentTarget.dataset.index;
        wx.showModal({
            title: "确认收货",
            content: "是否要确认收货？",
            success: function(a) {
                a.confirm ? app.util.request({
                    url: "entry/wxapp/order",
                    method: "POST",
                    data: {
                        op: "order_status",
                        id: e[s].id,
                        status: 3
                    },
                    success: function(a) {
                        "" != a.data.data && (wx.showToast({
                            title: "收货成功",
                            icon: "success",
                            duration: 2e3
                        }), e.splice(s, 1), t.setData({
                            list: e
                        }));
                    }
                }) : a.cancel && console.log("用户点击取消");
            }
        });
    },
    submit: function(a) {
        var e = this, t = e.data.list, s = a.currentTarget.dataset.index;
        app.util.request({
            url: "entry/wxapp/orderpay",
            method: "POST",
            data: {
                id: t[s].id,
                form_id: a.detail.formId
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && ("" != t.data.errno && null != t.data.errno ? wx.showModal({
                    title: "错误",
                    content: t.data.message,
                    showCancel: !1
                }) : wxpay(t.data, e, s));
            }
        });
    },
    loadingFunc: function() {
        var e = this;
        if (!e.data.isbottom && e.data.canload) {
            e.setData({
                canload: !1
            });
            var a = {
                op: "order",
                page: e.data.page,
                pagesize: e.data.pagesize,
                curr: e.data.tabCurr
            };
            app.util.request({
                url: "entry/wxapp/order",
                method: "POST",
                data: a,
                success: function(a) {
                    var t = a.data;
                    "" != t.data ? e.setData({
                        list: e.data.list.concat(t.data),
                        page: e.data.page + 1,
                        canload: !0
                    }) : e.setData({
                        isbottom: !0,
                        canload: !0
                    });
                }
            });
        }
    },
    code: function(a) {
        var t = this, e = t.data.list, s = a.currentTarget.dataset.index, n = t.setCanvasSize();
        t.createQrCode("../order/detail?&id=" + e[s].id, "mycanvas", n.w, n.h), t.setData({
            canshow: !0,
            menu: !0
        });
    },
    canshow: function() {
        this.setData({
            canshow: !1,
            menu: !1
        });
    },
    tui: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            tui_index: t,
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
        var e = this;
        "" != e.data.content && null != e.data.content ? app.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "order_status",
                id: e.data.list[e.data.tui_index].id,
                content: e.data.content,
                status: 5
            },
            success: function(a) {
                if ("" != a.data.data) {
                    wx.showToast({
                        title: "提交成功",
                        icon: "success",
                        duration: 2e3
                    });
                    var t = e.data.list;
                    t[e.data.tui_index].order_status = 5, e.setData({
                        list: t,
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
    onLoad: function(a) {
        var e = this;
        common.config(e), "" != a.curr && null != a.curr && e.setData({
            tabCurr: a.curr
        });
        var t = {
            op: "order",
            page: e.data.page,
            pagesize: e.data.pagesize,
            curr: e.data.tabCurr
        };
        app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: t,
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    list: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                });
            }
        });
    },
    onPullDownRefresh: function() {
        var e = this;
        e.setData({
            page: 1,
            isbottom: !1
        });
        var a = {
            op: "order",
            page: e.data.page,
            pagesize: e.data.pagesize,
            curr: e.data.tabCurr
        };
        app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: a,
            success: function(a) {
                var t = a.data;
                "" != t.data ? (wx.stopPullDownRefresh(), e.setData({
                    list: t.data,
                    page: e.data.page + 1
                })) : e.setData({
                    isbottom: !0,
                    list: []
                });
            }
        });
    },
    onShareAppMessage: function(a) {
        var t = app.config.webname, e = "/xc_farm/pages/index/index", s = "";
        if ("button" === a.from) {
            console.log(a.target);
            var n = a.target.dataset.index, o = this.data.list;
            t = o[n].service_name, e = "/xc_farm/pages/shared/shared?&group=" + o[n].group, 
            s = o[n].simg;
        }
        return console.log(e), {
            title: t,
            path: e,
            imageUrl: s,
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
            var t = wx.getSystemInfoSync(), e = .4 * t.windowWidth, s = e;
            a.w = e, a.h = s;
        } catch (a) {
            console.log("获取设备信息失败" + a);
        }
        return a;
    },
    createQrCode: function(a, t, e, s) {
        QR.qrApi.draw(a, t, e, s);
        var n = this, o = setTimeout(function() {
            n.canvasToTempImage(), clearTimeout(o);
        }, 3e3);
    },
    canvasToTempImage: function() {
        var e = this;
        wx.canvasToTempFilePath({
            canvasId: "mycanvas",
            success: function(a) {
                var t = a.tempFilePath;
                console.log(t), e.setData({
                    imagePath: t
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    }
});