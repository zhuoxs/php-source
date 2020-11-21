var app = getApp();

Page({
    data: {
        page: 1,
        pagesize: 20,
        loadend: !1
    },
    toattention: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.playback;
        e[t].attention = !0, this.setData({
            playback: e
        });
    },
    onLoad: function(a) {
        var e = this;
        e.setData({
            options: a
        }), app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            data: {
                op: "loadLivePlayback",
                live_id: a.live_id,
                page: 1,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                console.log(a);
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.setData({
                    loadend: !0
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
    onShareAppMessage: function() {}
});