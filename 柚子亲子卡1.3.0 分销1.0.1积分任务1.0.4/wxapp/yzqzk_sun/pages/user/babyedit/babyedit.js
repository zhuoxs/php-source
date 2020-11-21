var app = getApp();

Page({
    data: {
        navTile: "新增孩子",
        sex: [ "男", "女" ],
        sexIndex: 0,
        date: "2000-01-01",
        babyname: "",
        isRequest: 0
    },
    onLoad: function(t) {
        var a = this;
        "" != t.id && (a.data.navTile = "修改孩子信息"), wx.setNavigationBarTitle({
            title: a.data.navTile
        });
        var e = wx.getStorageSync("setting");
        e ? wx.setNavigationBarColor({
            frontColor: e.fontcolor,
            backgroundColor: e.color
        }) : app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            });
        });
        var n = new Date(), o = n.getFullYear() + "-" + (n.getMonth() + 1) + "-" + n.getDay();
        console.log(o), a.setData({
            babyid: t.id,
            endTime: o || "2020-01-01"
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        "" != a.data.babyid && app.util.request({
            url: "entry/wxapp/getBabyDetail",
            cachetime: "0",
            data: {
                id: a.data.babyid
            },
            success: function(t) {
                console.log(t.data), a.setData({
                    babyname: t.data.name,
                    sexIndex: "男" == t.data.sex ? "0" : "1",
                    date: t.data.birth
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    blurInput: function(t) {
        this.setData({
            isRequest: 0
        });
    },
    bindPickerChange: function(t) {
        this.setData({
            sexIndex: t.detail.value,
            isRequest: 0
        });
    },
    bindDateChange: function(t) {
        this.setData({
            date: t.detail.value,
            isRequest: 0
        });
    },
    formSubmit: function(t) {
        var a = this, e = t.detail.value.uname, n = t.detail.value.sex, o = t.detail.value.birthday;
        if ("" == e) wx.showToast({
            title: "请填写宝宝姓名~",
            icon: "none"
        }); else {
            if (a.setData({
                isRequest: ++a.data.isRequest
            }), 1 != a.data.isRequest) return void wx.showToast({
                title: "正在请求中...",
                icon: "none"
            });
            "" != a.data.babyid ? app.util.request({
                url: "entry/wxapp/editBaby",
                cachetime: "0",
                data: {
                    id: a.data.babyid,
                    name: e,
                    sex: n,
                    birth: o
                },
                success: function(t) {
                    console.log(t.data), 1 == t.data && wx.showToast({
                        title: "修改成功",
                        duration: 2500,
                        success: function(t) {
                            wx.navigateBack({
                                delta: 1
                            });
                        }
                    });
                }
            }) : app.get_openid().then(function(t) {
                app.util.request({
                    url: "entry/wxapp/setBaby",
                    cachetime: "0",
                    data: {
                        openid: t,
                        name: e,
                        sex: n,
                        birth: o
                    },
                    success: function(t) {
                        console.log(t.data), 1 == t.data && wx.showToast({
                            title: "新增宝宝成功",
                            duration: 2500,
                            success: function(t) {
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