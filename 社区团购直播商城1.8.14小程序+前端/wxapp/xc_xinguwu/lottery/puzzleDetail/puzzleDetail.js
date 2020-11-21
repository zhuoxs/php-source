function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var Puzzle = require("./h5puzzle.js"), app = getApp(), game = null;

Page({
    data: {
        before: !0,
        countDownNum: "10",
        countDownNum1: "200",
        percent: 100,
        percent1: 100,
        imgUrl: "",
        chance: 20,
        type: 4,
        WIDTH: 0,
        HEIGHT: 0,
        width: 0,
        height: 0,
        status: !1,
        currentX: 0,
        currentY: 0,
        currentPX: 0,
        currentPY: 0,
        startTime: "",
        ranking: 99,
        usedtime: [ 0, 0, 0 ],
        showFinish: !1,
        page: 1,
        pagesize: 15,
        loadend: !1,
        log: null
    },
    seeList: function() {
        this.setData({
            showList: !0,
            shadow: !0
        });
    },
    countDown: function() {
        var t = this;
        if (this.data.chance <= 0) this.setData({
            noChance: !0
        }); else {
            this.setData({
                chance: this.data.chance - 1
            });
            var a = t.data.list.puzzle.memory_time;
            t.timer = setInterval(function() {
                if (a--, t.setData({
                    countDownNum: a,
                    percent: a / t.data.list.puzzle.memory_time * 100
                }), 0 == a) return clearInterval(t.timer), t.hideBefore(), void (game = new Puzzle(t, {
                    type: t.data.type
                }));
            }, 1e3);
        }
    },
    countDown1: function() {
        var t = this, a = t.data.list.puzzle.play_time;
        t.timer1 = setInterval(function() {
            if (a--, t.setData({
                countDownNum1: a,
                percent: a / t.data.list.puzzle.play_time * 100
            }), 0 == a) return clearInterval(t.timer1), void t.failed();
        }, 1e3);
    },
    playAgain: function() {
        var t = this;
        this.setData({
            before: !0,
            percent: 100
        }), setTimeout(function() {
            t.close(), t.countDown();
        }, 100);
    },
    failed: function() {
        this.setData({
            showFailed: !0,
            shadow: !0
        }), game.page.gameEnd = !1;
        var t = this;
        app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !1,
            data: {
                op: "puzzleLog",
                id: t.data.options.id,
                second: parseInt(t.data.list.puzzle.play_time - t.data.countDownNum1)
            },
            success: function(t) {}
        });
    },
    hideBefore: function() {
        this.setData({
            before: !1
        }), this.countDown1();
    },
    finishFunc: function() {
        var t = this;
        game.page.gemeEnd = !1, t.setData({
            showFinish: !0,
            shadow: !0
        }), clearInterval(this.timer1), app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !1,
            data: {
                op: "puzzleLog",
                id: t.data.options.id,
                second: parseInt(t.data.list.puzzle.play_time - t.data.countDownNum1)
            },
            success: function(t) {}
        });
    },
    retry: function() {
        var t = this;
        t.Puzzle = new Puzzle(t, {
            type: t.data.type
        }), t.setData({
            usedtime: [ 0, 0, 0 ],
            showFinish: !1,
            startTime: new Date()
        });
    },
    close: function() {
        this.setData({
            shadow: !1,
            showList: !1,
            showRank: !1,
            showFinish: !1,
            showFailed: !1,
            noChance: !1
        });
    },
    quitGame: function() {
        app.look.back(1);
    },
    seeRank: function() {
        this.setData({
            shadow: !0,
            showRank: !0
        });
        var e = this;
        null == this.data.log && app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !0,
            data: {
                op: "puzzleRankingList",
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
        }), app.util.request({
            url: "entry/wxapp/lottery",
            showLoading: !0,
            data: {
                op: "puzzleRankingSelf",
                id: e.data.options.id
            },
            success: function(t) {
                var a = t.data;
                a.data.list && e.setData({
                    rankself: a.data.list,
                    avatarurl: app.globalData.userInfo.avatarurl
                });
            }
        });
    },
    onLoad: function(t) {
        var n = this;
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
                var a, e = t.data;
                e.data.list && (n.setData((_defineProperty(a = {
                    list: e.data.list,
                    chance: e.data.num,
                    imgUrl: e.data.list.puzzle.img,
                    countDownNum: e.data.list.puzzle.memory_time,
                    countDownNum1: e.data.list.puzzle.play_time
                }, "imgUrl", e.data.list.puzzle.img), _defineProperty(a, "type", e.data.list.puzzle.row), 
                a)), n.countDown());
            }
        });
    },
    onReady: function() {
        var t = {};
        t.puzzle_bg = app.module_url + "/resource/wxapp/lottery/puzzle-bg.jpg", this.setData({
            images: t
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var t = "/xc_xinguwu/lottery/lottery/lottery?id=" + this.data.options.id;
        return {
            title: '您的好友邀请你一起来"玩游戏、赢奖品"!',
            path: "/xc_xinguwu/pages/base/base?share=" + (t = encodeURIComponent(t)) + "&useid=" + app.globalData.userInfo.id
        };
    }
});