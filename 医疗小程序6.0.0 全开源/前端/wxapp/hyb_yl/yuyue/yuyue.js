var _Page;

function _defineProperty(e, a, t) {
    return a in e ? Object.defineProperty(e, a, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[a] = t, e;
}

var app = getApp();

Page((_defineProperty(_Page = {
    data: {
        array1: [],
        array2: [],
        doctor: [],
        monery: [],
        doctorId: [],
        onlyId: null,
        monerynum: "",
        indexx: null,
        date: "2017-12-14",
        array: [],
        yiyuan: [],
        radioIndex: 1,
        ids: []
    },
    bindPickerChange1: function(e) {
        var a = this, t = e.detail.value, o = a.data.ids[t];
        console.log(e), app.util.request({
            url: "entry/wxapp/Jdoctor",
            data: {
                id: o
            },
            success: function(e) {
                console.log(e), a.setData({
                    jdoctor: e.data.data,
                    array2: e.data.data.z_name,
                    monery: e.data.data.z_yy_money,
                    doctorId: e.data.data.id
                });
            },
            fail: function(e) {
                console.log(e);
            }
        }), a.setData({
            index: e.detail.value
        });
    },
    bindPickerChange2: function(e) {
        var a = this, t = e.detail.value, o = a.data.monery, n = a.data.doctorId;
        a.setData({
            indexx: t,
            monerynum: o[t],
            onlyId: n[t]
        });
    },
    bindPickerChange: function(e) {
        this.setData({
            index: e.detail.value
        });
    },
    radio: function(e) {
        console.log(e);
        var a = e.detail.value;
        this.setData({
            radioIndex: e.detail.value,
            ky_sex: a
        });
    },
    submit: function(e) {
        e.detail.value;
        wx.request({
            url: ".php"
        });
    },
    onLoad: function(e) {
        var a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        });
        var t = wx.getStorageSync("openid");
        this.setData({
            openid: t
        });
    },
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), setTimeout(function() {
            wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
        }, 1e3);
    },
    onReady: function() {
        this.getKeshi(), this.getBase(), this.getHdoctor();
    },
    getBase: function() {
        var a = this;
        console.log(app), app.util.request({
            url: "entry/wxapp/Base",
            success: function(e) {
                a.setData({
                    baseinfo: e.data.data
                });
            },
            fail: function(e) {
                console.log(e);
            }
        });
    },
    getKeshi: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Keshi",
            cachetime: "30",
            success: function(e) {
                a.setData({
                    array1: e.data.data.k_name,
                    ids: e.data.data.k_id
                });
            },
            fail: function(e) {
                console.log(e);
            }
        });
    },
    getHdoctor: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Hdoctor",
            cachetime: "30",
            success: function(e) {
                a.setData({
                    hdoctor: e.data.data,
                    array2: e.data.data.k_name,
                    money: e.data.data.k_yuymoney
                });
            },
            fail: function(e) {
                console.log(e);
            }
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {}
}, "onPullDownRefresh", function() {}), _defineProperty(_Page, "onReachBottom", function() {}), 
_defineProperty(_Page, "onShareAppMessage", function() {}), _defineProperty(_Page, "formSubmit", function(t) {
    var o = this.data.onlyId;
    console.log(o);
    var e = t.detail.value.ky_docmoney, a = t.detail.value, n = a.ky_name, i = (a.k_name, 
    wx.getStorageSync("openid")), l = a.ky_telphone, c = a.ky_time_1, d = a.ky_doctor, r = a.ky_docmoney, s = a.ky_sex;
    if (0 == t.detail.value.ky_name.length || 0 == t.detail.value.ky_telphone.length) return wx.showModal({
        content: "姓名和手机号不能为空"
    }), !1;
    if (0 == t.detail.value.k_name.length) return wx.showModal({
        content: "请选择就诊科室"
    }), !1;
    if (0 == t.detail.value.ky_doctor.length) return wx.showModal({
        content: "请选择就诊医生"
    }), !1;
    if (0 < e) {
        console.log("收费");
        i = wx.getStorageSync("openid");
        return app.util.request({
            url: "entry/wxapp/Pay",
            cachetime: "0",
            header: {
                "Content-Type": "application/xml"
            },
            method: "GET",
            data: {
                openid: i,
                z_tw_money: e
            },
            success: function(e) {
                console.log(e), wx.requestPayment({
                    timeStamp: e.data.timeStamp,
                    nonceStr: e.data.nonceStr,
                    package: e.data.package,
                    signType: e.data.signType,
                    paySign: e.data.paySign,
                    success: function(e) {
                        console.log(e);
                        var a = t.detail.value.k_name;
                        app.util.request({
                            url: "entry/wxapp/Keshiyuyue",
                            data: {
                                ky_name: n,
                                ky_openid: i,
                                ky_sex: s,
                                ky_zhenzhuang: o,
                                ky_telphone: l,
                                ky_time_1: c,
                                ky_doctor: d,
                                ky_docmoney: r,
                                k_name: a
                            },
                            header: {
                                "Content-Type": "application/json"
                            },
                            success: function(e) {
                                console.log(e.data), 1 == e.data.code ? wx.showToast({
                                    title: "提交失败"
                                }) : wx.showModal({
                                    title: "提交成功",
                                    content: "",
                                    success: function(e) {
                                        e.confirm ? (console.log("用户点击确定"), wx.redirectTo({
                                            url: "../index/index"
                                        })) : e.cancel && console.log("用户点击取消");
                                    }
                                });
                            },
                            fail: function(e) {
                                console.log(e);
                            }
                        });
                    }
                });
            },
            fail: function(e) {
                console.log(e);
            }
        }), !1;
    }
    wx.showModal({
        title: "提示",
        content: " 确认提交么？ ",
        success: function(e) {
            if (e.confirm) {
                console.log("用户点击确定");
                var a = t.detail.value.k_name;
                app.util.request({
                    url: "entry/wxapp/Keshiyuyue",
                    data: {
                        ky_name: n,
                        ky_openid: i,
                        ky_sex: s,
                        ky_zhenzhuang: o,
                        ky_telphone: l,
                        ky_time_1: c,
                        ky_doctor: d,
                        ky_docmoney: r,
                        k_name: a
                    },
                    header: {
                        "Content-Type": "application/json"
                    },
                    success: function(e) {
                        1 == e.data.code ? wx.showToast({
                            title: "提交失败"
                        }) : wx.showModal({
                            title: "提交成功",
                            content: "",
                            success: function(e) {
                                console.log(e), e.confirm ? (console.log("用户点击确定"), wx.redirectTo({
                                    url: "../index/index"
                                })) : e.cancel && console.log("用户点击取消");
                            }
                        });
                    },
                    fail: function(e) {
                        console.log(e);
                    }
                });
            } else e.cancel && console.log("用户点击取消");
        }
    });
}), _Page));