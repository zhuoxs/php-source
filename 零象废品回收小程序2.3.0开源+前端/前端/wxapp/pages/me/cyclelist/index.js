var t = getApp();

Page({
    data: {
        list: []
    },
    onLoad: function(a) {
        var e = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "order.cycleList",
                order_id: a.id
            },
            success: function(t) {
                e.setData({
                    list: t.data.data
                });
            }
        });
    }
});