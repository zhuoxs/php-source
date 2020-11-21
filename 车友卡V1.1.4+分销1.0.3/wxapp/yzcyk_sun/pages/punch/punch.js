var app = getApp();

Page({
    data: {
        navTile: "打卡",
        createMisson: [],
        myMisson: [],
        curPage: 1,
        pageIndex: 1,
        pagesize: 5,
        isMyTask: !0,
        imgroot: wx.getStorageSync("imgroot")
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
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
        }), app.get_imgroot().then(function(t) {
            a.setData({
                imgroot: t
            });
        });
    },
    getCreate: function() {
        var n = this, o = n.data.curPage, i = n.data.createMisson;
        app.util.request({
            url: "entry/wxapp/getPunchList",
            cachetime: "0",
            data: {
                page: o,
                pagesize: n.data.pagesize
            },
            success: function(t) {
                var a = t.data.length == n.data.pagesize;
                if (1 == o) i = t.data; else for (var e in t.data) i.push(t.data[e]);
                o += 1, n.setData({
                    curPage: o,
                    createMisson: i,
                    hasMores: a
                });
            }
        });
    },
    get_my_task: function() {
        var n = this, o = n.data.pageIndex, i = n.data.myMisson;
        app.get_openid().then(function(t) {
            app.util.request({
                url: "entry/wxapp/getMyPunchTaskList",
                cachetime: "0",
                data: {
                    openid: t,
                    page: o,
                    pagesize: n.data.pagesize
                },
                success: function(t) {
                    var a = t.data.length == n.data.pagesize;
                    if (1 == o) i = t.data; else for (var e in t.data) i.push(t.data[e]);
                    o += 1, n.setData({
                        pageIndex: o,
                        myMisson: i,
                        hasMore: a
                    });
                }
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this;
        t.setData({
            curPage: 1,
            pageIndex: 1,
            isMyTask: !0
        }), t.get_my_task(), t.getCreate();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var t = this;
        if (t.data.isMyTask) {
            if (!t.data.hasMore) return void wx.showToast({
                title: "没有更多打卡任务啦啦~",
                icon: "none"
            });
            t.get_my_task();
        } else {
            if (!t.data.hasMores) return void wx.showToast({
                title: "没有更多打卡任务啦啦~",
                icon: "none"
            });
            t.getCreate();
        }
    },
    onShareAppMessage: function() {},
    toPunchlist: function(t) {
        this.setData({
            isMyTask: !this.data.isMyTask
        });
    },
    toPunchdet: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "punchdet/punchdet?id=" + a
        });
    },
    toSettarget: function(t) {
        var a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "settarget/settarget?id=" + a
        });
    }
});