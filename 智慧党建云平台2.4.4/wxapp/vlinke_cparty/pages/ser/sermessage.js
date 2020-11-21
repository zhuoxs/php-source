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
        var i = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var e = i.data.seritem.id, t = i.data.pindex, a = i.data.psize;
        _request2.default.post("sermessage", {
            op: "getmore",
            itemid: e,
            pindex: t,
            psize: a
        }).then(function(e) {
            var t = i.data.list;
            1 == i.data.pindex && (t = []);
            var a = e;
            a.length < i.data.psize ? i.setData({
                list: t.concat(a),
                hasMore: !1
            }) : i.setData({
                list: t.concat(a),
                hasMore: !0,
                pindex: i.data.pindex + 1
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
            });
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
            var i = t.data.seritem.id, s = t.data.user.id, n = JSON.stringify(t.data.picall);
            _request2.default.post("sermessage", {
                op: "addmessage",
                itemid: i,
                userid: s,
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
        var a = this, t = e.target.dataset.messageid, i = e.target.dataset.index, s = a.data.user.id;
        _request2.default.post("sermessage", {
            op: "delmessage",
            messageid: t,
            userid: s
        }).then(function(e) {
            var t = a.data.list;
            t.splice(i, 1), a.setData({
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
        var t = this, a = wx.getStorageSync("attachurl") || "", i = wx.getStorageSync("param") || null, s = wx.getStorageSync("user") || null;
        t.setData({
            attachurl: a,
            param: i,
            user: s
        }), null == s && wx.redirectTo({
            url: "../login/login"
        });
        var n = e.itemid;
        null == s || s.id;
        _request2.default.get("sermessage", {
            itemid: n
        }).then(function(e) {
            t.setData({
                seritem: e.seritem,
                sercate: e.sercate,
                branch: e.branch
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