var a = getApp();

Page({
    data: {
        markers: [ {
            iconPath: "/images/kai.jpg",
            id: 0,
            latitude: 23.099994,
            longitude: 113.32452,
            width: 40,
            height: 40
        }, {
            iconPath: "/images/zhong.jpg",
            id: 0,
            latitude: 23.21229,
            longitude: 113.32452,
            width: 30,
            height: 30
        } ],
        polyline: [ {
            points: [ {
                longitude: 113.3245211,
                latitude: 23.10229
            }, {
                longitude: 113.32452,
                latitude: 23.21229
            } ],
            color: "#1571FA",
            width: 3,
            dottedLine: !0
        } ],
        style: "width:100%;height:358rpx;",
        logintag: "",
        nclass: "",
        yval: "",
        xval: "",
        info: "",
        array: [],
        num: "",
        ntype: "",
        fxid: "",
        id: "",
        classs: "",
        coos_id: 0,
        clss: ""
    },
    onLoad: function(e) {
        var t = this;
        if (a.acquire(), console.log(e), e.id) console.log("分享来的............."), t.setData({
            id: e.nid,
            ntype: e.ntype,
            fxid: e.id,
            clss: e.nclass
        }), wx.login({
            success: function(e) {
                if (console.log("购买订单 => wx.login => 获取code"), console.log(e), e.code) {
                    wx.setStorage({
                        key: "code",
                        data: e.code
                    });
                    var o = e.code, n = t.data.fxid, i = t.data.ntype, s = t.data.id;
                    console.log("购买订单.js => login:" + n), console.log("购买订单.js => login:" + i), console.log("购买订单.js => login:" + s), 
                    wx.request({
                        url: a.data.url + "memberlogin",
                        data: {
                            code: o,
                            nid: n,
                            ntype: i,
                            orderid: s
                        },
                        success: function(a) {
                            console.log("购买订单 => memberlogin => 获取登录信息"), console.log(a), "0000" == a.data.retCode ? (a.data.wx_headimg || wx.redirectTo({
                                url: "/pages/index/getinfo/getinfo"
                            }), wx.setStorage({
                                key: "session",
                                data: a.data.logintag
                            }), wx.setStorage({
                                key: "nclass",
                                data: a.data.nclass
                            }), t.setData({
                                logintag: a.data.logintag,
                                nclass: a.data.nclass
                            }), t.begin()) : wx.showToast({
                                title: a.data.retDesc,
                                icon: "none",
                                duration: 1e3
                            });
                        }
                    });
                } else console.log("获取用户登录态失败！" + e.errMsg);
            }
        }); else {
            var o = e.nid;
            t.setData({
                id: o
            });
            try {
                (n = wx.getStorageSync("session")) && (console.log("logintag:", n), t.setData({
                    logintag: n
                }));
            } catch (e) {}
            try {
                var n = wx.getStorageSync("nclass");
                n && (console.log("nclass:", n), t.setData({
                    nclass: n
                }));
            } catch (e) {}
            t.begin();
        }
    },
    pulldown: function(a) {
        var e = this;
        0 == e.data.classs ? e.setData({
            style: "width:100%;height:1200rpx;",
            classs: "1"
        }) : e.setData({
            style: "width:100%;height:358rpx;",
            classs: "0"
        });
    },
    begin: function(e) {
        var t = this;
        wx.getLocation({
            type: "gcj02",
            success: function(e) {
                var o = e.latitude, n = e.longitude, i = t.data.logintag, s = t.data.id, l = t.data.nclass;
                if (0 == l || 1 == l) var d = "car_owner_task_info", c = "2"; else var d = "passenger_task_info", c = "1";
                wx.request({
                    url: a.data.url + d,
                    data: {
                        logintag: i,
                        nid: s,
                        flag: c,
                        yval: o,
                        xval: n
                    },
                    header: {
                        "content-type": "application/x-www-form-urlencoded"
                    },
                    success: function(a) {
                        if (console.log(d + " => 查看订单任务详情"), console.log(a), "0000" == a.data.retCode) {
                            var e = a.data.info.b_lnglat, i = a.data.info.e_lnglat, s = e.split(","), l = i.split(",");
                            console.log(s), console.log(l);
                            for (var c = a.data.info.nowseat, g = [], r = 1; r <= c; r++) console.log(r), g[r - 1] = r;
                            console.log(g), t.setData({
                                info: a.data.info,
                                yval: o,
                                xval: n,
                                array: g,
                                markers: [ {
                                    iconPath: "/images/kai.jpg",
                                    id: 0,
                                    latitude: s[0],
                                    longitude: s[1],
                                    width: 40,
                                    height: 40
                                }, {
                                    iconPath: "/images/zhong.jpg",
                                    id: 0,
                                    latitude: l[0],
                                    longitude: l[1],
                                    width: 30,
                                    height: 30
                                } ],
                                polyline: [ {
                                    points: [ {
                                        longitude: s[1],
                                        latitude: s[0]
                                    }, {
                                        longitude: l[1],
                                        latitude: l[0]
                                    } ],
                                    color: "#1571FA",
                                    width: 3,
                                    dottedLine: !0
                                } ]
                            });
                        } else wx.showToast({
                            title: a.data.retDesc,
                            icon: "none",
                            duration: 1e3
                        });
                    }
                });
            }
        });
    },
    rob: function(a) {
        var e = this, t = e.data.nclass, o = a.detail.formId;
        console.log(t), 0 == t || 1 == t ? e.passenger(o) : e.owner(o);
    },
    owner: function(e) {
        var t = this, o = t.data.id, n = t.data.logintag, i = t.data.fxid, s = e;
        wx.request({
            url: a.data.url + "car_owner_robbing_passenger_task",
            data: {
                logintag: n,
                nid: o,
                form_id: s
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(e) {
                console.log("car_owner_robbing_passenger_task => 车主抢单操作"), console.log(e), "0000" == e.data.retCode ? (wx.showToast({
                    title: e.data.retDesc,
                    icon: "succes",
                    duration: 1e3,
                    mask: !0
                }), i ? wx.navigateTo({
                    url: "/pages/index/index"
                }) : setTimeout(function() {
                    a.data.QD = 1, console.log("延迟调用 => 返回上一页"), wx.navigateBack({
                        delta: 1
                    });
                }, 1e3)) : "请完善手机号" == e.data.retDesc ? wx.showModal({
                    title: "提示",
                    content: e.data.retDesc,
                    success: function(a) {
                        a.confirm && wx.navigateTo({
                            url: "/pages/index/phone/phone"
                        });
                    }
                }) : wx.showToast({
                    title: e.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    passenger: function(e) {
        var t = this, o = t.data.id, n = t.data.logintag, i = t.data.fxid, s = t.data.num, l = t.data.coos_id;
        wx.request({
            url: a.data.url + "passenger_buy_car_owner_seat",
            data: {
                logintag: n,
                nid: o,
                seatnum: s,
                coos_id: l
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(e) {
                console.log("car_owner_robbing_passenger_task => 乘客购买订单操作"), console.log(e), "0000" == e.data.retCode ? 2 == e.data.paytype ? (wx.showToast({
                    title: e.data.retDesc,
                    icon: "succes",
                    duration: 1e3,
                    mask: !0
                }), i ? wx.navigateTo({
                    url: "/pages/index/index"
                }) : setTimeout(function() {
                    console.log("延迟调用 => 返回上一页"), a.data.QD = 1, wx.navigateBack({
                        delta: 1
                    });
                }, 1e3)) : t.passenger_buy(e.data.nid) : "请完善手机号" == e.data.retDesc ? wx.showModal({
                    title: "提示",
                    content: e.data.retDesc,
                    success: function(a) {
                        a.confirm && wx.navigateTo({
                            url: "/pages/index/phone/phone"
                        });
                    }
                }) : wx.showToast({
                    title: e.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    passenger_buy: function(e) {
        console.log(e);
        var t = this, o = e, n = t.data.logintag, i = t.data.fxid;
        wx.request({
            url: a.data.url + "passenger_buy_seat_pay",
            data: {
                logintag: n,
                nid: o
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(e) {
                console.log("乘客购买车主任务座位发起小程序支付"), console.log(e), wx.requestPayment({
                    timeStamp: e.data.timeStamp,
                    nonceStr: e.data.nonceStr,
                    package: e.data.package,
                    signType: "MD5",
                    paySign: e.data.paySign,
                    success: function(e) {
                        console.log(e), i ? wx.navigateTo({
                            url: "/pages/index/index"
                        }) : setTimeout(function() {
                            console.log("延迟调用 => 返回上一页"), a.data.QD = 1, wx.navigateBack({
                                delta: 1
                            });
                        }, 1e3);
                    },
                    fail: function(a) {}
                });
            }
        });
    },
    bindPickerChange: function(a) {
        var e = this;
        console.log("picker发送选择改变，携带值为", a.detail.value);
        var t = parseInt(a.detail.value) + 1;
        this.setData({
            num: t
        }), e.passenger();
    },
    radioChange: function(a) {
        var e = this, t = a.detail.value;
        console.log(t), e.setData({
            coos_id: t
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var a = this, e = a.data.id, t = a.data.nclass;
        if (0 == t || 1 == t) o = 3; else var o = 2;
        try {
            var n = wx.getStorageSync("ac_nid");
            if (n) {
                console.log("ac_nid:", n);
                var i = n;
                return console.log("分享：", i), console.log("ntype", o), console.log("nid", e), {
                    title: "拼车",
                    desc: "拼车!",
                    imageUrl: "/images/eqweqw.jpg",
                    path: "/pages/index/search/information/route/route?id=" + i + "&ntype=" + o + "&nid=" + e + "&nclass=" + t
                };
            }
        } catch (a) {}
    }
});