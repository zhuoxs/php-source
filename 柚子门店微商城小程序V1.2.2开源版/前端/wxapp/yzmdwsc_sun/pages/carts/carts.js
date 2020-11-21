var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
    return typeof t;
} : function(t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
}, app = getApp(), tempArray = [];

Page({
    data: {
        navTile: "购物车",
        carts: [],
        totalPrice: 0,
        allSelect: !1,
        noSelect: !0,
        totalNum: 0,
        fullPrice: "100",
        distribution: "3.00",
        checked: !1,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var e = getCurrentPages(), r = e[e.length - 1].route;
        console.log("当前路径为:" + r), a.setData({
            current_url: r
        });
        var c = wx.getStorageSync("tab");
        this.setData({
            tab: c
        }), app.editTabBar(), app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url2", t.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    goTap: function(t) {
        var a = this;
        a.setData({
            current: t.currentTarget.dataset.index
        }), 0 == a.data.current && wx.redirectTo({
            url: "../index/index?currentIndex=0"
        }), 1 == a.data.current && wx.redirectTo({
            url: "../shop/shop?currentIndex=1"
        }), 2 == a.data.current && wx.redirectTo({
            url: "../active/active?currentIndex=2"
        }), 3 == a.data.current && wx.redirectTo({
            url: "../carts/carts?currentIndex=3"
        }), 4 == a.data.current && wx.redirectTo({
            url: "../user/user?currentIndex=4"
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/GetShopCar",
                    cachetime: "0",
                    data: {
                        uid: t.data
                    },
                    success: function(t) {
                        a.setData({
                            shopcar: t.data.data
                        }), a.setData({
                            checked: !1,
                            allSelect: 0
                        }), a.totalPrice();
                    }
                });
            }
        });
    },
    onHide: function() {
        console.log(12333);
    },
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bindCheckbox: function(t) {
        for (var a = t.currentTarget.dataset.index, e = this.data.shopcar, r = this.data.totalNum, c = 0; c < e.length; c++) e[c].check ? c == a && (e[c].check = "", 
        r--, this.setData({
            totalPrice: 0,
            totalNum: r,
            shopcar: e
        })) : c == a && (e[c].check = e[c].id, r++, this.setData({
            totalPrice: 0,
            totalNum: r,
            shopcar: e
        }));
        this.totalPrice();
    },
    checkAll: function(t) {
        var a = this, e = this.data.shopcar, r = this.data, c = t.currentTarget.dataset.checked;
        if (console.log(c), a.setData({
            checked: c
        }), r.allSelect) {
            r.allSelect = "";
            for (n = 0; n < e.length; n++) e[n].check = "";
            this.setData({
                totalPrice: 0,
                totalNum: 0
            });
        } else {
            this.setData({
                totalPrice: 0,
                totalNum: e.length
            }), r.allSelect = 1;
            for (var n = 0; n < e.length; n++) 1 != e[n].no_stock && (e[n].check = 1);
        }
        var s = e;
        this.setData({
            shopcar: s,
            allSelect: r.allSelect
        }), this.totalPrice();
    },
    add: function(t) {
        var a = t.currentTarget.dataset.index, e = t.currentTarget.dataset.id, r = this.data.shopcar;
        if (tempArray[parseInt(a)] = this.data.shopcar[parseInt(a)].price / this.data.shopcar[parseInt(a)].num, 
        "" !== a && null != a && r[parseInt(a)].num < 10) {
            r[parseInt(a)].num++, this.setData({
                shopcar: r,
                totalPrice: 0
            }), tempArray[parseInt(a)] || (tempArray[parseInt(a)] = this.data.shopcar[parseInt(a)].price);
            var c = tempArray[parseInt(a)] * this.data.shopcar[parseInt(a)].num;
            r[parseInt(a)].price = c, this.setData({
                shopcar: r,
                totalPrice: 0
            }), this.totalPrice();
            var n = r[parseInt(a)].num, s = r[parseInt(a)].price;
            app.util.request({
                url: "entry/wxapp/buyNum",
                data: {
                    id: e,
                    num: n,
                    price: s
                },
                success: function(t) {}
            });
        }
    },
    reduce: function(t) {
        var a = this, e = t.currentTarget.dataset.index, r = t.currentTarget.dataset.id, c = this.data.shopcar;
        if (tempArray[parseInt(e)] = this.data.shopcar[parseInt(e)].price / this.data.shopcar[parseInt(e)].num, 
        "" !== e && null != e) if (1 < c[parseInt(e)].num) {
            c[parseInt(e)].num--, this.setData({
                shopcar: c,
                totalPrice: 0
            }), tempArray[parseInt(e)] || (tempArray[parseInt(e)] = this.data.shopcar[parseInt(e)].price);
            var n = tempArray[parseInt(e)] * this.data.shopcar[parseInt(e)].num;
            c[parseInt(e)].price = n, this.setData({
                shopcar: c,
                totalPrice: 0
            }), this.totalPrice();
            var s = c[parseInt(e)].num, o = c[parseInt(e)].price;
            app.util.request({
                url: "entry/wxapp/buyNum",
                data: {
                    id: r,
                    num: s,
                    price: o
                },
                success: function(t) {}
            });
        } else 1 == c[parseInt(e)].num && wx.showModal({
            title: "提示",
            content: "确定删除该商品吗",
            showCancel: !0,
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/DelSopSingleCar",
                    cachetime: "0",
                    data: {
                        id: r
                    },
                    success: function(t) {
                        console.log(t.data.message), a.setData({
                            shopcar: t.data.message
                        });
                    }
                }) : t.cancel;
            }
        });
    },
    totalPrice: function() {
        for (var t = this.data.shopcar, a = 0, e = 0; e < t.length; e++) {
            var r = t[e];
            r.check && (a += parseFloat(r.price));
        }
        return a = parseFloat(a.toFixed(2)), this.setData({
            totalPrice: a
        }), a;
    },
    empty: function(t) {
        var a = [], e = this;
        wx.showModal({
            title: "提示",
            content: "确定清空商品吗",
            showCancel: !0,
            success: function(t) {
                t.confirm ? (app.util.request({
                    url: "entry/wxapp/EmptySopCar",
                    cachetime: "0",
                    data: {
                        uid: wx.getStorageSync("openid")
                    },
                    success: function(t) {
                        e.setData({
                            shopcar: []
                        });
                    }
                }), wx.setStorageSync("carts", a), e.setData({
                    shopcar: []
                }), e.totalPrice()) : t.cancel;
            }
        });
    },
    toCforder: function(a) {
        for (var t = this.data.shopcar, e = "", r = 0; r < t.length; r++) t[r].check && (e = e + t[r].id + ",");
        console.log(e), wx.setStorage({
            key: "crid",
            data: {
                crid: e
            }
        }), e ? app.util.request({
            url: "entry/wxapp/is_stock",
            cachetime: "0",
            data: {
                crid: e
            },
            success: function(t) {
                wx.navigateTo({
                    url: "../index/cforder/cforder?cid=" + a.currentTarget.dataset.cid
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "请选择商品~",
            showCancel: !1
        });
    },
    toTab: function(t) {
        var a = t.currentTarget.dataset.url;
        a = "/" + a, wx.redirectTo({
            url: a
        });
    }
});