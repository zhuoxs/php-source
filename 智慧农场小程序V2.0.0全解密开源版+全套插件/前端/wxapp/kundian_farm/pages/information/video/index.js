var t = require("../../../../wxParse/wxParse.js"), a = new getApp(), e = a.siteInfo.uniacid;

Page({
    data: {
        isPlay: !1,
        articleDetail: []
    },
    onLoad: function(i) {
        this.videoContext = wx.createVideoContext("myVideo");
        var s = this, l = i.aid;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "article",
                op: "getArticleDetail",
                uniacid: e,
                aid: l
            },
            success: function(a) {
                var e = a.data.articleDetail;
                s.setData({
                    articleDetail: e
                }), "" != e.content && t.wxParse("article", "html", e.content, s, 5);
            }
        }), a.util.setNavColor(e);
    },
    hadPause: function() {
        var t = this.data.isPlay;
        this.setData({
            isPlay: !t
        });
    },
    playVideo: function() {
        this.videoContext.play();
    }
});