var app = getApp();

Page({
    data: {
        CarIdIndex: [],
        CarListValue: [],
        sex: [ "先生", "女士" ],
        money: 0,
        currentSelect: 0,
        free: 1
    },
    onLoad: function(e) {
        var t = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.util.request({
            url: "entry/wxapp/anliType",
            cachetime: "0",
            success: function(e) {
                t.setData({
                    array: e.data
                });
            }
        });
        var o = e.id;
        app.util.request({
            url: "entry/wxapp/lawType",
            cachetime: "0",
            success: function(e) {
                if (o) for (var a = 0; a < e.data.length; a++) if (o == e.data[a].id) {
                    var n = a;
                    t.data.money = e.data[a].appmoney;
                }
                t.setData({
                    arrays: e.data,
                    indexs: n,
                    money: t.data.money,
                    lid: o
                });
            }
        });
    },
    bindPickerChange: function(e) {
        this.setData({
            index: e.detail.value
        });
    },
    bindPickerChange1: function(e) {
        var a = this, n = e.detail.value, t = a.data.arrays[n].id;
        a.setData({
            indexs: e.detail.value
        }), app.util.request({
            url: "entry/wxapp/lawData",
            cachetime: "0",
            data: {
                id: t
            },
            success: function(e) {
                a.data.money = e.data.appmoney, a.setData({
                    money: a.data.money,
                    lid: t
                });
            }
        });
    },
    selectSex: function(e) {
        this.setData({
            currentSelect: e.currentTarget.dataset.index
        });
    },
    bindSave: function(e) {
        var a = this, o = e.detail.value, t = e.detail.formId;
        if ("" != o.leixing) if ("" != o.lawyer) if ("" != o.phone) if ("" != o.linkMan) if ("" != o.contents) {
            var n = a.data.currentSelect;
            o.linkMan = 0 == n ? o.linkMan + "先生" : o.linkMan + "女士", 0 < a.data.money ? wx.showModal({
                title: "提示",
                content: "是否提交咨询！",
                success: function(e) {
                    e.confirm ? (console.log("用户点击确定"), wx.getStorage({
                        key: "openid",
                        success: function(e) {
                            var t = e.data;
                            console.log(t), app.util.request({
                                url: "entry/wxapp/Orderarr",
                                cachetime: "30",
                                data: {
                                    openid: t,
                                    price: a.data.money
                                },
                                success: function(e) {
                                    var n = e.data.package;
                                    console.log(n), wx.requestPayment({
                                        timeStamp: e.data.timeStamp,
                                        nonceStr: e.data.nonceStr,
                                        package: e.data.package,
                                        signType: "MD5",
                                        paySign: e.data.paySign,
                                        success: function(e) {
                                            wx.getStorage({
                                                key: "openid",
                                                success: function(e) {
                                                    app.util.request({
                                                        url: "entry/wxapp/Payconsultation",
                                                        cachetime: "0",
                                                        data: {
                                                            openid: t,
                                                            contents: o.contents,
                                                            leixing: o.leixing,
                                                            linkMan: o.linkMan,
                                                            phone: o.phone,
                                                            id: a.data.lid,
                                                            money: a.data.money
                                                        },
                                                        success: function(e) {
                                                            console.log(e.data);
                                                            var a = e.data;
                                                            console.log(a), app.util.request({
                                                                url: "entry/wxapp/Paysuccess",
                                                                cachetime: "0",
                                                                data: {
                                                                    openid: t,
                                                                    fid: a,
                                                                    prepay_id: n
                                                                },
                                                                success: function(e) {
                                                                    console.log(e.data), wx.navigateBack({});
                                                                }
                                                            });
                                                        }
                                                    });
                                                }
                                            });
                                        },
                                        fail: function(e) {}
                                    });
                                }
                            });
                        }
                    })) : e.cancel && console.log("用户点击取消");
                }
            }) : wx.showModal({
                title: "提示",
                content: "是否提交咨询！",
                success: function(e) {
                    e.confirm ? (console.log("用户点击确定"), wx.getStorage({
                        key: "openid",
                        success: function(e) {
                            var n = e.data;
                            app.util.request({
                                url: "entry/wxapp/Payconsultation",
                                cachetime: "0",
                                data: {
                                    openid: e.data,
                                    contents: o.contents,
                                    leixing: o.leixing,
                                    linkMan: o.linkMan,
                                    phone: o.phone,
                                    id: a.data.lid,
                                    money: a.data.money
                                },
                                success: function(e) {
                                    console.log(e);
                                    var a = e.data;
                                    app.util.request({
                                        url: "entry/wxapp/Paysuccess",
                                        cachetime: "0",
                                        data: {
                                            openid: n,
                                            fid: a,
                                            prepay_id: t
                                        },
                                        success: function(e) {
                                            console.log(e.data), wx.navigateBack({});
                                        }
                                    });
                                }
                            });
                        }
                    })) : e.cancel && console.log("用户点击取消");
                }
            });
        } else wx.showModal({
            title: "提示",
            content: "请输入想要咨询的内容",
            showCancel: !1
        }); else wx.showModal({
            title: "提示",
            content: "请输入称呼",
            showCancel: !1
        }); else wx.showModal({
            title: "提示",
            content: "请输入手机号",
            showCancel: !1
        }); else wx.showModal({
            title: "提示",
            content: "请选择咨询律师",
            showCancel: !1
        }); else wx.showModal({
            title: "提示",
            content: "请选择案件类型",
            showCancel: !1
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});