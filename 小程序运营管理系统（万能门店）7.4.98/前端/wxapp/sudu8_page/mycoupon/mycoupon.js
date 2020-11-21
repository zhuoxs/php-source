var app = getApp();

Page({
    data: {
        page_signs: "/sudu8_page/mycoupon/mycoupon",
        couponlist: [],
        baseinfo: [],
        footer: {
            i_tel: app.globalData.i_tel,
            i_add: app.globalData.i_add,
            i_time: app.globalData.i_time,
            i_view: app.globalData.i_view,
            close: app.globalData.close,
            v_ico: app.globalData.v_ico
        },
        youhqid: 0,
        hxmm: "",
        showhx: 0
    },
    onPullDownRefresh: function() {
        this.getBase(), this.getList(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this, e = 0;
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
                kwd: "coupon",
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
                }), t.getList();
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
                }), wx.setNavigationBarTitle({
                    title: "我的优惠券"
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        });
    },
    getList: function(a) {
        var t = this, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/mycoupon",
            data: {
                openid: e,
                flag: 1
            },
            success: function(a) {
                t.setData({
                    couponlist: a.data.data
                }), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
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
    ycoupp: function() {
        wx.redirectTo({
            url: "/sudu8_page/coupon/coupon"
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
    hxmmInput: function(a) {
        this.setData({
            hxmm: a.detail.value
        });
    },
    hxmmpass: function() {
        var a = this.data.hxmm, t = this.data.youhqid;
        a ? app.util.request({
            url: "entry/wxapp/Hxyhq",
            data: {
                hxmm: a,
                youhqid: t
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                0 == a.data.data ? wx.showModal({
                    title: "提示",
                    content: "核销密码不正确！",
                    showCancel: !1
                }) : wx.showToast({
                    title: "成功",
                    icon: "success",
                    duration: 2e3,
                    success: function(a) {
                        wx.redirectTo({
                            url: "/sudu8_page/mycoupon/mycoupon"
                        });
                    }
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "核销密码必填！",
            showCancel: !1
        });
    },
    hxshow: function(a) {
        var t = a.currentTarget.id;
        this.setData({
            showhx: 1,
            youhqid: t
        });
    },
    hxhide: function() {
        this.setData({
            showhx: 0
        });
    }
});