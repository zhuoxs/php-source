var t = getApp(), a = t.requirejs("core");

Page({
    data: {
        cate: "",
        page: 1,
        loading: !1,
        loaded: !1,
        list: [],
        approot: t.globalData.approot
    },
    onLoad: function(t) {
        this.getList();
    },
    myTab: function(t) {
        var e = this, i = a.pdata(t).cate;
        e.setData({
            cate: i,
            page: 1,
            list: []
        }), e.getList();
    },
    getList: function() {
        var t = this;
        a.loading(), this.setData({
            loading: !0
        }), a.get("sale/coupon/my/getlist", {
            page: this.data.page,
            cate: this.data.cate
        }, function(e) {
            var i = {
                loading: !1,
                total: e.total,
                pagesize: e.pagesize,
                closecenter: e.closecenter
            };
            e.list.length > 0 && (i.page = t.data.page + 1, i.list = t.data.list.concat(e.list), 
            e.list.length < e.pagesize && (i.loaded = !0)), t.setData(i), a.hideLoading();
        });
    },
    onReachBottom: function() {
        this.data.loaded || this.data.list.length == this.data.total || this.getList();
    },
    jump: function(t) {
        var e = a.pdata(t).id;
        e > 0 && wx.navigateTo({
            url: "/pages/sale/coupon/my/detail/index?id=" + e
        });
    }
});