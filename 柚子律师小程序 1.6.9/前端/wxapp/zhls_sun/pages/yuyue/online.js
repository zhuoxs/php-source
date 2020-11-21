var util = require("../../resource/js/utils/util.js"), app = getApp();

Page({
    data: {
        sex: [ "先生", "女士" ],
        currentSelect: 0
    },
    bindSave: function(t) {
        var e = t.detail.value.contents, n = t.detail.value.date, a = t.detail.value.datetime, o = t.detail.value.linkMan, i = t.detail.value.phone;
        if (0 == this.data.currentSelect) var c = o + "先生"; else c = o + "女士";
        console.log(c);
        var l = n + " " + a;
        "" != e ? "" != i ? " " != l ? "" != o ? wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/Appointment",
                    cachetime: "0",
                    data: {
                        openid: t.data,
                        content: e,
                        phone: i,
                        time: l,
                        gender: c
                    },
                    success: function(t) {
                        1 == t.data && wx.showModal({
                            title: "提示",
                            content: "提交成功！",
                            showCancel: !1,
                            success: function(t) {
                                wx.navigateBack({});
                            }
                        });
                    }
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "您的称呼！",
            showCancel: !1
        }) : wx.showModal({
            title: "提示",
            content: "请选择时间！",
            showCancel: !1
        }) : wx.showModal({
            title: "提示",
            content: "请输入您的手机号！",
            showCancel: !1
        }) : wx.showModal({
            title: "提示",
            content: "请输入您遇到的法律问题！",
            showCancel: !1
        });
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var e = util.formatTime(new Date());
        this.setData({
            time: e
        });
        this.data.time;
    },
    selectSex: function(t) {
        console.log(t), this.setData({
            currentSelect: t.currentTarget.dataset.index
        });
    },
    bindDateChange: function(t) {
        var e = t.detail.value;
        this.setData({
            valData: e
        });
    },
    bindTimeChange: function(t) {
        var e = t.detail.value;
        this.setData({
            timData: e
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});