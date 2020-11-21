function t(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var a = require("../../../utils/base.js"), e = require("../../../../api.js"), i = new a.Base(), n = getApp();

Page({
    data: {
        Switch: -1,
        page: 1,
        size: 20,
        currentPage: 0,
        listArray: [],
        loadmore: !0,
        loadnot: !1
    },
    onLoad: function(t) {
        n.pageOnLoad(), console.log(t), t.scene && n.bind(t.scene), t.cateId && this.getCate(t.cateId), 
        t.cateId && this.getbyCate(t.cateId), t.cateId && this.setData({
            cateId: t.cateId
        }), t.name && this.setData({
            name: t.name
        }), t.name ? wx.setNavigationBarTitle({
            title: t.name
        }) : wx.setNavigationBarTitle({
            title: "列表"
        });
    },
    onShareAppMessage: function() {
        console.log("name=>", this.data.name);
        var t = wx.getStorageSync("userData").user_info.id, a = encodeURIComponent("parentId=" + t + " & id= & type=share");
        return {
            title: this.data.name,
            path: "/boguan_mall/pages/Home/new_list/new_list?cateId=" + this.data.cateId + "&name=" + this.data.name + "&scene=" + a
        };
    },
    onReachBottom: function() {
        this.setData({
            page: this.data.page + 1
        }), this.data.loadmore && this.getbyCate(this.data.cateId);
    },
    getMore: function(t) {
        this.setData({
            page: this.data.page + 1
        }), this.data.loadmore && this.getbyCate(this.data.cateId);
    },
    Switch: function(t) {
        var a = t.currentTarget.dataset.id;
        this.setData({
            Switch: t.currentTarget.dataset.index,
            listArray: [],
            page: 1,
            size: 20,
            currentPage: 0,
            cateId: a
        }), this.getbyCate(a);
    },
    getCate: function(t) {
        var a = this, n = {
            url: e.default.content_cate,
            data: {
                cateId: t
            },
            method: "GET"
        };
        i.getData(n, function(t) {
            console.log("分类数据=>", t), a.setData({
                cateArray: t
            });
        });
    },
    getbyCate: function(a) {
        var n = this;
        wx.showLoading({
            title: "请稍后"
        });
        var s = {
            url: e.default.content_by_cate,
            data: {
                cateId: a,
                page: this.data.page,
                size: this.data.size
            },
            method: "GET"
        };
        i.getData(s, function(a) {
            setTimeout(function() {
                wx.hideLoading();
            }, 300), console.log("文章数据=>", a);
            var e = n, i = n.data.currentPage, s = n.data.listArray;
            if (1 == a.errorCode) {
                var o;
                e.setData((o = {}, t(o, "listArray[" + i + "]", a.data.data), t(o, "currentPage", i + 1), 
                o)), a.data.data.length < n.data.size && e.setData({
                    loadmore: !1,
                    loadnot: !0
                });
            } else e.setData({
                loadmore: !1,
                loadnot: !0
            });
            console.log("listArray=>", s);
        });
    },
    navigatorLink: function(t) {
        n.navClick(t, this);
    }
});