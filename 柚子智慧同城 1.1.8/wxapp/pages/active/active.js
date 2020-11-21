function t(t, a, i) {
    return a in t ? Object.defineProperty(t, a, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = i, t;
}

var a = getApp();

a.Base({
    data: {
        lng: 0,
        lat: 0,
        temList: {
            mask: !1,
            classify: [],
            banner: {
                list: [],
                root: ""
            },
            choose: 0,
            flag: 1
        }
    },
    onClassifyTap: function(a) {
        var i, o = a.currentTarget.dataset.idx;
        this.setData((i = {}, t(i, "temList.choose", o), t(i, "temList.mask", !1), t(i, "list", {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            none: !1,
            data: []
        }), i)), this.loadListData();
    },
    onNavTap: function(a) {
        var i, o = a.currentTarget.dataset.idx;
        this.setData((i = {}, t(i, "temList.flag", o), t(i, "list", {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            none: !1,
            data: []
        }), i)), this.loadListData();
    },
    onTaggleTap: function() {
        this.setData(t({}, "temList.mask", !this.data.temList.mask));
    },
    onLoad: function(t) {
        var a = this;
        this.getLatLng(function() {
            return a.onLoadData();
        });
    },
    onLoadData: function() {
        var i = this;
        Promise.all([ a.api.apiGoodsGetCategoryList(), a.api.apiStoreGetBanner({
            type: 2
        }) ]).then(function(a) {
            var o, s = {
                name: "全部",
                id: 0
            };
            a[0].data.unshift(s), i.setData((o = {
                imgRoot: a[0].other.img_root
            }, t(o, "temList.classify", a[0].data), t(o, "temList.banner", {
                list: a[1].data,
                root: a[1].other.img_root
            }), t(o, "show", !0), o)), i.loadListData();
        }).catch(function(t) {
            a.tips(t.msg);
        });
    },
    onChange: function(t) {
        wx.showToast({
            title: "切换到标签 " + (t.detail.index + 1),
            icon: "none"
        });
    },
    loadListData: function() {
        var i, o = this;
        if (!this.data.list.over && !this.data.ajax) {
            this.setData((i = {}, t(i, "list.load", !0), t(i, "ajax", !0), i));
            var s = {
                cat_id: this.data.temList.classify[this.data.temList.choose].id,
                is_status: this.data.temList.flag,
                page: this.data.list.page,
                length: this.data.list.length,
                lng: this.data.lng,
                lat: this.data.lat
            };
            a.api.apiActivityGetActivityList(s).then(function(t) {
                o.data.show || o.setData({
                    show: !0,
                    imgRoot: t.other.img_root
                }), o.dealList(t.data, o.data.list.page);
            }).catch(function(t) {
                a.tips(t.msg);
            });
        }
    },
    onReachBottom: function() {
        this.loadListData();
    },
    onCouponTap: function(t) {
        var i = t.currentTarget.dataset.idx, o = this.data.list.data[i].goods_id, s = this.data.list.data[i].type;
        1 == s ? a.navTo("/base/goodsdetail/goodsdetail?id=" + o) : 2 == s ? a.navTo("/plugin/panic/info/info?id=" + o) : 3 == s ? a.navTo("/base/coupondetail/coupondetail?id=" + o) : 4 == s ? a.navTo("/plugin/spell/info/info?id=" + o + "-0") : 5 == s && a.navTo("/plugin/free/info/info?id=" + o + "-0");
    },
    onShareAppMessage: function(t) {}
});