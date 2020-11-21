var dot_inter, app = getApp(), WxParse = require("../../../../common/wxParse/wxParse.js");

Page({
    data: {
        navTile: "",
        showModel: !1,
        is_modal_Hidden: !0,
        iscandraw: !1,
        animationData: {},
        pt_name: "",
        goods: [],
        prize: [ "恭喜李**抽到二等奖", "字数不要太多", "恭喜***抽到三等奖" ],
        isLogin: !1,
        bgLogo: "../../../../style/images/icon6.png",
        rouletteData: {
            speed: 10,
            award: [ {
                level: "特等奖",
                prize: "",
                probability: 0,
                num: 0,
                turn: "0turn"
            }, {
                level: "一等奖",
                prize: "",
                probability: 0,
                num: 0,
                turn: "0.16666666666666666turn"
            }, {
                level: "二等奖",
                prize: "",
                probability: 0,
                num: 0,
                turn: "0.3333333333333333turn"
            }, {
                level: "三等奖",
                prize: "",
                probability: 0,
                num: 0,
                turn: "0.5turn"
            }, {
                level: "四等奖",
                prize: "",
                probability: 0,
                num: 0,
                turn: "0.6666666666666666turn"
            }, {
                level: "未中奖",
                prize: "没有获得奖品，请再接再厉",
                probability: 0,
                num: 0,
                turn: "0.8333333333333333turn"
            } ],
            fontColor: "#e21b58",
            font: "18px Arial",
            bgOut: "#ffe774",
            bgMiddle: "#ffc046",
            bgInner: [ "#fff2ca", "#fdd890", "#fff2ca", "#fdd890", "#fff2ca", "#fdd890" ],
            speedDot: 1e3,
            dotColor: [ "#ffffff", "#b1ffdd" ],
            dotColor_1: [ "#ffffff", "#b1ffdd" ],
            dotColor_2: [ "#b1ffdd", "#ffffff" ],
            angel: 0
        },
        awardIndex: 5,
        lotteryNum: 100,
        lotteryredata: [],
        optionsdata: ""
    },
    onLoad: function(a) {
        var r = this;
        a = app.func.decodeScene(a), r.setData({
            options: a,
            optionsdata: a
        }), console.log(a);
        var s = a.id;
        if (s <= 0 || !s || "undefined" == s) return wx.showModal({
            title: "提示",
            content: "参数错误，获取不到商品，点击确认跳转到首页",
            showCancel: !1,
            success: function(t) {
                wx.redirectTo({
                    url: "/pages/plugin/eatvisit/life/life"
                });
            }
        }), !1;
        r.drawCanvas(), app.get_user_info().then(function(t) {
            console.log(t), r.setData({
                cardNum: t.tel ? t.tel : "***********",
                isLogin: !t.name,
                phoneGrant: !(t.tel || !t.name),
                user: t,
                openid: t.openid
            }), app.util.request({
                url: "entry/wxapp/GetPlatformInfo",
                data: {
                    m: "yzhyk_sun"
                },
                success: function(t) {
                    console.log(t), r.setData({
                        setting: t.data
                    }), wx.setNavigationBarColor({
                        frontColor: 1 == t.data.app_fcolor ? "#000000" : "#ffffff",
                        backgroundColor: t.data.app_bcolor ? t.data.app_bcolor : "#ffffff"
                    });
                }
            });
            var e = t.openid, o = t;
            console.log(o.end_time), app.util.request({
                url: "entry/wxapp/GetGoodsInfo",
                data: {
                    id: r.data.options.id,
                    m: app.globalData.Plugin_eatvisit
                },
                showLoading: !1,
                success: function(t) {
                    if (console.log(t.data), 1 == t.data.is_vip && null == o.is_member) return wx.showModal({
                        title: "提示",
                        content: "会员商品，请先购买会员",
                        showCancel: !1,
                        success: function(t) {
                            wx.reLaunch({
                                url: "/pages/plugin/eatvisit/life/life"
                            });
                        }
                    }), !1;
                    if (2 != t.data) {
                        if (t.data.nowtime > t.data.antime) return wx.showModal({
                            title: "提示",
                            content: "此活动已过期！",
                            showCancel: !1,
                            success: function(t) {
                                wx.reLaunch({
                                    url: "/pages/plugin/eatvisit/life/life"
                                });
                            }
                        }), !1;
                        if (1 != t.data.isshelf) return wx.showModal({
                            title: "提示",
                            content: "此活动已下架！",
                            showCancel: !1,
                            success: function(t) {
                                wx.reLaunch({
                                    url: "/pages/plugin/eatvisit/life/life"
                                });
                            }
                        }), !1;
                        if (2 != t.data.status) return wx.showModal({
                            title: "提示",
                            content: "此活动已关闭！",
                            showCancel: !1,
                            success: function(t) {
                                wx.reLaunch({
                                    url: "/pages/plugin/eatvisit/life/life"
                                });
                            }
                        }), !1;
                        var a = r.data.rouletteData, e = a.award;
                        e[0].prize = t.data.grandprize ? t.data.grandprize : "特等奖奖品", e[1].prize = t.data.firstprize ? t.data.firstprize : "一等奖奖品", 
                        e[2].prize = t.data.secondprize ? t.data.secondprize : "二等奖奖品", e[3].prize = t.data.thirdprize ? t.data.thirdprize : "三等奖奖品", 
                        e[4].prize = t.data.fourthprize ? t.data.fourthprize : "四等奖奖品", e[5].prize = t.data.notwonprize ? t.data.notwonprize : "没有获得奖品，请再接再厉", 
                        a.award = e, r.setData({
                            rouletteData: a,
                            goods: t.data
                        }), r.dotStart(), wx.setNavigationBarTitle({
                            title: t.data.gname
                        }), t.data.content && WxParse.wxParse("content", "html", t.data.content, r, 20), 
                        t.data.usenotice && WxParse.wxParse("usenotice", "html", t.data.usenotice, r, 20);
                    } else r.setData({
                        goods: []
                    });
                }
            });
            var n = o ? o.id : 0, i = a.d_user_id ? a.d_user_id : 0;
            console.log(i + "--" + n + "--" + s + "--" + e), e ? 0 != i && i != n ? app.util.request({
                url: "entry/wxapp/SaveEatShare",
                data: {
                    gid: s,
                    share_uid: i,
                    clickopenid: e,
                    m: app.globalData.Plugin_eatvisit
                },
                success: function(t) {
                    console.log("成功之后数据保存22"), console.log(t);
                }
            }) : console.log("br22") : wx.login({
                success: function(t) {
                    var a = t.code;
                    app.util.request({
                        url: "entry/wxapp/openid",
                        data: {
                            code: a
                        },
                        success: function(t) {
                            e = t.data.openid, console.log(e), 0 != i && i != n ? app.util.request({
                                url: "entry/wxapp/SaveEatShare",
                                data: {
                                    gid: s,
                                    share_uid: i,
                                    clickopenid: e,
                                    m: app.globalData.Plugin_eatvisit
                                },
                                success: function(t) {
                                    console.log("成功之后数据保存111"), console.log(t);
                                }
                            }) : console.log("br33");
                        }
                    });
                }
            });
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                m: app.globalData.Plugin_yzhyk,
                type: 2
            },
            showLoading: !1,
            success: function(t) {
                var a = t.data, e = t.data.navname ? t.data.navname : "大转盘";
                r.setData({
                    navname: e
                }), 2 != a ? r.setData({
                    eatvisit_set: a
                }) : wx.showModal({
                    title: "提示消息",
                    content: "大转盘功能未开启",
                    showCancel: !1,
                    success: function(t) {
                        wx.redirectTo({
                            url: "/yzhyk_sun/pages/inedx/index"
                        });
                    }
                });
            }
        });
    },
    onReady: function() {
        console.log(this.data.user);
    },
    onShow: function() {
        var r = this, t = r.data.optionsdata;
        t.d_user_id && app.distribution.distribution_parsent(app, t.d_user_id), app.get_user_info().then(function(t) {
            var a = t.openid, e = t, o = r.data.optionsdata.id;
            app.util.request({
                url: "entry/wxapp/GetLotteryreData",
                cachetime: "0",
                data: {
                    openid: a,
                    uid: e.id,
                    gid: o,
                    m: app.globalData.Plugin_eatvisit
                },
                showLoading: !1,
                success: function(t) {
                    var a = r.data.rouletteData, e = a.award;
                    console.log(t.data);
                    for (var o = t.data, n = t.data.awardnum, i = 0; i < n.length; i++) e[i].num = 0 < n[i] ? n[i] : 0;
                    a.award = e, r.setData({
                        lotteryredata: o,
                        rouletteData: a,
                        iscandraw: !0
                    });
                }
            });
        });
    },
    drawCanvas: function() {
        var t = wx.createCanvasContext("roulette", this), a = this.data.rouletteData;
        t.translate(147.5, 147.5), t.clearRect(-295, -295, 295, 295);
        var e = 2 * Math.PI / 360 * 60, o = 2 * Math.PI / 360 * -90;
        Math.PI;
        t.rotate(-30 * Math.PI / 180), t.beginPath(), t.lineWidth = 20, t.strokeStyle = a.bgOut, 
        t.arc(0, 0, 130, 0, 2 * Math.PI), t.stroke();
        for (var n = a.dotColor, i = 0; i < 26; i++) {
            t.beginPath();
            var r = 131 * Math.cos(o), s = 131 * Math.sin(o);
            t.fillStyle = n[i % n.length], t.arc(r, s, 5, 0, 2 * Math.PI), t.fill(), o += 2 * Math.PI / 360 * (360 / 26);
        }
        t.draw();
    },
    beforegetLottery: function() {
        var a = this, e = a.data.goods, t = a.data.openid, o = a.data.user;
        console.log(t), console.log(o), app.util.request({
            url: "entry/wxapp/CheckLottery",
            data: {
                openid: t,
                uid: o.id,
                gid: e.id,
                m: app.globalData.Plugin_eatvisit
            },
            showLoading: !1,
            success: function(t) {
                a.getLottery();
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    confirmText: "增加次数",
                    showCancel: !0,
                    success: function(t) {
                        t.confirm && wx.navigateTo({
                            url: "/pages/plugin/eatvisit/lifeexplore/lifeexplore?id=" + e.id
                        });
                    }
                });
            }
        });
    },
    getLottery: function() {
        var o = this, t = o.data.rouletteData;
        if (!o.data.iscandraw) return wx.showToast({
            title: "数据加载中，请稍后...",
            icon: "none"
        }), !1;
        var n = o.data.goods, a = [];
        a[0] = n.grandprobability / 100, a[1] = n.firstprobability / 100, a[2] = n.secondprobability / 100, 
        a[3] = n.thirdprobability / 100, a[4] = n.fourthprobability / 100, a[5] = n.notwonprobability / 100;
        var i = o.random(a);
        null == i && (i = 5), console.log(i);
        t.award;
        var e = wx.createAnimation({
            duration: 1
        });
        (this.animationInit = e).rotate(0).step(), this.setData({
            animationData: e.export(),
            iscandraw: !1
        }), setTimeout(function() {
            var t = wx.createAnimation({
                duration: 4e3,
                timingFunction: "ease"
            });
            (o.animationRun = t).rotate(2880 - 60 * i).step(), o.setData({
                animationData: t.export()
            });
        }, 100), setTimeout(function() {
            app.get_user_info().then(function(t) {
                var a = t.openid, e = t;
                app.util.request({
                    url: "entry/wxapp/SaveAward",
                    data: {
                        openid: a,
                        uid: e.id,
                        awardIndex: i,
                        gid: n.id,
                        m: app.globalData.Plugin_eatvisit
                    },
                    showLoading: !1,
                    success: function(t) {
                        o.onShow();
                    }
                });
            }), o.setData({
                showModel: !0,
                awardIndex: i
            });
        }, 4100);
    },
    random: function(t) {
        var a = 0, e = 0, o = Math.random(), n = this.data.rouletteData;
        console.log(n);
        for (var i = t.length - 1; 0 <= i; i--) a += t[i];
        if (0 == a) return 5;
        o *= a;
        for (i = t.length - 1; 0 <= i; i--) if (o <= (e += t[i])) {
            var r = parseInt(n.award[i].num);
            return r <= 0 ? (console.log(r), 5) : i;
        }
        return null;
    },
    dotStart: function() {
        var t = this, a = 0, e = t.data.rouletteData;
        dot_inter = setInterval(function() {
            e.dotColor = a % 2 ? e.dotColor_1 : e.dotColor_2, a++, t.setData({
                options: e
            }), t.drawCanvas();
        }, e.speedDot);
    },
    onHide: function() {},
    onUnload: function() {
        clearInterval(dot_inter);
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var t = this.data.goods, a = wx.getStorageSync("users");
        return {
            title: t.sharetitle ? t.sharetitle : t.gname,
            imageUrl: t.shareimg ? t.url + t.shareimg : t.url + t.thumbnail,
            path: "/pages/plugin/eatvisit/lifedet/lifedet?id=" + t.id + "&d_user_id=" + a.id
        };
    },
    toLife: function(t) {
        wx.reLaunch({
            url: "/pages/plugin/eatvisit/life/life"
        });
    },
    toShop: function(t) {
        wx.navigateTo({
            url: ""
        });
    },
    toIndex: function(t) {
        wx.reLaunch({
            url: "/pages/plugin/eatvisit/life/life"
        });
    },
    toLifeExplore: function(t) {
        var a = this.data.goods.id;
        wx.navigateTo({
            url: "/pages/plugin/eatvisit/lifeexplore/lifeexplore?id=" + a
        });
    },
    getDialog: function(t) {
        var a = this.data.goods;
        wx.makePhoneCall({
            phoneNumber: a.tel
        });
    },
    toMap: function(t) {
        var a = this.data.goods, e = Number(a.longitude), o = Number(a.latitude);
        if (0 == e && 0 == o) return !1;
        wx.openLocation({
            name: a.address,
            latitude: o,
            longitude: e,
            scale: 18,
            address: a.address
        });
    },
    hiddenModel: function(t) {
        this.setData({
            showModel: !1
        });
    },
    bindGetUserInfo: function(t) {
        var a = this, e = t.detail.userInfo;
        app.util.request({
            url: "entry/wxapp/UpdateUser",
            cachetime: "0",
            data: {
                id: a.data.user.id,
                img: e.avatarUrl,
                name: e.nickName,
                gender: e.gender,
                m: "yzhyk_sun"
            },
            success: function(t) {
                app.get_user_info(!1).then(function(t) {
                    a.setData({
                        user: t,
                        isLogin: !1,
                        phoneGrant: !(t.tel || !t.name)
                    });
                });
            }
        }), console.log(t.detail.userInfo);
    }
});