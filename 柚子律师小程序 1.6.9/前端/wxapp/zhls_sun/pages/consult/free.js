var app = getApp();

Page({
    data: {
        sex: [ "先生", "女士" ],
        currentSelect: 0,
        free: 1
    },
    onLoad: function(n) {
        var e = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.util.request({
            url: "entry/wxapp/anliType",
            cachetime: "0",
            success: function(n) {
                e.setData({
                    array: n.data
                });
            }
        });
    },
    bindPickerChange: function(n) {
        console.log("picker发送选择改变，携带值为", n.detail.value), this.setData({
            index: n.detail.value
        });
    },
    selectSex: function(n) {
        console.log(n), this.setData({
            currentSelect: n.currentTarget.dataset.index
        });
    },
    bindSave: function(n) {
        console.log(n.detail.value);
        var e = n.detail.value;
        if ("" != e.leixing) if ("" != e.phone) if ("" != e.linkMan) if ("" != e.contents) {
            var t = this.data.currentSelect;
            e.linkMan = 0 == t ? e.linkMan + "先生" : e.linkMan + "女士", wx.showModal({
                title: "提示",
                content: "是否提交咨询！",
                success: function(n) {
                    n.confirm ? (console.log("用户点击确定"), wx.getStorage({
                        key: "openid",
                        success: function(n) {
                            app.util.request({
                                url: "entry/wxapp/Consultation",
                                cachetime: "0",
                                data: {
                                    openid: n.data,
                                    content: e.contents,
                                    leixing: e.leixing,
                                    linkMan: e.linkMan,
                                    phone: e.phone
                                },
                                success: function(n) {
                                    wx.navigateBack({});
                                }
                            });
                        }
                    })) : n.cancel && console.log("用户点击取消");
                }
            }), console.log(e);
        } else wx.showModal({
            title: "提示",
            content: "请输入想要咨询的内容",
            showCancel: !1
        }); else wx.showModal({
            title: "提示",
            content: "请输入称呼",
            showCancel: !1
        }); else wx.showModal({
            title: "提示",
            content: "请输入手机号",
            showCancel: !1
        }); else wx.showModal({
            title: "提示",
            content: "请选择案件类型",
            showCancel: !1
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});