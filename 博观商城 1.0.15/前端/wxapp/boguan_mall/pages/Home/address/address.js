var t = require("../../../utils/base.js"), a = require("../../../../api.js"), e = new t.Base(), s = getApp();

Page({
    data: {
        page: "",
        addressId: "-1"
    },
    onLoad: function(t) {
        s.pageOnLoad(), t.page && (this.data.page = t.page);
    },
    onShow: function() {
        this.getAddressList();
    },
    toBack: function(t) {
        this.data.addressId = t.currentTarget.dataset.id, this.setDefault();
    },
    addressEdit: function(t) {
        wx.navigateTo({
            url: "../address_edit/address_edit"
        });
    },
    getAddressList: function() {
        var t = this, s = {
            url: a.default.addressList,
            method: "GET"
        };
        e.getData(s, function(a) {
            1 == a.errorCode ? t.setData({
                addressList: a.data || ""
            }) : t.setData({
                addressList: []
            });
        });
    },
    setDefault: function(t) {
        var s = this;
        wx.showLoading({
            title: "请稍后"
        });
        var d = {
            url: a.default.set_address,
            data: {
                addressId: -1 == this.data.addressId ? t.currentTarget.dataset.id : this.data.addressId
            }
        };
        e.getData(d, function(t) {
            if (setTimeout(function() {
                wx.hideLoading();
            }, 300), 1 == t.errorCode && (s.getAddressList(), "order" == s.data.page)) {
                var a = getCurrentPages(), e = a[a.length - 2];
                e.data.store_type = 2, e.data.openFunciton = 1, e.setData({
                    store_type: 2,
                    openFunciton: 1
                }), wx.navigateBack({
                    delta: 1
                });
            }
        });
    },
    delAddress: function(t) {
        var s = this;
        wx.showModal({
            title: "确定删除改地址吗？",
            content: "",
            success: function(d) {
                if (d.confirm) {
                    var r = {
                        url: a.default.del_address,
                        data: {
                            addressId: t.currentTarget.dataset.id
                        }
                    };
                    e.getData(r, function(t) {
                        1 == t.errorCode && (s.getAddressList(), wx.showToast({
                            title: "删除成功",
                            icon: "none"
                        }));
                    });
                }
            }
        });
    },
    navigatorLink: function(t) {
        s.navClick(t, this);
    }
});