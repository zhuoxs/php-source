var t = getApp(), s = t.requirejs("core");

Page({
    data: {},
    onLoad: function(s) {
        this.setData({
            options: s
        }), t.url(s), this.get_list(s.id);
    },
    get_list: function(t) {
        var e = this;
        s.get("creditshop/log/express", {
            id: t
        }, function(t) {
            0 == t.error ? (t.show = !0, e.setData(t)) : s.toast(t.message, "loading");
        });
    }
});