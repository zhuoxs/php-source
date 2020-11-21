var _WxValidate = require("../../../utils/WxValidate.js"), _WxValidate2 = _interopRequireDefault(_WxValidate);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var common = require("../common/common.js"), app = getApp(), Validate = "", Validate2 = "", Validate3 = "";

Page({
    data: {
        navHref: "",
        tab: [ "项目合作", "分销申请", "经销采购" ],
        tabCurr: 0,
        canload: !0
    },
    tabChange: function(e) {
        var a = e.currentTarget.id;
        this.setData({
            tabCurr: a
        });
    },
    formSubmit: function(e) {
        var a = e.detail.value;
        if (!Validate.checkForm(e)) {
            var t;
            return t = Validate.errorList[0], wx.showModal({
                title: "内容不符合要求",
                content: t.msg,
                showCancel: !1
            }), !1;
        }
        if (this.data.canload) {
            this.setData({
                canload: !1
            });
            var r = {
                op: "apply",
                type: 1,
                type2: a.style,
                cname: a.cname,
                address: a.caddr,
                coname: a.coname,
                name: a.ccname,
                mobile: a.ccphone,
                content: a.cbusiness
            };
            app.util.request({
                url: "entry/wxapp/index",
                method: "POST",
                data: r,
                success: function(e) {
                    "" != e.data.data && (wx.showToast({
                        title: "申请成功",
                        icon: "success",
                        duration: 2e3
                    }), setTimeout(function() {
                        wx.navigateBack({
                            delta: 1
                        });
                    }, 2e3));
                }
            });
        }
    },
    formSubmit2: function(e) {
        var a = e.detail.value;
        if (!Validate2.checkForm(e)) {
            var t;
            return t = Validate2.errorList[0], wx.showModal({
                title: "内容不符合要求",
                content: t.msg,
                showCancel: !1
            }), !1;
        }
        if (this.data.canload) {
            this.setData({
                canload: !1
            });
            var r = {
                op: "apply",
                type: 2,
                type2: a.style,
                cname: a.cname,
                address: a.caddr,
                coname: a.coname,
                name: a.ccname,
                mobile: a.ccphone,
                cmobile: a.cphone
            };
            app.util.request({
                url: "entry/wxapp/index",
                method: "POST",
                data: r,
                success: function(e) {
                    "" != e.data.data && (wx.showToast({
                        title: "申请成功",
                        icon: "success",
                        duration: 2e3
                    }), setTimeout(function() {
                        wx.navigateBack({
                            delta: 1
                        });
                    }, 2e3));
                }
            });
        }
    },
    formSubmit3: function(e) {
        var a = e.detail.value;
        if (!Validate3.checkForm(e)) {
            var t;
            return t = Validate3.errorList[0], wx.showModal({
                title: "内容不符合要求",
                content: t.msg,
                showCancel: !1
            }), !1;
        }
        if (this.data.canload) {
            this.setData({
                canload: !1
            });
            var r = {
                op: "apply",
                type: 4,
                cname: a.cname,
                address: a.caddr,
                coname: a.coname,
                name: a.coname,
                mobile: a.cphone
            };
            "" != a.invite_code && null != a.invite_code && (r.invite_code = a.invite_code), 
            app.util.request({
                url: "entry/wxapp/index",
                method: "POST",
                data: r,
                success: function(e) {
                    "" != e.data.data && (wx.showToast({
                        title: "申请成功",
                        icon: "success",
                        duration: 2e3
                    }), setTimeout(function() {
                        wx.navigateBack({
                            delta: 1
                        });
                    }, 2e3));
                }
            });
        }
    },
    onLoad: function(e) {
        var t = this;
        common.config(t), app.util.request({
            url: "entry/wxapp/index",
            method: "POST",
            data: {
                op: "apply_class"
            },
            success: function(e) {
                var a = e.data;
                "" != a.data && t.setData({
                    xc: a.data
                });
            }
        });
        Validate = new _WxValidate2.default({
            cname: {
                required: !0
            },
            caddr: {
                required: !0
            },
            coname: {
                required: !0
            },
            ccname: {
                required: !0
            },
            ccphone: {
                required: !0,
                number: !0
            },
            cbusiness: {
                required: !0
            }
        }, {
            cname: {
                required: "请输入企业名称"
            },
            caddr: {
                required: "请输入联系地址"
            },
            coname: {
                required: "请输入企业法人"
            },
            ccname: {
                required: "请输入联系人"
            },
            ccphone: {
                required: "请输入联系人电话",
                number: "请输入正确格式的联系人电话"
            },
            cbusiness: {
                required: "请简述主营业务"
            }
        });
        Validate2 = new _WxValidate2.default({
            cname: {
                required: !0
            },
            caddr: {
                required: !0
            },
            coname: {
                required: !0
            },
            cphone: {
                required: !0,
                number: !0
            },
            ccname: {
                required: !0
            },
            ccphone: {
                required: !0,
                number: !0
            }
        }, {
            cname: {
                required: "请输入企业名称"
            },
            caddr: {
                required: "请输入联系地址"
            },
            coname: {
                required: "请输入企业法人"
            },
            cphone: {
                required: "请输入企业电话",
                number: "请输入正确格式的企业电话"
            },
            ccname: {
                required: "请输入联系人"
            },
            ccphone: {
                required: "请输入联系人电话",
                number: "请输入正确格式的联系人电话"
            }
        });
        Validate3 = new _WxValidate2.default({
            cname: {
                required: !0
            },
            coname: {
                required: !0
            },
            cphone: {
                required: !0,
                number: !0
            },
            caddr: {
                required: !0
            }
        }, {
            cname: {
                required: "请输入分销店铺名称"
            },
            caddr: {
                required: "请输入联系地址"
            },
            coname: {
                required: "请输入真实姓名"
            },
            cphone: {
                required: "请输入您的联系电话",
                number: "请输入正确格式的联系电话"
            }
        });
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    }
});