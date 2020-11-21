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
            title: "未使用",
            status: 2
        }, {
            title: "已使用",
            status: 6
        }, {
            title: "售后",
            status: 7
        } ],
        curHdIndex: 0,
        show: !1,
        page: 1,
        limit: 5,
        list: []
    },
    onLoad: function(t) {
        this.setData({
            curHdIndex: t.id
        });
        var a = wx.getStorageSync("userInfo");
        a ? this.setData({
            uInfo: a
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/public/pages/myorder/myorder?id=0");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    onShow: function() {
        this.setData({
            page: 1
        }), this.loadData();
    },
    loadData: function() {
        var s = this, i = s.data.list, n = s.data.limit, r = s.data.page;
        app.ajax({
            url: "Corder|getOrder",
            data: {
                user_id: s.data.uInfo.id,
                page: r,
                limit: n,
                type: s.data.curHdIndex,
                lid: 2
            },
            success: function(t) {
                var a = t.data.length == n;
                if (1 == r) i = t.data; else for (var e in t.data) i.push(t.data[e]);
                r += 1, s.setData({
                    list: i,
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
        this.data.hasMore ? this.loadData() : wx.showToast({
            title: "没有更多订单啦~",
            icon: "none"
        });
    },
    cancelOrder: function(t) {
        var a = this, e = t.currentTarget.dataset.id, s = t.currentTarget.dataset.index, i = a.data.list;
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
                            list: i
                        });
                    }
                });
            }
        });
    },
    deleteOrder: function(t) {
        var a = this, e = t.currentTarget.dataset.id, s = t.currentTarget.dataset.index, i = a.data.list;
        wx.showModal({
            title: "提示",
            content: "订单删除后不再显示",
            success: function(t) {
                t.confirm && app.ajax({
                    url: "Corder|delOrder",
                    data: {
                        user_id: a.data.uInfo.id,
                        order_id: e
                    },
                    success: function(t) {
                        wx.showToast({
                            title: "删除成功"
                        }), i.splice(s, 1), a.setData({
                            list: i
                        });
                    }
                });
            }
        });
    },
    toComment: function(t) {
        var a = t.currentTarget.dataset.id, e = t.currentTarget.dataset.ids;
        app.navTo("/sqtg_sun/pages/hqs/pages/comment/comment?id=" + a + "&ids=" + e);
    },
    toOrderDetail: function(t) {
        var a = t.currentTarget.dataset.id;
        app.navTo("/sqtg_sun/pages/plugin/order/orderlistdet/orderlistdet?id=" + a);
    }
});