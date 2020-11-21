var _xx_util = require("../../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var app = getApp(), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {},
    onLoad: function(t) {
        console.log(this), console.log(t, "options");
        var e = {
            status: t.status
        };
        this.setData({
            globalData: app.globalData,
            paramObj: e
        });
    },
    onShow: function() {
        _xx_util2.default.showLoading();
        this.getAddressList();
    },
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), this.getAddressList();
    },
    getAddressList: function() {
        var i = this;
        _index.userModel.getAddressList().then(function(t) {
            _xx_util2.default.hideAll();
            var e = t.data, a = [], d = [];
            for (var s in e) e[s].is_default = parseInt(e[s].is_default), 1 == e[s].is_default ? a.push(1) : 0 == e[s].is_default && a.push(0), 
            d.push(e[s].phone.substr(0, 3) + "****" + e[s].phone.substr(7, 10));
            i.setData({
                idList: a,
                dataList: e,
                tmpPhone: d
            });
        });
    },
    setShopAddressDefault: function(a) {
        var t, d = this, s = d.data.dataList, i = d.data.idList;
        0 == s[a].is_default && (t = 1), 1 == s[a].is_default && (t = 2), _index.userModel.getAddDefault({
            type: t,
            id: s[a].id
        }).then(function(t) {
            for (var e in _xx_util2.default.hideAll(), s) s[e].is_default = 0, i[e] = 0;
            s[a].is_default = 1, i[a] = 1, wx.showToast({
                icon: "none",
                title: "已成功设为默认地址",
                duration: 2e3
            }), app.globalData.checkAddress = s[a], d.setData({
                idList: i,
                dataList: s
            });
        });
    },
    getToAddUpdateAddress: function(t) {
        _index.userModel.getAddAddress(t).then(function(t) {
            if (_xx_util2.default.hideAll(), 0 != t.errno) return !1;
            wx.showToast({
                icon: "none",
                title: "已成功新增地址！",
                duration: 2e3
            });
        });
    },
    getDeleteAddr: function(e) {
        var a = this, d = a.data.dataList, s = a.data.idList;
        _index.userModel.getDelAddress({
            id: d[e].id
        }).then(function(t) {
            if (_xx_util2.default.hideAll(), 0 != t.errno) return !1;
            wx.showToast({
                icon: "none",
                title: "已成功删除地址！",
                duration: 2e3
            }), s.splice(e, 1), d.splice(e, 1), a.setData({
                dataList: d,
                idList: s
            });
        });
    },
    toJump: function(t) {
        var a = this, e = t.currentTarget.dataset.status, d = t.currentTarget.dataset.index;
        a.data.dataList;
        if ("toAddAddr" == e || "toEditAddr" == e) {
            if ("toEditAddr" == e) {
                var s = a.data.dataList[d];
                a.setData({
                    currEditAddr: s
                });
            }
            _xx_util2.default.goUrl(t);
        } else if ("toCheckAddr" == e) {
            if ("checkaddr" != a.data.paramObj.status) return !1;
            var i = a.data.dataList[d];
            app.globalData.checkAddress_cur = i, setTimeout(function() {
                wx.navigateBack();
            }, 300);
        } else "toCheckDefaultAddr" == e ? a.setShopAddressDefault(d) : "toDeleteAddr" == e ? wx.showModal({
            title: "",
            content: "请确认是否要删除该地址？",
            success: function(t) {
                t.confirm && a.getDeleteAddr(d);
            }
        }) : "toWechatAddr" == e && wx.authorize({
            scope: "scope.address",
            success: function(t) {
                wx.chooseAddress({
                    success: function(t) {
                        var e = {
                            address: t.provinceName + t.cityName + t.countyName,
                            address_detail: t.detailInfo,
                            province: t.provinceName,
                            city: t.cityName,
                            area: t.countyName,
                            name: t.userName,
                            phone: t.telNumber,
                            sex: ""
                        };
                        a.getToAddUpdateAddress(e), a.setData({
                            dataList: []
                        }), a.onPullDownRefresh();
                    }
                });
            },
            fail: function(t) {
                a.setData({
                    isSetting: !0
                });
            }
        });
    }
});