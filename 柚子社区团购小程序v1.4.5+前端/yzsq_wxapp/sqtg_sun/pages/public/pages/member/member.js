var app = getApp();

Page({
    data: {
        reload: !1,
        current_key: 0,
        current_id: 0
    },
    onLoad: function(a) {
        this.onLoadData();
    },
    onShow: function() {
        this.data.reload && (this.onLoadData(), this.setData({
            reload: !1
        }));
    },
    onLoadData: function() {
        var s = this, a = wx.getStorageSync("userInfo");
        a ? (app.ajax({
            url: "Crecharge|recharge",
            data: {
                user_id: a.id
            },
            success: function(a) {
                s.setData({
                    btn: a.data
                });
            }
        }), app.ajax({
            url: "Cuser|myInfo",
            data: {
                user_id: a.id
            },
            success: function(a) {
                s.setData({
                    info: a.data,
                    imgRoot: a.other.img_root
                }), app.ajax({
                    url: "Cmemberconf|levelList",
                    success: function(a) {
                        if (a.data.length < 1) wx.showModal({
                            title: "提示",
                            content: "平台暂未开启会员功能！",
                            showCancel: !1,
                            success: function(a) {
                                wx.navigateBack({
                                    delta: 1
                                });
                            }
                        }); else {
                            var t = null;
                            for (var e in a.data) s.data.info.levelinfo.id == a.data[e].id && (t = a.data.length - 1 == e ? e - 0 : e - 0 + 1), 
                            s.data.info.levelinfo.id || (t = 1), a.data[e].img = s.data.imgRoot + a.data[e].img;
                            var n = a.data[t].money, o = (n - s.data.info.userinfo.total_consume).toFixed(2);
                            o < 0 && (o = 0);
                            var i = Math.floor((s.data.info.userinfo.total_consume - 0) / n * 100);
                            s.setData({
                                level: a.data,
                                show: !0,
                                nextMoney: n,
                                lessMoney: o,
                                percent: i
                            });
                        }
                    }
                });
            }
        })) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(a) {
                if (a.confirm) {
                    var t = encodeURIComponent("/sqtg_sun/pages/home/my/my?id=123");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + t);
                } else a.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    changeTabs: function(a) {
        var t = a.detail.currentItemId, e = a.detail.current;
        this.setData({
            current_id: t,
            current_key: e
        });
    }
});