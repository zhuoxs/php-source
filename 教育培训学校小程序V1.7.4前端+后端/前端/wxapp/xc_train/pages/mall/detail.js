function a(a) {
    e = setInterval(function() {
        var t = a.data.failtime;
        if ((t -= 1) > 0) {
            var r = a.data.times;
            r[0] = parseInt(t / 86400), r[1] = parseInt(t / 3600 % 24), r[2] = parseInt(t / 60 % 60), 
            r[3] = parseInt(t % 60), a.setData({
                failtime: t,
                times: r
            });
        } else {
            clearInterval(e);
            var o = a.data.list;
            o.type = 1, a.setData({
                list: o
            });
        }
    }, 1e3);
}

function t(a) {
    r = setInterval(function() {
        for (var t = a.data.list.group_order, e = 0; e < t.length; e++) if (-1 == t[e].status && parseInt(t[e].fail) > 0) {
            t[e].fail = t[e].fail - 1;
            var r = [ 0, 0, 0 ];
            r[0] = parseInt(parseInt(t[e].fail) / 60 / 60), r[2] = parseInt(parseInt(t[e].fail) % 60), 
            r[1] = parseInt(parseInt(t[e].fail) / 60 % 60), t[e].times = r;
        } else t[e].status;
        var o = a.data.list;
        o.group_order = t, a.setData({
            list: o
        });
    }, 1e3);
}

var e, r, o = getApp(), n = require("../common/common.js"), i = require("../../../wxParse/wxParse.js");

Page({
    data: {
        format: -1,
        numbervalue: 1,
        times: [ 0, 0, 0, 0 ],
        failtime: 0
    },
    radiochange: function(a) {
        var t = this, e = a.detail.value;
        t.setData({
            format: e
        });
    },
    numMinus: function() {
        var a = this, t = a.data.numbervalue;
        1 == t || (t--, a.setData({
            numbervalue: t
        }));
    },
    numPlus: function() {
        var a = this, t = a.data.numbervalue;
        t++, a.setData({
            numbervalue: t
        });
    },
    valChange: function(a) {
        var t = this, e = a.detail.value;
        e >= 1 || (e = 1), t.setData({
            numbervalue: e
        });
    },
    submit: function(a) {
        var t = this;
        wx.navigateTo({
            url: "porder?&id=" + t.data.list.id + "&format=" + t.data.format + "&member=" + t.data.numbervalue
        });
    },
    group_submit: function(a) {
        var t = this, e = a.currentTarget.dataset.index;
        1 == e ? wx.navigateTo({
            url: "porder?&id=" + t.data.list.id + "&format=" + t.data.format + "&member=" + t.data.numbervalue
        }) : 2 == e && wx.navigateTo({
            url: "porder?&id=" + t.data.list.id + "&format=" + t.data.format + "&member=" + t.data.numbervalue + "&group=1"
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
    ctFunc: function(a) {
        var t = this, e = a.currentTarget.dataset.index;
        t.setData({
            showct: !1,
            showctd: !0,
            group_index: e
        });
    },
    group_btn: function() {
        var a = this;
        if (-1 == a.data.format) wx.showModal({
            title: "错误",
            content: "请选择规格"
        }); else {
            var t = "porder?&id=" + a.data.list.id + "&format=" + a.data.format + "&member=" + a.data.numbervalue + "&group=1&group_id=" + a.data.list.group_order[a.data.group_index].id;
            wx.navigateTo({
                url: t
            });
        }
    },
    onLoad: function(e) {
        var r = this;
        n.config(r), n.theme(r), o.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "mall_detail",
                id: e.id
            },
            success: function(e) {
                var o = e.data;
                if ("" != o.data) {
                    if (2 == o.data.type && "" != o.data.group_order && null != o.data.group_order) for (var n = 0; n < o.data.group_order.length; n++) if (parseInt(o.data.group_order[n].fail) > 0) {
                        var s = [ 0, 0, 0 ];
                        s[0] = parseInt(parseInt(o.data.group_order[n].fail) / 60 / 60), s[2] = parseInt(parseInt(o.data.group_order[n].fail) % 60), 
                        s[1] = parseInt(parseInt(o.data.group_order[n].fail) / 60 % 60), o.data.group_order[n].times = s, 
                        console.log(s);
                    } else o.data.group_order[n].status = 2;
                    if (r.setData({
                        list: o.data
                    }), "" != o.data.content && null != o.data.content) i.wxParse("article", "html", o.data.content, r, 0);
                    "" != o.data.format && null != o.data.format && r.setData({
                        format: 0
                    }), 3 == o.data.type && 0 != o.data.failtime && (r.setData({
                        failtime: o.data.failtime
                    }), a(r)), 2 == o.data.type && "" != o.data.group_order && null != o.data.group_order && t(r);
                }
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        n.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var n = this;
        o.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "mall_detail",
                id: n.data.list.id
            },
            success: function(o) {
                wx.stopPullDownRefresh();
                var s = o.data;
                if ("" != s.data) {
                    if (2 == s.data.type && "" != s.data.group_order && null != s.data.group_order) for (var d = 0; d < s.data.group_order.length; d++) if (parseInt(s.data.group_order[d].fail) > 0) {
                        var l = [ 0, 0, 0 ];
                        l[0] = parseInt(parseInt(s.data.group_order[d].fail) / 60 / 60), l[2] = parseInt(parseInt(s.data.group_order[d].fail) % 60), 
                        l[1] = parseInt(parseInt(s.data.group_order[d].fail) / 60 % 60), s.data.group_order[d].times = l, 
                        console.log(l);
                    } else s.data.group_order[d].status = 2;
                    if (n.setData({
                        list: s.data
                    }), "" != s.data.content && null != s.data.content) i.wxParse("article", "html", s.data.content, n, 0);
                    clearInterval(e), 3 == s.data.type && 0 != s.data.failtime && (n.setData({
                        failtime: s.data.failtime
                    }), a(n)), clearInterval(r), 2 == s.data.type && "" != s.data.group_order && null != s.data.group_order && t(n);
                }
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var a = this, t = "/xc_train/pages/mall/detail?&id=" + a.data.list.id;
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