var app = getApp(), Page = require("../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        curIndex: -1,
        whichone: 2
    },
    onLoad: function(a) {
        app.editTabBar(), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var t = this;
        t.newurl(), app.util.request({
            url: "entry/wxapp/Category",
            cachetime: "0",
            success: function(a) {
                t.setData({
                    cate: a.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "0",
            success: function(a) {
                t.setData({
                    poster: a.data
                }), wx.setStorageSync("goodspicbg", a.data.goodspicbg);
            }
        });
    },
    newurl: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(a) {
                wx.setStorageSync("url2", a.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(a) {
                wx.setStorageSync("url", a.data), t.setData({
                    url: a.data
                });
            }
        });
    },
    onReady: function() {
        app.getNavList("");
    },
    onShow: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Allcate",
            cachetime: "0",
            success: function(a) {
                t.setData({
                    cateDa: a.data.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    cateTap: function(a) {
        var t = this;
        t.newurl();
        var e = parseInt(a.currentTarget.dataset.index);
        t.setData({
            curIndex: e,
            index: e
        });
        var n = "";
        n = -1 == e ? "" : a.currentTarget.dataset.id, app.util.request({
            url: "entry/wxapp/CateId",
            cachetime: "0",
            data: {
                id: n
            },
            success: function(a) {
                console.log(a.data.data), t.setData({
                    cateData: a.data.data
                });
            }
        });
    },
    toDetail: function(a) {
        console.log(a);
        var t = this, e = t.data.curIndex, n = a.currentTarget.dataset.index, o = a.currentTarget.dataset.id, r = a.currentTarget.dataset.pic, c = wx.getStorageSync("build_id");
        if (console.log("你的图片是多少" + r), -1 == e) var i = t.data.cateDa[n].goods_name; else i = t.data.cateData[n].goods_name;
        console.log(i), wx.navigateTo({
            url: "detail/detail?id=" + o + "&name=" + i + "&pic=" + r + "&build_id=" + c
        });
    }
});