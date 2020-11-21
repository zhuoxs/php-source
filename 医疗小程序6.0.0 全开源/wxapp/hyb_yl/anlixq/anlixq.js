var app = getApp(), WxParse = require("../wxParse/wxParse.js");

Page({
    data: {
        src: "/yiliao/images/budong.mp3",
        poster: "/wedding/images/poster.png",
        zname: "你根本不懂",
        author: "季彦霖",
        zan: !1,
        hide: !0,
        pinglun: [],
        shishi: "",
        shishijin: 0,
        aa: 0,
        speed: 0,
        miao2: 0,
        play: !0
    },
    pause: function() {
        this.audio = wx.createAudioContext("myAudio"), this.audio.pause(), this.setData({
            play: !1
        });
    },
    play: function() {
        this.audio = wx.createAudioContext("myAudio"), this.audio.play(), this.setData({
            play: !0
        });
    },
    funtimeupdate: function(a) {
        var t = this, i = parseInt(a.detail.currentTime), e = t.data.aa, n = parseInt(t.data.shishijin);
        ++e < 10 && (e = "0" + e), 59 < e && (e = 0, n++), (0 == n || n < 10) && (n = "0" + n);
        var o = parseInt(a.detail.duration), s = parseInt(o / 60), u = parseFloat(o % 60), d = parseInt(100), l = i * parseFloat(d / o);
        setTimeout(function() {
            t.setData({
                shishi: s,
                shishijin: n,
                miao2: u,
                speed: l,
                aa: e
            });
        }, 1e3);
    },
    liuyan: function() {
        this.setData({
            hide: !1
        });
    },
    hide: function(a) {
        this.setData({
            hide: !0
        });
    },
    show: function() {
        this.setData({
            hide: !1
        });
    },
    formSubmit: function(a) {
        var t = this, i = this.data.pinglun, e = {}, n = (a.detail.value.liuyan, a.detail.value.liuyan), o = a.detail.value.kc_id, s = wx.getStorageSync("openid");
        if ("" == a.detail.value.liuyan) wx.showModal({
            title: "内容不能为空",
            content: ""
        }); else {
            var u = new Date(), d = u.getFullYear(), l = u.getMonth(), c = d + "-" + ++l + "-" + u.getDate();
            t.data.userInfo.nickName, t.data.userInfo.avatarUrl;
            e.zan = !0, e.m_img = t.data.userInfo.avatarUrl, e.name = t.data.userInfo.nickName, 
            e.m_comment = a.detail.value.liuyan, e.m_time = c, i.push(e), this.setData({
                hide: !0,
                pinglun: i
            }), app.util.request({
                url: "entry/wxapp/Roomcomentarray",
                data: {
                    name: t.data.userInfo.nickName,
                    m_img: t.data.userInfo.avatarUrl,
                    m_comment: n,
                    kc_id: o,
                    m_openid: s,
                    m_type: 3
                },
                success: function(a) {
                    console.log(a);
                },
                fail: function(a) {
                    console.log(a);
                }
            }), console.log(this.data.pinglun);
        }
    },
    zan: function() {
        0 == this.data.zan ? wx.showLoading({
            title: "谢谢点赞"
        }) : wx.showLoading({
            title: "已取消点赞"
        }), setTimeout(function() {
            wx.hideLoading();
        }, 800), this.setData({
            zan: !this.data.zan
        });
    },
    plzan: function(a) {
        var t = this.data.pinglun, i = a.currentTarget.dataset.index, e = t[i].zan;
        1 == e ? (wx.showLoading({
            title: "谢谢点赞"
        }), setTimeout(function() {
            wx.hideLoading();
        }, 800), e = !1) : (wx.showLoading({
            title: "已取消点赞"
        }), setTimeout(function() {
            wx.hideLoading();
        }, 800), e = !0), t[i].zan = e, this.setData({
            pinglun: t
        });
    },
    onLoad: function(a) {
        var i = this, t = (a.id, a.hz_id);
        app.util.request({
            url: "entry/wxapp/Hzxq",
            data: {
                hz_id: t
            },
            success: function(a) {
                console.log(a), i.setData({
                    hzxq: a.data.data
                }), WxParse.wxParse("articles", "html", a.data.data.hz_count, i, 5);
            },
            fail: function(a) {
                console.log(a);
            }
        }), wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(a) {
                        var t = a.userInfo;
                        i.setData({
                            userInfo: t
                        });
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Allcoments",
            data: {
                hz_id: t
            },
            cachetime: "0",
            success: function(a) {
                console.log(a), i.setData({
                    pinglun: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        });
    },
    onReady: function() {
        this.audio = wx.createAudioContext("myAudio"), this.audio.play();
    },
    dianji: function() {
        console.log(this.audio.seek);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: this.data.title
        };
    }
});