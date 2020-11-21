var app = getApp();

Page({
    data: {
        tabs: [ "出售中", "已售罄", "未上架" ],
        activeIndex: 0,
        sliderOffset: 0,
        sliderLeft: 0,
        flag: 1
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this, e = a.id;
        t.setData({
            id: e
        });
        var o = 0;
        a.fxsid && (o = a.fxsid, t.setData({
            fxsid: a.fxsid
        }));
        var n = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: n,
            data: {
                vs1: 1
            },
            cachetime: "30",
            success: function(a) {
                a.data.data;
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(t.getinfos, o), t.prolist(1);
    },
    changflag: function(a) {
        var t = a.currentTarget.dataset.flag;
        null != t && this.setData({
            flag: t
        }), this.prolist(t);
    },
    prolist: function(a) {
        var t = this, e = app.util.url("entry/wxapp/prolist", {
            m: "sudu8_page_plugin_shop"
        });
        wx.request({
            url: e,
            data: {
                status: a,
                id: wx.getStorageSync("mlogin")
            },
            cachetime: "30",
            success: function(a) {
                t.setData({
                    prolist: a.data.data
                });
            }
        });
    },
    proedit: function(a) {
        var t = a.currentTarget.dataset.pid;
        wx.navigateTo({
            url: "/sudu8_page_plugin_shop/manage_pro/manage_pro?id=" + t
        });
    },
    prodel: function(a) {
        var e = a.currentTarget.dataset.pid;
        wx.showModal({
            title: "提示",
            content: "确定要删除这个商品吗？",
            showCancel: !0,
            cancelText: "取消",
            cancelColor: "#ccc",
            confirmText: "删除",
            confirmColor: "#ff0000",
            success: function(a) {
                if (a.confirm) {
                    var t = app.util.url("entry/wxapp/prodel", {
                        m: "sudu8_page_plugin_shop"
                    });
                    wx.request({
                        url: t,
                        data: {
                            pid: e,
                            id: wx.getStorageSync("mlogin")
                        },
                        cachetime: "30",
                        success: function(a) {
                            wx.showModal({
                                title: "提示",
                                content: "删除成功！",
                                showCancel: !1,
                                success: function(a) {
                                    wx.redirectTo({
                                        url: "/sudu8_page_plugin_shop/manage_prolist/manage_prolist"
                                    });
                                }
                            });
                        }
                    });
                }
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});