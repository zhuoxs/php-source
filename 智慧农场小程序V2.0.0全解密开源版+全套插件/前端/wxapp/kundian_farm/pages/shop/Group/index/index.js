var a = new getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        SystemInfo: a.globalData.sysData,
        isIphoneX: a.globalData.isIphoneX,
        goodsData: [],
        page: 1,
        farmSetData: [],
        tarbar: wx.getStorageSync("kundianFarmTarbar"),
        is_tarbar: !1
    },
    onLoad: function(o) {
        var r = this, e = (wx.getStorageSync("kundian_farm_uid"), !1);
        o.is_tarbar && (e = o.is_tarbar), r.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData"),
            tarbar: wx.getStorageSync("kundianFarmTarbar"),
            is_tarbar: e
        }), a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "group",
                op: "getGroupGoods",
                uniacid: t
            },
            success: function(a) {
                r.setData({
                    goodsData: a.data.goodsData
                });
            }
        }), a.util.setNavColor(t);
    },
    onReachBottom: function(o) {
        var r = this, e = r.data, s = (e.type_id, e.page), n = e.goodsData;
        wx.getStorageSync("kundian_farm_uid");
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "group",
                op: "getGroupGoods",
                uniacid: t,
                page: s
            },
            success: function(a) {
                if (a.data.goodsData) {
                    for (var t = a.data.goodsData, o = 0; o < t.length; o++) n.push(t[o]);
                    r.setData({
                        goodsData: n,
                        page: parseInt(s) + 1
                    });
                }
            }
        });
    },
    intoGroupDetail: function(a) {
        var t = a.currentTarget.dataset.goodsid;
        wx.navigateTo({
            url: "../proDetails/index?goods_id=" + t
        });
    }
});