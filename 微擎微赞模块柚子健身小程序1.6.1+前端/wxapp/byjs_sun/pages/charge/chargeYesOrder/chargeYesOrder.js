var app = getApp();

Page({
    data: {
        product: [],
        userName: "",
        totalPrice: "",
        is_open: ""
    },
    onLoad: function(e) {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(e) {
                wx.setStorageSync("url", e.data), o.setData({
                    url: e.data
                });
            }
        });
        var t = wx.getStorageSync("shopnow"), a = (t = Array(t))[0].picer * t[0].productNumber, n = wx.getStorageSync("total") || 0;
        console.log(t), console.log(t), console.log(a), console.log(n), "" == t && (t = wx.getStorageSync("newcar"), 
        a = wx.getStorageSync("newtotal"), console.log(a));
        for (var r = 0, s = 0; s < t.length; s++) 0 < t[s].freight && (r = Number(t[s].freight)) < t[s].freight && (r = Number(t[s].freight));
        var c = a + r;
        c = a <= n ? r : a - n + r, r = r.toFixed(2), a = Number(a).toFixed(2), c = c.toFixed(2), 
        o.setData({
            product: t,
            total: n,
            totalPrice: a,
            freight: r,
            lasttotalPrice: c
        }), console.log(this.data.product), app.util.request({
            url: "entry/wxapp/GetMbmessage",
            cachetime: 0,
            success: function(e) {
                o.setData({
                    is_open: e.data.is_open,
                    mb3: e.data.mb3
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
    formSubmit: function(e) {
        console.log(e.detail.formId);
        var s = e.detail.formId;
        console.log("111111这是断点");
        var c = this;
        if ("" != c.data.userName) {
            for (var o = c.data.product, l = (wx.getStorageSync("users").id, []), i = "", d = "", u = [], g = [], t = 0; t < o.length; t++) l.push(o[t].goods_id), 
            i += o[t].goods_name + ",", d = o[t].img, u.push(o[t].picer), g.push(o[t].productNumber);
            wx.getStorage({
                key: "openid",
                success: function(e) {
                    console.log("111111这是断点1");
                    var o = e.data, r = c.data.lasttotalPrice;
                    app.util.request({
                        url: "entry/wxapp/Orderarr",
                        cachetime: "30",
                        data: {
                            price: r,
                            openid: o
                        },
                        success: function(o) {
                            console.log(o);
                            var e = wx.getStorageSync("users").id;
                            if (console.log("-----直接购买=------"), console.log("" == wx.getStorageSync("shopnow"), "就是购物车过来的"), 
                            "" == wx.getStorageSync("shopnow")) {
                                console.log(l);
                                var t = wx.getStorageSync("shop");
                                console.log(t);
                                for (var a = 0; a < t.length; a++) for (var n = 0; n < l.length; n++) l[n] == t[a].goods_id && t.splice(a, 1);
                                wx.setStorageSync("shop", t);
                            }
                            app.util.request({
                                url: "entry/wxapp/Order",
                                cachetime: "0",
                                data: {
                                    user_id: e,
                                    money: r,
                                    user_name: c.data.userName,
                                    tel: c.data.telNumber,
                                    good_id: l,
                                    good_name: i,
                                    good_img: d,
                                    good_money: u,
                                    good_num: g,
                                    address: c.data.provinceName + c.data.cityName + c.data.countyName + c.data.detailInfo
                                },
                                success: function(e) {
                                    console.log(e.data);
                                    var n = e.data;
                                    console.log(o), wx.requestPayment({
                                        timeStamp: o.data.timeStamp,
                                        nonceStr: o.data.nonceStr,
                                        package: o.data.package,
                                        signType: "MD5",
                                        paySign: o.data.paySign,
                                        success: function(e) {
                                            if (wx.showToast({
                                                title: "支付成功",
                                                icon: "success",
                                                duration: 2e3
                                            }), app.util.request({
                                                url: "entry/wxapp/PayOrder",
                                                cachetime: "0",
                                                data: {
                                                    order_id: n
                                                },
                                                success: function(e) {
                                                    var o = this;
                                                    console.log("ssss");
                                                    var t = wx.getStorageSync("total");
                                                    t > o.data.totalPrice ? t -= o.data.totalPrice : t = (t = o.data.totalPrice - t).toFixed(2), 
                                                    wx.removeStorageSync("total"), wx.setStorageSync("total", Number(t)), wx.removeStorageSync("new");
                                                }
                                            }), 2 == c.data.is_open) {
                                                var o = wx.getStorageSync("access_token"), t = Date.parse(new Date());
                                                t /= 1e3;
                                                var a = {
                                                    access_token: o,
                                                    touser: wx.getStorageSync("users").openid,
                                                    template_id: c.data.mb3,
                                                    page: "byjs_sun/pages/myUser/myOrder/myOrder",
                                                    form_id: s,
                                                    value1: i,
                                                    color1: "#4a4a4a",
                                                    value2: t,
                                                    color2: "#9b9b9b",
                                                    value3: u,
                                                    color3: "#9b9b9b"
                                                };
                                                app.util.request({
                                                    url: "entry/wxapp/Send",
                                                    data: a,
                                                    method: "POST",
                                                    success: function(e) {
                                                        console.log("push msg"), console.log(e);
                                                    },
                                                    fail: function(e) {
                                                        console.log("push err"), console.log(e);
                                                    }
                                                });
                                            }
                                            wx.redirectTo({
                                                url: "../chargeIndex/chargeIndex"
                                            });
                                        },
                                        fail: function(e) {}
                                    });
                                }
                            });
                        }
                    });
                }
            });
        } else console.log(2), wx.showModal({
            title: "提示",
            content: "请填写地址",
            success: function(e) {
                e.confirm ? console.log("用户点击确定") : e.cancel && console.log("用户点击取消");
            }
        });
    },
    myAddress: function() {
        var o = this;
        wx.chooseAddress({
            success: function(e) {
                o.setData({
                    userName: e.userName,
                    postalCode: e.postalCode,
                    provinceName: e.provinceName,
                    cityName: e.cityName,
                    countyName: e.countyName,
                    detailInfo: e.detailInfo,
                    nationalCode: e.nationalCode,
                    telNumber: e.telNumber
                });
            }
        });
    },
    goAddress: function() {
        wx.navigateTo({
            url: "/byjs_sun/pages/charge/chargeAddressReceipt/chargeAddressReceipt"
        });
    }
});