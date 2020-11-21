var t = getApp(), e = t.requirejs("/core");

t.requirejs("jquery");

Page({
    data: {},
    onLoad: function(a) {
        var i = this;
        t.getCache("isIpx") ? i.setData({
            isIpx: !0
        }) : i.setData({
            isIpx: !1
        }), e.get("dividend/withdraw", "", function(t) {
            i.setData({
                msg: t
            });
        });
    },
    onShow: function(t) {
        var a = this;
        e.get("dividend/withdraw", "", function(t) {
            a.setData({
                msg: t
            });
        });
    },
    submit: function(t) {
        t.currentTarget.dataset.price <= 0 || wx.navigateTo({
            url: "/dividend/pages/apply/index"
        });
    }
});