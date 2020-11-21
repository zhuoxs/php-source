var t = getApp();

Page({
    data: {
        imgList: [],
        detail: {},
        appraiseList: "",
        TabCur: 1,
        scrollLeft: 0
    },
    onLoad: function(a) {
        var e = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "store.storeDetail2",
                master_uid: a.uid
            },
            success: function(t) {
                e.setData({
                    detail: t.data.data.detail,
                    imgList: t.data.data.imgs,
                    appraiseList: t.data.data.appraiseList
                });
            }
        });
    },
    call: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.target.dataset.phone
        });
    },
    tabSelect: function(t) {
        this.setData({
            TabCur: t.currentTarget.dataset.id,
            scrollLeft: 60 * (t.currentTarget.dataset.id - 1)
        });
    }
});