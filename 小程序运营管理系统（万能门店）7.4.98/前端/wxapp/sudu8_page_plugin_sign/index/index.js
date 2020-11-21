var choose_year = null, choose_month = null, app = getApp();

Page({
    data: {
        bg: "",
        userinfo: "",
        hasEmptyGrid: !1,
        showPicker: !1,
        jilu: "",
        isview: 0,
        page_signs: "/sudu8_page_plugin_sign/index/index",
        tongj: ""
    },
    onPullDownRefresh: function() {
        var t = this;
        t.data.id;
        t.checkvip(), t.getsign(), wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var a = this;
        wx.setNavigationBarTitle({
            title: "积分签到"
        });
        var e = 0;
        t.fxsid && (e = t.fxsid, a.setData({
            fxsid: t.fxsid
        })), a.checkvip(), a.getsign();
        var s = new Date(), n = s.getFullYear(), i = s.getMonth() + 1;
        this.calculateEmptyGrids(n, i), this.calculateDays(n, i), this.setData({
            cur_year: n,
            cur_month: i,
            weeks_ch: [ "日", "一", "二", "三", "四", "五", "六" ]
        });
        var r = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: r,
            data: {
                vs1: 1
            },
            success: function(t) {
                t.data.data;
                a.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: a.data.baseinfo.base_tcolor,
                    backgroundColor: a.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(a.getinfos, e);
    },
    redirectto: function(t) {
        var a = t.currentTarget.dataset.link, e = t.currentTarget.dataset.linktype;
        app.util.redirectto(a, e);
    },
    checkvip: function() {
        var a = this, t = wx.getStorageSync("openid");
        wx.request({
            url: app.util.url("entry/wxapp/checkvip", {
                m: "sudu8_page"
            }),
            data: {
                kwd: "sign",
                openid: t
            },
            success: function(t) {
                t.data.data || (a.setData({
                    needvip: !0
                }), wx.showModal({
                    title: "进入失败",
                    content: "使用本功能需先开通vip!",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.redirectTo({
                            url: "/sudu8_page/register/register"
                        });
                    }
                }));
            },
            fail: function(t) {}
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
    getThisMonthDays: function(t, a) {
        return new Date(t, a, 0).getDate();
    },
    getFirstDayOfWeek: function(t, a) {
        return new Date(Date.UTC(t, a - 1, 1)).getDay();
    },
    calculateEmptyGrids: function(t, a) {
        var e = this.getFirstDayOfWeek(t, a), s = [];
        if (0 < e) {
            for (var n = 0; n < e; n++) s.push(n);
            this.setData({
                hasEmptyGrid: !0,
                empytGrids: s
            });
        } else this.setData({
            hasEmptyGrid: !1,
            empytGrids: []
        });
    },
    calculateDays: function(t, a) {
        var e = this, s = (this.getThisMonthDays(t, a), wx.getStorageSync("openid"));
        app.util.request({
            url: "entry/wxapp/Mysign",
            data: {
                openid: s,
                year: t,
                month: a
            },
            success: function(t) {
                var a = t.data.data;
                e.setData({
                    days: a
                });
            }
        });
    },
    handleCalendar: function(t) {
        var a = t.currentTarget.dataset.handle, e = this.data.cur_year, s = this.data.cur_month;
        if ("prev" === a) {
            var n = s - 1, i = e;
            n < 1 && (i = e - 1, n = 12), this.calculateDays(i, n), this.calculateEmptyGrids(i, n), 
            this.setData({
                cur_year: i,
                cur_month: n
            });
        } else {
            var r = s + 1, o = e;
            12 < r && (o = e + 1, r = 1), this.calculateDays(o, r), this.calculateEmptyGrids(o, r), 
            this.setData({
                cur_year: o,
                cur_month: r
            });
        }
    },
    tapDayItem: function(t) {
        var a = t.currentTarget.dataset.idx, e = this.data.days;
        e[a].choosed = !e[a].choosed, this.setData({
            days: e
        });
    },
    chooseYearAndMonth: function() {
        for (var t = this.data.cur_year, a = this.data.cur_month, e = [], s = [], n = 1900; n <= 2100; n++) e.push(n);
        for (var i = 1; i <= 12; i++) s.push(i);
        var r = e.indexOf(t), o = s.indexOf(a);
        this.setData({
            picker_value: [ r, o ],
            picker_year: e,
            picker_month: s,
            showPicker: !0
        });
    },
    pickerChange: function(t) {
        var a = t.detail.value;
        choose_year = this.data.picker_year[a[0]], choose_month = this.data.picker_month[a[1]];
    },
    tapPickerBtn: function(t) {
        var a = {
            showPicker: !1
        };
        "confirm" === t.currentTarget.dataset.type && (a.cur_year = choose_year, a.cur_month = choose_month, 
        this.calculateEmptyGrids(choose_year, choose_month), this.calculateDays(choose_year, choose_month)), 
        this.setData(a);
    },
    getsign: function() {
        var e = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Mysign",
            data: {
                openid: t
            },
            success: function(t) {
                var a = t.data.data;
                e.setData({
                    days: a
                });
            }
        }), wx.request({
            url: app.util.url("entry/wxapp/globaluserinfo", {
                m: "sudu8_page"
            }),
            data: {
                openid: t
            },
            success: function(t) {
                var a = t.data.data;
                a.nickname && a.avatar || e.setData({
                    isview: 1
                }), e.setData({
                    userinfo: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Mysignjl",
            data: {
                openid: t
            },
            success: function(t) {
                var a = t.data.data;
                e.setData({
                    jilu: a
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Mysigntj",
            data: {
                openid: t
            },
            success: function(t) {
                var a = t.data.data;
                e.setData({
                    tongj: a
                });
            }
        }), wx.stopPullDownRefresh();
    },
    onShareAppMessage: function() {
        return {
            title: "积分签到"
        };
    },
    huoqusq: function() {
        var c = this, u = wx.getStorageSync("openid");
        wx.getUserInfo({
            success: function(t) {
                var a = t.userInfo, e = a.nickName, s = a.avatarUrl, n = a.gender, i = a.province, r = a.city, o = a.country;
                app.util.request({
                    url: "entry/wxapp/Useupdate",
                    data: {
                        openid: u,
                        nickname: e,
                        avatarUrl: s,
                        gender: n,
                        province: i,
                        city: r,
                        country: o
                    },
                    header: {
                        "content-type": "application/json"
                    },
                    success: function(t) {
                        wx.setStorageSync("golobeuid", t.data.data.id), wx.setStorageSync("golobeuser", t.data.data), 
                        c.setData({
                            isview: 0,
                            globaluser: t.data.data
                        }), c.getsign();
                    }
                });
            },
            fail: function() {
                app.util.selfinfoget(c.chenggfh);
            }
        });
    },
    qiandao: function() {
        var t = wx.getStorageSync("openid");
        t ? app.util.request({
            url: "entry/wxapp/Qiandao",
            data: {
                openid: t
            },
            success: function(t) {
                1 == t.data.data ? wx.showModal({
                    title: "提醒",
                    content: "您今天已经签过到了！",
                    showCancel: !1
                }) : wx.showModal({
                    title: "提醒",
                    content: "签到成功！",
                    showCancel: !1,
                    success: function(t) {
                        wx.redirectTo({
                            url: "/sudu8_page_plugin_sign/index/index"
                        });
                    }
                });
            }
        }) : wx.showModal({
            title: "签到失败",
            content: "请先授权登录再签到",
            showCancel: !1,
            success: function(t) {
                wx.redirectTo({
                    url: "/sudu8_page_plugin_sign/index/index"
                });
            }
        });
    }
});