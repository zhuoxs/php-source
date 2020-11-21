var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var i in e) Object.prototype.hasOwnProperty.call(e, i) && (t[i] = e[i]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js");

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
        nav: [ {
            name: "老师简介",
            choose: !0
        }, {
            name: "主授课程",
            choose: !1
        } ],
        choose: 0,
        list: {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            data: []
        }
    },
    onLoad: function(t) {
        this.setData({
            tid: t.tid
        });
        var a = wx.getStorageSync("isshare");
        this.setData({
            isshare: a
        });
    },
    onloadData: function(t) {
        var e = this;
        t.detail.login && (this.setData({
            login: t.detail.login
        }), this.checkUrl().then(function(t) {
            wx.showShareMenu();
            var a = {
                tid: e.data.tid,
                uid: wx.getStorageSync("userInfo").wxInfo.id
            };
            return (0, _api.TeacherDetailsData)(a).then(function(t) {
                e.setData({
                    info: t
                }), e.getListData();
            });
        }).catch(function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        }));
    },
    onNavTab: function(t) {
        var a = t.currentTarget.dataset.idx, e = this.data.nav;
        for (var i in e) {
            e[i = i - 0].choose = i === a;
        }
        this.setData({
            nav: e,
            choose: a
        });
    },
    onTelTab: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.info.tel
        });
    },
    onCollectTab: function(t) {
        var a = this, e = wx.getStorageSync("userInfo"), i = {
            type: t.currentTarget.dataset.type,
            typeid: this.data.tid,
            uid: e.wxInfo.id,
            act: 0 === this.data.info.islike ? 1 : 2,
            actid: this.data.info.islike
        };
        (0, _api.CollectData)(i).then(function(t) {
            a.setData(_defineProperty({}, "info.islike", 1 === i.act ? t.actid : 0));
        }).catch(function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        });
    },
    getListData: function() {
        var a = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var t = {
                tid: this.data.tid,
                uid: wx.getStorageSync("userInfo").wxInfo.id,
                page: this.data.list.page,
                length: this.data.list.length
            };
            (0, _api.TeachCourseData)(t).then(function(t) {
                a.dealList(t);
            });
        }
    },
    onReachBottom: function() {
        1 === this.data.choose && this.getListData();
    },
    onHomeTab: function() {
        this.lunchTo("../home/home");
    },
    onShareAppMessage: function() {
        return {
            title: this.data.info.info.name + "老师",
            path: "/yzpx_sun/pages/teacher/teacher?tid=" + this.data.tid
        };
    }
}));