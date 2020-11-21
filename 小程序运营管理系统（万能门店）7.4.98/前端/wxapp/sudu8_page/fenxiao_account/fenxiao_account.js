var app = getApp();

Page({
    data: {
        page_signs: "/sudu8_page/fenxiao_account/fenxiao_account"
    },
    onPullDownRefresh: function() {
        this.getmzh(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var o = this;
        wx.setNavigationBarTitle({
            title: "我的账户"
        }), wx.setNavigationBarColor({
            frontColor: "#000000",
            backgroundColor: "#fafafa"
        });
        var t = 0;
        a.fxsid && (t = a.fxsid, o.setData({
            fxsid: a.fxsid
        })), app.util.request({
            url: "entry/wxapp/BaseMin",
            data: {
                vs1: 1
            },
            success: function(a) {
                if (a.data.data.video) var t = "show";
                if (a.data.data.c_b_bg) var e = "bg";
                o.setData({
                    baseinfo: a.data.data,
                    show_v: t,
                    c_b_bg1: e
                }), wx.setNavigationBarColor({
                    frontColor: o.data.baseinfo.base_tcolor,
                    backgroundColor: o.data.baseinfo.base_color
                }), o.getmzh();
            },
            fail: function(a) {}
        }), app.util.getUserInfo(o.getinfos, t);
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getinfos: function() {
        var e = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                var t = a.data;
                e.setData({
                    openid: t
                });
            }
        });
    },
    account_tixian: function() {
        wx.navigateTo({
            url: "/sudu8_page/fenxiao_tixian/fenxiao_tixian"
        });
    },
    fenxiao_order: function() {
        wx.navigateTo({
            url: "/sudu8_page/fenxiao_order/fenxiao_order"
        });
    },
    tixian_record: function() {
        wx.navigateTo({
            url: "/sudu8_page/fenxiao_tixian_do/fenxiao_tixian_do"
        });
    },
    getmzh: function() {
        var t = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getmzh",
            data: {
                openid: a
            },
            success: function(a) {
                t.setData({
                    myzh: a.data.data.userinfo,
                    yj: a.data.data.wfmoney
                });
            }
        });
    }
});