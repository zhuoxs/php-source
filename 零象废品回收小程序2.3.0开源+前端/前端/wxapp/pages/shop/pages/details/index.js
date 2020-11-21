var a = getApp();

Page({
    data: {
        id: 0,
        info: [],
        imgs: [],
        details: ""
    },
    onLoad: function(a) {
        var i = this, t = decodeURIComponent(a.scene);
        console.log(t), t > 0 ? i.setData({
            id: t
        }) : a.id > 0 && i.setData({
            id: a.id
        }), i.detailinfo();
    },
    detailinfo: function() {
        var i = this, t = {
            uid: wx.getStorageSync("uid"),
            id: i.data.id,
            m: "ox_reclaim",
            r: "shop.details"
        };
        a.util.request({
            url: "entry/wxapp/Api",
            data: t,
            method: "POST",
            success: function(t) {
                if (!t.data.data.info) return a.util.message({
                    title: "商品信息不存在或已下架",
                    type: "error"
                }), void setTimeout(function() {
                    wx.navigateTo({
                        url: "/pages/shop/pages/home/index"
                    });
                }, 2e3);
                var e = t.data.data.info.details;
                i.setData({
                    info: t.data.data.info,
                    imgs: t.data.data.img,
                    details: e.replace(/\<img/g, '<img style="width:100%;height:auto;disply:block"')
                });
            }
        });
    },
    gohome: function() {
        wx.switchTab({
            url: "/pages/index/index"
        });
    },
    gome: function() {
        wx.switchTab({
            url: "/pages/me/index"
        });
    },
    gopay: function() {
        wx.navigateTo({
            url: "/pages/shop/pages/pay/index?id=" + this.data.id
        });
    }
});