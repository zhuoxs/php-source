var app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        var e = this;
        wx.getStorage({
            key: "url",
            success: function(t) {
                e.setData({
                    url: t.data
                });
            }
        }), e.diyWinColor();
    },
    bindInputTap: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Storeuser",
            cachetime: "0",
            data: {
                uid: t.detail.value
            },
            success: function(t) {
                console.log(t), e.setData({
                    searchedInfo: t.data.data
                });
            }
        });
    },
    bindAddMember: function(t) {
        var e = this, o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/AddStoreuser",
            cachetime: "0",
            data: {
                uid: e.data.searchedInfo.id,
                openid: o
            },
            success: function(t) {
                console.log(t), t.errno ? wx.showToast({
                    title: t.message
                }) : wx.showToast({
                    title: "添加成功"
                }), setTimeout(function(t) {
                    e.onShow();
                }, 1e3);
            }
        });
    },
    bindDelMember: function(t) {
        var e = this, o = t.currentTarget.dataset.uid;
        wx.showModal({
            title: "提示",
            content: "确定删除该核销员？",
            success: function(t) {
                t.confirm ? (console.log("用户点击确定"), app.util.request({
                    url: "entry/wxapp/DelStoreuser",
                    cachetime: "0",
                    data: {
                        uid: o
                    },
                    success: function(t) {
                        console.log(t), 1 == t.data.data ? wx.showToast({
                            title: "删除成功"
                        }) : wx.showToast({
                            title: "删除失败",
                            icon: "none"
                        }), setTimeout(function(t) {
                            e.onShow();
                        }, 1e3);
                    }
                })) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/GetStoreuser",
            cachetime: "0",
            data: {
                openid: t
            },
            success: function(t) {
                console.log(t), e.setData({
                    hadAddUser: t.data.data
                });
            }
        });
    },
    diyWinColor: function(t) {
        var e = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: e.color,
            backgroundColor: e.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: "添加核销员"
        });
    }
});