var _Page;

function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var app = getApp(), wxbarcode = require("../../../../style/utils/index.js");

Page((_defineProperty(_Page = {
    data: {
        navTile: "订单详情",
        addr: [ "墨纸", "1300000000", "厦门市集美区杏林湾运营中心" ],
        shopname: "柚子鲜花店",
        goods: [ {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            goodsThumb: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            price: "2.50",
            specConn: "s",
            num: "1"
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            goodsThumb: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            price: "2.50",
            specConn: "套餐1",
            num: "1"
        } ],
        distribution: "0.00",
        totalprice: "2.50",
        discount: "30.00",
        orderNnum: "1234567897",
        time: "2018-05-01 10:10:10",
        status: 1,
        order: {
            order_status: 0
        }
    },
    onLoad: function(e) {
        var t = this;
        wx.setStorageSync("oid", e.oid), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        });
        var a = '{ "id": ' + e.oid + ', "ordertype": 1}';
        wxbarcode.qrcode("qrcode", a, 320, 320);
    },
    topay: function(e) {},
    toCancel: function(e) {},
    toDel: function(e) {},
    onReady: function() {},
    onShow: function() {
        var t = this, e = wx.getStorageSync("oid");
        app.util.request({
            url: "entry/wxapp/OrderDetails",
            cachetime: "0",
            data: {
                oid: e
            },
            success: function(e) {
                console.log(e.data), t.setData({
                    details: e.data
                });
            }
        });
    }
}, "toDel", function(e) {
    var t = e.currentTarget.dataset.oid;
    wx.showModal({
        title: "提示",
        content: "确认取消订单吗",
        success: function(e) {
            e.confirm ? app.util.request({
                url: "entry/wxapp/OrderDelete",
                cachetime: "0",
                method: "GET",
                data: {
                    oid: t
                },
                success: function(e) {
                    wx.navigateBack({});
                }
            }) : e.cancel && console.log("用户点击取消");
        },
        fail: function(e) {}
    });
}), _defineProperty(_Page, "toCancel", function(e) {
    var t = this, a = e.currentTarget.dataset.oid;
    app.util.request({
        url: "entry/wxapp/Orderqueren",
        cachetime: "0",
        data: {
            oid: a
        },
        success: function(e) {
            wx.showToast({
                title: "确认成功！"
            }), t.onShow();
        }
    });
}), _defineProperty(_Page, "topay", function(e) {
    var t = this, a = wx.getStorageSync("openid"), n = e.currentTarget.dataset.oid, o = t.data.details.money;
    app.util.request({
        url: "entry/wxapp/Orderarr",
        data: {
            price: o,
            openid: a
        },
        success: function(e) {
            console.log(e.data), wx.requestPayment({
                timeStamp: e.data.timeStamp,
                nonceStr: e.data.nonceStr,
                package: e.data.package,
                signType: "MD5",
                paySign: e.data.paySign,
                success: function(e) {
                    wx.showToast({
                        title: "支付成功",
                        icon: "success",
                        duration: 2e3
                    }), app.util.request({
                        url: "entry/wxapp/PayOrder",
                        cachetime: "0",
                        data: {
                            order_id: n
                        },
                        success: function(e) {
                            t.onShow();
                        }
                    });
                },
                fail: function(e) {}
            });
        }
    });
}), _defineProperty(_Page, "onHide", function() {}), _defineProperty(_Page, "onUnload", function() {}), 
_defineProperty(_Page, "onPullDownRefresh", function() {}), _defineProperty(_Page, "onReachBottom", function() {}), 
_defineProperty(_Page, "deletes", function(e) {}), _defineProperty(_Page, "cancel", function(e) {}), 
_defineProperty(_Page, "subPay", function(e) {}), _defineProperty(_Page, "toMap", function(e) {
    var t = parseFloat(e.currentTarget.dataset.latitude), a = parseFloat(e.currentTarget.dataset.longitude);
    wx.openLocation({
        latitude: t,
        longitude: a,
        scale: 28
    });
}), _Page));