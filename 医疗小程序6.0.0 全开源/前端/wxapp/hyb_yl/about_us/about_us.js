var app = getApp();

Page({
    data: {
        swiper: {
            indicatorDots: !0,
            autoplay: !0,
            interval: 3e3,
            duration: 500,
            imgUrls: []
        },
        title: "山西省人民医院",
        subtitle: "副标题",
        detail: "但是快捷方式的空间发凯撒的龙卷风看拉萨的肌肤卡仕达酱翻开历史顶级了"
    },
    onLoad: function(i) {
        var a = i.id;
        this.getPianxinxixq(a);
    },
    getPianxinxixq: function(i) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Pianxinxixq",
            data: {
                id: i
            },
            success: function(i) {
                a.setData({
                    pianxinxi: i.data.data
                });
            }
        });
    },
    onShareAppMessage: function() {}
});