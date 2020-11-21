/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
function t(t, a, i) {
    return a in t ? Object.defineProperty(t, a, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = i, t
}
var a = getApp(),
    i = require("../../zhy/template/wxParse/wxParse.js");
a.Base({
    data: {
        share: !1
    },
    getSetting: function(t) {
        this.setData({
            support: t.detail
        })
    },
    onLoad: function(t) {
        var a = this,
            i = wx.getStorageSync("cityaddress");
        i && this.setData({
            cityaddress: i
        }), this.setData({
            id: t.id
        }), this.checkLogin(function(t) {
            var i = a;
            wx.getLocation({
                type: "wgs84",
                success: function(a) {
                    i.setData({
                        user: t,
                        lat: a.latitude,
                        lng: a.longitude
                    }), i.onLoadData(t)
                },
                fail: function(a) {
                    i.setData({
                        user: t,
                        show: !0,
                        popAllow: !0
                    })
                }
            })
        }, "/base/merchantsinfo/merchantsinfo?id=" + t.id)
    },
    onLoadData: function(t) {
        var o = this,
            e = this.data.cityaddress;
        a.api.apiStoreGetStoreDetail({
            user_id: t.id,
            id: this.data.id,
            lat: e ? e.citylat : this.data.lat,
            lng: e ? e.citylng : this.data.lng
        }).then(function(t) {
            i.wxParse("content", "html", t.data.details, o, 10);
            var a = t.data.service ? t.data.service.split(",") : "";
            o.setData({
                imgRoot: t.other.img_root,
                info: t.data,
                show: !0,
                service: a
            })
        }).
        catch (function(t) {
            a.tips(t.msg)
        })
    },
    onTelTap: function(t) {
        a.phone(this.data.info.tel)
    },
    onMapTap: function() {
        var t = this.data.cityaddress;
        a.map(t ? t.citylat : this.data.info.lat, t ? t.citylng : this.data.info.lng)
    },
    onCollectTap: function() {
        var i = this,
            o = (this.data.info.is_collection, {
                user_id: this.data.user.id,
                store_id: this.data.id
            });
        this.data.ajax || (this.data.ajax = !0, a.api.apiStoreSetcancelCollection(o).then(function(a) {
            "收藏成功" == a.data ? i.setData(t({}, "info.is_collection", 1)) : "取消成功" == a.data && i.setData(t({}, "info.is_collection", 0)), setTimeout(function() {
                i.data.ajax = !1
            }, 500)
        }).
        catch (function(t) {
            setTimeout(function() {
                i.data.ajax = !1
            }, 500), a.tips(t.msg)
        }))
    },
    onPosterTab: function() {
        var t = this;
        if (this.data.info.logo && "" != this.data.info.logo) if (this.setData({
            share: !1
        }), wx.showLoading({
            title: "海报生成中..."
        }), this.data.posterUrl) wx.hideLoading(), wx.previewImage({
            current: this.data.posterUrl,
            urls: [this.data.posterUrl]
        });
        else {
            var i = {
                link: "base/merchantsinfo/merchantsinfo?id=" + this.data.id + "&s_id=" + this.data.user.id,
                width: 120
            };
            a.api.apiGetQRCode(i).then(function(a) {
                wx.showLoading({
                    title: "海报生成中..."
                }), t.setData({
                    posterinfo: {
                        delRoot: a.data.path,
                        bg: t.data.support.config.poster_goods ? t.data.imgRoot + t.data.support.config.poster_goods : "",
                        img: a.other.img_root + t.data.info.logo,
                        avatar: t.data.user.avatar,
                        qr: a.other.img_root + a.data.path,
                        title: t.data.info.name,
                        price: t.data.info.per_consumption - 0 > 0 ? "特享人均￥" + t.data.info.per_consumption : -1,
                        name: t.data.user.nickname,
                        hot: t.data.info.popularity > 0 ? "人气：" + t.data.info.popularity : "",
                        is_pic: t.data.info.posterpic ? a.other.img_root + t.data.info.posterpic : null,
                        recommend: "特别值得推荐的店"
                    },
                    loadImgKey: !0
                }), console.log(t.data.posterinfo)
            }).
            catch (function(t) {
                a.tips(t.msg)
            })
        } else a.tips("没有商家封面图！")
    },
    createPoster: function(t) {
        var a = t.detail;
        this.setData({
            posterUrl: a.url
        }), wx.hideLoading(), wx.previewImage({
            current: this.data.posterUrl,
            urls: [this.data.posterUrl]
        })
    },
    toggleShare: function() {
        this.setData({
            share: !this.data.share
        })
    },
    onHomeTap: function() {
        a.lunchTo("/pages/home/home")
    },
    onShareAppMessage: function() {
        var t = this;
        return this.setData({
            share: !1
        }), {
            title: "发现一家好店（" + t.data.info.name + ")",
            path: "/base/merchantsinfo/merchantsinfo?id=" + t.data.id
        }
    },
    handler: function(t) {
        var i = this;
        t.detail.authSetting["scope.userLocation"] ? wx.getLocation({
            type: "wgs84",
            success: function(t) {
                i.setData({
                    lat: t.lat,
                    lng: t.lng,
                    popAllow: !1
                }), i.onLoadData()
            }
        }) : a.tips("获取地址失败")
    },
    onGoodsTap: function(t) {
        var i = t.currentTarget.dataset.idx;
        a.navTo("/base/goodsdetail/goodsdetail?id=" + i)
    },
    onGoodsListTap: function() {
        a.navTo("/base/goodslist/goodslist?id=")
    },
    toHomeTap: function() {
        a.lunchTo("/pages/home/home")
    },
    onSpellTap: function(t) {
        var i = t.currentTarget.dataset.idx,
            o = this.data.info.pinlist[i].id;
        a.navTo("/plugin/spell/info/info?id=" + o + "-0")
    },
    onSpellListTap: function() {
        a.navTo("/plugin/spell/list/list")
    },
    onPanicListTap: function() {
        a.navTo("/plugin/panic/list/list")
    },
    onCouponTap: function(t) {
        var i = t.currentTarget.dataset.idx,
            o = this.data.info.paniclist[i].id;
        a.navTo("/plugin/panic/info/info?id=" + o)
    },
    onReserveTap: function() {
        a.navTo("/base/reserve/reserve")
    },
    onReservedetailTap: function(t) {
        var i = t.currentTarget.dataset.idx,
            o = this.data.info.bookgoodslist[i].id;
        a.navTo("/base/reservedetail/reservedetail?id=" + o + "&goods_type=2")
    }
});