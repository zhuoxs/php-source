var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        list: [ {
            tel: "2825528256",
            imgSrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152634825519.png",
            adress: "厦门市思明65",
            goods_shop: "柚子KTV集美店1"
        }, {
            tel: "1213",
            imgSrc: "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152634825519.png",
            adress: "5厦门市思明区帝豪大夏626",
            goods_shop: "柚子KTV集美店2"
        } ]
    },
    onLoad: function(t) {},
    onShow: function() {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), n.setData({
                    url: t.data
                });
            }
        }), wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var a = t.longitude, e = t.latitude;
                app.util.request({
                    url: "entry/wxapp/building",
                    cachetime: "0",
                    data: {
                        lon: a,
                        lat: e
                    },
                    success: function(t) {
                        console.log(t.data), n.setData({
                            build: t.data
                        });
                    }
                });
            }
        });
    },
    goInndetail: function(t) {
        var a = this, e = a.data.build, n = t.currentTarget.dataset.index, i = e[n].id, o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/SwitchBranch",
            cachetime: "0",
            data: {
                id: i,
                openid: o
            },
            success: function(t) {
                1 == t.data && (e[n].switch = 1, a.setData({
                    build: e
                }), wx.reLaunch({
                    url: "/ymktv_sun/pages/booking/index/index"
                }), wx.setStorageSync("isSwitch", 1), wx.setStorageSync("bid", i));
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});