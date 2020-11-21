var _global = require("../../resource/js/global.js"), _global2 = _interopRequireDefault(_global);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp();

Page({
    data: {
        userList: [],
        userId: "",
        page: 1,
        noMoreHidden: !0
    },
    onLoad: function() {
        var t = this, e = wx.getStorageSync("userInfo");
        e && 0 != e.memberInfo.uid && "" != e.memberInfo ? (t.setData({
            userId: e.memberInfo.uid
        }), t.GetList()) : wx.getSetting({
            success: function(e) {
                0 == e.authSetting["scope.userInfo"] ? wx.showModal({
                    title: "提示",
                    content: "允许小程序获取您的用户信息后才可参与砍价哦",
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
    onPullDownRefresh: function() {
        this.setData({
            userList: [],
            page: 1
        }), this.GetList(), setTimeout(function() {
            wx.stopPullDownRefresh();
        }, 1e3);
    },
    onReachBottom: function() {
        var e = this, t = e.data.page;
        e.setData({
            page: t + 1
        }), e.GetList();
    },
    GetList: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/getdistributionuserlist",
            data: {
                page: t.data.page,
                uid: t.data.userId
            },
            cachetime: "0",
            success: function(e) {
                e.data.data && 0 < e.data.data.length ? t.setData({
                    userList: t.data.userList.concat(e.data.data)
                }) : t.setData({
                    noMoreHidden: !1
                });
            }
        });
    }
});