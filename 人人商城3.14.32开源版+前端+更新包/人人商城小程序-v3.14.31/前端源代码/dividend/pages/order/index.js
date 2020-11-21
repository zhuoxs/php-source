var t = getApp(), a = t.requirejs("/core");

t.requirejs("jquery");

Page({
    data: {
        list: [],
        page: 1,
        status: "all",
        loading: !1
    },
    bindViewTap: function() {
        wx.navigateTo({
            url: "../logs/logs"
        });
    },
    goIndex: function() {
        wx.navigateTo({
            url: "/pages/quickbuy/quickbuy/shop_index/shop_index"
        });
    },
    onLoad: function() {
        var t = {
            page: 1
        };
        this.getlist(t);
    },
    tab: function(t) {
        var a = t.currentTarget.dataset.status, e = {
            page: 1,
            status: "all" == a ? "" : a
        };
        this.setData({
            status: a,
            list: []
        }), this.getlist(e);
    },
    onReachBottom: function() {
        var t = this, a = {
            page: t.data.page,
            status: t.data.status
        };
        t.getlist(a);
    },
    getlist: function(t) {
        var e = this;
        e.setData({
            loading: !0
        }), a.get("dividend/order", t, function(a) {
            if (0 == a.error) {
                if (a.list.length > 0) {
                    var s = e.data.list.concat(a.list);
                    t.page = t.page + 1;
                }
                e.setData({
                    member: a.member,
                    list: s,
                    loading: !1,
                    total: a.total,
                    page: t.page,
                    stop: !1,
                    ordercount: a.ordercount
                });
            }
        });
    }
});