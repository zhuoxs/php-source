var t = new getApp(), a = t.util.getNewUrl("entry/wxapp/store", "kundian_farm_plugin_store");

Page({
    data: {
        live: [],
        farmSetData: wx.getStorageSync("kundian_farm_setData")
    },
    onLoad: function(e) {
        var i = this, r = e.id;
        t.util.setNavColor(t.siteInfo.uniacid), wx.request({
            url: a,
            data: {
                control: "index",
                op: "playVideo",
                id: r
            },
            success: function(t) {
                var a = t.data.live, e = a.src, r = [];
                e && (r = e.split(":")), i.setData({
                    src_xy: r,
                    live: a
                });
            }
        });
    }
});