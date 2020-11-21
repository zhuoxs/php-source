var t = new getApp(), a = t.siteInfo.uniacid;

Page({
    data: {
        status: -1,
        page: 1,
        list: [],
        is_content: !0
    },
    onLoad: function(t) {
        var a = this, e = (wx.getStorageSync("kundian_farm_uid"), a.data.page);
        a.getRecord(-1, e);
    },
    getRecord: function(e, s, n) {
        var i = wx.getStorageSync("kundian_farm_uid"), r = this, c = r.data.list;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "user",
                op: "getWithdrawRecord",
                uniacid: a,
                uid: i,
                status: e
            },
            success: function(t) {
                if (1 == n) {
                    var a = t.data.list;
                    a && a.map(function(t) {
                        c.push(t);
                    }), r.setData({
                        list: c,
                        is_content: !0
                    });
                } else t.data.list.length > 0 ? r.setData({
                    list: t.data.list,
                    is_content: !0
                }) : r.setData({
                    is_content: !1
                });
            }
        });
    },
    showDesc: function(t) {
        var a = t.currentTarget.dataset.id, e = this.data.records;
        e.map(function(t) {
            if (t.id == a) {
                var e = t.show;
                t.show = !e;
            }
        }), this.setData({
            records: e
        });
    },
    changeStatus: function(t) {
        var a = t.currentTarget.dataset.index, e = this, s = e.data.page;
        e.getRecord(a, s), e.setData({
            status: a,
            page: 1
        });
    },
    onReachBottom: function() {
        var t = this, a = t.data.status, e = parseInt(t.data.page) + 1;
        t.getRecord(a, e, 1), t.setData({
            status: a,
            page: e
        });
    }
});