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
        pindex: 1,
        psize: 5,
        hasMore: !0,
        list: [],
        currentTab: 0
    },
    getMore: function() {
        var e = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var a = e.data.pindex, i = e.data.psize, n = e.data.user.id;
        t.default.get("supreadily", {
            op: "getmore",
            userid: n,
            pindex: a,
            psize: i
        }).then(function(t) {
            var a = e.data.list;
            1 == e.data.pindex && (a = []);
            var i = t;
            i.length < e.data.psize ? e.setData({
                list: a.concat(i),
                hasMore: !1
            }) : e.setData({
                list: a.concat(i),
                hasMore: !0,
                pindex: e.data.pindex + 1
            }), wx.hideToast();
        });
    },
    previewImage: function(t) {
        var e = this, a = t.target.dataset.messageid, i = t.target.dataset.src;
        wx.previewImage({
            current: i,
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
        var e = this, a = t.currentTarget.dataset.index, i = e.data.picall;
        i.splice(a, 1), e.setData({
            picall: i
        });
    },
    formSubmit: function(e) {
        var a = this, i = e.detail.value.title, n = e.detail.value.details;
        if (0 == i.length) wx.showModal({
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
            var s = a.data.user.id, o = JSON.stringify(a.data.picall);
            t.default.post("supreadily", {
                op: "post",
                userid: s,
                title: i,
                details: n,
                picall: o
            }).then(function(t) {
                wx.showModal({
                    title: "提示",
                    content: "提交成功！",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && (a.data.pindex = 1, a.getMore(), a.setData({
                            title: "",
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
    delMessage: function(e) {
        var a = this, i = e.target.dataset.messageid, n = e.target.dataset.index, s = a.data.user.id;
        t.default.post("artmessage", {
            op: "delmessage",
            messageid: i,
            userid: s
        }).then(function(t) {
            var e = a.data.list;
            e.splice(n, 1), a.setData({
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
        var e = this, a = wx.getStorageSync("attachurl") || "", i = wx.getStorageSync("param") || null, n = wx.getStorageSync("user") || null;
        null == n && wx.redirectTo({
            url: "../login/login"
        }), e.setData({
            attachurl: a,
            param: i,
            user: n
        }), e.getMore();
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