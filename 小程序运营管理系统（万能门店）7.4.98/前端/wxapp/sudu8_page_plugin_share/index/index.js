var wxParse = require("../../sudu8_page/resource/wxParse/wxParse.js"), app = getApp();

Page({
    data: {
        touxiang1: "",
        touxiang2: "",
        touxiang3: "",
        touxiang4: "",
        cha_num: "",
        jine_num: 50,
        role: 0,
        tan: 0,
        storage: 0,
        dtime: 0,
        really: 0,
        name: "",
        tel: "",
        bg: "../images/bg1.jpg",
        click_cy: 0,
        sid: 0,
        shid: 0,
        sytime: 0,
        itime: 0,
        request_num: 0,
        aid: 0
    },
    onPullDownRefresh: function() {
        this.getinfos(), wx.stopPullDownRefresh();
    },
    onReady: function() {
        wx.setNavigationBarTitle({
            title: "拆红包赢大奖"
        }), wx.setNavigationBarColor({
            frontColor: "#000000",
            backgroundColor: "#fff"
        });
    },
    onLoad: function(a) {
        var t = this, e = a.aid, n = a.uid, i = a.hid;
        t.data.aid = e;
        var s = 0;
        a.fxsid && (s = a.fxsid, t.setData({
            fxsid: a.fxsid
        })), t.setData({
            aid: e,
            sid: n,
            shid: i,
            request_num: this.data.request_num
        }), null == e ? wx.showModal({
            content: "该活动已不存在",
            showCancel: !1
        }) : setTimeout(function() {
            t.active_is(e, n, i);
        }, 200), wx.showShareMenu({
            withShareTicket: !0
        }), app.util.getUserInfo(t.getinfos, s);
    },
    getinfos: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                t.setData({
                    openid: a.data
                });
            }
        });
    },
    checkauth: function() {
        var e = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                var t = a;
                app.util.request({
                    url: "entry/wxapp/checkauth",
                    cachetime: 0,
                    data: {
                        openid: t,
                        aid: e.data.aid
                    },
                    success: function(a) {
                        0 == a.data && wx.showModal({
                            title: "提示",
                            content: "不能参加",
                            complete: function() {
                                wx.reLaunch({
                                    url: "/sudu8_page/index/index"
                                });
                            }
                        });
                    },
                    fail: function() {
                        wx.showModal({
                            title: "提示",
                            content: "网络请求错误"
                        });
                    }
                });
            }
        });
    },
    active_is: function(t, e, n) {
        var i = this;
        app.util.request({
            url: "entry/wxapp/active_is",
            cachetime: 0,
            data: {
                aid: t
            },
            success: function(a) {
                2 == a.data.data.active_is ? (wx.showModal({
                    content: "该活动已不存在",
                    showCancel: !1
                }), i.setData({
                    active_is: a.data.data.active_is,
                    tan: 0
                })) : 3 == a.data.data.active_is ? (wx.showModal({
                    content: "该活动已过期",
                    showCancel: !1
                }), i.setData({
                    active_is: a.data.data.active_is,
                    tan: 0
                })) : 4 == a.data.data.active_is ? (wx.showModal({
                    content: "该活动未开始",
                    showCancel: !1
                }), i.setData({
                    active_is: a.data.data.active_is,
                    tan: 0
                })) : (i.userinfo(t, e, n), i.setData({
                    active_is: a.data.data.active_is
                }));
            },
            fail: function(a) {}
        });
    },
    makenewbao: function() {
        var a = this.data.aid;
        wx.reLaunch({
            url: "/sudu8_page_plugin_share/index/index?aid=" + a
        });
    },
    makenewbaos: function(a) {
        this.checkauth();
        var t = a.target.dataset.num, e = this, n = wx.getStorageSync("openid");
        if (t != this.data.request_num) return !1;
        app.util.request({
            url: "entry/wxapp/makenewbao",
            cachetime: 0,
            data: {
                openid: n,
                aid: e.data.aid
            },
            success: function(a) {
                1 == a.data.data.rindex ? setTimeout(function() {
                    wx.reLaunch({
                        url: "/sudu8_page_plugin_share/index/index?aid=" + a.data.data.aid,
                        success: function() {
                            e.setData({
                                request_num: e.data.request_num + 1
                            }), e.data.request_num = e.data.request_num + 1;
                        }
                    });
                }, 2e3) : 5 == a.data.data.chao ? wx.showModal({
                    content: "总分享数量已经超过最大数量了",
                    showCancel: !1
                }) : 6 == a.data.data.chao ? wx.showModal({
                    content: "总分享金额已经超过最大金额了",
                    showCancel: !1
                }) : 7 == a.data.data.chao ? wx.showModal({
                    content: "当日分享数量已经超过最大数量了",
                    showCancel: !1
                }) : 8 == a.data.data.chao ? wx.showModal({
                    content: "当日分享金额已经超过最大金额了",
                    showCancel: !1
                }) : 3 == a.data.data.flag ? e.setData({
                    active_is: 3
                }) : setTimeout(function() {
                    wx.reLaunch({
                        url: "/sudu8_page_plugin_share/index/index?aid=" + a.data.data.aid,
                        success: function() {
                            e.setData({
                                request_num: e.data.request_num + 1
                            }), e.data.request_num = e.data.request_num + 1;
                        }
                    });
                }, 2e3);
            },
            fail: function(a) {
                e.data.request_num = e.data.request_num + 1;
            }
        });
    },
    userNameInput: function(a) {
        this.setData({
            name: a.detail.value
        });
    },
    userTelInput: function(a) {
        this.setData({
            tel: a.detail.value
        });
    },
    click_cy: function() {
        var n = this, a = n.data.aid, t = n.data.sid, e = n.data.shid, i = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/click_cy",
            cachetime: 0,
            data: {
                openid: i,
                id: t,
                hid: e,
                aid: a
            },
            success: function(a) {
                if (1 == a.data.data.chao) wx.showModal({
                    content: "总参与数量已经超过最大数量了",
                    showCancel: !1
                }); else if (2 == a.data.data.chao) wx.showModal({
                    content: "总参与金额已经超过最大金额了",
                    showCancel: !1
                }); else if (3 == a.data.data.chao) wx.showModal({
                    content: "当日参与数量已经超过最大数量了",
                    showCancel: !1
                }); else if (4 == a.data.data.chao) wx.showModal({
                    content: "当日参与金额已经超过最大金额了",
                    showCancel: !1
                }); else if (5 == a.data.data.chao) wx.showModal({
                    content: "总分享数量已经超过最大数量了",
                    showCancel: !1
                }); else if (6 == a.data.data.chao) wx.showModal({
                    content: "总参与金额已经超过最大金额了",
                    showCancel: !1
                }); else if (7 == a.data.data.chao) wx.showModal({
                    content: "当日分享数量已经超过最大数量了",
                    showCancel: !1
                }); else if (8 == a.data.data.chao) wx.showModal({
                    content: "当日分享金额已经超过最大金额了",
                    showCancel: !1
                }); else if (3 == a.data.data.flag) n.setData({
                    active_is: 3
                }); else if (2 == a.data.data.shibai) if (2 == a.data.data.jindu) n.setData({
                    jindu: 2,
                    click_cy: 0,
                    touxiang1: a.data.data.avatar,
                    arr: a.data.data.cy,
                    tsuccessed: 1,
                    successed: 0,
                    score: a.data.data.score,
                    getscore: a.data.data.getscore,
                    nickname: a.data.data.nickname,
                    h: 0,
                    bignum: a.data.data.bignum
                }); else {
                    var t = a.data.data.cha_num, e = 1e3 * a.data.data.dtime;
                    n.setData({
                        success_cy: 2,
                        jindu: 1,
                        click_cy: 0,
                        cha_num: t,
                        sytime: e,
                        hb: 0
                    });
                } else n.setData({
                    success_cy: 1
                });
            },
            fail: function(a) {}
        });
    },
    userinfo: function(a, t, e) {
        var u = this, n = wx.getStorageSync("openid");
        0 < t && 0 < e ? app.util.request({
            url: "entry/wxapp/Userinfo",
            cachetime: 0,
            data: {
                openid: n,
                aid: a,
                id: t,
                hid: e
            },
            success: function(a) {
                if (2 == a.data.data.geren) if (1 == a.data.data.status) u.setData({
                    tan: 0,
                    hb: 0,
                    really: 0,
                    touxiang1: a.data.data.avatar,
                    arr: a.data.data.cy,
                    tsuccessed: 1,
                    successed: 0,
                    score: a.data.data.score,
                    getscore: a.data.data.getscore,
                    nickname: a.data.data.nickname,
                    h: 0,
                    bignum: a.data.data.bignum
                }); else if (0 == a.data.data.status) {
                    var t = a.data.data.cha_num, e = a.data.data.dtime, n = u.dateformat(e), i = a.data.data.id, s = a.data.data.hid;
                    0 < e ? 1 == a.data.data.ncy ? (u.setData({
                        really: 0,
                        tan: 0,
                        cha_num: t,
                        cyed: 1,
                        sytime: e,
                        stime: n,
                        jine: a.data.data.jine
                    }), setInterval(function() {
                        if (0 <= e) {
                            var a = u.dateformat(e);
                            u.setData({
                                stime: a
                            }), e--;
                        } else u.setData({
                            shibaila: 1,
                            really: 0,
                            tan: 0,
                            click_cy: 0,
                            cyed: 0,
                            hb: 0,
                            zibao: 1
                        });
                    }, 1e3)) : (u.setData({
                        really: 0,
                        tan: 0,
                        cha_num: t,
                        click_cy: 1,
                        sytime: e,
                        stime: n,
                        jine: a.data.data.jine
                    }), setInterval(function() {
                        if (0 <= e) {
                            var a = u.dateformat(e);
                            u.setData({
                                stime: a
                            }), e--;
                        } else u.setData({
                            shibaila: 1,
                            really: 0,
                            tan: 0,
                            click_cy: 0,
                            cyed: 0,
                            hb: 0,
                            zibao: 1
                        });
                    }, 1e3)) : u.setData({
                        chaotime: 1
                    });
                } else 2 == a.data.data.status ? u.setData({
                    shibaila: 1,
                    zibao: 1,
                    really: 0,
                    tan: 0,
                    hb: 0,
                    tsuccessed: 0,
                    h: 0
                }) : 3 == a.data.data.status && u.setData({
                    shibaila: 2,
                    zibao: 1,
                    really: 0,
                    tan: 0,
                    hb: 0,
                    tsuccessed: 0,
                    h: 0
                }); else if ("" != a.data.data.realname) if (1 == a.data.data.status) u.setData({
                    tan: 0,
                    hb: 0,
                    really: 0,
                    touxiang1: a.data.data.avatar,
                    arr: a.data.data.cy,
                    successed: 1,
                    tsuccessed: 1,
                    score: a.data.data.score,
                    nickname: a.data.data.nickname,
                    h: 0,
                    bignum: a.data.data.bignum,
                    getscore: a.data.data.score
                }); else if (0 == a.data.data.status) {
                    t = a.data.data.cha_num, e = a.data.data.dtime, n = u.dateformat(e), i = a.data.data.id, 
                    s = a.data.data.hid;
                    var d = a.data.data.cy;
                    if (0 < d.length) for (var c = [], o = 0; o < d.length; o++) c[o] = d[o].avatar;
                    0 < e ? (u.setData({
                        uid: i,
                        really: 0,
                        tan: 1,
                        cha_num: t,
                        hb: 1,
                        sytime: e,
                        stime: n,
                        touxiang1: a.data.data.avatar,
                        hid: s,
                        jine: a.data.data.jine,
                        arr: c
                    }), setInterval(function() {
                        if (0 <= e) {
                            var a = u.dateformat(e);
                            u.setData({
                                stime: a
                            }), e--;
                        } else u.setData({
                            shibaila: 1,
                            really: 0,
                            tan: 0,
                            click_cy: 0,
                            cyed: 0,
                            hb: 0,
                            sxb: 1
                        });
                    }, 1e3)) : u.setData({
                        chaotime: 1
                    });
                } else 2 == a.data.data.status && u.setData({
                    shibaila: 1,
                    sxb: 1,
                    really: 0,
                    tan: 0,
                    hb: 0,
                    tsuccessed: 0,
                    h: 0
                });
            },
            fail: function(a) {}
        }) : app.util.request({
            url: "entry/wxapp/Userinfo",
            cachetime: 0,
            data: {
                openid: n,
                aid: a
            },
            success: function(a) {
                if (1 == a.data.data.really) u.setData({
                    really: 1
                }); else if ("" != a.data.data.realname) if (1 == a.data.data.status) u.setData({
                    tan: 0,
                    hb: 0,
                    really: 0,
                    touxiang1: a.data.data.avatar,
                    arr: a.data.data.cy,
                    successed: 1,
                    tsuccessed: 1,
                    score: a.data.data.score,
                    getscore: a.data.data.score,
                    nickname: a.data.data.nickname,
                    h: 0,
                    bignum: a.data.data.bignum
                }); else if (0 == a.data.data.status) {
                    var t = a.data.data.cha_num, e = a.data.data.dtime, n = a.data.data.id, i = a.data.data.hid, s = a.data.data.cy;
                    if (0 < s.length) for (var d = [], c = 0; c < s.length; c++) d[c] = s.avatar;
                    0 < e ? (u.setData({
                        jine: a.data.data.jine,
                        initiator: a.data.data.initiator
                    }), setTimeout(function() {
                        u.setData({
                            uid: n,
                            really: 0,
                            tan: 1,
                            cha_num: t,
                            hb: 1,
                            sytime: e,
                            touxiang1: a.data.data.avatar,
                            hid: i,
                            arr: d
                        });
                    }, 1e3), setInterval(function() {
                        if (0 <= e) {
                            var a = u.dateformat(e);
                            u.setData({
                                stime: a
                            }), e--;
                        } else u.setData({
                            shibaila: 1,
                            really: 0,
                            tan: 0,
                            click_cy: 0,
                            cyed: 0,
                            hb: 0,
                            sxb: 1,
                            h: 0
                        });
                    }, 1e3)) : u.setData({
                        chaotime: 1
                    });
                } else if (2 == a.data.data.status) u.setData({
                    shibaila: 1,
                    sxb: 1,
                    really: 0,
                    tan: 0,
                    hb: 0,
                    tsuccessed: 0,
                    h: 0
                }); else if (4 == a.data.data.status) {
                    0 < (e = a.data.data.sytime) && (u.setData({
                        uid: a.data.data.uid,
                        cha_num: a.data.data.cha_num,
                        really: 0,
                        tan: 1,
                        hb: 1,
                        touxiang1: a.data.data.avatar,
                        sytime: e,
                        hid: a.data.data.hid,
                        jine: a.data.data.jine
                    }), setInterval(function() {
                        if (0 <= e) {
                            var a = u.dateformat(e);
                            u.setData({
                                stime: a
                            }), e--;
                        } else u.setData({
                            shibaila: 1,
                            really: 0,
                            tan: 0,
                            click_cy: 0,
                            cyed: 0,
                            hb: 0,
                            sxb: 1
                        });
                    }, 1e3));
                }
            },
            fail: function(a) {}
        });
    },
    really_sub: function() {
        var e = this, a = e.data.name, t = e.data.tel, n = e.data.aid;
        if ("" == a) return wx.showModal({
            content: "姓名不能为空",
            showCancel: !1
        }), !1;
        if ("" == t || t.length < 11) return wx.showModal({
            content: "请输入正确手机号",
            showCancel: !1
        }), !1;
        var i = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/really_save",
            data: {
                openid: i,
                name: a,
                tel: t,
                aid: n
            },
            cache: 0,
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                if (1 == a.data.flag) {
                    if ("" != a.data.avatar) {
                        var t = a.data.sytime;
                        0 < t && (e.setData({
                            uid: a.data.uid,
                            cha_num: a.data.cha_num,
                            really: 0,
                            tan: 1,
                            hb: 1,
                            touxiang1: a.data.avatar,
                            hid: a.data.hid,
                            jine: a.data.jine,
                            initiator: a.data.initiator
                        }), setInterval(function() {
                            if (0 <= t) {
                                var a = e.dateformat(t);
                                e.setData({
                                    sytime: a
                                }), t--;
                            } else e.setData({
                                shibaila: 1,
                                really: 0,
                                tan: 0,
                                click_cy: 0,
                                cyed: 0,
                                hb: 0,
                                sxb: 1
                            });
                        }, 1e3));
                    }
                } else wx.showModal({
                    content: "该活动已不存在",
                    showCancel: !1
                });
            }
        });
    },
    onShareAppMessage: function() {
        return {
            title: "拆红包领取现金红包~",
            path: "/sudu8_page_plugin_share/index/index?aid=" + this.data.aid + "&uid=" + this.data.uid + "&hid=" + this.data.hid,
            success: function(a) {
                a.shareTickets[0] && wx.getShareInfo({
                    shareTicket: a.shareTickets[0],
                    success: function(a) {},
                    fail: function(a) {},
                    complete: function(a) {}
                });
            },
            fail: function(a) {}
        };
    },
    dateformat: function(a) {
        var t = Math.floor(a);
        if (86400 == t) var e = 24, n = 0; else if (86400 < t) n = parseInt(t / 86400); else n = 0;
        e = Math.floor(t / 3600 % 24);
        return (e += 24 * n) + "小时" + Math.floor(t / 60 % 60) + "分钟" + Math.floor(t % 60) + "秒";
    },
    role_block: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/getrule",
            cachetime: 0,
            success: function(a) {
                t.setData({
                    role: 1,
                    article: wxParse.wxParse("article", "html", a.data.data.rules, t, 0)
                });
            },
            fail: function(a) {}
        });
    },
    role_close: function() {
        this.setData({
            role: 0
        });
    },
    tan_close: function() {
        this.setData({
            tan: 0
        });
    },
    getsetinfo: function() {
        var u = this;
        wx.getSetting({
            success: function(a) {
                a.authSetting["scope.userInfo"] ? wx.getUserInfo({
                    success: function(a) {
                        var t = a.userInfo, e = t.nickName, n = t.avatarUrl, i = t.gender, s = t.province, d = t.city, c = t.country, o = wx.getStorageSync("openid");
                        app.util.request({
                            url: "entry/wxapp/Useupdate",
                            data: {
                                openid: o,
                                nickname: e,
                                avatarUrl: n,
                                gender: i,
                                province: s,
                                city: d,
                                country: c
                            },
                            header: {
                                "content-type": "application/json"
                            },
                            success: function(a) {}
                        }), u.setData({
                            userInfo: a.userInfo
                        });
                    }
                }) : wx.showModal({
                    title: "提示",
                    content: "必须授权登录后才能操作,是否重新授权登录？",
                    success: function(a) {
                        a.confirm ? wx.openSetting({
                            success: function(a) {
                                a.authSetting["scope.userInfo"] ? wx.getUserInfo({
                                    success: function(a) {
                                        u.setData({
                                            userInfo: a.userInfo
                                        });
                                        var t = a.userInfo, e = t.nickName, n = t.avatarUrl, i = t.gender, s = t.province, d = t.city, c = t.country, o = wx.getStorageSync("openid");
                                        app.util.request({
                                            url: "entry/wxapp/Useupdate",
                                            data: {
                                                openid: o,
                                                nickname: e,
                                                avatarUrl: n,
                                                gender: i,
                                                province: s,
                                                city: d,
                                                country: c
                                            },
                                            header: {
                                                "content-type": "application/json"
                                            },
                                            success: function(a) {}
                                        });
                                    }
                                }) : wx.reLaunch({
                                    url: "/sudu8_page/index/index"
                                });
                            }
                        }) : a.cancel && wx.reLaunch({
                            url: "/sudu8_page/index/index"
                        });
                    }
                });
            }
        });
    },
    getinfo: function() {
        var i = this, a = i.data.aid;
        app.util.request({
            url: "entry/wxapp/Types",
            header: {
                "content-type": "application/json"
            },
            data: {
                aid: a
            },
            cache: 0,
            success: function(a) {
                var t = a.data.data.types;
                1 == t ? t = "积分" : 2 == t && (t = "元"), i.setData({
                    types: t
                });
            }
        }), wx.getUserInfo({
            success: function(a) {
                var t = a.userInfo, e = t.nickName, n = t.avatarUrl;
                t.gender, t.province, t.city, t.country;
                i.setData({
                    userInfoimg: n,
                    userInfonickname: e
                });
            }
        });
    },
    gethongbao: function() {
        var a = this.data.aid;
        wx.reLaunch({
            url: "/sudu8_page_plugin_share/index/index?aid=" + a
        });
    }
});