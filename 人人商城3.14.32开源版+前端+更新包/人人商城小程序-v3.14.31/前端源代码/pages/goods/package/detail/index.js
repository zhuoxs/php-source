var t = getApp(), o = t.requirejs("core"), a = (t.requirejs("icons"), t.requirejs("jquery"), 
t.requirejs("foxui"));

Page({
    data: {
        show: !0,
        option_mask: !1
    },
    onLoad: function(t) {
        var a = this;
        a.setData({
            pid: t.id
        }), o.get("package.get_detail", {
            pid: t.id
        }, function(t) {
            var o = t.packgoods, i = [];
            wx.setNavigationBarTitle({
                title: t.package.title || "套餐"
            });
            for (var e = 0; e < o.length; e++) "" == o[e].option ? i[e] = {
                goodsid: o[e].goodsid,
                optionid: ""
            } : i[e] = {
                goodsid: o[e].goodsid,
                optionid: null
            };
            a.setData({
                packgoods: o,
                package: t.package,
                good: i
            });
        });
    },
    option: function(t) {
        var a = this, i = t.currentTarget.dataset.goodsid, e = t.currentTarget.dataset.index;
        o.get("package.get_option", {
            pid: a.data.pid,
            goodsid: i
        }, function(t) {
            a.setData({
                option_mask: !0,
                option: t.option,
                index: e
            });
        });
    },
    back: function(t) {
        wx.setStorage({
            key: "mydata",
            data: {
                id: t.currentTarget.dataset.id
            },
            success: function() {
                wx.navigateBack();
            }
        });
    },
    close: function() {
        this.setData({
            option_mask: !1
        });
    },
    choose: function(t) {
        var o = t.currentTarget.dataset.optionid, a = t.currentTarget.dataset.title, i = t.currentTarget.dataset.index, e = this.data.packgoods, n = this.data.option[i].packageprice;
        e[this.data.index].packageprice = n;
        for (var d = 0, s = 0; s < e.length; s++) d += 1 * e[s].packageprice;
        this.setData({
            option_active: o,
            option_title: a,
            sum: d
        });
    },
    confirm: function() {
        var t = this.data.packgoods, o = this.data.index, a = this.data.option_active, i = this.data.option_title, e = this.data.good;
        t[o].optionname = i, e[o].optionid = a, this.setData({
            option_mask: !1,
            packgoods: t,
            good: e
        });
    },
    buy: function() {
        for (var t = this, o = this.data.good, i = !0, e = 0; e < o.length; e++) null == o[e].optionid && (i = !1);
        i ? (o = JSON.stringify(o), wx.redirectTo({
            url: "/pages/order/create/index?packageid=" + t.data.package.id + "&goods=" + o
        })) : a.toast(this, "请选择规格！");
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});