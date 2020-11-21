var e = require("../../../utils/base.js"), a = require("../../../../api.js"), t = new e.Base(), i = getApp();

Page({
    data: {
        region: [],
        add: -1,
        Location: !1,
        openAuth: !1
    },
    onLoad: function(e) {
        if (this.data.add = e.add, 0 == e.add) {
            var a = [];
            a.push(e.province, e.city, e.country), this.setData({
                name: e.name,
                detail: e.detail,
                phone: e.phone,
                region: a,
                id: e.id
            });
        }
    },
    onShow: function() {
        this.userLocation();
    },
    Modal_cancel: function(e) {
        this.setData({
            Location: !this.data.Location,
            openAuth: !0
        });
    },
    userLocation: function(e) {
        var a = this;
        wx.getSetting({
            success: function(e) {
                e.authSetting["scope.address"] ? a.setData({
                    Location: !1,
                    openAuth: !1
                }) : wx.authorize({
                    scope: "scope.address",
                    success: function(e) {},
                    fail: function(e) {
                        i.getUserLocation("scope.address", function(e) {
                            a.data.Location = !e, a.setData({
                                Location: a.data.Location,
                                openAuth: a.data.Location
                            });
                        });
                    }
                });
            }
        });
    },
    bindRegionChange: function(e) {
        var a = [];
        a = e.detail.value[0] == e.detail.value[1] ? [ "", e.detail.value[1], e.detail.value[2] ] : e.detail.value, 
        this.setData({
            region: a
        });
    },
    wechatAddress: function(e) {
        var a = this, t = [];
        wx.chooseAddress({
            success: function(e) {
                e.provinceName == e.cityName ? t.push("", e.cityName, e.countyName) : t.push(e.provinceName, e.cityName, e.countyName), 
                a.setData({
                    name: e.userName,
                    provinceName: e.provinceName,
                    cityName: e.cityName,
                    countyName: e.countyName,
                    detail: e.detailInfo,
                    phone: e.telNumber,
                    region: t
                });
            }
        });
    },
    inputPhone: function(e) {
        var a = this, i = e.detail.value;
        t.checkPhone(i, function(e) {
            e ? a.setData({
                phone: i
            }) : wx.showToast({
                title: "请输入正确手机号码",
                icon: "none",
                duration: 2e3
            });
        });
    },
    formSubmit: function(e) {
        var a = this;
        e.detail.value.region[0] == e.detail.value.region[1] && (e.detail.value.region = [ "", e.detail.value.region[1], e.detail.value.region[2] ]);
        var i = e.detail.value.region[0] + e.detail.value.region[1] + e.detail.value.region[2] + e.detail.value.detail, n = {};
        t.geocoder(i, function(t) {
            n = 347 == t.status ? {
                lat: "",
                lng: ""
            } : {
                lat: t.result.location.lat,
                lng: t.result.location.lng
            }, 1 == a.data.add ? a.add(e, n) : a.edit(e, n);
        });
    },
    add: function(e, i) {
        var n = {
            url: a.default.add_address,
            data: {
                name: e.detail.value.name,
                phone: e.detail.value.phone,
                province: e.detail.value.region[0] || "",
                city: e.detail.value.region[1],
                country: e.detail.value.region[2],
                detail: e.detail.value.detail,
                longitude: i.lng,
                latitude: i.lat
            }
        };
        t.getData(n, function(e) {
            wx.showModal({
                title: e.msg,
                showCancel: !1,
                success: function(a) {
                    a.confirm && 1 == e.errorCode && wx.navigateBack({
                        delta: 1
                    });
                }
            });
        });
    },
    edit: function(e, i) {
        var n = {
            url: a.default.edit_address,
            data: {
                addressId: this.data.id,
                name: e.detail.value.name,
                phone: e.detail.value.phone,
                province: e.detail.value.region[0] || "",
                city: e.detail.value.region[1],
                country: e.detail.value.region[2],
                detail: e.detail.value.detail,
                longitude: i.lng,
                latitude: i.lat
            }
        };
        t.getData(n, function(e) {
            wx.showModal({
                title: e.msg,
                showCancel: !1,
                success: function(a) {
                    a.confirm && 1 == e.errorCode && wx.navigateBack({
                        delta: 1
                    });
                }
            });
        });
    }
});