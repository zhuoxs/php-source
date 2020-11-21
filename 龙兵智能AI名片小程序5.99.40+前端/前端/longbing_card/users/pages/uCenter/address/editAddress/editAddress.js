var _xx_util = require("../../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        sexItems: [ {
            name: "先生",
            value: "先生",
            checked: !0
        }, {
            name: "女士",
            value: "女士",
            checked: !1
        } ],
        sexVal: "",
        address: "",
        editAddress: []
    },
    onLoad: function(e) {
        console.log(e, "options");
        var t, a = this, s = e.status, d = {
            status: s
        }, i = "先生";
        if ("toEdit" == s) {
            t = "编辑地址";
            var n = _xx_util2.default.getPage(-1).data.currEditAddr;
            d.editAddress = n;
            var o = a.data.sexItems;
            "先生" == d.editAddress.sex && (i = "先生", o[0].checked = !0), "女士" == d.editAddress.sex && (i = "女士", 
            o[1].checked = !0);
            var r = {};
            r.address = d.editAddress.address, r.address_detail = d.editAddress.address_detail, 
            a.setData({
                checkAddress: r
            });
        } else if ("toAdd" == e.status) {
            i = "先生", (o = a.data.sexItems)[0].checked = !0, t = "新增地址";
        }
        wx.setNavigationBarTitle({
            title: t
        }), a.setData({
            sexVal: i,
            sexItems: o,
            paramData: d,
            globalData: app.globalData
        });
    },
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading();
    },
    radioChange: function(e) {
        this.sexVal = e.detail.value, this.setData({
            sexVal: e.detail.value
        });
    },
    getToAddUpdateAddress: function(e) {
        var a = this;
        _index.userModel.getAddAddress(e).then(function(e) {
            if (_xx_util2.default.hideAll(), 0 != e.errno) return !1;
            var t;
            "toAdd" == a.data.paramData.status && (t = "已成功新增地址！"), "toEdit" == a.data.paramData.status && (t = "已成功编辑地址！"), 
            wx.showToast({
                icon: "none",
                title: t,
                duration: 2e3,
                success: function() {
                    setTimeout(function() {
                        wx.hideToast(), wx.navigateBack();
                    }, 1e3);
                }
            });
        });
    },
    chooseLocation: function(e) {
        var n = this;
        wx.authorize({
            scope: "scope.userLocation",
            success: function(e) {
                wx.chooseLocation({
                    success: function(s) {
                        var d = /^(北京市|天津市|重庆市|上海市|香港特别行政区|澳门特别行政区)/, e = [], t = {
                            REGION_PROVINCE: null,
                            REGION_COUNTRY: null,
                            REGION_CITY: null,
                            ADDRESS: null
                        };
                        function a(e, t) {
                            var a = (d = /^(.*?[市州]|.*?地区|.*?特别行政区)(.*?[市区县])(.*?)$/g).exec(e);
                            t.REGION_CITY = a[1], t.REGION_COUNTRY = a[2], t.ADDRESS = a[3] + "(" + s.name + ")";
                        }
                        (e = d.exec(s.address)) ? (t.REGION_PROVINCE = e[1], a(s.address, t)) : (e = (d = /^(.*?(省|自治区))(.*?)$/).exec(s.address), 
                        t.REGION_PROVINCE = e[1], a(e[3], t));
                        var i = {};
                        i.address = t.REGION_PROVINCE + t.REGION_CITY + t.REGION_COUNTRY, i.address_detail = t.ADDRESS, 
                        n.setData({
                            addressBean: t,
                            checkAddress: i
                        });
                    }
                });
            },
            fail: function(e) {
                n.setData({
                    isSetting: !0
                });
            }
        });
    },
    toEditAddress: function(e) {
        var t = this, a = e.detail.value;
        if (!a.name) return wx.showToast({
            icon: "none",
            title: "请填写联系人！",
            duration: 2e3,
            success: function() {
                setTimeout(function() {
                    wx.hideToast();
                }, 1e3);
            }
        }), !1;
        if (!a.phone) return wx.showToast({
            icon: "none",
            title: "请填写手机号！",
            duration: 2e3,
            success: function() {
                setTimeout(function() {
                    wx.hideToast();
                }, 1e3);
            }
        }), !1;
        if ("toAdd" == t.data.paramData.status) {
            if (console.log("新增"), !t.data.addressBean) return wx.showToast({
                icon: "none",
                title: "请选择地址！",
                duration: 2e3,
                success: function() {
                    setTimeout(function() {
                        wx.hideToast();
                    }, 1e3);
                }
            }), !1;
            var s = t.data.addressBean, d = s.REGION_PROVINCE, i = s.REGION_CITY, n = s.REGION_COUNTRY;
            a.province = d, a.city = i, a.area = n;
        } else if ("toEdit" == t.data.paramData.status) {
            console.log("编辑");
            var o = t.data.paramData.editAddress, r = o.id, u = o.province, c = o.city, l = o.area;
            if (a.id = r, t.data.addressBean) {
                var x = t.data.addressBean, f = x.REGION_PROVINCE, _ = x.REGION_CITY, R = x.REGION_COUNTRY;
                a.province = f, a.city = _, a.area = R;
            }
            t.data.addressBean || (a.province = u, a.city = c, a.area = l);
        }
        if (!a.address_detail) return wx.showToast({
            icon: "none",
            title: "请填写详细地址！",
            duration: 2e3,
            success: function() {
                setTimeout(function() {
                    wx.hideToast();
                }, 1e3);
            }
        }), !1;
        t.getToAddUpdateAddress(a);
    }
});