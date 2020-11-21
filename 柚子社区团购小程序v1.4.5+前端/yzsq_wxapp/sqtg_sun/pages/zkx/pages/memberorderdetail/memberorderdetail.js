var app = getApp();

Page({
    data: {
        show: !1
    },
    onLoad: function(a) {
        this.setData({
            state: a.state,
            goods_id: a.id,
            batch_no: a.batch_no,
            delivery_type: a.delivery_type,
            leader_id: a.leaderid
        }), this.loadData();
    },
    loadData: function() {
        var t = this;
        app.ajax({
            url: "Cleader|getOrder",
            data: {
                leader_id: t.data.leader_id,
                state: t.data.state,
                goods_id: t.data.goods_id,
                batch_no: t.data.batch_no,
                delivery_type: t.data.delivery_type
            },
            success: function(a) {
                t.setData({
                    show: !0,
                    olist: a.data,
                    imgroot: a.other.img_root
                });
            }
        });
    },
    onPhoneTab: function(a) {
        var t = a.currentTarget.dataset.index;
        wx.makePhoneCall({
            phoneNumber: this.data.olist.users[t].user.tel
        });
    },
    confirmUserGoods: function(e) {
        var o = this;
        console.log(e);
        var a = e.currentTarget.dataset.num;
        wx.showModal({
            title: "请确认团员已经提货？",
            content: o.data.olist.goods_name + " x " + a,
            success: function(a) {
                if (a.confirm) {
                    var t = e.currentTarget.dataset.ordergoodsids;
                    app.ajax({
                        url: "Cleader|confirmUserGoodses",
                        data: {
                            ids: t,
                            leader_id: o.data.leader_id
                        },
                        success: function(a) {
                            o.setData({
                                protect: !0
                            }), setTimeout(function() {
                                app.tips("确认提货成功");
                            }, 1e3), wx.navigateBack({
                                delta: 1
                            });
                        }
                    });
                }
            }
        });
    }
});