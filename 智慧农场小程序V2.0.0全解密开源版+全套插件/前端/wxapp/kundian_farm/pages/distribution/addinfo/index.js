var t = new getApp(), a = t.siteInfo.uniacid;

wx.getStorageSync("kundian_farm_uid");

Page({
    data: {
        click: !0,
        isShow: !1,
        farmSetData: [],
        distributionSet: []
    },
    onLoad: function(i) {
        var e = wx.getStorageSync("kundian_farm_uid");
        e || wx.navigateTo({
            url: "../../login/index"
        });
        var n = this;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "distribution",
                op: "apply_become_distribution",
                uniacid: a,
                uid: e
            },
            success: function(t) {
                -1 == t.data.code && wx.showModal({
                    title: "提示",
                    content: t.data.msg,
                    showCancel: !1,
                    success: function(t) {
                        wx.navigateTo({
                            url: "../../login/index"
                        });
                    }
                }), n.setData({
                    farmSetData: wx.getStorageSync("kundian_farm_setData"),
                    distributionSet: t.data.farmSetData
                }), t.data.is_distributor && wx.redirectTo({
                    url: "../index/index"
                });
            }
        }), t.util.setNavColor(a);
    },
    click: function() {
        var t = this.data.click;
        this.setData({
            click: !t
        });
    },
    check: function() {
        this.setData({
            isShow: !0
        });
    },
    preventTouchMove: function() {},
    close: function() {
        this.setData({
            isShow: !1
        });
    },
    formSubmit: function(i) {
        var e = this, n = i.detail.value, o = n.name, r = n.phone, s = wx.getStorageSync("kundian_farm_uid");
        if ("" == o) return wx.showToast({
            title: "请填写姓名"
        }), !1;
        if ("" == r) return wx.showToast({
            title: "请填写手机号"
        }), !1;
        if (0 == e.data.click) return wx.showModal({
            title: "提示",
            content: "请先同意申请协议",
            showCancel: !1
        }), !1;
        var c = i.detail.formId;
        t.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "distribution",
                op: "apply_distribution",
                uniacid: a,
                name: o,
                phone: r,
                uid: s,
                form_id: c
            },
            success: function(t) {
                wx.showModal({
                    title: "提示",
                    content: t.data.msg,
                    showCancel: !1,
                    success: function() {
                        5 == t.data.code ? wx.redirectTo({
                            url: "../index/index"
                        }) : wx.reLaunch({
                            url: "../../user/center/index?is_tarbar=true"
                        });
                    }
                });
            }
        });
    }
});