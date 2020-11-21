var t = getApp(), e = t.requirejs("/core");

t.requirejs("jquery");

Page({
    data: {
        list: [],
        page: 1,
        loading: !1
    },
    onLoad: function() {
        var t = {
            page: 1
        };
        this.getlist(t);
    },
    getlist: function(t) {
        var a = this;
        a.setData({
            loading: !0
        }), console.error(a.data.loading), e.get("dividend/down", t, function(e) {
            if (console.error(e), 0 == e.error) {
                if (e.list.length > 0) {
                    var i = a.data.list.concat(e.list);
                    t.page = t.page + 1;
                }
                a.setData({
                    member: e.member,
                    list: i,
                    loading: !1,
                    total: e.total,
                    page: t.page,
                    stop: !1
                });
            }
        });
    }
});