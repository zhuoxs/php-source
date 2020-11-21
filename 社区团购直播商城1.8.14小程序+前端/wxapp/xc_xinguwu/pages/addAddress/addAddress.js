var app = getApp();

Page({
    data: {
        catalogSelect: -1,
        address: "点击定位",
        region: [ "请选择所在地区", "", "" ],
        name: "",
        phone: "",
        detail: "",
        id: "",
        checked: !1
    },
    onLoad: function(e) {
        e.id && (this.setData({
            id: e.id,
            name: e.name,
            phone: e.phone,
            region: e.region.split(" "),
            detail: e.detail
        }), wx.setNavigationBarTitle({
            title: "修改地址"
        }));
    },
    chooseCatalog: function(e) {
        var o = this;
        o.setData({
            catalogSelect: -o.data.catalogSelect,
            checked: !o.data.checked
        });
    },
    map: function() {
        var o = this;
        wx.chooseLocation({
            success: function(e) {
                console.log(e), o.setData({
                    address: e.address,
                    map: e
                });
            }
        });
    },
    bindRegionChange: function(e) {
        console.log(e), this.setData({
            region: e.detail.value
        });
    },
    usewxaddress: function() {
        var o = this;
        wx.chooseAddress({
            success: function(e) {
                o.setData({
                    name: e.userName,
                    phone: e.telNumber,
                    detail: e.detailInfo,
                    region: [ e.provinceName, e.cityName, e.countyName ]
                });
            }
        });
    },
    myform: function(e) {
        console.log(e.detail.value);
        var o = e.detail.value;
        "" != o.name ? /^1\d{10}$/.test(o.phone) ? "" != o.detail ? o.region.length < 3 ? wx.showToast({
            title: "请填写所在地区",
            icon: "none"
        }) : (wx.showLoading({
            title: "数据提交中"
        }), app.util.request({
            url: "entry/wxapp/my",
            showLoading: !1,
            data: {
                op: "add_address",
                name: o.name,
                phone: o.phone,
                region: o.region.join(" "),
                detail: o.detail,
                ison: o.ison,
                id: this.data.id
            },
            success: function(e) {
                wx.hideLoading(), app.look.ok(e.data.message), app.look.back(1);
            }
        })) : wx.showToast({
            title: "请填写详细地址信息",
            icon: "none"
        }) : wx.showToast({
            title: "请填写正确联系方式",
            icon: "none"
        }) : wx.showToast({
            title: "请填写收货人信息",
            icon: "none"
        });
    },
    onReady: function() {
        app.look.navbar(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});