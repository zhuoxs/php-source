var t = getApp(), a = t.requirejs("core");

t.requirejs("jquery");

Page({
    data: {
        list: [],
        page: 1,
        cate: "",
        loaded: !1,
        loading: !0
    },
    onLoad: function(t) {
        this.get_list();
    },
    get_list: function() {
        var t = this;
        t.setData({
            loading: !0
        }), a.get("verifygoods/get_list", {
            page: t.data.page,
            cate: t.data.cate
        }, function(a) {
            var e = {
                loading: !1,
                total: a.total,
                show: !0
            };
            a.list || (a.list = []), a.list.length > 0 && (e.page = t.data.page + 1, e.list = t.data.list.concat(a.list), 
            a.list.length < a.pagesize && (e.loaded = !0)), t.setData(e);
        });
    },
    selected: function(t) {
        var a = this, e = t.currentTarget.dataset.cate;
        a.setData({
            cate: e,
            page: 1,
            list: [],
            loading: !0
        }), this.get_list();
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onReachBottom: function() {
        this.data.loaded || this.data.list.length == this.data.total || this.getList();
    }
});