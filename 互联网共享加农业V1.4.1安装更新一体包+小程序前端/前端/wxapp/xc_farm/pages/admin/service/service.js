var common = require("../../common/common.js"), app = getApp();

function sign(t) {
    var a = t.data.times, e = t.data.date, n = t.data.curr, i = t.data.img, s = t.data.content, o = "";
    "" != s && null != s || (o = "请输入文字内容"), "" != i && null != i || (o = "请添加照片"), 
    0 == n && (o = "请选择项目"), "" != e && null != e || (o = "请输入副标题"), "" != a && null != a || (o = "请输入标题"), 
    "" != o ? wx.showModal({
        title: "错误",
        content: o
    }) : t.setData({
        submit: !0
    });
}

function getUrlParam(t, a) {
    var e = new RegExp("(^|&)" + a + "=([^&]*)(&|$)"), n = t.split("?")[1].match(e);
    return null != n ? unescape(n[2]) : null;
}

Page({
    data: {
        navHref: "../../admin/service/service?&admin=2",
        curr: 0,
        submit: !1,
        img: ""
    },
    input: function(t) {
        var a = this, e = t.currentTarget.dataset.name, n = t.detail.value;
        switch (e) {
          case "times":
            a.setData({
                times: n
            });
            break;

          case "date":
            a.setData({
                date: n
            });
            break;

          case "content":
            a.setData({
                content: n
            });
        }
    },
    bindPickerChange: function(t) {
        this.setData({
            curr: t.detail.value
        });
    },
    upload: function(t) {
        var e = this, n = "entry/wxapp/upload";
        -1 == n.indexOf("http://") && -1 == n.indexOf("https://") && (n = app.util.url(n));
        var a = wx.getStorageSync("userInfo").sessionid;
        !getUrlParam(n, "state") && a && (n = n + "&state=we7sid-" + a), n = n + "&state=we7sid-" + a;
        var i = getCurrentPages();
        i.length && (i = i[getCurrentPages().length - 1]) && i.__route__ && (n = n + "&m=" + i.__route__.split("/")[0]), 
        wx.chooseImage({
            count: 1,
            success: function(t) {
                var a = t.tempFilePaths;
                wx.uploadFile({
                    url: n,
                    filePath: a[0],
                    name: "file",
                    formData: {
                        user: "test"
                    },
                    success: function(t) {
                        e.setData({
                            img: t.data
                        });
                    }
                });
            }
        });
    },
    submit: function(t) {
        var a = this;
        if (sign(a), a.data.submit) {
            var e = {
                op: "service_on",
                times: a.data.times,
                date: a.data.date,
                id: a.data.xc.lists[a.data.curr],
                img: a.data.img,
                content: a.data.content
            };
            app.util.request({
                url: "entry/wxapp/manage",
                method: "POST",
                data: e,
                success: function(t) {
                    "" != t.data.data && (wx.showToast({
                        title: "提交成功",
                        icon: "success",
                        duration: 2e3
                    }), a.setData({
                        times: "",
                        date: "",
                        curr: 0,
                        img: "",
                        content: ""
                    }));
                }
            });
        }
    },
    onLoad: function(t) {
        var e = this;
        "" != t.admin && null != t.admin ? common.config(e, "admin2") : common.config(e, "admin"), 
        app.util.request({
            url: "entry/wxapp/manage",
            method: "POST",
            data: {
                op: "service"
            },
            success: function(t) {
                var a = t.data;
                "" != a.data && e.setData({
                    xc: a.data
                });
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