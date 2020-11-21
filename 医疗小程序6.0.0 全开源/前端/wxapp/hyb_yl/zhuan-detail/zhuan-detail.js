Page({
    data: {
        weekArr: [ "周一", "周二", "周三", "周四", "周五", "周六", "周日" ],
        yuyueArr: [],
        amState: [ {
            state: "0"
        }, {
            state: "1"
        }, {
            state: "0"
        }, {
            state: "0"
        }, {
            state: "0"
        }, {
            state: "0"
        }, {
            state: "0"
        } ],
        pmState: [ {
            state: "0"
        }, {
            state: "2"
        }, {
            state: "1"
        }, {
            state: "2"
        }, {
            state: "2"
        }, {
            state: "2"
        }, {
            state: "2"
        } ],
        current: 0,
        wendaArr: [ {
            checked: !1,
            wenda: [ {
                id: 0,
                img: "../images/header_01.png",
                niming: "匿名用户",
                state: "已解答",
                con: "返几块大水井坊莱克斯顿解放路卡发链接为发胜利大街发狂了三解放路开始就流口水的解放路看电视",
                biaoqian: [ "辅导教师了", "范德萨", "213d" ],
                states: 1,
                imgArr: [ "../images/active_01.jpg", "../images/active_01.jpg", "../images/active_01.jpg", "../images/active_01.jpg", "../images/active_01.jpg", "../images/active_01.jpg", "../images/active_01.jpg", "../images/active_01.jpg" ]
            }, {
                id: 1,
                image: "../images/header_02.png",
                zhuan: "小猪佩奇",
                zhi: "主治医师",
                con1: "就得上来咖啡吉林省脸上法律手段放假了设计费雷克萨发了扣三分",
                time: "4天前"
            }, {
                id: 1,
                image: "../images/header_02.png",
                zhuan: "小猪佩奇",
                zhi: "主治医师",
                con1: "就得上来咖啡吉林省脸上法律手段放假了设计费雷克萨发了扣三分",
                time: "4天前"
            } ],
            lover: 0
        }, {
            checked: !0,
            wenda: [ {
                id: 0,
                img: "../images/header_01.png",
                niming: "匿名用户",
                state: "已解答",
                con: "返几块大水井坊莱克斯顿解放路卡发链接为发胜利大街发狂了三解放路开始就流口水的解放路看电视",
                biaoqian: [ "辅导教师了", "范德萨", "213d" ],
                states: 1,
                imgArr: [ "../images/active_01.jpg", "../images/active_01.jpg", "../images/active_01.jpg", "../images/active_01.jpg", "../images/active_01.jpg", "../images/active_01.jpg", "../images/active_01.jpg", "../images/active_01.jpg" ]
            }, {
                id: 1,
                image: "../images/header_02.png",
                zhuan: "小猪佩奇",
                zhi: "主治医师",
                con1: "就得上来咖啡吉林省脸上法律手段放假了设计费雷克萨发了扣三分",
                time: "4天前"
            }, {
                id: 1,
                image: "../images/header_02.png",
                zhuan: "小猪佩奇",
                zhi: "主治医师",
                con1: "就得上来咖啡吉林省脸上法律手段放假了设计费雷克萨发了扣三分",
                time: "4天前"
            } ],
            lover: 0
        } ],
        overflow: "",
        timeArr: [ {
            c: "false",
            c9: "false",
            time: "10:30-11:30"
        }, {
            c: "false",
            c9: "false",
            time: "10:30-11:30"
        }, {
            c: "false",
            c9: "false",
            time: "10:30-11:30"
        }, {
            c: "false",
            c9: "true",
            time: "10:30-11:30"
        } ],
        overFlow: "",
        id: 1,
        guan: !1,
        focus: !0,
        top: !1,
        moni: [ {
            id: 20,
            date: "2018-06-01",
            am: {
                wei: 1,
                zong: 2,
                time1: [ {
                    wei: 1,
                    zong: 3,
                    c: !1,
                    time: "09:30-10:30"
                }, {
                    wei: 0,
                    zong: 3,
                    c: !1,
                    time: "11:00-12:00"
                } ]
            },
            pm: {
                wei: 0,
                zong: 3,
                time1: [ {
                    wei: 1,
                    zong: 3,
                    c: !1,
                    time: "15:00-16:00"
                }, {
                    wei: 0,
                    zong: 3,
                    c: !1,
                    time: "16:30-17:30"
                } ]
            }
        }, {
            id: 20,
            date: "2018-06-10",
            am: {
                wei: 1,
                zong: 2,
                time1: [ {
                    wei: 1,
                    zong: 3,
                    c: !1,
                    time: "09:30-10:30"
                }, {
                    wei: 2,
                    zong: 3,
                    c: !1,
                    time: "11:00-12:00"
                } ]
            },
            pm: {
                wei: 1,
                zong: 3,
                time1: [ {
                    wei: 0,
                    zong: 3,
                    c: !1,
                    time: "15:00-16:00"
                }, {
                    wei: 1,
                    zong: 3,
                    c: !1,
                    time: "16:30-17:30"
                } ]
            }
        } ]
    },
    onLoad: function(e) {
        this.getDate();
    },
    a: function(e) {
        console.log(e);
    },
    zixunClick: function(e) {
        console.log(e);
        var a = e.currentTarget.dataset.tu;
        wx.navigateTo({
            url: "/pages/zixun/zixun?tu=" + a
        });
    },
    changeClick: function(e) {
        for (var a = e.detail.current, t = this, i = t.data.yuyueArr, n = t.data.moni, o = [], s = 0; s < n.length; s++) {
            var r = n[s].date.split("-"), m = r[1] + "-" + r[2];
            o.push(m);
        }
        for (var c = [], g = [], d = 0; d < i[a].length; d++) if (t.findTime(i[a][d], o)) {
            var l = {};
            (u = {}).state = 0, l.state = 0, u.am = n[t.findTime(i[a][d], o) - 1].am, l.pm = n[t.findTime(i[a][d], o) - 1].pm, 
            c.push(u), g.push(l);
        } else {
            var u;
            l = {};
            (u = {}).state = 2, l.state = 2, u.am = {}, l.pm = {}, u.am.time1 = [], l.pm.time1 = [], 
            c.push(u), g.push(l);
        }
        t.setData({
            current: a,
            amState: c,
            pmState: g
        });
    },
    getDate: function() {
        var e = this, a = Date.parse(new Date());
        a /= 1e3;
        for (var t = new Date(1e3 * a), i = t.getFullYear(), n = t.getMonth() + 1 < 10 ? "0" + (t.getMonth() + 1) : t.getMonth() + 1, o = t.getDate() < 10 ? "0" + t.getDate() : t.getDate(), s = new Date(i, n, 0).getDate(), r = new Date(i, n - 1, 0).getDate(), m = [], c = [], g = 1, d = o - t.getDay() + 1; d < o - t.getDay() + 15; d++) {
            var l = n + "-" + d;
            if (d <= 0) {
                g = r - d, (u = Math.floor(n) - 1) < 0 && (u = 12);
                l = "0" + u + "-" + g;
            } else if (s < d) {
                var u;
                12 < (u = Math.floor(n) + 1) && (u = 1);
                l = "0" + u + "-" + (10 <= g ? g : "0" + g);
                g++;
            }
            if (m.push(l), d < o) {
                c.push({
                    guoqi: 0
                });
            }
        }
        var h = e.data.yuyueArr, p = [], f = [];
        for (d = 0; d < 7; d++) p.push(m[d]);
        h.push(p);
        for (d = 7; d < 14; d++) f.push(m[d]);
        h.push(f), console.log(h);
        var v = e.data.moni;
        console.log(p), console.log(v);
        for (f = [], d = 0; d < v.length; d++) {
            var w = v[d].date.split("-"), D = w[1] + "-" + w[2];
            f.push(D);
        }
        console.log(p, f);
        for (var z = [], T = [], _ = 0; _ < h[0].length; _++) if (e.findTime(h[0][_], f)) {
            var S = {};
            (x = {}).state = 0, S.state = 0, x.am = v[e.findTime(h[0][_], f) - 1].am, S.pm = v[e.findTime(h[0][_], f) - 1].pm, 
            z.push(x), T.push(S);
        } else {
            var x;
            S = {};
            (x = {}).state = 2, S.state = 2, x.am = {}, S.pm = {}, x.am.time1 = [], S.pm.time1 = [], 
            z.push(x), T.push(S);
        }
        e.setData({
            yuyueArr: h,
            guoqiArr: c,
            amState: z,
            pmState: T
        });
    },
    yuClick: function(e) {
        var a = e.currentTarget.dataset.itemname, t = e.currentTarget.dataset.am;
        this.setData({
            overflow: "hidden",
            index1: a,
            am: t
        });
    },
    choose: function(e) {
        for (var a = this, t = e.currentTarget.dataset.index, i = a.data.index1, n = a.data.am, o = a.data.pmState, s = a.data.amState, r = 0; r < o.length; r++) for (var m = 0; m < o[r].pm.time1.length; m++) o[r].pm.time1[m].c = !1;
        for (var c = 0; c < s.length; c++) for (var g = 0; g < s[c].am.time1.length; g++) s[c].am.time1[g].c = !1;
        "am" == n ? 0 !== s[i].am.time1[t].wei ? 1 == s[i].am.time1[t].c ? s[i].am.time1[t].c = !1 : s[i].am.time1[t].c = !0 : wx.showToast({
            title: "该时间已预约满",
            icon: "none"
        }) : 0 !== o[i].pm.time1[t].wei ? 1 == o[i].pm.time1[t].c ? o[i].pm.time1[t].c = !1 : o[i].pm.time1[t].c = !0 : wx.showToast({
            title: "该时间已预约满",
            icon: "none"
        }), a.setData({
            amState: s,
            pmState: o
        });
    },
    hideClick1: function() {
        var e = this, a = e.data.am, t = e.data.index1;
        if (console.log(a, t), "am" == a) {
            for (var i = e.data.amState, n = 0; n < i[t].am.time1.length; n++) i[t].am.time1[n].c = !1;
            e.setData({
                amState: i,
                overflow: ""
            });
        } else {
            var o = e.data.pmState;
            for (n = 0; n < o[t].pm.time1.length; n++) o[t].pm.time1[n].c = !1;
            e.setData({
                pmState: o,
                overflow: ""
            });
        }
    },
    payClick: function() {
        var a = this, e = a.data.am, t = a.data.index1;
        if ("am" == e) for (var i = a.data.amState, n = 0; n < i[t].am.time1.length; n++) i[t].am.time1[n].c && wx.requestPayment({
            timeStamp: "",
            nonceStr: "",
            package: "",
            signType: "MD5",
            paySign: "",
            success: function(e) {
                wx.showToast({
                    title: "预约成功"
                }), a.setData({
                    overflow: ""
                });
            },
            fail: function(e) {}
        }); else {
            var o = a.data.pmState;
            for (n = 0; n < o[t].pm.time1.length; n++) o[t].pm.time1[n].c && wx.requestPayment({
                timeStamp: "",
                nonceStr: "",
                package: "",
                signType: "MD5",
                paySign: "",
                success: function(e) {
                    wx.showToast({
                        title: "预约成功"
                    }), a.setData({
                        overflow: ""
                    });
                },
                fail: function(e) {}
            });
        }
    },
    liaoClick: function() {
        wx.navigateTo({
            url: "/pages/zhuan_liao/zhuan_liao"
        });
    },
    tiwenClick: function(e) {
        console.log(e);
        var a = e.currentTarget.dataset.index;
        this.setData({
            overFlow1: "true",
            index: a,
            focus: !0
        });
    },
    hideClick: function() {
        this.setData({
            overFlow1: ""
        });
    },
    inputClick: function(e) {
        var a = e.detail.value;
        this.setData({
            value: a
        });
    },
    faClick: function() {
        var e = this, a = e.data.value, t = e.data.index;
        if (console.log(a, t), console.log("" === t), "" !== t) (o = {}).id = e.data.id, 
        o.image = "../images/header_0" + e.data.id + ".png", o.zhuan = "小猪佩奇", o.zhi = "主治医师", 
        o.con1 = a, o.time = "一天前", (i = e.data.wendaArr)[t].wenda.push(o), console.log(i); else if (0 == e.data.id) {
            (o = {}).id = e.data.id, o.image = "../images/header_0" + e.data.id + ".png", o.niming = "匿名用户", 
            o.state = "已解答", o.con = a, o.biaoqian = [ "辅导教师了", "范德萨", "213d" ];
            var i = e.data.wendaArr, n = {};
            (s = []).push(o), n.wenda = s, i.push(n), console.log(i);
        } else if (1 == e.data.id) {
            var o;
            (o = {}).id = e.data.id, o.image = "../images/header_0" + e.data.id + ".png", o.zhuan = "小猪佩奇", 
            o.zhi = "主治医师", o.con1 = a, o.biaoqian = [ "辅导教师了", "范德萨", "213d" ];
            var s;
            i = e.data.wendaArr, n = {};
            (s = []).push(o), n.wenda = s, i.push(n), console.log(i);
        }
        a = "";
        e.setData({
            wendaArr: i,
            value: a,
            overFlow1: ""
        });
    },
    zanClick: function(e) {
        var a = this.data.wendaArr;
        console.log(e);
        var t = e.currentTarget.dataset.index;
        a[t].checked = !a[t].checked, a[t].checked ? a[t].lover++ : a[t].lover--, this.setData({
            wendaArr: a
        });
    },
    guanClick: function() {
        var e = !this.data.guan;
        this.setData({
            guan: e
        });
    },
    findTime: function(e, a) {
        for (var t = 0; t < a.length; t++) if (e == a[t]) return t + 1;
    },
    preventTouchMove: function(e) {},
    retrunTopClick: function(e) {
        console.log(e);
        if (600 <= e.target.offsetTop) var a = !0; else a = !1;
        this.setData({
            top: a
        });
    },
    returnTop: function() {
        wx.pageScrollTo({
            scrollTop: 0,
            duration: 300
        });
        this.setData({
            top: !1
        });
    },
    yulan: function(e) {
        console.log(e);
        var a = e.target.dataset.index, t = e.currentTarget.dataset.idx, i = this.data.wendaArr;
        console.log(i);
        var n = i[t].wenda[0].imgArr[a], o = i[t].wenda[0].imgArr;
        wx.previewImage({
            current: n,
            urls: o
        });
    },
    yiwenClick: function() {
        this.setData({
            overflow4: !0
        });
    },
    hide1Click: function() {
        this.setData({
            overflow4: ""
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});