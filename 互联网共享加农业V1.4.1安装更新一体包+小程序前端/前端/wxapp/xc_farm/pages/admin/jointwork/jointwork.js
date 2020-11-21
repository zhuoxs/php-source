var _WxValidate = require("../../../../utils/WxValidate.js"), _WxValidate2 = _interopRequireDefault(_WxValidate);

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

var common = require("../../common/common.js"), app = getApp(), Validate = "";

function getUrlParam(e, a) {
    var t = new RegExp("(^|&)" + a + "=([^&]*)(&|$)"), n = e.split("?")[1].match(t);
    return null != n ? unescape(n[2]) : null;
}

Page({
    data: {
        navHref: "",
        imgs: [],
        canload: !0
    },
    map: function() {
        var a = this;
        wx.chooseLocation({
            success: function(e) {
                a.setData({
                    map: e,
                    map_address: e.address
                });
            }
        });
    },
    previewImage: function(e) {
        var a = e.currentTarget.dataset.index;
        wx.previewImage({
            current: this.data.imgs[a],
            urls: this.data.imgs
        });
    },
    upload: function() {
        var n = this, i = "entry/wxapp/upload";
        -1 == i.indexOf("http://") && -1 == i.indexOf("https://") && (i = app.util.url(i));
        var e = wx.getStorageSync("userInfo").sessionid;
        !getUrlParam(i, "state") && e && (i = i + "&state=we7sid-" + e), i = i + "&state=we7sid-" + e;
        var a = getCurrentPages();
        a.length && (a = a[getCurrentPages().length - 1]) && a.__route__ && (i = i + "&m=" + a.__route__.split("/")[0]), 
        wx.chooseImage({
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                for (var a = e.tempFilePaths, t = 0; t < a.length; t++) wx.uploadFile({
                    url: i,
                    filePath: a[t],
                    name: "file",
                    formData: {
                        user: "test"
                    },
                    success: function(e) {
                        var a = n.data.imgs;
                        a.push(e.data), n.setData({
                            imgs: a
                        });
                    }
                });
            }
        });
    },
    formSubmit: function(e) {
        var a = this, t = e.detail.value;
        if (console.log(t), !Validate.checkForm(e)) {
            var n;
            return n = Validate.errorList[0], wx.showModal({
                title: "内容不符合要求",
                content: n.msg,
                showCancel: !1
            }), !1;
        }
        if (0 < a.data.imgs.length) {
            if (a.data.canload) {
                a.setData({
                    canload: !1
                });
                var i = {
                    op: "apply",
                    type: 3,
                    type2: t.style,
                    cname: t.cname,
                    address: t.caddr,
                    coname: t.coname,
                    name: t.ccname,
                    mobile: t.ccphone,
                    content: t.cbusiness,
                    map: JSON.stringify(a.data.map),
                    imgs: JSON.stringify(a.data.imgs),
                    service: t.service.join(",")
                };
                app.util.request({
                    url: "entry/wxapp/index",
                    method: "POST",
                    data: i,
                    success: function(e) {
                        "" != e.data.data && (wx.showToast({
                            title: "提交成功",
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
        } else wx.showModal({
            title: "内容不符合要求",
            content: "请上传相关证件",
            showCancel: !1
        });
    },
    onLoad: function(e) {
        var t = this;
        common.config(t, "admin2"), app.util.request({
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
            map: {
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
            map: {
                required: "请定位"
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
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onReachBottom: function() {}
});