var app = getApp();

Page({
    data: {
        nav: [ {
            title: "全部",
            status: 0
        }, {
            title: "已支付",
            status: 1
        }, {
            title: "待确认",
            status: 2
        }, {
            title: "已完成",
            status: 3
        }, {
            title: "退款/售后",
            status: 5
        } ],
        curHdIndex: 0,
        show: !1,
        page: 1,
        limit: 5,
        list: []
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("userInfo");
        this.setData({
            store_id: t.id,
            curHdIndex: t.ostatus,
            uInfo: a
        });
    },
    onShow: function() {
        this.setData({
            page: 1
        }), this.loadData();
    },
    loadData: function() {
        var s = this, i = s.data.list, o = s.data.limit, r = s.data.page;
        app.ajax({
            url: "Cstore|getStoreOrders",
            data: {
                store_id: s.data.store_id,
                page: r,
                limit: o,
                state: s.data.curHdIndex
            },
            success: function(t) {
                var a = t.data.length == o;
                if (1 == r) i = t.data; else for (var e in t.data) i.push(t.data[e]);
                r += 1, s.setData({
                    list: i,
                    show: !0,
                    hasMore: a,
                    page: r,
                    imgroot: t.other.img_root
                });
            }
        });
    },
    swichNav: function(t) {
        var a = t.currentTarget.dataset.status;
        this.setData({
            curHdIndex: a,
            page: 1
        }), this.loadData();
    },
    onReachBottom: function() {
        this.data.hasMore ? this.loadData() : wx.showToast({
            title: "没有更多订单啦~",
            icon: "none"
        });
    },
    toOrderDetail: function(t) {
        var a = t.currentTarget.dataset.id;
        app.navTo("/sqtg_sun/pages/zkx/pages/merchants/orderdetail/orderdetail?id=" + a);
    },
    onShareAppMessage: function() {}
});