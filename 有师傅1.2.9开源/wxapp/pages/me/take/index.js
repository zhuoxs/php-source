var t = getApp();

Page({
    data: {
        list: [],
        page: 1,
        is_last: !1,
        userinfo: [],
        timoney: ""
    },
    onLoad: function(a) {
        var e = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "me.takeList",
                uid: wx.getStorageSync("uid"),
                page: e.data.page
            },
            success: function(t) {
                e.setData({
                    list: t.data.data.list,
                    userinfo: t.data.data.userinfo
                });
            }
        });
    },
    onPullDownRefresh: function() {
        this.jiazai2();
    },
    onReachBottom: function() {
        var a = this;
        a.data.is_last || t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "me.takeList",
                uid: wx.getStorageSync("uid"),
                page: a.data.page + 1
            },
            success: function(t) {
                t.data.data.list.length < 1 && (a.setData({
                    is_last: !0
                }), wx.showToast({
                    title: "没有更多数据了",
                    icon: "success",
                    duration: 2e3
                }));
                for (var e = a.data.list, i = 0; i < t.data.data.list.length; i++) e.push(t.data.data[i]);
                a.setData({
                    list: e,
                    page: a.data.page + 1
                });
            }
        });
    },
    jiazai2: function() {
        var a = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "me.takeList",
                uid: wx.getStorageSync("uid"),
                page: 1
            },
            success: function(t) {
                a.setData({
                    list: t.data.data.list,
                    userinfo: t.data.data.userinfo,
                    page: 1,
                    is_last: !1
                });
            }
        });
    },
    tixian: function(a) {
        var e = this;
        "" != a.detail.value.takemoney && "undefined" != a.detail.value.takemoney ? e.data.userinfo.money - a.detail.value.takemoney < 0 ? t.util.message({
            title: "账户余额不足",
            type: "error"
        }) : a.detail.value.takemoney - e.data.userinfo.min_cash < 0 ? t.util.message({
            title: "最低提现额：" + e.data.userinfo.min_cash,
            type: "error"
        }) : t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "me.takeAdd",
                uid: wx.getStorageSync("uid"),
                formid: a.detail.formId,
                takemoney: a.detail.value.takemoney
            },
            success: function(a) {
                t.util.message({
                    title: "提交成功",
                    type: "success"
                }), e.jiazai2(), e.setData({
                    timoney: ""
                });
            }
        }) : t.util.message({
            title: "请填写提现金额",
            type: "error"
        });
    },
    quanti: function() {
        this.setData({
            timoney: this.data.userinfo.money
        });
    }
});