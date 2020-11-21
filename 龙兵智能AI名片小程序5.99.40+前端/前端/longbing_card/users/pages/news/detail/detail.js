var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var timer, app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        openType: "getUserInfo",
        isStaffAdd: !1,
        globalData: {},
        detailData: []
    },
    onLoad: function(t) {
        var u = this;
        console.log(t, "options"), wx.showShareMenu({
            withShareTicket: !0
        }), _xx_util2.default.showLoading();
        var a = t.id, e = t.status, i = t.shareimg, o = t.name, r = t.src, n = t.fromshare, l = t.to_uid, d = t.from_id, s = t.nickName, g = t.companyName, c = {
            id: a,
            status: e,
            shareimg: i,
            name: o,
            src: r,
            fromshare: n,
            to_uid: l,
            from_id: d,
            nickName: s,
            companyName: g
        };
        o && wx.setNavigationBarTitle({
            title: o
        }), l && (getApp().globalData.to_uid = l);
        var f = wx.getStorageSync("userid");
        getApp().getConfigInfo(!0).then(function() {
            var t = getApp().globalData, a = t.isIphoneX, e = t.logoImg, i = t.configInfo, o = t.auth, r = o.authStatus, n = o.authPhoneStatus, d = i.config.preview_switch;
            u.setData({
                curr_user_id: f,
                paramData: c,
                authStatus: r,
                authPhoneStatus: n,
                isIphoneX: a,
                logoImg: e,
                preview_switch: d,
                copyright: i.config
            }, function() {
                if ("toPlayVideo" == c.status) {
                    var t = u.data.paramData, a = t.to_uid, e = t.id, i = getApp().globalData.loginParam.scene, o = getApp().siteInfo.uniacid;
                    a != f && (getApp().getCardAfter(), _index.baseModel.getReport({
                        to_uid: a,
                        sign: "view",
                        type: 8,
                        target: e,
                        scene: i,
                        uniacid: o
                    }), _xx_util2.default.hideAll());
                } else l != f && getApp().getCardAfter(), c.to_uid && u.getCardIndexData();
                u.getAuthInfoSuc(), u.getDetailData();
            });
        }), t.from_id && 3 == t.type && c.to_uid != f && 1044 == app.globalData.loginParam.scene && (timer = setInterval(function() {
            app.globalData.encryptedData && u.toGetShareInfo();
        }, 1e3)), _xx_util2.default.hideAll();
    },
    onUnload: function() {
        clearInterval(timer);
    },
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), this.getAuthInfoSuc(), this.getDetailData();
    },
    onShareAppMessage: function(t) {
        var a = this, e = a.data.paramData, i = e.id, o = e.status, r = e.to_uid, n = e.name, d = e.companyName, u = wx.getStorageSync("userid");
        if (r || (r = u), r != u && a.toForwardRecord(), "toPlayVideo" == o) {
            var l = a.data.detailData.cover, s = "/longbing_card/users/pages/news/detail/detail?to_uid=" + r + "&from_id=" + u + "&id=" + i + "&status=toPlayVideo&name=" + n + "&fromshare=true";
            return console.log(s), {
                title: n,
                path: s,
                imageUrl: l[0]
            };
        }
        var g = "/longbing_card/users/pages/news/detail/detail?to_uid=" + r + "&from_id=" + u + "&id=" + i + "&fromshare=true&type=3";
        return d && (g = g + "&companyName=" + d), console.log(g), {
            title: a.data.detailData.title,
            path: g,
            imageUrl: ""
        };
    },
    getAuthInfoSuc: function(t) {
        console.log(t, "getAuthInfoSuc");
        var a = this.data, e = a.openType, i = a.paramData.to_uid, o = getApp().getCurUserInfo(i, e);
        this.setData(o);
    },
    getCardIndexData: function() {
        var l = this, t = l.data.paramData.to_uid;
        _index.userModel.getCardShow({
            to_uid: t
        }).then(function(t) {
            if (_xx_util2.default.hideAll(), 0 == t.errno) {
                console.log("getCardShow==>", t.data);
                var a = t.data, e = a.to_uid, i = a.info, o = i.name, r = i.avatar, n = i.job_name, d = i.is_staff;
                getApp().globalData.to_uid = e, getApp().globalData.nickName = o, getApp().globalData.avatarUrl = r, 
                getApp().globalData.job_name = n;
                var u = 1 == d;
                l.setData({
                    cardIndexData: a,
                    isStaffAdd: u
                });
            }
        });
    },
    getDetailData: function() {
        var s = this, t = s.data.paramData, a = t.id, e = t.to_uid;
        _index.userModel.getTimeLineDetail({
            id: a,
            to_uid: e || 0
        }).then(function(t) {
            var a = t.data, e = a.cover, i = a.create_time;
            if (e) for (var o in e) e[o] || a.cover.splice(o, 1);
            if (a.create_time1 = _xx_util2.default.formatTime(1e3 * i, "M月D日"), s.setData({
                detailData: a
            }), -2 == t.errno) {
                var r = s.data.paramData, n = r.fromshare, d = r.to_uid, u = r.from_id;
                u || (u = wx.getStorageSync("userid"));
                var l = "true" == n ? "返回首页" : "确定";
                wx.showModal({
                    title: "提示",
                    content: t.message,
                    confirmText: l,
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && "true" == n && wx.reLaunch({
                            url: "/longbing_card/pages/index/index?to_uid=" + d + "&from_id=" + u + "&currentTabBar=toNews"
                        });
                    }
                });
            }
        });
    },
    toForwardRecord: function() {
        var t = this.data.paramData, a = t.id, e = t.to_uid;
        _index.userModel.getForwardRecord({
            type: 3,
            to_uid: e,
            target_id: a
        }), _xx_util2.default.hideAll();
    },
    toGetShareInfo: function() {
        var u = this;
        wx.login({
            success: function(t) {
                var a = u.data.paramData, e = a.id, i = a.to_uid, o = getApp().globalData, r = o.encryptedData, n = o.iv, d = t.code;
                _index.userModel.getShareRecord({
                    encryptedData: r,
                    iv: n,
                    type: 4,
                    code: d,
                    to_uid: i,
                    target_id: e
                }).then(function(t) {
                    _xx_util2.default.hideAll(), 0 == t.errno && clearInterval(timer);
                });
            }
        });
    },
    toPreviewImg: function(t) {
        var a = this.data.detailData.cover;
        if (0 < a.length) {
            var e = t.target.dataset.src;
            wx.previewImage({
                current: e,
                urls: a
            });
        }
    },
    bindwaiting: function(t) {
        console.log(t, "bindwaiting");
    },
    binderror: function(t) {
        console.log(t, "binderror");
    }
});