/*www.lanrenzhijia.com   time:2019-06-01 22:11:53*/
function t(t, a, o) {
    return a in t ? Object.defineProperty(t, a, {
        value: o,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = o, t
}
var a = getApp();
a.Base({
    data: {
        mask: !1,
        classify: [],
        banner: {
            list: [],
            root: ""
        },
        choose: 0,
        flag: 1,
        order_type: 0
    },
    onClassifyTap: function(t) {
        var a = t.currentTarget.dataset.idx;
        this.setData({
            choose: a,
            mask: !1,
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                none: !1,
                data: []
            }
        }), this.loadListData()
    },
    onNavTap: function(t) {
        var a = t.currentTarget.dataset.idx;
        this.setData({
            flag: a,
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                none: !1,
                data: []
            },
            order_typ: 1
        }), this.loadListData()
    },
    onTaggleTap: function() {
        this.setData({
            mask: !this.data.mask
        })
    },
    onLoad: function(t) {},
    onShow: function() {
        var t = this;
        this.checkLogin(function(a) {
            wx.getLocation({
                type: "wgs84",
                success: function(o) {
                    t.setData({
                        user_id: a.id,
                        lat: o.latitude,
                        lng: o.longitude
                    }), t.onLoadData()
                },
                fail: function(o) {
                    t.setData({
                        user_id: a.id,
                        show: !0,
                        popAllow: !0
                    })
                }
            })
        }, "/base/goodslist/goodslist")
    },
    onLoadData: function(t) {
        var o = this;
        Promise.all([a.api.apiGoodsGetCategoryList(), a.api.apiStoreGetBannerAll({
            type: 5
        })]).then(function(t) {
            var a = {
                name: "全部",
                id: 0
            };
            t[0].data.unshift(a), o.setData({
                imgRoot: t[0].other.img_root,
                classify: t[0].data,
                banner: {
                    list: t[1].data.goods,
                    root: t[1].other.img_root
                },
                show: !0
            }), o.loadListData()
        }).
        catch (function(t) {
            a.tips(t.msg)
        })
    },
    onChange: function(t) {
        wx.showToast({
            title: "切换到标签 " + (t.detail.index + 1),
            icon: "none"
        })
    },
    loadListData: function() {
        var o, i = this;
        if (!this.data.list.over && !this.data.ajax) {
            this.setData((o = {}, t(o, "list.load", !0), t(o, "ajax", !0), o));
            var s = {
                cat_id: this.data.classify[this.data.choose].id,
                is_status: 1,
                page: this.data.list.page,
                length: this.data.list.length,
                sort: this.data.flag
            };
            2 == this.data.flag && (2 == this.data.order_type || 0 == this.data.order_type ? (s.order_type = 1, this.setData({
                order_type: 1
            })) : (s.order_type = 2, this.setData({
                order_type: 2
            }))), a.api.apiPoodsGetGoodsList(s).then(function(t) {
                i.data.show || i.setData({
                    show: !0,
                    imgRoot: t.other.img_root
                }), i.dealList(t.data, i.data.list.page)
            }).
            catch (function(t) {
                a.tips(t.msg)
            })
        }
    },
    onReachBottom: function() {
        this.loadListData()
    },
    onCouponTap: function(t) {
        var o = t.currentTarget.dataset.idx,
            i = this.data.list.data[o].id;
        a.navTo("/base/goodsdetail/goodsdetail?id=" + i)
    },
    handler: function(t) {
        var o = this;
        t.detail.authSetting["scope.userLocation"] ? wx.getLocation({
            type: "wgs84",
            success: function(t) {
                o.setData({
                    lat: t.lat,
                    lng: t.lng,
                    popAllow: !1
                }), o.onLoadData()
            }
        }) : a.tips("获取地址失败")
    },
    onShareAppMessage: function(t) {}
});