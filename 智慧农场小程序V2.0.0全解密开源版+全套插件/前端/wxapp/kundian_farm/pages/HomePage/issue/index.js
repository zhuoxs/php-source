var t = new getApp(), a = t.siteInfo.uniacid;

Page({
    data: {
        currentType: 1,
        currentId: 0,
        parentData: [],
        typeData: [],
        setData: [],
        farmSetData: []
    },
    onLoad: function(e) {
        var r = this;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "problem",
                op: "getData",
                uniacid: a
            },
            success: function(t) {
                var a = t.data, e = a.parentData, n = a.typeData, s = a.setData;
                r.setData({
                    parentData: e,
                    typeData: n,
                    setData: s
                });
            }
        }), t.util.setNavColor(a), r.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData")
        });
    },
    changeType: function(e) {
        var r = e.currentTarget.dataset.type, n = this;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "problem",
                op: "changeType",
                uniacid: a,
                pid: r
            },
            success: function(t) {
                n.setData({
                    typeData: t.data.typeData
                });
            }
        }), this.setData({
            currentType: r
        });
    },
    showDesc: function(t) {
        var a = t.currentTarget.dataset.id, e = this.data, r = e.typeData;
        e.currentId;
        r.map(function(t) {
            t.items.map(function(t) {
                if (a == t.id) {
                    var e = t.isShow;
                    t.isShow = !e;
                } else t.isShow = !1;
            });
        }), this.setData({
            typeData: r,
            currentId: a
        });
    }
});