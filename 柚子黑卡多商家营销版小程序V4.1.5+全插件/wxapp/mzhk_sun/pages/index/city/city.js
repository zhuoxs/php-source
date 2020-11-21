var app = getApp();

Page({
    data: {
        nav: [ {
            text: "选择省",
            state: 0,
            sadcode: ""
        }, {
            text: "选择市",
            state: 1,
            sadcode: ""
        }, {
            text: "选择区/县",
            state: 2,
            sadcode: ""
        } ],
        currentcity: "厦门",
        curHdIndex: 0,
        sadcode: ""
    },
    swichNav: function(t) {
        var a = this, e = t.currentTarget.dataset.state, n = t.currentTarget.dataset.sadcode;
        a.data.city;
        if (0 == e) app.util.request({
            url: "entry/wxapp/Getallcity",
            showLoading: !1,
            data: {
                state: e
            },
            success: function(t) {
                a.setData({
                    city: t.data,
                    curHdIndex: 0
                });
            }
        }); else if (1 == e) {
            if (!n) return wx.showModal({
                title: "提示",
                content: "请选择省份",
                showCancel: !1
            }), !1;
            app.util.request({
                url: "entry/wxapp/Getallcity",
                showLoading: !1,
                data: {
                    state: e,
                    adcode: n
                },
                success: function(t) {
                    a.setData({
                        city: t.data,
                        curHdIndex: 1
                    });
                }
            });
        }
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("currentcity");
        a.data.currcurrentcityCity;
        a.setData({
            currentcity: e
        }), app.util.request({
            url: "entry/wxapp/Getallcity",
            showLoading: !1,
            success: function(t) {
                a.setData({
                    city: t.data
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
    selectprovince: function(t) {
        var a = this, e = a.data.curHdIndex, n = t.currentTarget.dataset.adcode, c = t.currentTarget.dataset.name;
        a.data.nav;
        0 == e && a.setData({
            "nav[0].text": c,
            curHdIndex: e + 1,
            "nav[1].sadcode": n
        }), 1 == e && a.setData({
            "nav[1].text": c,
            curHdIndex: e + 1,
            "nav[2].sadcode": n
        }), 2 == e && a.setData({
            "nav[2].text": c,
            curHdIndex: 0,
            "nav[2].sadcode": n
        }), 3 == e && a.setData({
            curHdIndex: 0
        }), app.util.request({
            url: "entry/wxapp/Getnextcity",
            showLoading: !1,
            data: {
                adcode: n
            },
            success: function(t) {
                console.log(t), 2 == t.data ? app.util.request({
                    url: "entry/wxapp/Setcurrentcity",
                    showLoading: !1,
                    data: {
                        adcode: n,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(t) {
                        wx.setStorageSync("currentcity", t.data.currentcity), wx.reLaunch({
                            url: "../index"
                        });
                    }
                }) : a.setData({
                    city: t.data
                });
            }
        });
    },
    commitSearch: function(t) {
        var a = this, e = t.detail.value;
        if ("" == e) return wx.showModal({
            title: "提示",
            content: "请输入区县名称",
            showCancel: !1
        }), !1;
        app.util.request({
            url: "entry/wxapp/Searchcity",
            data: {
                city: e
            },
            success: function(t) {
                console.log(t), a.setData({
                    city: t.data,
                    curHdIndex: 2
                });
            }
        });
    },
    cancel: function(t) {
        this.setData({
            curHdIndex: 0
        }), wx.reLaunch({
            url: "../index"
        });
    }
});