var wxbarcode = require("../../../style/utils/index.js"), app = getApp();

Page({
    data: {
        navTile: "我的",
        umoney: "0.00",
        integral: 0,
        state10: 0,
        state20: 0,
        state30: 0,
        showCode: !1,
        open_scoretask: !1,
        open_eatvisit: !1,
        istocontent: 0
    },
    onLoad: function(t) {
        var e = this;
        if (wx.setNavigationBarTitle({
            title: e.data.navTile
        }), wx.getStorageSync("tabBar")) {
            var a = wx.getStorageSync("tabBar"), n = getCurrentPages(), i = n[n.length - 1].__route__;
            0 != i.indexOf("/") && (i = "/" + i);
            for (var o = 0; o < a.list.length; o++) a.list[o].active = !1, a.list[o].selectedColor = a.selectedColor, 
            a.list[o].pagePath == i && (a.list[o].active = !0, a.list[o].title && wx.setNavigationBarTitle({
                title: a.list[o].title
            }));
            e.setData({
                tabBar: a
            });
        } else console.log(22), app.editTabBar();
        app.get_user_info().then(function(t) {
            console.log(t.admin_id), e.setData({
                user: t
            }), wxbarcode.qrcode("qrcode", "userid:" + t.id, 500, 500);
        }), app.get_store_info().then(function(t) {
            e.setData({
                cart: app.cart_get()
            });
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 1
            },
            showLoading: !1,
            success: function(t) {
                var a = 1 == t.data && t.data;
                e.setData({
                    open_scoretask: a
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 2
            },
            showLoading: !1,
            success: function(t) {
                var a = 1 == t.data.isopen && t.data;
                e.setData({
                    open_eatvisit: a
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 3
            },
            showLoading: !1,
            success: function(t) {
                var a = 0 < t.data.status && t.data;
                e.setData({
                    open_distribution: a
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        e.setData({
            cart: app.cart_get()
        }), app.get_user_info().then(function(t) {
            console.log(t), e.setData({
                thumb: t.img,
                nickname: t.name,
                openid: t.openid,
                umoney: t.balance ? t.balance : "0.00",
                integral: t.integral ? t.integral : 0,
                user: t
            }), app.util.request({
                url: "entry/wxapp/GetOrderStateCounts",
                cachetime: "0",
                data: {
                    user_id: t.id
                },
                success: function(t) {
                    console.log(t);
                    var a = {};
                    a.state10 = t.data[10] ? t.data[10] : 0, a.state20 = t.data[20] ? t.data[20] : 0, 
                    a.state30 = t.data[30] ? t.data[30] : 0, e.setData(a);
                }
            });
        });
    },
    toScoretask: function(t) {
        wx.navigateTo({
            url: "/pages/plugin/shoppingMall/home/home"
        });
    },
    toeatvisit: function(t) {
        wx.navigateTo({
            url: "/pages/plugin/eatvisit/life/life"
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toRecharge: function(t) {
        wx.navigateTo({
            url: "recharge/recharge"
        });
    },
    toIntegral: function(t) {
        wx.navigateTo({
            url: "integral/integral"
        });
    },
    toMyorder: function(t) {
        var a = t.currentTarget.dataset.curindex, e = t.currentTarget.dataset.state;
        wx.navigateTo({
            url: "myorder/myorder?curindex=" + a + "&state=" + e
        });
    },
    toScanorder: function(t) {
        wx.navigateTo({
            url: "scanorder/scanorder"
        });
    },
    toapporder: function(t) {
        wx.navigateTo({
            url: "apporder/apporder"
        });
    },
    toContact: function(t) {
        wx.navigateTo({
            url: "contact/contact"
        });
    },
    toBackstage: function(t) {},
    toUcenter: function(t) {
        wx.navigateTo({
            url: "ucenter/ucenter"
        });
    },
    toMybill: function(t) {
        wx.navigateTo({
            url: "mybill/mybill"
        });
    },
    getAddress: function(t) {
        wx.chooseAddress({
            success: function(t) {},
            fail: function(t) {}
        });
    },
    toMember: function(t) {
        wx.navigateTo({
            url: "member/member"
        });
    },
    formSubmit: function(t) {
        var a = t.detail.formId;
        "the formId is a mock one" != a && app.getFormid(a), wx.navigateTo({
            url: "../backstage/index/index"
        });
    },
    toMybargain: function(t) {
        wx.navigateTo({
            url: "mybargain/mybargain"
        });
    },
    toMygroup: function(t) {
        wx.navigateTo({
            url: "mygroup/mygroup"
        });
    },
    showModel: function(t) {
        this.setData({
            showCode: !this.data.showCode
        });
    },
    todistribution: function(t) {
        var a = this.data.openid, e = this.data.istocontent, n = wx.getStorageSync("users");
        app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 3
            },
            success: function(t) {
                2 != t.data && t.data && 0 == e && a && app.util.request({
                    url: "entry/wxapp/IsPromoter",
                    data: {
                        openid: a,
                        form_id: 0,
                        uid: n.id,
                        status: 3,
                        m: app.globalData.Plugin_distribution
                    },
                    success: function(t) {
                        t && 9 != t.data ? 0 == t.data || 222 == t.data ? wx.navigateTo({
                            url: "/yzhyk_sun/plugin/distribution/fxAddShare/fxAddShare"
                        }) : 111 == t.data ? wx.navigateTo({
                            url: "/yzhyk_sun/plugin/distribution/fxBuyShare/fxBuyShare"
                        }) : 333 == t.data ? wx.navigateTo({
                            url: "/yzhyk_sun/plugin/distribution/fxVipShare/fxVipShare"
                        }) : 5 == t.data ? wx.navigateTo({
                            url: "/yzhyk_sun/plugin/distribution/fxYqmShare/fxYqmShare"
                        }) : wx.navigateTo({
                            url: "/yzhyk_sun/plugin/distribution/fxCenter/fxCenter"
                        }) : wx.navigateTo({
                            url: "/yzhyk_sun/plugin/distribution/fxAddShare/fxAddShare"
                        });
                    }
                });
            }
        });
    }
});