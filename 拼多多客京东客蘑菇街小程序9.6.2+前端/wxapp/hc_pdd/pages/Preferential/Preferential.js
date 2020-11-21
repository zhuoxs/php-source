var app = getApp(), pageNum = 0;

Page({
    data: {},
    onLoad: function(a) {
        var t = this;
        t.Headcolor();
        var e = app.globalData.Headcolor, o = app.globalData.title;
        t.setData({
            backgroundColor: e,
            title: o
        }), t.shangpin(pageNum);
    },
    onReady: function() {},
    Headcolor: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            success: function(a) {
                var t = a.data.data.config.head_color;
                app.globalData.Headcolor = a.data.data.config.head_color, e.setData({
                    Headcolor: t
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    shangpin: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Themelist",
            method: "POST",
            data: {
                pageNum: a
            },
            success: function(a) {
                var t = a.data.data;
                e.setData({
                    goodsist: t
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    jaizai: function(a) {
        var o = this, n = o.data.goodsist;
        app.util.request({
            url: "entry/wxapp/Themelist",
            method: "POST",
            data: {
                pageNum: a
            },
            success: function(a) {
                for (var t = a.data.data, e = 0; e < t.length; e++) n.push(t[e]);
                o.setData({
                    goodsist: n
                });
            }
        });
    },
    onShow: function() {},
    copy: function(a) {
        var t = a.currentTarget.dataset.id, e = a.currentTarget.dataset.name;
        app.util.request({
            url: "entry/wxapp/Sharetheme",
            method: "POST",
            data: {
                theme_id: t,
                user_id: app.globalData.user_id,
                tname: e
            },
            success: function(a) {
                wx.showModal({
                    title: "提示",
                    content: "主题推广文案已复制到粘贴板,请自行推广",
                    success: function(a) {
                        a.confirm ? console.log("用户点击确定") : console.log("用户点击取消");
                    }
                });
                var t;
                t = a.data.data, wx.setClipboardData({
                    data: t,
                    success: function(a) {
                        wx.getClipboardData({
                            success: function(a) {
                                console.log(a.data);
                            }
                        });
                    }
                });
            }
        });
    },
    onHide: function() {
        pageNum = 0;
    },
    qcjah: function(a) {
        var t = a.currentTarget.dataset.id, e = (a.currentTarget.dataset.img, a.currentTarget.dataset.name, 
        a.currentTarget.dataset.page);
        wx.navigateTo({
            url: "../fuzhi/fuzhi?theme_id=" + t + "&pageNum=" + e
        });
    },
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        pageNum++, this.jaizai(pageNum);
    },
    onShareAppMessage: function(a) {
        a.from;
        var t = a.target.dataset.img, e = a.target.dataset.name;
        return this.setData({
            goods_src: t,
            goods_name: e
        }), {
            title: this.data.goods_name,
            path: "hc_pdd/pages/index/index",
            imageUrl: this.data.goods_src,
            success: function(a) {},
            fail: function(a) {}
        };
    }
});