var e = getApp(), t = e.requirejs("core");

Page({
    data: {
        loaded: !1,
        list: []
    },
    onLoad: function(t) {
        e.url(t);
    },
    onShow: function() {
        this.getList();
        var t = this;
        e.getCache("isIpx") ? t.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar",
            paddingb: "padding-b"
        }) : t.setData({
            isIpx: !1,
            iphonexnavbar: "",
            paddingb: ""
        });
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    chooseAddress: function() {
        this.data.can = !1, wx.chooseAddress({
            success: function(e) {
                var t = {
                    realname: e.userName,
                    mobile: e.telNumber,
                    address: e.detailInfo,
                    province: e.provinceName,
                    city: e.cityName,
                    area: e.countyName,
                    is_from_wx: 1
                };
                setTimeout(function() {
                    wx.navigateTo({
                        url: "/pages/member/address/post?type=member&params=" + JSON.stringify(t)
                    });
                }, 0);
            }
        });
    },
    getList: function() {
        var e = this;
        t.get("member/address/get_list", {}, function(t) {
            e.setData({
                loaded: !0,
                list: t.list,
                show: !0
            });
        });
    },
    setDefault: function(e) {
        var a = this, s = t.pdata(e).id;
        a.setData({
            loaded: !1
        }), t.get("member/address/set_default", {
            id: s
        }, function(e) {
            t.toast("设置成功"), a.getList();
        });
    },
    deleteItem: function(e) {
        var a = this, s = t.pdata(e).id;
        t.confirm("删除后无法恢复, 确认要删除吗 ?", function() {
            a.setData({
                loaded: !1
            }), t.get("member/address/delete", {
                id: s
            }, function(e) {
                t.toast("删除成功"), a.getList();
            });
        });
    }
});