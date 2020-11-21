var e = require("../../../utils/base.js"), a = require("../../../../api.js"), t = new e.Base();

Page({
    data: {
        timer: ""
    },
    onLoad: function(e) {
        this.setData({
            express: e.express,
            express_no: e.express_no,
            orderId: e.id,
            orderType: e.orderType
        }), "null" != e.express && "null" != e.express_no ? this.express(e) : this.setData({
            expressInfo: []
        }), this.orderDetail(e.id);
    },
    onUnload: function() {
        clearInterval(this.data.timer);
    },
    copy: function(e) {
        var a = e.target.dataset.orderon;
        wx.setClipboardData({
            data: a,
            success: function(e) {
                wx.showToast({
                    title: "复制成功"
                });
            }
        });
    },
    express: function(e) {
        var a = this, r = {
            url: "express",
            data: {
                expressName: e.express,
                expressNumber: e.express_no
            }
        };
        t.getData(r, function(e) {
            0 != e.errorCode && a.setData({
                expressInfo: e.data
            });
        });
    },
    orderDetail: function(e) {
        var r = this, o = {
            url: a.default.order_detail,
            data: {
                orderId: e
            }
        };
        t.getData(o, function(e) {
            var a = 0;
            for (var t in e.data.snap_info) a += e.data.snap_info[t].price * e.data.snap_info[t].num;
            r.setData({
                orderInfo: e.data,
                change_price: Number(e.data.change_price),
                pchange_price: Math.abs(e.data.change_price),
                goodsPrice: a.toFixed(2)
            }), 0 == e.data.status && r.orderTime();
        });
    },
    call: function(e) {
        var a = e.currentTarget.dataset.tel;
        t.Call(a);
    },
    openLocation: function(e) {
        wx.openLocation({
            latitude: parseFloat(e.currentTarget.dataset.latitude),
            longitude: parseFloat(e.currentTarget.dataset.longitude),
            name: e.currentTarget.dataset.name,
            address: e.currentTarget.dataset.address
        });
    },
    orderTime: function(e) {
        var a = this, t = wx.getStorageSync("store_info").info.order_time;
        t && t > 0 && (a.data.timer = setInterval(function() {
            var e = new Date(), t = (a.data.orderInfo.create_time, a.data.orderInfo.overdue), r = new Date(t.replace(/-/g, "/")).getTime() - e.getTime();
            if (r > 0) {
                var o = Math.floor(r / 864e5), s = r % 864e5, n = Math.floor(s / 36e5), i = s % 36e5, d = Math.floor(i / 6e4), c = i % 6e4, l = Math.round(c / 1e3);
                a.setData({
                    days: o,
                    hours: n,
                    minutes: d,
                    seconds: l
                });
            } else clearInterval(a.data.timer), wx.showModal({
                title: "提示",
                content: "该订单已超过有效期，请重新下单",
                showCancel: !1,
                complete: function(e) {
                    wx.redirectTo({
                        url: "../order/order?sindex=0&kind=all"
                    });
                }
            });
        }, 1e3));
    }
});