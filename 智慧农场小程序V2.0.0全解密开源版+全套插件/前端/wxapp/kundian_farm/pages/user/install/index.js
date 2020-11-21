var n = new getApp(), e = n.siteInfo.uniacid;

Page({
    data: {
        phone: ""
    },
    onLoad: function(a) {
        var t = wx.getStorageSync("kundian_farm_uid"), i = (wx.getStorageSync("kundian_farm_setData"), 
        this);
        n.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "index",
                op: "getUserBindPhone",
                uid: t,
                uniacid: e
            },
            success: function(n) {
                i.setData({
                    phone: n.data.userInfo.phone
                });
            }
        }), n.util.setNavColor(e);
    },
    phone: function() {
        wx.navigateTo({
            url: "../phone/index"
        });
    },
    real_name: function() {
        wx.navigateTo({
            url: "../identity/index"
        });
    },
    safety: function() {
        wx.navigateTo({
            url: "../accountSecurity/index"
        });
    },
    intoDesc: function(n) {
        wx.navigateTo({
            url: "/kundian_farm/pages/HomePage/about/index"
        });
    }
});