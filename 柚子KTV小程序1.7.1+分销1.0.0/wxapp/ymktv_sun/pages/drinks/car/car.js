function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        total: 0,
        bid: 0,
        state: 1,
        ids: []
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), this.url();
    },
    onShow: function() {
        var s = this, o = wx.getStorageSync("bid");
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/HaveCart",
                    cachetime: "0",
                    data: {
                        openid: t.data,
                        bid: o
                    },
                    success: function(t) {
                        console.log(t.data);
                        for (var a = 0, e = 0; e < t.data.length; e++) {
                            a += Number(t.data[e].numvalue) * Number(t.data[e].drink_price);
                        }
                        s.setData({
                            goods: t.data,
                            total: a,
                            bid: t.data[0] ? t.data[0].build_id : o
                        });
                    }
                });
            }
        });
    },
    url: function(t) {
        var a = this;
        app.util.request({
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
    addnum: function(a) {
        var t = this, e = a.currentTarget.dataset.index, s = t.data.goods[e].numvalue;
        s++;
        var o = "goods[" + e + "].numvalue";
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/cartnum",
                    cachetime: "0",
                    data: {
                        crid: a.currentTarget.dataset.crid,
                        openid: t.data,
                        num: s
                    },
                    success: function(t) {}
                });
            }
        }), t.setData(_defineProperty({}, o, s)), t.countCart();
    },
    subbnum: function(a) {
        var t = this, e = a.currentTarget.dataset.index, s = t.data.goods[e].numvalue;
        1 < s && (s -= 1);
        var o = "goods[" + e + "].numvalue";
        wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/cartnum",
                    cachetime: "0",
                    data: {
                        crid: a.currentTarget.dataset.crid,
                        openid: t.data,
                        num: s
                    },
                    success: function(t) {}
                });
            }
        }), t.setData(_defineProperty({}, o, s)), t.countCart();
    },
    goImmediately: function(t) {
        for (var a = this, e = 0; e < a.data.goods.length; e++) 1 == a.data.goods[e].status && a.data.ids.push(a.data.goods[e].crid);
        console.log(a.data), a.data.ids.length < 1 ? wx.showToast({
            title: "请选择商品！",
            icon: "none",
            duration: 2e3
        }) : wx.navigateTo({
            url: "../immediately/immediately?ids=" + a.data.ids + "&bid=" + a.data.bid,
            success: function(t) {
                a.setData({
                    ids: []
                });
            }
        });
    },
    choosecheck: function(t) {
        var a = this, e = t.currentTarget.dataset.index, s = a.data.goods[e].status;
        s = 0 == s ? 1 : 0;
        var o = "goods[" + e + "].status";
        a.setData(_defineProperty({}, o, s)), a.countCart();
        for (var r = [], n = 0; n < a.data.goods.length; n++) 0 == a.data.goods[n].status ? a.data.state = 0 : r.push(a.data.goods[n]);
        r.length == a.data.goods.length && (a.data.state = 1), a.setData({
            state: a.data.state
        });
    },
    closeitem: function(t) {
        var a = this, e = t.currentTarget.dataset.crid, s = t.currentTarget.dataset.index, o = a.data.goods;
        wx.showModal({
            title: "提示",
            content: "确认删除吗！",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/DeleteCart",
                    cachetime: "0",
                    data: {
                        crid: e
                    },
                    success: function(t) {
                        o.splice(s, 1), a.setData({
                            goods: o
                        }), a.countCart();
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    countCart: function() {
        for (var t = 0, a = 0; a < this.data.goods.length; a++) {
            if (1 == this.data.goods[a].status) t += Number(this.data.goods[a].numvalue) * Number(this.data.goods[a].drink_price);
        }
        this.setData({
            total: t
        });
    },
    taollchose: function(t) {
        var a = this.data.state, e = JSON.parse(JSON.stringify(this.data.goods));
        if (0 == a) {
            for (var s in e) e[s].status = 1;
            this.setData({
                goods: e,
                state: 1
            });
        } else {
            for (var o in e) e[o].status = 0;
            this.setData({
                goods: e,
                state: 0
            });
        }
        this.countCart();
    },
    allCheck: function() {
        var t = this.data.status, a = JSON.parse(JSON.stringify(this.data.product));
        if (!0 === t) {
            for (var e in a) a[e].status = !1;
            this.setData({
                product: a,
                status: !1
            });
        } else {
            for (var s in a) a[s].status = !0;
            this.setData({
                product: a,
                status: !0
            });
        }
    }
});