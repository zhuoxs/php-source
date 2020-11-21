var app = getApp(), WxParse = require("../../wxParse/wxParse.js"), Page = require("../../../sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        shop: {
            shopImg: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg",
            shopName: "贵族世家"
        },
        title: "文章标题文章标题文章标题文章标题文章标题文章标题文章标题文章标题文章标题",
        time: "2018-05-16",
        watch: "110",
        comment: "10",
        good: "122",
        isGood: !1,
        videoSrc: "http://www.w3school.com.cn/i/movie.ogg",
        newsinfo: [],
        is_modal_Hidden: !0
    },
    onLoad: function(e) {
        var t = this, n = e.id;
        n <= 0 || !n ? wx.showModal({
            title: "提示",
            content: "参数错误，获取不到商品，点击确认跳转到首页",
            showCancel: !1,
            success: function(e) {
                wx.reLaunch({
                    url: "/mzhk_sun/pages/index/index"
                });
            }
        }) : t.setData({
            id: n
        });
        var a = app.getSiteUrl();
        a ? t.setData({
            url: a
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), a = e.data, t.setData({
                    url: a
                });
            }
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor ? wx.getStorageSync("System").fontcolor : "",
            backgroundColor: wx.getStorageSync("System").color ? wx.getStorageSync("System").color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.wxauthSetting();
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        app.func.islogin(app, a);
        var e = a.data.id, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/GetNewsinfo",
            data: {
                id: e,
                openid: t
            },
            success: function(e) {
                var t = e.data;
                if (console.log("专题数据"), console.log(t), 2 == t) return wx.showModal({
                    title: "提示",
                    content: "参数错误，获取不到，点击确认跳转到首页",
                    showCancel: !1,
                    success: function(e) {
                        wx.reLaunch({
                            url: "/mzhk_sun/pages/index/index"
                        });
                    }
                }), !1;
                wx.setNavigationBarTitle({
                    title: t.title
                }), a.setData({
                    newsinfo: t
                });
                var n = e.data.content;
                WxParse.wxParse("content", "html", n, a, 10);
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        console.log("分享");
        var e = this.data.newsinfo;
        return {
            title: e.title,
            path: "mzhk_sun/pages/index/article/article?id=" + e.id,
            success: function(e) {
                console.log("转发成功");
            }
        };
    },
    clickGood: function(e) {
        var t = this, n = t.data.id, a = t.data.newsinfo, o = wx.getStorageSync("openid");
        if (1 == a.stlike) return wx.showToast({
            title: "你已经点过赞了",
            icon: "none",
            duration: 500
        }), !1;
        app.util.request({
            url: "entry/wxapp/addNewslike",
            cachetime: "30",
            data: {
                id: n,
                openid: o
            },
            success: function(e) {
                a.stlike = 1, a.likenum = parseInt(a.likenum) + 1, t.setData({
                    newsinfo: a,
                    isGood: !t.data.isGood
                });
            }
        });
    },
    toShop: function(e) {
        var t = e.currentTarget.dataset.bid;
        wx.navigateTo({
            url: "../shop/shop?id=" + t
        });
    },
    toActive: function(e) {
        var t, n = e.currentTarget.dataset.gid, a = e.currentTarget.dataset.lid;
        t = 3 == a ? "/mzhk_sun/pages/index/groupdet/groupdet?id=" + n : 2 == a ? "/mzhk_sun/pages/index/bardet/bardet?id=" + n : 4 == a ? "/mzhk_sun/pages/index/cardsdet/cardsdet?gid=" + n : 1 == a ? "/mzhk_sun/pages/index/goods/goods?gid=" + n : 6 == a ? "/mzhk_sun/pages/index/freedet/freedet?id=" + n : "/mzhk_sun/pages/index/package/package?id=" + n, 
        wx.redirectTo({
            url: t
        });
    },
    updateUserInfo: function(e) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});