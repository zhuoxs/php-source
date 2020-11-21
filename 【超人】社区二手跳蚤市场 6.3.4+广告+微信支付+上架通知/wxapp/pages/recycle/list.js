var app = getApp();

Page({
    data: {
        list: [],
        page: 1,
        nodata: !1
    },
    onLoad: function() {
        app.util.footer(this), app.setTabBar(), this.getRecycleList();
    },
    getRecycleList: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/recycle",
            data: {
                m: "superman_hand2",
                act: "list",
                page: e.data.page
            },
            fail: function(t) {
                console.log(t), wx.showModal({
                    title: "系统提示",
                    content: t.data.errmsg + "(" + t.data.errno + ")"
                });
            },
            success: function(t) {
                if (console.log(t), t.data.data.list.length) {
                    var a = void 0;
                    a = e.data.list.length ? e.data.list.concat(t.data.data.list) : t.data.data.list, 
                    e.setData({
                        list: a,
                        page: e.data.page + 1
                    });
                } else e.setData({
                    nodata: !0
                });
            }
        });
    },
    onReachBottom: function() {
        this.getRecycleList();
    }
});