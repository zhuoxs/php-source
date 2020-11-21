/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
var t = getApp();
t.Base({
    data: {
        page: 1,
        length: 10,
        type: 0,
        sort: "desc",
        num: 2,
        olist: []
    },
    onLoad: function(t) {
        var a = this;
        this.checkLogin(function(t) {
            var o = a;
            wx.getLocation({
                type: "wgs84",
                success: function(a) {
                    o.setData({
                        user_id: t.id,
                        lat: a.latitude,
                        lng: a.longitude
                    }), o.onLoadData()
                },
                fail: function(a) {
                    o.setData({
                        user_id: t.id,
                        show: !0,
                        popAllow: !0
                    })
                }
            })
        }, "/base/coupons/coupons")
    },
    onLoadData: function(a) {
        var o = this,
            n = o.data.olist,
            e = o.data.page,
            s = o.data.length,
            i = {
                type: o.data.type,
                user_id: o.data.user_id,
                sort: o.data.sort,
                lng: o.data.lng,
                lat: o.data.lat,
                page: e,
                length: s,
                hot: 0
            }, c = wx.getStorageSync("setting");
        if (c) {
            var d = c.config.coupon_list_bottom_color ? c.config.coupon_list_bottom_color : 0;
            this.setData({
                coupon_bg: d
            })
        }
        t.api.apIcouponCouponList(i).then(function(t) {
            var a = !(t.data.length < s);
            if (t.data.length < s && o.setData({
                nomore: !0,
                show: !0
            }), 1 == e) n = t.data;
            else for (var i in t.data) n.push(t.data[i]);
            e += 1, o.setData({
                olist: n,
                show: !0,
                hasMore: a,
                page: e,
                img_root: t.other.img_root
            })
        }).
        catch (function(a) {
            a.code, t.tips(a.msg)
        })
    },
    onBtnTap: function() {},
    getValue: function(t) {},
    onTabTap: function(t) {
        var a = this,
            o = t.currentTarget.dataset.index;
        o != a.data.type ? a.setData({
            type: o,
            sort: "desc",
            num: 2,
            page: 1
        }) : 2 == a.data.num ? a.setData({
            sort: "asc",
            num: 1,
            page: 1
        }) : a.setData({
            sort: "desc",
            num: 2,
            page: 1
        }), a.onLoadData()
    },
    handler: function(a) {
        var o = this;
        a.detail.authSetting["scope.userLocation"] ? wx.getLocation({
            type: "wgs84",
            success: function(t) {
                o.setData({
                    lat: t.lat,
                    lng: t.lng,
                    popAllow: !1
                }), o.onLoadData()
            }
        }) : t.tips("获取地址失败")
    },
    onReachBottom: function() {
        var t = this;
        t.data.hasMore ? t.onLoadData() : t.setData({
            nomore: !0
        })
    },
    onGetcouponTap: function(a) {
        var o = a.currentTarget.dataset.id,
            n = a.currentTarget.dataset.store_id;
        t.navTo("/base/coupondetail/coupondetail?id=" + o + "&store_id=" + n)
    },
    onShareAppMessage: function(t) {}
});