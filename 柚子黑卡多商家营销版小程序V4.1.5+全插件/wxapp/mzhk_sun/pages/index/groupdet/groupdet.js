var Page = require("../../../sdk/qitui/oddpush.js").oddPush(Page).Page, app = getApp(), tool = require("../../../../style/utils/countDown.js"), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        id: "",
        navTile: "活动详情",
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        activeList: [],
        lingshou: [],
        active: [],
        guess: [],
        curIndex: 0,
        nav: [ "商品详情", "商品评论" ],
        bargainList: [ {
            endTime: "1523519898765",
            clock: ""
        } ],
        isend: 1,
        is_modal_Hidden: !0,
        viptype: "0",
        hidden: !0,
        swiperIndex: 1,
        showgw: 0,
        wglist: [],
        wg_flag: 0,
        isendtitle: "",
        isloadWxParse: !1,
        rid: 0,
        uid: 0,
        isshare: 0,
        oid: 0,
        isPackage: !1,
        rpcontent: [],
        starnums: 5,
        page: 1,
        showModalStatus: 0,
        groups: !0,
        group_height: 570
    },
    onLoad: function(t) {
        var a = this;
        t = app.func.decodeScene(t), a.setData({
            options: t
        }), wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var e = t.id;
        if (e <= 0 || !e) return wx.showModal({
            title: "提示",
            content: "参数错误，获取不到商品，点击确认跳转到首页",
            showCancel: !1,
            success: function(t) {
                wx.reLaunch({
                    url: "/mzhk_sun/pages/index/index"
                });
            }
        }), !1;
        app.wxauthSetting(), console.log(t);
        var o = t.is_redshare, n = t.rid, i = t.user_id, s = t.oid;
        o && n && i && s && a.setData({
            rid: n,
            uid: i,
            isshare: o,
            oid: s
        }), a.setData({
            id: t.id
        });
        var c = app.getSiteUrl();
        c ? a.setData({
            url: c
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            showLoading: !1,
            success: function(t) {
                wx.setStorageSync("url", t.data), c = t.data, a.setData({
                    url: c
                });
            }
        });
        var r = wx.getStorageSync("System");
        wx.setNavigationBarColor({
            frontColor: r.fontcolor ? r.fontcolor : "",
            backgroundColor: r.color ? r.color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), a.setData({
            store_open: r.store_open ? r.store_open : 0
        });
        var d = r.showgw;
        if (1 == d) {
            var u = {
                wg_title: r.wg_title,
                wg_directions: r.wg_directions,
                wg_img: r.wg_img,
                wg_keyword: r.wg_keyword,
                wg_addicon: r.wg_addicon
            };
            a.setData({
                showgw: d,
                wglist: u
            });
        }
        app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 5
            },
            showLoading: !1,
            success: function(t) {
                2 != t.data && t.data && app.util.request({
                    url: "entry/wxapp/GoodsRedpacket",
                    data: {
                        id: a.data.id,
                        openid: wx.getStorageSync("openid"),
                        m: app.globalData.Plugin_redpacket
                    },
                    showLoading: !1,
                    success: function(t) {
                        console.log(t.data), 2 != t.data ? a.setData({
                            rpcontent: t.data,
                            isgive: t.data.isgive
                        }) : a.setData({
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
                console.log(t), a.setData({
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
    onReady: function() {},
    onShow: function() {
        var c = this;
        app.func.islogin(app, c), (a = c.data.options).d_user_id && app.distribution.distribution_parsent(app, a.d_user_id);
        var a = c.data.options;
        app.util.request({
            url: "entry/wxapp/UpdateGoods",
            showLoading: !1,
            data: {
                id: c.data.id,
                typeid: 1
            },
            success: function(t) {
                console.log("更新数据"), console.log(t.data);
            }
        });
        var t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ISVIP",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: t
            },
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                console.log("vip"), console.log(t.data), c.setData({
                    viptype: t.data.viptype
                });
            }
        });
        var r = c.data.isend;
        app.util.request({
            url: "entry/wxapp/PTdetails",
            cachetime: "30",
            showLoading: !1,
            method: "GET",
            data: {
                id: c.data.id,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                wx.setStorageSync("groupgoods" + t.data.gid, t.data), console.log("详情"), console.log(t.data), 
                c.setData({
                    activeList: t.data
                });
                var a = t.data.content, e = c.data.isloadWxParse;
                console.log(e), e || (c.setData({
                    isloadWxParse: !0
                }), a && WxParse.wxParse("content", "html", a, c, 10));
                var o, n = t.data, i = tool.countDown(c, n.enftime);
                console.log(i), i ? (n.clock = "离结束剩：" + i[0] + "天" + i[1] + "时" + i[3] + "分" + i[4] + "秒", 
                o = "", r = 0) : (n.clock = "已经截止", o = "已经结束", r = 1), c.setData({
                    activeList: n,
                    isend: r,
                    isendtitle: o
                });
                var s = setInterval(function() {
                    var t = tool.countDown(c, n.enftime);
                    t ? (n.clock = "离结束剩：" + t[0] + "天" + t[1] + "时" + t[3] + "分" + t[4] + "秒", o = "", 
                    r = 0) : (n.clock = "已经截止", o = "已经结束", clearInterval(s), r = 1), c.setData({
                        activeList: n,
                        isend: r,
                        isendtitle: o
                    });
                }, 1e3);
                c.gerdange();
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1,
                    success: function(t) {
                        1 == a.is_share ? wx.redirectTo({
                            url: "/mzhk_sun/pages/index/group/group"
                        }) : wx.navigateBack({
                            delta: 1
                        });
                    }
                });
            }
        });
        var e = c.data.isshare, o = c.data.rid, n = c.data.uid, i = c.data.oid;
        t = wx.getStorageSync("openid");
        console.log(e), console.log(o), console.log(n), console.log(i), console.log(t), 
        1 == e && 0 < o && 0 < n && 0 < i && t && app.util.request({
            url: "entry/wxapp/InsertRedPacket3",
            showLoading: !1,
            data: {
                rid: o,
                uid: n,
                oid: i,
                openid: t,
                m: app.globalData.Plugin_redpacket
            },
            success: function(t) {
                222 != t.data && c.setData({
                    rcontent: t.data,
                    isPackage: !0
                });
            }
        });
        var s = c.data.id;
        app.util.request({
            url: "entry/wxapp/Recdetail",
            data: {
                id: s,
                type: 3
            },
            showLoading: !1,
            success: function(t) {
                console.log(t.data), 2 != t.data && c.setData({
                    guess: t.data
                });
            }
        });
    },
    thegrouptime: function(t) {
        var a = tool.countDown(this, t.enftime);
        a ? (t.clock = "离结束剩：" + a[0] + "天" + a[1] + "时" + a[3] + "分" + a[4] + "秒", isend = 0) : (t.clock = "已经截止", 
        clearInterval(cdInterval), isend = 1), this.setData({
            activeList: t,
            isend: isend
        });
    },
    toMember: function(t) {
        wx.navigateTo({
            url: "../../member/member"
        });
    },
    getUrl: function() {
        var a = this, e = app.getSiteUrl();
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
        });
    },
    dialogue: function(t) {
        var a = t.currentTarget.dataset.phone;
        console.log(a), wx.makePhoneCall({
            phoneNumber: a
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
        var t = wx.getStorageSync("System"), a = this.data.activeList, e = [];
        e.codetype = t.ispnumber, e.goodspicbg = t.goodspicbg, e.gid = a.gid, e.bname = a.gname, 
        e.url = this.data.url, e.logo = a.pic, e.shopprice = a.shopprice, e.ptprice = a.ptprice;
        var o = wx.getStorageSync("users");
        e.scene = "d_user_id=" + o.id + "&id=" + this.data.id, e.tabletype = 1, app.creatPoster("mzhk_sun/pages/index/groupdet/groupdet", 430, e, 2, "shareImg");
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
    gerdange: function() {
        var a = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/danpin",
            showLoading: !1,
            cachetime: "30",
            method: "GET",
            data: {
                id: a.data.id,
                openid: t
            },
            success: function(t) {
                console.log("团单数据"), console.log(t), a.setData({
                    lingshou: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {
        clearTimeout(app.globalData.timer_slideupshoworder);
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this, o = e.data.page, t = wx.getStorageSync("openid"), n = e.data.activeList, i = n.comments, a = e.data.id;
        1 == e.data.curIndex && app.util.request({
            url: "entry/wxapp/PTdetails",
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
        var a = this, e = a.data.url, o = a.data.activeList;
        if ("button" === t.from) {
            var n = a.data.activeList.cj.gname, i = a.data.activeList.cj.onename, s = wx.getStorageSync("users").id, c = a.data.activeList.cj.gid;
            if (2 == t.target.dataset.cid) n = "红包 " + a.data.product.gname + " 元"; else {
                console.log(222);
                n = i || n;
            }
            return {
                title: wx.getStorageSync("users").name + "邀你参与[" + n + "]抽奖",
                path: 0 != a.data.activeList.cj.oid ? "/mzhk_sun/plugin4/ticket/ticketmiandetail/ticketmiandetail?gid=" + c + "&invuid=" + s : "/mzhk_sun/plugin4/ticket/ticketmiandetail/ticketmiandetail?gid=" + c,
                success: function(t) {},
                fail: function(t) {}
            };
        }
        app.util.request({
            url: "entry/wxapp/UpdateGoods",
            showLoading: !1,
            data: {
                id: a.data.id,
                typeid: 2
            },
            success: function(t) {
                console.log("更新数据"), console.log(t.data);
            }
        });
        var r = (a.data.activeList.biaoti ? a.data.activeList.biaoti + "：" : "") + a.data.activeList.gname, d = wx.getStorageSync("users");
        return {
            title: r,
            path: "/mzhk_sun/pages/index/groupdet/groupdet?id=" + a.data.id + "&is_share=1&d_user_id=" + d.id,
            imageUrl: e + o.lb_imgs[0]
        };
    },
    index: function(t) {
        wx.reLaunch({
            url: "../index"
        });
    },
    Alone: function(n) {
        var i = this;
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
                var a = n.currentTarget.dataset.id, e = n.currentTarget.dataset.price;
                if (i.data.isend) return wx.showModal({
                    title: "提示信息",
                    content: "该拼团商品已结束！！！",
                    showCancel: !1
                }), !1;
                var o = wx.getStorageSync("openid");
                app.util.request({
                    url: "entry/wxapp/CheckGoodsStatus",
                    cachetime: "0",
                    data: {
                        gid: a,
                        openid: o,
                        ltype: 1
                    },
                    success: function(t) {
                        console.log(t.data), wx.navigateTo({
                            url: "../../member/ptorder/ptorder?id=" + a + "&price=" + e + "&buytype=1"
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
    groups: function(n) {
        var i = this;
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
                var a = n.currentTarget.dataset.id, e = i.data.isend, o = wx.getStorageSync("openid");
                if (e) return wx.showModal({
                    title: "提示信息",
                    content: "该拼团商品已结束！！！",
                    showCancel: !1
                }), !1;
                app.util.request({
                    url: "entry/wxapp/CheckGoodsStatus",
                    cachetime: "0",
                    data: {
                        gid: a,
                        openid: o,
                        ltype: 1
                    },
                    success: function(t) {
                        console.log(t.data), wx.navigateTo({
                            url: "../../member/ptorder/ptorder?id=" + a
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
    gopt: function(t) {
        var a = this.data.viptype;
        if (1 == this.data.activeList.is_vip && 0 == a) return wx.showToast({
            title: "会员商品，请先开通会员",
            icon: "none",
            duration: 2e3
        }), !1;
        var e = t.currentTarget.dataset.id, o = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../../index/goCantuan/goCantuan?id=" + e + "&gid=" + o
        });
    },
    navTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: a
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
    pturl: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/mzhk_sun/pages/index/groupdet/groupdet?id=" + a
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
                    showModalStatus: e
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
    },
    change_group: function() {
        var t = this.data.groups;
        t && this.setData({
            groups: !1,
            group_height: ""
        }), t || this.setData({
            groups: !0,
            group_height: 570
        });
    }
});