var t = require("../../../utils/base.js"), a = require("../../../../api.js"), e = new t.Base(), o = getApp();

Page({
    data: {
        loadmore: !0,
        loadnot: !1,
        Switch: 0,
        page: 1,
        size: 20,
        product: [],
        content: []
    },
    onLoad: function(t) {
        o.pageOnLoad(), this.getCollection(this.data.Switch);
        var a = wx.getStorageSync("userData");
        a.user_info ? this.setData({
            is_vip: a.user_info.is_vip
        }) : this.getUserData();
    },
    onReachBottom: function() {
        this.setData({
            page: this.data.page + 1
        }), this.data.loadmore && this.getCollection(this.data.Switch);
    },
    getUserData: function() {
        var t = this, o = {
            url: a.default.user
        };
        e.getData(o, function(a) {
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
            loadnot: !1
        }), this.getCollection(this.data.Switch);
    },
    getCollection: function() {
        var t = this, o = {
            url: a.default.user_collect,
            data: {
                page: this.data.page,
                size: this.data.size
            }
        };
        e.getData(o, function(a) {
            console.log("收藏数据=>", a);
            var e = t;
            e.data.product, e.data.content;
            if (a.product.data.length > 0) for (var o in a.product.data) a.product.data[o].price = parseFloat(a.product.data[o].price), 
            a.product.data[o].o_price = parseFloat(a.product.data[o].o_price), a.product.data[o].vip_price = parseFloat(a.product.data[o].vip_price);
            0 == t.data.Switch ? a.product.data.length > 0 ? (e.data.product.push.apply(e.data.product, a.product.data), 
            e.setData({
                product: e.data.product,
                collect: !1
            }), a.product.data.length < t.data.size && e.setData({
                loadmore: !1,
                loadnot: !0
            })) : e.setData({
                loadmore: !1,
                loadnot: !0,
                collect: !0
            }) : a.content.data.length > 0 ? (e.data.content.push.apply(e.data.content, a.content.data), 
            e.setData({
                content: e.data.content,
                collect: !1
            }), a.content.data.length < t.data.size && e.setData({
                loadmore: !1,
                loadnot: !0
            })) : e.setData({
                loadmore: !1,
                loadnot: !0,
                collect: !0
            });
        });
    },
    delProduct: function(t) {
        var o = this, d = {
            url: a.default.Del_pcollect,
            data: {
                productId: t.currentTarget.dataset.id
            }
        };
        e.getData(d, function(a) {
            if (1 == a.errorCode) {
                var e = t.currentTarget.dataset.index;
                o.data.product.splice(e, 1), o.setData({
                    product: o.data.product,
                    content: []
                });
            }
        });
    },
    delNews: function(t) {
        var o = this, d = {
            url: a.default.Del_collect,
            data: {
                contentId: t.currentTarget.dataset.id
            }
        };
        e.getData(d, function(a) {
            if (1 == a.errorCode) {
                var e = t.currentTarget.dataset.index;
                o.data.content.splice(e, 1), o.setData({
                    content: o.data.content,
                    product: []
                });
            }
        });
    },
    navigatorLink: function(t) {
        console.log(t), o.navClick(t, this);
    }
});