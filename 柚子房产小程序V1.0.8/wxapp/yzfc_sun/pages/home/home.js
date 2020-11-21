var _extends = Object.assign || function(a) {
    for (var t = 1; t < arguments.length; t++) {
        var n = arguments[t];
        for (var e in n) Object.prototype.hasOwnProperty.call(n, e) && (a[e] = n[e]);
    }
    return a;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: _extends({}, _reload.data, {
        passFlag: 1
    }),
    onLoad: function() {},
    onloadData: function(a) {
        var n = this;
        a.detail.login && this.getUrl().then(function(a) {
            return Promise.all([ (0, _api.IndexData)(), (0, _api.IndexRecHouseData)(), (0, _api.IndexNewsData)() ]);
        }).then(function(a) {
            var t = wx.getStorageSync("config").homenav;
            n.setData({
                info: a[0],
                rec: a[1],
                news: a[2],
                show: !0,
                nav: t
            });
        }).catch(function(a) {
            -1 === a.code ? n.tips(a.msg) : n.tips("false");
        });
    },
    onHotTab: function() {
        this.navTo("../hot/hot");
    },
    onActivitylistTab: function() {
        this.navTo("../activitylist/activitylist");
    },
    onCompanyTab: function() {
        this.navTo("../company/company");
    },
    onNewsListTab: function() {
        this.navTo("../newslist/newslist");
    },
    onNewsTab: function(a) {
        var t = a.currentTarget.dataset.idx;
        this.navTo("../news/news?id=" + this.data.news[t].id);
    },
    onCalculatorTab: function() {
        this.navTo("../calculator/calculator");
    },
    onHouseAskTab: function() {
        this.navTo("../houseask/houseask");
    },
    onHousesTab: function(a) {
        var t = a.currentTarget.dataset.idx;
        this.navTo("../houses/houses?hid=" + this.data.rec[t].id);
    },
    onShareAppMessage: function() {
        return {
            title: "首页",
            path: "/yzxc_sun/pages/home/home"
        };
    }
}));