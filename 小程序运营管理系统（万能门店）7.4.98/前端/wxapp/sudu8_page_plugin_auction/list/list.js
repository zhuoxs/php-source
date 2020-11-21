var _Page;

function _defineProperty(t, a, i) {
    return a in t ? Object.defineProperty(t, a, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = i, t;
}

var u = require("../../sudu8_page/resource/js/util.js"), app = getApp();

Page((_defineProperty(_Page = {
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
        var i = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: i,
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
                    title: "拍卖中"
                }), app.util.getUserInfo(a.getinfos, 0);
            }
        }), null == t.cid ? a.setData({
            cid: 0
        }) : a.setData({
            cid: t.cid
        }), a.getauctionlist(1), a.setData({
            pagey: 1
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onReachBottom: function() {},
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
    unbegin: function(t) {
        this.getauctionlist(0), this.auction_nav(t), wx.setNavigationBarTitle({
            title: "未开始"
        });
    },
    begin: function(t) {
        this.getauctionlist(1);
        this.auction_nav(t), wx.setNavigationBarTitle({
            title: "拍卖中"
        });
    },
    passlist: function(t) {
        this.getauctionlist(2);
        this.auction_nav(t), wx.setNavigationBarTitle({
            title: "已成交"
        });
    },
    unpasslist: function(t) {
        this.getauctionlist(3);
        this.auction_nav(t), wx.setNavigationBarTitle({
            title: "流拍"
        });
    },
    getauctionlist: function(t) {
        if (!(this.data.cid < 0)) {
            var i = this;
            i.setData({
                auction: {}
            }), app.util.request({
                url: "entry/wxapp/auctionlist",
                data: {
                    vs1: 1,
                    stat: t,
                    pagey: 1,
                    cid: i.data.cid
                },
                success: function(t) {
                    var a = Date.parse(new Date()) / 1e3;
                    i.setData({
                        auction: t.data.data.list,
                        pagey: 1,
                        nowtime: a
                    }), wx.stopPullDownRefresh(), i.timeapu();
                },
                fail: function(t) {}
            });
        }
    },
    gotounbeginpage: function(t) {
        wx.navigateTo({
            url: "/sudu8_page_plugin_auction/auction_page/auction_page?id=" + t.currentTarget.id
        });
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, i = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, i);
    },
    onPullDownRefresh: function() {
        var t = this.data.a, a = 1;
        2 == t && (a = 0), 3 == t && (a = 2), 4 == t && (a = 3), this.getauctionlist(a), 
        wx.stopPullDownRefresh();
    }
}, "onReachBottom", function() {
    if (this.data.cid < 0) this.getindexpage(); else {
        var t = this.data.a, a = 1;
        2 == t && (a = 0), 3 == t && (a = 2), 4 == t && (a = 3);
        var i = a, e = this.data.pagey + 1, n = this;
        app.util.request({
            url: "entry/wxapp/auctionlist",
            data: {
                vs1: 1,
                stat: i,
                pagey: e
            },
            success: function(t) {
                clearInterval(n.data.timeapu), "nothing" != t.data.errno && n.setData({
                    auction: n.data.auction.concat(t.data.data.list),
                    pagey: e
                }), n.timeapu();
            },
            fail: function(t) {}
        });
    }
}), _defineProperty(_Page, "timeapu", function() {
    var t = this;
    this.data.auction;
    clearInterval(this.data.timeapu), t.timeapu_fast();
    var a = setInterval(function() {
        t.timeapu_fast();
    }, 1e3);
    this.setData({
        timeapu: a
    });
}), _defineProperty(_Page, "timeapu_fast", function() {
    for (var t = this.data.auction, a = 0; a < t.length; a++) {
        var i = t[a].time;
        i < 1 && (1 == this.data.a && this.itsfinish(t[a].id), t.splice(a, 1));
        var e = i % 60, n = (i - e) % 3600 / 60, o = (i - e - 60 * n) % 86400 / 3600, s = (i - e - 60 * n - 3600 * o) / 86400;
        t[a].time -= 1, t[a].timetostr = s + "天" + o + ":" + n + ":" + e;
    }
    this.setData({
        auction: t
    });
}), _defineProperty(_Page, "itsfinish", function(t) {
    app.util.request({
        url: "entry/wxapp/auctionthisok",
        data: {
            vs1: 1,
            goodsid: t
        },
        success: function(t) {},
        fail: function(t) {}
    });
}), _defineProperty(_Page, "getinfos", function() {
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
}), _Page));