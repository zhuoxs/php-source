var t = function(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}(require("../../util/request.js")), e = (require("../../util/image.js"), getApp());

Page({
    data: {
        sex: 1,
        sexarr: [ {
            id: 1,
            name: "男"
        }, {
            id: 2,
            name: "女"
        } ],
        sexindex: 0,
        birthday: "",
        partyday: "",
        today: ""
    },
    sexChange: function(t) {
        this.setData({
            sex: t.detail.value
        });
    },
    birthdayChange: function(t) {
        this.setData({
            birthday: t.detail.value
        });
    },
    partydayChange: function(t) {
        this.setData({
            partyday: t.detail.value
        });
    },
    formSubmit: function(e) {
        var a = this, n = e.detail.value.mobile;
        if (!/(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/.test(n)) return wx.showModal({
            title: "提示",
            content: "手机号不正确！",
            showCancel: !1,
            success: function(t) {}
        }), !1;
        var i = a.data.sex, o = e.detail.value.nation, r = a.data.birthday, s = e.detail.value.origin, u = e.detail.value.education, c = a.data.partyday, l = a.data.user.id;
        t.default.post("myinfo", {
            op: "postinfo",
            userid: l,
            mobile: n,
            sex: i,
            nation: o,
            birthday: r,
            origin: s,
            education: u,
            partyday: c
        }).then(function(t) {
            wx.showModal({
                title: "提示",
                content: "修改成功！",
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.navigateBack();
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
    headpicChoose: function() {
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                var e = t.tempFilePaths[0];
                wx.redirectTo({
                    url: "../my/myinfoupload?src=" + e
                });
            }
        });
    },
    userUntie: function() {
        var e = this.data.user.id;
        t.default.post("login", {
            op: "untie",
            userid: e
        }).then(function(t) {
            wx.showModal({
                title: "提示",
                content: "成功解绑当前微信号！",
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.reLaunch({
                        url: "../home/home"
                    });
                }
            });
        }, function(t) {
            wx.showModal({
                title: "提示",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.reLaunch({
                        url: "../login/login"
                    });
                }
            });
        });
    },
    onLoad: function(a) {
        var n = this, i = wx.getStorageSync("param") || null, o = wx.getStorageSync("user") || null;
        n.setData({
            param: i,
            user: o
        }), null == o && wx.redirectTo({
            url: "../login/login"
        });
        var r = new e.util.date();
        n.setData({
            today: r.dateToStr("yyyy-MM-dd")
        });
        var s = o.id;
        t.default.post("myinfo", {
            userid: s
        }).then(function(t) {
            n.setData({
                user: t.user,
                ulevel: t.ulevel,
                sex: t.user.sex,
                birthday: t.user.birthday,
                partyday: t.user.partyday,
                headpic: t.headpic
            });
        }, function(t) {
            wx.showModal({
                title: "提示",
                content: t,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.redirectTo({
                        url: "../login/login"
                    });
                }
            });
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
        e.util.footer(this);
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