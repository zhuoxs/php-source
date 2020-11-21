var t = getApp();

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
            var a = this;
            a.data.count <= 0 ? wx.showToast({
                title: "最多只能上传" + a.data.maxCount + "张图片",
                icon: "none",
                duration: 1e3
            }) : wx.chooseImage({
                count: a.data.count,
                success: function(e) {
                    var r = e.tempFilePaths, i = t.util.url("entry/wxapp/Api_common|uploadPic") + "&m=yztc_sun";
                    for (var n in r) wx.uploadFile({
                        url: i,
                        filePath: r[n],
                        name: "file",
                        formData: {
                            path: r[n]
                        },
                        success: function(e) {
                            var r = JSON.parse(e.data);
                            if (a.setData({
                                imgLink: r.other.img_root
                            }), r.code) t.tips("上传失败！请重新上传"); else {
                                var i = a.data.imgArr.concat(r.data);
                                a.setData({
                                    imgArr: i
                                }), a.triggerEvent("getArr", a.data.imgArr);
                            }
                        },
                        fail: function(a) {
                            t.tips("上传失败！请重新上传");
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