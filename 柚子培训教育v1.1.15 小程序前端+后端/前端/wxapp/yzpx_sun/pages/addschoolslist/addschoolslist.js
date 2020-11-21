var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var i = arguments[a];
        for (var e in i) Object.prototype.hasOwnProperty.call(i, e) && (t[e] = i[e]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js");

function _defineProperty(t, a, i) {
    return a in t ? Object.defineProperty(t, a, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = i, t;
}

var app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        choose: 0,
        login: !0,
        addflag: !1,
        showPage: !1,
        finduid: ""
    },
    onLoad: function(t) {},
    onloadData: function() {
        var a = this;
        this.setData({
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                data: []
            }
        }), this.checkUrl().then(function(t) {
            return a.setData({
                showPage: !0
            }), a.getListData();
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        });
    },
    getListData: function() {
        var a = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var t = {
                page: this.data.list.page,
                length: this.data.list.length,
                select_type: 2
            };
            return (0, _api.SchoolListData)(t).then(function(t) {
                a.dealList(t);
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    onSchoolTab: function(t) {
        var a = t.currentTarget.dataset.idx, i = this.data.list.data[a].id;
        this.navTo("../school/school?sid=" + i);
    },
    onShowAddTab: function(t) {
        var a = this, i = t.currentTarget.dataset.idx;
        this.setData({
            idx: i
        }), 0 < this.data.list.data[i].admin_uid ? wx.showModal({
            title: "提示",
            content: "确定解绑码？",
            success: function(t) {
                t.confirm && a.unbindTab();
            }
        }) : this.closeMask();
    },
    closeMask: function() {
        this.setData({
            addflag: !this.data.addflag
        });
    },
    onbindAuthTab: function() {
        var a = this, t = {
            uid: this.data.findmsg.id,
            type: 2,
            typeid: this.data.list.data[this.data.idx].id
        };
        (0, _api.AddAdminData)(t).then(function(t) {
            a.setData(_defineProperty({}, "list.data[" + a.data.idx + "].admin_uid", a.data.findmsg.id)), 
            a.tips("绑定成功！"), a.closeMask();
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        });
    },
    bindUidTab: function(t) {
        var a = this;
        this.setData({
            finduid: t.detail.value
        }), (0, _api.FindUserData)({
            uid: this.data.finduid
        }).then(function(t) {
            a.setData({
                findmsg: t
            });
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        });
    },
    unbindTab: function() {
        var a = this, t = {
            uid: this.data.list.data[this.data.idx].admin_uid,
            type: 2
        };
        (0, _api.QxAdminData)(t).then(function(t) {
            a.setData(_defineProperty({}, "list.data[" + a.data.idx + "].admin_uid", 0)), a.tips("解绑成功！");
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        });
    }
}));