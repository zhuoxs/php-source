var common = require("../common/common.js"), app = getApp(), width = 2;

Page({
    data: {
        navHref: "../plant/index",
        tagCurr1: -1,
        type: -1,
        page: 1,
        pagesize: 20,
        isbottom: !1,
        curr: -1,
        land_curr: -1,
        numbervalue: 1,
        scroll_left: 0
    },
    change: function() {
        var e = this, a = e.data.xc;
        a.list = [], e.setData({
            type: -e.data.type,
            page: 1,
            isbottom: !1,
            curr: -1,
            tagCurr1: -1,
            land_curr: -1,
            scroll_left: 0,
            xc: a
        });
        var t = {
            op: "plant",
            page: e.data.page,
            pagesize: e.data.pagesize,
            type: e.data.type
        };
        -1 != e.data.tagCurr1 && (t.cid = e.data.xc.class[e.data.tagCurr1].id), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: t,
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
        });
    },
    tagChange1: function(a) {
        var s = this, t = a.currentTarget.dataset.index;
        if (t != s.data.tagCurr1) {
            s.setData({
                tagCurr1: t,
                page: 1,
                isbottom: !1,
                curr: -1,
                land_curr: -1,
                scroll_left: 0
            });
            var e = {
                op: "plant",
                page: s.data.page,
                pagesize: s.data.pagesize,
                type: s.data.type
            };
            -1 != s.data.tagCurr1 && (e.cid = s.data.xc.class[s.data.tagCurr1].id), app.util.request({
                url: "entry/wxapp/service",
                method: "POST",
                data: e,
                success: function(a) {
                    var t = a.data;
                    if ("" != t.data) {
                        var e = s.data.xc;
                        "" != t.data.list && null != t.data.list ? (e.list = t.data.list, s.setData({
                            xc: e,
                            page: s.data.page + 1
                        })) : (e.list = [], s.setData({
                            xc: e,
                            isbottom: !0
                        }));
                    }
                }
            });
        }
    },
    tan: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.xc;
        this.setData({
            list: e.list[t],
            yin: !0
        });
    },
    tan_close: function(a) {
        this.setData({
            yin: !1,
            showbuy: !1
        });
    },
    choose: function(a) {
        var t = a.currentTarget.dataset.index;
        t != this.data.curr && this.setData({
            curr: t,
            land_curr: -1,
            scroll_left: 0
        });
    },
    land_choose: function(a) {
        var t = a.currentTarget.dataset.index;
        t != this.data.land_curr && this.setData({
            land_curr: t,
            scroll_left: 0
        });
    },
    submit: function() {
        -1 != this.data.land_curr ? this.setData({
            showbuy: !0
        }) : wx.showModal({
            title: "错误",
            content: "请先选择土地",
            showCancel: !1
        });
    },
    numMinus: function() {
        var a = this.data.numbervalue;
        1 < parseInt(a) && this.setData({
            numbervalue: a - 1
        });
    },
    numPlus: function() {
        var a = this, t = a.data.numbervalue, e = a.data.xc, s = a.data.curr, r = a.data.land_curr;
        parseInt(t) < parseInt(e.list[s].land[r].seed_member) && a.setData({
            numbervalue: t + 1
        });
    },
    valChange: function(a) {
        var t = this, e = t.data.xc, s = t.data.curr, r = t.data.land_curr, d = parseInt(a.detail.value);
        d <= 1 ? d = 1 : d > parseInt(e.list[s].land[r].seed_member) && (d = parseInt(e.list[s].land[r].seed_member)), 
        t.setData({
            numbervalue: d
        });
    },
    pay: function() {
        var a = this, t = a.data.xc, e = a.data.curr, s = a.data.land_curr;
        wx.navigateTo({
            url: "porder?&land=" + t.list[e].land[s].id + "&seed=" + t.list[e].id + "&member=" + a.data.numbervalue
        });
    },
    bindscroll: function(a) {
        this.setData({
            scroll_left: a.detail.scrollLeft * width
        });
    },
    scroll_prev: function() {
        this.data.xc, this.data.curr;
        var a = this.data.scroll_left;
        (a -= 67 * width) < 0 && (a = 0), this.setData({
            scroll_left: a
        });
    },
    scroll_next: function() {
        var a = this, t = a.data.xc, e = a.data.curr, s = t.list[e].land.length;
        4 < s && a.data.scroll_left < 67 * width * (s - 3) && a.setData({
            scroll_left: a.data.scroll_left + 67 * width
        });
    },
    onLoad: function(a) {
        var e = this;
        common.config(e), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "plant",
                page: e.data.page,
                pagesize: e.data.pagesize,
                type: e.data.type
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
        }), wx.getSystemInfo({
            success: function(a) {
                width = 750 / a.windowWidth;
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        e.setData({
            page: 1,
            isbottom: !1
        });
        var a = {
            op: "plant",
            page: e.data.page,
            pagesize: e.data.pagesize,
            type: e.data.type
        };
        -1 != e.data.tagCurr1 && (a.cid = e.data.xc.class[e.data.tagCurr1].id), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: a,
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data && (e.setData({
                    xc: t.data
                }), "" != t.data.list && null != t.data.list ? e.setData({
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                }));
            }
        });
    },
    onReachBottom: function() {
        var s = this;
        if (!s.data.isbottom) {
            var a = {
                op: "plant",
                page: s.data.page,
                pagesize: s.data.pagesize,
                type: s.data.type
            };
            -1 != s.data.tagCurr1 && (a.cid = s.data.xc.class[s.data.tagCurr1].id), app.util.request({
                url: "entry/wxapp/service",
                method: "POST",
                data: a,
                success: function(a) {
                    var t = a.data;
                    if ("" != t.data) {
                        var e = s.data.xc;
                        "" != t.data.list && null != t.data.list ? (e.list = e.list.concat(t.data.list), 
                        s.setData({
                            xc: e,
                            page: s.data.page + 1
                        })) : s.setData({
                            isbottom: !0
                        });
                    }
                }
            });
        }
    }
});