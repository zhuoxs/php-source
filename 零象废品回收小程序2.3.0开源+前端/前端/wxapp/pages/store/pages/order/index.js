var t = getApp();

Page({
    data: {
        FiterCur: 0,
        Page: 1,
        is_last: !1,
        list: [],
        money_input: 0,
        this_id: 0,
        showkuang: !1,
        showkuang1: !1,
        xianxia: 0
    },
    onLoad: function(t) {
        var a = this;
        a.setData({
            uid: wx.getStorageSync("uid")
        }), a.list();
    },
    onPullDownRefresh: function() {
        var t = this;
        t.clean(), t.list(), wx.stopPullDownRefresh();
    },
    onReachBottom: function() {
        var t = this;
        t.data.is_last || t.list();
    },
    navorder: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/pages/store/pages/orderDetail/index?orderid=" + a
        });
    },
    filterSelect: function(t) {
        var a = this;
        a.setData({
            FiterCur: t.currentTarget.dataset.id
        }), a.clean(), a.list();
    },
    clean: function() {
        this.setData({
            list: [],
            Page: 1,
            is_last: !1
        });
    },
    list: function(a) {
        var i = this, e = i.data.Page;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "store.orderList",
                page: e,
                status: i.data.FiterCur,
                uid: i.data.uid
            },
            success: function(t) {
                t.data.data.list.length < 1 && i.setData({
                    is_last: !0
                });
                for (var a = i.data.list, e = 0; e < t.data.data.list.length; e++) a.push(t.data.data.list[e]);
                i.setData({
                    list: a,
                    Page: i.data.Page + 1
                });
            }
        });
    },
    pay_botton_id: function(t) {
        this.setData({
            showkuang: !this.data.showkuang,
            money_input: "",
            this_id: t.currentTarget.dataset.id,
            xianxia: 0
        });
    },
    xxpay_botton_id: function(t) {
        this.setData({
            showkuang: !this.data.showkuang,
            money_input: "",
            this_id: t.currentTarget.dataset.id,
            xianxia: 1
        });
    },
    pay_botton: function() {
        this.setData({
            showkuang: !this.data.showkuang
        });
    },
    money_input: function(t) {
        this.setData({
            money_input: t.detail.value
        });
    },
    pay_sub: function() {
        var a = this;
        "" != a.data.money_input && "undefined" != a.data.money_input ? t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "store.order_pay_one",
                uid: wx.getStorageSync("uid"),
                amount: a.data.money_input,
                order_id: a.data.this_id,
                xianxia: a.data.xianxia
            },
            success: function(i) {
                t.util.message({
                    title: "提交成功",
                    type: "success"
                }), setTimeout(function() {
                    a.pay_botton(), a.clean(), a.list();
                }, 2e3);
            }
        }) : t.util.message({
            title: "请填写提现金额",
            type: "error"
        });
    },
    jiedan_botton_id: function(t) {
        this.setData({
            showkuang1: !this.data.showkuang1,
            this_id: t.currentTarget.dataset.id
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
                order_id: a.data.this_id
            },
            success: function(i) {
                t.util.message({
                    title: "提交成功",
                    type: "success"
                }), setTimeout(function() {
                    a.jiedan_botton(), a.clean(), a.list();
                }, 2e3);
            }
        });
    }
});