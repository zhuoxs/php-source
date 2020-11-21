var common = require("../common/common.js"), app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

Page({
    data: {
        numbervalue: 0,
        tabCurr: 0,
        tab: [ "详情介绍", "评价" ],
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    group_on: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.xc;
        e.group[t].on = -e.group[t].on, this.setData({
            xc: e
        });
    },
    numMinus: function(a) {
        var t = this.data.xc, e = a.currentTarget.dataset.group, s = a.currentTarget.dataset.list;
        0 < parseInt(t.group[e].list[s].value) && (t.group[e].list[s].value = parseInt(t.group[e].list[s].value) - 1, 
        this.setData({
            xc: t
        }));
    },
    numPlus: function(a) {
        var t = this.data.xc, e = a.currentTarget.dataset.group, s = a.currentTarget.dataset.list, i = parseInt(t.group[e].list[s].member) - parseInt(t.group[e].list[s].member_on);
        parseInt(t.group[e].list[s].value) < i && (t.group[e].list[s].value = parseInt(t.group[e].list[s].value) + 1, 
        this.setData({
            xc: t
        }));
    },
    valChange: function(a) {
        var t = this.data.xc, e = a.currentTarget.dataset.group, s = a.currentTarget.dataset.list, i = parseInt(t.group[e].list[s].member) - parseInt(t.group[e].list[s].member_on), r = parseInt(a.detail.value);
        r <= 0 ? r = 0 : i < r && (r = i), t.group[e].list[s].value = r, this.setData({
            xc: t
        });
    },
    submit: function(a) {
        for (var t = this.data.xc.group, e = "", s = [], i = 0; i < t.length; i++) if ("" != t[i].list && null != t[i].list) for (var r = 0; r < t[i].list.length; r++) if (0 < t[i].list[r].value) {
            var n = {
                id: t[i].list[r].id,
                member: t[i].list[r].value
            };
            e == t[i].id ? s.push(n) : (e = t[i].id, s = [ n ]);
        }
        "" != e && 0 < s.length ? wx.navigateTo({
            url: "porder?&id=" + this.data.id + "&group=" + e + "&group_detail=" + JSON.stringify(s)
        }) : app.util.message("请选择购买产品", "", "error");
    },
    tabChange: function(a) {
        var t = a.currentTarget.dataset.index;
        t != this.data.tabCurr && this.setData({
            tabCurr: t
        });
    },
    onLoad: function(a) {
        var e = this;
        common.config(e), e.setData({
            id: a.id
        }), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "pin_detail",
                id: e.data.id
            },
            success: function(a) {
                var t = a.data;
                if ("" != t.data && (e.setData({
                    xc: t.data
                }), "" != t.data.content && null != t.data.content)) WxParse.wxParse("article", "html", t.data.content, e, 0);
            }
        }), app.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            data: {
                op: "pin_discuss",
                id: e.data.id,
                page: e.data.page,
                pagesize: e.data.pagesize
            },
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
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "pin_detail",
                id: e.data.id
            },
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data && e.setData({
                    xc: t.data
                });
            }
        });
    },
    onReachBottom: function() {
        var e = this;
        1 != e.data.tabCurr || e.data.isbottom || app.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            data: {
                op: "pin_discuss",
                id: e.data.id,
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    list: e.data.list.concat(t.data),
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                });
            }
        });
    },
    onShareAppMessage: function() {
        var a = "/xc_farm/pages/pin/detail?&id=" + this.data.id;
        this.data.xc;
        return {
            title: app.config.webname + "-" + this.data.xc.name,
            imageUrl: "",
            path: a,
            success: function(a) {
                console.log(a);
            },
            fail: function(a) {
                console.log(a);
            }
        };
    }
});