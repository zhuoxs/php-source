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
            order_id: t.id
        }), this.loadData();
    },
    loadData: function() {
        var a = this;
        app.api.getCpinOrderDetails({
            oid: this.data.order_id
        }).then(function(t) {
            a.setData({
                imgRoot: t.other.img_root,
                info: t.data,
                show: !0
            });
        }).catch(function(t) {
            t.code, app.tips(t.msg);
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
                goods_id: e.data.info.info.goods_id,
                user_id: t.id,
                stars: e.data.star,
                content: e.data.txt,
                imgs: e.data.images
            };
            if (a.content.length < 10) return void app.tips("亲，服务评价至少10个字哦！");
            if (e.data.sending) return;
            e.setData({
                sending: !0
            }), app.api.getCpinAddComment(a).then(function(t) {
                e.setData({
                    sending: !1
                }), wx.showModal({
                    title: "提示",
                    content: "评论成功！",
                    showCancel: !1,
                    success: function(t) {
                        app.reTo("/sqtg_sun/pages/plugin/spell/myorder/myorder");
                    }
                });
            }).catch(function(t) {
                e.setData({
                    sending: !1
                }), t.code, app.tips(t.msg);
            });
        } else wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/plugin/spell/comment/comment?id=" + e.data.order_detail_id + "&ids=" + e.data.order_id);
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    }
});