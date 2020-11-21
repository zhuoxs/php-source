var app = getApp();

Page({
    data: {
        tab: [ "已完成", "已取消/未完成" ],
        current: null,
        userInfo: {}
    },
    tab: function(t) {
        var e = this, a = t.currentTarget.dataset.index, n = wx.getStorageSync("openid");
        if (0 == a) app.util.request({
            url: "entry/wxapp/Selectord1",
            data: {
                openid: n
            },
            method: "POST",
            success: function(t) {
                console.log(t.data.data), e.setData({
                    selectord: t.data.data
                });
            }
        }); else {
            n = wx.getStorageSync("openid");
            app.util.request({
                url: "entry/wxapp/Selectord2",
                data: {
                    openid: n
                },
                success: function(t) {
                    console.log(t), e.setData({
                        selectord1: t.data.data
                    });
                }
            });
        }
        this.setData({
            current: t.currentTarget.dataset.index
        });
    },
    tab1: function(t) {
        var e = this, a = t.currentTarget.dataset.index, n = wx.getStorageSync("openid");
        a || app.util.request({
            url: "entry/wxapp/Selectord",
            data: {
                openid: n
            },
            success: function(t) {
                console.log(t.data.data), e.setData({
                    selectord: t.data.data
                });
            }
        }), this.setData({
            current: null
        });
    },
    onLoad: function(t) {
        var e = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: e
        });
        var a = this;
        wx.login({
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
        });
    },
    delOrder: function(t) {
        var e = t.currentTarget.dataset.index, a = this.data.selectord;
        a.splice(e, 1);
        var n = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Delorder",
            data: {
                zy_id: n
            },
            success: function(t) {
                wx.showToast({
                    title: "删除成功"
                });
            }
        }), this.setData({
            selectord: a
        });
    },
    onReady: function() {},
    onShow: function() {
        this.getlist();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    ddxqClick: function(t) {
        var e = t.currentTarget.dataset.id, a = t.currentTarget.dataset.time;
        app.util.request({
            url: "entry/wxapp/Dmoney",
            data: {
                id: e
            },
            success: function(t) {
                wx.navigateTo({
                    url: "../ddxq/ddxq?id=" + e + "&yytime=" + a
                });
            }
        });
    },
    getlist: function() {
        var e = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Selectord",
            data: {
                openid: t
            },
            success: function(t) {
                e.setData({
                    selectord: t.data.data
                });
            }
        });
    }
});