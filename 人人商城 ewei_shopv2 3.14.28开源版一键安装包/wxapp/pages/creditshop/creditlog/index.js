var t = getApp(), e = t.requirejs("core");

t.requirejs("jquery");

Page(function(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}({
    data: {
        page: 1,
        list: {},
        total: 0,
        load: !0,
        more: !0,
        notgoods: !0
    },
    onLoad: function(t) {
        this.get_list();
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    get_list: function(t) {
        var a = this;
        e.post("creditshop/creditlog/getlist", {
            page: a.data.page
        }, function(e) {
            a.setData({
                total: e.credit
            }), t ? (e.list = a.data.list.concat(e.list), a.setData({
                list: e.list
            })) : a.setData({
                list: e.list
            }), 0 == e.total ? a.setData({
                notgoods: !1
            }) : a.setData({
                notgoods: !0
            }), e.pagesize >= e.next_page ? a.setData({
                more: !1
            }) : a.setData({
                more: !0
            });
        });
    }
}, "onReachBottom", function(t) {
    this.setData({
        page: this.data.page + 1,
        load: !1
    }), this.get_list(!0), this.setData({
        load: !0
    });
}));