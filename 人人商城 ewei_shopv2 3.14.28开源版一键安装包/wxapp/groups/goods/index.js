var t = getApp(), a = t.requirejs("core"), o = (t.requirejs("jquery"), t.requirejs("foxui"), 
t.requirejs("wxParse/wxParse")), e = 0;

Page({
    data: {
        goods_id: 0,
        advHeight: 1
    },
    imageLoad: function(t) {
        var a = t.detail.height, o = t.detail.width, e = Math.floor(750 * a / o);
        a == o ? this.setData({
            advHeight: 750
        }) : this.setData({
            advHeight: e
        });
    },
    onLoad: function(e) {
        var i = this;
        t.getCache("isIpx") ? i.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar"
        }) : i.setData({
            isIpx: !1,
            iphonexnavbar: ""
        });
        var s = e.id;
        this.setData({
            goods_id: s
        }), a.post("groups.goods", {
            id: s
        }, function(t) {
            i.setData({
                data: t.data
            }), o.wxParse("wxParseData", "html", t.data.content, i, "0");
        });
    },
    singlebuy: function(t) {
        var o = this;
        a.post("groups/goods/goodsCheck", {
            id: o.data.goods_id,
            type: "single"
        }, function(t) {
            if (1 != t.error) if (0 == o.data.data.more_spec) wx.navigateTo({
                url: "../confirm/index?id=" + o.data.goods_id + "&type=single"
            }); else {
                o.setData({
                    layershow: !0,
                    options: !0
                }), o.setData({
                    optionarr: [],
                    selectSpecsarr: []
                });
                var e = o.data.data.id;
                a.get("groups.goods.get_spec", {
                    id: e
                }, function(t) {
                    o.setData({
                        spec: t.data
                    });
                }), o.setData({
                    layershow: !0,
                    options: !0
                });
            } else a.alert(t.message);
        });
    },
    close: function() {
        this.setData({
            layershow: !1,
            options: !1
        });
    },
    specsTap: function(t) {
        e++;
        var o = this, i = o.data.spec, s = a.pdata(t).spedid, n = a.pdata(t).id, d = a.pdata(t).specindex;
        a.pdata(t).idx;
        i[d].item.forEach(function(t, a) {
            t.id == n ? i[d].item[a].status = "active" : i[d].item[a].status = "";
        }), o.setData({
            spec: i
        });
        var r = o.data.optionarr, p = o.data.selectSpecsarr;
        1 == e ? (r.push(n), p.push(s)) : p.indexOf(s) > -1 ? r.splice(d, 1, n) : (r.push(n), 
        p.push(s)), o.data.optionarr = r, o.data.selectSpecsarr = p, a.post("groups.goods.get_option", {
            spec_id: o.data.optionarr,
            groups_goods_id: o.data.goods_id
        }, function(t) {
            o.setData({
                optiondata: t.data
            });
        });
    },
    buy: function(t) {
        var o = this, e = (a.pdata(t).op, o.data.goods_id), i = o.data.optiondata;
        o.data.optiondata ? i.stock > 0 ? wx.navigateTo({
            url: "../confirm/index?id=" + e + "&option_id=" + i.id + " &type=single",
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
        }) : wx.showToast({
            title: "请选择规格",
            icon: "none",
            duration: 2e3
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: this.data.data.title
        };
    },
    check: function() {}
});