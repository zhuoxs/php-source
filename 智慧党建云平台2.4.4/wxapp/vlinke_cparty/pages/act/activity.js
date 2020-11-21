var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
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
    userSubmit: function(t) {
        var e = this, a = e.data.user.id, i = e.data.activity.id;
        _request2.default.post("activity", {
            op: "usersubmit",
            userid: a,
            activityid: i
        }).then(function(t) {
            userlist = t.userlist, e.setData({
                myuser: t.myuser,
                usersubmitarr: t.usersubmitarr,
                btnmore: 13 <= userlist.length,
                btnhidden: !1,
                userlist: userlist.slice(0, 12)
            });
        }, function(t) {
            wx.showModal({
                title: "提示信息",
                content: t,
                showCancel: !1,
                success: function(t) {}
            }), console.log(t);
        });
    },
    getMore: function() {
        var i = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var t = i.data.activity.id, e = i.data.pindex, a = i.data.psize;
        _request2.default.post("actmessage", {
            op: "getmore",
            activityid: t,
            pindex: e,
            psize: a
        }).then(function(t) {
            var e = i.data.list;
            1 == i.data.pindex && (e = []);
            var a = t;
            a.length < i.data.psize ? i.setData({
                list: e.concat(a),
                hasMore: !1
            }) : i.setData({
                list: e.concat(a),
                hasMore: !0,
                pindex: i.data.pindex + 1
            }), wx.hideToast();
        });
    },
    previewImage: function(t) {
        var e = t.target.dataset.messageid, a = t.target.dataset.src;
        wx.previewImage({
            current: a,
            urls: this.data.list[e].picall
        });
    },
    calling: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.target.dataset.mobile,
            success: function() {
                console.log("拨打电话成功！");
            },
            fail: function() {
                console.log("拨打电话失败！");
            }
        });
    },
    btnMore: function(t) {
        var e = this;
        0 == e.data.btnhidden ? e.setData({
            btnhidden: !0,
            userlist: userlist
        }) : e.setData({
            btnhidden: !1,
            userlist: userlist.slice(0, 12)
        });
    },
    onLoad: function(t) {
        var e = this, a = wx.getStorageSync("param") || null, i = wx.getStorageSync("user") || null;
        e.setData({
            param: a,
            user: i
        }), null == i && wx.redirectTo({
            url: "../login/login"
        });
        var s = t.id, n = i.id;
        _request2.default.get("activity", {
            id: s,
            userid: n
        }).then(function(t) {
            userlist = t.userlist, e.setData({
                activity: t.activity,
                actuser: t.actuser,
                branch: t.branch,
                myuser: t.myuser,
                btnmore: 13 <= userlist.length,
                btnhidden: !1,
                userlist: userlist.slice(0, 12),
                usersubmitarr: t.usersubmitarr
            }), e.getMore();
        }, function(t) {
            wx.showModal({
                title: "提示",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../act/acthome"
                    });
                }
            }), console.log(t);
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