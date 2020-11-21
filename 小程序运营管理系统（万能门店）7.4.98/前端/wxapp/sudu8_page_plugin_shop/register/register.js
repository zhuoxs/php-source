var _manage_shopModel = require("../manage_shop/manage_shop-model.js"), WxParse = require("../../sudu8_page/resource/wxParse/wxParse.js"), app = getApp(), upload = new _manage_shopModel.manageShop();

Page({
    data: {
        page_signs: "/sudu8_page_plugin_shop/register/register",
        baseurl: app.globalData.baseurl,
        imgUrls: [],
        indicatorDots: !1,
        autoplay: !1,
        interval: 5e3,
        duration: 1e3,
        check: 0,
        avatar: "",
        nickname: "",
        slide: "",
        catename: "请选择所属分类",
        apply_success: !1,
        logo_ok: [],
        textarea: 1,
        textcon: ""
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this;
        t.setData({
            isIphoneX: app.globalData.isIphoneX
        });
        var e = wx.getStorageSync("mlogin");
        this.data.id = e, t.setData({
            id: e
        }), wx.setNavigationBarTitle({
            title: "商户注册"
        }), t.getBase(), wx.getSystemInfo({
            success: function(a) {
                t.setData({
                    h: a.windowHeight
                });
            }
        }), t.getslide_m(), wx.getStorageSync("openid") ? t.is_apply() : t.getopenid();
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getBase: function() {
        var t = this, a = app.util.url("entry/wxapp/Base", {
            m: "sudu8_page"
        });
        wx.request({
            url: a,
            data: {
                vs1: 1
            },
            success: function(a) {
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                }), wx.setNavigationBarTitle({
                    title: "入驻商城"
                });
            }
        });
    },
    textinput: function(a) {
        var t = a.detail.value;
        this.setData({
            textcon: t
        });
    },
    getslide_m: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/getslide_m",
            success: function(a) {
                a.data.data.protocol && WxParse.wxParse("content", "html", a.data.data.protocol, t, 5), 
                t.setData({
                    system_name: a.data.data.system_name,
                    slide: a.data.data.bg,
                    category: a.data.data.category
                });
            }
        });
    },
    is_apply: function() {
        app.util.request({
            url: "entry/wxapp/LoginS",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                0 < a.data.data && (wx.setStorageSync("mlogin", a.data.data), app.util.request({
                    url: "entry/wxapp/is_apply",
                    data: {
                        openid: wx.getStorageSync("openid"),
                        id: wx.getStorageSync("mlogin")
                    },
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/is_apply",
                            data: {
                                openid: wx.getStorageSync("openid"),
                                id: wx.getStorageSync("mlogin")
                            },
                            success: function(a) {
                                1 == a.data.data.is_apply && wx.showModal({
                                    title: "提示",
                                    showCancel: !1,
                                    content: "您已提交申请，请等待管理员审核",
                                    success: function(a) {
                                        wx.redirectTo({
                                            url: "/sudu8_page/index/index"
                                        });
                                    }
                                }), 2 == a.data.data.is_apply && wx.redirectTo({
                                    url: "/sudu8_page_plugin_shop/manage_index/manage_index"
                                }), 3 == a.data.data.is_apply && wx.showModal({
                                    title: "提示",
                                    showCancel: !1,
                                    content: "您的申请未通过，请重新申请！"
                                });
                            }
                        });
                    }
                }));
            }
        });
    },
    onShareAppMessage: function() {},
    check_change: function() {
        var a = this;
        0 == a.data.check ? a.setData({
            check: 1
        }) : a.setData({
            check: 0
        });
    },
    xieyi_close: function() {
        this.setData({
            xieyi_block: 0,
            textarea: 1
        });
    },
    xieyi_hidden: function() {
        this.setData({
            xieyi_block: 1,
            check: 0,
            textarea: 0
        });
    },
    chooselogo: function(a) {
        var t = a.currentTarget.dataset.type, e = this;
        wx.chooseImage({
            count: 1,
            sizeType: [ "compressed", "original" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                upload._uploadImg(a.tempFilePaths, function(a) {
                    e.data.logo_ok = a, "yyzz" == t ? e.setData({
                        yyzz: e.data.logo_ok
                    }) : "logo" == t && e.setData({
                        logo: e.data.logo_ok
                    });
                });
            }
        });
    },
    formSubmit: function(a) {
        var t = this, e = a.detail.formId, o = a.detail.value;
        if (o.logo = t.data.logo_ok, 0 == t.data.check) return wx.showToast({
            title: "请先阅读协议",
            icon: "none"
        }), !1;
        if ("" == o.password) return wx.showModal({
            title: "提示",
            content: "请输入密码",
            showCancel: !1
        }), !1;
        if ("" == o.cid) return wx.showModal({
            title: "提示",
            content: "请选择分类",
            showCancel: !1
        }), !1;
        if ("" == o.name) return wx.showModal({
            title: "提示",
            content: "请输入商户名称",
            showCancel: !1
        }), !1;
        if ("" == o.logo) return wx.showModal({
            title: "提示",
            content: "请上传商户logo",
            showCancel: !1
        }), !1;
        o.openid = wx.getStorageSync("openid"), o.cid = t.data.cid, o.formID = e;
        app.util.url("entry/wxapp/", {
            m: "sudu8_page_plugin_shop"
        });
        app.util.request({
            url: "entry/wxapp/shopApply",
            data: {
                formdata: JSON.stringify(o)
            },
            method: "POST",
            header: {
                "content-type": "application/x-www-form-urlencoded"
            },
            success: function(a) {
                2 == a.data.data ? wx.showModal({
                    title: "提示",
                    content: "账号已被注册，请修改提交！",
                    showCancel: !1
                }) : wx.showToast({
                    title: "申请成功",
                    icon: "success",
                    duration: 2e3,
                    success: function() {
                        wx.redirectTo({
                            url: "/sudu8_page/index/index"
                        });
                    }
                });
            }
        });
    },
    bindPickerChange: function(a) {
        var t = a.detail.value;
        this.setData({
            cid: this.data.category[t].id,
            catename: this.data.category[t].name
        });
    },
    getLatlong: function() {
        var t = this;
        wx.chooseLocation({
            success: function(a) {
                t.setData({
                    latlong: Math.floor(1e6 * a.latitude) / 1e6 + "," + Math.floor(1e6 * a.longitude) / 1e6
                });
            }
        });
    }
});