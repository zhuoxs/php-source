var t = getApp(), e = t.requirejs("core");

Page({
    data: {
        stars_class: [ "text-default", "text-primary", "text-success", "text-warning", "text-danger" ],
        stars_text: [ "差评", "一般", "挺好", "满意", "非常满意" ],
        normalSrc: "icox icox-star",
        selectedSrc: "icox icox-xing selected",
        key: -1,
        content: "",
        images: [],
        imgs: [],
        log: [],
        is_openmerch: 0,
        shop: []
    },
    onLoad: function(e) {
        this.setData({
            options: e
        }), t.url(e), this.get_list();
    },
    get_list: function() {
        var t = this;
        e.get("creditshop/comment", t.data.options, function(a) {
            0 == a.error ? (a.show = !0, t.setData(a), t.setData({
                log: a.log,
                is_openmerch: a.is_openmerch,
                shop: a.shop
            })) : (e.toast(a.message, "loading"), wx.navigateBack());
        }, !0);
    },
    select: function(t) {
        var e = t.currentTarget.dataset.key;
        this.setData({
            key: e
        });
    },
    change: function(t) {
        var a = {};
        a[e.data(t).name] = t.detail.value, this.setData(a);
    },
    submit: function() {
        var t = {
            logid: this.data.log.id,
            merchid: this.data.log.merchid,
            comments: []
        };
        if ("" == this.data.content || -1 == this.data.key) return e.alert("有未填写项目!"), !1;
        var a = {
            goodsid: this.data.log.goodsid,
            level: this.data.key + 1,
            content: this.data.content,
            images: this.data.images
        };
        t.comments.push(a), e.post("creditshop/comment/submit", t, function(t) {
            0 != t.error && e.toast(t.message, "loading"), wx.navigateBack();
        }, !0);
    },
    upload: function(t) {
        var a = this, s = e.data(t), i = s.type, o = a.data.images, n = a.data.imgs, r = s.index;
        "image" == i ? e.upload(function(t) {
            o.push(t.filename), n.push(t.url), a.setData({
                images: o,
                imgs: n
            });
        }) : "image-remove" == i ? (o.splice(r, 1), n.splice(r, 1), a.setData({
            images: o,
            imgs: n
        })) : "image-preview" == i && wx.previewImage({
            current: n[r],
            urls: n
        });
    }
});