var app = getApp();

Page({
    data: {
        navTile: "好店",
        imgUrls: [],
        enterShop: [],
        indexCate: 0,
        showCate: !1,
        shopCate: [],
        tradingArea: [],
        shop: [],
        showJoin: !0,
        curPage: 1,
        pagesize: 3,
        priceArray: [ {
            day: 10,
            money: 50
        }, {
            day: 30,
            money: 100
        } ],
        isRequest: 0,
        showModalStatus: !0
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.navTile
        }), app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            }), e.setData({
                store_open: t.store_open
            });
        }), app.get_imgroot().then(function(t) {
            e.setData({
                imgroot: t
            });
        }), app.get_diy_msg().then(function(t) {
            e.setData({
                imgUrls: t.hd
            });
        }), app.util.request({
            url: "entry/wxapp/getStoreCategory",
            cachetime: "0",
            success: function(t) {
                e.setData({
                    shopCate: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/getStoreDistrict",
            cachetime: "0",
            success: function(t) {
                e.setData({
                    tradingArea: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/getAnnouncement",
            data: {
                type: 2
            },
            cachetime: "1000",
            success: function(t) {
                e.setData({
                    enterShop: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/getStorelimit",
            cachetime: "0",
            success: function(t) {
                e.setData({
                    storeEnter: t.data
                });
            }
        }), app.get_wxuser_location().then(function(t) {
            t ? e.setData({
                distance: 1,
                lat: t.latitude,
                lng: t.longitude
            }) : wx.showModal({
                title: "提示",
                content: "请点击右上角打开关于小程序再点击右上角选择设置"
            }), e.get_shop_list();
        }).catch(function() {
            wx.showModal({
                title: "提示",
                content: "请点击右上角打开关于小程序再点击右上角选择设置",
                showCancel: !1
            }), e.get_shop_list();
        });
    },
    get_shop_list: function() {
        var n = this, o = n.data.curPage, s = n.data.shop, e = n.data.cid || "", a = n.data.did || "", i = n.data.searchText || "", c = n.data.distance || 0, r = n.data.lat || 0, d = n.data.lng || 0;
        app.get_openid().then(function(t) {
            app.util.request({
                url: "entry/wxapp/getStore",
                cachetime: "0",
                data: {
                    openid: t,
                    distance: c,
                    lat: r,
                    lng: d,
                    page: o,
                    pagesize: n.data.pagesize,
                    category_id: e,
                    district_id: a,
                    title: i
                },
                success: function(t) {
                    var e = t.data.length == n.data.pagesize;
                    if (1 == o) s = t.data; else for (var a in t.data) s.push(t.data[a]);
                    o += 1, n.setData({
                        shop: s,
                        curPage: o,
                        hasMore: e
                    });
                }
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        this.data.hasMore ? this.get_shop_list() : wx.showToast({
            title: "没有更多商家啦~",
            icon: "none"
        });
    },
    onShareAppMessage: function() {},
    chosseCate: function(t) {
        var e = this, a = t.currentTarget.dataset.index;
        e.setData({
            indexCate: a
        }), 0 == a ? null != e.data.distance ? (1 == e.data.distance ? e.setData({
            distance: 0,
            cid: "",
            did: "",
            searchText: "",
            curPage: 1
        }) : e.setData({
            distance: 1,
            cid: "",
            did: "",
            searchText: "",
            curPage: 1
        }), e.get_shop_list()) : wx.showModal({
            title: "提示",
            content: "请点击右上角打开关于小程序再点击右上角选择设置"
        }) : e.setData({
            showCate: !e.data.showCate
        });
    },
    searchShop: function(t) {
        var e = this, a = t.currentTarget.dataset.id, n = e.data.indexCate;
        1 == n ? e.setData({
            cid: a,
            did: "",
            searchText: "",
            curPage: 1
        }) : 2 == n && e.setData({
            cid: "",
            did: a,
            searchText: "",
            curPage: 1
        }), e.get_shop_list(), e.setData({
            showCate: !e.data.showCate
        });
    },
    searchSubmit: function(t) {
        var e = t.detail.value.searchText;
        this.seachFun(e);
    },
    toSearch: function(t) {
        var e = t.detail.value;
        this.seachFun(e);
    },
    seachFun: function(t) {
        "" != t ? (this.setData({
            cid: "",
            did: "",
            curPage: 1,
            searchText: t,
            hasMore: !0
        }), this.get_shop_list()) : wx.showToast({
            title: "搜索关键词不得微空",
            icon: "none",
            duration: 2500
        });
    },
    receRards: function(t) {
        var a = this, n = a.data.shop, o = t.currentTarget.dataset.index, s = t.currentTarget.dataset.idx, i = t.currentTarget.dataset.id, e = t.currentTarget.dataset.status, c = t.currentTarget.dataset.vip;
        "2" == e ? wx.showModal({
            title: "提示",
            content: "您已经领取过该优惠券啦~",
            showCancel: !1
        }) : 1 == e ? wx.showModal({
            title: "提示",
            content: "优惠券已被抢光啦~下次早点来",
            showCancel: !1
        }) : "0" == e && app.get_openid().then(function(e) {
            1 == c ? app.get_user_vip().then(function(t) {
                t == c ? app.util.request({
                    url: "entry/wxapp/receiveCoupon",
                    data: {
                        openid: e,
                        coupon_id: i
                    },
                    cachetime: "0",
                    success: function(t) {
                        wx.showModal({
                            title: "提示",
                            content: "恭喜你，领取成功",
                            showCancel: !1,
                            success: function(t) {
                                n[o].coupon_list[s].status = 2, a.setData({
                                    shop: n
                                });
                            }
                        });
                    }
                }) : wx.showModal({
                    title: "",
                    content: "您尚未开通亲子会员",
                    confirmText: "去开通",
                    confirmColor: "#ff5e5e",
                    success: function(t) {
                        t.confirm && wx.navigateTo({
                            url: "/yzqzk_sun/pages/member/joinmember/joinmember"
                        });
                    }
                });
            }) : app.util.request({
                url: "entry/wxapp/receiveCoupon",
                data: {
                    openid: e,
                    coupon_id: i
                },
                cachetime: "0",
                success: function(t) {
                    wx.showModal({
                        title: "提示",
                        content: "恭喜你，领取成功",
                        showCancel: !1,
                        success: function(t) {
                            n[o].coupon_list[s].status = 2, a.setData({
                                shop: n
                            });
                        }
                    });
                }
            });
        });
    },
    showModel: function(t) {
        this.setData({
            showJoin: !this.data.showJoin
        });
    },
    toShopdet: function(t) {
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "shopdet/shopdet?id=" + e
        });
    },
    bindPickerChange: function(t) {
        this.setData({
            index: t.detail.value
        });
    },
    formSubmit: function(t) {
        var e = this, a = t.detail.formId, n = t.detail.value.shopname, o = t.detail.value.phone, s = t.detail.value.address, i = "", c = !0;
        "" == n ? i = "请输入您的姓名" : /^1(3|4|5|7|8)\d{9}$/.test(o) ? "" == s ? i = "请输入地址" : null == e.data.index ? i = "请选择入驻时间" : (c = !1, 
        app.get_openid().then(function(t) {
            e.setData({
                isRequest: ++e.data.isRequest
            }), 1 == e.data.isRequest ? app.util.request({
                url: "entry/wxapp/setStore",
                cachetime: "0",
                data: {
                    openid: t,
                    store_name: n,
                    tel: o,
                    address: s,
                    storelimit_id: e.data.storeEnter[e.data.index].id,
                    formId: a
                },
                success: function(t) {
                    app.util.request({
                        url: "entry/wxapp/getPayParam",
                        cachetime: "0",
                        data: {
                            order_id: t.data
                        },
                        success: function(t) {
                            wx.requestPayment({
                                timeStamp: t.data.timeStamp,
                                nonceStr: t.data.nonceStr,
                                package: t.data.package,
                                signType: "MD5",
                                paySign: t.data.paySign,
                                success: function(t) {
                                    wx.showModal({
                                        title: "提示",
                                        content: "支付成功",
                                        showCancel: !1,
                                        confirmColor: "#ff5e5e",
                                        success: function(t) {
                                            e.setData({
                                                showJoin: !e.data.showJoin
                                            });
                                        }
                                    });
                                },
                                fail: function(t) {
                                    wx.showModal({
                                        title: "提示",
                                        content: "支付失败",
                                        confirmColor: "#ff5e5e",
                                        success: function(t) {}
                                    });
                                }
                            });
                        }
                    });
                },
                fail: function(t) {
                    wx.showModal({
                        title: "提示",
                        content: t.data.message,
                        showCancel: !1,
                        success: function(t) {
                            e.setData({
                                showJoin: !e.data.showJoin
                            });
                        }
                    });
                },
                complete: function() {
                    e.setData({
                        isRequest: 0
                    });
                }
            }) : wx.showToast({
                title: "正在请求中...",
                icon: "none"
            });
        })) : i = "请正确输入手机号码", 1 == c && wx.showToast({
            title: i,
            icon: "none"
        });
    },
    toSwiperAd: function(t) {
        var e = t.currentTarget.dataset.url;
        "" != e && wx.navigateTo({
            url: e
        });
    }
});