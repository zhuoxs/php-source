var e = getApp(), t = e.requirejs("core");

e.requirejs("biz/order");

Page({
    data: {
        code: 1,
        tempFilePaths: "",
        delete: "",
        rtypeArr: [ "退款(仅退款不退货)", "退货退款", "换货" ],
        rtypeArrText: [ "退款", "退款", "换货" ],
        rtypeIndex: 0,
        reasonArr: [ "不想要了", "卖家缺货", "拍错了/订单信息错误", "其它" ],
        reasonIndex: 0,
        images: [],
        imgs: []
    },
    onLoad: function(t) {
        e.getCache("isIpx") ? this.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar"
        }) : this.setData({
            isIpx: !1,
            iphonexnavbar: ""
        }), this.setData({
            orderid: t.id
        }), this.get_list();
    },
    get_list: function() {
        var e = this;
        t.get("groups.refund", {
            orderid: this.data.orderid
        }, function(a) {
            0 == a.error ? (a.order.status < 2 && (a.rtypeArr = [ "退款(仅退款不退货)" ]), a.show = !0, 
            e.setData(a)) : t.toast(a.message, "loading");
        });
    },
    submit: function() {
        var e = {
            orderid: this.data.orderid,
            rtype: this.data.rtypeIndex,
            reason: this.data.reasonArr[this.data.reasonIndex],
            content: this.data.content,
            price: this.data.price,
            images: this.data.images
        };
        t.post("groups.refund.submit", e, function(e) {
            0 == e.error ? wx.navigateBack() : wx.showToast({
                title: e.error,
                icon: "none",
                duration: 2e3
            });
        }, !0);
    },
    change: function(e) {
        var a = {};
        a[t.data(e).name] = e.detail.value, this.setData(a);
    },
    upload: function(e) {
        var a = this, r = t.data(e), i = r.type, s = a.data.images, n = a.data.imgs, o = r.index;
        "image" == i ? t.upload(function(e) {
            s.push(e.filename), n.push(e.url), a.setData({
                images: s,
                imgs: n
            });
        }) : "image-remove" == i ? (s.splice(o, 1), n.splice(o, 1), a.setData({
            images: s,
            imgs: n
        })) : "image-preview" == i && wx.previewImage({
            current: n[o],
            urls: n
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
            "order.refundstate": 0
        });
    },
    refundcancel: function(e) {
        t.post("groups.refund.cancel", {
            orderid: this.data.orderid
        }, function(e) {
            0 == e.error ? wx.navigateBack() : wx.showToast({
                title: e.error,
                icon: "none",
                duration: 2e3
            });
        });
    },
    confirmRecive: function() {
        var e = {
            orderid: this.data.orderid,
            refundid: this.data.refund.id
        };
        t.post("groups.refund.receive", e, function(e) {
            0 == e.error ? wx.navigateBack() : wx.showToast({
                title: e.error,
                icon: "none",
                duration: 2e3
            });
        });
    }
});