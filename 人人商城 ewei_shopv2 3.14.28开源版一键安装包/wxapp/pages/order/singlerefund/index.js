var e = getApp(), t = e.requirejs("core");

e.requirejs("biz/order");

Page({
    data: {
        code: 1,
        tempFilePaths: "",
        delete: "",
        rtypeArr: [ "退款(仅退款不退货)", "退货退款", "换货" ],
        rtypeArrText: [ "退款", "退款", "换货" ],
        rtypeIndex: 1,
        reasonArr: [ "不想要了", "卖家缺货", "拍错了/订单信息错误", "其它" ],
        reasonIndex: 0,
        images: []
    },
    onLoad: function(t) {
        this.setData({
            options: t
        }), e.url(t), this.get_list();
    },
    get_list: function() {
        var e = this;
        t.get("order/single_refund", e.data.options, function(a) {
            e.setData({
                show: !0
            }), 0 == a.error ? (a.order.status < 2 && a.order.sendtime <= 0 && (a.rtypeArr = [ "退款(仅退款不退货)" ]), 
            e.setData(a)) : (t.toast(a.message, "none"), setTimeout(function() {
                wx.navigateBack();
            }, 1500));
        });
    },
    submit: function() {
        var e = {
            id: this.data.options.id,
            rtype: this.data.rtypeIndex,
            reason: this.data.reasonArr[this.data.reasonIndex],
            content: this.data.content,
            price: this.data.price,
            images: this.data.images
        };
        t.post("order/single_refund/submit", e, function(e) {
            0 == e.error ? wx.navigateBack() : t.toast(e.message, "none");
        }, !0);
    },
    change: function(e) {
        var a = {};
        a[t.data(e).name] = e.detail.value, this.setData(a);
    },
    upload: function(e) {
        var a = this, i = t.data(e), n = i.type, r = a.data.images, s = a.data.imgs, o = i.index;
        "image" == n ? t.upload(function(e) {
            r.push(e.filename), s.push(e.url), a.setData({
                images: r,
                imgs: s
            });
        }) : "image-remove" == n ? (r.splice(o, 1), s.splice(o, 1), a.setData({
            images: r,
            imgs: s
        })) : "image-preview" == n && wx.previewImage({
            current: s[o],
            urls: s
        });
    },
    toggle: function(e) {
        var a = t.pdata(e).id;
        a = 0 == a || void 0 === a ? 1 : 0, this.setData({
            code: a
        });
    },
    edit: function(e) {
        this.setData({
            "order.single_refundstate": 0
        });
    },
    refundcancel: function(e) {
        var a = this;
        t.confirm("您确定要取消申请?", function() {
            t.post("order/single_refund/cancel", {
                id: a.data.options.id
            }, function(e) {
                0 == e.error && wx.navigateBack(), t.toast(e.message, "none");
            }, !0);
        });
    },
    back: function() {
        wx.navigateBack();
    },
    fefundreceive: function(e) {
        var a = this;
        t.confirm("确认您已经收到换货物品?", function() {
            t.post("order/single_refund/receive", {
                id: a.data.options.id,
                single_refundid: a.data.refund.id
            }, function(e) {
                0 == e.error && wx.navigateBack(), t.toast(e.message, "none");
            }, !0);
        });
    }
});