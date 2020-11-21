var app = getApp();

Page({
    data: {
        detail: [],
        points: !1,
        id: "",
        code: "",
        value: !1,
        moreMissions: !0,
        oid: "",
        contain: !0,
        express_delivery: "",
        express_no: ""
    },
    onLoad: function(a) {
        var t = a.id, e = a.oid;
        console.log("你的商品oid是多少oid"), console.log(e), this.setData({
            id: t,
            oid: e
        });
        var o = this, n = wx.getStorageSync("user").openid;
        app.util.request({
            url: "entry/wxapp/getGoodsDetail",
            data: {
                m: app.globalData.Plugin_scoretask,
                id: t,
                openid: n
            },
            showLoading: !1,
            success: function(a) {
                o.setData({
                    details: a.data.data,
                    imgroot: a.data.other.img_root
                });
            }
        }), o.getgetOrderDetail();
    },
    task: function(a) {
        wx.redirectTo({
            url: "../assignment/assignment"
        }), console.log();
    },
    pointsMall: function() {
        wx.redirectTo({
            url: "../integrationMall/integrationMall"
        });
    },
    preventTouchMove: function() {},
    go: function() {
        this.setData({
            showModel: !1
        });
    },
    mark: function() {
        this.setData({
            showModel6: !1
        });
    },
    bulletWindow: function() {
        this.setData({
            points: !0
        });
    },
    close: function() {
        this.setData({
            points: !1
        });
    },
    earnPoints: function() {
        wx.navigateTo({
            url: "../assignment/assignment"
        });
    },
    orderUser: function(a) {
        var t = a.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../orderUser/orderUser?id=" + t
        });
    },
    getgetOrderDetail: function() {
        var l = this, a = (l.data.id, l.data.oid);
        console.log("你得到了oid是吗"), console.log(a);
        var t = wx.getStorageSync("user").openid;
        app.util.request({
            url: "entry/wxapp/getOrderDetail",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: t,
                id: a
            },
            showLoading: !1,
            success: function(a) {
                console.log("商品信息"), console.log(a.data.data);
                var t = a.data.data.express_delivery;
                console.log("有物流信息吗"), console.log(t);
                var e = a.data.data.name, o = a.data.data.phone, n = a.data.data.province, s = a.data.data.zip, i = a.data.data.city, d = a.data.data.address;
                l.setData({
                    name: e,
                    phone: o,
                    province: n,
                    zip: s,
                    city: i,
                    address: d
                }), t ? l.setData({
                    express_delivery: t
                }) : l.setData({
                    contain: !1
                });
                var r = a.data.data.express_no;
                r ? l.setData({
                    express_no: r
                }) : l.setData({
                    contain: !1
                }), l.setData({
                    list: a.data.data,
                    imgroot: a.data.other.img_root
                });
            }
        });
    },
    consignee: function(a) {
        this.data.id, a.currentTarget.dataset.id;
        console.log("你大大爷爷的有id吗"), wx.navigateTo({
            url: "../addressManagement/addressManagement"
        });
    }
});