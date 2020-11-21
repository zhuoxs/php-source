var _manage_proModel = require("manage_pro-model.js"), upload = new _manage_proModel.managePro(), app = getApp();

Page({
    data: {
        index: 0,
        thumb: "",
        thumb_ok: "",
        id: "",
        hideAdd1: 1,
        pagedata: [],
        host: "",
        video: "",
        cid: 0
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = (t = app.siteInfo.siteroot).substring(0, t.length - 13) + "attachment/", e = this, o = a.id ? a.id : "";
        (this.data.id = o) && this._getProInfo(o), e.getcate(), e.setData({
            host: t,
            id: o
        });
        var i = 0;
        a.fxsid && (i = a.fxsid, e.setData({
            fxsid: a.fxsid
        }));
        var d = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: d,
            data: {
                vs1: 1
            },
            cachetime: "30",
            success: function(a) {
                a.data.data;
                e.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: e.data.baseinfo.base_tcolor,
                    backgroundColor: e.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(e.getinfos, i);
    },
    getcate: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/GetGoodsCate",
            data: {
                id: o.data.id
            },
            success: function(a) {
                o.data.id;
                var t = a.data.data, e = a.data.data.index;
                o.setData({
                    cateinfo: t,
                    index: e
                });
            }
        });
    },
    bindPickerChange: function(a) {
        var t = a.detail.value;
        if (0 < t) var e = t - 1;
        var o = this.data.cateinfo.list[e].id;
        this.setData({
            index: t,
            cid: o
        });
    },
    _getProInfo: function(a) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/showPro",
            data: {
                id: a,
                sid: wx.getStorageSync("mlogin")
            },
            success: function(a) {
                t.data.pagedata = a.data.data.images, t.data.thumb_ok = a.data.data.thumb, t.data.video = a.data.data.video, 
                t.setData({
                    proInfo: a.data.data,
                    imgs: t.data.pagedata,
                    thumb: t.data.thumb_ok,
                    video: t.data.video
                });
            }
        });
    },
    formSubmit: function(a) {
        var t = this, e = a.detail.value;
        if (0 == t.data.cid) return wx.showModal({
            title: "提示",
            content: "请选择所属栏目",
            showCancel: !1
        }), !1;
        if ("" == e.title) return wx.showModal({
            title: "提示",
            content: "请输入商品标题",
            showCancel: !1
        }), !1;
        if (100 < t.getBLen(e.title)) return wx.showModal({
            title: "提示",
            content: "商品标题最多输入50个汉字",
            showCancel: !1
        }), !1;
        if ("" == t.data.thumb_ok) return wx.showModal({
            title: "提示",
            content: "请上传商品缩略图",
            showCancel: !1
        }), !1;
        if (t.data.pagedata.length < 1) return wx.showModal({
            title: "提示",
            content: "请至少上传一张商品组图",
            showCancel: !1
        }), !1;
        if ("" == e.sellprice) return wx.showModal({
            title: "提示",
            content: "请输入商品售价",
            showCancel: !1
        }), !1;
        if (!t.isInt(e.sellprice)) return wx.showModal({
            title: "提示",
            content: "商品售价应为正数",
            showCancel: !1
        }), !1;
        if ("" == e.storage) return wx.showModal({
            title: "提示",
            content: "请输入商品库存",
            showCancel: !1
        }), !1;
        for (var o = [], i = t.data.pagedata, d = 0; d < i.length; d++) {
            var s = i[d].replace(t.data.host, "");
            o.push(s);
        }
        var n = -1 == t.data.thumb_ok.indexOf("https") ? t.data.thumb_ok.replace(t.data.host, " ") : t.data.thumb_ok;
        app.util.request({
            url: "entry/wxapp/addPro",
            data: {
                title: e.title,
                num: e.num,
                pageview: e.pageview,
                buy_type: 0,
                flag: e.flag,
                kuaidi: 0,
                rsales: e.rsales,
                sellprice: e.sellprice,
                marketprice: e.marketprice,
                storage: e.storage,
                descp: e.descp,
                images: o,
                thumb: n,
                sid: wx.getStorageSync("mlogin"),
                id: t.data.id,
                video: t.data.video,
                cid: t.data.cid
            },
            success: function(a) {
                0 == a.data.data ? wx.showModal({
                    title: "提示",
                    content: "添加失败",
                    showCancel: !1
                }) : (wx.showToast({
                    title: "添加/修改成功",
                    icon: "success"
                }), setTimeout(function() {
                    wx.redirectTo({
                        url: "/sudu8_page_plugin_shop/manage_prolist/manage_prolist"
                    });
                }, 1e3));
            }
        });
    },
    chooseimage: function() {
        var e = this;
        wx.chooseImage({
            count: 3,
            sizeType: [ "original" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                0 < a.tempFilePaths.length && upload._uploadImg(a.tempFilePaths, 1, function(a) {
                    var t = a;
                    e.data.pagedata.push(t), 2 < e.data.pagedata.length ? e.setData({
                        hideAdd: 0,
                        imgs: e.data.pagedata
                    }) : e.setData({
                        hideAdd: 1,
                        imgs: e.data.pagedata
                    });
                });
            }
        });
    },
    choosethumb: function() {
        var e = this;
        wx.chooseImage({
            count: 1,
            sizeType: [ "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                upload._uploadImg(t.tempFilePaths, 1, function(a) {
                    e.data.thumb_ok = a, e.setData({
                        thumb: t.tempFilePaths,
                        hideAdd1: 0
                    });
                });
            }
        });
    },
    delimg: function(a) {
        var t = a.currentTarget.dataset.id, e = this.data.pagedata;
        e.splice(t, 1), this.setData({
            imgs: e
        });
    },
    changeVideo: function(a) {
        var e = this;
        wx.chooseVideo({
            sourceType: [ "album", "camera" ],
            maxDuration: 30,
            success: function(a) {
                upload._uploadImg(a.tempFilePath, 2, function(a) {
                    var t = e.data.host + a;
                    e.data.video = t, e.setData({
                        video: e.data.video,
                        hideAdd1: 0
                    });
                });
            }
        });
    },
    getBLen: function(a) {
        return null == a ? 0 : ("string" != typeof a && (a += ""), a.replace(/[^\x00-\xff]/g, "01").length);
    },
    isInt: function(a) {
        return !!/^\d+(?=\.{0,1}\d+$|$)/.test(a);
    }
});