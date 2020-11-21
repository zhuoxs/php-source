var app = getApp();

Page({
    data: {
        getSearch: [],
        searchdetail: !0,
        showdetail: !1,
        page: 1,
        pagesize: 20,
        loadend: !0,
        val: "",
        inputvalue: ""
    },
    bindInput: function(a) {
        this.setData({
            inputValue: a.detail.value,
            searchdetail: !0,
            showdetail: !1
        }), console.log("bindInput" + this.data.inputValue);
    },
    setSearchStorage: function(a) {
        var t = wx.getStorageSync("searchData") || [];
        t.push(a), wx.setStorageSync("searchData", t), this.setData({
            getSearch: t
        });
    },
    search: function(e) {
        var s = this;
        app.util.request({
            url: "entry/wxapp/goods",
            showLoading: !0,
            method: "POST",
            data: {
                op: "search",
                val: e,
                page: 1,
                pagesize: s.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                t.data.goods && s.setData({
                    searchdetail: !1,
                    showdetail: !0,
                    sale: t.data.goods,
                    page: 2,
                    loadend: !1,
                    val: e
                });
            },
            fail: function(a) {
                wx.showToast({
                    title: a.data.message,
                    icon: "none"
                }), s.setData({
                    val: e,
                    sale: [],
                    showdetail: !0,
                    searchdetail: !1,
                    loadend: !0
                });
            }
        });
    },
    searchGoods: function(a) {
        var t = a.detail.value;
        "" != t && (this.search(t), this.setSearchStorage(t));
    },
    searhsubmit: function(a) {
        var t = a.detail.value.seachkey;
        "" != t && (this.search(t), this.setSearchStorage(t));
    },
    searchbydata: function(a) {
        var t = a.currentTarget.dataset.value;
        this.search(t);
    },
    searchFocus: function() {
        this.setData({
            searchdetail: !0,
            showdetail: !1
        });
    },
    clearSearchStorage: function() {
        var t = this;
        wx.showModal({
            title: "提示",
            content: "清空历史记录?",
            success: function(a) {
                console.log(a), a.confirm && wx.setStorage({
                    key: "searchData",
                    data: [],
                    success: function() {
                        t.setData({
                            getSearch: []
                        });
                    }
                });
            }
        });
    },
    clearInput: function() {
        this.setData({
            inputvalue: "",
            searchdetail: !0,
            showdetail: !1
        });
    },
    onLoad: function() {
        app.look.navbar(this);
    },
    onShow: function() {
        var a = wx.getStorageSync("searchData");
        this.setData({
            getSearch: a
        });
    },
    onReachBottom: function() {
        var e = this, a = this.data.loadend;
        if (showdetail && !a) {
            var t = this.data.val;
            app.util.request({
                url: "entry/wxapp/goods",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "search",
                    val: t,
                    page: e.data.page,
                    pagesize: e.data.pagesize
                },
                success: function(a) {
                    var t = a.data;
                    t.data.goods && e.setData({
                        sale: e.data.sale.concat(t.data.goods),
                        page: e.data.page + 1,
                        loadend: !1
                    });
                },
                fail: function(a) {
                    wx.showToast({
                        title: a.data.message,
                        icon: "none"
                    }), e.setData({
                        loadend: !0
                    });
                }
            });
        }
    }
});