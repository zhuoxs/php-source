var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request), _image = require("../../util/image.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

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
        var s = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var e = s.data.edulesson.id, t = s.data.pindex, a = s.data.psize;
        _request2.default.post("edumessage", {
            op: "getmore",
            lessonid: e,
            pindex: t,
            psize: a
        }).then(function(e) {
            var t = s.data.list;
            1 == s.data.pindex && (t = []);
            var a = e;
            a.length < s.data.psize ? s.setData({
                list: t.concat(a),
                hasMore: !1
            }) : s.setData({
                list: t.concat(a),
                hasMore: !0,
                pindex: s.data.pindex + 1
            }), wx.hideToast();
        });
    },
    previewImage: function(e) {
        var t = e.target.dataset.messageid, a = e.target.dataset.src;
        wx.previewImage({
            current: a,
            urls: this.data.list[t].picall
        });
    },
    chooseImage: function() {
        var t = this, a = t.data.picall;
        (0, _image.chooseImage)().then(function(e) {
            if (!(9 <= a.length)) return (0, _image.upload)(e);
            wx.showToast({
                title: "最多上传九张"
            });
        }, function(e) {
            wx.showToast({
                title: "选择图片失败"
            });
        }).then(function(e) {
            a = a.concat(e.filename), t.setData({
                picall: a
            }), console.log(a);
        }, function(e) {
            wx.showToast({
                title: "图片上传失败"
            });
        });
    },
    picclearImage: function(e) {
        var t = e.currentTarget.dataset.index, a = this.data.picall;
        a.splice(t, 1), this.setData({
            picall: a
        });
    },
    formSubmit: function(e) {
        var t = this, a = e.detail.value.details;
        if (0 == a.length) wx.showModal({
            title: "提示",
            content: "评论内容不能为空",
            showCancel: !1,
            success: function(e) {}
        }); else {
            var s = t.data.edulesson.id, i = t.data.user.id, n = JSON.stringify(t.data.picall);
            _request2.default.post("edumessage", {
                op: "addmessage",
                lessonid: s,
                userid: i,
                details: a,
                picall: n
            }).then(function(e) {
                wx.showModal({
                    title: "提示",
                    content: "留言评论提交成功！",
                    showCancel: !1,
                    success: function(e) {
                        e.confirm && (t.data.pindex = 1, t.getMore(), t.setData({
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
    delMessage: function(e) {
        var a = this, t = e.target.dataset.messageid, s = e.target.dataset.index, i = a.data.user.id;
        _request2.default.post("edumessage", {
            op: "delmessage",
            messageid: t,
            userid: i
        }).then(function(e) {
            var t = a.data.list;
            t.splice(s, 1), a.setData({
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
    onLoad: function(e) {
        var t = this, a = wx.getStorageSync("attachurl") || "", s = wx.getStorageSync("param") || null, i = wx.getStorageSync("user") || null;
        t.setData({
            attachurl: a,
            param: s,
            user: i
        }), null == i && wx.redirectTo({
            url: "../login/login"
        });
        var n = e.lessonid;
        i.id;
        _request2.default.get("edumessage", {
            lessonid: n
        }).then(function(e) {
            t.setData({
                edulesson: e.edulesson,
                educate: e.educate
            }), t.getMore();
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