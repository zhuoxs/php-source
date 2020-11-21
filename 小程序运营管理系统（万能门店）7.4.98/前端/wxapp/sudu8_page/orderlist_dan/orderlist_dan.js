var app = getApp();

Page({
    data: {
        page_sign: "order",
        page: 1,
        morePro: !1,
        baseinfo: [],
        orderinfo: [],
        type: 10,
        footer: {
            i_tel: app.globalData.i_tel,
            i_add: app.globalData.i_add,
            i_time: app.globalData.i_time,
            i_view: app.globalData.i_view,
            close: app.globalData.close,
            v_ico: app.globalData.v_ico
        },
        nav: [ {
            id: 10,
            text: "全部"
        }, {
            id: -1,
            text: "已关闭"
        }, {
            id: 0,
            text: "待付款"
        }, {
            id: 1,
            text: "待消费",
            nav: 2
        }, {
            id: 2,
            text: "已完成"
        }, {
            id: 3,
            text: "已过期"
        }, {
            id: 4,
            text: "已发货"
        }, {
            id: 5,
            text: "商家已取消"
        }, {
            id: 6,
            text: "售后"
        }, {
            id: 11,
            text: "待发货",
            nav: 1
        } ]
    },
    onLoad: function(t) {
        var a = this;
        a.setData({
            isIphoneX: app.globalData.isIphoneX
        }), wx.setNavigationBarTitle({
            title: "秒杀订单"
        }), t.type && a.setData({
            type: t.type
        });
        var e = 0;
        t.fxsid && (e = t.fxsid, a.setData({
            fxsid: t.fxsid
        })), a.getBase(), app.util.getUserInfo(a.getinfos, e);
    },
    onShow: function() {
        this.setData({
            page: 1
        }), this.getList();
    },
    wlinfo: function(t) {
        var a = t.currentTarget.dataset.kuaidi, e = t.currentTarget.dataset.kuaidihao;
        wx.navigateTo({
            url: "/sudu8_page/logistics_state/logistics_state?kuaidi=" + a + "&kuaidihao=" + e
        });
    },
    getinfos: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                });
            }
        });
    },
    getBase: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "30",
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
            },
            fail: function(t) {}
        });
    },
    getList: function(t) {
        var a = this;
        wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Myorder",
            data: {
                openid: wx.getStorageSync("openid"),
                type: a.data.type,
                is_more: 0,
                nav: a.data.navs
            },
            success: function(t) {
                a.setData({
                    allnum: t.data.data.allnum,
                    orderinfo: t.data.data.list
                });
            },
            fail: function(t) {}
        });
    },
    chonxhq: function(t) {
        var a = this, e = t.currentTarget.dataset.id, o = t.currentTarget.dataset.nav || "";
        a.setData({
            type: e,
            morePro: !1,
            page: 1,
            navs: o
        }), app.util.request({
            url: "entry/wxapp/Myorder",
            data: {
                openid: wx.getStorageSync("openid"),
                type: e,
                nav: o,
                is_more: 0
            },
            success: function(t) {
                a.setData({
                    orderinfo: t.data.data.list
                });
            },
            fail: function(t) {}
        });
    },
    onReady: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var t = this;
        t.data.page = 1, t.getBase(), t.getList(), wx.stopPullDownRefresh();
    },
    onReachBottom: function() {
        var a = this, t = a.data.type, e = a.data.page + 1;
        app.util.request({
            url: "entry/wxapp/Myorder",
            data: {
                openid: wx.getStorageSync("openid"),
                page: e,
                type: t,
                is_more: 0
            },
            success: function(t) {
                "" != t.data.data.list && a.setData({
                    orderinfo: a.data.orderinfo.concat(t.data.data.list),
                    page: e
                });
            }
        });
    },
    onShareAppMessage: function() {},
    choose_nav: function(t) {
        var a = t.currentTarget.dataset.id;
        this.setData({
            a: a
        });
    },
    makePhoneCallB: function(t) {
        var a = this.data.baseinfo.tel_b;
        wx.makePhoneCall({
            phoneNumber: a
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
        t ? app.util.request({
            url: "entry/wxapp/hxmm",
            data: {
                hxmm: t,
                order_id: e,
                types: "miaosha",
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
        }) : wx.showModal({
            title: "提示",
            content: "请输入核销密码！",
            showCancel: !1
        });
    },
    lijipay: function(t) {
        var a = t.currentTarget.dataset.order, e = t.currentTarget.dataset.pid, o = t.currentTarget.dataset.address;
        wx.navigateTo({
            url: "/sudu8_page/order_dan/order_dan?orderid=" + a + "&id=" + e + "&addressid=" + o + "&again=1"
        });
    },
    orderagain: function(t) {
        var a = t.currentTarget.dataset.pid;
        wx.navigateTo({
            url: "/sudu8_page/showPro/showPro?id=" + a
        });
    },
    qrshouh: function(t) {
        var a = this, e = t.currentTarget.dataset.order, o = wx.getStorageSync("openid");
        wx.showModal({
            title: "提示",
            content: "确认收货吗？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/danshouhuo",
                    data: {
                        openid: o,
                        orderid: e
                    },
                    success: function(t) {
                        wx.showToast({
                            title: "收货成功！",
                            success: function(t) {
                                setTimeout(function() {
                                    a.data.page = 1, a.getList();
                                }, 1500);
                            }
                        });
                    }
                });
            }
        });
    },
    goevaluate: function(t) {
        var a = t.currentTarget.dataset.order, e = t.currentTarget.dataset.type;
        wx.navigateTo({
            url: "/sudu8_page/evaluate/evaluate?order_id=" + a + "&type=" + e
        });
    }
});