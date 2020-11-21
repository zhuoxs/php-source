var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Page({
    data: {
        exadaystatus: !0,
        itemindex: 0,
        maxitemindex: 0
    },
    showItem: function(e) {
        var t = e.target.dataset.itemindex;
        this.setData({
            itemindex: t,
            exadaystatus: !1
        });
    },
    showDay: function(e) {
        this.setData({
            exadaystatus: !0
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
    setDay: function() {
        var t = this.data.exaday.id, e = this.data.user.id;
        _request2.default.get("exadaydetails", {
            op: "setday",
            id: t,
            userid: e
        }).then(function(e) {
            wx.redirectTo({
                url: "../exa/exadaydetails?id=" + t
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
        if (i[n].ischange && 1 == a.data.exaday.status) {
            var e = i[n].id, s = i[n].myanswer;
            _request2.default.get("exadaydetails", {
                op: "setitem",
                exaitemid: e,
                myanswer: s
            }).then(function(e) {
                i[n].ischange = !1, a.setData({
                    exaitemall: i
                }), !0 === t && a.setDay();
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
        } else !0 === t && 1 == a.data.exaday.status && a.setDay();
    },
    submitDay: function() {
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
    onLoad: function(e) {
        var t = this, a = wx.getStorageSync("param") || null, i = wx.getStorageSync("user") || null;
        t.setData({
            param: a,
            user: i
        }), null == i && wx.redirectTo({
            url: "../login/login"
        });
        var n = e.id, s = i.id;
        _request2.default.get("exadaydetails", {
            userid: s,
            id: n
        }).then(function(e) {
            t.setData({
                exaday: e.exaday,
                exaitemall: e.exaitemall,
                maxitemindex: e.maxitemindex,
                exadaystatus: 2 == e.exaday.status
            });
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