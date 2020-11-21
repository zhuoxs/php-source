for (var date = new Date(), years = [], months = [], emonths = [], days = [], edays = [], hours = [], ehours = [], i = 1990; i <= date.getFullYear(); i++) years.push(i);

for (var _i = 1; _i <= 12; _i++) months.push(_i), emonths.push(_i);

for (var _i2 = 1; _i2 <= 31; _i2++) days.push(_i2), edays.push(_i2);

for (var _i3 = 0; _i3 <= 23; _i3++) hours.push(_i3), ehours.push(_i3);

var app = getApp(), chooseImgs = [];

Page({
    data: {
        hideTimesBox: !0,
        endTimesBox: !0,
        years: years,
        year: date.getFullYear(),
        months: months,
        emonths: emonths,
        month: "",
        emonth: "",
        days: days,
        edays: edays,
        day: "",
        eday: "",
        hours: hours,
        ehours: ehours,
        hour: "",
        ehour: "",
        value: [ 0, 0, 0 ]
    },
    bindStartChange: function(t) {
        var a = t.detail.value;
        this.setData({
            month: this.data.months[a[0]],
            day: this.data.days[a[1]],
            hour: this.data.hours[a[2]]
        });
        var e = this.data.month + "-" + this.data.day + "  " + this.data.hour + ":00";
        console.log(e), this.setData({
            startT: e
        });
    },
    bindEndChange: function(t) {
        var a = t.detail.value;
        this.setData({
            emonth: this.data.emonths[a[0]],
            eday: this.data.edays[a[1]],
            ehour: this.data.ehours[a[2]]
        });
        var e = this.data.emonth + "-" + this.data.eday + "  " + this.data.ehour + ":00";
        console.log(e), this.setData({
            endT: e
        });
    },
    onLoad: function(t) {
        this.setData({
            url: wx.getStorageSync("url2")
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    bindSave: function(e) {
        var o = this;
        console.log(e), console.log(o.data), e.detail.value.title ? e.detail.value.subtitle ? e.detail.value.num ? e.detail.value.sharenum ? e.detail.value.share_plus ? e.detail.value.content ? e.detail.value.thumb ? e.detail.value.storeinfo ? wx.getStorage({
            key: "openid",
            success: function(t) {
                var a = t.data;
                app.util.request({
                    url: "entry/wxapp/SelectAddActive",
                    cachetime: "0",
                    data: {
                        user_id: a
                    },
                    success: function(t) {
                        console.log(t), 1 == t.data.data ? app.util.request({
                            url: "entry/wxapp/AddActive",
                            cachetime: "0",
                            data: {
                                user_id: a,
                                title: e.detail.value.title,
                                subtitle: e.detail.value.subtitle,
                                content: e.detail.value.content,
                                thumb: e.detail.value.thumb,
                                num: e.detail.value.num,
                                sharenum: e.detail.value.sharenum,
                                share_plus: e.detail.value.share_plus,
                                storeinfo: e.detail.value.storeinfo,
                                astime: o.data.startT,
                                antime: o.data.endT
                            },
                            success: function(t) {
                                console.log(t), 1 != t.data.data ? wx.showToast({
                                    title: "请根据入驻时间选择结束日期",
                                    icon: "none"
                                }) : wx.navigateTo({
                                    url: "../add-activity/details"
                                });
                            }
                        }) : (console.log("----------已经添加-----------------"), wx.navigateTo({
                            url: "../add-activity/details"
                        }));
                    }
                });
            }
        }) : wx.showToast({
            title: "请输入店铺信息！",
            icon: "none"
        }) : wx.showToast({
            title: "请选择活动商品图片",
            icon: "none"
        }) : wx.showToast({
            title: "请输入活动规则",
            icon: "none"
        }) : wx.showToast({
            title: "请输入转发次数",
            icon: "none"
        }) : wx.showToast({
            title: "请输入转发获得次数",
            icon: "none"
        }) : wx.showToast({
            title: "请输入初次抽奖次数",
            icon: "none"
        }) : wx.showToast({
            title: "请输入活动副标题",
            icon: "none"
        }) : wx.showToast({
            title: "请输入活动名称",
            icon: "none"
        });
    },
    chooseImgs: function(t) {
        var o = this, s = wx.getStorageSync("uniacid");
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                console.log(t);
                var a = t.tempFilePaths;
                wx.showToast({
                    title: "正在上传...",
                    icon: "loading",
                    mask: !0,
                    duration: 2e3
                });
                var e = t.tempFilePaths;
                o.uploadimg({
                    url: o.data.url + "app/index.php?i=" + s + "&c=entry&a=wxapp&do=Upload&m=chbl_sun",
                    path: e
                }), o.setData({
                    have: 1,
                    tempFilePaths: a
                });
            }
        });
    },
    uploadimg: function(t) {
        var a = this, e = t.i ? t.i : 0, o = t.success ? t.success : 0, s = t.fail ? t.fail : 0;
        wx.uploadFile({
            url: t.url,
            filePath: t.path[e],
            name: "upfile",
            formData: null,
            success: function(t) {
                console.log(t), "" != t.data ? (o++, chooseImgs.push(t.data), a.setData({
                    chooseImgs: chooseImgs.pop()
                })) : wx.showToast({
                    icon: "loading",
                    title: "请重试"
                });
            },
            fail: function(t) {
                s++;
            },
            complete: function() {
                ++e == t.path.length ? (a.setData({
                    images: t.path
                }), wx.hideToast()) : (t.i = e, t.success = o, t.fail = s, a.uploadimg(t));
            }
        });
    },
    bindTimeChange: function(t) {
        console.log("picker发送选择改变，携带值为", t.detail.value), this.setData({
            stime: t.detail.value
        });
    },
    showTimeBox: function(t) {
        this.setData({
            hideTimesBox: !1
        }), 0 == this.data.hideTimesBox && (console.log(11111), this.setData({
            hideTextArea: !0
        }));
    },
    showEndBox: function(t) {
        this.setData({
            endTimesBox: !1
        }), 0 == this.data.endTimesBox && (console.log(11111), this.setData({
            hideTextArea: !0
        }));
    },
    endTab: function(t) {
        this.setData({
            hideTimesBox: !0,
            endTimesBox: !0
        }), 1 == this.data.hideTimesBox && this.setData({
            hideTextArea: !1
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