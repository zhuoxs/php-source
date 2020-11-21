var _Page;

function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var app = getApp();

Page((_defineProperty(_Page = {
    data: {
        navTile: "我的",
        showJoin: !0,
        activateCode: !1,
        code: "",
        region: [ "", "", "" ],
        is_admin: 2,
        isRequest: 0,
        showModalStatus: !0,
        imgUrls: [ "../../../style/images/wave.png", "../../../style/images/wave.png" ]
    },
    onLoad: function(e) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        wx.getStorageSync("setting");
        app.get_setting(!0).then(function(e) {
            wx.setNavigationBarColor({
                frontColor: e.fontcolor,
                backgroundColor: e.color
            }), a.setData({
                store_open: e.store_open
            });
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 1
            },
            showLoading: !1,
            success: function(e) {
                var t = 2 != e.data && e.data;
                a.setData({
                    open_distribution: t
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 2
            },
            showLoading: !1,
            success: function(e) {
                var t = 2 != e.data && e.data;
                a.setData({
                    open_scoretask: t
                });
            }
        });
    },
    toScoretask: function(e) {
        wx.navigateTo({
            url: "/pages/plugin/shoppingMall/home/home"
        });
    },
    toFxCenter: function(e) {
        var n = e.detail.formId;
        this.data.open_distribution;
        app.get_user_info().then(function(e) {
            var t = e.openid, a = e;
            wx.setStorageSync("users", a), app.util.request({
                url: "entry/wxapp/IsPromoter",
                data: {
                    openid: t,
                    form_id: n,
                    uid: a.id,
                    status: 3,
                    m: app.globalData.Plugin_distribution
                },
                showLoading: !1,
                success: function(e) {
                    e && 9 != e.data ? 0 == e.data ? wx.navigateTo({
                        url: "/yzqzk_sun/plugin/distribution/fxAddShare/fxAddShare"
                    }) : wx.navigateTo({
                        url: "/yzqzk_sun/plugin/distribution/fxCenter/fxCenter"
                    }) : wx.navigateTo({
                        url: "/yzqzk_sun/plugin/distribution/fxAddShare/fxAddShare"
                    });
                }
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this, e = wx.getStorageSync("user") || [];
        t.setData({
            user: e
        }), console.log(e), app.util.request({
            url: "entry/wxapp/getStorelimit",
            cachetime: "0",
            success: function(e) {
                t.setData({
                    storeEnter: e.data
                });
            }
        }), app.get_openid().then(function(e) {
            app.util.request({
                url: "entry/wxapp/is_hx_openid",
                cachetime: "0",
                data: {
                    openid: e
                },
                success: function(e) {
                    console.log(e.data.errcode), t.setData({
                        is_admin: e.data.errcode,
                        shopMsg: e.data.errmsg
                    });
                }
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bindRegionChange: function(e) {
        console.log("省市区"), console.log(e), this.setData({
            region: e.detail.value
        });
    },
    toBaby: function(e) {
        wx.navigateTo({
            url: "../baby/baby"
        });
    },
    toMyorder: function(e) {
        var t = e.currentTarget.dataset.sign;
        wx.navigateTo({
            url: "myorder/myorder?sign=" + t
        });
    }
}, "toBaby", function(e) {
    wx.navigateTo({
        url: "baby/baby"
    });
}), _defineProperty(_Page, "toCoupon", function(e) {
    wx.navigateTo({
        url: "coupon/coupon"
    });
}), _defineProperty(_Page, "toBackstage", function(e) {
    console.log(this.data.shopMsg), 1 == this.data.is_admin ? wx.navigateTo({
        url: "../backstage/index/index"
    }) : 2 == this.data.is_admin && wx.navigateTo({
        url: "../backstage/index2/index2?id=" + this.data.shopMsg.id + "&shopname=" + this.data.shopMsg.store_name
    });
}), _defineProperty(_Page, "showModel", function(e) {
    this.setData({
        showJoin: !this.data.showJoin
    });
}), _defineProperty(_Page, "showCardModel", function(e) {
    this.setData({
        activateCode: !this.data.activateCode
    });
}), _defineProperty(_Page, "jfMember", function(e) {
    var t = this, a = e.detail.value.code, n = e.detail.value.uname, o = e.detail.value.phone, i = e.detail.value.address, s = e.detail.value.addressdet, d = "", r = !0;
    "" == a ? d = "请输入激活码" : "" == n ? d = "请输入您的姓名" : /^1(3|4|5|7|8|9)\d{9}$/.test(o) ? "" == i ? d = "请选择地址" : "" == s ? d = "请输入详细地址" : (r = !1, 
    app.get_openid().then(function(e) {
        t.setData({
            isRequest: ++t.data.isRequest
        }), 1 == t.data.isRequest ? app.util.request({
            url: "entry/wxapp/useActivationCode",
            cachetime: "0",
            data: {
                openid: e,
                code: a,
                names: n,
                phone: o,
                addresss: i,
                address_detail: s
            },
            success: function(e) {
                wx.showModal({
                    title: "提示",
                    content: "激活成功",
                    showCancel: !1,
                    success: function(e) {
                        t.setData({
                            activateCode: !t.data.activateCode
                        });
                    }
                });
            },
            fail: function(e) {
                wx.showModal({
                    title: "提示",
                    content: e.data.message,
                    showCancel: !1,
                    success: function(e) {
                        t.setData({
                            activateCode: !t.data.activateCode
                        });
                    }
                });
            },
            complete: function() {
                t.setData({
                    isRequest: 0
                });
            }
        }) : wx.showToast({
            title: "正在请求中...",
            icon: "none"
        });
    })) : d = "请正确输入手机号码", 1 == r && wx.showToast({
        title: d,
        icon: "none"
    });
}), _defineProperty(_Page, "updateUserInfo", function(e) {
    var t = wx.getStorageSync("user") || [];
    this.setData({
        user: t
    });
}), _defineProperty(_Page, "bindPickerChange", function(e) {
    this.setData({
        index: e.detail.value
    });
}), _defineProperty(_Page, "formSubmit", function(e) {
    var t = this, a = e.detail.formId, n = e.detail.value.shopname, o = e.detail.value.phone, i = e.detail.value.address, s = "", d = !0;
    "" == n ? s = "请输入您的姓名" : /^1(3|4|5|7|8)\d{9}$/.test(o) ? "" == i ? s = "请输入地址" : null == t.data.index ? s = "请选择入驻时间" : (d = !1, 
    app.get_openid().then(function(e) {
        t.setData({
            isRequest: ++t.data.isRequest
        }), 1 == t.data.isRequest ? app.util.request({
            url: "entry/wxapp/setStore",
            cachetime: "0",
            data: {
                openid: e,
                store_name: n,
                tel: o,
                address: i,
                storelimit_id: t.data.storeEnter[t.data.index].id,
                formId: a
            },
            success: function(e) {
                app.util.request({
                    url: "entry/wxapp/getPayParam",
                    cachetime: "0",
                    data: {
                        order_id: e.data
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
                                    title: "提示",
                                    content: "支付成功",
                                    showCancel: !1,
                                    confirmColor: "#ff5e5e",
                                    success: function(e) {
                                        t.setData({
                                            showJoin: !t.data.showJoin
                                        });
                                    }
                                });
                            },
                            fail: function(e) {
                                wx.showModal({
                                    title: "提示",
                                    content: "支付失败",
                                    confirmColor: "#ff5e5e",
                                    success: function(e) {}
                                });
                            }
                        });
                    }
                });
            },
            fail: function(e) {
                wx.showModal({
                    title: "提示",
                    content: e.data.message,
                    showCancel: !1,
                    success: function(e) {
                        t.setData({
                            showJoin: !t.data.showJoin
                        });
                    }
                });
            },
            complete: function() {
                t.setData({
                    isRequest: 0
                });
            }
        }) : wx.showToast({
            title: "正在请求中...",
            icon: "none"
        });
    })) : s = "请正确输入手机号码", 1 == d && wx.showToast({
        title: s,
        icon: "none"
    });
}), _Page));