var app = getApp();

Page({
    data: {
        date: "2016-09-01",
        time: "12:01",
        openid: ""
    },
    onLoad: function(t) {
        var e = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: e
        });
        var a = t.tt_id, n = t.ty_id, o = wx.getStorageSync("openid");
        this.setData({
            openid: o
        }), this.getTijian_yuyue(a, n);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), setTimeout(function() {
            wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
        }, 1e3);
        var t = data.tt_id, e = data.ty_id;
        this.getTijian_yuyue(t, e);
    },
    getTijian_yuyue: function(t, e) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Tijian_yuyue",
            data: {
                tt_id: t,
                ty_id: e
            },
            success: function(t) {
                console.log(t), a.setData({
                    tijian_yuyue: t.data.data,
                    tt_money: t.data.data.tt_money
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    formSubmit: function(a) {
        var t = this.data.tijian_yuyue.ty_name, n = this.data.tt_money;
        console.log(n);
        var o = wx.getStorageSync("openid");
        console.log(t), 0 == a.detail.value.tjyy_name.length || 0 == a.detail.value.tjyy_shenfenzheng.length || 0 == a.detail.value.tjyy_telphone.length ? wx.showModal({
            content: "姓名、手机号、身份证号不能为空"
        }) : wx.showModal({
            title: "提示",
            content: " 确认提交么？ ",
            success: function(t) {
                if (t.confirm) {
                    console.log("用户点击确定");
                    var e = a.detail.value;
                    app.util.request({
                        url: "entry/wxapp/Pay",
                        method: "GET",
                        data: {
                            openid: o,
                            z_tw_money: n
                        },
                        success: function(t) {
                            wx.requestPayment({
                                timeStamp: t.data.timeStamp,
                                nonceStr: t.data.nonceStr,
                                package: t.data.package,
                                signType: t.data.signType,
                                paySign: t.data.paySign,
                                success: function(t) {
                                    console.log(t), app.util.request({
                                        url: "entry/wxapp/Tijian_yuyues",
                                        data: e,
                                        header: {
                                            "Content-Type": "application/json"
                                        },
                                        success: function(t) {
                                            console.log(t.data), 1 == t.data.code ? wx.showToast({
                                                title: "提交失败"
                                            }) : wx.showModal({
                                                title: "提交成功",
                                                content: "",
                                                success: function(t) {
                                                    t.confirm ? (console.log("用户点击确定"), wx.navigateTo({
                                                        url: "/hyb_yl/index/index"
                                                    })) : t.cancel && console.log("用户点击取消");
                                                }
                                            });
                                        },
                                        fail: function(t) {
                                            console.log(t);
                                        }
                                    });
                                },
                                fail: function(t) {
                                    console.log(t);
                                }
                            });
                        }
                    });
                } else t.cancel && console.log("用户点击取消");
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bindDateChange: function(t) {
        console.log("picker发送选择改变，携带值为", t.detail.value), this.setData({
            date: t.detail.value
        });
    },
    bindTimeChange: function(t) {
        console.log("picker发送选择改变，携带值为", t.detail.value), this.setData({
            time: t.detail.value
        });
    }
});