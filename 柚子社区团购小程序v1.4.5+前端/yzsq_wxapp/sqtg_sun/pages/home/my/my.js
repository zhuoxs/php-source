var Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page, app = getApp(), wxbarcode = require("../../../../zhy/resource/js/index.js");

Page({
    data: {
        spell: !1
    },
    onLoad: function(e) {},
    onShow: function() {
        var t = this;
        app.ajax({
            url: "Csystem|getSetting",
            success: function(e) {
                t.setData({
                    setting: e.data
                }), wx.setStorageSync("appConfig", e.data);
            }
        });
        var e = wx.getStorageSync("spell");
        this.setData({
            spell: e
        });
        var a = wx.getStorageSync("userInfo");
        a && 0 < a.id ? app.ajax({
            url: "Cuser|myInfo",
            data: {
                user_id: a.id
            },
            success: function(e) {
                console.log(e), t.setData({
                    show: !0,
                    info: e.data,
                    imgRoot: e.other.img_root,
                    user_id: a.id,
                    phoneGrant: !e.data.userinfo.tel
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(e) {
                if (e.confirm) {
                    var t = encodeURIComponent("/sqtg_sun/pages/home/my/my");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + t);
                } else e.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
        var n = wx.getStorageSync("linkaddress");
        n && this.setData({
            linkaddress: n
        }), app.api.getCartCount({
            user_id: a.id,
            leader_id: n.id
        }).then(function(e) {
            t.setData({
                cartCount: e
            });
        });
    },
    getPhoneNumber: function(a) {
        var n = this, s = wx.getStorageSync("open_id"), e = wx.getStorageSync("session_key");
        app.ajax({
            url: "Cwx|decrypt",
            data: {
                data: a.detail.encryptedData,
                iv: encodeURIComponent(a.detail.iv),
                key: e
            },
            success: function(e) {
                if (e.data || wx.login({
                    success: function(e) {
                        e.code && app.ajax({
                            url: "Cwx|getOpenid",
                            data: {
                                code: e.code
                            },
                            method: "GET",
                            success: function(e) {
                                wx.setStorageSync("session_key", e.data.session_key), wx.setStorageSync("open_id", e.data.openid), 
                                n.getPhoneNumber(a);
                            }
                        });
                    }
                }), e.data.phoneNumber) {
                    n.setData({
                        phoneGrant: !1
                    });
                    var t = {
                        openid: s,
                        tel: e.data.phoneNumber
                    };
                    app.ajax({
                        url: "Cuser|login",
                        data: t,
                        success: function(e) {
                            e.code ? app.tips(e.msg) : (wx.setStorageSync("userInfo", e.data), n.setData({
                                phoneGrant: !1
                            }), app.lunchTo("/sqtg_sun/pages/home/my/my"));
                        }
                    });
                } else app.tips("未检测到微信绑定的手机号，请自己填写"), n.setData({
                    phoneGrant: !1
                }), setTimeout(function() {
                    app.navTo("/sqtg_sun/pages/zkx/pages/setphonenum/setphonenum?id=my");
                }, 1500);
            }
        });
    },
    loadCode: function(e) {
        app.ajax({
            url: "Cuser|getUserCode",
            data: {
                user_id: e
            },
            success: function(e) {
                wxbarcode.qrcode("qrcode", "code-" + e.data, 300, 300);
            }
        });
    },
    qrcode: function() {
        var e = wx.getStorageSync("userInfo");
        this.setData({
            qrcode: !0
        }), this.loadCode(e.id);
    },
    close: function() {
        this.setData({
            qrcode: !1
        });
    },
    toSetphonenum: function() {
        this.setData({
            phoneGrant: !1
        }), setTimeout(function() {
            app.navTo("/sqtg_sun/pages/zkx/pages/setphonenum/setphonenum?id=my");
        }, 300);
    },
    distribution: function() {
        this.data.info;
        app.navTo("/sqtg_sun/pages/plugin/distribution/distributioncenter/distributioncenter");
    }
});