var app = getApp();

Page({
    data: {
        pade: [],
        logo: ""
    },
    onLoad: function(a) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(a) {
                wx.setStorageSync("url", a.data), t.setData({
                    url: a.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetMbmessage",
            cachetime: 0,
            success: function(a) {
                t.setData({
                    is_open: a.data.is_open,
                    mb3: a.data.mb3
                });
            }
        }), app.util.request({
            url: "entry/wxapp/VipLogo",
            cachetime: "30",
            success: function(a) {
                t.setData({
                    pade: a.data.res,
                    logo: a.data.banner
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    thisIndexStatus: function(a) {
        var t = a.currentTarget.dataset.index, e = JSON.parse(JSON.stringify(this.data.pade));
        !1 === e[t].status ? (e = this.forDataSet(e))[t].status = !0 : (e = this.forDataSet(e))[t].status = !1, 
        this.setData({
            pade: e
        });
    },
    forDataSet: function(a) {
        for (var t in a) a[t].status = !1;
        return a;
    },
    write: function(a) {
        this.setData({
            name: a.detail.value
        });
    },
    write1: function(a) {
        this.setData({
            tel: a.detail.value
        });
    },
    write2: function(a) {
        this.setData({
            g: a.detail.value
        });
    },
    radiochange: function(a) {
        console.log(a);
        var t = this;
        app.util.request({
            url: "entry/wxapp/GetCardPrice",
            data: {
                id: a.detail.value
            },
            success: function(a) {
                console.log(a), t.setData({
                    card_type_id: a.data.id,
                    price: a.data.card_price,
                    img: a.data.card_logo
                });
            }
        });
    },
    formSubmit: function(a) {
        var o = a.detail.formId, i = this;
        null == i.data.name ? wx.showModal({
            title: "",
            content: "请填写用户名"
        }) : wx.getStorage({
            key: "openid",
            success: function(a) {
                var t = a.data, e = i.data.price;
                app.util.request({
                    url: "entry/wxapp/Orderarr",
                    cachetime: "30",
                    data: {
                        price: e,
                        openid: t
                    },
                    success: function(a) {
                        wx.getStorageSync("new");
                        var s = wx.getStorageSync("users").id;
                        wx.requestPayment({
                            timeStamp: a.data.timeStamp,
                            nonceStr: a.data.nonceStr,
                            package: a.data.package,
                            signType: "MD5",
                            paySign: a.data.paySign,
                            success: function(a) {
                                if (wx.showToast({
                                    title: "支付成功",
                                    icon: "success",
                                    duration: 2e3
                                }), app.util.request({
                                    url: "entry/wxapp/addVip",
                                    cachetime: "0",
                                    data: {
                                        id: i.data.card_type_id,
                                        uid: s,
                                        tel: i.data.tel,
                                        g: i.data.g,
                                        name: i.data.name
                                    },
                                    success: function(a) {}
                                }), 2 == i.data.is_open) {
                                    var t = wx.getStorageSync("access_token"), e = Date.parse(new Date());
                                    e /= 1e3;
                                    var n = {
                                        access_token: t,
                                        touser: wx.getStorageSync("users").openid,
                                        template_id: i.data.mb3,
                                        page: "byjs_sun/pages/myUser/myOrder/myOrder",
                                        form_id: o,
                                        value1: "会员卡",
                                        color1: "#4a4a4a",
                                        value2: e,
                                        color2: "#9b9b9b",
                                        value3: i.data.price,
                                        color3: "#9b9b9b"
                                    };
                                    app.util.request({
                                        url: "entry/wxapp/Send",
                                        data: n,
                                        method: "POST",
                                        success: function(a) {
                                            console.log("push msg"), console.log(a);
                                        },
                                        fail: function(a) {
                                            console.log("push err"), console.log(a);
                                        }
                                    });
                                }
                                wx.reLaunch({
                                    url: "../index/index"
                                });
                            },
                            fail: function(a) {
                                wx.reLaunch({
                                    url: "../index/index"
                                });
                            }
                        }), console.log("-----直接购买=------");
                    }
                });
            }
        });
    }
});