var t = getApp().requirejs("core");

Page({
    data: {},
    onLoad: function(t) {},
    onShow: function() {
        this.getData();
    },
    getData: function() {
        var e = this;
        t.get("commission/index", {}, function(t) {
            7e4 != t.error ? (t.show = !0, e.setData(t), wx.setNavigationBarTitle({
                title: t.set.texts.center
            })) : wx.redirectTo({
                url: "/pages/commission/register/index"
            });
        });
    }
});