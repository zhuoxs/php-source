var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Page({
    data: {
        exaanswerstatus: 0,
        itemindex: 0,
        maxitemindex: 0
    },
    showItem: function(e) {
        var t = e.target.dataset.itemindex;
        this.setData({
            itemindex: t,
            exaanswerstatus: 1
        });
    },
    showAnswer: function(e) {
        this.setData({
            exaanswerstatus: 2
        });
    },
    checkItem: function(e) {
        var t = this, a = t.data.exaitemall, i = t.data.itemindex, n = a[i].myanswer;
        1 == a[i].qtype ? n = e.detail.value.toString() : 2 == a[i].qtype && (n = e.detail.value.sort().toString().replace(/,/g, "")), 
        a[i].itemachecked = -1 != n.indexOf("A"), a[i].itembchecked = -1 != n.indexOf("B"), 
        a[i].itemcchecked = -1 != n.indexOf("C"), a[i].itemdchecked = -1 != n.indexOf("D"), 
        a[i].itemechecked = -1 != n.indexOf("E"), a[i].itemfchecked = -1 != n.indexOf("F"), 
        a[i].myanswer = n, a[i].ischange = !0, t.setData({
            exaitemall: a
        });
    },
    setAnswer: function() {
        var t = this.data.exaanswer.id, e = this.data.user.id;
        _request2.default.get("exaanswerdetails", {
            op: "setanswer",
            id: t,
            userid: e
        }).then(function(e) {
            wx.redirectTo({
                url: "../exa/exaanswerdetails?id=" + t
            });
        }, function(e) {
            wx.showModal({
                title: "提示信息",
                content: e,
                showCancel: !1,
                success: function(e) {}
            });
        });
    },
    setItem: function() {
        var t = 0 < arguments.length && void 0 !== arguments[0] && arguments[0], a = this, i = a.data.exaitemall, n = a.data.itemindex;
        if (i[n].ischange && 1 == a.data.exaanswer.status) {
            var e = i[n].id, s = i[n].myanswer;
            _request2.default.get("exaanswerdetails", {
                op: "setitem",
                exaitemid: e,
                myanswer: s
            }).then(function(e) {
                i[n].ischange = !1, a.setData({
                    exaitemall: i
                }), !0 === t && a.setAnswer();
            }, function(e) {
                wx.showModal({
                    title: "提示信息",
                    content: e,
                    showCancel: !1,
                    success: function(e) {
                        e.confirm && wx.redirectTo({
                            url: "../home/home"
                        });
                    }
                });
            });
        } else !0 === t && 1 == a.data.exaanswer.status && a.setAnswer();
    },
    submitAnswer: function() {
        this.setItem(!0);
    },
    upperItem: function(e) {
        var t = this;
        t.setItem(), t.setData({
            itemindex: parseInt(t.data.itemindex) - 1
        });
    },
    lowerItem: function(e) {
        var t = this;
        t.setItem(), t.setData({
            itemindex: parseInt(t.data.itemindex) + 1
        });
    },
    startAnswer: function(e) {
        var t = this.data.exaanswer.id, a = this.data.user.id;
        _request2.default.get("exaanswerdetails", {
            op: "startanswer",
            id: t,
            userid: a
        }).then(function(e) {
            wx.redirectTo({
                url: "../exa/exaanswerdetails?id=" + t
            });
        }, function(e) {
            wx.showModal({
                title: "提示信息",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.redirectTo({
                        url: "../exa/exapaper"
                    });
                }
            });
        });
    },
    onLoad: function(e) {
        var t = this, a = wx.getStorageSync("param") || null, i = wx.getStorageSync("user") || null;
        t.setData({
            param: a,
            user: i
        }), null == i && wx.redirectTo({
            url: "../login/login"
        });
        var n = e.id, s = i.id;
        _request2.default.get("exaanswerdetails", {
            userid: s,
            id: n
        }).then(function(e) {
            t.setData({
                exaanswer: e.exaanswer,
                exapaper: e.exapaper,
                exaitemall: e.exaitemall,
                timelimit: e.timelimit,
                exaanswerstatus: e.exaanswer.status,
                maxitemindex: e.maxitemindex
            });
        }, function(e) {
            wx.showModal({
                title: "提示信息",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.redirectTo({
                        url: "../exa/exapaper"
                    });
                }
            });
        });
    },
    onReady: function() {
        app.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: this.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: this.data.param.wxappshareimageurl
        };
    }
});