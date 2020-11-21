var app = getApp();

Page({
    data: {
        padding: !1,
        activeIndex: 0,
        headerNav: [ "热销", "新鲜水果", "新鲜水果1", "新鲜水果2", "新鲜水果3", "新鲜水果4" ]
    },
    getPadding: function(a) {
        this.setData({
            padding: a.detail
        });
    },
    onLoad: function(a) {
        app.checkSetting();
    },
    swichNav: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            activeIndex: t
        });
    }
});