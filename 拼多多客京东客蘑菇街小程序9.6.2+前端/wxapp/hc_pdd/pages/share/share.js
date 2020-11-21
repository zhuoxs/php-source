var app = getApp();

Page({
    data: {
        imgUrls: [ {
            xian: !1,
            img: "../../resource/images/3f324f22fd3acff9407605642d12ebsa7.png"
        }, {
            xian: !1,
            img: "../../resource/images/3f324f22fd3acff9407605642d12ebsa7.png"
        }, {
            xian: !1,
            img: "../../resource/images/3f324f22fd3acff9407605642d12ebsa7.png"
        } ],
        shu: 0
    },
    onLoad: function(a) {
        var o = this, t = o.data.myuser_id, e = app.globalData.openId;
        console.log(e);
        var s = a.user_id, d = a.goods_id, i = a.itemUrl, r = a.skuId, n = a.parameter, l = a.materialUrl, u = app.globalData.couponUrl;
        s = null != s ? a.user_id : app.globalData.user_id;
        var c = app.globalData.Headcolor;
        app.globalData.title;
        o.setData({
            goods_id: d,
            myuser_id: t,
            backgroundColor: c,
            user_id: s,
            openId: e,
            itemUrl: i,
            skuId: r,
            parameter: n,
            couponUrl: u,
            materialUrl: l
        }), console.log(o.data.user_id), app.util.request({
            url: "entry/wxapp/Goodsdetail",
            method: "POST",
            data: {
                goods_id_list: o.data.goods_id,
                user_id: o.data.user_id,
                itemUrl: o.data.itemUrl,
                skuId: o.data.skuId,
                parameter: o.data.parameter
            },
            success: function(a) {
                var t = a.data.data;
                o.setData({
                    goods: t
                }), console.log(t, "goods"), o.Shareurl();
            }
        });
    },
    fanhui: function() {
        wx.navigateBack({
            delta: 1
        });
    },
    Shareurl: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Shareurl",
            method: "POST",
            data: {
                goods_id: e.data.goods_id,
                user_id: e.data.user_id,
                itemId: e.data.goods.itemId,
                promId: e.data.goods.promid,
                skuId: e.data.skuId,
                materialUrl: e.data.materialUrl,
                couponUrl: e.data.couponUrl,
                parameter: e.data.parameter
            },
            success: function(a) {
                app.globalData.we_app_info = a.data.data.we_app_info;
                var t = a.data.data.we_app_info, o = a.data.data.wenan;
                e.setData({
                    we_app_info: t,
                    wenan: o
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    pengyiud: function() {
        var t = this;
        wx.showLoading({
            title: "图片保存中"
        }), app.util.request({
            url: "entry/wxapp/Create",
            method: "POST",
            data: {
                goodname: t.data.goods.goods_name,
                yuanjia: t.data.goods.min_group_price,
                xianjia: t.data.goods.now_price,
                youhuiquan: t.data.goods.coupon_discount,
                src_path: t.data.goods.goods_gallery_urls[0],
                user_id: app.globalData.user_id,
                path: app.globalData.we_app_info.page_path,
                goods_id: t.data.goods_id,
                itemUrl: t.data.itemUrl,
                skuId: t.data.skuId,
                parameter: t.data.parameter,
                materialUrl: t.data.materialUrl
            },
            success: function(a) {
                t.bao();
            },
            fail: function(a) {
                t.bao();
            }
        });
    },
    bao: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/CreatePoster",
            method: "POST",
            success: function(a) {
                var t = a.data.data;
                o.setData({
                    imgcxs: t
                }), wx.downloadFile({
                    url: o.data.imgcxs,
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
                            fail: function(a) {}
                        });
                    }
                });
            },
            fail: function(a) {
                console.log(a), console.log("失败" + a);
            }
        });
    },
    copy: function() {
        var a;
        a = this.data.wenan, wx.setClipboardData({
            data: a,
            success: function(a) {
                wx.getClipboardData({
                    success: function(a) {
                        console.log(a.data);
                    }
                });
            }
        });
    },
    duabnb: function() {
        this.data.imgcxs;
        this.setData({
            fenxia: !1
        }), wx.clearStorageSync();
    },
    baocun: function() {
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
                    filePath: t
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
    onShareAppMessage: function(a) {
        var t = this, o = t.data.goods.goods_thumbnail_url, e = t.data.goods.goods_name, s = t.data.goods.goods_title, d = t.data.goods_id, i = t.data.itemUrl, r = t.data.skuId, n = t.data.parameter, l = t.data.materialUrl, u = t.data.couponUrl;
        if (t.setData({
            goods_src: o,
            goods_name: e,
            goods_title: s
        }), 0 == n) var c = "hc_pdd/pages/details/details?goods_id=" + d + "&parameter=" + n + "&user_id=" + app.globalData.user_id + "&sharein=sharein"; else if (1 == n) c = "hc_pdd/pages/details/details?itemUrl=" + i + "&parameter=" + n + "&user_id=" + app.globalData.user_id; else if (2 == n) c = "hc_pdd/pages/details/details?skuId=" + r + "&parameter=" + n + "&materialUrl=" + l + "&couponUrl=" + u + "&user_id=" + app.globalData.user_id + "&sharein=sharein";
        return {
            title: t.data.goods_title,
            path: c,
            imageUrl: t.data.goods_src,
            success: function(a) {},
            fail: function(a) {}
        };
    }
});