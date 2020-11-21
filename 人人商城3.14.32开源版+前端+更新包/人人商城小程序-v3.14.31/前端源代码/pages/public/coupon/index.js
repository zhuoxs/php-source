var t = getApp(), e = t.requirejs("core"), s = t.requirejs("jquery");

Page({
    data: {
        type: 0,
        merchs: [],
        goodslist: [],
        goodsid: 0,
        money: 0,
        list: [],
        loading: !0
    },
    onLoad: function(e) {
        if (Number(e.type)) this.setData({
            money: e.money
        }); else {
            var s = t.getCache("goodsInfo");
            this.setData({
                goodslist: s.goodslist,
                merchs: s.merchs
            });
        }
        this.setData({
            type: e.type
        }), this.getList();
    },
    getList: function() {
        for (var t = this, s = this.data, o = 0; o < s.goodslist.length; o++) delete s.goodslist[o].title, 
        delete s.goodslist[o].optiontitle, delete s.goodslist[o].thumb;
        s.type < 2 && e.get("sale/coupon/query", {
            type: s.type,
            money: s.money,
            goods: s.goodslist,
            merchs: s.merchs
        }, function(e) {
            t.setData({
                list: e.list,
                loading: !1
            });
        });
    },
    search: function(t) {
        var e = t.detail.value, o = this.data.old_list, i = this.data.list, a = [];
        s.isEmptyObject(o) && (o = i), s.isEmptyObject(o) || s.each(o, function(t, s) {
            -1 != s.couponname.indexOf(e) && a.push(s);
        }), this.setData({
            list: a,
            old_list: o
        });
    },
    bindBtn: function(e) {
        var s = this.data, o = e.currentTarget.dataset;
        s.type < 2 && (t.setCache("coupon", o, 20), wx.navigateBack());
    }
});