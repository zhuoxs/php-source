var _WxValidate = require("../../../utils/WxValidate.js"), _WxValidate2 = _interopRequireDefault(_WxValidate);

function _interopRequireDefault(a) {
    return a && a.__esModule ? a : {
        default: a
    };
}

var common = require("../common/common.js"), app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

Page({
    data: {
        navs: [ "项目介绍", "图文直播", "项目评论" ],
        tagCurr: 0,
        lnavCurr: -1,
        canload: !1,
        value: "",
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    changeTag: function(a) {
        var t = this;
        t.setData({
            tagCurr: a.currentTarget.id
        }), 2 == a.currentTarget.id ? t.setData({
            canload: !0
        }) : t.setData({
            canload: !1
        });
    },
    changeLNav: function(a) {
        this.setData({
            lnavCurr: a.currentTarget.id
        });
    },
    prewImg: function(a) {
        wx.previewImage({
            urls: [ a.currentTarget.id ]
        });
    },
    cleareva: function() {
        this.setData({
            value: ""
        });
    },
    submiteva: function() {
        var e = this;
        "" != e.data.value.replace(/\s/g, "") && app.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            data: {
                op: "discuss",
                id: e.data.xc.detail.id,
                type: 2,
                content: e.data.value
            },
            success: function(a) {
                "" != a.data.data && (wx.showToast({
                    title: "评论成功",
                    icon: "success",
                    duration: 2e3
                }), e.setData({
                    value: "",
                    page: 1,
                    isbototm: !1
                }), app.util.request({
                    url: "entry/wxapp/service",
                    showLoading: !1,
                    method: "POST",
                    data: {
                        op: "cf_detail",
                        id: e.data.xc.detail.id,
                        page: e.data.page,
                        pagesize: e.data.pagesize
                    },
                    success: function(a) {
                        var t = a.data;
                        "" != t.data && (e.setData({
                            xc: t.data
                        }), "" != t.data.list && null != t.data.list ? e.setData({
                            page: e.data.page + 1
                        }) : e.setData({
                            isbottom: !0
                        }));
                    }
                }));
            }
        });
    },
    input: function(a) {
        this.setData({
            value: a.detail.value
        });
    },
    callFunc: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.xc.detail.mobile
        });
    },
    submit: function() {
        var a = this;
        -1 == a.data.lnavCurr ? wx.showModal({
            title: "提示",
            content: "请先选择收益"
        }) : common.is_bind(function() {
            wx.navigateTo({
                url: "../cf_buy/cf_buy?&id=" + a.data.xc.detail.id + "&curr=" + a.data.lnavCurr
            });
        });
    },
    onLoad: function(a) {
        var e = this;
        common.config(e), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "cf_detail",
                id: a.id,
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                if ("" != t.data) {
                    if (e.setData({
                        xc: t.data
                    }), "" != t.data.detail.income && null != t.data.detail.income && e.setData({
                        lnavCurr: 0
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
        !i.data.isbottom && i.data.canload && app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "cf_detail",
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
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "cf_detail",
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
        var a = this, t = app.config.webname + "-" + a.data.xc.detail.title;
        "" != a.data.xc.detail.share_title && null != a.data.xc.detail.share_title && (t = a.data.xc.detail.share_title);
        var e = "";
        return "" != a.data.xc.detail.share_img && null != a.data.xc.detail.share_img && (e = a.data.xc.detail.share_img), 
        {
            title: t,
            imageUrl: e,
            path: "/xc_farm/pages/cf_detail/cf_detail?&id=" + a.data.xc.detail.id,
            success: function(a) {
                console.log(a);
            },
            fail: function(a) {
                console.log(a);
            }
        };
    }
});