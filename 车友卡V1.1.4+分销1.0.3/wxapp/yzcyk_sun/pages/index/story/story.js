var app = getApp();

Page({
    data: {
        story: {},
        imgroot: wx.getStorageSync("imgroot")
    },
    onLoad: function(t) {
        var n = this, o = wx.getStorageSync("setting");
        o ? wx.setNavigationBarColor({
            frontColor: o.fontcolor,
            backgroundColor: o.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        }), app.get_imgroot().then(function(o) {
            app.get_album(t.id, !0).then(function(t) {
                wx.setNavigationBarTitle({
                    title: t.title
                }), n.setData({
                    imgroot: o,
                    story: t
                });
            });
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toStorydet: function(t) {
        var o = t.currentTarget.dataset.id, n = t.currentTarget.dataset.flink, e = t.currentTarget.dataset.vip;
        console.log(e);
        var r = n || this.data.imgroot + t.currentTarget.dataset.src, a = t.currentTarget.dataset.index;
        1 == e ? app.get_user_vip().then(function(t) {
            0 == t ? wx.showModal({
                content: "您还不是会员喔~",
                confirmText: "开通会员",
                confirmColor: "#ff5e5e",
                success: function(t) {
                    t.confirm && wx.navigateTo({
                        url: "/yzqzk_sun/pages/member/joinmember/joinmember"
                    });
                }
            }) : wx.navigateTo({
                url: "../storydet/storydet?id=" + o + "&src=" + r + "&index=" + a
            });
        }) : wx.navigateTo({
            url: "../storydet/storydet?id=" + o + "&src=" + r + "&index=" + a
        });
    }
});