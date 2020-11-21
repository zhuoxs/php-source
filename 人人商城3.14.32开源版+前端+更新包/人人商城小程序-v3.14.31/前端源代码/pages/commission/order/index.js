var t = getApp().requirejs("core");

Page({
    data: {
        status: "",
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
    toggleSend: function(t) {
        if (this.data.openorderdetail || this.data.openorderbuyer) {
            var a = t.currentTarget.dataset.index, e = this.data.list[a].code, s = this.data.list;
            s[a].code = 1 == e ? 0 : 1, this.setData({
                list: s
            });
        }
    },
    getList: function() {
        var a = this;
        t.get("commission/order/get_list", {
            page: a.data.page,
            status: a.data.status
        }, function(t) {
            delete t.error;
            var e = t;
            e.show = !0, t.list.length > 0 && (e.page = a.data.page + 1, e.list = a.data.list.concat(t.list), 
            t.list.length < t.pagesize && (e.loaded = !0)), a.setData(e), wx.setNavigationBarTitle({
                title: t.textorder
            });
        }, this.data.show);
    },
    myTab: function(a) {
        var e = this, s = t.pdata(a).status;
        e.setData({
            status: s,
            page: 1,
            list: []
        }), e.getList();
    }
});