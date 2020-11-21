var app = getApp();

Page({
    data: {
        navSelected: 1
    },
    deleteStaff: function(a) {
        var e = a.currentTarget.dataset.index, s = this;
        wx.showModal({
            title: "操作提示",
            content: "确认删除该员工吗?删除后将不可恢复!",
            success: function(a) {
                a.confirm && app.util.request({
                    url: "entry/wxapp/supplier",
                    showLoading: !0,
                    data: {
                        op: "deleteStaff",
                        id: s.data.list[e].id
                    },
                    success: function(a) {
                        app.look.ok(a.data.message);
                        var t = s.data.list;
                        t.splice(e, 1), s.setData({
                            list: t,
                            staffNum: parseInt(s.data.staffNum) - 1
                        });
                    }
                });
            }
        });
    },
    consent: function(a) {
        var e = a.currentTarget.dataset.index, s = this;
        wx.showModal({
            title: "操作提示",
            content: "确认同意申请?",
            success: function(a) {
                a.confirm && app.util.request({
                    url: "entry/wxapp/supplier",
                    showLoading: !0,
                    data: {
                        op: "staffConsent",
                        id: s.data.list[e].id
                    },
                    success: function(a) {
                        app.look.ok(a.data.message);
                        var t = s.data.list;
                        t.splice(e, 1), s.setData({
                            list: t,
                            staffNum: parseInt(s.data.staffNum) + 1,
                            staffApplyNum: parseInt(s.data.staffApplyNum) - 1
                        });
                    }
                });
            }
        });
    },
    neglect: function(a) {
        var e = a.currentTarget.dataset.index, s = this;
        wx.showModal({
            title: "操作提示",
            content: "确认忽略?",
            success: function(a) {
                a.confirm && app.util.request({
                    url: "entry/wxapp/supplier",
                    showLoading: !0,
                    data: {
                        op: "staffNeglect",
                        id: s.data.list[e].id
                    },
                    success: function(a) {
                        app.look.ok(a.data.message);
                        var t = s.data.list;
                        t.splice(e, 1), s.setData({
                            list: t,
                            staffApplyNum: parseInt(s.data.staffApplyNum) - 1
                        });
                    }
                });
            }
        });
    },
    allNeglect: function() {
        var t = this;
        wx.showModal({
            title: "操作提示",
            content: "确认全部忽略吗?",
            success: function(a) {
                a.confirm && app.util.request({
                    url: "entry/wxapp/supplier",
                    showLoading: !0,
                    data: {
                        op: "staffAllNeglect"
                    },
                    success: function(a) {
                        app.look.ok(a.data.message), t.setData({
                            list: [],
                            staffApplyNum: 0
                        });
                    }
                });
            }
        });
    },
    changeNav: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            navSelected: t
        });
        var e = this;
        e.page = 1, app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !0,
            data: {
                op: "loadSupplierStaff",
                page: 1,
                pagesize: e.pagesize,
                navSelected: t
            },
            success: function(a) {
                var t = a.data;
                t.data.list && (e.setData({
                    list: t.data.list
                }), e.loadend = !1);
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.loadend = !0, e.setData({
                    list: []
                });
            }
        });
    },
    onLoad: function(a) {
        console.log(a);
        var e = this;
        this.options = a, this.page = 1, this.pagesize = 20, this.loadend = !1, app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !1,
            data: {
                op: "getSupplierStaffNum",
                supplier_id: a.id
            },
            success: function(a) {
                var t = a.data;
                e.data.supplier_id = t.data.supplier_id, e.setData({
                    staffNum: t.data.staffNum,
                    staffApplyNum: t.data.staffApplyNum
                });
            }
        }), app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !1,
            data: {
                op: "loadSupplierStaff",
                page: 1,
                pagesize: e.pagesize,
                navSelected: e.data.navSelected
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
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !0,
            data: {
                op: "loadSupplierStaff",
                page: 1,
                pagesize: e.pagesize,
                navSelected: e.data.navSelected
            },
            success: function(a) {
                var t = a.data;
                t.data.list && (e.setData({
                    list: t.data.list
                }), e.page = 1, e.loadend = !1);
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.loadend = !0, e.setData({
                    list: []
                });
            }
        }), app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !1,
            data: {
                op: "getSupplierStaffNum"
            },
            success: function(a) {
                var t = a.data;
                e.setData({
                    staffNum: t.data.staffNum,
                    staffApplyNum: t.data.staffApplyNum
                });
            }
        });
    },
    onReachBottom: function() {
        if (!this.loadend) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/supplier",
                showLoading: !0,
                data: {
                    op: "loadSupplierStaff",
                    page: e.page + 1,
                    pagesize: e.pagesize,
                    navSelected: e.data.navSelected
                },
                success: function(a) {
                    var t = a.data;
                    t.data.list && (e.setData({
                        list: e.data.list.concat(t.data.list)
                    }), e.page += 1);
                },
                fail: function(a) {
                    app.look.alert(a.data.message), e.loadend = !0;
                }
            });
        }
    },
    onShareAppMessage: function() {
        console.log("6666666666666666666666");
        var a = "/xc_xinguwu/supplier/supplierStaffApply/supplierStaffApply?supplier_id=" + this.data.supplier_id;
        return console.log(a), {
            path: "/xc_xinguwu/pages/base/base?share=" + (a = encodeURIComponent(a)) + "&userid=" + app.globalData.userInfo,
            success: function() {
                wx.showToast({
                    title: "转发成功"
                });
            }
        };
    }
});