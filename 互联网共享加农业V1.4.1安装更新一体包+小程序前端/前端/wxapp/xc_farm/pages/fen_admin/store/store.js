var common = require("../../common/common.js"), app = getApp();

Page({
    data: {
        navHref: "../../fen_admin/store/store",
        page: 1,
        pagesize: 20,
        isbottom: !1,
        code: ""
    },
    fen_del: function(a) {
        var t = this, e = a.currentTarget.dataset.index, s = t.data.xc;
        app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "fen_service",
                id: s.list[e].id,
                status: -1
            },
            success: function(a) {
                "" != a.data.data && (s.list.splice(e, 1), t.setData({
                    xc: s
                }));
            }
        });
    },
    code: function() {
        var e = this;
        "" != e.data.code ? e.setData({
            showhb: !0
        }) : app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "fen_code",
                openid: e.data.xc.userinfo.openid,
                type: 2
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && e.setData({
                    code: t.data.code,
                    showhb: !0
                });
            }
        });
    },
    closehb: function() {
        this.setData({
            showhb: !1,
            showhb2: !1
        });
    },
    dlimg: function() {
        wx.showLoading({
            title: "保存中"
        }), wx.downloadFile({
            url: this.data.code,
            success: function(a) {
                wx.saveImageToPhotosAlbum({
                    filePath: a.tempFilePath,
                    success: function(a) {
                        console.log(a), wx.hideLoading(), wx.showToast({
                            title: "保存成功",
                            icon: "success",
                            duration: 2e3
                        });
                    },
                    fail: function(a) {
                        wx.hideLoading(), wx.showToast({
                            title: "保存失败",
                            icon: "success",
                            duration: 2e3
                        });
                    }
                });
            }
        });
    },
    onLoad: function(a) {},
    onReady: function() {},
    onShow: function() {
        var e = this;
        common.config(e, "admin3"), e.setData({
            page: 1,
            isbottom: !1
        }), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "fen_index",
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && (e.setData({
                    xc: t.data
                }), "" != t.data.list && null != t.data.list ? e.setData({
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                }));
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        e.setData({
            page: 1,
            isbottom: !1
        }), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "fen_index",
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data && (e.setData({
                    xc: t.data
                }), "" != t.data.list && null != t.data.list ? e.setData({
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                }));
            }
        });
    },
    onReachBottom: function() {
        var s = this;
        s.data.isbottom || app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "fen_index",
                page: s.data.page,
                pagesize: s.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                if ("" != t.data) if ("" != t.data.list && null != t.data.list) {
                    var e = s.data.xc;
                    e.list = e.list.concat(t.data.list), s.setData({
                        xc: e,
                        page: s.data.page + 1
                    });
                } else s.setData({
                    isbottom: !0
                });
            }
        });
    }
});