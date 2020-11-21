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
        imageAward: [ "../../../../zhy/resource/image/pointsDraw/1.jpg", "../../../../zhy/resource/image/pointsDraw/2.jpg", "../../../../zhy/resource/image/pointsDraw/3.jpg", "../../../../zhy/resource/image/pointsDraw/4.jpg", "../../../../zhy/resource/image/pointsDraw/5.jpg", "../../../../zhy/resource/image/pointsDraw/6.jpg", "../../../../zhy/resource/image/pointsDraw/7.jpg", "../../../../zhy/resource/image/pointsDraw/8.jpg", "../../../../zhy/resource/image/pointsDraw/1.jpg" ]
    },
    onLoad: function() {
        var e = this, s = this;
        this.getSystem(), app.get_openid().then(function(e) {
            console.log(e), s.setData({
                openid: e
            }), s.getuser();
        });
        for (var a = 7.5, t = 7.5, i = [], n = 0; n < 24; n++) {
            if (0 == n) a = t = 15; else if (n < 6) t = 7.5, a += 102.5; else if (6 == n) t = 15, 
            a = 620; else if (n < 12) t += 94, a = 620; else if (12 == n) t = 565, a = 620; else if (n < 18) t = 570, 
            a -= 102.5; else if (18 == n) t = 565, a = 15; else {
                if (!(n < 24)) return;
                t -= 94, a = 7.5;
            }
            i.push({
                topCircle: t,
                leftCircle: a
            });
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
            });
        }, 500);
        var o = [], r = 25, c = 25;
        app.util.request({
            url: "entry/wxapp/getLotteryPrize",
            data: {
                m: app.globalData.Plugin_scoretask
            },
            showLoading: !1,
            success: function(e) {
                if ((e = e.data).data.length < 8) wx.showModal({
                    title: "系统信息",
                    content: "请后台先设置8个奖项",
                    showCancel: !1
                }); else {
                    for (var a = 0; a < 8; a++) {
                        0 == a ? c = r = 25 : a < 3 ? (r = r, c = c + 166.6666 + 15) : a < 5 ? (c = c, r = r + 150 + 15) : a < 7 ? (c = c - 166.6666 - 15, 
                        r = r) : a < 8 && (c = c, r = r - 150 - 15);
                        var t = e.other.img_root + e.data[a].pic;
                        o.push({
                            topAward: r,
                            leftAward: c,
                            imageAward: t
                        });
                    }
                    s.setData({
                        awardList: o
                    });
                }
            }
        });
    },
    startGame: function() {
        var s = this;
        if (!this.data.isRunning) {
            this.setData({
                isRunning: !0
            });
            var i = this, n = 0, o = 0, a = s.data.openid;
            app.util.request({
                url: "entry/wxapp/checkLotteryAddress",
                data: {
                    m: app.globalData.Plugin_scoretask,
                    openid: a
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
                                url: "/pages/plugin/shoppingMall/addressManagement/addressManagement"
                            });
                        }
                    }) : 1 == e && app.util.request({
                        url: "entry/wxapp/setLottery",
                        data: {
                            m: app.globalData.Plugin_scoretask,
                            openid: a
                        },
                        showLoading: !1,
                        success: function(e) {
                            if (1 != e.data.code) var a = 30 * (e = e.data).data.index + 960, t = setInterval(function() {
                                if (n++, a < (o += 30)) return clearInterval(t), s.setData({
                                    indexSelect: e.data.index
                                }), s.getuser(), void wx.showModal({
                                    title: "系统信息",
                                    content: "获得了" + e.data.name,
                                    showCancel: !1,
                                    success: function(e) {
                                        e.confirm && i.setData({
                                            isRunning: !1
                                        });
                                    }
                                });
                                n %= 8, i.setData({
                                    indexSelect: n
                                });
                            }, 200 + o); else wx.showModal({
                                title: "系统信息",
                                content: e.data.msg,
                                showCancel: !1,
                                success: function(e) {
                                    i.setData({
                                        isRunning: !1
                                    });
                                }
                            });
                        }
                    });
                }
            });
        }
    },
    getSystem: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/System",
            data: {
                m: app.globalData.Plugin_scoretask
            },
            showLoading: !1,
            success: function(e) {
                a.setData({
                    system: e.data
                });
            }
        });
    },
    getuser: function() {
        var a = this, e = a.data.openid;
        console.log(e), app.util.request({
            url: "entry/wxapp/getUser",
            data: {
                openid: e,
                m: app.globalData.Plugin_scoretask
            },
            showLoading: !1,
            success: function(e) {
                console.log(e), a.setData({
                    user: e.data
                });
            }
        });
    },
    earn: function() {
        wx.navigateTo({
            url: "../assignment/assignment"
        });
    },
    record: function() {
        wx.navigateTo({
            url: "../winningRecord/winningRecord"
        });
    }
});