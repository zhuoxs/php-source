var app = getApp();

Page({
    data: {
        nav: [ {
            title: "未使用",
            status: 1
        }, {
            title: "已使用",
            status: 2
        }, {
            title: "已过期",
            status: 3
        } ],
        curHdIndex: 1,
        page: 1,
        limit: 8,
        status: 1,
        shouldFiexd: !1,
        olist: []
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("userInfo") || {};
        this.setData({
            user_id: a.id
        }), this.loadData();
    },
    loadData: function() {
        var e = this, i = e.data.olist, o = e.data.limit, d = e.data.page;
        app.ajax({
            url: "Ccoupon|getMyCoupons",
            data: {
                user_id: e.data.user_id,
                page: d,
                limit: o,
                state: e.data.curHdIndex
            },
            success: function(t) {
                var a = t.data.length == o;
                if (1 == d) i = t.data; else for (var s in t.data) i.push(t.data[s]);
                d += 1, e.setData({
                    olist: i,
                    show: !0,
                    hasMore: a,
                    page: d
                });
            }
        });
    },
    onPageScroll: function(t) {
        10 <= t.scrollTop ? this.setData({
            shouldFiexd: !0
        }) : this.setData({
            shouldFiexd: !1
        });
    },
    swichNav: function(t) {
        var a = t.currentTarget.dataset.status;
        this.setData({
            curHdIndex: a,
            page: 1
        }), this.loadData();
    },
    onReachBottom: function() {
        this.data.hasMore ? this.loadData() : wx.showToast({
            title: "没有更多优惠券单啦~",
            icon: "none"
        });
    }
});