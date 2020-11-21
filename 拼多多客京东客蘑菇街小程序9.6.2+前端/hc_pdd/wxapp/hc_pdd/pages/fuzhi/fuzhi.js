var app = getApp();

Page({
    data: {
        thiseven: 0,
        gun: !0,
        text: [ "综合", "佣金比例", "销量", "价格" ],
        zoor: 0,
        searchinput: "",
        fen: !0,
        rankno: 0
    },
    bindchange: function(a) {
        this.setData({
            tuhight: a.detail.current
        });
    },
    fanhui: function() {
        console.log(111), wx.switchTab({
            url: "../index/index"
        });
    },
    onLoad: function(a) {
        a.cateid;
        var t = a.theme_id, e = a.name, i = a.img, s = this;
        s.setData({
            qieone: 0,
            qietwo: 0,
            qiethree: 0,
            theme_id: t,
            img: i,
            name: e
        }), s.Headcolor(), s.shangpin(), s.Theme();
    },
    Theme: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Themedetail",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                theme_id: e.data.theme_id,
                img: e.data.img,
                tname: e.data.name
            },
            success: function(a) {
                var t = a.data.data;
                e.setData({
                    yesno: t
                });
            },
            fail: function(a) {}
        });
    },
    shangpin: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Themedetail",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                theme_id: e.data.theme_id,
                img: e.data.img,
                tname: e.data.name
            },
            success: function(a) {
                var t = a.data.data.list;
                e.setData({
                    goodsist: t
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    details: function(a) {
        var t = a.currentTarget.dataset.id, e = a.currentTarget.dataset.hui;
        wx.navigateTo({
            url: "../details/details?goods_id=" + t + "&hui=" + e + "&parameter=0"
        });
    },
    swiperChange: function(a) {
        this.setData({
            swiperCurrent: a.detail.current
        });
    },
    Headcolor: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            success: function(a) {
                var t = a.data.data.search_color, e = a.data.data.config.share_icon;
                i.setData({
                    search_color: t,
                    share_icon: e
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    onShareAppMessage: function(a) {
        a.from;
        var t = this, e = a.target.dataset.src, i = a.target.dataset.id, s = a.target.dataset.name;
        return t.setData({
            goods_src: e,
            goods_id: i,
            goods_name: s
        }), {
            title: t.data.goods_name,
            path: "hc_pdd/pages/details/details?goods_id=" + t.data.goods.goods_id + "&user_id=" + app.globalData.user_id,
            imageUrl: t.data.goods_src,
            success: function(a) {},
            fail: function(a) {}
        };
    }
});