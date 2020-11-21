var app = getApp();

Page({
    data: {
        navTile: "宝宝信息",
        list: []
    },
    onLoad: function(t) {
        var a = t.isback || "";
        wx.setNavigationBarTitle({
            title: this.data.navTile
        });
        var e = wx.getStorageSync("setting");
        e ? wx.setNavigationBarColor({
            frontColor: e.fontcolor,
            backgroundColor: e.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        }), this.setData({
            isback: a
        });
    },
    onReady: function() {},
    onShow: function() {
        var o = this, i = (o.data.list, new Date().getFullYear());
        app.get_openid().then(function(t) {
            app.util.request({
                url: "entry/wxapp/getBaby",
                cachetime: "0",
                data: {
                    openid: t
                },
                success: function(t) {
                    for (var a = t.data, e = 0; e < a.length; e++) {
                        var n = a[e].birth.split("-")[0];
                        a[e].age = i - n;
                    }
                    o.setData({
                        list: a
                    });
                }
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toDelete: function(t) {
        var a = this, e = a.data.list, n = t.currentTarget.dataset.index, o = t.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "确定删除宝宝信息吗?",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/delBaby",
                    cachetime: "0",
                    data: {
                        id: o
                    },
                    success: function(t) {
                        1 == t.data && wx.showToast({
                            title: "删除成功",
                            duration: 2500,
                            success: function(t) {
                                e.splice(n, 1), a.setData({
                                    list: e
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    toAddbady: function(t) {
        var a = t.currentTarget.dataset.id || "";
        wx.navigateTo({
            url: "../babyedit/babyedit?id=" + a
        });
    },
    toBack: function(t) {
        var a = t.currentTarget.dataset.index, e = this.data.list, n = this.data.isback, o = e[a];
        1 == n && wx.setStorage({
            key: "baby",
            data: o,
            success: function() {
                wx.navigateBack({});
            }
        });
    }
});