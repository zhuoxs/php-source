var app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var o = a.id;
        this.setData({
            goods_id: o
        }), this.loadData();
    },
    loadData: function() {
        var o = this;
        app.ajax({
            url: "Cgoods|getGoodsUsers",
            data: {
                goods_id: o.data.goods_id
            },
            success: function(a) {
                console.log(a), o.setData({
                    show: !0,
                    olist: a.data
                });
            }
        });
    }
});