var app = getApp(), WxParse = require("../wxParse/wxParse.js");

Page({
    data: {
        src: "/yiliao/images/budong.mp3",
        poster: "/wedding/images/poster.png",
        zname: "你根本不懂",
        author: "季彦霖",
        hide: !0,
        pinglun: [],
        shishi: "",
        shishijin: 0,
        aa: 0,
        speed: 0,
        miao2: 0,
        play: !0,
        toastHidden3: !1,
        toastHidden4: !1
    },
    wxParseTagATap: function(a) {
        console.log(a);
        var t = a.currentTarget.dataset.src;
        wx.navigateTo({
            url: "../webview/webview?src=" + t
        });
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
        var t = this, e = parseInt(a.detail.currentTime), n = t.data.aa, i = parseInt(t.data.shishijin);
        ++n < 10 && (n = "0" + n), 59 < n && (n = 0, i++), (0 == i || i < 10) && (i = "0" + i);
        var o = parseInt(a.detail.duration), s = parseInt(o / 60), u = parseFloat(o % 60), d = parseInt(100), r = e * parseFloat(d / o);
        setTimeout(function() {
            t.setData({
                shishi: s,
                shishijin: i,
                miao2: u,
                speed: r,
                aa: n
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
        var t = this, e = this.data.pinglun, n = {}, i = (a.detail.value.liuyan, a.detail.value.liuyan), o = a.detail.value.kc_id, s = wx.getStorageSync("openid");
        if ("" == a.detail.value.liuyan) wx.showModal({
            title: "内容不能为空",
            content: ""
        }); else {
            var u = new Date(), d = u.getFullYear(), r = u.getMonth(), l = d + "-" + ++r + "-" + u.getDate(), c = (t.data.userInfo.nickName, 
            t.data.zan);
            console.log(c);
            t.data.userInfo.avatarUrl;
            n.zan = c, n.m_img = t.data.userInfo.avatarUrl, n.name = t.data.userInfo.nickName, 
            n.m_comment = a.detail.value.liuyan, n.m_time = l, e.push(n), this.setData({
                hide: !0,
                pinglun: e
            }), app.util.request({
                url: "entry/wxapp/Roomcomentarray",
                data: {
                    name: t.data.userInfo.nickName,
                    m_img: t.data.userInfo.avatarUrl,
                    m_comment: i,
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
    zan: function(a) {
        var t = a.currentTarget.dataset.id;
        console.log(a);
        var e = wx.getStorageSync("openid"), n = parseInt(this.data.zan);
        0 == this.data.toastHidden3 ? (n += 1, app.util.request({
            url: "entry/wxapp/SaveCollect",
            headers: {
                "Content-Type": "application/json"
            },
            data: {
                openid: e,
                goods_id: t,
                cerated_type: 2
            },
            dataType: "json",
            success: function(a) {
                wx.showToast({
                    title: "谢谢点赞",
                    icon: "success",
                    duration: 1500
                });
            }
        }), this.setData({
            toastHidden3: !0,
            zan: n
        })) : (n -= 1, console.log("给个赞呗"), app.util.request({
            url: "entry/wxapp/SaveCollect",
            cachetime: "0",
            data: {
                openid: e,
                goods_id: t,
                cerated_type: 2
            },
            dataType: "json",
            success: function(a) {
                wx.showToast({
                    title: "给个赞呗",
                    icon: "success",
                    duration: 1500
                });
            }
        }), this.setData({
            toastHidden3: !1,
            zan: n
        }));
    },
    plzan: function(a) {
        var t = this, e = t.data.pinglun, n = a.currentTarget.dataset.index;
        app.util.request({
            url: "entry/wxapp/Zengpldianz",
            data: {
                openid: wx.getStorageSync("openid"),
                m_id: a.currentTarget.dataset.id
            },
            success: function(a) {
                console.log(a), 1 == a.data ? e[n].dianz-- : e[n].dianz++, t.setData({
                    pinglun: e
                });
            }
        });
    },
    onLoad: function(a) {
        var t = a.title, e = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: e
        });
        var n = this, i = (a.id, a.hz_id), o = wx.getStorageSync("openid");
        console.log(i), app.util.request({
            url: "entry/wxapp/Hzxq",
            data: {
                hz_id: i
            },
            success: function(a) {
                n.setData({
                    hzxq: a.data.data,
                    mp3: a.data.data.hz_mp3
                }), WxParse.wxParse("articles", "html", a.data.data.hz_count, n, 5);
            },
            fail: function(a) {
                console.log(a);
            }
        }), wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(a) {
                        var t = a.userInfo;
                        n.setData({
                            userInfo: t
                        });
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Allhzzan",
            headers: {
                "Content-Type": "application/json"
            },
            data: {
                openid: o,
                goods_id: i
            },
            success: function(a) {
                n.setData({
                    zan: a.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Scurl",
            success: function(a) {
                n.setData({
                    dataurl: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        }), app.util.request({
            url: "entry/wxapp/Allcoments",
            data: {
                hz_id: i
            },
            cachetime: "0",
            success: function(a) {
                console.log(a), n.setData({
                    pinglun: a.data.data
                });
            },
            fail: function(a) {
                console.log(a);
            }
        }), wx.setNavigationBarTitle({
            title: t
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