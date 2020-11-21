var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var start_clientX, end_clientX, app = getApp();

Page({
    data: {
        cateid: 0,
        pindex: 1,
        psize: 20,
        hasMore: !0,
        list: [],
        replyid: 0,
        replytitle: "",
        replydetails: "",
        topicindex: 0,
        windowWidth: wx.getSystemInfoSync().windowWidth
    },
    touchstart: function(t) {
        start_clientX = t.changedTouches[0].clientX;
    },
    touchend: function(t) {
        120 < (end_clientX = t.changedTouches[0].clientX) - start_clientX ? this.setData({
            display: "block",
            translate: "transform: translateX(" + .7 * this.data.windowWidth + "px); position: fixed; z-index: 1;"
        }) : 0 < start_clientX - end_clientX && this.setData({
            display: "none",
            translate: ""
        });
    },
    showview: function() {
        this.setData({
            display: "block",
            translate: "transform: translateX(" + .7 * this.data.windowWidth + "px); position: fixed; z-index: 1;"
        });
    },
    hideview: function() {
        this.setData({
            display: "none",
            translate: ""
        });
    },
    getMore: function() {
        var i = this, t = i.data.user.id, e = i.data.user.scort, a = i.data.cateid, n = i.data.pindex, s = i.data.psize;
        _request2.default.get("bbshome", {
            op: "getmore",
            userid: t,
            userscort: e,
            cateid: a,
            pindex: n,
            psize: s
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
            });
        });
    },
    previewImage: function(t) {
        var e = t.target.dataset.messageid, a = t.target.dataset.src;
        wx.previewImage({
            current: a,
            urls: this.data.list[e].picall
        });
    },
    showMore: function(t) {
        var e = t.target.dataset.index, a = t.target.dataset.hidden, i = this.data.list;
        i[e].ishidden = "true" == a, this.setData({
            list: i
        });
    },
    clickCollect: function(t) {
        var e = this, a = e.data.user.id, i = t.currentTarget.dataset.index, n = e.data.list, s = n[i].id;
        _request2.default.get("bbshome", {
            op: "clickcollect",
            userid: a,
            topicid: s
        }).then(function(t) {
            n[i].ucollect = t.collectid, e.setData({
                list: n
            });
        });
    },
    clickZan: function(t) {
        var e = this, a = e.data.user.id, i = t.currentTarget.dataset.index, n = e.data.list, s = n[i].id;
        _request2.default.get("bbshome", {
            op: "clickzan",
            userid: a,
            topicid: s
        }).then(function(t) {
            n[i].zantol = t.tol, n[i].zanarr = t.arr, n[i].uzan = t.zanid, e.setData({
                list: n
            });
        });
    },
    clickReply: function(t) {
        var e = t.currentTarget.dataset.index, a = t.currentTarget.dataset.replytitle, i = this.data.list[e].id;
        this.setData({
            replyid: i,
            replytitle: a,
            topicindex: e
        });
    },
    replyClose: function(t) {
        this.setData({
            replyid: 0,
            replytitle: "",
            replydetails: "",
            topicindex: 0
        });
    },
    replyPost: function(t) {
        var e = this, a = e.data.user.id, i = e.data.replyid, n = t.detail.value.details, s = e.data.topicindex, r = e.data.list;
        _request2.default.get("bbshome", {
            op: "replypost",
            userid: a,
            topicid: i,
            details: n
        }).then(function(t) {
            r[s].replytol = t.tol, r[s].replyarr = t.arr, e.setData({
                list: r,
                replyid: 0,
                replytitle: "",
                replydetails: ""
            });
        }, function(t) {
            wx.showModal({
                title: "提示信息",
                content: t,
                showCancel: !1,
                success: function(t) {}
            });
        });
    },
    replyDelete: function(t) {
        var e = this, a = e.data.user.id, i = t.currentTarget.dataset.replyid, n = t.currentTarget.dataset.index, s = e.data.list;
        _request2.default.get("bbshome", {
            op: "replydelete",
            userid: a,
            replyid: i
        }).then(function(t) {
            s[n].replytol = t.tol, s[n].replyarr = t.arr, e.setData({
                list: s
            });
        }, function(t) {
            wx.showModal({
                title: "提示信息",
                content: t,
                showCancel: !1,
                success: function(t) {}
            });
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
        var n = parseInt(t.cateid);
        e.setData({
            cateid: n
        }), _request2.default.get("bbshome", {
            cateid: n
        }).then(function(t) {
            e.setData({
                catename: t.catename
            }), e.getMore();
        }, function(t) {
            wx.showModal({
                title: "提示信息",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../bbs/bbshome"
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