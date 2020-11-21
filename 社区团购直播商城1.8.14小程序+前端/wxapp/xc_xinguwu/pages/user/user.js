var app = getApp();

Page({
    data: {
        curIndex: 0,
        userInfo: {}
    },
    onLoad: function() {
        var e = this;
        this.setData({
            webset: app.globalData.webset,
            theme: app.globalData.theme
        }), null != app.user_set && app.look.istrue(app.user_set.list) && e.setData({
            nav_list: app.user_set.list
        }), null != app.user_set && app.look.istrue(app.user_set.bg) ? e.setData({
            bg: app.user_set.bg
        }) : e.setData({
            bg: app.module_url + "resource/images/user-banner.jpg"
        });
    },
    sysset: function() {
        wx.openSetting();
    },
    debugopen: function() {
        wx.showActionSheet({
            itemList: [ "开启调试", "关闭调试" ],
            success: function(e) {
                0 == e.tapIndex ? wx.setEnableDebug({
                    enableDebug: !0
                }) : wx.setEnableDebug({
                    enableDebug: !1
                });
            },
            fail: function(e) {
                console.log(e.errMsg);
            }
        });
    },
    sysupdate: function() {
        var a = wx.getUpdateManager();
        a.onCheckForUpdate(function(e) {
            e.hasUpdate ? a.applyUpdate() : wx.reLaunch({
                url: "../base/base"
            });
        });
    },
    onShow: function() {
        this.setData({
            userInfo: app.globalData.userInfo
        });
    },
    onReady: function() {
        app.look.footer(this), app.look.navbar(this);
        var e = {};
        e.cart = app.module_url + "resource/wxapp/user/cart.png", e.community = app.module_url + "resource/wxapp/user/community.png", 
        e.community_apply = app.module_url + "resource/wxapp/user/community_apply.png", 
        e.distribution = app.module_url + "resource/wxapp/user/distribution.png", e.help = app.module_url + "resource/wxapp/user/help.png", 
        e.sysset = app.module_url + "resource/wxapp/user/sysset.png", e.updateset = app.module_url + "resource/wxapp/user/updateset.png", 
        e.sysdebug = app.module_url + "resource/wxapp/user/sysdebug.png", e.manage = app.module_url + "resource/wxapp/user/manage.png", 
        e.mycard = app.module_url + "resource/wxapp/user/mycard.png", e.order = app.module_url + "resource/wxapp/user/order.png", 
        e.position = app.module_url + "resource/wxapp/user/position.png", e.recharge = app.module_url + "resource/wxapp/user/recharge.png", 
        e.return = app.module_url + "resource/wxapp/user/return.png", e.service = app.module_url + "resource/wxapp/user/service.png", 
        e.voucher = app.module_url + "resource/wxapp/user/voucher.png", e.wait_delivery = app.module_url + "resource/wxapp/user/wait_delivery.png", 
        e.wait_pay = app.module_url + "resource/wxapp/user/wait_pay.png", e.wait_send = app.module_url + "resource/wxapp/user/wait_send.png", 
        this.setData({
            images: e
        });
    },
    onPullDownRefresh: function() {
        var r = this;
        app.util.request({
            url: "entry/wxapp/index",
            showLoading: !0,
            data: {
                op: "get_userinfo"
            },
            success: function(e) {
                wx.stopPullDownRefresh();
                var a = e.data;
                console.log(a.data.userinfo), a.data.userinfo && (app.globalData.userInfo = a.data.userinfo, 
                r.setData({
                    userInfo: a.data.userinfo
                }));
            }
        });
    },
    wait_pay: function() {
        wx.navigateTo({
            url: "../order/order?curIndex=2"
        });
    },
    toorder: function(e) {
        var a = e.currentTarget.dataset.status;
        wx.navigateTo({
            url: "../order/order?status=" + a
        });
    },
    tocart: function() {
        wx.reLaunch({
            url: "../cart/cart"
        });
    },
    torecharge: function() {
        wx.navigateTo({
            url: "../recharge/recharge"
        });
    },
    toposition: function() {
        wx.navigateTo({
            url: "../address/address"
        });
    },
    tovoucher: function() {
        wx.navigateTo({
            url: "../voucher/voucher"
        });
    },
    tomyvoucher: function() {
        wx.navigateTo({
            url: "../myvoucher/myvoucher?stausid=1"
        });
    },
    tomember: function() {
        wx.navigateTo({
            url: "../member/member"
        });
    },
    todistribution: function() {
        wx.navigateTo({
            url: "/xc_xinguwu/distribution/distribution/distribution"
        });
    },
    tomanage: function() {
        wx.redirectTo({
            url: "/xc_xinguwu/manage/manageIndex/manageIndex"
        });
    },
    tohelp: function() {
        wx.navigateTo({
            url: "../help/help"
        });
    },
    tolink: function(e) {
        var a = e.currentTarget.dataset.link;
        app.look.istrue(a) && wx.navigateTo({
            url: a
        });
    },
    tocommunity: function() {
        wx.navigateTo({
            url: "/xc_xinguwu/community/sqMasterCenter/sqMasterCenter"
        });
    },
    onGotUserInfo: function(e) {
        if ("getUserInfo:ok" == e.detail.errMsg) {
            var a = this.data.userInfo;
            a || (a = {}), a.avatarurl = e.detail.userInfo.avatarUrl, a.nickname = e.detail.userInfo.nickName, 
            this.setData({
                userInfo: a
            });
        }
        app.look.getuserinfo(e, this);
    }
});