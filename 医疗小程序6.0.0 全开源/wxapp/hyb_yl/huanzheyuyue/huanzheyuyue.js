var app = getApp();

Page({
    data: {
        tab: [ "已完成", "未完成" ],
        current: null,
        userInfo: {}
    },
    tab: function(t) {
        var e = this, a = e.data.id, n = t.currentTarget.dataset.index;
        console.log(n);
        wx.getStorageSync("openid");
        0 == n ? app.util.request({
            url: "entry/wxapp/Selectdoctor2",
            data: {
                id: a
            },
            success: function(t) {
                e.setData({
                    selectdoctor2: t.data.data
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/Selectdoctor1",
            data: {
                id: a
            },
            success: function(t) {
                e.setData({
                    selectdoctor1: t.data.data
                });
            }
        }), this.setData({
            current: t.currentTarget.dataset.index
        });
    },
    tab1: function(t) {
        var e = this, a = (t.currentTarget.dataset.index, e.data.id);
        app.util.request({
            url: "entry/wxapp/Selectdoctororder",
            data: {
                id: a
            },
            success: function(t) {
                console.log(t), e.setData({
                    selectdoctororder: t.data.data
                });
            }
        }), this.setData({
            current: null
        });
    },
    onLoad: function(t) {
        var a = this, e = t.id;
        a.setData({
            id: e
        }), wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(t) {
                        var e = t.userInfo;
                        a.setData({
                            userInfo: e
                        });
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Selectdoctororder",
            data: {
                id: e
            },
            success: function(t) {
                a.setData({
                    selectdoctororder: t.data.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    ddxqClick: function(t) {
        var e = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Dmoney",
            data: {
                id: e
            },
            success: function(t) {
                console.log(t), wx.navigateTo({
                    url: "../ddxq/ddxq?id=" + e
                });
            }
        });
    },
    look_detail: function(t) {
        wx.navigateTo({
            url: "../patient_detail2/patient_detail2"
        });
    }
});