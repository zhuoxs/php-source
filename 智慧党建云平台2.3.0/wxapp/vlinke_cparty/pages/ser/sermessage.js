var t = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), e = require("../../util/image.js"), a = getApp();

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
        var e = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var a = e.data.seritem.id, i = e.data.pindex, s = e.data.psize;
        t.default.post("sermessage", {
            op: "getmore",
            itemid: a,
            pindex: i,
            psize: s
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
            });
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
        var a = this, i = e.detail.value.details;
        if (0 == i.length) wx.showModal({
            title: "提示",
            content: "评论内容不能为空",
            showCancel: !1,
            success: function(t) {}
        }); else {
            var s = a.data.seritem.id, n = a.data.user.id, o = JSON.stringify(a.data.picall);
            t.default.post("sermessage", {
                op: "addmessage",
                itemid: s,
                userid: n,
                details: i,
                picall: o
            }).then(function(t) {
                wx.showModal({
                    title: "提示",
                    content: "留言评论提交成功！",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && (a.data.pindex = 1, a.getMore(), a.setData({
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
        var a = this, i = e.target.dataset.messageid, s = e.target.dataset.index, n = a.data.user.id;
        t.default.post("sermessage", {
            op: "delmessage",
            messageid: i,
            userid: n
        }).then(function(t) {
            var e = a.data.list;
            e.splice(s, 1), a.setData({
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
    onLoad: function(e) {
        var a = this, i = wx.getStorageSync("attachurl") || "", s = wx.getStorageSync("param") || null, n = wx.getStorageSync("user") || null;
        a.setData({
            attachurl: i,
            param: s,
            user: n
        }), null == n && wx.redirectTo({
            url: "../login/login"
        });
        var o = e.itemid;
        null == n || n.id;
        t.default.get("sermessage", {
            itemid: o
        }).then(function(t) {
            a.setData({
                seritem: t.seritem,
                sercate: t.sercate,
                branch: t.branch
            }), a.getMore();
        }, function(t) {
            wx.showModal({
                title: "提示",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../ser/serhome"
                    });
                }
            }), console.log(t);
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