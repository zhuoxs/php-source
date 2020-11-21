var app = getApp();

Page({
    data: {
        navTile: "新增汽车信息",
        sex: [ "男", "女" ],
        sexIndex: 0,
        date: "2018-01-01",
        babyname: "",
        isRequest: 0
    },
    onLoad: function(a) {
        var t = this;
        "" != a.id && (t.data.navTile = "修改车辆信息"), wx.setNavigationBarTitle({
            title: t.data.navTile
        });
        var e = wx.getStorageSync("setting");
        e ? wx.setNavigationBarColor({
            frontColor: e.fontcolor,
            backgroundColor: e.color
        }) : app.get_setting(!0).then(function(a) {
            wx.setNavigationBarColor({
                frontColor: a.fontcolor,
                backgroundColor: a.color
            });
        });
        new Date();
        t.setData({
            babyid: a.id,
            endTime: "2050-01-01"
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this;
        "" != t.data.babyid && app.util.request({
            url: "entry/wxapp/getBabyDetail",
            cachetime: "0",
            data: {
                id: t.data.babyid
            },
            success: function(a) {
                console.log(a.data), t.setData({
                    car_producer: a.data.car_producer,
                    car_level: a.data.car_level,
                    car_number: a.data.car_number,
                    date: a.data.car_insurance
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    blurInput: function(a) {
        this.setData({
            isRequest: 0
        });
    },
    bindPickerChange: function(a) {
        this.setData({
            sexIndex: a.detail.value,
            isRequest: 0
        });
    },
    bindDateChange: function(a) {
        this.setData({
            date: a.detail.value,
            isRequest: 0
        });
    },
    formSubmit: function(a) {
        var t = this, e = a.detail.value.car_producer, n = a.detail.value.car_level, o = a.detail.value.car_number, i = a.detail.value.birthday;
        if ("" == e) wx.showToast({
            title: "请填写车辆产商~",
            icon: "none"
        }); else if ("" == n) wx.showToast({
            title: "请填写车辆级别~",
            icon: "none"
        }); else if ("" == o) wx.showToast({
            title: "请填写车辆号~",
            icon: "none"
        }); else {
            if (t.setData({
                isRequest: ++t.data.isRequest
            }), 1 != t.data.isRequest) return void wx.showToast({
                title: "正在请求中...",
                icon: "none"
            });
            null == t.data.babyid && (t.data.babyid = ""), "" != t.data.babyid ? app.util.request({
                url: "entry/wxapp/editBaby",
                cachetime: "0",
                data: {
                    id: t.data.babyid,
                    car_producer: e,
                    car_level: n,
                    car_number: o,
                    car_insurance: i
                },
                success: function(a) {
                    console.log(a.data), 1 == a.data && wx.showToast({
                        title: "修改成功",
                        duration: 2500,
                        success: function(a) {
                            wx.navigateBack({
                                delta: 1
                            });
                        }
                    });
                }
            }) : app.get_openid().then(function(a) {
                app.util.request({
                    url: "entry/wxapp/setBaby",
                    cachetime: "0",
                    data: {
                        openid: a,
                        car_producer: e,
                        car_level: n,
                        car_number: o,
                        car_insurance: i
                    },
                    success: function(a) {
                        console.log(a.data), 1 == a.data && wx.showToast({
                            title: "新增宝宝成功",
                            duration: 2500,
                            success: function(a) {
                                wx.navigateBack({
                                    delta: 1
                                });
                            }
                        });
                    }
                });
            });
        }
    }
});