var WxParse = require("../../sudu8_page/resource/wxParse/wxParse.js"), app = getApp();

Page({
    data: {
        page_signs: "/sudu8_page/book/book",
        footer: {
            i_tel: app.globalData.i_tel,
            i_add: app.globalData.i_add,
            i_time: app.globalData.i_time
        },
        baseinfo: [],
        date_c: "",
        time_c: "",
        minHeight: 220,
        heighthave: 0,
        currentSwiper: 0
    },
    onPullDownRefresh: function() {
        this.getbaseinfo(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this;
        a.setData({
            isIphoneX: app.globalData.isIphoneX
        });
        var e = 0;
        t.fxsid && (e = t.fxsid, a.setData({
            fxsid: t.fxsid
        })), a.getbaseinfo(), app.util.getUserInfo(a.getinfos, e);
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    getinfos: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                });
            }
        });
    },
    getbaseinfo: function() {
        var l = this;
        app.util.request({
            url: "entry/wxapp/base",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(t) {
                l.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: l.data.baseinfo.base_tcolor,
                    backgroundColor: l.data.baseinfo.base_color
                });
            },
            fail: function(t) {}
        }), app.util.request({
            url: "entry/wxapp/FormsConfig",
            cachetime: "30",
            success: function(t) {
                var a = t.data.data, e = t.data.data.single_v, o = t.data.data.checkbox_v, n = t.data.data.s2.s2v, i = t.data.data.c2.c2v, s = new Array(), r = new Array(), d = new Array(), f = new Array();
                s = e ? e.split(",") : "无", r = n ? n.split(",") : "无", d = o ? o.split(",") : "无", 
                f = i ? i.split(",") : "无", "pic" == a.forms_head && l.setData({
                    forms_head_con: WxParse.wxParse("forms_head_con", "html", a.forms_head_con, l, 0)
                }), l.setData({
                    formsConfig: a,
                    single_v: s,
                    checkbox_v: d,
                    single_v2: r,
                    checkbox_v2: f
                }), wx.setNavigationBarTitle({
                    title: l.data.formsConfig.forms_name
                }), wx.setStorageSync("isShowLoading", !1), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
            }
        });
    },
    bindDateChange: function(t) {
        this.setData({
            date_c: t.detail.value
        });
    },
    bindTimeChange: function(t) {
        this.setData({
            time_c: t.detail.value
        });
    },
    formSubmit: function(t) {
        var a = this;
        if (0 == t.detail.value.name.length && 1 == a.data.formsConfig.name_must) return wx.showModal({
            title: "提示",
            content: "请输入" + a.data.formsConfig.name,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.tel_use && 0 == t.detail.value.tel.length && 1 == a.data.formsConfig.tel_must) return wx.showModal({
            title: "提示",
            content: "请输入" + a.data.formsConfig.tel,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.wechat_use && 0 == t.detail.value.wechat.length && 1 == a.data.formsConfig.wechat_must) return wx.showModal({
            title: "提示",
            content: "请输入" + a.data.formsConfig.wechat,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.address_use && 0 == t.detail.value.address.length && 1 == a.data.formsConfig.address_must) return wx.showModal({
            title: "提示",
            content: "请输入" + a.data.formsConfig.address,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.t5.t5u && 0 == t.detail.value.t5.length && 1 == a.data.formsConfig.t5.t5m) return wx.showModal({
            title: "提示",
            content: "请输入" + a.data.formsConfig.t5.t5n,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.t6.t6u && 0 == t.detail.value.t6.length && 1 == a.data.formsConfig.t6.t6m) return wx.showModal({
            title: "提示",
            content: "请输入" + a.data.formsConfig.t6.t6n,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.date_use && "" == t.detail.value.date && 1 == a.data.formsConfig.date_must) return wx.showModal({
            title: "提示",
            content: "请选择" + a.data.formsConfig.date,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.time_use && "" == t.detail.value.time && 1 == a.data.formsConfig.time_must) return wx.showModal({
            title: "提示",
            content: "请选择" + a.data.formsConfig.time,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.single_use && "" == t.detail.value.single && 1 == a.data.formsConfig.single_must) return wx.showModal({
            title: "提示",
            content: "请选择" + a.data.formsConfig.single_n,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.s2.s2u && "" == t.detail.value.s2 && 1 == a.data.formsConfig.s2.s2m) return wx.showModal({
            title: "提示",
            content: "请选择" + a.data.formsConfig.s2.s2n,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.checkbox_use) {
            if ("" == t.detail.value.checkbox && 1 == a.data.formsConfig.checkbox_must) return wx.showModal({
                title: "提示",
                content: "请选择" + a.data.formsConfig.checkbox_n,
                showCancel: !1
            }), !1;
            t.detail.value.checkbox = t.detail.value.checkbox.join(",");
        }
        if (1 == a.data.formsConfig.c2.c2u) {
            if ("" == t.detail.value.c2 && 1 == a.data.formsConfig.c2.c2m) return wx.showModal({
                title: "提示",
                content: "请选择" + a.data.formsConfig.c2.c2n,
                showCancel: !1
            }), !1;
            t.detail.value.c2 = t.detail.value.c2.join(",");
        }
        if (1 == a.data.formsConfig.content_use && 0 == t.detail.value.content.length && 1 == a.data.formsConfig.content_must) return wx.showModal({
            title: "提示",
            content: "请输入" + a.data.formsConfig.content_n,
            showCancel: !1
        }), !1;
        if (1 == a.data.formsConfig.con2.con2u && 0 == t.detail.value.con2.length && 1 == a.data.formsConfig.con2.con2m) return wx.showModal({
            title: "提示",
            content: "请输入" + a.data.formsConfig.con2.con2n,
            showCancel: !1
        }), !1;
        var e = t.detail.value, o = t.detail.formId;
        e.formid = o, e.openid = wx.getStorageSync("openid");
        var n = new Date(), i = n.getMonth() + 1 + "" + n.getDate() + (3600 * n.getHours() + 60 * n.getMinutes() + n.getSeconds()), s = wx.getStorageSync("mypretime");
        s ? i - s > a.data.formsConfig.subtime && wx.setStorage({
            key: "mypretime",
            data: i,
            success: function(t) {},
            fail: function(t) {}
        }) : wx.setStorage({
            key: "mypretime",
            data: i,
            success: function(t) {},
            fail: function(t) {}
        }), wx.showToast({
            title: "数据提交中...",
            icon: "loading",
            duration: 5e3
        }), app.util.request({
            url: "entry/wxapp/AddForms",
            cachetime: "30",
            data: e,
            success: function(t) {
                wx.showToast({
                    title: a.data.formsConfig.success,
                    icon: "success",
                    duration: 5e3,
                    success: function() {
                        setTimeout(function() {
                            wx.redirectTo({
                                url: "/sudu8_page/index/index"
                            });
                        }, 3e3);
                    }
                });
            },
            fail: function(t) {
                wx.showModal({
                    title: "提示",
                    content: "提交失败，请打电话联系商家！",
                    showCancel: !1
                });
            }
        });
    },
    swiperLoad: function(o) {
        var n = this;
        wx.getSystemInfo({
            success: function(t) {
                var a = o.detail.width / o.detail.height, e = t.windowWidth / a;
                n.data.heighthave || n.setData({
                    minHeight: e,
                    heighthave: 1
                });
            }
        });
    },
    makePhoneCall: function(t) {
        var a = this.data.baseinfo.tel;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    makePhoneCallB: function(t) {
        var a = this.data.baseinfo.tel_b;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    openMap: function(t) {
        wx.openLocation({
            latitude: parseFloat(this.data.baseinfo.latitude),
            longitude: parseFloat(this.data.baseinfo.longitude),
            name: this.data.baseinfo.name,
            address: this.data.baseinfo.address,
            scale: 22
        });
    },
    onShareAppMessage: function() {
        return {
            title: this.data.formsConfig.forms_name + "-" + this.data.baseinfo.name
        };
    },
    swiperChange: function(t) {
        this.setData({
            currentSwiper: t.detail.current
        });
    }
});