var a = require("../../../utils/base.js"), t = require("../../../../api.js"), e = new a.Base();

Page({
    data: {
        pload: !0,
        cload: !0,
        pageOpen: !0,
        Switch: 0,
        page: 1,
        size: 10,
        product: [],
        content: []
    },
    onLoad: function() {
        var a = wx.getStorageSync("userData");
        a.user_info ? this.setData({
            is_vip: a.user_info.is_vip
        }) : this.getUserData();
    },
    onReachBottom: function() {
        this.setData({
            page: this.data.page + 1,
            pageOpen: !1
        }), (this.data.pload || this.data.cload) && this.search(this.data.Switch);
    },
    getUserData: function() {
        var a = this, d = {
            url: t.default.user
        };
        e.getData(d, function(t) {
            var e = 0;
            1 == t.errorCode && (wx.setStorageSync("userData", t), e = t.user_info.is_vip, a.setData({
                is_vip: e
            }));
        });
    },
    tabSwitch: function(a) {
        this.setData({
            Switch: a.currentTarget.dataset.index,
            page: 1,
            size: 10
        });
    },
    keyword: function(a) {
        this.setData({
            keyword: a.detail.value,
            Switch: 0,
            product: [],
            content: [],
            page: 1,
            size: 10,
            pload: !0,
            cload: !0,
            pageOpen: !0
        });
    },
    search: function(a) {
        var d = this, o = {
            url: t.default.search,
            data: {
                keyword: this.data.keyword,
                page: this.data.page,
                size: this.data.size
            }
        };
        console.log(o), e.getData(o, function(a) {
            console.log("搜索内容", a), e.getData(o, function(a) {
                var t = d;
                t.data.product, t.data.content;
                if (1 == a.errorCode) {
                    if (a.data.content.data.length > 0 ? (t.data.content.push.apply(t.data.content, a.data.content.data), 
                    a.data.content.data.length < d.data.size && t.setData({
                        cload: !1
                    }), t.data.content.length > 0 && d.data.pageOpen && t.setData({
                        Switch: 3
                    }), t.setData({
                        content: t.data.content
                    })) : t.setData({}), a.data.product.data.length > 0) for (var e in a.data.product.data) a.data.product.data[e].price = parseFloat(a.data.product.data[e].price), 
                    a.data.product.data[e].o_price = parseFloat(a.data.product.data[e].o_price), a.data.product.data[e].vip_price = parseFloat(a.data.product.data[e].vip_price);
                    a.data.product.data.length > 0 ? (t.data.product.push.apply(t.data.product, a.data.product.data), 
                    a.data.product.data.length < d.data.size && t.setData({
                        pload: !1
                    }), t.data.product.length > 0 && d.data.pageOpen && t.setData({
                        Switch: 2
                    }), t.setData({
                        product: t.data.product
                    })) : t.setData({});
                } else d.setData({
                    page: 1,
                    size: 10
                });
            });
        });
    },
    searchCancel: function() {
        wx.navigateBack({
            delta: 1
        });
    }
});