var a = require("../../../../utils/base.js"), t = require("../../../../../api.js"), r = new a.Base();

Page({
    data: {
        swith: 0,
        show: !1,
        page: 1,
        size: 10,
        loadmore: !0,
        loadnot: !1,
        orderArray: []
    },
    onLoad: function(a) {
        this.getShareOrder();
    },
    onReachBottom: function() {
        this.setData({
            page: this.data.page + 1
        }), this.data.loadmore && this.getShareOrder(this.data.Switch);
    },
    swith: function(a) {
        var t = a.currentTarget.dataset.swith;
        this.setData({
            swith: t,
            id: -1
        }), this.forOrder();
    },
    show: function(a) {
        var t = a.currentTarget.dataset.id;
        this.setData({
            id: t,
            show: !this.data.show
        });
    },
    getShareOrder: function() {
        var a = this, e = {
            url: t.default.share_order,
            data: {
                page: this.data.page,
                size: this.data.size
            },
            method: "GET"
        };
        r.getData(e, function(t) {
            console.log(t);
            var r = a;
            1 == t.errorCode && (t.data.length > 0 ? (r.data.orderArray.push.apply(r.data.orderArray, t.data), 
            r.setData({
                orderArray: r.data.orderArray
            }), t.data.length < a.data.size && r.setData({
                loadmore: !1,
                loadnot: !0
            })) : r.setData({
                loadmore: !1,
                loadnot: !0
            }), a.setData({
                shareOrder: a.data.orderArray
            }));
        });
    },
    forOrder: function() {
        var a = this.data.swith, t = this.data.shareOrder || [], r = [];
        if (0 != a) {
            for (var e = 0; e < t.length; e++) t[e].status == a && r.push(t[e]);
            this.setData({
                orderArray: r
            });
        } else this.setData({
            orderArray: this.data.shareOrder
        });
    }
});