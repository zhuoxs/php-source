var app = getApp();

Page({
    data: {},
    myfrom: function(o) {
        var n = o.detail.value;
        if ("" != n.name) if ("" != n.phone) {
            app.util.request({
                url: "entry/wxapp/supplier",
                showLoading: !0,
                method: "POST",
                data: {
                    op: "staffApply",
                    name: n.name,
                    phone: n.phone,
                    supplier_id: this.options.supplier_id
                },
                success: function(o) {
                    app.look.ok("您的申请已提交", function() {
                        wx.redirectTo({
                            url: "/xc_xinguw/pages/index/index"
                        });
                    });
                },
                fail: function(o) {
                    o.data && o.data.message && app.look.alert(o.data.message);
                }
            });
        } else app.look.alert("请输入你的手机号码"); else app.look.alert("请输入你的姓名");
    },
    onLoad: function(o) {
        this.options = o;
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});