var _data;

function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var tool = require("../../../../style/utils/tools.js"), app = getApp();

Page({
    data: (_data = {
        order: [],
        url: [],
        hasAddress: !1,
        address: [],
        curprice: "0",
        cardprice: "0",
        totalPrice: "",
        showStatus: !1,
        choose: [ {
            name: "weixin",
            value: "微信支付",
            icon: "../../../../style/images/wx.png"
        }, {
            name: "local",
            value: "余额支付",
            icon: "../../../../style/images/local.png"
        } ],
        rstatus: "",
        multiArray: [],
        multiIndex: [ 0, 0 ],
        orderid: "",
        phoneNumber: "",
        uname: ""
    }, _defineProperty(_data, "address", [ "暂无分店" ]), _defineProperty(_data, "index", 0), 
    _defineProperty(_data, "ispay", !1), _defineProperty(_data, "isclick", !1), _data),
    onLoad: function(e) {
        var t = this;
        wx.setNavigationBarTitle({
            title: t.data.navTile
        });
        var a = wx.getStorageSync("openid");
        wx.setStorageSync("kjgid", e.id), app.util.request({
            url: "entry/wxapp/kjirder",
            data: {
                id: e.id,
                price: e.price,
                openid: a
            },
            success: function(e) {
                console.log(e), t.setData({
                    bargain_details: e.data
                }), t.getUrl();
            }
        });
        var i = tool.formatTime(new Date());
        t.setData({
            multiArray: i
        });
        t = this;
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
        wx.getStorageSync("openid");
        var i = wx.getStorageSync("kjgid"), n = this;
        wx.getLocation({
            type: "wgs84",
            success: function(e) {
                var t = e.latitude, a = e.longitude;
                app.util.request({
                    url: "entry/wxapp/getStoreAddress",
                    cachetime: "0",
                    data: {
                        lat: t,
                        lon: a,
                        kjgid: i
                    },
                    success: function(e) {
                        console.log(e.data), n.setData({
                            address: e.data,
                            build_id: e.data[0].id
                        });
                    }
                });
            }
        });
    },
    message: function(e) {
        this.setData({
            message: e.detail.value
        });
    },
    phone: function(e) {
        this.setData({
            phoneNumber: e.detail.value
        });
    },
    uname: function(e) {
        this.setData({
            uname: e.detail.value
        });
    },
    getUrl: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bindMultiPickerColumnChange: function(e) {
        var t = {
            multiArray: this.data.multiArray,
            multiIndex: this.data.multiIndex
        };
        t.multiIndex[e.detail.column] = e.detail.value, this.setData(t);
    },
    showDrawer: function(e) {
        var t = e.currentTarget.dataset.statu;
        this.utils(t);
    },
    utils: function(e) {
        var t = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = t).opacity(0).height(0).step(), this.setData({
            animationshowData: t.export()
        }), setTimeout(function() {
            t.opacity(1).height("500rpx").step(), this.setData({
                animationshowData: t
            }), "close" == e && this.setData({
                showStatus: !1
            });
        }.bind(this), 200), "open" == e && this.setData({
            showStatus: !0
        });
    },
    radioChange: function(e) {
        var t = e.detail.value;
        this.setData({
            rstatus: t
        });
    },
    formSubmit: function(e) {
        var a = this, t = a.data.build_id, i = (a.data.rstatus, !0), n = "", s = a.data.rstatus, o = wx.getStorageSync("openid"), r = e.detail.value.price, d = e.detail.value.message, c = e.detail.value.id, u = e.detail.value.time, l = a.data.uname, p = a.data.phoneNumber, g = a.data.index, f = a.data.address[g].name + a.data.address[g].address, m = a.data.address[g].hair_id;
        if (console.log(m), a.data.isclick) return console.log("多次点击"), !1;
        a.setData({
            isclick: !0
        });
        if (/^1(3|4|5|7|8)\d{9}$/.test(p)) if ("" == l && l.length <= 10) n = "请输入您的名字"; else if (i = "false", 
        "weixin" == s) {
            var h = a.data.orderid;
            if (0 < h) return app.util.request({
                url: "entry/wxapp/Orderarr",
                data: {
                    openid: o,
                    price: r,
                    ordertype: 2,
                    order_id: h
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
                                title: "",
                                content: "支付成功",
                                cancelText: "去首页",
                                confirmText: "查看订单",
                                success: function(e) {
                                    e.confirm ? wx.redirectTo({
                                        url: "/ymmf_sun/pages/user/bgorder/bgorder"
                                    }) : e.cancel && wx.reLaunch({
                                        url: "../../index/index"
                                    });
                                }
                            });
                        },
                        fail: function(e) {
                            a.setData({
                                isclick: !1
                            });
                        }
                    });
                }
            }), !1;
            app.util.request({
                url: "entry/wxapp/Addkanjiaorder",
                data: {
                    price: r,
                    id: c,
                    text: d,
                    telNumber: p,
                    name: l,
                    pays: s,
                    openid: o,
                    status: 2,
                    address: f,
                    goods_type: 2,
                    build_id: t,
                    hair_id: m
                },
                success: function(e) {
                    var t = e.data;
                    a.setData({
                        orderid: t
                    }), app.util.request({
                        url: "entry/wxapp/Orderarr",
                        data: {
                            openid: o,
                            price: r,
                            ordertype: 2,
                            order_id: t
                        },
                        success: function(e) {
                            wx.requestPayment({
                                timeStamp: e.data.timeStamp,
                                nonceStr: e.data.nonceStr,
                                package: e.data.package,
                                signType: "MD5",
                                paySign: e.data.paySign,
                                success: function(e) {
                                    wx.showToast({
                                        title: "支付成功",
                                        icon: "success",
                                        duration: 2e3
                                    }), wx.reLaunch({
                                        url: "../../index/index"
                                    });
                                },
                                fail: function(e) {
                                    a.setData({
                                        isclick: !1
                                    });
                                }
                            });
                        }
                    });
                }
            });
        } else "local" == s ? (console.log("-------------余额支付------------------"), app.util.request({
            url: "entry/wxapp/kjlocal",
            data: {
                price: r,
                openid: o
            },
            success: function(e) {
                console.log(e), 2 == e.data.status ? (a.setData({
                    isclick: !1
                }), wx.showToast({
                    title: "余额不足，请充值！",
                    icon: "none"
                })) : (app.util.request({
                    url: "entry/wxapp/Addkanjiaorder",
                    data: {
                        price: r,
                        id: c,
                        text: d,
                        time: u,
                        telNumber: p,
                        name: l,
                        pays: s,
                        openid: o,
                        status: 3,
                        address: f,
                        goods_type: 2,
                        build_id: t,
                        hair_id: m
                    },
                    success: function(e) {
                        console.log(e.data), app.util.request({
                            url: "entry/wxapp/yuezhifu",
                            cachetime: "0",
                            data: {
                                id: c,
                                openid: o
                            },
                            success: function(e) {
                                wx.showModal({
                                    title: "",
                                    content: "支付成功",
                                    cancelText: "去首页",
                                    confirmText: "查看订单",
                                    success: function(e) {
                                        e.confirm ? wx.redirectTo({
                                            url: "/ymmf_sun/pages/user/bgorder/bgorder"
                                        }) : e.cancel && wx.reLaunch({
                                            url: "../../index/index"
                                        });
                                    }
                                });
                            }
                        });
                    }
                }), a.setData({
                    isclick: !1
                }));
            }
        })) : wx.showToast({
            title: "请选择付款方式",
            icon: "none"
        }); else n = "请正确输入联系方式";
        1 == i && wx.showModal({
            title: "提示",
            content: n,
            showCancel: !1
        });
    },
    toAddress: function() {
        var t = this;
        wx.chooseAddress({
            success: function(e) {
                console.log("获取地址成功"), t.setData({
                    address: e,
                    hasAddress: !0
                });
            },
            fail: function(e) {
                console.log("获取地址失败");
            }
        });
    },
    bindPickerChange: function(e) {
        var t = this.data.address;
        console.log("picker发送选择改变，携带值为", e.detail.value);
        var a = t[e.detail.value].id;
        this.setData({
            index: e.detail.value,
            build_id: a
        });
    }
});