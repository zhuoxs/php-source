var app = getApp(), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {},
    onLoad: function(a) {
        var n = this, e = a.id, t = a.typeid;
        n.setData({
            typeid: t
        }), app.util.request({
            url: "entry/wxapp/GetMealDetail",
            data: {
                id: e
            },
            success: function(a) {
                console.log(a), n.setData({
                    itemarr: a.data
                });
                var e = a.data.text.text;
                WxParse.wxParse("content", "html", e, n, 15);
                var t = a.data.details;
                WxParse.wxParse("details", "html", t, n, 15);
            }
        });
        var o = wx.getStorageSync("url");
        n.setData({
            url: o
        }), app.util.request({
            url: "entry/wxapp/GetMbmessage",
            cachetime: 0,
            success: function(a) {
                n.setData({
                    is_open: a.data.is_open,
                    mb3: a.data.mb3
                });
            }
        });
    },
    buy: function(a) {
        var r = this;
        console.log(a);
        var s = a.detail.formId, t = r.data.itemarr.id;
        wx.showModal({
            content: "是否确认立即购买此餐劵？",
            cancelColor: "#000",
            confirmColor: "#3daddd",
            success: function(a) {
                a.confirm ? wx.getStorage({
                    key: "openid",
                    success: function(a) {
                        var e = a.data, o = r.data.itemarr.price;
                        app.util.request({
                            url: "entry/wxapp/Orderarr",
                            cachetime: "30",
                            data: {
                                price: o,
                                openid: e
                            },
                            success: function(a) {
                                var e = wx.getStorageSync("users").id;
                                wx.requestPayment({
                                    timeStamp: a.data.timeStamp,
                                    nonceStr: a.data.nonceStr,
                                    package: a.data.package,
                                    signType: "MD5",
                                    paySign: a.data.paySign,
                                    success: function(a) {
                                        wx.showToast({
                                            title: "支付成功",
                                            icon: "success",
                                            duration: 2e3
                                        }), app.util.request({
                                            url: "entry/wxapp/addMeal",
                                            cachetime: "0",
                                            data: {
                                                uid: e,
                                                mid: t
                                            },
                                            success: function(a) {
                                                if (1 == a.data) {
                                                    if (2 == r.data.is_open) {
                                                        var e = wx.getStorageSync("access_token"), t = Date.parse(new Date());
                                                        t /= 1e3, t = util.formatTimeTwo(t, "Y/M/D h:m:s");
                                                        var n = {
                                                            access_token: e,
                                                            touser: wx.getStorageSync("users").openid,
                                                            template_id: r.data.mb3,
                                                            page: "byjs_sun/pages/product/index/index",
                                                            form_id: s,
                                                            value1: "餐劵",
                                                            color1: "#4a4a4a",
                                                            value2: t,
                                                            color2: "#9b9b9b",
                                                            value3: o,
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
                                                        url: "../mealList/mealList?typeid=" + r.data.typeid
                                                    });
                                                } else wx.showToast({
                                                    title: "购买失败，请联系管理员！",
                                                    icon: "none",
                                                    duration: 2e3
                                                });
                                            }
                                        });
                                    },
                                    fail: function(a) {
                                        wx.reLaunch({
                                            url: "../mealList/mealList?typeid=" + r.data.typeid
                                        });
                                    }
                                }), console.log("-----直接购买=------");
                            }
                        });
                    }
                }) : a.cancel && console.log("用户点击取消");
            }
        });
    },
    addCar: function(a) {
        var e = this, t = wx.getStorageSync("mealCar"), n = [], o = {
            Id: t.length + 1,
            price: e.data.itemarr.price,
            name: e.data.itemarr.typename + "-" + e.data.itemarr.name,
            content: e.data.itemarr.content,
            mid: e.data.itemarr.id,
            img: e.data.itemarr.imgs
        };
        wx.showModal({
            content: "是否将此餐劵加入到购物车中？",
            cancelColor: "#000",
            confirmColor: "#3daddd",
            success: function(a) {
                a.confirm ? (0 == t.length ? n.push(o) : (n = t).push(o), wx.setStorageSync("mealCar", n), 
                wx.showToast({
                    title: "添加成功",
                    icon: "success",
                    duration: 2e3
                })) : a.cancel && console.log("用户点击取消");
            }
        });
    },
    Car: function() {
        wx.navigateTo({
            url: "../mealCart/mealCart"
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});