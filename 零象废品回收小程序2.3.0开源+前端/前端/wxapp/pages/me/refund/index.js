var e = getApp();

Page({
    data: {},
    onLoad: function(e) {},
    formSubmit: function(t) {
        console.log(t), "" != t.detail.value.suggest && "undefined" != t.detail.suggest ? e.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "me.suggest",
                suggest: t.detail.value.suggest
            },
            method: "get",
            success: function(e) {
                wx.showModal({
                    title: "反馈成功",
                    content: "感谢您的反馈",
                    success: function(e) {
                        console.log(e), e.confirm && wx.navigateBack({
                            delta: 1
                        });
                    }
                });
            }
        }) : e.util.message({
            title: "您还没有填写建议奥",
            type: "error"
        });
    }
});