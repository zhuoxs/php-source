var tool = require("../../../../style/utils/countDown.js"), app = getApp(), Page = require("../../../sdk/qitui/oddpush.js").oddPush(Page).Page, WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        status: !0,
        navTile: "套餐详情",
        indicatorDots: !1,
        autoplay: !1,
        guess: [],
        interval: 3e3,
        duration: 800,
        activeList: {},
        sid: "",
        shares: "",
        is_modal_Hidden: !0,
        winning: [],
        viptype: "0",
        showgw: 0,
        wglist: [],
        wg_flag: 0,
        hidden: !0,
        isloadWxParse: !1,
        shiptypetitle: [ "", "到店消费", "送货上门", "快递" ],
        showModalStatus: 0
    },
    onLoad: function(e) {
        var t = this, a = e.sid, o = e.shares;
        a && o && t.setData({
            sid: a,
            shares: o
        }), e = app.func.decodeScene(e), wx.setNavigationBarTitle({
            title: t.data.navTile
        });
        var n = e.id;
        (n <= 0 || !n) && wx.showModal({
            title: "提示",
            content: "参数错误，获取不到商品，点击确认跳转到首页",
            showCancel: !1,
            success: function(e) {
                wx.reLaunch({
                    url: "/mzhk_sun/pages/index/index"
                });
            }
        }), t.setData({
            id: e.id
        });
        var s = app.getSiteUrl();
        s ? (t.setData({
            url: s
        }), app.editTabBar(s)) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), s = e.data, app.editTabBar(s), t.setData({
                    url: s
                });
            }
        }), app.wxauthSetting();
        var i = wx.getStorageSync("System");
        wx.setNavigationBarColor({
            frontColor: i.fontcolor ? i.fontcolor : "",
            backgroundColor: i.color ? i.color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), t.setData({
            store_open: i.store_open ? i.store_open : 0
        });
        var r = i.showgw;
        if (1 == r) {
            var c = {
                wg_title: i.wg_title,
                wg_directions: i.wg_directions,
                wg_img: i.wg_img,
                wg_keyword: i.wg_keyword,
                wg_addicon: i.wg_addicon
            };
            t.setData({
                showgw: r,
                wglist: c
            });
        }
    },
    showwgtable: function(e) {
        var t = e.currentTarget.dataset.flag;
        this.setData({
            wg_flag: t
        });
    },
    onReady: function() {},
    onShow: function() {
        var n = this;
        app.func.islogin(app, n);
        var e = n.data.id;
        app.util.request({
            url: "entry/wxapp/UpdateGoods",
            data: {
                id: e,
                typeid: 1
            },
            success: function(e) {
                console.log("更新数据"), console.log(e.data);
            }
        });
        var t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ISVIP",
            cachetime: "0",
            data: {
                openid: t
            },
            header: {
                "content-type": "application/json"
            },
            success: function(e) {
                console.log("vip"), console.log(e.data), n.setData({
                    viptype: e.data.viptype
                });
            }
        }), app.util.request({
            url: "entry/wxapp/QGdetails",
            data: {
                id: e,
                showtype: 6,
                openid: t
            },
            success: function(e) {
                console.log("获取数据"), console.log(e.data), n.setData({
                    activeList: e.data
                });
                var t = e.data.content;
                n.data.isloadWxParse || (n.setData({
                    isloadWxParse: !0
                }), WxParse.wxParse("content", "html", t, n, 10));
                var a = n.data.sid, o = n.data.activeList;
                app.util.request({
                    url: "entry/wxapp/Codetype",
                    cachetime: "0",
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(e) {
                        1 == e.data.code_type && a && n.addhyorder(a, o);
                    }
                });
            }
        });
        e = n.data.id;
        app.util.request({
            url: "entry/wxapp/Recdetail",
            data: {
                id: e,
                type: 6
            },
            showLoading: !1,
            success: function(e) {
                console.log(e.data), 2 != e.data && n.setData({
                    guess: e.data
                });
            }
        });
    },
    toMember: function(e) {
        wx.navigateTo({
            url: "../../member/member"
        });
    },
    shareCanvas: function() {
        var e = this, t = wx.getStorageSync("System"), a = wx.getStorageSync("openid"), o = e.data.activeList, n = [];
        n.codetype = t.ispnumber, n.goodspicbg = t.goodspicbg, n.bname = o.gname, n.url = e.data.url, 
        n.logo = o.pic, n.astime = o.astime, n.antime = o.antime, n.scene = "id=" + e.data.id, 
        n.openid = "&shares=1&sid=" + a, n.tabletype = 1, app.creatPoster("mzhk_sun/pages/index/freedet/freedet", 430, n, 7, "shareImg");
    },
    hidden: function(e) {
        this.setData({
            hidden: !0
        });
    },
    save: function() {
        var t = this;
        wx.saveImageToPhotosAlbum({
            filePath: t.data.prurl,
            success: function(e) {
                wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(e) {
                        e.confirm && (console.log("用户点击确定"), t.setData({
                            hidden: !0
                        }));
                    }
                });
            },
            fail: function(e) {
                console.log("失败"), wx.getSetting({
                    success: function(e) {
                        e.authSetting["scope.writePhotosAlbum"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(e) {
                                console.log("openSetting success", e.authSetting);
                            }
                        }));
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
    onShareAppMessage: function() {
        console.log("分享");
        var e = this, t = wx.getStorageSync("openid");
        return app.util.request({
            url: "entry/wxapp/UpdateGoods",
            data: {
                id: e.data.id,
                typeid: 2
            },
            success: function(e) {
                console.log("更新数据"), console.log(e.data);
            }
        }), {
            title: (e.data.activeList.biaoti ? e.data.activeList.biaoti + "：" : "") + e.data.activeList.gname,
            path: "/mzhk_sun/pages/index/freedet/freedet?id=" + e.data.id + "&is_share=1&sid=" + t + "&shares=1"
        };
    },
    toShop: function(e) {
        var t = e.currentTarget.dataset.bid;
        wx.navigateTo({
            url: "../shop/shop?id=" + t
        });
    },
    toIndex: function(e) {
        wx.reLaunch({
            url: "../index"
        });
    },
    toApply: function(e) {
        app.util.request({
            url: "entry/wxapp/User",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(e) {
                if (1 == e.data) return wx.showToast({
                    title: "禁止购买",
                    icon: "loading",
                    duration: 2e3
                }), tourl = "/mzhk_sun/pages/index/index", wx.redirectTo({
                    url: tourl
                }), !1;
            }
        });
        var t = e.currentTarget.dataset.gid, a = wx.getStorageSync("openid"), o = this.data.sid, n = this.data.shares;
        app.util.request({
            url: "entry/wxapp/CheckGoodsStatus",
            cachetime: "0",
            data: {
                gid: t,
                ltype: 6,
                openid: a
            },
            success: function(e) {
                console.log(e.data), wx.navigateTo({
                    url: "../../member/hyorder/hyorder?id=" + t + "&price=0&sid=" + o + "&shares=" + n
                });
            },
            fail: function(e) {
                return wx.showModal({
                    title: "提示信息",
                    content: e.data.message,
                    showCancel: !1
                }), !1;
            }
        });
    },
    updateUserInfo: function(e) {
        console.log("授权操作更新");
        app.wxauthSetting();
    },
    addhyorder: function(e, t) {
        console.log("点击获取抽奖码");
        var a = {
            price: 0,
            id: t.gid,
            openid: e,
            uremark: "",
            cityName: "",
            detailInfo: "",
            countyName: "",
            name: "",
            sincetype: this.data.shiptypetitle[t.ship_type],
            provinceName: "",
            deliveryfee: 0,
            paytype: 1,
            click_openid: wx.getStorageSync("openid"),
            code: 1
        };
        app.util.request({
            url: "entry/wxapp/AddhyOrder",
            data: a,
            success: function(e) {
                console.log(e);
            }
        });
    },
    pturl: function(e) {
        var t = e.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/mzhk_sun/pages/index/freedet/freedet?id=" + t
        });
    },
    toApplys: function(e) {
        var t = this, a = e.currentTarget.dataset.statu, o = wx.getStorageSync("openid");
        console.log(a), console.log(o), app.util.request({
            url: "entry/wxapp/GetstoreNotice2",
            cachetime: "30",
            data: {
                openid: o
            },
            success: function(e) {
                console.log(e.data), 2 == e.data.data ? t.toBackstage() : t.setData({
                    storenotice: e.data.data.notice,
                    showModalStatus: a
                });
            }
        });
    },
    toBackstage: function(e) {
        var t = wx.getStorageSync("openid");
        console.log("商家管理入口"), app.util.request({
            url: "entry/wxapp/CheckBrandUser",
            cachetime: "0",
            data: {
                openid: t
            },
            success: function(e) {
                console.log("商家数据"), console.log(e.data), e.data ? (wx.setStorageSync("brand_info", e.data.data), 
                app.globalData.islogin = 1, wx.navigateTo({
                    url: "/mzhk_sun/pages/backstage/index2/index2"
                })) : wx.navigateTo({
                    url: "/mzhk_sun/pages/backstage/backstage"
                });
            },
            fail: function(e) {
                var t = wx.getStorageSync("loginname");
                console.log("非绑定登陆，获取登陆信息"), console.log(t), t ? wx.navigateTo({
                    url: "/mzhk_sun/pages/backstage/index2/index2"
                }) : wx.navigateTo({
                    url: "/mzhk_sun/pages/backstage/backstage"
                });
            }
        });
    }
});