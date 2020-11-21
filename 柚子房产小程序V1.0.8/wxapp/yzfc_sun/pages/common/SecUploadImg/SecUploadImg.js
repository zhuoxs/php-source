var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var r in e) Object.prototype.hasOwnProperty.call(e, r) && (t[r] = e[r]);
    }
    return t;
}, _reload = require("../../../resource/js/reload.js"), app = getApp();

Component({
    properties: {
        imgArr: {
            type: Array,
            value: [],
            observer: function(t, a, e) {
                this.setData({
                    count: this.data.maxCount - t.length
                });
            }
        },
        prevent: {
            type: Boolean,
            value: !1
        },
        maxCount: {
            type: Number
        },
        title: {
            type: String
        }
    },
    data: {},
    ready: function() {
        var a = this;
        this.checkUrl().then(function(t) {
            a.setData({
                bk: t
            });
        }).catch(function(t) {
            a.tips("请求过期（url）");
        });
    },
    methods: _extends({}, _reload.reload, {
        _addImg: function() {
            var i = this;
            i.data.count <= 0 ? wx.showToast({
                title: "最多只能上传" + i.data.maxCount + "张图片",
                icon: "none",
                duration: 1e3
            }) : wx.chooseImage({
                count: i.data.count,
                success: function(t) {
                    var a = t.tempFilePaths, e = app.util.url("entry/wxapp/UploadPic") + "&m=yzfc_sun";
                    for (var r in a) wx.uploadFile({
                        url: e,
                        filePath: a[r],
                        name: "file",
                        formData: {
                            path: a[r]
                        },
                        success: function(t) {
                            var a = JSON.parse(t.data);
                            if (1 == a.code) {
                                var e = i.data.imgArr.concat(a.data);
                                i.setData({
                                    imgArr: e
                                }), i.triggerEvent("getArr", i.data.imgArr);
                            } else i.tips("上传失败！请重新上传");
                        },
                        fail: function(t) {
                            i.tips("上传失败！请重新上传");
                        }
                    });
                }
            });
        },
        _onDelTab: function(t) {
            var a = t.currentTarget.dataset.idx;
            this.data.imgArr.splice(a, 1), this.setData({
                imgArr: this.data.imgArr
            }), this.triggerEvent("getArr", this.data.imgArr);
        }
    })
});