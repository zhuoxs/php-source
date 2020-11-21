function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page, app = getApp();

Page({
    data: {
        show: !1,
        padding: !1,
        check: {
            plat: !1,
            checkAll: !1
        },
        editFlag: !1,
        protect: !0
    },
    getPadding: function(t) {
        this.setData({
            padding: t.detail
        });
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("userInfo"), e = wx.getStorageSync("linkaddress");
        a ? this.setData({
            uInfo: a,
            linkaddress: e
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/home/shopcar/shopcar");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    onShow: function(t) {
        this.setData({
            check: {
                plat: !1,
                checkAll: !1
            }
        }), this.loadDate();
    },
    loadDate: function() {
        var e = this;
        app.ajax({
            url: "Csystem|getSetting",
            success: function(t) {
                e.setData({
                    setting: t.data
                }), wx.setStorageSync("appConfig", t.data);
            }
        }), app.ajax({
            url: "Ccart|getCarts",
            data: {
                user_id: e.data.uInfo.id,
                leader_id: e.data.linkaddress.id
            },
            success: function(t) {
                console.log(t.data);
                var a = 0;
                t.data.forEach(function(t) {
                    a += t.num;
                }), e.setData({
                    cart: t.data,
                    imgroot: t.other.img_root,
                    show: !0,
                    cartCount: a
                }), e.getTotal(), e.getCarnum();
            }
        });
    },
    getCarnum: function() {
        wx.setStorageSync("cartNum", this.data.cart.length);
    },
    getPlatform: function(t) {
        var a = this, e = a.data.check, c = a.data.cart;
        e.plat = !e.plat, e.checkAll = !1, c.list.forEach(function(t, a) {
            t.status = e.plat;
        }), a.setData({
            check: e,
            cart: c
        }), a.getTotal();
    },
    getShopCart: function(t) {
        var a = this, e = a.data.check, c = a.data.cart, n = t.currentTarget.dataset.index;
        c.mch_list[n].status = !c.mch_list[n].status, e.checkAll = !1, c.mch_list[n].list.forEach(function(t, a) {
            t.status = c.mch_list[n].status;
        }), a.setData({
            cart: c,
            check: e
        }), a.getTotal();
    },
    getSinglePlat: function(t) {
        var a = this, e = a.data.check, c = a.data.cart, n = t.currentTarget.dataset.index;
        e.plat = !1, e.checkAll = !1, c[n].status = !c[n].status, a.setData({
            check: e,
            cart: c
        }), a.getTotal();
    },
    getAllGoods: function(t) {
        var a = this, e = a.data.check, c = a.data.cart;
        e.checkAll = !e.checkAll, e.plat = e.checkAll, c.forEach(function(t, a) {
            t.status = e.checkAll;
        }), a.setData({
            check: e,
            cart: c
        }), a.getTotal();
    },
    addPlat: function(t) {
        var a = this, e = a.data.cart, c = a.data.cartCount, n = t.currentTarget.dataset.index, s = t.currentTarget.dataset.id, r = e[n].num + 1;
        a.changeNum(s, r).then(function() {
            e[n].num = r, a.setData({
                cart: e,
                cartCount: c + 1
            });
        }).catch(function() {}), a.getCarnum();
    },
    reducePlat: function(t) {
        var a = this, e = a.data.cart, c = a.data.cartCount, n = t.currentTarget.dataset.index, s = t.currentTarget.dataset.id;
        if (1 < e[n].num) {
            var r = e[n].num - 1;
            a.changeNum(s, r).then(function() {
                e[n].num = r, a.setData({
                    cartCount: c - 1,
                    cart: e
                });
            }).catch(function() {});
        } else wx.showToast({
            title: "商品数量不得少于1",
            icon: "none"
        });
        a.getCarnum();
    },
    changeNum: function(e, c) {
        var n = this;
        return n.data.protect ? (n.setData({
            protect: !1
        }), new Promise(function(a, t) {
            app.ajax({
                url: "Ccart|updateCart",
                data: {
                    cart_id: e,
                    num: c
                },
                success: function(t) {
                    n.setData({
                        protect: !0
                    }), 0 == t.code && (n.getTotal(), a());
                },
                fail: function(t) {
                    n.setData({
                        protect: !0
                    }), app.tips(t.data.msg);
                }
            });
        })) : Promise.reject();
    },
    getTotal: function(t) {
        var a = this.data.cart, e = 0;
        a.forEach(function(t, a) {
            t.status && (e += parseFloat(t.price * t.num));
        }), this.setData({
            totalPrice: e.toFixed(2)
        });
    },
    editCart: function(t) {
        var a;
        this.setData((_defineProperty(a = {}, "check.checkAll", !0), _defineProperty(a, "editFlag", !this.data.editFlag), 
        a)), this.getAllGoods();
    },
    deleCarts: function(t) {
        var a = this, e = (a.data.cart, t.currentTarget.dataset.id);
        "" != e ? app.ajax({
            url: "Ccart|deleteCarts",
            data: {
                cart_ids: e
            },
            success: function(t) {
                0 == t.code && (wx.showToast({
                    title: "删除成功"
                }), a.loadDate());
            }
        }) : wx.showToast({
            title: "请选择商品",
            icon: "none"
        }), a.getCarnum();
    },
    toOrder: function(t) {
        var a = this, c = a.data.cart, e = [], n = a.data.protect, s = [];
        c.forEach(function(t, a) {
            t.status && (e.push(t), s.push(t.id));
        }), e.length && n ? (a.setData({
            protect: !1
        }), app.ajax({
            url: "Ccart|checkStock",
            data: {
                cart_ids: s.join(",")
            },
            success: function(t) {
                if (0 == t.code) {
                    if (t.data.length) return t.data.forEach(function(e) {
                        c.forEach(function(t, a) {
                            t.id == e.id && (t.limit = e.num);
                        });
                    }), void a.setData({
                        cart: c,
                        protect: !0
                    });
                    a.setData({
                        goodses: e,
                        protect: !0
                    }), app.navTo("/sqtg_sun/pages/zkx/pages/classifyorder/classifyorder");
                }
            }
        })) : wx.showToast({
            title: "请选择商品",
            icon: "none"
        });
    }
});