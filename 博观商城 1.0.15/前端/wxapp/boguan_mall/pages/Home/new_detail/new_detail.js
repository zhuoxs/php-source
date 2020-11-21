var t = require("../../../utils/base.js"), e = require("../../../../wxParse/wxParse.js"), a = require("../../../../api.js"), n = new t.Base(), i = getApp();

Page({
    data: {},
    onLoad: function(t) {
        var o = this;
        t.scene && i.bind(t.scene), i.pageOnLoad();
        var s = {
            url: a.default.content_detail,
            data: {
                contentId: t.contentId
            },
            method: "GET"
        };
        n.getData(s, function(t) {
            if (console.log(t), 1 == t.errorCode) {
                var a = t.data.content;
                a && e.wxParse("content", "html", a, o), wx.setNavigationBarTitle({
                    title: t.data.title
                }), o.setData({
                    news: t.data,
                    is_collect: t.data.is_collect
                });
            }
        });
    },
    onShareAppMessage: function() {
        var t = wx.getStorageSync("userData").user_info.id, e = encodeURIComponent("parentId=" + t + " & id=" + this.data.news.id + " & type=share");
        return {
            title: this.data.news.title,
            path: "boguan_mall/pages/Home/new_detail/new_detail?contentId=" + this.data.news.id + "&scene=" + e,
            imageUrl: this.data.news.image
        };
    },
    collect: function(t) {
        var e = this, i = t.currentTarget.dataset.id, o = {
            url: a.default.content_collect,
            data: {
                contentId: i
            }
        };
        n.getData(o, function(t) {
            1 == t.errorCode && (e.setData({
                is_collect: t.data.is_collect
            }), wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            }));
        });
    }
});