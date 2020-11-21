var app = getApp(), WxParse = require("../wxParse/wxParse.js");

Page({
    data: {
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
    funtimeupdate: function(t) {
        var a = this, e = parseInt(t.detail.currentTime), n = a.data.aa, i = parseInt(a.data.shishijin);
        ++n < 10 && (n = "0" + n), 59 < n && (n = 0, i++), (0 == i || i < 10) && (i = "0" + i);
        var o = parseInt(t.detail.duration), s = parseInt(o / 60), d = parseFloat(o % 60), u = parseInt(100), l = e * parseFloat(u / o);
        setTimeout(function() {
            a.setData({
                shishi: s,
                shishijin: i,
                miao2: d,
                speed: l,
                aa: n
            });
        }, 1e3);
    },
    liuyan: function() {
        this.setData({
            hide: !1
        });
    },
    hide: function(t) {
        this.setData({
            hide: !0
        });
    },
    show: function() {
        this.setData({
            hide: !1
        });
    },
    formSubmit: function(t) {
        var a = this, e = this.data.pinglun;
        console.log(e);
        var n = {}, i = (t.detail.value.liuyan, t.detail.value.liuyan), o = t.detail.value.id, s = wx.getStorageSync("openid");
        if ("" == t.detail.value.liuyan) wx.showModal({
            title: "内容不能为空",
            content: ""
        }); else {
            var d = new Date(), u = d.getFullYear(), l = d.getMonth(), r = u + "-" + ++l + "-" + d.getDate(), c = (a.data.userInfo.nickName, 
            a.data.zan);
            a.data.userInfo.avatarUrl;
            n.zan = c, n.m_img = a.data.userInfo.avatarUrl, n.name = a.data.userInfo.nickName, 
            n.m_comment = t.detail.value.liuyan, n.m_time = r, e.push(n), this.setData({
                hide: !0,
                pinglun: e
            }), app.util.request({
                url: "entry/wxapp/Roomcomentarray",
                data: {
                    name: a.data.userInfo.nickName,
                    m_img: a.data.userInfo.avatarUrl,
                    m_comment: i,
                    kc_id: o,
                    m_openid: s,
                    m_type: 2
                },
                success: function(t) {},
                fail: function(t) {
                    console.log(t);
                }
            }), console.log(this.data.pinglun);
        }
    },
    zan: function(t) {
        var a = t.currentTarget.dataset.id, e = wx.getStorageSync("openid"), n = parseInt(this.data.zan);
        0 == this.data.toastHidden3 ? (n += 1, app.util.request({
            url: "entry/wxapp/SaveCollect",
            headers: {
                "Content-Type": "application/json"
            },
            data: {
                openid: e,
                goods_id: a,
                cerated_type: 3
            },
            dataType: "json",
            success: function(t) {
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
                goods_id: a,
                cerated_type: 3
            },
            dataType: "json",
            success: function(t) {
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
    onLoad: function(t) {
        var e = this, a = t.title;
        e.setData({
            title: a
        }), wx.setNavigationBarTitle({
            title: a
        });
        var n = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: n
        });
        var i = wx.getStorageSync("openid");
        e = this;
        var o = t.id;
        t.hz_id, t.m_id;
        wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(t) {
                        var a = t.userInfo;
                        e.setData({
                            userInfo: a
                        });
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Scurl",
            success: function(t) {
                e.setData({
                    dataurl: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/Allzicoment",
            data: {
                id: o
            },
            cachetime: "0",
            success: function(t) {
                e.setData({
                    pinglun: t.data.data
                });
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
                openid: i,
                goods_id: o
            },
            success: function(t) {
                2 == t.data ? e.setData({
                    toastHidden3: !0
                }) : 1 == t.data && e.setData({
                    toastHidden3: !1
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Allzzan",
            headers: {
                "Content-Type": "application/json"
            },
            data: {
                openid: i,
                goods_id: o
            },
            success: function(t) {
                e.setData({
                    zan: t.data.data
                });
            }
        }), e.setData({
            id: o,
            toDate: function(t) {
                var a = new Date(1e3 * t);
                return a.getFullYear() + "/" + (a.getMonth() + 1 < 10 ? "0" + (a.getMonth() + 1) : a.getMonth() + 1) + "/" + (a.getDate() < 10 ? "0" + a.getDate() : a.getDate());
            }
        });
    },
    plzan: function(t) {
        var a = this, e = a.data.pinglun, n = t.currentTarget.dataset.index;
        app.util.request({
            url: "entry/wxapp/Zengpldianz",
            data: {
                openid: wx.getStorageSync("openid"),
                m_id: t.currentTarget.dataset.id
            },
            success: function(t) {
                console.log(t), 1 == t.data ? e[n].dianz-- : e[n].dianz++, a.setData({
                    pinglun: e
                });
            }
        });
    },
    onReady: function() {
        this.getAllathud(), this.getAllzan();
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
    },
    getAllzan: function() {
        var a = this, t = a.data.id, e = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Allpzan",
            headers: {
                "Content-Type": "application/json"
            },
            data: {
                openid: e,
                goods_id: t
            },
            success: function(t) {
                a.setData({
                    zzan: t.data.data
                });
            }
        });
    },
    getAllathud: function() {
        var a = this, t = a.data.id, e = a.data.toDate;
        app.util.request({
            url: "entry/wxapp/Xiangq",
            data: {
                id: t
            },
            success: function(t) {
                console.log(t), a.setData({
                    xiangq: t.data.data,
                    time: e(t.data.data.time),
                    mp3: t.data.data.mp3
                }), console.log(t.data.data.mp3), WxParse.wxParse("article", "html", t.data.data.content, a, 5);
            },
            fail: function(t) {
                console.log(t);
            }
        });
    }
});