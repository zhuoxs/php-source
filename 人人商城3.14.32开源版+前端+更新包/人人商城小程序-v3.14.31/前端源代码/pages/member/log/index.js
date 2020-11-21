var t = getApp(), a = t.requirejs("core");

Page({
    data: {
        icons: t.requirejs("icons"),
        type: 0,
        isopen: !1,
        page: 1,
        loaded: !1,
        loading: !0,
        list: []
    },
    onLoad: function(a) {
        a.type > 0 && this.setData({
            type: 1
        }), t.url(a), this.getList();
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onReachBottom: function() {
        this.data.loaded || this.data.list.length == this.data.total || this.getList();
    },
    getList: function() {
        var t = this;
        t.setData({
            loading: !0
        }), a.get("member/log/get_list", {
            type: t.data.type,
            page: t.data.page
        }, function(a) {
            var e = {
                loading: !1,
                total: a.total,
                show: !0
            };
            if (1 == t.data.page) {
                e.isopen = a.isopen;
                var i = "充值记录";
                1 == a.isopen && (i = a.moneytext + "明细"), wx.setNavigationBarTitle({
                    title: i
                });
            }
            a.list || (a.list = []), a.list.length > 0 && (e.page = t.data.page + 1, e.list = t.data.list.concat(a.list), 
            a.list.length < a.pagesize && (e.loaded = !0)), t.setData(e);
        });
    },
    myTab: function(t) {
        var e = this, i = a.pdata(t).type;
        e.setData({
            type: i,
            page: 1,
            list: [],
            loading: !0
        }), e.getList();
    }
});