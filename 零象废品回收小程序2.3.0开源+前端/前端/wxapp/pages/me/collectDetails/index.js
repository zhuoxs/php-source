var e = getApp();

Page({
    data: {
        type: 1,
        tixian: 0
    },
    onLoad: function(t) {
        var a = this;
        a.setData({
            type: t.type,
            tixian: t.tixian
        }), e.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "me.collect",
                uid: wx.getStorageSync("uid")
            },
            success: function(e) {
                console.log(e), a.setData({
                    info: e.data.data
                });
            }
        });
    },
    formSubmit: function(t) {
        var a = this;
        if ("" != t.detail.value.code1 && "undefined" != t.detail.value.code1) if ("" != t.detail.value.username && "undefined" != t.detail.value.username) {
            var i = {
                formid: t.detail.formId,
                code: t.detail.value.code1,
                username: t.detail.value.username,
                uid: wx.getStorageSync("uid"),
                type: a.data.type,
                m: "ox_reclaim",
                r: "me.collect_sub"
            };
            e.util.request({
                url: "entry/wxapp/Api",
                data: i,
                method: "POST",
                success: function(t) {
                    "0" == t.data.errno ? (e.util.message({
                        title: "提交成功",
                        type: "success"
                    }), setTimeout(function() {
                        1 == a.data.tixian ? wx.navigateTo({
                            url: "/pages/me/take/index"
                        }) : wx.switchTab({
                            url: "/pages/me/index"
                        });
                    }, 2e3)) : e.util.message({
                        title: t.data.message,
                        type: "error"
                    });
                }
            });
        } else e.util.message({
            title: "请输入姓名",
            type: "error"
        }); else e.util.message({
            title: "请输入账号",
            type: "error"
        });
    }
});