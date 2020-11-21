var app = getApp(), WxParse = require("../../../../../zhy/template/wxParse/wxParse.js");

Page({
    data: {},
    onLoad: function(a) {
        var t = this;
        app.ajax({
            url: "Csystem|getSetting",
            success: function(a) {
                t.setData({
                    setting: a.data
                }), wx.setStorageSync("appConfig", a.data);
            }
        }), t.setData({
            id: a.id,
            show: !0
        }), t.getOrder();
    },
    getOrder: function() {
        var t = this;
        app.ajax({
            url: "Corder|getOrder",
            data: {
                order_id: t.data.id
            },
            success: function(a) {
                t.setData({
                    olist: a.data,
                    imgroot: a.other.img_root
                });
            }
        });
    },
    onShow: function() {},
    loadData: function() {},
    onShareAppMessage: function() {
        return {
            title: this.data.goods.name
        };
    },
    cancelOrder: function(a) {
        var t = this, e = a.currentTarget.dataset.index, s = t.data.olist;
        wx.showModal({
            title: "提示",
            content: "确定取消该订单吗",
            success: function(a) {
                a.confirm && app.ajax({
                    url: "Corder|cancelOrder",
                    data: {
                        order_id: s.id
                    },
                    success: function(a) {
                        wx.showToast({
                            title: "取消成功"
                        }), wx.navigateBack({}), s.splice(e, 1), t.setData({
                            olist: s
                        });
                    }
                });
            }
        });
    },
    payNow: function(a) {
        var t = this;
        a.currentTarget.dataset.index;
        app.ajax({
            url: "Corder|payOrder",
            data: {
                order_id: t.data.olist.id
            },
            success: function(a) {
                a.other.paydata && wx.requestPayment({
                    timeStamp: a.other.paydata.timeStamp,
                    nonceStr: a.other.paydata.nonceStr,
                    package: a.other.paydata.package,
                    signType: a.other.paydata.signType,
                    paySign: a.other.paydata.paySign,
                    success: function(a) {
                        app.reTo("/sqtg_sun/pages/zkx/pages/ordersuccess/ordersuccess");
                    }
                });
            },
            complete: function() {
                t.setData({
                    isRequest: 0
                });
            }
        });
    },
    deleteOrder: function(a) {
        var t = this.data.olist;
        wx.showModal({
            title: "提示",
            content: "订单删除后不再显示",
            success: function(a) {
                a.confirm && app.ajax({
                    url: "Corder|deleteOrder",
                    data: {
                        order_id: t.id
                    },
                    success: function(a) {
                        wx.showToast({
                            title: "删除成功"
                        }), wx.navigateBack({});
                    }
                });
            }
        });
    },
    toMap: function() {
        var a = this;
        wx.openLocation({
            name: a.data.olist.leader_community,
            latitude: parseFloat(a.data.olist.leader_latitude),
            longitude: parseFloat(a.data.olist.leader_longitude),
            scale: 18,
            address: a.data.olist.leader_address
        });
    },
    onCallLeader: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.olist.leader_tel + ""
        });
    }
});