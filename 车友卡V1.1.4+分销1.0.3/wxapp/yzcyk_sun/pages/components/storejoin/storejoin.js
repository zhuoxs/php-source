var app = getApp();

Component({
    properties: {
        showJoin: {
            type: String,
            value: !0
        }
    },
    data: {
        showModalStatus: !0,
        isRequest: 0
    },
    attached: function() {
        console.log("2222222222222");
        var e = this;
        app.util.request({
            url: "entry/wxapp/getStorelimit",
            cachetime: "0",
            success: function(t) {
                console.log(t.data), e.setData({
                    storeEnter: t.data
                });
            }
        });
    },
    methods: {
        showModel: function() {
            this.setData({
                showJoin: !0
            });
        },
        bindPickerChange: function(t) {
            this.setData({
                index: t.detail.value
            });
        },
        formSubmit: function(t) {
            var e = this, a = t.detail.value.shopname, s = t.detail.value.phone, n = t.detail.value.address, o = "", i = !0;
            "" == a ? o = "请输入您的姓名" : /^1(3|4|5|7|8)\d{9}$/.test(s) ? "" == n ? o = "请输入地址" : null == e.data.index ? o = "请选择入驻时间" : (i = !1, 
            app.get_openid().then(function(t) {
                e.setData({
                    isRequest: ++e.data.isRequest
                }), 1 == e.data.isRequest ? app.util.request({
                    url: "entry/wxapp/setStore",
                    cachetime: "0",
                    data: {
                        openid: t,
                        store_name: a,
                        tel: s,
                        address: n,
                        storelimit_id: e.data.storeEnter[e.data.index].id
                    },
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/getPayParam",
                            cachetime: "0",
                            data: {
                                order_id: t.data
                            },
                            success: function(t) {
                                wx.requestPayment({
                                    timeStamp: t.data.timeStamp,
                                    nonceStr: t.data.nonceStr,
                                    package: t.data.package,
                                    signType: "MD5",
                                    paySign: t.data.paySign,
                                    success: function(t) {
                                        wx.showModal({
                                            title: "提示",
                                            content: "支付成功",
                                            showCancel: !1,
                                            confirmColor: "#ff5e5e",
                                            success: function(t) {
                                                e.setData({
                                                    showJoin: !e.data.showJoin
                                                });
                                            }
                                        });
                                    },
                                    fail: function(t) {
                                        wx.showModal({
                                            title: "提示",
                                            content: "支付失败",
                                            confirmColor: "#ff5e5e",
                                            success: function(t) {}
                                        });
                                    }
                                });
                            }
                        });
                    },
                    fail: function(t) {
                        wx.showModal({
                            title: "提示",
                            content: t.data.message,
                            showCancel: !1,
                            success: function(t) {
                                e.setData({
                                    showJoin: !e.data.showJoin
                                });
                            }
                        });
                    },
                    complete: function() {
                        e.setData({
                            isRequest: 0
                        });
                    }
                }) : wx.showToast({
                    title: "正在请求中...",
                    icon: "none"
                });
            })) : o = "请正确输入手机号码", 1 == i && wx.showToast({
                title: o,
                icon: "none"
            });
        }
    }
});