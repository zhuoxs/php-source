function a(a, e) {
    a.appId;
    var s = a.timeStamp.toString(), i = a.package, n = a.nonceStr, o = a.paySign.toUpperCase();
    wx.requestPayment({
        timeStamp: s,
        nonceStr: n,
        package: i,
        signType: "MD5",
        paySign: o,
        success: function(a) {
            wx.showToast({
                title: "支付成功",
                icon: "success",
                duration: 2e3
            }), t.util.request({
                url: "entry/wxapp/service",
                data: {
                    op: "video_detail",
                    id: e.data.list.id
                },
                success: function(a) {
                    var t = a.data;
                    "" != t.data && e.setData({
                        list: t.data,
                        shadow: !1,
                        menu: !1
                    });
                }
            });
        },
        fail: function(a) {}
    });
}

var t = getApp(), e = require("../common/common.js"), s = require("../../../wxParse/wxParse.js");

Page({
    data: {
        curr: 1,
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    tab: function(a) {
        var e = this, s = a.currentTarget.dataset.index;
        s != e.data.curr && (e.setData({
            curr: s,
            page: 1,
            pagesize: 20,
            isbottom: !1,
            tui: []
        }), 2 == s ? t.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "video",
                id: e.data.list.id,
                service: e.data.list.pid,
                tui: 1,
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    tui: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                });
            }
        }) : 3 == s && t.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "discuss",
                page: e.data.page,
                pagesize: e.data.pagesize,
                id: e.data.list.id,
                type: 2
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    tui: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                });
            }
        }));
    },
    input: function(a) {
        this.setData({
            content: a.detail.value
        });
    },
    discuss_on: function() {
        var a = this, e = a.data.content;
        "" != e && null != e ? t.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "discuss_on",
                id: a.data.list.id,
                content: e,
                type: 2
            },
            success: function(e) {
                "" != e.data.data && (wx.showToast({
                    title: "评论成功",
                    icon: "success",
                    duration: 2e3
                }), a.setData({
                    page: 1,
                    isbottom: !1,
                    content: ""
                }), t.util.request({
                    url: "entry/wxapp/order",
                    data: {
                        op: "discuss",
                        page: a.data.page,
                        pagesize: a.data.pagesize,
                        id: a.data.list.id,
                        type: 2
                    },
                    success: function(t) {
                        var e = t.data;
                        "" != e.data ? a.setData({
                            tui: e.data,
                            page: a.data.page + 1
                        }) : a.setData({
                            isbottom: !0
                        });
                    }
                }));
            }
        }) : wx.showModal({
            title: "错误",
            content: "评论内容不能为空",
            success: function(a) {
                a.confirm ? console.log("用户点击确定") : a.cancel && console.log("用户点击取消");
            }
        });
    },
    menu_on: function() {
        this.setData({
            menu: !0,
            shadow: !0
        });
    },
    menu_close: function() {
        this.setData({
            menu: !1,
            shadow: !1
        });
    },
    pay: function() {
        var e = this;
        t.util.request({
            url: "entry/wxapp/buyvideo",
            data: {
                id: e.data.list.id
            },
            success: function(t) {
                var s = t.data;
                "" != s.data && (e.setData({
                    shadow: !1,
                    menu: !1
                }), "" != s.data.errno && null != s.data.errno ? wx.showModal({
                    title: "错误",
                    content: s.data.message,
                    showCancel: !1
                }) : a(s.data, e));
            }
        });
    },
    to_shop: function() {
        var a = this;
        t.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "bind"
            },
            success: function(t) {
                "" != t.data.data ? wx.navigateTo({
                    url: "../manage/index"
                }) : a.setData({
                    shadow: !0,
                    manage: !0
                });
            }
        });
    },
    password: function(a) {
        this.setData({
            password: a.detail.value
        });
    },
    shop_close: function() {
        this.setData({
            shadow: !1,
            manage: !1
        });
    },
    shop_login: function(a) {
        var e = this, s = a.currentTarget.dataset.status;
        "" == e.data.password || null == e.data.password ? wx.showModal({
            title: "错误",
            content: "请输入密码",
            success: function(a) {
                a.confirm ? console.log("用户点击确定") : a.cancel && console.log("用户点击取消");
            }
        }) : t.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "login",
                status: s,
                password: e.data.password
            },
            success: function(a) {
                "" != a.data.data ? wx.navigateTo({
                    url: "../manage/index"
                }) : e.setData({
                    password: ""
                });
            }
        });
    },
    onLoad: function(a) {
        var i = this;
        e.config(i), e.theme(i), t.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "video_detail",
                id: a.id
            },
            success: function(a) {
                var t = a.data;
                if ("" != t.data && (i.setData({
                    list: t.data
                }), 2 == t.data.content_type)) {
                    var e = t.data.content2;
                    s.wxParse("content2", "html", e, i, 5);
                }
            }
        }), i.setData({
            userinfo: t.userinfo
        });
    },
    onReady: function() {},
    onShow: function() {
        e.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var a = this;
        t.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "video_detail",
                id: a.data.list.id
            },
            success: function(t) {
                wx.stopPullDownRefresh();
                var e = t.data;
                if ("" != e.data && (a.setData({
                    list: e.data
                }), 2 == e.data.content_type)) {
                    var i = e.data.content2;
                    s.wxParse("content2", "html", i, a, 5);
                }
            }
        });
    },
    onReachBottom: function() {
        var a = this;
        a.data.isbottom ? 3 == index && t.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "discuss",
                page: a.data.page,
                pagesize: a.data.pagesize,
                id: a.data.list.id,
                type: 2
            },
            success: function(t) {
                var e = t.data;
                "" != e.data ? a.setData({
                    tui: e.data,
                    page: a.data.page + 1
                }) : a.setData({
                    isbottom: !0
                });
            }
        }) : 2 == a.data.curr && t.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "video",
                id: a.data.list.id,
                service: a.data.list.pid,
                tui: 1,
                page: a.data.page,
                pagesize: a.data.pagesize
            },
            success: function(t) {
                var e = t.data;
                "" != e.data ? a.setData({
                    tui: a.data.tui.concat(e.data),
                    page: a.data.page + 1
                }) : a.setData({
                    isbottom: !0
                });
            }
        });
    },
    onShareAppMessage: function() {
        var a = this, t = "/xc_train/pages/video/detail?&id=" + a.data.list.id;
        return t = escape(t), {
            title: a.data.config.title + "-" + a.data.list.name,
            path: "/xc_train/pages/base/base?&share=" + t,
            success: function(a) {
                console.log(a);
            },
            fail: function(a) {
                console.log(a);
            }
        };
    }
});