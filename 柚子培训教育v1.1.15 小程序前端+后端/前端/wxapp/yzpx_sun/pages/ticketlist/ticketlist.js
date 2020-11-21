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
        login: !0,
        list: {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            data: []
        },
        schoolFlag: !1,
        choose: "",
        ajax: !0
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("shopinfo");
        this.setData({
            sid: a.sid
        });
    },
    onloadData: function(t) {
        var a = this;
        t.detail.login && this.checkUrl().then(function(t) {
            a.getListData();
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        });
    },
    getListData: function() {
        var a = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                uid: wx.getStorageSync("userInfo").wxInfo.id,
                page: this.data.list.page,
                length: this.data.list.length,
                sid: this.data.sid
            };
            (0, _api.CouponListData)(e).then(function(t) {
                a.dealList(t, e.page);
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    closeSchool: function(t) {
        var a = t.currentTarget.dataset.idx;
        null != a && (this.setData({
            choose: a
        }), 0 != this.data.list.data[a].use) || this.setData({
            schoolFlag: !this.data.schoolFlag
        });
    },
    onGetTab: function(t) {
        var a = this;
        if (this.data.ajax) {
            this.data.ajax = !1;
            var e = t.currentTarget.dataset.idx;
            if (this.setData({
                choose: e
            }), 0 < this.data.list.data[e].isget) return this.tips("您已领取！"), void (this.data.ajax = !0);
            if (new Date().getTime() / 1e3 < this.data.list.data[e].start_time - 0) return this.tips("领取时间还未到，请耐心等待！"), 
            void (this.data.ajax = !0);
            var i = {
                couponid: this.data.list.data[e].id,
                uid: wx.getStorageSync("userInfo").wxInfo.id
            };
            (0, _api.GetCouponData)(i).then(function(t) {
                a.setData(_defineProperty({}, "list.data[" + e + "].isget", 1)), a.data.ajax = !0, 
                a.tips("恭喜您，领取成功！");
            }).catch(function(t) {
                a.data.ajax = !0, -1 === t.code ? a.tips(t.msg) : a.tips("false");
            });
        }
    }
}));