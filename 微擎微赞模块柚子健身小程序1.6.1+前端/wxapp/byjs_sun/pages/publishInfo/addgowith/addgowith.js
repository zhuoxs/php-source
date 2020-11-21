var app = getApp(), image = "", util = require("../../../resource/js/utils/util.js");

Page({
    data: {
        src: [],
        tab: 0,
        content: "",
        contetn_time: "",
        content_route: "",
        goId: 0,
        showbox: 1,
        goods_id: "",
        visa_id: "",
        goods: "",
        pics: [],
        imgAddr: "",
        gowithtime: "年/月/日",
        thistime: util.formatTime,
        disabled: !1,
        sendtitle: "发送"
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
        var i = this, o = t.id, e = t.visa_id, a = wx.getStorageSync("url");
        null != o && "" != o && "undefined" != o && null != o ? app.util.request({
            url: "entry/wxapp/GoodsDeatil",
            cachetime: "0",
            data: {
                gid: o
            },
            success: function(t) {
                console.log(t.data), i.setData({
                    url: a,
                    goId: 1,
                    goods: t.data,
                    goods_id: o
                });
            }
        }) : null != e && "" != e && null != e && app.util.request({
            url: "entry/wxapp/GetVisaDetail",
            cachetime: "0",
            data: {
                visa_id: e
            },
            success: function(t) {
                console.log(t.data), i.setData({
                    url: a,
                    goId: 1,
                    goods: t.data,
                    visa_id: e
                });
            }
        });
    },
    orderTab: function(t) {
        wx.switchTab({
            url: "../../publishInfo/publish/publishTxt"
        });
    },
    chooseImage: function() {
        var i = this, o = i.data.pics;
        o.length < 9 ? wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                o = o.concat(t.tempFilePaths), i.setData({
                    pics: o
                });
            }
        }) : wx.showToast({
            title: "只允许上传9张图片！！！",
            icon: "none"
        });
    },
    deleteImage: function(t) {
        var i = this.data.pics, o = t.currentTarget.dataset.index;
        i.splice(o, 1), this.setData({
            pics: i
        });
    },
    gowithformSubmit: function(t) {
        var i = t.detail.value, e = this, a = app.util.url("entry/wxapp/Toupload") + "&m=" + app.siteInfo.mname, n = e.data.pics, o = e.data.gowithtime, s = e.data.goods_id, c = e.data.visa_id;
        if (!s && !c) return wx.showToast({
            title: "结伴行需要选择一个旅游或者签证哦！！！",
            icon: "none"
        }), wx.switchTab({
            url: "../../product/index/index"
        }), !1;
        if (!i.gowithline) return wx.showToast({
            title: "写个路线名吧！！！",
            icon: "none"
        }), !1;
        if ("年/月/日" == o) return wx.showToast({
            title: "加下日期吧！！！",
            icon: "none"
        }), !1;
        if (!i.gowithcontent) return wx.showToast({
            title: "写点内容吧！！！",
            icon: "none"
        }), !1;
        wx.showLoading({
            title: "内容发布中，需要点时间，请稍后...",
            mask: !0
        });
        var l = wx.getStorageSync("users").id;
        e.setData({
            disabled: !0,
            sendtitle: "稍后"
        }), app.util.request({
            url: "entry/wxapp/PublishGoWith",
            cachetime: "0",
            data: {
                user_id: l,
                uniacid: app.siteInfo.uniacid,
                content_time: o,
                content_route: i.gowithline,
                content: i.gowithcontent,
                goods_id: s,
                visa_id: c
            },
            success: function(t) {
                console.log(t.data);
                var i = t.data;
                if (0 < n.length) {
                    var o = {
                        tcid: i,
                        types: 1
                    };
                    e.uploadimg({
                        url: a,
                        path: n
                    }, o);
                } else wx.showToast({
                    title: "发布成功！！！",
                    icon: "success",
                    success: function() {
                        app.globalData.aci = 1, wx.switchTab({
                            url: "../../interactive/interactiveMoving/interactiveMoving"
                        });
                    }
                });
            },
            fail: function() {
                e.setData({
                    disabled: !1,
                    sendtitle: "发送"
                }), wx.showToast({
                    title: "可能由于网络原因，发布失败，请重新发布！！！",
                    icon: "none",
                    success: function() {}
                });
            }
        });
    },
    uploadimg: function(t, i) {
        var o = this, e = t.i ? t.i : 0, a = t.success ? t.success : 0, n = t.fail ? t.fail : 0;
        console.log(i), wx.uploadFile({
            url: t.url,
            filePath: t.path[e],
            name: "file",
            formData: i,
            success: function(t) {
                1 == t.data && a++, console.log(t);
            },
            fail: function(t) {
                2 == t.data && n++, console.log("fail:" + e + "fail:" + n);
            },
            complete: function() {
                ++e == t.path.length ? (console.log("执行完毕"), wx.hideLoading(), wx.showToast({
                    title: "发布成功！！！",
                    icon: "success",
                    success: function() {
                        app.globalData.aci = 1, wx.switchTab({
                            url: "../../interactive/interactiveMoving/interactiveMoving"
                        });
                    }
                })) : (t.i = e, t.success = a, t.fail = n, o.uploadimg(t, i));
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    showData: function(t) {},
    contentTimeInput: function(t) {
        var i = t.detail.value;
        this.setData({
            gowithtime: i
        });
    },
    toPublishGowith: function(t) {
        wx.showToast({
            title: "该功能暂时关闭！",
            icon: "none"
        });
    }
});