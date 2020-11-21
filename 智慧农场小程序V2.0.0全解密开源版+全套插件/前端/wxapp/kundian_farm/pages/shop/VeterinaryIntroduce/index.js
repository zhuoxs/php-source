var t = new getApp();

Page({
    data: {
        Veterinary: [],
        setData: []
    },
    onLoad: function(e) {
        var a = this, r = t.siteInfo.uniacid;
        e.title && wx.setNavigationBarTitle({
            title: e.title
        }), t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "user",
                op: "getVetData",
                uniacid: r
            },
            success: function(t) {
                a.setData({
                    Veterinary: t.data.vetData,
                    setData: wx.getStorageSync("kundian_farm_setData")
                });
            }
        }), t.util.setNavColor(r);
    },
    previewImg: function(t) {
        for (var e = this, a = t.currentTarget.dataset.vetid, r = e.data.Veterinary, i = t.currentTarget.dataset.index, n = new Array(), s = 0; s < r.length; s++) a == r[s].id && (n = r[s].certificate);
        console.log(n[i]), wx.previewImage({
            current: n[i],
            urls: n
        });
    }
});