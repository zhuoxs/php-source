var a = getApp();

Page({
    data: {
        detail: "",
        list: ""
    },
    onLoad: function(t) {
        var e = this;
        a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "me.about"
            },
            success: function(a) {
                console.log(a), a.data.data && e.setData({
                    detail: a.data.data.detail,
                    list: a.data.data.list
                });
            }
        });
    },
    phoneCall: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.info.phone
        });
    },
    rich: function(a) {
        wx.navigateTo({
            url: "/pages/me/richtext/index?id=" + a.currentTarget.dataset.id
        });
    }
});