var t = getApp();

Page({
    data: {
        detail: "",
        imgs: [],
        showkuang: !1,
        money_input: 0,
        showkuang1: !1,
        showtype: !1,
        type: [],
        xianxia: 0
    },
    onLoad: function(a) {
        var e = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "store.orderDetail",
                uid: wx.getStorageSync("uid"),
                order_id: a.orderid
            },
            success: function(t) {
                e.setData({
                    detail: t.data.data.detail,
                    imgs: t.data.data.imgs,
                    prevImgs: t.data.data.prevImgs,
                    type: t.data.data.type
                });
            }
        });
    },
    refound: function(t) {
        wx.navigateTo({
            url: "/pages/order/refound/index?orderid=" + t.currentTarget.dataset.orderid
        });
    },
    call: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.target.dataset.phone
        });
    },
    preview: function(t) {
        wx.previewImage({
            current: t.target.dataset.url,
            urls: this.data.prevImgs
        });
    },
    repairInfo: function(t) {
        wx.navigateTo({
            url: "/pages/store/pages/masterDetail/index?uid=" + t.target.dataset.uid
        });
    },
    pay_botton: function() {
        this.setData({
            showkuang: !this.data.showkuang,
            xianxia: 0
        });
    },
    xxpay_botton: function() {
        this.setData({
            showkuang: !this.data.showkuang,
            xianxia: 1
        });
    },
    money_input: function(t) {
        this.setData({
            money_input: t.detail.value
        });
    },
    navigation: function() {
        wx.openLocation({
            latitude: Number(this.data.detail.latitude),
            longitude: Number(this.data.detail.longitude),
            name: this.data.detail.address,
            address: this.data.detail.address_detail
        });
    },
    pay_sub: function() {
        var a = this;
        "" != a.data.money_input && "undefined" != a.data.money_input ? a.data.detail.cycle > 0 ? t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "store.order_pay",
                uid: wx.getStorageSync("uid"),
                amount: a.data.money_input,
                order_id: a.data.detail.id,
                xianxia: a.data.xianxia
            },
            success: function(e) {
                a.pay_botton(), t.util.message({
                    title: "提交成功",
                    type: "success"
                }), setTimeout(function() {
                    wx.navigateTo({
                        url: "/pages/store/pages/cycle/index"
                    });
                }, 2e3);
            }
        }) : t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "store.order_pay_one",
                uid: wx.getStorageSync("uid"),
                amount: a.data.money_input,
                order_id: a.data.detail.id,
                xianxia: a.data.xianxia
            },
            success: function(e) {
                a.pay_botton(), t.util.message({
                    title: "提交成功",
                    type: "success"
                }), setTimeout(function() {
                    wx.navigateTo({
                        url: "/pages/store/pages/order/index"
                    });
                }, 2e3);
            }
        }) : t.util.message({
            title: "请填写提现金额",
            type: "error"
        });
    },
    jiedan_botton_id: function(t) {
        this.setData({
            showkuang1: !this.data.showkuang1
        });
    },
    jiedan_botton: function() {
        this.setData({
            showkuang1: !this.data.showkuang1
        });
    },
    jiedan_sub: function() {
        var a = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "store.order_jiedan_one",
                uid: wx.getStorageSync("uid"),
                order_id: a.data.detail.id
            },
            success: function(e) {
                a.jiedan_botton(), t.util.message({
                    title: "提交成功",
                    type: "success"
                }), setTimeout(function() {
                    wx.navigateTo({
                        url: "/pages/store/pages/order/index"
                    });
                }, 2e3);
            }
        });
    },
    showtype: function() {
        this.setData({
            showtype: !this.data.showtype
        });
    },
    selecttype: function(a) {
        var e = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "store.order_type",
                uid: wx.getStorageSync("uid"),
                order_id: e.data.detail.id,
                type: a.currentTarget.dataset.id
            },
            success: function(i) {
                e.showtype(), t.util.message({
                    title: "修改成功",
                    type: "success"
                });
                var n = e.data.detail;
                n.type_name = a.currentTarget.dataset.title, e.setData({
                    detail: n
                });
            },
            fail: function() {
                e.showtype(), t.util.message({
                    title: "修改失败",
                    type: "error"
                });
            }
        });
    }
});