var app = getApp(), page = require("../../../../common/page.js");

page.ListPage({
    data: {
        sets: [ {
            sets: "shop",
            status: !0
        }, {
            sets: "order",
            status: !0
        } ],
        isIpx: app.globalData.isIpx,
        curIndex: 0,
        pageIndex: 1,
        nav: [ {
            name: "全部",
            state: 0
        }, {
            name: "待付款",
            state: 10
        }, {
            name: "待核销",
            state: 20
        }, {
            name: "已核销",
            state: 30
        } ],
        goodsOrder: [ {
            store_name: "111",
            state: 10,
            goods_img: "",
            goods_name: "11111",
            goods_price: "10.00",
            num: 10,
            time: "2018",
            nums: "10",
            pay_amount: "10.00"
        } ]
    },
    switchChange: function(t) {
        var e = t.detail.value, a = t.currentTarget.dataset.index, s = this.data.sets;
        s[a].status = !e, this.setData({
            sets: s
        });
    },
    toIndex: function(t) {
        wx.redirectTo({
            url: "../index/index"
        });
    },
    toset22222: function(t) {
        wx.redirectTo({
            url: "../set/set"
        });
    },
    bargainTap: function(t) {
        var e = parseInt(t.currentTarget.dataset.index), a = t.currentTarget.dataset.state;
        this.setData({
            page: 1,
            curIndex: e,
            state: a
        }), this.getData();
    },
    getDataPromise: function() {
        var a = this;
        return new Promise(function(e, t) {
            app.get_admin_store_info().then(function(t) {
                app.util.request({
                    url: "entry/wxapp/GetStoreappOrders",
                    cachetime: "0",
                    data: {
                        state: a.data.state || 0,
                        page: a.data.page,
                        limit: a.data.limit,
                        store_id: t.id
                    },
                    success: e
                });
            });
        });
    }
});