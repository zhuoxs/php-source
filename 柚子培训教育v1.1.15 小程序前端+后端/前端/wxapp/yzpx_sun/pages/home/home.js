var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var i in e) Object.prototype.hasOwnProperty.call(e, i) && (t[i] = e[i]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), _rewx = require("../../resource/js/rewx.js");

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        padding: !1,
        showSummer: !1,
        list: {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            data: []
        },
        username: "",
        tel: "",
        prevent: !1,
        open: !1,
        login: !0,
        gps: !0
    },
    onLoad: function(t) {
        if (wx.setStorageSync("isshare", !1), 1 == t.schoolflag) this.setData({
            sid: t.sid
        }); else {
            var a = wx.getStorageSync("shopinfo");
            "" == a ? this.setData({
                sid: -1
            }) : this.setData({
                sid: a.sid
            });
        }
    },
    onloadData: function(t) {
        var e = this;
        this.getSetting(), t.detail.login && (this.setData({
            login: t.detail.login
        }), this.checkUrl().then(function(t) {
            return e.checkSchool();
        }).then(function(t) {
            e.setData({
                list: {
                    load: !1,
                    over: !1,
                    page: 1,
                    length: 10,
                    data: []
                }
            });
            var a = {
                sid: e.data.sid,
                uid: wx.getStorageSync("userInfo").wxInfo.id,
                page: e.data.list.page,
                length: e.data.list.length
            };
            return (0, _api.IndexData)(a);
        }).then(function(t) {
            e.setData({
                info: t,
                open: !0
            }), null == t.we.id && (t.we.id = 0), e.dealList(t.rec, 1);
        }).catch(function(t) {
            -1 === t.code ? e.tips(t.msg) : e.tips("false");
        }));
    },
    getSetting: function() {
        (0, _api.ColorData)().then(function(t) {
            wx.setStorageSync("color", t);
        }), (0, _api.FootnavData)().then(function(t) {
            var a = [];
            if (0 != t && 0 < t.length) {
                a = t;
                var e = !0, i = !1, n = void 0;
                try {
                    for (var s, o = a[Symbol.iterator](); !(e = (s = o.next()).done); e = !0) {
                        s.value.choose = !1;
                    }
                } catch (t) {
                    i = !0, n = t;
                } finally {
                    try {
                        !e && o.return && o.return();
                    } finally {
                        if (i) throw n;
                    }
                }
            }
            wx.setStorageSync("confMsg", a);
        });
    },
    getListData: function() {
        var a = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                sid: this.data.sid,
                uid: wx.getStorageSync("userInfo").wxInfo.id,
                page: this.data.list.page,
                length: this.data.list.length
            };
            (0, _api.IndexData)(e).then(function(t) {
                a.dealList(t.rec, e.page);
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    getUserName: function(t) {
        var a = t.detail.value.trim();
        this.setData({
            username: a
        });
    },
    getTel: function(t) {
        var a = t.detail.value.trim();
        this.setData({
            tel: a
        });
    },
    onSingUpTab: function() {
        var a = this;
        this.setData({
            prevent: !0
        });
        var t = {
            uid: wx.getStorageSync("userInfo").wxInfo.id,
            aid: this.data.info.ad.id,
            username: this.data.username,
            tel: this.data.tel
        };
        return t.username.length < 2 ? (wx.showToast({
            title: "请输入正确的姓名",
            icon: "none",
            duration: 1e3
        }), void this.setData({
            prevent: !1
        })) : t.tel.length < 11 ? (wx.showToast({
            title: "请输入正确的手机号码",
            icon: "none",
            duration: 1e3
        }), void this.setData({
            prevent: !1
        })) : void (0, _api.AdsignData)(t).then(function(t) {
            wx.showToast({
                title: "报名成功",
                icon: "none",
                duration: 2e3
            }), setTimeout(function() {
                a.setData({
                    prevent: !1
                }), a.onSummerTab();
            }, 1e3);
        }).catch(function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            }), setTimeout(function() {
                a.setData({
                    prevent: !1
                }), a.onSummerTab();
            }, 1e3);
        });
    },
    onGPSTab: function() {
        var t = this.data.info.we.lat - 0, a = this.data.info.we.lng - 0;
        wx.openLocation({
            latitude: t,
            longitude: a,
            scale: 28
        });
    },
    onSignUpTab: function() {
        this.navTo("../signup/signup?sid=" + this.data.sid);
    },
    onActivityListTab: function() {
        1 != this.data.info.we.join_card ? wx.showModal({
            title: "提示",
            content: "该分校暂未开通此功能",
            showCancel: !1,
            success: function(t) {}
        }) : this.navTo("../activitylist/activitylist");
    },
    onAboutTab: function() {
        this.navTo("../about/about?sid=" + this.data.sid);
    },
    onNewsListTab: function() {
        this.navTo("../newstable/newstable?sid=" + this.data.sid);
    },
    onClassListTab: function() {
        this.navTo("../classlist/classlist?sid=" + this.data.sid);
    },
    onTeacherListTab: function() {
        this.navTo("../teacherlist/teacherlist?sid=" + this.data.sid);
    },
    onSummerTab: function() {
        this.setData({
            showSummer: !this.data.showSummer
        });
    },
    onSchoolsListTab: function() {
        this.navTo("../schoolslist/schoolslist");
    },
    onBargainsListTab: function() {
        this.navTo("../bargainlist/bargainlist?sid=" + this.data.sid);
    },
    onCouponsListTab: function() {
        this.navTo("../ticketlist/ticketlist?sid=" + this.data.sid);
    },
    onShareAppMessage: function(t) {
        return {
            title: this.data.info.we.name,
            path: "/yzpx_sun/pages/home/home?sid=" + this.data.sid
        };
    }
}));