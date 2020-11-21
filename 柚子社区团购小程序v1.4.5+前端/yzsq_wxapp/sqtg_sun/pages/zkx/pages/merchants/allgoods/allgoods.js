function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp();

Page({
    data: {
        spindex: 0,
        show: !1,
        orderBy: "asc",
        field: "create_time"
    },
    onLoad: function(t) {
        this.setData({
            id: t.id,
            cat_id: t.catid || 0
        }), this.getControl(), this.loadDate(), this.getGoods();
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
    getGoods: function() {
        var a = this;
        this.data.list.over ? app.tips("没有更多商品啦~") : (this.setData(_defineProperty({}, "list.load", !0)), 
        app.ajax({
            url: "Cgoods|getCatGoodses",
            data: {
                cat_id: a.data.cat_id,
                store_id: a.data.id,
                page: a.data.list.page,
                limit: a.data.list.length,
                orderfield: a.data.field,
                ordertype: a.data.orderBy
            },
            success: function(t) {
                a.dealList(t.data, a.data.list.page), a.setData({
                    show: !0
                });
            }
        }));
    },
    onShow: function() {},
    onReachBottom: function() {
        this.getGoods();
    },
    onShareAppMessage: function() {},
    spTap: function(t) {
        var a = t.currentTarget.dataset.index, e = t.currentTarget.dataset.field, s = this;
        s.data.spindex == a ? s.setData({
            orderBy: "asc" == s.data.orderBy ? "desc" : "asc"
        }) : s.setData({
            spindex: a,
            field: e,
            orderBy: "asc"
        }), s.setData({
            list: {
                page: 1,
                length: 10,
                over: !1,
                load: !1,
                none: !1,
                data: []
            }
        }), s.getGoods();
    },
    toStoreindex: function() {
        app.reTo("/sqtg_sun/pages/zkx/pages/merchants/merchantindex/merchantindex?id=" + this.data.id);
    },
    toAllgoods: function() {
        app.reTo("/sqtg_sun/pages/zkx/pages/merchants/allgoods/allgoods?id=" + this.data.id);
    },
    toStoredetail: function() {
        app.reTo("/sqtg_sun/pages/zkx/pages/merchants/merchantdetail/merchantdetail?id=" + this.data.id);
    },
    getClassify: function() {
        app.reTo("/sqtg_sun/pages/zkx/pages/merchants/classify/classify?id=" + this.data.id);
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
    }
});