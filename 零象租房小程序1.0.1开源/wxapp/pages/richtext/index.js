var t = getApp();

Page({
    data: {
        detail: "",
        content: ""
    },
    onLoad: function(a) {
        var e = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reathouse",
                r: "home.webView",
                id: a.id
            },
            success: function(t) {
                var a = t.data.data.content;
                wx.setNavigationBarTitle({
                    title: t.data.data.name
                }), e.setData({
                    content: a.replace(/\<img/g, '<img style="width:100%;height:auto;disply:block"')
                });
            }
        });
    }
});