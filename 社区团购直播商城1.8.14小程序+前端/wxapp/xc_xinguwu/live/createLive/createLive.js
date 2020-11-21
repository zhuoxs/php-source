function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var app = getApp(), sel_good_del_idx = null;

Page({
    data: {
        page: 1,
        pagesize: 5,
        loadend: !1,
        inputVal: "",
        inputShowed: !1,
        addDetail: !1,
        goodsSitting: !1,
        show_del_sel: !1,
        sel_goods: [],
        list: [],
        filename: "",
        live_time: 48,
        hasGoods: !1,
        staus: 1,
        selectAllStatus: !1
    },
    toliveIndex: function() {
        wx.navigateTo({
            url: "../liveIndex/liveIndex?id=" + this.data.list.id + "&style=2"
        });
    },
    showInput: function() {
        this.setData({
            inputShowed: !0
        });
    },
    hideInput: function() {
        this.setData({
            inputShowed: !1
        }), this.clearInput(), app.util.request({
            url: "entry/wxapp/live",
            showLoading: !1,
            method: "POST",
            data: {
                op: "live_goods",
                page: 1,
                pagesize: that.data.pagesize
            },
            success: function(t) {
                var e = t.data;
                e.data.goods && that.setData({
                    goods: e.data.goods,
                    page: 1,
                    loadend: !1
                });
            },
            fail: function(t) {
                app.look, alert(t.data.messge), that.setData({
                    loadend: !0,
                    goods: []
                });
            }
        });
    },
    inputTyping: function(t) {
        this.setData({
            inputVal: t.detail.value
        });
    },
    clearInput: function() {
        this.setData({
            inputVal: ""
        });
    },
    search: function() {
        var t = this.data.inputVal;
        if ("" != t) {
            var a = this;
            app.util.request({
                url: "entry/wxapp/live",
                method: "POST",
                showLoading: !0,
                data: {
                    op: "live_goods",
                    page: 1,
                    pagesize: a.data.pagesize,
                    search: t
                },
                success: function(t) {
                    var e = t.data;
                    e.data.goods && a.setData({
                        goods: e.data.goods,
                        page: 1,
                        loadeng: !1
                    });
                },
                fail: function(t) {
                    app.look.alert(t.data.message), a.setData({
                        loadend: !0,
                        goods: []
                    });
                }
            });
        } else app.look.alert("請輸入搜索內容");
    },
    selectList: function(t) {
        var e = t.currentTarget.dataset.index;
        this.setData(_defineProperty({}, "goods[" + e + "].selected", -this.data.goods[e].selected));
    },
    select_sure: function() {
        for (var t = this.data.goods, e = [], a = 0, o = t.length, i = 0; a < o; a++) 1 == t[a].selected && (e[i] = t[a], 
        i++);
        this.setData({
            sel_goods: e,
            addDetail: !1
        });
    },
    goodsSitting: function() {
        this.setData({
            goodsSitting: !this.data.goodsSitting
        });
    },
    chooseImage: function() {
        var o = this, t = new app.util.date(), i = "images/" + app.siteInfo.uniacid + "/" + t.dateToStr("yyyy") + t.dateToStr("/MM/") + app.util.md5("xc_xinguwu" + t.dateToLong(new Date()) + Math.random().toString(36).substr(2)) + ".jpg";
        wx.chooseImage({
            count: 1,
            sizeType: [ "compressed" ],
            success: function(t) {
                var a = t.tempFilePaths;
                wx.uploadFile({
                    url: app.siteInfo.siteroot + "?i=" + app.siteInfo.uniacid + "&c=entry&do=upload&m=xc_xinguwu",
                    filePath: a[0],
                    name: "file",
                    formData: {
                        filename: i
                    },
                    success: function(t) {
                        var e;
                        o.setData((_defineProperty(e = {}, "list.img", a[0]), _defineProperty(e, "filename", i), 
                        e));
                    }
                });
            }
        });
    },
    previewImage: function(t) {
        wx.previewImage({
            current: t.currentTarget.id,
            urls: this.data.files
        });
    },
    choGoods: function() {
        this.setData({
            addDetail: !this.data.addDetail
        });
    },
    toDelete: function(a) {
        var o = this;
        wx.showActionSheet({
            itemList: [ "移除商品" ],
            success: function(t) {
                if (0 == t.tapIndex) {
                    var e = o.data.sel_goods;
                    wx.showModal({
                        title: "提示",
                        content: "确定删除商品？",
                        success: function(t) {
                            t.confirm ? (e.splice(a.currentTarget.dataset.index, 1), o.setData({
                                sel_goods: e
                            })) : t.cancel && console.log("用户点击取消");
                        }
                    });
                }
            }
        });
    },
    sureDelete: function() {
        var e = this, a = this.data.sel_goods;
        wx.showModal({
            title: "提示",
            content: "确定删除商品？",
            success: function(t) {
                t.confirm ? (a.splice(sel_good_del_idx, 1), e.setData({
                    sel_goods: a,
                    show: !1
                })) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    setselect: function(t) {
        for (var e = this.data.sel_goods, a = 0, o = t.length; a < o; a++) {
            t[a].selected = -1;
            for (var i = 0, s = e.length; i < s; i++) if (e[i].id == t[a].id) {
                t[a].selected = 1;
                break;
            }
        }
        return t;
    },
    live_name: function(t) {
        console.log(t), this.setData(_defineProperty({}, "list.title", t.detail.value));
    },
    live_time: function(t) {
        this.setData({
            live_time: t.detail.value
        });
    },
    myform: function(t) {
        var e = this;
        e.data.filename, e.data.sel_goods, e.data.live_time;
        app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            data: {
                op: "creat_live",
                id: e.data.list ? e.data.list.id : "",
                title: e.data.list.title,
                filename: e.data.filename,
                live_time: e.data.live_time,
                sel_goods: JSON.stringify(e.data.sel_goods)
            },
            success: function(t) {
                app.look.ok(t.data.message, function() {
                    wx.navigateTo({
                        url: "../livePush/livePush?id=" + t.data.data
                    });
                }, 2e3);
            }
        });
    },
    onLoad: function(t) {
        var a = this;
        if (1 != app.globalData.userInfo.admin1 && 1 != app.globalData.userInfo.admin2) {
            if (!app.look.istrue(t.supplier_id)) return this.options.supplier_id = null, void app.look.alert("无操作权限", function() {
                wx.redirectTo({
                    url: "/xc_xinguwu/pages/index/index"
                });
            });
            this.options = t;
        } else this.options.supplier_id = "";
        a.setData({
            userinfo: app.globalData.userInfo
        }), app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            data: {
                op: "live_info"
            },
            success: function(t) {
                var e = t.data;
                console.log(e), e.data.list && (a.setData({
                    list: e.data.list
                }), app.look.istrue(e.data.list.contents) && a.setData({
                    sel_goods: e.data.list.contents
                }));
            },
            fail: function(t) {
                1 == app.globalData.webset.live_create || app.look.alert(t.data.message, function() {
                    wx.navigateBack({
                        delta: 1
                    });
                });
            }
        }), app.util.request({
            url: "entry/wxapp/live",
            method: "POST",
            data: {
                op: "live_goods",
                page: a.data.page,
                pagesize: a.data.pagesize,
                supplier_id: a.options.supplier_id
            },
            success: function(t) {
                var e = t.data;
                console.log(e), e.data.goods && a.setData({
                    goods: a.setselect(e.data.goods)
                });
            },
            fail: function(t) {
                app.look.alert(t.data.message), a.setData({
                    loadend: !0
                });
            }
        });
    },
    loadGoods: function() {
        if (!this.data.loadend) {
            var a = this;
            app.util.request({
                url: "entry/wxapp/live",
                method: "POST",
                data: {
                    op: "live_goods",
                    page: a.data.page + 1,
                    pagesize: a.data.pagesize,
                    supplier_id: a.options.supplier_id
                },
                success: function(t) {
                    var e = t.data;
                    e.data.goods && (console.log(e.data.goods), a.setData({
                        goods: a.data.goods.concat(a.setselect(e.data.goods)),
                        page: a.data.page + 1
                    }));
                },
                fail: function(t) {
                    app.look.alert(t.data.message), a.setData({
                        loadend: !0
                    });
                }
            });
        }
    },
    onReady: function() {
        var t = {};
        t.dy_add = app.module_url + "resource/wxapp/live/dy-add.png", t.selected = app.module_url + "resource/wxapp/live/selected.png", 
        this.setData({
            images: t
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});