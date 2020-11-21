var app = getApp();

Page({
    data: {
        current: 0,
        yiyuan: [ {
            yiyuan: "分类一",
            arrs: [ "好的撒点击撒打算1", "好的撒点击撒打算1", "好的撒点击撒打算1", "好的撒点击撒打算1" ]
        }, {
            yiyuan: "分类二",
            arrs: [ "好的撒点击撒打算2", "好的撒点击撒打算2", "好的撒点击撒打算2", "好的撒点击撒打算2" ]
        }, {
            yiyuan: "分类三",
            arrs: [ "好的撒点击撒打算3", "好的撒点击撒打算3", "好的撒点击撒打算3", "好的撒点击撒打算3" ]
        } ]
    },
    selyiyuan: function(n) {
        this.setData({
            current: n.currentTarget.dataset.index
        });
    },
    success: function(n) {
        console.log(n);
        var a = n.currentTarget.dataset.yiyuan, t = getCurrentPages();
        t[t.length - 2].setData({
            yiyuan: a
        }), wx.navigateBack({
            delta: 1
        });
    },
    onLoad: function(n) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Getalldq",
            success: function(n) {
                console.log(n), a.setData({
                    hsp: n.data.data
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