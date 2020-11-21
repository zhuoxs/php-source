var app = getApp(), chooseImgs = [];

Page({
    data: {
        pushSuccess: !0,
        hidden: 1,
        indexnum: [ "1", "2", "3", "4", "5", "6", "7", "8", "9", "10" ],
        pics: [],
        pics1: [],
        picss: [],
        uppic: [],
        uppics: [],
        uploadPic: [],
        indexP: []
    },
    onLoad: function(e) {
        this.setData({
            url: wx.getStorageSync("url2"),
            hidden: "true"
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    uploadPic: function(e) {
        var u = this, i = e.currentTarget.dataset.index;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                var a = e.tempFilePaths;
                u.uploadimg(a, i), console.log(a);
                var t = u.data.uploadPic, o = u.data.indexP;
                console.log(t[i]), t[i] = a, o[i] = i, console.log(t), u.setData({
                    uploadPic: t,
                    indexP: o
                });
            }
        });
    },
    uploadimg: function(e, t) {
        var o = this, a = e, u = (t = t, app.util.url("entry/wxapp/Toupload") + "&m=chbl_sun");
        console.log(a), wx.uploadFile({
            url: u,
            filePath: a[0],
            name: "file",
            success: function(e) {
                console.log(e);
                var a = o.data.pics;
                a[t] = e.data, console.log(a), o.setData({
                    have: 1,
                    img: a
                });
            }
        });
    },
    zengjiakapian: function() {
        this.setData({
            hidden: "false"
        });
    },
    bindSave: function(t) {
        console.log(t);
        var o = this;
        wx.getStorage({
            key: "openid",
            success: function(e) {
                app.util.request({
                    url: "entry/wxapp/getAddNowActive",
                    cachetime: "0",
                    data: {
                        user_id: e.data
                    },
                    success: function(e) {
                        console.log(e), "" == t.detail.value.rate ? wx.showToast({
                            title: "请添加卡片或填写概率",
                            icon: "none"
                        }) : wx.showModal({
                            title: "提示",
                            content: "确认信息填写无误？",
                            success: function(e) {
                                if (e.confirm) {
                                    var a = wx.getStorageSync("collecting_id");
                                    app.util.request({
                                        url: "entry/wxapp/addGift",
                                        cachetime: "0",
                                        data: {
                                            pid: a,
                                            rate: t.detail.value.rate,
                                            rate1: t.detail.value.rate1,
                                            rate2: t.detail.value.rate2,
                                            rate3: t.detail.value.rate3,
                                            rate4: t.detail.value.rate4,
                                            rate5: t.detail.value.rate5,
                                            rate6: t.detail.value.rate6,
                                            rate7: t.detail.value.rate7,
                                            rate8: t.detail.value.rate8,
                                            rate9: t.detail.value.rate9,
                                            thumb: t.detail.value.thumb,
                                            thumb1: t.detail.value.thumb1,
                                            thumb2: t.detail.value.thumb2,
                                            thumb3: t.detail.value.thumb3,
                                            thumb4: t.detail.value.thumb4,
                                            thumb5: t.detail.value.thumb5,
                                            thumb6: t.detail.value.thumb6,
                                            thumb7: t.detail.value.thumb7,
                                            thumb8: t.detail.value.thumb8,
                                            thumb9: t.detail.value.thumb9
                                        },
                                        success: function(e) {
                                            console.log(e), o.bindGuigeTap();
                                        }
                                    });
                                } else e.cancel && console.log("用户点击取消");
                            }
                        });
                    }
                });
            }
        });
    },
    releaseTap: function(e) {
        this.closePopupTap(), wx.reLaunch({
            url: "../mine/index"
        });
    },
    closePopupTap: function(e) {
        this.setData({
            pushSuccess: !0
        });
    },
    bindGuigeTap: function() {
        this.setData({
            pushSuccess: !1
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});