/*   time:2019-08-09 13:18:47*/
var app = getApp();

function sendMessage(e) {
    app.util.request({
        url: "entry/wxapp/SendMessagePay",
        data: e,
        success: function(a) {
            console.log(a), console.log(e), console.log("发送成功")
        }
    })
}
Page({
    data: {
        hasAddress: !1,
        address: [],
        navTile: "提交订单",
        goods: [],
        rebate: [],
        firstmoney: 0,
        cardprice: "0",
        curprice: "0",
        showModalStatus: !1,
        cards: [],
        showRemark: 0,
        isshowpay: 0,
        choose: [{
            name: "微信支付",
            value: "1",
            icon: "/style/images/wx.png",
            checked: "checked"
        }],
        payStatus: 0,
        payType: "1",
        uremark: "",
        showuremark: "20字以内",
        orderNum: "1111111111111",
        orderTime: "2018-02-02 10:30",
        deliveryfee: 0,
        is_modal_Hidden: !0,
        typeid: 0,
        order_id: 0,
        continuesubmit: !1,
        tel: "",
        isclickpay: !1,
        goodsnum: 1,
        rmoney: 0,
        rid: 0
    },
    onLoad: function(a) {
        var t = this;
        t.setData({
            pid: a.id,
            price: a.price
        });
        wx.getStorageSync("openid");
        app.wxauthSetting(), app.util.request({
            url: "entry/wxapp/System",
            cachetime: "30",
            showLoading: !1,
            success: function(a) {
                console.log(a.data);
                var e = t.data.choose;
                if (1 == a.data.isopen_recharge) {
                    e = e.concat([{
                        name: "余额支付",
                        value: "2",
                        icon: "/style/images/yuelogo.png",
                        checked: ""
                    }])
                }
                console.log("69696969696969"), console.log(e), t.setData({
                    choose: e
                }), wx.setNavigationBarColor({
                    frontColor: a.data.fontcolor ? a.data.fontcolor : "",
                    backgroundColor: a.data.color ? a.data.color : "",
                    animation: {
                        duration: 0,
                        timingFunc: "easeIn"
                    }
                })
            }
        })
    },
    onShow: function() {
        var e = this,
            a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/ISVIP",
            cachetime: "0",
            data: {
                openid: a
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                console.log("vip"), console.log(a.data), wx.setStorageSync("viptype", a.data.viptype), e.setData({
                    viptype: a.data.viptype
                })
            }
        }), app.util.request({
            url: "entry/wxapp/orderbuy",
            data: {
                m: app.globalData.Plugin_package,
                pid: e.data.pid
            },
            success: function(a) {
                console.log(a), e.setData({
                    infos: a.data,
                    imgLink: wx.getStorageSync("url")
                })
            }
        })
    },
    bindTimeChange: function(a) {
        this.setData({
            time: a.detail.value
        })
    },
    powerDrawer: function(a) {
        var e = a.currentTarget.dataset.statu;
        this.util(e)
    },
    util: function(a) {
        var e = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = e).opacity(0).height(0).step(), this.setData({
            animationData: e.export()
        }), setTimeout(function() {
            e.opacity(1).height("550rpx").step(), this.setData({
                animationData: e
            }), "close" == a && this.setData({
                showModalStatus: !1
            })
        }.bind(this), 200), "open" == a && this.setData({
            showModalStatus: !0
        })
    },
    showModel: function(a) {
        var e = a.currentTarget.dataset.statu;
        console.log(), this.setData({
            showRemark: e
        })
    },
    showPay: function(a) {
        var e = this,
            t = e.data.tel,
            o = e.data.name;
        e.data.sincetype;
        if (!t) return wx.showToast({
            title: "请输入电话号码",
            icon: "none",
            duration: 2e3
        }), !1;
        if (!o) return wx.showToast({
            title: "请输入名字",
            icon: "none",
            duration: 2e3
        }), !1;
        e.data.price;
        var s = a.currentTarget.dataset.statu,
            n = e.data.rid,
            i = e.data.open_redpacket,
            r = e.data.rmoney,
            c = e.data.totalprice,
            l = parseFloat(c) + parseFloat(r);
        l = l.toFixed(2), i && app.util.request({
            url: "entry/wxapp/RedPacketUse",
            showLoading: !1,
            data: {
                rid: n,
                m: app.globalData.Plugin_redpacket
            },
            success: function(a) {
                console.log(a.data), 111 == a.data && e.setData({
                    rmoney: 0,
                    totalprice: l
                })
            }
        }), e.setData({
            payStatus: s
        })
    },
    remark: function(a) {
        var e = a.detail.value;
        this.setData({
            uremark: e,
            showuremark: e
        })
    },
    radioChange: function(a) {
        var e = a.detail.value;
        this.setData({
            payType: e
        })
    },
    formSubmit: function(a) {
        var t = this,
            o = wx.getStorageSync("openid"),
            s = (t.data.deliveryfee, t.data.payType),
            e = t.data.uremark,
            n = wx.getStorageSync("users").id,
            i = t.data.name,
            r = a.detail.value.tel,
            c = t.data.price,
            l = (t.data.rid, t.data.firstmoney, t.data.rmoney),
            d = a.detail.formId,
            u = t.data.price;
        console.log(i), console.log(o), console.log(r), console.log(c), i && o && r && app.util.request({
            url: "entry/wxapp/addorder",
            cachetime: "0",
            showLoading: !1,
            data: {
                openid: o,
                pid: t.data.pid,
                telNumber: r,
                paytype: s,
                uremark: e,
                uid: n,
                rmoney: l,
                name: i,
                m: app.globalData.Plugin_package
            },
            success: function(a) {
                console.log(a);
                var e = {
                    orderarr: {
                        order_id: a.data,
                        openid: o,
                        price: u,
                        m: app.globalData.Plugin_package
                    },
                    message: {
                        order_id: a.data,
                        openid: o,
                        form_id: d,
                        m: app.globalData.Plugin_package
                    },
                    payType: s,
                    url: "../packageOrder/packageOrder?id=" + t.data.pid,
                    price: u
                };
                app.util.request({
                    url: "entry/wxapp/ispay",
                    data: {
                        uid: n,
                        pid: t.data.pid,
                        m: app.globalData.Plugin_package
                    },
                    success: function(a) {
                        1 == a.data ? t.pays(e) : wx.showToast({
                            title: "库存不足,无法下单"
                        })
                    }
                })
            }
        })
    },
    toAddress: function() {
        var e = this;
        e.data.telnum;
        wx.chooseAddress({
            success: function(a) {
                console.log("获取地址成功"), e.setData({
                    address: a,
                    telnum: a.telNumber,
                    hasAddress: !0
                })
            },
            fail: function(a) {
                console.log("获取地址失败"), wx.getSetting({
                    success: function(a) {
                        a.authSetting["scope.address"] || (console.log("进入信息授权开关页面"), wx.openSetting({
                            success: function(a) {
                                console.log("openSetting success", a.authSetting)
                            }
                        }))
                    }
                })
            }
        })
    },
    updateUserInfo: function(a) {
        console.log("授权操作更新");
        app.wxauthSetting()
    },
    nowtel: function(a) {
        console.log(a);
        var e = a.detail.value;
        this.data.tel;
        this.setData({
            tel: e
        })
    },
    nowname: function(a) {
        console.log(a);
        var e = a.detail.value;
        this.data.tel;
        this.setData({
            name: e
        })
    },
    pays: function(e) {
        var t = this,
            a = e.orderarr,
            o = e.payType,
            s = e.message,
            n = e.orderarr.order_id;
        1 == o && 0 < e.price ? app.util.request({
            url: "entry/wxapp/Orderarr",
            data: a,
            success: function(a) {
                console.log(a.data), wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: a.data.signType,
                    paySign: a.data.paySign,
                    success: function(a) {
                        wx.showToast({
                            title: "支付成功",
                            icon: "success",
                            duration: 2e3
                        }), sendMessage(s), wx.redirectTo({
                            url: e.url
                        })
                    },
                    fail: function(a) {
                        wx.showToast({
                            title: "支付失败",
                            icon: "none",
                            duration: 2e3
                        }), console.log("失败00003"), t.setData({
                            continuesubmit: !0,
                            isclickpay: !1,
                            isclick: !1
                        })
                    }
                })
            },
            fail: function(a) {
                console.log("失败00002"), t.setData({
                    continuesubmit: !0,
                    isclickpay: !1,
                    isclick: !1
                }), wx.showModal({
                    title: "提示信息",
                    content: a.data.message,
                    showCancel: !1
                })
            }
        }) : 2 == o && 0 < e.price ? (console.log("余额"), console.log(a), app.util.request({
            url: "entry/wxapp/OrderarrYue",
            data: a,
            success: function(a) {
                wx.showToast({
                    title: "支付成功",
                    icon: "success",
                    duration: 2e3
                }), sendMessage(s), wx.redirectTo({
                    url: e.url
                })
            },
            fail: function(a) {
                console.log("失败00004"), t.setData({
                    continuesubmit: !0,
                    isclickpay: !1,
                    isclick: !1
                }), wx.showModal({
                    title: "提示信息",
                    content: a.data.message,
                    showCancel: !1
                })
            }
        })) : app.util.request({
            url: "entry/wxapp/Orderarrzero",
            data: {
                order_id: n,
                m: app.globalData.Plugin_package
            },
            success: function(a) {
                wx.showToast({
                    title: "下单成功",
                    icon: "success",
                    duration: 2e3
                }), sendMessage(s), wx.redirectTo({
                    url: e.url
                })
            },
            fail: function(a) {
                console.log("失败00004"), t.setData({
                    continuesubmit: !0,
                    isclickpay: !1,
                    isclick: !1
                }), wx.showModal({
                    title: "提示信息",
                    content: a.data.message,
                    showCancel: !1
                })
            }
        })
    }
});