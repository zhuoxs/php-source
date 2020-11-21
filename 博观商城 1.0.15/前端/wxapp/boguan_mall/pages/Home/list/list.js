var t = require("../../../utils/base.js"), a = require("../../../../api.js"), e = new t.Base(), o = getApp();

Page({
    data: {
        selectIndex: -1,
        CateProduct: [],
        loadmore: !0,
        loadnot: !1,
        page: 1,
        size: 20
    },
    onLoad: function(t) {
        console.log(t);
        var a = this;
        a.setData({
            cateId: t.cateId,
            selectIndex: t.cateId,
            cateType: t.cateType ? t.cateType : "",
            parent_id: t.parent_id
        }), a.getListGoods(t.cateId), 0 == t.parent_id ? a.getChildCate(t.cateId) : a.getChildCate(t.parent_id), 
        o.pageOnLoad();
        var e = wx.getStorageSync("userData");
        e.user_info ? this.setData({
            is_vip: e.user_info.is_vip
        }) : this.getUserData();
    },
    getUserData: function() {
        var t = this, o = {
            url: a.default.user
        };
        e.getData(o, function(a) {
            var e = 0;
            1 == a.errorCode && (wx.setStorageSync("userData", a), e = a.user_info.is_vip, t.setData({
                is_vip: e
            }));
        });
    },
    onReachBottom: function() {
        this.setData({
            page: this.data.page + 1
        }), this.data.loadmore && this.getCateProduct(this.data.cateId);
    },
    switchType: function(t) {
        var a = t.target.id, e = t.target.dataset.secondid;
        this.setData({
            toview: a,
            selectIndex: e,
            CateProduct: [],
            loadmore: !0,
            loadnot: !1,
            page: 1,
            size: 20
        }), this.getListGoods(e);
    },
    getListGoods: function(t) {
        var o = this;
        wx.showLoading({
            title: "请稍后"
        });
        var d = {
            url: a.default.cate_product,
            data: {
                cateId: t,
                page: this.data.page,
                size: this.data.size
            },
            method: "GET"
        };
        e.getData(d, function(t) {
            if (console.log("列表商品res=>", t), setTimeout(function() {
                wx.hideLoading();
            }, 200), t.data.length > 0) for (var a in t.data) t.data[a].price = parseFloat(t.data[a].price), 
            t.data[a].o_price = parseFloat(t.data[a].o_price), t.data[a].vip_price = parseFloat(t.data[a].vip_price);
            var e = o;
            e.data.CateProduct;
            t.data.length > 0 ? (e.data.CateProduct.push.apply(e.data.CateProduct, t.data), 
            e.setData({
                CateProduct: e.data.CateProduct
            }), t.data.length < o.data.size && e.setData({
                loadmore: !1,
                loadnot: !0
            })) : e.setData({
                loadmore: !1,
                loadnot: !0
            });
        });
    },
    getChildCate: function(t) {
        var o = this, d = {
            url: a.default.cate_child,
            data: {
                cateId: t
            },
            method: "GET"
        };
        console.log("分类参数=>", d), e.getData(d, function(t) {
            console.log("分类=>", t), t.data.length > 0 && o.setData({
                SecondCate: t.data
            });
        });
    },
    navigatorLink: function(t) {
        console.log(t), o.navClick(t, this);
    }
});