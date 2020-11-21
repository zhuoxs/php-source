var _slotMachine = require("../components/slotMachine/slotMachine.js"), _slotMachine2 = _interopRequireDefault(_slotMachine);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp(), now = "", timer_log = "";

function loadLog(n) {
    if ("" == now) {
        var t = new app.util.date();
        now = t.dateToStr("yyyy-MM-dd HH:mm:ss");
    }
    app.util.request({
        url: "entry/wxapp/lottery",
        showLoading: !1,
        data: {
            op: "loadLog",
            id: n.data.options.id,
            date: now
        },
        success: function(t) {
            var a = t.data;
            now = a.data.list[a.data.list.length - 1].createtime;
            var e = a.data.list, o = new app.util.date();
            (e = n.data.list.concat(e)).forEach(function(t, a, e) {
                e.createtime = o.dateDiff(new Date(t.createtime), new Date()) + "分钟前";
            }), n.setData({
                tip: e
            });
        }
    }), timer_log = setTimeout(function() {
        loadLog(n);
    }, 6e4);
}

Page({
    data: {
        circleList: [],
        colorCircleFirst: "#fede2b",
        colorCircleSecond: "#f9746d",
        page: 1,
        pagesize: 20,
        loadend: !1
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
    seeShare: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !0,
            data: {
                op: "getPoster",
                id: a.data.list.id,
                poster: a.data.list.poster,
                type: a.data.list.type
            },
            success: function(t) {
                a.setData({
                    poster: t.data.data,
                    showShare: !0
                });
            }
        });
    },
    previewImage: function() {
        wx, wx.previewImage({
            urls: [ this.data.poster ],
            success: function(t) {},
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    playAgain: function() {
        this.closeNoPrize(), this.onStart();
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
    closeShare: function() {
        this.setData({
            showShare: !1
        });
    },
    closePrize: function() {
        this.setData({
            getPrize: !1
        });
    },
    closeChance: function() {
        this.setData({
            nochance: !1
        });
    },
    closeNoPrize: function() {
        this.setData({
            noPrize: !1
        });
    },
    onLoad: function(t) {
        var e = this;
        this.setData({
            options: t
        }), app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !1,
            data: {
                op: "getLottery",
                id: t.id
            },
            success: function(t) {
                var a = t.data;
                console.log(a.data.list), e.setData({
                    list: a.data.list ? a.data.list : null,
                    num: a.data.num ? a.data.num : 0
                }), loadLog(e), e.slotMachine = new _slotMachine2.default(e, {
                    height: 105,
                    len: a.data.list.contents.length,
                    transY1: 0,
                    num1: 0,
                    transY2: 0,
                    num2: 0,
                    transY3: 0,
                    num3: 0,
                    transY4: 0,
                    num4: 0,
                    speed: 24,
                    callback: function() {}
                });
            }
        }), app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !1,
            data: {
                op: "loadLotteryLog",
                id: t.id,
                page: 1,
                pagesize: e.data.pagesize
            },
            success: function(t) {
                var a = t.data;
                e.setData({
                    log: a.data.list ? a.data.list : null
                }), loadLog(e);
            },
            fail: function() {
                e.setData({
                    loadend: !0
                });
            }
        });
    },
    onReady: function() {
        var t = {};
        t.slot_bg_img = app.module_url + "/resource/wxapp/lottery/slot-bg-img.jpg", this.setData({
            images: t
        });
    },
    onUnload: function() {
        clearTimeout(timer_log);
    },
    onStart: function() {
        var e = this;
        this.data.num <= 0 ? e.setData({
            nochance: !0
        }) : app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !0,
            data: {
                op: "drawlottery",
                id: e.data.options.id
            },
            success: function(t) {
                e.setData({
                    num: e.data.num - 1
                });
                var a = t.data.data.index;
                e.slotMachine.num1 = e.slotMachine.num2 = e.slotMachine.num3 = e.slotMachine.num4 = a, 
                e.slotMachine.endCallBack = function() {
                    5 == e.data.list.contents[a].type ? e.setData({
                        noPrize: !0
                    }) : (e.setData({
                        getPrize: !0
                    }), 6 == e.data.list.contents[a].type && e.setData({
                        num: e.data.nun + 1
                    }));
                }, e.setData({
                    index: a
                }), e.slotMachine.start();
            }
        });
    }
});