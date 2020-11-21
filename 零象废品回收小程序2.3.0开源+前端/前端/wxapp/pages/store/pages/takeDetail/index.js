var t = getApp();

Page({
    data: {
        id: 0,
        detail: "",
        user: [],
        showkuang: !1,
        money_input: 0
    },
    onLoad: function(t) {
        this.setData({
            id: t.id
        }), this.get_info();
    },
    get_info: function() {
        var e = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "store.takeDetail",
                uid: wx.getStorageSync("uid"),
                id: e.data.id
            },
            success: function(t) {
                e.setData({
                    detail: t.data.data.detail,
                    user: t.data.data.user
                });
            }
        });
    },
    refound: function(t) {
        wx.navigateTo({
            url: "/pages/order/refound/index?orderid=" + t.currentTarget.dataset.orderid
        });
    },
    call: function(t) {
        wx.makePhoneCall({
            phoneNumber: t.target.dataset.phone
        });
    },
    repairInfo: function(t) {
        wx.navigateTo({
            url: "/pages/store/pages/masterDetail/index?uid=" + t.target.dataset.uid
        });
    },
    bohui_show: function() {
        this.setData({
            showkuang: !this.data.showkuang
        });
    },
    money_input: function(t) {
        this.setData({
            money_input: t.detail.value
        });
    },
    bohui_botton: function() {
        var e = this;
        "" != e.data.money_input && "undefined" != e.data.money_input ? t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "store.take_bohui",
                uid: wx.getStorageSync("uid"),
                describe: e.data.money_input,
                id: e.data.detail.id
            },
            success: function(e) {
                t.util.message({
                    title: "驳回成功",
                    type: "success"
                }), setTimeout(function() {
                    wx.navigateTo({
                        url: "/pages/store/pages/take/index"
                    });
                }, 2e3);
            }
        }) : t.util.message({
            title: "请填写驳回原因",
            type: "error"
        });
    },
    tongguo_botton: function() {
        var e = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_reclaim",
                r: "store.take_tongguo",
                uid: wx.getStorageSync("uid"),
                id: e.data.detail.id
            },
            success: function(a) {
                t.util.message({
                    title: "操作成功",
                    type: "success"
                }), setTimeout(function() {
                    e.get_info();
                }, 2e3);
            }
        });
    }
});