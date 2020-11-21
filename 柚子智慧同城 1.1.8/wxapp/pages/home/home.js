var t = getApp(), a = require("../../zhy/component/libs/bmap-wx.min.js"), e = require("../../zhy/resource/js/qqmap-wx-jssdk.min.js");

t.Base({
    data: {
        currentcity: "",
        nav: [ {
            title: "最新信息",
            status: 0
        }, {
            title: "热门商家",
            status: 1
        } ],
        lng: 0,
        lat: 0,
        showcheck: 0,
        curHdIndex: 0,
        page: 1,
        length: 5,
        spage: 1,
        slength: 5,
        olist: [],
        solist: [],
        cat_id: 0,
        oIndex: 0
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("cityaddress");
        e && this.setData({
            cityaddress: e
        }), this.checkLogin(function(t) {
            a.setData({
                show: !0,
                user: t
            }), a.getLatLng(function(t) {
                a.onLoadData(), a.getInfoList();
            });
        }, "/pages/home/home");
    },
    onLoadData: function() {
        var a = this, e = wx.getStorageSync("currentcity");
        e ? this.setData({
            show: !0,
            currentcity: e
        }) : (this.setData({
            show: !0
        }), this.getNowPlace()), this.weather();
        var s = this.data.cityaddress;
        Promise.all([ t.api.apiPoodsGetGoodsList({
            type: 0,
            sort: "desc",
            hot: 1,
            is_status: 1,
            page: 1,
            length: 5,
            lng: this.data.lng,
            lat: this.data.lat
        }), t.api.apIindexMenuIcon(), t.api.apiStoreGetBannerAll({}), t.api.apiIndexGetWeatherDetail(), t.api.apiIndexGetStatistics(), t.api.apiStoreGetStoreList({
            quality_status: 1,
            district_id: 0,
            lng: s ? s.citylng : this.data.lng,
            lat: s ? s.citylat : this.data.lat,
            page: 1,
            length: 5,
            category_id: 0
        }), t.api.apiInfoGetInfosettings(), t.api.apiPinGoodsList({
            is_recommend: 1,
            page: 1,
            length: 5
        }), t.api.apiPanicIndexPanicList({
            lng: this.data.lng,
            lat: this.data.lat,
            page: 1,
            length: 5
        }), t.api.apIcouponCouponList({
            sort: "asc",
            hot: 1,
            page: 1,
            type: 3,
            length: 4,
            lng: this.data.lng,
            lat: this.data.lat
        }), t.api.apiGoodsGetBookGoodsList({
            page: 1,
            length: 5,
            lng: this.data.lng,
            lat: this.data.lat,
            goods_type: 2
        }) ]).then(function(t) {
            var e = t[8].data;
            for (var s in e) 1 != e[s].vip_free ? e[s].show_vip_price = e[s].vip_price : e[s].show_vip_price = "0.00";
            a.setData({
                imgRoot: t[0].other.img_root,
                baseInfo: {
                    goods: t[0].data,
                    nav: {
                        list: t[1].data.length > 0 ? t[1].data : i,
                        root: t[1].other.img_root
                    },
                    banner: {
                        list: t[2].data.index,
                        root: t[2].other.img_root
                    },
                    ad: t[2].data,
                    weather: t[3].data,
                    statistics: t[4].data,
                    store: t[5].data,
                    mes: t[6].data,
                    spell: t[7].data,
                    panic: e,
                    coupon: t[9].data,
                    reserve: t[10].data
                },
                show: !0
            });
        }).catch(function(a) {
            t.tips(a.msg);
        });
    },
    getInfoList: function() {
        var a = this, e = this.data.cityaddress, i = this.data.page, s = this.data.length, n = this.data.olist, o = {
            cat_id: this.data.cat_id,
            sort: 2,
            area_adcode: e ? e.cityadcode : this.data.area_adcode,
            lat: e ? e.citylat : this.data.lat,
            lng: e ? e.citylng : this.data.lng,
            page: i,
            length: s,
            user_id: this.data.user.id
        };
        t.api.apiInfoGetInfoList(o).then(function(t) {
            var e = !(t.data.length < s);
            if (t.data.length < s && a.setData({
                nomore: !0,
                show: !0
            }), 1 == i) n = t.data; else for (var o in t.data) n.push(t.data[o]);
            i += 1, a.setData({
                hasMore: e,
                page: i,
                olist: n,
                show: !0
            });
        }).catch(function(a) {
            t.tips(a.msg);
        });
    },
    onReachBottom: function() {
        var t = this;
        if (0 == t.data.curHdIndex) {
            if (!t.data.hasMore) return void this.setData({
                nomore: !0
            });
            t.getInfoList();
        } else if (1 == t.data.curHdIndex) {
            if (!t.data.shasMore) return void this.setData({
                nomore: !0
            });
            t.getStore();
        }
    },
    getStore: function() {
        var a = this, e = this.data.cityaddress, i = this.data.spage, s = this.data.slength, n = this.data.solist;
        t.api.apiStoreGetStoreList({
            is_recommend: 1,
            district_id: 0,
            sort: 0,
            lng: e ? e.citylng : this.data.lng,
            lat: e ? e.citylat : this.data.lat,
            page: i,
            length: s,
            category_id: 0
        }).then(function(t) {
            var e = !(t.data.length < s);
            if (t.data.length < s && a.setData({
                nomore: !0,
                show: !0
            }), 1 == i) n = t.data; else for (var o in t.data) n.push(t.data[o]);
            i += 1, a.setData({
                shasMore: e,
                spage: i,
                solist: n,
                show: !0
            });
        }).catch(function(a) {
            t.tips(a.msg);
        });
    },
    getNowPlace: function() {
        var a = this, i = wx.getStorageSync("setting") ? wx.getStorageSync("setting") : a.data.showcheck, s = 0;
        t.siteInfo.version == i.config.version && 1 == i.config.showcheck && (s = 1), a.setData({
            showcheck: s
        });
        var n = this.data.cityaddress;
        new e({
            key: i.config.map_key
        }).reverseGeocoder({
            location: {
                latitude: n ? n.citylat : a.data.lat,
                longitude: n ? n.citylng : a.data.lng
            },
            success: function(t) {
                var e = t.result;
                a.setData({
                    area_adcode: e.ad_info.adcode,
                    currentcity: e.ad_info.district
                });
            }
        });
    },
    weather: function() {
        var t = this, e = wx.getStorageSync("setting");
        new a.BMapWX({
            ak: e.config.ak
        }).weather({
            fail: function(t) {
                console.log("fail!");
            },
            success: function(a) {
                var e = a.currentWeather[0];
                t.setData({
                    weatherData: e
                });
            }
        });
    },
    getSetting: function(t) {
        wx.setNavigationBarTitle({
            title: t.detail.config.index_title
        }), this.setData({
            support: t.detail
        });
    },
    onTelTap: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.currentTarget.dataset.tel
        });
    },
    getUserInfo: function(a) {
        t.globalData.userInfo = a.detail.userInfo, this.setData({
            userInfo: a.detail.userInfo,
            hasUserInfo: !0
        });
    },
    swichNav: function(t) {
        var a = t.currentTarget.dataset.status;
        1 == a && (this.setData({
            curHdIndex: a,
            spage: 1
        }), this.getStore()), this.setData({
            curHdIndex: a,
            page: 1
        });
    },
    onPreviewTap: function(t) {
        for (var a = this, e = t.currentTarget.dataset.index, i = t.currentTarget.dataset.idx, s = a.data.olist[e].pics, n = [], o = 0; o < s.length; o++) n[o] = a.data.imgRoot + s[o];
        wx.previewImage({
            urls: n,
            current: n[i]
        });
    },
    onLikeTap: function(a) {
        var e = this, i = a.currentTarget.dataset.id;
        t.api.apiInfoSetLike({
            user_id: this.data.user.id,
            id: i
        }).then(function(t) {
            e.setData({
                page: 1
            }), e.getInfoList();
        }).catch(function(a) {
            t.tips(a.msg);
        });
    },
    onPanicListTap: function() {
        t.navTo("/plugin/panic/list/list");
    },
    onCouponTap: function(a) {
        var e = a.currentTarget.dataset.idx, i = this.data.baseInfo.panic[e].id;
        t.navTo("/plugin/panic/info/info?id=" + i);
    },
    onTypeTap: function(t) {
        var a = t.currentTarget.dataset.idx;
        this.setData({
            oIndex: a
        });
    },
    toggleShare: function() {
        this.setData({
            share: !this.data.share
        });
    },
    onShareAppMessage: function(t) {
        return {
            title: wx.getStorageSync("setting").config.index_title,
            path: "/pages/home/home"
        };
    },
    goDetails: function(t) {
        wx.navigateTo({
            url: "/pages/index/psDetails/psDetails"
        });
    },
    onGoodsListTap: function() {
        t.navTo("/base/goodslist/goodslist?id=");
    },
    onGoodsTap: function(a) {
        var e = a.currentTarget.dataset.idx, i = this.data.baseInfo.goods[e].id;
        t.navTo("/base/goodsdetail/goodsdetail?id=" + i);
    },
    toCityTap: function() {
        t.navTo("/base/city/city");
    },
    onGoodsdetailTap: function(a) {
        var e = a.currentTarget.dataset.id;
        t.navTo("/base/goodsdetail/goodsdetail?id=" + e);
    },
    onStoredetailTap: function(a) {
        var e = a.currentTarget.dataset.id;
        t.navTo("/base/merchantsinfo/merchantsinfo?id=" + e);
    },
    toInfoTap: function(a) {
        t.navTo("/base/circledetail/circledetail?id=" + a.currentTarget.dataset.id);
    },
    onReleaseTap: function() {
        t.navTo("/pages/release/release");
    },
    onApplyTap: function() {
        t.navTo("/base/apply/apply");
    },
    onSearchTap: function() {
        t.navTo("/base/search/search");
    },
    onSpellListTap: function() {
        t.navTo("/plugin/spell/list/list");
    },
    onSpellTap: function(a) {
        var e = a.currentTarget.dataset.idx, i = this.data.baseInfo.spell[e].id;
        t.navTo("/plugin/spell/info/info?id=" + i + "-0");
    },
    onReservedetailTap: function(a) {
        var e = a.currentTarget.dataset.idx, i = this.data.baseInfo.reserve[e].id;
        t.navTo("/base/reservedetail/reservedetail?id=" + i + "&goods_type=2");
    },
    onCouponListTap: function() {
        t.navTo("/base/coupons/coupons");
    },
    onGetcouponTap: function(a) {
        var e = a.currentTarget.dataset.id;
        t.navTo("/base/coupondetail/coupondetail?id=" + e);
    },
    onReserveTap: function() {
        t.navTo("/base/reserve/reserve");
    }
});

var i = [ {
    clickago_icon: "",
    clickafter_icon: "",
    pic: "/zhy/resource/images/application/mormal.png",
    title: "普通商品",
    url: "/base/goodslist/goodslist",
    path: "",
    appid: "",
    link_type: 1,
    typeid: "",
    choose: !1
} ];