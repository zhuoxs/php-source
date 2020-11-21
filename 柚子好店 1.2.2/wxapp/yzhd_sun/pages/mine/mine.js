var app = getApp(), Api = require("../../resource/utils/util.js");

Page({
    data: {
        currentType: 0,
        currentStatus: 0,
        currentStatuss: 0,
        use: 1
    },
    onLoad: function(t) {
        var e = this, a = wx.getStorageSync("openid");
        console.log(a), wx.getStorage({
            key: "url",
            success: function(t) {
                e.setData({
                    url: t.data
                });
            }
        });
        var o = wx.getStorageSync("system");
        e.setData({
            mineBj: o.personal_img
        }), e.diyWinColor(), e.getHeaderImg();
    },
    gomanagerTap: function(t) {
        var e = wx.getStorageSync("openid");
        console.log(e), app.util.request({
            url: "entry/wxapp/ComeInBackstage",
            cachetime: "0",
            data: {
                openid: e
            },
            success: function(t) {
                console.log(t), t.data.data ? wx.navigateTo({
                    url: "../manager/manager?auth=" + t.data.data.auth
                }) : wx.showModal({
                    title: "提示",
                    content: "请先成为平台的入驻商家",
                    showCancel: !1
                });
            }
        });
    },
    statusTap: function(t) {
        this.setData({
            currentType: t.currentTarget.dataset.index
        });
    },
    selStatus: function(t) {
        console.log(t), this.setData({
            currentStatus: t.currentTarget.dataset.index
        }), this.onShow();
    },
    selStatuss: function(t) {
        console.log(t), this.setData({
            currentStatuss: t.currentTarget.dataset.index
        }), this.onShow();
    },
    deleteOrder: function(t) {
        var e = this;
        console.log(t);
        var a = t.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "是否删除该订单？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/DeleteOrder",
                    cachetime: "0",
                    data: {
                        id: a
                    },
                    success: function(t) {
                        console.log(t), 1 == t.data ? wx.showToast({
                            title: "删除成功！"
                        }) : wx.showToast({
                            title: "删除失败！",
                            icon: "none"
                        }), setTimeout(function() {
                            e.onShow();
                        }, 2e3);
                    }
                }), t.cancel;
            }
        });
    },
    deleteTap: function(e) {
        console.log("长按"), console.log(e);
        var a = this;
        wx.showModal({
            title: "提示",
            content: "是否删除该优惠券？",
            success: function(t) {
                console.log(t), t.confirm && (console.log("点击确认"), app.util.request({
                    url: "entry/wxapp/DelMyCoupon",
                    cachetime: "0",
                    data: {
                        id: e.currentTarget.dataset.id,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(t) {
                        console.log(t), 1 == t.data ? wx.showToast({
                            title: "删除成功！"
                        }) : wx.showToast({
                            title: "删除失败！",
                            icon: "none"
                        }), setTimeout(function() {
                            a.onShow();
                        }, 2e3);
                    }
                })), t.cancel;
            }
        });
    },
    goOrderAfter: function(t) {
        console.log(t), wx.navigateTo({
            url: "../orderAfter/orderAfter?orderID=" + t.currentTarget.dataset.id + "&&store_id=" + t.currentTarget.dataset.store_id
        });
    },
    goOrderComment: function(t) {
        console.log(t), wx.navigateTo({
            url: "../menu/menu?currentType=2&&storeID=" + t.currentTarget.dataset.store_id + "&&orderno=" + t.currentTarget.dataset.orderno
        });
    },
    payNowTap: function(a) {
        console.log(a);
        console.log(a.currentTarget.dataset.orderno);
        var o = a.currentTarget.dataset.id, n = wx.getStorageSync("openid");
        console.log(n), app.util.request({
            url: "entry/wxapp/isStockGoods",
            cachetime: "0",
            data: {
                id: o,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log(t), 1 == t.data && app.util.request({
                    url: "entry/wxapp/orderarr",
                    cachetime: "0",
                    data: {
                        openid: n,
                        price: a.currentTarget.dataset.price
                    },
                    success: function(t) {
                        console.log(t);
                        var e = t.data.package;
                        wx.requestPayment({
                            timeStamp: t.data.timeStamp,
                            nonceStr: t.data.nonceStr,
                            package: t.data.package,
                            signType: "MD5",
                            paySign: t.data.paySign,
                            success: function(t) {
                                console.log("-----支付成功-----"), app.util.request({
                                    url: "entry/wxapp/BuyMessage",
                                    cachetime: "0",
                                    data: {
                                        gname: a.currentTarget.dataset.gname,
                                        prepay_id: e,
                                        openid: n,
                                        money: a.currentTarget.dataset.money,
                                        bid: a.currentTarget.dataset.store_id,
                                        gid: a.currentTarget.dataset.id,
                                        buyType: 4
                                    },
                                    success: function(t) {
                                        console.log(t);
                                    }
                                }), app.util.request({
                                    url: "entry/wxapp/checkOrder",
                                    data: {
                                        order_id: o
                                    },
                                    success: function(t) {
                                        wx.showModal({
                                            title: "提示",
                                            content: "已支付成功，赶快去使用吧~",
                                            showCancel: !1,
                                            success: function(t) {
                                                wx.navigateTo({
                                                    url: "../orderAfter/orderAfter?orderNo=" + a.currentTarget.dataset.orderno + "&&store_id=" + a.currentTarget.dataset.store_id + "&&orderID=" + a.currentTarget.dataset.id
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(t) {
                                console.log("-----支付失败-----"), wx.showModal({
                                    title: "提示",
                                    content: "支付失败",
                                    showCancel: !1
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    goShopDetails: function(t) {
        wx.navigateTo({
            url: "../shopDetails/shopDetails?store_id=" + t.currentTarget.dataset.store_id
        });
    },
    goYhqDetails: function(t) {
        console.log(t), wx.navigateTo({
            url: "../yhqDetails/yhqDetails?id=" + t.currentTarget.dataset.id + "&&bid=" + t.currentTarget.dataset.bid + "&&qrcode=" + t.currentTarget.dataset.qrcode
        });
    },
    goManagerTap: function(t) {
        wx.navigateTo({
            url: "../manager/manager"
        });
    },
    dragMoveTap: function(t) {
        this.setData({
            x: 30,
            y: 30
        });
    },
    onReady: function() {},
    getHeaderImg: function() {
        var e = this;
        app.globalData.userInfo ? this.setData({
            userInfo: app.globalData.userInfo,
            hasUserInfo: !0
        }) : this.data.canIUse ? app.userInfoReadyCallback = function(t) {
            e.setData({
                userInfo: t.userInfo,
                hasUserInfo: !0
            });
        } : wx.getUserInfo({
            success: function(t) {
                app.globalData.userInfo = t.userInfo, e.setData({
                    userInfo: t.userInfo,
                    hasUserInfo: !0
                });
            }
        });
    },
    diyWinColor: function(t) {
        var e = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: e.color,
            backgroundColor: e.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: "我的"
        });
    },
    bindChange: function(t) {
        this.setData({
            currentTab: t.detail.current
        });
    },
    swichNav: function(t) {
        if (this.data.currentTab === t.target.dataset.current) return !1;
        this.setData({
            currentTab: t.target.dataset.current
        });
    },
    onShow: function() {
        var c = this, t = wx.getStorageSync("openid");
        console.log(t), app.util.request({
            url: "entry/wxapp/GetOrder",
            cachetime: "0",
            data: {
                openid: t
            },
            success: function(t) {
                console.log(t), c.setData({
                    allOrders: t.data.data
                });
            }
        }), console.log(c.data.currentStatus), app.util.request({
            url: "entry/wxapp/GetMyAllCoupon",
            cachetime: "0",
            data: {
                openid: t,
                currentStatuss: c.data.currentStatuss
            },
            success: function(t) {
                console.log(t), c.setData({
                    couponRecords: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetUserInfo",
            cachetime: "0",
            data: {
                openid: t
            },
            success: function(t) {
                console.log(t);
                for (var e = t.data.data.comment.list, a = 0; a < e.length; a++) e[a].comment_time = Api.js_date_time(e[a].comment_time);
                var o = [], n = [];
                for (a = 0; a < e.length; a++) {
                    o[a] = new Array(), n[a] = new Array();
                    for (var r = 0; r < t.data.data.comment.list[a].score; r++) o[a][r] = 1;
                    for (var s = 0; s < 5 - t.data.data.comment.list[a].score; s++) n[a][s] = 1;
                }
                for (a = 0; a < e.length; a++) e[a].star = o[a], e[a].kong = n[a];
                console.log(e), c.setData({
                    userId: t.data.data.id,
                    commentsList: e,
                    commentRecords: t.data.data.comment,
                    reserveRecords: t.data.data.reservations
                });
            }
        });
    }
});