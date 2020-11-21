var app = getApp();

Page({
    data: {
        shopprice: "",
        template_order: "",
        postData: [ "快递", "到店取货" ],
        addressData: [],
        guige: 0,
        buyNumbe: 0,
        consignee: "",
        ContactNum: "",
        money: "",
        youhui: "",
        addNew: [],
        buy_message: ""
    },
    onLoad: function(a) {
        var o = this;
        console.log("订单页面数据加载"), console.log(a);
        var t = a.buyNumber, n = a.freight, s = a.iid;
        o.diyWinColor(), app.util.request({
            url: "entry/wxapp/Url",
            success: function(e) {
                console.log("页面加载请求"), console.log(e), wx.getStorageSync("url", e.data), o.setData({
                    gid: s,
                    url: e.data,
                    buyNumber: t,
                    freight: n
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Doods_details",
            data: {
                iid: a.iid,
                openid: a.openid
            },
            success: function(e) {
                console.log("订单数据请求"), console.log(e), o.setData({
                    list: e.data,
                    guige: a.guige,
                    shopprice: a.shopprice
                }), app.util.request({
                    url: "entry/wxapp/Card_hy",
                    data: {
                        openid: a.openid
                    },
                    success: function(e) {
                        console.log("会员查询"), console.log(e), 0 == e.data ? o.setData({
                            youhui: "办会员卡可以有优惠",
                            money: o.data.shopprice * t
                        }) : app.util.request({
                            url: "entry/wxapp/Menber_yh",
                            success: function(e) {
                                console.log("查询优惠价格"), console.log(e.data);
                                parseInt(e.data.discount);
                                if (console.log(o.data.shopprice), console.log(t), console.log(e.data.discount), 
                                o.data.shopprice * t <= .01) o.setData({
                                    youhui: "金额小于等于0.01不享受优惠",
                                    money: (o.data.shopprice * t).toFixed(2)
                                }); else {
                                    var a = (o.data.shopprice * t * e.data.discount).toFixed(2);
                                    console.log("moneys" + o.data.shopprice * t), console.log("moneys" + o.data.shopprice * t * e.data.discount), 
                                    console.log("moneys" + e.data.discount), console.log("moneys" + a), o.setData({
                                        youhui: 10 * e.data.discount + "折",
                                        money: a
                                    });
                                }
                            }
                        });
                    }
                });
            }
        });
        var e = wx.getStorageSync("openid");
        o.diyWinColor(), app.util.request({
            url: "entry/wxapp/User_id",
            data: {
                openid: e
            },
            success: function(e) {
                console.log("查看用户id"), console.log(e), wx.setStorageSync("user_id", e.data.id);
            }
        }), app.util.request({
            url: "entry/wxapp/Mob_message",
            success: function(e) {
                console.log("模板消息数据"), console.log(e), o.setData({
                    template_order: e.data.template_order
                });
            }
        });
    },
    consignee: function(e) {
        console.log("收货人"), console.log(e), this.setData({
            consignee: e.detail.value
        });
    },
    ContactNum: function(e) {
        console.log("联系电话"), console.log(e), this.setData({
            ContactNum: e.detail.value
        });
    },
    buy_message: function(e) {
        console.log("买家留言"), console.log(e), this.setData({
            buy_message: e.detail.value
        });
    },
    selectPost: function(e) {
        console.log(e);
        var a = e.currentTarget.dataset.index;
        this.setData({
            currentSelect: a
        }), console.log(this.data.currentSelect);
    },
    goAdd: function() {
        var i = this;
        wx.chooseAddress({
            success: function(e) {
                var a = e.userName, o = (e.postalCode, e.provinceName), t = e.cityName, n = e.countyName, s = e.detailInfo, c = (e.nationalCode, 
                e.telNumber);
                i.setData({
                    currentSelect: 0,
                    address: o + t + n + s,
                    userName: a,
                    tel: c
                });
            }
        });
    },
    payments: function(e) {
        var t = e.detail.formId, n = this;
        console.log("订单金额"), console.log(e);
        var o = n.data.address, s = wx.getStorageSync("openid"), c = n.data.currentSelect;
        if (0 == c) var i = Number(e.detail.target.dataset.money) + Number(n.data.freight); else i = e.detail.target.dataset.money;
        console.log(i);
        var r = wx.getStorageSync("user_id"), d = n.data.userName, l = n.data.tel, a = n.data.consignee, u = n.data.ContactNum;
        0 != c || d && l && o ? 1 != c || u && a ? "undefined" != c && null != c ? app.util.request({
            url: "entry/wxapp/Orderarr",
            cachetime: "30",
            data: {
                openid: s,
                price: i
            },
            success: function(a) {
                console.log(a), wx.setStorageSync("prepay_id", a.data.prepay_id), app.util.request({
                    url: "entry/wxapp/Order_zf",
                    data: {
                        user_id: r,
                        guige: n.data.guige,
                        buyNumber: n.data.buyNumber,
                        price: i,
                        consignee: n.data.consignee,
                        ContactNum: n.data.ContactNum,
                        address: o,
                        currentSelect: c,
                        userName: d,
                        gid: n.data.gid,
                        tel: l,
                        message: n.data.buy_message
                    },
                    success: function(e) {
                        console.log("添加成功"), console.log(e);
                        var o = e.data;
                        console.log(a), wx.requestPayment({
                            timeStamp: a.data.timeStamp,
                            nonceStr: a.data.nonceStr,
                            package: a.data.package,
                            signType: "MD5",
                            paySign: a.data.paySign,
                            success: function(e) {
                                console.log("支付数据"), console.log(e), wx.showToast({
                                    title: "支付成功",
                                    icon: "success",
                                    duration: 2e3
                                });
                                var a = wx.getStorageSync("prepay_id");
                                console.log(a), app.util.request({
                                    url: "entry/wxapp/AccessToken",
                                    cachetime: "0",
                                    success: function(a) {
                                        console.log(a.data), console.log(n.data.gid), app.util.request({
                                            url: "entry/wxapp/changeOrder",
                                            cachetime: "0",
                                            data: {
                                                order_id: o,
                                                gid: n.data.gid,
                                                money: i,
                                                buyNumber: n.data.buyNumber
                                            },
                                            success: function(e) {
                                                app.util.request({
                                                    url: "entry/wxapp/Send",
                                                    cachetime: "0",
                                                    data: {
                                                        access_token: a.data.access_token,
                                                        template_id: n.data.template_order,
                                                        page: "yzkm_sun/pages/goodsDetails/goodsDetails?id=" + n.data.gid,
                                                        openid: s,
                                                        gid: n.data.gid,
                                                        form_id: t,
                                                        money: i
                                                    },
                                                    success: function(e) {}
                                                }), wx.reLaunch({
                                                    url: "../myOrder/myOrder?currentTab=2"
                                                });
                                            }
                                        });
                                    }
                                });
                            },
                            fail: function(e) {
                                wx.reLaunch({
                                    url: "../myOrder/myOrder?currentTab=1"
                                });
                            }
                        });
                    }
                });
            }
        }) : wx.showToast({
            title: "请选择收货方式",
            icon: "none"
        }) : wx.showToast({
            title: "请填写收货人或者联系电话",
            icon: "none"
        }) : wx.showToast({
            title: "请填写收货人或者联系方式！",
            icon: "none"
        });
    },
    goAddress: function(e) {
        "no" == e.currentTarget.dataset.statu ? wx.navigateTo({
            url: "../address-add/index"
        }) : wx.navigateTo({
            url: "../myAddress/myAddress"
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        wx.getStorage({
            key: "addNew",
            success: function(e) {
                console.log(e), a.setData({
                    addNew: [ e.data ]
                }), console.log(a.data);
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    diyWinColor: function(e) {
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: "#ffb62b"
        }), wx.setNavigationBarTitle({
            title: "提交订单"
        });
    }
});