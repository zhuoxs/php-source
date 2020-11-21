var app = getApp();

Page({
    data: {
        nav: [ {
            title: "全部",
            status: 0
        }, {
            title: "待付款",
            status: 1
        }, {
            title: "待配送",
            status: 2
        }, {
            title: "配送中",
            status: 3
        }, {
            title: "待自提",
            status: 4
        }, {
            title: "已完成",
            status: 5
        } ],
        curHdIndex: 0,
        show: !1,
        page: 1,
        limit: 5,
        olist: []
    },
    onLoad: function(t) {
        t.id && this.setData({
            curHdIndex: t.id
        });
        var a = wx.getStorageSync("userInfo");
        this.setData({
            uInfo: a
        });
    },
    onShow: function() {
        this.setData({
            page: 1
        }), this.loadData();
    },
    loadData: function() {
        var s = this, i = s.data.olist, o = s.data.limit, r = s.data.page;
        app.ajax({
            url: "Cdistribution|getOrders",
            data: {
                user_id: s.data.uInfo.id,
                page: r,
                limit: o,
                state: s.data.curHdIndex
            },
            success: function(t) {
                var a = t.data.length == o;
                if (t.data.length || s.setData({
                    hasMore: !1,
                    show: !0,
                    nomore: !0
                }), 1 == r) i = t.data; else for (var e in t.data) i.push(t.data[e]);
                r += 1, s.setData({
                    olist: i,
                    show: !0,
                    hasMore: a,
                    page: r,
                    imgroot: t.other.img_root
                });
            }
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
        var t = this;
        t.data.hasMore ? t.loadData() : t.setData({
            nomore: !0
        });
    },
    cancelOrder: function(t) {
        var a = this, e = t.currentTarget.dataset.id, s = t.currentTarget.dataset.index, i = a.data.olist;
        wx.showModal({
            title: "提示",
            content: "确定取消该订单吗",
            success: function(t) {
                t.confirm && app.ajax({
                    url: "Corder|cancelOrder",
                    data: {
                        user_id: a.data.uInfo.id,
                        order_id: e
                    },
                    success: function(t) {
                        wx.showToast({
                            title: "取消成功"
                        }), i.splice(s, 1), a.setData({
                            olist: i
                        });
                    }
                });
            }
        });
    }
});