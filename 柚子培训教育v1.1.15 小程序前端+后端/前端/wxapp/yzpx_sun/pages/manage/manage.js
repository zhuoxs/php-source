var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var i = arguments[a];
        for (var n in i) Object.prototype.hasOwnProperty.call(i, n) && (t[n] = i[n]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        show: !1
    },
    onLoad: function(t) {
        this.setData({
            auth: t.auth,
            sid: t.sid,
            tid: t.tid,
            name: t.name,
            logo: t.logo
        }), this.onloadData();
    },
    onloadData: function() {
        var i = this, a = this, n = {
            uid: wx.getStorageSync("userInfo").wxInfo.id
        };
        3 == this.data.auth && (n.tid = this.data.tid), 2 == this.data.auth && (n.sid = this.data.sid), 
        -1 == this.data.sid ? this.checkUrl().then(function(t) {
            var a = {
                tid: i.data.tid,
                uid: wx.getStorageSync("userInfo").wxInfo.id
            };
            return (0, _api.TeacherDetailsData)(a);
        }).then(function(t) {
            return i.setData({
                tsid: t.sid
            }), (0, _api.AdminInfoData)(n);
        }).then(function(t) {
            i.setData({
                show: !0,
                info: t
            });
        }).catch(function(t) {
            "您还不是管理员哦" === t.msg ? wx.showModal({
                title: "提示",
                content: "您不是管理员哦！",
                showCancel: !1,
                success: function(t) {
                    a.lunchTo("../mine/mine");
                }
            }) : wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        }) : this.checkUrl().then(function(t) {
            return (0, _api.AdminInfoData)(n);
        }).then(function(t) {
            i.setData({
                show: !0,
                info: t
            });
        }).catch(function(t) {
            "您还不是管理员哦" === t.msg ? wx.showModal({
                title: "提示",
                content: "您不是管理员哦！",
                showCancel: !1,
                success: function(t) {
                    a.lunchTo("../mine/mine");
                }
            }) : wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        }), 1 == this.data.auth && (0, _api.WeData)().then(function(t) {
            i.setData({
                name: t.name,
                logo: t.pic ? i.data.imgLink + t.pic : "../../resource/images/mine/user.png"
            });
        });
    },
    onAddTeacherTab: function() {
        this.navTo("../addteacherlist/addteacherlist?sid=" + this.data.sid);
    },
    onAddSchoolTab: function() {
        this.navTo("../addschoolslist/addschoolslist");
    },
    onApplyListTab: function() {
        -1 == this.data.sid ? this.navTo("../applylist/applylist?sid=" + this.data.tsid) : this.navTo("../applylist/applylist?sid=" + this.data.sid);
    }
}));