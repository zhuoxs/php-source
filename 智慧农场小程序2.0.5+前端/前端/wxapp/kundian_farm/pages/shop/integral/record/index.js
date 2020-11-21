var a = new getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        recordData: [],
        page: 1,
        sign_title: "",
        isContent: !0
    },
    onLoad: function(e) {
        var r = this, n = wx.getStorageSync("kundian_farm_uid");
        wx.showLoading({
            title: "玩命加载中..."
        }), a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "sign",
                op: "getRecord",
                uniacid: t,
                uid: n
            },
            success: function(a) {
                a.data.recordData ? r.setData({
                    recordData: a.data.recordData
                }) : r.setData({
                    isContent: !1
                }), wx.hideLoading();
            }
        }), a.util.setNavColor(t);
    },
    onReachBottom: function() {
        var e = this, r = wx.getStorageSync("kundian_farm_uid"), n = e.data, o = n.page, i = n.recordData;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "sign",
                op: "getRecord",
                uniacid: t,
                uid: r,
                page: o
            },
            success: function(a) {
                if (a.data.recordData) {
                    for (var t = a.data.recordData, r = 0; r < t.length; r++) i.push(t[r]);
                    e.setData({
                        recordData: i,
                        page: parseInt(o) + 1
                    });
                }
            }
        });
    }
});