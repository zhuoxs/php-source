var app = getApp();

Page({
    data: {
        show: !1
    },
    onLoad: function(e) {
        this.setData({
            state: e.state,
            goods_id: e.id,
            order_id: e.order_id,
            delivery_type: e.delivery_type,
            leader_id: e.leaderid,
            header_id: e.head_id
        }), this.loadData();
    },
    loadData: function() {
        var a = this, e = wx.getStorageSync("userInfo");
        app.ajax({
            url: "Cpin|getGouporder",
            data: {
                leader_id: a.data.leader_id,
                user_id: e.id,
                header_id: this.data.header_id,
                order_id: a.data.order_id
            },
            success: function(e) {
                console.log(e), a.setData({
                    show: !0,
                    imgroot: e.other.img_root,
                    olist: e.data
                });
            }
        });
    },
    onPhoneTab: function(e) {
        var a = e.currentTarget.dataset.index;
        wx.makePhoneCall({
            phoneNumber: this.data.olist[a].user.tel
        });
    },
    confirmUserGoods: function(t) {
        var d = this;
        console.log(t);
        var e = t.currentTarget.dataset.num;
        wx.showModal({
            title: "请确认团员已经提货？",
            content: d.data.olist.goods_name + " x " + e,
            success: function(e) {
                if (e.confirm) {
                    var a = t.currentTarget.dataset.ordergoodsids;
                    app.ajax({
                        url: "Cleader|confirmUserGoodses",
                        data: {
                            ids: a,
                            leader_id: d.data.leader_id
                        },
                        success: function(e) {
                            d.setData({
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