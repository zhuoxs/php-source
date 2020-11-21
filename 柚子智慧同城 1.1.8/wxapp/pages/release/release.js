function t(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

function a(t, a) {
    for (var e = [], n = 0; n < t.length; n++) t[n].icon = a + t[n].icon;
    for (var r = 0; r < t.length; r += 10) e.push(t.slice(r, r + 10));
    return e;
}

var e = getApp(), n = require("../../zhy/template/wxParse/wxParse.js");

e.Base({
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
        }
    },
    onLoad: function(a) {
        var e = this;
        this.checkLogin(function(a) {
            e.setData({
                user: a
            }), e.getLatLng(function(a) {
                if (a) {
                    var n;
                    e.setData((n = {}, t(n, "param.lng", a.lng), t(n, "param.lat", a.lat), n));
                }
                return e.onLoadData();
            });
        }, "/pages/release/release");
    },
    onLoadData: function() {
        var t = this;
        Promise.all([ e.api.apiInfoGetInfosettings(), e.api.apiInfoGetInfocategory({
            parent_id: 0
        }) ]).then(function(e) {
            var r = a(e[1].data, e[1].other.img_root), i = e[0].data.disclaimer;
            n.wxParse("detail", "html", i, t, 20), t.setData({
                imgRoot: e[1].other.img_root,
                show: !0,
                nav: r
            });
        }).catch(function(t) {
            e.tips(t.msg);
        });
    },
    bindChange: function(t) {
        this.setData({
            currentTab: t.detail.current
        });
    },
    swichNav: function(t) {
        var a = this;
        if (this.data.currentTab === t.target.dataset.current) return !1;
        a.setData({
            currentTab: t.target.dataset.current
        });
    },
    toDetailTap: function(t) {
        var a = t.currentTarget.dataset.id - 0;
        e.navTo("/base/releaseedit/releaseedit?id=" + a);
    },
    getSetting: function(t) {
        this.setData({
            support: t.detail
        });
    },
    onCidxTap: function(t) {
        var a = this, n = t.currentTarget.dataset.index - 0, r = t.currentTarget.dataset.idx - 0, i = this.data.nav[n][r].id;
        e.api.apiInfoGetInfocategory({
            parent_id: i
        }).then(function(t) {
            t.data.length > 0 ? a.setData({
                categoryWin: !0,
                categorySub: t.data
            }) : e.navTo("/base/releaseedit/releaseedit?id=" + i);
        }).catch(function(t) {
            e.tips(t.msg);
        });
    },
    close: function() {
        this.setData({
            categoryWin: !1
        });
    },
    toggleShare: function() {
        this.setData({
            share: !this.data.share
        });
    },
    onShareAppMessage: function(t) {
        return {
            title: "发布页",
            path: "/pages/release/release"
        };
    }
});