var app = getApp();

Page({
    data: {
        hideShopPopup: !0,
        hideStarBox: !0,
        starMap: [ "非常差", "差", "一般", "好", "非常好" ],
        star: 0
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var a = this, e = t.mid, o = t.fid;
        wx.setStorageSync("mid", e), wx.setStorageSync("fid", o), console.log(o), console.log(e), 
        e && wx.setNavigationBarTitle({
            title: "我的免费咨询"
        }), o && wx.setNavigationBarTitle({
            title: "我的付费咨询"
        }), wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/Usermiananswer",
                    cachetime: "0",
                    data: {
                        openid: t.data,
                        mid: e,
                        fid: o
                    },
                    success: function(t) {
                        console.log(t.data), a.setData({
                            mzData: t.data
                        });
                    }
                });
            }
        });
    },
    toAsk: function(t) {
        this.askText();
    },
    pushAsk: function(t) {
        console.log(t), this.setData({
            contents: t.detail.value
        }), console.log(this.data.askList);
    },
    pushAfter: function(t) {
        var a = this, e = a.data.contents, o = t.currentTarget.dataset.mid, n = t.currentTarget.dataset.fid;
        o && app.util.request({
            url: "entry/wxapp/MAskData",
            cachetime: "0",
            data: {
                mid: o,
                content: e
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    hideShopPopup: !0,
                    contents: ""
                }), a.onShow();
            }
        }), n && app.util.request({
            url: "entry/wxapp/PAskData",
            cachetime: "0",
            data: {
                fid: n,
                content: e
            },
            success: function(t) {
                a.setData({
                    hideShopPopup: !0,
                    contents: ""
                }), a.onShow();
            }
        });
    },
    commentStar: function(t) {
        console.log(this.data), this.starBox();
    },
    closePopupTap: function(t) {
        this.setData({
            hideShopPopup: !0
        });
    },
    myChooseStar: function(t) {
        console.log(t);
        var a = parseInt(t.target.dataset.star) || 0;
        this.setData({
            star: a
        });
    },
    deterTap: function(t) {
        var a = this, e = t.currentTarget.dataset.mid, o = t.currentTarget.dataset.fid;
        0 < a.data.star ? (e && wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/Mevaluate",
                    cachetime: "0",
                    data: {
                        openid: t.data,
                        mid: e,
                        star: a.data.star
                    },
                    success: function(t) {
                        wx.showToast({
                            title: "评价成功",
                            icon: "success",
                            duration: 2e3
                        }), a.setData({
                            hideStarBox: !0
                        }), a.onLoad();
                    }
                });
            }
        }), o && wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/Fevaluate",
                    cachetime: "0",
                    data: {
                        openid: t.data,
                        fid: o,
                        star: a.data.star
                    },
                    success: function(t) {
                        wx.showToast({
                            title: "评价成功",
                            icon: "success",
                            duration: 2e3
                        }), a.setData({
                            hideStarBox: !0
                        }), a.onLoad();
                    }
                });
            }
        })) : wx.showToast({
            title: "请评价星级",
            icon: "none",
            duration: 2e3
        });
    },
    deterTaps: function(t) {
        this.setData({
            hideStarBox: !0
        });
    },
    askText: function(t) {
        this.setData({
            hideShopPopup: !1
        });
    },
    starBox: function(t) {
        this.setData({
            hideStarBox: !1
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this, e = wx.getStorageSync("mid"), o = wx.getStorageSync("fid");
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/UsermianAsk",
                    cachetime: "0",
                    data: {
                        openid: t.data,
                        mid: e,
                        fid: o
                    },
                    success: function(t) {
                        console.log(t.data), a.setData({
                            askList: t.data
                        });
                    }
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});