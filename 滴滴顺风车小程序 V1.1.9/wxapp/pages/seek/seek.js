var t = getApp(), o = require("../../3421FA616A7AF98C524792666BF19D70.js");

Page({
    data: {
        origin: "",
        QDTIT: "",
        site: "",
        b_lnglat: ""
    },
    onLoad: function(o) {
        t.data.title = "", t.data.address = "", t.data.JWD = "";
    },
    origin: function(t) {
        var o = this;
        o.setData({
            origin: t.detail.value
        }), o.deom(t.detail.value);
    },
    deom: function(t) {
        var a = this;
        console.log(t), new o({
            key: "WEMBZ-A6IKG-TWFQP-I2ADL-ZRNK6-K4FMC"
        }).getSuggestion({
            keyword: t,
            success: function(t) {
                console.log(t.data), a.setData({
                    data: t.data
                });
            },
            fail: function(t) {
                console.log(t);
            },
            complete: function(t) {
                console.log(t);
            }
        });
    },
    title: function(t) {
        var o = this;
        o.data.commonality;
        o.setData({
            origin: t.currentTarget.dataset.address + t.currentTarget.dataset.title,
            origin_k: "",
            site: t.currentTarget.dataset.address,
            QDTIT: t.currentTarget.dataset.title
        }), o.price();
    },
    price: function(t) {
        var a = this, n = a.data.origin;
        new o({
            key: "WEMBZ-A6IKG-TWFQP-I2ADL-ZRNK6-K4FMC"
        }).geocoder({
            address: n,
            success: function(t) {
                console.log(t.result.location);
                var o = t.result.location.lat + "," + t.result.location.lng;
                a.setData({
                    b_lnglat: o
                }), console.log("起点腾讯接口获取经纬度 => b_lnglat", t.result.location.lat + "," + t.result.location.lng), 
                console.log("起点腾讯接口获取经纬度 => b_lnglat", o);
            },
            fail: function(t) {
                console.log(t);
            },
            complete: function(t) {
                console.log(t);
            }
        });
    },
    ok: function(o) {
        var a = this, n = a.data.QDTIT, e = a.data.site, l = a.data.b_lnglat;
        console.log(n), console.log(e), console.log(l), "" == l ? wx.showToast({
            title: "根据提示点击输入",
            icon: "none",
            duration: 2e3
        }) : (t.data.title = n, t.data.address = e, t.data.JWD = l, wx.navigateBack({
            delta: 1
        }));
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});