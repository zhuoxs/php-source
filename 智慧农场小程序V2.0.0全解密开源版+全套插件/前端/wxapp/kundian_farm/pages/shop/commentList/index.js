var t = new getApp(), e = t.siteInfo.uniacid;

Page({
    data: {
        commentList: [],
        page: 1,
        goods_id: 0
    },
    onLoad: function(t) {
        var e = t.goods_id;
        this.getCommentList(e, 1);
    },
    onReachBottom: function() {
        var t = this.data, e = t.goods_id, a = t.page;
        this.getCommentList(e, parseInt(a) + 1);
    },
    getCommentList: function(a, i) {
        var o = this;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "shop",
                op: "getCommentList",
                uniacid: e,
                page: i,
                goods_id: a
            },
            success: function(t) {
                var e = o.data.commentList, s = t.data.commentList;
                i > 1 ? (s.length > 0 && s.map(function(t) {
                    e.push(t);
                }), o.setData({
                    commentList: e,
                    page: i,
                    goods_id: a
                })) : o.setData({
                    commentList: t.data.commentList,
                    goods_id: a
                });
            }
        });
    },
    previewImg: function(t) {
        var e = t.currentTarget.dataset, a = e.id, i = e.index, o = [];
        this.data.commentList.map(function(t) {
            t.id == a && (o = t.src);
        }), wx.previewImage({
            urls: o,
            current: o[i]
        });
    }
});