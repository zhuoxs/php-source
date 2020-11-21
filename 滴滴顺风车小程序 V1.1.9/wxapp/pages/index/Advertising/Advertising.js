var t = getApp();

Page({
    data: {
        logintag: "",
        style: "width:100%;height:358rpx;",
        classs: "0",
        yval: "",
        xval: ""
    },
    onLoad: function(a) {
        console.log(a);
        var e = this, o = a.id;
        e.setData({
            nid: o
        });
        try {
            var n = wx.getStorageSync("session");
            n && (console.log("logintag:", n), e.setData({
                logintag: n
            }));
        } catch (t) {}
        e.data.logintag;
        wx.getLocation({
            type: "gcj02",
            success: function(a) {
                a.latitude, a.longitude;
                var n = e.data.logintag;
                wx.request({
                    url: t.data.url + "car_owner_bidding_view",
                    data: {
                        logintag: n,
                        nid: o
                    },
                    header: {
                        "content-type": "application/x-www-form-urlencoded"
                    },
                    success: function(t) {
                        if (console.log(t), "0000" == t.data.retCode) {
                            var a = t.data.info.b_lnglat, o = t.data.info.e_lnglat, n = a.split(","), i = o.split(",");
                            console.log(n), console.log(i), e.setData({
                                info: t.data.info,
                                yval: n[0],
                                xval: n[1],
                                markers: [ {
                                    iconPath: "/images/kai.jpg",
                                    id: 0,
                                    latitude: n[0],
                                    longitude: n[1],
                                    width: 40,
                                    height: 40
                                }, {
                                    iconPath: "/images/zhong.jpg",
                                    id: 0,
                                    latitude: i[0],
                                    longitude: i[1],
                                    width: 30,
                                    height: 30
                                } ],
                                polyline: [ {
                                    points: [ {
                                        longitude: n[1],
                                        latitude: n[0]
                                    }, {
                                        longitude: i[1],
                                        latitude: i[0]
                                    } ],
                                    color: "#1571FA",
                                    width: 3,
                                    dottedLine: !0
                                } ]
                            });
                        } else wx.showToast({
                            title: t.data.retDesc,
                            icon: "loading",
                            duration: 1e3
                        });
                    }
                });
            }
        });
    },
    locth: function(t) {
        var a = this;
        wx.getLocation({
            type: "gcj02",
            success: function(t) {
                var e = t.latitude, o = t.longitude;
                a.setData({
                    yval: e,
                    xval: o
                });
            }
        });
    },
    pulldown: function(t) {
        var a = this;
        0 == a.data.classs ? a.setData({
            style: "width:100%;height:1200rpx;",
            classs: "1"
        }) : a.setData({
            style: "width:100%;height:358rpx;",
            classs: "0"
        });
    },
    phone: function(t) {
        var a = t.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: a,
            success: function(t) {
                console.log(t);
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: "拼车",
            desc: "拼车!",
            imageUrl: "/images/eqweqw.jpg"
        };
    }
});