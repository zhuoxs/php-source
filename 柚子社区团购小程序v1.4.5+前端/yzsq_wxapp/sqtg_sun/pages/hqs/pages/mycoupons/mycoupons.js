var app = getApp();

Page({
    data: {
        tab1: "已使用",
        tab2: "未使用",
        tab3: "已过期",
        page: 1,
        limit: 7,
        status: 1,
        shouldFiexd: !1,
        tabArr: {
            curHdIndex: 1,
            curBdIndex: 0
        }
    },
    onLoad: function(a) {
        var t = wx.getStorageSync("userInfo") || {};
        null == t.id && wx.navigateTo({
            url: "/sqtg_sun/pages/home/login/login?url=/sqtg_sun/pages/hqs/pages/mycoupons/mycoupons"
        }), this.setData({
            user_id: t.id
        }), this.loadData();
    },
    loadData: function() {
        var o = this, e = o.data.page, n = o.data.limit, a = o.data.status, u = o.data.coupon;
        app.ajax({
            url: "Ccoupon|getMyCoupon",
            data: {
                user_id: o.data.user_id,
                page: e,
                limit: n,
                status: a
            },
            success: function(a) {
                var t = a.data.length == n;
                if (1 == e) u = a.data; else for (var s in a.data) u.push(a.data[s]);
                e += 1, o.setData({
                    coupon: u,
                    page: e,
                    hasMore: t
                });
            }
        });
    },
    onPageScroll: function(a) {
        10 <= a.scrollTop ? this.setData({
            shouldFiexd: !0
        }) : this.setData({
            shouldFiexd: !1
        });
    },
    onReachBottom: function() {
        this.data.hasMore ? this.loadData() : wx.showToast({
            title: "没有更多优惠券啦~",
            icon: "none"
        });
    },
    swichNav: function(a) {
        var t = a.currentTarget.dataset.index, s = a.currentTarget.dataset.status, o = {};
        o.curHdIndex = t, o.curBdIndex = t, this.setData({
            tabArr: o,
            status: s,
            page: 1,
            coupon: []
        }), wx.pageScrollTo({
            scrollTop: 0,
            duration: 400
        }), this.loadData();
    }
});