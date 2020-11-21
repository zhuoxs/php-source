var t = new getApp(), a = t.siteInfo.uniacid;

Page({
    data: {
        is_show_sale_dailog: !1,
        bagList: [],
        operationtype: "",
        selectBag: [],
        disabled: !1,
        isContent: !0
    },
    onLoad: function(e) {
        var i = this, s = "";
        e.formid && (s = e.formid);
        var o = wx.getStorageSync("kundian_farm_uid");
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getSeeBagList",
                control: "land",
                uid: o,
                uniacid: a,
                formid: s
            },
            success: function(t) {
                t.data.bagList.length > 0 ? i.setData({
                    bagList: t.data.bagList
                }) : i.setData({
                    isContent: !1
                });
            }
        }), t.util.setNavColor(a);
    },
    getBagList: function() {
        var e = this, i = wx.getStorageSync("kundian_farm_uid");
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getSeeBagList",
                control: "land",
                uid: i,
                uniacid: a
            },
            success: function(t) {
                t.data.bagList.length > 0 ? e.setData({
                    bagList: t.data.bagList
                }) : e.setData({
                    isContent: !1
                });
            }
        });
    },
    onShow: function(t) {
        this.getBagList();
    },
    operationBag: function(t) {
        var a = this;
        if (this.data.is_show_sale_dailog) this.setData({
            is_show_sale_dailog: !this.data.is_show_sale_dailog
        }); else {
            var e = t.currentTarget.dataset, i = (e.seedid, e.bagid), s = e.operationtype;
            if (this.data.bagList.map(function(t) {
                t.id == i && a.setData({
                    selectBag: t
                });
            }), 2 == s) return wx.navigateTo({
                url: "../pay_freight/index?selectBag=" + JSON.stringify(this.data.selectBag)
            }), !1;
            this.setData({
                is_show_sale_dailog: !this.data.is_show_sale_dailog,
                operationtype: s,
                bagid: i
            });
        }
    },
    saleSeed: function(e) {
        var i = this, s = this.data.selectBag, o = e.detail.value.weight, n = e.detail.formId, d = wx.getStorageSync("kundian_farm_uid");
        return o <= 0 ? (wx.showModal({
            title: "提示",
            content: "重量必须大于0",
            showCancel: !1
        }), !1) : parseFloat(o) > parseFloat(s.weight) ? (wx.showModal({
            title: "提示",
            content: "重量不能大于" + s.weight + " kg",
            showCancel: !1
        }), !1) : (i.setData({
            disabled: !0
        }), void t.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "saleSeed",
                control: "land",
                uniacid: a,
                selectBag: JSON.stringify(s),
                uid: d,
                weight: o,
                formid: n
            },
            method: "POST",
            success: function(t) {
                wx.showModal({
                    title: "提示",
                    content: t.data.msg,
                    showCancel: !1,
                    success: function() {
                        i.setData({
                            is_show_sale_dailog: !i.data.is_show_sale_dailog,
                            disabled: !1
                        }), i.getBagList(n);
                    }
                });
            }
        }));
    }
});