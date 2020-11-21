var t = getApp(), e = t.requirejs("/core"), a = t.requirejs("jquery");

Page({
    data: {
        audios: {},
        audiosObj: {},
        roomid: "0",
        timeindex: "0",
        taskid: "0",
        timeid: "0",
        timer: 0,
        goods: "",
        rooms: "",
        room_num: 0,
        times: "",
        time_num: 0,
        advs: "",
        adv_num: 0,
        list_error: 0,
        goods_error: 0,
        message: "",
        lasttime: 0,
        hour: "-",
        min: "-",
        sec: "-",
        diypages: "",
        seckill_style: "",
        seckill_color: "",
        color: {
            red: "#ff5555",
            blue: "#4e87ee",
            purple: "#a839fa",
            orange: "#ff8c1e",
            pink: "#ff7e95"
        },
        swiperheight: ""
    },
    onLoad: function() {
        var t = this;
        wx.getSystemInfo({
            success: function(e) {
                "0" == e.model.indexOf("iPhone X") && t.setData({
                    height: "168rpx"
                });
                var a = e.windowWidth / 1.7;
                t.setData({
                    swiperheight: a
                });
            }
        }), e.get("seckill/get_list", {}, function(e) {
            1 == e.error ? t.setData({
                list_error: 1,
                message: e.message
            }) : (void 0 != e.diypages.items && a.each(e.diypages.items, function(a, s) {
                var i = {};
                "seckill_advs" == s.id && (i.adv_num = s.data.length), i.diypages = e.diypages, 
                t.setData(i);
            }), t.setData({
                rooms: e.rooms,
                room_num: e.rooms.length,
                times: e.times,
                time_num: e.times.length,
                timeindex: e.timeindex,
                roomid: e.roomid,
                taskid: e.taskid,
                timeid: e.timeid,
                seckill_style: e.seckill_style,
                seckill_color: e.seckill_color,
                background_color: e.diypages.background_color
            }), "style2" == e.seckill_style ? (wx.setNavigationBarColor({
                frontColor: e.diypages.titlebarcolor,
                backgroundColor: t.data.color[e.seckill_color]
            }), wx.setNavigationBarTitle({
                title: e.diypages.page_title
            })) : wx.setNavigationBarColor({
                frontColor: "#000000",
                backgroundColor: "#ffffff"
            }), t.getGoods(e.timeid));
        });
    },
    selected: function(t) {
        var a = this;
        a.setData({
            roomid: t.currentTarget.dataset.id
        });
        var s = t.currentTarget.dataset.id;
        e.get("seckill/get_list", {
            roomid: s
        }, function(t) {
            1 == t.error ? a.setData({
                list_error: 1,
                message: t.message
            }) : a.setData({
                rooms: t.rooms,
                times: t.times,
                time_num: t.times.length,
                timeindex: t.timeindex
            }), a.getGoods(t.timeid);
        });
    },
    current: function(t) {
        var e = this;
        e.getGoods(t.currentTarget.dataset.timeid), e.setData({
            timeindex: t.currentTarget.dataset.index
        });
    },
    getGoods: function(t) {
        var a = this;
        e.get("seckill/get_goods", {
            taskid: a.data.taskid,
            roomid: a.data.roomid,
            timeid: t
        }, function(e) {
            1 == e.error ? a.setData({
                goods_error: 1,
                message: e.message
            }) : (a.setData({
                goods_error: 0,
                goods: e.goods
            }), a.initTimer(t));
        });
    },
    initTimer: function(e) {
        var s = this, i = "";
        a.each(s.data.times, function(t, a) {
            a.id === e && (i = a);
        });
        var r = parseInt(i.status), o = i.starttime, n = i.endtime;
        if (clearInterval(s.data.timer), -1 != r) {
            var d = 0, u = 0, l = t.globalData.approot;
            wx.request({
                url: l + "map.json",
                success: function(t) {
                    var e = new Date(t.header.Date) / 1e3;
                    d = 0 == r ? n - e : o - e, s.setData({
                        lasttime: d
                    }), s.setTimer(i), u = s.setTimerInterval(i), s.setData({
                        timer: u
                    });
                }
            });
        }
    },
    formatSeconds: function(t) {
        var e = parseInt(t), a = 0, s = 0;
        return e > 60 && (a = parseInt(e / 60), e = parseInt(e % 60), a > 60 && (s = parseInt(a / 60), 
        a = parseInt(a % 60))), {
            hour: s < 10 ? "0" + s : s,
            min: a < 10 ? "0" + a : a,
            sec: e < 10 ? "0" + e : e
        };
    },
    setTimer: function(e) {
        var a = this, s = 0;
        if (-1 != e.status && parseInt(a.data.lasttime) % 10 == 0) {
            var i = t.globalData.approot;
            wx.request({
                url: i + "map.json",
                success: function(t) {
                    var i = new Date(t.header.Date) / 1e3;
                    s = 0 == e.status ? e.endtime - i : e.starttime - i, a.setData({
                        lasttime: s
                    });
                }
            });
        }
        s = parseInt(a.data.lasttime) - 1;
        var r = a.formatSeconds(s);
        a.setData({
            lasttime: s,
            hour: r.hour,
            min: r.min,
            sec: r.sec
        }), s <= 0 && a.onLoad();
    },
    setTimerInterval: function(t) {
        var e = this;
        return setInterval(function() {
            e.setTimer(t);
        }, 1e3);
    },
    play: function(t) {
        var e = t.target.dataset.id, a = this.data.audiosObj[e] || !1;
        if (!a) {
            a = wx.createInnerAudioContext("audio_" + e);
            var s = this.data.audiosObj;
            s[e] = a, this.setData({
                audiosObj: s
            });
        }
        var i = this;
        a.onPlay(function() {
            var t = setInterval(function() {
                var s = a.currentTime / a.duration * 100 + "%", r = Math.floor(Math.ceil(a.currentTime) / 60), o = (Math.ceil(a.currentTime) % 60 / 100).toFixed(2).slice(-2), n = Math.ceil(a.currentTime);
                r < 10 && (r = "0" + r);
                var d = r + ":" + o, u = i.data.audios;
                u[e].audiowidth = s, u[e].Time = t, u[e].audiotime = d, u[e].seconds = n, i.setData({
                    audios: u
                });
            }, 1e3);
        });
        var r = t.currentTarget.dataset.audio, o = t.currentTarget.dataset.time, n = t.currentTarget.dataset.pausestop, d = t.currentTarget.dataset.loopplay;
        0 == d && a.onEnded(function(t) {
            u[e].status = !1, i.setData({
                audios: u
            });
        });
        var u = i.data.audios;
        u[e] || (u[e] = {}), a.paused && 0 == o ? (a.src = r, a.play(), 1 == d && (a.loop = !0), 
        u[e].status = !0, i.pauseOther(e)) : a.paused && o > 0 ? (a.play(), 0 == n ? a.seek(o) : a.seek(0), 
        u[e].status = !0, i.pauseOther(e)) : (a.pause(), u[e].status = !1), i.setData({
            audios: u
        });
    },
    pauseOther: function(t) {
        var e = this;
        a.each(this.data.audiosObj, function(a, s) {
            if (a != t) {
                s.pause();
                var i = e.data.audios;
                i[a] && (i[a].status = !1, e.setData({
                    audios: i
                }));
            }
        });
    },
    navigate: function(t) {
        var e = t.currentTarget.dataset.url, a = t.currentTarget.dataset.phone, s = t.currentTarget.dataset.appid, i = t.currentTarget.dataset.appurl;
        e && wx.navigateTo({
            url: e,
            fail: function() {
                wx.switchTab({
                    url: e
                });
            }
        }), a && wx.makePhoneCall({
            phoneNumber: a
        }), s && wx.navigateToMiniProgram({
            appId: s,
            path: i
        });
    },
    tabwidget: function(t) {
        var a = this, s = a.data.diypages, i = (s.items, t.currentTarget.dataset.id), r = t.currentTarget.dataset.url, o = t.currentTarget.dataset.type;
        "" != r && void 0 != r && e.get("diypage/getInfo", {
            dataurl: r
        }, function(t) {
            for (var e in s.items) e == i && (s.items[e].data[o].data = t.goods.list, s.items[e].data[o].type = t.type, 
            s.items[e].type = t.type, s.items[e].status = o, t.goods.list.length <= 8 && (s.items[e].data[o].showmore = !0), 
            a.setData({
                diypages: s
            }));
        });
    }
});