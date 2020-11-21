var app = getApp();

Page({
    data: {
        state: 1,
        orderFormDisable: !0,
        isChange: "",
        formchangeBtn: 2,
        kuaidi: [ "选择快递", "圆通", "中通", "申通", "顺丰", "韵达", "天天", "EMS", "本人到店", "其他" ],
        index: 0
    },
    onPullDownRefresh: function() {
        this.getOrder(), wx.stopPullDownRefresh();
    },
    changeOrderFormDisable: function() {
        this.setData({
            orderFormDisable: !1,
            isChange: "isChange",
            formchangeBtn: 3
        });
    },
    changeOrderFormConfirm: function() {
        var a = this;
        wx.showModal({
            title: "确定提交吗",
            content: "只有一次修改的机会哦",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/applyModifyAppointInfo",
                    data: {
                        pro_name: a.data.pro_name,
                        pro_tel: a.data.pro_tel,
                        pro_address: a.data.pro_address,
                        chuydate: a.data.chuydate,
                        chuytime: a.data.chuytime,
                        order_id: a.data.order
                    },
                    success: function(t) {
                        a.setData({
                            orderFormDisable: !0,
                            isChange: "",
                            formchangeBtn: 4
                        }), wx.showModal({
                            title: "提示",
                            content: "信息修改成功，请等待后台管理员审核！",
                            showCancel: !1
                        });
                    }
                });
            }
        });
    },
    changeOrderFormCancel: function() {
        this.setData({
            orderFormDisable: !0,
            isChange: "",
            formchangeBtn: 2
        });
    },
    ContactMerchant: function() {
        var e = this;
        wx.showModal({
            title: "提示",
            content: "请联系商家咨询具体信息！",
            confirmText: "联系商家",
            success: function(t) {
                if (t.confirm) {
                    var a = e.data.baseinfo.tel;
                    wx.makePhoneCall({
                        phoneNumber: a
                    });
                }
            }
        });
    },
    makePhoneCall: function(t) {
        var a = t.currentTarget.dataset.tel;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    bindDateChange2: function(t) {
        this.setData({
            chuydate: t.detail.value
        });
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: "订单详情"
        }), t.orderid && a.setData({
            orderid: t.orderid
        });
        var e = 0;
        t.fxsid && (e = t.fxsid, a.setData({
            fxsid: t.fxsid
        })), a.getBase(), app.util.getUserInfo(a.getinfos, e);
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
    getinfos: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                }), a.getOrder();
            }
        });
    },
    getOrder: function() {
        var a = this, t = a.data.orderid;
        app.util.request({
            url: "entry/wxapp/getOrderMoreDetail",
            data: {
                order_id: t
            },
            success: function(t) {
                a.setData({
                    datas: t.data.data
                });
            }
        });
    },
    copy: function(t) {
        wx.setClipboardData({
            data: t.currentTarget.dataset.ddh,
            success: function(t) {
                wx.showToast({
                    title: "复制成功"
                });
            }
        });
    },
    makephonecall: function() {
        this.data.datas.seller_tel && wx.makePhoneCall({
            phoneNumber: this.data.datas.seller_tel
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    tuikuan: function(t) {
        var a = t.detail.formId, e = t.currentTarget.dataset.order;
        wx.showModal({
            title: "提醒",
            content: "确定要退款吗？",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/duotk",
                    data: {
                        formId: a,
                        order_id: e
                    },
                    success: function(a) {
                        0 == a.data.data.flag ? wx.showModal({
                            title: "提示",
                            content: a.data.data.message,
                            showCancel: !1,
                            success: function(t) {
                                wx.redirectTo({
                                    url: "/sudu8_page/orderDetail/orderDetail?orderid=" + e
                                });
                            }
                        }) : wx.showModal({
                            title: "很抱歉",
                            content: a.data.data.message,
                            confirmText: "联系客服",
                            success: function(t) {
                                t.confirm && wx.makePhoneCall({
                                    phoneNumber: a.data.data.mobile
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    qrshouh: function(t) {
        var a = t.target.dataset.order, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/querenxc",
            data: {
                openid: e,
                orderid: a
            },
            success: function(t) {
                wx.redirectTo({
                    url: "/sudu8_page/orderDetail/orderDetail?orderid=" + a
                });
            }
        });
    },
    tuihuo: function(t) {
        this.setData({
            showmask: !0,
            order_tuihuo: t.currentTarget.dataset.order
        });
    },
    bindPickerChange: function(t) {
        this.setData({
            index: t.detail.value
        });
    },
    changekdh: function(t) {
        this.setData({
            kdh: t.detail.value
        });
    },
    cancelkdinfo: function() {
        this.setData({
            showmask: !1
        });
    },
    changekdinfo: function() {
        var a = this;
        0 == a.data.index ? wx.showModal({
            title: "提交失败",
            content: "必须选择快递",
            showCancel: !1
        }) : a.data.kdh ? app.util.request({
            url: "entry/wxapp/tuihuo",
            data: {
                order_id: a.data.order_tuihuo,
                kuaidi: a.data.kuaidi[a.data.index],
                kuaidihao: a.data.kdh
            },
            success: function(t) {
                wx.showToast({
                    title: "已申请退货",
                    icon: "success",
                    success: function() {
                        setTimeout(function() {
                            wx.redirectTo({
                                url: "/sudu8_page/orderDetail/orderDetail?orderid=" + a.data.orderid
                            });
                        }, 1500);
                    }
                });
            }
        }) : wx.showModal({
            title: "提交失败",
            content: "快递号/信息必填",
            showCancel: !1
        });
    }
});