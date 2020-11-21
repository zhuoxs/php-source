function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp(), foot = require("../../../../../../zhy/component/comFooter/dealfoot.js");

Page({
    data: {
        hotSearch: !1,
        hadsearch: [],
        value: ""
    },
    classify: function() {
        var t = this.data.hotSearch;
        this.setData({
            hotSearch: !t
        });
    },
    onLoad: function(t) {
        var a = this, e = (a.data.value, wx.getStorageSync("userInfo"));
        e.id ? a.setData({
            user_id: e.id
        }) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/zkx/pages/merchants/merchants/merchant");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.reTo("/sqtg_sun/pages/home/index/index");
            }
        }), a.gets(), a.loadList();
    },
    statisticalnum: function(t) {
        var a = this.data.user_id, e = t.currentTarget.dataset.id;
        app.ajax({
            url: "Cstore|addAccressRecord",
            data: {
                store_id: e,
                user_id: a
            },
            success: function(t) {}
        });
    },
    gets: function() {
        var a = this;
        wx.getStorage({
            key: "searchvalue",
            success: function(t) {
                a.setData({
                    hadsearch: t.data
                });
            },
            fail: function(t) {}
        });
    },
    searchBtn: function(t) {
        var a, e = t.detail.value;
        if ("" != (e = e.trim())) {
            var s = this.data.hadsearch, r = [];
            r.push(e);
            var i = 0;
            for (var o in s) s[o] && s[o] != e && i < 9 && (i++, r.push(s[o]));
            wx.setStorage({
                key: "searchvalue",
                data: r,
                success: function(t) {}
            }), this.setData((_defineProperty(a = {
                value: e
            }, "list.page", 1), _defineProperty(a, "hadsearch", r), a)), this.loadList();
        }
    },
    loadList: function() {
        var e = this;
        e.data.value;
        this.setData(_defineProperty({}, "list.load", !0));
        var s = {
            key: this.data.value,
            page: this.data.list.page,
            limit: this.data.list.length
        };
        app.ajax({
            url: "Cstore|getStores",
            data: s,
            success: function(t) {
                e.dealList(t.data, s.page);
                var a = foot.dealFootNav(t.other.store_swipers, t.other.img_root);
                e.setData({
                    banner: a,
                    img_root: t.other.img_root
                });
            }
        });
    },
    onReachBottom: function() {
        this.loadList();
    },
    getValue: function(t) {
        var a = t.currentTarget.dataset.value;
        this.setData(_defineProperty({
            value: a
        }, "list.page", 1)), this.loadList();
    },
    _onNavTab1: function(t) {
        var a = getCurrentPages(), e = "/" + a[a.length - 1].route, s = t.currentTarget.dataset.index, r = this.data.banner[s].link, i = this.data.banner[s].typeid;
        r != e && "" != r && app.navTo(r + "?id=" + i);
    },
    onShareAppMessage: function() {}
});