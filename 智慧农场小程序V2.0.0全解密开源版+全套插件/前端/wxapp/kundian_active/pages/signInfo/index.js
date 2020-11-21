var i = new getApp(), a = i.siteInfo.uniacid;

Page({
    data: {
        sign: []
    },
    onLoad: function(t) {
        var n = this, e = t.active_id, s = i.util.url("entry/wxapp/active") + "m=kundian_farm_plugin_active";
        wx.request({
            url: s,
            data: {
                op: "getSignInfo",
                uniacid: a,
                active_id: e
            },
            success: function(i) {
                n.setData({
                    sign: i.data.signInfo
                });
            }
        }), i.util.setNavColor();
    }
});