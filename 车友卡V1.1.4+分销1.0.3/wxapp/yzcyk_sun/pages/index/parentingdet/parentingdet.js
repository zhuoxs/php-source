var app = getApp(), WxParse = require("../../wxParse/wxParse.js");

Page({
    data: {
        navTile: "活动详情",
        isOver: 1,
        active: {},
        vipType: 0,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        var o = this;
        wx.setNavigationBarTitle({
            title: o.data.navTile
        });
        var e = wx.getStorageSync("setting");
        e ? wx.setNavigationBarColor({
            frontColor: e.fontcolor,
            backgroundColor: e.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        }), o.setData({
            id: t.id || ""
        }), app.get_imgroot().then(function(t) {
            o.setData({
                imgroot: t
            });
        });
    },
    onReady: function() {},
    onShow: function() {
        var o = this;
        app.get_user_vip().then(function(t) {
            console.log(t), o.setData({
                vipType: t
            });
        }), "" != o.data.id ? app.util.request({
            url: "entry/wxapp/getActivityDetail",
            cachetime: "0",
            data: {
                id: o.data.id
            },
            success: function(t) {
                o.setData({
                    active: t.data
                });
            }
        }) : wx.showModal({
            title: "提示",
            content: "该活动不存在",
            showCancel: !1,
            success: function(t) {
                wx.navigateBack({});
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toDialog: function(t) {
        var o = t.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: o
        });
    },
    toActiveJoin: function(t) {
        wx.navigateTo({
            url: "../activejoin2/activejoin2?id=" + this.data.active.id
        });
    },
    toIndex: function(t) {
        wx.navigateTo({
            url: "../index"
        });
    },
    toJoin: function(t) {
        wx.showModal({
            title: "提示",
            content: "您还不是会员",
            confirmText: "去开卡",
            confirmColor: "#ff5e5e",
            success: function(t) {
                t.confirm && wx.navigateTo({
                    url: "/yzcyk_sun/pages/member/joinmember/joinmember"
                });
            }
        });
    },
    toMap: function(t) {
        var o = parseFloat(this.data.active.store.latitude), e = parseFloat(this.data.active.store.longitude);
        wx.getLocation({
            type: "gcj02",
            success: function(t) {
                wx.openLocation({
                    latitude: o,
                    longitude: e,
                    scale: 28
                });
            }
        });
    },
    toMemberjoin: function(t) {
        wx.navigateTo({
            url: "/yzcyk_sun/pages/member/joinmember/joinmember"
        });
    }
});