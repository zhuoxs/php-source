var WxParse = require("../../sudu8_page/resource/wxParse/wxParse.js"), app = getApp(), innerAudioContext = wx.createInnerAudioContext();

Page({
    data: {
        staffinfo: "",
        style: 0,
        hide_info: 0,
        id: 0,
        isview: 0,
        voice: "",
        autovoice: 0,
        music: "",
        musicAutoPlay: "",
        musicTitle: "",
        musicpay: 0,
        audioplay: 1,
        duration: "",
        curTimeVal: "",
        durationDay: "播放获取",
        curTimeValDay: "00:00",
        st: "",
        sy: "",
        status: 0,
        tabbar_t: 0,
        iszan: 0,
        zans: "",
        zan: 0,
        page_signs: "index",
        baseinfo: "",
        share: 0,
        staffset: "",
        pic: ""
    },
    onLoad: function(t) {
        var a = this;
        a.setData({
            isIphoneX: app.globalData.isIphoneX
        }), wx.setNavigationBarTitle({
            title: "名片"
        }), t.scene ? a.setData({
            id: t.scene
        }) : a.setData({
            id: t.id
        });
        var e = 0;
        t.fxsid && (e = t.fxsid, a.data.fxsid = e), 1 == t.share && a.share111(), app.util.getUserInfo(a.getinfos, e);
        var n = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: n,
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(t) {
                a.setData({
                    basecon: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.data.base_tcolor,
                    backgroundColor: t.data.data.base_color
                });
            },
            fail: function(t) {}
        }), t.shareopenid && t.shareopenid != wx.getStorageSync("openid") ? app.util.request({
            url: "entry/wxapp/sharecardSuccess",
            data: {
                id: a.data.id,
                shareopenid: t.shareopenid,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                a.addvisit();
            }
        }) : a.addvisit();
    },
    addvisit: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/addVisit",
            data: {
                id: a.data.id,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                a.getStaffInfo(), a.getStaffset();
            }
        });
    },
    getStaffInfo: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/getStaffInfo",
            data: {
                id: a.data.id,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                t.data.data.staffinfo ? ("" == t.data.data.userinfo.nickname && a.setData({
                    isview: 1
                }), a.setData({
                    staffinfo: t.data.data.staffinfo,
                    zan: t.data.data.staffinfo.zan,
                    voice: t.data.data.staffinfo.voice
                }), "" != a.data.voice && a.setData({
                    autovoice: t.data.data.staffinfo.autovoice
                }), "" == t.data.data.staffinfo.pic ? a.setData({
                    pic: "/sudu8_page/resource/img/default_pic.png"
                }) : a.setData({
                    pic: t.data.data.staffinfo.pic
                }), 1 == t.data.data.haszan ? a.setData({
                    zans: 1,
                    iszan: 1
                }) : a.setData({
                    zans: "",
                    iszan: 0
                }), "" == t.data.data.staffinfo.descp ? WxParse.wxParse("descp", "html", "暂无个人简介", a, 0) : WxParse.wxParse("descp", "html", t.data.data.staffinfo.descp, a, 0), 
                0 == a.data.autovoice ? a.setData({
                    st: 10,
                    sy: "",
                    status: 0
                }) : (a.setData({
                    st: 2,
                    sy: "music-on",
                    status: 1
                }), a.audioPlay())) : wx.showModal({
                    title: "提示",
                    content: "该员工信息已被删除!",
                    success: function(t) {
                        t.confirm ? wx.navigateBack({
                            delta: 1
                        }) : t.cancel && wx.navigateBack({
                            delta: 1
                        });
                    }
                });
            }
        });
    },
    getStaffset: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/getStaffset",
            success: function(t) {
                a.setData({
                    style: t.data.data.card_style,
                    tabbar_t: t.data.data.tabbar_t,
                    baseinfo: t.data.data.baseInfo,
                    staffset: t.data.data
                });
            }
        });
    },
    onReady: function() {
        this.audioCtx = wx.createAudioContext("myAudio");
    },
    onShow: function() {},
    onHide: function() {
        this.getStaffInfo(), this.getStaffset();
    },
    onUnload: function() {
        this.audioPause(), this.getStaffset();
    },
    onPullDownRefresh: function() {
        this.getStaffInfo(), this.getStaffset(), wx.stopPullDownRefresh();
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var t = wx.getStorageSync("openid");
        return {
            title: "微信小程序名片",
            path: "/sudu8_page/staff_card/staff_card?id=" + this.data.id + "&shareopenid=" + t
        };
    },
    callphone: function(t) {
        var a = t.currentTarget.dataset.text;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    copy: function(t) {
        var a = t.currentTarget.dataset.text;
        wx.setClipboardData({
            data: a,
            success: function(t) {
                wx.getClipboardData({
                    success: function(t) {}
                });
            }
        });
    },
    addPhoneContact: function(t) {
        var e = this, a = t.currentTarget.dataset.text, n = t.currentTarget.dataset.mobile, i = t.currentTarget.dataset.wxnumber;
        null != i && "" != i || (i = n);
        var s = t.currentTarget.dataset.email, o = t.currentTarget.dataset.company, r = wx.getStorageSync("openid"), d = t.currentTarget.dataset.province, c = t.currentTarget.dataset.city, u = t.currentTarget.dataset.address;
        wx.addPhoneContact({
            firstName: a,
            mobilePhoneNumber: n,
            weChatNumber: i,
            email: s,
            organization: o,
            addressState: d,
            addressCity: c,
            addressStreet: u,
            success: function() {
                app.util.request({
                    url: "entry/wxapp/savecard",
                    data: {
                        id: e.data.id,
                        openid: r
                    },
                    success: function(t) {
                        var a = t.data.data;
                        0 == a ? wx.showModal({
                            title: "提示",
                            content: "保存成功, 增加积分与抽奖次数!",
                            confirmText: "去抽奖",
                            success: function(t) {
                                t.confirm ? e.prizes() : t.cancel;
                            }
                        }) : 1 == a ? wx.showModal({
                            title: "提示",
                            content: "保存成功, 但积分增加与抽奖次数都已达到达每日上限!",
                            confirmText: "去抽奖",
                            success: function(t) {
                                t.confirm ? e.prizes() : t.cancel;
                            }
                        }) : 2 == a ? wx.showModal({
                            title: "提示",
                            content: "保存成功, 积分增加已达到每日上限,继续保存可增加抽奖次数!",
                            confirmText: "去抽奖",
                            success: function(t) {
                                t.confirm ? e.prizes() : t.cancel;
                            }
                        }) : 3 == a ? wx.showModal({
                            title: "提示",
                            content: "保存成功, 抽奖次数已达到每日上限,继续保存可增加积分!!",
                            confirmText: "去抽奖",
                            success: function(t) {
                                t.confirm ? e.prizes() : t.cancel;
                            }
                        }) : 10 == a ? wx.showModal({
                            title: "提示",
                            content: "该员工已保存过了!",
                            confirmText: "去抽奖",
                            success: function(t) {
                                t.confirm ? e.prizes() : t.cancel;
                            }
                        }) : 11 == a && wx.showModal({
                            title: "提示",
                            content: "您已成功保存该员工!",
                            confirmText: "去抽奖",
                            success: function(t) {
                                t.confirm ? e.prizes() : t.cancel;
                            }
                        });
                    }
                });
            }
        });
    },
    getinfos: function() {
        var a = this;
        wx.getStorage({
            key: "openid",
            success: function(t) {
                a.setData({
                    openid: t.data
                });
            }
        });
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    huoqusq: function() {
        var c = this, u = wx.getStorageSync("openid");
        c.setData({
            openid: u
        }), wx.getUserInfo({
            success: function(t) {
                var a = t.userInfo, e = a.nickName, n = a.avatarUrl, i = a.gender, s = a.province, o = a.city, r = a.country, d = app.util.url("entry/wxapp/Useupdate", {
                    m: "sudu8_page"
                });
                wx.request({
                    url: d,
                    data: {
                        openid: u,
                        nickname: e,
                        avatarUrl: n,
                        gender: i,
                        province: s,
                        city: o,
                        country: r
                    },
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(t) {
                        wx.setStorageSync("golobeuid", t.data.data.id), wx.setStorageSync("golobeuser", t.data.data), 
                        c.setData({
                            isview: 0
                        });
                    }
                });
            },
            fail: function() {
                c.setData({
                    isview: 1
                });
            }
        });
    },
    playvoice: function(t) {
        var a = this, e = t.currentTarget.dataset.text;
        "" == a.data.voice ? wx.showModal({
            title: "提示",
            content: "该员工还没有语音简介"
        }) : 0 == e ? (a.audioPlay(), a.setData({
            status: 1,
            st: 2,
            sy: "music-on",
            autovoice: 1
        })) : 1 == e && (a.audioPause(), a.setData({
            status: 0,
            st: 10,
            sy: "",
            autovoice: 0
        }));
    },
    prizes: function() {
        app.util.request({
            url: "entry/wxapp/toPrizes",
            success: function(t) {
                var a = t.data.data;
                -1 != a ? wx.navigateTo({
                    url: "/sudu8_page_plugin_shake/index/index?id=" + a
                }) : wx.showModal({
                    title: "提示",
                    content: "当前小程序没有抽奖活动!"
                });
            }
        });
    },
    zan: function(t) {
        var a = this, e = t.currentTarget.dataset.text;
        app.util.request({
            url: "entry/wxapp/staffzan",
            data: {
                id: a.data.id,
                iszan: e,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                1 == t.data.data.result ? (a.setData({
                    iszan: 1,
                    zans: 1,
                    zan: t.data.data.zan
                }), wx.showToast({
                    title: "点赞成功"
                })) : (a.setData({
                    iszan: 0,
                    zans: "",
                    zan: t.data.data.zan
                }), wx.showToast({
                    title: "取消赞成功"
                }));
            }
        });
    },
    share111: function() {
        this.setData({
            share: 1
        });
    },
    share_close: function() {
        this.setData({
            share: 0
        });
    },
    audioPlay: function() {
        var r = this;
        "" == r.data.voice ? wx.showModal({
            title: "提示",
            content: "该员工还没有语音简介"
        }) : (r.setData({
            autovoice: 1,
            st: 2,
            sy: "music-on",
            status: 1
        }), innerAudioContext.src = r.data.voice, innerAudioContext.play(), innerAudioContext.onPlay(function(t) {
            innerAudioContext.onTimeUpdate(function(t) {
                var a = innerAudioContext.duration, e = parseInt(a / 60);
                e < 10 && (e = "0" + e);
                var n = parseInt(a - 60 * e);
                n < 10 && (n = "0" + n);
                var i = innerAudioContext.currentTime, s = parseInt(i / 60);
                s < 10 && (s = "0" + s);
                var o = parseInt(i - 60 * s);
                o < 10 && (o = "0" + o), r.setData({
                    duration: 100 * innerAudioContext.duration.toFixed(2),
                    curTimeVal: 100 * innerAudioContext.currentTime.toFixed(2),
                    durationDay: e + ":" + n,
                    curTimeValDay: s + ":" + o
                });
            }), innerAudioContext.onEnded(function() {
                r.setStopState(r), r.setData({
                    autovoice: 0,
                    st: 10,
                    sy: "",
                    status: 0
                });
            });
        }));
    },
    audioPause: function() {
        this.setData({
            autovoice: 0,
            st: 10,
            sy: "",
            status: 0
        }), innerAudioContext.pause();
    },
    slideBar: function(t) {
        var a = t.detail.value;
        this.setData({
            curTimeVal: a / 100
        }), innerAudioContext.seek(this.data.curTimeVal);
    },
    updateTime: function(r) {
        innerAudioContext.onTimeUpdate(function(t) {
            var a = innerAudioContext.duration, e = parseInt(a / 60);
            e < 10 && (e = "0" + e);
            var n = parseInt(a - 60 * e);
            n < 10 && (n = "0" + n);
            var i = innerAudioContext.currentTime, s = parseInt(i / 60);
            s < 10 && (s = "0" + s);
            var o = parseInt(i - 60 * s);
            o < 10 && (o = "0" + o), r.setData({
                duration: 100 * innerAudioContext.duration.toFixed(2),
                curTimeVal: 100 * innerAudioContext.currentTime.toFixed(2),
                durationDay: e + ":" + n,
                curTimeValDay: s + ":" + o
            });
        }), innerAudioContext.duration.toFixed(2) - innerAudioContext.currentTime.toFixed(2) <= 0 && r.setStopState(r), 
        innerAudioContext.onEnded(function() {
            r.setStopState(r);
        });
    },
    setStopState: function(t) {
        t.setData({
            curTimeVal: 0
        }), innerAudioContext.stop();
    },
    hide_info: function() {
        var t = this.data.hide_info;
        t = 0 == t ? 1 : 0, this.setData({
            hide_info: t
        });
    }
});