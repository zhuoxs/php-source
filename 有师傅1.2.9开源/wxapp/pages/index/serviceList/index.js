var a = getApp();

Page({
    data: {
        list: [],
        detail: []
    },
    onLoad: function(t) {
        var e = this;
        a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "home.typeList",
                type: t.type
            },
            success: function(a) {
                a.data.data && (wx.setNavigationBarTitle({
                    title: a.data.data.detail.name
                }), e.setData({
                    list: a.data.data.list,
                    detail: a.data.data.detail
                }));
            }
        });
    },
    onShareAppMessage: function() {},
    gofenlei: function(t) {
        a.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "me.add_formid",
                uid: wx.getStorageSync("uid"),
                formid: t.detail.formId
            }
        }), wx.navigateTo({
            url: "/pages/need/pages/home/index?type_value=" + t.target.dataset.name
        });
    }
});