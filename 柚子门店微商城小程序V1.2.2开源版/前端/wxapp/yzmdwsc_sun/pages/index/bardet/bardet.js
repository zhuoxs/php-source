var _Page;

function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var tool = require("../../../../style/utils/countDown.js"), app = getApp();

Page((_defineProperty(_Page = {
    data: {
        navTile: "商品详情",
        showModalStatus: !1,
        join: 0,
        imgsrc: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264601.png",
        title: "发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽",
        price: "100",
        minPrice: "68",
        surplus: "100",
        startTime: "2017-12-12 00:00:00",
        endTime: "2018-06-01 00:00:00",
        imgArr: [ "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264579.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15254126459.png", "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264601.png" ],
        bargainList: [ {
            endTime: "1527782400000",
            clock: ""
        } ],
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var n = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: n.data.navTile
        });
        var e = t.gid;
        n.setData({
            gid: e
        }), wx.setStorageSync("kanjiaid", e);
        var i = wx.getStorageSync("openid");
        n.setData({
            url: wx.getStorageSync("url")
        }), app.util.request({
            url: "entry/wxapp/GoodsDetails",
            cachetime: "0",
            data: {
                id: e
            },
            success: function(e) {
                var a;
                n.setData({
                    goodinfo: e.data.data,
                    openid: i
                });
                setInterval(function() {
                    var t = tool.countDown(n, e.data.data.endtime);
                    a = t ? "距离结束还剩：" + t[0] + "天" + t[1] + "时" + t[3] + "分" + t[4] + "秒" : "00 : 00 : 00", 
                    n.setData({
                        clock: a
                    });
                }, 1e3);
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = wx.getStorageSync("kanjiaid"), e = wx.getStorageSync("openid");
        this.getUserInfo();
        var a = this;
        app.util.request({
            url: "entry/wxapp/iskanjia",
            cachetime: "0",
            data: {
                openid: e,
                id: t
            },
            success: function(t) {
                a.setData({
                    iskanjia: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/myBargain",
            cachetime: "0",
            data: {
                openid: e,
                id: t
            },
            success: function(t) {
                a.setData({
                    mybargain: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/friendsImg",
            cachetime: "0",
            data: {
                openid: e,
                id: t
            },
            success: function(t) {
                a.setData({
                    Img: t.data.data
                });
            }
        });
    },
    getUserInfo: function() {
        var e = this;
        wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(t) {
                        e.setData({
                            userInfo: t.userInfo
                        });
                    }
                });
            }
        });
    }
}, "onReady", function() {}), _defineProperty(_Page, "onHide", function() {}), _defineProperty(_Page, "onUnload", function() {}), 
_defineProperty(_Page, "onPullDownRefresh", function() {}), _defineProperty(_Page, "onReachBottom", function() {}), 
_defineProperty(_Page, "onShareAppMessage", function(t) {
    var e = wx.getStorageSync("openid"), a = wx.getStorageSync("kanjiaid");
    console.log(e), console.log(a);
    var n = wx.getStorageSync("settings");
    return console.log(n), console.log("分销"), console.log(t), "button" === t.from && console.log(t), 
    {
        title: n.bargain_title,
        path: "yzmdwsc_sun/pages/index/help/help?id=" + a + "&openid=" + e,
        success: function(t) {
            console.log("转发成功");
        },
        fail: function(t) {
            console.log("转发失败");
        }
    };
}), _defineProperty(_Page, "order", function(t) {}), _defineProperty(_Page, "bargain", function(t) {}), 
_defineProperty(_Page, "powerDrawer1", function(t) {
    var e = t.currentTarget.dataset.statu;
    this.util(e);
}), _defineProperty(_Page, "powerDrawer", function(t) {
    var e = t.currentTarget.dataset.statu, a = t.currentTarget.dataset.join;
    this.setData({
        join: a
    });
    var n = this, i = t.currentTarget.dataset.gid, o = wx.getStorageSync("openid");
    app.util.request({
        url: "entry/wxapp/checkGoods",
        cachetime: "0",
        data: {
            gid: i
        },
        success: function(t) {
            app.util.request({
                url: "entry/wxapp/NowBargain",
                cachetime: "0",
                data: {
                    id: i,
                    openid: o
                },
                success: function(t) {
                    1 == t.errno || (n.util(e), n.setData({
                        hideShopPopup: !1,
                        myprice: t.data,
                        iskanjia: !0
                    }), app.util.request({
                        url: "entry/wxapp/myBargain",
                        cachetime: "0",
                        data: {
                            openid: o,
                            id: i
                        },
                        success: function(t) {
                            n.setData({
                                mybargain: t.data.data
                            });
                        }
                    }));
                }
            });
        }
    });
}), _defineProperty(_Page, "util", function(t) {
    var e = wx.createAnimation({
        duration: 200,
        timingFunction: "linear",
        delay: 0
    });
    (this.animation = e).opacity(0).height(0).step(), this.setData({
        animationData: e.export()
    }), setTimeout(function() {
        e.opacity(1).height("488rpx").step(), this.setData({
            animationData: e
        }), "close" == t && this.setData({
            showModalStatus: !1
        });
    }.bind(this), 200), "open" == t && this.setData({
        showModalStatus: !0
    });
}), _defineProperty(_Page, "help", function(t) {
    wx.updateShareMenu({
        withShareTicket: !0,
        success: function() {}
    });
}), _defineProperty(_Page, "toCforder", function(a) {
    var n = a.currentTarget.dataset.gid, i = wx.getStorageSync("kanjiaid"), o = wx.getStorageSync("openid");
    app.util.request({
        url: "entry/wxapp/Expire",
        cachetime: "0",
        data: {
            id: i
        },
        success: function(t) {
            var e = t.data.data;
            app.util.request({
                url: "entry/wxapp/buyed",
                cachetime: "0",
                data: {
                    id: i,
                    openid: o
                },
                success: function(t) {
                    2 == t.data ? 1 == e ? app.util.request({
                        url: "entry/wxapp/checkGoods",
                        cachetime: "0",
                        data: {
                            gid: n
                        },
                        success: function(t) {
                            wx.navigateTo({
                                url: "../cforder-bargain/cforder-bargain?gid=" + a.currentTarget.dataset.gid
                            });
                        }
                    }) : wx.showToast({
                        title: "活动已结束！感谢参与！",
                        icon: "none"
                    }) : wx.showToast({
                        title: "您已购买该商品，不要贪心哦！",
                        icon: "none"
                    });
                }
            });
        }
    });
}), _defineProperty(_Page, "toIndex", function(t) {
    wx.redirectTo({
        url: "../index"
    });
}), _Page));