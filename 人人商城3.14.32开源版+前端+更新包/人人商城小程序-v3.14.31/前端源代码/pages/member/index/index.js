var e = getApp(), t = e.requirejs("core"), a = e.requirejs("wxParse/wxParse"), i = e.requirejs("biz/diypage"), s = e.requirejs("jquery");

Page({
    data: {
        route: "member",
        icons: e.requirejs("icons"),
        member: {},
        diypages: {},
        audios: {},
        audiosObj: {},
        modelShow: !1,
        autoplay: !0,
        interval: 5e3,
        duration: 500,
        swiperheight: 0,
        iscycelbuy: !1,
        bargain: !1,
        result: {}
    },
    onLoad: function(t) {
        e.checkAuth(), this.setData({
            options: t
        });
    },
    getInfo: function() {
        var e = this;
        t.get("member", {}, function(t) {
            1 == t.isblack && wx.showModal({
                title: "无法访问",
                content: "您在商城的黑名单中，无权访问！",
                success: function(t) {
                    t.confirm && e.close(), t.cancel && e.close();
                }
            }), 0 != t.error ? wx.redirectTo({
                url: "/pages/message/auth/index"
            }) : e.setData({
                member: t,
                show: !0,
                customer: t.customer,
                customercolor: t.customercolor,
                phone: t.phone,
                phonecolor: t.phonecolor,
                phonenumber: t.phonenumber,
                iscycelbuy: t.iscycelbuy,
                bargain: t.bargain
            }), a.wxParse("wxParseData", "html", t.copyright, e, "5");
        });
    },
    onShow: function() {
        e.checkAuth();
        var t = this;
        this.getInfo(), wx.getSystemInfo({
            success: function(e) {
                var a = e.windowWidth / 1.7;
                t.setData({
                    windowWidth: e.windowWidth,
                    windowHeight: e.windowHeight,
                    swiperheight: a
                });
            }
        }), t.setData({
            imgUrl: e.globalData.approot
        }), i.get(this, "member", function(e) {});
    },
    onShareAppMessage: function() {
        return t.onShareAppMessage();
    },
    imagesHeight: function(e) {
        var t = e.detail.width, a = e.detail.height, i = e.target.dataset.type, s = this;
        wx.getSystemInfo({
            success: function(e) {
                s.data.result[i] = e.windowWidth / t * a, (!s.data[i] || s.data[i] && result[i] < s.data[i]) && s.setData({
                    result: s.data.result
                });
            }
        });
    },
    cancelclick: function() {
        wx.switchTab({
            url: "/pages/index/index"
        });
    },
    confirmclick: function() {
        wx.openSetting({
            success: function(e) {}
        });
    },
    phone: function() {
        var e = this.data.phonenumber + "";
        wx.makePhoneCall({
            phoneNumber: e
        });
    },
    play: function(e) {
        var t = e.target.dataset.id, a = this.data.audiosObj[t] || !1;
        if (!a) {
            a = wx.createInnerAudioContext("audio_" + t);
            var i = this.data.audiosObj;
            i[t] = a, this.setData({
                audiosObj: i
            });
        }
        var s = this;
        a.onPlay(function() {
            var e = setInterval(function() {
                var i = a.currentTime / a.duration * 100 + "%", r = Math.floor(Math.ceil(a.currentTime) / 60), n = (Math.ceil(a.currentTime) % 60 / 100).toFixed(2).slice(-2), o = Math.ceil(a.currentTime);
                r < 10 && (r = "0" + r);
                var u = r + ":" + n, c = s.data.audios;
                c[t].audiowidth = i, c[t].Time = e, c[t].audiotime = u, c[t].seconds = o, s.setData({
                    audios: c
                });
            }, 1e3);
        });
        var r = e.currentTarget.dataset.audio, n = e.currentTarget.dataset.time, o = e.currentTarget.dataset.pausestop, u = e.currentTarget.dataset.loopplay;
        0 == u && a.onEnded(function(e) {
            c[t].status = !1, s.setData({
                audios: c
            });
        });
        var c = s.data.audios;
        c[t] || (c[t] = {}), a.paused && 0 == n ? (a.src = r, a.play(), 1 == u && (a.loop = !0), 
        c[t].status = !0, s.pauseOther(t)) : a.paused && n > 0 ? (a.play(), 0 == o ? a.seek(n) : a.seek(0), 
        c[t].status = !0, s.pauseOther(t)) : (a.pause(), c[t].status = !1), s.setData({
            audios: c
        });
    },
    pauseOther: function(e) {
        var t = this;
        s.each(this.data.audiosObj, function(a, i) {
            if (a != e) {
                i.pause();
                var s = t.data.audios;
                s[a] && (s[a].status = !1, t.setData({
                    audios: s
                }));
            }
        });
    },
    onHide: function() {
        this.pauseOther();
    },
    onUnload: function() {
        this.pauseOther();
    },
    navigate: function(e) {
        var t = e.currentTarget.dataset.url, a = e.currentTarget.dataset.phone, i = e.currentTarget.dataset.appid, s = e.currentTarget.dataset.appurl;
        t && wx.navigateTo({
            url: t,
            fail: function() {
                wx.switchTab({
                    url: t
                });
            }
        }), a && wx.makePhoneCall({
            phoneNumber: a
        }), i && wx.navigateToMiniProgram({
            appId: i,
            path: s
        });
    },
    close: function() {
        e.globalDataClose.flag = !0, wx.reLaunch({
            url: "/pages/index/index"
        });
    }
});