var app = getApp();

Page({
    data: {
        navTile: "动态",
        banner: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531842309.png",
        dynamicList: [],
        inputShowed: !1,
        comment: "",
        isLogin: !1,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(t) {
        console.log("重新加载");
        var a = this;
        wx.setNavigationBarTitle({
            title: a.data.navTile
        }), app.get_setting(!0).then(function(t) {
            wx.setNavigationBarColor({
                frontColor: t.fontcolor,
                backgroundColor: t.color
            }), a.setData({
                store_open: t.store_open
            });
        }), app.get_imgroot().then(function(t) {
            a.setData({
                imgroot: t
            });
        }), app.util.request({
            url: "entry/wxapp/Tab",
            cachetime: "0",
            success: function(t) {
                a.setData({
                    tab: t.data.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        app.get_openid().then(function(t) {
            app.util.request({
                url: "entry/wxapp/getDynamic",
                cachetime: "0",
                data: {
                    openid: t
                },
                success: function(t) {
                    a.setData({
                        dynamic: t.data
                    });
                }
            });
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    clickGood: function(t) {
        var a = this, e = a.data.dynamic, n = t.currentTarget.dataset.statu, i = t.currentTarget.dataset.index, o = t.currentTarget.dataset.id, c = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/setDynamicCollection",
            cachetime: "0",
            data: {
                openid: c,
                dynamic_id: o,
                is_status: n
            },
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/getDynamicCollectionHeadimg",
                    cachetime: "0",
                    data: {
                        dynamic_id: o
                    },
                    success: function(t) {
                        console.log("返回信息"), console.log(t.data);
                        t.data.length;
                        e[i].is_collection = 1 == n ? 1 : 0, e[i].headimg = t.data, a.setData({
                            dynamic: e
                        });
                    }
                });
            }
        });
    },
    toMsg: function(t) {
        this.data.dynamicList;
        var a = t.currentTarget.dataset.index, e = t.currentTarget.dataset.id;
        this.setData({
            comment_id: e,
            inputShowed: !0,
            commIndex: a
        });
    },
    loseFocus: function(t) {
        var a = this, e = wx.getStorageSync("openid"), n = a.data.comment_id, i = a.data.comment, o = a.data.dynamic, c = a.data.commIndex;
        "" != i ? app.util.request({
            url: "entry/wxapp/setDynamicComment",
            cachetime: "0",
            data: {
                openid: e,
                comment: i,
                comment_id: n
            },
            success: function(t) {
                app.util.request({
                    url: "entry/wxapp/getDynamicComment",
                    cachetime: "0",
                    data: {
                        comment_id: n
                    },
                    success: function(t) {
                        o[c].comment = t.data, a.setData({
                            dynamic: o,
                            inputShowed: !1,
                            comment: ""
                        });
                    }
                });
            }
        }) : a.setData({
            inputShowed: !1
        });
    },
    comment: function(t) {
        this.setData({
            comment: t.detail.value
        });
    },
    previewImg: function(t) {
        for (var a = this.data.dynamic, e = this.data.imgroot, n = t.currentTarget.dataset.index, i = t.currentTarget.dataset.idx, o = e + "" + a[n].imgs[i], c = a[n].imgs, s = 0; s < c.length; s++) c[s] = e + "" + c[s];
        wx.previewImage({
            current: o,
            urls: c
        });
    },
    toGoodsdet: function(t) {
        var a = t.currentTarget.dataset.gid, e = t.currentTarget.dataset.related_gid;
        0 < e && (a = e), wx.navigateTo({
            url: "/yzcyk_sun/pages/index/parentingdet/parentingdet?id=" + a
        });
    }
});