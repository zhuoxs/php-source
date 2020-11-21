var Page = require("../../../sdk/qitui/oddpush.js").oddPush(Page).Page, app = getApp(), tool = require("../../../../style/utils/countDown.js"), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        kanjia: [],
        guess: [],
        activeList: [],
        navTile: "套餐详情",
        showModalStatus: !1,
        imgsrc: "",
        bargainList: [ {
            endTime: "1523519898765",
            clock: ""
        } ],
        is_modal_Hidden: !0,
        viptype: "0",
        hidden: !0,
        showStatus: !0,
        thumb: "",
        nickname: "",
        swiperIndex: 1,
        showgw: 0,
        wglist: [],
        wg_flag: 0,
        arrowStatu: !1,
        rid: 0,
        uid: 0,
        isshare: 0,
        oid: 0,
        isPackage: !1,
        nav: [ "商品详情", "商品评论" ],
        starnums: 5,
        page: 1,
        curIndex: 0,
        showModalStatus2: 0
    },
    onLoad: function(a) {
        var e = this, t = (a = app.func.decodeScene(a)).id;
        if (t <= 0 || !t) return wx.showModal({
            title: "提示",
            content: "参数错误，获取不到商品，点击确认跳转到首页",
            showCancel: !1,
            success: function(t) {
                wx.reLaunch({
                    url: "/mzhk_sun/pages/index/index"
                });
            }
        }), !1;
        e.setData({
            id: a.id,
            options: a
        });
        var o = app.getSiteUrl();
        o ? e.setData({
            url: o
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), o = t.data, e.setData({
                    url: o
                });
            }
        }), wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var n = wx.getStorageSync("System");
        wx.setNavigationBarColor({
            frontColor: n.fontcolor ? n.fontcolor : "",
            backgroundColor: n.color ? n.color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), e.setData({
            store_open: n.store_open ? n.store_open : 0
        });
        var i = n.showgw;
        if (1 == i) {
            var s = {
                wg_title: n.wg_title,
                wg_directions: n.wg_directions,
                wg_img: n.wg_img,
                wg_keyword: n.wg_keyword,
                wg_addicon: n.wg_addicon
            };
            e.setData({
                showgw: i,
                wglist: s
            });
        }
        app.wxauthSetting(), console.log(a);
        var c = a.is_redshare, r = a.rid, d = a.user_id, u = a.oid;
        c && r && d && u && e.setData({
            rid: r,
            uid: d,
            isshare: c,
            oid: u
        }), console.log("options"), console.log(a), app.util.request({
            url: "entry/wxapp/KJdetails",
            data: {
                id: t,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log("商品信息s"), console.log(t.data), e.setData({
                    activeList: t.data
                });
                var a = t.data.content;
                WxParse.wxParse("content", "html", a, e, 10), console.log("商品信息e");
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1,
                    success: function(t) {
                        1 == a.is_share ? wx.redirectTo({
                            url: "/mzhk_sun/pages/index/bargain/bargain"
                        }) : wx.navigateBack({
                            delta: 1
                        });
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 5
            },
            showLoading: !1,
            success: function(t) {
                2 != t.data && t.data && app.util.request({
                    url: "entry/wxapp/GoodsRedpacket",
                    data: {
                        id: e.data.id,
                        openid: wx.getStorageSync("openid"),
                        m: app.globalData.Plugin_redpacket
                    },
                    showLoading: !1,
                    success: function(t) {
                        console.log(t.data), 2 != t.data ? e.setData({
                            rpcontent: t.data,
                            isgive: t.data.isgive
                        }) : e.setData({
                            relation: t.data
                        });
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 9
            },
            showLoading: !1,
            success: function(t) {
                console.log(t), e.setData({
                    open_lottery: t.data.is_openzx
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
    max: function(t) {
        var a = t.currentTarget.dataset.address, e = Number(t.currentTarget.dataset.longitude), o = Number(t.currentTarget.dataset.latitude);
        if (0 == e && 0 == o) return wx.showToast({
            title: "该地址有问题，可能无法显示~",
            icon: "none",
            duration: 1e3
        }), !1;
        wx.openLocation({
            name: a,
            latitude: o,
            longitude: e,
            scale: 18,
            address: a
        });
    },
    dialogue: function(t) {
        var a = t.currentTarget.dataset.phone;
        console.log(a), wx.makePhoneCall({
            phoneNumber: a
        });
    },
    toIndex: function(t) {
        wx.reLaunch({
            url: "/mzhk_sun/pages/index/index"
        });
    },
    shareCanvas: function() {
        var t = this, a = wx.getStorageSync("System"), e = t.data.activeList, o = [];
        o.codetype = a.ispnumber, o.goodspicbg = a.goodspicbg, o.gid = e.gid, o.bname = e.gname, 
        o.url = t.data.url, o.logo = e.pic, o.shopprice = e.shopprice, o.kjprice = e.kjprice;
        var n = wx.getStorageSync("users");
        o.tabletype = 1, o.scene = "d_user_id=" + n.id + "&id=" + t.data.id, app.creatPoster("mzhk_sun/pages/index/bardet/bardet", 430, o, 3, "shareImg");
    },
    shareCanvas_help: function() {
        var t = this, a = wx.getStorageSync("System"), e = t.data.kanjia.cs_id, o = t.data.activeList, n = [];
        n.goodspicbg = a.goodspicbg, n.bname = o.gname, n.url = t.data.url, n.logo = o.pic, 
        n.tabletype = 1, n.sharetitle = o.biaoti ? o.biaoti : "老铁，快来帮我砍一刀，快来支援我", n.scene = "cs_id=" + e + "&id=" + t.data.id + "&is_share=1", 
        app.creatPoster("mzhk_sun/pages/index/help/help", 430, n, 6, "shareImg"), this.setData({
            showStatus: !0
        });
    },
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
                console.log("成功"), wx.showModal({
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
    toMember: function(t) {
        wx.navigateTo({
            url: "../../member/member"
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        app.func.islogin(app, e);
        var t = e.data.options;
        t.d_user_id && app.distribution.distribution_parsent(app, t.d_user_id), app.util.request({
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
        var a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ISVIP",
            cachetime: "0",
            data: {
                openid: a
            },
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                console.log("vip"), console.log(t.data), e.setData({
                    viptype: t.data.viptype
                });
            }
        });
        var o = e.data.id;
        app.util.request({
            url: "entry/wxapp/ISkanjia",
            data: {
                id: o,
                openid: a
            },
            success: function(t) {
                console.log("查询是否已经砍过价了"), console.log(t);
                var a = t.data.status;
                e.setData({
                    join: a,
                    kanjia: t.data
                });
            }
        });
        var n = e.data.isshare, i = e.data.rid, s = e.data.uid, c = e.data.oid;
        a = wx.getStorageSync("openid");
        console.log(n), console.log(i), console.log(s), console.log(c), console.log(a), 
        1 == n && 0 < i && 0 < s && 0 < c && a && app.util.request({
            url: "entry/wxapp/InsertRedPacket3",
            showLoading: !1,
            data: {
                rid: i,
                uid: s,
                oid: c,
                openid: a,
                m: app.globalData.Plugin_redpacket
            },
            success: function(t) {
                222 != t.data && e.setData({
                    rcontent: t.data,
                    isPackage: !0
                });
            }
        });
        o = e.data.id;
        console.log(o), app.util.request({
            url: "entry/wxapp/Recdetail",
            data: {
                id: o,
                type: 2
            },
            showLoading: !1,
            success: function(t) {
                console.log(t.data), 2 != t.data && e.setData({
                    guess: t.data
                });
            }
        });
    },
    countDownClock: function() {
        var t = "", a = this.data.activeList, e = tool.countDown(this, a.enftime);
        if (!e) return !(t = "已经截止");
        t = "距离结束还剩：" + e[0] + "天" + e[1] + "时" + e[3] + "分" + e[4] + "秒", this.setData({
            clock: t
        });
    },
    getUrl: function() {
        var a = this, e = app.getSiteUrl();
        e ? a.setData({
            url: e
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e = t.data, a.setData({
                    url: e
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {
        clearTimeout(app.globalData.timer_slideupshoworder);
    },
    onPullDownRefresh: function() {
        this.onShow(), wx.stopPullDownRefresh();
    },
    onReachBottom: function() {
        var e = this, o = e.data.page, t = wx.getStorageSync("openid"), n = e.data.activeList, i = n.comments, a = e.data.id;
        1 == e.data.curIndex && app.util.request({
            url: "entry/wxapp/KJdetails",
            data: {
                id: a,
                openid: t,
                page: o
            },
            success: function(t) {
                if (console.log(t.data.comments), t.data.comments.length <= 0) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var a = t.data.comments;
                    i = i.concat(a), n.comments = i, e.setData({
                        activeList: n,
                        page: o + 1
                    });
                }
            }
        });
    },
    onShareAppMessage: function(t) {
        console.log("分享");
        var a = this, e = a.data.activeList, o = e.gid, n = a.data.kanjia, i = n.cs_id, s = a.data.url;
        console.log(e), console.log(n);
        var c = (e.biaoti ? e.biaoti + "：" : "") + e.gname;
        if (console.log(o), "button" === t.from) {
            var r = a.data.activeList.cj.gname, d = a.data.activeList.cj.onename, u = wx.getStorageSync("users").id, l = a.data.activeList.cj.gid;
            if (2 == t.target.dataset.cid) r = "红包 " + a.data.product.gname + " 元"; else {
                console.log(222);
                r = d || r;
            }
            return {
                title: wx.getStorageSync("users").name + "邀你参与[" + r + "]抽奖",
                path: 0 != a.data.activeList.cj.oid ? "/mzhk_sun/plugin4/ticket/ticketmiandetail/ticketmiandetail?gid=" + l + "&invuid=" + u : "/mzhk_sun/plugin4/ticket/ticketmiandetail/ticketmiandetail?gid=" + l,
                success: function(t) {},
                fail: function(t) {}
            };
        }
        app.util.request({
            url: "entry/wxapp/UpdateGoods",
            data: {
                id: o,
                typeid: 2
            },
            success: function(t) {
                console.log("更新数据"), console.log(t.data);
            }
        });
        var g = wx.getStorageSync("users");
        if (0 < i) var p = "/mzhk_sun/pages/index/help/help?id=" + o + "&cs_id=" + i + "&is_share=1"; else p = "/mzhk_sun/pages/index/bardet/bardet?id=" + o + "&is_share=1&d_user_id=" + g.id;
        return {
            title: c,
            path: p,
            imageUrl: s + e.lb_imgs[0],
            success: function(t) {
                a.setData({
                    showModalStatus: !1
                }), console.log("转发成功");
            },
            fail: function(t) {
                console.log("转发失败"), a.setData({
                    showModalStatus: !1
                });
            }
        };
    },
    order: function(t) {},
    showShareModel: function(t) {
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
                    title: "禁止参与",
                    icon: "loading",
                    duration: 2e3
                }), tourl = "/mzhk_sun/pages/index/index", wx.redirectTo({
                    url: tourl
                }), !1;
            }
        });
        var e = t.currentTarget.dataset.id, o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/CheckGoodsStatus",
            cachetime: "0",
            data: {
                gid: e,
                openid: o,
                ltype: 2
            },
            success: function(t) {
                a.setData({
                    showStatus: !1
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
    },
    CloseShareModel: function(t) {
        this.setData({
            showStatus: !0
        });
    },
    powerDrawer: function(t) {
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
                    title: "禁止参与",
                    icon: "loading",
                    duration: 2e3
                }), tourl = "/mzhk_sun/pages/index/index", wx.redirectTo({
                    url: tourl
                }), !1;
            }
        });
        var e = t.currentTarget.dataset.statu, o = t.currentTarget.dataset.join;
        if ("open" == e) {
            var n = t.currentTarget.dataset.id, i = wx.getStorageSync("openid");
            app.util.request({
                url: "entry/wxapp/CheckGoodsStatus",
                cachetime: "0",
                data: {
                    gid: n,
                    openid: i,
                    ltype: 2
                },
                success: function(t) {
                    console.log(t.data), app.util.request({
                        url: "entry/wxapp/ZKanjia",
                        cachetime: "0",
                        data: {
                            gid: n,
                            openid: i
                        },
                        success: function(t) {
                            console.log("砍价"), console.log(t.data), a.setData({
                                kanjia: t.data,
                                join: o
                            }), a.util(e);
                        }
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
        } else a.util(e);
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
            a.opacity(1).height("488rpx").step(), this.setData({
                animationData: a
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    help: function(t) {
        wx.updateShareMenu({
            withShareTicket: !0,
            success: function() {}
        });
    },
    toCforder: function(t) {
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
                }), tourl = "/mzhk_sun/pages/index/index", wx.redirectTo({
                    url: tourl
                }), !1;
            }
        });
        var a = t.currentTarget.dataset.id, e = t.currentTarget.dataset.price, o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/CheckGoodsStatus",
            cachetime: "0",
            data: {
                gid: a,
                openid: o,
                ltype: 2,
                isbuy: 1
            },
            success: function(t) {
                console.log(t.data), wx.navigateTo({
                    url: "../../member/cforder/cforder?id=" + a + "&price=" + e
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
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    },
    swiperChange: function(t) {
        this.setData({
            swiperIndex: t.detail.current + 1
        });
    },
    tapArrow: function() {
        var t = !this.data.arrowStatu;
        this.setData({
            arrowStatu: t
        });
    },
    toPackageReceive: function(t) {
        wx.navigateTo({
            url: "/mzhk_sun/plugin/redpacket/packageReceive/packageReceive"
        });
    },
    onPackage: function() {
        this.setData({
            isPackage: !this.data.isPackage
        });
    },
    navTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: a
        });
    },
    pturl: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/mzhk_sun/pages/index/bardet/bardet?id=" + a
        });
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
    },
    toCj: function() {
        wx.navigateTo({
            url: "/mzhk_sun/plugin4/ticket/ticketmiandetail/ticketmiandetail?gid=" + this.data.activeList.cj.gid
        });
    },
    goTicketnum: function(t) {
        var a = this.data.activeList.cj.gid;
        wx.navigateTo({
            url: "/mzhk_sun/plugin4/ticket/ticketnum/ticketnum?gid=" + a
        });
    }
});