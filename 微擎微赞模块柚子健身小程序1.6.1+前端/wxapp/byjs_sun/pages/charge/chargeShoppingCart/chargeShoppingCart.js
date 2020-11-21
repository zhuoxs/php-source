var app = getApp();

Page({
    data: {
        status: !1,
        product: [ {
            img: "http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png",
            productNumber: 1,
            cord: "蓝色",
            types: "XL",
            title: "上家肯定福建省看到了荆防颗粒胜多负少的",
            picer: 89,
            status: !1
        } ],
        total: 0
    },
    onLoad: function(t) {
        var a = this;
        a.getTotal(), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
        var e = wx.getStorageSync("shop");
        a.setData({
            product: e,
            red: e.red
        });
    },
    getTotal: function() {
        for (var t = this.data.product, a = 0, e = 0; e < t.length; e++) {
            if (1 == t[e].status) a += Number(t[e].productNumber) * Number(t[e].picer);
        }
        this.setData({
            total: a
        });
    },
    addnum: function(t) {
        var a = this, e = a.data.product, o = t.currentTarget.dataset.index, r = e[o].productNumber;
        r += 1, e[o].productNumber = r;
        for (var s, n = t.currentTarget.dataset.index, u = wx.getStorageSync("shop"), c = 0; c < u.length; c++) u[c].goods_id, 
        e[n].goods_id, s = c;
        u[s].productNumber = r, wx.setStorageSync("shop", u), a.getTotal(), a.setData({
            product: e
        });
    },
    subbnum: function(t) {
        var a = this, e = a.data.product, o = t.currentTarget.dataset.index, r = e[o].productNumber;
        if (1 == r) return !1;
        r -= 1, e[o].productNumber = r;
        for (var s, n = t.currentTarget.dataset.index, u = wx.getStorageSync("shop"), c = 0; c < u.length; c++) u[c].goods_id, 
        e[n].goods_id, s = c;
        u[s].productNumber = r, wx.setStorageSync("shop", u), a.setData({
            product: e
        }), a.getTotal();
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goYesOrder: function() {
        for (var t = this.data.product, a = [], e = 0; e < t.length; e++) 1 == t[e].status && a.push(t[e]);
        0 == a.length ? wx.showLoading({
            title: "请选择你想买的商品"
        }) : (wx.setStorageSync("newcar", a), wx.setStorageSync("newtotal", this.data.total), 
        wx.navigateTo({
            url: "/byjs_sun/pages/charge/chargeYesOrder/chargeYesOrder"
        }));
    },
    check: function(t) {
        var a = this, e = (a.data.total, t.currentTarget.dataset.index), o = JSON.parse(JSON.stringify(this.data.product));
        console.log(a.data.product), !0 === o[e].status ? o[e].status = !1 : o[e].status = !0, 
        this.setData({
            product: o
        }), this.getTotal(), console.log(a.data.product);
        for (var r = 0, s = o.length; r < s; ) {
            if (!0 !== o[r].status) return this.setData({
                status: !1
            }), !1;
            r++;
        }
        this.setData({
            status: !0
        });
    },
    allCheck: function() {
        var t = this.data.status, a = JSON.parse(JSON.stringify(this.data.product));
        if (!0 === t) {
            for (var e in a) a[e].status = !1;
            this.setData({
                product: a,
                status: !1
            }), this.getTotal();
        } else {
            for (var o in a) a[o].status = !0;
            this.setData({
                product: a,
                status: !0
            }), this.getTotal();
        }
    },
    gotobuy: function(t) {
        wx.switchTab({
            url: "/byjs_sun/pages/charge/chargeIndex/chargeIndex"
        });
    },
    clear: function(t) {
        for (var a, e = this, o = t.currentTarget.dataset.index, r = e.data.product, s = wx.getStorageSync("shop"), n = 0; n < s.length; n++) s[n].goods_id, 
        r[o].goods_id, a = n;
        wx.showModal({
            title: "提示",
            content: "是否删除?",
            success: function(t) {
                t.confirm && (r.splice(o, 1), s.splice(a, 1), wx.setStorageSync("shop", s), e.setData({
                    product: r
                }));
            }
        });
    }
});