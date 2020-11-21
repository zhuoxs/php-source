var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request), _image = require("../../util/image.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
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
    chooseImage: function() {
        var e = this, a = e.data.picall;
        (0, _image.chooseImage)().then(function(t) {
            if (!(9 <= a.length)) return (0, _image.upload)(t);
            wx.showToast({
                title: "最多上传九张"
            });
        }, function(t) {
            wx.showToast({
                title: "选择图片失败"
            });
        }).then(function(t) {
            a = a.concat(t.filename), e.setData({
                picall: a
            });
        }, function(t) {
            wx.showToast({
                title: "图片上传失败"
            });
        });
    },
    picclearImage: function(t) {
        var e = t.currentTarget.dataset.index, a = this.data.picall;
        a.splice(e, 1), this.setData({
            picall: a
        });
    },
    formSubmit: function(t) {
        var e = this, a = t.detail.value.details;
        if (0 == a.length) wx.showModal({
            title: "提示",
            content: "评论内容不能为空",
            showCancel: !1,
            success: function(t) {}
        }); else {
            var i = e.data.activity.id, s = e.data.user.id, n = JSON.stringify(e.data.picall);
            _request2.default.post("actmessage", {
                op: "addmessage",
                activityid: i,
                userid: s,
                details: a,
                picall: n
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
    delMessage: function(t) {
        var a = this, e = t.target.dataset.messageid, i = t.target.dataset.index, s = a.data.user.id;
        _request2.default.post("actmessage", {
            op: "delmessage",
            messageid: e,
            userid: s
        }).then(function(t) {
            var e = a.data.list;
            e.splice(i, 1), a.setData({
                list: e
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
    onLoad: function(t) {
        var e = this, a = wx.getStorageSync("attachurl") || "", i = wx.getStorageSync("param") || null, s = wx.getStorageSync("user") || null;
        e.setData({
            attachurl: a,
            param: i,
            user: s
        }), null == s && wx.redirectTo({
            url: "../login/login"
        });
        var n = t.activityid;
        s.id;
        _request2.default.get("actmessage", {
            activityid: n
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