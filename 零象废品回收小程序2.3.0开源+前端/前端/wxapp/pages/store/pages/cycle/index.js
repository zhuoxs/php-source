var t = getApp();

Page({
    data: {
        isShow: !1,
        TabCur: 0,
        scrollLeft: 0,
        list: [],
        page: 1,
        status: 0,
        is_last: !1,
        money_input: 0,
        this_id: 0,
        showkuang: !1,
        xianxia: 0
    },
    onLoad: function(a) {
        var e = this;
        t.util.getUserInfo(function(a) {
            a.memberInfo ? (t.util.request({
                url: "entry/wxapp/Api",
                data: {
                    m: "ox_reclaim",
                    r: "order.manageCycle",
                    uid: a.memberInfo.uid,
                    page: e.data.page
                },
                success: function(t) {
                    e.setData({
                        list: t.data.data
                    });
                }
            }), wx.setStorageSync("uid", a.memberInfo.uid)) : e.hideDialog();
        });
    },
    hideDialog: function() {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    updateUserInfo: function(a) {
        var e = this;
        e.hideDialog(), a.detail.userInfo && t.util.getUserInfo(function(a) {
            t.util.request({
                url: "entry/wxapp/Api",
                data: {
                    m: "ox_reclaim",
                    r: "order.manageCycle",
                    uid: a.memberInfo.uid,
                    status: e.data.status,
                    page: e.data.page
                },
                success: function(t) {
                    e.setData({
                        list: t.data.data
                    });
                }
            }), wx.setStorageSync("uid", a.memberInfo.uid);
        }, a.detail);
    },
    onPullDownRefresh: function() {
        var a = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "order.manageCycle",
                uid: wx.getStorageSync("uid"),
                status: a.data.status,
                page: 1
            },
            success: function(t) {
                a.setData({
                    list: t.data.data,
                    page: 1,
                    is_last: !1
                }), wx.stopPullDownRefresh();
            }
        });
    },
    onReachBottom: function() {
        var a = this;
        a.data.is_last || t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "order.manageCycle",
                uid: wx.getStorageSync("uid"),
                page: a.data.page + 1,
                status: a.data.status
            },
            success: function(t) {
                t.data.data.length < 1 && (a.setData({
                    is_last: !0
                }), wx.showToast({
                    title: "没有更多数据了",
                    icon: "success",
                    duration: 2e3
                }));
                for (var e = a.data.list, i = 0; i < t.data.data.length; i++) e.push(t.data.data[i]);
                a.setData({
                    list: e,
                    page: a.data.page + 1
                });
            }
        });
    },
    viewOrder: function(t) {
        wx.navigateTo({
            url: "/pages/me/cyclelist/index?id=" + t.currentTarget.dataset.orderid
        });
    },
    call: function(t) {
        var a = t.target.dataset.rid;
        wx.navigateTo({
            url: "/pages/store/pages/masterDetail/index?uid=" + a
        });
    },
    showModal: function(t) {
        this.setData({
            modalName: t.currentTarget.dataset.target,
            orderid: t.currentTarget.dataset.orderid
        });
    },
    hideModal: function(t) {
        this.setData({
            modalName: null
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
                r: "store.order_pay",
                uid: wx.getStorageSync("uid"),
                amount: a.data.money_input,
                order_id: a.data.this_id,
                xianxia: a.data.xianxia
            },
            success: function(e) {
                a.pay_botton(), t.util.message({
                    title: "提交成功",
                    type: "success"
                });
            }
        }) : t.util.message({
            title: "请填写提现金额",
            type: "error"
        });
    }
});