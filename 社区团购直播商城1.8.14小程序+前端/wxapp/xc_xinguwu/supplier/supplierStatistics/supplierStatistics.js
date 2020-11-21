var app = getApp();

function countSales(a) {
    for (var t in a) for (var s in a[t].sailed = 0, a[t].attrs) a[t].sailed += parseInt(a[t].attrs[s]);
    return a;
}

Page({
    data: {
        nav: 1,
        statistic: [ {
            img: "../../images/goods-img.png",
            name: "红颜牛奶草莓新鲜水果红颜牛奶草莓新鲜水果",
            sailed: 20,
            big: 10,
            middle: 3,
            small: 7
        }, {
            img: "../../images/goods-img.png",
            name: "红颜牛奶草莓新鲜水果红颜牛奶草莓新鲜水果",
            sailed: 20,
            big: 10,
            middle: 3,
            small: 7
        }, {
            img: "../../images/goods-img.png",
            name: "红颜牛奶草莓新鲜水果红颜牛奶草莓新鲜水果",
            sailed: 20,
            big: 10,
            middle: 3,
            small: 7
        } ]
    },
    changeNav: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            nav: a.currentTarget.dataset.index
        });
        var s = this;
        app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !0,
            data: {
                op: "statistics",
                nav: t
            },
            success: function(a) {
                var t = a.data;
                console.log(a.data), t.data.list && s.setData({
                    list: countSales(t.data.list),
                    total: t.data.total
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), s.setData({
                    list: []
                });
            }
        });
    },
    onLoad: function(a) {
        var s = this;
        app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !1,
            data: {
                op: "statistics",
                nav: s.data.nav
            },
            success: function(a) {
                var t = a.data;
                t.data.list && s.setData({
                    list: countSales(t.data.list),
                    total: t.data.total
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message);
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});