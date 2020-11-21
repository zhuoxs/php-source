var app = getApp();

Page({
    data: {
        nav: [ {
            title: "待审核",
            status: 1
        }, {
            title: "待打款",
            status: 2
        }, {
            title: "已打款",
            status: 3
        } ],
        curHdIndex: 1,
        page: 1,
        limit: 5,
        list: []
    },
    onLoad: function(a) {
        var t = wx.getStorageSync("userInfo");
        this.setData({
            user_id: t.id
        });
    },
    onShow: function() {
        this.setData({
            page: 1
        }), this.loadData();
    },
    loadData: function() {
        var e = this, i = e.data.list, d = e.data.limit, o = e.data.page;
        app.ajax({
            url: "Cdistribution|getWithdraws",
            data: {
                user_id: e.data.user_id,
                page: o,
                limit: d,
                state: e.data.curHdIndex
            },
            success: function(a) {
                var t = a.data.length == d;
                if (a.data.length || e.setData({
                    hasMore: !1,
                    show: !0,
                    nomore: !0
                }), 1 == o) i = a.data; else for (var s in a.data) i.push(a.data[s]);
                o += 1, e.setData({
                    list: i,
                    show: !0,
                    hasMore: t,
                    page: o
                });
            }
        });
    },
    swichNav: function(a) {
        var t = a.currentTarget.dataset.status;
        this.setData({
            curHdIndex: t,
            page: 1
        }), this.loadData();
    },
    onReachBottom: function() {
        var a = this;
        a.data.hasMore ? a.loadData() : a.setData({
            nomore: !0
        });
    }
});