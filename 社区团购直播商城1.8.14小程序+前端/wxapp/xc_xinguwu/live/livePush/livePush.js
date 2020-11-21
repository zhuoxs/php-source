function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var app = getApp(), webim = require("../../../we7/resource/js/webim_wx.js"), webimhandler = require("../../../we7/resource/js/webim_handler.js");

global.webim = webim;

var Config = {
    sdkappid: null,
    accountType: null,
    accountMode: 0
}, totalSecond = 0, interval = "", startTime = null, timer_Dialog = null, timer_onlineNum = null;

function loadDialog(i) {
    var t = "";
    t = 0 == i.data.msgs.length ? startTime : i.data.msgs[i.data.msgs.length - 1].createtime, 
    app.util.request({
        url: "entry/wxapp/live",
        method: "POST",
        showLoading: !1,
        data: {
            op: "loadDialog",
            time: t,
            live_id: i.data.list.id
        },
        success: function(t) {
            var e = t.data;
            if (e.data.list) {
                var a = i.data.msgs;
                e.data.list.forEach(function(t, e, a) {
                    2 == t.type ? a[e].content = "进入了房间" : 3 == t.type ? (a[e].content = "刚刚点了个赞", i.setData({
                        praise: i.data.praise + 1
                    })) : 4 == t.type ? a[e].content = "刚刚剁了手" : t.type;
                }), i.setData(_defineProperty({
                    msgs: a.concat(e.data.list)
                }, "list.number", t.data.data.num)), i.dialogTobottom();
            }
        },
        fail: function(t) {
            console.log("聊天返回3"), t && t.data && t.data.data && t.data.data.num && i.setData(_defineProperty({}, "list.number", t.data.data.num));
        }
    }), timer_Dialog = setTimeout(function() {
        loadDialog(i);
    }, 1e3 * app.globalData.webset.live_dialog_time);
}

Page({
    data: {
        saveing: !1,
        pushUrl: "",
        userinfo: {},
        msgs: [],
        Identifier: null,
        UserSig: null,
        msgContent: "",
        countHour: "00",
        countDownMinute: "00",
        countDownSecond: "00",
        praise: 0,
        muted: !1,
        mode: "HD",
        beauty: 6.3,
        start: !1,
        whiteness: 3,
        enableCamera: !0,
        showbtn: !1,
        light: !1,
        pushArea: !0
    },
    onMuteClick: function() {
        this.setData({
            muted: !this.data.muted
        });
    },
    savetitle: function(t) {
        this.setData({
            title: t.detail.value
        });
    },
    saveLive: function() {
        1 != this.data.saveing && (this.data.saveing = !0, app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            showLoading: !0,
            data: {
                op: "saveLive",
                title: this.data.title,
                id: this.data.list.id
            },
            success: function(t) {
                app.look.ok(t.data.message, function() {
                    wx.reLaunch({
                        url: "/xc_xinguwu/manage/manageIndex/manageIndex"
                    });
                });
            },
            fail: function(t) {
                app.look.no(t.data.message);
            },
            complete: function(e) {
                function t(t) {
                    return e.apply(this, arguments);
                }
                return t.toString = function() {
                    return e.toString();
                }, t;
            }(function(t) {
                console.log(complete), this.data.saveing = !1;
            })
        }));
    },
    onSwitchMode: function() {
        var t = !this.data.showHDTips;
        this.setData({
            showHDTips: t
        });
    },
    onModeClick: function(t) {
        var e = "SD";
        switch (t.target.dataset.mode) {
          case "SD":
            e = "SD";
            break;

          case "HD":
            e = "HD";
            break;

          case "FHD":
            e = "FHD";
        }
        this.setData({
            mode: e,
            showHDTips: !1
        });
    },
    onBeautyClick: function() {
        0 != this.data.beauty ? (this.data.beauty = 0, this.data.whiteness = 0) : (this.data.beauty = 6.3, 
        this.data.whiteness = 3), this.setData({
            beauty: this.data.beauty,
            whiteness: this.data.whiteness
        });
    },
    get_online: function() {
        var i = this;
        1 == app.globalData.webset.live_dialog_type ? webim.getGroupInfo({
            GroupIdList: [ i.data.list.groupid ],
            GroupBaseInfoFilter: [ "MemberNum" ]
        }, function(t) {
            var e = t;
            if (0 == e.ErrorCode) {
                var a = e.GroupInfo[0].MemberNum;
                app.look.istrue(a) || (a = 0), app.util.request({
                    url: "entry/wxapp/live",
                    method: "POST",
                    showLoading: !1,
                    data: {
                        op: "changeOnlineNum",
                        id: i.data.options.id,
                        num: a
                    },
                    success: function(t) {
                        i.setData(_defineProperty({}, "list.number", a));
                    }
                });
            }
        }, function(t) {}) : 1 == i.data.list.isplay && app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            showLoading: !1,
            data: {
                op: "queryOnlineNum",
                stream: i.data.list.stream,
                live_id: i.data.list.id
            },
            success: function(t) {
                console.log(t), i.setData(_defineProperty({}, "list.number", t.data.data));
            },
            fail: function(t) {
                app.look.alert(t.data.message);
            }
        }), timer_onlineNum = setTimeout(function() {
            i.get_online();
        }, 12e4);
    },
    dialogTobottom: function() {
        var t = this.data.msgs.length;
        t <= 4 ? t = 0 : t -= 4, this.setData({
            scrollTop: 64 * t
        });
    },
    receiveMsgs: function(t) {
        var e = this.data.msgs || [];
        "@TIM#SYSTEM" == t.fromAccountNick && (t.fromAccountNick = "系统提示", t.content = t.content.substr(7, t.content.length));
        var a = t.content.substring(0, 7);
        "#18mod#" == a && (t.content = "刚剁了手"), "[群点赞消息]" != a ? (e.push(t), this.setData({
            msgs: e
        }), this.dialogTobottom()) : this.setData({
            praise: this.data.praise + 1
        });
    },
    initIM: function(t) {
        var e = this, a = e.data.list.groupid;
        webimhandler.init({
            accountMode: Config.accountMode,
            accountType: Config.accountType,
            sdkAppID: Config.sdkappid,
            avChatRoomId: a,
            selType: webim.SESSION_TYPE.GROUP,
            selToID: a,
            selSess: null
        });
        var i = {
            sdkAppID: Config.sdkappid,
            appIDAt3rd: Config.sdkappid,
            accountType: Config.accountType,
            identifier: e.data.Identifier,
            identifierNick: t.nickName,
            userSig: e.data.UserSig
        }, o = (webimhandler.onDestoryGroupNotify, webimhandler.onRevokeGroupNotify, webimhandler.onCustomGroupNotify, 
        {
            onConnNotify: webimhandler.onConnNotify,
            onBigGroupMsgNotify: function(t) {
                webimhandler.onBigGroupMsgNotify(t, function(t) {
                    e.receiveMsgs(t);
                });
            },
            onMsgNotify: webimhandler.onMsgNotify,
            onGroupSystemNotifys: webimhandler.onGroupSystemNotifys,
            onGroupInfoChangeNotify: webimhandler.onGroupInfoChangeNotify
        }), n = {
            isAccessFormalEnv: !0,
            isLogOn: !0
        };
        Config.accountMode, webimhandler.sdkLogin(i, o, n, a);
    },
    onLoad: function(t) {
        console.log(t), this.setData({
            options: t
        });
        var o = this;
        app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            data: {
                op: "get_live",
                id: o.data.options.id
            },
            success: function(t) {
                var e = t.data;
                if (e.data.list && (console.log(e.data.list), o.setData({
                    list: e.data.list,
                    pushUrl: e.data.list.pusher.replace(" ", ""),
                    title: e.data.list.title
                }), wx.setNavigationBarTitle({
                    title: e.data.list.title
                })), 1 == app.globalData.webset.live_dialog_type) {
                    e.data.sdkappid && (Config.sdkappid = e.data.sdkappid), e.data.accounttype && (Config.accountType = e.data.accounttype), 
                    e.data.sig && o.setData({
                        Identifier: "user" + app.globalData.userInfo.id,
                        UserSig: e.data.sig
                    });
                    var a = [];
                    a.nickName = app.globalData.userInfo.nickname, o.initIM(a);
                } else {
                    var i = new app.util.date();
                    startTime = i.dateToStr("yyyy-MM-dd HH:mm:ss"), loadDialog(o);
                }
                setTimeout(function() {
                    o.get_online();
                }, 12e4);
            }
        });
    },
    onReady: function(t) {
        wx.setKeepScreenOn({
            keepScreenOn: !0
        }), this.ctx = wx.createLivePusherContext("pusher");
        var e = {};
        e.people = app.module_url + "resource/wxapp/live/people.png", e.live_detail_heart = app.module_url + "resource/wxapp/live/live-detail-heart.png", 
        e.beauty = app.module_url + "resource/wxapp/live/beauty.png", e.beauty_dis = app.module_url + "resource/wxapp/live/beauty-dis.png", 
        e.camera_dis = app.module_url + "resource/wxapp/live/camera-dis.png", e.c_camera = app.module_url + "resource/wxapp/live/c-camera.png", 
        e.dis_microphone = app.module_url + "resource/wxapp/live/dis-microphone.png", e.HD = app.module_url + "resource/wxapp/live/HD.png", 
        e.microphone = app.module_url + "resource/wxapp/live/microphone.png", e.off = app.module_url + "resource/wxapp/live/off.png", 
        e.SD = app.module_url + "resource/wxapp/live/SD.png", e.hd_tips = app.module_url + "resource/wxapp/live/hd_tips.png", 
        e.FHD = app.module_url + "resource/wxapp/live/FHD.png", this.setData({
            images: e,
            showbtn: !0
        });
    },
    statechange: function(t) {
        console.log("live-pusher code:", t.detail.code);
    },
    bindStart: function() {
        var e = this, a = this;
        this.ctx.start({
            success: function(t) {
                e.setData(_defineProperty({
                    start: !0
                }, "list.isplay", 1)), app.look.alert("开始直播"), a.timeUp(), console.log("start success");
            },
            fail: function(t) {
                console.log("start fail");
            }
        });
    },
    bindStop: function() {
        var a = this, i = this;
        this.ctx.stop({
            success: function(t) {
                var e = !0;
                1 == app.globalData.webset.live_playback && i.data.totalSecond > 60 * parseInt(app.globalData.webset.live_playback_time) && (e = !1), 
                a.setData(_defineProperty({
                    start: !1,
                    pushArea: e
                }, "list.isplay", -1)), console.log("stop success");
            },
            fail: function(t) {
                console.log("stop fail");
            }
        });
    },
    bindSwitchCamera: function() {
        this.ctx.switchCamera({
            success: function(t) {
                console.log("switchCamera success");
            },
            fail: function(t) {
                console.log("switchCamera fail");
            }
        });
    },
    cancelSaveLive: function() {
        this.setData({
            pushArea: !0
        });
    },
    onEnableCameraClick: function() {
        this.setData({
            enableCamera: !this.data.enableCamera
        }), this.data.enableCamera ? this.ctx.resume() : this.ctx.pause({
            success: function(t) {
                console.log(t);
            }
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {
        clearTimeout(timer_Dialog), clearTimeout(timer_onlineNum);
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    timeUp: function() {
        var u = this;
        "" != interval && clearInterval(interval), interval = setInterval(function() {
            var t = totalSecond, e = Math.floor(t / 3600 / 24), a = e.toString();
            1 == a.length && (a = "0" + a);
            var i = Math.floor((t - 3600 * e * 24) / 3600), o = i.toString();
            1 == o.length && (o = "0" + o);
            var n = Math.floor(t / 3600).toString();
            1 == n.length && (n = "0" + n);
            var s = Math.floor((t - 3600 * e * 24 - 3600 * i) / 60), l = s.toString();
            1 == l.length && (l = "0" + l);
            var r = (t - 3600 * e * 24 - 3600 * i - 60 * s).toString();
            1 == r.length && (r = "0" + r), u.setData({
                countHour: n,
                countDownDay: a,
                countDownHour: o,
                countDownMinute: l,
                countDownSecond: r,
                totalSecond: totalSecond + 1
            }), totalSecond++;
        }.bind(u), 1e3);
    }
});