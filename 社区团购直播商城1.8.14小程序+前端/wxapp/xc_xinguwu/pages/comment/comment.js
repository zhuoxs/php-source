function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var app = getApp();

function changeArray(t) {
    for (var e = 0, a = t.length; e < a; e++) t[e].goodcom = 0, t[e].anonymity = !1, 
    t[e].imgs = [], t[e].text = "";
    return t;
}

Page({
    data: {
        start: [ "非常差", "差", "一般", "好", "非常好" ],
        service_attitude: 0,
        logistics_speed: 0
    },
    goodCom: function(t) {
        console.log(t), console.log(this.data.list);
        var e = t.currentTarget.dataset.index;
        console.log(e), this.setData(_defineProperty({}, "list[" + e + "].goodcom", t.currentTarget.dataset.current));
    },
    serviceAttitude: function(t) {
        this.setData({
            service_attitude: t.currentTarget.dataset.current
        });
    },
    logisticsSpeed: function(t) {
        this.setData({
            logistics_speed: t.currentTarget.dataset.current
        });
    },
    addImage: function(t) {
        var i = t.currentTarget.dataset.index, s = this;
        wx.chooseImage({
            count: 9 - s.data.list[i].imgs.length,
            sizeType: [ "compressed" ],
            success: function(t) {
                var e = t.tempFiles, a = s.data.list[i].imgs;
                e.forEach(function(t, e) {
                    204800 < t.size ? app.look.alert("图片尺寸过大") : a.push(t.path);
                }), s.setData(_defineProperty({}, "list[" + i + "].imgs", a));
            }
        });
    },
    delImg: function(t) {
        var e = t.currentTarget.dataset.imgIndex, a = t.currentTarget.dataset.index, i = this.data.list[a].imgs;
        i.splice(e, 1), this.setData(_defineProperty({}, "list[" + a + "].imgs", i));
    },
    myform: function(t) {
        for (var e = this.data.list, a = 0, i = e.length; a < i; a++) if (0 == e[a].goodcom) return void app.look.alert("商品评分?");
        if (0 != this.data.service_attitude) if (0 != this.data.logistics_speed) {
            var s = this;
            for (a = 0, i = e.length; a < i; a++) 0 < e[a].imgs.length && (wx.showLoading({
                title: "上传图片中"
            }), e[a].imgs = app.look.updata(e[a].imgs), wx.hideLoading()), delete e[a].img, 
            e[a].anonymity ? e[a].anonymity = 1 : e[a].anonymity = -1;
            app.util.request({
                url: "entry/wxapp/my",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "sendComment",
                    list: JSON.stringify(e),
                    service_attitude: s.data.service_attitude,
                    logistics_speed: s.data.logistics_speed,
                    order_id: s.options.id
                },
                success: function(t) {
                    app.look.ok(t.data.message, function() {
                        app.look.back(1);
                    });
                }
            });
        } else app.look.alert("物流发货速度?"); else app.look.alert("商家服务态度?");
    },
    previewImage: function(t) {
        var e = t.currentTarget.dataset.index, a = t.currentTarget.dataset.img_idnex;
        wx.previewImage({
            urls: this.data.list[e].imgs,
            current: this.data.list[e].imgs[a]
        });
    },
    inputValue: function(t) {
        var e = t.currentTarget.dataset.index;
        this.setData(_defineProperty({}, "list[" + e + "].text", t.detail.value));
    },
    onLoad: function(t) {
        this.options = t;
        var a = this;
        app.util.request({
            url: "entry/wxapp/my",
            showLoading: !1,
            data: {
                op: "comment",
                order_id: t.id
            },
            success: function(t) {
                var e = t.data;
                e.data.list && a.setData({
                    list: changeArray(e.data.list)
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});