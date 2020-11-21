var t = require("../../../utils/base.js"), a = require("../../../../api.js"), e = new t.Base();

Page({
    data: {
        page: 1,
        size: 4,
        commentArray: [],
        loadmore: !0,
        loadnot: !1
    },
    onLoad: function(t) {
        console.log(t), this.setData({
            comment_count: t.comment_count,
            praise: t.praise,
            productId: t.productId
        }), t.productId && this.getComment(t.productId);
    },
    onReachBottom: function() {
        this.setData({
            page: this.data.page + 1
        }), this.data.loadmore && this.getComment(this.data.productId);
    },
    getComment: function(t) {
        var o = this, d = {
            url: a.default.comment_list,
            data: {
                page: this.data.page,
                size: this.data.size,
                productId: t
            }
        };
        e.getData(d, function(t) {
            console.log(t);
            var a = o;
            a.data.commentArray;
            t.data.length > 0 ? (a.data.commentArray.push.apply(a.data.commentArray, t.data), 
            a.setData({
                commentArray: a.data.commentArray
            }), t.data.length < o.data.size && a.setData({
                loadmore: !1,
                loadnot: !0
            })) : a.setData({
                loadmore: !1,
                loadnot: !0
            });
        });
    }
});