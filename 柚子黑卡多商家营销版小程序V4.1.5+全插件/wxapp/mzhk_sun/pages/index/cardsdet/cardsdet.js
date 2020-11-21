var Page = require("../../../sdk/qitui/oddpush.js").oddPush(Page).Page, app = getApp();

Page({
    data: {
        navTile: "集卡活动详情",
        banner: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/15227233856.png",
        title: "集卡标题",
        startTime: "2018-04-10",
        endTime: "2018-05-10",
        cards: [],
        num: "3",
        isJoin: "0",
        isOk: 0,
        showModalStatus: !1,
        is_modal_Hidden: !0,
        options_data: [],
        viptype: "0",
        hidden: !0,
        showgw: 0,
        wglist: [],
        wg_flag: 0,
        showModalStatus2: 0
    },
    onLoad: function(t) {
        var a = this;
        t = app.func.decodeScene(t), wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var e = app.getSiteUrl();
        e ? a.setData({
            url: e
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                wx.setStorageSync("url", t.data), e = t.data, a.setData({
                    url: e
                });
            }
        }), app.wxauthSetting();
        var o = wx.getStorageSync("System");
        wx.setNavigationBarColor({
            frontColor: o.fontcolor ? o.fontcolor : "",
            backgroundColor: o.color ? o.color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), a.setData({
            store_open: o.store_open ? o.store_open : 0
        });
        var n = o.showgw;
        if (1 == n) {
            var s = {
                wg_title: o.wg_title,
                wg_directions: o.wg_directions,
                wg_img: o.wg_img,
                wg_keyword: o.wg_keyword,
                wg_addicon: o.wg_addicon
            };
            a.setData({
                showgw: n,
                wglist: s
            });
        }
        var i = t.gid, c = t.userid ? t.userid : 0;
        if (i <= 0 || !i) return wx.showModal({
            title: "提示",
            content: "参数错误，获取不到商品，点击确认跳转到首页",
            showCancel: !1,
            success: function(t) {
                wx.reLaunch({
                    url: "/mzhk_sun/pages/index/index"
                });
            }
        }), !1;
        a.setData({
            id: i,
            options: t,
            share_uid: c
        });
        var r = wx.getStorageSync("openid");
        r ? 0 != c && c != r ? app.util.request({
            url: "entry/wxapp/SaveCardsShare",
            showLoading: !1,
            data: {
                gid: i,
                openid: c,
                clickopenid: r
            },
            success: function(t) {
                console.log("成功之后数据保存222"), console.log(t.data);
            }
        }) : console.log("br22") : wx.login({
            success: function(t) {
                console.log("进入wx-login333"), console.log(t), console.log(t.code);
                var a = t.code;
                app.util.request({
                    url: "entry/wxapp/openid",
                    data: {
                        code: a
                    },
                    success: function(t) {
                        console.log("进入获取openid333"), console.log(t.data), r = t.data.openid, 0 != c && c != r ? app.util.request({
                            url: "entry/wxapp/SaveCardsShare",
                            data: {
                                gid: i,
                                openid: c,
                                clickopenid: r
                            },
                            success: function(t) {
                                console.log("成功之后数据保存111"), console.log(t.data);
                            }
                        }) : console.log("br33");
                    }
                });
            }
        });
    },
    showwgtable: function(t) {
        var a = t.currentTarget.dataset.flag;
        this.setData({
            wg_flag: a
        });
    },
    getUrl: function() {
        var a = this, e = app.getSiteUrl();
        e ? a.setData({
            url: e
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), e = t.data, a.setData({
                    url: e
                });
            }
        });
    },
    toIndex: function(t) {
        wx.reLaunch({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    onReady: function() {},
    hidden: function(t) {
        this.setData({
            hidden: !0
        });
    },
    save: function() {
        var a = this;
        wx.saveImageToPhotosAlbum({
            filePath: a.data.prurl,
            success: function(t) {
                wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(t) {
                        t.confirm && (console.log("用户点击确定"), a.setData({
                            hidden: !0
                        }));
                    }
                });
            },
            fail: function(t) {
                console.log("失败"), wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.writePhotosAlbum"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(t) {
                                console.log("openSetting success", t.authSetting);
                            }
                        }));
                    }
                });
            }
        });
    },
    shareCanvas: function() {
        var t = this, a = wx.getStorageSync("System"), e = t.data.cards, o = [];
        o.codetype = a.ispnumber, o.goodspicbg = a.goodspicbg, o.gid = e.gid, o.bname = e.gname, 
        o.url = t.data.url, o.logo = e.pic, o.astime = e.astime, o.antime = e.antime, o.scene = "gid=" + t.data.id, 
        o.tabletype = 1, app.creatPoster("mzhk_sun/pages/index/cardsdet/cardsdet", 430, o, 5, "shareImg");
    },
    toMember: function(t) {
        wx.navigateTo({
            url: "../../member/member"
        });
    },
    onShow: function() {
        var e = this, a = e.data.options;
        app.func.islogin(app, e), app.util.request({
            url: "entry/wxapp/UpdateGoods",
            showLoading: !1,
            data: {
                id: e.data.id,
                typeid: 1
            },
            success: function(t) {
                console.log("更新数据"), console.log(t.data);
            }
        });
        var t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ISVIP",
            showLoading: !1,
            cachetime: "0",
            data: {
                openid: t
            },
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                console.log("vip"), console.log(t.data), e.setData({
                    viptype: t.data.viptype
                });
            }
        }), app.util.request({
            url: "entry/wxapp/JKdetails",
            data: {
                gid: e.data.id,
                openid: t
            },
            success: function(t) {
                console.log("获取集卡详情"), console.log(t.data);
                var a = t.data;
                t.data.num <= 0 && (a.isend = 1), e.setData({
                    cards: a,
                    isJoin: t.data.isJoin,
                    isOk: 1 == t.data.isOk ? 1 : 0
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1,
                    success: function(t) {
                        1 == a.is_share ? wx.redirectTo({
                            url: "/mzhk_sun/pages/index/cards/cards"
                        }) : wx.navigateBack({
                            delta: 1
                        });
                    }
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {
        clearTimeout(app.globalData.timer_slideupshoworder);
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        var a = this.data.cards, e = (a.lotterynum, this.data.url);
        app.util.request({
            url: "entry/wxapp/UpdateGoods",
            data: {
                id: this.data.id,
                typeid: 2
            },
            success: function(t) {
                console.log("更新数据"), console.log(t.data);
            }
        }), "button" === t.from && console.log(t.target);
        var o = a.gid, n = wx.getStorageSync("openid");
        return {
            title: (a.biaoti ? a.biaoti + "：" : "") + a.gname,
            path: "/mzhk_sun/pages/index/cardsdet/cardsdet?gid=" + o + "&userid=" + n + "&is_share=1",
            imageUrl: e + a.lb_imgs[0],
            success: function(t) {
                console.log("转发成功！！！"), console.log(t), wx.showToast({
                    title: "分享成功",
                    icon: "none",
                    duration: 1e3
                });
            },
            fail: function(t) {}
        };
    },
    GetGift: function(t) {
        var a = t.currentTarget.dataset.gid, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/CheckGift",
            data: {
                gid: a,
                openid: e,
                ltype: 3
            },
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/CheckGoodsStatus",
                    cachetime: "10",
                    data: {
                        gid: a
                    },
                    success: function(t) {
                        console.log(t.data), wx.navigateTo({
                            url: "/mzhk_sun/pages/member/jkorder/jkorder?id=" + a + "&price=0"
                        });
                    },
                    fail: function(t) {
                        return wx.showModal({
                            title: "提示信息",
                            content: t.data.message,
                            showCancel: !1
                        }), !1;
                    }
                });
            }
        });
    },
    join: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/User",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                if (1 == t.data) return wx.showToast({
                    title: "禁止购买",
                    icon: "loading",
                    duration: 2e3
                }), !1;
                a.setData({
                    isJoin: 1
                });
            }
        });
    },
    powerDrawer: function(t) {
        var a = t.currentTarget.dataset.statu, e = (t.currentTarget.dataset.again, this), o = e.data.cards, n = o.card_son, s = o.lotterynum, i = e.data.isOk;
        if (app.util.request({
            url: "entry/wxapp/UpdateGoods",
            data: {
                id: e.data.id,
                typeid: 3
            },
            success: function(t) {
                console.log("更新数据"), console.log(t.data);
            }
        }), s <= 0) return wx.showModal({
            content: "你已经没有抽卡次数了",
            showCancel: !1
        }), !1;
        var c = [], r = [];
        console.log("卡片数据"), console.log(n);
        for (var l = 0; l < n.length; l++) c[l] = n[l], r[l] = n[l].probability / 100;
        var d = e.random(c, r), u = wx.getStorageSync("openid");
        console.log("获取奖品"), console.log(d);
        var g = 1;
        for (l = 0; l < n.length; l++) d.id == n[l].id && (n[l].status = 1, n[l].num = n[l].num + 1), 
        1 != n[l].status && (g = 0);
        1 == g && (i = 1), o.card_son = n, app.util.request({
            url: "entry/wxapp/SaveWin",
            data: {
                openid: u,
                id: d.id,
                gid: o.gid
            },
            success: function(t) {
                console.log("存储的数据"), console.log(t.data), s--, o.lotterynum = s, console.log(s), 
                e.setData({
                    win: d,
                    cards: o,
                    isOk: i
                });
            }
        }), e.util(a);
    },
    random: function(t, a) {
        for (var e = 0, o = 0, n = Math.random(), s = a.length - 1; 0 <= s; s--) e += a[s];
        n *= e;
        for (s = a.length - 1; 0 <= s; s--) if (n <= (o += a[s])) return t[s];
        return null;
    },
    closethemodal: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a);
    },
    util: function(t) {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).opacity(0).height(0).step(), this.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.opacity(1).height("660rpx").step(), this.setData({
                animationData: a
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    },
    toApply: function(t) {
        var a = this, e = t.currentTarget.dataset.statu, o = wx.getStorageSync("openid");
        console.log(e), console.log(o), app.util.request({
            url: "entry/wxapp/GetstoreNotice2",
            cachetime: "30",
            data: {
                openid: o
            },
            success: function(t) {
                console.log(t.data), 2 == t.data.data ? a.toBackstage() : a.setData({
                    storenotice: t.data.data.notice,
                    showModalStatus2: e
                });
            }
        });
    },
    toBackstage: function(t) {
        var a = wx.getStorageSync("openid");
        console.log("商家管理入口"), app.util.request({
            url: "entry/wxapp/CheckBrandUser",
            cachetime: "0",
            data: {
                openid: a
            },
            success: function(t) {
                console.log("商家数据"), console.log(t.data), t.data ? (wx.setStorageSync("brand_info", t.data.data), 
                app.globalData.islogin = 1, wx.navigateTo({
                    url: "/mzhk_sun/pages/backstage/index2/index2"
                })) : wx.navigateTo({
                    url: "/mzhk_sun/pages/backstage/backstage"
                });
            },
            fail: function(t) {
                var a = wx.getStorageSync("loginname");
                console.log("非绑定登陆，获取登陆信息"), console.log(a), a ? wx.navigateTo({
                    url: "/mzhk_sun/pages/backstage/index2/index2"
                }) : wx.navigateTo({
                    url: "/mzhk_sun/pages/backstage/backstage"
                });
            }
        });
    }
});