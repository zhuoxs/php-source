var common = require("../common/common.js"), app = getApp();

Page({
    data: {
        tagCurr1: 0,
        tagCurr2: -1,
        tagList1: [ "全部", "拼团", "砍价", "秒杀" ],
        page: 1,
        pagesize: 20,
        isbottom: !1,
        code: ""
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
                openid: e.data.openid,
                type: 1
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
    tagChange1: function(a) {
        var e = this;
        if (a.currentTarget.id != e.data.tagCurr1) {
            e.setData({
                page: 1,
                isbottom: !1,
                tagCurr1: a.currentTarget.id
            });
            var t = {
                op: "service",
                page: e.data.page,
                pagesize: e.data.pagesize,
                type: e.data.tagCurr1,
                fen_openid: e.data.openid
            };
            -1 != e.data.tagCurr2 && (t.cid = e.data.xc.class[e.data.tagCurr2].id), app.util.request({
                url: "entry/wxapp/service",
                method: "POST",
                data: t,
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
        }
    },
    tagChange2: function(a) {
        var e = this, t = a.currentTarget.id;
        if (e.data.tagCurr2 != t) {
            e.setData({
                page: 1,
                isbottom: !1,
                tagCurr2: t
            });
            var s = {
                op: "service",
                page: e.data.page,
                pagesize: e.data.pagesize,
                type: e.data.tagCurr1,
                fen_openid: e.data.openid
            };
            -1 != t && (s.cid = e.data.xc.class[t].id), app.util.request({
                url: "entry/wxapp/service",
                method: "POST",
                data: s,
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
        }
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
    menu_on: function() {
        this.setData({
            showhb2: !0
        });
    },
    onLoad: function(a) {
        var e = this;
        common.config(e), e.setData({
            openid: a.openid
        }), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            method: "POST",
            data: {
                op: "fen_apply2",
                openid: e.data.openid
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && e.setData({
                    list: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "service",
                page: e.data.page,
                pagesize: e.data.pagesize,
                type: e.data.tagCurr1,
                fen_openid: e.data.openid
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
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onReachBottom: function() {
        var s = this;
        if (!s.data.isbottom) {
            var a = {
                op: "service",
                page: s.data.page,
                pagesize: s.data.pagesize,
                type: s.data.tagCurr1,
                fen_openid: s.data.openid
            };
            -1 != s.data.tagCurr2 && (a.cid = s.data.xc.class[s.data.tagCurr2].id), app.util.request({
                url: "entry/wxapp/service",
                method: "POST",
                data: a,
                success: function(a) {
                    var t = a.data;
                    if ("" != t.data) if ("" != t.data.list && null != t.data.list) {
                        var e = s.data.xc;
                        e.list = e.list.concat(t.data.list), s.setData({
                            page: s.data.page + 1,
                            xc: e
                        });
                    } else wx.showToast({
                        title: "全部加载",
                        icon: "success",
                        duration: 2e3
                    }), s.setData({
                        isbottom: !0
                    });
                }
            });
        }
    }
});