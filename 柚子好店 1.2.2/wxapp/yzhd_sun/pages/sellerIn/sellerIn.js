var _Page;

function _defineProperty(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var _imgArray = [], _imgArray2 = [];

Page((_defineProperty(_Page = {
    data: {
        shopFun: [ {
            nameFun: "菜单功能",
            id: 1
        }, {
            nameFun: "订座功能",
            id: 2
        }, {
            nameFun: "评论功能",
            id: 3
        } ]
    },
    onLoad: function(e) {
        this.diyWinColor();
    },
    chooseLocaTap: function(e) {
        wx.chooseLocation({
            success: function(e) {
                console.log(e);
            }
        });
    },
    bindTimeChange: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), "start" == e.currentTarget.dataset.statu ? this.setData({
            stime: e.detail.value
        }) : this.setData({
            etime: e.detail.value
        });
    },
    imgArray1: function(e) {
        var o = this, t = (wx.getStorageSync("uniacid"), 9 - _imgArray.length);
        0 < t && t <= 9 ? wx.chooseImage({
            count: t,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                wx.showToast({
                    icon: "loading",
                    title: "正在上传"
                });
                for (var t = e.tempFilePaths, a = 0; a < t.length; a++) _imgArray.push(t[a]);
                o.setData({
                    imgArray1: _imgArray
                });
            }
        }) : wx.showModal({
            title: "上传提示",
            content: "最多上传9张图片",
            showCancel: !0,
            cancelText: "取消",
            cancelColor: "",
            confirmText: "确定",
            confirmColor: "",
            success: function(e) {},
            fail: function(e) {},
            complete: function(e) {}
        });
    },
    uploadimg: function(e) {
        console.log(e);
        var t = this, a = e.i ? e.i : 0, o = e.success ? e.success : 0, i = e.fail ? e.fail : 0;
        wx.uploadFile({
            url: e.url,
            filePath: e.path[a],
            name: "upfile",
            formData: null,
            success: function(e) {
                console.log(e), "" != e.data ? (o++, _imgArray.push(e.data), t.setData({
                    imgArray1: _imgArray
                }), console.log(t.data.imgArray1)) : wx.showToast({
                    icon: "loading",
                    title: "请重试"
                });
            },
            fail: function(e) {
                i++;
            },
            complete: function() {
                ++a == e.path.length ? (t.setData({
                    images: e.path
                }), wx.hideToast()) : (e.i = a, e.success = o, e.fail = i, t.uploadimg(e));
            }
        });
    },
    delete1: function(e) {
        console.log(e);
        Array.prototype.indexOf = function(e) {
            for (var t = 0; t < this.length; t++) if (this[t] == e) return t;
            return -1;
        }, Array.prototype.remove = function(e) {
            var t = this.indexOf(e);
            -1 < t && this.splice(t, 1);
        };
        var t = e.currentTarget.dataset.index;
        _imgArray.remove(_imgArray[t]), this.setData({
            imgArray1: _imgArray
        });
    },
    imgArray2: function(e) {
        var o = this, t = (wx.getStorageSync("uniacid"), 9 - _imgArray2.length);
        0 < t && t <= 9 ? wx.chooseImage({
            count: t,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                wx.showToast({
                    icon: "loading",
                    title: "正在上传"
                });
                for (var t = e.tempFilePaths, a = 0; a < t.length; a++) _imgArray2.push(t[a]);
                o.setData({
                    imgArray2: _imgArray2
                });
            }
        }) : wx.showModal({
            title: "上传提示",
            content: "最多上传9张图片",
            showCancel: !0,
            cancelText: "取消",
            cancelColor: "",
            confirmText: "确定",
            confirmColor: "",
            success: function(e) {},
            fail: function(e) {},
            complete: function(e) {}
        });
    }
}, "uploadimg", function(e) {
    console.log(e);
    var t = this, a = e.i ? e.i : 0, o = e.success ? e.success : 0, i = e.fail ? e.fail : 0;
    wx.uploadFile({
        url: e.url,
        filePath: e.path[a],
        name: "upfile",
        formData: null,
        success: function(e) {
            console.log(e), "" != e.data ? (o++, _imgArray2.push(e.data), t.setData({
                imgArray2: _imgArray2
            }), console.log(t.data.imgArray2)) : wx.showToast({
                icon: "loading",
                title: "请重试"
            });
        },
        fail: function(e) {
            i++;
        },
        complete: function() {
            ++a == e.path.length ? (t.setData({
                images: e.path
            }), wx.hideToast()) : (e.i = a, e.success = o, e.fail = i, t.uploadimg(e));
        }
    });
}), _defineProperty(_Page, "delete2", function(e) {
    console.log(e);
    Array.prototype.indexOf = function(e) {
        for (var t = 0; t < this.length; t++) if (this[t] == e) return t;
        return -1;
    }, Array.prototype.remove = function(e) {
        var t = this.indexOf(e);
        -1 < t && this.splice(t, 1);
    };
    var t = e.currentTarget.dataset.index;
    _imgArray2.remove(_imgArray2[t]), this.setData({
        imgArray2: _imgArray2
    });
}), _defineProperty(_Page, "previewImage", function(e) {
    console.log(e);
    var t = e.currentTarget.dataset.index, a = e.currentTarget.dataset.list;
    wx.previewImage({
        current: a[t],
        urls: a
    });
}), _defineProperty(_Page, "onReady", function() {}), _defineProperty(_Page, "onShow", function() {}), 
_defineProperty(_Page, "onHide", function() {}), _defineProperty(_Page, "onUnload", function() {}), 
_defineProperty(_Page, "onPullDownRefresh", function() {}), _defineProperty(_Page, "onReachBottom", function() {}), 
_defineProperty(_Page, "diyWinColor", function(e) {
    var t = wx.getStorageSync("system");
    wx.setNavigationBarColor({
        frontColor: t.color,
        backgroundColor: t.fontcolor,
        animation: {
            duration: 400,
            timingFunc: "easeIn"
        }
    }), wx.setNavigationBarTitle({
        title: "商家入驻"
    });
}), _Page));