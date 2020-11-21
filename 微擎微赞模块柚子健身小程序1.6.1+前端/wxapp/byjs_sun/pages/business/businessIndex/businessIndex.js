var app = getApp();

Page({
    data: {
        user: {
            userImg: "http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png",
            userBackImg: "http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png",
            userName: "amorno",
            userSex: "0",
            userAttention: "2",
            userFans: "3",
            movingImg: [ "http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png", "http://img.zcool.cn/community/0142135541fe180000019ae9b8cf86.jpg@1280w_1l_2o_100sh.png" ],
            userMovingNumber: "2"
        },
        fight: [],
        order_num: ""
    },
    onLoad: function(n) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(n) {
                wx.setStorageSync("url", n.data), e.setData({
                    url: n.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetBusinessUserInfo",
            cachetime: "0",
            data: {
                name: wx.getStorageSync("business_name")
            },
            success: function(n) {
                e.setData({
                    user: n.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetBusinessIndexInfo",
            cachetime: 0,
            success: function(n) {
                e.setData({
                    fight: n.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    goOrder: function() {
        wx.navigateTo({
            url: "/byjs_sun/pages/business/businessOrder/businessOrder"
        });
    },
    goSettings: function() {
        wx.navigateTo({
            url: "/byjs_sun/pages/business/businessSettings/businessSettings"
        });
    },
    soso: function() {
        wx.scanCode({
            success: function(n) {
                console.log(n);
            }
        });
    },
    order_num: function(n) {
        this.setData({
            order_num: n.data.value
        });
    },
    confirm: function() {
        var n = this.data.order_num;
        app.util.request({
            url: "entry/wxapp/OrderConfirm",
            data: {
                order_num: n
            },
            success: function(n) {
                wx.showModal({
                    title: "成功",
                    content: "核销成功"
                });
            }
        });
    },
    loginout: function() {
        wx.removeStorageSync("business_name"), wx.showModal({
            title: "",
            content: "你确认退出",
            success: function(n) {
                n.confirm && wx.switchTab({
                    url: "../../../../byjs_sun/pages/product/index/index"
                });
            }
        });
    }
});