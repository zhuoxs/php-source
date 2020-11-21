/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
var t = getApp(),
    a = require("../../zhy/resource/js/qqmap-wx-jssdk.min.js");
t.Base({
    data: {
        key: "",
        page: 1,
        length: 10,
        olist: [],
        address: "",
        cat_id: 0
    },
    onLoad: function(t) {
        var a = this,
            e = wx.getStorageSync("cityaddress");
        e && this.setData({
            cityaddress: e
        }), this.checkLogin(function(t) {
            a.setData({
                user: t
            }), a.getLatLng(function(t) {
                a.onLoadData()
            })
        }, "/pages/circle/circle")
    },
    onLoadData: function() {
        var a = this,
            e = this.data.cityaddress,
            i = this.data.page,
            s = this.data.length,
            n = this.data.olist,
            o = {
                cat_id: this.data.cat_id,
                sort: 0,
                area_adcode: e ? e.cityadcode : this.data.area_adcode,
                lat: e ? e.citylat : this.data.lat,
                lng: e ? e.citylng : this.data.lng,
                page: i,
                length: s,
                user_id: this.data.user.id,
                key: this.data.key
            };
        Promise.all([t.api.apiInfoGetInfosettings(), t.api.apiInfoGetInfoList(o)]).then(function(t) {
            a.getNowPlace(t[0].data.map_key);
            var e = !(t[1].data.length < s);
            if (t[1].data.length < s && a.setData({
                nomore: !0,
                show: !0
            }), 1 == i) n = t[1].data;
            else for (var o in t[1].data) n.push(t[1].data[o]);
            i += 1, a.setData({
                imgRoot: t[1].other.img_root,
                show: !0,
                hasMore: e,
                page: i,
                olist: n,
                mes: t[0].data
            })
        }).
        catch (function(a) {
            t.tips(a.msg)
        })
    },
    getNowPlace: function(t) {
        var e = this,
            i = this.data.cityaddress;
        new a({
            key: t
        }).reverseGeocoder({
            location: {
                latitude: i ? i.citylat : e.data.lat,
                longitude: i ? i.citylng : e.data.lng
            },
            success: function(t) {
                var a = t.result;
                e.setData({
                    area_adcode: a.ad_info.adcode,
                    address: a.address
                })
            }
        })
    },
    onReachBottom: function() {
        var t = this;
        t.data.hasMore ? t.onLoadData() : this.setData({
            nomore: !0
        })
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
    toInfoTap: function(a) {
        t.navTo("/base/circledetail/circledetail?id=" + a.currentTarget.dataset.id)
    },
    onPreviewTap: function(t) {
        for (var a = this, e = t.currentTarget.dataset.index, i = t.currentTarget.dataset.idx, s = a.data.olist[e].pics, n = [], o = 0; o < s.length; o++) n[o] = a.data.imgRoot + s[o];
        wx.previewImage({
            urls: n,
            current: n[i]
        })
    },
    onLikeTap: function(a) {
        var e = this,
            i = a.currentTarget.dataset.id;
        t.api.apiInfoSetLike({
            user_id: this.data.user.id,
            id: i
        }).then(function(t) {
            e.setData({
                page: 1
            }), e.onLoadData()
        }).
        catch (function(a) {
            t.tips(a.msg)
        })
    },
    formSubmit: function(t) {
        var a = t.detail.value.key.trim();
        this.setData({
            page: 1,
            key: a
        }), this.onLoadData()
    }
});