var app = getApp();

Page({
    data: {
        navTile: "设置目标",
        targetName: "",
        remark: "",
        isIpx: app.globalData.isIpx
    },
    onLoad: function(a) {
        var n = this, t = wx.getStorageSync("setting");
        t ? wx.setNavigationBarColor({
            frontColor: t.fontcolor,
            backgroundColor: t.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        }), app.util.request({
            url: "entry/wxapp/getPunchDetail",
            cachetime: "0",
            data: {
                id: a.id
            },
            success: function(t) {
                console.log(t.data), wx.setNavigationBarTitle({
                    title: t.data.title
                }), n.setData({
                    target: t.data,
                    day: t.data.task_day,
                    punch_id: a.id
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = wx.getStorageSync("baby") || {};
        console.log(t), this.setData({
            baby: t
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bindPickerChange: function(t) {
        this.setData({
            dayIndex: t.detail.value
        });
    },
    toBaby: function(t) {
        wx.navigateTo({
            url: "../../user/baby/baby?isback=1"
        });
    },
    formSubmit: function(t) {
        var a = this, n = t.detail.value.cont, o = t.detail.value.day, e = a.data.baby, i = "", c = !0;
        "" == n ? i = "请填写任务内容" : "" == o ? i = "请选择任务时间" : null == e.id ? i = "请选择宝宝" : (c = !1, 
        app.get_openid().then(function(t) {
            app.util.request({
                url: "entry/wxapp/setPunchTask",
                cachetime: "0",
                data: {
                    openid: t,
                    punch_id: a.data.punch_id,
                    task_day_id: a.data.day[a.data.dayIndex].id,
                    baby_id: e.id,
                    content: n
                },
                success: function(t) {
                    wx.showModal({
                        title: "",
                        content: "创建成功",
                        showCancel: !1,
                        success: function(t) {
                            wx.navigateBack({});
                        }
                    });
                },
                fail: function() {
                    wx.showModal({
                        title: "",
                        content: "创建失败，请重新创建",
                        showCancel: !1,
                        success: function(t) {
                            wx.navigateBack({});
                        }
                    });
                }
            });
        })), c && wx.showToast({
            title: i,
            icon: "none",
            duration: 2e3
        });
    }
});