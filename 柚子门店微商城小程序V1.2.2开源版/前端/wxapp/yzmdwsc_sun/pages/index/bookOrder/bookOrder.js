var app = getApp(), tool = require("../../../../style/utils/tools.js");

Page({
    data: {
        navTile: "订单确认",
        goodsDet: [ {
            title: "发财树绿萝栀子花海棠花卉盆栽发财树绿萝栀子花海棠花卉盆栽",
            price: "399.00",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152541264562.png"
        } ],
        choose: [ {
            name: "微信",
            value: "微信支付",
            pay_type: 1,
            icon: "../../../../style/images/wx.png"
        }, {
            name: "余额",
            value: "余额支付",
            pay_type: 2,
            icon: "../../../../style/images/local.png"
        } ],
        multiArray: [],
        multiIndex: [ 0, 0 ],
        orderMoney: "0.01",
        isOpenPay: !1,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var e = t.gid;
        a.setData({
            gid: e
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GoodsDetails",
            cachetime: "0",
            data: {
                id: e
            },
            success: function(t) {
                console.log(t), a.setData({
                    goodinfo: t.data.data
                });
            }
        });
        var o = tool.formatTime(new Date());
        this.setData({
            multiArray: o
        });
    },
    uname: function(t) {
        var a = t.detail;
        console.log(a), this.setData({
            uname: a
        });
    },
    phone: function(t) {
        var a = t.detail;
        console.log(a), this.setData({
            phone: a
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bindMultiPickerColumnChange: function(t) {
        var a = {
            multiArray: this.data.multiArray,
            multiIndex: this.data.multiIndex
        };
        console.log(111111), console.log(t), a.multiIndex[t.detail.column] = t.detail.value, 
        this.setData(a), this.setData({
            showtime: !0
        });
    },
    formSubmit: function(t) {
        this.setData({
            isOpenPay: !this.data.isOpenPay,
            formId: t.detail.formId,
            uname: t.detail.value.uname,
            phone: t.detail.value.phone,
            time: t.detail.value.time,
            remark: t.detail.value.remark
        });
    },
    toSubmit: function(t) {
        this.setData({
            isOpenPay: !this.data.isOpenPay
        });
    },
    radioChange: function(t) {
        var a = t.detail.value;
        console.log(a), this.setData({
            payType: a
        });
    },
    toPay: function(t) {
        var e = this, o = e.data.uname, n = e.data.phone, i = e.data.time, a = e.data.showtime, s = e.data.remark, l = e.data.payType;
        if (null != l) {
            var u = "";
            if ("" == o) return u = "请输入您的姓名", void wx.showModal({
                title: "温馨提示",
                content: u,
                showCancel: !1
            });
            if (!/^1(3|4|5|7|8)\d{9}$/.test(n)) return u = "请正确输入手机号码", void wx.showModal({
                title: "温馨提示",
                content: u,
                showCancel: !1
            });
            if (null == a) return u = "请选择预约时间", void wx.showModal({
                title: "温馨提示",
                content: u,
                showCancel: !1
            });
            console.log("---订单提交中---"), wx.getStorage({
                key: "openid",
                success: function(t) {
                    console.log("---下订单---");
                    var a = t.data;
                    app.util.request({
                        url: "entry/wxapp/AddBookOrder",
                        cachetime: "0",
                        data: {
                            uid: a,
                            gid: e.data.gid,
                            yuyue_name: o,
                            yuyue_phone: n,
                            yuyue_time: i,
                            remark: s,
                            pay_type: l,
                            formId: e.data.formId
                        },
                        success: function(t) {
                            console.log("获取支付参数");
                            var a = t.data;
                            0 != a ? app.util.request({
                                url: "entry/wxapp/getPayParam",
                                cachetime: "0",
                                data: {
                                    order_id: a
                                },
                                success: function(t) {
                                    wx.requestPayment({
                                        timeStamp: t.data.timeStamp,
                                        nonceStr: t.data.nonceStr,
                                        package: t.data.package,
                                        signType: "MD5",
                                        paySign: t.data.paySign,
                                        success: function(t) {
                                            wx.showToast({
                                                title: "支付成功",
                                                icon: "success",
                                                duration: 2e3,
                                                success: function() {},
                                                complete: function() {
                                                    wx.redirectTo({
                                                        url: "/yzmdwsc_sun/pages/user/mybook/mybook"
                                                    });
                                                }
                                            });
                                        },
                                        fail: function(t) {}
                                    });
                                }
                            }) : wx.showToast({
                                title: "支付成功",
                                icon: "success",
                                duration: 2e3,
                                success: function() {},
                                complete: function() {
                                    wx.redirectTo({
                                        url: "/yzmdwsc_sun/pages/user/mybook/mybook"
                                    });
                                }
                            });
                        }
                    });
                }
            });
            0;
        } else wx.showModal({
            title: "温馨提示",
            content: "请选择支付方式",
            showCancel: !1
        });
    }
});