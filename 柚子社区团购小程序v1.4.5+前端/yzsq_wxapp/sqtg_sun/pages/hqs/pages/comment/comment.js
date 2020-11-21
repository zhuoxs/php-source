var app = getApp();

Page({
    data: {
        images: [],
        star: 4,
        txt: "",
        sending: !1
    },
    onLoad: function(t) {
        this.setData({
            order_id: t.ids,
            order_detail_id: t.id
        }), this.loadData();
    },
    loadData: function() {
        var e = this;
        app.ajax({
            url: "Corder|getOrderDetail",
            data: {
                order_id: this.data.order_id
            },
            success: function(t) {
                for (var a in e.setData({
                    info: t.data
                }), t.data.detail) t.data.detail[a].id == e.data.order_detail_id && (t.data.detail[a].pic = t.other.img_root + t.data.detail[a].pic, 
                e.setData({
                    info: t.data.detail[a]
                }));
            }
        });
    },
    getImages: function(t) {
        this.setData({
            images: t.detail
        });
    },
    getStar: function(t) {
        this.setData({
            star: t.detail
        });
    },
    getTxt: function(t) {
        this.setData({
            txt: t.detail.value
        });
    },
    onSendTab: function() {
        var e = this, t = wx.getStorageSync("userInfo");
        if (t) {
            var a = {
                order_id: e.data.order_id,
                order_detail_id: e.data.order_detail_id,
                user_id: t.id,
                stars: e.data.star,
                content: e.data.txt,
                imgs: e.data.images
            };
            if (a.content.length < 10) return void app.tips("亲，服务评价至少10个字哦！");
            if (e.data.sending) return;
            e.setData({
                sending: !0
            }), app.ajax({
                url: "Ccomment|comment",
                data: a,
                success: function(t) {
                    e.setData({
                        sending: !1
                    }), wx.showModal({
                        title: "提示",
                        content: "评论成功！",
                        showCancel: !1,
                        success: function(t) {
                            app.reTo("/sqtg_sun/pages/public/pages/myorder/myorder?ostatus=3&id=6");
                        }
                    });
                },
                fail: function(t) {
                    e.setData({
                        sending: !1
                    });
                }
            });
        } else wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/hqs/pages/comment/comment?id=" + e.data.order_detail_id + "&ids=" + e.data.order_id);
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    }
});