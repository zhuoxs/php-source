var app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

Page({
    data: {
        list: [ "商品推荐", "营销素材", "新手必发" ],
        tiesstyle: 0,
        lisrimg: [ "../../resource/images/01a2565937d7a8a8012193a3af47cc.png", "../../resource/images/01a2565937d7a8a8012193a3af47cc.png", "../../resource/images/01a2565937d7a8a8012193a3af47cc.png" ],
        yuamn: !1,
        listindex: 1,
        pageNum: 1,
        loding: !0,
        hua: 0
    },
    onLoad: function(a) {
        var i = this;
        wx.getSystemInfo({
            success: function(a) {
                var t = (a = a).screenHeight - a.windowHeight + a.statusBarHeight;
                console.log(a), i.setData({
                    res: a,
                    htijty: t
                });
            }
        });
    },
    qiyua: function(a) {
        for (var t = a.currentTarget.id, i = this.data.list, s = 0; s < i.list.length; s++) var e = i.list[t].yuamn;
        i.list[t].yuamn = !e, this.setData({
            list: i
        });
    },
    tiesliyu: function(a) {
        var t = a.currentTarget.dataset.index, i = a.currentTarget.dataset.index + 1;
        this.setData({
            tiesstyle: t,
            listindex: i
        });
        var s = this.data.list;
        s.list = [], this.setData({
            list: s,
            pageNum: 1,
            hua: 0
        }), this.list(1);
    },
    previewImage: function(a) {
        var t = this.data.list.list, i = this.data.tiesstyle, s = a.currentTarget.id;
        console.log(s);
        var e = a.target.dataset.src;
        0 == i ? wx.previewImage({
            current: e,
            urls: t[s].copy_imgs
        }) : wx.previewImage({
            current: e,
            urls: [ e ]
        });
    },
    pengyiud: function(a) {
        var t = this, i = a.currentTarget.id;
        a = a.currentTarget.dataset;
        wx.showLoading({
            title: "图片保存中"
        }), 0 == t.data.tiesstyle ? app.util.request({
            url: "entry/wxapp/Create",
            method: "POST",
            data: {
                goodname: a.goods_name,
                yuanjia: a.yuanjia,
                xianjia: a.xianjia,
                youhuiquan: a.youhuiquan,
                src_path: a.src_path,
                user_id: app.globalData.user_id,
                goods_id: a.goods_id
            },
            success: function(a) {
                t.bao(i);
            },
            fail: function(a) {
                t.bao(i);
            }
        }) : t.jiyu(i);
    },
    bao: function(a) {
        var i = this, s = i.data.list.list, e = a;
        console.log(e);
        var t = s[e].copy_img;
        i.setData({
            imgIndex: t
        }), app.util.request({
            url: "entry/wxapp/CreatePoster",
            method: "POST",
            success: function(a) {
                var t = a.data.data;
                i.setData({
                    imgcxs: t
                }), wx.setClipboardData({
                    data: s[e].copy_text,
                    success: function(a) {}
                }), i.firstimg(), setTimeout(function() {
                    i.last();
                }, 200);
            },
            fail: function(a) {
                console.log(a), console.log("失败" + a);
            }
        });
    },
    jiyu: function(a) {
        var i = this, s = i.data.list.list, e = a;
        console.log(e);
        var t = s[e].copy_img;
        i.setData({
            imgIndex: t
        }), app.util.request({
            url: "entry/wxapp/saveqrcode",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                app.util.request({
                    url: "entry/wxapp/Save",
                    method: "POST",
                    success: function(a) {
                        var t = a.data.data;
                        i.setData({
                            imgcxs: t
                        }), wx.setClipboardData({
                            data: s[e].copy_text,
                            success: function(a) {}
                        }), i.firstimg(), setTimeout(function() {
                            i.last();
                        }, 200);
                    }
                });
            },
            fail: function(a) {
                console.log(a), console.log("失败" + a);
            }
        });
    },
    firstimg: function() {
        wx.downloadFile({
            url: this.data.imgcxs,
            success: function(a) {
                console.log(a);
                var t = a.tempFilePath;
                wx.showToast({
                    title: "保存成功",
                    icon: "success",
                    duration: 2e3
                }), wx.saveImageToPhotosAlbum({
                    filePath: t,
                    success: function(a) {
                        console.log(a);
                    },
                    fail: function(a) {
                        console.log(a, "失败");
                    }
                });
            }
        });
    },
    last: function() {
        wx.downloadFile({
            url: this.data.imgIndex,
            success: function(a) {
                console.log(a);
                var t = a.tempFilePath;
                wx.showToast({
                    title: "保存成功",
                    icon: "success",
                    duration: 2e3
                }), wx.saveImageToPhotosAlbum({
                    filePath: t,
                    success: function(a) {
                        console.log(a);
                    },
                    fail: function(a) {
                        console.log(a, "失败");
                    }
                });
            }
        });
    },
    onReady: function() {},
    list: function(a) {
        var o = this;
        o.data.list.list = [], app.util.request({
            url: "entry/wxapp/copy",
            method: "POST",
            data: {
                copy: o.data.listindex,
                user_id: app.globalData.user_id,
                pageNum: a
            },
            success: function(a) {
                for (var t = a.data.data, i = t.list, s = 0; s < t.list.length; s++) {
                    t.list[s].yuamn = !1;
                    var e = i[0].copy_img;
                }
                o.setData({
                    list: t,
                    copy_img: e
                }), console.log(t);
            },
            fail: function(a) {}
        });
    },
    jaizai: function(a) {
        var o = this, n = o.data.list;
        app.util.request({
            url: "entry/wxapp/copy",
            method: "POST",
            data: {
                copy: o.data.listindex,
                user_id: app.globalData.user_id,
                pageNum: a
            },
            success: function(a) {
                for (var t = a.data.data.list, i = 0; i < t.length; i++) n.list.push(t[i]);
                var s = n.list;
                for (i = 0; i < n.list.length; i++) {
                    n.list[i].yuamn = !1;
                    var e = s[0].copy_img;
                }
                o.setData({
                    list: n,
                    copy_img: e,
                    loding: !0,
                    goods: t
                });
            }
        });
    },
    onShow: function() {
        this.list(1);
        var t = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                a.data.data.config.head_color;
                app.globalData.Headcolor = a.data.data.config.head_color;
                a.data.data.config.title;
                app.globalData.title = a.data.data.config.title, t.setData({
                    backgroundColor: a.data.data.config.head_color,
                    title: a.data.data.config.title
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        var a = this.data.pageNum;
        console.log(this.data.goods), a++, this.setData({
            pageNum: a,
            loding: !1,
            hua: 1
        }), this.jaizai(a);
    },
    onShareAppMessage: function() {}
});