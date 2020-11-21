var app = getApp();

Page({
    data: {
        page_sign: "order",
        page: 1,
        morePro: !1,
        baseinfo: [],
        orderinfo: [],
        type: 9,
        footer: {
            i_tel: app.globalData.i_tel,
            i_add: app.globalData.i_add,
            i_time: app.globalData.i_time,
            i_view: app.globalData.i_view,
            close: app.globalData.close,
            v_ico: app.globalData.v_ico
        }
    },
    onPullDownRefresh: function() {
        this.getinfos(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this;
        a.setData({
            isIphoneX: app.globalData.isIphoneX
        }), wx.setNavigationBarTitle({
            title: "我的拼团订单"
        });
        var e = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: e,
            data: {
                vs1: 1
            },
            success: function(t) {
                a.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: a.data.baseinfo.base_tcolor,
                    backgroundColor: a.data.baseinfo.base_color
                });
            }
        }), t.type && a.setData({
            type: t.type
        });
        var o = 0;
        t.fxsid && (o = t.fxsid, a.setData({
            fxsid: t.fxsid
        })), app.util.getUserInfo(a.getinfos, o);
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    getinfos: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                }), a.getList();
            }
        });
    },
    getList: function(t) {
        var a = this;
        wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ptorderlist",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                a.setData({
                    orderinfo: t.data.data
                });
            }
        });
    },
    makePhoneCallB: function(t) {
        var a = this.data.baseinfo.tel_b;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    qrshouh: function(t) {
        var a = this, e = t.target.dataset.order, o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/querenxc",
            data: {
                openid: o,
                orderid: e
            },
            success: function(t) {
                a.getList();
            }
        });
    },
    wlinfo: function(t) {
        var a = t.currentTarget.dataset.kuaidi, e = t.currentTarget.dataset.kuaidihao;
        wx.navigateTo({
            url: "/sudu8_page/logistics_state/logistics_state?kuaidi=" + a + "&kuaidihao=" + e
        });
    },
    hxshow: function(t) {
        this.setData({
            showhx: 1,
            order: t.currentTarget.dataset.order
        });
    },
    hxhide: function() {
        this.setData({
            showhx: 0,
            hxmm: ""
        });
    },
    hxmmInput: function(t) {
        this.setData({
            hxmm: t.detail.value
        });
    },
    hxmmpass: function() {
        var a = this, t = a.data.hxmm, e = a.data.order;
        if (t) {
            var o = app.util.url("entry/wxapp/hxmm", {
                m: "sudu8_page"
            });
            wx.request({
                url: o,
                data: {
                    hxmm: t,
                    order_id: e,
                    types: "pt",
                    openid: wx.getStorageSync("openid")
                },
                header: {
                    "content-type": "application/json"
                },
                success: function(t) {
                    0 == t.data.data ? wx.showModal({
                        title: "提示",
                        content: "核销密码不正确！",
                        showCancel: !1
                    }) : wx.showToast({
                        title: "消费成功",
                        icon: "success",
                        duration: 2e3,
                        success: function(t) {
                            a.setData({
                                showhx: 0,
                                hxmm: ""
                            }), wx.startPullDownRefresh(), a.data.page = 1, a.getList(), wx.stopPullDownRefresh();
                        }
                    });
                }
            });
        } else wx.showModal({
            title: "提示",
            content: "请输入核销密码！",
            showCancel: !1
        });
    }
});