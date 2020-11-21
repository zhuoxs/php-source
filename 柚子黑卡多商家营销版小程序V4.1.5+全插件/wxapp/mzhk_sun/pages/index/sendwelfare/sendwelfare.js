var app = getApp();

Page({
    data: {
        navTile: "优惠券转赠",
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        welfareList: [],
        url: [],
        viptype: "0",
        is_modal_Hidden: !0
    },
    onLoad: function(e) {
        var t = this;
        wx.setNavigationBarTitle({
            title: t.data.navTile
        });
        e.id;
        var a = e.uid ? e.uid : "", n = e.ucid ? e.ucid : "";
        t.setData({
            id: e.id,
            sendopenid: a,
            ucid: n
        });
        var i = app.getSiteUrl();
        i ? t.setData({
            url: i
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), i = e.data, t.setData({
                    url: i
                });
            }
        }), app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(e) {
                wx.setNavigationBarColor({
                    frontColor: e.data.fontcolor ? e.data.fontcolor : "",
                    backgroundColor: e.data.color ? e.data.color : "",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                });
            }
        });
    },
    onReady: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/welfare",
            method: "GET",
            data: {
                id: t.data.id
            },
            success: function(e) {
                t.setData({
                    welfareList: e.data
                });
            }
        });
    },
    toIndex: function(e) {
        wx.redirectTo({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    onShow: function() {
        var t = this;
        app.func.islogin(app, t), t.getUrl();
        var e = wx.getStorageSync("openid"), a = t.data.sendopenid;
        e == a && wx.showModal({
            title: "提示",
            content: "自己无法领取自己的优惠券",
            showCancel: !1,
            success: function(e) {
                wx.redirectTo({
                    url: "/mzhk_sun/pages/index/index"
                });
            }
        }), app.util.request({
            url: "entry/wxapp/isreceived",
            data: {
                id: t.data.id,
                sendopenid: a,
                ucid: t.data.ucid,
                openid: e
            },
            header: {
                "content-type": "application/json"
            },
            success: function(e) {
                console.log(e), 0 < e.data ? t.setData({
                    receive: 1
                }) : t.setData({
                    receive: 0
                });
            },
            fail: function(e) {
                wx.showModal({
                    title: "提示信息",
                    content: e.data.message,
                    showCancel: !1,
                    success: function(e) {
                        wx.redirectTo({
                            url: "/mzhk_sun/pages/index/index"
                        });
                    }
                });
            }
        });
    },
    getUrl: function() {
        var t = this, a = app.getSiteUrl();
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
        });
    },
    callphone: function(e) {
        var t = e.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    toMember: function(e) {
        wx.redirectTo({
            url: "../../member/member"
        });
    },
    receive: function(e) {
        var t = this, a = (t.data.welfareList, t.data.id), n = t.data.sendopenid, i = wx.getStorageSync("openid"), o = t.data.receive;
        0 == o ? app.util.request({
            url: "entry/wxapp/Counpsendadd",
            cachetime: "30",
            data: {
                id: a,
                sendopenid: n,
                ucid: t.data.ucid,
                openid: i
            },
            header: {
                "content-type": "application/json"
            },
            success: function(e) {
                t.setData({
                    receive: 1
                }), 2 == e.data.status ? wx.showToast({
                    title: "优惠券领取失败",
                    icon: "none",
                    duration: 1e3
                }) : wx.showToast({
                    title: "领取成功",
                    icon: "success",
                    duration: 1e3
                });
            },
            fail: function(e) {
                wx.showModal({
                    title: "提示信息",
                    content: e.data.message,
                    showCancel: !1,
                    success: function(e) {
                        wx.redirectTo({
                            url: "/mzhk_sun/pages/index/index"
                        });
                    }
                });
            }
        }) : wx.showToast({
            title: "优惠券已经被领取了~",
            icon: "none",
            duration: 1e3
        });
    },
    showmap: function(e) {
        var t = e.currentTarget.dataset.address, a = Number(e.currentTarget.dataset.longitude), n = Number(e.currentTarget.dataset.latitude);
        0 == a && 0 == n && wx.showToast({
            title: "该地址可能无法在地图上显示~",
            icon: "none",
            duration: 1e3
        }), wx.openLocation({
            name: t,
            latitude: n,
            longitude: a,
            scale: 18,
            address: t
        });
    },
    updateUserInfo: function(e) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});