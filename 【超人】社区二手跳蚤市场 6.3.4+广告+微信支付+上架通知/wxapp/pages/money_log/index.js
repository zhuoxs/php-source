var app = getApp();

Page({
    data: {
        list: []
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("loading_img");
        e ? a.setData({
            loadingImg: e
        }) : a.setData({
            loadingImg: "../../libs/images/loading.gif"
        }), t.type ? (a.setData({
            type: t.type
        }), a.getLogs(t.type)) : wx.showModal({
            title: "系统提示",
            content: "参数错误"
        });
    },
    getLogs: function(e) {
        var o = this;
        app.util.request({
            url: "entry/wxapp/finance",
            cachetime: "0",
            data: {
                m: "superman_hand2",
                act: e
            },
            success: function(t) {
                console.log(t);
                var a = "getcash_log" == e ? "提现记录" : "收支明细";
                wx.setNavigationBarTitle({
                    title: a
                }), t.data.errno ? wx.showModal({
                    title: "系统错误",
                    content: t.data.errmsg
                }) : o.setData({
                    list: t.data.data.log,
                    completed: !0
                });
            },
            fail: function(t) {
                o.setData({
                    completed: !0
                }), wx.showModal({
                    title: "系统错误",
                    content: t.data.errmsg
                });
            }
        });
    }
});