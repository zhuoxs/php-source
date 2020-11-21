var e = getApp(), a = e.requirejs("core");

Page({
    data: {
        loaded: !1,
        list: [],
        can: !0
    },
    onLoad: function(a) {
        e.url(a);
    },
    onShow: function() {
        if (this.data.can) {
            this.getList();
            var a = this;
            e.getCache("isIpx") ? a.setData({
                isIpx: !0,
                iphonexnavbar: "fui-iphonex-navbar",
                paddingb: "padding-b"
            }) : a.setData({
                isIpx: !1,
                iphonexnavbar: "",
                paddingb: ""
            });
        }
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    getList: function() {
        var e = this;
        console.log(33), a.get("member/address/get_list", {}, function(a) {
            e.setData({
                loaded: !0,
                list: a.list,
                show: !0
            });
        });
    },
    chooseAddress: function() {
        this.data.can = !1, wx.chooseAddress({
            success: function(e) {
                var a = {
                    realname: e.userName,
                    mobile: e.telNumber,
                    address: e.detailInfo,
                    province: e.provinceName,
                    city: e.cityName,
                    area: e.countyName,
                    is_from_wx: 1
                };
                setTimeout(function() {
                    wx.redirectTo({
                        url: "/pages/member/address/post?type=quickaddress&params=" + JSON.stringify(a)
                    });
                }, 0);
            }
        });
    },
    select: function(t) {
        var s = a.pdata(t).index;
        e.setCache("orderAddress", this.data.list[s], 30), wx.navigateBack();
    }
});