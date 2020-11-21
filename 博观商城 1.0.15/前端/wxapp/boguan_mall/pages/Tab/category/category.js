function t(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var a = require("../../../utils/base.js"), e = require("../../../../api.js"), o = new a.Base(), r = getApp();

Page({
    data: {
        currentTab: 0,
        specSwitch: !1,
        goodsNum: 1,
        page: 1,
        size: 20,
        currentPage: 0,
        loadmore: !0,
        loadnot: !1,
        cateGoodsArray: []
    },
    onLoad: function(t) {
        this.getCategory(), r.pageOnLoad();
        var a = wx.getStorageSync("userData");
        a.user_info ? this.setData({
            is_vip: a.user_info.is_vip
        }) : this.getUserData();
    },
    onShow: function() {
        var t = this;
        r.userInfoAuth(function(a) {
            t.setData({
                infoAuth: a
            });
        });
    },
    getUserData: function() {
        var t = this, a = {
            url: e.default.user
        };
        o.getData(a, function(a) {
            var e = 0;
            1 == a.errorCode && (wx.setStorageSync("userData", a), e = a.user_info.is_vip), 
            t.setData({
                userData: a,
                is_vip: e
            });
        });
    },
    getUserInfo: function(t) {
        var a = this;
        wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] && wx.getUserInfo({
                    success: function(t) {
                        r.userInfoAuth(function(t) {
                            a.setData({
                                infoAuth: t
                            });
                        }), wx.setStorageSync("userInfo", t.userInfo), r.updateToken(function(a) {
                            if ("undefined" != a) {
                                var r = {
                                    url: e.default.user_update,
                                    data: {
                                        nickname: t.userInfo.nickName,
                                        avatar: t.userInfo.avatarUrl
                                    }
                                };
                                o.getData(r, function(t) {});
                            }
                        });
                    }
                });
            }
        });
    },
    scrollClick: function(t) {
        var a = t.target.offsetTop;
        this.setData({
            currentTab: t.target.dataset.id,
            FirstId: t.target.dataset.id,
            Fbanner: t.target.dataset.img,
            Fname: t.target.dataset.name,
            SecondCate: this.data.category[t.target.dataset.index].second || [],
            link: this.data.category[t.target.dataset.index].link || [],
            page: 1,
            size: 20,
            loadmore: !0,
            loadnot: !1,
            cateGoodsArray: [],
            currentPage: 0,
            cateId: t.target.dataset.id,
            scrollTop: 0
        });
        var e = wx.createAnimation({
            duration: 200,
            timingFunction: "ease-in"
        });
        this.animation = e, e.top(a + 17).step(), this.setData({
            animationData: this.animation.export()
        }), 4 == this.data.cateType && this.getCategoryGoods(t.target.dataset.id);
    },
    getMoreGoods: function(t) {
        this.setData({
            page: this.data.page + 1
        }), 4 == this.data.cateType && this.data.loadmore && this.getCategoryGoods(this.data.cateId);
    },
    getCategory: function() {
        var t = this, a = {
            url: e.default.category,
            method: "GET"
        };
        o.getData(a, function(a) {
            console.log("分类数据=>", a), 1 == a.errorCode && (4 == a.type && t.getCategoryGoods(a.data[0].id), 
            t.setData({
                cateId: a.data[0].id,
                category: a.data,
                cateType: a.type,
                Fbanner: a.data[0].image,
                Fname: a.data[0].name,
                SecondCate: 1 != a.type && 4 != a.type ? a.data[0].second : [],
                link: 1 != a.type && 4 != a.type ? a.data[0].link : []
            }));
        });
    },
    getCategoryGoods: function(a) {
        var r = this, i = this, s = {
            url: e.default.category,
            method: "GET",
            data: {
                cateId: a,
                page: this.data.page,
                size: this.data.size
            }
        };
        o.getData(s, function(a) {
            r.data.cateGoodsArray;
            var e = r.data.currentPage;
            if (1 == a.errorCode) {
                if (a.product.data.length > 0 && 4 == a.type) for (var o in a.product.data) a.product.data[o].price = parseFloat(a.product.data[o].price), 
                a.product.data[o].o_price = parseFloat(a.product.data[o].o_price), a.product.data[o].vip_price = parseFloat(a.product.data[o].vip_price);
                if (a.product.data.length > 0) {
                    var s;
                    i.setData((s = {}, t(s, "cateGoodsArray[" + e + "]", a.product.data), t(s, "currentPage", e + 1), 
                    s)), a.product.data.length < r.data.size && i.setData({
                        loadmore: !1,
                        loadnot: !0
                    });
                } else i.setData({
                    loadmore: !1,
                    loadnot: !0
                });
            }
            console.log("res=>", a);
        });
    },
    openSpec: function(t) {
        var a = t.currentTarget.dataset.goodinfo, e = a.attr, o = [];
        for (var r in e) {
            var i = {
                title: r,
                attr_Spec: e[r]
            };
            o.push(i);
        }
        this.setData({
            specSwitch: !0,
            newSpec: o,
            goodId: a.id,
            product: a,
            attrInfo: [],
            specValue: [],
            goodsNum: 1
        });
    },
    closeSpec: function(t) {
        this.setData({
            specSwitch: !1
        });
    },
    checkSpec: function(t) {
        var a = this, r = this.data.newSpec, i = (t.target.dataset.attr, t.target.dataset.attrid), s = t.target.dataset.spec, d = [], n = [];
        for (var c in r) if (c == s) for (var u in r[c].attr_Spec) r[c].attr_Spec[u].attr_id == i ? r[c].attr_Spec[u].checked = !0 : r[c].attr_Spec[u].checked = !1;
        for (var c in r) for (var u in r[c].attr_Spec) r[c].attr_Spec[u].checked && (d.push(r[c].attr_Spec[u].attr_id), 
        n.push(r[c].attr_Spec[u].attr_name), this.setData({
            newSpec: r,
            specId: d,
            specValue: n,
            specLength: d.length
        }));
        var p = {
            url: e.default.attr_info,
            data: {
                product_id: this.data.goodId,
                attr_id_list: d
            }
        };
        o.getData(p, function(t) {
            console.log(t), 1 == t.errorCode && (t.data.price = parseFloat(t.data.price), a.setData({
                attrInfo: t.data,
                stock: t.data.stock,
                price: t.data.price
            }));
        });
    },
    myCatchTouch: function(t) {
        return 0;
    },
    add: function() {
        var t = this.data.goodsNum;
        1 == this.data.product.is_attr ? this.data.specLength == this.data.newSpec.length ? t >= this.data.stock ? wx.showToast({
            title: "商品数量超出库存",
            icon: "none"
        }) : this.setData({
            goodsNum: t + 1
        }) : wx.showToast({
            title: "请选择规格",
            icon: "none"
        }) : t >= this.data.product.stock ? wx.showToast({
            title: "商品数量超出库存",
            icon: "none"
        }) : this.setData({
            goodsNum: t + 1
        });
    },
    sum: function() {
        var t = this.data.goodsNum;
        this.setData({
            goodsNum: t - 1
        });
    },
    AddCart: function(t) {
        var a = this;
        wx.showLoading({
            title: "请稍后"
        });
        var r = "";
        1 == this.data.product.is_attr ? this.data.specLength == this.data.newSpec.length ? r = {
            url: e.default.addcart,
            data: {
                product_id: this.data.product.id,
                num: this.data.goodsNum,
                attr_id_list: this.data.specId
            }
        } : wx.showToast({
            title: "请选择规格",
            icon: "none"
        }) : r = {
            url: e.default.addcart,
            data: {
                product_id: this.data.product.id,
                num: this.data.goodsNum
            }
        }, "" != r && o.getData(r, function(t) {
            setTimeout(function() {
                wx.hideLoading({
                    complete: function(a) {
                        wx.showToast({
                            title: t.msg,
                            icon: "none"
                        });
                    }
                });
            }, 500), 1 == t.errorCode && a.setData({
                specSwitch: !1
            }), console.log("加入购物车", t);
        });
    },
    tobuy: function(t) {
        var a = this.data.product;
        1 == this.data.product.is_attr ? this.data.specLength == this.data.newSpec.length ? wx.navigateTo({
            url: "../../User/order/order_pay/order_pay?buyType=0&goodId=" + a.id + "&num=" + this.data.goodsNum + "&attr_id_list=" + this.data.specId + "&specValue=" + this.data.specValue
        }) : wx.showToast({
            title: "请选择规格",
            icon: "none"
        }) : wx.navigateTo({
            url: "../../User/order/order_pay/order_pay?buyType=0&goodId=" + a.id + "&num=" + this.data.goodsNum + "&attr_id_list=&specValue="
        });
    },
    navigatorLink: function(t) {
        r.navClick(t, this);
    }
});