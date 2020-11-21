var a = getApp();

Page({
    data: {
        id: "",
        info: [],
        user: [],
        address: []
    },
    onLoad: function(e) {
        var s = this;
        s.setData({
            id: e.id
        }), a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "shop.xiadan",
                id: s.data.id,
                uid: wx.getStorageSync("uid")
            },
            success: function(a) {
                s.setData({
                    info: a.data.data.info,
                    user: a.data.data.user,
                    address: a.data.data.address
                });
            },
            fail: function(a) {
                wx.showModal({
                    title: "系统提示",
                    content: a.data.message,
                    success: function(a) {
                        wx.navigateTo({
                            url: "/pages/shop/pages/home/index"
                        });
                    }
                });
            }
        });
    },
    subpay: function() {
        var e = this;
        e.data.user.integral < e.data.info.integral ? a.util.message({
            title: "积分不足，当前积分：" + e.data.user.integral,
            type: "error"
        }) : 100 * e.data.user.money < 100 * e.data.info.price ? a.util.message({
            title: "余额不足，当前余额：" + e.data.user.money,
            type: "error"
        }) : e.data.info.num <= 0 ? a.util.message({
            title: "库存不足",
            type: "error"
        }) : "" != e.data.address.address && void 0 != e.data.address.address ? a.util.request({
            url: "entry/wxapp/Api",
            method: "POST",
            data: {
                m: "ox_reclaim",
                r: "shop.duihuan",
                uid: wx.getStorageSync("uid"),
                id: e.data.id,
                address: e.data.address.address + " " + e.data.address.address_detail,
                address_name: e.data.address.name,
                address_phone: e.data.address.phone
            },
            success: function(a) {
                console.log(a), wx.showModal({
                    title: "兑换提示",
                    content: "兑换成功",
                    success: function(a) {
                        wx.navigateTo({
                            url: "/pages/shop/pages/order/index"
                        });
                    }
                });
            },
            fail: function(a) {
                wx.showModal({
                    title: "系统提示",
                    content: a.data.message ? a.data.message : "错误",
                    showCancel: !1,
                    success: function(a) {}
                });
            }
        }) : a.util.message({
            title: "请选择收货地址",
            type: "error"
        });
    },
    address: function() {
        wx.navigateTo({
            url: "/pages/me/address/index?id=1"
        });
    }
});