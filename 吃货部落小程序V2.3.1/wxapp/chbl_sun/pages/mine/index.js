var app = getApp();

Page({
    data: {
        hideSeller: !0,
        paySuccess: !0,
        hideRuzhu: !0,
        array: [ "一周", "一个月", "三个月", "半年", "一年" ],
        array1: [ "集卡" ],
        price: "",
        end: 1536397024e3
    },
    goRuzhu: function(e) {
        var t = this, a = wx.getStorageSync("openid");
        console.log(a), app.util.request({
            url: "entry/wxapp/isStoreIn",
            cachetime: "30",
            data: {
                openid: a
            },
            success: function(e) {
                console.log(e), 0 == e.data || "false" == e.data ? t.setData({
                    hideRuzhu: !1
                }) : wx.showToast({
                    title: "您已入驻，如需续费请进入管理入口！",
                    icon: "none"
                });
            }
        });
    },
    goGetYhq: function(e) {
        wx.navigateTo({
            url: "../getYhq/getYhq"
        });
    },
    onLoad: function(e) {
        this.setData({
            current: e.currentIndex
        });
        var t = wx.getStorageSync("tab"), a = wx.getStorageSync("url");
        console.log(wx.getStorageSync("openid")), this.setData({
            tab: t,
            url: a
        });
    },
    goTap: function(e) {
        console.log(e);
        var t = this;
        t.setData({
            current: e.currentTarget.dataset.index
        }), 0 == t.data.current && wx.redirectTo({
            url: "../first/index"
        }), 1 == t.data.current && wx.redirectTo({
            url: "../cheap/index?currentIndex=1"
        }), 2 == t.data.current && wx.redirectTo({
            url: "../eater-card/index?currentIndex=2"
        });
    },
    onShow: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(e) {
                console.log(e), t.setData({
                    rzxz: e.data
                });
            }
        });
        var a = wx.getStorageSync("user_info");
        app.util.request({
            url: "entry/wxapp/storeIn",
            cachetime: "30",
            success: function(e) {
                console.log(e.data.data), t.setData({
                    storein: e.data.data,
                    user_info: a
                });
            }
        }), console.log(a);
    },
    bindPickerChange1: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            index1: e.detail.value
        });
    },
    bindPickerChange: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            index: e.detail.value
        });
    },
    goAddressList: function(e) {
        wx.navigateTo({
            url: "../address-add/details"
        });
    },
    goMyOrderList: function(e) {
        wx.navigateTo({
            url: "../myOrder-list/index"
        });
    },
    goPrize: function(e) {
        wx.navigateTo({
            url: "../jika-prize/index"
        });
    },
    goManager: function(e) {
        var a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/isStoreIn",
            cacahetime: "30",
            data: {
                openid: a
            },
            success: function(e) {
                console.log(e);
                var t = e.data;
                t.user_id ? app.util.request({
                    url: "entry/wxapp/StoreInTimeOut",
                    cachetime: "0",
                    data: {
                        openid: a,
                        auth_type: t.auth_type
                    },
                    success: function(e) {
                        console.log(e), 1 == e.data.data && (wx.setStorageSync("auth_type", t.auth_type), 
                        wx.navigateTo({
                            url: "../manager/center/center?userid=" + t.user_id
                        }));
                    }
                }) : wx.showToast({
                    title: "该入口仅限入驻商家使用！",
                    icon: "none"
                });
            }
        });
    },
    goAddSeller: function(e) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(e) {
                console.log(e), 1 == e.data.sj_ruzhu ? wx.getStorage({
                    key: "openid",
                    success: function(e) {
                        var t = e.data;
                        app.util.request({
                            url: "entry/wxapp/isStore",
                            cachetime: "0",
                            data: {
                                openid: t
                            },
                            success: function(e) {
                                console.log(e), "0" == e.data.data.length ? (console.log("这是空的"), a.setData({
                                    hideRuzhu: !1
                                })) : wx.navigateTo({
                                    url: "../mine/usRuzhu"
                                });
                            }
                        });
                    }
                }) : wx.showToast({
                    title: "活动入驻尚未开启！",
                    icon: "none"
                });
            }
        });
    },
    applyFor: function(e) {
        wx.navigateTo({
            url: "../sjrz/sjrz"
        });
    },
    closePopupTap: function(e) {
        this.setData({
            hideSeller: !0,
            paySuccess: !0,
            hideRuzhu: !0
        });
    },
    bindSave: function(a) {
        this.closePopupTap(), console.log(a);
        var e;
        e = a.detail.target.dataset.price.split("￥"), console.log(e[1]);
        var n = e[1], o = a.detail.value.time_type;
        console.log(o);
        var i = this;
        wx.getStorage({
            key: "openid",
            success: function(e) {
                var t = e.data;
                app.util.request({
                    url: "entry/wxapp/orderarr",
                    cachetime: "0",
                    data: {
                        openid: t,
                        price: n
                    },
                    success: function(e) {
                        console.log(e), wx.requestPayment({
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
                                }), app.util.request({
                                    url: "entry/wxapp/addStore",
                                    cachetime: "0",
                                    data: {
                                        user_id: t,
                                        store_name: a.detail.value.store_name,
                                        tel: a.detail.value.tel,
                                        address: a.detail.value.address,
                                        active_type: a.detail.value.active_type,
                                        time_type: o
                                    },
                                    success: function(e) {
                                        console.log(e);
                                    }
                                }), i.setData({
                                    paySuccess: !1
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    releaseTap: function(e) {
        console.log(e), e.currentTarget.dataset.succ && wx.navigateTo({
            url: "../add-activity/index"
        });
    },
    goUsRuzhu: function(e) {
        wx.redirectTo({
            url: "../mine/usRuzhu"
        });
    },
    onReady: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});