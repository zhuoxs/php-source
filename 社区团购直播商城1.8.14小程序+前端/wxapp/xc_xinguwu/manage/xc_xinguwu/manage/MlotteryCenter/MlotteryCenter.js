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
        curIndex: 0,
        page: 1,
        pagesize: 15,
        loadend: !1,
        taokouling: "12345678"
    },
    scan: function() {
        wx.scanCode({
            onlyFromCamera: !0,
            success: function(a) {
                app.util.request({
                    url: "entry/wxapp/lottery",
                    showLoading: !0,
                    data: {
                        op: "sweepCodeHex",
                        text: a.result
                    },
                    success: function(a) {
                        if (app.look.ok(a.data.message), 0 == that.data.curIndex) that.setData(_defineProperty({}, "list[" + that.data.index + "].log_status", 2)); else {
                            var t = that.data.list;
                            t.splice(that.data.index, 1), that.setData({
                                list: t
                            });
                        }
                    }
                });
            }
        });
    },
    prizeDeliveery: function(a) {
        this.setData({
            prizeDeliveery: !0,
            index: a.currentTarget.dataset.index
        });
    },
    prizeHex: function(a) {
        this.setData({
            prizeHex: !0,
            index: a.currentTarget.dataset.index
        });
    },
    changeNav: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            curIndex: t
        });
    },
    confirmDelivery: function() {
        app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !0,
            data: {
                op: "confirmDelivery",
                id: that.data.list[that.data.index].id
            },
            success: function(a) {
                if (app.look.ok(a.data.message), 0 == that.data.curIndex) that.setData(_defineProperty({}, "list[" + that.data.index + "].log_status", 2)); else {
                    var t = that.data.list;
                    t.splice(that.data.index, 1), that.setData({
                        list: t
                    });
                }
            }
        });
    },
    inputValue: function(a) {
        this.inputValue = a.detail.value;
    },
    confirmHex: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !0,
            data: {
                op: "confirmHex",
                id: e.data.list[e.data.index].id,
                text: e.inputValue
            },
            success: function(a) {
                if (e.inputValue = "", app.look.ok(a.data.message), 0 == e.data.curIndex) e.setData(_defineProperty({}, "list[" + e.data.index + "].log_status", 2)); else {
                    var t = e.data.list;
                    t.splice(e.data.index, 1), e.setData({
                        list: t
                    });
                }
            }
        });
    },
    close: function() {
        this.setData({
            prizeHex: !1,
            prizeDeliveery: !1
        });
    },
    onLoad: function(a) {
        1 != app.globalData.userInfo.admin1 && 1 != app.globalData.userInfo.admin2 && app.util.message({
            title: "您当前无权操作",
            redirect: "redirect:/xc_xinguwu/pages/index/index"
        });
        var e = this;
        app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !1,
            data: {
                op: "loadLotteryManage",
                curIndex: e.data.curIndex,
                page: 1,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                t.data.list && (console.log(t.data.list), e.setData({
                    list: t.data.list
                }));
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.setData({
                    loadend: !0
                });
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
            url: "entry/wxapp/lottery",
            showLoading: !0,
            data: {
                op: "loadLotteryManage",
                curIndex: e.data.curIndex,
                page: 1,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list,
                    page: 1,
                    loadend: !1
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.setData({
                    loadend: !0,
                    list: []
                });
            }
        });
    },
    onReachBottom: function() {
        if (!this.data.loadend) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/lottery",
                showLoading: !0,
                data: {
                    op: "loadLotteryManage",
                    curIndex: e.data.curIndex,
                    page: e.data.page + 1,
                    pagesize: e.data.pagesize
                },
                success: function(a) {
                    var t = a.data;
                    t.data.list && e.setData({
                        list: e.data.list.concat(t.data.list),
                        page: e.data.page + 1
                    });
                },
                fail: function(a) {
                    app.look.alert(a.data.message), e.setData({
                        loadend: !0
                    });
                }
            });
        }
    }
});