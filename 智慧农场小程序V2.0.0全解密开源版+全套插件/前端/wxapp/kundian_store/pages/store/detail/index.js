var t = new getApp(), e = t.util.getNewUrl("entry/wxapp/store", "kundian_farm_plugin_store");

Page({
    data: {
        isIphoneX: t.globalData.isIphoneX,
        store: [],
        store_id: "",
        live: [],
        slideCurrent: 1,
        page: 1,
        showPost: !1,
        setData: []
    },
    onLoad: function(a) {
        var o = this, s = a.store_id, i = wx.getStorageSync("kundian_farm_uid"), n = wx.getStorageSync("kundian_farm_setData");
        t.util.setNavColor(t.siteInfo.uniacid), o.setData({
            setData: n,
            store_id: s
        }), wx.request({
            url: e,
            data: {
                control: "index",
                op: "storeDetail",
                type: "init",
                store_id: s,
                uid: i
            },
            success: function(t) {
                o.setData({
                    store: t.data.store,
                    live: t.data.live
                });
            }
        });
    },
    doCall: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.store.phone
        });
    },
    doMap: function() {
        var t = this.data.store;
        wx.openLocation({
            latitude: parseFloat(t.latitude),
            longitude: parseFloat(t.longitude),
            name: t.name,
            address: t.address
        });
    },
    playVideo: function(t) {
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../video/index?id=" + e
        });
    },
    setCurrent: function(t) {
        this.setData({
            slideCurrent: parseInt(t.detail.current) + 1
        });
    },
    onReachBottom: function() {
        var t = this, a = t.data, o = a.store_id, s = a.live, i = a.page;
        i = parseInt(i) + 1;
        wx.getStorageSync("kundian_farm_uid");
        wx.request({
            url: e,
            data: {
                control: "index",
                op: "storeDetail",
                type: "live_more",
                store_id: o,
                page: i
            },
            success: function(e) {
                e.data.live && (e.data.live.map(function(t, e) {
                    s.push(t);
                }), t.setData({
                    live: s,
                    page: i
                }));
            }
        });
    },
    createPost: function(t) {
        var e = this, a = e.data.store;
        a.post_img ? this.setData({
            showPost: !0,
            local_src: a.post_img,
            post_src: a.post_img
        }) : e.createPoster();
    },
    createPoster: function() {
        var t = this, a = t.data.store;
        wx.showLoading({
            title: "海报生成中..."
        }), wx.request({
            url: e,
            data: {
                control: "store",
                op: "createPoster",
                store_id: a.id
            },
            success: function(e) {
                a.post_img = e.data.post_src, t.setData({
                    local_src: e.data.local_src,
                    post_src: e.data.post_src,
                    showPost: !0,
                    store: a
                }), wx.hideLoading();
            }
        });
    },
    savePost: function(t) {
        var e = this.data.local_src;
        wx.downloadFile({
            url: e,
            success: function(t) {
                wx.saveImageToPhotosAlbum({
                    filePath: t.tempFilePath,
                    success: function(t) {
                        wx.showModal({
                            title: "提示",
                            content: "海报保存成功",
                            showCancel: !1
                        });
                    },
                    fail: function(t) {}
                });
            }
        });
    },
    hidePost: function() {
        this.setData({
            showPost: !1
        });
    }
});