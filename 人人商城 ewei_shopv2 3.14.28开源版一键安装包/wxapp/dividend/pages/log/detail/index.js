var t = getApp(), a = t.requirejs("/core");

t.requirejs("jquery");

Page({
    data: {
        list: [],
        page: 1,
        status: "all",
        loading: !1,
        args: {
            id: ""
        }
    },
    onLoad: function(t) {
        var a = this, s = {
            id: t.id
        };
        a.setData({
            "args.id": t.id
        }), a.getlist(s);
    },
    onReachBottom: function() {
        var t = this, a = (t.data.page, t.data.status, t.data.args);
        t.getlist(a);
    },
    getlist: function(t) {
        var s = this;
        s.setData({
            loading: !0
        }), a.get("dividend/log/orders", t, function(a) {
            if (console.error(a), 0 == a.error) {
                if (a.list.length > 0 && s.data.list.length < a.total) {
                    var e = s.data.list.concat(a.list);
                    t.page = t.page + 1;
                }
                s.setData({
                    sysset: a.sysset,
                    set: a.set,
                    list: e,
                    loading: !1,
                    total: a.total,
                    page: t.page,
                    stop: !1
                });
            }
        });
    }
});