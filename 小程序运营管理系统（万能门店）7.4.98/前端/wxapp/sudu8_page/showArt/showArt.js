var WxParse = require("../../sudu8_page/resource/wxParse/wxParse.js"), app = getApp(), BackgroundAudioManager = wx.getBackgroundAudioManager();

BackgroundAudioManager.title = "";

var innerAudioContext = wx.createInnerAudioContext();

Page({
    data: {
        id: "",
        datas: "",
        pagedata: {},
        imgcount_xz: 0,
        pagedata_set: [],
        zh_all: 0,
        zh_now: 0,
        zhixin: !1,
        is_comment: 0,
        comm: 0,
        commSelf: 0,
        comments: [],
        commShow: 0,
        shareShow: 0,
        shareScore: 0,
        videopay: 0,
        autoplay: !1,
        poster: "",
        navtel: "",
        xuanz: 0,
        lixuanz: -1,
        ttcxs: 0,
        share: 0,
        shareHome: 0,
        fxsid: 0,
        showLike: 0,
        art_price: "",
        music_price: "",
        loopPlay: "",
        music: "",
        musicAutoPlay: "",
        musicTitle: "",
        musicpay: 0,
        artpay: 1,
        audioplay: 1,
        duration: "",
        curTimeVal: "",
        durationDay: "播放获取",
        curTimeValDay: "00:00",
        musictype: "",
        iospay: 0
    },
    onReady: function() {
        this.refreshSessionkey(), this.audioCtx = wx.createAudioContext("myAudio");
    },
    audioPlay: function() {
        var d = this, a = d.data.musictype;
        d.setData({
            audioplay: 2
        }), 1 == a && (innerAudioContext.play(), innerAudioContext.onPlay(function(a) {
            innerAudioContext.onTimeUpdate(function(a) {
                var t = innerAudioContext.duration, e = parseInt(t / 60);
                e < 10 && (e = "0" + e);
                var i = parseInt(t - 60 * e);
                i < 10 && (i = "0" + i);
                var n = innerAudioContext.currentTime, o = parseInt(n / 60);
                o < 10 && (o = "0" + o);
                var s = parseInt(n - 60 * o);
                s < 10 && (s = "0" + s), d.setData({
                    duration: 100 * innerAudioContext.duration.toFixed(2),
                    curTimeVal: 100 * innerAudioContext.currentTime.toFixed(2),
                    durationDay: e + ":" + i,
                    curTimeValDay: o + ":" + s
                });
            }), innerAudioContext.onEnded(function() {
                d.setStopState(d);
            });
        })), 2 == a && ("" != d.data.music && (BackgroundAudioManager.src = d.data.music), 
        BackgroundAudioManager.play());
    },
    audioPause: function() {
        var a = this.data.musictype;
        this.setData({
            audioplay: 1
        }), 1 == a && innerAudioContext.pause(), 2 == a && BackgroundAudioManager.pause();
    },
    slideBar: function(a) {
        var t = a.detail.value;
        this.setData({
            curTimeVal: t / 100
        }), innerAudioContext.seek(this.data.curTimeVal);
    },
    updateTime: function(d) {
        innerAudioContext.onTimeUpdate(function(a) {
            var t = innerAudioContext.duration, e = parseInt(t / 60);
            e < 10 && (e = "0" + e);
            var i = parseInt(t - 60 * e);
            i < 10 && (i = "0" + i);
            var n = innerAudioContext.currentTime, o = parseInt(n / 60);
            o < 10 && (o = "0" + o);
            var s = parseInt(n - 60 * o);
            s < 10 && (s = "0" + s), d.setData({
                duration: 100 * innerAudioContext.duration.toFixed(2),
                curTimeVal: 100 * innerAudioContext.currentTime.toFixed(2),
                durationDay: e + ":" + i,
                curTimeValDay: o + ":" + s
            });
        }), innerAudioContext.duration.toFixed(2) - innerAudioContext.currentTime.toFixed(2) <= 0 && d.setStopState(d), 
        innerAudioContext.onEnded(function() {
            d.setStopState(d);
        });
    },
    setStopState: function(a) {
        var t = this.data.musictype;
        a.setData({
            curTimeVal: 0
        }), 1 == t && innerAudioContext.stop(), 2 == t && BackgroundAudioManager.stop();
    },
    onPullDownRefresh: function() {
        var a = this;
        a.refreshSessionkey();
        var t = a.data.id;
        a.getPoductDetail(t), a.setData({
            zhixin: !1
        }), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this;
        t.setData({
            isIphoneX: app.globalData.isIphoneX,
            isios: app.globalData.isios
        });
        var e = a.id;
        t.refreshSessionkey(), t.setData({
            id: e,
            page_signs: "/sudu8_page/showArt/showArt?id=" + e
        }), wx.showShareMenu({
            withShareTicket: !0
        });
        var i = 0;
        a.fxsid && (i = a.fxsid, t.setData({
            fxsid: a.fxsid,
            shareHome: 1
        })), a.userid && t.setData({
            userid: a.userid
        }), app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                a.data.data;
                t.setData({
                    baseinfo: a.data.data,
                    comm: a.data.data.commA,
                    comms: a.data.data.commAs,
                    ios: a.data.data.ios
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(t.getinfos, i);
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getinfos: function() {
        var e = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                e.setData({
                    openid: a.data
                });
                var t = e.data.id;
                e.getPoductDetail(t), e.givepscore();
            }
        });
    },
    huoqusq: function(a) {
        var t = this, e = wx.getStorageSync("openid");
        if (a.detail.userInfo) {
            var i = a.detail.userInfo, n = i.nickName, o = i.avatarUrl, s = i.gender, d = i.province, r = i.city, u = i.country;
            app.util.request({
                url: "entry/wxapp/Useupdate",
                data: {
                    openid: e,
                    nickname: n,
                    avatarUrl: o,
                    gender: s,
                    province: d,
                    city: r,
                    country: u
                },
                header: {
                    "content-type": "application/json"
                },
                success: function(a) {
                    wx.setStorageSync("golobeuid", a.data.data.id), wx.setStorageSync("golobeuser", a.data.data), 
                    t.setData({
                        isview: 0,
                        globaluser: a.data.data
                    }), t.getPoductDetail(t.data.id);
                }
            });
        } else wx.showModal({
            title: "获取失败",
            content: "请您允许授权",
            showCancel: !1,
            success: function(a) {
                a.confirm && wx.getSetting({
                    success: function(a) {
                        a.authSetting["scope.userInfo"] || wx.openSetting({
                            success: function(a) {
                                wx.reLaunch({
                                    url: "/sudu8_page/usercenter/usercenter"
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    follow: function(a) {
        var t = this, e = a.currentTarget.dataset.id, i = a.currentTarget.dataset.zan;
        app.util.request({
            url: "entry/wxapp/commentFollow",
            cachetime: "0",
            data: {
                id: e,
                zan: i,
                openid: wx.getStorageSync("openid")
            },
            success: function(a) {
                1 == a.data.data.result ? (wx.showToast({
                    title: "点赞成功",
                    icon: "success",
                    duration: 1e3
                }), t.getPoductDetail(t.data.id)) : 2 == a.data.data.result && (wx.showToast({
                    title: "取消赞成功",
                    icon: "success",
                    duration: 1e3
                }), t.getPoductDetail(t.data.id));
            }
        });
    },
    pinglun: function(a) {
        this.setData({
            pinglun_t: a.detail.value
        });
    },
    pinglun_sub: function() {
        var a = this.data.pinglun_t, t = this.data.id, e = wx.getStorageSync("openid");
        if ("" == a || null == a) return wx.showModal({
            content: "评论不能为空"
        }), !1;
        app.util.request({
            url: "entry/wxapp/comment",
            cachetime: "30",
            data: {
                pinglun_t: a,
                id: t,
                openid: e
            },
            success: function(a) {
                1 == a.data.data.result && (wx.showToast({
                    title: "评价提交成功",
                    icon: "success",
                    duration: 2e3
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/sudu8_page/showArt/showArt?id=" + t
                    });
                }, 2e3));
            }
        });
    },
    getPoductDetail: function(t) {
        var x = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/globaluserinfo",
            data: {
                openid: a
            },
            success: function(a) {
                var t = a.data.data;
                t.nickname && t.avatar || x.setData({
                    isview: 1
                }), x.setData({
                    globaluser: a.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/productsDetail",
            data: {
                id: t,
                openid: a
            },
            cachetime: "0",
            success: function(a) {
                if (0 == a.data.data.get_con) return wx.showModal({
                    title: "提示",
                    content: "文章已不存在",
                    showCancel: !1,
                    success: function() {
                        wx.navigateBack({
                            deltail: 1
                        });
                    }
                }), !1;
                if (null != a.data.data.share_score && "null" != a.data.data.share_score) {
                    if (-1 != a.data.data.share_score.indexOf("http")) {
                        var t = encodeURIComponent(a.data.data.share_score);
                        wx.redirectTo({
                            url: "/sudu8_page/webpage/webpage?url=" + t
                        });
                    }
                    -1 != a.data.data.share_score.indexOf("sudu8_page") && wx.redirectTo({
                        url: a.data.data.share_score
                    });
                }
                var e = a.data.data.ctime;
                if ("" == a.data.data.labels) var i = a.data.data.thumb; else i = a.data.data.labels;
                if ("false" == a.data.data.market_price) var n = !1; else n = !0;
                if (0 < parseInt(a.data.data.pro_flag)) {
                    if (a.data.data.navlistnum) {
                        var o = (100 / a.data.data.navlistnum).toFixed(2);
                        x.setData({
                            pro_flag: a.data.data.pro_flag,
                            navlist: a.data.data.navlist,
                            navwidth: o + "%",
                            likeArtList: a.data.data.likeArtList
                        });
                    }
                } else x.setData({
                    pro_flag: a.data.data.pro_flag
                });
                var s = a.data.data.likeArtList;
                s && 0 < s.length && x.setData({
                    showLike: 1
                });
                var d = a.data.data.music_art_info.music, r = a.data.data.musicpay, u = a.data.data.music_art_info.autoPlay, c = a.data.data.music_art_info.loopPlay, l = 1;
                a.data.data.music_art_info.musictype && (l = a.data.data.music_art_info.musictype);
                var p = a.data.data.videopay, g = a.data.data.artpay, h = x.data.isios, f = x.data.ios;
                h && 0 == f && (g = p = r = 1), 2 == l ? 1 == r && 1 == u && ("" != d && (BackgroundAudioManager.src = d), 
                BackgroundAudioManager.play(), Math.ceil(BackgroundAudioManager.duration) - Math.ceil(BackgroundAudioManager.currentTime) <= 0 && (c ? BackgroundAudioManager.onEnded(function() {
                    x.audioPlay();
                }) : (BackgroundAudioManager.onEnded(function() {
                    x.setStopState(x);
                }), x.setData({
                    audioplay: 2
                })))) : (innerAudioContext.src = d, 1 == r && 1 == u && (x.setData({
                    audioplay: 2
                }), innerAudioContext.autoplay = !0, innerAudioContext.onPlay(function() {
                    innerAudioContext.onTimeUpdate(function(a) {
                        var t = innerAudioContext.duration, e = parseInt(t / 60);
                        e < 10 && (e = "0" + e);
                        var i = parseInt(t - 60 * e);
                        i < 10 && (i = "0" + i);
                        var n = innerAudioContext.currentTime, o = parseInt(n / 60);
                        o < 10 && (o = "0" + o);
                        var s = parseInt(n - 60 * o);
                        s < 10 && (s = "0" + s), x.setData({
                            duration: 100 * innerAudioContext.duration.toFixed(2),
                            curTimeVal: 100 * innerAudioContext.currentTime.toFixed(2),
                            durationDay: e + ":" + i,
                            curTimeValDay: o + ":" + s
                        });
                    }), innerAudioContext.onEnded(function() {
                        x.setStopState(x);
                    });
                })), 1 == c && (innerAudioContext.loop = !0)), x.setData({
                    id: a.data.data.id,
                    title: a.data.data.title,
                    time: e,
                    v: a.data.data.video,
                    videopay: p,
                    autoplay: n,
                    poster: i,
                    price: a.data.data.price,
                    block: a.data.data.btn.pic_page_btn,
                    pmarb: a.data.data.pmarb,
                    ptit: a.data.data.ptit,
                    datas: a.data.data,
                    formdescs: a.data.data.formdescs,
                    pagedata: a.data.data.forms,
                    commSelf: a.data.data.comment,
                    art_price: a.data.data.music_art_info.art_price,
                    music_price: a.data.data.music_art_info.music_price,
                    loopPlay: c,
                    music: d,
                    musicTitle: a.data.data.music_art_info.musicTitle,
                    musicpay: r,
                    artpay: g,
                    musictype: l,
                    descs: a.data.data.desc
                }), a.data.data.text && WxParse.wxParse("content", "html", a.data.data.text, x, 0), 
                wx.setNavigationBarTitle({
                    title: x.data.title
                }), wx.setStorageSync("isShowLoading", !1), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
            }
        }), app.util.request({
            url: "entry/wxapp/mymoney",
            data: {
                openid: a
            },
            success: function(a) {
                var t = a.data.data;
                x.setData({
                    mymoney: t.money,
                    globaluser: t
                });
            }
        }), setTimeout(function() {
            if (1 == x.data.comm && 0 != x.data.commSelf || 1 == x.data.commSelf) {
                x.setData({
                    commShow: 1
                });
                var a = x.data.comms;
                app.util.request({
                    url: "entry/wxapp/getComment",
                    cachetime: "0",
                    data: {
                        id: t,
                        comms: a,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(a) {
                        "" != a.data && x.setData({
                            comments: a.data.data,
                            is_comment: 1
                        });
                    }
                });
            }
        }, 500);
    },
    makePhoneCall: function(a) {
        var t = a.currentTarget.dataset.navtel;
        if ("" != t) wx.makePhoneCall({
            phoneNumber: t
        }); else {
            var e = this.data.baseinfo.tel;
            wx.makePhoneCall({
                phoneNumber: e
            });
        }
    },
    makePhoneCallB: function(a) {
        var t = this.data.baseinfo.tel_b;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    openMap: function(a) {
        wx.openLocation({
            latitude: parseFloat(this.data.baseinfo.latitude),
            longitude: parseFloat(this.data.baseinfo.longitude),
            name: this.data.baseinfo.name,
            address: this.data.baseinfo.address,
            scale: 22
        });
    },
    shareClo: function() {
        this.setData({
            shareShow: 0
        });
    },
    onShareAppMessage: function() {
        var a = wx.getStorageSync("openid"), t = this.data.id, e = "";
        return e = 1 == this.data.globaluser.fxs ? "/sudu8_page/showArt/showArt?id=" + t + "&userid=" + a : "/sudu8_page/showArt/showArt?id=" + t + "&userid=" + a + "&fxsid=" + a, 
        {
            title: this.data.title,
            path: e,
            success: function(a) {}
        };
    },
    bindInputChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, i = this.data.pagedata;
        i[e].val = t, this.setData({
            pagedata: i
        });
    },
    bindPickerChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, i = this.data.pagedata, n = i[e].tp_text[t];
        i[e].val = n, this.setData({
            pagedata: i
        });
    },
    bindDateChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, i = this.data.pagedata;
        i[e].val = t, this.setData({
            pagedata: i
        });
    },
    bindTimeChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, i = this.data.pagedata;
        i[e].val = t, this.setData({
            pagedata: i
        });
    },
    checkboxChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, i = this.data.pagedata;
        i[e].val = t, this.setData({
            pagedata: i
        });
    },
    radioChange: function(a) {
        var t = a.detail.value, e = a.currentTarget.dataset.index, i = this.data.pagedata;
        i[e].val = t, this.setData({
            pagedata: i
        });
    },
    formSubmit: function(a) {
        for (var e = this, t = a.detail.formId, i = (e.data.datas, e.data.id), n = !0, o = e.data.pagedata, s = 0; s < o.length; s++) if (1 == o[s].ismust) if (5 == o[s].type) {
            if ("" == o[s].z_val) return n = !1, wx.showModal({
                title: "提醒",
                content: o[s].name + "为必填项！",
                showCancel: !1
            }), !1;
        } else if ("" == o[s].val) return n = !1, wx.showModal({
            title: "提醒",
            content: o[s].name + "为必填项！",
            showCancel: !1
        }), !1;
        n && app.util.request({
            url: "entry/wxapp/Formval",
            data: {
                id: i,
                pagedata: JSON.stringify(o),
                types: "showArt",
                openid: wx.getStorageSync("openid"),
                form_id: t,
                fid: e.data.datas.formset
            },
            success: function(a) {
                var t = a.data.data.id;
                wx.showModal({
                    title: "提示",
                    content: a.data.data.con,
                    showCancel: !1,
                    success: function(a) {
                        e.sendMail_form(i, t);
                    }
                });
            }
        });
    },
    sendMail_form: function(t, a) {
        app.util.request({
            url: "entry/wxapp/sendMail_form",
            data: {
                id: t,
                cid: a
            },
            success: function(a) {
                wx.redirectTo({
                    url: "/sudu8_page/showArt/showArt?id=" + t
                });
            },
            fail: function(a) {}
        });
    },
    choiceimg1111: function(a) {
        var o = this, t = 0, s = o.data.zhixin, d = a.currentTarget.dataset.index, r = o.data.pagedata, e = r[d].val, i = r[d].tp_text[0];
        e ? t = e.length : (t = 0, e = []);
        var n = i - t, u = app.util.url("entry/wxapp/wxupimg", {
            m: "sudu8_page"
        }), c = r[d].z_val ? r[d].z_val : [];
        wx.chooseImage({
            count: n,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                s = !0, o.setData({
                    zhixin: s
                }), wx.showLoading({
                    title: "图片上传中"
                });
                var t = a.tempFilePaths, i = 0, n = t.length;
                !function e() {
                    wx.uploadFile({
                        url: u,
                        filePath: t[i],
                        name: "file",
                        success: function(a) {
                            var t = JSON.parse(a.data);
                            c.push(t), r[d].z_val = c, o.setData({
                                pagedata: r
                            }), ++i < n ? e() : (s = !1, o.setData({
                                zhixin: s
                            }), wx.hideLoading());
                        }
                    });
                }();
            }
        });
    },
    delimg: function(a) {
        var t = a.currentTarget.dataset.index, e = a.currentTarget.dataset.id, i = this.data.pagedata, n = i[t].z_val;
        n.splice(e, 1), 0 == n.length && (n = ""), i[t].z_val = n, this.setData({
            pagedata: i
        });
    },
    onPreviewImage: function(a) {
        app.util.showImage(a);
    },
    ffgk: function(a) {
        var t = this, e = t.data.id, i = t.data.mymoney, n = a.currentTarget.dataset.pay, o = a.currentTarget.dataset.type, s = wx.getStorageSync("openid");
        if (1 * n <= 1 * i) wx.showModal({
            title: "提醒",
            content: "您的余额为" + i + "元，本次将扣除" + n + "元",
            success: function(a) {
                a.confirm && app.util.request({
                    url: "entry/wxapp/videozhifu",
                    data: {
                        openid: s,
                        mykoumoney: n,
                        types: 1,
                        id: e,
                        artType: o
                    },
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(a) {
                        t.payover_fxs(a.data.data.order_id), t.getPoductDetail(e);
                    }
                });
            }
        }); else {
            var d = n - i;
            0 == i ? wx.showModal({
                title: "提醒",
                content: "您将微信支付" + d + "元",
                success: function(a) {
                    a.confirm && t.zhifu(d, i, e, o);
                }
            }) : wx.showModal({
                title: "提醒",
                content: "您将余额支付" + i + "元，微信支付" + d + "元",
                success: function(a) {
                    a.confirm && t.zhifu(d, i, e, o);
                }
            });
        }
    },
    zhifu: function(e, i, n, o) {
        var s = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/videozhifu",
            data: {
                openid: a,
                money: e,
                mykoumoney: i,
                types: 2,
                id: n
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                var t = a.data.data.order_id;
                "success" == a.data.message && wx.requestPayment({
                    timeStamp: a.data.data.timeStamp,
                    nonceStr: a.data.data.nonceStr,
                    package: a.data.data.package,
                    signType: "MD5",
                    paySign: a.data.data.paySign,
                    success: function(a) {
                        wx.showToast({
                            title: "支付成功",
                            icon: "success",
                            duration: 3e3,
                            success: function(a) {
                                s.dosetmoney(e, i, n, t, o);
                            }
                        });
                    }
                });
            }
        });
    },
    dosetmoney: function(a, t, e, i, n) {
        var o = this, s = wx.getStorageSync("openid");
        e = o.data.id;
        app.util.request({
            url: "entry/wxapp/videogeng",
            data: {
                openid: s,
                money: a,
                mykoumoney: t,
                orderid: i,
                id: e,
                artType: n
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                "1" == a.data.data.count && o.payover_fxs(a.data.data.order_id), o.getPoductDetail(e);
            }
        });
    },
    namexz: function(a) {
        for (var t = a.currentTarget.dataset.index, e = this.data.pagedata[t], i = [], n = 0; n < e.tp_text.length; n++) {
            var o = {};
            o.keys = e.tp_text[n], o.val = 1, i.push(o);
        }
        this.setData({
            ttcxs: 1,
            formindex: t,
            xx: i,
            xuanz: 0,
            lixuanz: -1
        }), this.riqi();
    },
    riqi: function() {
        for (var a = new Date(), t = new Date(a.getTime()), e = t.getFullYear() + "-" + (t.getMonth() + 1) + "-" + t.getDate(), i = this.data.xx, n = 0; n < i.length; n++) i[n].val = 1;
        this.setData({
            xx: i
        }), this.gettoday(e);
        var o = [], s = [], d = new Date();
        for (n = 0; n < 5; n++) {
            var r = new Date(d.getTime() + 24 * n * 3600 * 1e3), u = r.getFullYear(), c = r.getMonth() + 1, l = r.getDate(), p = c + "月" + l + "日", g = u + "-" + c + "-" + l;
            o.push(p), s.push(g);
        }
        this.setData({
            arrs: o,
            fallarrs: s,
            today: e
        });
    },
    xuanzd: function(a) {
        for (var t = a.currentTarget.dataset.index, e = this.data.fallarrs[t], i = this.data.xx, n = 0; n < i.length; n++) i[n].val = 1;
        this.setData({
            xuanz: t,
            today: e,
            lixuanz: -1,
            xx: i
        }), this.gettoday(e);
    },
    goux: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            lixuanz: t
        });
    },
    gettoday: function(a) {
        var n = this, t = n.data.id, e = n.data.formindex, o = n.data.xx;
        app.util.request({
            url: "entry/wxapp/Duzhan",
            data: {
                id: t,
                types: "showArt",
                days: a,
                pagedatekey: e
            },
            header: {
                "content-type": "application/json"
            },
            success: function(a) {
                for (var t = a.data.data, e = 0; e < t.length; e++) o[t[e]].val = 2;
                var i = 0;
                t.length == o.length && (i = 1), n.setData({
                    xx: o,
                    isover: i
                });
            }
        });
    },
    save: function() {
        var a = this, t = a.data.today, e = a.data.xx, i = a.data.lixuanz;
        if (-1 == i) return wx.showModal({
            title: "提现",
            content: "请选择预约的选项",
            showCancel: !1
        }), !1;
        var n = "已选择" + t + "，" + e[i].keys, o = a.data.pagedata, s = a.data.formindex;
        o[s].val = n, o[s].days = t, o[s].indexkey = s, o[s].xuanx = i, a.setData({
            ttcxs: 0,
            pagedata: o
        });
    },
    quxiao: function() {
        this.setData({
            ttcxs: 0
        });
    },
    refreshSessionkey: function() {
        var t = this;
        wx.login({
            success: function(a) {
                app.util.request({
                    url: "entry/wxapp/getNewSessionkey",
                    data: {
                        code: a.code
                    },
                    success: function(a) {
                        t.setData({
                            newSessionKey: a.data.data
                        });
                    }
                });
            }
        });
    },
    getPhoneNumber1: function(a) {
        var i = this, t = a.detail.iv, e = a.detail.encryptedData;
        "getPhoneNumber:ok" == a.detail.errMsg ? wx.checkSession({
            success: function() {
                app.util.request({
                    url: "entry/wxapp/jiemiNew",
                    data: {
                        newSessionKey: i.data.newSessionKey,
                        iv: t,
                        encryptedData: e
                    },
                    success: function(a) {
                        if (a.data.data) {
                            for (var t = i.data.pagedata, e = 0; e < t.length; e++) 0 == t[e].type && 5 == t[e].tp_text[0] && (t[e].val = a.data.data);
                            i.setData({
                                wxmobile: a.data.data,
                                pagedata: t
                            });
                        } else wx.showModal({
                            title: "提示",
                            content: "sessionKey已过期，请下拉刷新！"
                        });
                    },
                    fail: function(a) {}
                });
            },
            fail: function() {
                wx.showModal({
                    title: "提示",
                    content: "sessionKey已过期，请下拉刷新！"
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "请先授权获取您的手机号！",
            showCancel: !1
        });
    },
    weixinadd: function() {
        var s = this;
        wx.chooseAddress({
            success: function(a) {
                for (var t = a.provinceName + " " + a.cityName + " " + a.countyName + " " + a.detailInfo, e = a.userName, i = a.telNumber, n = s.data.pagedata, o = 0; o < n.length; o++) 0 == n[o].type && 2 == n[o].tp_text[0] && (n[o].val = e), 
                0 == n[o].type && 3 == n[o].tp_text[0] && (n[o].val = i), 0 == n[o].type && 4 == n[o].tp_text[0] && (n[o].val = t);
                s.setData({
                    myname: e,
                    mymobile: i,
                    myaddress: t,
                    pagedata: n
                });
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
    givepscore: function() {
        var a = this.data.id, t = this.data.userid, e = wx.getStorageSync("openid");
        t != e && 0 != t && "" != t && null != t && app.util.request({
            url: "entry/wxapp/giveposcore",
            data: {
                id: a,
                types: "showArt",
                openid: e,
                fxsid: t
            },
            success: function(a) {}
        });
    },
    payover_fxs: function(a) {
        var t = wx.getStorageSync("openid"), e = wx.getStorageSync("fxsid");
        app.util.request({
            url: "entry/wxapp/payoverFxs",
            data: {
                openid: t,
                order_id: a,
                fxsid: e,
                types: "art"
            },
            success: function(a) {},
            fail: function(a) {}
        });
    }
});