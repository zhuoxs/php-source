var _manage_shopModel = require("manage_shop-model.js");

function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var WxParse = require("../../sudu8_page/resource/wxParse/wxParse.js"), upload = new _manage_shopModel.manageShop(), app = getApp();

Page({
    data: {
        index: 0,
        id: "",
        logo_ok: [],
        pagedata: [],
        bg_ok: "",
        host: "",
        cateId: null,
        address: "",
        latitude: null,
        longitude: null,
        cateList: []
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = (t = app.siteInfo.siteroot).substring(0, t.length - 13) + "attachment/", e = this, o = wx.getStorageSync("mlogin");
        (this.data.id = o) && this._getShopInfo(o), e.setData({
            host: t,
            id: o
        });
        var d = 0;
        a.fxsid && (d = a.fxsid, e.setData({
            fxsid: a.fxsid
        }));
        var s = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: s,
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
        }), app.util.getUserInfo(e.getinfos, d);
    },
    _getShopInfo: function(a) {
        var r = this;
        app.util.request({
            url: "entry/wxapp/shopInfo",
            data: {
                id: a
            },
            success: function(a) {
                r.data.logo_ok = a.data.data[1].logo, r.data.bg_ok = a.data.data[1].bg, r.data.address = a.data.data[1].address;
                for (var t = [], e = a.data.data[1].images, o = 0; o < e.length; o++) {
                    var d = e[o];
                    t.push(d);
                }
                r.data.pagedata = t;
                var s = a.data.data[0];
                r.data.cateList = s;
                var i = [];
                for (o = 0; o < s.length; o++) if (i.push(s[o].name), s[o].id == a.data.data[1].cid) var n = o;
                r.setData({
                    proInfo: a.data.data[1],
                    content: WxParse.wxParse("content", "html", a.data.data[1].descp, r, 0),
                    imgs: r.data.pagedata,
                    logo: r.data.logo_ok,
                    bg: r.data.bg_ok,
                    catelist: s,
                    cateName: i,
                    cate: n,
                    address: r.data.address
                });
            }
        });
    },
    formSubmit: function(a) {
        for (var t, e = this, o = a.detail.value, d = [], s = e.data.pagedata, i = 0; i < s.length; i++) {
            var n = s[i].replace(e.data.host, "");
            d.push(n);
        }
        app.util.request({
            url: "entry/wxapp/editShop",
            data: (t = {
                username: o.username,
                password: o.password,
                title: o.title,
                descp: o.descp,
                cid: e.data.cateId,
                intro: o.intro,
                worktime: o.worktime,
                name: o.name,
                tel: o.tel,
                address: e.data.address,
                latitude: e.data.latitude,
                longitude: e.data.longitude
            }, _defineProperty(t, "title", o.title), _defineProperty(t, "images", d), _defineProperty(t, "logo", e.data.logo_ok), 
            _defineProperty(t, "bg", e.data.bg_ok), _defineProperty(t, "sid", wx.getStorageSync("mlogin")), 
            _defineProperty(t, "id", e.data.id), t),
            success: function(a) {
                0 == a.data.data ? wx.showModal({
                    title: "提示",
                    content: "添加失败",
                    showCancel: !1
                }) : wx.redirectTo({
                    url: "/sudu8_page_plugin_shop/manage_index/manage_index"
                });
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
                upload._uploadImg(a.tempFilePaths, function(a) {
                    var t = e.data.host + a;
                    e.data.pagedata.push(t), e.setData({
                        imgs: e.data.pagedata
                    });
                });
            }
        });
    },
    chooselogo: function() {
        var t = this;
        wx.chooseImage({
            count: 1,
            sizeType: [ "compressed", "original" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                upload._uploadImg(a.tempFilePaths, function(a) {
                    t.data.logo_ok = t.data.host + a, t.setData({
                        logo: t.data.logo_ok
                    });
                });
            }
        });
    },
    choosebg: function() {
        var t = this;
        wx.chooseImage({
            count: 1,
            sizeType: [ "original" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                upload._uploadImg(a.tempFilePaths, function(a) {
                    t.data.bg_ok = a, t.setData({
                        bg: t.data.host + t.data.bg_ok
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
    changePicker: function(a) {
        var t = a.detail.value, e = this.data.cateList;
        this.data.cateId = e[t].id, this.setData({
            cate: t
        });
    },
    getlocation: function() {
        var t = this;
        wx.chooseLocation({
            success: function(a) {
                t.data.address = a.address, t.data.latitude = a.latitude, t.data.longitude = a.longitude, 
                t.setData({
                    address: t.data.address
                });
            }
        });
    }
});