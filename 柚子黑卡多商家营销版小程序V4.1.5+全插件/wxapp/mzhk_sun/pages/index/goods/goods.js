var Page = require("../../../sdk/qitui/oddpush.js").oddPush(Page).Page, app = getApp(), tool = require("../../../../style/utils/countDown.js"), WxParse = require("../../wxParse/wxParse.js");

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
        hidden: !0,
        nav: [ "商品详情", "商品评论" ],
        bargainList: "1527519898765",
        is_modal_Hidden: !0,
        viptype: "0",
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
    onLoad: function(t) {
        var a = this;
        t = app.func.decodeScene(t), a.setData({
            options: t
        }), wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var e = app.getSiteUrl();
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
        }), app.wxauthSetting();
        var i = t.is_redshare, n = t.rid, s = t.user_id, o = t.oid;
        i && n && s && o && a.setData({
            rid: n,
            uid: s,
            isshare: i,
            oid: o
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
            var c = {
                wg_title: r.wg_title,
                wg_directions: r.wg_directions,
                wg_img: r.wg_img,
                wg_keyword: r.wg_keyword,
                wg_addicon: r.wg_addicon
            };
            a.setData({
                showgw: d,
                wglist: c
            });
        }
        a.setData({
            id: t.gid
        }), app.util.request({
            url: "entry/wxapp/QGdetails",
            cachetime: "30",
            data: {
                id: a.data.id,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                a.setData({
                    activeList: t.data
                });
                var e = t.data.content;
                WxParse.wxParse("content", "html", e, a, 10), a.getUrl();
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
                        id: a.data.id,
                        openid: wx.getStorageSync("openid"),
                        m: app.globalData.Plugin_redpacket
                    },
                    showLoading: !1,
                    success: function(t) {
                        2 != t.data ? a.setData({
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
                a.setData({
                    open_lottery: t.data.is_openzx
                });
            }
        });
    },
    showwgtable: function(t) {
        var e = t.currentTarget.dataset.flag;
        this.setData({
            wg_flag: e
        });
    },
    toMember: function(t) {
        wx.navigateTo({
            url: "../../member/member"
        });
    },
    dialogue: function(t) {
        var e = t.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: e
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
    onReady: function() {},
    onShow: function() {
        var e = this;
        e.islogin();
        var t = e.data.options;
        t.d_user_id && app.distribution.distribution_parsent(app, t.d_user_id), app.util.request({
            url: "entry/wxapp/UpdateGoods",
            data: {
                id: e.data.id,
                typeid: 1
            },
            success: function(t) {}
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
                e.setData({
                    viptype: t.data.viptype
                });
            }
        });
        var i = e.data.isshare, n = e.data.rid, s = e.data.uid, o = e.data.oid;
        a = wx.getStorageSync("openid");
        1 == i && 0 < n && 0 < s && 0 < o && a && app.util.request({
            url: "entry/wxapp/InsertRedPacket3",
            showLoading: !1,
            data: {
                rid: n,
                uid: s,
                oid: o,
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
        var r = e.data.id;
        app.util.request({
            url: "entry/wxapp/Recdetail",
            data: {
                id: r,
                type: 1
            },
            showLoading: !1,
            success: function(t) {
                2 != t.data && e.setData({
                    guess: t.data
                });
            }
        });
    },
    islogin: function() {
        var e = this;
        wx.getStorageSync("have_wxauth") || wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] ? (wx.setStorageSync("have_wxauth", 1), wx.getUserInfo({
                    success: function(t) {
                        e.setData({
                            is_modal_Hidden: !0
                        });
                    }
                })) : e.setData({
                    is_modal_Hidden: !1
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
        var a = this, i = a.data.page, t = wx.getStorageSync("openid"), n = a.data.activeList, s = n.comments, e = a.data.id;
        1 == a.data.curIndex && app.util.request({
            url: "entry/wxapp/QGdetails",
            data: {
                id: e,
                openid: t,
                page: i
            },
            success: function(t) {
                if (t.data.comments.length <= 0) wx.showToast({
                    title: "已经没有内容了哦！！！",
                    icon: "none"
                }); else {
                    var e = t.data.comments;
                    s = s.concat(e), n.comments = s, a.setData({
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
            var n = e.data.activeList.cj.gname, s = e.data.activeList.cj.onename, o = wx.getStorageSync("users").id, r = e.data.activeList.cj.gid;
            if (2 == t.target.dataset.cid) n = "红包 " + e.data.product.gname + " 元"; else n = s || n;
            return {
                title: wx.getStorageSync("users").name + "邀你参与[" + n + "]抽奖",
                path: 0 != e.data.activeList.cj.oid ? "/mzhk_sun/plugin4/ticket/ticketmiandetail/ticketmiandetail?gid=" + r + "&invuid=" + o : "/mzhk_sun/plugin4/ticket/ticketmiandetail/ticketmiandetail?gid=" + r,
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
            success: function(t) {}
        });
        var d = (e.data.activeList.biaoti ? e.data.activeList.biaoti + "：" : "") + e.data.activeList.gname, c = wx.getStorageSync("users");
        return {
            title: d,
            path: "/mzhk_sun/pages/index/goods/goods?gid=" + e.data.id + "&is_share=1&d_user_id=" + c.id,
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
                }), tourl = "/mzhk_sun/pages/index/index", void wx.redirectTo({
                    url: tourl
                });
            }
        });
        var e = t.currentTarget.dataset.id, a = t.currentTarget.dataset.price, i = this.data.activeList;
        0 < this.data.viptype && (a = 0 < i.vipprice ? i.vipprice : a), app.util.request({
            url: "entry/wxapp/timeover",
            cachetime: "0",
            showLoading: !1,
            data: {
                id: e
            },
            success: function(t) {
                wx.navigateTo({
                    url: "../../member/order/order?id=" + e + "&price=" + a + "&typeid=1"
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
        app.wxauthSetting();
    },
    shareCanvas: function() {
        var t = wx.getStorageSync("System"), e = this.data.activeList, a = [];
        a.codetype = t.ispnumber, a.gid = e.gid, a.goodspicbg = t.goodspicbg, a.bname = e.gname, 
        a.url = this.data.url, a.logo = e.pic, a.shopprice = e.shopprice, a.vipprice = e.vipprice, 
        a.tabletype = 1;
        var i = wx.getStorageSync("users");
        a.scene = "d_user_id=" + i.id + "&gid=" + this.data.id, app.creatPoster("mzhk_sun/pages/index/goods/goods", 430, a, 8, "shareImg");
    },
    hidden: function(t) {
        this.setData({
            hidden: !0
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
                        t.confirm && e.setData({
                            hidden: !0
                        });
                    }
                });
            },
            fail: function(t) {
                wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.writePhotosAlbum"] || wx.openSetting({
                            success: function(t) {}
                        });
                    }
                });
            }
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
            url: "/mzhk_sun/pages/index/goods/goods?gid=" + e
        });
    },
    toApply: function(t) {
        var e = this, a = t.currentTarget.dataset.statu, i = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/GetstoreNotice2",
            cachetime: "30",
            data: {
                openid: i
            },
            success: function(t) {
                2 == t.data.data ? e.toBackstage() : e.setData({
                    storenotice: t.data.data.notice,
                    showModalStatus: a
                });
            }
        });
    },
    toBackstage: function(t) {
        var e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/CheckBrandUser",
            cachetime: "0",
            data: {
                openid: e
            },
            success: function(t) {
                t.data ? (wx.setStorageSync("brand_info", t.data.data), app.globalData.islogin = 1, 
                wx.navigateTo({
                    url: "/mzhk_sun/pages/backstage/index2/index2"
                })) : wx.navigateTo({
                    url: "/mzhk_sun/pages/backstage/backstage"
                });
            },
            fail: function(t) {
                wx.getStorageSync("loginname") ? wx.navigateTo({
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
        var s = this, o = this.data.activeList, r = [ {
            gid: o.gid,
            gname: o.gname,
            is_vip: o.is_vip,
            is_delivery: o.is_delivery,
            is_delivery_limit: o.is_delivery_limit,
            delivery_limit: o.delivery_limit,
            num: 1,
            pic: o.pic
        } ];
        if (1 == o.is_vip && this.data.viptype <= 0) return wx.showToast({
            title: "该商品为会员专属",
            duration: 2e3,
            icon: "none"
        }), !1;
        app.util.request({
            url: "entry/wxapp/psnum",
            data: {
                gid: o.gid,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                if (0 < t.data.num) if (o.is_delivery_limit - 0 == 1) if (0 < t.data.delivery_limit - 0 - (t.data.total - 0)) {
                    0 < o.vipprice - 0 && 0 < s.data.viptype ? r[0].money = parseFloat(s.data.activeList.vipprice - 0) : r[0].money = parseFloat(o.shopprice - 0);
                    var e = wx.getStorageSync("cars"), a = wx.getStorageSync("car_price");
                    if (e) if (e[o.bid]) {
                        if (!e[o.bid].info.every(function(t) {
                            return t.gid != r[0].gid;
                        })) return wx.showToast({
                            title: "购物车已有该商品",
                            icon: "none",
                            duration: 2e3
                        }), !1;
                        e[o.bid].info.push(r[0]);
                    } else e[o.bid] = {}, e[o.bid].info = r, e[o.bid].name = o.bname, e[o.bid].delivery_start = o.delivery_start[0].delivery_start; else (e = new Object())[o.bid] = {}, 
                    e[o.bid].info = r, e[o.bid].name = o.bname, e[o.bid].delivery_start = o.delivery_start[0].delivery_start;
                    a ? a[o.bid] ? a[o.bid] = parseFloat(a[o.bid] - 0 + (r[0].money - 0)).toFixed(2) : a[o.bid] = parseFloat(r[0].money - 0).toFixed(2) : (a = new Object())[o.bid] = parseFloat(r[0].money).toFixed(2), 
                    wx.setStorageSync("car_price", a), wx.setStorageSync("cars", e);
                } else wx.showToast({
                    title: "超出商品限购",
                    duration: 2e3,
                    icon: "none"
                }); else {
                    0 < o.vipprice - 0 && 0 < s.data.viptype ? r[0].money = parseFloat(o.vipprice - 0) : r[0].money = parseFloat(o.shopprice - 0);
                    var i = wx.getStorageSync("cars"), n = wx.getStorageSync("car_price");
                    if (i) if (i[o.bid]) {
                        if (!i[o.bid].info.every(function(t) {
                            return t.gid != r[0].gid;
                        })) return wx.showToast({
                            title: "购物车已有该商品",
                            icon: "none",
                            duration: 2e3
                        }), !1;
                        i[o.bid].info.push(r[0]);
                    } else i[o.bid] = {}, i[o.bid].info = r, i[o.bid].name = o.bname, i[o.bid].delivery_start = o.delivery_start[0].delivery_start; else (i = new Object())[o.bid] = {}, 
                    i[o.bid].info = r, i[o.bid].name = o.bname, i[o.bid].delivery_start = o.delivery_start[0].delivery_start;
                    n ? n[o.bid] ? n[o.bid] = parseFloat(n[o.bid] - 0 + (r[0].money - 0)).toFixed(2) : n[o.bid] = parseFloat(r[0].money - 0).toFixed(2) : (n = new Object())[o.bid] = parseFloat(r[0].money).toFixed(2), 
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