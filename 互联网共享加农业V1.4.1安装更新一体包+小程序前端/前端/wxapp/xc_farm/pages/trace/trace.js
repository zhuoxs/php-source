var _WxValidate = require("../../../utils/WxValidate.js"), _WxValidate2 = _interopRequireDefault(_WxValidate);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var common = require("../common/common.js"), app = getApp(), Validate = "";

Page({
    data: {
        navHref: "",
        code: ""
    },
    scanFunc: function() {
        var a = this;
        wx.scanCode({
            scanType: [ "qrCode", "barCode", "datamatrix", "pdf417" ],
            success: function(e) {
                console.log(e), a.setData({
                    code: e.result
                });
            }
        });
    },
    formSubmit: function(e) {
        var a = e.detail.value.code;
        if (!Validate.checkForm(e)) {
            var t = Validate.errorList[0];
            return wx.showModal({
                title: "内容不符合要求",
                content: t.msg,
                showCancel: !1
            }), !1;
        }
        app.util.request({
            url: "entry/wxapp/service",
            method: "POST",
            data: {
                op: "trace",
                code: a
            },
            success: function(e) {
                "" != e.data.data && wx.navigateTo({
                    url: "../trace_result/trace_result?&code=" + a
                });
            }
        });
    },
    onLoad: function(e) {
        common.config(this);
        Validate = new _WxValidate2.default({
            code: {
                required: !0
            }
        }, {
            code: {
                required: "请输入查询编号"
            }
        });
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    }
});