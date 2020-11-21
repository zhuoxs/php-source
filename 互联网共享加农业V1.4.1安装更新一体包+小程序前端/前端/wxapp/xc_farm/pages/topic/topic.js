var tt, common = require("../common/common.js"), app = getApp();

function time_up(t) {
    tt = setInterval(function() {
        var a = t.data.failtime;
        0 == a ? clearInterval(tt) : (a = parseInt(a) - 1, t.setData({
            failtime: a,
            day: parseInt(a / 86400),
            hour: parseInt(a % 86400 / 3600),
            min: parseInt(a % 3600 / 60),
            second: parseInt(a % 60)
        }));
    }, 1e3);
}

Page({
    data: {
        failtime: 0,
        day: 0,
        hour: 0,
        min: 0,
        second: 0,
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    onLoad: function(a) {
        var e = this;
        common.config(e), e.setData({
            id: a.id
        }), app.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            data: {
                op: "topic",
                id: e.data.id,
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && (clearInterval(tt), e.setData({
                    xc: t.data,
                    failtime: t.data.failtime
                }), time_up(e), "" != t.data.list && null != t.data.list ? e.setData({
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                }));
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
        }), app.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            data: {
                op: "topic",
                id: e.data.id,
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data && (clearInterval(tt), e.setData({
                    xc: t.data,
                    failtime: t.data.failtime
                }), time_up(e), "" != t.data.list && null != t.data.list ? e.setData({
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                }));
            }
        });
    },
    onReachBottom: function() {
        var i = this;
        i.data.isbottom || app.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            data: {
                op: "topic",
                id: i.data.id,
                page: i.data.page,
                pagesize: i.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                if (wx.stopPullDownRefresh(), "" != t.data) if ("" != t.data.list && null != t.data.list) {
                    var e = i.data.xc;
                    e.list.concat(t.data.list), i.setData({
                        page: i.data.page + 1,
                        xc: e
                    });
                } else i.setData({
                    isbottom: !0
                });
            }
        });
    }
});