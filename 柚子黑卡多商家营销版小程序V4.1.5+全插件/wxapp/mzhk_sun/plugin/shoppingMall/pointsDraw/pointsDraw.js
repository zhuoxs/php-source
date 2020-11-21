/*   time:2019-08-09 13:18:39*/
var app = getApp();
Page({
    data: {
        circleList: [],
        awardList: [],
        colorCircleFirst: "#FFDF2F",
        colorCircleSecond: "#FE4D32",
        colorAwardDefault: "#F5F0FC",
        colorAwardSelect: "#ffe400",
        indexSelect: 0,
        isRunning: !1,
        is_modal_Hidden: !0,
        imageAward: ["../../resource/images/pointsDraw/1.jpg", "../../resource/images/pointsDraw/2.jpg", "../../resource/images/pointsDraw/3.jpg", "../../resource/images/pointsDraw/4.jpg", "../../resource/images/pointsDraw/5.jpg", "../../resource/images/pointsDraw/6.jpg", "../../resource/images/pointsDraw/7.jpg", "../../resource/images/pointsDraw/8.jpg", "../../resource/images/pointsDraw/1.jpg"]
    },
    onLoad: function() {
        var e = this;
        app.wxauthSetting();
        var s = this;
        this.getSystem();
        for (var t = 7.5, a = 7.5, i = [], n = 0; n < 24; n++) {
            if (0 == n) t = a = 15;
            else if (n < 6) a = 7.5, t += 102.5;
            else if (6 == n) a = 15, t = 620;
            else if (n < 12) a += 94, t = 620;
            else if (12 == n) a = 565, t = 620;
            else if (n < 18) a = 570, t -= 102.5;
            else if (18 == n) a = 565, t = 15;
            else {
                if (!(n < 24)) return;
                a -= 94, t = 7.5
            }
            i.push({
                topCircle: a,
                leftCircle: t
            })
        }
        this.setData({
            circleList: i
        }), setInterval(function() {
            "#FFDF2F" == e.data.colorCircleFirst ? e.setData({
                colorCircleFirst: "#FE4D32",
                colorCircleSecond: "#FFDF2F"
            }) : e.setData({
                colorCircleFirst: "#FFDF2F",
                colorCircleSecond: "#FE4D32"
            })
        }, 500);
        var r = [],
            o = 25,
            c = 25;
        app.util.request({
            url: "entry/wxapp/getLotteryPrize",
            data: {
                m: app.globalData.Plugin_scoretask
            },
            showLoading: !1,
            success: function(e) {
                if ((e = e.data).data.length < 8) wx.showModal({
                    title: "系统信息",
                    content: "请先后台设置8个奖项",
                    showCancel: !1
                });
                else {
                    for (var t = 0; t < 8; t++) {
                        0 == t ? c = o = 25 : t < 3 ? (o = o, c = c + 166.6666 + 15) : t < 5 ? (c = c, o = o + 150 + 15) : t < 7 ? (c = c - 166.6666 - 15, o = o) : t < 8 && (c = c, o = o - 150 - 15);
                        var a = e.other.img_root + e.data[t].pic;
                        r.push({
                            topAward: o,
                            leftAward: c,
                            imageAward: a
                        })
                    }
                    s.setData({
                        awardList: r
                    })
                }
            }
        })
    },
    startGame: function() {
        var s = this;
        if (!this.data.isRunning) {
            this.setData({
                isRunning: !0
            });
            var i = this,
                n = 0,
                r = 0,
                t = wx.getStorageSync("users").openid;
            app.util.request({
                url: "entry/wxapp/checkLotteryAddress",
                data: {
                    m: app.globalData.Plugin_scoretask,
                    openid: t
                },
                showLoading: !1,
                success: function(e) {
                    0 == (e = e.data) ? wx.showModal({
                        title: "系统信息",
                        content: "请先设置抽奖收货地址",
                        showCancel: !1,
                        success: function(e) {
                            i.setData({
                                isRunning: !1
                            }), wx.setStorageSync("jump_type", 1), wx.navigateTo({
                                url: "/mzhk_sun/plugin/shoppingMall/addressManagement/addressManagement"
                            })
                        }
                    }) : 1 == e && app.util.request({
                        url: "entry/wxapp/setLottery",
                        data: {
                            m: app.globalData.Plugin_scoretask,
                            openid: t
                        },
                        showLoading: !1,
                        success: function(e) {
                            if (1 != e.data.code) var t = 30 * (e = e.data).data.index + 960,
                                a = setInterval(function() {
                                    if (n++, t < (r += 30)) return clearInterval(a), s.setData({
                                        indexSelect: e.data.index
                                    }), s.getuser(), void wx.showModal({
                                        title: "系统信息",
                                        content: "获得了" + e.data.name,
                                        showCancel: !1,
                                        success: function(e) {
                                            e.confirm && i.setData({
                                                isRunning: !1
                                            })
                                        }
                                    });
                                    n %= 8, i.setData({
                                        indexSelect: n
                                    })
                                }, 200 + r);
                            else wx.showModal({
                                title: "系统信息",
                                content: e.data.msg,
                                showCancel: !1,
                                success: function(e) {
                                    i.setData({
                                        isRunning: !1
                                    })
                                }
                            })
                        }
                    })
                }
            })
        }
    },
    getSystem: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/System",
            data: {
                m: app.globalData.Plugin_scoretask
            },
            showLoading: !1,
            success: function(e) {
                t.setData({
                    system: e.data
                })
            }
        })
    },
    getuser: function() {
        var t = this,
            e = wx.getStorageSync("users").openid;
        app.util.request({
            url: "entry/wxapp/getUser2",
            data: {
                openid: e
            },
            showLoading: !1,
            success: function(e) {
                t.setData({
                    user: e.data
                })
            }
        })
    },
    onShow: function() {
        app.func.islogin(app, this), this.getuser()
    },
    earn: function() {
        wx.navigateTo({
            url: "../assignment/assignment"
        })
    },
    record: function() {
        wx.navigateTo({
            url: "../winningRecord/winningRecord"
        })
    },
    updateUserInfo: function(e) {
        app.wxauthSetting()
    }
});