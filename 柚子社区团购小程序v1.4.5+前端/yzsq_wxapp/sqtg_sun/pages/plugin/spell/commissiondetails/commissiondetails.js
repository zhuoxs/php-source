var app = getApp();

Page({
    data: {
        currenttab: 1,
        myleaderid: "",
        type: 1,
        commissionData: [],
        page: 1,
        limit: 10,
        hasMore: !0,
        isData: !1
    },
    onLoad: function(a) {
        var t = this;
        console.log(a.myleaderid), t.setData({
            myleaderid: a.myleaderid
        }), app.ajax({
            url: "Cleader|leaderbill",
            data: {
                leader_id: a.myleaderid,
                type: t.data.type
            },
            success: function(a) {
                console.log(a), t.setData({
                    commissionData: a.data
                });
            }
        });
    },
    onCommission: function(a) {
        var t = this;
        if (t.setData({
            page: 1,
            limit: 10,
            hasMore: !0
        }), a) {
            if (this.data.currenttab == a.currentTarget.dataset.tabid) return !1;
            this.setData({
                currenttab: a.currentTarget.dataset.tabid,
                type: a.currentTarget.dataset.tabid
            });
        }
        app.ajax({
            url: "Cleader|leaderbill",
            data: {
                leader_id: t.data.myleaderid,
                type: a.currentTarget.dataset.tabid
            },
            success: function(a) {
                console.log(a), t.setData({
                    commissionData: a.data
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
        var o = this;
        console.log("上拉触底"), o.data.hasMore ? (o.setData({
            page: ++o.data.page,
            limit: o.data.limit
        }), app.ajax({
            url: "Cleader|leaderbill",
            data: {
                leader_id: o.data.myleaderid,
                type: o.data.type,
                page: o.data.page,
                limit: o.data.limit
            },
            success: function(a) {
                console.log(a);
                var t = o.data.commissionData.concat(a.data), e = parseInt(a.other.count), i = o.data.page * o.data.limit < e;
                o.setData({
                    commissionData: t,
                    hasMore: i
                });
            }
        })) : wx.showToast({
            title: "没有更多数据了",
            icon: "none"
        });
    },
    onShareAppMessage: function() {}
});