var app = getApp(), wxbarcode = require("../../../../style/utils/index.js");

Page({
    data: {
        award: [ "特等奖", "一等奖", "二等奖", "三等奖", "四等奖" ],
        coupon: {}
    },
    onLoad: function(t) {
        var e = t.id;
        if (e <= 0 || !e || "undefined" == e) return wx.showModal({
            title: "提示",
            content: "参数错误，获取不到商品，点击确认跳转到首页",
            showCancel: !1,
            success: function(t) {
                wx.redirectTo({
                    url: "/pages/plugin/eatvisit/life/life"
                });
            }
        }), !1;
        this.setData({
            id: e
        });
    },
    onReady: function() {
        var n = this, a = n.data.id;
        app.util.request({
            url: "entry/wxapp/GetOrderInfo",
            data: {
                id: a,
                m: app.globalData.Plugin_eatvisit
            },
            showLoading: !1,
            success: function(t) {
                if (console.log(t.data), 2 != t.data) {
                    var e = t.data;
                    n.setData({
                        coupon: e
                    });
                    var o = '{ "id": ' + a + ', "ordertype": "10"}';
                    wxbarcode.qrcode("qrcode", o, 420, 420);
                } else n.setData({
                    orderlist: []
                });
            }
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    bindblur: function(t) {
        this.setData({
            code: t.detail.value
        });
    },
    subCode: function(t) {
        this.data.code || wx.showToast({
            title: "请输入核销码",
            icon: "none"
        });
    },
    toLifeDet: function(t) {
        wx.navigateTo({
            url: "/pages/index/lifedet/lifedet"
        });
    },
    toDel: function(t) {
        wx.showModal({
            title: "提示",
            content: "优惠券删除后不再显示!",
            success: function(t) {
                t.confirm;
            }
        });
    },
    getDialog: function(t) {
        var e = this.data.coupon;
        wx.makePhoneCall({
            phoneNumber: e.tel
        });
    },
    toMap: function(t) {
        var e = this.data.coupon, o = Number(e.longitude), n = Number(e.latitude);
        if (0 == o && 0 == n) return !1;
        wx.openLocation({
            name: e.address,
            latitude: n,
            longitude: o,
            scale: 18,
            address: e.address
        });
    }
});