function t(t) {
    var e = getApp();
    "" != t.detail.userInfo && null != t.detail.userInfo && (e.util.getUserInfo(function(t) {
        var o = {};
        "" != t.wxInfo && null != t.wxInfo ? (o = t.wxInfo).op = "userinfo" : o.op = "userinfo", 
        "" != e.share && null != e.share && (o.share = e.share), e.util.request({
            url: "entry/wxapp/index",
            showLoading: !1,
            data: o,
            success: function(t) {
                var o = t.data;
                "" != o.data && (e.userinfo = o.data);
            }
        });
    }, t.detail), console.log(t));
}

function e(t) {
    var e = wx.getStorageSync("userInfo") || {};
    "" != e.wxInfo && null != e.wxInfo || t.setData({
        shadow: !0,
        get_userinfo: !0,
        menu: !1
    });
}

function o() {
    this.setData({
        shadow: !1,
        get_userinfo: !1,
        manage: !1
    });
}

function n(t) {
    r = setInterval(function() {
        s.audio_status || (clearInterval(r), t.setData({
            audio_status: !1
        }));
    }, 1e3);
}

function a() {
    var t = getCurrentPages();
    return t[t.length - 1].route;
}

var r, s = getApp();

module.exports = {
    config: function(n) {
        var a = [ {
            pagePath: "/xc_train/pages/index/index",
            text: "主页",
            iconPath: "/xc_train/resource/bottom01.png",
            selectedIconPath: "/xc_train/resource/bottom001.png",
            status: 1
        }, {
            pagePath: "/xc_train/pages/active/list",
            text: "优惠活动",
            iconPath: "/xc_train/resource/bottom02.png",
            selectedIconPath: "/xc_train/resource/bottom002.png",
            status: 1
        }, {
            pagePath: "/xc_train/pages/video/video",
            text: "视频",
            iconPath: "/xc_train/resource/bottom04.png",
            selectedIconPath: "/xc_train/resource/bottom004.png",
            status: 1
        }, {
            pagePath: "/xc_train/pages/user/user",
            text: "我的",
            iconPath: "/xc_train/resource/bottom03.png",
            selectedIconPath: "/xc_train/resource/bottom003.png",
            status: 1
        }, {
            pagePath: "",
            text: "",
            iconPath: "",
            selectedIconPath: "",
            status: -1
        } ], r = "";
        if ("" != s.config && null != s.config && (wx.setNavigationBarTitle({
            title: s.config.content.title
        }), "" != (r = s.config.content).footer && null != r.footer)) for (i = 0; i < r.footer.length; i++) "" != r.footer[i].text && null != r.footer[i].text && (a[i].text = r.footer[i].text), 
        "" != r.footer[i].icon && null != r.footer[i].icon && (a[i].iconPath = r.footer[i].icon), 
        "" != r.footer[i].select && null != r.footer[i].select && (a[i].selectedIconPath = r.footer[i].select), 
        "" != r.footer[i].link && null != r.footer[i].link && (a[i].pagePath = r.footer[i].link), 
        "" != r.footer[i].status && null != r.footer[i].status && (a[i].status = r.footer[i].status);
        for (var i = 0; i < a.length; i++) n.data.pagePath == a[i].pagePath && n.setData({
            footerCurr: i + 1
        });
        n.updateUserInfo = t, e(n), n.user_close = o, n.setData({
            footer: a,
            config: r,
            system_mobile: s.mobile
        });
    },
    theme: function(t) {
        var e = {
            name: "theme1",
            color: "#5fcceb",
            icon: [ "/xc_train/resource/icon01.png", "/xc_train/resource/class01.png", "/xc_train/resource/class02.png", "/xc_train/resource/class03.png", "/xc_train/resource/contact01.png", "/xc_train/resource/contact02.png", "/xc_train/resource/contact03.png", "/xc_train/resource/contact04.png", "/xc_train/resource/manage01.png" ]
        };
        if ("" != s.theme && null != s.theme) {
            var o = s.theme.content;
            if (2 == o.theme && (e.name = "theme" + o.theme, e.color = o.color, "" != o.icon && null != o.icon)) {
                for (var n = 0; n < o.icon.length; n++) "" != o.icon[n] && null != o.icon[n] && (e.icon[n] = o.icon[n]);
                wx.setNavigationBarColor({
                    frontColor: "#ffffff",
                    backgroundColor: e.color,
                    animation: {
                        duration: 400,
                        timingFunc: "easeIn"
                    }
                });
            }
        }
        t.setData({
            theme: e
        });
    },
    login: function(t, e) {
        s.util.getUserInfo(function(t) {
            var e = {};
            "" != t.wxInfo && null != t.wxInfo ? (e = t.wxInfo).op = "userinfo" : e.op = "userinfo", 
            "" != s.share && null != s.share && (e.share = s.share), s.util.request({
                url: "entry/wxapp/index",
                showLoading: !1,
                data: e,
                success: function(t) {
                    var e = t.data;
                    "" != e.data && (s.userinfo = e.data);
                }
            });
        });
    },
    updateUserInfo: t,
    is_user: e,
    user_close: o,
    audio_end: function(t) {
        var e = a();
        clearInterval(r), "xc_train/pages/audio/audio" != e && "xc_train/pages/audio/detail" != e && "" != s.innerAudioContext.src && null != s.innerAudioContext.src && "" != s.audio_Id && null != s.audio_Id ? (t.setData({
            audio_status: s.audio_status,
            audio_on: s.audio_on
        }), n(t)) : (s.audio_status = !1, t.setData({
            audio_status: !1
        }));
    },
    formCheck: function(t, e, o) {
        for (var n in t) for (var a = 0; a < e.length; a++) if (n == e[a].name) {
            if (e[a].required && ("" == t[n] || null == t[n])) return wx.showModal({
                title: "提示",
                content: e[a].required_msg
            }), !1;
            if (e[a].tel && !/^[1][0-9]{10}$/.test(t[n])) return wx.showModal({
                title: "提示",
                content: e[a].tel_msg
            }), !1;
            if (e[a].gt && parseFloat(t[n]) < parseFloat(e[a].gt)) return wx.showModal({
                title: "提示",
                content: e[a].gt_msg
            }), !1;
            if (e[a].lt && parseFloat(t[n]) > parseFloat(e[a].lt)) return wx.showModal({
                title: "提示",
                content: e[a].lt_msg
            }), !1;
        }
        return !0;
    }
};