var _scratch = require("../components/scratch/scratch.js"), _scratch2 = _interopRequireDefault(_scratch);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp();

Page({
    data: {
        show: !1,
        isStart: !0,
        nochance: !1,
        num: 0,
        log: null,
        page: 1,
        pagesize: 20,
        loadend: !1
    },
    onLoad: function(t) {
        this.scratch = new _scratch2.default(this, {
            canvasWidth: 315,
            canvasHeight: 110,
            maskColor: "#FFC404",
            imageResource: "",
            r: 15,
            awardTxt: "谢谢参与",
            awardTxtColor: "#FFC404",
            awardTxtFontSize: "32px",
            callback: function() {}
        }), this.setData({
            options: t
        });
        var e = this;
        app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !1,
            data: {
                op: "getLottery",
                id: t.id
            },
            success: function(t) {
                var a = t.data;
                e.setData({
                    list: a.data.list ? a.data.list : null,
                    num: a.data.num ? a.data.num : 0
                });
            }
        });
    },
    onStart: function() {
        var t = this.data.isStart;
        if (!(this.data.num <= 0)) if (t) {
            this.setData({
                num: this.data.num - 1
            });
            var e = this;
            app.util.request({
                url: "entry/wxapp/lottery",
                showLoading: !0,
                data: {
                    op: "drawlottery",
                    id: e.data.options.id
                },
                success: function(t) {
                    var a = t.data.data.index;
                    e.scratch.endCallBack = function() {
                        5 != e.data.list.contents[a].type && (e.setData({
                            success: !0
                        }), 6 == e.data.list.contents[a].type && e.setData({
                            num: e.data.nun + 1
                        }));
                    }, e.scratch.start(), e.setData(_defineProperty({
                        isStart: !1
                    }, "scratch.awardTxt", e.data.list.contents[a].name)), e.setData({
                        show: !0
                    });
                }
            });
        } else this.scratch.restart();
    },
    close: function() {
        this.setData({
            success: !1
        });
    },
    closeList: function() {
        this.setData({
            showList: !1
        });
    },
    seeList: function() {
        if (this.setData({
            showList: !0
        }), null == this.data.log) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/lottery",
                showLoading: !0,
                data: {
                    op: "loadLotteryLog",
                    id: e.data.options.id,
                    page: 1,
                    pagesize: e.data.pagesize
                },
                success: function(t) {
                    var a = t.data;
                    a.data.list && e.setData({
                        log: a.data.list
                    });
                },
                fail: function(t) {
                    app.look.alert(t.data.message), e.setData({
                        loadend: !0
                    });
                }
            });
        }
    },
    loadLotteryLog: function() {
        if (!this.data.loadend) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/lottery",
                showLoading: !1,
                data: {
                    op: "loadLotteryLog",
                    id: e.data.options.id,
                    page: e.data.page + 1,
                    pagesize: e.data.pagesize
                },
                success: function(t) {
                    var a = t.data;
                    e.setData({
                        log: e.data.log.concat(a.data.list),
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
    previewImage: function() {
        wx.previewImage({
            urls: [ this.data.poster ],
            success: function(t) {},
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    savePoster: function() {
        if (app.look.istrue(this.data.poster)) {
            wx.downloadFile({
                url: this.data.poster,
                success: function(t) {
                    console.log(t);
                    var a = t.tempFilePath;
                    wx.authorize({
                        scope: "scope.writePhotosAlbum",
                        success: function(t) {
                            wx.saveImageToPhotosAlbum({
                                filePath: a,
                                success: function(t) {
                                    app.look.alert("保存成功");
                                },
                                fail: function(t) {
                                    "saveImageToPhotosAlbum:fail auth deny" === t.errMsg && wx.openSetting({
                                        success: function(t) {}
                                    });
                                }
                            });
                        }
                    });
                }
            });
        }
    },
    seeShare: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !0,
            data: {
                op: "getPoster",
                id: a.data.list.id,
                poster: a.data.list.poster
            },
            success: function(t) {
                a.setData({
                    poster: t.data.data,
                    showShare: !0
                });
            }
        });
    },
    closeShare: function() {
        this.setData({
            showShare: !1
        });
    },
    onReady: function() {
        var t = {};
        t.scratch_off_bg = app.module_url + "/resource/wxapp/lottery/scratch-off-bg.jpg", 
        this.setData({
            images: t
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});