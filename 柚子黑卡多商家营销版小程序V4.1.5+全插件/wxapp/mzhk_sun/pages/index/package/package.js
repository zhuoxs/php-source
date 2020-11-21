var app = getApp(), Page = require("../../../sdk/qitui/oddpush.js").oddPush(Page).Page, tool = require("../../../../style/utils/countDown.js"), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        status: !0,
        navTile: "套餐详情",
        indicatorDots: !1,
        autoplay: !1,
        interval: 3e3,
        duration: 800,
        packList: [],
        guess: [],
        curIndex: 0,
        nav: [ "商品详情", "商品评论" ],
        bargainList: "1527519898765",
        is_modal_Hidden: !0,
        viptype: "0",
        hidden: !0,
        swiperIndex: 1,
        isclose: !1,
        showgw: 0,
        wglist: [],
        wg_flag: 0,
        relation: 0,
        isgive: 0,
        rid: 0,
        uid: 0,
        isshare: 0,
        oid: 0,
        isPackage: !1,
        rpcontent: [],
        starnums: 5,
        page: 1,
        showModalStatus: 0
    },
    map: function(t) {
        wx.getLocation({
            type: "gcj02",
            success: function(t) {
                var e = t.latitude, a = t.longitude;
                wx.openLocation({
                    latitude: e,
                    longitude: a,
                    scale: 28
                });
            }
        });
    },
    onLoad: function(t) {
        var e = this;
        t = app.func.decodeScene(t), e.setData({
            options: t
        }), wx.setNavigationBarTitle({
            title: e.data.navTile
        });
        var a = app.getSiteUrl();
        a ? e.setData({
            url: a
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a = t.data, e.setData({
                    url: a
                });
            }
        }), app.wxauthSetting(), console.log(t);
        var i = t.is_redshare, n = t.rid, o = t.user_id, s = t.oid;
        i && n && o && s && e.setData({
            rid: n,
            uid: o,
            isshare: i,
            oid: s
        });
        var r = wx.getStorageSync("System");
        wx.setNavigationBarColor({
            frontColor: r.fontcolor ? r.fontcolor : "",
            backgroundColor: r.color ? r.color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), e.setData({
            store_open: r.store_open ? r.store_open : 0
        });
        var c = r.showgw;
        if (1 == c) {
            var d = {
                wg_title: r.wg_title,
                wg_directions: r.wg_directions,
                wg_img: r.wg_img,
                wg_keyword: r.wg_keyword,
                wg_addicon: r.wg_addicon
            };
            e.setData({
                showgw: c,
                wglist: d
            });
        }
        var l = t.id;
        if (l <= 0 || !l) return wx.showModal({
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
            id: t.id
        });
        e.data.isgive;
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
    hidden: function(t) {
        this.setData({
            hidden: !0
        });
    },
    showwgtable: function(t) {
        var e = t.currentTarget.dataset.flag;
        this.setData({
            wg_flag: e
        });
    },
    save: function() {
        var e = this;
        wx.saveImageToPhotosAlbum({
            filePath: e.data.prurl,
            success: function(t) {
                wx.showModal({
                    content: "图片已保存到相册，赶紧晒一下吧~",
                    showCancel: !1,
                    confirmText: "好哒",
                    confirmColor: "#ef8200",
                    success: function(t) {
                        t.confirm && (console.log("用户点击确定"), e.setData({
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
        var t = this, e = wx.getStorageSync("System"), a = t.data.activeList, i = [];
        i.codetype = e.ispnumber, i.gid = a.gid, i.goodspicbg = e.goodspicbg, i.bname = a.gname, 
        i.url = t.data.url, i.logo = a.pic, i.shopprice = a.shopprice, i.qgprice = a.qgprice;
        var n = wx.getStorageSync("users");
        i.scene = "d_user_id=" + n.id + "&id=" + t.data.id, i.tabletype = 1, app.creatPoster("mzhk_sun/pages/index/package/package", 430, i, 4, "shareImg");
    },
    toMember: function(t) {
        wx.navigateTo({
            url: "../../member/member"
        });
    },
    max: function(t) {
        var e = t.currentTarget.dataset.address, a = Number(t.currentTarget.dataset.longitude), i = Number(t.currentTarget.dataset.latitude);
        if (0 == a && 0 == i) return wx.showToast({
            title: "该地址有问题，可能无法显示~",
            icon: "none",
            duration: 1e3
        }), !1;
        wx.openLocation({
            name: e,
            latitude: i,
            longitude: a,
            scale: 18,
            address: e
        });
    },
    countDown: function(t) {
        var e = this, a = t, i = [], n = setInterval(function() {
            var t = tool.countDown(e, a);
            t ? (i[0] = t[0], i[1] = t[1], i[2] = t[3], i[3] = t[4]) : (e.setData({
                isclose: !0
            }), clearInterval(n), i[0] = "00", i[1] = "00", i[2] = "00", clcok[3] = "00"), e.setData({
                clock: i
            });
        }, 1e3);
    },
    onReady: function() {},
    dialogue: function(t) {
        var e = t.currentTarget.dataset.phone;
        console.log(e), wx.makePhoneCall({
            phoneNumber: e
        });
    },
    onShow: function() {
        var a = this;
        app.func.islogin(app, a);
        var e = a.data.options;
        e.d_user_id && app.distribution.distribution_parsent(app, e.d_user_id), app.util.request({
            url: "entry/wxapp/UpdateGoods",
            data: {
                id: a.data.id,
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
            data: {
                openid: t
            },
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                console.log("vip"), console.log(t.data), a.setData({
                    viptype: t.data.viptype
                });
            }
        });
        var i = a.data.isshare, n = a.data.rid, o = a.data.uid, s = a.data.oid;
        t = wx.getStorageSync("openid");
        console.log(i), console.log(n), console.log(o), console.log(s), console.log(t), 
        1 == i && 0 < n && 0 < o && 0 < s && t && app.util.request({
            url: "entry/wxapp/InsertRedPacket3",
            showLoading: !1,
            data: {
                rid: n,
                uid: o,
                oid: s,
                openid: t,
                m: app.globalData.Plugin_redpacket
            },
            success: function(t) {
                222 != t.data && a.setData({
                    rcontent: t.data,
                    isPackage: !0
                });
            }
        });
        var r, c = a.data.id;
        app.util.request({
            url: "entry/wxapp/Recdetail",
            data: {
                id: c,
                type: 5
            },
            showLoading: !1,
            success: function(t) {
                console.log(t.data), 2 != t.data && a.setData({
                    guess: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/QGdetails",
            cachetime: "30",
            data: {
                id: a.data.id,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log("获取数据"), console.log(t.data), r = t.data.clocktime, a.countDown(r), 
                a.setData({
                    activeList: t.data
                });
                var e = t.data.content;
                WxParse.wxParse("content", "html", e, a, 10), a.getUrl();
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示信息",
                    content: t.data.message,
                    showCancel: !1,
                    success: function(t) {
                        1 == e.is_share ? wx.redirectTo({
                            url: "/mzhk_sun/pages/index/timebuy/timebuy"
                        }) : wx.navigateBack({
                            delta: 1
                        });
                    }
                });
            }
        });
    },
    getUrl: function() {
        var e = this, a = app.getSiteUrl();
        a ? e.setData({
            url: a
        }) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a = t.data, e.setData({
                    url: a
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
        var a = this, i = a.data.page, t = wx.getStorageSync("openid"), n = a.data.activeList, o = n.comments, e = a.data.id;
        1 == a.data.curIndex && app.util.request({
            url: "entry/wxapp/QGdetails",
            data: {
                id: e,
                openid: t,
                page: i
            },
            success: function(t) {
                if (console.log(t.data.comments), t.data.comments.length <= 0) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var e = t.data.comments;
                    o = o.concat(e), n.comments = o, a.setData({
                        activeList: n,
                        page: i + 1
                    });
                }
            }
        });
    },
    onShareAppMessage: function(t) {
        var e = this, a = e.data.url, i = e.data.activeList;
        if ("button" === t.from) {
            var n = e.data.activeList.cj.gname, o = e.data.activeList.cj.onename, s = wx.getStorageSync("users").id, r = e.data.activeList.cj.gid;
            if (2 == t.target.dataset.cid) n = "红包 " + e.data.product.gname + " 元"; else {
                console.log(222);
                n = o || n;
            }
            return {
                title: wx.getStorageSync("users").name + "邀你参与[" + n + "]抽奖",
                path: 0 != e.data.activeList.cj.oid ? "/mzhk_sun/plugin4/ticket/ticketmiandetail/ticketmiandetail?gid=" + r + "&invuid=" + s : "/mzhk_sun/plugin4/ticket/ticketmiandetail/ticketmiandetail?gid=" + r,
                success: function(t) {},
                fail: function(t) {}
            };
        }
        app.util.request({
            url: "entry/wxapp/UpdateGoods",
            data: {
                id: e.data.id,
                typeid: 2
            },
            success: function(t) {
                console.log("更新数据"), console.log(t.data);
            }
        });
        var c = (e.data.activeList.biaoti ? e.data.activeList.biaoti + "：" : "") + e.data.activeList.gname, d = wx.getStorageSync("users");
        return {
            title: c,
            path: "/mzhk_sun/pages/index/package/package?id=" + e.data.id + "&is_share=1&d_user_id=" + d.id,
            imageUrl: a + i.lb_imgs[0]
        };
    },
    index: function(t) {
        wx.reLaunch({
            url: "../index"
        });
    },
    navTap: function(t) {
        var e = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: e
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
        var e = t.currentTarget.dataset.id, a = t.currentTarget.dataset.price, i = wx.getStorageSync("openid"), n = this.data.activeList;
        0 < this.data.viptype && (a = 0 < n.vipprice ? n.vipprice : a), app.util.request({
            url: "entry/wxapp/CheckGoodsStatus",
            cachetime: "10",
            data: {
                gid: e,
                openid: i,
                ltype: 0
            },
            success: function(t) {
                wx.navigateTo({
                    url: "../../member/order/order?id=" + e + "&price=" + a
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
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/mzhk_sun/pages/index/package/package?id=" + e
        });
    },
    toApply: function(t) {
        var e = this, a = t.currentTarget.dataset.statu, i = wx.getStorageSync("openid");
        console.log(a), console.log(i), app.util.request({
            url: "entry/wxapp/GetstoreNotice2",
            cachetime: "30",
            data: {
                openid: i
            },
            success: function(t) {
                console.log(t.data), 2 == t.data.data ? e.toBackstage() : e.setData({
                    storenotice: t.data.data.notice,
                    showModalStatus: a
                });
            }
        });
    },
    toBackstage: function(t) {
        var e = wx.getStorageSync("openid");
        console.log("商家管理入口"), app.util.request({
            url: "entry/wxapp/CheckBrandUser",
            cachetime: "0",
            data: {
                openid: e
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
                var e = wx.getStorageSync("loginname");
                console.log("非绑定登陆，获取登陆信息"), console.log(e), e ? wx.navigateTo({
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
        var e = this.data.activeList.cj.gid;
        wx.navigateTo({
            url: "/mzhk_sun/plugin4/ticket/ticketnum/ticketnum?gid=" + e
        });
    },
    addDeliveryCar: function(t) {
        var o = this, s = this.data.activeList, r = [ {
            gid: s.gid,
            gname: s.gname,
            is_vip: s.is_vip,
            is_delivery: s.is_delivery,
            is_delivery_limit: s.is_delivery_limit,
            delivery_limit: s.delivery_limit,
            num: 1,
            pic: s.pic
        } ];
        if (1 == s.is_vip && this.data.viptype <= 0) return wx.showToast({
            title: "该商品为会员专属",
            duration: 2e3,
            icon: "none"
        }), !1;
        app.util.request({
            url: "entry/wxapp/psnum",
            data: {
                gid: s.gid,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                if (0 < t.data.num) if (s.is_delivery_limit - 0 == 1) if (0 < t.data.delivery_limit - 0 - (t.data.total - 0)) {
                    0 < s.vipprice - 0 && 0 < o.data.viptype ? r[0].money = parseFloat(o.data.activeList.vipprice - 0) : r[0].money = parseFloat(s.qgprice - 0);
                    var e = wx.getStorageSync("cars"), a = wx.getStorageSync("car_price");
                    if (e) if (e[s.bid]) {
                        if (!e[s.bid].info.every(function(t) {
                            return t.gid != r[0].gid;
                        })) return wx.showToast({
                            title: "购物车已有该商品",
                            icon: "none",
                            duration: 2e3
                        }), !1;
                        e[s.bid].info.push(r[0]);
                    } else e[s.bid] = {}, e[s.bid].info = r, e[s.bid].name = s.bname, e[s.bid].delivery_start = s.delivery_start[0].delivery_start; else (e = new Object())[s.bid] = {}, 
                    e[s.bid].info = r, e[s.bid].name = s.bname, e[s.bid].delivery_start = s.delivery_start[0].delivery_start;
                    a ? a[s.bid] ? a[s.bid] = parseFloat(a[s.bid] - 0 + (r[0].money - 0)).toFixed(2) : a[s.bid] = parseFloat(r[0].money - 0).toFixed(2) : (a = new Object())[s.bid] = parseFloat(r[0].money).toFixed(2), 
                    wx.setStorageSync("car_price", a), wx.setStorageSync("cars", e);
                } else wx.showToast({
                    title: "超出商品限购",
                    duration: 2e3,
                    icon: "none"
                }); else {
                    0 < s.vipprice - 0 && 0 < o.data.viptype ? r[0].money = parseFloat(s.vipprice - 0) : r[0].money = parseFloat(s.qgprice - 0);
                    var i = wx.getStorageSync("cars"), n = wx.getStorageSync("car_price");
                    if (i) if (i[s.bid]) {
                        if (!i[s.bid].info.every(function(t) {
                            return t.gid != r[0].gid;
                        })) return wx.showToast({
                            title: "购物车已有该商品",
                            icon: "none",
                            duration: 2e3
                        }), !1;
                        i[s.bid].info.push(r[0]);
                    } else i[s.bid] = {}, i[s.bid].info = r, i[s.bid].name = s.bname, i[s.bid].delivery_start = s.delivery_start[0].delivery_start; else (i = new Object())[s.bid] = {}, 
                    i[s.bid].info = r, i[s.bid].name = s.bname, i[s.bid].delivery_start = s.delivery_start[0].delivery_start;
                    n ? n[s.bid] ? n[s.bid] = parseFloat(n[s.bid] - 0 + (r[0].money - 0)).toFixed(2) : n[s.bid] = parseFloat(r[0].money - 0).toFixed(2) : (n = new Object())[s.bid] = parseFloat(r[0].money).toFixed(2), 
                    wx.setStorageSync("car_price", n), wx.setStorageSync("cars", i);
                } else wx.showToast({
                    title: "商品库存不足",
                    icon: "none",
                    duration: 2e3
                });
            }
        });
    },
    toCars: function(t) {
        wx.navigateTo({
            url: "/mzhk_sun/plugin3/delivery/carList/carList"
        });
    }
});