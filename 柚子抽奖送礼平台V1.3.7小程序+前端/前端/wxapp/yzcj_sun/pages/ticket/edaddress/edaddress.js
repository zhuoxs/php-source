var Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page, app = getApp();

Page({
    data: {},
    onLoad: function(e) {
        var a = e.openid;
        wx.setStorageSync("openid", a);
    },
    address: function() {
        var a = this;
        wx.chooseAddress({
            success: function(e) {
                a.setData({
                    name: e.userName,
                    postalCode: e.postalCode,
                    provinceName: e.provinceName,
                    cityName: e.cityName,
                    countyName: e.countyName,
                    detailInfo: e.detailInfo,
                    nationalCode: e.nationalCode,
                    telNumber: e.telNumber
                });
            }
        });
    },
    saveAddress: function() {
        var e = this;
        if (e.data.name || e.data.address) {
            var a = wx.getStorageSync("users").openid, t = wx.getStorageSync("oid"), n = wx.getStorageSync("gid");
            app.util.request({
                url: "entry/wxapp/GetAddr",
                data: {
                    userName: e.data.name,
                    telNumber: e.data.telNumber,
                    postalCode: e.data.postalCode,
                    provinceName: e.data.provinceName,
                    cityName: e.data.cityName,
                    countyName: e.data.countyName,
                    detailInfo: e.data.detailInfo,
                    detailAddr: e.data.value,
                    openid: a,
                    oid: t,
                    gid: n
                },
                success: function(e) {
                    wx.navigateBack({
                        url: "../ticketresults/ticketresults"
                    });
                }
            });
        } else console.log(2);
    },
    bindKeyInput1: function(e) {
        this.setData({
            length1: e.detail.value.length
        }), console.log(this.data.length1);
    },
    bindKeyInput2: function(e) {
        this.setData({
            value: e.detail.value
        });
    },
    onShow: function(e) {
        var a = this, t = wx.getStorageSync("gid"), n = wx.getStorageSync("users").openid;
        app.util.request({
            url: "entry/wxapp/ShowAddr",
            data: {
                gid: t,
                openid: n
            },
            success: function(e) {
                console.log(e), "" != e.data && a.setData({
                    address: e.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});