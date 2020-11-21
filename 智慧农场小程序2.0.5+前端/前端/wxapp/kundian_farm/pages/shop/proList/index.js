var t = new getApp(), a = require("../../../utils/util.js"), o = t.siteInfo.uniacid;

Page({
    data: {
        currentType: "综合",
        sort: !0,
        goodsData: [],
        page: 1,
        type_id: "",
        arr: [],
        scrollTop: 0,
        tarrHight: [],
        farmSetData: []
    },
    onLoad: function(e) {
        var s = this, r = e.type_id || 0, d = e.goods_name || "";
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "shop",
                op: "getGoodsList",
                type_id: r,
                uniacid: o,
                goods_name: d
            },
            success: function(t) {
                var o = t.data.goodsData;
                o ? s.setData({
                    type_id: r,
                    goodsData: o
                }) : s.setData({
                    type_id: r
                }), a.computeHeight(s, o, 4);
            }
        }), t.util.setNavColor(), s.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData")
        });
    },
    onPageScroll: function(t) {
        for (var a = this, o = t.scrollTop, e = a.data, s = e.arr, r = e.tarrHight, d = 0; d < a.data.goodsData.length; d++) r[d] < o + 300 && 0 == s[d] && (s[d] = !0);
        a.setData({
            arr: s,
            scrollTop: o
        });
    },
    sortPro: function(e) {
        var s = this, r = e.currentTarget.dataset, d = r.name, i = r.rank, n = void 0, p = "";
        d == this.data.currentType ? (n = !this.data.sort, p = "desc") : (n = !0, p = "asc");
        var c = s.data.type_id;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "shop",
                op: "getGoodsList",
                type_id: c,
                uniacid: o,
                rank: i,
                rank_type: p
            },
            success: function(t) {
                t.data.goodsData && s.setData({
                    goodsData: t.data.goodsData
                });
            }
        }), this.setData({
            currentType: d,
            sort: n
        }), a.computeHeight(s, s.data.goodsData, 4), a.returnTop();
    },
    onReachBottom: function(a) {
        var e = this, s = e.data, r = s.type_id, d = s.page, i = s.goodsData;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "shop",
                op: "getGoodsList",
                type_id: r,
                uniacid: o,
                page: d
            },
            success: function(t) {
                if (t.data.goodsData) {
                    for (var a = t.data.goodsData, o = 0; o < a.length; o++) i.push(a[o]);
                    e.setData({
                        type_id: r,
                        goodsData: i,
                        page: parseInt(d) + 1
                    });
                }
            }
        });
    },
    intoGoodsDetail: function(t) {
        var a = t.currentTarget.dataset.goodsid;
        wx.navigateTo({
            url: "../prodeteils/index?goodsid=" + a
        });
    }
});