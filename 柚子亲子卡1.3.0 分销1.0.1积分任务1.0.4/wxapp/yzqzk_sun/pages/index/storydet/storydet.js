var app = getApp();

Page({
    data: {
        name: "",
        bgImg: "",
        styoyThumb: "",
        src: "",
        currentTime: 0,
        duration: 0,
        result: "00:00",
        times: "06:30",
        isCollect: !1,
        isOpen: !1,
        styorList: [],
        showModalStatus: !1,
        cur: 0,
        imgroot: wx.getStorageSync("imgroot")
    },
    onLoad: function(t) {
        var a = this, e = parseInt(t.index);
        console.log(t.src), a.setData({
            src: t.src,
            storyId: t.id,
            curIndex: e
        }), app.get_imgroot().then(function(t) {
            a.setData({
                imgroot: t
            });
        });
    },
    get_story_det: function() {
        var o = this;
        app.get_openid().then(function(e) {
            app.util.request({
                url: "entry/wxapp/getStory",
                cachetime: "0",
                data: {
                    id: o.data.storyId,
                    openid: e
                },
                success: function(t) {
                    var a = t.data;
                    console.log(a), app.util.request({
                        url: "entry/wxapp/getStoryList",
                        data: {
                            id: o.data.storyId,
                            openid: e
                        },
                        success: function(t) {
                            console.log(t.data), o.setData({
                                storydet: a,
                                collection: a.is_collect,
                                styorList: t.data
                            });
                        }
                    }), wx.setNavigationBarTitle({
                        title: t.data.title
                    });
                }
            });
        });
    },
    onShow: function() {
        var e = this;
        wx.setNavigationBarTitle({
            title: e.data.name
        });
        var t = wx.getStorageSync("setting");
        t ? wx.setNavigationBarColor({
            frontColor: t.fontcolor,
            backgroundColor: t.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        }), wx.getBackgroundAudioPlayerState({
            success: function(t) {
                if (1 == t.status && e.data.src == t.dataUrl) {
                    var a = wx.getBackgroundAudioManager();
                    console.log(a), a.onTimeUpdate(function() {
                        console.log(a.duration), e.formatSeconds(a.currentTime);
                        var t = 100 * a.currentTime;
                        e.setData({
                            duration: 100 * a.duration,
                            currentTime: t
                        });
                    }), e.setData({
                        isOpen: !0,
                        backgroundAudioManager: a
                    });
                }
            }
        }), e.get_story_det();
    },
    audio: function() {
        wx.seekBackgroundAudio({
            position: 30
        });
    },
    audioPlay: function() {
        var a = this, e = wx.getBackgroundAudioManager();
        console.log(a.data.currentTime), a.data.currentTime <= 0 || null == a.data.currentTime ? (e.title = a.data.storydet.title, 
        e.epname = "", e.singer = "", e.coverImgUrl = a.data.imgroot + "" + a.data.storydet.pic_bg, 
        e.src = a.data.src, console.log(a.data.src), e.onPlay(function() {
            a.setData({
                isOpen: !0
            });
        }), e.onCanplay(function() {}), e.onTimeUpdate(function() {
            console.log(e.duration), a.formatSeconds(e.currentTime);
            var t = 100 * e.currentTime;
            a.setData({
                duration: 100 * e.duration,
                currentTime: t
            });
        }), e.onPause(function() {
            a.setData({
                cur: e.currentTime,
                isOpen: !1
            });
        }), e.onEnded(function() {
            var t = a.data.curIndex;
            t == a.data.styorList.length - 1 ? t = 0 : t += 1, 1 == a.data.isOpen && a.audioStop(), 
            a.setData({
                curIndex: t,
                cur: 0
            }), a.changeAduio();
        })) : (a.setData({
            isOpen: !0
        }), e.play()), a.setData({
            backgroundAudioManager: e
        });
    },
    audioPause: function() {
        this.data.backgroundAudioManager.pause(), this.setData({
            isOpen: !1
        });
    },
    audioStop: function() {
        this.data.backgroundAudioManager.stop(), console.log("停止播放"), this.setData({
            isOpen: !1,
            currentTime: 0
        });
    },
    sliderChange: function(t) {
        this.data.backgroundAudioManager.seek(t.detail.value / 100);
    },
    audioPrev: function(t) {
        var a = this, e = a.data.curIndex;
        0 == e ? e = a.data.styorList.length - 1 : e -= 1, 1 == a.data.isOpen && a.audioStop(), 
        a.setData({
            curIndex: e,
            cur: 0
        }), a.changeAduio();
    },
    audioNext: function(t) {
        var a = this, e = a.data.curIndex;
        e == a.data.styorList.length - 1 ? e = 0 : e += 1, 1 == a.data.isOpen && a.audioStop(), 
        a.setData({
            curIndex: e,
            cur: 0
        }), a.changeAduio();
    },
    chooseAudio: function(t) {
        var a = this, e = t.currentTarget.dataset.index;
        a.audioStop(), a.setData({
            curIndex: e,
            cur: 0
        }), a.changeAduio(), a.util("close");
    },
    changeAduio: function() {
        var t = this, a = t.data.styorList, e = t.data.curIndex;
        console.log(e);
        var o = null != a[e].file_link && "" != a[e].file_link ? a[e].file_link : t.data.imgroot + a[e].file_path;
        wx.setNavigationBarTitle({
            title: a[e].title
        }), t.setData({
            storydet: a[e],
            src: o
        }), t.audioPlay();
    },
    Collection: function(t) {
        var a = this;
        app.get_openid().then(function(t) {
            app.util.request({
                url: "entry/wxapp/setStoryCollection",
                cachetime: "0",
                data: {
                    id: a.data.storyId,
                    openid: t
                },
                success: function(t) {
                    1 == a.data.collection ? a.setData({
                        collection: 0
                    }) : a.setData({
                        collection: 1
                    });
                }
            });
        });
    },
    formatSeconds: function(t) {
        var a = parseInt(t), e = 0, o = 0, n = "";
        function i(t) {
            return t < 10 ? "0" + t : t;
        }
        60 < a && (e = parseInt(a / 60), a = parseInt(a % 60), 60 < e && (o = parseInt(e / 60), 
        e = parseInt(e % 60))), n = i(parseInt(e)) + ":" + i(parseInt(a)), 0 < o && (n = parseInt(o) + ":" + n), 
        this.setData({
            result: n
        });
    },
    powerDrawer: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a);
    },
    util: function(t) {
        var a = wx.createAnimation({
            duration: 200,
            timingFunction: "linear",
            delay: 0
        });
        (this.animation = a).opacity(0).height(0).step(), this.setData({
            animationData: a.export()
        }), setTimeout(function() {
            a.opacity(1).height(300).step(), this.setData({
                animationData: a
            }), "close" == t && this.setData({
                showModalStatus: !1
            });
        }.bind(this), 200), "open" == t && this.setData({
            showModalStatus: !0
        });
    }
});