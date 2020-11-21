var look = {
    navbar: function(e) {
        var t = getApp().globalData.theme;
        console.log(t), null != t && 2 == t.theme_type && "" != t.navbar_bg && null != t.navbar_bg && null != t.navbar_bg && wx.setNavigationBarColor({
            frontColor: t.navbar_color,
            backgroundColor: t.navbar_bg,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        });
    },
    no: function(e, t) {
        var a = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 1500;
        wx.showToast({
            title: e,
            icon: "none",
            duration: a,
            image: "../../images/close.png",
            success: function() {
                "function" == typeof t && setTimeout(t, a);
            }
        });
    },
    alert: function(e) {
        wx.showToast({
            title: e,
            icon: "none"
        });
    },
    istrue: function(e) {
        return "" != e && null != e && "undefined" != e;
    },
    back: function(e) {
        wx.navigateBack({
            delta: e
        });
    },
    ok: function(e, t) {
        var a = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 1500;
        wx.showToast({
            title: e,
            duration: a,
            success: function() {
                "function" == typeof t && setTimeout(t, a);
            }
        });
    },
    change_date: function(e) {
        return e.replace(/\-/g, "/");
    },
    getuserinfo: function(a, n) {
        var r = getApp();
        if ("getUserInfo:ok" != a.detail.errMsg) return r.getUserInfo = !1, void n.setData({
            getUserInfo: !1
        });
        r.util.getUserInfo(function(t) {
            if ("getUserInfo:ok" === a.detail.errMsg) {
                r.getUserInfo = !1, look.accredit(n);
                var e = r.globalData.userInfo;
                t = t.wxInfo;
                null != e && e.avatarurl == t.avatarUrl && e.gender == t.gender && e.nickname == t.nickName || r.util.request({
                    url: "entry/wxapp/index",
                    showLoading: !1,
                    data: {
                        op: "changeuser",
                        nickname: t.nickName,
                        gender: t.gender,
                        avatar: t.avatarUrl
                    },
                    success: function(e) {
                        null == r.globalData.userInfo ? r.globalData.userInfo = {
                            niakname: t.nickName,
                            gender: t.gender,
                            avatarurl: t.avatarUrl
                        } : (r.globalData.userInfo.nickname = t.nickName, r.globalData.userInfo.gender = t.gender, 
                        r.globalData.userInfo.avatarurl = t.avatarUrl);
                    }
                });
            }
        }, a.detail);
    },
    footer: function(e) {
        var t = getApp(), a = wx.getStorageSync("cars") || [];
        a && (t.tabBar.number = a.length), t.util.footer(e);
    },
    group_footer: function(e) {
        var t = e, a = getApp().group_tabBar;
        for (var n in a.list) a.list[n].pageUrl = a.list[n].pagePath.replace(/(\?|#)[^"]*/g, "");
        t.setData({
            tabBar: a,
            "tabBar.thisurl": t.__route__
        });
    },
    sport_footer: function(e) {
        var t = e, a = getApp().sport_tabBar;
        for (var n in a.list) a.list[n].pageUrl = a.list[n].pagePath.replace(/(\?|#)[^"]*/g, "");
        t.setData({
            tabBar: a,
            "tabBar.thisurl": t.__route__
        });
    },
    accredit: function(e) {
        var t = getApp(), a = e;
        null == t.accredit && (t.accredit = []), t.accredit.force = t.globalData.webset.force, 
        a.setData({
            getUserInfo: t.getUserInfo,
            accredit: t.accredit
        });
    },
    txvideo: function() {
        var t = requirePlugin("tencentvideo").getTxvContext("txv1");
        t.play(), t.pause(), t.requestFullScreen(), t.exitFullScreen(), t.playbackRate(+e.currentTarget.dataset.rate);
    },
    count_express: function(o, i, l, s) {
        var a = {}, e = getCurrentPages();
        e && (a = e[getCurrentPages().length - 1]), a.data.isexpress = !0;
        var u = 0, t = getApp();
        o = t.globalData.express;
        if (1 != t.globalData.webset.express || null == o) return u;
        s = s.split(" ");
        var c = !0;
        if ("" != o.notarea && null != o.notarea && "undefined" != o.notarea && c) {
            var n = o.notarea;
            for (var r in n) {
                if (!c) return;
                s[0] == r && n[r].forEach(function(e, t) {
                    if (e == s[1]) return a.setData({
                        isexpress: !1
                    }), void (c = !1);
                });
            }
        }
        c && "" != o.setting && null != o.setting && "undefined" != o.setting && o.setting.forEach(function(r, e) {
            if (c && "" != r.citys) {
                var t = r.citys;
                for (var a in t) {
                    if (!c) return;
                    a == s[0] && t[a].forEach(function(e, t) {
                        if (e == s[1]) {
                            var a = o.calculatetype, n = r.value;
                            return "weight" == a && (l <= n.firstweight && (u = parseFloat(n.firstprice)), l > n.firstweight && (u = parseFloat(n.firstprice) + Math.ceil((l - n.firstweight) / n.secondweight) * n.secondprice)), 
                            "number" == a && (i <= n.firstnum && (u = parseFloat(n.firstnumprice)), i > n.firstnum && (u = parseFloat(n.firstnumprice) + Math.ceil((i - n.firstnum) / n.secondnum) * n.secondnumprice)), 
                            void (c = !1);
                        }
                    });
                }
            }
        });
        if (c && "" != o.default && null != o.default && "undefined" != o.default) {
            var f = o.default, d = o.calculatetype;
            "weight" == d && (l <= f.default_firstweight && (u = parseFloat(f.default_firstprice)), 
            l > f.default_firstweight && (u = parseFloat(f.default_firstprice) + Math.ceil((l - f.default_firstweight) / f.default_secondweight) * f.default_secondprice)), 
            "number" == d && (i <= f.default_firstnum && (u = parseFloat(f.default_firstnumprice)), 
            i > f.default_firstnum && (u = parseFloat(f.default_firstnumprice) + (i - f.default_firstnum) / f.default_secondnum * f.default_secondnumprice));
        }
        return u.toFixed(2);
    },
    updata: function(e) {
        console.log(e);
        var r = [];
        if (!look.istrue(e)) return console.info("look.updata:参数为空"), r;
        var o = getApp(), i = new o.util.date();
        return e.forEach(function(e, t) {
            var a = e.substring(e.lastIndexOf("."), e.length), n = "images/" + o.siteInfo.uniacid + "/" + i.dateToStr("yyyy") + i.dateToStr("/MM/") + o.util.md5("xc_xinguwu" + i.dateToLong(new Date()) + Math.random().toString(36).substr(2)) + a;
            r.push(n);
        }), e.forEach(function(e, t) {
            wx.uploadFile({
                url: o.siteInfo.siteroot + "?i=" + o.siteInfo.uniacid + "&c=entry&do=upload&m=xc_xinguwu",
                filePath: e,
                name: "file",
                formData: {
                    filename: r[t]
                },
                success: function(e) {}
            });
        }), r;
    },
    updataone: function(e, t) {
        t || (t = 1);
        var a = "images/" + app.siteInfo.uniacid + "/" + date.dateToStr("yyyy") + date.dateToStr("/MM/") + app.util.md5("xc_xinguwu" + date.dateToLong(new Date()) + Math.random().toString(36).substr(2) + t) + type;
        return wx.uploadFile({
            url: app.siteInfo.siteroot + "?i=" + app.siteInfo.uniacid + "&c=entry&do=upload&m=xc_xinguwu",
            filePath: e,
            name: "file",
            formData: {
                filename: a
            },
            success: function(e) {}
        }), a;
    },
    floatIcon: function(e, t) {
        null == e.data.hiddenFloat && e.setData({
            hiddenFloat: !1
        }), null == e.scrollTop || (e.scrollTop > t.scrollTop && 1 == e.data.hiddenFloat ? e.setData({
            hiddenFloat: !1
        }) : e.scrollTop < t.scrollTop && 0 == e.data.hiddenFloat && e.setData({
            hiddenFloat: !0
        })), e.scrollTop = t.scrollTop;
    },
    goHome: function(t) {
        var a = getApp();
        console.log(a.systeminfo), null == a.goHome && (a.goHome = {
            left: 620,
            top: 750 / parseInt(a.systeminfo.screenWidth) * parseInt(a.systeminfo.screenHeight) - 360
        }), t.setData({
            goHome: a.goHome
        }), t.moveGoHome = function(e) {
            t.setData({
                "goHome.left": 750 / parseInt(a.systeminfo.screenWidth) * parseInt(e.touches[0].clientX),
                "goHome.top": 750 / parseInt(a.systeminfo.screenWidth) * parseInt(e.touches[0].clientY)
            });
        };
    }
};

module.exports = look;