/*www.lanrenzhijia.com   time:2019-06-01 22:11:53*/
function t(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t
}
var a = getApp(),
    e = require("../../zhy/resource/js/qqmap-wx-jssdk.min.js");
a.Base({
    data: {
        navtab: [{
            title: "全部",
            id: 0
        }],
        curHdIndex: 0,
        page: 1,
        length: 10,
        olist: [],
        address: "",
        topcat_id: 0,
        cat_id: 0,
        showchoice: !0
    },
    onLoad: function(a) {
        var e = this,
            i = wx.getStorageSync("cityaddress");
        i && this.setData({
            cityaddress: i
        }), this.checkLogin(function(i) {
            e.setData({
                topcat_id: a.cat_id || 0,
                show: !0,
                user: i
            }), e.getInfocategory(), e.getLatLng(function(a) {
                if (a) {
                    var i;
                    e.setData((i = {}, t(i, "param.lng", a.lng), t(i, "param.lat", a.lat), i))
                }
                return e.onLoadData()
            })
        }, "/pages/circlesub/circlesub")
    },
    onLoadData: function() {
        var t = this,
            e = this.data.cityaddress,
            i = this.data.page,
            n = this.data.length,
            s = this.data.olist,
            d = {
                topcat_id: this.data.topcat_id,
                cat_id: this.data.cat_id,
                sort: 0,
                area_adcode: e ? e.cityadcode : this.data.area_adcode,
                lat: e ? e.citylat : this.data.lat,
                lng: e ? e.citylng : this.data.lng,
                page: i,
                length: n,
                user_id: this.data.user.id
            };
        a.api.apiInfoGetInfoList(d).then(function(a) {
            var e = !(a.data.length < n);
            if (a.data.length < n && t.setData({
                nomore: !0,
                show: !0
            }), 1 == i) s = a.data;
            else for (var d in a.data) s.push(a.data[d]);
            i += 1, t.setData({
                imgRoot: a.other.img_root,
                show: !0,
                hasMore: e,
                page: i,
                olist: s
            })
        }).
        catch (function(t) {
            a.tips(t.msg)
        })
    },
    getInfocategory: function() {
        var t = this;
        Promise.all([a.api.apiInfoGetInfosettings(), a.api.apiInfoGetInfocategory({
            parent_id: this.data.topcat_id
        })]).then(function(a) {
            t.getNowPlace(a[0].data.map_key);
            var e = t.data.navtab;
            a[1].data.forEach(function(t) {
                e.push({
                    title: t.name,
                    id: t.id
                })
            }), t.setData({
                navtab: e,
                mes: a[0].data
            })
        }).
        catch (function(t) {
            a.tips(t.msg)
        })
    },
    getNowPlace: function(t) {
        var a = this,
            i = this.data.cityaddress;
        new e({
            key: t
        }).reverseGeocoder({
            location: {
                latitude: i ? i.citylat : a.data.lat,
                longitude: i ? i.citylng : a.data.lng
            },
            success: function(t) {
                var e = t.result;
                a.setData({
                    area_adcode: e.ad_info.adcode,
                    address: e.address
                })
            }
        })
    },
    getAddress: function(a) {
        var e, i = a.detail;
        this.setData((e = {}, t(e, "param.lat", i.latitude), t(e, "param.lng", i.longitude), t(e, "address", i.address), e))
    },
    onCidxTap: function(t) {
        var a = t.currentTarget.dataset.index - 0,
            e = t.currentTarget.dataset.idx - 0,
            i = this.data.nav[a][e].id;
        this.setData({
            page: 1,
            cat_id: i
        }), this.onLoadData()
    },
    swichNav: function(t) {
        var a = this,
            e = t.currentTarget.dataset.id;
        a.setData({
            curHdIndex: e,
            page: 1,
            cat_id: e
        }), this.onLoadData()
    },
    onReachBottom: function() {
        var t = this;
        t.data.hasMore ? t.onLoadData() : this.setData({
            nomore: !0
        })
    },
    onLikeTap: function(t) {
        var e = this,
            i = t.currentTarget.dataset.id;
        a.api.apiInfoSetLike({
            user_id: this.data.user.id,
            id: i
        }).then(function(t) {
            e.setData({
                page: 1
            }), e.onLoadData()
        }).
        catch (function(t) {
            a.tips(t.msg)
        })
    },
    onPreviewTap: function(t) {
        for (var a = this, e = t.currentTarget.dataset.index, i = t.currentTarget.dataset.idx, n = a.data.olist[e].pics, s = [], d = 0; d < n.length; d++) s[d] = a.data.imgRoot + n[d];
        wx.previewImage({
            urls: s,
            current: s[i]
        })
    },
    toggleShare: function() {
        this.setData({
            share: !this.data.share
        })
    },
    onShareAppMessage: function(t) {
        return {
            title: "圈子",
            path: "/pages/circle/circle"
        }
    },
    getSetting: function(t) {
        this.setData({
            support: t.detail
        })
    },
    onTelTap: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.tel
        })
    },
    toInfoTap: function(t) {
        a.navTo("/base/circledetail/circledetail?id=" + t.currentTarget.dataset.id)
    }
});