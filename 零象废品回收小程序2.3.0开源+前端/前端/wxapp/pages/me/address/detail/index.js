var e, t = getApp(), a = require("../../../../utils/qqmap-wx-jssdk.min.js");

Page({
    data: {
        province: "",
        city: "",
        district: "",
        latitude: "",
        longitude: ""
    },
    onLoad: function(i) {
        var d = this;
        console.log(i), i.id && t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "address.addressDetail",
                uid: wx.getStorageSync("uid"),
                id: i.id
            },
            method: "get",
            success: function(e) {
                d.setData({
                    detail: e.data.data
                });
            }
        }), e = new a({
            key: "HEQBZ-R6TWR-3YHWF-WJACM-ZH6LE-3SFB6"
        }), wx.getLocation({
            type: "wgs84",
            success: function(e) {
                d.getCity(e.latitude, e.longitude);
            }
        });
    },
    getPhoneNumber: function(e) {
        var a = this;
        t.util.getUserInfo(function(e) {}), e.detail.iv && t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "home.userphone",
                iv: e.detail.iv,
                encryptedData: e.detail.encryptedData
            },
            success: function(e) {
                a.setData({
                    phone: e.data.data
                }), console.log(e);
            }
        });
    },
    getCity: function(t, a) {
        var i = this;
        e.reverseGeocoder({
            location: {
                latitude: t,
                longitude: a
            },
            success: function(e) {
                var e = e.result;
                i.setData({
                    province: e.address_component.province,
                    city: e.address_component.city,
                    district: e.address_component.district
                });
            },
            fail: function(e) {
                console.error(e);
            }
        });
    },
    tomap: function() {
        var t = this;
        wx.authorize({
            scope: "scope.userLocation",
            success: function(i) {
                wx.chooseLocation({
                    success: function(i) {
                        t.setData({
                            latitude: i.latitude,
                            longitude: i.longitude,
                            address: i.address
                        }), e = new a({
                            key: "HEQBZ-R6TWR-3YHWF-WJACM-ZH6LE-3SFB6"
                        });
                        var d = i.latitude, s = i.longitude;
                        t.getCity(d, s);
                    },
                    fail: function() {
                        wx.getSetting({
                            success: function(e) {
                                e.authSetting["scope.userLocation"] || wx.showModal({
                                    content: "请允许获取地理位置后再次尝试",
                                    success: function(e) {
                                        e.confirm ? wx.openSetting({
                                            success: function(e) {
                                                e.authSetting = {
                                                    "scope.userInfo": !0,
                                                    "scope.userLocation": !0
                                                };
                                            },
                                            fail: function(e) {
                                                console.log(e);
                                            }
                                        }) : e.cancel && console.log("用户点击取消");
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    formSubmit: function(e) {
        var a = this;
        console.log(e), "" != e.detail.value.phone && "undefined" != e.detail.value.phone ? "" != e.detail.value.name && "undefined" != e.detail.value.name ? /^1[3456789]\d{9}$/.test(e.detail.value.phone) ? "" != e.detail.value.address && "undefined" != e.detail.address ? "" != e.detail.value.address_detail && "undefined" != e.detail.address_detail ? t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "address.create",
                name: e.detail.value.name,
                phone: e.detail.value.phone,
                address_detail: e.detail.value.address_detail,
                address: e.detail.value.address,
                default: e.detail.value.default ? 1 : 0,
                latitude: a.data.latitude ? a.data.latitude : a.data.detail.latitude,
                longitude: a.data.longitude ? a.data.longitude : a.data.detail.longitude,
                province: a.data.province,
                uid: wx.getStorageSync("uid"),
                city: a.data.city,
                district: a.data.district,
                id: a.data.detail ? a.data.detail.id : ""
            },
            method: "post",
            success: function(e) {
                wx.showModal({
                    title: "",
                    content: "保存成功",
                    success: function(e) {
                        console.log(e), e.confirm && wx.navigateBack({
                            delta: 1
                        });
                    }
                });
            }
        }) : t.util.message({
            title: "请填写服务详细地址",
            type: "error"
        }) : t.util.message({
            title: "请填写服务地址",
            type: "error"
        }) : t.util.message({
            title: "请检查手机格式",
            type: "error"
        }) : t.util.message({
            title: "请填写联系人",
            type: "error"
        }) : t.util.message({
            title: "请填写联系方式",
            type: "error"
        });
    }
});