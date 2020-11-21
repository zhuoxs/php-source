function _defineProperty(e, n, t) {
    return n in e ? Object.defineProperty(e, n, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[n] = t, e;
}

var app = getApp();

Page(_defineProperty({
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
        order_num: "",
        backimg: ""
    },
    onLoad: function(e) {
        var n = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), n.setData({
                    url: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetBusinessUserInfo",
            cachetime: "0",
            data: {
                name: wx.getStorageSync("business_name")
            },
            success: function(e) {
                n.setData({
                    user: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetBusinessImg",
            cachetime: "0",
            success: function(e) {
                n.setData({
                    backimg: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetBusinessIndexInfo",
            cachetime: 0,
            success: function(e) {
                n.setData({
                    fight: e.data
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
            success: function(e) {
                console.log(e);
            }
        });
    },
    ordernum: function(e) {
        console.log(e);
        this.setData({
            order_num: e.detail.value
        });
    },
    confirm: function() {
        var n = this, e = n.data.order_num;
        app.util.request({
            url: "entry/wxapp/OrderConfirm",
            data: {
                order_num: e
            },
            success: function(e) {
                wx.showModal({
                    title: "成功",
                    content: "核销成功"
                }), n.onLoad();
            }
        });
    },
    loginout: function() {
        wx.removeStorageSync("business_name"), wx.showModal({
            title: "",
            content: "你确认退出",
            success: function(e) {
                e.confirm && wx.redirectTo({
                    url: "../../../../byjs_sun/pages/product/index/index"
                });
            }
        });
    }
}, "goOrder", function() {
    wx.navigateTo({
        url: "/byjs_sun/pages/business/businessOrder/businessOrder"
    });
}));