function a(a, t, i) {
    return t in a ? Object.defineProperty(a, t, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = i, a;
}

function t(a, t) {
    for (var i = [], e = 0; e < a.length; e++) a[e].icon = t + a[e].icon;
    for (var n = 0; n < a.length; n += 10) i.push(a.slice(n, n + 10));
    return i;
}

var i = getApp();

i.Base({
    data: {
        param: {
            is_recommend: 1,
            district_id: 0,
            sort: 0,
            lng: 0,
            lat: 0,
            category_id: 0,
            key: "",
            didx: 0
        },
        idx: 0
    },
    onLoad: function(t) {
        var i = this, e = wx.getStorageSync("cityaddress");
        e && this.setData({
            cityaddress: e
        }), this.checkLogin(function(n) {
            var r;
            i.setData((r = {}, a(r, "param.category_id", t.cat_id || 0), a(r, "user", n), r)), 
            i.getLatLng(function(t) {
                if (t) {
                    var n;
                    i.setData((n = {}, a(n, "param.lng", e ? e.citylng : t.lng), a(n, "param.lat", e ? e.citylat : t.lat), 
                    n));
                }
                return i.onLoadData();
            });
        }, "/pages/market/market");
    },
    onLoadData: function() {
        var a = this;
        Promise.all([ i.api.apiStoreGetBanner({
            type: 4
        }), i.api.apiStoreGetStoreCategoryList(), i.api.apiStoreGetStoreDistrictList(), i.api.apiStoreGetMyStore({
            user_id: this.data.user.id
        }), i.api.apiStoreGetNewsestStore() ]).then(function(i) {
            var e = t(i[1].data, i[1].other.img_root), n = {
                id: 0,
                name: "全部"
            };
            i[2].data.unshift(n), a.setData({
                show: !0,
                imgRoot: i[0].other.img_root,
                banner: {
                    list: i[0].data,
                    root: i[0].other.img_root
                },
                nav: e,
                circle: i[2].data,
                shop: i[3].data,
                enterShop: i[4].data
            }), a.loadListData();
        }).catch(function(a) {
            i.tips(a.msg);
        });
    },
    onTaggleTap: function() {
        this.setData({
            mask: !this.data.mask
        });
    },
    onApplyTap: function() {
        i.navTo("/base/apply/apply");
    },
    getKey: function(t) {
        var i = t.detail.value.trim();
        this.setData(a({}, "param.key", i));
    },
    onCidxTap: function(t) {
        var i = t.currentTarget.dataset.index - 0, e = t.currentTarget.dataset.idx - 0;
        this.setData(a({}, "param.category_id", this.data.nav[i][e].id)), this.onSearchTap();
    },
    onDidxTap: function(t) {
        var i, e = t.currentTarget.dataset.idx - 0;
        this.setData((i = {}, a(i, "param.didx", e), a(i, "param.district_id", this.data.circle[e].id), 
        a(i, "mask", !1), i)), this.onSearchTap();
    },
    onSortTap: function(t) {
        var i = t.currentTarget.dataset.idx - 0;
        if (0 == i) {
            var e;
            this.setData((e = {
                idx: i
            }, a(e, "param.is_recommend", 1), a(e, "param.sort", 0), e));
        } else {
            var n;
            this.setData((n = {
                idx: i
            }, a(n, "param.is_recommend", 0), a(n, "param.sort", i), n));
        }
        this.onSearchTap();
    },
    onSearchTap: function() {
        this.setData({
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                none: !1,
                data: []
            }
        }), this.loadListData();
    },
    loadListData: function() {
        var t = this, e = this.data.cityaddress;
        3 == this.data.param.sort && this.data.param.lng <= 0 ? i.location().then(function(n) {
            if (n) {
                var r;
                t.setData((r = {}, a(r, "param.lng", e ? e.citylng : n.lng - 0), a(r, "param.lat", e ? e.citylat : n.lat - 0), 
                r)), t.loadListAjax();
            } else i.tips("请允许定位您的当前位置，以便获取附近商家！"), t.setData({
                list: {
                    load: !1,
                    over: !1,
                    page: 1,
                    length: 10,
                    none: !1,
                    data: []
                }
            });
        }) : this.loadListAjax();
    },
    loadListAjax: function() {
        var t, e = this;
        if (!this.data.list.over && !this.data.ajax) {
            this.setData((t = {}, a(t, "list.load", !0), a(t, "ajax", !0), t));
            var n = this.data.param;
            n.page = this.data.list.page, n.length = this.data.list.length, n.sort = this.data.idx + 1, 
            i.api.apiStoreGetStoreList(n).then(function(a) {
                e.dealList(a.data, e.data.list.page);
            }).catch(function(a) {
                i.tips(a.msg);
            });
        }
    },
    onReachBottom: function() {
        this.loadListData();
    },
    onTelTap: function(a) {
        var t = a.currentTarget.dataset.idx;
        i.phone(this.data.list.data[t].tel);
    },
    openAuth: function(a) {
        a.detail.authSetting["scope.userLocation"] && this.loadListData();
    },
    onShopInfoTap: function(a) {
        var t = a.currentTarget.dataset.idx, e = this.data.list.data[t].id;
        i.navTo("/base/merchantsinfo/merchantsinfo?id=" + e);
    },
    onShareAppMessage: function(a) {}
});