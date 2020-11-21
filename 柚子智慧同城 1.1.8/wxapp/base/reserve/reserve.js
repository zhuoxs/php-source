/*www.lanrenzhijia.com   time:2019-06-01 22:11:54*/
function t(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t
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
                success: function(e) {
                    t.setData({
                        user_id: a.id,
                        lat: e.latitude,
                        lng: e.longitude
                    }), t.onLoadData()
                },
                fail: function(e) {
                    t.setData({
                        user_id: a.id,
                        show: !0,
                        popAllow: !0
                    })
                }
            })
        }, "/base/reserce/reserce")
    },
    onLoadData: function(t) {
        var e = this;
        Promise.all([a.api.apiGoodsGetCategoryList(), a.api.apiStoreGetBannerAll()]).then(function(t) {
            var a = {
                name: "全部",
                id: 0
            };
            t[0].data.unshift(a), e.setData({
                imgRoot: t[0].other.img_root,
                classify: t[0].data,
                banner: {
                    list: t[1].data.book,
                    root: t[1].other.img_root
                },
                show: !0
            }), e.loadListData()
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
        var e, o = this;
        if (!this.data.list.over && !this.data.ajax) {
            this.setData((e = {}, t(e, "list.load", !0), t(e, "ajax", !0), e));
            var i = {
                cat_id: this.data.classify[this.data.choose].id,
                is_status: 1,
                page: this.data.list.page,
                length: this.data.list.length,
                sort: this.data.flag,
                goods_type: 2
            };
            2 == this.data.flag && (2 == this.data.order_type || 0 == this.data.order_type ? (i.order_type = 1, this.setData({
                order_type: 1
            })) : (i.order_type = 2, this.setData({
                order_type: 2
            }))), a.api.apiPoodsGetGoodsList(i).then(function(t) {
                o.data.show || o.setData({
                    show: !0,
                    imgRoot: t.other.img_root
                }), o.dealList(t.data, o.data.list.page)
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
        var e = t.currentTarget.dataset.idx,
            o = this.data.list.data[e].id;
        a.navTo("/base/reservedetail/reservedetail?id=" + o + "&goods_type=2")
    },
    handler: function(t) {
        var e = this;
        t.detail.authSetting["scope.userLocation"] ? wx.getLocation({
            type: "wgs84",
            success: function(t) {
                e.setData({
                    lat: t.lat,
                    lng: t.lng,
                    popAllow: !1
                }), e.onLoadData()
            }
        }) : a.tips("获取地址失败")
    },
    onShareAppMessage: function(t) {}
});