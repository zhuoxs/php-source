var app = getApp();

Page({
    data: {
        region: [ "省市区" ],
        posAddress: "",
        longitude: "",
        latitude: ""
    },
    bindRegionChange: function(e) {
        this.setData({
            region: e.detail.value
        });
    },
    choAddress: function() {
        var t = this;
        wx.chooseLocation({
            success: function(e) {
                t.setData({
                    longitude: e.longitude,
                    latitude: e.latitude,
                    posAddress: e.address
                });
            },
            fail: function() {},
            complete: function() {}
        });
    },
    myform: function(e) {
        var t = e.detail.value, o = e.detail.formId;
        if ("" != t.title) if ("" != t.name) if (/^[1][3,4,5,7,8][0-9]{9}$/.test(t.phone)) if (t.region.length < 3) app.look.alert("地区必填"); else if ("" != t.detail) if ("" != this.data.longitude) {
            app.util.request({
                url: "entry/wxapp/community",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "clubApply",
                    title: t.title,
                    name: t.name,
                    phone: t.phone,
                    region: t.region.join(" "),
                    detail: t.detail,
                    longitude: this.data.longitude,
                    latitude: this.data.latitude,
                    remark: t.remark,
                    formid: o
                },
                success: function(e) {
                    app.look.ok(e.data.message, function() {
                        wx.redirectTo({
                            url: "/xc_xinguwu/community/sqMasterCenter/sqMasterCenter"
                        });
                    });
                },
                fail: function(e) {
                    app.look.no(e.data.message);
                }
            });
        } else app.look.alert("请在地图上选择你的地址"); else app.look.alert("地址必填"); else app.look.alert("手机格式不符"); else app.look.alert("姓名必填"); else app.look.alert("社团名称必填");
    },
    onLoad: function(e) {},
    getPhoneNumber: function(e) {
        var t = this;
        "getPhoneNumber:ok" == e.detail.errMsg && app.util.request({
            url: "entry/wxapp/supplier",
            showLoading: !0,
            method: "POST",
            data: {
                op: "getphone",
                iv: e.detail.iv,
                encryptedData: e.detail.encryptedData
            },
            success: function(e) {
                t.setData({
                    phone: e.data.data.phoneNumber
                });
            },
            fail: function(e) {
                wx.showModal({
                    title: "获取手机号码失败",
                    content: "获取手机号码失败",
                    showCancel: !1,
                    cancelText: "关闭"
                });
            }
        });
    },
    onReady: function() {
        var e = {};
        e.sqApply_bg = app.module_url + "resource/wxapp/community/sqApply-bg.png", this.setData({
            images: e
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});