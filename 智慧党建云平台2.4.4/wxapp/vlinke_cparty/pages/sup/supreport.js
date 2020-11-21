var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request), _image = require("../../util/image.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp();

Page({
    data: {
        title: "",
        details: "",
        picall: [],
        currentTab: 0
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
        var e = this, a = t.detail.value.title, n = t.detail.value.details;
        if (0 == a.length) wx.showModal({
            title: "提示",
            content: "内容主题不能为空",
            showCancel: !1,
            success: function(t) {}
        }); else if (0 == n.length) wx.showModal({
            title: "提示",
            content: "内容详情不能为空",
            showCancel: !1,
            success: function(t) {}
        }); else {
            var i = JSON.stringify(e.data.picall);
            _request2.default.post("supreport", {
                op: "post",
                title: a,
                details: n,
                picall: i
            }).then(function(t) {
                wx.showModal({
                    title: "提示",
                    content: "提交成功！",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && e.setData({
                            title: "",
                            details: "",
                            picall: []
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
        }
    },
    onLoad: function(t) {
        var e = wx.getStorageSync("attachurl") || "", a = wx.getStorageSync("param") || null, n = wx.getStorageSync("user") || null;
        this.setData({
            attachurl: e,
            param: a,
            user: n
        });
    },
    clickTab: function(t) {
        if (this.data.currentTab === t.target.dataset.current) return !1;
        this.setData({
            currentTab: t.target.dataset.current
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