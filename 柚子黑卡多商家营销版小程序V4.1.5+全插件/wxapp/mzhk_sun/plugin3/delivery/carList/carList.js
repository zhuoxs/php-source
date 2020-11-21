/*   time:2019-08-09 13:18:47*/
var app = getApp();

function requestFun(t, r, n) {
    return n = new Promise(function(a, e) {
        app.util.request({
            url: r,
            data: n,
            success: function(t) {
                a(t.data)
            },
            fail: function(t) {
                e("系统异常,请重试")
            }
        })
    })
}
Page({
    data: {
        addClick: !0
    },
    onLoad: function(t) {},
    onReady: function() {},
    onShow: function() {
        var t = wx.getStorageSync("cars");
        wx.getStorageSync("openid");
        for (var a in t) t[a].hiddens = !0, t[a].info.length < 1 && delete t[a];
        0 < Object.keys(t).length ? this.setData({
            cars: t,
            url: wx.getStorageSync("url"),
            car_price: wx.getStorageSync("car_price")
        }) : wx.showModal({
            title: "提示",
            content: "购物车为空,是否前往商品列表",
            success: function(t) {
                t.confirm ? wx.redirectTo({
                    url: "/mzhk_sun/pages/goods/goods"
                }) : wx.navigateBack({
                    delta: 1
                })
            }
        })
    },
    onHide: function() {
        this.data.cars;
        var t = Number.parseFloat(this.data.car_price);
        wx.setStorageSync("car_price", t), wx.setStorageSync("cars", cars)
    },
    onUnload: function() {
        var t = this.data.cars,
            a = this.data.car_price;
        wx.setStorageSync("car_price", a), wx.setStorageSync("cars", t)
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    topay: function(t) {
        var a = this.data.cars[t.currentTarget.dataset.bid].info;
        wx.setStorageSync("deliveryInfo", a), wx.redirectTo({
            url: "/mzhk_sun/plugin3/delivery/delivery_order/delivery_order?deliveryCar_price=" + t.currentTarget.dataset.price + "&bid=" + t.currentTarget.dataset.bid + "&sincetype=0"
        })
    },
    toShop: function(t) {
        wx.redirectTo({
            url: "/mzhk_sun/pages/index/shop/shop?id=" + t.currentTarget.dataset.bid
        })
    },
    clear: function(t) {
        var a = this.data.cars,
            e = t.currentTarget.dataset.bid,
            r = this.data.car_price;
        delete a[e], delete r[e], this.setData({
            cars: a,
            car_price: r
        })
    },
    delivery_add: function(a) {
        var e = this,
            r = e.data.cars[a.currentTarget.dataset.bid].info[a.currentTarget.dataset.index],
            n = e.data.cars,
            i = e.data.car_price;
        e.data.addClick && (e.setData({
            addClick: !1
        }), 0 < r.is_delivery_limit - 0 ? app.util.request({
            url: "entry/wxapp/psnum",
            data: {
                gid: r.gid,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                if (!(r.num - 0 < t.data.num - 0 && r.num - 0 < t.data.delivery_limit - 0 - (t.data.total - 0))) return r.num - 0 == t.data.num - 0 && wx.showToast({
                    title: "该商品库存不足",
                    duration: 2e3,
                    icon: "none"
                }), r.num - 0 != t.data.delivery_limit - 0 && r.num - 0 != t.data.delivery_limit - 0 - (t.data.total - 0) || wx.showToast({
                    title: "超出商品限购",
                    duration: 2e3,
                    icon: "none"
                }), e.setData({
                    addClick: !0
                }), !1;
                ++r.num, i[a.currentTarget.dataset.bid] = (parseFloat(i[a.currentTarget.dataset.bid] - 0) + parseFloat(r.money - 0)).toFixed(2), n[a.currentTarget.dataset.bid].info[a.currentTarget.dataset.index] = r, e.setData({
                    cars: n,
                    car_price: i,
                    addClick: !0
                })
            }
        }) : app.util.request({
            url: "entry/wxapp/psnum",
            data: {
                gid: r.gid,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                if (r.num - 0 >= t.data.num - 0) return wx.showToast({
                    title: "商品库存不足",
                    duration: 2e3,
                    icon: "none"
                }), e.setData({
                    addClick: !0
                }), !1;
                ++r.num, n[a.currentTarget.dataset.bid].info[a.currentTarget.dataset.index] = r, i[a.currentTarget.dataset.bid] = (parseFloat(i[a.currentTarget.dataset.bid] - 0) + parseFloat(r.money - 0)).toFixed(2), e.setData({
                    cars: n,
                    car_price: i,
                    addClick: !0
                })
            }
        }))
    },
    delivery_reduce: function(t) {
        var a = this,
            e = a.data.cars[t.currentTarget.dataset.bid].info[t.currentTarget.dataset.index],
            r = a.data.cars,
            n = a.data.car_price;
        1 < e.num ? (--e.num, r[t.currentTarget.dataset.bid].info[t.currentTarget.dataset.index] = e, n[t.currentTarget.dataset.bid] = (parseFloat(n[t.currentTarget.dataset.bid] - 0).toFixed(2) - parseFloat(e.money - 0)).toFixed(2)) : (r[t.currentTarget.dataset.bid].info.splice(t.currentTarget.dataset.index, 1), n[t.currentTarget.dataset.bid] = (parseFloat(n[t.currentTarget.dataset.bid] - 0).toFixed(2) - parseFloat(e.money - 0)).toFixed(2), r[t.currentTarget.dataset.bid].info.length < 1 && (delete r[t.currentTarget.dataset.bid], delete n[t.currentTarget.dataset.bid])), a.setData({
            cars: r,
            car_price: n
        })
    },
    changeHiddens: function(t) {
        var a = this.data.cars,
            e = t.currentTarget.dataset.bid;
        a[e].hiddens = !a[e].hiddens, this.setData({
            cars: a
        })
    }
});