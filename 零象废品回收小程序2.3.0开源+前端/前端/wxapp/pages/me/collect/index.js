var e = getApp();

Page({
    data: {},
    onLoad: function() {
        e.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "me.collect",
                uid: wx.getStorageSync("uid")
            },
            success: function(e) {}
        });
    },
    collect: function(e) {
        wx.navigateTo({
            url: "/pages/me/collectDetails/index?type=" + e.currentTarget.dataset.type
        });
    }
});