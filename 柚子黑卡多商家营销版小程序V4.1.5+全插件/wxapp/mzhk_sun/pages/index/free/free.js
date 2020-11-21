var app = getApp();

Page({
    data: {
        navTile: "我要免单",
        banner: "",
        curList: [],
        page: 1,
        is_modal_Hidden: !0,
        adflashimg: []
    },
    onLoad: function(t) {
        var o = this, a = app.getSiteUrl();
        a ? (o.setData({
            url: a
        }), app.editTabBar(a)) : app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a = t.data, app.editTabBar(a), o.setData({
                    url: a
                });
            }
        }), app.wxauthSetting(), wx.setNavigationBarTitle({
            title: o.data.navTile
        }), wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("System").fontcolor ? wx.getStorageSync("System").fontcolor : "",
            backgroundColor: wx.getStorageSync("System").color ? wx.getStorageSync("System").color : "",
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var a = t.latitude, e = t.longitude;
                app.util.request({
                    url: "entry/wxapp/QGactive",
                    data: {
                        showtype: 6,
                        lat: a,
                        lon: e,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(t) {
                        console.log(t.data), 2 == t.data ? o.setData({
                            curList: []
                        }) : o.setData({
                            curList: t.data
                        });
                    }
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetadData",
            cachetime: "30",
            data: {
                position: 7
            },
            success: function(t) {
                console.log("11111"), console.log(t.data);
                var a = t.data;
                o.setData({
                    adflashimg: a
                });
            }
        });
    },
    toIndex: function(t) {
        wx.reLaunch({
            url: "../index"
        });
    },
    gotoadinfo: function(t) {
        var a = t.currentTarget.dataset.tid, e = t.currentTarget.dataset.id;
        app.func.gotourl(app, a, e);
    },
    formid_one: function(t) {
        console.log("搜集第一个formid"), console.log(t), app.util.request({
            url: "entry/wxapp/SaveFormid",
            cachetime: "0",
            data: {
                user_id: wx.getStorageSync("users").id,
                form_id: t.detail.formId,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {}
        });
    },
    onReady: function() {},
    onShow: function() {
        app.func.islogin(app, this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var o = this, n = o.data.page, i = o.data.curList;
        console.log(n), wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var a = t.latitude, e = t.longitude;
                app.util.request({
                    url: "entry/wxapp/QGactive",
                    cachetime: "30",
                    data: {
                        showtype: 6,
                        lat: a,
                        lon: e,
                        page: n,
                        openid: wx.getStorageSync("openid")
                    },
                    success: function(t) {
                        if (console.log("活动数据"), console.log(t.data), 2 == t.data) wx.showToast({
                            title: "已经没有内容了哦！！！",
                            icon: "none"
                        }); else {
                            var a = t.data;
                            i = i.concat(a), o.setData({
                                curList: i,
                                page: n + 1
                            });
                        }
                    }
                });
            }
        });
    },
    onShareAppMessage: function() {},
    toFreedet: function(t) {
        var a = t.currentTarget.dataset.gid;
        wx.navigateTo({
            url: "../freedet/freedet?id=" + a
        });
    },
    updateUserInfo: function(t) {
        console.log("授权操作更新");
        app.wxauthSetting();
    }
});