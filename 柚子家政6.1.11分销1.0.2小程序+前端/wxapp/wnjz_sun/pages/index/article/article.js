var app = getApp();

Page({
    data: {
        navTile: "热门服务",
        navBar: [],
        curIndex: -1
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        }), app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Arc",
            method: "GET",
            success: function(t) {
                console.log(t), a.setData({
                    navBar: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Default",
            method: "GET",
            success: function(t) {
                console.log(t), a.setData({
                    curIndex: -1,
                    section: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    navTab: function(t) {
        var a = t.currentTarget.dataset.index, e = t.currentTarget.dataset.id, n = this;
        n.setData({
            curIndex: a
        }), app.util.request({
            url: "entry/wxapp/Article",
            method: "GET",
            data: {
                id: e
            },
            success: function(t) {
                console.log(t), n.setData({
                    section: t.data
                });
            }
        });
    },
    toArcdet: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../hotser/hotser?id=" + a
        });
    }
});