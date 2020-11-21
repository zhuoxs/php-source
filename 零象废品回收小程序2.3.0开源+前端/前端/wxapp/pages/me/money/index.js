var t = getApp();

Page({
    data: {
        info: []
    },
    onLoad: function(a) {
        var e = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "me.collect",
                uid: wx.getStorageSync("uid")
            },
            success: function(t) {
                e.setData({
                    info: t.data.data
                });
            }
        });
    },
    onShow: function() {
        var a = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "me.collect",
                uid: wx.getStorageSync("uid")
            },
            success: function(t) {
                a.setData({
                    info: t.data.data
                });
            }
        });
    },
    take: function() {
        "" == this.data.info.name || void 0 == this.data.info.name || "" == this.data.info.phone || void 0 == this.data.info.phone ? wx.showModal({
            title: "您还没认证个人信息，请先认证",
            content: "",
            success: function(t) {
                t.confirm && wx.navigateTo({
                    url: "/pages/me/set/index"
                });
            }
        }) : wx.navigateTo({
            url: "/pages/me/take/index"
        });
    },
    takelog: function() {
        wx.navigateTo({
            url: "/pages/me/takelog/index"
        });
    }
});