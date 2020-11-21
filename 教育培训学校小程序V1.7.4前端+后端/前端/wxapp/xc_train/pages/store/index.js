var a = getApp(), t = require("../common/common.js");

Page({
    data: {
        page: 1,
        pagesize: 20,
        isbottom: !1
    },
    onLoad: function(e) {
        var d = this;
        t.config(d), t.theme(d), wx.getLocation({
            type: "wgs84",
            success: function(a) {
                var t = a.latitude, e = a.longitude;
                a.speed, a.accuracy;
                d.setData({
                    latitude: t,
                    longitude: e
                });
            },
            complete: function() {
                var t = {
                    op: "school",
                    page: d.data.page,
                    pagesize: d.data.pagesize
                };
                null != d.data.latitude && "" != d.data.latitude && (t.latitude = d.data.latitude), 
                null != d.data.longitude && "" != d.data.longitude && (t.longitude = d.data.longitude), 
                a.util.request({
                    url: "entry/wxapp/index",
                    data: t,
                    success: function(a) {
                        var t = a.data;
                        "" != t.data ? d.setData({
                            list: t.data,
                            page: d.data.page + 1
                        }) : d.setData({
                            isbottom: !0
                        });
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        t.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var t = this;
        t.setData({
            page: 1,
            isbottom: !1
        });
        var e = {
            op: "school",
            page: t.data.page,
            pagesize: t.data.pagesize
        };
        null != t.data.latitude && "" != t.data.latitude && (e.latitude = t.data.latitude), 
        null != t.data.longitude && "" != t.data.longitude && (e.longitude = t.data.longitude), 
        a.util.request({
            url: "entry/wxapp/index",
            data: e,
            success: function(a) {
                var e = a.data;
                wx.stopPullDownRefresh(), "" != e.data ? t.setData({
                    list: e.data,
                    page: t.data.page + 1
                }) : t.setData({
                    isbottom: !0
                });
            }
        });
    },
    onReachBottom: function() {
        var t = this;
        if (!t.data.isbottom) {
            var e = {
                op: "school",
                page: t.data.page,
                pagesize: t.data.pagesize
            };
            null != t.data.latitude && "" != t.data.latitude && (e.latitude = t.data.latitude), 
            null != t.data.longitude && "" != t.data.longitude && (e.longitude = t.data.longitude), 
            a.util.request({
                url: "entry/wxapp/index",
                data: e,
                success: function(a) {
                    var e = a.data;
                    "" != e.data ? t.setData({
                        list: t.data.list.concat(e.data),
                        page: t.data.page + 1
                    }) : t.setData({
                        isbottom: !0
                    });
                }
            });
        }
    }
});