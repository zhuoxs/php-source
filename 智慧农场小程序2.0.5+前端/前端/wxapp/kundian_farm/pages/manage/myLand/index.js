var t = new getApp(), a = t.siteInfo.uniacid;

Page({
    data: {
        plate: 1,
        mineid: "",
        landDetail: [],
        adoptid: "",
        config: [],
        landData: [],
        landSpec: [],
        is_show_estimate_dialog: !1,
        is_show_sure_dialog: !1,
        seed_id: "",
        adoptData: []
    },
    onLoad: function(a) {
        t.util.setNavColor();
        var e = this, s = a.plate;
        if (1 == s) {
            var i = a.mineid;
            e.getLandDetail(i);
        } else {
            var d = a.adoptid;
            e.getAnimalDetail(d);
        }
        e.setData({
            config: wx.getStorageSync("kundian_farm_setData"),
            plate: s
        });
    },
    getLandDetail: function(e) {
        var s = this;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getLandDetail",
                action: "land",
                control: "seller",
                mineid: e,
                uniacid: a
            },
            success: function(t) {
                var a = t.data, i = a.landDetail, d = a.seedData, n = a.landData, o = a.landSpec;
                s.setData({
                    landDetail: i,
                    mineid: e,
                    seedData: d,
                    landData: n,
                    landSpec: o
                });
            }
        });
    },
    getAnimalDetail: function(e) {
        var s = this;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "getAnimalDetail",
                action: "adopt",
                control: "seller",
                adoptid: e,
                uniacid: a
            },
            success: function(t) {
                var a = t.data, i = a.adoptData, d = a.orderData;
                s.setData({
                    adoptData: i,
                    adoptid: e,
                    animalOrder: d
                });
            }
        });
    },
    releases: function(t) {
        var a = this.data.plate;
        if (1 == a) {
            var e = t.currentTarget.dataset.seedid;
            wx.navigateTo({
                url: "../release/index?lid=" + this.data.landDetail.id + "&plate=" + a + "&seed_id=" + e
            });
        } else {
            var s = t.currentTarget.dataset.adoptid;
            wx.navigateTo({
                url: "../release/index?adoptid=" + s + "&plate=" + a
            });
        }
    },
    seedMature: function(t) {
        var a = "";
        this.data.is_show_estimate_dialog || (a = t.currentTarget.dataset.seedid), this.setData({
            is_show_estimate_dialog: !this.data.is_show_estimate_dialog,
            seed_id: a
        });
    },
    seedEstimate: function(e) {
        var s = this, i = this.data.seed_id, d = e.detail.value, n = d.sale_price, o = d.weight, l = e.currentTarget.dataset.status;
        return o <= 0 || !o ? (wx.showModal({
            title: "提示",
            content: "重量必须大于0",
            showCancel: !1
        }), !1) : n <= 0 || !n ? (wx.showModal({
            title: "提示",
            content: "售出单价必须大于0",
            showCancel: !1
        }), !1) : void t.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "seedEstimate",
                action: "land",
                control: "seller",
                id: i,
                uniacid: a,
                sale_price: n,
                weight: o,
                status: l
            },
            success: function(t) {
                console.log(t), wx.showModal({
                    title: "提示",
                    content: t.data.msg,
                    showCancel: !1,
                    success: function() {
                        0 == t.data.code && (s.getLandDetail(s.data.mineid), 1 == l ? s.setData({
                            is_show_sure_dialog: !1
                        }) : s.setData({
                            is_show_estimate_dialog: !1
                        }));
                    }
                });
            }
        });
    },
    seedPick: function(t) {
        var a = "";
        this.data.is_show_estimate_dialog || (a = t.currentTarget.dataset.seedid), this.setData({
            is_show_sure_dialog: !this.data.is_show_sure_dialog,
            seed_id: a
        });
    },
    gainSeed: function(e) {
        var s = this, i = this.data.seed_id, d = e.detail.value, n = d.sale_price, o = d.weight, l = e.currentTarget.dataset.status;
        return o <= 0 || !o ? (wx.showModal({
            title: "提示",
            content: "重量必须大于0",
            showCancel: !1
        }), !1) : n <= 0 || !n ? (wx.showModal({
            title: "提示",
            content: "售出单价必须大于0",
            showCancel: !1
        }), !1) : void t.util.request({
            url: "entry/wxapp/class",
            data: {
                op: "gainSeed",
                action: "land",
                control: "seller",
                id: i,
                uniacid: a,
                sale_price: n,
                weight: o,
                status: l
            },
            success: function(t) {
                wx.showModal({
                    title: "提示",
                    content: t.data.msg,
                    showCancel: !1,
                    success: function() {
                        0 == t.data.code && (s.getLandDetail(s.data.mineid), 1 == l ? s.setData({
                            is_show_estimate_dialog: !s.data.is_show_estimate_dialog
                        }) : s.setData({
                            is_show_sure_dialog: !s.data.is_show_sure_dialog
                        }));
                    }
                });
            }
        });
    },
    sendRequest: function(a, e) {
        var s = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : 1, i = this;
        wx.showModal({
            title: "提示",
            content: a,
            success: function(a) {
                a.confirm && t.util.request({
                    url: "entry/wxapp/class",
                    data: e,
                    success: function(t) {
                        1 == s && wx.showToast({
                            title: t.data.msg,
                            icon: "none"
                        }), 2 == s && wx.showModal({
                            title: "提示",
                            content: t.data.msg,
                            showCancel: !1,
                            success: function() {
                                0 == t.data.code && i.getLandDetail(e.mineid);
                            }
                        }), 3 == s && wx.showModal({
                            title: "提示",
                            content: t.data.msg,
                            success: function() {
                                0 == t.data.code && i.getAnimalDetail(i.data.adoptid);
                            }
                        });
                    }
                });
            }
        });
    },
    sendTemplateToUser: function(t) {
        var e = t.currentTarget.dataset, s = e.seedid, i = e.statustxt, d = "确认要发送模板消息通知用户当前种植状态为" + i + "吗？", n = {
            op: "sendTemplateToUser",
            action: "land",
            control: "seller",
            id: s,
            currentStatus: i,
            uniacid: a
        };
        this.sendRequest(d, n);
    },
    sendAdoptTemplateToUser: function(t) {
        var e = t.currentTarget.dataset, s = e.adoptid, i = e.statustxt, d = "确认要发送模板消息通知用户当前认养状态为" + i + "吗？", n = {
            op: "sendTemplateToUser",
            action: "adopt",
            control: "seller",
            id: s,
            currentStatus: i,
            uniacid: a
        };
        this.sendRequest(d, n);
    },
    changeSeedStstua: function(t) {
        var a = this.data.mineid, e = t.currentTarget.dataset, s = e.seedid, i = e.status, d = "确认修改种植状态为" + e.statustxt + "吗？", n = {
            op: "changeSeedStstua",
            action: "land",
            control: "seller",
            id: s,
            status: i,
            mineid: a
        };
        this.sendRequest(d, n, 2);
    },
    changeAdoptStstua: function(t) {
        var e = t.currentTarget.dataset, s = e.adoptid, i = e.statustxt, d = "确认修改认养状态为" + i + "吗？", n = {
            op: "changeAdoptStatus",
            action: "adopt",
            control: "seller",
            adopt_id: s,
            currentStatus: i,
            status: e.status,
            uniacid: a
        };
        this.sendRequest(d, n, 3);
    },
    updateAdoptNumber: function(t) {
        var e = t.detail.value, s = "确认要修改认养编号为" + e + "吗？", i = {
            op: "udpateAdoptNumber",
            action: "adopt",
            control: "seller",
            adopt_id: t.currentTarget.dataset.adoptid,
            adopt_number: e,
            uniacid: a
        };
        this.sendRequest(s, i);
    }
});