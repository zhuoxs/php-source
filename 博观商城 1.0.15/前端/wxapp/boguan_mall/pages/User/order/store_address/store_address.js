var t = require("../../../../utils/base.js"), a = require("../../../../../api.js"), e = new t.Base();

Page({
    data: {
        openCity: !1,
        focus: !1
    },
    onShow: function() {
        var t = wx.getStorageSync("pickAddress");
        t && (this.setData({
            cityName: t.city.name,
            addressName: t.city.name
        }), this.pickSearch(t.city.name)), this.getUserCity();
    },
    getCity: function(t) {
        this.setData({
            openCity: !this.data.openCity
        }), this.allAddress();
    },
    getUserCity: function() {
        var t = this;
        e.getUserCity(function(a) {
            console.log("获取用户城市=>", a), a && (wx.setStorageSync("cityInfo", a), t.setData({
                cityName: a.city,
                addressName: a.city
            }), t.pickSearch(a.city));
        });
    },
    authorize: function(t) {
        var a = this;
        wx.getSetting({
            success: function(t) {
                1 == t.authSetting["scope.userLocation"] && wx.authorize({
                    scope: "scope.userLocation",
                    success: function() {
                        e.getUserCity(function(t) {
                            wx.setStorageSync("cityInfo", t), t && a.setData({
                                cityName: t.city
                            });
                        });
                    }
                });
            }
        });
    },
    pickSearch: function(t) {
        var i = this, s = {
            url: a.default.pickcity_search,
            data: {
                keyword: t
            },
            method: "GET"
        };
        e.getData(s, function(t) {
            console.log("检索城市", t), 1 == t.errorCode && (i.setData({
                cityId: t.data[0].id
            }), i.pickList(t.data[0].id));
        });
    },
    pickList: function(t) {
        var i = this, s = {
            url: a.default.pickpoint_list,
            data: {
                cityId: t
            }
        };
        e.getData(s, function(t) {
            if (console.log("自提点=>", t), 1 == t.errorCode) {
                i.setData({
                    addressList: t.data.data
                });
                var a = wx.getStorageSync("pickAddress");
                for (var e in t.data.data) t.data.data[e].id == a.id && i.setData({
                    pickId: t.data.data[e].id
                });
            } else i.setData({
                addressList: []
            });
        });
    },
    searchCity: function(t) {
        var i = this, s = {
            url: a.default.pickcity_search,
            data: {
                keyword: t.detail.value
            },
            method: "GET"
        };
        e.getData(s, function(t) {
            1 == t.errorCode && i.setData({
                searchList: t.data
            });
        });
    },
    getFocus: function(t) {
        this.setData({
            focus: !0
        });
    },
    searchClose: function(t) {
        this.setData({
            focus: !1,
            keyword: "",
            searchList: []
        });
    },
    selectCity: function(t) {
        var a = t.currentTarget.dataset.id, e = t.currentTarget.dataset.city;
        this.pickList(a), this.setData({
            focus: !1,
            openCity: !this.data.openCity,
            searchList: [],
            cityName: e,
            addressName: e
        });
    },
    allAddress: function() {
        var t = this, i = {
            url: a.default.pickcity_list,
            method: "GET"
        };
        e.getData(i, function(a) {
            console.log("所有地址=>", a);
            var e = [];
            if (1 == a.errorCode) {
                for (var i in a.data) 1 == a.data[i].have_pick && e.push(a.data[i]);
                console.log("allAddressList=>", e), t.setData({
                    allAddress: e
                });
            }
        });
    },
    nowCity: function(t) {
        var a = t.currentTarget.dataset.addressname;
        this.pickSearch(a), this.setData({
            openCity: !this.data.openCity,
            searchList: [],
            cityName: a
        });
    },
    tabswicth: function(t) {
        var a = t.currentTarget.dataset.index, e = getCurrentPages(), i = e[e.length - 2], s = {};
        this.setData({
            pickId: t.currentTarget.dataset.id
        }), i.data.daydata = s, i.setData({
            daydata: s
        }), wx.navigateBack({
            delta: 1
        }), wx.setStorage({
            key: "pickAddress",
            data: this.data.addressList[a]
        });
    }
});