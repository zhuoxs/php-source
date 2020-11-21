var app = getApp(), Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        page: 1,
        state: 1
    },
    onLoad: function(a) {
        var t = wx.getStorageSync("users").id, e = a.gid;
        this.setData({
            gid: e,
            uid: t
        });
    },
    onShow: function() {
        var t = this, a = t.data.gid, e = t.data.uid, i = t.data.page;
        app.util.request({
            url: "entry/wxapp/ProNum",
            data: {
                gid: a,
                uid: e,
                page: i
            },
            success: function(a) {
                console.log(a), t.setData({
                    product: a.data,
                    img: a.data.img
                });
            }
        });
    },
    ProNum: function() {
        var t = this, a = t.data.gid, e = t.data.uid, i = t.data.page + 1, o = (t.data.product, 
        t.data.img);
        console.log(o), t.setData({
            state: 2
        }), wx.showToast({
            title: "加载中~~~~~",
            icon: "loading",
            duration: 2e3
        }), setTimeout(function() {
            app.util.request({
                url: "entry/wxapp/ProNum",
                data: {
                    gid: a,
                    uid: e,
                    page: i
                },
                success: function(a) {
                    console.log(o), console.log(t.data.img), console.log(a.data.img), o = t.data.img.concat(a.data.img), 
                    t.setData({
                        img: o,
                        page: i,
                        state: 1
                    });
                }
            });
        }, 1e3);
    }
});