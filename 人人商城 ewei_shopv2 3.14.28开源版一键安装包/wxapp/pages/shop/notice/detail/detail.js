var t = getApp(), e = t.requirejs("core"), a = t.requirejs("wxParse/wxParse");

Page({
    data: {
        id: "-",
        title: "-",
        createtime: "-"
    },
    onLoad: function(i) {
        var r = this;
        r.setData({
            id: i.id
        }), t.url(i), e.get("shop/notice/detail", {
            id: this.data.id
        }, function(t) {
            var e = t.notice;
            a.wxParse("wxParseData", "html", e.detail, r, "5"), r.setData({
                show: !0,
                title: e.title,
                createtime: e.createtime
            });
        });
    }
});