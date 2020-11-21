var t = new getApp(), e = t.util.getNewUrl("entry/wxapp/store", "kundian_farm_plugin_store");

Page({
    data: {
        isIphoneX: t.globalData.isIphoneX,
        store: [],
        remark: [],
        page: 1,
        slideCurrent: 1,
        setData: []
    },
    onLoad: function(e) {
        var o = e.phone, a = wx.getStorageSync("kundian_farm_setData");
        this.setData({
            phone: o,
            setData: a
        }), t.util.setNavColor(t.siteInfo.uniacid), this.getStoreInfo();
    },
    onShow: function(t) {
        this.getStoreInfo(), this.setData({
            page: 1
        });
    },
    getStoreInfo: function(t) {
        var o = this, a = o.data.phone;
        wx.request({
            url: e,
            data: {
                op: "storeLogin",
                control: "store",
                type: "getStoreAndLive",
                phone: a
            },
            success: function(t) {
                var e = t.data.store.remark.split(",");
                o.setData({
                    store: t.data.store,
                    remark: e,
                    live: t.data.live
                });
            }
        });
    },
    toUpdate: function(t) {
        var e = t.currentTarget.dataset.type;
        wx.navigateTo({
            url: "../update/index?uType=" + e + "&phone=" + this.data.store.phone
        });
    },
    chooseLogo: function(o) {
        var a = this, s = a.data.store;
        wx.chooseImage({
            count: 1,
            success: function(o) {
                var i = t.siteInfo.siteroot.replace("app/index.php", "web/index.php") + "?i=" + t.siteInfo.uniacid + "&c=utility&a=file&do=upload&thumb=0";
                wx.showToast({
                    title: "正在上传...",
                    icon: "loading",
                    mask: !0,
                    duration: 1e3
                }), wx.uploadFile({
                    url: i,
                    filePath: o.tempFilePaths[0],
                    name: "file",
                    formData: {
                        op: "upload_file"
                    },
                    success: function(t) {
                        var o = JSON.parse(t.data);
                        wx.request({
                            url: e,
                            data: {
                                op: "updateStore",
                                control: "store",
                                id: s.id,
                                uType: "logo",
                                logo: o.url
                            },
                            success: function(t) {
                                wx.hideToast(), s.logo = o.url, a.setData({
                                    store: s
                                }), wx.showToast({
                                    title: t.data.msg,
                                    icon: "none"
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    toAddLive: function(t) {
        wx.navigateTo({
            url: "../addVideo/index?store_id=" + this.data.store.id
        });
    },
    editVideo: function(t) {
        wx.navigateTo({
            url: "../addVideo/index?store_id=" + this.data.store.id + "&id=" + t.currentTarget.dataset.id
        });
    },
    doRecord: function() {
        wx.navigateTo({
            url: "../browse/index?store_id=" + this.data.store.id
        });
    },
    delVideo: function(t) {
        var o = this, a = t.currentTarget.dataset.id, s = o.data.store;
        wx.showModal({
            title: "提示",
            content: "确认删除该监控吗？",
            success: function(t) {
                t.confirm && wx.request({
                    url: e,
                    data: {
                        control: "store",
                        op: "handleLive",
                        type: "delVideo",
                        id: a,
                        store_id: s.id
                    },
                    success: function(t) {
                        wx.showToast({
                            title: t.data.msg,
                            icon: "none",
                            success: function() {
                                if (0 == t.data.code) var e = setTimeout(function() {
                                    clearTimeout(e), o.getStoreInfo();
                                }, 1500);
                            }
                        });
                    }
                });
            }
        });
    },
    onReachBottom: function(t) {
        wx.showLoading({
            title: "玩命加载中..."
        });
        var o = this, a = o.data, s = a.store, i = a.page, n = a.live;
        i = parseInt(i) + 1, wx.request({
            url: e,
            data: {
                op: "storeLogin",
                control: "store",
                type: "getLive",
                store_id: s.id,
                page: i
            },
            success: function(t) {
                var e = t.data.live;
                e && (e.map(function(t, e) {
                    n.push(t);
                }), o.setData({
                    live: n,
                    page: i
                })), wx.hideLoading();
            }
        });
    },
    playVidel: function(t) {
        wx.navigateTo({
            url: "../video/index?id=" + t.currentTarget.dataset.id
        });
    },
    createPost: function(t) {
        var e = this, o = e.data.store;
        o.post_img ? this.setData({
            showPost: !0,
            local_src: o.post_img,
            post_src: o.post_img
        }) : e.createPoster();
    },
    afreshPost: function() {
        this.createPoster();
    },
    createPoster: function() {
        var t = this, o = t.data.store;
        wx.showLoading({
            title: "海报生成中..."
        }), wx.request({
            url: e,
            data: {
                control: "store",
                op: "createPoster",
                store_id: o.id
            },
            success: function(e) {
                t.setData({
                    local_src: e.data.local_src,
                    post_src: e.data.post_src,
                    showPost: !0
                }), wx.hideLoading();
            }
        });
    },
    hidePost: function() {
        this.setData({
            showPost: !1
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
    onShareAppMessage: function(t) {
        var e = this.data.store;
        return {
            path: "/kundian_store/pages/store/detail/index?&store_id=" + e.id,
            success: function(t) {},
            title: e.name,
            imageUrl: e.logo
        };
    },
    setCurrent: function(t) {
        this.setData({
            slideCurrent: parseInt(t.detail.current) + 1
        });
    }
});