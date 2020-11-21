var a = new getApp(), t = a.siteInfo.uniacid;

Page({
    data: {
        SystemInfo: a.globalData.sysData,
        isIphoneX: a.globalData.isIphoneX,
        playState: !0,
        LiveIndex: 0,
        farmlands: [],
        liveData: [],
        liveType: [],
        recommendData: [],
        scrollLeft: 0,
        farmSetData: [],
        height: 0,
        tarbar: wx.getStorageSync("kundianFarmTarbar"),
        is_tarbar: !1,
        is_loading: !0,
        src_xy: []
    },
    onLoad: function(t) {
        var e = this, i = t.user_uid, n = wx.getStorageSync("kundian_farm_uid");
        a.loginBindParent(i, n);
        var r = !1;
        t.is_tarbar && (r = t.is_tarbar), e.setData({
            farmSetData: wx.getStorageSync("kundian_farm_setData"),
            tarbar: wx.getStorageSync("kundianFarmTarbar"),
            is_tarbar: r
        }), e.videoContext = wx.createVideoContext("myVideo", this);
        var s = a.siteInfo.uniacid;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "live",
                op: "getLiveData",
                uniacid: s
            },
            success: function(a) {
                var t = new Array();
                if (a.data.liveData) {
                    var i = (t = a.data.liveData[0]).src, n = [];
                    i && (n = i.split(":"));
                }
                e.setData({
                    farmland: a.data.liveData,
                    liveType: a.data.liveType,
                    LiveIndex: 0,
                    recommendData: t,
                    src_xy: n
                });
            }
        }), a.util.setNavColor(s), wx.getSystemInfo({
            success: function(a) {
                var t = void 0, i = a.windowWidth;
                t = a.windowHeight - i / 750 * 215 - 225, e.setData({
                    height: t
                });
            }
        });
    },
    changTab: function(e) {
        var i = this, n = e.currentTarget.dataset, r = n.index, s = n.typename;
        i.data.liveType;
        a.util.request({
            url: "entry/wxapp/class",
            data: {
                control: "live",
                op: "getLiveTypeData",
                uniacid: t,
                type_id: r
            },
            success: function(a) {
                i.data.liveType.map(function(a, t) {
                    a.name === s && (t <= 1 ? i.setData({
                        scrollLeft: 0
                    }) : t > 1 && t <= i.data.liveType.length - 2 && i.setData({
                        scrollLeft: 100 * (t - 1)
                    }));
                });
                var t = new Array();
                if (a.data.liveData) {
                    var e = (t = a.data.liveData[0]).src, n = [];
                    e && (n = e.split(":"));
                }
                i.setData({
                    farmland: a.data.liveData,
                    LiveIndex: r,
                    recommendData: t,
                    src_xy: n
                });
            }
        });
    },
    chooseLive: function(a) {
        var t = this, e = a.currentTarget.dataset.id;
        console.log(e);
        var i = t.data.recommendData;
        console.log(i);
        var n = void 0;
        if (t.setData({
            playState: !t.data.playState
        }), i.id == e) t.data.playState ? (t.videoContext.pause(), t.setData({
            playState: !1
        })) : (t.videoContext.play(), t.setData({
            playState: !0
        })); else {
            for (var r = t.data.farmland, s = 0; s < r.length; s++) e == r[s].id && (n = r[s]);
            var o = n.src, d = [];
            o && (d = o.split(":")), t.setData({
                recommendData: n,
                is_loading: !0,
                src_xy: d,
                playState: !0
            });
        }
    },
    statechange: function(a) {},
    play: function(a) {
        this.setData({
            playState: !0,
            is_loading: !1
        });
    },
    pause: function(a) {
        this.setData({
            playState: !1
        });
    },
    bindwaiting: function(a) {
        wx.showToast({
            title: "连接成功",
            icon: "loading"
        }), this.setData({
            is_loading: !1
        });
    },
    onShareAppMessage: function() {
        var a = wx.getStorageSync("kundian_farm_uid"), t = "/kundian_farm/pages/HomePage/live/index";
        return a && (t = "/kundian_farm/pages/HomePage/live/index?user_uid=" + a), {
            path: t,
            success: function(a) {},
            title: "实时监控"
        };
    }
});