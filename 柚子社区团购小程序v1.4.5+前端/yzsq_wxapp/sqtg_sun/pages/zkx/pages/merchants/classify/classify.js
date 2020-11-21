var app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        this.setData({
            id: a.id
        }), this.loadDate();
    },
    loadDate: function() {
        var t = this;
        app.ajax({
            url: "Ccategory|getStoreCategorys",
            data: {
                store_id: t.data.id
            },
            success: function(a) {
                t.setData({
                    list: a.data,
                    imgroot: a.other.img_root,
                    show: !0
                });
            }
        });
    },
    onShow: function() {},
    onShareAppMessage: function() {},
    toAllgoods: function(a) {
        var t = a.currentTarget.dataset.id;
        app.reTo("/sqtg_sun/pages/zkx/pages/merchants/allgoods/allgoods?id=" + this.data.id + "&catid=" + t);
    }
});