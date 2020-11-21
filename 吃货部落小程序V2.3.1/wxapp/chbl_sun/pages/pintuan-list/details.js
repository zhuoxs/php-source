var app = getApp(), tool = require("../../../we7/js/countDown.js");

Page({
    data: {
        joinGroup: !0,
        hideShopPopup: !0,
        banners: [ "../../resource/images/first/dw.png" ],
        indicatorDots: !0,
        autoplay: !0,
        interval: 3e3,
        duration: 1e3,
        circular: !0
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), console.log(t);
        var o = this, a = t.id, e = wx.getStorageSync("url");
        wx.getStorageSync("latitude"), wx.getStorageSync("longitude");
        o.setData({
            url: e,
            system: wx.getStorageSync("system")
        }), app.get_location().then(function(t) {
            app.util.request({
                url: "entry/wxapp/groupsDetails",
                cachetime: "30",
                data: {
                    id: a,
                    latitude: t.latitude,
                    longitude: t.longitude
                },
                success: function(a) {
                    console.log(a);
                    var e = a.data.data, n = setInterval(function() {
                        var t = tool.countDown(o, e.endtime);
                        t ? e.clock = t[0] + " 天 " + t[1] + " 时 " + t[3] + "分 " + t[4] + "秒 " : (e.clock = " 0 天 0 时 0 分 0 秒 ", 
                        clearInterval(n)), o.setData({
                            details: a.data.data
                        });
                    }, 1e3);
                    o.setData({
                        details: a.data.data
                    });
                }
            });
        }), app.util.request({
            url: "entry/wxapp/userGroupsList",
            cachetime: "30",
            data: {
                id: a
            },
            success: function(t) {
                console.log(t);
                t.data.data;
                o.setData({
                    groupsList: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/partnumgroups",
            cachetime: "30",
            data: {
                id: a
            },
            success: function(t) {
                console.log(t), wx.setStorageSync("partnum", t.data.data.length), o.setData({
                    partnum: t.data.data
                });
            }
        });
    },
    joinGroup: function(t) {
        this.setData({
            joinGroup: !1
        });
    },
    closeWelfare: function(t) {
        this.setData({
            joinGroup: !0
        });
    },
    closePopupTap: function(t) {
        this.setData({
            hideShopPopup: !0
        });
    },
    bindGuiGeTap: function() {
        this.setData({
            hideShopPopup: !1
        });
    },
    labelItemTap: function(t) {
        console.log(t);
        var a = t.currentTarget.dataset.propertychildindex;
        this.setData({
            currentIndex: a,
            currentName: t.currentTarget.dataset.propertychildname
        });
    },
    labelItemTaB: function(t) {
        console.log(t);
        var a = t.currentTarget.dataset.propertychildindex;
        this.setData({
            currentSel: a,
            currentNamet: t.currentTarget.dataset.propertychildname
        });
    },
    numJianTap: function() {
        if (this.data.buyNumber > this.data.buyNumMin) {
            var t = this.data.buyNumber;
            t--, this.setData({
                buyNumber: t
            });
        }
    },
    numJiaTap: function() {
        if (this.data.buyNumber < this.data.buyNumMax) {
            var t = this.data.buyNumber;
            t++, this.setData({
                buyNumber: t
            });
        }
    },
    buyNowGroups: function(a) {
        console.log(a);
        var t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/isBuyGroups",
            cachetime: "0",
            data: {
                id: a.currentTarget.dataset.id,
                openid: t
            },
            success: function(t) {
                1 == t.data ? wx.showToast({
                    title: "您的商品正在拼团中...",
                    icon: "none"
                }) : wx.navigateTo({
                    url: "../to-pay-bargain/index?id=" + a.currentTarget.dataset.id + "&pid=" + a.currentTarget.dataset.pid
                });
            }
        });
    },
    buyNow: function(t) {
        console.log(t), wx.navigateTo({
            url: "../to-pay-bargain/index?id=" + t.currentTarget.dataset.id + "&pid=" + t.currentTarget.dataset.pid
        });
    },
    goPintuan: function(t) {
        wx.navigateTo({
            url: "../pintuan-list/goCantuan?id=" + t.currentTarget.dataset.id + "&openid=" + t.currentTarget.dataset.openid + "&jiren=" + t.currentTarget.dataset.jiren
        });
    },
    makeCall: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.tel
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});