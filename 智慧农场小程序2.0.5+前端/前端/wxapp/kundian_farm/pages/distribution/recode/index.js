var t = new getApp(), a = t.siteInfo.uniacid;

Page({
    data: {
        status: -1,
        page: 1,
        list: [],
        isContent: !0
    },
    onLoad: function(t) {
        wx.getStorageSync("kundian_farm_uid");
        var a = this.data.page;
        this.getRecord(-1, a);
    },
    getRecord: function(s, e, i) {
        var n = wx.getStorageSync("kundian_farm_uid"), r = this, o = r.data, d = o.list, u = o.isContent;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "distribution",
                op: "getWithdrawRecord",
                uniacid: a,
                uid: n,
                status: s
            },
            success: function(t) {
                if (1 == i) {
                    var a = t.data.list;
                    a && a.map(function(t) {
                        d.push(t);
                    }), r.setData({
                        list: d
                    });
                } else u = t.data.list.length > 0, r.setData({
                    list: t.data.list,
                    isContent: u
                });
            }
        });
    },
    showDesc: function(t) {
        var a = t.currentTarget.dataset.id, s = this.data.records;
        s.map(function(t) {
            if (t.id == a) {
                var s = t.show;
                t.show = !s;
            }
        }), this.setData({
            records: s
        });
    },
    changeStatus: function(t) {
        var a = t.currentTarget.dataset.index, s = this.data.page;
        this.getRecord(a, s), this.setData({
            status: a,
            page: 1
        });
    },
    onReachBottom: function() {
        var t = this.data.status, a = t.status, s = t.page;
        s = parseInt(s) + 1, this.getRecord(a, s, 1), this.setData({
            status: a,
            page: s
        });
    }
});