var e = function(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}(require("../../util/request.js")), t = require("../../util/image.js"), a = getApp();

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
        var t = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var a = t.data.edulesson.id, s = t.data.pindex, n = t.data.psize;
        e.default.post("edumessage", {
            op: "getmore",
            lessonid: a,
            pindex: s,
            psize: n
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
    chooseImage: function() {
        var e = this, a = e.data.picall;
        (0, t.chooseImage)().then(function(e) {
            if (!(a.length >= 9)) return (0, t.upload)(e);
            wx.showToast({
                title: "最多上传九张"
            });
        }, function(e) {
            wx.showToast({
                title: "选择图片失败"
            });
        }).then(function(t) {
            a = a.concat(t.filename), e.setData({
                picall: a
            }), console.log(a);
        }, function(e) {
            wx.showToast({
                title: "图片上传失败"
            });
        });
    },
    picclearImage: function(e) {
        var t = this, a = e.currentTarget.dataset.index, s = t.data.picall;
        s.splice(a, 1), t.setData({
            picall: s
        });
    },
    formSubmit: function(t) {
        var a = this, s = t.detail.value.details;
        if (0 == s.length) wx.showModal({
            title: "提示",
            content: "评论内容不能为空",
            showCancel: !1,
            success: function(e) {}
        }); else {
            var n = a.data.edulesson.id, i = a.data.user.id, o = JSON.stringify(a.data.picall);
            e.default.post("edumessage", {
                op: "addmessage",
                lessonid: n,
                userid: i,
                details: s,
                picall: o
            }).then(function(e) {
                wx.showModal({
                    title: "提示",
                    content: "留言评论提交成功！",
                    showCancel: !1,
                    success: function(e) {
                        e.confirm && (a.data.pindex = 1, a.getMore(), a.setData({
                            details: "",
                            picall: []
                        }));
                    }
                });
            }, function(e) {
                wx.showModal({
                    title: "提示",
                    content: e,
                    showCancel: !1,
                    success: function(e) {}
                });
            });
        }
    },
    delMessage: function(t) {
        var a = this, s = t.target.dataset.messageid, n = t.target.dataset.index, i = a.data.user.id;
        e.default.post("edumessage", {
            op: "delmessage",
            messageid: s,
            userid: i
        }).then(function(e) {
            var t = a.data.list;
            t.splice(n, 1), a.setData({
                list: t
            });
        }, function(e) {
            wx.showModal({
                title: "提示",
                content: e,
                showCancel: !1,
                success: function(e) {}
            });
        });
    },
    onLoad: function(t) {
        var a = this, s = wx.getStorageSync("attachurl") || "", n = wx.getStorageSync("param") || null, i = wx.getStorageSync("user") || null;
        a.setData({
            attachurl: s,
            param: n,
            user: i
        }), null == i && wx.redirectTo({
            url: "../login/login"
        });
        var o = t.lessonid;
        i.id;
        e.default.get("edumessage", {
            lessonid: o
        }).then(function(e) {
            a.setData({
                edulesson: e.edulesson,
                educate: e.educate
            }), a.getMore();
        }, function(e) {
            wx.showModal({
                title: "提示",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.redirectTo({
                        url: "../edu/eduhome"
                    });
                }
            }), console.log(e);
        });
    },
    onReady: function() {
        a.util.footer(this);
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