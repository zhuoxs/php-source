var app = getApp();

Page({
    data: {
        page: 1,
        pagesize: 20,
        curIndex: 1
    },
    toDelete: function(a) {
        var t = a.currentTarget.dataset.index, e = this, n = this.data.list;
        wx.showModal({
            title: "提示",
            content: "确定删除员工?",
            success: function(a) {
                a.confirm ? app.util.request({
                    url: "entry/wxapp/manage",
                    showLoading: !0,
                    data: {
                        op: "staff_refuse",
                        id: n.id
                    },
                    success: function(a) {
                        app.globalData.userInfo.admin1 = -1, app.look.ok(a.data.message), n.splice(t, 1), 
                        e.setData({
                            list: n
                        });
                    }
                }) : a.cancel && console.log("用户点击取消");
            }
        });
    },
    bindTap: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            curIndex: t,
            list: []
        });
        var e = this;
        app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !0,
            data: {
                op: "staff",
                curindex: e.data.curIndex
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list
                });
            },
            fail: function() {
                e.setData({
                    loadend: !0
                });
            }
        });
    },
    previewImage: function(a) {
        wx.previewImage({
            urls: [ this.data.poster ]
        });
    },
    close: function(a) {
        this.setData({
            code: !1
        });
    },
    agree: function(a) {
        var t = this, e = a.currentTarget.dataset.index, n = this.data.list;
        app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !0,
            data: {
                op: "staff_agree",
                id: n[e].id
            },
            success: function(a) {
                app.globalData.userInfo.admin1 = 1, app.look.ok(a.data.message), n.splice(e, 1), 
                t.setData({
                    list: n,
                    num_2: t.data.num_2 - 1,
                    num_1: t.data.num_1 + 1
                });
            }
        });
    },
    refuse: function(a) {
        var t = a.currentTarget.dataset.index, e = this.data.list;
        app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !0,
            data: {
                op: "staff_refuse",
                id: e.id
            },
            success: function(a) {
                app.globalData.userInfo.admin1 = -1, app.look.ok(a.data.message), e.splice(t, 1), 
                that.setData({
                    list: e,
                    num_2: that.data.num_2 - 1
                });
            }
        });
    },
    save: function() {
        wx.downloadFile({
            url: this.data.poster,
            success: function(a) {
                var t = a.tempFilePath;
                wx.authorize({
                    scope: "scope.writePhotosAlbum",
                    success: function(a) {
                        console.log(a), wx.saveImageToPhotosAlbum({
                            filePath: t,
                            success: function(a) {
                                app.look.alert("保存成功");
                            },
                            fail: function(a) {
                                console.log(a), "saveImageToPhotosAlbum:fail auth deny" === a.errMsg && wx.openSetting({
                                    success: function(a) {}
                                });
                            }
                        });
                    },
                    fail: function(a) {
                        console.log(a);
                    }
                });
            }
        });
    },
    seeCode: function(a) {
        this.hideshare(), this.setData({
            code: !0
        });
        var t = this;
        app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !0,
            data: {
                op: "staff_poster"
            },
            success: function(a) {
                console.log(a), t.setData({
                    poster: a.data.data
                });
            }
        });
    },
    share: function(a) {
        var t = this, e = wx.createAnimation({
            duration: 500,
            timingFunction: "linear"
        });
        (t.animation = e).translateY(100).step(), t.setData({
            animationData: e.export(),
            share: !0
        }), setTimeout(function() {
            e.translateY(0).step(), t.setData({
                animationData: e.export()
            });
        }, 200);
    },
    hideshare: function() {
        var a = this, t = wx.createAnimation({
            duration: 1e3,
            timingFunction: "linear"
        });
        (a.animation = t).translateY(100).step(), a.setData({
            animationData: t.export()
        }), setTimeout(function() {
            t.translateY(0).step(), a.setData({
                animationData: t.export(),
                share: !1
            });
        }, 200);
    },
    onLoad: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "staff_num"
            },
            success: function(a) {
                var t = a.data;
                t.data.num_1 && e.setData({
                    num_1: t.data.num_1
                }), t.data.num_2 && e.setData({
                    num_2: t.data.num_2
                });
            }
        }), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "staff",
                curindex: e.data.curIndex,
                page: e.data.page,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list
                });
            },
            fail: function() {
                e.setData({
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
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "staff_num"
            },
            success: function(a) {
                var t = a.data;
                t.data.num_1 && e.setData({
                    num_1: t.data.num_1
                }), t.data.num_2 && e.setData({
                    num_2: t.data.num_2
                });
            }
        }), app.util.request({
            url: "entry/wxapp/manage",
            showLoading: !1,
            data: {
                op: "staff",
                curindex: e.data.curIndex,
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
            fail: function() {
                e.setData({
                    loadend: !0
                });
            }
        });
    },
    onReachBottom: function() {
        if (!this.data.loadend) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/manage",
                showLoading: !1,
                data: {
                    op: "staff",
                    curindex: e.data.curIndex,
                    page: e.data.page + 1,
                    pagesize: e.data.pagesize
                },
                success: function(a) {
                    wx.stopPullDownRefresh();
                    var t = a.data;
                    t.data.list && e.setData({
                        list: e.data.list.concat(t.data.list),
                        page: e.data.page + 1
                    });
                },
                fail: function() {
                    e.setData({
                        loadend: !0
                    });
                }
            });
        }
    },
    onShareAppMessage: function() {
        wx.showShareMenu({
            withShareTicket: !0
        });
        var a = "/xc_xinguwu/manage/staffapply/staffapply";
        return {
            title: "邀请你加入他的管理团队",
            path: "/xc_xinguwu/pages/base/base?share=" + (a = encodeURIComponent(a)),
            imageUrl: "",
            success: function(a) {
                wx.showToast({
                    title: "转发成功"
                });
            },
            fail: function(a) {}
        };
    }
});