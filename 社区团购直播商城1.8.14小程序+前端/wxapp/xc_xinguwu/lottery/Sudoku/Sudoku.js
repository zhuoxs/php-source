var app = getApp(), timer_log = "", now = "";

function loadLog(e) {
    if ("" == now) {
        var t = new app.util.date();
        now = t.dateToStr("yyyy-MM-dd HH:mm:ss");
    }
    app.util.request({
        url: "entry/wxapp/lottery",
        showLoading: !1,
        data: {
            op: "loadLog",
            id: e.data.options.id,
            date: now
        },
        success: function(t) {
            var a = t.data.data.list;
            now = a[a.length - 1].createtime;
            var o = new app.util.date();
            (a = e.data.list.concat(a)).forEach(function(t, a, e) {
                e.createtime = o.dateDiff(new Date(t.createtime), new Date()) + "分钟前";
            }), e.setData({
                tip: a
            });
        }
    }), timer_log = setTimeout(function() {
        loadLog(e);
    }, 6e4);
}

Page({
    data: {
        page: 1,
        pagesize: 15,
        loadend: !1,
        circleList: 16,
        colorAwardDefault: "#FFEDEF",
        colorAwardSelect: "#ff7071",
        indexSelect: null,
        isRunning: !1,
        show: !1,
        show1: !1,
        num: 3,
        tip: [],
        list: []
    },
    onLoad: function(t) {
        this.setData({
            options: t
        }), console.log(this.data.options);
        var i = this;
        app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !1,
            data: {
                op: "getLottery",
                id: t.id
            },
            success: function(t) {
                var a = t.data, e = a.data.list;
                console.log(e);
                for (var o = 25, s = 25, n = 0; n < 8; n++) 0 == n ? s = o = 25 : n < 3 ? (o = o, 
                s = s + 166.6666 + 15) : n < 5 ? (s = s, o = o + 150 + 15) : n < 7 ? (s = s - 166.6666 - 15, 
                o = o) : n < 8 && (s = s, o = o - 150 - 15), e.contents[n].topAward = o, e.contents[n].leftAward = s;
                i.setData({
                    list: e,
                    num: a.data.num
                }), wx.setNavigationBarTitle({
                    title: e.name
                });
            }
        }), app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !1,
            data: {
                op: "loadLotteryLog",
                id: t.id,
                page: 1,
                pagesize: i.data.pagesize
            },
            success: function(t) {
                var a = t.data;
                i.setData({
                    log: a.data.list ? a.data.list : null
                }), loadLog(i);
            },
            fail: function() {
                i.setData({
                    loadend: !0
                });
            }
        });
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
    startGame: function() {
        if (!this.data.isRunning) if (this.data.num <= 0) this.setData({
            nochance: !0
        }); else {
            var n = this;
            app.util.request({
                url: "entry/wxapp/lottery",
                showLoading: !0,
                data: {
                    op: "drawlottery",
                    id: n.data.options.id
                },
                success: function(t) {
                    n.setData({
                        isRunning: !0,
                        num: n.data.num - 1
                    });
                    var a = 0, e = 0, o = t.data.data.index;
                    app.globalData.userInfo.score = t.data.data.score;
                    var s = setInterval(function t() {
                        if (a++, 24 + o < (e += 1)) return clearInterval(s), n.setData({
                            isRunning: !1
                        }), console.log(n.data.list.contents[o]), void (5 == n.data.list.contents[o].type ? n.setData({
                            noPrize: !0
                        }) : (n.setData({
                            index: o,
                            getPrize: !0
                        }), 6 == n.data.list.contents[o].type && n.setData({
                            num: n.data.num + 1
                        })));
                        a %= 8, n.setData({
                            indexSelect: a
                        }), clearInterval(s), s = setInterval(t, 100 + 10 * e);
                    }, 100);
                },
                fail: function(t) {
                    2 == t.data.errno && n.setData({
                        nochance: !0
                    }), 1 == t.data.errno && app.util.message({
                        title: t.data.message,
                        type: "error"
                    });
                }
            });
        }
    },
    playAgain: function() {
        this.closeNoPrize(), this.startGame();
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
    close: function() {
        this.setData({
            show: !1
        });
    },
    close1: function() {
        this.setData({
            show1: !1,
            isRunning: !1
        });
    },
    closeNoPrize: function() {
        this.setData({
            noPrize: !1
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
    closePrize: function() {
        this.setData({
            getPrize: !1,
            isRunning: !1
        });
    },
    closeChance: function() {
        this.setData({
            nochance: !1
        });
    },
    onReady: function() {
        var t = {};
        t.sodoku_bg = app.module_url + "resource/wxapp/lottery/sodoku-bg.jpg", this.setData({
            images: t
        }), app.look.accredit(this);
    },
    onGotUserInfo: function(t) {
        app.look.getuserinfo(t, this);
    },
    onUnload: function() {
        clearTimeout(timer_log);
    }
});