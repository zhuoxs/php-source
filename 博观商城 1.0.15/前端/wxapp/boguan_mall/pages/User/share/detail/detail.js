var a = require("../../../../utils/base.js"), t = require("../../../../../api.js"), r = new a.Base();

Page({
    data: {
        swith: -1,
        page: 1,
        size: 20,
        loadmore: !0,
        loadnot: !1,
        orderArray: []
    },
    onLoad: function(a) {
        this.setData({
            swith: a.swith
        }), this.getForwardOrder();
    },
    onReachBottom: function() {
        this.setData({
            page: this.data.page + 1
        }), this.data.loadmore && this.getForwardOrder(this.data.Switch);
    },
    swith: function(a) {
        var t = a.currentTarget.dataset.swith;
        this.setData({
            swith: t
        }), this.forOrder();
    },
    getForwardOrder: function() {
        var a = this, e = {
            url: t.default.share_withdraw,
            data: {
                page: this.data.page,
                size: this.data.size
            },
            method: "GET"
        };
        r.getData(e, function(t) {
            var r = a;
            t.data.data.length > 0 ? (r.data.orderArray.push.apply(r.data.orderArray, t.data.data), 
            r.setData({
                orderArray: r.data.orderArray
            }), t.data.data.length < a.data.size && r.setData({
                loadmore: !1,
                loadnot: !0
            })) : r.setData({
                loadmore: !1,
                loadnot: !0
            }), a.setData({
                shareOrder: a.data.orderArray
            });
        });
    },
    forOrder: function() {
        var a = this.data.swith, t = this.data.shareOrder, r = [];
        if (-1 != a) {
            for (var e = 0; e < t.length; e++) t[e].status == a && r.push(t[e]);
            this.setData({
                orderArray: r
            });
        } else this.setData({
            orderArray: this.data.shareOrder
        });
    }
});