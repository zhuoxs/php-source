var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp(), userlist = [];

Page({
    data: {
        pindex: 1,
        psize: 2,
        hasMore: !0,
        list: [],
        btntype: "primary",
        btnval: ""
    },
    userSubmit: function(e) {
        var t = this, s = t.data.user.id, a = t.data.seritem.id;
        _request2.default.post("seritem", {
            op: "usersubmit",
            userid: s,
            itemid: a
        }).then(function(e) {
            userlist = e.userlist, t.setData({
                myuser: e.myuser,
                usersubmitarr: e.usersubmitarr,
                btnmore: 13 <= userlist.length,
                btnhidden: !1,
                userlist: userlist.slice(0, 12)
            });
        }, function(e) {
            wx.showModal({
                title: "提示信息",
                content: e,
                showCancel: !1,
                success: function(e) {}
            }), console.log(e);
        });
    },
    getMore: function() {
        var a = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var e = a.data.seritem.id, t = a.data.pindex, s = a.data.psize;
        _request2.default.post("sermessage", {
            op: "getmore",
            itemid: e,
            pindex: t,
            psize: s
        }).then(function(e) {
            var t = a.data.list;
            1 == a.data.pindex && (t = []);
            var s = e;
            s.length < a.data.psize ? a.setData({
                list: t.concat(s),
                hasMore: !1
            }) : a.setData({
                list: t.concat(s),
                hasMore: !0,
                pindex: a.data.pindex + 1
            }), wx.hideToast();
        });
    },
    previewImage: function(e) {
        var t = e.target.dataset.messageid, s = e.target.dataset.src;
        wx.previewImage({
            current: s,
            urls: this.data.list[t].picall
        });
    },
    calling: function(e) {
        wx.makePhoneCall({
            phoneNumber: e.target.dataset.mobile,
            success: function() {
                console.log("拨打电话成功！");
            },
            fail: function() {
                console.log("拨打电话失败！");
            }
        });
    },
    btnMore: function(e) {
        var t = this;
        0 == t.data.btnhidden ? t.setData({
            btnhidden: !0,
            userlist: userlist
        }) : t.setData({
            btnhidden: !1,
            userlist: userlist.slice(0, 12)
        });
    },
    onLoad: function(e) {
        var t = this, s = wx.getStorageSync("param") || null, a = wx.getStorageSync("user") || null;
        t.setData({
            param: s,
            user: a
        }), null == a && wx.redirectTo({
            url: "../login/login"
        });
        var i = e.id, r = null == a ? 0 : a.id;
        _request2.default.get("seritem", {
            id: i,
            userid: r
        }).then(function(e) {
            userlist = e.userlist, t.setData({
                seritem: e.seritem,
                sercate: e.sercate,
                branch: e.branch,
                myuser: e.myuser,
                btnmore: 13 <= userlist.length,
                btnhidden: !1,
                userlist: userlist.slice(0, 12),
                usersubmitarr: e.usersubmitarr
            }), t.getMore();
        }, function(e) {
            wx.showModal({
                title: "提示",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.redirectTo({
                        url: "../ser/serhome"
                    });
                }
            }), console.log(e);
        });
    },
    onReady: function() {
        app.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        this.data.pindex = 1, this.getMore();
    },
    onReachBottom: function() {
        this.data.hasMore ? this.getMore() : wx.showToast({
            title: "没有更多数据"
        });
    },
    onShareAppMessage: function() {
        return {
            title: this.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: this.data.param.wxappshareimageurl
        };
    }
});