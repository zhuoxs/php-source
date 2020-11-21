var common = require("../common/common.js"), app = getApp();

Page({
    data: {
        list: [ {
            href: "../detail1/detail1",
            img: "../../images/detail_img01.jpg",
            name: "黄桃罐头混合水果罐头1",
            ptype: "20斤装",
            price: 26,
            numbervalue: 1
        }, {
            href: "../detail1/detail1",
            img: "../../images/detail_img01.jpg",
            name: "黄桃罐头混合水果罐头2",
            ptype: "20斤装",
            price: 26,
            numbervalue: 1
        } ],
        allprice: 0,
        tprice: 5,
        off: .9,
        ticketp: 20,
        check: 0,
        balance: 233
    },
    onLoad: function(e) {
        var t = this;
        common.config(t), app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "order_detail",
                id: e.id
            },
            success: function(e) {
                var a = e.data;
                "" != a.data && t.setData({
                    list: a.data
                });
            }
        });
    },
    onPullDownRefresh: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "order_detail",
                id: options.id
            },
            success: function(e) {
                var a = e.data;
                wx.stopPullDownRefresh(), "" != a.data && t.setData({
                    list: a.data
                });
            }
        });
    }
});