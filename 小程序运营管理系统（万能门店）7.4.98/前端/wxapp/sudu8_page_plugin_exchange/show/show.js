var WxParse = require("../../sudu8_page/resource/wxParse/wxParse.js"), app = getApp();

Page({
    data: {
        id: "",
        sc: 0,
        bg: "",
        minHeight: 220,
        datas: "",
        content: "",
        jhsl: 1,
        dprice: "",
        yhje: 0,
        hjjg: "",
        sfje: "",
        order: "",
        my_num: "",
        xg_num: "",
        shengyu: "",
        userInfo: "",
        num: [],
        xz_num: [],
        proinfo: "",
        heighthave: 0,
        currentSwiper: 0
    },
    onPullDownRefresh: function() {
        this.getinfos(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var e = this, a = t.id;
        e.setData({
            id: a
        });
        var n = 0;
        t.fxsid && (n = t.fxsid, e.setData({
            fxsid: t.fxsid
        }));
        var i = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: i,
            data: {
                vs1: 1
            },
            success: function(t) {
                t.data.data;
                e.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: e.data.baseinfo.base_tcolor,
                    backgroundColor: e.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(e.getinfos, n);
    },
    redirectto: function(t) {
        var e = t.currentTarget.dataset.link, a = t.currentTarget.dataset.linktype;
        app.util.redirectto(e, a);
    },
    getinfos: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                });
                var e = a.data.id;
                a.getShowPic(e);
            }
        });
    },
    collect: function(t) {
        var n = this, e = (t.currentTarget.dataset.name, wx.getStorageSync("openid"), app.util.url("entry/wxapp/Collect", {
            m: "sudu8_page"
        }));
        wx.request({
            url: e,
            data: {
                openid: n.data.openid,
                types: "exchange",
                id: n.data.id
            },
            header: {
                "content-type": "application/json"
            },
            success: function(t) {
                var e = t.data.data, a = n.data.datas;
                a.collectcount = "收藏成功" == e ? 1 : 0, n.setData({
                    datas: a
                }), wx.showToast({
                    title: e,
                    icon: "succes",
                    duration: 1e3,
                    mask: !0
                });
            }
        });
    },
    makePhoneCall: function(t) {
        var e = this.data.baseinfo.tel;
        wx.makePhoneCall({
            phoneNumber: e
        });
    },
    getShowPic: function(t) {
        var e = this;
        wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/scoreinfo",
            data: {
                id: t,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                e.setData({
                    datas: t.data.data,
                    content: WxParse.wxParse("content", "html", t.data.data.product_txt, e, 5)
                }), wx.setNavigationBarTitle({
                    title: t.data.data.title
                }), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
            }
        });
    },
    save_before: function(t) {
        this.checkvip(), this.setData({
            formId: t.detail.formId
        });
    },
    checkvip: function() {
        var e = this, t = wx.getStorageSync("openid");
        wx.request({
            url: app.util.url("entry/wxapp/checkvip", {
                m: "sudu8_page"
            }),
            data: {
                kwd: "exchange",
                openid: t
            },
            success: function(t) {
                t.data.data ? e.save() : (e.setData({
                    needvip: !0
                }), wx.showModal({
                    title: "进入失败",
                    content: "使用本功能需先开通vip!",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.redirectTo({
                            url: "/sudu8_page/register/register"
                        });
                    }
                }));
            },
            fail: function(t) {}
        });
    },
    save: function(t) {
        var e = this, a = (e.data.jhsl, wx.getStorageSync("openid")), n = e.data.id;
        wx.showModal({
            title: "提示",
            content: "确定兑换此商品吗？",
            success: function(t) {
                if (t.confirm) app.util.request({
                    url: "entry/wxapp/Scoreorder",
                    data: {
                        openid: a,
                        id: n,
                        formId: e.data.formId
                    },
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(t) {
                        var e = t.data.data;
                        0 == e.flag ? wx.showModal({
                            title: "提醒",
                            content: e.msg,
                            showCancel: !1
                        }) : wx.showToast({
                            title: "兑换成功",
                            icon: "success",
                            duration: 1e3,
                            success: function() {
                                setTimeout(function() {
                                    wx.redirectTo({
                                        url: "/sudu8_page_plugin_exchange/order/order"
                                    });
                                }, 1e3);
                            }
                        });
                    }
                }); else if (t.cancel) ;
            }
        });
    },
    tabChange: function(t) {
        var e = t.currentTarget.dataset.id;
        this.setData({
            nowcon: e
        });
    },
    swiperLoad: function(n) {
        var i = this;
        wx.getSystemInfo({
            success: function(t) {
                var e = n.detail.width / n.detail.height, a = t.windowWidth / e;
                i.data.heighthave || i.setData({
                    minHeight: a,
                    heighthave: 1
                });
            }
        });
    },
    onShareAppMessage: function() {
        return {
            title: this.data.title
        };
    },
    swiperChange: function(t) {
        this.setData({
            currentSwiper: t.detail.current
        });
    }
});