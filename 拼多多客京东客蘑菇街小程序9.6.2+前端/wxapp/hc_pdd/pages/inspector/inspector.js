var app = getApp();

Page({
    data: {
        lign: 0,
        jiae: [ "申请代理", "升级总监" ],
        yellow: 0,
        role: app.globalData.role,
        yun: 0,
        zongjian: 0,
        is_shoufei: 0,
        res: 1
    },
    onLoad: function(a) {
        var t = a.ov, e = this;
        e.setData({
            ov: t,
            backgroundColor: app.globalData.Headcolor,
            role: app.globalData.role,
            nufiome: app.globalData.role
        }), e.agent(0), e.Diyname();
    },
    asvad: function() {
        wx.reLaunch({
            url: "../index/index"
        });
    },
    qie: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            lign: t
        });
    },
    Diyname: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/Diyname",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                t.setData({
                    nufiome: a.data.data.config,
                    role: a.data.data.role
                });
            }
        });
    },
    hunge: function(a) {
        var t = a.currentTarget.dataset.index;
        this.setData({
            yellow: t,
            zongjian: t
        }), this.agent(t);
    },
    onReady: function(a) {},
    agent: function(a) {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Agent",
            method: "POST",
            data: {
                user_id: app.globalData.user_id,
                yellow: a
            },
            success: function(a) {
                var t = a.data.data.info, e = a.data.data.data, n = t.is_shoufei;
                a = a.data.data.res;
                o.setData({
                    agree: t,
                    pand: e,
                    is_shoufei: n,
                    res: a
                });
            }
        });
    },
    payzhi: function() {
        var t = this, a = t.data.yellow;
        app.util.request({
            url: "entry/wxapp/pay",
            method: "POST",
            dataType: "json",
            data: {
                user_id: app.globalData.user_id,
                fid: a
            },
            success: function(a) {
                console.log(a);
                a.data;
                wx.requestPayment({
                    timeStamp: a.data.data.timeStamp + "",
                    nonceStr: a.data.data.nonceStr,
                    package: a.data.data.package,
                    signType: "MD5",
                    paySign: a.data.data.sign + "",
                    success: function(a) {
                        t.data.state;
                        console.log("成功"), t.agent(t.data.yellow);
                    },
                    fail: function(a) {
                        console.log(a);
                    },
                    complete: function(a) {}
                });
            }
        });
    },
    onShow: function() {},
    pay: function() {
        var e = this, a = e.data.agree.is_shoufei;
        0 != a && 2 != a || app.util.request({
            url: "entry/wxapp/Agentzhuce",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                wx.showModal({
                    title: "提示",
                    content: "恭喜您升级成功",
                    success: function(a) {
                        a.confirm ? console.log("用户点击确定") : console.log("用户点击取消");
                    }
                });
                var t = a.data.data;
                e.setData({
                    pand: t
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});