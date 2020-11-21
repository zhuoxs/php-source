var app = getApp(), WxParse = require("../wxParse/wxParse.js");

Page({
    data: {
        id: "",
        shouqi: !1,
        shanchang: !1,
        guanzhu: !0,
        yuyue_status: !1,
        toastHidden3: !0,
        toastHidden4: !1
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
        var a = t.currentTarget.dataset.id, e = t.currentTarget.dataset.data, n = t.currentTarget.dataset.day, o = t.currentTarget.dataset.massige;
        console.log(t), wx.navigateTo({
            url: "/hyb_yl/zhuanjiayuyue/zhuanjiayuyue?id=" + a + "&date=" + e + "&day=" + n + "&ksname=" + o
        });
    },
    onLoad: function(t) {
        var n = this, a = t.id, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Zhuanjiaxiangqing",
            data: {
                id: a
            },
            success: function(t) {
                console.log(t), n.setData({
                    xiangqing: t.data.data
                }), WxParse.wxParse("article", "html", t.data.data.z_content, n, 5);
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
                goods_id: a
            },
            success: function(t) {
                2 == t.data ? (console.log("已经关注"), n.setData({
                    toastHidden3: !0,
                    toastHidden4: !1,
                    toastHidden31: !0,
                    toastHidden41: !1
                })) : 1 == t.data && (console.log("关注"), n.setData({
                    toastHidden3: !1,
                    toastHidden4: !0,
                    toastHidden31: !1,
                    toastHidden41: !0
                }));
            }
        }), app.util.request({
            url: "entry/wxapp/Question",
            data: {
                pid: a
            },
            success: function(t) {
                console.log(t.data.data), n.setData({
                    pinfo: t.data.data
                }), WxParse.wxParse("article", "html", t.data.data.z_content, n, 5);
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/Zhuanpaib",
            data: {
                pp_id: a,
                openid: e
            },
            success: function(t) {
                n.setData({
                    zhuanpaib: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/Selectdoctime",
            data: {
                zid: a
            },
            success: function(t) {
                var a = t.data.data;
                if (0 !== a.length) {
                    a[0].morth.split("-");
                    var u = [], c = function(t, a) {
                        return t.setDate(t.getDate() + a), t;
                    };
                    !function(t) {
                        var a, e, n, o, s, i = t.getDay() - 1;
                        t = c(t, -1 * i), new Date(t);
                        for (var d = 0; d < 7; d++) u.push((a = 0 == d ? t : c(t, 1), s = void 0, e = a.getFullYear() + "年", 
                        n = 9 < a.getMonth() + 1 ? a.getMonth() + 1 : "0" + (a.getMonth() + 1), o = 9 < a.getDate() ? a.getDate() : "0" + a.getDate(), 
                        (s = {}).month = e + "-" + n + "-月" + o + "日", s.day = n + "-" + o, s));
                    }(new Date());
                    a[0].newweek;
                    for (var e = 0; e < a.length; e++) a[e].morth = u[e].month, a[e].day = u[e].day;
                    console.log(a), n.setData({
                        selectdoctime: a,
                        length: t.data.data.length
                    });
                }
            }
        });
        e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Myinforsarray",
            data: {
                openid: e
            },
            success: function(t) {
                n.setData({
                    mygerzl: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), n.setData({
            zid: a
        });
    },
    yuyuw_xin: function(t) {
        var c = this, a = t.target.dataset.id, e = t.target.dataset.index, r = c.data.selectdoctime[e].morth;
        app.util.request({
            url: "entry/wxapp/Select1",
            data: {
                tid: a
            },
            success: function(t) {
                if (console.log(t.data.data), "0" == t.data.data.check1) return wx.showToast({
                    title: "当前医生休息中"
                }), !1;
                for (var a = t.data.data, e = a.star_time, n = a.end_time, o = a.shengyunus, s = a.nums, i = [], d = 0; d < e.length; d++) {
                    var u = {};
                    u.sjstr = e[d] + "-" + n[d], u.cont = s[d], u.shen = o[d], i.push(u);
                }
                console.log(i), c.setData({
                    time: t.data.data.time,
                    week: t.data.data.week,
                    star: i,
                    dangqianriqi: r,
                    yuyuebf: t.data.data
                });
            }
        }), this.setData({
            yuyue_status: !0
        });
    },
    choose_yy_time: function(n) {
        var o = this, a = o.data.mygerzl, s = a.my_id, i = n.currentTarget.dataset.index, d = o.data.star, u = n.currentTarget.dataset.id;
        d[i].shen--;
        var c = o.data.zid, t = o.data.yuyuebf;
        t.shengyunus[i]--;
        var r = t.shengyunus[i], e = wx.getStorageSync("openid"), l = d[i].sjstr, p = o.data.dangqianriqi + " " + l, y = o.data.week, g = n.currentTarget.dataset.xq;
        app.util.request({
            url: "entry/wxapp/Myshifouyy",
            data: {
                zy_openid: e,
                zy_type: p,
                zy_riqi: y
            },
            success: function(t) {
                return !1 !== t.data.data ? (wx.showToast({
                    title: "您已预约",
                    icon: "success",
                    duration: 800
                }), !1) : 0 == a ? (wx.showModal({
                    content: "请完善您的个人资料后再预约",
                    success: function(t) {
                        t.confirm && wx.navigateTo({
                            url: "../gerenxinxi/gerenxinxi"
                        });
                    }
                }), !1) : void wx.showModal({
                    content: "确认预约吗？",
                    success: function(t) {
                        var a = n.currentTarget.dataset.data, e = wx.getStorageSync("openid");
                        t.confirm && app.util.request({
                            url: "entry/wxapp/Orderpay",
                            method: "GET",
                            data: {
                                s_openid: e,
                                s_ormoney: a
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
                                            url: "entry/wxapp/Myzhuanjiayy",
                                            data: {
                                                zy_money: a,
                                                zy_name: s,
                                                z_name: c,
                                                zy_openid: e,
                                                zy_type: p,
                                                zy_riqi: y,
                                                ksname: g,
                                                states: 1,
                                                remove: 1,
                                                paystate: 1
                                            },
                                            success: function(t) {
                                                app.util.request({
                                                    url: "entry/wxapp/Upweek",
                                                    data: {
                                                        index: i,
                                                        syrs: r,
                                                        tid: u
                                                    },
                                                    success: function(t) {
                                                        wx.showToast({
                                                            title: "预约成功",
                                                            success: function() {
                                                                app.util.request({
                                                                    url: "entry/wxapp/PaysendSms",
                                                                    data: {
                                                                        my_id: s,
                                                                        zid: c
                                                                    },
                                                                    success: function(t) {
                                                                        console.log(t);
                                                                    },
                                                                    fail: function(t) {
                                                                        console.log(t);
                                                                    }
                                                                }), setTimeout(function() {
                                                                    wx.navigateTo({
                                                                        url: "/hyb_yl/wodeyuyue/wodeyuyue"
                                                                    });
                                                                }, 2e3);
                                                            }
                                                        }), o.setData({
                                                            star: d
                                                        }), app.util.request({
                                                            url: "entry/wxapp/PaysendSms",
                                                            data: {
                                                                my_id: s,
                                                                zid: c
                                                            },
                                                            success: function(t) {
                                                                console.log(t);
                                                            },
                                                            fail: function(t) {
                                                                console.log(t);
                                                            }
                                                        });
                                                    }
                                                });
                                            },
                                            fail: function(t) {
                                                console.log(t);
                                            }
                                        });
                                    },
                                    fail: function(t) {
                                        console.log(t);
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    close_modal: function() {
        this.setData({
            yuyue_status: !1
        });
    },
    onReady: function() {},
    onShow: function(t) {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    likeClick: function(t) {
        var a = this, e = t.currentTarget.dataset.id;
        console.log(t.currentTarget.dataset.id);
        var n = wx.getStorageSync("openid");
        console.log(e, n), app.util.request({
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
                        console.log(t), wx.showToast({
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
    }
});