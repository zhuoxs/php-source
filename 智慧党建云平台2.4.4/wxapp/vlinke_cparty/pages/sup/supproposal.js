var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request), _image = require("../../util/image.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Page({
    data: {
        title: "",
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
        var i = this;
        wx.showToast({
            title: "加载中",
            icon: "loading"
        });
        var e = i.data.pindex, t = i.data.psize, a = i.data.user.id;
        _request2.default.get("supproposal", {
            op: "getmore",
            userid: a,
            pindex: e,
            psize: t
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
    formSubmit: function(e) {
        var t = this, a = e.detail.value.title, i = e.detail.value.realname, n = e.detail.value.mobile, s = e.detail.value.details;
        if (0 == a.length) wx.showModal({
            title: "提示",
            content: "内容主题不能为空",
            showCancel: !1,
            success: function(e) {}
        }); else if (0 == s.length) wx.showModal({
            title: "提示",
            content: "内容详情不能为空",
            showCancel: !1,
            success: function(e) {}
        }); else {
            var o = t.data.user.id, l = JSON.stringify(t.data.picall);
            _request2.default.post("supproposal", {
                op: "post",
                userid: o,
                title: a,
                realname: i,
                mobile: n,
                details: s,
                picall: l
            }).then(function(e) {
                wx.showModal({
                    title: "提示",
                    content: "提交成功！",
                    showCancel: !1,
                    success: function(e) {
                        e.confirm && (t.data.pindex = 1, t.getMore(), t.setData({
                            title: "",
                            realname: t.data.user.realname,
                            mobile: t.data.user.mobile,
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
        var a = this, t = e.target.dataset.messageid, i = e.target.dataset.index, n = a.data.user.id;
        _request2.default.post("artmessage", {
            op: "delmessage",
            messageid: t,
            userid: n
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
        var t = wx.getStorageSync("attachurl") || "", a = wx.getStorageSync("param") || null, i = wx.getStorageSync("user") || null;
        null == i && wx.redirectTo({
            url: "../login/login"
        }), this.setData({
            attachurl: t,
            param: a,
            user: i,
            realname: i.realname,
            mobile: i.mobile
        }), null == i && wx.redirectTo({
            url: "../login/login"
        }), this.getMore();
    },
    clickTab: function(e) {
        if (this.data.currentTab === e.target.dataset.current) return !1;
        this.setData({
            currentTab: e.target.dataset.current
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