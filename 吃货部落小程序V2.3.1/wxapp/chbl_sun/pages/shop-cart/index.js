Array.prototype.remove = function(t) {
    var a = this.indexOf(t);
    -1 < a && this.splice(a, 1);
}, Array.prototype.indexOf = function(t) {
    for (var a = 0; a < this.length; a++) if (this[a] == t) return a;
    return -1;
};

var app = getApp(), tempArray = [];

Page({
    data: {
        buyNumMin: 1,
        buyNumMax: 10,
        totalPrice: 0,
        allSelect: !1,
        noSelect: !0,
        totalNum: 0,
        delShopCar: [],
        cartid: []
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var a = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    numJianTap: function(t) {
        console.log(t), console.log(this.data), console.log(this.data.buyNumMax);
        var a = t.currentTarget.dataset.crid, e = t.currentTarget.dataset.pindex, n = t.currentTarget.dataset.sindex, r = this.data.arr;
        console.log(r);
        var o = r[parseInt(e)].newdata[parseInt(n)].price / r[parseInt(e)].newdata[parseInt(n)].num;
        if (console.log(o), "" !== e && null != e && 1 < r[parseInt(e)].newdata[parseInt(n)].num) {
            r[parseInt(e)].newdata[parseInt(n)].num--, this.setData({
                arr: r,
                totalPrice: 0
            }), o || (o = this.data.arr[parseInt(e)].newdata[parseInt(n)].price);
            var s = o * r[parseInt(e)].newdata[parseInt(n)].num;
            r[parseInt(e)].newdata[parseInt(n)].price = s, this.setData({
                arr: r,
                totalPrice: 0
            }), this.totalPrice();
            var l = r[parseInt(e)].newdata[parseInt(n)].num, c = r[parseInt(e)].newdata[parseInt(n)].price;
            app.util.request({
                url: "entry/wxapp/buyNum",
                data: {
                    id: a,
                    num: l,
                    price: c
                },
                success: function(t) {}
            });
        }
    },
    numJiaTap: function(t) {
        console.log(t), console.log(this.data), console.log(this.data.buyNumMax);
        var a = t.currentTarget.dataset.crid, e = t.currentTarget.dataset.pindex, n = t.currentTarget.dataset.sindex, r = this.data.arr;
        console.log(r);
        var o = r[parseInt(e)].newdata[parseInt(n)].price / r[parseInt(e)].newdata[parseInt(n)].num;
        if (console.log(o), "" !== e && null != e && r[parseInt(e)].newdata[parseInt(n)].num < 10) {
            r[parseInt(e)].newdata[parseInt(n)].num++, this.setData({
                arr: r,
                totalPrice: 0
            }), o || (o = this.data.arr[parseInt(e)].newdata[parseInt(n)].price);
            var s = o * r[parseInt(e)].newdata[parseInt(n)].num;
            r[parseInt(e)].newdata[parseInt(n)].price = s, this.setData({
                arr: r,
                totalPrice: 0
            }), this.totalPrice();
            var l = r[parseInt(e)].newdata[parseInt(n)].num, c = r[parseInt(e)].newdata[parseInt(n)].price;
            app.util.request({
                url: "entry/wxapp/buyNum",
                data: {
                    id: a,
                    num: l,
                    price: c
                },
                success: function(t) {}
            });
        }
    },
    selectTap: function(t) {
        console.log(t);
        var a = t.currentTarget.dataset.index, e = t.currentTarget.dataset.ppindex, n = this.data.totalNum, r = this.data.arr;
        console.log(r);
        for (var o = 0; o < r[e].newdata.length; o++) console.log(r[e]), r[e].newdata[o].check ? (console.log("nnnnnnnnnnnnnn"), 
        o == a && (r[e].newdata[o].check = "", n--, this.setData({
            totalPrice: 0,
            totalNum: n
        }), this.totalPrice())) : o == a && (r[e].newdata[o].check = r[e].newdata[o].id, 
        n++, this.setData({
            totalPrice: 0,
            totalNum: n
        }), this.totalPrice()), this.setData({
            allSelect: !1
        });
        var s = r;
        console.log(r), this.setData({
            arr: s
        });
    },
    bindAllSelect: function(t) {
        console.log(this.data);
        var a = this.data.arr, e = 0, n = this.data;
        if (console.log(a), console.log(n), n.allSelect) {
            n.allSelect = "";
            for (r = 0; r < a.length; r++) for (o = 0; o < a[r].newdata.length; o++) a[r].newdata[o].check = "";
            this.setData({
                totalPrice: 0,
                totalNum: 0
            });
        } else {
            for (var r = 0; r < a.length; r++) e += a[r].newdata.length;
            this.setData({
                totalPrice: 0,
                totalNum: e
            }), n.allSelect = 1;
            for (var r = 0; r < a.length; r++) {
                console.log("进入");
                for (var o = 0; o < a[r].newdata.length; o++) a[r].newdata[o].check = 1;
            }
            console.log(a), this.totalPrice();
        }
        var s = a;
        this.setData({
            arr: s,
            allSelect: n.allSelect
        });
    },
    totalPrice: function() {
        var t = this.data.arr, a = this.data.totalPrice, e = Array();
        console.log(t);
        for (var n = 0; n < t.length; n++) for (var r = 0; r < t[n].newdata.length; r++) e = t[n].newdata[r], 
        console.log(e), e.check && (a += parseFloat(e.price));
        return a = parseFloat(a.toFixed(2)), this.setData({
            totalPrice: a
        }), a;
    },
    delShopCar: function(t) {
        console.log(this.data);
        for (var e = this, a = e.data.arr, n = Array(), r = 0; r < a.length; r++) for (var o = 0; o < a[r].newdata.length; o++) a[r].newdata[o].check && n.push(a[r].newdata[o].id);
        console.log(n);
        var s = "";
        0 == e.data.totalNum ? wx.showToast({
            title: "请选择删除的购物车！",
            icon: "none",
            duration: 2e3
        }) : wx.showModal({
            title: "提示",
            content: "确认删除该购物车吗？",
            success: function(t) {
                if (t.confirm) {
                    for (var a = 0; a < n.length; a++) console.log(n[a]), s += n[a] + ",";
                    console.log(s), app.util.request({
                        url: "entry/wxapp/DelSopCar",
                        cachetime: "0",
                        data: {
                            id: s
                        },
                        success: function(t) {
                            console.log(t), e.setData({
                                totalPrice: 0,
                                totalNum: 0
                            }), e.onShow();
                        }
                    });
                } else t.cancel;
            }
        });
    },
    toPayOrder: function(t) {
        console.log(t);
        var a = this.data.arr;
        console.log(a);
        for (var e = "", n = Array(), r = Array(), o = 0; o < a.length; o++) for (var s = 0; s < a[o].newdata.length; s++) a[o].newdata[s].check && n.push(a[o].newdata[s].id), 
        a[o].newdata[s].check && r.push(a[o].newdata[s].store_id);
        console.log(r);
        for (o = 0; o < n.length; o++) console.log(n[o]), e += n[o] + ",";
        if (console.log(e), e) {
            for (o = 0; o < r.length; o++) if (r[0] != r[o]) var l = 1;
            l ? wx.showToast({
                title: "请选择相同店铺商品进行结算！",
                icon: "none"
            }) : (wx.setStorage({
                key: "crid",
                data: {
                    crid: e
                }
            }), wx.navigateTo({
                url: "../to-pay-order/index?cid=" + t.currentTarget.dataset.cid
            }));
        } else wx.showModal({
            title: "提示",
            content: "请选择商品~",
            showCancel: !1
        });
    },
    onReady: function() {},
    onShow: function() {
        var r = this;
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
                        console.log(t.data.data);
                        var a = t.data.data, e = [];
                        for (var n in a) e.push(a[n]);
                        r.setData({
                            arr: e,
                            totalPrice: 0,
                            totalNum: 0
                        }), console.log(e);
                    }
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});