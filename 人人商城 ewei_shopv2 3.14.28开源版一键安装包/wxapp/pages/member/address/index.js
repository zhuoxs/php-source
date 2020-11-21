var t = getApp(), e = t.requirejs("core");

Page({
    data: {
        loaded: !1,
        list: []
    },
    onLoad: function(e) {
        t.url(e);
    },
    onShow: function() {
        this.getList();
        var e = this;
        t.getCache("isIpx") ? e.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar",
            paddingb: "padding-b"
        }) : e.setData({
            isIpx: !1,
            iphonexnavbar: "",
            paddingb: ""
        });
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    getList: function() {
        var t = this;
        e.get("member/address/get_list", {}, function(e) {
            t.setData({
                loaded: !0,
                list: e.list,
                show: !0
            });
        });
    },
    setDefault: function(t) {
        var a = this, i = e.pdata(t).id;
        a.setData({
            loaded: !1
        }), e.get("member/address/set_default", {
            id: i
        }, function(t) {
            e.toast("设置成功"), a.getList();
        });
    },
    deleteItem: function(t) {
        var a = this, i = e.pdata(t).id;
        e.confirm("删除后无法恢复, 确认要删除吗 ?", function() {
            a.setData({
                loaded: !1
            }), e.get("member/address/delete", {
                id: i
            }, function(t) {
                e.toast("删除成功"), a.getList();
            });
        });
    }
});