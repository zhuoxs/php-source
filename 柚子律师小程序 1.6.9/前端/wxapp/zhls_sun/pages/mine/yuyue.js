var app = getApp();

Page({
    data: {
        reasonList: [ "重复预约", "问题已解决", "预约已过期", "其他原因" ],
        hideShopPopup: !0,
        cancle: !0
    },
    onLoad: function(t) {
        var n = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.getStorage({
            key: "openid",
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/AppointmentData",
                    cachetime: "0",
                    data: {
                        openid: t.data
                    },
                    success: function(t) {
                        console.log(t.data), n.setData({
                            mentData: t.data
                        });
                    }
                });
            }
        });
    },
    onShow: function() {
        this.getUserInfo();
    },
    getUserInfo: function() {
        var n = this;
        wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(t) {
                        console.log(t), n.setData({
                            userInfo: t.userInfo
                        });
                    }
                });
            }
        });
    },
    cancleBtn: function(t) {
        console.log(t);
        this.setData({
            yuid: t.currentTarget.dataset.id
        }), this.bindReasonTap();
    },
    closePopupTap: function(t) {
        this.setData({
            hideShopPopup: !0
        });
    },
    bindReasonTap: function(t) {
        this.setData({
            hideShopPopup: !1
        });
    },
    selectReason: function(t) {
        console.log(t), this.setData({
            currentSel: t.currentTarget.dataset.index,
            question: t.currentTarget.dataset.reason
        });
    },
    pushTab: function(t) {
        var n = this;
        if (0 <= n.data.currentSel) {
            var o = n.data.question, e = n.data.yuid;
            app.util.request({
                url: "entry/wxapp/Cancel",
                cachetime: "0",
                data: {
                    question: o,
                    id: e
                },
                success: function(t) {
                    wx.showToast({
                        title: "您成功取消预约",
                        icon: "success",
                        duration: 2e3
                    }), n.setData({
                        hideShopPopup: !0
                    }), n.onLoad();
                }
            });
        } else wx.showToast({
            title: "您还没选择取消原因",
            icon: "none",
            duration: 2e3
        });
    },
    onReady: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});