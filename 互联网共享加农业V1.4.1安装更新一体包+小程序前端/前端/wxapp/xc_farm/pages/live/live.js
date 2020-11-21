var common = require("../common/common.js"), app = getApp();

Page({
    data: {
        navHref: "../live/live",
        tagCurr1: -1,
        canload: !0,
        loading: !1,
        nomore: !1,
        list: [ {
            href: "",
            img: "../../images/live_img01.jpg",
            name: "鸡舍东南1号机"
        }, {
            href: "",
            img: "../../images/live_img01.jpg",
            name: "鸡舍饲料2号机"
        }, {
            href: "",
            img: "../../images/live_img01.jpg",
            name: "室外饮水区3号机"
        }, {
            href: "",
            img: "../../images/live_img01.jpg",
            name: "林地4号机"
        }, {
            href: "",
            img: "../../images/live_img01.jpg",
            name: "鸡舍东南1号机"
        }, {
            href: "",
            img: "../../images/live_img01.jpg",
            name: "鸡舍东南1号机"
        } ],
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    tagChange1: function(a) {
        var e = this, t = a.currentTarget.id;
        if (e.data.tagCurr1 != t) {
            e.setData({
                tagCurr1: t,
                page: 1,
                isbottom: !1
            });
            var i = {
                op: "live",
                page: e.data.page,
                pagesize: e.data.pagesize
            };
            -1 != t && (i.cid = e.data.xc.class[t].id), app.util.request({
                url: "entry/wxapp/service",
                method: "POST",
                data: i,
                success: function(a) {
                    var t = a.data;
                    "" != t.data && ("" != t.data.list && null != t.data.list ? e.setData({
                        page: e.data.page + 1
                    }) : (t.data.list = [], e.setData({
                        isbottom: !0
                    })), e.setData({
                        xc: t.data
                    }));
                }
            });
        }
    },
    onLoad: function(a) {
        var e = this;
        common.config(e), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "live",
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
        });
    },
    onReachBottom: function() {
        var i = this;
        if (!i.data.isbottom) {
            var a = {
                op: "live",
                page: i.data.page,
                pagesize: i.data.pagesize
            };
            -1 != i.data.tagCurr1 && (a.cid = i.data.xc.class[i.data.tagCurr1].id), app.util.request({
                url: "entry/wxapp/service",
                method: "POST",
                data: a,
                success: function(a) {
                    var t = a.data;
                    if ("" != t.data) if ("" != t.data.list && null != t.data.list) {
                        var e = i.data.xc;
                        e.list = e.list.concat(t.data.list), i.setData({
                            page: i.data.page + 1,
                            xc: e
                        });
                    } else wx.showToast({
                        title: "全部加载",
                        icon: "success",
                        duration: 2e3
                    }), i.setData({
                        isbottom: !0
                    });
                }
            });
        }
    },
    onPullDownRefresh: function() {
        var e = this;
        e.setData({
            page: 1,
            isbottom: !1
        });
        var a = {
            op: "live",
            page: e.data.page,
            pagesize: e.data.pagesize
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
    onShareAppMessage: function() {
        return {
            title: app.config.webname,
            path: "/xc_farm/pages/live/live",
            success: function(a) {
                console.log(a);
            },
            fail: function(a) {
                console.log(a);
            }
        };
    }
});