var app = getApp(), WxParse = require("../wxParse/wxParse.js");

Page({
    data: {
        src: "/hyb_yl/images/budong.mp3",
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
        var a = this, e = parseInt(t.detail.currentTime), n = a.data.aa, o = parseInt(a.data.shishijin);
        ++n < 10 && (n = "0" + n), 59 < n && (n = 0, o++), (0 == o || o < 10) && (o = "0" + o);
        var i = parseInt(t.detail.duration), s = parseInt(i / 60), d = parseFloat(i % 60), l = parseInt(100), u = e * parseFloat(l / i);
        setTimeout(function() {
            a.setData({
                shishi: s,
                shishijin: o,
                miao2: d,
                speed: u,
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
        var n = {}, o = (t.detail.value.liuyan, t.detail.value.liuyan), i = t.detail.value.id, s = wx.getStorageSync("openid");
        if ("" == t.detail.value.liuyan) wx.showModal({
            title: "内容不能为空",
            content: ""
        }); else {
            var d = new Date(), l = d.getFullYear(), u = d.getMonth(), c = l + "-" + ++u + "-" + d.getDate(), r = (a.data.userInfo.nickName, 
            a.data.zan);
            console.log(r);
            a.data.userInfo.avatarUrl;
            n.zan = r, n.m_img = a.data.userInfo.avatarUrl, n.name = a.data.userInfo.nickName, 
            n.m_comment = t.detail.value.liuyan, n.m_time = c, e.push(n), console.log(i, o, t.detail.value.liuyan, t), 
            this.setData({
                hide: !0,
                pinglun: e
            }), app.util.request({
                url: "entry/wxapp/Roomcomentarray",
                data: {
                    name: a.data.userInfo.nickName,
                    m_img: a.data.userInfo.avatarUrl,
                    m_comment: o,
                    kc_id: i,
                    m_openid: s,
                    m_type: 2
                },
                success: function(t) {
                    console.log(t);
                },
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
                console.log(t), wx.showToast({
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
    plzan: function(t) {
        var a = t.currentTarget.dataset.id, e = wx.getStorageSync("openid"), n = parseInt(this.data.zan);
        0 == this.data.toastHidden4 ? (n += 1, app.util.request({
            url: "entry/wxapp/SaveCollect",
            headers: {
                "Content-Type": "application/json"
            },
            data: {
                openid: e,
                goods_id: a,
                cerated_type: 4
            },
            dataType: "json",
            success: function(t) {
                console.log(t), wx.showToast({
                    title: "谢谢点赞",
                    icon: "success",
                    duration: 1500
                });
            }
        }), this.setData({
            toastHidden4: !0,
            zan: n
        })) : (n -= 1, console.log("给个赞呗"), app.util.request({
            url: "entry/wxapp/SaveCollect",
            cachetime: "0",
            data: {
                openid: e,
                goods_id: a,
                cerated_type: 4
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
            toastHidden4: !1,
            zan: n
        }));
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("openid");
        function e(t) {
            var a = new Date(1e3 * t);
            return a.getFullYear() + "/" + ((a.getMonth() + 1 < 10 ? "0" + (a.getMonth() + 1) : a.getMonth() + 1) + "/") + (a.getDate() < 10 ? "0" + a.getDate() : a.getDate());
        }
        var n = this, o = t.id, i = (t.hz_id, t.m_id);
        console.log(i, t), app.util.request({
            url: "entry/wxapp/Xiangq",
            data: {
                id: o
            },
            success: function(t) {
                console.log(t), n.setData({
                    xiangq: t.data.data,
                    time: e(t.data.data.time)
                }), console.log(e(t.data.data.time)), WxParse.wxParse("article", "html", t.data.data.content, n, 5);
            },
            fail: function(t) {
                console.log(t);
            }
        }), wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(t) {
                        var a = t.userInfo;
                        n.setData({
                            userInfo: a
                        });
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Allzicoment",
            data: {
                id: o
            },
            cachetime: "0",
            success: function(t) {
                console.log(t), n.setData({
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
                openid: a,
                goods_id: o
            },
            success: function(t) {
                2 == t.data ? (console.log("已点赞"), n.setData({
                    toastHidden3: !0
                })) : 1 == t.data && (console.log("未点赞"), n.setData({
                    toastHidden3: !1
                }));
            }
        }), app.util.request({
            url: "entry/wxapp/Allzzan",
            headers: {
                "Content-Type": "application/json"
            },
            data: {
                openid: a,
                goods_id: o
            },
            success: function(t) {
                console.log(t.data.data), n.setData({
                    zan: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Allpzan",
            headers: {
                "Content-Type": "application/json"
            },
            data: {
                openid: a,
                goods_id: o
            },
            success: function(t) {
                console.log(t.data.data), n.setData({
                    zzan: t.data.data
                });
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