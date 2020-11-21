var app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var t = this;
        wx.setStorage({
            key: "ls_id",
            data: a.id
        }), t.setData({
            id: a.id
        }), wx.setStorageSync("ls_id", a.id), app.util.request({
            url: "entry/wxapp/MyFinances",
            cachetime: "0",
            data: {
                id: a.id
            },
            success: function(a) {
                t.setData({
                    Putforward: a.data.Putforward,
                    all: a.data.all,
                    today: a.data.today,
                    yesterday: a.data.yesterday
                });
            }
        });
    },
    goDaiHuifu: function() {
        wx.navigateTo({
            url: "../../daihuifu/index/index?id=" + this.data.id
        });
    },
    loginOut: function(a) {
        wx.navigateBack({});
    },
    backIndex: function() {
        wx.reLaunch({
            url: "../../shouye/index"
        });
    },
    onReady: function() {},
    onShow: function() {
        this.getUserInfo();
        var t = this;
        app.util.request({
            url: "entry/wxapp/Todayappion",
            cachetime: "0",
            success: function(a) {
                t.setData({
                    appnum: a.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/TodayConsultation",
            cachetime: "0",
            data: {
                ls_id: wx.getStorageSync("ls_id")
            },
            success: function(a) {
                t.setData({
                    count: a.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/TodayFang",
            cachetime: "0",
            success: function(a) {
                t.setData({
                    fang: a.data
                });
            }
        });
    },
    getUserInfo: function() {
        var t = this;
        wx.login({
            success: function() {
                wx.getUserInfo({
                    success: function(a) {
                        console.log(a), t.setData({
                            userInfo: a.userInfo
                        });
                    }
                });
            }
        });
    },
    putFoward: function(a) {
        wx.navigateTo({
            url: "../../withDrawal/withDrawal"
        });
    }
});