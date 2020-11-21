var app = getApp();

function getWeRunData(t) {
    wx.getWeRunData({
        success: function(a) {
            console.log(a), app.util.request({
                url: "entry/wxapp/sport",
                showLoading: !1,
                method: "POST",
                data: {
                    op: "getWeRunData",
                    encryptedData: a.encryptedData,
                    iv: a.iv
                },
                success: function(a) {
                    console.log(a), app.look.ok("更新成功"), t.setData({
                        step: a.data.data.step
                    }), wx.setStorageSync("weRunData", a.data.data);
                },
                fail: function(a) {
                    app.look.no(a.data.message);
                }
            });
        }
    });
}

Page({
    data: {
        step: 0,
        showSuccessful: !1,
        join: [ {
            img: "../../images/sport-img.png"
        }, {
            img: "../../images/sport-img.png"
        } ],
        challenge: []
    },
    update: function() {
        getWeRunData(this);
        var a = this, t = wx.createAnimation({
            duration: 500,
            timingFunction: "linear"
        });
        (a.animation = t).rotate(720 * Math.random() - 360).step(), a.setData({
            animationData: t.export()
        }), setTimeout(function() {
            t.rotate(0).step(), a.setData({
                animationData: t.export()
            });
        }, 500);
    },
    sportRemind: function(a) {
        var t = 0;
        t = a.detail.value ? 1 : -1, app.util.request({
            url: "entry/wxapp/sport",
            showLoading: !1,
            method: "POST",
            data: {
                op: "sport_remind",
                status: t
            },
            success: function(a) {
                app.globalData.userInfo.sport_remind = t;
            }
        });
    },
    onLoad: function(a) {
        var p = this;
        this.setData({
            "goHome.blackhomeimg": app.globalData.blackhomeimg
        }), app.util.request({
            url: "entry/wxapp/sport",
            showLoading: !1,
            method: "POST",
            data: {
                op: "index"
            },
            success: function(a) {
                var t = a.data;
                console.log(t), t.data.good && p.setData({
                    good: t.data.good
                }), t.data.pageset && (p.setData({
                    sportSet: t.data.pageset
                }), app.sportSet = t.data.pageset);
                var e = [ 1, 1, 1, 1, 1, 1, 1 ];
                if (t.data.avatars) {
                    for (var o = t.data.avatars.length, s = 0; s < o; s++) e.splice(s, 1);
                    p.setData({
                        avatars: t.data.avatars
                    });
                }
                p.setData({
                    coin: t.data.coin,
                    noavatar: e
                });
            }
        });
    },
    toChange: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/sport",
            showLoading: !1,
            method: "POST",
            data: {
                op: "stepChangeCoin",
                step: t.data.step
            },
            success: function(a) {
                t.setData({
                    shadow: !0,
                    showSuccessful: !0,
                    changeCoin: a.data.data,
                    coin: parseInt(t.data.coin) + parseInt(a.data.data),
                    steps: t.data.step,
                    step: 0
                });
            },
            fail: function(a) {
                app.look.no(a.data.message);
            }
        });
    },
    close: function() {
        this.setData({
            shadow: !1,
            showSuccessful: !1
        });
    },
    onReady: function() {
        app.look.sport_footer(this), app.look.accredit(this);
        var a = {};
        a.sport_icon = app.module_url + "resource/wxapp/sport/sport-icon.png", a.sport_warn = app.module_url + "resource/wxapp/sport/sport-warn.png", 
        a.sport_today = app.module_url + "resource/wxapp/sport/sport-today.png", a.walk = app.module_url + "resource/wxapp/sport/walk.png", 
        a.sysn = app.module_url + "resource/wxapp/sport/sysn.png", a.step_change_bg = app.module_url + "resource/wxapp/sport/step-change-bg.png", 
        a.step_share_bg = app.module_url + "resource/wxapp/sport/step-share-bg.png", a.sport_change = app.module_url + "resource/wxapp/sport/sport-change.png", 
        a.sport_invite = app.module_url + "resource/wxapp/sport/sport-invite.png", a.cha_success = app.module_url + "resource/wxapp/sport/cha-success.png", 
        a.step_success = app.module_url + "resource/wxapp/sport/step-success.png", this.setData({
            images: a,
            sport_remind: app.globalData.userInfo.sport_remind,
            sport_friend_rate: app.globalData.webset.sport_friend_rate
        });
        getWeRunData(this);
    },
    onGotUserInfo: function(a) {
        app.look.getuserinfo(a, this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var p = this;
        app.util.request({
            url: "entry/wxapp/sport",
            showLoading: !0,
            method: "POST",
            data: {
                op: "index"
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                t.data.good && p.setData({
                    good: t.data.good
                }), t.data.pageset && (p.setData({
                    sportSet: t.data.pageset
                }), app.sportSet = t.data.pageset);
                var e = [ 1, 1, 1, 1, 1, 1, 1 ];
                if (t.data.avatars) {
                    for (var o = t.data.avatars.length, s = 0; s < o; s++) e.splice(s, 1);
                    p.setData({
                        avatars: t.data.avatars
                    });
                }
                p.setData({
                    coin: t.data.coin,
                    noavatar: e
                });
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var a = "", t = "";
        null != app.sportSet && (app.look.istrue(app.sportSet.share_title) && (a = app.sportSet.share_title), 
        app.look.istrue(app.sportSet.share_img) && (t = app.sportSet.share_img));
        var e = "/xc_xinguwu/sport/sport/sport";
        return {
            title: a,
            path: "/xc_xinguwu/pages/base/base?share=" + (e = encodeURIComponent(e)) + "&userid=" + app.globalData.userInfo.id + "&type=sport",
            imageUrl: t,
            success: function(a) {
                that.hideshare(), wx.showToast({
                    title: "转发成功"
                });
            },
            fail: function(a) {}
        };
    }
});