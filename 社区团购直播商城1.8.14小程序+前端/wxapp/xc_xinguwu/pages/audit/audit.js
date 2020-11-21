var app = getApp(), WxParse = require("../../../wxParse/wxParse.js");

Page({
    data: {
        list: null
    },
    onLoad: function(a) {
        var o = this;
        app.look.navbar(this), app.util.request({
            url: "entry/wxapp/index",
            showLoading: !0,
            method: "POST",
            data: {
                op: "audit"
            },
            success: function(a) {
                var t = a.data;
                console.log(t), t.data.audit && (console.log(t.data.audit.contents), WxParse.wxParse("article", "html", t.data.audit.contents, o, 10), 
                o.setData({
                    list: t.data.audit
                }));
            }
        });
    },
    onReady: function() {
        app.look.navbar(this);
        var a = {};
        a.audit_contact = app.module_url + "resource/wxapp/audit/audit-contact.png", a.audit_merchant = app.module_url + "resource/wxapp/audit/audit-merchant.png", 
        a.audit_position = app.module_url + "resource/wxapp/audit/audit-position.png", a.audit_tell = app.module_url + "resource/wxapp/audit/audit-tell.png", 
        a.audit_time = app.module_url + "resource/wxapp/audit/audit-time.png", this.setData({
            images: a
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});