var app = getApp(), recorderManager = wx.getRecorderManager();

Page({
    data: {
        luyin_flag: !0,
        flag: !0,
        release_money: 0,
        stick_money: 0,
        stick_days: 7,
        release_img: [],
        cons: "",
        fid: 0,
        rid: 0,
        funcAll: [],
        funcTitleArr: [],
        index: 0,
        userMoney: 0,
        success_rid: 0,
        choose_address: "",
        tel: "",
        stick: 2,
        update: 0,
        cons_len: 0,
        settop: 1,
        release_audit: 0,
        choose_type: 0,
        voice: [],
        videoimg: "",
        videourl: "",
        title: "",
        address: "",
        voice_start: 2,
        touchStartTime: 0,
        touchEndTime: 0,
        lastTapTime: 0,
        lastTapTimeoutFunc: null,
        voice_flag: 0,
        textarea_flag: 1,
        telphone: "",
        get_wx: 0
    },
    onPullDownRefresh: function() {
        this.huoqusq(), this.getReleaseInfo(), wx.stopPullDownRefresh();
    },
    onLoad: function(e) {
        var t = this;
        wx.setNavigationBarTitle({
            title: "发布信息"
        });
        var a = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: a,
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(e) {
                t.setData({
                    baseinfo: e.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            },
            fail: function(e) {}
        }), t.huoqusq();
        var s = e.fid;
        0 < s && t.setData({
            fid: s
        });
        var i = e.rid;
        0 < i && (t.setData({
            rid: i
        }), t.getReleaseInfo());
    },
    getInputTel: function(e) {
        var t = e.detail.value;
        this.setData({
            telphone: t
        });
    },
    getInputAdd: function(e) {
        var t = e.detail.value;
        this.setData({
            address: t
        });
    },
    getReleaseInfo: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/GetForumCon",
            data: {
                rid: t.data.rid,
                types: 1
            },
            success: function(e) {
                t.setData({
                    cons: e.data.data.content,
                    release_img: e.data.data.img,
                    release_money: 0,
                    fid: e.data.data.fid,
                    telphone: e.data.data.telphone,
                    address: e.data.data.address,
                    stick: e.data.data.stick,
                    update: 1,
                    videourl: e.data.data.videourl,
                    voice: e.data.data.voice,
                    title: e.data.data.release_title,
                    choose_address: e.data.data.choose_address,
                    choose_type: e.data.data.choose_type
                });
            }
        });
    },
    getlocation: function() {
        var t = this;
        wx.chooseLocation({
            success: function(e) {
                t.setData({
                    choose_address: e.name,
                    latitude: e.latitude,
                    longitude: e.longitude
                });
            },
            fail: function() {
                wx.getSetting({
                    success: function(e) {
                        e.authSetting["scope.userLocation"] || wx.showModal({
                            title: "请授权获取当前位置",
                            content: "获取位置需要授权此功能",
                            showCancel: !1,
                            success: function(e) {
                                e.confirm && wx.openSetting({
                                    success: function(e) {
                                        !0 === e.authSetting["scope.userLocation"] ? wx.showToast({
                                            title: "授权成功",
                                            icon: "success",
                                            duration: 1e3
                                        }) : wx.showToast({
                                            title: "授权失败",
                                            icon: "success",
                                            duration: 1e3,
                                            success: function() {
                                                t.getlocation();
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    },
                    fail: function(e) {
                        wx.showToast({
                            title: "调用授权窗口失败",
                            icon: "success",
                            duration: 1e3
                        });
                    }
                });
            }
        });
    },
    huoqusq: function() {
        var r = this, u = wx.getStorageSync("openid");
        r.setData({
            openid: u
        }), wx.getUserInfo({
            success: function(e) {
                var t = e.userInfo, a = t.nickName, s = t.avatarUrl, i = t.gender, o = t.province, n = t.city, c = t.country, d = app.util.url("entry/wxapp/Useupdate", {
                    m: "sudu8_page"
                });
                wx.request({
                    url: d,
                    data: {
                        openid: u,
                        nickname: a,
                        avatarUrl: s,
                        gender: i,
                        province: o,
                        city: n,
                        country: c
                    },
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(e) {
                        r.setData({
                            isview: 0,
                            userMoney: e.data.data.money
                        });
                    }
                }), r.getforumset(), r.getfuncall();
            },
            fail: function() {
                r.setData({
                    isview: 1
                });
            }
        });
    },
    getfuncall: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/GetFuncAll",
            success: function(e) {
                if (0 < e.data.data.funcAll.length) {
                    var t = e.data.data.funcAll;
                    i.setData({
                        funcAll: e.data.data.funcAll,
                        funcTitleArr: e.data.data.funcTitleArr
                    });
                    var a = i.data.fid;
                    if (0 < a) {
                        for (var s = 0; s < t.length; s++) a == t[s].id && i.setData({
                            index: s
                        });
                        i.setData({
                            fid: a
                        });
                    } else i.setData({
                        fid: e.data.data.funcAll[0].id
                    });
                }
            },
            fail: function(e) {}
        });
    },
    bindPickerChange: function(e) {
        var t = e.detail.value, a = this.data.funcAll[t].id;
        this.setData({
            fid: a,
            index: t
        });
    },
    releasePay: function(e) {
        var t = this;
        if (0 == t.data.fid) return wx.showModal({
            fid: "提示",
            showCancel: !1,
            content: "发布类型不能为空"
        }), !1;
        if ("" == t.data.title) return wx.showModal({
            title: "提示",
            showCancel: !1,
            content: "标题不能为空"
        }), !1;
        if ("" == t.data.cons) return wx.showModal({
            title: "提示",
            showCancel: !1,
            content: "发布信息不能为空"
        }), !1;
        var a = t.data.set_location, s = t.data.choose_address;
        if (1 == a && "" == s) return wx.showModal({
            title: "提示",
            showCancel: !1,
            content: "请选择所在位置"
        }), !1;
        var i = t.data.set_tel, o = t.data.telphone;
        if (1 == i && "" == o) return wx.showModal({
            title: "提示",
            showCancel: !1,
            content: "请获取/输入电话号码"
        }), !1;
        var n = t.data.set_address, c = t.data.address;
        if (1 == n && "" == c) return wx.showModal({
            title: "提示",
            showCancel: !1,
            content: "请获取/输入联系地址"
        }), !1;
        var d = e.detail.formId, r = t.data.release_money, u = t.data.update;
        0 < r && 0 == u ? app.util.request({
            url: "entry/wxapp/ForumOrder",
            data: {
                release_money: r,
                openid: t.data.openid,
                formId: d
            },
            success: function(e) {
                if (1 == e.data.data.type) wx.showModal({
                    title: "请注意",
                    content: "您将使用余额支付" + r + "元",
                    success: function(e) {
                        e.confirm && t.releaseSub();
                    }
                }); else {
                    if ("success" == e.data.data.message) {
                        e.data.data.order_id;
                        t.setData({
                            prepay_id: e.data.data.package
                        }), wx.requestPayment({
                            timeStamp: e.data.data.timeStamp,
                            nonceStr: e.data.data.nonceStr,
                            package: e.data.data.package,
                            signType: "MD5",
                            paySign: e.data.data.paySign,
                            success: function(e) {
                                0 < t.data.userMoney ? app.util.request({
                                    url: "entry/wxapp/UpdateUserMoney",
                                    data: {
                                        openid: t.data.openid
                                    },
                                    success: function(e) {
                                        1 == e.data.data && wx.showToast({
                                            title: "支付成功",
                                            icon: "success",
                                            duration: 3e3,
                                            success: function(e) {
                                                t.releaseSub();
                                            }
                                        });
                                    }
                                }) : wx.showToast({
                                    title: "支付成功",
                                    icon: "success",
                                    duration: 3e3,
                                    success: function(e) {
                                        t.releaseSub();
                                    }
                                });
                            },
                            fail: function(e) {},
                            complete: function(e) {}
                        });
                    }
                    "error" == e.data.data.message && wx.showModal({
                        title: "提醒",
                        content: e.data.data.message,
                        showCancel: !1
                    });
                }
            },
            fail: function(e) {}
        }) : t.releaseSub();
    },
    releaseSub: function() {
        var a = this, e = a.data.cons, t = a.data.release_money, s = a.data.release_img;
        0 == s.length && (s = "");
        var i = a.data.release_audit, o = a.data.settop;
        app.util.request({
            url: "entry/wxapp/ReleaseSub",
            data: {
                openid: a.data.openid,
                fid: a.data.fid,
                rid: a.data.rid,
                cons: e,
                release_money: t,
                release_img: 0 < s.length ? JSON.stringify(s) : "",
                address: a.data.address,
                choose_address: a.data.choose_address,
                latitude: a.data.latitude,
                longitude: a.data.longitude,
                telphone: a.data.telphone,
                release_audit: i,
                title: a.data.title,
                videourl: a.data.videourl,
                voice: 0 < a.data.voice.length ? JSON.stringify(a.data.voice) : ""
            },
            success: function(e) {
                var t = e.data.data;
                0 < t ? 0 == i ? wx.showModal({
                    title: "提示",
                    showCancel: !1,
                    content: "发布成功",
                    success: function() {
                        if (1 == a.data.stick) {
                            a.data.fid;
                            wx.navigateBack({
                                delta: 1
                            });
                        } else a.setData({
                            success_rid: t
                        });
                        0 == o && a.goReleaseLists();
                    }
                }) : wx.showModal({
                    title: "提示",
                    showCancel: !1,
                    content: "发布成功，请等待审核！",
                    success: function(e) {
                        if (1 == a.data.stick) {
                            a.data.fid;
                            a.goReleaseLists();
                        } else a.setData({
                            success_rid: t
                        });
                        0 == o && a.goReleaseLists();
                    }
                }) : wx.showToast({
                    title: "发布失败"
                });
            },
            fail: function(e) {}
        });
    },
    goReleaseLists: function() {
        var e = this.data.fid;
        wx.redirectTo({
            url: "/sudu8_page_plugin_mapforum/forum/forum?fid=" + e
        });
    },
    go_set_top: function() {
        var e = this.data.fid, t = this.data.success_rid;
        wx.redirectTo({
            url: "/sudu8_page_plugin_mapforum/set_top/set_top?fid=" + e + "&rid=" + t + "&returnpage=2"
        });
    },
    delimg: function(e) {
        var t = e.currentTarget.dataset.index, a = this.data.release_img;
        a.splice(t, 1), 0 == a.length && this.setData({
            choose_type: 0
        }), this.setData({
            release_img: a
        });
    },
    delvoice: function(e) {
        var t = e.currentTarget.dataset.index, a = this.data.voice;
        a.splice(t, 1), this.setData({
            voice: a,
            voice_flag: 1
        }), 0 == a.length && this.setData({
            choose_type: 0
        });
    },
    getforumset: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/ForumSet",
            success: function(e) {
                t.setData({
                    release_money: e.data.data.release_money,
                    stick_money: e.data.data.stick_money,
                    settop: e.data.data.settop,
                    release_audit: e.data.data.release_audit,
                    set_location: e.data.data.location,
                    set_tel: e.data.data.tel,
                    set_address: e.data.data.address,
                    get_wx: e.data.data.get_wx
                });
            },
            fail: function(e) {}
        });
    },
    gettitle: function(e) {
        var t = e.detail.value;
        this.setData({
            title: t
        });
    },
    getcons: function(e) {
        var t = e.detail.value, a = t.length;
        this.setData({
            cons: t,
            cons_len: a
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    select: function() {
        var e = this.data.select;
        e = 2 == e ? 1 : 2, this.setData({
            select: e
        });
    },
    bindManual: function(e) {
        var t = e.detail.value;
        this.setData({
            stick_days: t
        });
    },
    zhezhao_open: function() {
        this.setData({
            flag: !1,
            textarea_flag: 0
        });
    },
    zhezhao_close: function() {
        this.setData({
            flag: !0,
            textarea_flag: 1
        });
    },
    change_type: function(e) {
        var a = this;
        if (this.setData({
            choose_type: e.currentTarget.dataset.type,
            flag: !0
        }), 1 == this.data.choose_type) this.setData({
            textarea_flag: 1
        }); else if (2 == this.data.choose_type) this.chooseVideo(), this.setData({
            textarea_flag: 1
        }); else if (3 == this.data.choose_type) {
            !function t() {
                wx.authorize({
                    scope: "scope.record",
                    success: function() {
                        a.setData({
                            luyin_flag: !1,
                            voice_start: 1
                        });
                    },
                    fail: function() {
                        wx.showModal({
                            title: "提示",
                            content: "您未授权录音，功能将无法使用",
                            confirmText: "授权",
                            showCancel: !1,
                            success: function(e) {
                                wx.openSetting({
                                    success: function(e) {
                                        e.authSetting["scope.record"] ? a.setData({
                                            luyin_flag: !1,
                                            voice_start: 1
                                        }) : t();
                                    }
                                });
                            }
                        });
                    }
                });
            }();
        }
    },
    chooseImg: function() {
        var o = this, n = o.data.zhixin, c = o.data.release_img;
        c || (c = []);
        var d = app.util.url("entry/wxapp/wxupimg", {
            m: "sudu8_page"
        });
        wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                n = !0, o.setData({
                    zhixin: n
                }), wx.showLoading({
                    title: "图片上传中"
                });
                var t = e.tempFilePaths, s = 0, i = t.length;
                !function a() {
                    wx.uploadFile({
                        url: d,
                        filePath: t[s],
                        name: "file",
                        success: function(e) {
                            var t = e.data.replace(/\\/g, "").replace(/\"/g, "");
                            c.push(t), o.setData({
                                release_img: c
                            }), ++s < i ? a() : (n = !1, o.setData({
                                zhixin: n
                            }), wx.hideLoading());
                        }
                    });
                }();
            }
        });
    },
    chooseVideo: function() {
        var a = this, s = app.util.url("entry/wxapp/wxupimg", {
            m: "sudu8_page"
        });
        wx.chooseVideo({
            sourceType: [ "album", "camera" ],
            success: function(e) {
                wx.showLoading({
                    title: "视频上传中"
                });
                var t = e.tempFilePath;
                wx.uploadFile({
                    url: s,
                    filePath: t,
                    name: "file",
                    success: function(e) {
                        var t = e.data.replace(/\\/g, "").replace(/\"/g, "");
                        a.setData({
                            videourl: t
                        }), wx.hideLoading();
                    }
                });
            },
            fail: function() {
                a.setData({
                    flag: !1,
                    textarea_flag: 0
                });
            }
        });
    },
    startRecode: function() {
        recorderManager.start({
            duration: 6e4,
            sampleRate: 16e3,
            numberOfChannels: 1,
            encodeBitRate: 96e3,
            format: "mp3",
            frameSize: 50
        }), this.setData({
            voice_start: 0
        }), recorderManager.onStart(function() {}), recorderManager.onError(function(e) {});
    },
    endRecode: function() {
        var i = this;
        recorderManager.stop(), recorderManager.onStop(function(e) {
            var s = i.data.voice;
            s || (s = []), wx.showLoading({
                title: "音频上传中"
            });
            var t = app.util.url("entry/wxapp/wxupimg", {
                m: "sudu8_page"
            });
            wx.uploadFile({
                url: t,
                filePath: e.tempFilePath,
                name: "file",
                success: function(e) {
                    var t = e.data.replace(/\\/g, "").replace(/\"/g, "");
                    if (s.push(t), 3 == s.length) var a = 0; else a = 1;
                    i.setData({
                        voice: s,
                        voice_flag: a,
                        voice_start: 2,
                        luyin_flag: !0,
                        textarea_flag: 1
                    }), wx.hideLoading();
                }
            });
        });
    },
    delvideo: function() {
        this.setData({
            choose_type: 0,
            videourl: ""
        });
    },
    chooseMusic: function() {
        this.setData({
            luyin_flag: !1,
            voice_start: 1
        });
    },
    getwxadd: function() {
        var t = this;
        wx.chooseAddress({
            success: function(e) {
                t.setData({
                    telphone: e.telNumber,
                    address: e.provinceName + e.countyName + e.cityName + e.detailInfo
                });
            },
            fail: function() {
                wx.showModal({
                    title: "授权失败",
                    content: "请重新授权",
                    showCancel: !1,
                    success: function(e) {
                        e.confirm && wx.openSetting({
                            success: function() {
                                wx.getSetting({
                                    success: function(e) {
                                        e.authSetting["scope.address"] && wx.chooseAddress({
                                            success: function(e) {
                                                t.setData({
                                                    telphone: e.telNumber,
                                                    address: e.provinceName + e.countyName + e.cityName + e.detailInfo
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        }), e.cancel;
                    }
                });
            }
        });
    }
});