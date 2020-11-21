var u = require("../../sudu8_page/resource/js/util.js"), app = getApp();

Page({
    data: {
        auction: [],
        a: 1,
        remind: 0,
        indexpage: []
    },
    onLoad: function(t) {
        var a = this;
        a.setData({
            isIphoneX: app.globalData.isIphoneX
        });
        var e = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: e,
            data: {
                vs1: 1
            },
            success: function(t) {
                t.data.data;
                a.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: a.data.baseinfo.base_tcolor,
                    backgroundColor: a.data.baseinfo.base_color
                }), wx.setNavigationBarTitle({
                    title: "拍卖中心"
                }), app.util.getUserInfo(a.getinfos, 0);
            }
        }), null == t.type || "" == t.type ? a.setData({
            type: 3
        }) : a.setData({
            type: t.type
        }), a.getindexpage();
    },
    serachInput: function(t) {
        this.setData({
            searchtitle: t.detail.value
        });
    },
    search: function() {
        var t = this.data.searchtitle;
        t ? wx.navigateTo({
            url: "/sudu8_page/search/search?paimai=1&title=" + t
        }) : wx.showModal({
            title: "提示",
            content: "请输入搜索内容！",
            showCancel: !1
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onShareAppMessage: function() {},
    auction_nav: function(t) {
        var a = t.currentTarget.dataset.id;
        this.setData({
            a: a
        });
    },
    remind: function() {
        this.setData({
            remind: 1
        });
    },
    hide_remind: function() {
        this.setData({
            remind: 0
        });
    },
    pagetogoodspage: function(t) {
        wx.navigateTo({
            url: "/sudu8_page_plugin_auction/auction_page/auction_page?id=" + t.currentTarget.id
        });
    },
    gotounbeginpage: function(t) {
        wx.navigateTo({
            url: "/sudu8_page_plugin_auction/auction_page/auction_page?id=" + t.currentTarget.id
        });
    },
    onPullDownRefresh: function() {
        this.getindexpage(), wx.stopPullDownRefresh();
    },
    timeapu: function() {
        var t = this;
        this.data.auction;
        clearInterval(this.data.timeapu), t.timeapu_fast();
        var a = setInterval(function() {
            t.timeapu_fast();
        }, 1e3);
        this.setData({
            timeapu: a
        });
    },
    timeapu_fast: function() {
        for (var t = this.data.auction, a = 0; a < t.length; a++) {
            var e = t[a].time;
            t[a].time = e - 1;
            var i = e % 60, n = (e - i) % 3600 / 60, o = (e - i - 60 * n) % 86400 / 3600, u = (e - i - 60 * n - 3600 * o) / 86400;
            t[a].timetostr = u + "天" + o + ":" + n + ":" + i;
        }
        this.setData({
            auction: t
        });
    },
    getinfos: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                });
                a.data.id;
            }
        });
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    getindexpage: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/getappindex",
            data: {
                type: a.data.type
            },
            success: function(t) {
                a.setData({
                    auction: t.data.list
                }), wx.stopPullDownRefresh(), a.timeapu();
            },
            fail: function(t) {}
        });
    },
    changecid: function(t) {
        wx.navigateTo({
            url: "../list/list?cid=" + t.currentTarget.id
        });
    }
});