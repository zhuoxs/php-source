var app = getApp();

Page({
    data: {
        curIndex: 0,
        orderlist: [],
        pages: [ 1, 1, 1 ]
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("branch_id");
        app.util.request({
            url: "entry/wxapp/GetBuildOrder",
            cachetime: "0",
            data: {
                branch_id: e,
                status: 10,
                isdefault: 0
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    worder: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var e = this, n = e.data.curIndex, t = wx.getStorageSync("branch_id"), r = e.data.pages, s = r[n], a = {
            branch_id: t,
            page: s
        };
        1 == n ? (a.isdefault = 0, a.status = 20) : 0 == n ? (a.isdefault = 0, a.status = 10) : 2 == n && (a.isdefault = 1);
        var d = e.data.worder;
        app.util.request({
            url: "entry/wxapp/GetBuildOrder",
            cachetime: "0",
            data: a,
            success: function(t) {
                if (console.log(t), 2 != t.data) {
                    var a = t.data;
                    d = d.concat(a), r[n] = s + 1, e.setData({
                        worder: d,
                        pages: r
                    });
                } else wx.showToast({
                    title: "没有更多内容了"
                });
            }
        });
    },
    onShareAppMessage: function() {},
    bargainTap: function(t) {
        var a = this, e = parseInt(t.currentTarget.dataset.index), n = {
            branch_id: wx.getStorageSync("branch_id")
        };
        1 == e ? (n.isdefault = 0, n.status = 20) : 0 == e ? (n.isdefault = 0, n.status = 10) : 2 == e && (n.isdefault = 1), 
        app.util.request({
            url: "entry/wxapp/GetBuildOrder",
            cachetime: "0",
            data: n,
            success: function(t) {
                console.log(t), 2 != t.data ? a.setData({
                    worder: t.data,
                    curIndex: e,
                    pages: [ 1, 1, 1 ]
                }) : a.setData({
                    worder: [],
                    curIndex: e,
                    pages: [ 1, 1, 1 ]
                });
            }
        });
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "../index3/index3"
        });
    },
    toSet: function(t) {
        wx.redirectTo({
            url: "../set2/set2"
        });
    }
});