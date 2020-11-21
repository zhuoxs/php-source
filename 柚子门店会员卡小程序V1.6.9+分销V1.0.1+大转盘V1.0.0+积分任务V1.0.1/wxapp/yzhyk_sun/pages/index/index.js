var _slicedToArray = function(t, a) {
    if (Array.isArray(t)) return t;
    if (Symbol.iterator in Object(t)) return function(t, a) {
        var e = [], n = !0, o = !1, s = void 0;
        try {
            for (var i, r = t[Symbol.iterator](); !(n = (i = r.next()).done) && (e.push(i.value), 
            !a || e.length !== a); n = !0) ;
        } catch (t) {
            o = !0, s = t;
        } finally {
            try {
                !n && r.return && r.return();
            } finally {
                if (o) throw s;
            }
        }
        return e;
    }(t, a);
    throw new TypeError("Invalid attempt to destructure non-iterable instance");
}, app = getApp();

Page({
    data: {
        currstore: {},
        cardNum: "",
        bghead: "../../../style/images/bgHead.png",
        bgCards: "../../../style/images/bgCards.png",
        bgLogo: "",
        operation: [ {
            title: "扫码购物篮",
            src: "../../../style/images/icon1.png",
            bind: "toBasket"
        }, {
            title: "扫码购",
            src: "../../../style/images/icon3.png",
            bind: "toScan"
        }, {
            title: "附近门店",
            src: "../../../style/images/icon2.png",
            bind: "toBranch"
        } ],
        cardsNum: 2,
        cards: [],
        timeUpdata: "每周二/六 定时更新",
        phoneGrant: !1,
        phone_switch: 0,
        isaddress: !1,
        isLogin: !1,
        showAd: !1,
        isIpx: app.globalData.isIpx
    },
    onShow: function() {
        var s = this;
        app.get_user_info().then(function(t) {
            s.setData({
                cardNum: t.tel ? t.tel : "***********",
                isLogin: !t.name,
                phoneGrant: !(t.tel || !t.name),
                user: t
            }), app.get_coupons().then(function(t) {
                console.log(t), s.setData({
                    cards: t
                });
            }), app.get_user_coupons().then(function(t) {
                s.setData({
                    cardsNum: t.length
                });
            });
        }), app.get_store_info().then(function(t) {
            if (console.log(t), console.log(77777777777), wx.getStorageSync("tabBar")) {
                var a = wx.getStorageSync("tabBar"), e = getCurrentPages(), n = e[e.length - 1].__route__;
                0 != n.indexOf("/") && (n = "/" + n);
                for (var o = 0; o < a.list.length; o++) a.list[o].active = !1, a.list[o].selectedColor = a.selectedColor, 
                a.list[o].pagePath == n && (a.list[o].active = !0, a.list[o].title && wx.setNavigationBarTitle({
                    title: a.list[o].title
                }));
                s.setData({
                    tabBar: a
                });
            } else console.log(22), app.editTabBar();
            1 == t ? s.setData({
                isaddress: !0
            }) : (s.setData({
                currstore: t,
                isaddress: !1,
                cart: app.cart_get(),
                offlinecart: app.offline_cart_get()
            }), app.util.request({
                url: "entry/wxapp/GetGroupGoodses",
                fromcache: !1,
                data: {
                    store_id: t.id,
                    page: 1,
                    limit: 6
                },
                success: function(t) {
                    s.setData({
                        group_goods_list: t.data
                    });
                }
            }), app.util.request({
                url: "entry/wxapp/GetActivityGoods",
                cachetime: "0",
                data: {
                    store_id: t.id
                },
                success: function(t) {
                    s.setData({
                        activity_goods: t.data
                    });
                }
            }), app.util.request({
                url: "entry/wxapp/GetCutGoodses",
                fromcache: !1,
                data: {
                    store_id: t.id,
                    page: 1,
                    limit: 4
                },
                success: function(t) {
                    s.setData({
                        cut_goods_list: t.data
                    });
                }
            }));
        }), app.get_card_price().then(function(t) {
            s.setData({
                card: t,
                isvip: 0 < t.id ? 1 : 0
            });
        });
    },
    onLoad: function(t) {
        try {
            Promise.reject("出错了").catch(function(t) {
                console.log("2", t);
            }), console.log("1");
        } catch (t) {
            console.log(t);
        }
        t.d_user_id && app.distribution.distribution_parsent(app, t.d_user_id);
        var s = this;
        Promise.all([ app.get_imgroot(), app.api.get_setting(), app.api.get_menus() ]).then(function(t) {
            var a = _slicedToArray(t, 3), e = a[0], n = a[1], o = a[2];
            console.log(n), s.setData({
                imgroot: e,
                setting: n,
                phone_switch: n.phone_switch,
                showAd: !(!app.globalData.showAd || !n.ad_show || 0 == n.ad_show),
                operation: o,
                bghead: n.bghead ? e + n.bghead : s.data.bghead,
                pic: n.pic ? e + n.pic : "../../../style/images/icon6.png"
            }), console.log(s.data.bghead);
        });
    },
    receRards: function(t) {
        var a = this, e = t.currentTarget.dataset.status, n = t.currentTarget.dataset.index, o = a.data.cards, s = (t.currentTarget.dataset.vip, 
        a.data.user);
        1 == a.data.setting.member_charge ? null == s.is_member ? wx.showModal({
            title: "提示",
            content: "该优惠券为会员专属",
            showCancel: !1
        }) : "2" == e ? wx.showModal({
            title: "提示",
            content: "您已经领取过该优惠券啦~",
            showCancel: !1
        }) : 1 == e ? wx.showModal({
            title: "提示",
            content: "优惠券已被抢光啦~下次早点来",
            showCancel: !1
        }) : "0" == e && (o[n].status = 4, a.setData({
            cards: o
        }), app.get_user_info().then(function(t) {
            app.util.request({
                url: "entry/wxapp/AddUserCoupon",
                cachetime: "0",
                data: {
                    user_id: t.id,
                    storecoupon_id: o[n].id
                },
                success: function(t) {
                    0 == t.data.code && (app.get_user_coupons(!1), app.get_coupons(!1), wx.showModal({
                        title: "提示",
                        content: "恭喜你，领取成功",
                        showCancel: !1
                    }), o[n].status = 2, a.setData({
                        cards: o
                    }));
                },
                fail: function(t) {
                    o[n].status = 0, a.setData({
                        cards: o
                    });
                }
            });
        })) : "2" == e ? wx.showModal({
            title: "提示",
            content: "您已经领取过该优惠券啦~",
            showCancel: !1
        }) : 1 == e ? wx.showModal({
            title: "提示",
            content: "优惠券已被抢光啦~下次早点来",
            showCancel: !1
        }) : "0" == e && (o[n].status = 4, a.setData({
            cards: o
        }), app.get_user_info().then(function(t) {
            app.util.request({
                url: "entry/wxapp/AddUserCoupon",
                cachetime: "0",
                data: {
                    user_id: t.id,
                    storecoupon_id: o[n].id
                },
                success: function(t) {
                    0 == t.data.code && (app.get_user_coupons(!1), app.get_coupons(!1), wx.showModal({
                        title: "提示",
                        content: "恭喜你，领取成功",
                        showCancel: !1
                    }), o[n].status = 2, a.setData({
                        cards: o
                    }));
                },
                fail: function(t) {
                    o[n].status = 0, a.setData({
                        cards: o
                    });
                }
            });
        }));
    },
    openSetting: function() {
        wx.openSetting();
    },
    toBranch: function(t) {
        wx.navigateTo({
            url: "branch/branch"
        });
    },
    toPay: function(t) {
        wx.navigateTo({
            url: "pay/pay"
        });
    },
    toCards: function(t) {
        wx.navigateTo({
            url: "cards/cards"
        });
    },
    toBasket: function(t) {
        wx.navigateTo({
            url: "basket/basket"
        });
    },
    toDo: function(t) {
        var a = t.currentTarget.dataset.index, e = this.data.operation[a];
        "toScan" == e.page ? this.toScan() : "distribution" == e.page ? app.setFx().then(function(t) {
            wx.navigateTo({
                url: t
            });
        }) : wx.navigateTo({
            url: e.page
        });
    },
    toScan: function(t) {
        var n = this;
        wx.scanCode({
            success: function(t) {
                var e = t.result;
                app.get_store_info().then(function(t) {
                    app.util.request({
                        url: "entry/wxapp/GetGoodsByBarcode",
                        cachetime: 0,
                        data: {
                            barcode: e,
                            store_id: t.id
                        },
                        success: function(t) {
                            if (console.log(e), t.data.id) {
                                var a = app.offline_cart_add(t.data);
                                setTimeout(function() {
                                    wx.showToast({
                                        title: "商品已加入购物篮",
                                        duration: 3e3,
                                        success: function(t) {}
                                    });
                                }, 500), n.setData({
                                    cart: a
                                }), wx.navigateTo({
                                    url: "/yzhyk_sun/pages/index/basket/basket"
                                });
                            } else wx.showModal({
                                title: "没有找到该商品",
                                content: ""
                            });
                        }
                    });
                });
            }
        });
    },
    toTimebuy: function(t) {
        wx.navigateTo({
            url: "timebuy/timebuy"
        });
    },
    toMember: function(t) {
        wx.navigateTo({
            url: "member/member"
        });
    },
    toMembercard: function(t) {
        wx.navigateTo({
            url: "../user/recharge/recharge"
        });
    },
    phoneGrant: function(t) {
        this.setData({
            phoneGrant: !this.data.phoneGrant
        });
    },
    isaddress: function(t) {
        this.setData({
            isaddress: !this.data.isaddress
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
                gender: e.gender
            },
            success: function(t) {
                app.get_user_info(!1).then(function(t) {
                    console.log(111), a.setData({
                        user: t,
                        isLogin: !1,
                        phoneGrant: !(t.tel || !t.name)
                    });
                });
            }
        }), console.log(t.detail.userInfo);
    },
    getPhoneNumber: function(a) {
        var e = this;
        app.get_key().then(function(t) {
            console.log(66666666), app.util.request({
                url: "entry/wxapp/decrypt",
                data: {
                    data: a.detail.encryptedData,
                    iv: a.detail.iv,
                    key: t
                },
                success: function(t) {
                    console.log(t), t.data.phoneNumber && (e.setData({
                        cardNum: t.data.phoneNumber,
                        phoneGrant: !1
                    }), app.util.request({
                        url: "entry/wxapp/UpdateUser",
                        cachetime: "0",
                        data: {
                            id: e.data.user.id,
                            tel: t.data.phoneNumber
                        },
                        success: function(t) {
                            app.get_user_info(!1), app.get_user_coupons(!1), e.onShow();
                        }
                    }));
                }
            });
        });
    },
    toMap: function(t) {
        wx.openLocation({
            name: this.data.currstore.name,
            latitude: parseFloat(this.data.currstore.latitude),
            longitude: parseFloat(this.data.currstore.longitude),
            scale: 18,
            address: this.data.currstore.address
        });
    },
    callphone: function(t) {
        var a = t.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    isLogin: function(t) {
        this.setData({
            isLogin: !1
        });
    },
    toggleAd: function(t) {
        app.globalData.showAd = !1, this.setData({
            showAd: !1
        });
    },
    toAd: function(t) {
        this.data.setting.ad_link && wx.navigateTo({
            url: this.data.setting.ad_link + "?id=" + this.data.setting.ad_value
        });
    },
    toBragain: function(t) {
        wx.navigateTo({
            url: "bargain/bargain"
        });
    },
    toGroup: function(t) {
        wx.navigateTo({
            url: "group/group"
        });
    },
    toBardet: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "bardet/bardet?id=" + a
        });
    },
    toGroupdet: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "groupDet/groupDet?id=" + a
        });
    },
    onShareAppMessage: function() {
        return {
            path: "/yzhyk_sun/pages/index/index?d_user_id=" + wx.getStorageSync("users").id
        };
    }
}, 2);