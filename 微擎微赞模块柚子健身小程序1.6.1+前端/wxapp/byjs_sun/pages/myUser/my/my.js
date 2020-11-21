var app = getApp();

Page({
    data: {
        user: {},
        back_img: "",
        myPic: "",
        tabBarList: []
    },
    onLoad: function(n) {
        var e = this;
        e.setData({
            tabBarList: app.globalData.tabbar5
        });
        wx.getStorageSync("users");
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(n) {
                wx.setStorageSync("url", n.data), e.setData({
                    url: n.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetBackimg",
            cachetime: 0,
            success: function(n) {
                e.setData({
                    backimg: n.data
                });
            }
        });
    },
    goIndex: function(n) {
        wx.reLaunch({
            url: "../../product/index/index"
        });
    },
    goChargeIndex: function(n) {
        wx.reLaunch({
            url: "../../charge/chargeIndex/chargeIndex"
        });
    },
    goPublishTxt: function(n) {
        wx.reLaunch({
            url: "../../publishInfo/publish/publishTxt"
        });
    },
    goFindIndex: function(n) {
        wx.reLaunch({
            url: "../../find/findIndex/findIndex"
        });
    },
    onReady: function() {},
    myAddress: function() {
        var e = this;
        wx.chooseAddress({
            success: function(n) {
                e.setData({
                    userName: n.userName,
                    postalCode: n.postalCode,
                    provinceName: n.provinceName,
                    cityName: n.cityName,
                    countyName: n.countyName,
                    detailInfo: n.detailInfo,
                    nationalCode: n.nationalCode,
                    telNumber: n.telNumber
                });
            }
        });
    },
    onShow: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/My",
            data: {
                user_id: wx.getStorageSync("users").id
            },
            cachetime: 0,
            success: function(n) {
                console.log(n), e.setData({
                    user: n.data.user,
                    total: n.data.total
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goMyOrder: function() {
        wx.navigateTo({
            url: "/byjs_sun/pages/myUser/myOrder/myOrder"
        });
    },
    myMoving: function() {
        wx.navigateTo({
            url: "/byjs_sun/pages/myUser/myMoving/myMoving"
        });
    },
    myFans: function() {
        wx.navigateTo({
            url: "/byjs_sun/pages/myUser/myFans/myFans"
        });
    },
    myAttention: function() {
        wx.navigateTo({
            url: "/byjs_sun/pages/myUser/myAttention/myAttention"
        });
    },
    myCollect: function() {
        wx.navigateTo({
            url: "/byjs_sun/pages/myUser/myBespoke/myBespoke"
        });
    },
    myAccount: function(n) {
        wx.navigateTo({
            url: "/byjs_sun/pages/mineAccount/mineAccount"
        });
    },
    myAct: function(n) {
        wx.navigateTo({
            url: "/byjs_sun/pages/mineAct/mineAct?currIdx=1"
        });
    },
    myFight: function() {
        wx.navigateTo({
            url: "/byjs_sun/pages/myUser/myRedEnvelope/myRedEnvelope"
        });
    },
    goBusiness: function() {
        wx.navigateTo({
            url: "/byjs_sun/pages/business/bussinessLogin/bussinessLogin"
        });
    },
    call: function() {
        var n = wx.getStorageSync("phone").phone;
        wx.makePhoneCall({
            phoneNumber: n,
            success: function() {
                console.log("拨打电话成功！");
            },
            fail: function() {
                console.log("拨打电话失败！");
            }
        });
    }
});