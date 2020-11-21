var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        address: []
    },
    onLoad: function(e) {
        var a = e.gid;
        this.setData({
            gid: a
        });
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
    saveAddress: function(e) {
        var a = this, t = wx.getStorageSync("users").id, n = e.detail.formId;
        if (a.data.name) {
            var o = wx.getStorageSync("users").openid, d = a.data.gid;
            app.util.request({
                url: "entry/wxapp/GetAddr",
                data: {
                    userName: a.data.name,
                    telNumber: a.data.telNumber,
                    postalCode: a.data.postalCode,
                    provinceName: a.data.provinceName,
                    cityName: a.data.cityName,
                    countyName: a.data.countyName,
                    detailInfo: a.data.detailInfo,
                    detailAddr: a.data.detail,
                    openid: o,
                    gid: d
                },
                success: function(e) {
                    app.util.request({
                        url: "entry/wxapp/SaveFormid1",
                        data: {
                            openid: o,
                            user_id: t,
                            form_id: n,
                            gid: d,
                            state: 1
                        },
                        success: function(e) {
                            wx.navigateBack({
                                url: "../ticketresults/ticketresults"
                            });
                        }
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
            detail: e.detail.value
        });
    },
    onShow: function(e) {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});