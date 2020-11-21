var e = function(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}(require("../../util/request.js")), t = getApp(), a = [];

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
        var s = this, i = s.data.user.id, n = s.data.seritem.id;
        e.default.post("seritem", {
            op: "usersubmit",
            userid: i,
            itemid: n
        }).then(function(e) {
            a = e.userlist, s.setData({
                myuser: e.myuser,
                usersubmitarr: e.usersubmitarr,
                btnmore: a.length >= 13,
                btnhidden: !1,
                userlist: a.slice(0, 12)
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
        var t = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var a = t.data.seritem.id, s = t.data.pindex, i = t.data.psize;
        e.default.post("sermessage", {
            op: "getmore",
            itemid: a,
            pindex: s,
            psize: i
        }).then(function(e) {
            var a = t.data.list;
            1 == t.data.pindex && (a = []);
            var s = e;
            s.length < t.data.psize ? t.setData({
                list: a.concat(s),
                hasMore: !1
            }) : t.setData({
                list: a.concat(s),
                hasMore: !0,
                pindex: t.data.pindex + 1
            }), wx.hideToast();
        });
    },
    previewImage: function(e) {
        var t = this, a = e.target.dataset.messageid, s = e.target.dataset.src;
        wx.previewImage({
            current: s,
            urls: t.data.list[a].picall
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
            userlist: a
        }) : t.setData({
            btnhidden: !1,
            userlist: a.slice(0, 12)
        });
    },
    onLoad: function(t) {
        var s = this, i = wx.getStorageSync("param") || null, n = wx.getStorageSync("user") || null;
        s.setData({
            param: i,
            user: n
        }), null == n && wx.redirectTo({
            url: "../login/login"
        });
        var r = t.id, o = null == n ? 0 : n.id;
        e.default.get("seritem", {
            id: r,
            userid: o
        }).then(function(e) {
            a = e.userlist, s.setData({
                seritem: e.seritem,
                sercate: e.sercate,
                branch: e.branch,
                myuser: e.myuser,
                btnmore: a.length >= 13,
                btnhidden: !1,
                userlist: a.slice(0, 12),
                usersubmitarr: e.usersubmitarr
            }), s.getMore();
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
        t.util.footer(this);
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
        var e = this;
        return {
            title: e.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: e.data.param.wxappshareimageurl
        };
    }
});