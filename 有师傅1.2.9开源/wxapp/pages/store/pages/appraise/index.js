function e(e, t, a) {
    return t in e ? Object.defineProperty(e, t, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = a, e;
}

var t = getApp();

Page({
    data: {
        imgList: [],
        isShow: !1,
        loading: !0,
        level: 0,
        detail: {}
    },
    onLoad: function(e) {
        var a = this;
        t.util.request({
            url: "entry/wxapp/Api",
            data: {
                m: "ox_master",
                r: "order.orderDetail",
                uid: wx.getStorageSync("uid"),
                order_id: e.orderid
            },
            success: function(e) {
                a.setData({
                    detail: e.data.data.detail,
                    level: e.data.data.detail.level
                });
            }
        });
    },
    formSubmit: function(a) {
        var i, d = this;
        if ("" != a.detail.value.detail && "undefined" != a.detail.detail) {
            var r = (i = {
                formid: a.detail.formId,
                detail: a.detail.value.detail,
                uid: wx.getStorageSync("uid"),
                order_id: d.data.detail.id,
                level: d.data.level
            }, e(i, "detail", a.detail.value.detail), e(i, "m", "ox_master"), e(i, "r", "order.appraise"), 
            i);
            t.util.request({
                url: "entry/wxapp/Api",
                data: r,
                method: "POST",
                success: function(e) {
                    wx.showModal({
                        title: "评价成功",
                        content: "感谢您的评价",
                        success: function(e) {
                            e.confirm && wx.switchTab({
                                url: "/pages/order/index"
                            });
                        }
                    });
                }
            });
        } else t.util.message({
            title: "请填写评价内容",
            type: "error"
        });
    },
    changeIndex: function(e) {
        1 != this.data.detail.appraise && this.setData({
            level: e.currentTarget.dataset.index + 1
        });
    },
    deleteImg: function(e) {
        var t = e.currentTarget.dataset.id, a = this.data.imgList;
        a.splice(t, 1), this.setData({
            imgList: a
        });
    },
    uplaod: function() {
        var e = this;
        wx.chooseImage({
            count: 6,
            sizeType: [ "original", "compressed" ],
            success: function(a) {
                var i = a.tempFilePaths, d = a.tempFilePaths.length, r = 1;
                e.setData({
                    loading: !1
                });
                for (var l in i) wx.uploadFile({
                    url: t.util.url("entry/wxapp/Api", {
                        m: "ox_master",
                        r: "upload.save"
                    }),
                    filePath: i[l],
                    name: "file",
                    success: function(t) {
                        var a = JSON.parse(t.data), i = e.data.imgList;
                        i.push(a.data), e.setData({
                            imgList: i
                        }), r == d && e.setData({
                            loading: !0
                        }), r += 1;
                    }
                });
            }
        });
    }
});