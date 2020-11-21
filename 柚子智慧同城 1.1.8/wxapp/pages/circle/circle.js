function t(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

function a(t, a) {
    for (var e = [], i = 0; i < t.length; i++) ;
    for (var n = 0; n < t.length; n += 10) e.push(t.slice(n, n + 10));
    return e;
}

var e = getApp(), i = require("../../zhy/resource/js/qqmap-wx-jssdk.min.js");

e.Base({
    data: {
        navtab: [ {
            title: "最新置顶",
            status: 1
        }, {
            title: "最新发布",
            status: 2
        }, {
            title: "最近距离",
            status: 3
        } ],
        curHdIndex: 1,
        page: 1,
        length: 10,
        olist: [],
        address: "",
        cat_id: 0,
        showchoice: !0
    },
    onLoad: function(a) {
        var e = this, i = wx.getStorageSync("cityaddress");
        i && this.setData({
            cityaddress: i
        }), this.checkLogin(function(i) {
            e.setData({
                cat_id: a.cat_id || 0,
                show: !0,
                user: i
            }), e.getLatLng(function(a) {
                if (a) {
                    var i;
                    e.setData((i = {}, t(i, "param.lng", a.lng), t(i, "param.lat", a.lat), i));
                }
                e.onLoadData();
            });
        }, "/pages/circle/circle");
    },
    onLoadData: function() {
        var t = this, i = this.data.cityaddress, n = this.data.page, s = this.data.length, r = this.data.olist, o = {
            cat_id: this.data.cat_id,
            sort: this.data.curHdIndex,
            area_adcode: i ? i.cityadcode : this.data.area_adcode,
            lat: i ? i.citylat : this.data.lat,
            lng: i ? i.citylng : this.data.lng,
            page: n,
            length: s,
            user_id: this.data.user.id
        };
        Promise.all([ e.api.apiInfoGetInfosettings(), e.api.apiInfoGetInfocategory({
            parent_id: 0
        }), e.api.apiInfoGetInfoList(o), e.api.apiStoreGetBanner({
            type: 2
        }) ]).then(function(e) {
            t.getNowPlace(e[0].data.map_key);
            var i = a(e[1].data, e[1].other.img_root), o = !(e[2].data.length < s);
            if (e[2].data.length < s && t.setData({
                nomore: !0,
                show: !0
            }), 1 == n) r = e[2].data; else for (var d in e[2].data) r.push(e[2].data[d]);
            n += 1, t.setData({
                imgRoot: e[1].other.img_root,
                mes: e[0].data,
                show: !0,
                nav: i,
                hasMore: o,
                page: n,
                olist: r,
                banner: {
                    list: e[3].data,
                    root: e[3].other.img_root
                }
            });
        }).catch(function(t) {
            e.tips(t.msg);
        });
    },
    getNowPlace: function(t) {
        var a = this, e = this.data.cityaddress;
        new i({
            key: t
        }).reverseGeocoder({
            location: {
                latitude: e ? e.citylat : a.data.lat,
                longitude: e ? e.citylng : a.data.lng
            },
            success: function(t) {
                var e = t.result;
                a.setData({
                    area_adcode: e.ad_info.adcode,
                    address: e.address
                });
            }
        });
    },
    getAddress: function(a) {
        var e, i = a.detail;
        this.setData((e = {}, t(e, "param.lat", i.latitude), t(e, "param.lng", i.longitude), 
        t(e, "address", i.address), e));
    },
    onCidxTap: function(t) {
        var a = this, i = t.currentTarget.dataset.index - 0, n = t.currentTarget.dataset.idx - 0, s = this.data.nav[i][n].id;
        e.api.apiInfoIsSecondInfocategory({
            id: s
        }).then(function(t) {
            "有帖子下级分类" == t.data && e.navTo("/base/circlesub/circlesub?cat_id=" + s);
        }).catch(function(t) {
            a.setData({
                page: 1,
                cat_id: s
            }), a.onLoadData();
        });
    },
    swichNav: function(t) {
        var a = this, e = t.currentTarget.dataset.status;
        a.setData({
            curHdIndex: e,
            page: 1
        }), this.onLoadData();
    },
    onReachBottom: function() {
        var t = this;
        t.data.hasMore ? t.onLoadData() : this.setData({
            nomore: !0
        });
    },
    onLikeTap: function(t) {
        var a = this, i = t.currentTarget.dataset.id;
        e.api.apiInfoSetLike({
            user_id: this.data.user.id,
            id: i
        }).then(function(t) {
            a.setData({
                page: 1
            }), a.onLoadData();
        }).catch(function(t) {
            e.tips(t.msg);
        });
    },
    onPreviewTap: function(t) {
        for (var a = this, e = t.currentTarget.dataset.index, i = t.currentTarget.dataset.idx, n = a.data.olist[e].pics, s = [], r = 0; r < n.length; r++) s[r] = a.data.imgRoot + n[r];
        wx.previewImage({
            urls: s,
            current: s[i]
        });
    },
    toggleShare: function() {
        this.setData({
            share: !this.data.share
        });
    },
    onShareAppMessage: function(t) {
        return {
            title: "圈子",
            path: "/pages/circle/circle"
        };
    },
    getSetting: function(t) {
        this.setData({
            support: t.detail
        });
    },
    onTelTap: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.tel
        });
    },
    toInfoTap: function(t) {
        e.navTo("/base/circledetail/circledetail?id=" + t.currentTarget.dataset.id);
    }
});