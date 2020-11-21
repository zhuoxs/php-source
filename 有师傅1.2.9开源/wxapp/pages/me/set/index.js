var e = getApp();

Page({
    data: {},
    onLoad: function(e) {},
    formSubmit: function(t) {
        e.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "me.suggest",
                name: t.detail.value.name,
                phone: t.detail.value.phone
            },
            method: "get",
            success: function(e) {
                wx.showModal({
                    title: "",
                    content: "保存成功",
                    success: function(e) {
                        console.log(e), e.confirm && wx.navigateBack({
                            delta: 1
                        });
                    }
                });
            }
        });
    }
});