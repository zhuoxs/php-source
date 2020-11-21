var t = getApp().requirejs("core");

Page({
    data: {
        type: 0,
        page: 1,
        list: []
    },
    onLoad: function() {
        this.getList();
    },
    onReachBottom: function() {
        this.data.loaded || this.data.list.length == this.data.total || this.getList();
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    getList: function() {
        var a = this;
        t.get("member.fullback.get_list", {
            page: a.data.page,
            type: a.data.type
        }, function(t) {
            var e = {
                total: t.total,
                pagesize: t.pagesize,
                list: t.list,
                show: !0
            };
            t.list.length > 0 && (e.page = a.data.page + 1, e.list = a.data.list.concat(t.list), 
            t.list.length < t.pagesize && (e.loaded = !0)), a.setData(e);
        }), t.get("member.fullback.get_all", {}, function(t) {
            !1 !== t.info.day ? a.setData({
                info: t.info
            }) : a.setData({
                info: !1
            });
        });
    },
    myTab: function(t) {
        var a = this, e = t.currentTarget.dataset.type;
        a.setData({
            type: e,
            page: 1,
            list: []
        }), a.getList();
    }
});