var app = getApp(), BasePage = function(t) {
    t.app = getApp();
    var o = t.onLoad;
    t.onLoad = function(a) {
        t.app.get_setting().then(function(a) {
            if (a.app_bcolor) {
                var t = {};
                t.frontColor = "0" == a.app_fcolor || null == a.app_fcolor ? "#ffffff" : "#000000", 
                t.backgroundColor = a.app_bcolor, wx.setNavigationBarColor(t);
            }
        }), o.call(this, a);
    }, Page(t);
}, ListPage = function(a) {
    var t = {
        getData: function() {
            var o = this;
            o.getDataPromise().then(function(a) {
                var t = [];
                1 < o.data.page && (t = o.data.dataList), t = t.concat(a.data), o.setData({
                    hasMore: a.data.length >= o.data.limit,
                    dataList: t
                });
            });
        },
        onReachBottom: function() {
            this.data.hasMore && (this.data.page++, this.getData());
        },
        onLoad: function(a) {
            var t = this;
            app.get_imgroot().then(function(a) {
                t.setData({
                    imgroot: a
                }), t.getData();
            });
        }
    };
    a.data = Object.assign({}, {
        hasMore: !0,
        page: 1,
        limit: 10
    }, a.data), a = Object.assign({}, t, a), BasePage(a);
};

module.exports = {
    BasePage: BasePage,
    ListPage: ListPage
};