var common = require("../common/common.js"), app = getApp();

Page({
    data: {
        tagCurr1: 0,
        tagCurr2: -1,
        tagList1: [ "产品", "活动", "认证信息" ],
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
                op: "code",
                openid: e.data.openid
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
            showhb: !1
        });
    },
    tagChange1: function(a) {
        var e = this;
        a.currentTarget.id != e.data.tagCurr1 && (e.setData({
            page: 1,
            isbottom: !1,
            tagCurr1: a.currentTarget.id,
            xc: []
        }), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "store_service",
                page: e.data.page,
                pagesize: e.data.pagesize,
                type: e.data.tagCurr1,
                openid: e.data.openid
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    xc: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0,
                    xc: []
                });
            }
        }));
    },
    tagChange2: function(a) {
        var e = this, t = a.currentTarget.id;
        if (e.data.tagCurr2 != t) {
            e.setData({
                page: 1,
                isbottom: !1,
                tagCurr2: t
            });
            var o = {
                op: "service",
                page: e.data.page,
                pagesize: e.data.pagesize,
                type: e.data.tagCurr1,
                openid: e.data.openid
            };
            -1 != t && (o.cid = e.data.xc.class[t].id), app.util.request({
                url: "entry/wxapp/service",
                method: "POST",
                data: o,
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
    map: function() {
        var a = this;
        wx.openLocation({
            name: a.data.xc.map.name,
            latitude: parseFloat(a.data.xc.map.latitude),
            longitude: parseFloat(a.data.xc.map.longitude),
            scale: 28
        });
    },
    call: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.xc.mobile
        });
    },
    previewImage: function(a) {
        var t = a.currentTarget.dataset.index;
        wx.previewImage({
            current: this.data.xc.imgs[t],
            urls: this.data.xc.imgs
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
                op: "store_apply",
                openid: e.data.openid
            },
            success: function(a) {
                var t = a.data;
                "" != t.data && e.setData({
                    list: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "store_service",
                page: e.data.page,
                pagesize: e.data.pagesize,
                type: e.data.tagCurr1,
                openid: e.data.openid
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    xc: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
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
        e.setData({
            page: 1,
            isbottom: !1
        }), app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "store_service",
                page: e.data.page,
                pagesize: e.data.pagesize,
                type: e.data.tagCurr1,
                openid: e.data.openid
            },
            success: function(a) {
                var t = a.data;
                wx.stopPullDownRefresh(), "" != t.data ? e.setData({
                    xc: t.data,
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0,
                    xc: []
                });
            }
        });
    },
    onReachBottom: function() {
        var e = this;
        e.data.isbottom || 2 == e.data.tagCurr1 || app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "store_service",
                page: e.data.page,
                pagesize: e.data.pagesize,
                type: e.data.tagCurr1,
                openid: e.data.openid
            },
            success: function(a) {
                var t = a.data;
                "" != t.data ? e.setData({
                    xc: e.data.xc.concat(t.data),
                    page: e.data.page + 1
                }) : e.setData({
                    isbottom: !0
                });
            }
        });
    }
});