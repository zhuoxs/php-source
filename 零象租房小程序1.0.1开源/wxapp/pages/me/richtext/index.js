var t = getApp();

Page({
    data: {
        detail: "",
        content: ""
    },
    onLoad: function(a) {
        var e = this;
        1 == a.type && wx.setNavigationBarTitle({
            title: "关于我们"
        }), 2 == a.type && wx.setNavigationBarTitle({
            title: "操作指南"
        }), t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reathouse",
                r: "user.webView",
                type: a.type,
                id: a.id
            },
            success: function(t) {
                var i = t.data.data.content;
                e.setData({
                    detail: t.data.data,
                    content: i.replace(/\<img/g, '<img style="width:100%;height:auto;disply:block"')
                }), 2 != a.type && wx.setNavigationBarTitle({
                    title: t.data.data.title
                });
            }
        });
    }
});