function t(t, e, o) {
    return e in t ? Object.defineProperty(t, e, {
        value: o,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = o, t;
}

var e, o, a = getApp();

Page((o = {
    data: (e = {
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
        casArraya: [ "和乘客商量（无责取消）", "直接取消（需要扣除相应费用，见车主须知）" ],
        selectionbar: !1,
        showModal: !1,
        cancel_order: !1,
        yval: "",
        xval: "",
        ntype: "",
        id: "",
        logintag: "",
        nid: "",
        casArray: [ "联系不上乘客" ]
    }, t(e, "cancel_order", !0), t(e, "cancelorder", !1), t(e, "num", ""), e),
    onLoad: function(t) {
        var e = this;
        e.locth();
        try {
            (o = wx.getStorageSync("senid")) && (console.log("nid:", o), e.setData({
                nid: o
            }));
        } catch (t) {}
        try {
            var o = wx.getStorageSync("session");
            o && (console.log("logintag:", o), e.setData({
                logintag: o
            }));
        } catch (t) {}
        var n = e.data.logintag, i = e.data.nid;
        wx.request({
            url: a.data.url + "my_travel_carowner_click_passenger",
            data: {
                logintag: n,
                nid: i
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                if (console.log("my_travel_carowner_click_passenger=> 车主任务点击乘客详情"), console.log(t), 
                console.log(t), "0000" == t.data.retCode) {
                    var o = t.data.info.b_lnglat, a = t.data.info.e_lnglat, n = o.split(","), i = a.split(",");
                    e.setData({
                        info: t.data.info,
                        markers: [ {
                            iconPath: "/images/kai.jpg",
                            id: 0,
                            latitude: n[0],
                            longitude: n[1],
                            width: 40,
                            height: 40
                        }, {
                            iconPath: "/images/zhong.jpg",
                            id: 0,
                            latitude: i[0],
                            longitude: i[1],
                            width: 30,
                            height: 30
                        } ],
                        polyline: [ {
                            points: [ {
                                longitude: n[1],
                                latitude: n[0]
                            }, {
                                longitude: i[1],
                                latitude: i[0]
                            } ],
                            color: "#1571FA",
                            width: 3,
                            dottedLine: !0
                        } ]
                    });
                } else wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                });
            }
        });
    },
    locth: function(t) {
        var e = this;
        wx.getLocation({
            type: "gcj02",
            success: function(t) {
                var o = t.latitude, a = t.longitude;
                console.log("yval:", o), console.log("xval:", a), e.setData({
                    yval: o,
                    xval: a
                });
            }
        });
    },
    phone: function(t) {
        var e = t.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: e,
            success: function(t) {
                console.log(t);
            }
        });
    },
    ts: function(t) {
        wx.showToast({
            title: "点击无效",
            icon: "none",
            duration: 1e3
        });
    },
    Unable: function(t) {
        this.setData({
            selectionbar: !0,
            showModal: !0
        });
    },
    bindtap: function(t) {
        var e = this;
        console.log(t.currentTarget.dataset.ipid), e.setData({
            ipid: t.currentTarget.dataset.ipid
        });
    },
    exploit: function(t) {
        var e = this, o = e.data.logintag, n = e.data.nid;
        wx.request({
            url: a.data.url + "my_travel_chickbegin",
            data: {
                logintag: o,
                nid: n,
                ntype: 2
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                if (console.log("my_travel_chickbegin => 车主点击开始出行安钮操作"), console.log(t), "0000" == t.data.retCode) wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), e.onLoad(); else if (wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), "账号已冻结" == t.data.retDesc) return void wx.navigateTo({
                    url: "/pages/index/index"
                });
            }
        });
    },
    hideModal: function() {
        this.setData({
            showModal: !1,
            selectionbar: !1
        });
    },
    abolish: function(t) {
        this.setData({
            selectionbar: !1,
            showModal: !1
        });
    },
    iphone: function(t) {
        console.log(t), wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.mobile,
            success: function(t) {
                console.log(t);
            }
        });
    },
    refuse: function(t) {
        var e = this.data.logintag, o = t.currentTarget.dataset.nid;
        wx.request({
            url: a.data.url + "car_owner_click_notagree_op",
            data: {
                logintag: e,
                nid: o,
                ntype: 2
            },
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(t) {
                if (console.log("车主点击不同意操作"), console.log(t), "0000" == t.data.retCode) setTimeout(function() {
                    console.log("延迟调用 => 返回上一页"), wx.navigateBack({
                        delta: 1,
                        success: function(t) {
                            var e = getCurrentPages().pop();
                            void 0 != e && null != e && e.onLoad();
                        }
                    });
                }, 1e3), wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3,
                    mask: !0
                }); else if (wx.showToast({
                    title: t.data.retDesc,
                    icon: "none",
                    duration: 1e3
                }), "账号已冻结" == t.data.retDesc) return void wx.navigateTo({
                    url: "/pages/index/index"
                });
            }
        });
    },
    dj: function(t) {
        wx.showToast({
            title: "订单已冻结",
            icon: "none",
            duration: 1e3
        });
    }
}, t(o, "ts", function(t) {
    wx.showToast({
        title: "点击无效",
        icon: "none",
        duration: 1e3
    });
}), t(o, "consent", function(t) {
    var e = this.data.logintag, o = t.currentTarget.dataset.nid;
    wx.request({
        url: a.data.url + "car_owner_click_agree_op",
        data: {
            logintag: e,
            nid: o,
            ntype: 2
        },
        header: {
            "content-type": "application/x-www-form-urlencoded"
        },
        success: function(t) {
            if (console.log("车主点击同意操作"), console.log(t), "0000" == t.data.retCode) setTimeout(function() {
                console.log("延迟调用 => 返回上一页"), wx.navigateBack({
                    delta: 1,
                    success: function(t) {
                        var e = getCurrentPages().pop();
                        void 0 != e && null != e && e.onLoad();
                    }
                });
            }, 1e3), wx.showToast({
                title: t.data.retDesc,
                icon: "none",
                duration: 1e3,
                mask: !0
            }); else if (wx.showToast({
                title: t.data.retDesc,
                icon: "none",
                duration: 1e3
            }), "账号已冻结" == t.data.retDesc) return void wx.navigateTo({
                url: "/pages/index/index"
            });
        }
    });
}), t(o, "yes", function(t) {
    var e = this.data.nid;
    wx.setStorage({
        key: "imgid",
        data: e
    }), wx.setStorage({
        key: "xntype",
        data: 2
    }), wx.setStorage({
        key: "PD",
        data: 2
    }), wx.setStorage({
        key: "san",
        data: 3
    }), wx.navigateTo({
        url: "/pages/index/journey/Schedule/uploading/uploading"
    });
}), t(o, "onReady", function() {}), t(o, "onShow", function() {}), t(o, "onHide", function() {}), 
t(o, "onUnload", function() {}), t(o, "onPullDownRefresh", function() {}), t(o, "onReachBottom", function() {}), 
t(o, "onShareAppMessage", function() {}), o));