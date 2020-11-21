var Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page, app = getApp(), setIndex = 0, s = require("../../../../zhy/template/wxParse/wxParse.js"), foot = require("../../../../zhy/component/comFooter/dealfoot.js");

Page({
    data: {
        curHdIndex: 0,
        page: 1,
        limit: 5,
        olist: [],
        flag: !1,
        num: 1,
        showModalStatus: !1,
        addCarStatus: !1,
        buyNow: !1,
        unitPrice: 0,
        addCount: 1,
        protect: !0,
        isRefresh: 1,
        currenttab: "0",
        isValue: !0,
        isValue1: !0,
        isShare: !1,
        isNav: !1,
        isAssemble: !1,
        isSharePage: !1,
        yesterdaySwitch: !1,
        spell: !1,
        unplug: !1,
        topListArr: [ "getgoodsesYesterday", "getPingoodses", "getgoodsesYesterday" ]
    },
    onHide: function() {
        clearInterval(setIndex);
    },
    onShow: function() {
        var e = this;
        e.data.leaderPromise.then(function() {
            var t = wx.getStorageSync("linkaddress");
            if (t = t || e.data.linkaddress) {
                if (e.setData({
                    linkaddress: t
                }), e.data.isRefresh) {
                    e.setData({
                        isRefresh: 0
                    }), console.log("is refresh 1111");
                    var a = wx.getStorageSync("userInfo");
                    a && 0 < a.id ? (e.setData({
                        user_id: a.id,
                        page: 1
                    }), e.loadData()) : wx.showModal({
                        title: "提示",
                        content: "您未登陆，请先登陆！",
                        success: function(t) {
                            if (t.confirm) {
                                var a = encodeURIComponent("/sqtg_sun/pages/home/index/index");
                                app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                            } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
                        }
                    });
                }
                setIndex = setInterval(function() {
                    var t = new Date().getTime();
                    e.setData({
                        curr: t
                    });
                }, 1e3);
            } else app.reTo("/sqtg_sun/pages/zkx/pages/nearleaders/nearleaders", !0);
        }), wx.getUserInfo({
            success: function(t) {
                var a = t.userInfo, e = wx.getStorageSync("userInfo");
                if (e.name) {
                    var s = !1;
                    if (a.nickName == e.name ? console.log("用户名没变") : s = !0, a.avatarUrl == e.img ? console.log("头像没变") : s = !0, 
                    s) {
                        var o = {
                            openid: e.openid,
                            name: a.nickName,
                            img: a.avatarUrl
                        };
                        app.ajax({
                            url: "Cuser|login",
                            data: o,
                            method: "GET",
                            success: function(t) {
                                t.code ? app.tips(t.msg) : wx.setStorageSync("userInfo", t.data);
                            }
                        });
                    } else console.log(wx.getStorageSync("userInfo"));
                }
            }
        });
        var a = wx.getStorageSync("linkaddress");
        null != a.id && app.ajax({
            url: "Cleader|getLeader",
            data: {
                leader_id: a.id
            },
            success: function(t) {
                t.data.pic != a.pic && (console.log("团长头像更新"), a.pic = t.data.pic, wx.setStorageSync("linkaddress", a));
            }
        });
    },
    onLoad: function(t) {
        var e = this;
        t.share_user_id && wx.setStorageSync("share_user_id", t.share_user_id);
        var s = t.l_id || 0;
        console.log(s);
        var o = wx.getStorageSync("linkaddress");
        e.data.leaderPromise = Promise.resolve(), s && (e.data.leaderPromise = new Promise(function(a, t) {
            app.ajax({
                url: "Cleader|getLeader",
                data: {
                    leader_id: s
                },
                success: function(t) {
                    o = t.data, wx.setStorageSync("linkaddress", o), console.log(o), e.setData({
                        linkaddress: o
                    }), e.loadData(), a();
                }
            });
        })), wx.checkSession({
            fail: function() {
                console.log("session timeout"), wx.login({
                    success: function(t) {
                        t.code && app.ajax({
                            url: "Cwx|getOpenid",
                            data: {
                                code: t.code
                            },
                            method: "GET",
                            success: function(t) {
                                console.log(t), wx.setStorageSync("session_key", t.data.session_key), wx.setStorageSync("open_id", t.data.openid);
                            }
                        });
                    }
                });
            }
        });
    },
    loadData: function() {
        var o = this;
        app.ajax({
            url: "Csystem|getMenuicon",
            success: function(t) {
                console.log(t), o.setData({
                    nav: t
                });
            }
        }), app.ajax({
            url: "Csystem|getSetting",
            success: function(t) {
                console.log(t), o.setData({
                    setting: t.data,
                    imgRoot: t.other.img_root
                }), t.data.pin_open ? (console.log("拼"), o.data.spell = !0, o.data.isNav = !0, wx.setStorageSync("spell", !0), 
                o.setData({
                    spell: !0,
                    isNav: !0
                })) : (console.log("不拼"), wx.setStorageSync("spell", !1), o.setData({
                    spell: !1,
                    isNav: !0
                })), t.data.index_yesterday_switch ? (o.data.currenttab = "0", o.setData({
                    yesterdaySwitch: t.data.index_yesterday_switch
                }), wx.setStorageSync("yesterday_switch", t.data.index_yesterday_switch), o.getgoodsesYesterday(t.data.index_yesterday_switch)) : t.data.pin_open ? (o.data.currenttab = "1", 
                o.setData({
                    currenttab: o.data.currenttab
                }), console.log("调用拼团"), o.getPingoodses()) : (console.log(o.data.pin_open), o.data.currenttab = "-1", 
                o.setData({
                    currenttab: o.data.currenttab
                })), wx.setStorageSync("appConfig", t.data), wx.setNavigationBarTitle({
                    title: t.data.index_title
                }), wx.setNavigationBarColor({
                    frontColor: t.data.fontcolor,
                    backgroundColor: t.data.top_color
                });
            }
        });
        var n = 0;
        wx.getStorageSync("userInfo");
        wx.setStorageSync("footNav", null), app.ajax({
            url: "Index|getIndexData",
            success: function(t) {
                console.log(t);
                var a = 1;
                t.data.announcement.title = t.data.announcement.title.join("");
                var e = function(t) {
                    for (var a = 0, e = 0; e < t.length; e++) null != t[e].charAt(e).match(/[^\x00-\xff]/gi) ? a += 2 : a += 1;
                    return a;
                }(t.data.announcement.title);
                a *= Math.ceil(e / 40), o.setData({
                    index: t.data,
                    endP: a,
                    imgRoot: t.other.img_root,
                    catid: o.data.catid || (t.data.categorys.length ? t.data.categorys[0].id : 0)
                });
                var s = foot.dealFootNav(t.data.swipers, t.other.img_root);
                o.setData({
                    banner: s
                }), 1 == ++n && o.setData({
                    show: !0
                }), o.getCoupons(), o.getgoodses();
            }
        }), app.api.getCartCount({
            user_id: o.data.user_id,
            leader_id: o.data.linkaddress.id
        }).then(function(t) {
            o.setData({
                cartCount: t
            });
        });
    },
    getCoupons: function() {
        var e = this;
        app.ajax({
            url: "Ccoupon|getAvailableCoupons",
            data: {
                user_id: e.data.user_id || 0,
                page: 1,
                limit: 6
            },
            success: function(t) {
                var a = app.globalData.couponFlag;
                e.setData({
                    flag: t.data.length && a,
                    coupons: t.data
                });
            }
        });
    },
    _onNavTab1: function(t) {
        var a = getCurrentPages(), e = "/" + a[a.length - 1].route, s = t.currentTarget.dataset.index, o = this.data.banner[s].link, n = this.data.banner[s].typeid;
        o != e && "" != o && app.navTo(o + "?id=" + n);
    },
    _onNavTab2: function(t) {
        var a = getCurrentPages(), e = "/" + a[a.length - 1].route, s = t.currentTarget.dataset.index, o = this.data.nav[s].link, n = this.data.nav[s].typeid;
        o != e && "" != o && app.navTo(o + "?id=" + n);
    },
    _onNavTab3: function(t) {
        var a = getCurrentPages(), e = "/" + a[a.length - 1].route, s = t.currentTarget.dataset.index, o = this.data.centerAd[s].link, n = this.data.centerAd[s].typeid;
        o != e && "" != o && app.navTo(o + "?id=" + n);
    },
    receivecoupon: function(t) {
        for (var a = this, e = wx.getStorageSync("userInfo"), s = a.data.coupons, o = [], n = 0; n < s.length; n++) o.push(s[n].id);
        t.currentTarget.dataset.index;
        e ? app.ajax({
            url: "Ccoupon|receiveCoupon",
            data: {
                user_id: a.data.user_id,
                coupon_ids: o.join(",")
            },
            success: function(t) {
                0 == t.code && (a.getCoupons(), wx.showToast({
                    title: t.data,
                    icon: "none"
                }), a.close());
            },
            fail: function(t) {
                app.tips(t.data.msg), setTimeout(function() {
                    a.setData({
                        flag: !1
                    });
                }, 1e3);
            }
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/home/index/index");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    onShareAppMessage: function(t) {
        var a = wx.getStorageSync("userInfo").id, e = this.data.linkaddress.id;
        return {
            title: this.data.setting.index_title,
            path: "/sqtg_sun/pages/home/index/index?share_user_id=" + a + "&l_id=" + e
        };
    },
    swichNav: function(t) {
        var a = t.currentTarget.dataset.index;
        t.currentTarget.dataset.catid;
        this.setData({
            curHdIndex: a,
            page: 1,
            catid: t.currentTarget.dataset.catid
        }), this.getgoodses();
    },
    getgoodses: function() {
        var s = this, o = s.data.olist, n = s.data.limit, i = s.data.page;
        app.ajax({
            url: "Cgoods|getGoodses",
            data: {
                cat_id: s.data.catid,
                page: i,
                limit: n,
                leader_id: s.data.linkaddress.id
            },
            success: function(t) {
                console.log(t.data);
                var a = t.data.length == n;
                if (1 == i) o = t.data; else for (var e in t.data) o.push(t.data[e]);
                i += 1, s.setData({
                    olist: o,
                    show: !0,
                    hasMore: a,
                    page: i,
                    imgroot: t.other.img_root
                }), s.totalPrice();
            }
        });
    },
    getgoodsesYesterday: function(t) {
        var a = this;
        app.ajax({
            url: "Cgoods|getGoodses",
            data: {
                cat_id: t,
                page: 1,
                limit: 15,
                leader_id: a.data.linkaddress.id
            },
            success: function(t) {
                a.setData({
                    topList: t.data
                }), a.totalPrice();
            }
        });
    },
    getPingoodses: function() {
        var a = this, t = wx.getStorageSync("linkaddress");
        app.ajax({
            url: "Cpin|goodsList",
            data: {
                leader_id: t.id
            },
            success: function(t) {
                console.log(t), a.setData({
                    topList: t.data,
                    pinShow: !0
                });
            }
        });
    },
    onReachBottom: function() {
        this.data.hasMore ? this.getgoodses() : wx.showToast({
            title: "没有更多商品啦~",
            icon: "none"
        });
    },
    close: function() {
        this.setData({
            flag: !1
        }), app.globalData.couponFlag = !1;
    },
    totalPrice: function() {
        var t = this.data.unitPrice, a = this.data.num, e = (parseFloat(t) * parseInt(a)).toFixed(2);
        this.setData({
            totalPrice: e
        });
    },
    spTap: function(t) {
        var a = this, e = a.data.protect, s = !1, o = t.currentTarget.dataset.index, n = t.currentTarget.dataset.idx, i = (t.currentTarget.dataset.id, 
        a.data.olist[a.data.currIndex]);
        i.attrgroups[o].status = !0;
        for (var r = 0; r < i.attrgroups.length; r++) {
            if (1 != i.attrgroups[r].status) {
                s = !1;
                break;
            }
            s = !0;
        }
        i.attrgroups[o].attrs.forEach(function(t, a) {
            t.status = !1;
        }), i.attrgroups[o].attrs[n].status = !0;
        for (var d = ",", c = "", u = 0; u < i.attrgroups.length; u++) for (var l = 0; l < i.attrgroups[u].attrs.length; l++) i.attrgroups[u].attrs[l].status && (d += i.attrgroups[u].attrs[l].id + ",", 
        c += i.attrgroups[u].attrs[l].name + " ");
        e && s && (a.setData({
            show: !1
        }), a.setData({
            protect: !1
        }), app.ajax({
            url: "Cgoods|getGoodsAttrs",
            data: {
                goods_id: i.id,
                attr_ids: d
            },
            success: function(t) {
                console.log(t.data[0].stock), console.log(t), a.setData({
                    protect: !0
                }), a.setData({
                    show: !0
                }), 0 == t.code && (a.setData({
                    unitPrice: t.data[0].price,
                    stock: t.data[0].stock,
                    idGroup: d,
                    choiceindex: o,
                    choiceidx: n,
                    choiceattr: t.data[0]
                }), a.totalPrice());
            },
            fail: function(t) {
                a.setData({
                    show: !0
                }), a.setData({
                    protect: !0
                }), app.tips(t.data.msg);
            }
        })), a.setData({
            olist: a.data.olist,
            chooseSpec: c,
            isChecked: s
        });
    },
    addNum: function(t) {
        var a = t.currentTarget.dataset.num, e = this.data.stock, s = this.data.cartCount || 1;
        e <= a ? wx.showToast({
            title: "商品库存不足",
            icon: "none"
        }) : (this.setData({
            num: ++a,
            cartCount: s + 1
        }), this.totalPrice());
    },
    reduceNum: function(t) {
        var a = t.currentTarget.dataset.num, e = this.data.cartCount;
        1 < a ? (this.setData({
            num: --a,
            cartCount: e - 1
        }), this.totalPrice()) : wx.showToast({
            title: "商品不得少于1件",
            icon: "none"
        });
    },
    formSubmit: function(t) {
        this.data.isChecked ? this.data.protect && this.addCarts() : wx.showToast({
            title: "请选择规格",
            icon: "none"
        });
    },
    addCarts: function() {
        var a = this, t = a.data.olist[a.data.currIndex], e = a.data.idGroup, s = a.data.chooseSpec, o = wx.getStorageSync("userInfo"), n = a.data.cartCount, i = a.data.num;
        app.ajax({
            url: "Ccart|joinCart",
            data: {
                user_id: o.id,
                leader_id: a.data.linkaddress.id,
                goods_id: t.id,
                store_id: t.store_id,
                num: i,
                attr_ids: t.use_attr ? e : "",
                attr_names: t.use_attr ? s : ""
            },
            success: function(t) {
                wx.showToast({
                    title: "加入购物车成功！",
                    icon: "none"
                }), a.setData({
                    showModalStatus: !1,
                    cartCount: n + 1,
                    num: 1,
                    addCount: ++a.data.addCount
                });
            }
        });
    },
    addCar: function(t) {
        t.currentTarget.dataset.statu;
        var a = t.currentTarget.dataset.index;
        this.setData({
            currIndex: a
        });
        var e = this.data.olist[a];
        e.use_attr ? this.setData({
            showModalStatus: !0,
            unitPrice: e.price || 0
        }) : this.addCarts();
    },
    oclose: function(t) {
        if ("close" != t.currentTarget.dataset.statu) return !1;
        this.setData({
            buyNow: !1,
            showModalStatus: !1
        });
    },
    onPhoneTab: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.setting.jszc_tel
        });
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    submitform: function(t) {
        var a = wx.getStorageSync("userInfo");
        app.ajax({
            url: "Index|addFormid",
            data: {
                user_id: a.id,
                form_id: t.detail.formId
            },
            success: function(t) {}
        });
    },
    onCouponsInfoTab: function(t) {
        var a = this, e = wx.getStorageSync("userInfo"), s = t.currentTarget.dataset.id;
        t.currentTarget.dataset.index, a.data.coupons;
        e ? app.ajax({
            url: "Ccoupon|receiveCoupon",
            data: {
                user_id: e.id,
                coupon_ids: s
            },
            success: function(t) {
                0 == t.code ? wx.showToast({
                    title: "领取成功",
                    icon: "none"
                }) : wx.showToast({
                    title: t.msg,
                    icon: "none"
                }), a.getCoupons();
            }
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/home/index/index");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    goPin: function(t) {
        console.log(702), app.navTo("/sqtg_sun/pages/plugin/pin/pinindex/pinindex");
    },
    onSwitch: function(t) {
        if (t) {
            if (this.data.currenttab == t.currentTarget.dataset.tabid) return !1;
            this.setData({
                currenttab: t.currentTarget.dataset.tabid
            });
            var a = wx.getStorageSync("yesterday_switch");
            this[this.data.topListArr[this.data.currenttab]](a);
        }
    }
});