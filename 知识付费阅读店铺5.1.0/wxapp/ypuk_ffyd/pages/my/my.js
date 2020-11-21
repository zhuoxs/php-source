var _global = require("../../resource/js/global.js"), _global2 = _interopRequireDefault(_global);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp(), WxParse = require("../../resource/wxParse/wxParse.js");

Page({
    data: {
        userInfo: [],
        setting: [],
        menutext: [ "我喜欢的", "我购买的", "订阅专栏", "我评论的", "会员服务" ],
        menudata: [ {
            imgsrc: "../../resource/images/fav.png",
            url: "../../pages/myfav/myfav",
            id: "favlist"
        }, {
            imgsrc: "../../resource/images/cat.png",
            url: "../../pages/myrecord/myrecord",
            id: "recordlist"
        }, {
            imgsrc: "../../resource/images/cat.png",
            url: "../../pages/mypackage/mypackage",
            id: "mypackage"
        }, {
            imgsrc: "../../resource/images/comment.png",
            url: "../../pages/mycomment/mycomment",
            id: "mycomment"
        }, {
            imgsrc: "../../resource/images/vip.png",
            url: "../../pages/buyvip/buyvip",
            id: "buyvip"
        } ],
        loginModelHidden: !0
    },
    onLoad: function() {
        var t = this, e = wx.getStorageSync("userInfo");
        e && 0 != e.memberInfo.uid && "" != e.memberInfo ? (t.setData({
            userId: e.memberInfo.uid
        }), t.GetHelpExamineSetting()) : wx.getSetting({
            success: function(e) {
                0 == e.authSetting["scope.userInfo"] ? wx.showModal({
                    title: "提示",
                    content: "允许小程序获取您的用户信息后才可阅读文章哦",
                    showCancel: !1,
                    success: function(e) {
                        e.confirm && wx.openSetting({
                            success: function(e) {
                                1 == e.authSetting["scope.userInfo"] && (t.setData({
                                    loginModelHidden: !1
                                }), wx.removeStorageSync("userInfo"));
                            }
                        });
                    }
                }) : (wx.removeStorageSync("userInfo"), t.setData({
                    loginModelHidden: !1
                }));
            }
        }), wx.hideShareMenu();
    },
    updateUserInfo: function(e) {
        var t = this;
        app.util.getUserInfo(function(e) {
            e = wx.getStorageSync("userInfo");
            t.setData({
                userId: e.memberInfo.uid,
                loginModelHidden: !0
            }), t.GetHelpExamineSetting();
        }, e.detail);
    },
    onShow: function() {},
    onShareAppMessage: function() {},
    GetHelpExamineSetting: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/GetHelpExamineSetting",
            cachetime: "0",
            data: {
                version: _global2.default.ClientVersion,
                appos: _global2.default.systemInfo()
            },
            success: function(e) {
                t.setData({
                    helpExamine: e.data.data
                }), WxParse.wxParse("HelpExamineMy", "html", e.data.data.help_examine_my, t, 20), 
                1 != e.data.data.help_examine_open && (t.GetUserInfo(), t.GetKeFuSetting());
            }
        });
    },
    GetKeFuSetting: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/getsetting",
            cachetime: "0",
            success: function(e) {
                t.setData({
                    setting: e.data.data
                });
            }
        });
    },
    GoKefuQr: function() {
        wx.previewImage({
            current: this.data.setting.kefuqr,
            urls: this.data.setting.kefuqr
        });
    },
    GetUserInfo: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/getuserinfo",
            cachetime: "0",
            data: {
                uid: t.data.userId
            },
            success: function(e) {
                t.setData({
                    userInfo: e.data.data
                });
            }
        });
    }
});