var app = getApp();

Page({
    data: {
        navTile: "我发起的砍价",
        curIndex: 0,
        nav: [ "正在砍价中", "已完成" ],
        curBargain: [ {
            ordernum: "2018032015479354825174",
            status: "1",
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            title: "发财树绿萝栀子花海棠花卉盆栽",
            price: "2.50",
            oldprice: "3.00",
            num: "1"
        }, {
            ordernum: "2018032015479354825174",
            status: "1",
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            title: "发财树绿萝栀子花海棠花卉盆栽",
            price: "2.50",
            oldprice: "3.00",
            num: "1"
        }, {
            ordernum: "2018032015479354825174",
            status: "1",
            img: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            title: "发财树绿萝栀子花海棠花卉盆栽",
            price: "2.50",
            oldprice: "3.00",
            num: "1"
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
        isOpenPay: !1
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: this.data.navTile
        });
        var a = wx.getStorageSync("url");
        this.setData({
            url: a
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getUserBargain",
            cachetime: "0",
            data: {
                openid: t,
                index: a.data.curIndex
            },
            success: function(t) {
                a.setData({
                    bargain: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        if ("button" === t.from) {
            var a = t.target.dataset.gid;
            return {
                title: t.target.dataset.gname,
                path: "yzmdwsc_sun/pages/index/help/help?id=" + a + "&openid=" + wx.getStorageSync("openid"),
                success: function(t) {
                    console.log("转发成功");
                },
                fail: function(t) {
                    console.log("转发失败");
                }
            };
        }
    },
    bargainTap: function(t) {
        var a = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: a
        });
        var e = this, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getUserBargain",
            cachetime: "0",
            data: {
                openid: n,
                index: e.data.curIndex
            },
            success: function(t) {
                e.setData({
                    bargain: t.data
                });
            }
        });
    },
    toBuy: function(t) {
        var a = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../../index/bardet/bardet?gid=" + a
        });
    },
    toCancel: function(t) {
        var a = this, e = t.currentTarget.dataset.index, n = a.data.bargain, i = t.currentTarget.dataset.id, o = wx.getStorageSync("openid");
        wx.showModal({
            title: "提示",
            content: "订单删除后将不再显示",
            success: function(t) {
                t.confirm && (n.splice(e, 1), app.util.request({
                    url: "entry/wxapp/delUserBargain",
                    cachetime: "0",
                    data: {
                        id: i,
                        openid: o
                    },
                    success: function(t) {
                        a.setData({
                            bargain: n
                        });
                    }
                }));
            }
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
    ljzf: function(t) {
        var a = t.currentTarget.dataset.order_id;
        console.log(a);
        var e = t.currentTarget.dataset.order_amount;
        this.setData({
            isOpenPay: !this.data.isOpenPay,
            formId: t.detail.formId,
            order_id: a,
            order_amount: e
        });
    },
    formSubmit: function(t) {
        var a = this.data.order_id, e = wx.getStorageSync("openid"), n = t.detail.formId, i = this.data.payType;
        null != i ? 1 == i ? app.util.request({
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
                                    url: "/yzmdwsc_sun/pages/user/mybargain/mybargain"
                                });
                            }
                        });
                    },
                    fail: function(t) {}
                });
            }
        }) : 2 == i && app.util.request({
            url: "entry/wxapp/setAmountPay",
            cachetime: "0",
            data: {
                order_id: a,
                formId: n,
                uid: e,
                pay_type: i
            },
            success: function(t) {
                wx.showToast({
                    title: "支付成功",
                    icon: "success",
                    duration: 2e3,
                    success: function() {},
                    complete: function() {
                        wx.redirectTo({
                            url: "/yzmdwsc_sun/pages/user/mybargain/mybargain"
                        });
                    }
                });
            }
        }) : wx.showModal({
            title: "温馨提示",
            content: "请选择支付方式",
            showCancel: !1
        });
    }
});