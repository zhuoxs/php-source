var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        items: [ {
            name: "微信支付",
            value: "微信支付",
            checked: "true"
        }, {
            name: "余额支付",
            value: "余额支付"
        } ],
        radios: "微信支付"
    },
    radioChange: function(e) {
        console.log("radio发生change事件，携带value值为：", e.detail.value), this.setData({
            radios: e.detail.value
        });
    },
    bindSave: function(e) {
        var a = this, t = e.detail.formId, n = a.data.radios, i = e.detail.value, r = a.data.integral, c = a.data.goods.s_sid, s = wx.getStorageSync("bid"), d = a.data.price, u = wx.getStorageSync("gid"), l = wx.getStorageSync("dateArrays_time"), g = wx.getStorageSync("newuseAtime"), p = wx.getStorageSync("newuseNtime"), m = wx.getStorageSync("date_dr"), w = wx.getStorageSync("date_cr"), y = "预约包厢(" + a.data.goods.goods_name + ")";
        console.log(a.data), "" != i.mobile ? wx.getStorage({
            key: "openid",
            success: function(e) {
                var o = e.data;
                "微信支付" == n ? app.util.request({
                    url: "entry/wxapp/Orderarr",
                    cachetime: "30",
                    data: {
                        openid: o,
                        price: d
                    },
                    success: function(e) {
                        console.log(e.data);
                        var t = e.data.package;
                        wx.requestPayment({
                            timeStamp: e.data.timeStamp,
                            nonceStr: e.data.nonceStr,
                            package: e.data.package,
                            signType: "MD5",
                            paySign: e.data.paySign,
                            success: function(e) {
                                app.util.request({
                                    url: "entry/wxapp/Roomorder",
                                    cachetime: "0",
                                    data: {
                                        openid: o,
                                        gid: u,
                                        price: d,
                                        dateArrays_time: l,
                                        newuseAtime: g,
                                        newuseNtime: p,
                                        date_dr: m,
                                        date_cr: w,
                                        mobile: i.mobile,
                                        remark: i.remark,
                                        integral: r,
                                        sid: c,
                                        bid: s
                                    },
                                    success: function(e) {
                                        console.log(e.data);
                                        var a = e.data.id;
                                        console.log(a), app.util.request({
                                            url: "entry/wxapp/Paysuccess",
                                            cachetime: "0",
                                            data: {
                                                openid: o,
                                                oid: a,
                                                prepay_id: t,
                                                local: 1,
                                                cate: 1
                                            },
                                            success: function(e) {
                                                console.log(e.data);
                                            }
                                        }), wx.redirectTo({
                                            url: "../../my/mybooking/mybooking"
                                        });
                                    }
                                });
                            },
                            fail: function(e) {}
                        });
                    }
                }) : app.util.request({
                    url: "entry/wxapp/BalancePay",
                    cacheime: "0",
                    data: {
                        openid: o,
                        total: d,
                        name: y
                    },
                    success: function(e) {
                        1 == e.data ? app.util.request({
                            url: "entry/wxapp/Roomorder",
                            cachetime: "0",
                            data: {
                                openid: o,
                                gid: u,
                                price: d,
                                dateArrays_time: l,
                                newuseAtime: g,
                                newuseNtime: p,
                                date_dr: m,
                                date_cr: w,
                                mobile: i.mobile,
                                remark: i.remark,
                                integral: r,
                                sid: c,
                                bid: s
                            },
                            success: function(e) {
                                var a = e.data.id;
                                console.log(a), app.util.request({
                                    url: "entry/wxapp/Paysuccess",
                                    cachetime: "0",
                                    data: {
                                        openid: o,
                                        oid: a,
                                        formId: t,
                                        local: 1,
                                        cate: 2
                                    },
                                    success: function(e) {
                                        console.log(e.data);
                                    }
                                }), wx.redirectTo({
                                    url: "../../my/mybooking/mybooking"
                                });
                            }
                        }) : wx.showToast({
                            title: "余额不足！",
                            icon: "none",
                            duration: 2e3
                        });
                    }
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "请输入联系方式！",
            showCancel: !1
        });
    },
    onLoad: function(e) {
        var a = this;
        wx.setStorageSync("bid", e.bid), wx.setStorageSync("gid", e.gid), wx.setStorageSync("price", e.price), 
        wx.setStorageSync("spec", e.spec), wx.setStorageSync("dateArrays_time", e.dateArrays_time), 
        wx.setStorageSync("newuseAtime", e.newuseAtime), wx.setStorageSync("newuseNtime", e.newuseNtime), 
        wx.setStorageSync("date_dr", e.date_dr), wx.setStorageSync("date_cr", e.date_cr), 
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), console.log(e), a.url(), 0 != e.bid && app.util.request({
            url: "entry/wxapp/buildDetail",
            cahcetime: "0",
            data: {
                id: e.bid
            },
            success: function(e) {
                a.setData({
                    build_name: e.data.b_name,
                    tel: e.data.tel
                });
            }
        }), a.setData({
            bid: e.bid
        });
    },
    url: function(e) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url2", e.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), a.setData({
                    url: e.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this, e = wx.getStorageSync("openid"), a = wx.getStorageSync("gid"), o = wx.getStorageSync("price");
        app.util.request({
            url: "entry/wxapp/Goodbao",
            cachetime: "0",
            data: {
                gid: a,
                price: o,
                openid: e
            },
            success: function(e) {
                console.log(e.data), t.setData({
                    goods: e.data.roomData,
                    price: e.data.price
                });
            }
        }), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "0",
            success: function(e) {
                var a = (o * e.data.integral).toFixed(2);
                t.setData({
                    phone: e.data.tel,
                    integral: a
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    callphone: function(e) {
        var a = e.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: a
        });
    }
});