var t = new getApp(), a = t.siteInfo.uniacid, e = t.util.url("entry/wxapp/class") + "m=kundian_farm_plugin_active";

Page({
    data: {
        signList: [ {
            name: "",
            id: "0",
            tel: "",
            IDCard: ""
        } ],
        activeid: "",
        active: [],
        total: 0,
        selectNum: 0,
        spec: [],
        activeSet: wx.getStorageSync("kundian_farm_active_set"),
        farmSetData: []
    },
    onLoad: function(i) {
        var s = this, n = i.activeid, d = i.total, o = i.selectNum, r = JSON.parse(i.spec), c = wx.getStorageSync("kundian_farm_setData");
        wx.request({
            url: e,
            data: {
                action: "active",
                op: "getActiveConfirm",
                uniacid: a,
                active_id: n
            },
            success: function(t) {
                s.setData({
                    active: t.data.active,
                    activeid: n
                });
            }
        }), s.setData({
            spec: r,
            total: d,
            selectNum: o,
            farmSetData: c
        }), t.util.setNavColor(a);
    },
    addSign: function() {
        var t = this.data.signList, a = {
            id: t[t.length - 1].id + 1,
            name: "",
            tel: "",
            IDCard: ""
        };
        t.push(a), this.setData({
            signList: t
        });
    },
    delete: function(t) {
        var a = [ t.currentTarget.dataset.index, this.data.signList ], e = a[0], i = a[1];
        console.log(e), i.splice(e, 1), this.setData({
            signList: i
        });
    },
    modifyName: function(t) {
        var a = [ t.currentTarget.dataset.index, t.detail.value, this.data.signList ], e = a[0], i = a[1], s = a[2];
        s[e].name = i, this.setData({
            signList: s
        });
    },
    modifytel: function(t) {
        var a = [ t.currentTarget.dataset.index, t.detail.value, this.data.signList ], e = a[0], i = a[1], s = a[2];
        s[e].tel = i, this.setData({
            signList: s
        });
    },
    modifyidcard: function(t) {
        var a = [ t.currentTarget.dataset.index, t.detail.value, this.data.signList ], e = a[0], i = a[1], s = a[2];
        s[e].IDCard = i, this.setData({
            signList: s
        });
    },
    confirm: function(e) {
        var i = this, s = wx.getStorageSync("kundian_farm_uid");
        if (s) {
            for (var n = i.data, d = n.signList, o = n.activeid, r = n.spec, c = n.selectNum, u = n.total, l = n.active, f = 0; f < d.length; f++) for (var g = 0; g < l.add_info.length; g++) {
                if ("姓名" == l.add_info[g] && "" == d[f].name) return wx.showToast({
                    title: "请填写" + l.add_info[g]
                }), !1;
                if ("联系电话" == l.add_info[g] && "" == d[f].tel) return wx.showToast({
                    title: "请填写" + l.add_info[g]
                }), !1;
                if ("身份证号" == l.add_info[g] && "" == d[f].IDCard) return wx.showToast({
                    title: "请填写" + l.add_info[g]
                }), !1;
            }
            var w = t.util.url("entry/wxapp/class") + "m=" + mudule_name + "&op=addOrder&action=active";
            wx.showLoading({
                title: "加载中"
            }), wx.request({
                url: w,
                method: "POST",
                data: {
                    sign: JSON.stringify(d),
                    activeid: o,
                    spec: JSON.stringify(r),
                    selectNum: c,
                    total: u,
                    uid: s,
                    uniacid: a,
                    formid: e.detail.formId
                },
                success: function(e) {
                    if (1 == e.data.code) {
                        var i = e.data.order_id;
                        if (u > 0) t.util.request({
                            url: "entry/wxapp/activePay",
                            data: {
                                orderid: i,
                                uniacid: a
                            },
                            cachetime: "0",
                            success: function(e) {
                                if (e.data && e.data.data && !e.data.errno) {
                                    var n = e.data.data.package;
                                    wx.requestPayment({
                                        timeStamp: e.data.data.timeStamp,
                                        nonceStr: e.data.data.nonceStr,
                                        package: e.data.data.package,
                                        signType: "MD5",
                                        paySign: e.data.data.paySign,
                                        success: function(e) {
                                            wx.showLoading({
                                                title: "加载中..."
                                            });
                                            var d = t.util.url("entry/wxapp/class") + "m=" + mudule_name;
                                            wx.request({
                                                url: d,
                                                data: {
                                                    action: "active",
                                                    op: "notify",
                                                    uniacid: a,
                                                    uid: s,
                                                    orderid: i,
                                                    prepay_id: n
                                                },
                                                success: function(t) {
                                                    wx.hideLoading(), wx.showToast({
                                                        title: "支付成功",
                                                        success: function(t) {
                                                            wx.redirectTo({
                                                                url: "../payforResult/index?status=true&order_id=" + i
                                                            });
                                                        }
                                                    });
                                                }
                                            });
                                        },
                                        fail: function(t) {
                                            wx.showModal({
                                                title: "提示",
                                                content: "您取消了支付",
                                                showCancel: !1,
                                                success: function() {
                                                    wx.redirectTo({
                                                        url: "../orderList/index"
                                                    });
                                                }
                                            });
                                        }
                                    });
                                }
                                "JSAPI支付必须传openid" == e.data.message && wx.navigateTo({
                                    url: "../../login/index"
                                }), "当前余票不足" == e.data.message && wx.showModal({
                                    title: "提示",
                                    content: e.data.message,
                                    showCancel: !1
                                });
                            },
                            fail: function(t) {
                                wx.showModal({
                                    title: "系统提示",
                                    content: t.data.message ? t.data.message : "错误",
                                    showCancel: !1,
                                    success: function(t) {
                                        t.confirm;
                                    }
                                });
                            }
                        }); else {
                            var n = t.util.url("entry/wxapp/active") + "m=" + mudule_name;
                            wx.request({
                                url: n,
                                data: {
                                    op: "notify",
                                    uniacid: a,
                                    uid: s,
                                    orderid: i
                                },
                                success: function(t) {
                                    wx.showToast({
                                        title: "支付成功",
                                        success: function(t) {
                                            wx.redirectTo({
                                                url: "../payforResult/index?status=true&order_id=" + i
                                            }), wx.hideLoading();
                                        }
                                    });
                                }
                            });
                        }
                    } else wx.hideLoading(), wx.showModal({
                        title: "提示",
                        content: e.data.msg,
                        showCancel: !1
                    });
                }
            });
        } else wx.navigateTo({
            url: "../../login/index"
        });
    }
});