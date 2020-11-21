var app = getApp();

Page({
    data: {
        bannerList: [ "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152472139629.jpg", "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152472139629.jpg", "http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/152472139629.jpg" ],
        list: []
    },
    onLoad: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Banner",
            cachetime: "30",
            success: function(t) {
                a.setData({
                    bannerList: t.data.lb_imgs
                });
            }
        });
        var e = t.course_type;
        console.log(t), app.util.request({
            url: "entry/wxapp/TypeCourse",
            data: {
                course_type: e
            },
            success: function(t) {
                a.setData({
                    list: t.data
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
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../courseGoInfo/courseGoInfo?id=" + a
        });
    }
});