var app = getApp();

Page({
    data: {
        currIdx: 1,
        select: 2
    },
    onLoad: function(t) {
        var e = this;
        this.setData({
            currIdx: t.currIdx
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
    },
    selectTab: function(t) {
        var e = t.currentTarget.dataset.index;
        this.setData({
            currIdx: e
        }), this.onShow();
    },
    toIndex: function(t) {
        wx.reLaunch({
            url: "/byjs_sun/pages/product/index/index"
        });
    },
    toActive: function(t) {
        wx.redirectTo({
            url: "/byjs_sun/pages/product/active/active"
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        console.log(e.data.currIdx);
        var t = wx.getStorageSync("users").id;
        app.util.request({
            url: "entry/wxapp/getMyActiveList",
            cachetime: "30",
            data: {
                currIdx: e.data.currIdx,
                uid: t
            },
            success: function(t) {
                console.log(t), e.setData({
                    list: t.data
                });
            }
        });
    },
    goActiveDet: function(t) {
        var e = t.currentTarget.dataset.id, a = wx.getStorageSync("users").id;
        app.util.request({
            url: "entry/wxapp/addLiu",
            cachetime: "0",
            data: {
                aid: e,
                uid: a
            },
            success: function(t) {
                wx.navigateTo({
                    url: "/byjs_sun/pages/product/activeDet/activeDet?aid=" + e
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});