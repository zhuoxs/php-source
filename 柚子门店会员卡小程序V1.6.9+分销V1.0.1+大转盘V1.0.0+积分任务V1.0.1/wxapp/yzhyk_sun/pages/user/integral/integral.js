var app = getApp();

Page({
    data: {
        navTile: "我的积分",
        integral: "90",
        curIndex: 0,
        detail: [],
        record: [ {
            active: "200积分兑换1元现金",
            time: "2018-05-05"
        } ],
        showbtn: 0,
        pageRecord: 1,
        pageDetail: 1
    },
    onLoad: function(t) {
        wx.setNavigationBarTitle({
            title: this.data.navTile
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        app.get_user_info().then(function(t) {
            e.setData({
                integral: t.integral ? t.integral : 0
            }), app.util.request({
                url: "entry/wxapp/GetIntegrals",
                cachetime: "0",
                data: {
                    user_id: t.id,
                    page: e.data.pageDetail
                },
                success: function(t) {
                    e.setData({
                        detail: t.data,
                        pageDetail: e.data.pageDetail + 1
                    });
                }
            }), app.util.request({
                url: "entry/wxapp/GetIntegralsExchange",
                cachetime: "0",
                data: {
                    user_id: t.id,
                    page: e.data.pageRecord
                },
                success: function(t) {
                    e.setData({
                        record: t.data,
                        pageRecord: e.data.pageRecord + 1
                    });
                }
            }), app.util.request({
                url: "entry/wxapp/GetIntegralsSetting",
                cachetime: "0",
                success: function(t) {
                    e.setData({
                        setting: t.data
                    });
                }
            });
        });
    },
    getDetai: function() {
        var a = this, n = a.data.pageDetail, i = a.data.detail;
        app.get_user_info().then(function(t) {
            app.util.request({
                url: "entry/wxapp/GetIntegrals",
                cachetime: "0",
                data: {
                    user_id: t.id,
                    page: n
                },
                success: function(t) {
                    for (var e = 0; e < t.data.length; e++) i.push(t.data[e]);
                    a.setData({
                        detail: i,
                        pageDetail: n + 1
                    }), t.data.length < 10 && wx.showToast({
                        title: "没有更多数据了~",
                        icon: "none"
                    });
                }
            });
        });
    },
    getRecord: function() {
        var a = this, n = a.data.pageRecord, i = a.data.record;
        app.get_user_info().then(function(t) {
            app.util.request({
                url: "entry/wxapp/GetIntegralsExchange",
                cachetime: "0",
                data: {
                    user_id: t.id,
                    page: n
                },
                success: function(t) {
                    for (var e = 0; e < t.data.length; e++) i.push(t.data[e]);
                    a.setData({
                        record: i,
                        pageRecord: n + 1
                    }), t.data.length < 10 && wx.showToast({
                        title: "没有更多数据了~",
                        icon: "none"
                    });
                }
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        0 == this.data.curIndex ? this.getDetai() : this.getRecord();
    },
    changeTap: function(t) {
        var e = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: e
        });
    },
    exchange: function(t) {
        this.data.setting.integral2 - 0 > this.data.integral - 0 ? wx.showModal({
            title: "您的积分不足以兑换现金",
            content: ""
        }) : wx.showModal({
            content: "确认兑换该权益吗",
            showCancel: !0,
            success: function(t) {
                t.cancel || t.confirm && app.get_user_info().then(function(t) {
                    app.util.request({
                        url: "entry/wxapp/Integral2Balance",
                        data: {
                            user_id: t.id
                        },
                        success: function(t) {
                            app.get_user_info(!1), app.get_user_coupons(!1), wx.reLaunch({
                                url: "../exchangesuc/exchangesuc"
                            });
                        }
                    });
                });
            }
        });
    },
    exchange1: function(t) {
        var e = this;
        console.log(e.data.setting.integral3), console.log(e.data.integral), e.data.setting.integral3 - 0 > e.data.integral - 0 ? wx.showModal({
            title: "您的积分不足以兑换点劵",
            content: ""
        }) : wx.showModal({
            content: "确认兑换点劵吗",
            showCancel: !0,
            success: function(t) {
                t.cancel || t.confirm && app.get_user_info().then(function(t) {
                    app.util.request({
                        url: "entry/wxapp/Integral3Balance",
                        data: {
                            user_id: t.id
                        },
                        success: function(t) {
                            app.get_user_info(!1), app.get_user_coupons(!1), wx.reLaunch({
                                url: "../exchangesuc/exchangesuc"
                            });
                        }
                    });
                });
            }
        });
    }
});