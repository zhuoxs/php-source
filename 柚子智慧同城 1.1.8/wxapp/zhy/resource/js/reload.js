function t(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

require("./api.js");

var e = getApp(), a = {
    show: !1,
    ajax: !1,
    reload: !0,
    padding: 0,
    list: {
        load: !1,
        over: !1,
        page: 1,
        length: 10,
        none: !1,
        data: []
    }
}, n = {
    checkLogin: function(t, a) {
        var n = wx.getStorageSync("yztcInfo");
        n ? t && t(n) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    a || (a = "/pages/home/home");
                    var n = encodeURIComponent(a);
                    e.reTo("/pages/login/login?id=" + n);
                } else t.cancel && e.lunchTo("/pages/home/home");
            }
        });
    },
    dealList: function(e, a) {
        var n;
        1 == a && this.setData({
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                none: !1,
                data: []
            }
        });
        var o = this.data.list.data.concat(e);
        e.length < this.data.list.length && this.setData(t({}, "list.over", !0)), 0 === o.length && this.setData(t({}, "list.none", !0)), 
        this.setData((n = {}, t(n, "list.load", !1), t(n, "list.page", ++this.data.list.page), 
        t(n, "list.data", o), n));
    },
    toReload: function() {
        var t = getCurrentPages();
        t[t.length - 2].setData({
            reload: !0
        });
    },
    getPadding: function(t) {
        console.log(t.detail), this.setData({
            padding: t.detail
        });
    }
};

module.exports = {
    data: a,
    reload: n
};