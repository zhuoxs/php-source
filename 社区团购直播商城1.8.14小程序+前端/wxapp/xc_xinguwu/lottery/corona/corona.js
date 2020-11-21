var app = getApp(), canRoll = !0, num = 1, lotteryArrLen = 0, lottery = [], now = "", timer_log = "";

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
        navCurrent: "0",
        userImg: "",
        synum: 2,
        show: !1,
        show1: !1,
        page: 1,
        pagesize: 20,
        loadend: !1,
        list: []
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
                e.setPlateData(a.data.list.contents), e.setData({
                    synum: a.data.num ? a.data.num : 0,
                    list: a.data.list ? a.data.list : null
                }), loadLog(e);
            }
        });
        var a = wx.createAnimation({
            duration: 2e3,
            timingFunction: "ease"
        });
        this.aniData = a, app.util.request({
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
    setPlateData: function(t) {
        if ((lotteryArrLen = t.length) < 2) ; else if (lotteryArrLen < 3 && 1 < lotteryArrLen) {
            for (var a = new Array(), e = 0; e < 4; e++) a[e] = e % 2 == 0 ? t[0] : t[1];
            t = [].concat(a);
        } else {
            for (var o = 0, n = new Array(), s = 0; s < lotteryArrLen; s++) n[s] = t[o], o++;
            t = [].concat(n);
        }
        lotteryArrLen = t.length, console.log(t), this.setData({
            lottery: t
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
    startRollTap: function() {
        var n = this;
        this.data.synum <= 0 ? this.setData({
            nochance: !0
        }) : canRoll && (canRoll = !1, n.setData({
            synum: n.data.synum - 1
        }), app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !0,
            data: {
                op: "drawlottery",
                id: n.data.options.id
            },
            success: function(t) {
                var a = t.data.data.index, e = n.aniData, o = a;
                e.rotate(3600 * num - 360 / lotteryArrLen * o).step(), n.setData({
                    aniData: e.export()
                }), num++, n.setData({
                    index: a
                });
            }
        }));
    },
    transitionend: function(t) {
        canRoll = !0, 5 == this.data.lottery[this.data.index].type ? this.setData({
            noPrize: !0
        }) : (this.setData({
            getPrize: !0
        }), 6 == this.data.lottery[index].type && this.setData({
            synum: this.data.synum + 1
        }));
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
    onReady: function() {
        var t = {};
        t.corona = app.module_url + "resource/wxapp/lottery/corona-bg.jpg", this.setData({
            images: t
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
        this.closeNoPrize(), this.startRollTap();
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
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {
        clearTimeout(timer_log);
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});