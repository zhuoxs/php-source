var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        playBtn: !1,
        typeIndex: 0,
        numvalue: 1,
        goods: [ {
            imgSrc: [ "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/15259327809.png", "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152593278087.png", "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152593278084.png", "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152593278081.png", "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152593278074.png" ],
            name: "LUNA 洁面仪",
            msg: "明星网红都在用洁面仪",
            price: "1280.00",
            detail: "",
            typeName: "颜色",
            typeLise: [ "铁蓝色" ]
        } ]
    },
    onLoad: function(t) {
        var a = this, e = t.id;
        wx.setStorageSync("id", e), app.util.request({
            url: "entry/wxapp/GiftsDetail",
            data: {
                id: e
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    goods: t.data
                }), a.getUrl();
            }
        });
        this.data.isLogin;
        wx.getStorageSync("openid") ? wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(t) {
                        a.setData({
                            isLogin: !1,
                            userInfo: t.userInfo
                        });
                    }
                });
            }
        }) : a.setData({
            isLogin: !0
        });
    },
    bindGetUserInfo: function(t) {
        var e = this;
        wx.setStorageSync("user_info", t.detail.userInfo);
        var n = t.detail.userInfo.nickName, i = t.detail.userInfo.avatarUrl;
        wx.login({
            success: function(t) {
                var a = t.code;
                console.log(a), app.util.request({
                    url: "entry/wxapp/openid",
                    cachetime: "0",
                    data: {
                        code: a
                    },
                    success: function(t) {
                        console.log(t), wx.setStorageSync("key", t.data.session_key), wx.setStorageSync("openid", t.data.openid);
                        var a = t.data.openid;
                        app.util.request({
                            url: "entry/wxapp/Login",
                            cachetime: "0",
                            data: {
                                openid: a,
                                img: i,
                                name: n
                            },
                            success: function(t) {
                                console.log(t), e.setData({
                                    isLogin: !1
                                }), wx.setStorageSync("users", t.data), wx.setStorageSync("uniacid", t.data.uniacid);
                            }
                        });
                    }
                });
            }
        });
    },
    getUrl: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        var a = wx.getStorageSync("id");
        return "button" === t.from && console.log(t.target), {
            title: "求礼物求礼物求礼物，重要的事情说三遍~",
            path: "/yzcj_sun/pages/gift/giftlistdetail/giftlistdetail?id=" + a
        };
    },
    gohome: function() {
        wx.reLaunch({
            url: "../../ticket/ticketmiannew/ticketmiannew"
        });
    },
    changeIndex: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            typeIndex: a
        });
    },
    addnum: function(t) {
        var a = this, e = a.data.numvalue + 1, n = a.data.goods.count;
        Number(e) > Number(n) ? a.setData({
            numvalue: conut
        }) : a.setData({
            numvalue: e
        });
    },
    subbnum: function(t) {
        var a = this, e = a.data.numvalue - 1;
        Number(e) < 0 ? a.setData({
            numvalue: 1
        }) : a.setData({
            numvalue: e
        });
    },
    count: function(t) {
        var a = t.detail.value, e = this.data.goods.count;
        "" == a ? this.setData({
            numvalue: 0
        }) : Number(a) > Number(e) ? this.setData({
            numvalue: e
        }) : this.setData({
            numvalue: a
        });
    },
    submitBtn: function() {
        var t = this, a = t.data.goods, e = (t.data.typeIndex, t.data.numvalue), n = {
            id: a.id,
            name: a.gname,
            imgSrc: a.pic[0],
            price: a.price,
            num: e,
            count: a.count
        };
        0 == t.data.numvalue ? (wx.showToast({
            title: "数量不得为零！",
            icon: "none",
            duration: 2e3
        }), t.setData({
            numvalue: 1
        })) : (wx.setStorageSync("shopcart", n), t.setData({
            playBtn: !1
        }), wx.reLaunch({
            url: "../giftindex/giftindex"
        }));
    },
    opendPlay: function() {
        this.setData({
            playBtn: !0
        });
    },
    closePlay: function() {
        this.setData({
            playBtn: !1
        });
    }
});