var app = getApp();

Page({
    data: {
        nav: 1,
        page_signs: "/sudu8_page/fenxiao_order/fenxiao_order"
    },
    onPullDownRefresh: function() {
        this.getlistqf(1), this.getbase(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var n = this;
        wx.setNavigationBarTitle({
            title: "分销订单"
        }), wx.setNavigationBarColor({
            frontColor: "#000000",
            backgroundColor: "#fafafa"
        });
        var a = 0;
        t.fxsid && (a = t.fxsid, n.setData({
            fxsid: t.fxsid
        })), app.util.request({
            url: "entry/wxapp/BaseMin",
            data: {
                vs1: 1
            },
            success: function(t) {
                if (t.data.data.video) var a = "show";
                if (t.data.data.c_b_bg) var e = "bg";
                n.setData({
                    baseinfo: t.data.data,
                    show_v: a,
                    c_b_bg1: e
                }), wx.setNavigationBarColor({
                    frontColor: n.data.baseinfo.base_tcolor,
                    backgroundColor: n.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(n.getinfos, a);
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    getinfos: function() {
        var e = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                var a = t.data;
                e.setData({
                    openid: a
                }), e.getlistqf(1), e.getbase();
            }
        });
    },
    nav: function(t) {
        this.setData({
            nav: t.currentTarget.dataset.id
        });
        var a = t.currentTarget.dataset.id;
        this.getlistqf(a);
    },
    getbase: function() {
        var a = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/fxcount",
            data: {
                openid: t
            },
            success: function(t) {
                a.setData({
                    orderscount: t.data.data
                });
            }
        });
    },
    getlistqf: function(t) {
        var a = this, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/fxdingdan",
            data: {
                openid: e,
                types: t
            },
            success: function(t) {
                a.setData({
                    orders: t.data.data
                });
            }
        });
    },
    toshopping: function() {
        wx.reLaunch({
            url: "/sudu8_page/index/index"
        });
    }
});