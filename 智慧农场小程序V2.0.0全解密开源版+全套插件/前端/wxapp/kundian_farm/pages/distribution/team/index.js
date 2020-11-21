var a = new getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        currentId: 1,
        saleData: [],
        page: 1,
        isContent: !0
    },
    onLoad: function(a) {
        var t = this.data, e = t.currentId, n = t.page;
        this.getSaleData(e, n);
    },
    getSaleData: function(e, n, s) {
        wx.showLoading({
            title: "玩命加载中..."
        });
        var i = this, o = wx.getStorageSync("kundian_farm_uid"), r = i.data, d = r.saleData, u = r.isContent;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "distribution",
                op: "getSaleTeam",
                uniacid: t,
                uid: o,
                current: e,
                page: n
            },
            success: function(a) {
                1 == s ? a.data.one_sale && (a.data.one_sale.map(function(a) {
                    d.push(a);
                }), i.setData({
                    saleData: d,
                    page: n
                })) : (u = a.data.one_sale.length > 0, i.setData({
                    saleData: a.data.one_sale,
                    page: 1,
                    isContent: u
                })), wx.hideLoading();
            }
        });
    },
    changeId: function(a) {
        var t = a.currentTarget.dataset.id;
        this.getSaleData(t, 1), this.setData({
            currentId: t
        });
    },
    onReachBottom: function(a) {
        var t = this.data, e = t.currentId, n = t.page;
        n = parseInt(n) + 1, this.getSaleData(e, n, 1);
    }
});