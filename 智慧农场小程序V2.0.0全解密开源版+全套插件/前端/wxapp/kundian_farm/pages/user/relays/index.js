var t = new getApp(), a = t.siteInfo.uniacid;

Page({
    data: {
        relays: []
    },
    onLoad: function(t) {
        this.getRelaysData();
    },
    getRelaysData: function() {
        var s = this;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getRelays",
                control: "control",
                uniacid: a
            },
            success: function(t) {
                s.setData({
                    relays: t.data.relays
                });
            }
        });
    },
    controlRelays: function(s) {
        var e = this, n = s.currentTarget.dataset, o = n.id, c = n.status, l = e.data.relays;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "controlRelays",
                id: o,
                status: c,
                control: "control",
                uniacid: a
            },
            success: function(t) {
                wx.showModal({
                    title: "提示",
                    content: t.data.msg,
                    showCancel: !1,
                    success: function(t) {
                        l.map(function(t) {
                            o == t.ID && (t.Status = 1 == c ? 0 : 1);
                        }), e.setData({
                            relays: l
                        });
                    }
                });
            }
        });
    },
    onPullDownRefresh: function(t) {
        this.getRelaysData();
    }
});