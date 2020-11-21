var app = getApp(), tool = require("../../../../style/utils/tools.js");

Page({
    data: {
        isIpx: app.globalData.isIpx,
        status: 0,
        ispay: !0,
        phonestatus: "0",
        multiArray: [],
        multiIndex: [ 0, 0 ],
        num: 1,
        showModalStatus: !1,
        rstatus: "",
        choose: [ {
            name: "微信",
            value: "微信支付",
            icon: "../../../../style/images/wx.png"
        }, {
            name: "余额",
            value: "余额支付",
            icon: "../../../../style/images/local.png"
        } ]
    },
    bindSave: function(t) {
        var a = this, e = new Date(), n = e.getMonth() + 1 + "-" + e.getDate() + " " + e.getHours() + ":" + e.getMinutes(), i = Date.parse(new Date(n)) / 1e3;
        console.log(i);
        var s = a.data.multiIndex, o = a.data.multiArray, r = o[0][s[0]].substring(o[0][s[0]].length - 5) + " " + o[1][s[1]], c = Date.parse(new Date(r)) / 1e3;
        if (console.log(c), c < i) return wx.showModal({
            title: "提示",
            content: "时间选择错误，请重新选择",
            showCancel: !1
        }), !1;
        for (var u = a.data.phone, l = a.data.property, d = "", p = 0; p < l.length; p++) 1 == l[p].prostatus && (d = d + l[p].type_name + ",");
        return null == u || "" == u || "" != u && u.length < 6 ? (wx.showModal({
            title: "提示",
            content: "请正确填写预留电话",
            showCancel: !1
        }), !1) : "" == d ? (wx.showModal({
            title: "提示",
            content: "请选择服务项目",
            showCancel: !1
        }), !1) : void ("" != d && u && a.utils("open"));
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var e = new Date(), n = e.getHours(), i = e.getMinutes(), s = 0, o = tool.formatTime(new Date());
        if (10 <= n && n <= 22) for (var r in o[1]) {
            if (o[1][r].split(":")[0] == n) {
                s = 30 < i ? parseInt(r) + 2 : parseInt(r) + 1;
                break;
            }
        }
        var c = [ 0, s ];
        a.setData({
            multiArray: o,
            multiIndex: c
        }), console.log(t), wx.setStorageSync("hair_id", t.id), app.util.request({
            url: "entry/wxapp/Appion",
            cachetime: "10",
            data: {
                hair_id: t.id
            },
            success: function(t) {
                a.setData({
                    unitPrice: t.data.data,
                    totalprice: t.data.data
                });
            }
        });
        var u = t.id;
        app.util.request({
            url: "entry/wxapp/HairerData",
            cachetime: "10",
            data: {
                hair_id: u
            },
            success: function(t) {
                a.setData({
                    hairDa: t.data.data
                });
            }
        }), a.titleshop();
    },
    titleshop: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Shop",
            cachetime: "10",
            success: function(t) {
                a.setData({
                    shopData: t.data.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this, t = wx.getStorageSync("hair_id");
        app.util.request({
            url: "entry/wxapp/ServiceItems",
            cachetime: "0",
            data: {
                hair_id: t
            },
            success: function(t) {
                a.setData({
                    property: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    radioChange: function(t) {
        var a = t.detail.value;
        console.log(a), this.setData({
            rstatus: a
        });
    },
    showDrawer: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.utils(a);
    },
    utils: function(t) {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).opacity(0).height(0).step(), this.setData({
            animationshowData: a.export()
        }), setTimeout(function() {
            a.opacity(1).height("500rpx").step(), this.setData({
                animationshowData: a
            }), "close" == t && this.setData({
                showStatus: !1,
                rstatus: ""
            });
        }.bind(this), 200), "open" == t && this.setData({
            showStatus: !0
        });
    },
    choosepro: function(t) {
        for (var a = this, e = t.currentTarget.dataset.index, n = a.data.property, i = 0; i < n.length; i++) i == e && (0 == n[i].prostatus ? n[i].prostatus = 1 : n[i].prostatus = 0);
        console.log(n), a.setData({
            property: n
        });
        for (i = 0; i < n.length; i++) {
            if ("1" == n[i].prostatus && "1" == a.phonestatus) {
                a.setData({
                    status: 1
                });
                break;
            }
            a.setData({
                status: 0
            });
        }
    },
    bindMultiPickerColumnChange: function(t) {
        var a = this.data.multiIndex, e = t.detail.value;
        if (0 == a[0] && 1 == t.detail.column || 0 == t.detail.column && 0 == t.detail.value) {
            var n = new Date(), i = n.getHours(), s = n.getMinutes(), o = this.data.multiArray, r = 0;
            if (10 <= i && i <= 22) for (var c in o[1]) {
                if (o[1][c].split(":")[0] == i) {
                    e = (r = 30 < s ? parseInt(c) + 2 : parseInt(c) + 1) < e ? e : r;
                    break;
                }
            }
            if (0 == t.detail.column && 0 == t.detail.value) {
                var u = {
                    multiIndex: [ 0, e ]
                };
                return this.setData(u), !1;
            }
        }
        console.log(t.detail), console.log(e), (u = {
            multiIndex: this.data.multiIndex
        }).multiIndex[t.detail.column] = e, this.setData(u);
    },
    addNum: function(t) {
        var a = t.currentTarget.dataset.index, e = parseInt(a) + 1;
        100 < e && (e = 99), this.setData({
            num: e
        }), this.getTotalPrice();
    },
    reduceNum: function(t) {
        var a = t.currentTarget.dataset.index, e = parseInt(a) - 1;
        e < 1 && (e = 1), this.setData({
            num: e
        }), this.getTotalPrice();
    },
    getTotalPrice: function() {
        var t = parseInt(this.data.num), a = parseFloat(this.data.unitPrice * t);
        this.setData({
            totalprice: a
        });
    },
    phonestatue: function(t) {
        this.setData({
            disabled: !this.data.disabled
        });
    },
    passWdInput: function(t) {
        var a = this, e = t.detail.value, n = a.data.property;
        e.length < 6 ? a.phonestatus = "0" : a.phonestatus = "1", a.setData({
            phone: e
        });
        for (var i = 0; i < n.length; i++) {
            if ("1" == n[i].prostatus && "1" == a.phonestatus) {
                a.setData({
                    status: 1
                });
                break;
            }
            a.setData({
                status: 0
            });
        }
    },
    submit: function(i) {
        var s = this;
        if (0 == s.data.ispay) return !1;
        for (var o = wx.getStorageSync("build_id"), t = s.data.multiIndex, a = s.data.multiArray, r = s.data.hairDa.id, c = a[0][t[0]] + " " + a[1][t[1]], u = i.detail.value.num, l = i.detail.value.phone, d = i.detail.value.remark, p = s.data.totalprice, e = (l = i.detail.value.phone, 
        s.data.property), h = "", n = 0; n < e.length; n++) 1 == e[n].prostatus && (h = h + e[n].type_name + ",");
        if ("" != h) {
            if (l) if ("微信" == s.data.rstatus) console.log("woshi1111111111111111"), wx.getUserInfo({
                success: function(e) {
                    wx.getStorage({
                        key: "openid",
                        success: function(t) {
                            var n = t.data, a = s.data.orderid;
                            if (a) return app.util.request({
                                url: "entry/wxapp/Orderarr",
                                cachetime: "30",
                                data: {
                                    openid: n,
                                    price: p,
                                    ordertype: 1,
                                    order_id: a
                                },
                                success: function(t) {
                                    console.log(t);
                                    var a = t.data.package;
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
                                                url: "entry/wxapp/PaySuccess",
                                                cachetime: "0",
                                                data: {
                                                    prepay_id: a,
                                                    openid: n,
                                                    order_id: order_id
                                                },
                                                success: function(t) {
                                                    console.log(t.data);
                                                }
                                            }), wx.showModal({
                                                title: "",
                                                content: "支付成功",
                                                cancelText: "去首页",
                                                confirmText: "查看订单",
                                                success: function(t) {
                                                    t.confirm ? wx.redirectTo({
                                                        url: "../../user/myorder/myorder?tab=1"
                                                    }) : t.cancel && wx.reLaunch({
                                                        url: "../index"
                                                    });
                                                }
                                            }), s.setData({
                                                ispay: !0
                                            });
                                        }
                                    });
                                },
                                fail: function(t) {
                                    s.setData({
                                        ispay: !0
                                    });
                                }
                            }), !1;
                            app.util.request({
                                url: "entry/wxapp/OrderAppion",
                                cachetime: "0",
                                data: {
                                    time: c,
                                    num: u,
                                    phone: l,
                                    remark: d,
                                    pname: h,
                                    id: i.currentTarget.dataset.id,
                                    totalprice: p,
                                    uid: n,
                                    nickName: e.userInfo.nickName,
                                    hair_id: r,
                                    build_id: o
                                },
                                success: function(t) {
                                    var e = t.data.data;
                                    s.setData({
                                        orderid: e
                                    }), app.util.request({
                                        url: "entry/wxapp/Orderarr",
                                        cachetime: "30",
                                        data: {
                                            openid: n,
                                            price: p,
                                            ordertype: 1,
                                            order_id: e
                                        },
                                        success: function(t) {
                                            console.log(t);
                                            var a = t.data.package;
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
                                                        url: "entry/wxapp/PaySuccess",
                                                        cachetime: "0",
                                                        data: {
                                                            prepay_id: a,
                                                            openid: n,
                                                            order_id: e
                                                        },
                                                        success: function(t) {
                                                            console.log(t.data);
                                                        }
                                                    }), wx.showModal({
                                                        title: "",
                                                        content: "支付成功",
                                                        cancelText: "去首页",
                                                        confirmText: "查看订单",
                                                        success: function(t) {
                                                            t.confirm ? wx.redirectTo({
                                                                url: "../../user/myorder/myorder?tab=1"
                                                            }) : t.cancel && wx.reLaunch({
                                                                url: "../index"
                                                            });
                                                        }
                                                    }), s.setData({
                                                        ispay: !0
                                                    });
                                                }
                                            });
                                        },
                                        fail: function(t) {
                                            s.setData({
                                                ispay: !0
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            }); else if ("余额" == s.data.rstatus) {
                console.log("woshi222222222222");
                var m = wx.getStorageSync("openid");
                console.log(m), app.util.request({
                    url: "entry/wxapp/CheckBalance",
                    cachetime: "0",
                    data: {
                        totalprice: p,
                        openid: m
                    },
                    success: function(t) {
                        console.log(t), 2 == t.data ? wx.getUserInfo({
                            success: function(t) {
                                console.log(t), app.util.request({
                                    url: "entry/wxapp/OrderAppion",
                                    cachetime: "0",
                                    data: {
                                        time: c,
                                        num: u,
                                        phone: l,
                                        remark: d,
                                        pname: h,
                                        id: i.currentTarget.dataset.id,
                                        totalprice: p,
                                        uid: m,
                                        nickName: t.userInfo.nickName,
                                        hair_id: r,
                                        build_id: o,
                                        paytype: 2
                                    },
                                    success: function(t) {
                                        console.log(t), wx.showModal({
                                            title: "",
                                            content: "支付成功",
                                            cancelText: "去首页",
                                            confirmText: "查看订单",
                                            success: function(t) {
                                                t.confirm ? wx.redirectTo({
                                                    url: "../../user/myorder/myorder?tab=1"
                                                }) : t.cancel && wx.reLaunch({
                                                    url: "../index"
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        }) : wx.showToast({
                            title: "余额不足，请充值！",
                            icon: "none"
                        }), s.setData({
                            ispay: !0
                        });
                    }
                });
            } else wx.showToast({
                title: "请选择支付方式",
                icon: "none"
            }); else wx.showToast({
                title: "请输入预留电话！",
                icon: "none"
            });
        } else wx.showToast({
            title: "请选择服务项目",
            icon: "none"
        });
    }
});