function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp(), WxParse = require("../../../../../zhy/template/wxParse/wxParse.js"), foot = require("../../../../../zhy/component/comFooter/dealfoot.js");

Page({
    data: {
        activeIndex: 0,
        store_id: 0,
        showStore: !1
    },
    onLoad: function(t) {
        t.id && this.setData({
            store_id: t.id
        }), this.onLoadData();
    },
    onLoadData: function() {
        var o = this;
        app.ajax({
            url: "Index|getpluginkey",
            success: function(t) {
                console.log(t.data);
            }
        }), 0 < this.data.store_id && app.api.getIndexGetpluginkey().then(function(t) {
            return t.data.plugin_2 && t.data.plugin_6 && o.setData({
                showStore: !0
            }), o.setData({
                control: t.data
            }), app.api.getCstoreGetStore({
                id: o.data.store_id
            });
        }).then(function(t) {
            o.setData({
                shop: t.data,
                imgroot: t.other.img_root
            });
        }).catch(function(t) {
            t.code, app.tips(t.msg);
        }), Promise.all([ app.api.getCpinBanner(), app.api.getCpinClassifyList() ]).then(function(t) {
            var a = foot.dealFootNav(t[0].data, t[0].other.img_root);
            o.setData({
                banner: a,
                nav: t[1].data,
                imgRoot: t[0].other.img_root
            });
            var e = wx.getStorageSync("linkaddress"), i = {
                page: o.data.list.page,
                length: o.data.list.length,
                cid: o.data.nav[0].id,
                is_hot: o.data.nav[0].is_hot,
                store_id: o.data.store_id,
                leader_id: e.id
            };
            return app.api.getCpinGoodsList(i);
        }).then(function(t) {
            var a = t.data;
            for (var e in a) {
                var i = a[e].id + "-0";
                a[e].key_id = i;
            }
            o.dealList(a, 0), o.setData({
                show: !0
            });
        }).catch(function(t) {
            console.log(t), t.code, app.tips(t.msg);
        });
    },
    loadList: function() {
        var o = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var t = wx.getStorageSync("linkaddress"), a = {
                page: this.data.list.page,
                length: this.data.list.length,
                cid: this.data.nav[this.data.activeIndex].id,
                is_hot: this.data.nav[this.data.activeIndex].is_hot,
                store_id: this.data.store_id,
                leader_id: t.id
            };
            app.api.getCpinGoodsList(a).then(function(t) {
                var a = t.data;
                for (var e in a) {
                    var i = a[e].id + "-0";
                    a[e].key_id = i;
                }
                o.dealList(t.data, 0);
            }).catch(function(t) {
                t.code, app.tips(t.msg);
            });
        }
    },
    onReachBottom: function() {
        this.loadList();
    },
    _onNavTab1: function(t) {
        var a = getCurrentPages(), e = "/" + a[a.length - 1].route, i = t.currentTarget.dataset.index, o = this.data.banner[i].link, s = this.data.banner[i].typeid;
        o != e && "" != o && app.navTo(o + "?id=" + s);
    },
    swichNav: function(t) {
        var a = t.currentTarget.dataset.index;
        this.setData({
            activeIndex: a,
            list: {
                page: 1,
                length: 10,
                over: !1,
                load: !1,
                none: !1,
                data: []
            }
        }), this.loadList();
    },
    toStoreindex: function() {
        app.reTo("/sqtg_sun/pages/zkx/pages/merchants/merchantindex/merchantindex?id=" + this.data.store_id);
    },
    toAllgoods: function() {
        app.reTo("/sqtg_sun/pages/zkx/pages/merchants/allgoods/allgoods?id=" + this.data.store_id);
    },
    toStoredetail: function() {
        app.reTo("/sqtg_sun/pages/zkx/pages/merchants/merchantdetail/merchantdetail?id=" + this.data.store_id);
    },
    onSpellTab: function() {
        app.reTo("/sqtg_sun/pages/plugin/spell/list/list?id=" + this.data.store_id);
    },
    onSeckillTab: function() {
        app.reTo("/sqtg_sun/pages/plugin/seckill/list/list?id=" + this.data.store_id);
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
    }
});