var e = getApp().requirejs("core");

Page({
    data: {
        showimage: !1
    },
    onLoad: function(e) {},
    onShow: function() {
        this.getData();
    },
    getData: function() {
        var o = this;
        e.get("commission/qrcode", {}, function(e) {
            70001 != e.error ? (e.show = !0, o.setData(e), o.getImage()) : wx.redirectTo({
                url: "/pages/member/info/index"
            });
        });
    },
    getImage: function() {
        var o = this;
        e.post("commission/qrcode", {}, function(e) {
            70001 != e.error ? (e.showimage = !0, o.setData(e)) : wx.redirectTo({
                url: "/pages/member/info/index"
            });
        });
    }
});