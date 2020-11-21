function t(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var a, e, i = getApp(), s = i.requirejs("core"), o = i.requirejs("wxParse/wxParse"), n = i.requirejs("biz/diypage"), r = i.requirejs("biz/diyform"), d = i.requirejs("biz/goodspicker"), u = (i.requirejs("foxui"), 
i.requirejs("jquery"));

Page((e = {
    data: (a = {
        imgUrls: [ "https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1509963648306&di=1194f5980cccf9e5ad558dfb18e895ab&imgtype=0&src=http%3A%2F%2Fd.hiphotos.baidu.com%2Fzhidao%2Fpic%2Fitem%2F9c16fdfaaf51f3de87bbdad39ceef01f3a29797f.jpg", "https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1509963737453&di=b1472a710a2c9ba30808fd6823b16feb&imgtype=0&src=http%3A%2F%2Fwww.qqzhi.com%2Fwenwen%2Fuploads%2Fpic.wenwen.soso.com%2Fp%2F20160830%2F20160830220016-586751007.jpg", "https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=3004162400,3684436606&fm=11&gp=0.jpg" ],
        indicatorDotss: !0,
        autoplays: !0,
        intervals: 2e3,
        durations: 500,
        circulars: !0,
        adveradmin: !0,
        clock: "",
        diypage: "true",
        route: "custom",
        icons: i.requirejs("icons"),
        shop: {},
        indicatorDots: !0,
        autoplay: !0,
        interval: 5e3,
        duration: 500,
        circular: !0,
        storeRecommand: [],
        total: 1,
        page: 1,
        loaded: !1,
        loading: !0,
        indicatorDotsHot: !1,
        autoplayHot: !0,
        intervalHot: 5e3,
        durationHOt: 1e3,
        circularHot: !0,
        hotimg: "/static/images/hotdot.jpg",
        notification: "/static/images/notification.png",
        saleout1: "/static/images/saleout-1.png",
        saleout2: "/static/images/saleout-2.png",
        saleout3: "/static/images/saleout-3.png",
        play: "/static/images/video_play.png",
        mute: "/static/images/icon/mute.png",
        voice: "/static/images/icon/voice.png",
        specs: [],
        options: [],
        diyform: {},
        specsTitle: ""
    }, t(a, "total", 1), t(a, "active", ""), t(a, "slider", ""), t(a, "tempname", ""), 
    t(a, "buyType", ""), t(a, "areas", []), t(a, "closeBtn", !1), t(a, "soundpic", !0), 
    t(a, "modelShow", !1), t(a, "limits", !0), t(a, "result", {}), t(a, "audios", {}), 
    t(a, "audiosObj", {}), t(a, "picture", {}), t(a, "result", {}), t(a, "pageid", 0), 
    a),
    onShow: function() {
        var t = this, a = wx.getSystemInfoSync(), e = t.data.pageid;
        s.get("diypage&id=" + e, {}, function(a) {
            var e = {
                loading: !1,
                diypage: a.diypage
            };
            t.setData(e);
        }), t.setData({
            screenWidth: a.windowWidth
        });
    },
    onLoad: function(t) {
        t = t || {};
        var a = this;
        a.pauseOther();
        var e = t.pageid;
        if (void 0 == e) {
            var o = getCurrentPages(), r = o[o.length - 1].route.split("/");
            e = r[r.length - 1];
        }
        a.setData({
            pageid: e,
            imgUrl: i.globalData.approot
        });
        var d = decodeURIComponent(t.scene);
        if (!t.id && d) {
            var u = s.str2Obj(d);
            t.id = u.id, u.mid && (t.mid = u.mid);
        }
        setTimeout(function() {
            a.setData({
                areas: i.getCache("cacheset").areas
            });
        }, 3e3), i.url(t), n.get(this, e, function(t) {
            if (void 0 != a.data.startadv && "" != a.data.startadv) {
                0 != a.data.startadv.status && "" != a.data.startadv || wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.userInfo"];
                    }
                });
                var e = a.data.startadv.params;
                if ("default" == e.style) {
                    var s = e.autoclose;
                    !function t(e) {
                        a.setData({
                            clock: s
                        }), s <= 0 ? a.setData({
                            adveradmin: !1
                        }) : setTimeout(function() {
                            s -= 1, t(e);
                        }, 1e3);
                    }(a);
                }
                if (1 == e.showtype) {
                    var o = 1e3 * e.showtime * 60, n = i.getCache("startadvtime"), r = +new Date(), d = !0;
                    a.setData({
                        adveradmin: !0
                    }), n && r - n < o && (d = !1), a.setData({
                        adveradmin: d
                    }), d && i.setCache("startadvtime", r);
                }
                a.data.startadv.status;
            }
        }), a.setData({
            cover: !0,
            showvideo: !1
        }), wx.getSystemInfo({
            success: function(t) {
                var e = t.windowWidth / 1.7;
                a.setData({
                    swiperheight: e
                });
            }
        });
    },
    getShop: function() {
        var t = this;
        s.get("shop/get_shopindex", {}, function(a) {
            o.wxParse("wxParseData", "html", a.copyright, t, "5"), t.setData({
                shop: a
            });
        });
    },
    onReachBottom: function() {
        this.data.loaded || this.data.storeRecommand.length == this.data.total || this.getRecommand();
    },
    getRecommand: function() {
        var t = this;
        "true" != t.data.diypage && s.get("shop/get_recommand", {
            page: t.data.page
        }, function(a) {
            var e = {
                loading: !1,
                total: a.total
            };
            t.setData({
                loading: !1,
                total: a.total,
                show: !0
            }), a.list || (a.list = []), a.list.length > 0 && (t.setData({
                storeRecommand: t.data.storeRecommand.concat(a.list),
                page: a.page + 1
            }), a.list.length < a.pagesize && (e.loaded = !0));
        });
    },
    imagesHeight: function(t) {
        var a = t.detail.width, e = t.detail.height, i = t.target.dataset.type, s = this;
        wx.getSystemInfo({
            success: function(t) {
                s.data.result[i] = t.windowWidth / a * e, (!s.data[i] || s.data[i] && result[i] < s.data[i]) && s.setData({
                    result: s.data.result
                });
            }
        });
    },
    bindInput: function(t) {
        this.setData({
            inputValue: t.detail.value
        });
    },
    t1: function(t) {
        n.fixedsearch(this, t);
    },
    startplay: function(t) {
        var a = t.target.dataset.cover;
        this.setData({
            cover: a,
            showvideo: !0
        }), this.videoContext = wx.createVideoContext("Video"), this.videoContext.play();
    },
    unpaidcolse: function(t) {
        var a = "";
        a = "open" == t.target.dataset.type, this.setData({
            unpaid: a
        });
    },
    unpaidcolse2: function(t) {
        this.setData({
            unpaidhide: !0
        });
    },
    get_nopayorder: function() {
        var t = this;
        s.get("shop/get_nopayorder", {}, function(a) {
            1 == a.hasinfo && t.setData({
                nopaygoods: a.goods,
                nopaygoodstotal: a.goodstotal,
                nopayorder: a.order,
                unpaid: !0
            });
        });
    },
    get_hasnewcoupon: function() {
        var t = this;
        s.get("shop/get_hasnewcoupon", {}, function(a) {
            1 == a.hasnewcoupon && t.setData({
                showcoupontips: !0
            });
        });
    },
    get_cpinfos: function() {
        var t = this;
        s.get("shop/get_cpinfos", {}, function(a) {
            1 == a.hascpinfos && t.setData({
                showcoupon: !0,
                cpinfos: a.cpinfos
            });
        });
    },
    adverclose: function() {
        this.setData({
            adveradmin: !1
        }), this.get_nopayorder();
    },
    indexChangebtn: function(t) {
        var a = t.currentTarget.dataset.type;
        wx.navigateTo({
            url: a
        });
    }
}, t(e, "unpaidcolse", function(t) {
    var a = "";
    a = "open" == t.target.dataset.type, this.setData({
        unpaid: a
    });
}), t(e, "unpaidcolse2", function(t) {
    this.setData({
        unpaidhide: !0
    });
}), t(e, "selectPicker", function(t) {
    i.checkAuth();
    var a = this;
    wx.getSetting({
        success: function(e) {
            if (e.authSetting["scope.userInfo"]) {
                d.selectpicker(t, a, "goodslist"), a.setData({
                    cover: "",
                    showvideo: !1
                });
            }
        }
    });
}), t(e, "specsTap", function(t) {
    var a = this;
    d.specsTap(t, a);
}), t(e, "emptyActive", function() {
    this.setData({
        active: "",
        slider: "out",
        tempname: "",
        specsTitle: ""
    });
}), t(e, "buyNow", function(t) {
    var a = this;
    d.buyNow(t, a);
}), t(e, "getCart", function(t) {
    var a = this;
    d.getCart(t, a);
}), t(e, "select", function() {
    var t = this;
    d.select(t);
}), t(e, "inputNumber", function(t) {
    var a = this;
    d.inputNumber(t, a);
}), t(e, "number", function(t) {
    var a = this;
    d.number(t, a);
}), t(e, "onChange", function(t) {
    return r.onChange(this, t);
}), t(e, "DiyFormHandler", function(t) {
    return r.DiyFormHandler(this, t);
}), t(e, "selectArea", function(t) {
    return r.selectArea(this, t);
}), t(e, "bindChange", function(t) {
    return r.bindChange(this, t);
}), t(e, "onCancel", function(t) {
    return r.onCancel(this, t);
}), t(e, "onConfirm", function(t) {
    return r.onConfirm(this, t);
}), t(e, "getIndex", function(t, a) {
    return r.getIndex(t, a);
}), t(e, "changevoice", function() {
    this.data.sound ? this.setData({
        sound: !1,
        soundpic: !0
    }) : this.setData({
        sound: !0,
        soundpic: !1
    });
}), t(e, "phone", function() {
    var t = this.data.phonenumber + "";
    wx.makePhoneCall({
        phoneNumber: t
    });
}), t(e, "cancelclick", function() {
    this.setData({
        modelShow: !1
    });
}), t(e, "confirmclick", function() {
    this.setData({
        modelShow: !1
    }), wx.openSetting({
        success: function(t) {}
    });
}), t(e, "navigate", function(t) {
    var a = t.currentTarget.dataset.url, e = t.currentTarget.dataset.phone, i = t.currentTarget.dataset.appid, s = t.currentTarget.dataset.appurl;
    a && wx.navigateTo({
        url: a,
        fail: function(t) {
            wx.switchTab({
                url: a
            });
        }
    }), e && wx.makePhoneCall({
        phoneNumber: e
    }), i && wx.navigateToMiniProgram({
        appId: i,
        path: s
    });
}), t(e, "closecoupon", function() {
    this.setData({
        showcoupon: !1
    });
}), t(e, "closecoupontips", function() {
    this.setData({
        showcoupontips: !1
    });
}), t(e, "onReady", function(t) {}), t(e, "pauseOther", function(t) {
    var a = this;
    u.each(this.data.audiosObj, function(e, i) {
        if (e != t) {
            i.pause();
            var s = a.data.audios;
            s[e] && (s[e].status = !1, a.setData({
                audios: s
            }));
        }
    });
}), t(e, "play", function(t) {
    var a = t.target.dataset.id, e = this.data.audiosObj[a] || !1;
    if (!e) {
        e = wx.createInnerAudioContext("audio_" + a);
        var i = this.data.audiosObj;
        i[a] = e, this.setData({
            audiosObj: i
        });
    }
    var s = this;
    e.onPlay(function() {
        var t = setInterval(function() {
            var i = e.currentTime / e.duration * 100 + "%", o = Math.floor(Math.ceil(e.currentTime) / 60), n = (Math.ceil(e.currentTime) % 60 / 100).toFixed(2).slice(-2), r = Math.ceil(e.currentTime);
            o < 10 && (o = "0" + o);
            var d = o + ":" + n, u = s.data.audios;
            u[a].audiowidth = i, u[a].Time = t, u[a].audiotime = d, u[a].seconds = r, s.setData({
                audios: u
            });
        }, 1e3);
    });
    var o = t.currentTarget.dataset.audio, n = t.currentTarget.dataset.time, r = t.currentTarget.dataset.pausestop, d = t.currentTarget.dataset.loopplay;
    0 == d && e.onEnded(function(t) {
        u[a].status = !1, s.setData({
            audios: u
        });
    });
    var u = s.data.audios;
    u[a] || (u[a] = {}), e.paused && 0 == n ? (e.src = o, e.play(), 1 == d && (e.loop = !0), 
    u[a].status = !0, s.pauseOther(a)) : e.paused && n > 0 ? (e.play(), 0 == r ? e.seek(n) : e.seek(0), 
    u[a].status = !0, s.pauseOther(a)) : (e.pause(), u[a].status = !1), s.setData({
        audios: u
    });
}), t(e, "imagesHeight", function(t) {
    var a = t.detail.width, e = t.detail.height, i = t.target.dataset.type, s = this;
    wx.getSystemInfo({
        success: function(t) {
            s.data.result[i] = t.windowWidth / a * e, (!s.data[i] || s.data[i] && result[i] < s.data[i]) && s.setData({
                result: s.data.result
            });
        }
    });
}), t(e, "onHide", function() {
    this.pauseOther();
}), t(e, "onUnload", function() {
    this.pauseOther();
}), t(e, "onPullDownRefresh", function() {}), t(e, "onReachBottom", function() {}), 
t(e, "onShareAppMessage", function() {
    return {
        title: this.data.diypages.page.title
    };
}), t(e, "tabtopmenu", function(t) {
    var a = this, e = a.data.diypages, i = (e.items, t.currentTarget.dataset.id, t.currentTarget.dataset.url), o = t.currentTarget.dataset.type, n = a.data.topmenu, r = t.currentTarget.dataset.index;
    if (c = a.data.pageid, a.setData({
        topmenuindex: r
    }), "" != i && void 0 != i) {
        if (1 == i.indexOf("pages")) {
            var d = i.lastIndexOf("="), c = i.substring(d + 1, i.length);
            s.get("diypage", {
                id: c
            }, function(t) {
                if (0 == t.error) {
                    var e = [];
                    for (var i in t.diypage.items) e.push(t.diypage.items[i]);
                    e.unshift(n);
                    var s = new Object();
                    for (var r in e) s[r] = e[r], "topmenu" == e[r].id && (e[r].status = o);
                    t.diypage.items = s, a.setData({
                        diypages: t.diypage,
                        topmenuDataType: ""
                    });
                }
            });
        } else s.get("diypage/getInfo", {
            dataurl: i
        }, function(t) {
            a.data.topmenu;
            s.get("diypage", {
                type: c
            }, function(e) {
                var i = e.diypage;
                u.each(i.items, function(a, e) {
                    if ("topmenu" == e.id) {
                        e.status = o;
                        for (var i in e.data) i == o && (e.data[i].data = t.goods.list, t.goods.list.length <= 8 && (e.data[i].showmore = !0));
                    }
                }), 0 == e.error && a.setData({
                    diypages: e.diypage,
                    topmenuDataType: t.type
                });
            });
        });
        a.setData({
            diypages: e
        });
    }
}), t(e, "tabwidget", function(t) {
    var a = this, e = a.data.diypages, i = (e.items, t.currentTarget.dataset.id), o = t.currentTarget.dataset.url, n = t.currentTarget.dataset.type;
    "" != o && void 0 != o && s.get("diypage/getInfo", {
        dataurl: o
    }, function(t) {
        for (var s in e.items) s == i && (e.items[s].data[n].data = t.goods.list, e.items[s].data[n].type = t.type, 
        e.items[s].type = t.type, e.items[s].status = n, t.goods.list.length <= 8 && (e.items[s].data[n].showmore = !0), 
        a.setData({
            diypages: e
        }));
    });
}), t(e, "getstoremore", function(t) {
    var a = this, e = t.currentTarget.dataset.id, i = a.data.diypages;
    u.each(i.items, function(t, o) {
        if (t == e) if (void 0 == o.status || "" == o.status) {
            if (-1 != o.data[0].linkurl.indexOf("stores")) d = "stores"; else d = "goods";
            var n = o.data[0].linkurl, r = o.data[0].data.length;
            s.get("diypage/getInfo", {
                dataurl: n,
                num: r,
                paramsType: d
            }, function(t) {
                o.data[0].data = t.goods.list, o.data[0].data.length == t.goods.count && (o.data[0].showmore = !0), 
                a.setData({
                    diypages: i
                });
            });
        } else {
            if (-1 != o.data[o.status].linkurl.indexOf("stores")) d = "stores"; else var d = "goods";
            var n = o.data[o.status].linkurl, r = o.data[o.status].data.length;
            s.get("diypage/getInfo", {
                dataurl: n,
                num: r,
                paramsType: d
            }, function(t) {
                o.data[o.status].data = t.goods.list, o.data[o.status].data.length == t.goods.count && (o.data[o.status].showmore = !0), 
                a.setData({
                    diypages: i
                });
            });
        }
    });
}), e));