function t(t, a) {
    t.appId;
    var e = t.timeStamp.toString(), s = t.package, n = t.nonceStr, i = t.paySign.toUpperCase();
    wx.requestPayment({
        timeStamp: e,
        nonceStr: n,
        package: s,
        signType: "MD5",
        paySign: i,
        success: function(t) {
            wx.showToast({
                title: "支付成功",
                icon: "success",
                duration: 2e3
            });
            var e = a.data.list;
            e.order = 1, self.setData({
                list: e
            });
        },
        fail: function(t) {}
    });
}

var a = getApp(), e = require("../../common/common.js"), s = require("../../../../wxParse/wxParse.js");

Page({
    data: {
        curr: 1,
        page: 1,
        pagesize: 20,
        isbottim: !1,
        tui: []
    },
    zan: function() {
        var t = this;
        -1 == t.data.list.zan_user && a.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "line_zan",
                id: t.data.id
            },
            success: function(a) {
                if ("" != a.data.data) {
                    wx.showToast({
                        title: "点赞成功",
                        icon: "success",
                        duration: 2e3
                    });
                    var e = t.data.list;
                    e.zan_user = 1, e.zan = parseInt(e.zan) + 1, t.setData({
                        list: e
                    });
                }
            }
        });
    },
    tab: function(t) {
        var a = this, e = t.currentTarget.dataset.index;
        e != a.data.curr && a.setData({
            curr: e
        });
    },
    input: function(t) {
        this.setData({
            content: t.detail.value
        });
    },
    discuss_on: function() {
        var t = this, e = t.data.content;
        "" != e && null != e ? a.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "discuss_on",
                id: t.data.id,
                content: e,
                type: 4
            },
            success: function(a) {
                if ("" != a.data.data) {
                    wx.showToast({
                        title: "评论成功",
                        icon: "success",
                        duration: 2e3
                    });
                    var e = t.data.list;
                    e.discuss = parseInt(e.discuss) + 1, e.discuss_on = 1, t.setData({
                        content: "",
                        list: e
                    }), t.getDiscuss(!0);
                }
            }
        }) : wx.showModal({
            title: "错误",
            content: "评论内容不能为空",
            success: function(t) {
                t.confirm ? console.log("用户点击确定") : t.cancel && console.log("用户点击取消");
            }
        });
    },
    submit: function() {
        var e = this;
        a.util.request({
            url: "entry/wxapp/lineOrder",
            data: {
                id: e.data.id
            },
            success: function(a) {
                var s = a.data;
                if ("" != s.data) if (2 == s.data.status) {
                    wx.showToast({
                        title: "支付成功",
                        icon: "success",
                        duration: 2e3
                    });
                    var n = e.data.list;
                    n.order = 1, e.setData({
                        list: n
                    });
                } else 1 == s.data.status && ("" != s.data.errno && null != s.data.errno ? wx.showModal({
                    title: "错误",
                    content: s.data.message,
                    showCancel: !1
                }) : t(s.data, e));
            }
        });
    },
    onLoad: function(t) {
        var a = this;
        e.config(a), e.theme(a), a.setData({
            id: t.id
        }), a.getData(), a.getDiscuss(!0);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        this.getData();
    },
    onReachBottom: function() {
        var t = this;
        3 == t.data.curr && t.getDiscuss(!1);
    },
    onShareAppMessage: function() {
        var t = this, a = "/xc_train/pages/line/detail/index?&id=" + t.data.id;
        return a = escape(a), {
            title: t.data.config.title + "-" + t.data.list.name,
            path: "/xc_train/pages/base/base?&share=" + a,
            success: function(t) {
                console.log(t);
            },
            fail: function(t) {
                console.log(t);
            }
        };
    },
    getData: function() {
        var t = this;
        a.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "line_detail",
                id: t.data.id
            },
            success: function(a) {
                var e = a.data;
                if (wx.stopPullDownRefresh(), "" != e.data && (t.setData({
                    list: e.data
                }), "" != e.data.content && null != e.data.content)) {
                    var n = e.data.content;
                    s.wxParse("content2", "html", n, t, 5);
                }
            }
        });
    },
    getDiscuss: function(t) {
        var e = this;
        t && e.setData({
            page: 1,
            isbottim: !1,
            tui: []
        }), e.data.isbottim || a.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "discuss",
                page: e.data.page,
                pagesize: e.data.pagesize,
                type: 4,
                id: e.data.id
            },
            success: function(t) {
                var a = t.data;
                wx.stopPullDownRefresh(), "" != a.data ? e.setData({
                    tui: e.data.tui.concat(a.data),
                    page: e.data.page + 1
                }) : e.setData({
                    isbottim: !0
                });
            }
        });
    }
});