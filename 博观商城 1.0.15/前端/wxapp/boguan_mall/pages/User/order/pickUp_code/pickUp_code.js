var e = require("../../../../utils/base.js"), a = require("../../../../../api.js"), o = new e.Base();

Page({
    data: {},
    onLoad: function(e) {
        console.log("options=>", e), this.orderDetail(e.orderId);
    },
    orderDetail: function(e) {
        var r = this, t = {
            url: a.default.order_detail,
            data: {
                orderId: e
            }
        };
        o.getData(t, function(e) {
            console.log(e), r.setData({
                orderInfo: e.data
            });
        });
    }
});