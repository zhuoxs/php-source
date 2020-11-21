var a = getApp(), t = a.requirejs("core"), o = (a.requirejs("jquery"), a.requirejs("foxui"), 
0);

Page({
    data: {
        layershow: !1,
        chosenum: !1,
        options: !1,
        optionarr: [],
        selectSpecsarr: [],
        goods_id: 0
    },
    onLoad: function(a) {
        var o = this, e = a.id;
        this.setData({
            goods_id: e
        }), t.get("groups.goods.openGroups", {
            id: e
        }, function(a) {
            o.setData({
                data: a.data,
                teams: a.teams,
                ladder: a.ladder
            });
        });
    },
    joinTeam: function(a) {
        var o = this, e = t.pdata(a).type, d = t.pdata(a).op;
        if (o.setData({
            optionarr: [],
            selectSpecsarr: []
        }), "creat" == d ? o.setData({
            op: "creat"
        }) : o.setData({
            op: ""
        }), "ladder" == e) {
            s = o.data.data.id;
            t.get("groups.goods.goodsCheck", {
                id: s,
                type: "group"
            }, function(a) {
                0 == a.error ? o.setData({
                    layershow: !0,
                    chosenum: !0
                }) : wx.showToast({
                    title: a.message,
                    icon: "none",
                    duration: 2e3
                });
            });
        } else if (0 == o.data.data.more_spec) {
            s = o.data.data.id;
            t.get("groups.goods.goodsCheck", {
                id: s,
                type: "group"
            }, function(a) {
                0 == a.error ? "creat" == d ? wx.navigateTo({
                    url: "../confirm/index?type=groups&id=" + s + "&heads=1"
                }) : t.get("groups.goods.check_tuan", {
                    id: s,
                    type: "group"
                }, function(a) {
                    a.data.order_num <= 0 ? t.alert("暂无拼团") : wx.navigateTo({
                        url: "../jointeam/index?id=" + s
                    });
                }) : wx.showToast({
                    title: a.message,
                    icon: "none",
                    duration: 2e3
                });
            });
        } else {
            var s = o.data.data.id;
            t.get("groups.goods.goodsCheck", {
                id: s,
                type: "group"
            }, function(a) {
                0 == a.error ? (t.get("groups.goods.get_spec", {
                    id: s
                }, function(a) {
                    o.setData({
                        spec: a.data
                    });
                }), o.setData({
                    layershow: !0,
                    options: !0
                })) : wx.showToast({
                    title: a.message,
                    icon: "none",
                    duration: 2e3
                });
            });
        }
    },
    chosenum: function(a) {
        var o = t.pdata(a).index, e = t.pdata(a).goodsid, d = t.pdata(a).id, s = t.pdata(a).price;
        this.setData({
            selectindex: o,
            id: e,
            ladder_id: d,
            ladder_price: s
        });
    },
    close: function() {
        this.setData({
            layershow: !1,
            chosenum: !1,
            options: !1
        });
    },
    ladder_buy: function() {
        var a = this;
        a.data.ladder_id ? ("creat" != this.data.op ? t.get("groups.goods.check_tuan", {
            id: a.data.goods_id,
            ladder_id: a.data.ladder_id
        }, function(o) {
            o.data.ladder_num <= 0 ? t.alert("暂无拼团") : wx.navigateTo({
                url: "../jointeam/index?id=" + a.data.goods_id + "&ladder_id=" + a.data.ladder_id,
                success: function() {
                    a.setData({
                        layershow: !1,
                        chosenum: !1,
                        options: !1
                    });
                }
            });
        }) : wx.navigateTo({
            url: "../confirm/index?id=" + a.data.goods_id + "&heads=1&type=groups&ladder_id=" + a.data.ladder_id,
            success: function() {
                a.setData({
                    layershow: !1,
                    chosenum: !1,
                    options: !1
                });
            }
        }), this.close()) : t.alert("请选择拼团人数");
    },
    specsTap: function(a) {
        o++;
        var e = this, d = e.data.spec, s = t.pdata(a).spedid, i = t.pdata(a).id, n = t.pdata(a).specindex;
        t.pdata(a).idx;
        d[n].item.forEach(function(a, t) {
            a.id == i ? d[n].item[t].status = "active" : d[n].item[t].status = "";
        }), e.setData({
            spec: d
        });
        var r = e.data.optionarr, c = e.data.selectSpecsarr;
        1 == o ? (r.push(i), c.push(s)) : c.indexOf(s) > -1 ? r.splice(n, 1, i) : (r.push(i), 
        c.push(s)), e.data.optionarr = r, e.data.selectSpecsarr = c, t.post("groups.goods.get_option", {
            spec_id: e.data.optionarr,
            groups_goods_id: e.data.goods_id
        }, function(a) {
            e.setData({
                optiondata: a.data
            });
        });
    },
    buy: function(a) {
        var o = this, e = t.pdata(a).op, d = o.data.goods_id, s = o.data.optiondata;
        o.data.optiondata ? "creat" == e ? s.stock > 0 ? wx.navigateTo({
            url: "../confirm/index?id=" + d + "&heads=1&type=groups&option_id=" + s.id,
            success: function() {
                o.setData({
                    layershow: !1,
                    chosenum: !1,
                    options: !1
                });
            }
        }) : wx.showToast({
            title: "库存不足",
            icon: "none",
            duration: 2e3
        }) : s.stock > 0 ? t.get("groups.goods.check_tuan", {
            id: d,
            type: "group"
        }, function(a) {
            a.data.order_num <= 0 ? t.alert("暂无拼团") : wx.navigateTo({
                url: "../jointeam/index?id=" + d + "&option_id=" + s.id,
                success: function() {
                    o.setData({
                        layershow: !1,
                        chosenum: !1,
                        options: !1
                    });
                }
            });
        }) : wx.showToast({
            title: "库存不足",
            icon: "none",
            duration: 2e3
        }) : wx.showToast({
            title: "请选择规格",
            icon: "none",
            duration: 2e3
        });
    },
    onReady: function() {},
    onShow: function() {
        a.checkAuth();
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});