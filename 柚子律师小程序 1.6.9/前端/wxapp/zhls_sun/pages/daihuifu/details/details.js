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
        var a = t.fid;
        wx.setStorageSync("fid", a), console.log(a), a && wx.setNavigationBarTitle({
            title: "我的付费咨询"
        });
    },
    toAsk: function(t) {
        this.askText();
    },
    pushAsk: function(t) {
        console.log(t), this.setData({
            contents: t.detail.value
        }), console.log(this.data.askList), this.setData({
            hideShopPopup: !1
        });
    },
    pushAfter: function(t) {
        var a = this, o = a.data.contents, e = t.currentTarget.dataset.fid;
        e && app.util.request({
            url: "entry/wxapp/Lawtianswer",
            cachetime: "0",
            data: {
                fid: e,
                content: o
            },
            success: function(t) {
                console.log(t.data), a.setData({
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
        var a = this, o = t.currentTarget.dataset.fid;
        0 < a.data.star ? o && wx.getStorage({
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
        }) : wx.showToast({
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
        var a = this, t = wx.getStorageSync("fid");
        app.util.request({
            url: "entry/wxapp/lawyeranswer",
            cachetime: "0",
            data: {
                fid: t
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    mzData: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/lawyerAsk",
            cachetime: "0",
            data: {
                fid: t
            },
            success: function(t) {
                a.setData({
                    askList: t.data
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