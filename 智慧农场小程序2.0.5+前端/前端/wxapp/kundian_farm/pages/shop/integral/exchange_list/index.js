var t = require("../../../../utils/util.js"), a = new getApp(), o = a.siteInfo.uniacid;

Page({
    data: {
        currentType: "综合",
        sort: !0,
        goodsData: [],
        page: 1,
        type_id: "",
        arr: [],
        scrollTop: 0,
        tarrHight: []
    },
    onLoad: function(e) {
        var s = this, r = e.type_id;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "integral",
                op: "getGoodsList",
                type_id: r,
                uniacid: o
            },
            success: function(a) {
                a.data.goodsData ? s.setData({
                    type_id: r,
                    goodsData: a.data.goodsData
                }) : s.setData({
                    type_id: r
                }), t.computeHeight(s, a.data.goodsData, 2);
            }
        }), a.util.setNavColor(o);
    },
    onPageScroll: function(t) {
        for (var a = this, o = t.scrollTop, e = a.data.arr, s = a.data.tarrHight, r = 0; r < a.data.goodsData.length; r++) s[r] < o && 0 == e[r] && (e[r] = !0);
        a.setData({
            arr: e,
            scrollTop: o
        });
    },
    sortPro: function(o) {
        var e = this, s = o.currentTarget.dataset.name, r = o.currentTarget.dataset.rank, i = void 0, d = "";
        s == this.data.currentType ? (i = !this.data.sort, d = "desc") : (i = !0, d = "asc");
        var n = a.siteInfo.uniacid, c = e.data.type_id;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "integral",
                op: "getGoodsList",
                type_id: c,
                uniacid: n,
                rank: r,
                rank_type: d
            },
            success: function(t) {
                t.data.goodsData && e.setData({
                    goodsData: t.data.goodsData
                });
            }
        }), this.setData({
            currentType: s,
            sort: i
        }), t.computeHeight(e, e.data.goodsData, 4), t.returnTop();
    },
    onReachBottom: function(t) {
        var e = this, s = e.data, r = s.type_id, i = s.page, d = s.goodsData;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "integral",
                op: "getGoodsList",
                type_id: r,
                uniacid: o,
                page: i
            },
            success: function(t) {
                if (t.data.goodsData) {
                    for (var a = t.data.goodsData, o = 0; o < a.length; o++) d.push(a[o]);
                    e.setData({
                        type_id: r,
                        goodsData: d,
                        page: parseInt(i) + 1
                    });
                }
            }
        });
    },
    intoGoodsDetail: function(t) {
        var a = t.currentTarget.dataset.goodsid;
        wx.navigateTo({
            url: "../exchangedetails/index?goods_id=" + a
        });
    },
    onShareAppMessage: function() {}
});