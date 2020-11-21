var t = require("../../../../../wxParse/wxParse.js"), a = new getApp(), e = a.siteInfo.uniacid;

Page({
    data: {
        goodsid: "",
        goodsData: [],
        specItem: [],
        is_show: 1,
        count: 1,
        price: "",
        spec_src: "",
        spec_id: "",
        farmSetData: []
    },
    onLoad: function(s) {
        var o = s.goods_id, i = this;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getIntegralGoodsDetail",
                uniacid: e,
                goods_id: o,
                control: "integral"
            },
            success: function(a) {
                var e = a.data, s = e.goodsData, d = e.specItem;
                i.setData({
                    goodsData: s,
                    specItem: d,
                    goodsid: o
                }), "" != s.goods_desc && t.wxParse("article", "html", s.goods_desc, i, 5);
            }
        }), a.util.setNavColor(e);
        var d = 0;
        a.globalData.sysData.model.indexOf("iPhone X") > -1 && (d = 68), i.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData"),
            bottom: d
        });
    },
    hideModal: function() {
        this.setData({
            is_show: 1
        });
    },
    reduceNum: function() {
        1 != this.data.count && this.setData({
            count: this.data.count - 1
        });
    },
    addNum: function() {
        this.setData({
            count: this.data.count + 1
        });
    },
    chooseNum: function(t) {
        this.setData({
            count: t.detail.value
        });
    },
    doExchange: function(t) {
        var a = this, e = wx.getStorageSync("kundian_farm_uid");
        if (void 0 != e && 0 != e) {
            var s = a.data, o = s.goodsData, i = s.goodsid, d = s.count;
            1 == o.is_open_sku ? a.setData({
                is_show: 2
            }) : wx.navigateTo({
                url: "../orderConfrim/index?goodsid=" + i + "&count=" + d
            });
        } else wx.navigateTo({
            url: "../../../login/index"
        });
    },
    selectSpec: function(t) {
        for (var s = this, o = s.data, i = o.goodsid, d = o.specItem, c = t.currentTarget.dataset, n = c.specid, r = c.valid, u = new Array(), l = 0; l < d.length; l++) {
            d[l].id == n && (d[l].select_spec = 1);
            for (var g = 0; g < d[l].specVal.length; g++) d[l].id == n && (d[l].specVal[g].select_val = 0), 
            d[l].specVal[g].id == r && (d[l].specVal[g].select_val = 1), 1 == d[l].specVal[g].select_val && u.push(d[l].specVal[g].id);
        }
        var p = u.join(",");
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getSpec",
                uniacid: e,
                spec_id: p,
                goodsid: i,
                control: "integral"
            },
            success: function(t) {
                if (t.data.specVal) {
                    var a = t.data;
                    s.setData({
                        price: a.price,
                        spec_src: a.spec_src,
                        spec_id: a.id,
                        specItem: d
                    });
                } else s.setData({
                    specItem: d
                });
            }
        });
    },
    sureGoods: function(t) {
        var a = this.data, e = a.goodsid, s = a.spec_id, o = a.count;
        if (1 == a.goodsData.is_open_sku) {
            if ("" == s && 0 == s.length) return wx.showToast({
                title: "请选择规格"
            }), !1;
            wx.navigateTo({
                url: "../orderConfrim/index?goodsid=" + e + "&spec_id=" + s + "&count=" + o
            });
        } else wx.navigateTo({
            url: "../orderConfrim/index?goodsid=" + e + "&count=" + o
        });
    }
});