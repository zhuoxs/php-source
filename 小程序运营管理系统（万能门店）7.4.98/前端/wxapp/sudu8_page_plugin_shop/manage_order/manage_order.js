var app = getApp();

Page({
    data: {
        tabs: [ "全部", "待付款", "待核销", "待发货", "已发货", "已完成" ],
        activeIndex: 0,
        sliderOffset: 0,
        sliderLeft: 0,
        isshow: "hide",
        flag: 10,
        type1: 10
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this, e = t.id;
        a.setData({
            id: e
        });
        var s = 0;
        t.fxsid && (s = t.fxsid, a.setData({
            fxsid: t.fxsid
        }));
        var o = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: o,
            data: {
                vs1: 1
            },
            cachetime: "30",
            success: function(t) {
                t.data.data;
                a.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: a.data.baseinfo.base_tcolor,
                    backgroundColor: a.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(a.getinfos, s), a.orderList(10, 10);
    },
    orderList: function(t, a) {
        var e = this, s = app.util.url("entry/wxapp/orderList", {
            m: "sudu8_page_plugin_shop"
        });
        wx.request({
            url: s,
            data: {
                nav: t,
                flag: a,
                id: wx.getStorageSync("mlogin")
            },
            cachetime: "30",
            success: function(t) {
                e.setData({
                    orderlist: t.data.data
                });
            }
        });
    },
    changflag: function(t) {
        var a = this, e = t.currentTarget.dataset.flag, s = t.currentTarget.dataset.nav;
        null != s && null != e ? a.setData({
            type1: s,
            flag: e
        }) : null == s && a.setData({
            flag: e
        }), a.orderList(s, e);
    },
    gosend: function(t) {
        var a = t.currentTarget.dataset.id;
        this.setData({
            isshow: "show",
            proid: a
        });
    },
    close: function() {
        this.setData({
            isshow: "hide"
        });
    },
    doSend: function(t) {
        var a = t.detail.value;
        "" == a.kdname || "" == a.kdnum ? wx.showToast({
            title: "请填写完整发货信息",
            icon: "none"
        }) : app.util.request({
            url: "entry/wxapp/doSend",
            data: {
                id: this.data.proid,
                sid: wx.getStorageSync("mlogin"),
                kdname: a.kdname,
                kdnum: a.kdnum
            },
            success: function(t) {
                1 == t.data.data ? wx.showToast({
                    title: "发货成功",
                    icon: "success"
                }) : wx.showToast({
                    title: "发货失败",
                    icon: "none"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/sudu8_page_plugin_shop/manage_order/manage_order"
                    });
                }, 1e3);
            }
        });
    },
    hexiao: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "确定核销该订单？",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/duoshophx",
                    data: {
                        sid: wx.getStorageSync("mlogin"),
                        order_id: a
                    },
                    success: function(t) {
                        1 == t.data.data ? wx.showToast({
                            title: "核销完成",
                            icon: "success",
                            duration: 2e3,
                            success: function(t) {
                                wx.redirectTo({
                                    url: "/sudu8_page/order_more_list/order_more_list"
                                });
                            }
                        }) : wx.showModal({
                            title: "提示",
                            content: "发生未知错误, 核销失败!",
                            showCancel: !1
                        });
                    }
                }) : t.cancel;
            }
        });
    }
});