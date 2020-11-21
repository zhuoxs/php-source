var _request = require("../../util/request.js"), _request2 = _interopRequireDefault(_request), _image = require("../../util/image.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

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
    sexChange: function(e) {
        this.setData({
            sex: e.detail.value
        });
    },
    birthdayChange: function(e) {
        this.setData({
            birthday: e.detail.value
        });
    },
    partydayChange: function(e) {
        this.setData({
            partyday: e.detail.value
        });
    },
    formSubmit: function(e) {
        var t = this, a = e.detail.value.mobile;
        if (!/(^1[3|4|5|7|8]\d{9}$)|(^09\d{8}$)/.test(a)) return wx.showModal({
            title: "提示",
            content: "手机号不正确！",
            showCancel: !1,
            success: function(e) {}
        }), !1;
        var n = t.data.sex, i = e.detail.value.nation, o = t.data.birthday, r = e.detail.value.origin, u = e.detail.value.education, s = t.data.partyday, c = t.data.user.id;
        _request2.default.post("myinfo", {
            op: "postinfo",
            userid: c,
            mobile: a,
            sex: n,
            nation: i,
            birthday: o,
            origin: r,
            education: u,
            partyday: s
        }).then(function(e) {
            wx.showModal({
                title: "提示",
                content: "修改成功！",
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.navigateBack();
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
    },
    headpicChoose: function() {
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                var t = e.tempFilePaths[0];
                wx.redirectTo({
                    url: "../my/myinfoupload?src=" + t
                });
            }
        });
    },
    userUntie: function() {
        var e = this.data.user.id;
        _request2.default.post("login", {
            op: "untie",
            userid: e
        }).then(function(e) {
            wx.showModal({
                title: "提示",
                content: "成功解绑当前微信号！",
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.reLaunch({
                        url: "../home/home"
                    });
                }
            });
        }, function(e) {
            wx.showModal({
                title: "提示",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.reLaunch({
                        url: "../login/login"
                    });
                }
            });
        });
    },
    onLoad: function(e) {
        var t = this, a = wx.getStorageSync("param") || null, n = wx.getStorageSync("user") || null;
        t.setData({
            param: a,
            user: n
        }), null == n && wx.redirectTo({
            url: "../login/login"
        });
        var i = new app.util.date();
        t.setData({
            today: i.dateToStr("yyyy-MM-dd")
        });
        var o = n.id;
        _request2.default.post("myinfo", {
            userid: o
        }).then(function(e) {
            t.setData({
                user: e.user,
                ulevel: e.ulevel,
                sex: e.user.sex,
                birthday: e.user.birthday,
                partyday: e.user.partyday,
                headpic: e.headpic
            });
        }, function(e) {
            wx.showModal({
                title: "提示",
                content: e,
                showCancel: !1,
                success: function(e) {
                    e.confirm && wx.redirectTo({
                        url: "../login/login"
                    });
                }
            });
        });
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