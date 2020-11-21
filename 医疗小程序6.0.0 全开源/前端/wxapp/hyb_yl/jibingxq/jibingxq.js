var app = getApp();

Page({
    data: {
        hidden: !0,
        tab: [ "详情", "目录", "评价" ],
        current: 0,
        pinglun: [],
        guanzhu: !0,
        qupinglun: !0,
        plindex: !1,
        userInfo: {},
        labelIndex: null,
        kc_id: "",
        goumai: !1,
        vurl: "",
        toastHidden3: !0,
        toastHidden4: !1,
        autoplay: !1,
        src: "/yiliao/images/budong.mp3",
        poster: "",
        zname: "你根本不懂",
        author: "季彦霖",
        Audiocurrent: "",
        loop: !1,
        gaimusic: !1,
        autoplay1: !1,
        muvd: [],
        action: {
            method: ""
        }
    },
    musictoggle: function(t) {
        var a = this;
        if (console.log(t), 0 == this.data.gaimusic) {
            var e = wx.getBackgroundAudioManager();
            e.src = t.currentTarget.dataset.src, console.log(e.src, t.currentTarget.dataset.src), 
            e.title = t.currentTarget.dataset.title, e.coverImgUrl = t.currentTarget.dataset.pic, 
            e.play(), e.onPlay(function() {
                a.setData({
                    gaimusic: !0
                }), console.log("音乐播放开始");
            }), e.onPause(function() {
                console.log("暂停播放"), a.setData({
                    gaimusic: !1
                });
            }), e.onEnded(function() {
                console.log("音乐播放结束"), a.setData({
                    gaimusic: !1
                });
            });
        } else wx.pauseBackgroundAudio(), this.setData({
            gaimusic: !1
        });
    },
    funplay: function(t) {
        console.log(t);
        var a = wx.getBackgroundAudioManager();
        a.src = t.target.dataset.src, a.play();
    },
    funpause: function() {
        wx.getBackgroundAudioManager().pause();
    },
    audioPlay: function(t) {
        console.log(t), this.setData({
            action: {
                method: "play"
            }
        });
    },
    tab: function(t) {
        var c = this, a = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Videoxianglist",
            data: {
                id: a
            },
            success: function(t) {
                for (var a = t.data.data, e = 0; e < a.length; e++) {
                    var o = a[e].demo, n = parseInt(o / 60), i = parseInt(o % 60);
                    a[e].demo = n + "分" + i + "秒";
                }
                for (var s = c.data.muvd, u = 0; u < a.length; u++) s[u + 1] = a[u];
                c.setData({
                    muvd: s
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), c.setData({
            current: t.currentTarget.dataset.index,
            autoplay: !1
        });
    },
    suibian: function(t) {
        var a = this;
        console.log(t), a.videoCtx = wx.createVideoContext("myVideo1"), a.videoCtx1 = wx.createVideoContext("myVideo"), 
        this.setData({
            hidden: !1
        }), setTimeout(function() {
            a.videoCtx.play(), a.videoCtx1.play();
        }, 500);
    },
    likeClick: function(t) {
        var a = this, e = t.currentTarget.dataset.id;
        console.log(t.currentTarget.dataset.id);
        var o = wx.getStorageSync("openid");
        console.log(o), app.util.request({
            url: "entry/wxapp/CheckCollect",
            headers: {
                "Content-Type": "application/json"
            },
            cachetime: "0",
            data: {
                openid: o,
                goods_id: e
            },
            success: function(t) {
                2 == t.data ? (console.log("已取消"), app.util.request({
                    url: "entry/wxapp/SaveCollect",
                    cachetime: "0",
                    data: {
                        openid: o,
                        goods_id: e,
                        cerated_type: 1
                    },
                    dataType: "json",
                    success: function(t) {
                        wx.showToast({
                            title: "取消成功",
                            icon: "success",
                            duration: 1500
                        }), a.setData({
                            toastHidden4: !0,
                            toastHidden3: !1
                        });
                    }
                })) : 1 == t.data && (console.log("关注成功"), app.util.request({
                    url: "entry/wxapp/SaveCollect",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    cachetime: "0",
                    data: {
                        openid: o,
                        goods_id: e,
                        cerated_type: 1
                    },
                    dataType: "json",
                    success: function(t) {
                        console.log(t), wx.showToast({
                            title: "关注成功",
                            icon: "success",
                            duration: 1500
                        }), a.setData({
                            collect_url: !a.data.collect_url,
                            c_text: !a.data.c_text,
                            toastHidden3: !0,
                            toastHidden4: !1
                        });
                    }
                }));
            }
        });
    },
    muurl: function(t) {
        var a = this, e = this;
        if (0 == e.data.goumai) wx.showToast({
            title: "请购买学习课程",
            image: "../images/err.png"
        }); else {
            e.data.videoxiang;
            var o = t.currentTarget.dataset.pic, n = t.currentTarget.dataset.url, i = t.currentTarget.dataset.data, s = t.currentTarget.dataset.title, u = t.currentTarget.dataset.name, c = t.currentTarget.dataset.off, d = t.currentTarget.dataset.index;
            if (1 == t.currentTarget.dataset.off) {
                var r = wx.getBackgroundAudioManager();
                console.log(t), r.src = i, r.title = s, r.coverImgUrl = o, r.play(), r.onPlay(function() {
                    a.setData({
                        gaimusic: !0
                    });
                }), r.onPause(function() {
                    a.setData({
                        gaimusic: !1
                    });
                }), r.onEnded(function() {
                    a.setData({
                        gaimusic: !1
                    });
                });
            }
            e.setData({
                vurl: n,
                autoplay: !1,
                room_teacher: u,
                sroomtitle: s,
                kaiguan: c,
                Audiocurrent: d,
                mp3: i,
                loop: !0,
                autoplay1: !1,
                poster: o,
                hidden: !0
            });
        }
    },
    xuexi: function() {
        this.setData({
            current: 1
        });
    },
    qupinglun: function(t) {
        var a = this, e = t.currentTarget.dataset.data;
        console.log(t);
        var o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Pingl",
            data: {
                s_id: e,
                openid: o
            },
            success: function(t) {
                if (console.log(t), 0 == t.data.data) return wx.showToast({
                    title: "您还未购买",
                    icon: "success",
                    duration: 800
                }), !1;
                "" !== t.data.data.m_comment ? wx.showToast({
                    title: "您已发表过评论",
                    icon: "success",
                    duration: 1500
                }) : a.setData({
                    qupinglun: !1,
                    plindex: !0
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    mqupinglun: function(t) {
        var a = this, e = t.currentTarget.dataset.data, o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Pingl",
            data: {
                s_id: e,
                openid: o
            },
            success: function(t) {
                if (0 == t.data.data) return wx.showToast({
                    title: "您未学习该课程",
                    icon: "success",
                    duration: 800
                }), !1;
                "" !== t.data.data.m_comment ? wx.showToast({
                    title: "您已发表过评论",
                    icon: "success",
                    duration: 1500
                }) : a.setData({
                    qupinglun: !1,
                    plindex: !0
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    close: function() {
        this.setData({
            plindex: !1
        });
    },
    formSubmit: function(i) {
        var s = this, t = i.detail.value, u = s.data.labelIndex, c = t.s_id;
        console.log(i);
        var d = t.m_comment, a = t.room_money, r = wx.getStorageSync("openid");
        console.log(a, d, c, u), null == u ? wx.showToast({
            title: "请您评个花花吧^^",
            icon: "success",
            duration: 1500
        }) : wx.showModal({
            title: "提示",
            content: " 确认提交么？ ",
            success: function(t) {
                if (t.confirm) {
                    var a = s.data.pinglun, e = new Date(), o = e.getUTCFullYear() + "-" + (e.getMonth() + 1 < 10 ? "0" + (e.getMonth() + 1) : e.getMonth() + 1) + "-" + (e.getDate() < 10 ? "0" + e.getDate() : e.getDate()) + " ", n = {};
                    n.m_img = s.data.userInfo.avatarUrl, n.name = s.data.userInfo.nickName, n.m_fenshu = i.detail.value.m_fenshu, 
                    n.m_comment = i.detail.value.m_comment, n.m_time = o, a.unshift(n), console.log(n.m_img, n.name), 
                    s.setData({
                        pinglun: a,
                        plindex: !1
                    }), app.util.request({
                        url: "entry/wxapp/Roomcoment",
                        data: {
                            name: s.data.userInfo.nickName,
                            m_img: s.data.userInfo.avatarUrl,
                            m_comment: d,
                            s_id: c,
                            m_fenshu: u,
                            s_openid: r
                        },
                        success: function(t) {
                            console.log(t);
                        },
                        fail: function(t) {
                            console.log(t);
                        }
                    });
                }
            }
        });
    },
    radioChange: function(t) {
        console.log(t.detail.value), this.setData({
            labelIndex: t.detail.value
        });
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        });
        var e = wx.getStorageSync("openid"), o = t.sroomtitle;
        wx.setNavigationBarTitle({
            title: o
        }), this.getBase();
        var s = this;
        app.util.request({
            url: "entry/wxapp/Scurl",
            success: function(t) {
                var a = t.data.data;
                s.setData({
                    surl: a
                });
            }
        }), wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(t) {
                        var a = t.userInfo;
                        s.setData({
                            userInfo: a
                        });
                    }
                });
            }
        });
        var n = t.id;
        s.setData({
            id: n
        }), app.util.request({
            url: "entry/wxapp/Videoxiang",
            data: {
                id: n,
                openid: e
            },
            success: function(t) {
                var a = t.data.data, e = a.demo, o = parseInt(e / 60), n = parseInt(e % 60);
                a.demo = o + "分" + n + "秒", "null" == a.demo && (a.demo = "");
                var i = s.data.muvd;
                i.unshift(a), s.setData({
                    muvd: i,
                    videoxiang: t.data.data,
                    kaiguan: t.data.data.kaiguan,
                    mp3: t.data.data.mp3,
                    room_money: t.data.data.room_money,
                    vurl: t.data.data.room_video,
                    sroomtitle: t.data.data.sroomtitle,
                    room_teacher: t.data.data.room_teacher,
                    poster: t.data.data.room_thumb
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/Mianfei",
            data: {
                id: n,
                openid: e
            },
            success: function(t) {
                s.setData({
                    baoming: t.data.data,
                    openid: e,
                    s_id: t.data.data.s_id
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/Allcoment",
            data: {
                id: n
            },
            success: function(t) {
                s.setData({
                    pinglun: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
        e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Kcselect",
            data: {
                s_pid: n,
                s_openid: e
            },
            success: function(t) {
                s.setData({
                    kcselect: t.data.data
                });
                var a = wx.getStorageSync("openid");
                t.data.data.s_openid == a && s.setData({
                    goumai: !0
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/CheckCollect",
            headers: {
                "Content-Type": "application/json"
            },
            data: {
                openid: e,
                goods_id: n
            },
            success: function(t) {
                2 == t.data ? s.setData({
                    toastHidden3: !0,
                    toastHidden4: !1,
                    toastHidden31: !0,
                    toastHidden41: !1
                }) : 1 == t.data && s.setData({
                    toastHidden3: !1,
                    toastHidden4: !0,
                    toastHidden31: !1,
                    toastHidden41: !0
                });
            }
        });
    },
    onReady: function() {
        this.getMygou();
    },
    onShow: function() {},
    onHide: function(t) {},
    onUnload: function() {
        wx.pauseBackgroundAudio();
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    zhifu: function(t) {
        var a = this, e = a.data.room_money, o = a.data.id, n = t.currentTarget.dataset.name, i = wx.getStorageSync("openid");
        e <= 0 ? (console.log("免费"), app.util.request({
            url: "entry/wxapp/Kcinsert",
            data: {
                s_ormoney: e,
                s_pid: o,
                s_openid: i,
                m_type: 1,
                s_type: 0,
                m_tj: 0
            },
            success: function(t) {
                console.log(t), a.setData({
                    openid: i
                });
            }
        }), a.setData({
            current: 1
        })) : (console.log("付费"), wx.showModal({
            title: "是否支付",
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/Orderpay",
                    method: "GET",
                    data: {
                        s_openid: i,
                        s_ormoney: e
                    },
                    success: function(t) {
                        wx.requestPayment({
                            timeStamp: t.data.timeStamp,
                            nonceStr: t.data.nonceStr,
                            package: t.data.package,
                            signType: t.data.signType,
                            paySign: t.data.paySign,
                            success: function(t) {
                                app.util.request({
                                    url: "entry/wxapp/Joninmoney",
                                    data: {
                                        use_openid: i,
                                        leixing: "课堂",
                                        name: n,
                                        pay: e
                                    },
                                    header: {
                                        "content-type": "application/json"
                                    },
                                    success: function(t) {
                                        console.log(t);
                                    },
                                    fail: function(t) {
                                        console.log(t);
                                    }
                                }), app.util.request({
                                    url: "entry/wxapp/Kcinsert",
                                    data: {
                                        s_ormoney: e,
                                        s_pid: o,
                                        s_openid: i,
                                        m_type: 1,
                                        s_type: 1,
                                        m_tj: 0
                                    },
                                    success: function(t) {
                                        console.log(t), a.setData({
                                            goumai: !0,
                                            s_id: t.data.data
                                        });
                                    }
                                });
                            },
                            fail: function(t) {
                                console.log(t);
                            }
                        });
                    }
                });
            },
            fail: function(t) {
                a.setData({
                    goumai: !1
                });
            }
        }));
    },
    getBase: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                a.setData({
                    bq_thumb: t.data.data.bq_thumb,
                    bq_name: t.data.data.bq_name
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    getMygou: function() {
        var a = this, t = a.data.id, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Mygou",
            data: {
                id: t,
                openid: e
            },
            success: function(t) {
                a.setData({
                    s_id: t.data.data.s_id
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    }
});