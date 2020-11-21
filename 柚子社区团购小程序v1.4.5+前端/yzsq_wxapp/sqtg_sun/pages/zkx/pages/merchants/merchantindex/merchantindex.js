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
        show: !1
    },
    onLoad: function(t) {
        this.setData({
            id: t.id
        }), this.loadDate(), this.getGoods(), this.getControl();
    },
    getControl: function() {
        var a = this;
        app.ajax({
            url: "Index|getpluginkey",
            success: function(t) {
                console.log(t), a.setData({
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
            url: "Cgoods|getStoreHotGoodses",
            data: {
                store_id: a.data.id,
                page: a.data.list.page,
                limit: a.data.list.length
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
    }
});