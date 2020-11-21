var e = getApp(), o = e.requirejs("core");

e.requirejs("jquery");

Page({
    data: {
        verifygoods: []
    },
    onLoad: function(o) {
        this.setData({
            options: o
        }), e.url(o);
    },
    onShow: function() {
        this.get_detail();
    },
    get_detail: function() {
        var e = this;
        o.get("verifygoods/get_detail", e.data.options, function(t) {
            0 == t.error ? e.setData({
                verifygoods: t.item,
                store: t.store,
                canverify: t.canverify,
                canverify_message: t.canverify_message,
                qrcode: t.qrcode,
                verifygoodlogs: t.verifygoodlogs,
                verifynum: t.verifynum,
                limitdatestr: t.limitdatestr,
                verifycode: t.verifycode
            }) : (5e4 != t.error && o.toast(t.message, "loading"), wx.redirectTo({
                url: "/pages/verifygoods/index"
            }));
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});