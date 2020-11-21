var t = require("../../../../wxParse/wxParse.js"), a = new getApp(), e = a.siteInfo.uniacid;

Page({
    data: {
        articleDetail: []
    },
    onLoad: function(i) {
        var r = this, c = i.aid;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "article",
                op: "getArticleDetail",
                uniacid: e,
                aid: c
            },
            success: function(a) {
                var e = a.data.articleDetail;
                r.setData({
                    articleDetail: e
                }), "" != e.content && t.wxParse("article", "html", e.content, r, 5);
            }
        }), a.util.setNavColor(e);
    }
});