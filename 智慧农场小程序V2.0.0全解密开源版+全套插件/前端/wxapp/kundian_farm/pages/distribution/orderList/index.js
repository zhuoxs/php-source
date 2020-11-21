var t = new getApp(), a = t.siteInfo.uniacid;

Page({
    data: {
        currentIndex: 6,
        orderData: [],
        page: 1,
        order_type: 1,
        isContent: !0
    },
    onLoad: function(t) {
        var e = this, r = t.order_type, n = e.data, d = n.currentIndex, i = n.page;
        e.getOrderData(d, a, i, 0, r), e.setData({
            page: 1,
            order_type: r
        });
    },
    getOrderData: function(a, e, r, n, d) {
        wx.showLoading({
            title: "玩命加载中..."
        });
        var i = this, o = wx.getStorageSync("kundian_farm_uid"), s = i.data, c = s.orderData, u = s.isContent;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "distribution",
                op: "getSaleOrder",
                uniacid: e,
                uid: o,
                status: a,
                page: r,
                order_type: d
            },
            success: function(t) {
                1 == n ? t.data.orderData && t.data.orderData.map(function(t) {
                    c.push(t);
                }) : (c = t.data.orderData, u = !(0 == c.length || !c)), i.setData({
                    orderData: c,
                    isContent: u
                }), wx.hideLoading();
            }
        });
    },
    changeIndex: function(t) {
        var e = t.currentTarget.dataset.index, r = this.data, n = r.page, d = r.order_type;
        this.getOrderData(e, a, n, 0, d), this.setData({
            page: 1,
            currentIndex: e
        });
    },
    isShow: function(t) {
        var a = t.currentTarget.dataset.id, e = this.data.orderData;
        e.map(function(t) {
            if (t.id == a) {
                var e = t.click;
                t.click = !e;
            }
        }), this.setData({
            orderData: e
        });
    },
    onReachBottom: function(t) {
        var e = this.data.currentIndex, r = e.currentIndex, n = e.page, d = e.order_type;
        n = parseInt(n) + 1, this.getOrderData(r, a, n, 1, d), this.setData({
            page: n
        });
    }
});