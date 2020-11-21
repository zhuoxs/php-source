var t = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), e = (require("../../util/image.js"), getApp());

Page({
    data: {
        title: "",
        luserid: 0,
        realname: "",
        mobile: "",
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
        t.default.get("supmailbox", {
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
    radioChange: function(t) {
        this.setData({
            luserid: t.detail.value
        });
    },
    formSubmit: function(e) {
        var a = this, i = e.detail.value.title, n = e.detail.value.realname, s = e.detail.value.mobile, o = e.detail.value.details, l = a.data.luserid;
        if (0 == l) wx.showModal({
            title: "提示",
            content: "请选择信息收件人",
            showCancel: !1,
            success: function(t) {}
        }); else if (0 == i.length) wx.showModal({
            title: "提示",
            content: "内容主题不能为空",
            showCancel: !1,
            success: function(t) {}
        }); else if (0 == o.length) wx.showModal({
            title: "提示",
            content: "内容详情不能为空",
            showCancel: !1,
            success: function(t) {}
        }); else {
            var r = a.data.user.id, u = JSON.stringify(a.data.picall);
            t.default.post("supmailbox", {
                op: "post",
                userid: r,
                luserid: l,
                title: i,
                realname: n,
                mobile: s,
                details: o,
                picall: u
            }).then(function(t) {
                wx.showModal({
                    title: "提示",
                    content: "提交成功！",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && (a.data.pindex = 1, a.getMore(), a.setData({
                            title: "",
                            realname: a.data.user.realname,
                            mobile: a.data.user.mobile,
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
    onLoad: function(e) {
        var a = this, i = wx.getStorageSync("attachurl") || "", n = wx.getStorageSync("param") || null, s = wx.getStorageSync("user") || null;
        a.setData({
            attachurl: i,
            param: n,
            user: s,
            realname: s.realname,
            mobile: s.mobile
        }), null == s && wx.redirectTo({
            url: "../login/login"
        });
        var o = s.branchid;
        t.default.get("supmailbox", {
            branchid: o
        }).then(function(t) {
            a.setData({
                brancharr: t.brancharr
            });
        }, function(t) {
            wx.showModal({
                title: "提示信息",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../sup/supmailbox"
                    });
                }
            });
        }), a.getMore();
    },
    clickTab: function(t) {
        var e = this;
        if (this.data.currentTab === t.target.dataset.current) return !1;
        e.setData({
            currentTab: t.target.dataset.current
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
        0 != this.data.currentTab && (this.data.hasMore ? this.getMore() : wx.showToast({
            title: "没有更多数据"
        }));
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