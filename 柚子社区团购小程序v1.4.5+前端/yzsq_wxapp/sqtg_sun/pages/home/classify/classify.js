var app = getApp();

Page({
    data: {
        padding: !1,
        spindex: 0,
        activeIndex: 0
    },
    getPadding: function(t) {
        this.setData({
            padding: t.detail
        });
    },
    onLoad: function(t) {
        app.checkSetting();
        var e = this;
        app.ajax({
            url: "Ccategory|getCategorys",
            success: function(t) {
                var a = t.data;
                e.setData({
                    level: t.other.level,
                    lvone: a,
                    img_root: t.other.img_root
                });
            }
        });
    },
    jumpTo: function(t) {
        var a = t.currentTarget.dataset.index, e = t.currentTarget.dataset.opt;
        this.setData({
            toView: e,
            activeIndex: a
        });
    },
    tabTap: function(t) {
        this.setData({
            activeIndex: t.currentTarget.id
        });
    },
    onShareAppMessage: function(t) {}
});