function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var app = getApp();

Page({
    data: {
        navIndex: 1,
        categoryid: 0,
        searchValue: "",
        editCategory: !1,
        categoryItemValue: ""
    },
    toAddGood: function() {
        wx.navigateTo({
            url: "../addGood/addGood"
        });
    },
    changeNav: function(a) {
        var e = this, t = a.currentTarget.dataset.nav;
        this.setData({
            navIndex: a.currentTarget.dataset.nav,
            list: []
        }), this.page = 1, this.loadend = !1, app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !0,
            method: "POST",
            data: {
                op: "goodsManage",
                category: e.data.categoryid,
                navIndex: t,
                page: 1,
                pagesize: this.pagesize
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.loadend = !0;
            }
        });
    },
    changeCategory: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            categoryid: t,
            list: []
        }), this.page = 1, this.loadend = !1;
        var e = this;
        app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !0,
            method: "POST",
            data: {
                op: "goodsManage",
                category: t,
                navIndex: e.data.navIndex,
                page: 1,
                pagesize: this.pagesize
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.loadend = !0;
            }
        });
    },
    search: function(a) {
        var e = this, s = a.detail.value;
        "" != s && (this.page = 1, this.loadend = !1, this.setData({
            list: []
        }), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !0,
            method: "POST",
            data: {
                op: "goodsManage",
                searchValue: s,
                navIndex: this.data.navIndex,
                categoryid: this.data.categoryid,
                page: 1,
                pagesize: this.pagesize
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list,
                    searchValue: s
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.loadend = !0;
            }
        }));
    },
    edit: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData(_defineProperty({}, "list[" + t + "].edit", !this.data.list[t].edit));
    },
    soldOut: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.list, s = this;
        wx.showModal({
            title: "提示",
            content: "确认" + (1 == e[t].status ? "下架" : "上架") + "?",
            success: function(a) {
                a.confirm && app.util.request({
                    url: "entry/wxapp/manage",
                    showLoading: !0,
                    data: {
                        op: "soldOut",
                        id: e[t].id,
                        status: e[t].status
                    },
                    success: function(a) {
                        app.look.ok(a.data.message), e.splice(t, 1), s.setData({
                            list: e
                        });
                    },
                    fail: function(a) {
                        app.look.no(a.data.message);
                    }
                });
            }
        });
    },
    delGood: function(a) {
        var e = a.currentTarget.dataset.index, s = this;
        wx.showModal({
            title: "提示",
            content: "确认删除?",
            success: function(a) {
                if (a.confirm) {
                    var t = s.data.list;
                    app.util.request({
                        url: "entry/wxapp/manage",
                        showLoading: !0,
                        data: {
                            op: "delGood",
                            id: t[e].id
                        },
                        success: function(a) {
                            app.look.ok(a.data.message), t.splice(e, 1), s.setData({
                                list: t
                            });
                        },
                        fail: function(a) {
                            app.look.no(a.data.message);
                        }
                    });
                }
            }
        });
    },
    goodEdit: function(a) {
        var t = a.currentTarget.dataset.index;
        wx.navigateTo({
            url: "../addGood/addGood?id=" + this.data.list[t].id
        });
    },
    editCategory: function(a) {
        this.setData({
            editCategory: !0
        });
    },
    editCategoryItem: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            editCategoryItem: !0,
            categoryItemValue: 0 <= t ? this.data.category[t].name : "",
            categoryItemIndex: t
        });
    },
    closeCategory: function() {
        this.setData({
            editCategory: !1
        });
    },
    closeCategoryItem: function() {
        this.setData({
            editCategoryItem: !1
        });
    },
    confirmCategoryItem: function() {
        if ("" != this.data.categoryItemValue) {
            var e = this;
            0 <= e.data.categoryItemIndex ? app.util.request({
                url: "entry/wxapp/manage",
                showLoading: !0,
                data: {
                    op: "editCategory",
                    id: e.data.category[e.data.categoryItemIndex].id,
                    name: e.data.categoryItemValue
                },
                success: function(a) {
                    app.look.ok(a.data.message), e.setData(_defineProperty({}, "category[" + e.data.categoryItemIndex + "].name", e.data.categoryItemValue)), 
                    e.closeCategoryItem();
                }
            }) : app.util.request({
                url: "entry/wxapp/manage",
                showLoading: !0,
                data: {
                    op: "addCategory",
                    name: e.data.categoryItemValue
                },
                success: function(a) {
                    app.look.ok(a.data.message);
                    var t = e.data.category;
                    t.concat(a.data.data), e.setData({
                        category: t
                    });
                }
            });
        }
    },
    onLoad: function(a) {
        this.page = 1, this.pagesize = 10, this.loadend = !1;
        var e = this;
        this.setData({
            "goHome.blackhomeimg": app.globalData.blackhomeimg
        }), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "category"
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    category: t.data.list
                });
            }
        }), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "goodsManage",
                category: e.data.categoryid,
                navIndex: e.data.navIndex,
                page: 1,
                pagesize: this.pagesize
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list
                });
            },
            fail: function(a) {
                app.look.alert(a.data.mesage), this.loadend = !0;
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        this.setData({
            searchValue: "",
            list: []
        }), this.loadend = !1, this.page = 1, app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !0,
            method: "POST",
            data: {
                op: "goodsManage",
                navIndex: this.data.navIndex,
                categoryid: this.data.categoryid,
                page: 1,
                pagesize: this.pagesize
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.loadend = !0;
            }
        });
    },
    lowend: function() {
        if (this.loadend) app.look.alert("数据加载完成"); else {
            var e = this;
            app.util.request({
                url: "entry/wxapp/manage",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "goodsManage",
                    searchValue: this.data.searchValue,
                    navIndex: this.data.navIndex,
                    categoryid: this.data.categoryid,
                    page: this.page + 1,
                    pagesize: this.pagesize
                },
                success: function(a) {
                    var t = a.data;
                    t.data.list && (e.setData({
                        list: e.data.list.concat(t.data.list)
                    }), e.page = e.page + 1);
                },
                fail: function(a) {
                    app.look.alert(a.data.message), e.loadend = !0;
                }
            });
        }
    },
    onReachBottom: function() {}
});