function t(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var a, e = require("../../../../../wxParse/wxParse.js"), o = new getApp(), s = o.siteInfo.uniacid;

Page({
    data: (a = {
        imgs: [],
        info: {},
        state: !1,
        Position: []
    }, t(a, "state", !1), t(a, "count", 1), t(a, "goodsData", []), t(a, "specItem", []), 
    t(a, "goods_id", ""), t(a, "specVal", ""), t(a, "sku_name_str", ""), t(a, "aboutData", []), 
    t(a, "user_uid", 0), t(a, "farmSetData", []), t(a, "bottom", 0), a),
    onLoad: function(t) {
        var a = this, i = t.goods_id, n = wx.getStorageSync("kundian_farm_uid"), d = t.user_uid;
        void 0 != d && 0 != d && (o.loginBindParent(d, n), a.setData({
            user_uid: d
        })), o.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "group",
                op: "getGroupDetail",
                uniacid: s,
                goods_id: i
            },
            success: function(t) {
                a.setData({
                    goodsData: t.data.goodsData,
                    specItem: t.data.specItem,
                    goods_id: i,
                    aboutData: t.data.aboutData
                }), "" != t.data.goodsData.goods_desc && e.wxParse("article", "html", t.data.goodsData.goods_desc, a, 5);
            }
        });
        var u = 0;
        o.globalData.sysData.model.indexOf("iPhone X") > -1 && (u = 68), o.util.setNavColor(s), 
        a.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData"),
            bottom: u
        });
    },
    onShow: function(t) {
        var a = this, e = a.data.user_uid, s = wx.getStorageSync("kundian_farm_uid");
        void 0 != e && 0 != e && (o.loginBindParent(e, s), a.setData({
            user_uid: e
        }));
    },
    showMode: function() {
        this.setData({
            state: !0
        });
    },
    hideModal: function() {
        this.setData({
            state: !1
        });
    },
    chooseTime: function(t) {
        for (var a = this, e = t.currentTarget.dataset, i = e.spec_id, n = e.valid, d = a.data, u = d.specItem, r = d.goods_id, c = [], l = 0; l < u.length; l++) {
            u[l].id == i && (u[l].is_select = 1);
            for (var g = 0; g < u[l].specVal.length; g++) u[l].id == i && (u[l].specVal[g].is_select = 0), 
            u[l].specVal[g].id == n && (u[l].specVal[g].is_select = 1), 1 == u[l].specVal[g].is_select && c.push(u[l].specVal[g].id);
        }
        var p = c.join("_");
        o.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "group",
                op: "getGroupSpec",
                spec_id: p,
                uniacid: s,
                goods_id: r
            },
            success: function(t) {
                if (1 == t.data.code) a.setData({
                    specVal: t.data.specVal
                }); else if (2 == t.data.code) {
                    for (var e = 0; e < u.length; e++) {
                        u[e].id == i && (u[e].is_select = 1);
                        for (var o = 0; o < u[e].specVal.length; o++) {
                            u[e].specVal[o].id == n && (u[e].specVal[o].is_select = 0, u[e].specVal[o].is_count = 0);
                            for (var s = 0; s < c.length; s++) c[s] == n && c.splice(s, 1);
                        }
                    }
                    wx.showToast({
                        title: "库存不足"
                    }), a.setData({
                        specVal: []
                    });
                }
                a.setData({
                    specItem: u,
                    sku_name_str: t.data.sku_name_str,
                    count: 1
                });
            }
        });
    },
    buyNow: function(t) {
        var a = this, e = wx.getStorageSync("kundian_farm_uid");
        if (0 != e && void 0 != e) {
            var o = a.data, s = o.goodsData, i = o.count;
            1 == s.is_open_sku ? a.setData({
                state: !0
            }) : s.count >= 1 && i > s.count ? wx.navigateTo({
                url: "../confrimOrder/index?goods_id=" + s.id + "&count=" + i
            }) : wx.showToast({
                title: "库存不足"
            });
        } else wx.navigateTo({
            url: "../../../login/index"
        });
    },
    reduceNum: function() {
        1 != this.data.count && this.setData({
            count: this.data.count - 1
        });
    },
    addNum: function() {
        var t = this.data, a = t.specVal, e = t.count, o = t.goodsData;
        if (1 == o.is_open_sku) {
            if ("" == a || 0 == a.length) return wx.showToast({
                title: "请选择规格"
            }), !1;
            parseInt(e) + 1 > a.count ? wx.showToast({
                title: "库存不足"
            }) : this.setData({
                count: this.data.count + 1
            });
        } else parseInt(e) + 1 > o.count ? wx.showToast({
            title: "库存不足"
        }) : this.setData({
            count: this.data.count + 1
        });
    },
    chooseNum: function(t) {
        var a = this.data, e = a.specVal, o = a.goodsData, s = t.detail.value;
        if (1 == o.is_open_sku) {
            if ("" == e || 0 == e.length) return wx.showToast({
                title: "请选择规格"
            }), !1;
            parseInt(s) > e.count ? (wx.showToast({
                title: "库存不足"
            }), this.setData({
                count: 1
            })) : this.setData({
                count: s
            });
        } else parseInt(s) > o.count ? (wx.showToast({
            title: "库存不足"
        }), this.setData({
            count: 1
        })) : this.setData({
            count: s
        });
    },
    goHome: function(t) {
        wx.reLaunch({
            url: "/kundian_farm/pages/HomePage/index/index?is_tarbar=true"
        });
    },
    doCall: function(t) {
        var a = t.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    sureGoods: function(t) {
        var a = this.data, e = a.goods_id, o = a.goodsData, s = (a.specItem, a.count), i = a.specVal, n = wx.getStorageSync("kundian_farm_uid");
        if (0 == n || void 0 == n) wx.navigateTo({
            url: "../../../login/index"
        }); else if (1 == o.is_open_sku) {
            if (0 == i.length || "" == i) return wx.showToast({
                title: "请选择规格"
            }), !1;
            if (i.count >= 1) return i.count >= s ? void wx.navigateTo({
                url: "../confrimOrder/index?goods_id=" + e + "&spec_id=" + i.id + "&count=" + s
            }) : void wx.showToast({
                title: "库存不足"
            });
            wx.showToast({
                title: "库存不足"
            });
        } else {
            if (i.count >= 1) return i.count >= s ? void wx.navigateTo({
                url: "../confrimOrder/index?goods_id=" + e + "&count=" + s
            }) : void wx.showToast({
                title: "库存不足"
            });
            wx.showToast({
                title: "库存不足"
            });
        }
    },
    onShareAppMessage: function() {
        var t = this.data.goodsData, a = wx.getStorageSync("kundian_farm_uid");
        return {
            path: "/kundian_farm/pages/shop/Group/proDetails/index?goods_id=" + t.id + "&user_uid=" + a,
            success: function(t) {},
            title: t.goods_name,
            imageUrl: t.cover
        };
    }
});