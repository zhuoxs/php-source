var t = new getApp(), e = t.util.getNewUrl("entry/wxapp/store", "kundian_farm_plugin_store");

Page({
    data: {
        isContent: !0,
        browse: [],
        store_id: 0,
        page: 1
    },
    onLoad: function(o) {
        var a = this, s = o.store_id;
        t.util.setNavColor(), wx.showLoading({
            title: "玩命加载中...."
        }), wx.request({
            url: e,
            data: {
                control: "store",
                op: "browseRecord",
                store_id: s
            },
            success: function(t) {
                wx.hideLoading();
                var e = !0;
                t.data.browse || (e = !1), a.setData({
                    browse: t.data.browse,
                    store_id: s,
                    isContent: e
                });
            }
        });
    },
    onReachBottom: function() {
        var t = this;
        wx.showLoading({
            title: "玩命加载中...."
        });
        var o = t.data, a = o.browse, s = o.page, r = o.store_id;
        s = parseInt(s) + 1, wx.request({
            url: e,
            data: {
                control: "store",
                op: "browseRecord",
                store_id: r,
                page: s
            },
            success: function(e) {
                wx.hideLoading();
                var o = e.data.browse;
                o && (o.map(function(t, e) {
                    a.push(t);
                }), t.setData({
                    browse: a,
                    page: s
                }));
            }
        });
    }
});