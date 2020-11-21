var a = require("../../../utils/base.js"), t = require("../../../../api.js"), e = new a.Base(), o = getApp();

Page({
    data: {
        list: [],
        page: 1,
        size: 10,
        loadmore: !0,
        loadnot: !1
    },
    onLoad: function(a) {
        o.pageOnLoad(), this.getHelp();
    },
    getHelp: function() {
        var a = this, o = {
            url: t.default.help_list,
            data: {
                page: this.data.page,
                size: this.data.size
            },
            method: "GET"
        };
        e.getData(o, function(t) {
            console.log("帮助中心", t);
            var e = a;
            e.data.list;
            1 == t.errorCode && t.data.data.length > 0 ? (e.data.list.push.apply(e.data.list, t.data.data), 
            e.setData({
                list: e.data.list
            }), t.data.data.length < a.data.size && e.setData({
                loadmore: !1,
                loadnot: !0
            })) : e.setData({
                loadmore: !1,
                loadnot: !0
            });
        });
    },
    navigatorLink: function(a) {
        console.log(a), o.navClick(a, this);
    }
});