var e = new getApp(), t = e.siteInfo.uniacid, a = e.util.url("entry/wxapp/funding") + "m=kundian_farm_plugin_funding";

Page({
    data: {
        proDetail: [],
        spec: [],
        count: 1,
        name: "",
        phone: "",
        address: "",
        farmsetData: wx.getStorageSync("kundian_farm_setData"),
        funding_set: [],
        return_type: 2,
        return_desc: ""
    },
    onLoad: function(e) {
        var t = this, n = e.count, r = e.pid, i = e.spec;
        i = JSON.parse(i), wx.request({
            url: a,
            data: {
                op: "getOrderProDetail",
                control: "project",
                pid: r,
                count: n,
                spec_id: i.id
            },
            success: function(e) {
                var a = e.data, r = a.proDetail, c = a.total_price, s = a.funding_set;
                t.setData({
                    proDetail: r,
                    total_price: c,
                    spec: i,
                    count: n,
                    funding_set: s,
                    return_desc: i.spec_desc
                });
            }
        });
    },
    chooseAddr: function(e) {
        var t = this;
        wx.chooseAddress({
            success: function(e) {
                t.setData({
                    name: e.userName,
                    phone: e.telNumber,
                    address: e.provinceName + " " + e.cityName + " " + e.countyName + " " + e.detailInfo
                });
            },
            fail: function(e) {
                wx.showModal({
                    title: "提示",
                    content: "您上次拒绝了授权收获地址",
                    confirmText: "前去授权",
                    success: function(e) {
                        e.confirm ? wx.reLaunch({
                            url: "../../user/center/index"
                        }) : e.cancel;
                    }
                });
            }
        });
    },
    radioChange: function(e) {
        var t = e.detail.value, a = this.data, n = a.proDetail, r = a.spec, i = "";
        i = 1 == t ? "平台将以" + n.return_percent + "%的价格回收" : r.spec_desc, this.setData({
            return_type: t,
            return_desc: i
        });
    },
    changeState: function(e) {
        var t = e.currentTarget.dataset.value, a = this.data, n = a.proDetail, r = a.spec, i = "";
        i = 1 == t ? "平台将以" + n.return_percent + "%的价格回收" : r.spec_desc, this.setData({
            return_type: t,
            return_desc: i
        });
    },
    subOrder: function(n) {
        var r = this, i = wx.getStorageSync("kundian_farm_uid"), c = r.data, s = c.count, o = c.proDetail, d = c.spec, u = c.name, p = c.phone, l = c.address, f = c.total_price, _ = c.remark, g = c.return_type;
        if ("" == u || "" == l || "" == p) return wx.showToast({
            title: "请选择地址"
        }), !1;
        if (i) {
            e.util.url("entry/wxapp/project");
            wx.request({
                url: a,
                data: {
                    op: "addOrder",
                    control: "project",
                    pid: o.id,
                    spec_id: d.id,
                    count: s,
                    name: u,
                    phone: p,
                    address: l,
                    uid: i,
                    uniacid: t,
                    remark: _,
                    total_price: f,
                    return_type: g
                },
                success: function(n) {
                    var r = n.data.order_id;
                    e.util.request({
                        url: "entry/wxapp/fundingPay",
                        data: {
                            orderid: r,
                            uniacid: t
                        },
                        cachetime: "0",
                        success: function(e) {
                            if (e.data && e.data.data && !e.data.errno) {
                                var t = e.data.data.package;
                                wx.requestPayment({
                                    timeStamp: e.data.data.timeStamp,
                                    nonceStr: e.data.data.nonceStr,
                                    package: e.data.data.package,
                                    signType: "MD5",
                                    paySign: e.data.data.paySign,
                                    success: function(e) {
                                        wx.request({
                                            url: a,
                                            data: {
                                                op: "notify",
                                                control: "project",
                                                uid: i,
                                                orderid: r,
                                                prepay_id: t
                                            },
                                            success: function(e) {
                                                console.log(e), wx.showToast({
                                                    title: "支付成功",
                                                    success: function(e) {
                                                        wx.redirectTo({
                                                            url: "../orderList/index"
                                                        });
                                                    }
                                                });
                                            }
                                        });
                                    },
                                    fail: function(e) {
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
                            });
                        },
                        fail: function(e) {
                            wx.showModal({
                                title: "系统提示",
                                content: e.data.message ? e.data.message : "错误",
                                showCancel: !1,
                                success: function(e) {
                                    e.confirm;
                                }
                            });
                        }
                    });
                }
            });
        } else wx.navigateTo({
            url: "../../login/index"
        });
    }
});