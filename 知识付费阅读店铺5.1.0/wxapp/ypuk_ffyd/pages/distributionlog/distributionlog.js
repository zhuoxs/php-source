var _global = require("../../resource/js/global.js"), _global2 = _interopRequireDefault(_global);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp();

Page({
    data: {
        logList: [],
        userId: "",
        page: 1,
        noMoreHidden: !0,
        type: 1
    },
    onLoad: function() {
        var e = this, t = wx.getStorageSync("userInfo");
        t && 0 != t.memberInfo.uid && "" != t.memberInfo ? (e.setData({
            userId: t.memberInfo.uid
        }), e.GetList()) : wx.getSetting({
            success: function(t) {
                0 == t.authSetting["scope.userInfo"] ? wx.showModal({
                    title: "提示",
                    content: "允许小程序获取您的用户信息后才可参与砍价哦",
                    showCancel: !1,
                    success: function(t) {
                        t.confirm && wx.openSetting({
                            success: function(t) {
                                1 == t.authSetting["scope.userInfo"] && (e.setData({
                                    loginModelHidden: !1
                                }), wx.removeStorageSync("userInfo"));
                            }
                        });
                    }
                }) : (wx.removeStorageSync("userInfo"), e.setData({
                    loginModelHidden: !1
                }));
            }
        }), wx.hideShareMenu();
    },
    onPullDownRefresh: function() {
        this.setData({
            logList: [],
            page: 1
        }), this.GetList(), setTimeout(function() {
            wx.stopPullDownRefresh();
        }, 1e3);
    },
    onReachBottom: function() {
        var t = this, e = t.data.page;
        t.setData({
            page: e + 1
        }), t.GetList();
    },
    bindType: function(t) {
        var e = this, a = t.currentTarget.dataset.type;
        e.setData({
            type: a
        }), e.setData({
            logList: [],
            page: 1
        }), e.GetList();
    },
    GetList: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/getdistributionloglist",
            data: {
                page: e.data.page,
                type: e.data.type,
                uid: e.data.userId
            },
            cachetime: "0",
            success: function(t) {
                t.data.data && 0 < t.data.data.length ? e.setData({
                    logList: e.data.logList.concat(t.data.data)
                }) : e.setData({
                    noMoreHidden: !1
                });
            }
        });
    }
});