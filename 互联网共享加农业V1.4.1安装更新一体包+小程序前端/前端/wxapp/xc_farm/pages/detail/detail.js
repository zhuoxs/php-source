var _WxValidate = require("../../../utils/WxValidate.js"), _WxValidate2 = _interopRequireDefault(_WxValidate);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var tt, dd, common = require("../common/common.js"), app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

function time_up(d) {
    dd = setInterval(function() {
        for (var t = d.data.xc.group_order, a = 0; a < t.length; a++) if (-1 == t[a].status && 0 < parseInt(t[a].fail)) {
            t[a].fail = t[a].fail - 1;
            var e = [ 0, 0, 0 ];
            e[0] = parseInt(parseInt(t[a].fail) / 60 / 60), e[2] = parseInt(parseInt(t[a].fail) % 60), 
            e[1] = parseInt(parseInt(t[a].fail) / 60 % 60), t[a].times = e;
        } else t[a].status;
        var i = d.data.xc;
        i.group_order = t, d.setData({
            xc: i
        });
    }, 1e3);
}

Page({
    data: {
        numbervalue: 1,
        format: -1,
        canload: !0,
        tab: [ "商品详情", "砍价记录", "图文直播" ],
        tabCurr: 0,
        showkj: !1,
        code: ""
    },
    radiochange: function(t) {
        var a = t.detail.value, e = this.data.xc;
        2 == e.detail.type && "" != e.cut_order && null != e.cut_order || this.setData({
            format: a
        });
    },
    numMinus: function() {
        var t = this.data.numbervalue;
        1 == t || (t--, this.setData({
            numbervalue: t
        }));
    },
    numPlus: function() {
        var t = this.data.numbervalue;
        t++, this.setData({
            numbervalue: t
        });
    },
    valChange: function(t) {
        var a = t.detail.value;
        1 <= a || (a = 1), this.setData({
            numbervalue: a
        });
    },
    shop_add: function() {
        var e = this, t = e.data.xc.detail;
        if (e.data.canload) {
            e.setData({
                canload: !1
            });
            var i = {
                op: "shop_add",
                id: t.id,
                format_index: e.data.format,
                member: e.data.numbervalue
            };
            app.util.request({
                url: "entry/wxapp/service",
                method: "POST",
                data: i,
                success: function(t) {
                    if ("" != t.data.data) {
                        wx.showToast({
                            title: "添加成功",
                            icon: "success",
                            duration: 2e3
                        });
                        var a = e.data.xc;
                        a.shop = parseInt(a.shop) + parseInt(i.member), e.setData({
                            numbervalue: 1,
                            xc: a
                        });
                    }
                },
                complete: function() {
                    e.setData({
                        canload: !0
                    });
                }
            });
        }
    },
    tabChange: function(t) {
        var a = t.currentTarget.id;
        this.setData({
            tabCurr: a
        });
    },
    kjFunc: function() {
        var i = this;
        -1 == i.data.format ? wx.showModal({
            title: "错误",
            content: "请选择规格"
        }) : common.is_bind(function() {
            app.util.request({
                url: "entry/wxapp/service",
                method: "POST",
                data: {
                    op: "cut",
                    id: i.data.xc.detail.id,
                    format_index: i.data.format
                },
                success: function(t) {
                    var a = t.data;
                    "" != a.data && (i.setData({
                        showkj: !0,
                        cut_price: a.data.cut_price
                    }), app.util.request({
                        url: "entry/wxapp/service",
                        showLoading: !1,
                        method: "POST",
                        data: {
                            op: "service_detail",
                            id: i.data.xc.detail.id
                        },
                        success: function(t) {
                            var a = t.data;
                            if ("" != a.data) {
                                var e = i.data.xc;
                                "" != a.data.cut_order && null != a.data.cut_order && (i.setData({
                                    format: a.data.cut_order.format_index
                                }), e.cut_order = a.data.cut_order), "" != a.data.cut_log && null != a.data.cut_log && (e.cut_log = a.data.cut_log), 
                                i.setData({
                                    xc: e
                                });
                            }
                        }
                    }));
                }
            });
        });
    },
    kjFunc2: function() {
        var i = this;
        common.is_bind(function() {
            app.util.request({
                url: "entry/wxapp/service",
                method: "POST",
                data: {
                    op: "cut_help",
                    id: i.data.xc.help_order.id,
                    openid: i.data.cut_openid
                },
                success: function(t) {
                    var a = t.data;
                    "" != a.data && (i.setData({
                        showkj2: !0,
                        cut_price: a.data.cut_price
                    }), app.util.request({
                        url: "entry/wxapp/service",
                        showLoading: !1,
                        method: "POST",
                        data: {
                            op: "service_detail",
                            id: i.data.xc.detail.id,
                            cut_openid: i.data.cut_openid
                        },
                        success: function(t) {
                            var a = t.data;
                            if ("" != a.data) {
                                var e = i.data.xc;
                                "" != a.data.help_order && null != a.data.help_order && (e.help_order = a.data.help_order), 
                                i.setData({
                                    xc: e
                                });
                            }
                        }
                    }));
                }
            });
        });
    },
    closekj: function() {
        this.setData({
            showkj: !1,
            showkj2: !1
        });
    },
    closect: function() {
        this.setData({
            showct: !1
        });
    },
    showct: function() {
        this.setData({
            showct: !0
        });
    },
    closectd: function() {
        this.setData({
            showctd: !1
        });
    },
    ctFunc: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            showct: !1,
            showctd: !0,
            group_index: a
        });
    },
    submit: function(t) {
        var a = this, e = t.currentTarget.dataset.index;
        common.is_bind(function() {
            if (3 != e && 2 != e || -1 != a.data.format) {
                var t = "../cart_pay/cart_pay?&id=" + a.data.xc.detail.id + "&format_index=" + a.data.format + "&member=" + a.data.numbervalue + "&order_type=" + e;
                "" != a.data.xc.topic && null != a.data.xc.topic && (t = t + "&topic=" + a.data.topic), 
                wx.navigateTo({
                    url: t
                });
            } else wx.showModal({
                title: "错误",
                content: "请选择规格"
            });
        });
    },
    group_btn: function() {
        var a = this;
        common.is_bind(function() {
            if (-1 == a.data.format) wx.showModal({
                title: "错误",
                content: "请选择规格"
            }); else {
                var t = "../cart_pay/cart_pay?&id=" + a.data.xc.detail.id + "&format_index=" + a.data.format + "&member=" + a.data.numbervalue + "&order_type=2&group=" + a.data.xc.group_order[a.data.group_index].id;
                wx.navigateTo({
                    url: t
                });
            }
        });
    },
    group_btn2: function() {
        var a = this;
        common.is_bind(function() {
            if (-1 == a.data.format) wx.showModal({
                title: "错误",
                content: "请选择规格"
            }); else {
                var t = "../cart_pay/cart_pay?&id=" + a.data.xc.detail.id + "&format_index=" + a.data.format + "&member=" + a.data.numbervalue + "&order_type=2&group=" + a.data.group_id;
                wx.navigateTo({
                    url: t
                });
            }
        });
    },
    showShare: function() {
        this.setData({
            showShare: !0
        });
    },
    closeShare: function() {
        this.setData({
            showShare: !1
        });
    },
    showhb: function() {
        var e = this;
        "" != e.data.code ? e.setData({
            showhb: !0,
            showShare: !1
        }) : app.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            data: {
                op: "code",
                id: e.data.xc.detail.id
            },
            success: function(t) {
                var a = t.data;
                "" != a.data && e.setData({
                    code: a.data.code,
                    showhb: !0,
                    showShare: !1
                });
            }
        });
    },
    closehb: function() {
        this.setData({
            showhb: !1
        });
    },
    dlimg: function() {
        wx.showLoading({
            title: "保存中"
        }), wx.downloadFile({
            url: this.data.code,
            success: function(t) {
                wx.saveImageToPhotosAlbum({
                    filePath: t.tempFilePath,
                    success: function(t) {
                        console.log(t), wx.hideLoading(), wx.showToast({
                            title: "保存成功",
                            icon: "success",
                            duration: 2e3
                        });
                    },
                    fail: function(t) {
                        wx.hideLoading(), wx.showToast({
                            title: "保存失败",
                            icon: "success",
                            duration: 2e3
                        });
                    }
                });
            }
        });
    },
    onLoad: function(t) {
        var d = this;
        common.config(d), "" != t.group && null != t.group && d.setData({
            group_id: t.group
        });
        var a = {
            op: "service_detail",
            id: t.id
        };
        "" != t.openid && null != t.openid && (d.setData({
            cut_openid: t.openid
        }), a.cut_openid = t.openid), "" != t.topic && null != t.topic && (d.setData({
            topic: t.topic
        }), a.topic = d.data.topic), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: a,
            success: function(t) {
                var a = t.data;
                if ("" != a.data) {
                    if ("" != a.data.detail.format && null != a.data.detail.format && d.setData({
                        format: 0
                    }), "" != a.data.cut_order && null != a.data.cut_order && d.setData({
                        format: a.data.cut_order.format_index
                    }), 1 == a.data.detail.type && "" != a.data.group_order && null != a.data.group_order) {
                        for (var e = 0; e < a.data.group_order.length; e++) if (0 < parseInt(a.data.group_order[e].fail)) {
                            var i = [ 0, 0, 0 ];
                            i[0] = parseInt(parseInt(a.data.group_order[e].fail) / 60 / 60), i[2] = parseInt(parseInt(a.data.group_order[e].fail) % 60), 
                            i[1] = parseInt(parseInt(a.data.group_order[e].fail) / 60 % 60), a.data.group_order[e].times = i;
                        } else a.data.group_order[e].status = 2;
                        time_up(d);
                    }
                    if (d.setData({
                        xc: a.data
                    }), d.timecount(), "" != a.data.detail.content && null != a.data.detail.content) WxParse.wxParse("article", "html", a.data.detail.content, d, 0);
                }
            }
        });
    },
    onReady: function() {},
    timecount: function() {
        var e = this, t = e.data.xc.detail;
        if ((3 == t.type || 2 == t.type) && 1 == t.fail_status) {
            t.times[0] = parseInt(t.fail_time / 86400), t.times[1] = parseInt((t.fail_time - 24 * t.times[0] * 60 * 60) / 3600), 
            t.times[2] = parseInt(t.fail_time % 3600 / 60), t.times[3] = t.fail_time % 60;
            var a = e.data.xc;
            a.detail = t, e.setData({
                xc: a
            }), tt = setInterval(function() {
                var t = e.data.xc.detail;
                0 < t.times[3] ? t.times[3] = t.times[3] - 1 : 0 < t.times[2] ? (t.times[3] = 59, 
                t.times[2] = t.times[2] - 1) : 0 < t.times[1] ? (t.times[3] = 59, t.times[2] = 59, 
                t.times[1] = t.times[1] - 1) : 0 < t.times[0] ? (t.times[3] = 59, t.times[2] = 59, 
                t.times[1] = 24, t.times[0] = t.times[0] - 1) : (clearInterval(tt), t.fail_status = 2);
                var a = e.data.xc;
                a.detail = t, e.setData({
                    xc: a
                });
            }, 1e3);
        }
    },
    onPullDownRefresh: function() {
        var e = this, t = {
            op: "service_detail",
            id: e.data.xc.detail.id
        };
        "" != e.data.cut_openid && null != e.data.cut_openid && (t.cut_openid = e.data.cut_openid), 
        "" != e.data.topic && null != e.data.topic && (t.topic = e.data.topic), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: t,
            success: function(t) {
                var a = t.data;
                wx.stopPullDownRefresh(), "" != a.data && (clearInterval(tt), clearInterval(dd), 
                e.setData({
                    xc: a.data
                }), e.timecount(), 1 == a.data.detail.type && "" != a.data.group_list && null != a.data.group_list && time_up(e));
            }
        });
    },
    onShareAppMessage: function(t) {
        var a = this;
        a.setData({
            showkj: !1,
            showkj2: !1
        });
        var e = "/xc_farm/pages/detail/detail?&id=" + a.data.xc.detail.id, i = a.data.xc;
        if (console.log(t), "" != t.target && null != t.target && "" != t.target.dataset.index && null != t.target.dataset.index) {
            var d = t.target.dataset.index;
            console.log(d), 1 == d ? e = e + "&openid=" + a.data.cut_openid : 2 == i.detail.type && "" != i.cut_order && null != i.cut_order && (e = e + "&openid=" + app.userinfo.openid);
        }
        var o = app.config.webname + "-" + a.data.xc.detail.name;
        "" != a.data.xc.detail.share_title && null != a.data.xc.detail.share_title && (o = a.data.xc.detail.share_title);
        var r = "";
        return "" != a.data.xc.detail.share_img && null != a.data.xc.detail.share_img && (r = a.data.xc.detail.share_img), 
        {
            title: o,
            imageUrl: r,
            path: e,
            success: function(t) {
                console.log(t);
            },
            fail: function(t) {
                console.log(t);
            }
        };
    }
});