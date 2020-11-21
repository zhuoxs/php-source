var app = getApp();

Page({
    data: {
        showList: !1,
        myRule: !1,
        shadow: !1
    },
    showRule: function() {
        this.setData({
            myRule: !0,
            shadow: !0
        });
    },
    close: function() {
        this.setData({
            myRule: !1,
            shadow: !1,
            showList: !1
        });
    },
    showList: function() {
        this.setData({
            showList: !0
        });
    },
    getUrl: function() {
        if (new Date().getTime() > new Date(this.data.list.enddate)) app.look.no("活动已结束", function() {
            app.look.back(1);
        }); else {
            wx.navigateTo({
                url: "../puzzleDetail/puzzleDetail?id=" + this.data.options.id
            });
        }
    },
    onLoad: function(t) {
        t.id = 8;
        var o = this;
        o.setData({
            options: t
        }), app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !1,
            data: {
                op: "getLottery",
                id: t.id
            },
            success: function(t) {
                var a = t.data;
                a.data.list && o.setData({
                    list: a.data.list
                });
            }
        });
    },
    onReady: function() {
        var t = {};
        t.puzzle_bg = app.module_url + "/resource/wxapp/lottery/puzzle-bg.jpg", this.setData({
            images: t
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});