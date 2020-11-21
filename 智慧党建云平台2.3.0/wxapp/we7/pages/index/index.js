var e = getApp();

Page({
    data: {
        navs: [],
        slide: [],
        commend: [],
        userInfo: {}
    },
    onLoad: function() {
        var s = this;
        e.util.footer(s), e.util.request({
            url: "wxapp/home/nav",
            cachetime: "30",
            success: function(e) {
                e.data.message.errno || (console.log(e.data.message.message), s.setData({
                    navs: e.data.message.message
                }));
            }
        }), e.util.request({
            url: "wxapp/home/slide",
            cachetime: "30",
            success: function(e) {
                e.data.message.errno || s.setData({
                    slide: e.data.message.message
                });
            }
        }), e.util.request({
            url: "wxapp/home/commend",
            cachetime: "30",
            success: function(e) {
                e.data.message.errno || s.setData({
                    commend: e.data.message.message
                });
            }
        });
    }
});