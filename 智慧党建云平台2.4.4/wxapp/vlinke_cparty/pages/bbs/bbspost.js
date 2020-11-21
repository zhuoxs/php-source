var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request), _image = require("../../util/image.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp();

Page({
    data: {
        cateid: 0,
        details: "",
        picall: []
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
            }), console.log(a);
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
        var e = this, a = e.data.cateid, n = e.data.user.id, i = t.detail.value.title, o = t.detail.value.details, s = JSON.stringify(e.data.picall);
        0 == a ? wx.showModal({
            title: "提示",
            content: "请选择话题分类！",
            showCancel: !1,
            success: function(t) {}
        }) : 0 == i.length || 0 == o.length ? wx.showModal({
            title: "提示",
            content: "标题和内容均不能为空！",
            showCancel: !1,
            success: function(t) {}
        }) : _request2.default.post("bbspost", {
            op: "addpost",
            cateid: a,
            userid: n,
            title: i,
            details: o,
            picall: s
        }).then(function(t) {
            wx.showModal({
                title: "提示",
                content: "话题提交成功！",
                showCancel: !1,
                success: function(t) {
                    wx.redirectTo({
                        url: "../bbs/bbshome"
                    });
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
    },
    onLoad: function(t) {
        var e = this, a = wx.getStorageSync("attachurl") || "", n = wx.getStorageSync("param") || null, i = wx.getStorageSync("user") || null;
        e.setData({
            attachurl: a,
            param: n,
            user: i
        }), null == i && wx.redirectTo({
            url: "../login/login"
        });
        var o = i.scort;
        _request2.default.get("bbspost", {
            userscort: o
        }).then(function(t) {
            e.setData({
                cate: t.cate
            });
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
    bindCateidChange: function(t) {
        var e = t.detail.value, a = this.data.cate[e].id;
        this.setData({
            cateid: a,
            index: e
        });
    },
    onReady: function() {
        app.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: this.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: this.data.param.wxappshareimageurl
        };
    }
});