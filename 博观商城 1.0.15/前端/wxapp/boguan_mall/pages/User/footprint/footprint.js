function t(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var a = require("../../../utils/base.js"), e = require("../../../../api.js"), r = new a.Base(), o = getApp();

Page({
    data: {
        page: 1,
        size: 20,
        Switch: 1,
        loadmore: !0,
        loadnot: !1,
        product: [],
        content: [],
        productArray: [],
        contentArray: [],
        currentPage: 0
    },
    onLoad: function(t) {
        o.pageOnLoad(), this.getFootprint();
        var a = wx.getStorageSync("userData");
        a.user_info ? this.setData({
            is_vip: a.user_info.is_vip
        }) : this.getUserData();
    },
    onReachBottom: function() {
        this.setData({
            page: this.data.page + 1
        }), this.data.loadmore && this.getFootprint(this.data.Switch);
    },
    getUserData: function() {
        var t = this, a = {
            url: e.default.user
        };
        r.getData(a, function(a) {
            var e = 0;
            1 == a.errorCode && (wx.setStorageSync("userData", a), e = a.user_info.is_vip), 
            t.setData({
                userData: a,
                is_vip: e
            });
        });
    },
    tabSwitch: function(t) {
        this.setData({
            Switch: t.currentTarget.dataset.index,
            size: 20,
            page: 1,
            product: [],
            content: [],
            loadmore: !0,
            loadnot: !1,
            productArray: [],
            contentArray: [],
            currentPage: 0
        }), this.getFootprint(this.data.type);
    },
    getFootprint: function() {
        var a = this, o = {
            url: e.default.footprint_list,
            data: {
                type: this.data.Switch,
                page: this.data.page,
                size: this.data.size
            },
            method: "GET"
        };
        r.getData(o, function(e) {
            if (console.log(e), 1 == e.errorCode && e.data.length > 0) for (var r in e.data) for (var o in e.data[r].footprint) e.data[r].footprint[o].price = parseFloat(e.data[r].footprint[o].price), 
            e.data[r].footprint[o].o_price = parseFloat(e.data[r].footprint[o].o_price), e.data[r].footprint[o].vip_price = parseFloat(e.data[r].footprint[o].vip_price);
            var n = a, i = (n.data.product, n.data.content, a.data.productArray, a.data.contentArray, 
            a.data.currentPage);
            if (1 == e.errorCode) if (1 == a.data.Switch) {
                var d;
                n.data.product.push.apply(n.data.product, e.data), n.setData((d = {}, t(d, "productArray[" + i + "]", e.data), 
                t(d, "currentPage", i + 1), t(d, "collect", !1), d)), e.product - n.data.product.length < a.data.size && n.setData({
                    loadmore: !1,
                    loadnot: !0
                });
            } else {
                var c;
                n.data.content.push.apply(n.data.content, e.data), n.setData((c = {}, t(c, "contentArray[" + i + "]", e.data), 
                t(c, "currentPage", i + 1), t(c, "collect", !1), c)), e.content - n.data.content.length < a.data.size && n.setData({
                    loadmore: !1,
                    loadnot: !0
                });
            } else n.setData({
                loadmore: !1,
                loadnot: !0,
                collect: !0
            });
        });
    },
    del: function(t) {
        var a = this, o = t.currentTarget.dataset.id, n = {
            url: e.default.footprint_del,
            data: {
                type: 1,
                id: o
            },
            method: "GET"
        };
        r.getData(n, function(e) {
            if (1 == e.errorCode) {
                var r = t.currentTarget.dataset.index, o = t.currentTarget.dataset.idx;
                a.data.product[r].footprint.splice(o, 1), a.setData({
                    product: a.data.product
                });
            }
        });
    },
    delNews: function(t) {
        var a = this, o = t.currentTarget.dataset.id, n = {
            url: e.default.footprint_del,
            data: {
                type: 2,
                id: o
            },
            method: "GET"
        };
        r.getData(n, function(e) {
            var r = t.currentTarget.dataset.index, o = t.currentTarget.dataset.idx;
            a.data.content[r].footprint.splice(o, 1), a.setData({
                content: a.data.content
            });
        });
    },
    navigatorLink: function(t) {
        o.navClick(t, this);
    }
});