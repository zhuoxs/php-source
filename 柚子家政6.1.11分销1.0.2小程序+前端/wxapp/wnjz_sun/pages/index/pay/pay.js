var app = getApp();

Page({
    data: {
        totalprice: "0",
        cardprice: "",
        curprice: "0",
        choose: [ {
            name: "weixin",
            value: "微信支付",
            icon: "../../../../style/images/wx.png"
        }, {
            name: "local",
            value: "余额支付",
            icon: "../../../../style/images/local.png"
        } ],
        showModalStatus: !1,
        cards: [],
        pays: "",
        shop: [ "柚子美发 湖里店", "柚子美发 思明店", "柚子美发 集美店", "柚子美发 海沧店" ]
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = wx.getStorageSync("openid"), a = this;
        app.util.request({
            url: "entry/wxapp/CounpPay",
            method: "GET",
            data: {
                userid: t
            },
            success: function(t) {
                a.setData({
                    cards: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    totalprice: function(t) {
        var a = t.detail.value, e = this, n = e.data.cardprice;
        if (a > e.data.valb || a == e.data.valb) var i = a - n; else i = a;
        i < 0 && (i = 0), e.setData({
            totalprice: a,
            curprice: i
        });
    },
    counpData: function() {
        var i = this, t = wx.getStorageSync("build_id"), a = wx.getStorageSync("openid"), o = i.data.totalprice;
        app.util.request({
            url: "entry/wxapp/CounpPay",
            method: "GET",
            data: {
                userid: a,
                build_id: t
            },
            success: function(t) {
                console.log(t);
                for (var a = t.data, e = [], n = 0; n < a.length; n++) console.log(parseInt(a[n].vab) < parseInt(o)), 
                (parseInt(a[n].vab) < parseInt(o) || parseInt(a[n].vab) == parseInt(o)) && (console.log(a[n] + "ssss"), 
                e.push(a[n]));
                i.setData({
                    cards: e
                });
            }
        });
    },
    radionChange: function(t) {
        var a = t.detail.value;
        this.setData({
            pays: a
        });
    },
    coupon: function(t) {
        var a = t.currentTarget.dataset.price, e = t.currentTarget.dataset.allprice, n = t.currentTarget.dataset.cid, i = this.data.totalprice;
        if (e < i || i == e) var o = i - a; else o = i;
        o < 0 && (o = 0), this.setData({
            valb: e,
            cardprice: a,
            curprice: o,
            cid: n
        }), this.util("close");
    },
    powerDrawer: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a), this.counpData();
    },
    util: function(t) {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).opacity(0).height(0).step(), this.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.opacity(1).height(300).step(), this.setData({
                animationData: a
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    },
    formSubmit: function(t) {
        var a = "", e = wx.getStorageSync("openid"), n = wx.getStorageSync("build_id"), i = t.detail.value.price, o = !0, s = this.data.pays, c = this.data.cid;
        i <= 0 ? a = "金额不得小于0" : "" == s ? a = "请选择支付方式" : (o = "false", "weixin" == s ? (app.util.request({
            url: "entry/wxapp/Addorde",
            data: {
                price: i,
                openid: e,
                cid: c,
                pays: s,
                build_id: n
            },
            success: function(t) {}
        }), app.util.request({
            url: "entry/wxapp/Orderarr",
            data: {
                price: i,
                openid: e
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
                            duration: 2e3
                        }), app.util.request({
                            url: "entry/wxapp/PayOrder",
                            cachetime: "0",
                            data: {
                                order_id: order_id
                            },
                            success: function(t) {
                                wx.showModal({
                                    title: "提示",
                                    content: "支付成功",
                                    showCancel: !1,
                                    success: function(t) {
                                        t.confirm && wx.navigateBack({});
                                    }
                                });
                            }
                        });
                    },
                    fail: function(t) {}
                });
            }
        })) : (app.util.request({
            url: "entry/wxapp/Addorde",
            data: {
                price: i,
                openid: e,
                cid: c,
                pays: s,
                build_id: n
            },
            success: function(t) {}
        }), app.util.request({
            url: "entry/wxapp/local",
            data: {
                price: i,
                openid: e,
                build_id: n
            },
            success: function(t) {
                console.log(t), 2 == t.data.status ? wx.showToast({
                    title: "余额不足！",
                    icon: "none",
                    duration: 2e3
                }) : wx.showModal({
                    title: "提示",
                    content: "支付成功",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.navigateBack({});
                    }
                });
            }
        }))), 1 == o && wx.showModal({
            title: "提示",
            content: a,
            showCancel: !1
        });
    },
    bindPickerChange: function(t) {
        this.setData({
            index: t.detail.value
        });
    }
});