var a = new getApp();

Page({
    data: {
        adoptData: [],
        statusData: [],
        adopt_id: "",
        page: 1,
        state: 1,
        isslaugHter: !1,
        farmSetData: [],
        isShow: !1,
        is_loading: !0,
        src_xy: []
    },
    onLoad: function(t) {
        var s = this, e = a.siteInfo.uniacid, i = t.adopt_id;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "animal",
                op: "getAdoptDetail",
                uniacid: e,
                adopt_id: i
            },
            success: function(a) {
                var t = a.data, e = t.adoptData, o = t.statusData, r = e.live_src, n = [];
                r && (n = r.split(":")), s.setData({
                    adoptData: e,
                    statusData: o,
                    adopt_id: i,
                    src_xy: n
                });
            }
        }), s.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData")
        }), a.util.setNavColor(e);
    },
    onReachBottom: function(t) {
        var s = this, e = a.siteInfo.uniacid, i = s.data, o = i.adopt_id, r = i.statusData, n = i.page;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "animal",
                op: "getStatusData",
                uniacid: e,
                adopt_id: o,
                page: n
            },
            success: function(a) {
                if (a.data.statusData) {
                    for (var t = a.data.statusData, e = 0; e < t.length; e++) r.push(t[e]);
                    s.setData({
                        statusData: r,
                        page: parseInt(n) + 1
                    });
                }
            }
        });
    },
    preImg: function(a) {
        for (var t = this.data.statusData, s = a.currentTarget.dataset, e = s.sid, i = s.index, o = [], r = 0; r < t.length; r++) t[r].id == e && (o = t[r].src);
        wx.previewImage({
            current: o[i],
            urls: o
        });
    },
    kellSend: function(a) {
        var t = this.data.adopt_id;
        wx.navigateTo({
            url: "../../user/confirmOrder/index?adopt_id=" + t
        });
    },
    slaugHter: function() {
        this.setData({
            isslaugHter: !0
        });
    },
    preventTouchMove: function() {},
    showVideo: function() {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    play: function(a) {
        this.setData({
            is_loading: !1
        });
    },
    lookOrder: function(a) {
        var t = a.currentTarget.dataset.orderid;
        wx.navigateTo({
            url: "/kundian_farm/pages/shop/Group/orderDetails/index?order_id=" + t
        });
    }
});