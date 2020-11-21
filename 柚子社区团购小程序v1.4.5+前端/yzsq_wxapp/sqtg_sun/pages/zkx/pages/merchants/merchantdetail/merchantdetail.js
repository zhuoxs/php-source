var app = getApp();

Page({
    data: {
        page: 1,
        limit: 10
    },
    onLoad: function(t) {
        var o = this;
        this.setData({
            id: t.id
        }), this.getControl(), this.loadDate(), wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var a = t.latitude, e = t.longitude;
                o.setData({
                    latitude: a,
                    longitude: e
                }), o.getStorelist();
            },
            fail: function(t) {
                console.log("获取地址失败"), o.setData({
                    popAllow: !0
                });
            }
        });
    },
    getControl: function() {
        var a = this;
        app.ajax({
            url: "Index|getpluginkey",
            success: function(t) {
                a.setData({
                    control: t.data
                });
            }
        });
    },
    getStorelist: function() {
        var o = this, t = o.data.latitude, a = o.data.longitude, i = o.data.page, s = o.data.limit, e = o.data.id;
        app.ajax({
            url: "Cshop|getShops",
            data: {
                longitude: a,
                latitude: t,
                page: i,
                limit: s,
                store_id: e
            },
            success: function(t) {
                console.log(t);
                var a = o.data.storelist;
                if (1 == i) a = t.data; else for (var e in t.data) a.push(t.data[e]);
                o.setData({
                    nomore: t.data.length < s,
                    storelist: a,
                    img_root: t.other.img_root,
                    show: !0
                });
            }
        });
    },
    loadDate: function() {
        var a = this;
        app.ajax({
            url: "Cstore|getStore",
            data: {
                id: a.data.id
            },
            success: function(t) {
                a.setData({
                    shop: t.data,
                    imgroot: t.other.img_root,
                    show: !0
                });
            }
        });
    },
    handler: function(t) {
        var o = this;
        t.detail.authSetting["scope.userLocation"] ? wx.getLocation({
            type: "wgs84",
            success: function(t) {
                var a = t.latitude, e = t.longitude;
                o.setData({
                    latitude: a,
                    longitude: e
                }), o.getStorelist(), o.setData({
                    popAllow: !1
                });
            }
        }) : console.log("获取地址失败");
    },
    allowAddress: function() {
        wx.getLocation({
            success: function(t) {
                console.log(t);
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    addPage: function() {
        var t = this, a = t.data.page;
        t.setData({
            page: ++a
        }), t.getStorelist();
    },
    onReachBottom: function() {
        this.data.nomore || this.addPage();
    },
    onShow: function() {},
    onShareAppMessage: function() {},
    toStoreindex: function() {
        app.reTo("/sqtg_sun/pages/zkx/pages/merchants/merchantindex/merchantindex?id=" + this.data.id);
    },
    toAllgoods: function() {
        app.reTo("/sqtg_sun/pages/zkx/pages/merchants/allgoods/allgoods?id=" + this.data.id);
    },
    toStoredetail: function() {
        app.reTo("/sqtg_sun/pages/zkx/pages/merchants/merchantdetail/merchantdetail?id=" + this.data.id);
    },
    onSpellTab: function() {
        app.reTo("/sqtg_sun/pages/plugin/spell/list/list?id=" + this.data.id);
    },
    onSeckillTab: function() {
        app.reTo("/sqtg_sun/pages/plugin/seckill/list/list?id=" + this.data.id);
    },
    toggleService: function() {
        this.setData({
            service: !this.data.service
        });
    },
    copyTxt: function(t) {
        var a = this;
        wx.setClipboardData({
            data: this.data.shop.wechat_number + " " + this.data.shop.tel,
            success: function(t) {
                wx.getClipboardData({
                    success: function(t) {
                        app.tips("复制成功"), a.toggleService();
                    }
                });
            }
        });
    },
    getDialog: function(t) {
        wx.makePhoneCall({
            phoneNumber: this.data.shop.tel
        });
    },
    callme: function(t) {
        wx.makePhoneCall({
            phoneNumber: this.data.shop.tel
        });
    }
});