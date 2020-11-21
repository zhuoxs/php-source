var app = getApp(), util = require("../../../resource/utils/util.js");

Page({
    data: {
        list: [],
        navIndex: 0
    },
    onLoad: function(t) {
        var e = this, n = t.navIndex, a = t.id, o = t.Bespoketid;
        e.setData({
            navIndex: n,
            id: a,
            Bespoketid: o
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    changeIndex: function(t) {
        var e = t.currentTarget.dataset.index;
        this.setData({
            navIndex: e
        });
    },
    onShow: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/SeeAppointmentAdmin",
            data: {
                id: e.data.id,
                Bespoketid: e.data.Bespoketid
            },
            success: function(t) {
                e.setData({
                    list: t.data.noSure,
                    list1: t.data.Sure
                }), console.log(e.data.list);
            }
        });
    },
    callphone: function(t) {
        var e = t.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: e,
            success: function() {
                console.log("拨打电话成功！");
            },
            fail: function() {
                console.log("拨打电话失败！");
            }
        });
    },
    goSure: function(t) {
        var e = this, n = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/changeAppointmentAdmin",
            data: {
                id: n,
                Bespoketid: e.data.Bespoketid
            },
            success: function(t) {
                e.onShow();
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});