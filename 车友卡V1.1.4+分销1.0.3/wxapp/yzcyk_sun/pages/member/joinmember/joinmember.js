var app = getApp();

Page({
    data: {
        navTile: "开卡支付",
        bg: "../../../../style/images/bg.png",
        cardsBg: app.globalData.cardsBg,
        weblogo: "../../../../style/images/logo.png",
        cardsOpear: [ {
            title: "免费特权",
            src: "../../../../style/images/icon4.png"
        }, {
            title: "优惠折扣",
            src: "../../../../style/images/icon5.png"
        }, {
            title: "宝妈福利",
            src: "../../../../style/images/icon6.png"
        } ],
        price: 199,
        oldprice: 398,
        region: [ "", "", "" ],
        baby: {},
        isRequest: 0,
        imgroot: wx.getStorageSync("imgroot"),
        isIpx: app.globalData.isIpx
    },
    onLoad: function(e) {
        var t = this;
        wx.setNavigationBarTitle({
            title: t.data.navTile
        }), app.get_imgroot().then(function(e) {
            t.setData({
                imgroot: e
            });
        });
        var a = wx.getStorageSync("setting");
        a ? wx.setNavigationBarColor({
            frontColor: a.fontcolor,
            backgroundColor: a.color
        }) : app.get_setting(!0).then(function(e) {
            wx.setNavigationBarColor({
                frontColor: e.fontcolor,
                backgroundColor: e.color
            });
        }), app.get_setting().then(function(e) {
            console.log(e), t.setData({
                setting: e
            });
        }), app.get_qz_cards(!0).then(function(e) {
            console.log(e), e.background = e.background ? t.data.imgroot + e.background : e.background, 
            t.setData({
                qzCards: e,
                cardsBg: e.background || t.data.cardsBg
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this;
        app.get_user_info(!0).then(function(e) {
            t.setData({
                user: e
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bindRegionChange: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            region: e.detail.value
        });
    },
    formSubmit: function(e) {
        var t = this, a = e.detail.value.uname, o = e.detail.value.phone, n = e.detail.value.address, i = e.detail.value.addressdet, s = "", c = t.data.baby, r = !0;
        if (console.log(n), "" == a) s = "请输入您的姓名"; else if (/^1(3|4|5|7|8|9)\d{9}$/.test(o)) if ("" == n) s = "请选择地址"; else if ("" == i) s = "请输入详细地址"; else {
            if (r = "false", t.setData({
                isRequest: ++t.data.isRequest
            }), 1 != t.data.isRequest) return void wx.showToast({
                title: "正在请求中...",
                icon: "none"
            });
            app.get_openid().then(function(e) {
                app.util.request({
                    url: "entry/wxapp/setParentShip",
                    cachetime: "0",
                    data: {
                        openid: e,
                        names: a,
                        phone: o,
                        address: n,
                        address_detail: i,
                        baby_id: c.id
                    },
                    success: function(e) {
                        console.log(e.data), app.util.request({
                            url: "entry/wxapp/getPayParam",
                            cachetime: "0",
                            data: {
                                order_id: e.data
                            },
                            success: function(e) {
                                wx.requestPayment({
                                    timeStamp: e.data.timeStamp,
                                    nonceStr: e.data.nonceStr,
                                    package: e.data.package,
                                    signType: "MD5",
                                    paySign: e.data.paySign,
                                    success: function(e) {
                                        wx.showModal({
                                            title: "提示",
                                            content: "支付成功",
                                            showCancel: !1,
                                            confirmText: "去首页",
                                            confirmColor: "#ff5e5e",
                                            success: function(e) {
                                                wx.redirectTo({
                                                    url: "/yzcyk_sun/pages/index/index"
                                                });
                                            }
                                        });
                                    },
                                    fail: function(e) {
                                        wx.showModal({
                                            title: "提示",
                                            content: "支付失败",
                                            confirmText: "去首页",
                                            confirmColor: "#ff5e5e",
                                            success: function(e) {
                                                e.confirm && wx.redirectTo({
                                                    url: "/yzcyk_sun/pages/index/index"
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    },
                    fail: function() {
                        wx.showModal({
                            title: "提示",
                            content: "支付失败"
                        });
                    },
                    complete: function() {
                        t.setData({
                            isRequest: 0
                        });
                    }
                });
            });
        } else s = "请正确输入手机号码";
        1 == r && wx.showModal({
            title: "提示",
            content: s,
            showCancel: !1
        });
    },
    toBaby: function(e) {
        wx.navigateTo({
            url: "../../user/baby/baby?isback=1"
        });
    }
});