/*   time:2019-08-09 13:18:39*/
var dot_inter, Page = require("../../../sdk/qitui/oddpush.js").oddPush(Page).Page,
    app = getApp(),
    WxParse = require("../../../pages/wxParse/wxParse.js");
Page({
    data: {
        navTile: "",
        showModel: !1,
        is_modal_Hidden: !0,
        iscandraw: !1,
        animationData: {},
        pt_name: "",
        goods: [],
        prize: ["恭喜李**抽到二等奖", "字数不要太多", "恭喜***抽到三等奖"],
        rouletteData: {
            speed: 10,
            award: [{
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
            }],
            fontColor: "#e21b58",
            font: "18px Arial",
            bgOut: "#ffe774",
            bgMiddle: "#ffc046",
            bgInner: ["#fff2ca", "#fdd890", "#fff2ca", "#fdd890", "#fff2ca", "#fdd890"],
            speedDot: 1e3,
            dotColor: ["#ffffff", "#b1ffdd"],
            dotColor_1: ["#ffffff", "#b1ffdd"],
            dotColor_2: ["#b1ffdd", "#ffffff"],
            angel: 0
        },
        awardIndex: 5,
        lotteryNum: 100,
        lotteryredata: [],
        optionsdata: ""
    },
    onLoad: function(t) {
        var e = this;
        t = app.func.decodeScene(t), e.setData({
            options: t,
            optionsdata: t
        });
        var o = t.id;
        if (o <= 0 || !o || "undefined" == o) return wx.showModal({
            title: "提示",
            content: "参数错误，获取不到商品，点击确认跳转到首页",
            showCancel: !1,
            success: function(t) {
                wx.redirectTo({
                    url: "/mzhk_sun/pages/index/index"
                })
            }
        }), !1;
        e.drawCanvas(), app.wxauthSetting();
        var i = wx.getStorageSync("openid"),
            a = wx.getStorageSync("users"),
            n = a ? a.id : 0,
            r = t.d_user_id ? t.d_user_id : 0;
        console.log(r + "--" + n + "--" + o + "--" + i), i ? 0 != r && r != n ? app.util.request({
            url: "entry/wxapp/SaveEatShare",
            data: {
                gid: o,
                share_uid: r,
                clickopenid: i,
                m: app.globalData.Plugin_eatvisit
            },
            success: function(t) {
                console.log("成功之后数据保存22"), console.log(t)
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
                        i = t.data.openid, console.log(i), 0 != r && r != n ? app.util.request({
                            url: "entry/wxapp/SaveEatShare",
                            data: {
                                gid: o,
                                share_uid: r,
                                clickopenid: i,
                                m: app.globalData.Plugin_eatvisit
                            },
                            success: function(t) {
                                console.log("成功之后数据保存111"), console.log(t)
                            }
                        }) : console.log("br33")
                    }
                })
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 2
            },
            showLoading: !1,
            success: function(t) {
                var a = t.data;
                2 != a ? e.setData({
                    eatvisit_set: a
                }) : wx.showModal({
                    title: "提示消息",
                    content: "吃探功能未开启",
                    showCancel: !1,
                    success: function(t) {
                        wx.redirectTo({
                            url: "/mzhk_sun/pages/inedx/index"
                        })
                    }
                })
            }
        }), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                e.setData({
                    pt_name: t.data.hk_tubiao ? t.data.hk_tubiao : ""
                }), wx.setNavigationBarColor({
                    frontColor: t.data.fontcolor ? t.data.fontcolor : "#000000",
                    backgroundColor: t.data.color ? t.data.color : "#ffffff",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                })
            }
        })
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新"), console.log(t);
        app.wxauthSetting()
    },
    onReady: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/GetGoodsInfo",
            data: {
                id: o.data.options.id,
                m: app.globalData.Plugin_eatvisit
            },
            showLoading: !1,
            success: function(t) {
                if (2 != t.data) {
                    var a = o.data.rouletteData,
                        e = a.award;
                    e[0].prize = t.data.grandprize ? t.data.grandprize : "特等奖奖品", e[1].prize = t.data.firstprize ? t.data.firstprize : "一等奖奖品", e[2].prize = t.data.secondprize ? t.data.secondprize : "二等奖奖品", e[3].prize = t.data.thirdprize ? t.data.thirdprize : "三等奖奖品", e[4].prize = t.data.fourthprize ? t.data.fourthprize : "四等奖奖品", e[5].prize = t.data.notwonprize ? t.data.notwonprize : "没有获得奖品，请再接再厉", a.award = e, o.setData({
                        rouletteData: a,
                        goods: t.data
                    }), o.dotStart(), wx.setNavigationBarTitle({
                        title: t.data.gname
                    }), t.data.content && WxParse.wxParse("content", "html", t.data.content, o, 20), t.data.usenotice && WxParse.wxParse("usenotice", "html", t.data.usenotice, o, 20)
                } else o.setData({
                    goods: []
                })
            }
        })
    },
    onShow: function() {
        var r = this;
        app.func.islogin(app, r);
        var t = r.data.optionsdata;
        t.d_user_id && app.distribution.distribution_parsent(app, t.d_user_id);
        var a = wx.getStorageSync("openid"),
            e = wx.getStorageSync("users"),
            o = r.data.optionsdata.id;
        e || r.setData({
            is_modal_Hidden: !1
        }), app.util.request({
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
                var a = r.data.rouletteData,
                    e = a.award;
                console.log(t.data);
                for (var o = t.data, i = t.data.awardnum, n = 0; n < i.length; n++) e[n].num = 0 < i[n] ? i[n] : 0;
                a.award = e, r.setData({
                    lotteryredata: o,
                    rouletteData: a,
                    iscandraw: !0
                })
            }
        })
    },
    drawCanvas: function() {
        var t = wx.createCanvasContext("roulette", this),
            a = this.data.rouletteData,
            e = 295;
        t.translate(147.5, 147.5), t.clearRect(-e, -295, e, 295);
        var o = 2 * Math.PI / 360 * 60,
            i = 2 * Math.PI / 360 * -90;
        Math.PI;
        t.rotate(-30 * Math.PI / 180), t.beginPath(), t.lineWidth = 20, t.strokeStyle = a.bgOut, t.arc(0, 0, 130, 0, 2 * Math.PI), t.stroke();
        for (var n = a.dotColor, r = 0; r < 26; r++) {
            t.beginPath();
            var d = 131 * Math.cos(i),
                s = 131 * Math.sin(i);
            t.fillStyle = n[r % n.length], t.arc(d, s, 5, 0, 2 * Math.PI), t.fill(), i += 2 * Math.PI / 360 * (360 / 26)
        }
        t.draw()
    },
    beforegetLottery: function() {
        var a = this,
            e = a.data.goods,
            t = wx.getStorageSync("openid"),
            o = wx.getStorageSync("users");
        app.util.request({
            url: "entry/wxapp/CheckLottery",
            data: {
                openid: t,
                uid: o.id,
                gid: e.id,
                m: app.globalData.Plugin_eatvisit
            },
            showLoading: !1,
            success: function(t) {
                a.getLottery()
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    confirmText: "增加次数",
                    showCancel: !0,
                    success: function(t) {
                        t.confirm && wx.navigateTo({
                            url: "/mzhk_sun/plugin/eatvisit/lifeexplore/lifeexplore?id=" + e.id
                        })
                    }
                })
            }
        })
    },
    getLottery: function() {
        var e = this,
            t = e.data.rouletteData;
        if (!e.data.iscandraw) return wx.showToast({
            title: "数据加载中，请稍后...",
            icon: "none"
        }), !1;
        var o = e.data.goods,
            a = [];
        a[0] = o.grandprobability / 100, a[1] = o.firstprobability / 100, a[2] = o.secondprobability / 100, a[3] = o.thirdprobability / 100, a[4] = o.fourthprobability / 100, a[5] = o.notwonprobability / 100;
        var i = e.random(a);
        null == i && (i = 5), console.log(i);
        t.award;
        var n = wx.createAnimation({
            duration: 1
        });
        (this.animationInit = n).rotate(0).step(), this.setData({
            animationData: n.export(),
            iscandraw: !1
        }), setTimeout(function() {
            var t = wx.createAnimation({
                duration: 4e3,
                timingFunction: "ease"
            });
            (e.animationRun = t).rotate(2880 - 60 * i).step(), e.setData({
                animationData: t.export()
            })
        }, 100), setTimeout(function() {
            var t = wx.getStorageSync("openid"),
                a = wx.getStorageSync("users");
            app.util.request({
                url: "entry/wxapp/SaveAward",
                data: {
                    openid: t,
                    uid: a.id,
                    awardIndex: i,
                    gid: o.id,
                    m: app.globalData.Plugin_eatvisit
                },
                showLoading: !1,
                success: function(t) {
                    e.onShow()
                }
            }), e.setData({
                showModel: !0,
                awardIndex: i
            })
        }, 4100)
    },
    random: function(t) {
        var a = 0,
            e = 0,
            o = Math.random(),
            i = this.data.rouletteData;
        console.log(i);
        for (var n = t.length - 1; 0 <= n; n--) a += t[n];
        if (0 == a) return 5;
        o *= a;
        for (n = t.length - 1; 0 <= n; n--) if (o <= (e += t[n])) {
            var r = parseInt(i.award[n].num);
            return r <= 0 ? (console.log(r), 5) : n
        }
        return null
    },
    dotStart: function() {
        var t = this,
            a = 0,
            e = t.data.rouletteData;
        dot_inter = setInterval(function() {
            e.dotColor = a % 2 ? e.dotColor_1 : e.dotColor_2, a++, t.setData({
                options: e
            }), t.drawCanvas()
        }, e.speedDot)
    },
    onHide: function() {},
    onUnload: function() {
        clearInterval(dot_inter)
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var t = this.data.goods,
            a = wx.getStorageSync("users");
        return {
            title: t.sharetitle ? t.sharetitle : t.gname,
            imageUrl: t.shareimg ? t.url + t.shareimg : t.url + t.thumbnail,
            path: "/mzhk_sun/plugin/eatvisit/lifedet/lifedet?id=" + t.id + "&d_user_id=" + a.id
        }
    },
    toLife: function(t) {
        wx.reLaunch({
            url: "/mzhk_sun/plugin/eatvisit/life/life"
        })
    },
    toShop: function(t) {
        wx.navigateTo({
            url: ""
        })
    },
    toIndex: function(t) {
        wx.reLaunch({
            url: "/mzhk_sun/pages/index/index"
        })
    },
    toLifeExplore: function(t) {
        var a = this.data.goods.id;
        wx.navigateTo({
            url: "/mzhk_sun/plugin/eatvisit/lifeexplore/lifeexplore?id=" + a
        })
    },
    getDialog: function(t) {
        var a = this.data.goods;
        wx.makePhoneCall({
            phoneNumber: a.phone
        })
    },
    toMap: function(t) {
        var a = this.data.goods,
            e = Number(a.longitude),
            o = Number(a.latitude);
        if (0 == e && 0 == o) return !1;
        wx.openLocation({
            name: a.address,
            latitude: o,
            longitude: e,
            scale: 18,
            address: a.address
        })
    },
    hiddenModel: function(t) {
        this.setData({
            showModel: !1
        })
    }
});