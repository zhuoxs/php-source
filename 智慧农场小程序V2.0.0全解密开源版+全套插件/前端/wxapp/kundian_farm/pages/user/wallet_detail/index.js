var t = new getApp(), a = t.siteInfo.uniacid;

Page({
    data: {
        list: [],
        page: 1
    },
    onLoad: function(t) {
        this.getList(1, 0);
    },
    getList: function(i, e) {
        var n = this, s = wx.getStorageSync("kundian_farm_uid");
        1 == e && (i = parseInt(i) + 1), t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "user",
                op: "getDetail",
                uid: s,
                uniacid: a,
                page: i
            },
            success: function(t) {
                if (console.log(t), 1 == e) {
                    var a = t.data.list, s = n.data.list;
                    a.map(function(t) {
                        s.push(t);
                    }), n.setData({
                        list: s,
                        page: i
                    });
                } else n.setData({
                    list: t.data.list,
                    page: 1
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onReachBottom: function() {
        var t = this.data.page;
        this.getList(t, 1);
    }
});