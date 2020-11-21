var t = new getApp(), a = t.siteInfo.uniacid;

Page({
    data: {
        records: []
    },
    onLoad: function(i) {
        var r = this;
        t.util.setNavColor(a);
        var e = wx.getStorageSync("kundian_farm_uid"), s = t.util.getNewUrl("entry/wxapp/withdraw", "kundian_farm_plugin_play");
        wx.request({
            url: s,
            data: {
                op: "getWithdrawList",
                uniacid: a,
                uid: e
            },
            success: function(t) {
                console.log(t), r.setData({
                    records: t.data.withdrawList
                });
            }
        });
    },
    showDesc: function(t) {
        var a = t.currentTarget.dataset.id, i = this.data.records;
        i.map(function(t) {
            if (t.id == a) {
                var i = t.show;
                t.show = !i;
            }
        }), this.setData({
            records: i
        });
    }
});