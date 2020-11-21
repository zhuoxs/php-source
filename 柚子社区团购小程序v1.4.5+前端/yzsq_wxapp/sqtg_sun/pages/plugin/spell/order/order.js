function _defineProperty(a, e, t) {
    return e in a ? Object.defineProperty(a, e, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[e] = t, a;
}

var app = getApp();

Page({
    data: {
        payType: [ {
            name: "微信支付",
            pic: "../../../../../zhy/resource/images/wx.png"
        }, {
            name: "余额支付",
            pic: "../../../../../zhy/resource/images/local.png"
        } ],
        curPay: 1,
        expressType: [],
        expressChoose: 1,
        expressInfo: !1,
        shopChoose: 0,
        remark: "",
        sending: !1,
        alert: !1,
        shops: [],
        tabId: 1,
        phoneGrant: !1
    },
    onLoad: function(a) {
        var t = this, e = wx.getStorageSync("linkaddress");
        e && this.setData({
            linkaddress: e
        });
        var s = JSON.parse(a.id);
        s.name = e.name, s.phone = e.tel, console.log(s), this.setData({
            param: s,
            expressChoose: s.sincetype
        }), 1 == this.data.param.sincetype ? this.setData({
            expressType: [ {
                name: "快递",
                value: 1,
                checked: "true"
            } ]
        }) : 2 == this.data.param.sincetype && this.setData({
            expressType: [ {
                name: "门店自提",
                value: 2,
                checked: "true"
            } ]
        }), app.ajax({
            url: "Csystem|getSetting",
            success: function(a) {
                var e = (a.data.delivery_type - 0) % 2 + 1;
                t.setData({
                    setting: a.data
                }), t.data.param.sincetype = 1 == e ? 2 : 1, 1 == t.data.param.delivery_single && (t.data.param.sincetype = 1, 
                e = 2), t.setData({
                    tabId: e
                }), wx.setStorageSync("appConfig", a.data), t.onLoadData();
            }
        });
    },
    onShow: function() {
        this.onLoadData();
    },
    onLoadData: function() {
        var t = this, a = getCurrentPages();
        a[a.length - 2].setData({
            refresh: !0
        });
        var e = wx.getStorageSync("userInfo");
        if (e) {
            var s = wx.getStorageSync("expressInfo");
            if (e.tel || (console.log("没手机号"), this.setData({
                phoneGrant: !0
            })), s && this.setData({
                expressInfo: s,
                uName: s.userName,
                uPhone: s.telNumber
            }), 1 == t.data.param.sincetype) t.checkFee(); else if (2 == t.data.param.sincetype) {
                var n = 0;
                2 == t.data.param.ordertype ? (n = (t.data.param.money * t.data.param.num).toFixed(2), 
                t.data.param.coupon_money = 0) : 1 == t.data.param.ordertype && (0 < t.data.param.heads_id ? (n = (t.data.param.money * t.data.param.num).toFixed(2), 
                t.data.param.coupon_money = 0) : n = (t.data.param.money * t.data.param.num - t.data.param.coupon_money).toFixed(2)), 
                t.setData(_defineProperty({}, "param.order_amount", n));
            }
            this.setData({
                show: !0
            });
        } else wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(a) {
                if (a.confirm) {
                    var e = encodeURIComponent("/sqtg_sun/pages/yxl/pages/integraldetail/integraldetail?id=" + t.data.param.goods_id);
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + e);
                } else a.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    checkFee: function() {
        var a, e = 0, t = this.data.param.delivery_fee;
        2 == this.data.tabId ? 2 == this.data.param.ordertype ? e = (t - 0 + this.data.param.money * this.data.param.num).toFixed(2) : 1 == this.data.param.ordertype && (e = 0 < this.data.param.heads_id ? (t - 0 + this.data.param.money * this.data.param.num).toFixed(2) : (t - 0 + this.data.param.money * this.data.param.num - this.data.param.coupon_money).toFixed(2)) : 1 == this.data.tabId && (2 == this.data.param.ordertype ? e = (this.data.param.money * this.data.param.num).toFixed(2) : 1 == this.data.param.ordertype && (e = 0 < this.data.param.heads_id ? (this.data.param.money * this.data.param.num).toFixed(2) : (this.data.param.money * this.data.param.num - this.data.param.coupon_money).toFixed(2))), 
        this.setData((_defineProperty(a = {
            fee: t
        }, "param.distribution", t), _defineProperty(a, "param.order_amount", e), _defineProperty(a, "param.province", this.data.expressInfo.provinceName), 
        _defineProperty(a, "param.city", this.data.expressInfo.cityName), _defineProperty(a, "param.area", this.data.expressInfo.countyName), 
        _defineProperty(a, "param.address", this.data.expressInfo.detailInfo), _defineProperty(a, "param.leader_id", this.data.linkaddress.id), 
        _defineProperty(a, "param.name", this.data.expressInfo.userName), _defineProperty(a, "param.phone", this.data.expressInfo.telNumber), 
        _defineProperty(a, "param.fee", t), a));
    },
    expressChange: function(a) {},
    bindPickerChange: function(a) {
        this.setData(_defineProperty({
            shopChoose: a.detail.value
        }, "param.shop_id", this.data.shops[a.detail.value].id));
    },
    getUName: function(a) {
        this.setData({
            uName: a.detail.value
        });
    },
    getUPhone: function(a) {
        this.setData({
            uPhone: a.detail.value
        });
    },
    getRemark: function(a) {
        this.setData(_defineProperty({
            remark: a.detail.value
        }, "param.remark", a.detail.value));
    },
    GPSMap: function() {
        var a = this.data.shops[this.data.shopChoose].latitude - 0, e = this.data.shops[this.data.shopChoose].longitude - 0;
        wx.openLocation({
            latitude: a,
            longitude: e,
            scale: 28
        });
    },
    onBuyTab: function(a) {
        var e = this, t = wx.getStorageSync("userInfo");
        console.log(a), app.ajax({
            url: "Index|addFormid",
            data: {
                user_id: t.id,
                form_id: a.detail.formId
            },
            success: function(a) {
                console.log(a);
            }
        });
        var s = this.data.param;
        s.leader_id = this.data.linkaddress.id;
        wx.getStorageSync("userinfo");
        if (2 == this.data.param.sincetype && (s.name = this.data.linkaddress.name, s.phone = this.data.linkaddress.tel), 
        1 == this.data.param.sincetype) {
            if (!this.data.param.city) return void app.tips("请选择收货地址！");
        } else if (2 == this.data.param.sincetype) {
            if (!s.name || s.name.length < 1) return console.log(s.name), void app.tips("请输入正确的收货人姓名！");
            if (!s.phone || s.phone.length < 11) return void app.tips("请输入正确的联系电话！");
        }
        this.data.sending || (this.setData({
            sending: !0
        }), 0 < this.data.param.heads_id ? app.api.getCpinJoinGroup(s).then(function(a) {
            console.log(s), app.reTo("/sqtg_sun/pages/plugin/spell/orderinfo/orderinfo?id=" + a.data.oid);
        }).catch(function(a) {
            e.setData({
                sending: !1
            }), a.code, app.tips(a.msg);
        }) : app.api.getCpinGetBuy(s).then(function(a) {
            console.log(s), app.reTo("/sqtg_sun/pages/plugin/spell/orderinfo/orderinfo?id=" + a.data.oid);
        }).catch(function(a) {
            e.setData({
                sending: !1
            }), a.code, app.tips(a.msg);
        }));
    },
    onSelfMention: function(a) {
        this.setData(_defineProperty({
            tabId: a.currentTarget.dataset.tabid
        }, "param.sincetype", 2)), this.checkFee(), console.log(this.data.param.sincetype);
    },
    onDelivery: function(a) {
        this.setData(_defineProperty({
            tabId: a.currentTarget.dataset.tabid
        }, "param.sincetype", 1)), this.checkFee(), console.log(this.data.param.sincetype);
    },
    getPhoneNumber: function(t) {
        var s = this, n = wx.getStorageSync("open_id"), a = wx.getStorageSync("session_key");
        app.ajax({
            url: "Cwx|decrypt",
            data: {
                data: t.detail.encryptedData,
                iv: encodeURIComponent(t.detail.iv),
                key: a
            },
            success: function(a) {
                if (a.data || wx.login({
                    success: function(a) {
                        a.code && app.ajax({
                            url: "Cwx|getOpenid",
                            data: {
                                code: a.code
                            },
                            method: "GET",
                            success: function(a) {
                                wx.setStorageSync("session_key", a.data.session_key), wx.setStorageSync("open_id", a.data.openid), 
                                s.getPhoneNumber(t);
                            }
                        });
                    }
                }), a.data.phoneNumber) {
                    s.setData({
                        phoneGrant: !1
                    });
                    var e = {
                        openid: n,
                        tel: a.data.phoneNumber
                    };
                    app.ajax({
                        url: "Cuser|login",
                        data: e,
                        success: function(a) {
                            a.code ? app.tips(a.msg) : (wx.setStorageSync("userInfo", a.data), s.setData({
                                phoneGrant: !1
                            }));
                        }
                    });
                } else app.tips("未检测到微信绑定的手机号，请自己填写"), s.setData({
                    phoneGrant: !1
                }), setTimeout(function() {
                    app.navTo("/sqtg_sun/pages/zkx/pages/setphonenum/setphonenum?id=classfiyorder");
                }, 1500);
            }
        });
    },
    toSetphonenum: function() {
        this.setData({
            phoneGrant: !1
        }), setTimeout(function() {
            app.navTo("/sqtg_sun/pages/zkx/pages/setphonenum/setphonenum?id=classfiyorder");
        }, 300);
    }
});