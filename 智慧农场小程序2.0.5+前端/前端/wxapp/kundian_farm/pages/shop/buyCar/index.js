var t = new getApp(), a = t.siteInfo.uniacid;

Page({
    data: {
        SystemInfo: t.globalData.sysData,
        buyList: [],
        checkAll: !1,
        sumPrice: 0,
        cart_id: [],
        page: 1,
        farmSetData: [],
        tarbar: wx.getStorageSync("kundianFarmTarbar"),
        is_tarbar: !1,
        height: 0
    },
    onLoad: function(e) {
        var i = this, c = wx.getStorageSync("kundian_farm_uid"), n = !1;
        e.is_tarbar && (n = e.is_tarbar);
        var r = 0, s = t.globalData.sysData;
        r = n ? s.model.indexOf("iPhone X") > -1 ? 162 : 100 : s.model.indexOf("iPhone X") > -1 ? 62 : 0, 
        i.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData"),
            tarbar: wx.getStorageSync("kundianFarmTarbar"),
            is_tarbar: n,
            height: r
        }), 0 != c ? t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "cart",
                op: "cartList",
                uid: c,
                uniacid: a
            },
            success: function(t) {
                i.setData({
                    buyList: t.data.cartData
                });
            }
        }) : wx.redirectTo({
            url: "../../login/index"
        }), t.util.setNavColor(a);
    },
    reduceNum: function(e) {
        var i = this, c = e.currentTarget.dataset.id, n = wx.getStorageSync("kundian_farm_uid"), r = i.data.buyList;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "cart",
                op: "reducuCount",
                uid: n,
                uniacid: a,
                id: c
            },
            success: function(t) {
                if (1 == t.data.code) for (var a = 0; a < r.length; a++) r[a].id == c && (t.data.count ? r[a].count = t.data.count : r.splice(a, 1)); else wx.showToast({
                    title: "操作失败"
                });
                i.setData({
                    buyList: r
                }), i.sumPrice();
            }
        });
    },
    addNum: function(e) {
        var i = this, c = e.currentTarget.dataset.id, n = wx.getStorageSync("kundian_farm_uid"), r = i.data.buyList;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "cart",
                op: "addCount",
                uid: n,
                uniacid: a,
                id: c
            },
            success: function(t) {
                if (1 == t.data.code) for (var a = 0; a < r.length; a++) r[a].id == c && (r[a].count = t.data.count); else wx.showToast({
                    title: "操作失败"
                });
                i.setData({
                    buyList: r
                }), i.sumPrice();
            }
        });
    },
    checked: function(t) {
        var a = this, e = t.currentTarget.dataset.id, i = 0, c = a.data.cart_id;
        a.data.buyList.map(function(t) {
            if (t.id == e) if (t.check = !t.check, t.check) c.push(e); else for (var a = 0; a < c.length; a++) c[a] == e && c.splice(a, 1);
            i += t.price * t.count;
        }), a.setData({
            buyList: a.data.buyList
        }), a.sumPrice(), i == a.data.sumPrice ? a.setData({
            checkAll: !0
        }) : a.setData({
            checkAll: !1
        });
    },
    sumPrice: function() {
        var t = this, a = 0;
        t.data.buyList.map(function(t) {
            parseInt(t.goodsStock) >= parseInt(t.count) && t.check && (a += t.count * t.price);
        }), t.setData({
            sumPrice: a.toFixed(2)
        });
    },
    checkAll: function() {
        for (var t = this, a = t.data.buyList, e = new Array(), i = 0; i < a.length; i++) a[i].goodsStock > 0 && e.push(a[i].id);
        t.data.buyList.map(function(a) {
            t.data.checkAll ? a.check = !1 : a.check = !0;
        }), t.setData({
            checkAll: !t.data.checkAll,
            buyList: t.data.buyList,
            cart_id: e
        }), t.sumPrice();
    },
    deleteItem: function(e) {
        var i = this, c = e.currentTarget.dataset.id, n = wx.getStorageSync("kundian_farm_uid"), r = i.data.buyList;
        r.map(function(t, a) {
            t.id == c && r.splice(a, 1);
        }), i.setData({
            buyList: r
        }), 0 == i.data.buyList.length && i.setData({
            checkAll: !1
        }), t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "cart",
                op: "deleteCart",
                uid: n,
                uniacid: a,
                id: c
            },
            success: function(t) {
                1 != t.data.code ? wx.showToast({
                    title: "操作失败",
                    icon: "none"
                }) : wx.showToast({
                    title: "已删除",
                    icon: "none"
                });
            }
        }), i.sumPrice();
    },
    intoJieSuan: function(t) {
        var a = this.data.cart_id, e = a.join("_");
        "" != a && 0 != a.length ? wx.navigateTo({
            url: "../confrimOrder/index?cart_id=" + e
        }) : wx.showToast({
            title: "请选择商品",
            icon: "none"
        });
    },
    onReachBottom: function(e) {
        var i = this, c = wx.getStorageSync("kundian_farm_uid"), n = i.data, r = n.page, s = n.cartData;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "cart",
                op: "cartList",
                uid: c,
                uniacid: a,
                page: r
            },
            success: function(t) {
                if ("" != t.data.cartData) {
                    for (var a = t.data.cartData, e = 0; e < a.length; e++) s.push(a[e]);
                    i.setData({
                        buyList: s,
                        page: parseInt(r) + 1
                    });
                }
            }
        });
    },
    goBuyGoods: function(t) {
        wx.navigateTo({
            url: "../index/index"
        });
    },
    ListTouchStart: function(t) {
        this.setData({
            ListTouchStart: t.touches[0].pageX
        });
    },
    ListTouchMove: function(t) {
        this.setData({
            ListTouchDirection: this.data.ListTouchStart - t.touches[0].pageX > 50 ? "left" : "right"
        });
    },
    ListTouchEnd: function(t) {
        var a = null;
        "left" == this.data.ListTouchDirection && (a = t.currentTarget.dataset.target), 
        this.setData({
            ListTouchDirection: null,
            modalName: a
        });
    }
});