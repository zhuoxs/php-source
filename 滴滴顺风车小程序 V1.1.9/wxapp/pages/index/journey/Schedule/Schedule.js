var e = getApp();

Page({
    data: {
        markers: [ {
            iconPath: "/images/kai.jpg",
            id: 0,
            latitude: 23.099994,
            longitude: 113.32452,
            width: 40,
            height: 40
        } ],
        polyline: [ {
            points: [ {
                longitude: 113.3245211,
                latitude: 23.10229
            }, {
                longitude: 113.32452,
                latitude: 23.21229
            } ],
            color: "#15AB27",
            width: 2,
            dottedLine: !0
        } ],
        style: "width:100%;height:358rpx;",
        nclass: "1",
        casArray: [ "无责取消(与乘客协商)", "直接取消（需要扣除相应费用，见车主须知）", "联系不到乘客" ],
        casArraya: [ "无责取消(与车主协商)", "直接取消（需要扣除相应费用，见乘客须知）", "联系不到车主" ],
        selectionbar: !1,
        showModal: !1,
        cancel_order: !1,
        ntype: "",
        yval: "",
        xval: "",
        ipid: ""
    },
    onLoad: function(t) {
        var a = this;
        a.locth();
        try {
            (o = wx.getStorageSync("session")) && (console.log("logintag:", o), a.setData({
                logintag: o
            }));
        } catch (t) {}
        try {
            (o = wx.getStorageSync("Did")) && (console.log("Did:", o), a.setData({
                id: o
            }));
        } catch (t) {}
        try {
            var o = wx.getStorageSync("Dntype");
            o && (console.log("Dntype:", o), a.setData({
                ntype: o
            }));
        } catch (t) {}
        var n = a.data.logintag, i = a.data.ntype, d = a.data.id;
        if (1 == i) s = "my_passenger_order_view"; else var s = "my_carowner_order_view";
        wx.request({
            url: e.data.url + s,
            data: {
                logintag: n,
                nid: d
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(e) {
                if (console.log(s + "=> 查看订单任务详情"), console.log(e), "0000" == e.data.retCode) {
                    var t = e.data.info.b_lnglat, o = e.data.info.e_lnglat, n = e.data.info.end_addr, d = e.data.info.end_place, l = t.split(","), c = o.split(",");
                    a.setData({
                        info: e.data.info,
                        end_addr: n,
                        e_arr: c,
                        end_place: d,
                        markers: [ {
                            iconPath: "/images/kai.jpg",
                            id: 0,
                            latitude: l[0],
                            longitude: l[1],
                            width: 40,
                            height: 40
                        }, {
                            iconPath: "/images/zhong.jpg",
                            id: 0,
                            latitude: c[0],
                            longitude: c[1],
                            width: 30,
                            height: 30
                        } ],
                        polyline: [ {
                            points: [ {
                                longitude: l[1],
                                latitude: l[0]
                            }, {
                                longitude: c[1],
                                latitude: c[0]
                            } ],
                            color: "#1571FA",
                            width: 3,
                            dottedLine: !0
                        } ]
                    }), 1 == i ? "4" !== e.data.info.isstart && 2 == e.data.info.apply && 1 == e.data.info.cancel_order && 0 == e.data.info.iscancal && a.setData({
                        cancel_order: !0
                    }) : "4" !== e.data.info.isstart && 1 == e.data.info.apply && 1 == e.data.info.iscancel && 0 == e.data.info.isflag && a.setData({
                        cancel_order: !0
                    });
                } else wx.showToast({
                    title: e.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    daohang: function(e) {
        var t = this.data.end_place, a = this.data.end_addr, o = this.data.e_arr;
        console.log(o), console.log(o[0]), console.log(o[1]), wx.openLocation({
            latitude: parseFloat(o[0]),
            longitude: parseFloat(o[1]),
            scale: 18,
            name: t,
            address: a
        });
    },
    locth: function(e) {
        var t = this;
        wx.getLocation({
            type: "gcj02",
            success: function(e) {
                var a = e.latitude, o = e.longitude;
                console.log("yval:", a), console.log("xval:", o), t.setData({
                    yval: a,
                    xval: o
                });
            }
        });
    },
    Unable: function(e) {
        this.setData({
            selectionbar: !0,
            showModal: !0
        });
    },
    phone: function(e) {
        var t = e.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: t,
            success: function(e) {
                console.log(e);
            }
        });
    },
    dj: function(e) {
        wx.showToast({
            title: "订单已冻结",
            icon: "none",
            duration: 1e3
        });
    },
    ts: function(e) {
        wx.showToast({
            title: "点击无效",
            icon: "none",
            duration: 1e3
        });
    },
    chickbegin: function(t) {
        var a = this, o = a.data.logintag, n = a.data.id;
        wx.request({
            url: e.data.url + "my_travel_chickbegin",
            data: {
                logintag: o,
                nid: n,
                ntype: 1
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(e) {
                if (console.log("my_travel_chickbegin => 车主点击开始出行安钮操作"), console.log(e), "0000" == e.data.retCode) wx.showToast({
                    title: e.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), a.onLoad(); else if (wx.showToast({
                    title: e.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), "账号已冻结" == e.data.retDesc) return void wx.navigateTo({
                    url: "/pages/index/index"
                });
            }
        });
    },
    arrive: function(t) {
        var a = this, o = a.data.logintag, n = a.data.id;
        wx.request({
            url: e.data.url + "my_travel_chickpay",
            data: {
                logintag: o,
                nid: n,
                ntype: 2
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(e) {
                if (console.log("my_travel_chickbegin => 乘客点击到达目的地安钮操作支付"), console.log(e), "0000" == e.data.retCode) wx.showToast({
                    title: e.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), a.onLoad(); else {
                    if (wx.showToast({
                        title: e.data.retDesc,
                        icon: "none",
                        duration: 1e3
                    }), "账号已冻结" == e.data.retDesc) return void wx.navigateTo({
                        url: "/pages/index/index"
                    });
                    console.log("身份选择失败");
                }
            }
        });
    },
    bindtap: function(e) {
        var t = this;
        console.log(e.currentTarget.dataset.ipid), t.setData({
            ipid: e.currentTarget.dataset.ipid
        });
    },
    abolish: function(e) {
        this.setData({
            selectionbar: !1,
            showModal: !1
        });
    },
    hideModal: function() {
        this.setData({
            showModal: !1,
            selectionbar: !1
        });
    },
    yes: function(e) {
        var t = this;
        if (console.log(t.data.ipid), 2 == t.data.ipid) {
            var a = t.data.ntype;
            if (2 == a) n = 1; else n = 2;
            var o = t.data.id;
            return wx.setStorage({
                key: "imgid",
                data: o
            }), wx.setStorage({
                key: "xntype",
                data: n
            }), wx.setStorage({
                key: "PD",
                data: a
            }), void t.uploading();
        }
        var n = t.data.ntype, i = t.data.ipid, d = t.data.info.num;
        console.log(i), console.log(d), 1 == i ? 2 == n ? t.cannot() : t.tousu() : d >= 2 ? wx.showToast({
            title: "超过两次操作",
            icon: "none",
            duration: 1e3
        }) : 2 == n ? t.cannot() : t.tousu();
    },
    uploading: function(e) {
        wx.navigateTo({
            url: "/pages/index/journey/Schedule/uploading/uploading"
        });
    },
    cannot: function(t) {
        var a = this, o = a.data.logintag, n = a.data.ntype, i = a.data.id;
        if ("" == (d = a.data.ipid) || 0 == d) d = 1; else var d = 2;
        console.log("nid:", i), console.log("ntype:", 1), console.log("iscancel:", d), wx.request({
            url: e.data.url + "car_owner_wfcx_task",
            data: {
                logintag: o,
                nid: i,
                ntype: 1,
                iscancel: d
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(e) {
                if (console.log("车主点击无法出行操作"), console.log(e), "0000" == e.data.retCode) setTimeout(function() {
                    console.log("延迟调用 => 返回上一页"), wx.navigateBack({
                        delta: 1,
                        success: function(e) {
                            var t = getCurrentPages().pop();
                            void 0 != t && null != t && t.onLoad(n);
                        }
                    });
                }, 1e3), wx.showToast({
                    title: e.data.retDesc,
                    icon: "none",
                    duration: 1e3,
                    mask: !0
                }); else {
                    if (wx.showToast({
                        title: e.data.retDesc,
                        icon: "none",
                        duration: 1e3
                    }), "账号已冻结" == e.data.retDesc) return void wx.navigateTo({
                        url: "/pages/index/index"
                    });
                    a.hideModal();
                }
            }
        });
    },
    tousu: function(t) {
        var a = this, o = a.data.logintag, n = a.data.ntype, i = a.data.id;
        if ("" == (d = a.data.ipid) || 0 == d) d = 1; else var d = 2;
        console.log("nid:", i), console.log("ntype:", 2), console.log("iscancel:", d), wx.request({
            url: e.data.url + "passenger_wfcx_task",
            data: {
                logintag: o,
                nid: i,
                ntype: 2,
                iscancel: d
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(e) {
                if (console.log("乘客点击无法出行操作"), console.log(e), "0000" == e.data.retCode) setTimeout(function() {
                    console.log("延迟调用 => 返回上一页"), wx.navigateBack({
                        delta: 1,
                        success: function(e) {
                            var t = getCurrentPages().pop();
                            void 0 != t && null != t && t.onLoad(n);
                        }
                    });
                }, 1e3), wx.showToast({
                    title: e.data.retDesc,
                    icon: "none",
                    duration: 1e3,
                    mask: !0
                }); else {
                    if (wx.showToast({
                        title: e.data.retDesc,
                        icon: "none",
                        duration: 1e3
                    }), "账号已冻结" == e.data.retDesc) return void wx.navigateTo({
                        url: "/pages/index/index"
                    });
                    a.hideModal();
                }
            }
        });
    },
    iphone: function(e) {
        console.log(e), wx.makePhoneCall({
            phoneNumber: e.currentTarget.dataset.mobile,
            success: function(e) {
                console.log(e);
            }
        });
    },
    consent: function(t) {
        var a = this, o = a.data.logintag, n = a.data.ntype, i = t.currentTarget.dataset.nid;
        if (console.log(n), 1 == n) var d = "passenger_click_agree_op", s = 2; else var d = "car_owner_click_agree_op", s = 1;
        wx.request({
            url: e.data.url + d,
            data: {
                logintag: o,
                nid: i,
                ntype: s
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(e) {
                if (console.log("车主点击同意操作"), console.log(e), "0000" == e.data.retCode) setTimeout(function() {
                    console.log("延迟调用 => 返回上一页"), wx.navigateBack({
                        delta: 1,
                        success: function(e) {
                            var t = getCurrentPages().pop();
                            void 0 != t && null != t && t.onLoad(n);
                        }
                    });
                }, 1e3), wx.showToast({
                    title: e.data.retDesc,
                    icon: "none",
                    duration: 1e3,
                    mask: !0
                }); else if (wx.showToast({
                    title: e.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), "账号已冻结" == e.data.retDesc) return void wx.navigateTo({
                    url: "/pages/index/index"
                });
            }
        });
    },
    complaint: function(e) {
        var t = this;
        console.log(e);
        var a = e.currentTarget.dataset.nid, o = e.currentTarget.dataset.ntype;
        wx.setStorage({
            key: "imgid",
            data: a
        }), wx.setStorage({
            key: "xntype",
            data: o
        }), t.uploading();
    },
    refuse: function(t) {
        var a = this, o = a.data.logintag, n = a.data.ntype, i = t.currentTarget.dataset.nid;
        if (1 == n) var d = "passenger_click_notagree_op", s = 2; else var d = "car_owner_click_notagree_op", s = 1;
        wx.request({
            url: e.data.url + d,
            data: {
                logintag: o,
                nid: i,
                ntype: s
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(e) {
                if (console.log("车主点击不同意操作"), console.log(e), "0000" == e.data.retCode) setTimeout(function() {
                    console.log("延迟调用 => 返回上一页"), wx.navigateBack({
                        delta: 1,
                        success: function(e) {
                            var t = getCurrentPages().pop();
                            void 0 != t && null != t && t.onLoad(n);
                        }
                    });
                }, 1e3), wx.showToast({
                    title: e.data.retDesc,
                    icon: "none",
                    duration: 1e3,
                    mask: !0
                }); else if (wx.showToast({
                    title: e.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), "账号已冻结" == e.data.retDesc) return void wx.navigateTo({
                    url: "/pages/index/index"
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
    onShareAppMessage: function() {}
});