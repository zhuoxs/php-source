var app = getApp();

Page({
    data: {
        types: []
    },
    onLoad: function(t) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), e.setData({
                    url: t.data
                });
            }
        });
        var a = t.id;
        app.util.request({
            url: "entry/wxapp/CourseTypeDetail",
            data: {
                id: a
            },
            success: function(t) {
                e.setData({
                    types: t.data
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
    see: function(t) {
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../equipment/equipment?course_type=" + e
        });
    }
});