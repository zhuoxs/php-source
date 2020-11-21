var app = getApp();

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
        },
        imgLink: {
            type: String
        }
    },
    data: {},
    ready: function() {},
    methods: {
        _addImg: function() {
            var i = this;
            i.data.count <= 0 ? wx.showToast({
                title: "最多只能上传" + i.data.maxCount + "张图片",
                icon: "none",
                duration: 1e3
            }) : wx.chooseImage({
                count: i.data.count,
                success: function(t) {
                    var a = t.tempFilePaths, e = app.util.url("entry/wxapp/uploadPic") + "m=mzhk_sun";
                    for (var r in console.log(e), a) wx.uploadFile({
                        url: e,
                        filePath: a[r],
                        name: "file",
                        formData: {
                            path: a[r]
                        },
                        success: function(t) {
                            console.log(t);
                            var a = JSON.parse(t.data);
                            if (console.log(a), i.setData({
                                imgLink: a.data.other.img_root
                            }), a.errno) app.tips("上传失败！请重新上传"); else {
                                var e = i.data.imgArr.concat(a.data[0]);
                                i.setData({
                                    imgArr: e
                                }), i.triggerEvent("getArr", i.data.imgArr);
                            }
                        },
                        fail: function(t) {
                            app.tips("上传失败！请重新上传");
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
    }
});