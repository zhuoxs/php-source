var userinfoutil = {}, app = getApp(), util = require("../js/util.js");

userinfoutil.getOpenId = function(o) {
    var n = this;
    "" == app.globalData.openId ? app.util.request({
        url: "entry/wxapp/GetUid",
        data: {
            code: o
        },
        success: function(o) {
            var e = o.data.data;
            if (wx.hideLoading(), console.log(o.data), null != e) {
                if (console.log("获取用户openID:" + e.userinfo.openid), null != app.globalData.userInfo && "" != app.globalData.openId) {
                    var a = wx.getStorageSync("have_status_user");
                    console.log("have_user:" + a), a && (console.log("检查一次用户信息"), n.check_user_have());
                }
                app.globalData.openId = e.openid, wx.setStorageSync("openId", e.openid);
            } else console.log("======解析失败==openid=======");
        }
    }) : wx.setStorageSync("openId", app.globalData.openId);
}, userinfoutil.getUserinfo_det = function(o) {
    var e = this, a = wx.getStorageSync("openId");
    "" != a && null != a ? (app.globalData.openId = a, console.log("缓存Store:" + app.globalData.openId)) : "" == app.globalData.openId && null != app.globalData.openId ? e.getOpenId(o) : console.log("缓存App:" + app.globalData.openId);
    var n = wx.getStorageSync("ubinfo");
    "" != n && null != n ? (app.globalData.userInfo = n, console.log("缓存stroe:" + JSON.stringify(n))) : null == app.globalData.userInfo && (wx.getUserInfo({
        success: function(o) {
            var e = o.userInfo;
            console.log("实时用户信息>>>"), console.log(e), app.globalData.userInfo = e, wx.setStorageSync("ubinfo", e);
        }
    }), setTimeout(function() {
        "" == app.globalData.openId && wx.login({
            success: function(o) {
                o.code && e.getOpenId(o.code);
            }
        });
    }, 1500)), setTimeout(function() {
        if (null != app.globalData.userInfo && "" != app.globalData.openId) {
            var o = wx.getStorageSync("have_status_user");
            console.log("have_user:" + o), o && (console.log("检查一次用户信息"), e.check_user_have());
        }
    }, 1200);
}, userinfoutil.getUserinfo = function() {
    var a = this;
    wx.login({
        success: function(e) {
            e.code && wx.getUserInfo({
                success: function(o) {
                    a.getUserinfo_det(e.code);
                },
                fail: function() {
                    wx.showModal({
                        title: "提示",
                        content: "授权获取用户信息失败,将不可发布消息和评论!",
                        confirmText: "去设置",
                        success: function(o) {
                            o.confirm ? wx.openSetting({
                                success: function(o) {
                                    o && (1 == o.authSetting["scope.userInfo"] ? (console.log("取得用户信息授权成功"), wx.login({
                                        success: function(o) {
                                            o.code && a.getUserinfo_det(o.code);
                                        }
                                    })) : a.getUserinfo());
                                }
                            }) : a.getUserinfo();
                        }
                    });
                }
            });
        }
    });
}, userinfoutil.check_user_have = function() {
    var o = {};
    o.u_unionid = app.globalData.unionId, o.u_openid = app.globalData.openId, o.u_nickname = app.globalData.userInfo.nickName, 
    o.u_city = app.globalData.userInfo.city, o.u_avatarurl = app.globalData.userInfo.avatarUrl, 
    o.u_gender = app.globalData.userInfo.gender, o.u_province = app.globalData.userInfo.province, 
    o.u_country = app.globalData.userInfo.country, "" != o.u_openid && app.util.request({
        url: "entry/wxapp/check_user_have",
        data: o,
        success: function(o) {
            console.log("检查用户信息:"), console.log(o.data.data), wx.setStorageSync("have_status_user", o.data.data.user_have);
        }
    });
}, userinfoutil.pay_user_account = function() {}, userinfoutil.pay_wx_api = function() {}, 
userinfoutil.gps_loc = function() {}, module.exports = userinfoutil;