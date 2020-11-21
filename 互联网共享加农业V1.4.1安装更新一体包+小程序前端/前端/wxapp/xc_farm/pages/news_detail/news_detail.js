var _WxValidate = require("../../../utils/WxValidate.js"), _WxValidate2 = _interopRequireDefault(_WxValidate);

function _interopRequireDefault(a) {
    return a && a.__esModule ? a : {
        default: a
    };
}

var common = require("../common/common.js"), app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

Page({
    data: {
        replyval: "",
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    replychange: function(a) {
        var t = a.detail.value;
        this.setData({
            replyval: t
        });
    },
    replysubmit: function() {
        var e = this, a = e.data.replyval;
        "" == a.replace(/\s/g, "") || app.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            data: {
                op: "discuss",
                type: 3,
                id: e.data.xc.detail.id,
                content: a
            },
            success: function(a) {
                "" != a.data.data && (wx.showToast({
                    title: "评论成功",
                    icon: "success",
                    duration: 2e3
                }), e.setData({
                    page: 1,
                    isbottom: !1,
                    replyval: ""
                }), app.util.request({
                    url: "entry/wxapp/index",
                    method: "POST",
                    data: {
                        op: "news_detail",
                        id: e.data.xc.detail.id,
                        page: e.data.page,
                        pagesize: e.data.pagesize
                    },
                    success: function(a) {
                        var t = a.data;
                        if ("" != t.data) {
                            if (e.setData({
                                xc: t.data
                            }), "" != t.data.detail.content && null != t.data.detail.content) WxParse.wxParse("article", "html", t.data.detail.content, e, 0);
                            "" != t.data.list && null != t.data.list ? e.setData({
                                page: e.data.page + 1
                            }) : e.setData({
                                isbottom: !0
                            });
                        }
                    }
                }));
            }
        });
    },
    zan: function() {
        var t = this, e = t.data.xc;
        -1 == e.detail.zan_status && app.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            data: {
                op: "zan",
                id: e.detail.id
            },
            success: function(a) {
                "" != a.data.data && (wx.showToast({
                    title: "点赞成功",
                    icon: "success",
                    duration: 2e3
                }), e.detail.zan_status = 1, e.detail.zan = parseInt(e.detail.zan) + 1, t.setData({
                    xc: e
                }));
            }
        });
    },
    onLoad: function(a) {
        var e = this;
        common.config(e), app.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            data: {
                op: "news_detail",
                id: a.id,
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                if ("" != t.data) {
                    if (e.setData({
                        xc: t.data
                    }), "" != t.data.detail.content && null != t.data.detail.content) WxParse.wxParse("article", "html", t.data.detail.content, e, 0);
                    "" != t.data.list && null != t.data.list ? e.setData({
                        page: e.data.page + 1
                    }) : e.setData({
                        isbottom: !0
                    });
                }
            }
        });
    },
    onReachBottom: function() {
        var i = this;
        i.data.isbottom || app.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            data: {
                op: "news_detail",
                id: i.data.xc.detail.id,
                page: i.data.page,
                pagesize: i.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                if ("" != t.data) if ("" != t.data.list && null != t.data.list) {
                    var e = i.data.xc;
                    e.list = e.list.concat(t.data.list), i.setData({
                        xc: e,
                        page: i.data.page + 1
                    });
                } else i.setData({
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
        }), app.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            data: {
                op: "news_detail",
                id: e.data.xc.detail.id,
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                if (wx.stopPullDownRefresh(), "" != t.data) {
                    if (e.setData({
                        xc: t.data
                    }), "" != t.data.detail.content && null != t.data.detail.content) WxParse.wxParse("article", "html", t.data.detail.content, e, 0);
                    "" != t.data.list && null != t.data.list ? e.setData({
                        page: e.data.page + 1
                    }) : e.setData({
                        isbottom: !0
                    });
                }
            }
        });
    },
    onShareAppMessage: function() {
        return {
            title: app.config.webname + "-" + this.data.xc.detail.title,
            path: "/xc_farm/pages/news_detail/news_detail?&id=" + this.data.xc.detail.id,
            success: function(a) {
                console.log(a);
            },
            fail: function(a) {
                console.log(a);
            }
        };
    }
});