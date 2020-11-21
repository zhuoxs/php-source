var t = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), a = require("../../util/image.js"), e = getApp();

Page({
    data: {
        details: "",
        picall: [],
        pindex: 1,
        psize: 20,
        hasMore: !0,
        list: []
    },
    getMore: function() {
        var a = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var e = a.data.activity.id, i = a.data.pindex, n = a.data.psize;
        t.default.post("actmessage", {
            op: "getmore",
            activityid: e,
            pindex: i,
            psize: n
        }).then(function(t) {
            var e = a.data.list;
            1 == a.data.pindex && (e = []);
            var i = t;
            i.length < a.data.psize ? a.setData({
                list: e.concat(i),
                hasMore: !1
            }) : a.setData({
                list: e.concat(i),
                hasMore: !0,
                pindex: a.data.pindex + 1
            }), wx.hideToast();
        });
    },
    previewImage: function(t) {
        var a = this, e = t.target.dataset.messageid, i = t.target.dataset.src;
        wx.previewImage({
            current: i,
            urls: a.data.list[e].picall
        });
    },
    chooseImage: function() {
        var t = this, e = t.data.picall;
        (0, a.chooseImage)().then(function(t) {
            if (!(e.length >= 9)) return (0, a.upload)(t);
            wx.showToast({
                title: "最多上传九张"
            });
        }, function(t) {
            wx.showToast({
                title: "选择图片失败"
            });
        }).then(function(a) {
            e = e.concat(a.filename), t.setData({
                picall: e
            });
        }, function(t) {
            wx.showToast({
                title: "图片上传失败"
            });
        });
    },
    picclearImage: function(t) {
        var a = this, e = t.currentTarget.dataset.index, i = a.data.picall;
        i.splice(e, 1), a.setData({
            picall: i
        });
    },
    formSubmit: function(a) {
        var e = this, i = a.detail.value.details;
        if (0 == i.length) wx.showModal({
            title: "提示",
            content: "评论内容不能为空",
            showCancel: !1,
            success: function(t) {}
        }); else {
            var n = e.data.activity.id, s = e.data.user.id, o = JSON.stringify(e.data.picall);
            t.default.post("actmessage", {
                op: "addmessage",
                activityid: n,
                userid: s,
                details: i,
                picall: o
            }).then(function(t) {
                wx.showModal({
                    title: "提示",
                    content: "留言评论提交成功！",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && (e.data.pindex = 1, e.getMore(), e.setData({
                            details: "",
                            picall: []
                        }));
                    }
                });
            }, function(t) {
                wx.showModal({
                    title: "提示",
                    content: t,
                    showCancel: !1,
                    success: function(t) {}
                });
            });
        }
    },
    delMessage: function(a) {
        var e = this, i = a.target.dataset.messageid, n = a.target.dataset.index, s = e.data.user.id;
        t.default.post("actmessage", {
            op: "delmessage",
            messageid: i,
            userid: s
        }).then(function(t) {
            var a = e.data.list;
            a.splice(n, 1), e.setData({
                list: a
            });
        }, function(t) {
            wx.showModal({
                title: "提示",
                content: t,
                showCancel: !1,
                success: function(t) {}
            });
        });
    },
    onLoad: function(a) {
        var e = this, i = wx.getStorageSync("attachurl") || "", n = wx.getStorageSync("param") || null, s = wx.getStorageSync("user") || null;
        e.setData({
            attachurl: i,
            param: n,
            user: s
        }), null == s && wx.redirectTo({
            url: "../login/login"
        });
        var o = a.activityid;
        s.id;
        t.default.get("actmessage", {
            activityid: o
        }).then(function(t) {
            e.setData({
                activity: t.activity,
                branch: t.branch
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