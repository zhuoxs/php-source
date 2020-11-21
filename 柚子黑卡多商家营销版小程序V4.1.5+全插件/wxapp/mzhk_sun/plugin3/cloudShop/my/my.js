/*   time:2019-08-09 13:18:48*/
var _Page;

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t
}
var app = getApp(),
    Page = require("../../../sdk/qitui/oddpush.js").oddPush(Page).Page;
Page((_defineProperty(_Page = {
    data: {
        istocenter: 0,
        viptype: [],
        navTile: "我的",
        showModalStatus: 0,
        hklogo: "../../../style/images/hklogo.png",
        hkname: "柚子黑卡",
        storenotice: "须知",
        is_modal_Hidden: !0,
        storeinopen: !0,
        tabBar: app.globalData.tabBar,
        whichone: 3,
        whichonetwo: 18,
        userStyle: 999,
        mybanner: "",
        isopen_recharge: 0,
        open_distribution: !1,
        eatvisit_set: [],
        open_payment: 1,
        cturl: "/style/images/eatvisit.png",
        ckurl2: "/style/images/mysubcardorder.png",
        qyurl3: "/style/images/mymember.png",
        tcurl3: "/style/images/tc.png",
        cjurl3: "/style/images/cj3.png",
        fxurl: "/style/images/icon02.png",
        jfurl: "/style/images/icon_scoretask.png",
        lbqurl: "/style/images/icon_fission.png",
        hburl: "/style/images/eatvisit.png",
        ckurl: "/style/images/door.png",
        qyurl: "/style/images/qy.png",
        tcurl: "/style/images/tc2.png",
        cjurl: "/style/images/cj.png",
        qytext: "权益",
        cttext: "我的吃探",
        cktext2: "我的次卡",
        qytext3: "权益订单",
        fxtext: "分销中心",
        jftext: "积分任务",
        lbqtext: "裂变券",
        hbtext: "福袋",
        cktext: "次卡",
        tctext: "套餐",
        cjtext: "抽奖",
        cjtext3: "抽奖订单",
        tctext3: "套餐订单",
        commonOrder: [{
            name: "待付款",
            icon: "../../../style/images/icon03.png",
            tab: "1"
        }, {
            name: "待使用",
            icon: "../../../style/images/icon04.png",
            tab: "2"
        }, {
            name: "待收货",
            icon: "../../../style/images/icon05.png",
            tab: "3"
        }, {
            name: "完成/售后",
            icon: "../../../style/images/icon06.png",
            tab: "4"
        }],
        navigate: [{
            name: "普通订单",
            icon: "/style/images/icon016.png",
            bind: "toOrder"
        }, {
            name: "我的拼团",
            icon: "/style/images/icon07.png",
            bind: "toGroup"
        }, {
            name: "砍价订单",
            icon: "/style/images/icon08.png",
            bind: "toBargain"
        }, {
            name: "集卡订单",
            icon: "/style/images/icon09.png",
            bind: "tocardcollect"
        }, {
            name: "抢购订单",
            icon: "/style/images/icon010.png",
            bind: "toMyOrder"
        }, {
            name: "我的免单",
            icon: "/style/images/icon011.png",
            bind: "tofreeorder"
        }, {
            name: "我的优惠券",
            icon: "/style/images/icon012.png",
            bind: "toWelfare"
        }, {
            name: "我的赠送",
            icon: "/style/images/icon012.png",
            bind: "toReturn"
        }, {
            name: "配送订单",
            icon: "/style/images/icon010.png",
            bind: "toPsorder"
        }]
    },
    onLoad: function(t) {
        var n = this;
        t = app.func.decodeScene(t), console.log(t), t.d_user_id && (app.distribution.distribution_parsent(app, t.d_user_id), n.setData({
            options: t
        })), wx.setNavigationBarTitle({
            title: n.data.navTile
        });
        var o = app.getSiteUrl();
        o ? (n.setData({
            url: o
        }), app.editTabBar(o)) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                wx.setStorageSync("url", t.data), o = t.data, app.editTabBar(o), n.setData({
                    url: o
                })
            }
        }), app.wxauthSetting();
        var e = n.data.navigate,
            i = n.data.cturl,
            r = n.data.ckurl2,
            s = n.data.fxurl,
            d = n.data.jfurl,
            u = n.data.lbqurl,
            c = n.data.hburl,
            l = n.data.ckurl,
            p = n.data.qyurl,
            g = n.data.qyurl3,
            m = n.data.tcurl3,
            y = n.data.tcurl,
            x = n.data.cjurl3,
            h = n.data.cjurl,
            f = n.data.cttext,
            _ = n.data.cktext2,
            w = n.data.fxtext,
            k = n.data.jftext,
            b = n.data.lbqtext,
            v = n.data.hbtext,
            S = n.data.cktext,
            q = n.data.qytext,
            P = n.data.qytext3,
            T = n.data.tctext,
            z = n.data.tctext3,
            j = n.data.cjtext,
            D = n.data.cjtext3;
        app.util.request({
            url: "entry/wxapp/System",
            cachetime: "60",
            showLoading: !1,
            success: function(t) {
                console.log(t.data);
                var a = t.data.attachurl;
                wx.setStorageSync("url", a), wx.setNavigationBarColor({
                    frontColor: t.data.fontcolor ? t.data.fontcolor : "#000000",
                    backgroundColor: t.data.color ? t.data.color : "#ffffff",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                }), t.data.myicon && (e[0].icon = a + t.data.myicon), t.data.mypticon && (e[1].icon = a + t.data.mypticon), t.data.mykjicon && (e[2].icon = a + t.data.mykjicon), t.data.myjkicon && (e[3].icon = a + t.data.myjkicon), t.data.myqgicon && (e[4].icon = a + t.data.myqgicon), t.data.mymdicon && (e[5].icon = a + t.data.mymdicon), t.data.myyhqicon && (e[6].icon = a + t.data.myyhqicon), t.data.myzsicon && (e[7].icon = a + t.data.myzsicon), t.data.mypsicon && (e[8].icon = a + t.data.mypsicon), t.data.mycticon && (i = a + t.data.mycticon), t.data.myckicon2 && (i = a + t.data.myckicon2), t.data.myfxicon && (s = a + t.data.myfxicon), t.data.myjficon && (d = a + t.data.myjficon), t.data.mylbqicon && (u = a + t.data.mylbqicon), t.data.myhbicon && (c = a + t.data.myhbicon), t.data.myckicon && (l = a + t.data.myckicon), t.data.myqyicon && (p = a + t.data.myqyicon), t.data.myqyicon2 && (g = a + t.data.myqyicon2), t.data.mytcicon && (y = a + t.data.mytcicon), t.data.mytcicon2 && (m = a + t.data.mytcicon2), t.data.mycjicon && (h = a + t.data.mycjicon), t.data.mycjicon2 && (x = a + t.data.mycjicon2), t.data.mytext && (e[0].name = t.data.mytext), t.data.mypttext && (e[1].name = t.data.mypttext), t.data.mykjtext && (e[2].name = t.data.mykjtext), t.data.myjktext && (e[3].name = t.data.myjktext), t.data.myqgtext && (e[4].name = t.data.myqgtext), t.data.mymdtext && (e[5].name = t.data.mymdtext), t.data.myyhqtext && (e[6].name = t.data.myyhqtext), t.data.myzstext && (e[7].name = t.data.myzstext), t.data.mypstext && (e[8].name = t.data.mypstext), t.data.mycttext && (f = t.data.mycttext), t.data.mycktext2 && (_ = t.data.mycktext2), t.data.myfxtext && (w = t.data.myfxtext), t.data.myjftext && (k = t.data.myjftext), t.data.mylbqtext && (b = t.data.mylbqtext), t.data.myhbtext && (v = t.data.myhbtext), t.data.mycktext && (S = t.data.mycktext), t.data.myqytext && (q = t.data.myqytext), t.data.myqytext2 && (P = t.data.myqytext2), t.data.mytctext && (T = t.data.mytctext), t.data.mytctext2 && (z = t.data.mytctext2), t.data.mycjtext && (j = t.data.mycjtext), t.data.mycjtext2 && (D = t.data.mycjtext2), n.setData({
                    open_payment: t.data.open_payment,
                    openblackcard: t.data.openblackcard,
                    logo: t.data.hk_logo ? a + t.data.hk_logo : "",
                    pt_name: t.data.hk_tubiao ? t.data.hk_tubiao : "",
                    hk_bgimg: t.data.hk_bgimg ? a + t.data.hk_bgimg : "",
                    hk_namecolor: t.data.hk_namecolor ? t.data.hk_namecolor : "#f5ac32",
                    store_in_name: t.data.store_in_name ? t.data.store_in_name : "",
                    store_open: t.data.store_open ? t.data.store_open : 0,
                    hk_mytitle: t.data.hk_mytitle ? t.data.hk_mytitle : "会员卡专属特权•专属商品•折上折",
                    hk_mybgimg: t.data.hk_mybgimg ? a + t.data.hk_mybgimg : "",
                    hk_mytopimg: t.data.hk_mytopimg,
                    userStyle: t.data.mytheme ? t.data.mytheme : 0,
                    isopen_recharge: t.data.isopen_recharge ? t.data.isopen_recharge : 0,
                    navigate: e,
                    cturl: i,
                    ckurl2: r,
                    fxurl: s,
                    jfurl: d,
                    lbqurl: u,
                    hburl: c,
                    ckurl: l,
                    cttext: f,
                    cktext2: _,
                    fxtext: w,
                    jftext: k,
                    lbqtext: b,
                    hbtext: v,
                    cktext: S,
                    qytext: q,
                    qytext3: P,
                    qyurl: p,
                    qyurl3: g,
                    tctext: T,
                    tctext3: z,
                    tcurl: y,
                    tcurl3: m,
                    cjtext: j,
                    cjtext3: D,
                    cjurl: h,
                    cjurl3: x
                })
            }
        }), app.util.request({
            url: "entry/wxapp/GetadData",
            showLoading: !1,
            data: {
                inpos: "14"
            },
            success: function(t) {
                var a, e = t.data;
                2 != e ? (a = e.mybanner ? o + e.mybanner[0].pop_img : "../../../style/images/headbg.png", n.setData({
                    mybanner: a
                })) : n.setData({
                    mybanner: "../../../style/images/headbg.png"
                })
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 1
            },
            showLoading: !1,
            success: function(t) {
                var a = 2 != t.data && t.data;
                console.log("分销"), console.log(t.data), n.setData({
                    open_distribution: a
                })
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 3
            },
            showLoading: !1,
            success: function(t) {
                var a = 2 != t.data && t.data;
                n.setData({
                    open_scoretask: a
                })
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 4
            },
            showLoading: !1,
            success: function(t) {
                var a = 2 != t.data && t.data;
                n.setData({
                    open_fission: a
                })
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 5
            },
            showLoading: !1,
            success: function(t) {
                var a = 2 != t.data && t.data;
                n.setData({
                    open_redpacket: a
                })
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 7
            },
            showLoading: !1,
            success: function(t) {
                var a = 2 != t.data && t.data;
                n.setData({
                    open_subcard: a
                })
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 6,
                uid: wx.getStorageSync("users").id
            },
            showLoading: !1,
            success: function(t) {
                t.data.isopen && n.setData({
                    open_member: t.data.isopen
                })
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 8
            },
            showLoading: !1,
            success: function(t) {
                wx.setStorageSync("packageTitle", t.data.navname), n.setData({
                    open_package: t.data.isopen
                })
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 9
            },
            showLoading: !1,
            success: function(t) {
                console.log(t), n.setData({
                    open_lottery: t.data.is_openzx
                })
            }
        }), app.util.request({
            url: "entry/wxapp/CheckGroup",
            showLoading: !1,
            success: function(t) {
                console.log("成功"), console.log(t.data)
            }
        }), this.onCloudShopSet()
    },
    onReady: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 2
            },
            showLoading: !1,
            success: function(t) {
                var a = t.data;
                2 != a && e.setData({
                    eatvisit_set: a
                })
            }
        }), app.util.request({
            url: "entry/wxapp/GetadData",
            showLoading: !1,
            data: {
                position: 15
            },
            success: function(t) {
                var a = t.data;
                e.setData({
                    adbackcardimg: a || []
                })
            }
        })
    },
    gotoadinfo: function(t) {
        var a = t.currentTarget.dataset.tid,
            e = t.currentTarget.dataset.id;
        app.func.gotourl(app, a, e)
    },
    onShow: function() {
        var a = this;
        app.func.islogin(app, a), app.util.request({
            url: "entry/wxapp/url",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                })
            }
        }), a.GetVip(), a.toFxCenter2()
    },
    toFxCenter2: function() {
        var a = this,
            e = wx.getStorageSync("openid"),
            n = wx.getStorageSync("users"),
            t = a.data.options,
            o = a.data.istocenter;
        if (t) {
            var i = t.d_user_id;
            app.distribution.distribution_parsent(app, t.d_user_id)
        }
        console.log(t), console.log(o), console.log(e), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 1
            },
            showLoading: !1,
            success: function(t) {
                2 != t.data && t.data && i && 0 == o && e && app.util.request({
                    url: "entry/wxapp/IsPromoter",
                    data: {
                        openid: e,
                        form_id: 0,
                        uid: n.id,
                        status: 3,
                        m: app.globalData.Plugin_distribution
                    },
                    showLoading: !1,
                    success: function(t) {
                        t && 9 != t.data ? 0 == t.data || 222 == t.data ? wx.navigateTo({
                            url: "/mzhk_sun/plugin/distribution/fxAddShare/fxAddShare"
                        }) : 111 == t.data ? wx.navigateTo({
                            url: "/mzhk_sun/plugin/distribution/fxBuyShare/fxBuyShare"
                        }) : 333 == t.data ? wx.navigateTo({
                            url: "/mzhk_sun/plugin/distribution/fxVipShare/fxVipShare"
                        }) : 5 == t.data ? wx.navigateTo({
                            url: "/mzhk_sun/plugin/distribution/fxYqmShare/fxYqmShare"
                        }) : wx.navigateTo({
                            url: "/mzhk_sun/plugin/distribution/fxCenter/fxCenter"
                        }) : wx.navigateTo({
                            url: "/mzhk_sun/plugin/distribution/fxAddShare/fxAddShare"
                        }), a.setData({
                            istocenter: 1
                        })
                    }
                })
            }
        })
    },
    GetVip: function() {
        var a = this,
            t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ISVIP",
            showLoading: !1,
            data: {
                openid: t
            },
            success: function(t) {
                console.log("获取vip数据"), console.log(t), a.setData({
                    viptype: t.data
                })
            }
        })
    },
    onHide: function() {
        this.setData({
            showModalStatus: 0
        })
    },
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toMyOrder: function(t) {
        wx.navigateTo({
            url: "/mzhk_sun/pages/user/myorder/myorder?tab=0"
        })
    },
    toPsorder: function(t) {
        wx.navigateTo({
            url: "/mzhk_sun/pages/user/psOrder/psOrder"
        })
    },
    toOrder: function(t) {
        wx.navigateTo({
            url: "/mzhk_sun/pages/user/order/order?tab=0"
        })
    },
    toAwaitOrder: function(t) {
        wx.navigateTo({
            url: "order/order?tab=1"
        })
    },
    toShipOrder: function(t) {
        wx.navigateTo({
            url: "order/order?tab=2"
        })
    },
    toFinishOrder: function(t) {
        wx.navigateTo({
            url: "order/order?tab=3"
        })
    },
    toWelfare: function(t) {
        wx.navigateTo({
            url: "/mzhk_sun/pages/user/welfare/welfare"
        })
    },
    toGroup: function(t) {
        wx.navigateTo({
            url: "/mzhk_sun/pages/user/mygroup/mygroup"
        })
    },
    tocardcollect: function(t) {
        wx.navigateTo({
            url: "/mzhk_sun/pages/user/mycardcollect/mycardcollect"
        })
    },
    toBargain: function(t) {
        wx.navigateTo({
            url: "/mzhk_sun/pages/user/mybargain/mybargain"
        })
    },
    tofreeorder: function(t) {
        wx.navigateTo({
            url: "/mzhk_sun/pages/user/myfreeorder/myfreeorder"
        })
    },
    toApply: function(t) {
        wx.navigateTo({
            url: "apply/apply"
        })
    },
    toMember: function(t) {
        wx.navigateTo({
            url: "/mzhk_sun/pages/member/member"
        })
    },
    toReturn: function(t) {
        wx.navigateTo({
            url: "/mzhk_sun/pages/user/return/return"
        })
    },
    scanCode: function(t) {
        wx.scanCode({
            success: function(t) {
                if (console.log("扫描获取数据-成功"), console.log(t), "" == t.result) wx.navigateTo({
                    url: "/" + t.path
                });
                else {
                    var e = JSON.parse(t.result);
                    app.util.request({
                        url: "entry/wxapp/Payment",
                        cachetime: "0",
                        showLoading: !1,
                        data: {
                            bid: e.bid
                        },
                        success: function(t) {
                            if (console.log(t.data), 2 == t.data) return wx.showModal({
                                title: "提示",
                                content: "商家未开启线下付",
                                showCancel: !1
                            }), !1;
                            var a = "pay/pay?bid=" + e.bid;
                            wx.navigateTo({
                                url: a
                            })
                        }
                    })
                }
            }
        })
    },
    showModel: function(t) {
        var a = t.currentTarget.dataset.statu,
            e = wx.getStorageSync("openid"),
            n = this;
        app.util.request({
            url: "entry/wxapp/GetstoreNotice",
            cachetime: "30",
            data: {
                openid: e
            },
            success: function(t) {
                console.log("须知内容"), console.log(t.data), n.setData({
                    storenotice: t.data.data.notice,
                    showModalStatus: a
                })
            }
        })
    }
}, "toMember", function(t) {
    wx.navigateTo({
        url: "/mzhk_sun/pages/member/member"
    })
}), _defineProperty(_Page, "tosubcard", function(t) {
    wx.navigateTo({
        url: "/mzhk_sun/plugin2/secondary/list/list"
    })
}), _defineProperty(_Page, "tomember", function(t) {
    wx.navigateTo({
        url: "/mzhk_sun/pages/member/member?cur=2"
    })
}), _defineProperty(_Page, "tosubcardorder", function(t) {
    wx.navigateTo({
        url: "/mzhk_sun/plugin2/secondary/userorder/userorder"
    })
}), _defineProperty(_Page, "tomMemberUserOrder", function(t) {
    wx.navigateTo({
        url: "/mzhk_sun/plugin2/member/memberUserOrder/memberUserOrder"
    })
}), _defineProperty(_Page, "toPackAgeOrder", function(t) {
    wx.navigateTo({
        url: "/mzhk_sun/plugin3/package/packageOrder/packageOrder"
    })
}), _defineProperty(_Page, "toLotteryOrder", function(t) {
    wx.navigateTo({
        url: "/mzhk_sun/plugin4/ticket/recordall/recordall"
    })
}), _defineProperty(_Page, "toBackstage", function(t) {
    var a = wx.getStorageSync("openid");
    console.log("商家管理入口"), app.util.request({
        url: "entry/wxapp/CheckBrandUser",
        cachetime: "0",
        data: {
            openid: a
        },
        success: function(t) {
            console.log("商家数据"), console.log(t.data), t.data ? (wx.setStorageSync("brand_info", t.data.data), app.globalData.islogin = 1, wx.navigateTo({
                url: "/mzhk_sun/pages/backstage/index2/index2"
            })) : wx.navigateTo({
                url: "/mzhk_sun/pages/backstage/backstage"
            })
        },
        fail: function(t) {
            var a = wx.getStorageSync("loginname");
            console.log("非绑定登陆，获取登陆信息"), console.log(a), a ? wx.navigateTo({
                url: "/mzhk_sun/pages/backstage/index2/index2"
            }) : wx.navigateTo({
                url: "/mzhk_sun/pages/backstage/backstage"
            })
        }
    })
}), _defineProperty(_Page, "updateUserInfo", function(t) {
    console.log("授权操作更新");
    app.wxauthSetting()
}), _defineProperty(_Page, "toMember", function(t) {
    wx.navigateTo({
        url: "/mzhk_sun/pages/member/member"
    })
}), _defineProperty(_Page, "topackage", function(t) {
    wx.navigateTo({
        url: "/mzhk_sun/plugin3/package/packageIndex/packageIndex"
    })
}), _defineProperty(_Page, "tolottery", function(t) {
    wx.navigateTo({
        url: "/mzhk_sun/plugin4/ticket/ticketmiannew/ticketmiannew"
    })
}), _defineProperty(_Page, "toFxCenter", function(t) {
    app.util.request({
        url: "entry/wxapp/User",
        cachetime: "0",
        showLoading: !1,
        data: {
            openid: wx.getStorageSync("openid")
        },
        success: function(t) {
            if (1 == t.data) return wx.showToast({
                title: "禁止参与",
                icon: "loading",
                duration: 2e3
            }), tourl = "/mzhk_sun/pages/index/index", wx.redirectTo({
                url: tourl
            }), !1
        }
    });
    this.data.open_distribution;
    var a = wx.getStorageSync("openid"),
        e = t.detail.formId,
        n = wx.getStorageSync("users");
    app.util.request({
        url: "entry/wxapp/IsPromoter",
        data: {
            openid: a,
            form_id: e,
            uid: n.id,
            status: 3,
            m: app.globalData.Plugin_distribution
        },
        showLoading: !1,
        success: function(t) {
            t && 9 != t.data ? 0 == t.data || 222 == t.data ? wx.navigateTo({
                url: "/mzhk_sun/plugin/distribution/fxAddShare/fxAddShare"
            }) : 111 == t.data ? wx.navigateTo({
                url: "/mzhk_sun/plugin/distribution/fxBuyShare/fxBuyShare"
            }) : 333 == t.data ? wx.navigateTo({
                url: "/mzhk_sun/plugin/distribution/fxVipShare/fxVipShare"
            }) : 5 == t.data ? wx.navigateTo({
                url: "/mzhk_sun/plugin/distribution/fxYqmShare/fxYqmShare"
            }) : wx.navigateTo({
                url: "/mzhk_sun/plugin/distribution/fxCenter/fxCenter"
            }) : wx.navigateTo({
                url: "/mzhk_sun/plugin/distribution/fxAddShare/fxAddShare"
            })
        }
    })
}), _defineProperty(_Page, "toCharge", function(t) {
    wx.navigateTo({
        url: "/mzhk_sun/pages/user/recharge/recharge"
    })
}), _defineProperty(_Page, "toEat", function(t) {
    wx.navigateTo({
        url: "/mzhk_sun/plugin/eatvisit/mycoupon/mycoupon"
    })
}), _defineProperty(_Page, "toScoretask", function(t) {
    app.util.request({
        url: "entry/wxapp/User",
        cachetime: "0",
        showLoading: !1,
        data: {
            openid: wx.getStorageSync("openid")
        },
        success: function(t) {
            if (1 == t.data) return wx.showToast({
                title: "禁止参与",
                icon: "loading",
                duration: 2e3
            }), tourl = "/mzhk_sun/pages/index/index", wx.redirectTo({
                url: tourl
            }), !1
        }
    }), wx.navigateTo({
        url: "/mzhk_sun/plugin/shoppingMall/home/home"
    })
}), _defineProperty(_Page, "toFission", function(t) {
    app.util.request({
        url: "entry/wxapp/User",
        cachetime: "0",
        showLoading: !1,
        data: {
            openid: wx.getStorageSync("openid")
        },
        success: function(t) {
            if (1 == t.data) return wx.showToast({
                title: "禁止参与",
                icon: "loading",
                duration: 2e3
            }), tourl = "/mzhk_sun/pages/index/index", wx.redirectTo({
                url: tourl
            }), !1
        }
    }), wx.navigateTo({
        url: "/mzhk_sun/pages/member/forder/forder"
    })
}), _defineProperty(_Page, "toRedpacket", function(t) {
    app.util.request({
        url: "entry/wxapp/User",
        cachetime: "0",
        showLoading: !1,
        data: {
            openid: wx.getStorageSync("openid")
        },
        success: function(t) {
            if (1 == t.data) return wx.showToast({
                title: "禁止参与",
                icon: "loading",
                duration: 2e3
            }), tourl = "/mzhk_sun/pages/index/index", wx.redirectTo({
                url: tourl
            }), !1
        }
    }), wx.navigateTo({
        url: "/mzhk_sun/plugin/redpacket/packageList/packageList"
    })
}), _defineProperty(_Page, "onCloudManagement", function() {
    wx.navigateTo({
        url: "/mzhk_sun/plugin3/cloudShop/managementCenter/managementCenter"
    })
}), _defineProperty(_Page, "onMyCloudShop", function() {
    wx.navigateTo({
        url: "/mzhk_sun/plugin3/cloudShop/myCloudShop/myCloudShop"
    })
}), _defineProperty(_Page, "onCloudShopSet", function() {
    var a = this;
    app.util.request({
        url: "entry/wxapp/CloudShopSet",
        data: {
            m: app.globalData.Plugin_cloud
        },
        success: function(t) {
            console.log("平台首页是否显示"), console.log(t), a.setData({
                toindex_open: t.data.toindex_open
            })
        }
    })
}), _Page));