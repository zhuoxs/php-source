var t = require("../../../utils/base.js"), a = require("../../../../api.js"), e = new t.Base(), r = getApp();

Page({
    data: {},
    onLoad: function(t) {
        r.pageOnLoad(), this.getCart(), this.guessYouLike();
        var a = wx.getStorageSync("userData");
        a.user_info ? this.setData({
            is_vip: a.user_info.is_vip
        }) : this.getUserData();
    },
    onShow: function() {
        this.getCart();
    },
    getUserData: function() {
        var t = this, r = {
            url: a.default.user
        };
        e.getData(r, function(a) {
            var e = 0;
            1 == a.errorCode && (wx.setStorageSync("userData", a), e = a.user_info.is_vip), 
            t.setData({
                userData: a,
                is_vip: e
            });
        });
    },
    getCart: function() {
        var t = this, r = [], i = [], o = [], s = {
            url: a.default.getCart,
            method: "GET"
        };
        e.getData(s, function(a) {
            if (console.log("购物车数据", a), 1 == a.errorCode) {
                for (var e in a.data.info) 1 == a.data.info[e].product.can_buy ? r.push(a.data.info[e]) : (i.push(a.data.info[e]), 
                o.push(a.data.info[e].id));
                t.setData({
                    cartList: r,
                    total_price: a.data.total_price,
                    notCartList: i,
                    idArray: o
                }), t.cheched(a.data.info);
            }
        });
    },
    cheched: function(t) {
        var a = 0, e = "checked", r = [], i = !1;
        if (t) {
            for (var o = 0; o < t.length; o++) r.push(t[o].id), 1 == t[o].is_checked && 1 == t[o].product.can_buy && a++;
            a == this.data.cartList.length ? (e = "cancel", i = !0) : (e = "checked", i = !1), 
            this.setData({
                op: e,
                cartIdArray: r,
                allChecked: i
            });
        }
    },
    checkGoods: function(t) {
        var r = this, i = [];
        i.push(t.currentTarget.dataset.id);
        var o = {
            url: a.default.cartCheck,
            data: {
                cartId: i
            }
        };
        e.getData(o, function(t) {
            1 == t.errorCode && r.getCart();
        });
    },
    checkAll: function(t) {
        var r = this, i = {
            url: a.default.cartCheck,
            data: {
                cartId: this.data.cartIdArray,
                op: this.data.op
            }
        };
        e.getData(i, function(t) {
            1 == t.errorCode && r.getCart();
        });
    },
    deleteGoods: function(t) {
        var r = this, i = [];
        "one" == t.currentTarget.dataset.type ? i.push(t.currentTarget.dataset.id) : i = this.data.idArray, 
        wx.showModal({
            title: "您确定删除该商品吗？",
            success: function(t) {
                if (t.confirm) {
                    var o = {
                        url: a.default.cartDel,
                        data: {
                            cartId: i
                        }
                    };
                    console.log("删除id=>", o), e.getData(o, function(t) {
                        console.log("删除res=>", t), 1 == t.errorCode && (r.getCart(), r.cheched(r.data.cartList));
                    });
                }
            }
        });
    },
    addNum: function(t) {
        var r = this, i = t.currentTarget.dataset.id, o = {
            url: a.default.cartEdit,
            data: {
                num: 1,
                cartId: i
            }
        };
        e.getData(o, function(t) {
            1 == t.errorCode ? r.getCart() : wx.showToast({
                title: t.msg,
                icon: "none"
            });
        });
    },
    sumNum: function(t) {
        var r = this, i = t.currentTarget.dataset.id, o = {
            url: a.default.cartEdit,
            data: {
                num: -1,
                cartId: i
            }
        };
        e.getData(o, function(t) {
            1 == t.errorCode && r.getCart();
        });
    },
    toPay: function(t) {
        for (var a = 0, e = this.data.cartList, r = 0; r < e.length; r++) 1 == e[r].is_checked && a++;
        a > 0 ? wx.navigateTo({
            url: "../../User/order/order_pay/order_pay?buyType=1"
        }) : wx.showToast({
            title: "请勾选商品",
            icon: "none",
            duration: 2e3
        });
    },
    guessYouLike: function() {
        var t = this, r = {
            url: a.default.guess
        };
        e.getData(r, function(a) {
            if (1 == a.errorCode) for (var e in a.data) a.data[e].price = parseFloat(a.data[e].price), 
            a.data[e].o_price = parseFloat(a.data[e].o_price), a.data[e].vip_price = parseFloat(a.data[e].vip_price);
            t.setData({
                guessGood: a.data
            });
        });
    },
    navigatorLink: function(t) {
        console.log(t), r.navClick(t, this);
    }
});