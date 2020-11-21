var app = getApp();

Page({
    data: {
        orientationList: [ {
            id: "0",
            region: "东北"
        }, {
            id: "1",
            region: "华北"
        }, {
            id: "2",
            region: "华东"
        }, {
            id: "3",
            region: "华南"
        } ],
        staffList: [ {
            lastName: "张",
            firstName: "三",
            id: 0
        }, {
            lastName: "李",
            firstName: "四",
            id: 1
        } ],
        title: "tom",
        mob: 0,
        toView: "inToView3"
    },
    onShow: function() {
        this.setData({
            toView: "inToView3",
            mob: 3
        });
    },
    dainji: function(t) {
        console.log(t.currentTarget.dataset.id);
    },
    scrollToViewFn: function(t) {
        var i = t.target.dataset.id, e = t.target.dataset.id;
        this.setData({
            toView: "inToView" + i,
            mob: e
        }), console.log(this.data.toView), wx.navigateToMiniProgram({
            appId: "wxca3957e5474b3670",
            path: "/pages/unionCoupon/index?promsign=PVVXWmlSM2QxWUhheDhsTXVCVGJ3UVdNZjlWTg==&itemId=1lopjn0&_uni_asso=1&_uni_gid=0&_uni_uid=1d0m0n2&ptp=_qd._cps____1d0m0n2.0.1.0&flow_channel=_qd._cps____1d0m0n2.0.1.0",
            envVersion: "release",
            success: function(t) {}
        });
    },
    bindscroll: function(t) {
        var o = this;
        wx.createSelectorQuery().in(this).select("#inToView0").boundingClientRect(function(t) {
            t.top;
            var i = t.top, e = o.data.mob;
            i < 100 && (e = 0, o.setData({
                mob: e
            }));
        }).exec(), wx.createSelectorQuery().in(this).select("#inToView1").boundingClientRect(function(t) {
            t.top;
            var i = t.top, e = o.data.mob;
            i < 100 && (e = 1, o.setData({
                mob: e
            }));
        }).exec(), wx.createSelectorQuery().in(this).select("#inToView2").boundingClientRect(function(t) {
            t.top;
            var i = t.top, e = o.data.mob;
            i < 100 && (e = 2, o.setData({
                mob: e
            }));
        }).exec(), wx.createSelectorQuery().in(this).select("#inToView3").boundingClientRect(function(t) {
            t.top;
            var i = t.top, e = o.data.mob;
            i < 100 && (e = 3, o.setData({
                mob: e
            }));
        }).exec();
    },
    onLoad: function(t) {
        this.shangpin();
    },
    shangpin: function() {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Goodslist",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(t) {
                var i = t.data.data.list, e = t.data.data.toplist;
                o.setData({
                    goodsist: i,
                    toplist: e
                });
            },
            fail: function(t) {
                console.log("失败" + t);
            }
        });
    },
    showDialog: function(t) {
        this.dialog.hideDialog();
    },
    _cancelEvent: function() {
        console.log("你点击了取消"), this.dialog.hideDialog();
    },
    _confirmEvent: function() {
        console.log("你点击了确定"), this.dialog.hideDialog();
    }
});