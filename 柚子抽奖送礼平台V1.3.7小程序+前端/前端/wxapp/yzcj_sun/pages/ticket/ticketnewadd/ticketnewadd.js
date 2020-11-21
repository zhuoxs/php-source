var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        list: [ {
            name: "付费参与",
            price: "",
            checked: !1
        }, {
            name: "口令抽奖",
            price: "",
            checked: !1
        }, {
            name: "组团抽奖",
            price: "",
            checked: !1
        }, {
            name: "抽奖码抽奖",
            price: "",
            checked: !1
        } ],
        check: [ {
            name: "一，二，三等奖",
            price: "1.00"
        } ],
        rad2: [],
        price1: 0,
        price2: 0
    },
    onLoad: function(e) {
        var a = this, c = a.data.list, t = a.data.check;
        app.util.request({
            url: "entry/wxapp/Getsenior",
            success: function(e) {
                console.log(e), c[0].price = e.data.paidprice, c[1].price = e.data.passwordprice, 
                c[2].price = e.data.growpprice, c[3].price = e.data.codeprice, t[0].price = e.data.oneprice, 
                a.setData({
                    list: c,
                    check: t,
                    res: e.data
                });
            }
        });
    },
    onShow: function() {},
    checkchange: function(e) {
        var a = e.detail.value, c = this.data.check[0].price;
        console.log(c), this.setData({
            rad2: a,
            price1: 0 < a.length ? c : 0
        });
    },
    checkselect: function(e) {
        var a = this, c = e.currentTarget.dataset.ind, t = a.data.list, i = t[c].checked;
        a.data.price2;
        if (console.log(c), i) {
            for (var r = 0; r < t.length; r++) t[r].checked = !1;
            a.setData({
                list: t,
                rad: -1,
                price2: 0
            });
        } else {
            for (var d = 0; d < t.length; d++) t[d].checked = d == c;
            a.setData({
                list: t,
                rad: c,
                price2: t[c].price
            });
        }
    },
    toTicket: function() {
        wx.redirectTo({
            url: "../ticketadd/ticketadd"
        });
    },
    sureSubmit: function() {
        var e = this, a = -1 < e.data.rad ? e.data.rad : -1, c = 0 < e.data.rad2.length ? e.data.rad2 : 0, t = e.data.price2, i = e.data.price1;
        console.log(a), console.log(c), 0 < c.length || 0 <= a ? wx.navigateTo({
            url: "./ticketadvanced/ticketadvanced?rad=" + a + "&rad2=" + c + "&price2=" + t + "&price1=" + i
        }) : wx.showToast({
            title: "至少勾选一项",
            icon: "none",
            duration: 2e3
        });
    }
});