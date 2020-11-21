function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var common = require("../common/common.js"), app = getApp();

Page({
    data: {
        navHref: "../cart/cart",
        canload: !0,
        allcount: 0,
        list: []
    },
    deleteFunc: function(a) {
        var e = this, n = a.currentTarget.id;
        wx.showModal({
            title: "确认删除",
            content: "是否删除这个商品？",
            success: function(a) {
                if (a.confirm) {
                    var t = e.data.list;
                    app.util.request({
                        url: "entry/wxapp/service",
                        method: "POST",
                        data: {
                            op: "shop_del",
                            id: t[n].id,
                            all: -1
                        },
                        success: function(a) {
                            "" != a.data.data && (t.splice(n, 1), e.setData({
                                list: t
                            }), e.allcount());
                        }
                    });
                } else a.cancel;
            }
        });
    },
    numMinus: function(a) {
        var t = this;
        if (t.data.canload) {
            t.setData({
                canload: !1
            });
            var e = a.currentTarget.id, n = t.data.list[e].member, s = "list[" + e + "].member";
            1 == n || n--;
            var o = {
                op: "shop_sum",
                id: t.data.list[e].id,
                member: n
            };
            app.util.request({
                url: "entry/wxapp/service",
                method: "POST",
                showLoading: !1,
                data: o,
                success: function(a) {
                    "" != a.data.data && (t.setData(_defineProperty({}, s, n)), t.allcount());
                },
                complete: function() {
                    t.setData({
                        canload: !0
                    });
                }
            });
        }
    },
    numPlus: function(a) {
        var t = this;
        if (t.data.canload) {
            t.setData({
                canload: !1
            });
            var e = a.currentTarget.id, n = t.data.list[e].member, s = "list[" + e + "].member";
            n++;
            var o = {
                op: "shop_sum",
                id: t.data.list[e].id,
                member: n
            };
            app.util.request({
                url: "entry/wxapp/service",
                method: "POST",
                showLoading: !1,
                data: o,
                success: function(a) {
                    "" != a.data.data && (t.setData(_defineProperty({}, s, n)), t.allcount());
                },
                complete: function() {
                    t.setData({
                        canload: !0
                    });
                }
            });
        }
    },
    valChange: function(a) {
        var t = this;
        if (t.data.canload) {
            t.setData({
                canload: !1
            });
            var e = a.currentTarget.id, n = a.detail.value, s = "list[" + e + "].member";
            1 <= n || (n = 1);
            var o = {
                op: "shop_sum",
                id: t.data.list[e].id,
                member: n
            };
            app.util.request({
                url: "entry/wxapp/service",
                method: "POST",
                showLoading: !1,
                data: o,
                success: function(a) {
                    "" != a.data.data && (t.setData(_defineProperty({}, s, n)), t.allcount());
                },
                complete: function() {
                    t.setData({
                        canload: !0
                    });
                }
            });
        }
    },
    allcount: function() {
        for (var a = this, t = 0, e = 0; e < a.data.list.length; e++) t = (parseFloat(t) + parseInt(a.data.list[e].member) * parseFloat(a.data.list[e].price)).toFixed(2);
        a.setData({
            allcount: t
        });
    },
    resetFunc: function() {
        var t = this;
        0 < t.data.list.length && wx.showModal({
            title: "确认清空",
            content: "是否清空购物车？",
            success: function(a) {
                a.confirm ? app.util.request({
                    url: "entry/wxapp/service",
                    method: "POST",
                    data: {
                        op: "shop_del",
                        all: 1
                    },
                    success: function(a) {
                        "" != a.data.data && (t.setData({
                            list: []
                        }), t.allcount());
                    }
                }) : a.cancel;
            }
        });
    },
    submit: function() {
        var a = this.data.list;
        common.is_bind(function() {
            0 < a.length && wx.navigateTo({
                url: "../cart_pay/cart_pay?&order_type=1"
            });
        });
    },
    onLoad: function(a) {
        var e = this;
        common.config(e), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "shop"
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && (e.setData({
                    list: t.data
                }), e.allcount());
            }
        });
    },
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "shop"
            },
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data && (e.setData({
                    list: t.data
                }), e.allcount());
            }
        });
    }
});