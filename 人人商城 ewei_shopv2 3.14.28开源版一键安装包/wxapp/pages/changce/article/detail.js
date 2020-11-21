var t = getApp(),
    e = t.requirejs("wxParse/wxParse"),
    a = t.requirejs("core");
Page({
    data: {
        aid: 0,
        loading: !1,
        show: !1,
        article: [],
        likenum: 0,
        approot: t.globalData.approot
    },
    onLoad: function(t) {
        this.setData({
            aid: t.id
        }), this.getDetail()
    },
    getDetail: function() {
        var t = this;
        a.get("changce/article/get_detail", {
            id: t.data.aid
        }, function(i) {
            if (!i.article) return a.alert(i.error), !1;
            wx.setNavigationBarTitle({
                title: i.article.article_title
            }), t.setData({
                article: i.article,
                likenum: i.article.likenum,
                show: !0
            }), e.wxParse("wxParseData", "html", i.article.article_content, t, "10")
        })
    },
    callme: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.target.id
        })
    },
    likeit: function(t) {
        var e = this,
            i = e.data.likenum,
            r = e.data.aid;
        a.get("changce/article/like", {
            id: r
        }, function(t) {
            if (!t.success) return a.alert(t.error), !1;
            1 == t.status ? i++ : i--, e.setData({
                likenum: i
            })
        })
    },
    phone: function(t) {
        a.phone(t)
    }
});