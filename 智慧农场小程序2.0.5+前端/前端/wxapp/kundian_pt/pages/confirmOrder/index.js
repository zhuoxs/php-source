var e = new getApp(), t = e.siteInfo.uniacid, a = e.util.getNewUrl("entry/wxapp/pt", "kundian_farm_plugin_pt");

Page({
    data: {
        selectNum: 1,
        address: {
            address: "",
            name: "",
            phone: ""
        },
        buy_types: 2,
        totalPrice: 0,
        send_price: 0,
        selectSpec: [],
        total_price: 0,
        relation_id: 0,
        countDownNum: 0,
        farmSetData: []
    },
    onLoad: function(e) {
        var d = this, s = e.goods_id, i = e.selectNum, r = e.selectSpec, n = e.buy_types, o = e.selected, c = e.relation_id, u = wx.getStorageSync("kundian_farm_setData"), l = wx.getStorageSync("kundian_farm_uid");
        wx.request({
            url: a,
            data: {
                op: "getSurePtOrder",
                action: "index",
                goods_id: s,
                selectNum: i,
                selectSpec: r,
                buy_types: n,
                uniacid: t,
                uid: l
            },
            success: function(e) {
                "undefined" != r ? r = JSON.parse(r) : o = [];
                var t = e.data, a = t.address, l = (t.goods, t.totalPrice), p = t.total_price, _ = t.send_price, g = "";
                a && (g = {
                    address: a.region + " " + a.address,
                    name: a.name,
                    phone: a.phone
                }), d.setData({
                    goods_id: s,
                    goods: e.data.goods,
                    selectNum: i,
                    selectSpec: r,
                    buy_types: n,
                    selected: o,
                    totalPrice: l,
                    total_price: p,
                    send_price: _,
                    relation_id: c,
                    farmSetData: u,
                    address: g
                });
            }
        });
    },
    chooseAddress: function(e) {
        wx.navigateTo({
            url: "/kundian_farm/pages/user/address/index?is_select=true"
        });
    },
    onShow: function(e) {
        var t = wx.getStorageSync("kundian_farm_uid"), a = wx.getStorageSync("selectAdd_" + t);
        if (a) {
            this.data.address;
            var d = {
                address: a.region + " " + a.address,
                name: a.name,
                phone: a.phone
            };
            this.setData({
                address: d
            }), wx.removeStorageSync("selectAdd_" + t);
        }
    },
    add: function() {
        var e = this.data, t = e.selectNum, a = e.selectSpec, d = e.send_price, s = (e.totalPrice, 
        e.buy_types), i = e.goods;
        t = parseInt(t) + 1;
        var r = 0;
        r = a ? 2 == s ? a.pt_price * t + parseFloat(d) : a.price * t + parseFloat(d) : i.price * t + parseFloat(d), 
        this.setData({
            selectNum: t,
            total_price: r.toFixed(2)
        });
    },
    reduce: function() {
        var e = this.data, t = e.selectNum, a = e.selectSpec, d = e.send_price, s = (e.totalPrice, 
        e.buy_types), i = e.goods;
        if (!(t <= 1)) {
            t = parseInt(t) - 1;
            var r = 0;
            r = a ? 2 == s ? a.pt_price * t + parseFloat(d) : a.price * t + parseFloat(d) : i.price * t + parseFloat(d), 
            this.setData({
                selectNum: t,
                total_price: r.toFixed(2)
            });
        }
    },
    addPtOrder: function(d) {
        var s = this.data, i = s.goods_id, r = (s.goods, s.selectSpec), n = s.buy_types, o = s.selectNum, c = s.address, u = s.send_price, l = s.total_price, p = s.relation_id, _ = s.selected, g = wx.getStorageSync("kundian_farm_uid");
        if (!c.address) return wx.showToast({
            title: "请选择收货地址",
            icon: "none"
        }), !1;
        wx.request({
            url: a,
            data: {
                action: "index",
                op: "addPtOrder",
                goods_id: i,
                selectSpec: r,
                buy_types: n,
                selectNum: o,
                address: c,
                uniacid: t,
                uid: g,
                total_price: l,
                send_price: u,
                form_id: d.detail.formId,
                relation_id: p,
                sku_name: _
            },
            success: function(d) {
                if (d.data.order_id) {
                    var s = d.data.order_id, i = e.util.getNewUrl("entry/wxapp/pay", "kundian_farm_plugin_pt");
                    wx.request({
                        url: i,
                        data: {
                            orderid: s,
                            uniacid: t
                        },
                        cachetime: "0",
                        success: function(e) {
                            if (e.data && e.data.data && !e.data.errno) {
                                var d = e.data.data.package;
                                wx.requestPayment({
                                    timeStamp: e.data.data.timeStamp,
                                    nonceStr: e.data.data.nonceStr,
                                    package: e.data.data.package,
                                    signType: "MD5",
                                    paySign: e.data.data.paySign,
                                    success: function(e) {
                                        wx.showLoading({
                                            title: "加载中"
                                        }), wx.request({
                                            url: a,
                                            data: {
                                                action: "index",
                                                op: "sendMsg",
                                                order_id: s,
                                                uniacid: t,
                                                prepay_id: d
                                            },
                                            success: function() {
                                                wx.showModal({
                                                    title: "提示",
                                                    content: "支付成功",
                                                    showCancel: !1,
                                                    success: function() {
                                                        wx.redirectTo({
                                                            url: "../orderDetail/index?order_id=" + s
                                                        });
                                                    }
                                                }), wx.hideLoading();
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
                                                    url: "../orderDetail/index?order_id=" + s
                                                });
                                            }
                                        });
                                    }
                                });
                            }
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
                } else wx.showToast({
                    title: d.data.msg
                });
            }
        });
    }
});