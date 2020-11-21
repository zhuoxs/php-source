var app = getApp();

Page({
    data: {
        more: !0,
        refresh: !0,
        pages: 1,
        recycle: {
            open: !1,
            style: []
        }
    },
    onLoad: function(a) {
        var t = this, e = wx.getStorageSync("loading_img");
        e ? t.setData({
            loadingImg: e
        }) : t.setData({
            loadingImg: "../../libs/images/loading.gif"
        }), t.setData({
            options: a
        });
        var s = t.data.options.type ? t.data.options.type : "";
        app.viewCount(), app.util.request({
            url: "entry/wxapp/mycredit",
            cachetime: "0",
            data: {
                type: s,
                m: "superman_hand2"
            },
            success: function(a) {
                a.data.data && t.setData({
                    list: a.data.data,
                    total: a.data.data.length,
                    completed: !0
                });
            }
        });
    },
    onPullDownRefresh: function() {
        this.onLoad(this.data.options), wx.stopPullDownRefresh();
    },
    onReachBottom: function() {
        var s = this;
        if (s.data.refresh) if (s.data.total < 20) s.setData({
            more: !1
        }); else {
            s.setData({
                hide: !1
            });
            var o = s.data.pages + 1;
            app.util.request({
                url: "entry/wxapp/mycredit",
                cachetime: "0",
                data: {
                    page: o,
                    m: "superman_hand2"
                },
                success: function(a) {
                    if (s.setData({
                        hide: !0
                    }), 0 == a.data.errno) {
                        var t = a.data.data;
                        if (0 < t.length) {
                            var e = s.data.list.concat(t);
                            s.setData({
                                total: t.length,
                                list: e,
                                pages: o
                            });
                        } else s.setData({
                            more: !1,
                            refresh: !1
                        });
                    } else wx.showModal({
                        title: "系统提示",
                        content: a.data.errmsg + "(" + a.data.errno + ")"
                    });
                }
            });
        }
    }
});