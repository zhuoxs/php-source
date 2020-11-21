var t = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), e = require("../../util/image.js"), a = getApp();

Page({
    data: {
        title: "",
        details: "",
        picall: [],
        currentTab: 0
    },
    previewImage: function(t) {
        var e = this, a = t.target.dataset.messageid, n = t.target.dataset.src;
        wx.previewImage({
            current: n,
            urls: e.data.list[a].picall
        });
    },
    chooseImage: function() {
        var t = this, a = t.data.picall;
        (0, e.chooseImage)().then(function(t) {
            if (!(a.length >= 9)) return (0, e.upload)(t);
            wx.showToast({
                title: "最多上传九张"
            });
        }, function(t) {
            wx.showToast({
                title: "选择图片失败"
            });
        }).then(function(e) {
            a = a.concat(e.filename), t.setData({
                picall: a
            }), console.log(a);
        }, function(t) {
            wx.showToast({
                title: "图片上传失败"
            });
        });
    },
    picclearImage: function(t) {
        var e = this, a = t.currentTarget.dataset.index, n = e.data.picall;
        n.splice(a, 1), e.setData({
            picall: n
        });
    },
    formSubmit: function(e) {
        var a = this, n = e.detail.value.title, i = e.detail.value.details;
        if (0 == n.length) wx.showModal({
            title: "提示",
            content: "内容主题不能为空",
            showCancel: !1,
            success: function(t) {}
        }); else if (0 == i.length) wx.showModal({
            title: "提示",
            content: "内容详情不能为空",
            showCancel: !1,
            success: function(t) {}
        }); else {
            var o = JSON.stringify(a.data.picall);
            t.default.post("supreport", {
                op: "post",
                title: n,
                details: i,
                picall: o
            }).then(function(t) {
                wx.showModal({
                    title: "提示",
                    content: "提交成功！",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && a.setData({
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
        var e = this, a = wx.getStorageSync("attachurl") || "", n = wx.getStorageSync("param") || null, i = wx.getStorageSync("user") || null;
        e.setData({
            attachurl: a,
            param: n,
            user: i
        });
    },
    clickTab: function(t) {
        var e = this;
        if (this.data.currentTab === t.target.dataset.current) return !1;
        e.setData({
            currentTab: t.target.dataset.current
        });
    },
    onReady: function() {
        a.util.footer(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var t = this;
        return {
            title: t.data.param.wxappsharetitle,
            path: "/vlinke_cparty/pages/home/home",
            imageUrl: t.data.param.wxappshareimageurl
        };
    }
});