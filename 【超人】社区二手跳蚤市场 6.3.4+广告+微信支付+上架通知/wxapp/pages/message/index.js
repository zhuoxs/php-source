var app = getApp(), Toast = require("../../libs/zanui/toast/toast");

Page({
    data: {
        pages: 1,
        hide: !0,
        more: !0,
        refresh: !0,
        showCategoryPopup: !1,
        recycle: {
            open: !1,
            style: []
        }
    },
    onLoad: function() {
        var t = wx.getStorageSync("loading_img");
        t ? this.setData({
            loadingImg: t
        }) : that.setData({
            loadingImg: "../../libs/images/loading.gif"
        }), app.viewCount();
    },
    onShow: function() {
        var t = this;
        t.getMsgList(), app.util.footer(t), app.setTabBar(t);
    },
    getMsgList: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/message",
            data: {
                act: "list",
                m: "superman_hand2"
            },
            success: function(t) {
                t.data.errno ? a.showIconToast(t.data.errmsg) : a.setData({
                    list: t.data.data,
                    total: t.data.data.length,
                    completed: !0
                });
            },
            fail: function(t) {
                a.setData({
                    completed: !0
                }), a.showIconToast(t.data.errmsg);
            }
        });
    },
    deleteItem: function(t) {
        var a = this, e = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/message",
            cachetime: "0",
            data: {
                act: "delete",
                id: e,
                m: "superman_hand2"
            },
            success: function(t) {
                t.data.errno ? a.showIconToast(t.errmsg) : (a.showIconToast("删除成功", "success"), 
                a.getMsgList());
            }
        });
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
                url: "entry/wxapp/message",
                cachetime: "0",
                data: {
                    act: "list",
                    page: o,
                    m: "superman_hand2"
                },
                success: function(t) {
                    if (s.setData({
                        hide: !0
                    }), 0 == t.data.errno) {
                        var a = t.data.data;
                        if (0 < a.length) {
                            var e = s.data.list.concat(a);
                            s.setData({
                                total: a.length,
                                list: e,
                                pages: o
                            });
                        } else s.setData({
                            more: !1,
                            refresh: !1
                        });
                    } else s.showIconToast(t.errmsg);
                }
            });
        }
    },
    onPullDownRefresh: function() {
        this.getMsgList(), wx.stopPullDownRefresh();
    },
    toggleCategoryPopup: function() {
        this.setData({
            category: wx.getStorageSync("category") ? wx.getStorageSync("category") : [],
            showCategoryPopup: !this.data.showCategoryPopup
        });
    },
    jumpToPage: function(t) {
        var a = t.currentTarget.dataset.url;
        -1 != a.indexOf("http") ? wx.navigateTo({
            url: "../ad/index?path=" + encodeURIComponent(a)
        }) : wx.navigateTo({
            url: a
        });
    },
    showIconToast: function(t) {
        var a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "fail";
        Toast({
            type: a,
            message: t,
            selector: "#zan-toast"
        });
    }
});