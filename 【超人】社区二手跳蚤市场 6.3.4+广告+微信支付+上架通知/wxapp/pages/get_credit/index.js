var app = getApp();

Page({
    data: {
        recycle: {
            open: !1,
            style: []
        }
    },
    onLoad: function() {
        var t = this, a = wx.getStorageSync("loading_img");
        a ? t.setData({
            loadingImg: a
        }) : t.setData({
            loadingImg: "../../libs/images/loading.gif"
        }), app.viewCount(), app.util.request({
            url: "entry/wxapp/mycredit",
            cachetime: "0",
            data: {
                act: "get",
                m: "superman_hand2"
            },
            success: function(a) {
                t.setData({
                    list: a.data.data.list,
                    completed: !0
                });
            }
        });
    },
    onPullDownRefresh: function() {
        this.onLoad(), wx.stopPullDownRefresh();
    }
});