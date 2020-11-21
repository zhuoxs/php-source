var app = getApp();

Page({
    data: {
        tab: [ "已完成", "未就诊/已取消" ],
        current: null,
        userInfo: {}
    },
    tab: function(t) {
        var e = this, a = e.data.id, r = t.currentTarget.dataset.index;
        console.log(r);
        wx.getStorageSync("openid");
        0 == r ? app.util.request({
            url: "entry/wxapp/Selectdoctor2",
            data: {
                id: a
            },
            success: function(t) {
                e.setData({
                    selectdoctor2: t.data.data
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/Selectdoctor1",
            data: {
                id: a
            },
            success: function(t) {
                console.log(t), e.setData({
                    selectdoctor1: t.data.data
                });
            }
        }), this.setData({
            current: t.currentTarget.dataset.index
        });
    },
    tab1: function(t) {
        var e = this, a = (t.currentTarget.dataset.index, e.data.id);
        app.util.request({
            url: "entry/wxapp/Selectdoctororder",
            data: {
                id: a
            },
            success: function(t) {
                console.log(t), e.setData({
                    selectdoctororder: t.data.data
                });
            }
        }), this.setData({
            current: null
        });
    },
    onLoad: function(t) {
        var e = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: e
        });
        var a = this, r = t.id;
        a.setData({
            id: r
        });
        var o = wx.getStorageSync("userInfo");
        a.setData({
            userInfo: o
        }), app.util.request({
            url: "entry/wxapp/Selectdoctororder",
            data: {
                id: r
            },
            success: function(t) {
                console.log(t), a.setData({
                    selectdoctororder: t.data.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    ddxqClick: function(t) {
        var e = t.currentTarget.dataset.id;
        app.util.request({
            url: "entry/wxapp/Dmoney",
            data: {
                id: e
            },
            success: function(t) {
                console.log(t), wx.navigateTo({
                    url: "../ddxq/ddxq?id=" + e
                });
            }
        });
    },
    look_detail: function(t) {
        var e = t.currentTarget.dataset.data, a = t.currentTarget.dataset.ks, r = t.currentTarget.dataset.money, o = t.currentTarget.dataset.phone, n = t.currentTarget.dataset.tjtime, c = t.currentTarget.dataset.yytime, s = t.currentTarget.dataset.dorder, d = t.currentTarget.dataset.sex, u = t.currentTarget.dataset.age, i = t.currentTarget.dataset.zjid, l = t.currentTarget.dataset.hzid, p = t.currentTarget.dataset.useropenid;
        wx.navigateTo({
            url: "../patient_detail2/patient_detail2?username=" + e + "&ksname=" + a + "&money=" + r + "&phone=" + o + "&tjtime=" + n + "&yytime=" + c + "&dorder=" + s + "&sex=" + d + "&age=" + u + "&zjid=" + i + "&hzid=" + l + "&useropenid=" + p + "&xq=0"
        });
    },
    entird: function(t) {
        var e = this, a = e.data.selectdoctororder;
        console.log(a);
        var r = t.currentTarget.dataset.id, o = t.currentTarget.dataset.index;
        wx.showModal({
            content: "是否确认就诊",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/Updatetype",
                    data: {
                        zy_id: r
                    },
                    success: function(t) {
                        a[o].zy_zhenzhuang = 1, e.setData({
                            selectdoctororder: a
                        }), console.log(t);
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    entird2: function(t) {
        var e = this, a = e.data.selectdoctor1;
        console.log(a);
        var r = t.currentTarget.dataset.id, o = t.currentTarget.dataset.index;
        wx.showModal({
            content: "是否确认就诊",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/Updatetype",
                    data: {
                        zy_id: r
                    },
                    success: function(t) {
                        a[o].zy_zhenzhuang = 1, e.setData({
                            selectdoctor1: a
                        }), console.log(t);
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    deldd: function(t) {
        var e = this, a = e.data.selectdoctororder, r = t.currentTarget.dataset.id, o = t.currentTarget.dataset.index;
        wx.showModal({
            content: "是否移除此订单",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/Updatetype3",
                    data: {
                        zy_id: r
                    },
                    success: function(t) {
                        a.splice(o, 1), e.setData({
                            selectdoctororder: a
                        });
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    deldd1: function(t) {
        var e = this, a = e.data.selectdoctor2, r = t.currentTarget.dataset.id, o = t.currentTarget.dataset.index;
        wx.showModal({
            content: "是否移除此订单",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/Updatetype3",
                    data: {
                        zy_id: r
                    },
                    success: function(t) {
                        console.log(t), a.splice(o, 1), e.setData({
                            selectdoctor2: a
                        });
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    deldd2: function(t) {
        var e = this, a = e.data.selectdoctor1, r = t.currentTarget.dataset.id, o = t.currentTarget.dataset.index;
        wx.showModal({
            content: "是否移除此订单",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/Updatetype3",
                    data: {
                        zy_id: r
                    },
                    success: function(t) {
                        console.log(t), a.splice(o, 1), e.setData({
                            selectdoctor1: a
                        });
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    }
});