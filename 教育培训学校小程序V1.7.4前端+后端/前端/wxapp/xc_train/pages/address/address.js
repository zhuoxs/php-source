function t(t) {
    s.util.request({
        url: "entry/wxapp/user",
        method: "POST",
        data: {
            op: "address"
        },
        success: function(a) {
            var e = a.data;
            wx.stopPullDownRefresh(), "" != e.data && t.setData({
                list: e.data
            });
        }
    });
}

function a(t) {
    var a = t.data.name, e = t.data.mobile, s = t.data.address, n = "", d = t.data.config, o = -1;
    "" != d.map_status && null != d.map_status && (o = d.map_status), 1 != o && ("" != s && null != s || (n = "请先定位")), 
    "" == e || null == e ? n = "请输入手机号码" : /^[1][0-9]{10}$/.test(e) || (n = "请输入正确的手机号码"), 
    "" != a && null != a || (n = "请输入您的姓名"), "" == n ? t.setData({
        submit: !0
    }) : wx.showModal({
        title: "错误",
        content: n
    });
}

var e = require("../common/common.js"), s = getApp();

Page({
    data: {
        change_id: -1,
        shwoLayer: !1,
        newsex: 1,
        submit: !1,
        can_load: !0
    },
    edit: function(t) {
        var a = this, e = t.currentTarget.dataset.index, s = a.data.list;
        a.setData({
            shwoLayer: !0,
            name: s[e].name,
            newsex: s[e].sex,
            mobile: s[e].mobile,
            address: s[e].address,
            content: s[e].content,
            latitude: s[e].latitude,
            longitude: s[e].longitude,
            change_id: s[e].id
        });
    },
    addressChange: function(t) {
        var a = this, e = t.detail.value, n = a.data.list;
        1 != n[e].status && s.util.request({
            url: "entry/wxapp/user",
            method: "POST",
            data: {
                op: "address_status",
                id: n[e].id
            },
            success: function(t) {
                if ("" != t.data.data) {
                    for (var s = 0; s < n.length; s++) n[s].status = -1;
                    n[e].status = 1, a.setData({
                        list: n
                    });
                }
            }
        });
    },
    deleteAddr: function(t) {
        var a = this, e = t.currentTarget.dataset.index, n = a.data.list;
        wx.showModal({
            title: "确认删除",
            content: "是否删除这条地址信息？",
            success: function(t) {
                t.confirm && (1 == n[e].status ? wx.showModal({
                    title: "错误",
                    content: "默认地址无法删除"
                }) : s.util.request({
                    url: "entry/wxapp/user",
                    method: "POST",
                    data: {
                        op: "address_del",
                        id: n[e].id
                    },
                    success: function(t) {
                        "" != t.data.data && (wx.showToast({
                            title: "删除成功",
                            icon: "success",
                            duration: 2e3
                        }), n.splice(e, 1), a.setData({
                            list: e
                        }));
                    }
                }));
            }
        });
    },
    mapping: function() {
        var t = this;
        wx.chooseLocation({
            success: function(a) {
                t.setData({
                    address: a.address,
                    latitude: a.latitude,
                    longitude: a.longitude
                });
            }
        });
    },
    sexSelect: function(t) {
        var a = this, e = t.currentTarget.id;
        a.setData({
            newsex: e
        });
    },
    showLayer: function() {
        this.setData({
            shwoLayer: !0
        });
    },
    closeLayer: function() {
        this.setData({
            shwoLayer: !1,
            name: "",
            newsex: 1,
            mobile: "",
            address: "",
            content: "",
            submit: !1,
            change_id: -1
        });
    },
    input: function(t) {
        var a = this, e = t.currentTarget.dataset.name, s = t.detail.value;
        switch (e) {
          case "name":
            a.setData({
                name: s
            });
            break;

          case "mobile":
            a.setData({
                mobile: s
            });
            break;

          case "content":
            a.setData({
                content: s
            });
        }
    },
    submit: function() {
        var e = this;
        if (a(e), e.data.submit && e.data.can_load) {
            e.setData({
                can_load: !1,
                shwoLayer: !1
            });
            var n = {
                op: "address_edit",
                name: e.data.name,
                sex: e.data.newsex,
                mobile: e.data.mobile
            };
            "" != e.data.address && null != e.data.address && (n.address = e.data.address, n.latitude = e.data.latitude, 
            n.longitude = e.data.longitude), "" != e.data.content && null != e.data.content && (n.content = e.data.content), 
            -1 != e.data.change_id && (n.id = e.data.change_id), s.util.request({
                url: "entry/wxapp/user",
                method: "POST",
                data: n,
                success: function(a) {
                    var s = a.data;
                    e.setData({
                        can_load: !0,
                        name: "",
                        newsex: 1,
                        mobile: "",
                        address: "",
                        content: "",
                        submit: !1,
                        change_id: -1
                    }), "" != s.data && (wx.showToast({
                        title: "操作成功",
                        icon: "success",
                        duration: 2e3
                    }), t(e));
                }
            });
        }
    },
    onLoad: function(a) {
        var s = this;
        e.config(s), e.theme(s), t(s);
    },
    onReady: function() {},
    onShow: function() {
        e.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onReachBottom: function() {}
});