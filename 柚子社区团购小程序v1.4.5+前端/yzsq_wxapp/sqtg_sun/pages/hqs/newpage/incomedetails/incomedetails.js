var app = getApp();

Page({
    data: {
        currenttab: 1,
        shopId: "",
        type: 1,
        commissionData: [],
        page: 1,
        limit: 15,
        hasMore: !0,
        isData: !1
    },
    onLoad: function(t) {
        var a = this;
        console.log(t.shopId), a.setData({
            shopId: t.shopId
        }), app.ajax({
            url: "Cstore|details",
            data: {
                store_id: t.shopId,
                type: a.data.type,
                ordertype: "desc",
                orderfield: "create_time",
                limit: this.data.limit
            },
            success: function(t) {
                console.log(t), a.setData({
                    commissionData: t.data
                });
            }
        });
    },
    onCommission: function(t) {
        var a = this;
        if (a.setData({
            page: 1,
            limit: 15,
            hasMore: !0
        }), t) {
            if (this.data.currenttab == t.currentTarget.dataset.tabid) return !1;
            this.setData({
                currenttab: t.currentTarget.dataset.tabid,
                type: t.currentTarget.dataset.tabid
            });
        }
        console.log(a.data.shopId), console.log(t.currentTarget.dataset.tabid), app.ajax({
            url: "Cstore|details",
            data: {
                store_id: a.data.shopId,
                type: t.currentTarget.dataset.tabid,
                ordertype: "desc",
                orderfield: "create_time",
                limit: a.data.limit
            },
            success: function(t) {
                console.log(t), a.setData({
                    commissionData: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var s = this;
        console.log("上拉触底"), s.data.hasMore ? (s.setData({
            page: ++s.data.page,
            limit: s.data.limit
        }), app.ajax({
            url: "Cstore|details",
            data: {
                store_id: s.data.shopId,
                type: s.data.type,
                page: s.data.page,
                limit: s.data.limit,
                ordertype: "desc",
                orderfield: "create_time"
            },
            success: function(t) {
                console.log(t);
                var a = s.data.commissionData.concat(t.data), e = parseInt(t.other.count), o = s.data.page * s.data.limit < e;
                s.setData({
                    commissionData: a,
                    hasMore: o
                });
            }
        })) : wx.showToast({
            title: "没有更多数据了",
            icon: "none"
        });
    }
});