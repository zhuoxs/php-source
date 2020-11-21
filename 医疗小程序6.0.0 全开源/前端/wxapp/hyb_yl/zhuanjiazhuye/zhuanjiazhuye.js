var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
    return typeof t;
} : function(t) {
    return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t;
}, app = getApp(), WxParse = require("../wxParse/wxParse.js");

Page({
    data: {
        id: "",
        shouqi: !1,
        shanchang: !1,
        guanzhu: !0,
        yuyue_status: !1,
        toastHidden3: !0,
        toastHidden4: !1,
        pageWrapCount: [],
        answerArr: []
    },
    payClick: function(t) {
        var a = t.currentTarget.dataset.url, e = wx.getStorageSync("openid"), n = t.currentTarget.dataset.money, i = this.data.xiangqing.z_name, o = wx.getStorageSync("openid"), s = this.data.zid;
        app.util.request({
            url: "entry/wxapp/Pay",
            header: {
                "Content-Type": "application/xml"
            },
            method: "GET",
            data: {
                openid: e,
                z_tw_money: n
            },
            success: function(t) {
                console.log(t), wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: t.data.signType,
                    paySign: t.data.paySign,
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/Joninmoney",
                            data: {
                                use_openid: o,
                                leixing: "电话",
                                name: i,
                                pay: n,
                                zid: s
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
                        }), wx.navigateTo({
                            url: "../webview/webview?src=" + a
                        });
                    }
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    switer: function() {
        this.setData({
            shouqi: !this.data.shouqi
        });
    },
    shanchang: function() {
        this.setData({
            shanchang: !this.data.shanchang
        });
    },
    doctorYuyue: function(t) {
        var a = t.currentTarget.dataset.id, e = t.currentTarget.dataset.data, n = t.currentTarget.dataset.day, i = t.currentTarget.dataset.massige;
        wx.navigateTo({
            url: "/hyb_yl/zhuanjiayuyue/zhuanjiayuyue?id=" + a + "&date=" + e + "&day=" + n + "&ksname=" + i
        });
    },
    answerListClick: function(t) {
        var a = this.data.zid;
        wx.navigateTo({
            url: "/hyb_yl/answer_list/answer_list?zid=" + a
        });
    },
    answerDetailClick: function(t) {
        var a = t.detail.id, e = this.data.zid, n = t.detail.qid;
        wx.navigateTo({
            url: "/hyb_yl/answer_detail/answer_detail?user_openid=" + a + "&p_id=" + e + "&qid=" + n
        });
    },
    zixianinfo: function(t) {
        var e = this.data.fid, a = t.currentTarget.dataset.data, n = t.currentTarget.dataset.name, i = (e = wx.getStorageSync("openid"), 
        t.currentTarget.dataset.money), o = t.currentTarget.dataset.docimg, s = this.data.tid, d = (this.data.bk_id, 
        this.data.zid), r = this.data.docid, c = t.currentTarget.dataset.u_id, u = wx.getStorageSync("openid"), l = a;
        app.util.request({
            url: "entry/wxapp/Mybkstate",
            data: {
                fid: e,
                tid: s
            },
            success: function(t) {
                var a = t.data.data.bk_id;
                "0" == t.data.data.bkstate ? 0 < i ? app.util.request({
                    url: "entry/wxapp/Pay",
                    header: {
                        "Content-Type": "application/xml"
                    },
                    method: "GET",
                    data: {
                        openid: wx.getStorageSync("openid"),
                        z_tw_money: i
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
                                        use_openid: u,
                                        leixing: "在线",
                                        name: n,
                                        pay: i,
                                        zid: d
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
                                    url: "entry/wxapp/Mybkstate",
                                    data: {
                                        bk_id: a
                                    },
                                    success: function(t) {
                                        wx.showModal({
                                            content: "请认真完成咨询哦^_^",
                                            showCancel: !1,
                                            success: function(t) {
                                                t.confirm && wx.navigateTo({
                                                    url: "/hyb_yl/liao_detail/liao_detail?name=" + n + "&fid=" + e + "&tid=" + l + "&bk_id=" + a + "&docimg=" + o + "&docid=" + r + "&u_id=" + c
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                }) : wx.showModal({
                    content: "请认真完成咨询哦^_^",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.navigateTo({
                            url: "/hyb_yl/liao_detail/liao_detail?name=" + n + "&fid=" + e + "&tid=" + l + "&bk_id=" + a + "&docimg=" + o + "&docid=" + r + "&u_id=" + c
                        });
                    }
                }) : wx.navigateTo({
                    url: "/hyb_yl/liao_detail/liao_detail?name=" + n + "&fid=" + e + "&tid=" + l + "&bk_id=" + a + "&docimg=" + o + "&docid=" + r + "&u_id=" + c
                });
            }
        });
    },
    copy: function(t, a) {
        a = a || {};
        for (var e in t) "object" === _typeof(t[e]) ? (a[e] = t[e].constructor === Array ? [] : {}, 
        this.copy(t[e], a[e])) : a[e] = t[e];
        return a;
    },
    onLoad: function(t) {
        wx.hideNavigationBarLoading();
        var a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        });
        var e = this, n = t.id, i = t.u_id, o = t.u_id, s = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Selmycuid",
            data: {
                openid: s
            },
            success: function(t) {
                var a = t.data.data.u_id;
                e.setData({
                    fid: t.data.data.u_id
                }), app.util.request({
                    url: "entry/wxapp/Mybkstateup",
                    data: {
                        fid: a,
                        tid: i
                    },
                    success: function(t) {
                        t.data.data.bk_id && e.setData({
                            bk_id: t.data.data.bk_id
                        });
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Zhuanjiaxiangqing",
            data: {
                id: n
            },
            success: function(t) {
                console.log(t), e.setData({
                    xiangqing: t.data.data
                }), WxParse.wxParse("article", "html", t.data.data.z_content, e, 5);
            },
            fail: function(t) {}
        }), app.util.request({
            url: "entry/wxapp/CheckCollect",
            headers: {
                "Content-Type": "application/json"
            },
            data: {
                openid: s,
                goods_id: n
            },
            success: function(t) {
                2 == t.data ? e.setData({
                    toastHidden3: !0,
                    toastHidden4: !1,
                    toastHidden31: !0,
                    toastHidden41: !1
                }) : 1 == t.data && e.setData({
                    toastHidden3: !1,
                    toastHidden4: !0,
                    toastHidden31: !1,
                    toastHidden41: !0
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Question",
            data: {
                pid: n
            },
            success: function(t) {
                console.log(t), app.globalData.answer = t.data.data, e.setData({
                    allq: t.data.data,
                    pageWrapCount: e.data.pageWrapCount.concat([ 1 ])
                }), WxParse.wxParse("article", "html", t.data.data.z_content, e, 5);
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/Zhuanpaib",
            data: {
                pp_id: n,
                openid: s
            },
            success: function(t) {
                e.setData({
                    zhuanpaib: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
        s = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Myinforsarray",
            data: {
                openid: s
            },
            success: function(t) {
                e.setData({
                    mygerzl: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), e.renshu(n), e.setData({
            zid: n,
            tid: i,
            docid: n,
            u_id: o
        });
    },
    renshu: function(t) {
        var y = this;
        app.util.request({
            url: "entry/wxapp/Selectdoctime",
            data: {
                zid: t
            },
            success: function(t) {
                var a = t.data, e = [], n = {};
                for (var i in a) y.copy(t.data, n), e = e.concat(n[i]);
                var o = Array.from(e);
                y.pin(o);
                for (var s = [ "一", "二", "三", "四", "五", "六", "日" ], d = 0; d < 7; d++) if ("object" == _typeof(o[d])) o[d].week = "周" + s[d]; else {
                    var r = {};
                    r.week = "周" + s[d], o[d] = r;
                }
                var c = new Date();
                if (0 == c.getDay()) var u = 6; else u = c.getDay() - 1;
                var l = o[o.length - 1];
                o.splice(o.length - 1, 1);
                for (var p = 0; p < o.length; p++) for (var f in o[p]) -1 != f.indexOf("num") && ("" == o[p][f] ? o[p].dian = !1 : o[p].dian = !0);
                y.setData({
                    selectdoctime: o,
                    length: o.length,
                    wg: u,
                    tid: l,
                    arr: a
                });
            }
        });
    },
    pin: function(t) {
        for (var a = 0, e = t.length; a < e; a++) if (a < t.length - 1 && "undefined" !== t[a].index && "undefined" !== t[a + 1].index && t[a].index == t[a + 1].index) {
            for (var n in t[a]) -1 != n.indexOf("time") && (t[a][n] += "-" + t[a + 1][n]), -1 != n.indexOf("num") && (t[a][n] += "-" + t[a + 1][n]);
            t.splice(a + 1, 1), a--;
        }
    },
    yuyuw_xin: function(t) {
        var a = this, e = a.data.selectdoctime, n = t.target.dataset.index, i = "week" + n;
        for (var o in console.log(e, n, i), e[n]) {
            if (-1 != o.indexOf("time")) if (-1 != e[n][o].indexOf("-")) {
                if (-1 != o.indexOf("endtime")) var s = e[n][o].split("-");
                if (-1 != o.indexOf("startime")) var d = e[n][o].split("-");
            } else {
                if (-1 != o.indexOf("endtime")) (s = []).push(e[n][o]);
                if (-1 != o.indexOf("startime")) (d = []).push(e[n][o]);
            }
            if (-1 != o.indexOf("num")) if ("number" == typeof e[n][o] && (e[n][o] = String(e[n][o])), 
            -1 != e[n][o].indexOf("-")) var r = e[n][o].split("-"); else (r = []).push(e[n][o]);
        }
        for (var c = [], u = 0, l = s.length; u < l; u++) {
            var p = {};
            p.sjstr = d[u] + "-" + s[u], p.shen = r[u], p.cont = r[u], c[u] = p;
        }
        var f = a.data.selectdoctime, y = f[n].index, g = f[n].week, x = new Date(), h = x.getDate(), w = x.getMonth() + 1, m = x.getFullYear(), _ = x.getDay();
        0 == _ ? _ = 6 : _--, h += y - _;
        var v = new Date(m, w, 0).getDate();
        v < h && (w++, h = 1 + (h - v));
        w < 10 && (w = "0" + w), h < 10 && (h = "0" + h);
        var S = m + "-" + w + "-" + h;
        console.log(c), a.setData({
            star: c,
            dangqianriqi: S,
            week: g,
            indxWeek: i,
            indx: n
        });
        var T = t.target.dataset.id;
        app.util.request({
            url: "entry/wxapp/Select1",
            data: {
                tid: T
            },
            success: function(t) {
                a.setData({
                    yuyuebf: t.data.data
                });
            }
        }), this.setData({
            yuyue_status: !0
        });
    },
    choose_yy_time: function(a) {
        var s = this, d = s.data.arr, e = s.data.mygerzl, r = e.my_id, c = a.currentTarget.dataset.index, t = s.data.star, n = s.data.indx;
        console.log(t);
        t = s.data.selectdoctime;
        for (var i in t[n]) {
            if (-1 != i.indexOf("time")) if (-1 != t[n][i].indexOf("-")) {
                if (-1 != i.indexOf("endtime")) var o = t[n][i].split("-");
                if (-1 != i.indexOf("startime")) var u = t[n][i].split("-");
            } else {
                if (-1 != i.indexOf("endtime")) (o = []).push(t[n][i]);
                if (-1 != i.indexOf("startime")) (u = []).push(t[n][i]);
            }
            if (-1 != i.indexOf("num")) if ("number" == typeof t[n][i] && (t[n][i] = String(t[n][i])), 
            -1 != t[n][i].indexOf("-")) var l = t[n][i].split("-"); else (l = []).push(t[n][i]);
        }
        console.log(o);
        for (var p = [], f = 0, y = o.length; f < y; f++) {
            var g = {};
            g.sjstr = u[f] + "-" + o[f], g.shen = l[f], g.cont = l[f], p[f] = g;
        }
        var x = a.currentTarget.dataset.id, h = s.data.indxWeek, w = s.data.week, m = (s.data.yuyuebf, 
        a.currentTarget.dataset.xq), _ = a.currentTarget.dataset.name, v = s.data.zid, S = (a.currentTarget.dataset.data, 
        wx.getStorageSync("openid"));
        if (0 < p[c].shen) {
            v = s.data.zid, S = wx.getStorageSync("openid");
            var T = p[c].shen;
            console.log(p[c]);
            var q = s.data.dangqianriqi, k = p[c].sjstr, b = p[c].sjstr.split("-"), z = (o = b[1], 
            u = b[0], q + " " + k);
            w = s.data.week;
            app.util.request({
                url: "entry/wxapp/Myshifouyy",
                data: {
                    zy_openid: S,
                    zy_type: z,
                    zy_riqi: w
                },
                success: function(t) {
                    return !1 !== t.data.data ? (wx.showToast({
                        title: "您已预约",
                        icon: "success",
                        duration: 800
                    }), !1) : 0 == e ? (wx.showModal({
                        content: "请完善您的个人资料后再预约",
                        success: function(t) {
                            t.confirm && wx.navigateTo({
                                url: "../gerenxinxi/gerenxinxi"
                            });
                        }
                    }), !1) : void wx.showModal({
                        content: "确认预约吗？",
                        success: function(t) {
                            var i = a.currentTarget.dataset.data, o = wx.getStorageSync("openid");
                            t.confirm && app.util.request({
                                url: "entry/wxapp/Orderpay",
                                method: "GET",
                                data: {
                                    s_openid: o,
                                    s_ormoney: i
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
                                                    use_openid: o,
                                                    leixing: "挂号",
                                                    name: _,
                                                    pay: i,
                                                    zid: v
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
                                            });
                                            var a = Array.from(d[h]);
                                            for (var e in d[h][c]) -1 != e.indexOf("num") && (console.log(d[h][c]), d[h][c][e]--);
                                            var n = h;
                                            app.util.request({
                                                url: "entry/wxapp/Upweek",
                                                data: {
                                                    wekinfo: a,
                                                    xingqi: n,
                                                    tid: x
                                                },
                                                success: function(t) {
                                                    app.util.request({
                                                        url: "entry/wxapp/Myzhuanjiayy",
                                                        data: {
                                                            zy_money: i,
                                                            zy_name: r,
                                                            z_name: v,
                                                            zy_openid: o,
                                                            zy_type: z,
                                                            zy_riqi: w,
                                                            ksname: m,
                                                            syperson: T,
                                                            states: 1,
                                                            remove: 1,
                                                            paystate: 1
                                                        },
                                                        success: function(t) {
                                                            wx.showToast({
                                                                title: "预约成功",
                                                                success: function() {
                                                                    p[c].shen--, s.setData({
                                                                        star: p
                                                                    }), app.util.request({
                                                                        url: "entry/wxapp/PaysendSms",
                                                                        data: {
                                                                            my_id: r,
                                                                            zid: v
                                                                        },
                                                                        success: function(t) {},
                                                                        fail: function(t) {}
                                                                    }), setTimeout(function() {
                                                                        wx.navigateTo({
                                                                            url: "/hyb_yl/wodeyuyue/wodeyuyue"
                                                                        });
                                                                    }, 2e3);
                                                                }
                                                            }), app.util.request({
                                                                url: "entry/wxapp/PaysendSms",
                                                                data: {
                                                                    my_id: r,
                                                                    zid: v
                                                                },
                                                                success: function(t) {},
                                                                fail: function(t) {}
                                                            });
                                                        },
                                                        fail: function(t) {}
                                                    });
                                                }
                                            });
                                        },
                                        fail: function(t) {}
                                    });
                                }
                            });
                        }
                    });
                }
            });
        } else wx.showToast({
            title: "已约满"
        });
    },
    close_modal: function() {
        this.setData({
            yuyue_status: !1
        });
    },
    yiwenClick: function() {
        this.setData({
            overflow: !0
        });
    },
    hideClick: function() {
        this.setData({
            overflow: !1
        });
    },
    phoneClick: function(t) {
        var a = t.currentTarget.dataset.data;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    onReady: function() {
        this.getBase(), wx.hideNavigationBarLoading();
    },
    onShow: function(t) {
        var a = this, e = a.data.zid, n = setInterval(function() {
            a.renshu(e), wx.hideNavigationBarLoading();
        }, 1e3);
        a.setData({
            timer: n
        });
    },
    onHide: function() {
        var t = this.data.timer;
        clearInterval(t);
    },
    onUnload: function() {
        var t = this.data.timer;
        clearInterval(t);
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    preventTouchMove: function(t) {},
    onShareAppMessage: function() {},
    likeClick: function(t) {
        var a = this, e = t.currentTarget.dataset.id, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/CheckCollect",
            headers: {
                "Content-Type": "application/json"
            },
            data: {
                openid: n,
                goods_id: e,
                cerated_type: 0
            },
            success: function(t) {
                console.log(t), 2 == t.data ? (console.log("已关注"), app.util.request({
                    url: "entry/wxapp/SaveCollect",
                    cachetime: "0",
                    data: {
                        openid: n,
                        goods_id: e,
                        cerated_type: 0
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
                })) : 1 == t.data && (console.log("没有关注"), app.util.request({
                    url: "entry/wxapp/SaveCollect",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    cachetime: "0",
                    data: {
                        openid: n,
                        goods_id: e,
                        cerated_type: 0
                    },
                    dataType: "json",
                    success: function(t) {
                        wx.showToast({
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
    zixunClick: function() {
        wx.navigateTo({
            url: "hyb_yl/zhuanjiatiwen/zhuanjiatiwen"
        });
    },
    getBase: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                a.setData({
                    base: t.data.data
                }), WxParse.wxParse("article", "html", t.data.data.fwsite, a, 5);
            },
            fail: function(t) {}
        });
    }
});