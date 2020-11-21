var app = getApp();

Page({
    data: {
        page_signs: "/sudu8_page/recharge/recharge",
        baseinfo: [],
        userInfo: "",
        searchtitle: "",
        footer: {
            i_tel: app.globalData.i_tel,
            i_add: app.globalData.i_add,
            i_time: app.globalData.i_time,
            i_view: app.globalData.i_view,
            close: app.globalData.close,
            v_ico: app.globalData.v_ico
        },
        scopes: !1,
        money: 0,
        guiz: "",
        a: 1
    },
    onPullDownRefresh: function() {
        this.getinfos(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        wx.setNavigationBarTitle({
            title: "账户充值"
        });
        var t = this;
        t.setData({
            isIphoneX: app.globalData.isIphoneX
        });
        var e = 0;
        a.fxsid && (e = a.fxsid, t.setData({
            fxsid: a.fxsid
        })), t.checkvip(), t.getBase(), app.util.getUserInfo(t.getinfos, e);
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    checkvip: function() {
        var t = this, a = wx.getStorageSync("openid");
        wx.request({
            url: app.util.url("entry/wxapp/checkvip", {
                m: "sudu8_page"
            }),
            data: {
                kwd: "recharge",
                openid: a
            },
            success: function(a) {
                a.data.data || (t.setData({
                    needvip: !0
                }), wx.showModal({
                    title: "进入失败",
                    content: "使用本功能需先开通vip!",
                    showCancel: !1,
                    success: function(a) {
                        a.confirm && wx.redirectTo({
                            url: "/sudu8_page/register/register"
                        });
                    }
                }));
            },
            fail: function(a) {}
        });
    },
    getinfos: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                t.setData({
                    openid: a.data
                }), t.getGuiz();
            }
        });
    },
    getBase: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        });
    },
    getGuiz: function() {
        var e = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Guiz",
            data: {
                openid: a
            },
            success: function(a) {
                var t = a.data.data.list;
                e.setData({
                    guiz: a.data.data,
                    gz: t[0] ? t[0].id : 0,
                    money: t[0] ? t[0].money : 0
                });
            },
            fail: function(a) {}
        });
    },
    makePhoneCall: function(a) {
        var t = this.data.baseinfo.tel;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    makePhoneCallB: function(a) {
        var t = this.data.baseinfo.tel_b;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    openMap: function(a) {
        var t = this;
        wx.openLocation({
            latitude: parseFloat(t.data.baseinfo.latitude),
            longitude: parseFloat(t.data.baseinfo.longitude),
            name: t.data.baseinfo.name,
            address: t.data.baseinfo.address,
            scale: 22
        });
    },
    setmoney: function(a) {
        var t = a.detail.value;
        this.setData({
            money: t
        });
    },
    setsubmit: function() {
        var t = this, a = t.data.money, e = wx.getStorageSync("openid"), n = !0;
        if (a <= 0) return wx.showModal({
            title: "提醒",
            content: "请输入正确的充值金额！",
            showCancel: !1
        }), n = !1;
        n && app.util.request({
            url: "entry/wxapp/Balance",
            data: {
                openid: e,
                money: a
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                t.setData({
                    order_id: a.data.data.order_id
                }), "success" == a.data.message && wx.requestPayment({
                    timeStamp: a.data.data.timeStamp,
                    nonceStr: a.data.data.nonceStr,
                    package: a.data.data.package,
                    signType: "MD5",
                    paySign: a.data.data.paySign,
                    success: function(a) {
                        wx.showToast({
                            title: "支付成功",
                            icon: "success",
                            duration: 3e3,
                            success: function(a) {
                                t.dosetmoney();
                            }
                        });
                    },
                    fail: function(a) {},
                    complete: function(a) {}
                }), "error" == a.data.message && wx.showModal({
                    title: "提醒",
                    content: a.data.data.message,
                    showCancel: !1
                });
            }
        });
    },
    dosetmoney: function() {
        var a = this.data.order_id, t = this.data.money, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Pay_cz",
            data: {
                openid: e,
                money: t,
                order_id: a,
                gz: 0 == this.data.a ? 0 : this.data.gz
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                wx.redirectTo({
                    url: "/sudu8_page/usercenter/usercenter"
                });
            }
        });
    },
    choose_cz: function(a) {
        var t = a.currentTarget.dataset.id;
        this.data.gz = a.currentTarget.dataset.gz;
        var e = this.data.guiz;
        if (0 == t) this.setData({
            a: t,
            money: 0
        }); else {
            t--;
            var n = e.list[t].money;
            t++, this.setData({
                a: t,
                money: n
            });
        }
    }
});