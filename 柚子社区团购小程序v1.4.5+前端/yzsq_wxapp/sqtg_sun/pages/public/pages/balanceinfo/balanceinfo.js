var app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var t = JSON.parse(a.id);
        this.setData({
            show: !0,
            info: t
        });
    }
});