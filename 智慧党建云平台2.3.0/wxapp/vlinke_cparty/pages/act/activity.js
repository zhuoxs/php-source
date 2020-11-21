var t = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), e = getApp(), a = [];

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
        var i = this, n = i.data.user.id, s = i.data.activity.id;
        t.default.post("activity", {
            op: "usersubmit",
            userid: n,
            activityid: s
        }).then(function(t) {
            a = t.userlist, i.setData({
                myuser: t.myuser,
                usersubmitarr: t.usersubmitarr,
                btnmore: a.length >= 13,
                btnhidden: !1,
                userlist: a.slice(0, 12)
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
        var e = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var a = e.data.activity.id, i = e.data.pindex, n = e.data.psize;
        t.default.post("actmessage", {
            op: "getmore",
            activityid: a,
            pindex: i,
            psize: n
        }).then(function(t) {
            var a = e.data.list;
            1 == e.data.pindex && (a = []);
            var i = t;
            i.length < e.data.psize ? e.setData({
                list: a.concat(i),
                hasMore: !1
            }) : e.setData({
                list: a.concat(i),
                hasMore: !0,
                pindex: e.data.pindex + 1
            }), wx.hideToast();
        });
    },
    previewImage: function(t) {
        var e = this, a = t.target.dataset.messageid, i = t.target.dataset.src;
        wx.previewImage({
            current: i,
            urls: e.data.list[a].picall
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
            userlist: a
        }) : e.setData({
            btnhidden: !1,
            userlist: a.slice(0, 12)
        });
    },
    onLoad: function(e) {
        var i = this, n = wx.getStorageSync("param") || null, s = wx.getStorageSync("user") || null;
        i.setData({
            param: n,
            user: s
        }), null == s && wx.redirectTo({
            url: "../login/login"
        });
        var o = e.id, r = s.id;
        t.default.get("activity", {
            id: o,
            userid: r
        }).then(function(t) {
            a = t.userlist, i.setData({
                activity: t.activity,
                actuser: t.actuser,
                branch: t.branch,
                myuser: t.myuser,
                btnmore: a.length >= 13,
                btnhidden: !1,
                userlist: a.slice(0, 12),
                usersubmitarr: t.usersubmitarr
            }), i.getMore();
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
        e.util.footer(this);
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
        var t = this;
        return {
            title: t.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: t.data.param.wxappshareimageurl
        };
    }
});